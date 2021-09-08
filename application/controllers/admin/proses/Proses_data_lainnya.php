<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->library('exportproses');
			
			$this->load->model('M_Proses_lainnya', 'M_Proses');
			$this->load->model('M_Pengiriman_lainnya');
			$this->load->model('Klien_model');
			$this->load->model('Akuntan_model');
			$this->load->model('Akses_model');
		} 
		 
		public function index() {
			$this->session->unset_userdata('akuntan');
			$data['judul'] = "Proses Data Lainnya"; 
			$data['link']	= base_url() . 'admin/proses/proses_data_lainnya';
			
			$this->libtemplate->main('admin/proses_lainnya/tampil', $data);
		}
		
		public function prosesOn() {
			$status = $_POST['tab'];
			$this->session->set_userdata('status', $status);
			
			$data['judul']		= 'Export Laporan Proses Data';
			$data['masa']		= $this->Klien_model->getMasa();
			$data['akuntan']	= $this->Akuntan_model->getAllAkuntan();
			
			$this->load->view('admin/proses_lainnya/view/'.$status, $data);
		}
		
		public function gantiKlien() {
			$bulan		= $_POST['bulan'];
			$tahun		= $_POST['tahun'];
			$akuntan	= $_POST['akuntan'];
			
			if($akuntan) {
				$klien	= $this->Akses_model->getByAkuntan($tahun, $bulan, $akuntan, 'lainnya');
				$klien	= ($klien) ? $klien : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $akuntan, 'lainnya');
			} else {
				$klien	= $this->Klien_model->getAllKlien();
			}
			
			$lists = "<option value=''>--Tidak Ada Klien--</option>";
			if( $klien ) {
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
			
			// jika memilih akuntan ...
			if($akuntan) {
				// ... tampilkan semua klien yang bisa diakses jika tidak ada klien yang dipilih
				if(empty($klien)) {
					$klien	= [];
					$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan, $akuntan, 'lainnya');
					$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $akuntan, 'lainnya');
					if( $akses ) {
						foreach($akses as $a) {
							$klien[] = $a['kode_klien'];
						}
					} else $klien = null;
				}
			}
			
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
				}
				$prosesor	= array_unique($prosesor);
				// format estimasi
				$stat		= str_replace(' ', '_', strtolower($k['status_pekerjaan']));
				$estimasi	= ($k[$stat]) ? $k[$stat].' jam' : '';
				// format durasi
				if($durasi) {
					$dur	= explode(',', $durasi);
					$jam	= ($dur[0] * 8) + $dur[1];
					$durasi	= $jam.' jam '. $dur[2].' min';
				}
				
				// format badge status
				if($k['status_proses'] == 'done') {
					$badge	= '<span class="badge badge-success">Done</span>';
				} elseif($k['status_proses'] == 'yet') {
					$badge	= '<span class="badge badge-warning">On Process</span>';
				} else {
					$badge	= '<span class="badge badge-danger">To Do</span>';
				}
				
				// buttons
				$btn = '<a class="btn-detail" data-id="'.$k['id_data'].'" data-toggle="tooltip" data-placement="bottom" title="Detail">
						<i class="bi bi-info-circle-fill icon-medium"></i>
					</a>';
				$tugas = '<a href="'.base_url('admin/master/tugas').'">
						<small class="text-danger">Lengkapi tugas disini.</small>
					</a>';
				if($status=='done' && $k['status_proses']=='done') {
					$btn .= '<a class="btn-batal" data-nilai="'.$k['id_data'].'" data-toggle="tooltip" data-placement="bottom" title="Batal Selesai">
							<i class="bi bi-trash icon-medium"></i>
						</a>';
				}
				
				// isi table
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= ($k['nama_tugas']) ? $k['nama_tugas'] : $tugas;
				$row[]	= ($status == 'todo') ? $k['jenis_data'].' '.$k['detail'] : implode(', ', $prosesor);
				if($status != 'todo') 
					$row[]	= $durasi;
				$row[]	= $estimasi;
				if($status == 'all')
					$row[]	= $badge;
				$row[]	= $btn;
				
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
			$pengiriman	= $this->M_Pengiriman_lainnya->getById($_REQUEST['id_data']);
			$last		= $this->M_Pengiriman_lainnya->getMax($_REQUEST['id_data']);
			
			if( $pengiriman['status_proses'] == 'done' ) {
				$pengiriman['badge']	= '<span class="badge badge-success">Selesai</span>';
			} else {
				$pengiriman['badge']	= '<span class="badge badge-warning">Belum Selesai</span>';
			}
			
			$add		= [];
			$total		= '';
			$proses		= $this->M_Proses->getDetail($_REQUEST['id_data']);
			if($proses) {
				foreach($proses as $p) {
					$selesai	= ($p['tanggal_selesai']) ? $p['tanggal_selesai'] : '';
					$durasi		= $this->proses_admin->durasi($p['tanggal_mulai'], $selesai);
					$total		= ($total) ? $this->proses_admin->addDurasi($total, $durasi) : $durasi;
					
					$durasi	= explode(',', $durasi);
					$add[]	= (($durasi[0] * 8) + $durasi[1]).' jam '. $durasi[2].' min';
				}
				$total		= explode(',', $total);
				$totalDur	= ($total[0] * 8) + $total[1];
				$totalDur	= $totalDur.' jam '. $total[2].' min';
			}
			
			$stat					= strtolower($pengiriman['status_pekerjaan']);
			$pengiriman['estimasi'] = ($pengiriman[$stat]) ? $pengiriman[$stat].' jam' : '';
			$pengiriman['last']		= $last['tanggal_pengiriman'];
			$pengiriman['akuntan']	= $proses ? $proses[0]['nama'] : '';
			
			$data['judul']		= 'Detail Proses';
			$data['pengiriman']	= $pengiriman;
			$data['proses']		= $proses ? $proses : '';
			$data['durasi']		= $add;
			$data['total']		= $total ? $totalDur : '';
			
			$this->load->view('admin/proses_lainnya/detail', $data);
		}

		public function batal() {
			$id				= $_REQUEST['id'];
			$data['judul']	= 'Batal Selesai';
			$data['text']	= 'Yakin ingin membatalkan status proses?';
			$data['button']	= '
				<a href="proses_data_lainnya/fix_batal/'.$id.'" class="btn btn-danger">Batal</a>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal" tabindex="1">Tutup</button>
			';
			
			$this->load->view('admin/template/confirm', $data);
		}
		
		public function fix_batal($id_data) {
			$this->M_Proses->batalProses($id_data);
			$this->session->set_flashdata('notification', 'Proses berhasil dibatalkan!');
			redirect('admin/proses/proses_data_lainnya');
		}
	}
?>