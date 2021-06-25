<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->library('exportproses');
			
			$this->load->model('M_Proses_akuntansi', 'm_proses');
			$this->load->model('Klien_model');
			$this->load->model('Akuntan_model');
			$this->load->model('Akses_model');
		} 
		 
		public function index() {
			$data['judul'] = "Proses Data Akuntansi"; 
			$this->libtemplate->main('admin/proses_akuntansi/tampil', $data);
		}
		
		public function prosesOn() {
			$unset = ['status', 'tampil', 'akuntan'];
			$this->session->unset_userdata($unset);
			
			$status		= $_POST['status'];
			$tampil		= $_POST['tampil'];
			$akuntan	= $_POST['akuntan'] ? $_POST['akuntan'] : '';
			$this->session->set_userdata('status', $status);
			$this->session->set_userdata('tampil', $tampil);
			$this->session->set_userdata('akuntan', $akuntan);
			
			$data['header']	= "Proses Data Akuntansi";
			$data['masa']	= $this->Klien_model->getMasa();
			
			$this->load->view('admin/proses_akuntansi/view_'.$status, $data);
		}

		public function gantiTampilan() {
			$lists	= "<option value='kosong'> --- </option>";
			if($_POST['tampil'] == 'Akuntan') {
				$lists	= "<option value='kosong'>--Semua ".$_POST['tampil']."--</option>";
				$akuntan	= $this->Akuntan_model->getAllAkuntan();
				foreach($akuntan as $a) {
					$lists	.= "<option value='".$a['id_user']."'>".$a['nama']."</option>"; 
				}
			}
			echo $lists;
		}
		
		public function gantiKlien() {
			$lists		= "<option value='kosong'>--Tidak Ada Klien--</option>";
			$tampil		= isset($_POST['tampil']) ? $_POST['tampil'] : $this->session->userdata('tampil');
			$akuntan	= isset($_POST['akuntan']) ? $_POST['akuntan'] : $this->session->userdata('akuntan');
			$klien		= $this->Klien_model->getAllKlien();
			
			if($tampil == "Akuntan") {
				if($akuntan && $akuntan != 'kosong') {
					$akses = $this->Akses_model->getByAkuntan($_POST['tahun'], $akuntan);
					if($akses) {
						$bulan = $this->Klien_model->getMasa($_POST['bulan']);
						if($bulan['id_bulan'] < $akses['masa']) {
							$akses = $this->Akses_model->getByAkuntan(($_POST['tahun'] - 1), $akuntan);
						}
					} 
					if($akses) {
						$id_klien	= explode(',', $akses['klien']);
						$klien		= [];
						foreach($id_klien as $id) {
							$klien[] = $this->Klien_model->getById($id);
						}
					} else {
						$klien = '';
					}
				}
			}
			
			if($klien) {
				$lists		= "<option value=''>--Semua Klien--</option>";
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
			$jenis		= $this->session->userdata('tampil'); // jenis tampilan(per klien/per akuntan)
			$akuntan	= $this->session->userdata('akuntan');
			$status		= $this->session->userdata('status'); 
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			
			if($jenis == "Akuntan") {
				if($klien == null) {
					$akses = $this->Akses_model->getByAkuntan($tahun, $akuntan);
					if($akses) { 
						$masa = $this->Klien_model->getMasa($bulan);
						if($masa['id_bulan'] < $akses['masa']) {
							$akses = $this->Akses_model->getByAkuntan(($tahun-1), $akuntan);
						}
						if($akses) {
							$klien = explode(",", $akses['klien']);
							implode(",", $klien);
						}
					}
				}
			}
			$countData	= $this->m_proses->countProses($status, $bulan, $tahun, $klien);
			$proses		= $this->m_proses->getByMasa($status, $bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($proses as $k) {
				$hari	= floor($k['lama_pengerjaan'] / 8);
				$jam	= $k['lama_pengerjaan'] % 8;
				$standar= $hari.' hari '.$jam.' jam';
				
				if($k['tanggal_mulai']) {
					$durasi	= $this->proses_admin->durasi($k['tanggal_mulai'], $k['tanggal_selesai']);
					if($k['temp_selesai']) {
						$durasi	= $this->proses_admin->durasi($k['tanggal_mulai'], $k['temp_selesai']);
						$add	= $this->proses_admin->durasi($k['temp_mulai'], $k['tanggal_selesai']);
						$durasi	= $durasi + $add;
					}
				}
				$btn = '
					<a class="btn btn-sm btn-primary btn-detail" data-nilai="'.$k['id_proses'].'" data-toggle="tooltip" data-placement="bottom" title="Detail">
						<i class="bi bi-info-circle"></i>
					</a>
					<a class="btn btn-sm btn-danger btn-batal" data-nilai="'.$k['id_proses'].'" data-toggle="tooltip" data-placement="bottom" title="Batalkan Proses">
						<i class="bi bi-trash"></i>
					</a>';
				
				$row	= [];
				$row[]	= ++$offset.'.';
				if($status == 'belum') {
					$row[]	= $k['nama_klien'];
					$row[]	= $k['nama_tugas'];
					$row[]	= $k['jenis_data'];
					$row[]	= $k['request'];
					$row[]	= $k['pembetulan'];
					$row[]	= $standar;
				} elseif($status == 'selesai') {
					$row[]	= $k['nama_klien'];
					$row[]	= $k['nama'];
					$row[]	= $k['nama_tugas'];
					$row[]	= $durasi;
					$row[]	= $standar;
					$row[]	= $btn;
				} else {
					$row[]	= $k['nama_klien'];
					$row[]	= $k['nama'];
					$row[]	= $k['nama_tugas'];
					$row[]	= $k['tanggal_mulai'];
					$row[]	= $durasi;
					$row[]	= $standar;
					$row[]	= $btn;
				}
				$data[] = $row;
			}
			
			$callback	= [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=>$countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
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
			
			$this->load->view('admin/proses_akuntansi/detail', $data);
		}

		public function batal() {
			$data					= $this->m_proses->getById($this->input->post('id'));
			$data['id_disposer3']	= $this->session->userdata('id_user');
			$data['status_proses']	= $this->session->userdata('status');
			
			$this->m_proses->batalProses($data);
			$this->session->set_flashdata('notification', 'Proses berhasil dibatalkan!'); 
		}

		public function export() {
			$data['judul']	= 'Export Laporan Proses Data';
			$data['masa']	= $this->Klien_model->getMasa();
			$this->load->view('admin/proses_akuntansi/export', $data);
		}
		
		public function download() {
			$masa		= $this->input->post('masa', true);
			$tahun		= $this->input->post('tahun', true);
			$klien		= $this->input->post('klien', true);
			$akuntan	= $this->input->post('akuntan', true);
			$tampil		= $this->input->post('tampil', true);
			$filename	= strtoupper(substr($masa, 0, 3)).' '.substr($tahun, -2);
			$bulan		= $this->Klien_model->getMasa($masa);

			if($klien == null) {
				$klien		= $this->Klien_model->getAllKlien(); 
				$akuntans	= $this->Akuntan_model->getAllAkuntan();
				
				if($tampil == "Akuntan" && $akuntan != null) {
					$akses = $this->Akses_model->getByAkuntan($tahun, $akuntan);
					if($akses) {
						if($bulan['id_bulan'] < $akses['masa']) {
							$akses = $this->Akses_model->getByAkuntan(($tahun - 1), $akuntan);
						}
					} 
					$klien = [];
					if($akses) {
						$getNew		= explode(",", $akses['klien']);
						$filename	= $filename.' '.$akses['nama'];
						foreach($getNew as $e) {
							$klien[] = $this->Klien_model->getById($e);
						}
					}
				}
			} else {
				$get		= $this->Klien_model->getById($klien);
				$filename	= $filename.' '.$get['nama_klien'];
				$klien		= [];
				$klien[]	= $get;
			}

			foreach($klien as $k) {
				$perklien				= $this->m_proses->getProses('', '', '', $masa, $tahun, $k['id_klien']);
				$proses[$k['id_klien']]	= $perklien;
			}
			
			$data['klien']		= $klien;
			$data['proses']		= $proses;
			$data['bulan']		= $masa;
			$data['tahun']		= $tahun;
			$data['now']		= date('d/m/Y H:i');
			$data['filename']	= 'Proses Data Akuntansi '.$filename;
			$data['judul']		= 'Proses Data Akuntansi';
			/*
			if($status == 'belum')
			$data['subjudul']	= "Belum Diproses";
			elseif($status == 'selesai')
			$data['subjudul']	= "Selesai Diproses";
			else
			$data['subjudul']	= "Sedang Diproses";
			*/
			if($this->input->post('xls', true)) {
				return $this->exportproses->exportExcel($data);
			}
			elseif($this->input->post('pdf', true))
				return $this->exportproses->exportPdf($data);
		}
	}
?>