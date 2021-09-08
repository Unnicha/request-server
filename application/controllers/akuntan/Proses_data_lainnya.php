<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->library('exportproses');
			
			$this->load->model('M_Proses_lainnya', 'M_Proses');
			$this->load->model('M_Pengiriman_lainnya', 'M_Pengiriman');
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
			
			$this->load->view('akuntan/proses_lainnya/view/'.$_POST['tab'], $data);
		}
		
		public function gantiKlien() {
			$akuntan	= $this->session->userdata('id_user');
			$tahun		= $_POST['tahun'];
			$bulan		= $_POST['bulan'];
			$akses		= $this->Akses_model->getByAkuntan($tahun, $bulan, $akuntan, 'lainnya');
			$akses		= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $akuntan, 'lainnya');
			
			$lists	= "<option value=''>--Tidak ada akses--</option>";
			if( $akses ) {
				$lists		= "<option value=''>--Semua Klien--</option>";
				foreach($akses as $a) {
					$lists .= "<option value='".$a['id_klien']."'>".$a['nama_klien']."</option>";
				}
			}
			echo $lists;
		}
		
		public function page() {
			$tahun		= $_POST['tahun'];		$this->session->set_userdata('tahun', $tahun);
			$bulan		= $_POST['bulan'];		$this->session->set_userdata('bulan', $bulan);
			
			$klien		= $this->input->post('klien', true);
			$akuntan	= $this->session->userdata('id_user');
			$status		= $this->session->userdata('status');
			
			// tampilkan klien yang bisa diakses jika tidak ada yang dipilih
			if(empty($klien)) {
				$klien	= [];
				$id		= $this->session->userdata('id_user');
				$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan, $id, 'lainnya');
				$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $id, 'lainnya');
				if( $akses ) {
					foreach($akses as $a) {
						$klien[] = $a['kode_klien'];
					}
				} else $klien = null;
			}
			// get selected data
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Proses->countProses($status, $bulan, $tahun, $klien);
			$proses		= $this->M_Proses->getByMasa($status, $bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($proses as $k) {
				$durasi		= '';
				$addDurasi	= '';
				$prosesor	= [];
				$detail		= $this->M_Proses->getDetail($k['id_data']);
				foreach($detail as $d) {
					$prosesor[] = $d['nama'];
					if( $d['tanggal_mulai'] ) {
						$durasi = $this->proses_admin->durasi($d['tanggal_mulai'], $d['tanggal_selesai']);
						if( $addDurasi ) {
							$durasi = $this->proses_admin->addDurasi($durasi, $addDurasi);
						}
						$addDurasi = $durasi;
					}
					$id_proses	= $d['id_proses'];
					$id_prosesor= $d['id_akuntan'];
				}
				$prosesor	= array_unique($prosesor);
				// format estimasi
				$stat		= str_replace(' ', '_', strtolower($k['status_pekerjaan']));
				$standar	= ($k[$stat]) ? $k[$stat].' jam' : '';
				// format durasi
				if($durasi) {
					$dur	= explode(',', $durasi);
					$jam	= ($dur[0] * 8) + $dur[1];
					$durasi	= $jam.' jam '. $dur[2].' min';
				}
				
				// buttons
				$action = '
					<a class="btn-detail" data-id="'.$k['id_data'].'" data-toggle="tooltip" data-placement="bottom" title="Detail">
						<i class="bi bi-info-circle-fill icon-medium"></i>
					</a>';
				if($status == 'todo') {
					$action .= '
						<a href="proses_data_lainnya/mulai/'.$k['id_data'].'" data-toggle="tooltip" data-placement="bottom" title="Mulai Proses">
							<i class="bi bi-file-earmark-play-fill icon-medium"></i>
						</a>';
				} elseif($status == 'onproses') {
					// cuma bisa didone sama yang memulai proses
					$action .= ($id_prosesor != $akuntan) ? '' : '
						<a href="proses_data_lainnya/done/'.$id_proses.'" data-toggle="tooltip" data-placement="bottom" title="Selesaikan Proses">
							<i class="bi bi-file-earmark-check-fill icon-medium"></i>
						</a>';
				}
				// badge status
				if($k['status_proses'] == 'done') {
					$badge	= '<span class="badge badge-success">Done</span>';
				} elseif($k['status_proses'] == 'yet') {
					$badge	= '<span class="badge badge-warning">On Process</span>';
				} else {
					$badge	= '<span class="badge badge-danger">To Do</span>';
				}
				
				// isi table
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['nama_tugas'];
				$row[]	= ($status == 'todo') ? $k['jenis_data'].' '.$k['detail'] : implode(', ', $prosesor);
				if($status != 'todo') 
					$row[]	= $durasi;
				$row[]	= $standar;
				if($status == 'all')
					$row[]	= $badge;
				$row[]	= $action;
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
			$pengiriman	= $this->M_Pengiriman->getById($id_data);
			$stat		= str_replace(' ', '_', strtolower($pengiriman['status_pekerjaan']));
			$last		= $this->M_Pengiriman->getMax($id_data);
			
			$durasi		= '';
			$addDurasi	= '';
			$detail		= $this->M_Proses->getDetail($id_data);
			foreach($detail as $d) {
				if( $d['tanggal_mulai'] ) {
					$durasi = $this->proses_admin->durasi($d['tanggal_mulai'], $d['tanggal_selesai']);
					if( $addDurasi ) {
						$durasi = $this->proses_admin->addDurasi($durasi, $addDurasi);
					}
					$addDurasi = $durasi;
				}
			}
			if($durasi) {
				$dur	= explode(',', $durasi);
				$jam	= ($dur[0] * 8) + $dur[1];
				$durasi	= $jam.' jam '. $dur[2].' min';
			}
			
			$pengiriman['last']		= $last['tanggal_pengiriman'];
			$pengiriman['standar']	= $pengiriman[$stat].' jam';
			$pengiriman['durasi']	= $durasi;
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
				if($this->M_Proses->tambahProses() == 'ERROR') {
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
			$last	= $this->M_Pengiriman->getMax($proses['id_data']);
			
			$durasi		= '';
			$addDurasi	= '';
			$detail		= $this->M_Proses->getDetail($proses['id_data']);
			foreach($detail as $d) {
				if( $d['tanggal_mulai'] ) {
					$durasi = $this->proses_admin->durasi($d['tanggal_mulai'], $d['tanggal_selesai']);
					if( $addDurasi ) {
						$durasi = $this->proses_admin->addDurasi($durasi, $addDurasi);
					}
					$addDurasi = $durasi;
				}
			}
			if($durasi) {
				$dur	= explode(',', $durasi);
				$jam	= ($dur[0] * 8) + $dur[1];
				$durasi	= $jam.' jam '. $dur[2].' min';
			}
			
			if($this->session->userdata('id_user') == $proses['id_akuntan']) {
				$proses['last']		= $last['tanggal_pengiriman'];
				$proses['standar']	= $proses[$stat].' jam';
				$proses['durasi']	= $durasi;
				$data['judul']		= "Proses Selesai"; 
				$data['proses']		= $proses;
				$data['mulai']		= explode(' ', $proses['tanggal_mulai']);
				
				$this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
				$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
				
				if($this->form_validation->run() == FALSE) {
					$this->libtemplate->main('akuntan/proses_lainnya/selesai', $data);
				} else {
					$this->M_Proses->ubahProses();
					$this->session->set_flashdata('notification', 'Proses data done!');
					redirect('akuntan/proses_data_lainnya');
				}
			} else {
				redirect('akuntan/proses_data_lainnya');
			}
		}
		
		public function detail() {
			$pengiriman	= $this->M_Pengiriman->getById($_REQUEST['id_data']);
			$status		= $this->session->userdata('status');
			$stat		= strtolower($pengiriman['status_pekerjaan']);
			$last		= $this->M_Pengiriman->getMax($_REQUEST['id_data']);
			
			if( $pengiriman['status_proses'] == 'done' ) {
				$pengiriman['badge']	= '<span class="badge badge-success">Selesai</span>';
			} else {
				$pengiriman['badge']	= '<span class="badge badge-warning">Belum Selesai</span>';
			}
			
			$add	= [];
			$total	= '';
			$proses	= $this->M_Proses->getDetail($_REQUEST['id_data']);
			if($proses) {
				foreach($proses as $p) {
					$selesai		= ($p['tanggal_selesai']) ? $p['tanggal_selesai'] : '';
					$dur			= $this->proses_admin->durasi($p['tanggal_mulai'], $selesai);
					$durasi			= explode(',', $dur);
					$jam			= ($durasi[0] * 8) + $durasi[1];
					$result			= $jam.' jam '. $durasi[2].' min';
					$total			= ($total) ? $this->proses_admin->addDurasi($total, $dur) : $dur;
					$add[]			= $result;
				}
				$total		= explode(',', $total);
				$totalDur	= ($total[0] * 8) + $total[1];
				$totalDur	= $totalDur.' jam '. $total[2].' min';
			}
			
			$pengiriman['estimasi'] = ($pengiriman[$stat]) ? $pengiriman[$stat].' jam' : '';
			$pengiriman['last']		= $last['tanggal_pengiriman'];
			$pengiriman['akuntan']	= $proses ? $proses[0]['nama'] : '';
			
			$stat				= str_replace(' ', '_', strtolower($pengiriman['status_pekerjaan']));
			$add['standar']		= $pengiriman[$stat].' jam';
			$data['judul']		= 'Proses Data';
			$data['pengiriman']	= $pengiriman;
			$data['proses']		= $proses ? $proses : '';
			$data['durasi']		= $add;
			$data['total']		= $total ? $totalDur : '';
			
			$this->load->view('akuntan/proses_lainnya/detail', $data);
		}
	}
?>
