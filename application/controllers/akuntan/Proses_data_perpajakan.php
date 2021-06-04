<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->library('exportproses');
			
			$this->load->model('M_Proses_perpajakan', 'm_proses');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
		} 
		 
		public function index() {
			$data['judul'] = "Proses Data Perpajakan"; 
			$this->libtemplate->main('akuntan/proses_perpajakan/tampil', $data);
		}
		
		public function prosesOn() {
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$data['header']	= "Proses Data Perpajakan";
			$data['masa']	= $this->Klien_model->getMasa();

			$this->load->view('akuntan/proses_perpajakan/view_'.$status, $data);
		}
		
		public function gantiKlien() {
			$lists		= "<option value=''>--Semua Klien--</option>";
			$klien		= '';
			$akuntan	= $this->session->userdata('id_user');
			$akses		= $this->Akses_model->getByAkuntan($_POST['tahun'], $akuntan);
			if($akses) {
				$bulan	= $this->Klien_model->getMasa($_POST['bulan']);
				if($bulan['id_bulan'] < $akses['masa']) {
					$akses = $this->Akses_model->getByAkuntan(($_POST['tahun'] - 1), $akuntan);
				}
				if($akses) {
					$id_klien	= explode(',', $akses['klien']);
					$klien		= [];
					foreach($id_klien as $id) {
						$klien[] = $this->Klien_model->getById($id);
					}
				} else {
					$lists = "<option value=''>--Tidak Ada Klien--</option>";
				}
			} else {
				$lists = "<option value=''>--Tidak Ada Klien--</option>";
			}
			
			if($klien) {
				foreach($klien as $k) {
					$lists .= "<option value='".$k['id_klien']."'>".$k['nama_klien']."</option>"; 
				}
			}
			echo $lists; 
		}
		
		public function page() {
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$klien		= $this->input->post('klien', true);
			$akuntan	= $this->session->userdata('id_user');
			$status		= $this->session->userdata('status'); 
			
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			
			if(empty($klien)) {
				$akses = $this->Akses_model->getByAkuntan($tahun, $akuntan);
				if($akses) { 
					$masa = $this->Klien_model->getMasa($bulan);
					if($masa['id_bulan'] < $akses['masa']) {
						$akses = $this->Akses_model->getByAkuntan(($tahun-1), $akuntan);
					}
					if($akses) {
						$klien = explode(",", $akses['klien']);
						implode(",", $klien);
					} else {
						$klien = 'kosong';
					}
				}
			}
			$countData	= $this->m_proses->countProses($status, $bulan, $tahun, $klien);
			$proses		= $this->m_proses->getProses($offset, $limit, $status, $bulan, $tahun, $klien);
			
			$data = [];
			foreach($proses as $k) {
				$hari		= floor($k['lama_pengerjaan'] / 8);
				$jam		= $k['lama_pengerjaan'] % 8;
				$standar	= $hari.' hari '.$jam.' jam';

				//HITUNG DURASI
				if( $k['tanggal_mulai'] ) {
					if( $k['tanggal_selesai'] ) {
						$durasi	= $this->proses_admin->durasi($k['tanggal_mulai'], $k['tanggal_selesai']);
					} else {
						$durasi	= $this->proses_admin->durasi($k['tanggal_mulai']);
					}
				}
				
				$row	= [];
				$row[]	= ++$offset.'.';
				if($status == 'belum') {
					$row[]	= $k['nama_klien'];
					$row[]	= $k['nama_tugas'];
					$row[]	= $k['jenis_data'];
					$row[]	= 'ke-' . $k['request'];
					$row[]	= 'ke-' . ($k['pembetulan'] + 1);
					$row[]	= $standar;
					$row[]	= '
						<a href="proses_data_perpajakan/mulai/'.$k['id_pengiriman'].'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Mulai Proses">
							<i class="bi bi-journal-plus"></i>
						</a>';
				} elseif($status == 'selesai') {
					$row[]	= $k['nama_klien'];
					$row[]	= $k['nama'];
					$row[]	= $k['nama_tugas'];
					$row[]	= $durasi;
					$row[]	= $standar;
					$row[]	= '
						<a class="btn btn-sm btn-primary btn-detail" data-nilai="'.$k['id_proses'].'" data-toggle="tooltip" data-placement="bottom" title="Detail">
							<i class="bi bi-info-circle"></i>
						</a>';
				} else {
					$row[]	= $k['nama_klien'];
					$row[]	= $k['nama'];
					$row[]	= $k['nama_tugas'];
					$row[]	= $k['tanggal_mulai'];
					$row[]	= $durasi;
					$row[]	= $standar;
					$row[]	= '
						<a class="btn btn-sm btn-primary btn-detail" data-nilai="'.$k['id_proses'].'" data-toggle="tooltip" data-placement="bottom" title="Detail">
							<i class="bi bi-info-circle"></i>
						</a>
						<a class="btn btn-sm btn-info" href="proses_data_perpajakan/selesai/'.$k['id_proses'].'" data-toggle="tooltip" data-placement="bottom" title="Selesaikan Proses">
							<i class="bi bi-journal-check"></i>
						</a>';
				}
				$data[] = $row;
			}
			
			$callback	= [
				'draw'			=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'	=> $countData,
				'recordsFiltered'=>$countData,
				'data'			=> $data,
			];
			echo json_encode($callback);
		}
		
		public function mulai($id_pengiriman) {
			
			$data['judul']		= "Mulai Proses Data"; 
			$data['pengiriman']	= $this->m_proses->getById($id_pengiriman, true);

			$this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/proses_perpajakan/tambah', $data);
			} else {
				$this->m_proses->tambahProses();
				$this->session->set_flashdata('notification', 'Proses data dimulai!');
				redirect('akuntan/proses_data_perpajakan');
			}
		}
		
		public function selesai($id_proses) {
			
			$data['judul']		= "Perbarui Proses Data"; 
			$data['pengiriman']	= $this->m_proses->getById($id_proses);
			
			$this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/proses_perpajakan/ubah', $data);
			} else {
				$this->m_proses->ubahProses();
				$this->session->set_flashdata('notification', 'Proses data selesai!');
				redirect('akuntan/proses_data_perpajakan');
			}
		}

		public function detail() {
			$id_proses	= $this->input->post('id', true);
			$proses		= $this->m_proses->getById($id_proses);
			$durasi		= '';

			if( $proses['tanggal_mulai'] ) {
				if( $proses['tanggal_selesai'] ) {
					$durasi	= $this->proses_admin->durasi($proses['tanggal_mulai'], $proses['tanggal_selesai']);
				} else {
					$durasi	= $this->proses_admin->durasi($proses['tanggal_mulai']);
				}
			}
			
			$data['judul']	= 'Detail Proses';
			$data['proses']	= $proses;
			$data['durasi']	= $durasi;
			$this->load->view('akuntan/proses_perpajakan/detail', $data);
		}
		
		public function download() {
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$get		= $this->input->post('klien', true);
			$tampil		= $this->input->post('tampil', true);
			$filename	= strtoupper($bulan).' '.$tahun;

			if($get == null) {
				$klien = $this->Klien_model->getAllKlien(); 
			} else {
				if($tampil == "Akuntan") {
					$akses = $this->Akses_model->getByAkuntan($get, $bulan, $tahun);
					$getNew = explode(",", $akses['klien']);
					$filename = $filename.' '.$akses['nama'];
					foreach($getNew as $e) {
						$klien[] = $this->Klien_model->getById($e);
					}
				} else {
					$get		= $this->Klien_model->getById($get);
					$filename	= $filename.' '.$get['nama_klien'];
					$klien[]	= $get;
				}
			}

			$status = $this->session->userdata('status');
			foreach($klien as $k) {
				if($status == 'belum')
				$perklien = $this->m_proses->getByKlienBelum($bulan, $tahun, $k['id_klien']);
				elseif($status == 'selesai')
				$perklien = $this->m_proses->getByKlienSelesai($bulan, $tahun, $k['id_klien']);
				else
				$perklien = $this->m_proses->getByKlienSedang($bulan, $tahun, $k['id_klien']);
				
				$proses[$k['id_klien']] = $perklien;
			}
			
			$data['proses']		= $proses;
			$data['bulan']		= $bulan;
			$data['tahun']		= $tahun;
			$data['klien']		= $klien;
			$data['now']		= date('d/m/Y H:i');
			$data['filename']	= 'Proses Data Perpajakan '.$filename;
			$data['judul']		= "Proses Data Perpajakan";
			
			if($status == 'belum')
			$data['subjudul']	= "Belum Diproses";
			elseif($status == 'selesai')
			$data['subjudul']	= "Selesai Diproses";
			else
			$data['subjudul']	= "Sedang Diproses";

			if($this->input->post('xls', true)) {
				echo "xls";
				return $this->exportproses->exportExcel($data);
			}
			elseif($this->input->post('pdf', true))
				return $this->exportproses->exportPdf($data);
		}
	}
?>
