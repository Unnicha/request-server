<?php
	
	class Permintaan_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_lainnya');
			$this->load->model('M_Pengiriman_lainnya');
			$this->load->model('Klien_model');
			$this->load->model('Jenis_data_model');
		} 
		 
		public function index() {
			
			$data['judul'] = "Permintaan Data Lainnya";
			$data['header'] ="Data Lainnya";
			$data['sub_header'] = "Daftar permintaan data";

			$data['masa'] = $this->M_Permintaan_lainnya->masa();
			$data['klien'] = $this->Klien_model->getAllKlien();
			
			$this->libtemplate->main('admin/permintaan_lainnya/tampil', $data);
		}

		public function ganti() {
			
			$klien = $_POST['klien'];
			$bulan = $_POST['bulan'];
			$tahun = $_POST['tahun'];
			
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);
			
			$data['pengiriman'] = $this->M_Pengiriman_lainnya->getAllPengiriman();
			if($klien == null) {
				$permintaan = $this->M_Permintaan_lainnya->getPerMasaTahun($bulan, $tahun);
			} else {
				$permintaan = $this->M_Permintaan_lainnya->getPerKlien($bulan, $tahun, $klien);
			}
			$data['permintaan'] = $permintaan;

			if($permintaan == null) {
				$this->session->set_flashdata('empty', 'Belum ada permintaan');
				$this->load->view('empty');
			} else {
				$this->load->view('admin/permintaan_lainnya/isi', $data);
			}
		}

		public function tambah() {
			
			$data['judul'] = "Form Tambah Permintaan"; 
			$data['header'] = "Kirim Permintaan - Data Lainnya";
			
			$data['masa'] = $this->M_Permintaan_lainnya->masa();
			$data['jenis'] = $this->Jenis_data_model->getAllJenisData();
			$data['klien'] = $this->Klien_model->getAllKlien();
			
			$this->form_validation->set_rules('id_klien', 'Klien', 'required');
			$this->form_validation->set_rules('kode_jenis', 'Jenis Data', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/permintaan_lainnya/tambah', $data);
			} else {
				$this->M_Permintaan_lainnya->tambahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/permintaan_data_lainnya'); 
			}
		}
		
		public function ubah($id_permintaan) {

			$data['judul'] = "Form Ubah Permintaan"; 
			$data['header'] = "Perbarui Permintaan";

			$data['masa'] = $this->M_Permintaan_lainnya->masa();
			$data['klien'] = $this->Klien_model->getAllKlien();
			$data['jenis'] = $this->Jenis_data_model->getAllJenisData();
			$data['permintaan'] = $this->M_Permintaan_lainnya->getById($id_permintaan);
			
			$this->form_validation->set_rules('id_klien', 'Klien', 'required');
			$this->form_validation->set_rules('kode_jenis', 'Jenis Data', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/permintaan_lainnya/ubah', $data);
			} else {
				$this->M_Permintaan_lainnya->ubahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('admin/permintaan_data_lainnya'); 
			}
		}

		public function detail() {

			$data['judul'] = 'Detail Permintaan';
			$id_permintaan = $_REQUEST['permintaan'];
			$data['permintaan'] = $this->M_Permintaan_lainnya->getById($id_permintaan);
			
			$this->load->view('admin/permintaan_lainnya/detail', $data);
		}
		
		public function hapus($id_permintaan) {
			
			$this->M_Permintaan_lainnya->hapusPermintaan($id_permintaan);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/permintaan_data_lainnya');
		}
	}
?>