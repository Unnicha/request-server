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
			$data['judul']	= "Proses Data Lainnya"; 
			$data['link']	= base_url() . 'akuntan/proses_data_lainnya';
			
			$this->libtemplate->main('akuntan/proses_lainnya/tampil', $data);
		}
		
		public function prosesOn() {
			$this->session->set_userdata('status', $_POST['tab']);
			
			$data['judul']	= 'Export Laporan Proses Data';
			$data['masa']	= $this->Klien_model->getMasa();
			
			$this->load->view('akuntan/proses_lainnya/view_'.$_POST['tab'], $data);
		}
		
		public function gantiKlien() {
			$klien		= [];
			$akuntan	= $this->session->userdata('id_user');
			$akses		= $this->Akses_model->getByAkuntan($_POST['tahun'], $akuntan);
			if($akses) {
				if($_POST['bulan'] < $akses['masa']) {
					$akses = $this->Akses_model->getByAkuntan(($_POST['tahun'] - 1), $akuntan);
				}
				if($akses) {
					$klien = $this->Klien_model->getById(explode(',', $akses['lainnya']));
				}
			}
			
			if($klien) {
				$lists = "<option value=''>--Semua Klien--</option>";
				foreach($klien as $k) {
					$lists .= "<option value='".$k['id_klien']."'>".$k['nama_klien']."</option>"; 
				}
			} else {
				$lists = "<option value=''>--Tidak Ada Akses--</option>";
			}
			echo $lists; 
		}
		
		public function page() {
			$tahun		= $_POST['tahun'];		$this->session->set_userdata('tahun', $tahun);
			$bulan		= $_POST['bulan'];		$this->session->set_userdata('bulan', $bulan);
			$klien		= $this->input->post('klien', true);
			$akuntan	= $this->session->userdata('id_user');
			$status		= $this->session->userdata('status');
			
			if(empty($klien)) {
				$akses = $this->Akses_model->getByAkuntan($tahun, $akuntan);
				if($akses) { 
					if($bulan < $akses['masa']) {
						$akses = $this->Akses_model->getByAkuntan(($tahun-1), $akuntan);
					}
					if($akses) {
						$klien = explode(",", $akses['lainnya']);
						implode(",", $klien);
					} else {
						$klien = 'kosong';
					}
				}
			}
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->m_proses->countProses($status, $bulan, $tahun, $klien);
			$proses		= $this->m_proses->getByMasa($status, $bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($proses as $k) {
				$stat		= str_replace(' ', '_', strtolower($k['status_pekerjaan']));
				$standar	= $k[$stat].' jam';
				//$hari		= floor($k[$stat] / 8);
				//$jam		= $k[$stat] % 8;
				//$standar	= $hari.' hari '.$jam.' jam';
				
				if( $k['tanggal_mulai'] ) {
					$dur	= $this->proses_admin->durasi($k['tanggal_mulai'], $k['tanggal_selesai']);
					if($k['temp_selesai']) {
						$dur1	= $this->proses_admin->durasi($k['tanggal_mulai'], $k['temp_selesai']);
						$dur2	= $this->proses_admin->durasi($k['temp_mulai'], $k['tanggal_selesai']);
						$dur	= $this->proses_admin->addDurasi($dur1, $dur2);
					}
					$dur	= explode(' ', $dur);
					$jam	= ($dur[0] * 8) + $dur[1];
					$durasi	= $jam.' jam '. $dur[2].' min';
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
			$pengiriman	= $this->m_proses->getById($id_proses, true);
			$stat		= str_replace(' ', '_', strtolower($pengiriman['status_pekerjaan']));
			
			$pengiriman['standar']	= $pengiriman[$stat].' jam';
			$data['judul']			= "Mulai Proses Data";
			$data['pengiriman']		= $pengiriman;
			
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
			$pengiriman	= $this->m_proses->getById($id_proses, true);
			$stat		= str_replace(' ', '_', strtolower($pengiriman['status_pekerjaan']));
			
			$pengiriman['standar']	= $pengiriman[$stat].' jam';
			$data['judul']			= "Proses Selesai"; 
			$data['pengiriman']		= $pengiriman;
			$data['mulai']			= explode(' ', $pengiriman['tanggal_mulai']);
			
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
			$proses	= $this->m_proses->getById($this->input->post('id', true));
			$dur	= $this->proses_admin->durasi($proses['tanggal_mulai'], $proses['tanggal_selesai']);
			if($proses['temp_selesai']) {
				$dur1	= $this->proses_admin->durasi($proses['tanggal_mulai'], $proses['temp_selesai']);
				$dur2	= $this->proses_admin->durasi($proses['temp_mulai'], $proses['tanggal_selesai']);
				$dur	= $this->proses_admin->addDurasi($dur1, $dur2);
			}
			$dur			= explode(' ', $dur);
			$jam			= ($dur[0] * 8) + $dur[1];
			$add['durasi']	= $jam.' jam '. $dur[2].' min';
			
			if( $proses['tanggal_selesai'] ) {
				$add['status']	= '<span class="badge badge-success">Proses Selesai</span>';
			} else {
				$add['status']	= '<span class="badge badge-warning">Belum Selesai</span>';
			}
			$stat			= str_replace(' ', '_', strtolower($proses['status_pekerjaan']));
			$add['standar']	= $proses[$stat].' jam';
			
			$data['judul']	= 'Detail Proses';
			$data['proses']	= $proses;
			$data['add']	= $add;
			$this->load->view('akuntan/proses_lainnya/detail', $data);
		}
		
		public function cek_proses() {
			if($_POST['klien'] == null) {
				$klien = '';
				$akses = $this->Akses_model->getByAkuntan($_POST['tahun'], $_SESSION['id_user']);
				if($akses) {
					if($_POST['bulan'] < $akses['masa']) {
						$akses = $this->Akses_model->getByAkuntan(($_POST['tahun']-1), $_SESSION['id_user']);
					}
					if($akses) {
						$klien = explode(',', $akses['lainnya']);
					}
				}
			}
			$klien = $_POST['klien'] ? $_POST['klien'] : $klien;
			$count = $this->m_proses->countProses('', $_POST['bulan'], $_POST['tahun'], $klien);
			if($count < 1) {
				$alert	= '<div class="alert alert-danger" role="alert">Tidak ada proses.</div>';
				$button	= '';
			} else {
				$alert	= '<div class="alert alert-primary" role="alert">Ada '.$count.' proses data.</div>';
				$button	= 'ok';
			}
			$callback = [
				'alert'		=> $alert,
				'button'	=> $button,
			];
			echo json_encode($callback);
		}
		
		public function download() {
			$masa		= $this->input->post('masa', true);
			$tahun		= $this->input->post('tahun', true);
			$id			= $this->input->post('klien', true);
			$akuntan	= $this->session->userdata('id_user');
			
			$bulan		= $this->Klien_model->getMasa($masa);
			$filename	= strtoupper(substr($bulan['nama_bulan'], 0, 3)).' '.substr($tahun, 2);
			$kliens		= [];
			
			if($id == null) {
				$akses		= $this->Akses_model->getByAkuntan($tahun, $akuntan);
				if($akses) {
					if($masa < $akses['masa'])
					$akses	= $this->Akses_model->getByAkuntan(($tahun - 1), $akuntan);
				}
				if($akses) {
					$filename	= $filename.' '.$akses['nama'];
					$klien		= explode(',', $akses['lainnya']);
					implode(',', $klien);
				}
			} else {
				$klien = [$id];
			}
			
			foreach($klien as $id_klien) {
				$proses[$id_klien]	= $this->m_proses->getById('', $id_klien, $tahun, $masa);
			}
			if($proses) {
				$data['masa'] = [
					'bulan'	=> $bulan['nama_bulan'],
					'tahun'	=> $tahun,
				];
				$data['proses']		= $proses;
				$data['now']		= date('d/m/Y H:i');
				$data['filename']	= 'Proses Data Lainnya '.$filename;
				$data['judul']		= 'Proses Data Lainnya';
				
				if($_POST['export'] == 'xls') {
					return $this->exportproses->exportExcel($data);
				}
				elseif($_POST['export'] == 'pdf') {
					return $this->exportproses->exportPdf($data);
				}
			} else {
				$this->session->set_flashdata('flash', 'Tidak ada proses data!');
				redirect('akuntan/proses_data_lainnya?p=export');
			}
		}
	}
?>
