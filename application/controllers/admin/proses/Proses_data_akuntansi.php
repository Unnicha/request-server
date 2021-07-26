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
			$data['link']	= base_url() . 'admin/proses/proses_data_akuntansi';
			
			$this->libtemplate->main('admin/proses_akuntansi/tampil', $data);
		}
		
		public function prosesOn() {
			$status = $_POST['tab'];
			$this->session->set_userdata('status', $status);
			
			$data['judul']		= 'Export Laporan Proses Data';
			$data['masa']		= $this->Klien_model->getMasa();
			$data['akuntan']	= $this->Akuntan_model->getAllAkuntan();
			
			$this->load->view('admin/proses_akuntansi/view_'.$status, $data);
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
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$klien		= $this->input->post('klien', true);
			$akuntan	= $this->input->post('akuntan', true);
			$status		= $this->session->userdata('status'); 
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			
			if(empty($klien)) {
				if($akuntan) {
					$akses = $this->Akses_model->getByAkuntan($tahun, $akuntan);
					if($akses) {
						if($bulan < $akses['masa']) {
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
				$stat		= str_replace(' ', '_', strtolower($k['status_pekerjaan']));
				$standar	= $k[$stat].' jam';
				//$hari		= floor($k[$stat] / 8);
				//$jam		= $k[$stat] % 8;
				//$standar	= $hari.' hari '.$jam.' jam';
				
				if($k['tanggal_mulai']) {
					$dur	= $this->proses_admin->durasi($k['tanggal_mulai'], $k['tanggal_selesai']);
					if($k['temp_selesai']) {
						$dur	= $this->proses_admin->durasi($k['tanggal_mulai'], $k['temp_selesai']);
						$add	= $this->proses_admin->durasi($k['temp_mulai'], $k['tanggal_selesai']);
						$dur	= $this->proses_admin->addDurasi($dur, $add);
					}
					$dur	= explode(' ', $dur);
					$jam	= ($dur[0] * 8) + $dur[1];
					$durasi	= $jam.' jam '. $dur[2].' min';
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
				'recordsFiltered'	=> $countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}

		public function detail() {
			$proses	= $this->m_proses->getById($this->input->post('id', true));
			if($proses['temp_selesai']) {
				$temp_selesai	= $proses['tanggal_selesai'].'|'.$proses['temp_selesai'];
				$temp_selesai	= explode(',', $temp_selesai);
				$temp_mulai		= $proses['temp_mulai'].'|'.$proses['tanggal_mulai'];
				$temp_mulai		= explode(',', $temp_mulai);
				for($i=0; $i<count($temp_selesai); $i++) {
					$dur	= $dur ? $dur : '';
					$add	= $this->proses_admin->durasi($temp_selesai[$i], $temp_mulai[$i]);
					$dur	= $this->proses_admin->addDurasi($dur, $add);
				}
			} else {
				$dur	= $this->proses_admin->durasi($proses['tanggal_mulai'], $proses['tanggal_selesai']);
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
			
			$this->load->view('admin/proses_akuntansi/detail', $data);
		}

		public function batal() {
			$data					= $this->m_proses->getById($this->input->post('id'));
			$data['id_disposer3']	= $this->session->userdata('id_user');
			$data['status_proses']	= $this->session->userdata('status');
			
			$this->m_proses->batalProses($data);
			$this->session->set_flashdata('notification', 'Proses berhasil dibatalkan!'); 
		}
		
		public function cek_proses() {
			$klien = $_POST['klien'] ? $_POST['klien'] : $this->Klien_model->getId();
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
			$masa	= $this->input->post('masa', true);
			$tahun	= $this->input->post('tahun', true);
			$klien	= $this->input->post('klien', true);
			
			$klien		= $klien ? $klien : $this->Klien_model->getId();
			$bulan		= $this->Klien_model->getMasa($masa);
			$filename	= strtoupper(substr($bulan['nama_bulan'], 0, 3)).' '.substr($tahun, 2);
			
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
				$data['filename']	= 'Proses Data Akuntansi '.$filename;
				$data['judul']		= 'Proses Data Akuntansi';
				
				if($_POST['export'] == 'xls') {
					return $this->exportproses->exportExcel($data);
				}
				elseif($_POST['export'] == 'pdf') {
					return $this->exportproses->exportPdf($data);
				}
			} else {
				$this->session->set_flashdata('flash', 'Tidak ada proses data!');
				redirect('admin/proses/proses_data_akuntansi?p=export');
			}
		}
	}
?>