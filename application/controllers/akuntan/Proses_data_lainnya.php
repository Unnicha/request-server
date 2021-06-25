<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->library('exportproses');
			
			$this->load->model('M_Proses_lainnya', 'm_proses');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
		} 
		 
		public function index() {
			$data['judul'] = "Proses Data Lainnya"; 
			$this->libtemplate->main('akuntan/proses_lainnya/tampil', $data);
		}
		
		public function prosesOn() {
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$data['header']	= "Proses Data Lainnya";
			$data['masa']	= $this->Klien_model->getMasa();
			
			$this->load->view('akuntan/proses_lainnya/view_'.$status, $data);
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
			$proses		= $this->m_proses->getByMasa($status, $bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($proses as $k) {
				$hari		= floor($k['lama_pengerjaan'] / 8);
				$jam		= $k['lama_pengerjaan'] % 8;
				$standar	= $hari.' hari '.$jam.' jam';
				
				if( $k['tanggal_mulai'] ) {
					$durasi = $this->proses_admin->durasi($k['tanggal_mulai'], $k['tanggal_selesai']);
				}
				
				$row	= [];
				$row[]	= ++$offset.'.';
				if($status == 'belum') {
					$row[]	= $k['nama_klien'];
					$row[]	= $k['nama_tugas'];
					$row[]	= $k['jenis_data'];
					$row[]	= $k['request'];
					$row[]	= $k['pembetulan'];
					$row[]	= $standar;
					$row[]	= '
						<a href="proses_data_lainnya/mulai/'.$k['id_proses'].'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Mulai Proses">
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
						<a class="btn btn-sm btn-info" href="proses_data_lainnya/selesai/'.$k['id_proses'].'" data-toggle="tooltip" data-placement="bottom" title="Selesaikan Proses">
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
		
		public function mulai($id_proses) {
			$data['judul']		= "Mulai Proses Data"; 
			$data['pengiriman']	= $this->m_proses->getById($id_proses, true);
			
			$this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			if($this->input->post('tanggal_selesai')) {
				if($this->input->post('jam_selesai') == null)
				$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			} else {
				if($this->input->post('jam_selesai'))
				$this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
			}
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/proses_lainnya/tambah', $data);
			} else {
				if($this->m_proses->tambahProses() == 'ERROR') {
					redirect('akuntan/proses_data_lainnya/mulai/'.$id_proses);
				} else {
					$this->session->set_flashdata('notification', 'Proses data dimulai!');
					redirect('akuntan/proses_data_lainnya');
				}
			}
		}
		
		public function selesai($id_proses) {
			$data['judul']		= "Proses Selesai"; 
			$data['pengiriman']	= $this->m_proses->getById($id_proses);
			$data['mulai']		= explode(' ', $data['pengiriman']['tanggal_mulai']);
			
			$this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/proses_lainnya/ubah', $data);
			} else {
				$this->m_proses->ubahProses();
				$this->session->set_flashdata('notification', 'Proses data selesai!');
				redirect('akuntan/proses_data_lainnya');
			}
		}

		public function detail() {
			$proses			= $this->m_proses->getById($this->input->post('id', true));
			$add['durasi']	= $this->proses_admin->durasi($proses['tanggal_mulai'], $proses['tanggal_selesai']);
			
			if( $proses['tanggal_selesai'] ) {
				$add['status']	= '<span class="badge badge-success">Proses Selesai</span>';
			} else {
				$add['status']	= '<span class="badge badge-warning">Belum Selesai</span>';
			}
			$hari			= floor($proses['lama_pengerjaan'] / 8);
			$jam			= $proses['lama_pengerjaan'] % 8;
			$add['standar']	= $hari.' hari '.$jam.' jam';

			$data['judul']	= 'Detail Proses';
			$data['proses']	= $proses;
			$data['add']	= $add;
			$this->load->view('akuntan/proses_lainnya/detail', $data);
		}

		public function export() {
			$data['judul']	= 'Export Laporan Proses Data';
			$data['masa']	= $this->Klien_model->getMasa();
			$this->load->view('akuntan/proses_lainnya/export', $data);
		}
		
		public function download() {
			$masa		= $this->input->post('masa', true);
			$tahun		= $this->input->post('tahun', true);
			$klien		= $this->input->post('klien', true);
			$akuntan	= $this->session->userdata('id_user');
			$filename	= strtoupper(substr($masa, 0, 3)).' '.substr($tahun, 2);
			$bulan		= $this->Klien_model->getMasa($masa);
			$kliens		= [];

			if($klien == null) {
				$akses		= $this->Akses_model->getByAkuntan($tahun, $akuntan);
				if($akses) {
					if($bulan['id_bulan'] < $akses['masa'])
					$akses	= $this->Akses_model->getByAkuntan(($tahun - 1), $akuntan);
				}
				if($akses) {
					$filename	= $filename.' '.$akses['nama'];
					$klien		= explode(",", $akses['klien']);
					implode(",", $klien);
				}
			}
			
			if(is_array($klien) != 1) {
				$klien = [$klien];
			}
			foreach($klien as $id_klien) {
				$get				= $this->m_proses->getProses('', '', '', $masa, $tahun, $id_klien);
				$proses[$id_klien]	= $get;
				$kliens[]			= $this->Klien_model->getById($id_klien);
			}
			
			$data['proses']		= $proses;
			$data['bulan']		= $masa;
			$data['tahun']		= $tahun;
			$data['klien']		= $kliens;
			$data['now']		= date('d/m/Y H:i');
			$data['filename']	= 'Proses Data Lainnya '.$filename;
			$data['judul']		= "Proses Data Lainnya";
			
			if($_POST['export'] == 'xls') {
				return $this->exportproses->exportExcel($data);
			}
			elseif($_POST['export'] == 'pdf') {
				return $this->exportproses->exportPdf($data);
			}
		}
	}
?>
