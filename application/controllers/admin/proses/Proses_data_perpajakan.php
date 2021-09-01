<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->library('exportproses');
			
			$this->load->model('M_Proses_perpajakan', 'M_Proses');
			$this->load->model('M_Pengiriman_perpajakan');
			$this->load->model('Klien_model');
			$this->load->model('Akuntan_model');
			$this->load->model('Akses_model');
		} 
		 
		public function index() {
			$this->session->unset_userdata('akuntan');
			$data['judul'] = "Proses Data Perpajakan"; 
			$data['link']	= base_url() . 'admin/proses/proses_data_perpajakan';
			
			$this->libtemplate->main('admin/proses_perpajakan/tampil', $data);
		}
		
		public function prosesOn() {
			$status = $_POST['tab'];
			$this->session->set_userdata('status', $status);
			
			$data['judul']		= 'Export Laporan Proses Data';
			$data['masa']		= $this->Klien_model->getMasa();
			$data['akuntan']	= $this->Akuntan_model->getAllAkuntan();
			
			$this->load->view('admin/proses_perpajakan/view/'.$status, $data);
		}
		
		public function gantiKlien() {
			$lists	= "<option value=''>--Tidak Ada Klien--</option>";
			$klien	= [];
			
			if($_POST['akuntan']) {
				$akses = $this->Akses_model->getByAkuntan($_POST['tahun'], $_POST['akuntan']);
				if($akses) {
					if($_POST['bulan'] < $akses['masa']) {
						$akses = $this->Akses_model->getByAkuntan(($_POST['tahun'] - 1), $_POST['akuntan']);
					}
					if($akses) {
						$klien = $this->Klien_model->getById(explode(',', $akses['klien']));
					}
				}
			} else {
				$klien = $this->Klien_model->getAllKlien();
			}
			
			if($klien) {
				$lists = "<option value=''>--Semua Klien--</option>";
				foreach($klien as $k) {
					$lists .= "<option value='".$k['id_klien']."'>".$k['nama_klien']."</option>"; 
				}
			}
			echo $lists;
		}
		
		public function page() {
			$bulan		= $_REQUEST['bulan'];		$this->session->set_userdata('bulan', $bulan); 
			$tahun		= $_REQUEST['tahun'];		$this->session->set_userdata('tahun', $tahun);
			$akuntan	= $_REQUEST['akuntan'];		$this->session->set_userdata('akuntan', $akuntan);
			$klien		= $this->input->post('klien', true);
			$status		= $this->session->userdata('status'); 
			
			if($akuntan) {
				if(empty($klien)) {
					$akses = $this->Akses_model->getByAkuntan($tahun, $akuntan);
					if($akses) {
						if($bulan < $akses['masa']) {
							$akses = $this->Akses_model->getByAkuntan(($tahun-1), $akuntan);
						}
						if($akses) {
							$klien = explode(",", $akses['perpajakan']);
							implode(",", $klien);
						}
					}
				}
			}
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Proses->countProses($status, $bulan, $tahun, $klien);
			$proses		= $this->M_Proses->getByMasa($status, $bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($proses as $k) {
				$stat		= str_replace(' ', '_', strtolower($k['status_pekerjaan']));
				$estimasi	= ($k[$stat]) ? $k[$stat].' jam' : '';
				$durasi		= '';
				if($status != 'todo'){
					$total	= '';
					$detail	= $this->M_Proses->getDetail($k['id_data']);
					foreach($detail as $d) {
						$selesai	= ($d['tanggal_selesai']) ? $d['tanggal_selesai'] : '';
						$dur		= $this->proses_admin->durasi($d['tanggal_mulai'], $selesai);
						$total		= ($total) ? $this->proses_admin->addDur($total, $dur) : $dur;
					}
					if($total) {
						$dur	= explode(',', $total);
						$durasi	= ($dur[0] * 8) + $dur[1];
						$durasi	= $durasi.' jam '. $dur[2].' min';
					}
				}
				
				if($k['status_proses'] == 'done') {
					$badge	= '<span class="badge badge-success">Done</span>';
				} elseif($k['status_proses'] == 'yet') {
					$badge	= '<span class="badge badge-warning">On Process</span>';
				} else {
					$badge	= '<span class="badge badge-danger">To Do</span>';
				}
				
				$btn = '<a class="btn-detail" data-id="'.$k['id_data'].'" data-proses="'.$k['id_proses'].'" data-toggle="tooltip" data-placement="bottom" title="Detail">
						<i class="bi bi-info-circle-fill icon-medium"></i>
					</a>';
				if($status == 'done') {
					$btn .= '<a class="btn-batal" data-nilai="'.$k['id_data'].'" data-toggle="tooltip" data-placement="bottom" title="Batal Selesai">
							<i class="bi bi-trash icon-medium"></i>
						</a>';
				}
				$tugas = '<a href="'.base_url('admin/master/tugas').'" data-nilai="'.$k['id_proses'].'">
						<small class="text-danger">Lengkapi tugas disini.</small>
					</a>';
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= ($status == 'todo') ? $k['jenis_data'].' '.$k['detail'] : $k['nama'];
				$row[]	= ($k['nama_tugas']) ? $k['nama_tugas'] : $tugas;
				if($status != 'todo') {
					$row[]	= $durasi;
				}
				$row[]	= $estimasi;
				$row[]	= ($status == 'all') ? $badge : $btn;
				
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

		public function detail() {
			$pengiriman	= $this->M_Pengiriman_perpajakan->getById($_REQUEST['id_data']);
			$detail		= $this->M_Pengiriman_perpajakan->getDetail($_REQUEST['id_data']);
			$status		= $this->session->userdata('status');
			$stat		= strtolower($pengiriman['status_pekerjaan']);
			$pengiriman['estimasi'] = ($pengiriman[$stat]) ? $pengiriman[$stat].' jam' : '';
			
			if($status != 'todo') {
				$add	= [];
				$total	= '';
				$proses	= $this->M_Proses->getDetail($_REQUEST['id_data']);
				foreach($proses as $p) {
					$selesai		= ($p['tanggal_selesai']) ? $p['tanggal_selesai'] : '';
					$dur			= $this->proses_admin->durasi($p['tanggal_mulai'], $selesai);
					$durasi			= explode(',', $dur);
					$jam			= ($durasi[0] * 8) + $durasi[1];
					$i['durasi']	= $jam.' jam '. $durasi[2].' min';
					$total			= ($total) ? $this->proses_admin->addDur($total, $dur) : $dur;
					
					if( $p['tanggal_selesai'] ) {
						$i['badge']	= '<span class="badge badge-success">Proses Selesai</span>';
					} else {
						$i['badge']	= '<span class="badge badge-warning">Belum Selesai</span>';
					}
					$add[] = $i;
				}
				$total		= explode(',', $total);
				$totalDur	= ($total[0] * 8) + $total[1];
				$totalDur	= $totalDur.' jam '. $total[2].' min';
			}
			// Estimasi bdsk status pengerjaan klien
			$stat				= str_replace(' ', '_', strtolower($pengiriman['status_pekerjaan']));
			$add['standar']		= $pengiriman[$stat].' jam';
			
			$data['judul']		= 'Detail Proses';
			$data['pengiriman']	= $pengiriman;
			$data['detail']		= $detail;
			$data['proses']		= isset($proses) ? $proses : '';
			$data['add']		= $add;
			$data['total']		= isset($total) ? $totalDur : '';
			
			$this->load->view('admin/proses_perpajakan/detail', $data);
		}

		public function batal() {
			$id				= $_REQUEST['id'];
			$data['judul']	= 'Batal Selesai';
			$data['text']	= 'Yakin ingin membatalkan status proses?';
			$data['button']	= '
				<a href="proses_data_perpajakan/fix_batal/'.$id.'" class="btn btn-danger">Batal</a>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal" tabindex="1">Tutup</button>
			';
			
			$this->load->view('admin/template/confirm', $data);
		}
		
		public function fix_batal($id_data) {
			$this->M_Proses->batalProses($id_data);
			$this->session->set_flashdata('notification', 'Proses berhasil dibatalkan!');
			redirect('admin/proses/proses_data_perpajakan');
		}
		
		// public function cek_proses() {
		// 	$klien = $_POST['klien'] ? $_POST['klien'] : $this->Klien_model->getId();
		// 	$count = $this->M_Proses->countProses('', $_POST['bulan'], $_POST['tahun'], $klien);
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
		// 	$masa	= $this->input->post('masa', true);
		// 	$tahun	= $this->input->post('tahun', true);
		// 	$klien	= $this->input->post('klien', true);
			
		// 	$klien		= $klien ? $klien : $this->Klien_model->getId();
		// 	$bulan		= $this->Klien_model->getMasa($masa);
		// 	$filename	= strtoupper(substr($bulan['nama_bulan'], 0, 3)).' '.substr($tahun, 2);
			
		// 	foreach($klien as $id_klien) {
		// 		$proses[$id_klien]	= $this->M_Proses->getById('', $id_klien, $tahun, $masa);
		// 	}
		// 	if($proses) {
		// 		$data['masa'] = [
		// 			'bulan'	=> $bulan['nama_bulan'],
		// 			'tahun'	=> $tahun,
		// 		];
		// 		$data['proses']		= $proses;
		// 		$data['now']		= date('d/m/Y H:i');
		// 		$data['filename']	= 'Proses Data Perpajakan '.$filename;
		// 		$data['judul']		= 'Proses Data Perpajakan';
				
		// 		if($_POST['export'] == 'xls') {
		// 			return $this->exportproses->exportExcel($data);
		// 		}
		// 		elseif($_POST['export'] == 'pdf') {
		// 			return $this->exportproses->exportPdf($data);
		// 		}
		// 	} else {
		// 		$this->session->set_flashdata('flash', 'Tidak ada proses data!');
		// 		redirect('admin/proses/proses_data_perpajakan?p=export');
		// 	}
		// }
	}
?>