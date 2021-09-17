<?php
	
	class Export_permintaan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('M_Export');
		}
		
		public function index() {
			$data['judul']		= 'Laporan Permintaan Data';
			$data['bulan']		= $this->Klien_model->getMasa();
			$data['kategori']	= ['Akuntansi', 'Perpajakan', 'Lainnya'];
			
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('bulan', 'Bulan', 'required');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required');
			
			$this->libtemplate->main('akuntan/export/permintaan', $data);
		}
		
		public function getKlien() {
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$kategori	= $this->input->post('kategori', true);
			$id_akuntan	= $this->session->userdata('id_user');
			
			$bulan	= $this->Klien_model->getMasa($bulan)['id_bulan'];
			$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan, $id_akuntan, $kategori);
			$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $id_akuntan, $kategori);
			
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
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Export->countPermintaan($tahun, $bulan, $klien, $kategori); 
			$permintaan	= $this->M_Export->getPermintaan($tahun, $bulan, $klien, $kategori, $offset, $limit);
			
			$data = [];
			foreach($permintaan as $k) {
				$badge = 'Belum Dikirim';
				if($k['status_kirim'] == 'yes') {
					$badge = 'Lengkap';
				} elseif($k['status_kirim'] == 'no') {
					$badge = 'Belum Lengkap';
				}
				$pengiriman = $this->M_Export->maxPengiriman($k['id_data'], $kategori);
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['request'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $k['nama'];
				$row[]	= $k['jenis_data'];
				$row[]	= $k['detail'];
				$row[]	= $k['format_data'];
				$row[]	= $badge;
				$row[]	= ($pengiriman) ? $pengiriman['tanggal_pengiriman'] : '-';
				
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
		
		public function filename() {
			$bulan		= $this->Klien_model->getMasa($_REQUEST['bulan']);
			$bulan		= substr($bulan['nama_bulan'], 0, 3);
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