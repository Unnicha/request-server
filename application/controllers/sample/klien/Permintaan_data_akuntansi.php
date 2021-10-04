<?php
	
	class Permintaan_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('notif');
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('M_Pengiriman_akuntansi');
		} 
		
		public function index() {
			
			$data['judul'] = "Permintaan Data Akuntansi";
			$data['masa'] = $this->M_Permintaan_akuntansi->masa();

			//$this->notif->klien();
			$this->libtemplate->main('klien/permintaan_akuntansi/tampil', $data);
		}
		
		public function isi() {

			$bulan = $_POST['bulan'];
			$tahun = $_POST['tahun'];
			$klien_id = $this->session->userdata('id_user');
			
			$data['pengiriman'] = $this->M_Pengiriman_akuntansi->getAllPengiriman();
			$permintaan = $this->M_Permintaan_akuntansi->getPerKlien($bulan, $tahun, $klien_id);
			
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);

			//tidak menampilkan data yang sudah dikirim
			foreach($data['pengiriman'] as $b) {
				foreach($permintaan as $a => $key) {
					if ($key['id_permintaan'] == $b['id_permintaan']) {
						unset($permintaan[$a]);
					}
				}
			}
			$data['permintaan'] = $permintaan;

			if($permintaan == null) {
				$this->session->set_flashdata('empty', 'Belum ada permintaan');
				$this->load->view('empty');
			} else {
				$this->load->view('klien/permintaan_akuntansi/isi', $data);
			}
		}
		
		public function kirim($id_permintaan) {
			
			$data['judul'] = "Form Pengiriman Data"; 
			$data['header'] = "Kirim Data";
			$data['permintaan'] = $this->M_Permintaan_akuntansi->getById($id_permintaan);
			
			$this->form_validation->set_rules('tanggal_pengiriman', 'Tanggal Pengiriman', 'required');
			$this->form_validation->set_rules('format_data', 'Format Data', 'required');
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_akuntansi/kirim', $data);
			} else {
				$this->M_Pengiriman_akuntansi->kirim();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('klien/permintaan_data_akuntansi'); 
			}
		}

		public function detail() {
			
			$id_permintaan = $_REQUEST['id_permintaan']; //data yang dikirim via Js

			$data['judul'] = 'Detail Permintaan Data ';
			$data['permintaan'] = $this->M_Permintaan_akuntansi->getById($id_permintaan);
			
			$this->load->view('klien/permintaan_akuntansi/detail', $data);
		}
	}
?>