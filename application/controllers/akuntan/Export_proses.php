<?php
	
	class Export_proses extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('M_Export');
		}
		
		public function index() {
			$data['judul']		= 'Laporan Proses Data';
			$data['bulan']		= Globals::bulan();
			$data['kategori']	= ['Akuntansi', 'Perpajakan', 'Lainnya'];
			
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('bulan', 'Bulan', 'required');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required');
			
			$this->libtemplate->main('akuntan/export/proses', $data);
		}
		
		public function getKlien() {
			$masa		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$kategori	= $this->input->post('kategori', true);
			$id_akuntan	= $this->session->userdata('id_user');
			
			$bulan	= Globals::bulan($masa);
			$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan['id'], $id_akuntan, $kategori);
			$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan['id'], $id_akuntan, $kategori);
			
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
			$tahun		= $_POST['tahun'];
			$bulan		= $_POST['bulan'];
			$klien		= $_POST['klien'];
			$kategori	= $_POST['kategori'];
			
			if($klien == null) {
				$klien	= [];
				$id		= $this->session->userdata('id_user');
				$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan, $id, $kategori);
				$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $id, $kategori);
				if( $akses ) {
					foreach($akses as $a) {
						$klien[] = $a['kode_klien'];
					}
				} else $klien = null;
			}
			
			$countData	= $this->M_Export->countProses($tahun, $bulan, $klien, $kategori); 
			$permintaan	= $this->M_Export->getProses($tahun, $bulan, $klien, $kategori);
			
			$data = [];
			foreach($permintaan as $num => $k) {
				$badge = 'Belum Dikirim';
				if($k['status_proses'] == 'done') {
					$badge = 'Selesai';
				} elseif($k['status_proses'] == 'yet') {
					$badge = 'On Proses';
				} else {
					$badge = 'Belum Diproses';
				}
				$pengiriman	= $this->M_Export->maxPengiriman($k['id_data'], $kategori);
				
				$durasi		= '';
				$addDurasi	= '';
				$detail		= $this->M_Export->detailProses($k['id_data'], $kategori);
				foreach($detail as $d) {
					if( $d['tanggal_mulai'] ) {
						$durasi = $this->proses_admin->durasi($d['tanggal_mulai'], $d['tanggal_selesai']);
						if( $addDurasi ) {
							$durasi = $this->proses_admin->addDurasi($durasi, $addDurasi);
						}
						$addDurasi = $durasi;
					}
				}
				// format durasi
				if($durasi) {
					$dur	= explode(',', $durasi);
					$jam	= ($dur[0] * 8) + $dur[1];
					$durasi	= $jam.' jam '. $dur[2].' min';
				}
				// format estimasi
				$stat		= str_replace(' ', '_', strtolower($k['status_pekerjaan']));
				$estimasi	= ($k[$stat]) ? $k[$stat].' jam' : '';
				
				$row	= [];
				$row[]	= $k['id_data'];
				$row[]	= ++$num.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['jenis_data'];
				$row[]	= $k['detail'];
				$row[]	= $pengiriman['tanggal_pengiriman'];
				$row[]	= isset($k['nama_tugas']) ? $k['nama_tugas'] : '';
				$row[]	= $durasi;
				$row[]	= $estimasi;
				$row[]	= $badge;
				
				$data[] = $row;
			}
			
			$callback = [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=> $countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
		
		public function child() {
			$detail	= $this->M_Export->detailProses($_REQUEST['id_data'], $_REQUEST['kategori']);
			echo json_encode($detail);
		}
		
		public function filename() {
			$bulan		= Globals::bulan($_REQUEST['bulan']);
			$bulan		= substr($bulan['nama'], 0, 3);
			$tahun		= $_REQUEST['tahun'];
			$kategori	= ucwords($_REQUEST['kategori']);
			$akuntan	= $this->session->userdata('nama');
			$klien		= $this->Klien_model->getById($_REQUEST['klien']);
			$nama		= ($klien) ? $klien['nama_klien'] : $akuntan;
			
			$result = [
				'filename'	=> 'Laporan Permintaan Data '.$kategori.' '.$bulan.' '.$tahun.' '.$nama,
				'title'		=> 'Laporan Permintaan Data '.$kategori,
			];
			echo json_encode($result);
		}
	}
?>