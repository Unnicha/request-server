<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->library('exportproses');
			
			$this->load->model('M_Proses_lainnya', 'MProses');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
		}
		
		public function index() {
			$data['judul']	= "Proses Data Lainnya"; 
			$data['link']	= base_url().'akuntan/proses_data_lainnya';
			
			$this->libtemplate->main('akuntan/proses_lainnya/tampil', $data);
		}
		
		public function prosesOn() {
			$data['judul']	= 'Export Laporan Proses Data';
			$data['masa']	= $this->Klien_model->getMasa();
			$this->session->set_userdata('status', $_POST['tab']);
			
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
			$countData	= $this->MProses->countProses($status, $bulan, $tahun, $klien);
			$proses		= $this->MProses->getByMasa($status, $bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($proses as $k) {
				$durasi		= '';
				$stat		= str_replace(' ', '_', strtolower($k['status_pekerjaan']));
				$standar	= ($k[$stat]) ? $k[$stat].' jam' : '';
				if($status != 'todo') {
					if( $k['tanggal_mulai'] ) {
						$dur	= $this->proses_admin->durasi($k['tanggal_mulai'], $k['tanggal_selesai']);
						$dur	= explode(' ', $dur);
						$jam	= ($dur[0] * 8) + $dur[1];
						$durasi	= $jam.' jam '. $dur[2].' min';
					}
				}
				
				$action = '';
				if($status == 'todo') {
					$action .= '
						<a href="proses_data_lainnya/mulai/'.$k['id_data'].'" data-toggle="tooltip" data-placement="bottom" title="Mulai Proses">
							<i class="bi bi-file-earmark-play-fill icon-medium"></i>
						</a>';
				} elseif($status == 'done') {
					$action .= '
						<a class="btn-detail" data-nilai="'.$k['id_proses'].'" data-toggle="tooltip" data-placement="bottom" title="Detail">
							<i class="bi bi-info-circle-fill icon-medium"></i>
						</a>';
				} else {
					// cuma bisa didonekan sama yang memulai proses
					$btnSelesai = ($k['id_akuntan'] != $akuntan) ? '' : '
						<a href="proses_data_lainnya/done/'.$k['id_proses'].'" data-toggle="tooltip" data-placement="bottom" title="Selesaikan Proses">
							<i class="bi bi-file-earmark-check-fill icon-medium"></i>
						</a>';
					$action	= '
						<a class="btn-detail" data-nilai="'.$k['id_proses'].'" data-toggle="tooltip" data-placement="bottom" title="Detail">
							<i class="bi bi-info-circle-fill icon-medium"></i>
						</a>'.$btnSelesai;
				}
				
				if($k['status_proses'] == 'done') {
					$badge	= '<span class="badge badge-success">Done</span>';
				} elseif($k['status_proses'] == 'yet') {
					$badge	= '<span class="badge badge-warning">On Process</span>';
				} else {
					$badge	= '<span class="badge badge-danger">To Do</span>';
				}
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['nama_tugas'];
				$row[]	= ($status == 'todo') ? $k['jenis_data'].' '.$k['detail'] : $k['nama'];
				if($status != 'todo') {
					$row[]	= $durasi;
				}
				$row[]	= $standar;
				$row[]	= ($status == 'all') ? $badge : $action;
				$data[] = $row;
			}
			
			$callback	= [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=> $countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
		
		public function mulai($id_data) {
			$pengiriman	= $this->MProses->getByData($id_data, true);
			$stat		= str_replace(' ', '_', strtolower($pengiriman['status_pekerjaan']));
			
			$pengiriman['standar']	= $pengiriman[$stat].' jam';
			$data['judul']			= "Mulai Proses Data";
			$data['pengiriman']		= $pengiriman;
			
			$this->form_validation->set_rules('nama_tugas', 'Output', 'required');
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
				$this->libtemplate->main('akuntan/proses_lainnya/mulai', $data);
			} else {
				if($this->MProses->tambahProses() == 'ERROR') {
					redirect('akuntan/proses_data_lainnya/mulai/'.$id_data);
				} else {
					$this->session->set_flashdata('notification', 'Proses data dimulai!');
					redirect('akuntan/proses_data_lainnya');
				}
			}
		}
		
		public function done($id_proses) {
			$proses	= $this->M_Proses->getById($id_proses);
			$stat	= str_replace(' ', '_', strtolower($proses['status_pekerjaan']));
			
			if($this->session->userdata('id_user') == $proses['id_user']) {
				$proses['standar']	= $proses[$stat].' jam';
				$data['judul']		= "Proses Selesai"; 
				$data['proses']		= $proses;
				$data['mulai']		= explode(' ', $proses['tanggal_mulai']);
				
				$this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
				$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
				
				if($this->form_validation->run() == FALSE) {
					$this->libtemplate->main('akuntan/proses_lainnya/selesai', $data);
				} else {
					$this->MProses->ubahProses();
					$this->session->set_flashdata('notification', 'Proses data done!');
					redirect('akuntan/proses_data_lainnya');
				}
			} else {
				redirect('akuntan/proses_data_lainnya');
			}
		}
		
		public function detail() {
			$proses	= $this->MProses->getByProses($this->input->post('id', true));
			
			if( $proses['tanggal_selesai'] ) {
				$add['status']	= '<span class="badge badge-success">Proses Selesai</span>';
			} else {
				$add['status']	= '<span class="badge badge-warning">Belum Selesai</span>';
			}
			$stat			= str_replace(' ', '_', strtolower($proses['status_pekerjaan']));
			$add['standar']	= $proses[$stat].' jam';
			
			$data['judul']	= 'Proses Data';
			$data['proses']	= $proses;
			$data['add']	= $add;
			$this->load->view('akuntan/proses_lainnya/detail', $data);
		}
		
		// public function countDur($mulai, $done) {
		// 	$dur			= $this->proses_admin->durasi($mulai, $done);
		// 	$dur			= explode(' ', $dur);
		// 	$jam			= ($dur[0] * 8) + $dur[1];
		// 	$add['durasi']	= $jam.' jam '. $dur[2].' min';
		// }
		
		// public function cek_proses() {
		// 	if($_POST['klien'] == null) {
		// 		$klien = '';
		// 		$akses = $this->Akses_model->getByAkuntan($_POST['tahun'], $_SESSION['id_user']);
		// 		if($akses) {
		// 			if($_POST['bulan'] < $akses['masa']) {
		// 				$akses = $this->Akses_model->getByAkuntan(($_POST['tahun']-1), $_SESSION['id_user']);
		// 			}
		// 			if($akses) {
		// 				$klien = explode(',', $akses['lainnya']);
		// 			}
		// 		}
		// 	}
		// 	$klien = $_POST['klien'] ? $_POST['klien'] : $klien;
		// 	$count = $this->MProses->countProses('', $_POST['bulan'], $_POST['tahun'], $klien);
		// 	if($count < 1) {
		// 		$alert	= '<div class="alert alert-danger" role="alert">Tidak ada proses.</div>';
		// 		$button	= '';
		// 	} else {
		// 		$alert	= '<div class="alert alert-primary" role="alert">Ada '.$count.' proses data.</div>';
		// 		$button	= 'ok';
		// 	}
		// 	$callback = [
		// 		'alert'		=> $alert,
		// 		'button'	=> $button,
		// 	];
		// 	echo json_encode($callback);
		// }
		
		// public function download() {
		// 	$masa		= $this->input->post('masa', true);
		// 	$tahun		= $this->input->post('tahun', true);
		// 	$id			= $this->input->post('klien', true);
		// 	$akuntan	= $this->session->userdata('id_user');
			
		// 	$bulan		= $this->Klien_model->getMasa($masa);
		// 	$filename	= strtoupper(substr($bulan['nama_bulan'], 0, 3)).' '.substr($tahun, 2);
		// 	$kliens		= [];
			
		// 	if($id == null) {
		// 		$akses		= $this->Akses_model->getByAkuntan($tahun, $akuntan);
		// 		if($akses) {
		// 			if($masa < $akses['masa'])
		// 			$akses	= $this->Akses_model->getByAkuntan(($tahun - 1), $akuntan);
		// 		}
		// 		if($akses) {
		// 			$filename	= $filename.' '.$akses['nama'];
		// 			$klien		= explode(',', $akses['lainnya']);
		// 			implode(',', $klien);
		// 		}
		// 	} else {
		// 		$klien = [$id];
		// 	}
			
		// 	foreach($klien as $id_klien) {
		// 		$proses[$id_klien]	= $this->MProses->getById('', $id_klien, $tahun, $masa);
		// 	}
		// 	if($proses) {
		// 		$data['masa'] = [
		// 			'bulan'	=> $bulan['nama_bulan'],
		// 			'tahun'	=> $tahun,
		// 		];
		// 		$data['proses']		= $proses;
		// 		$data['now']		= date('d/m/Y H:i');
		// 		$data['filename']	= 'Proses Data Lainnya '.$filename;
		// 		$data['judul']		= 'Proses Data Lainnya';
				
		// 		if($_POST['export'] == 'xls') {
		// 			return $this->exportproses->exportExcel($data);
		// 		}
		// 		elseif($_POST['export'] == 'pdf') {
		// 			return $this->exportproses->exportPdf($data);
		// 		}
		// 	} else {
		// 		$this->session->set_flashdata('flash', 'Tidak ada proses data!');
		// 		redirect('akuntan/proses_data_lainnya?p=export');
		// 	}
		// }
	}
?>
