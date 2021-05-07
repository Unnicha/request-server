<?php
	
	class Permintaan_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_lainnya');
			$this->load->model('M_Pengiriman_lainnya');
		} 
		
		public function index() {
			
			$data['judul'] = "Permintaan Data Lainnya";
			$data['masa'] = $this->M_Permintaan_lainnya->masa();
			$data['pengiriman'] = $this->M_Pengiriman_lainnya->getAllPengiriman();

			$this->libtemplate->main('klien/permintaan_lainnya/tampil', $data);
		}
		
		public function isi() {

			$bulan = $_POST['bulan'];
			$tahun = $_POST['tahun'];
			$klien_id = $this->session->userdata('id_user');
			
			$data['pengiriman'] = $this->M_Pengiriman_lainnya->getAllPengiriman();
			$permintaan = $this->M_Permintaan_lainnya->getPerKlien($bulan, $tahun, $klien_id);
			
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
				$this->load->view('klien/permintaan_lainnya/isi', $data);
			}
		}
		
		public function kirim($id_permintaan) {
			
			$data['judul'] = "Form Pengiriman Data"; 
			$data['header'] = "Kirim Data";
			$data['permintaan'] = $this->M_Permintaan_lainnya->getById($id_permintaan);
			
			$this->form_validation->set_rules('tanggal_pengiriman', 'Tanggal Pengiriman', 'required');
			$this->form_validation->set_rules('format_data', 'Format Data', 'required');
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_lainnya/kirim', $data);
			} else {
				$this->M_Pengiriman_lainnya->kirim();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('klien/permintaan_data_lainnya'); 
			}
		}

		public function detail() {

			$id_permintaan = $this->input->post('id_permintaan', true);

			$data['judul'] = 'Detail Permintaan Data ';
			$data['permintaan'] = $this->M_Permintaan_lainnya->getById($id_permintaan);
			
			$this->load->view('klien/permintaan_lainnya/detail', $data);
		}
	}
?>