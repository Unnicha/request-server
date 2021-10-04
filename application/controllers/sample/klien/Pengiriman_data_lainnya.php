<?php
	
	class Pengiriman_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_lainnya');
			$this->load->model('M_Pengiriman_lainnya');
		} 
		
		public function index() {
			
			$data['judul'] = "Pengiriman Data Lainnya"; 
			$data['masa'] = $this->M_Pengiriman_lainnya->masa();
			$data['lokasi'] = "asset/uploads";

			$this->libtemplate->main('klien/pengiriman_lainnya/tampil', $data);
		}
		
		public function isi() {

			$bulan = $_POST['bulan'];
			$tahun = $_POST['tahun'];
			$klien_id = $this->session->userdata('id_user');
			
			$pengiriman = $this->M_Pengiriman_lainnya->getPerKlien($bulan, $tahun, $klien_id);
			$data['pengiriman'] = $pengiriman;
			
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);

			if($pengiriman == null) {
				$this->session->set_flashdata('empty', 'Belum ada pengiriman');
				$this->load->view('empty');
			} else {
				$this->load->view('klien/pengiriman_lainnya/isi', $data);
			}
		}
		
		public function pembetulan($id_permintaan) {

			$data['judul'] = "Form Kirim Pembetulan"; 
			$data['masa'] = $this->M_Pengiriman_lainnya->masa();
			$data['permintaan'] = $this->M_Permintaan_lainnya->getById($id_permintaan);
						
			$this->form_validation->set_rules('tanggal_pengiriman', 'Tanggal Pengiriman', 'required');
			$this->form_validation->set_rules('format_data', 'Format Data', 'required');
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', ''); 

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/pengiriman_lainnya/pembetulan', $data);
			} else {
				$this->M_Pengiriman_lainnya->kirim();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('klien/pengiriman_data_lainnya'); 
			}
		}
		
		public function detail() {

			$id_pengiriman = $_REQUEST['action'];
			$pengiriman = $this->M_Pengiriman_lainnya->getById($id_pengiriman);

			$data['lokasi'] = "asset/uploads/{$pengiriman['nama_klien']}/{$pengiriman['tahun']}/{$pengiriman['masa']}";
			$data['judul'] = 'Detail Pengiriman Data';
			$data['pengiriman'] = $pengiriman;
			
			if($pengiriman['pembetulan'] == 0) {
				$this->load->view('klien/pengiriman_data_lainnya/detail_pengiriman', $data);
			} else {
				$this->load->view('klien/pengiriman_lainnya/detail_pembetulan', $data);
			}
		}
	}
?>