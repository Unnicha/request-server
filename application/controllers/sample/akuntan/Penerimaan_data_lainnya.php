<?php
	
	class Penerimaan_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('M_Pengiriman_lainnya');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
		} 
		
		public function index() {
			
			$data['judul'] = "Penerimaan Data Lainnya"; 
			$data['header'] = $data['judul'];
			$data['sub_header'] = "Daftar data yang sudah diterima & data yang akan diambil.";

			$data['klien'] = $this->Klien_model->getAllKlien();
			$data['masa'] = $this->M_Pengiriman_lainnya->masa();
			$data['lokasi'] = "asset/uploads/";
			
			$this->libtemplate->main('akuntan/penerimaan_lainnya/tampil', $data);
		}

		public function ganti() {
			
			$klien = $_POST['klien'];
			$bulan = $_POST['bulan'];
			$tahun = $_POST['tahun'];
				
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);

			if($klien == null) {
				$id_akuntan	= $this->session->userdata('id_user');
				$akses		= $this->Akses_model->getByAkuntanMasa($id_akuntan, $bulan, $tahun);
				if($akses == null) {
					$data['pengiriman'] = null;
				} else {
					$pengiriman = $this->M_Pengiriman_lainnya->getPerMasa($bulan, $tahun);
					$data['pengiriman'] = [];
					$id_klien = explode(",", $akses['klien']);
					foreach($id_klien as $id) { 
						foreach($pengiriman as $p => $val) {
							if($val['id_klien'] == $id)
							array_push($data['pengiriman'], $pengiriman[$p]);
						}
					} 
				}
			} else {
				$data['pengiriman'] = $this->M_Pengiriman_lainnya->getPerKlien($bulan, $tahun, $klien);
			}

			if($data['pengiriman'] == null) {
				$this->session->set_flashdata('empty', 'Belum ada data');
				$this->load->view('empty');
			} else {
				$this->load->view('akuntan/penerimaan_lainnya/isi', $data);
			}
		}

		public function klien() {
			
			$bulan	= $_REQUEST['bulan'];
			$tahun	= $_REQUEST['tahun'];
			
			$id_akuntan	= $this->session->userdata('id_user');
			$akses		= $this->Akses_model->getByAkuntanMasa($id_akuntan, $bulan, $tahun);
			if($akses == null) {
				$lists	= "<option value=''>--Tidak ada akses--</option>";
			} else {
				$lists	= "<option value=''>Semua Klien</option>";
				$id_klien	= explode(",", $akses['klien']);
				foreach($id_klien as $id) {
					$klien = $this->Klien_model->getById($id);
					$lists .= "<option value='".$klien['id_klien']."'>".$klien['nama_klien']."</option>"; 
				} 
			}
			echo $lists;
		}

		public function detail() {
			$id_pengiriman = $_REQUEST['action'];
			$pengiriman = $this->M_Pengiriman_lainnya->getById($id_pengiriman);

			$data['lokasi'] = "asset/uploads/{$pengiriman['nama_klien']}/{$pengiriman['tahun']}/{$pengiriman['masa']}";
			$data['judul'] = 'Detail Pengiriman Data';
			$data['pengiriman'] = $pengiriman;
			
			if($pengiriman['pembetulan'] == 0) {
				$this->load->view('akuntan/penerimaan_lainnya/detail_pengiriman', $data);
			} else {
				$this->load->view('akuntan/penerimaan_lainnya/detail_pembetulan', $data);
			}
		}
	}
?>