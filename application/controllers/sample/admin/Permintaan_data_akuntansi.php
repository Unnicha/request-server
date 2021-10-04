<?php
	
	class Permintaan_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('Klien_model');
			$this->load->model('Jenis_data_model');
		} 
		 
		public function index() {
			
			$data['judul'] = "Permintaan Data Akuntansi";
			$data['header'] ="Data Akuntansi";
			$data['sub_header'] = "Daftar permintaan data";

			$data['masa'] = $this->M_Permintaan_akuntansi->masa();
			$data['klien'] = $this->Klien_model->getAllKlien();
			
			$this->libtemplate->main('admin/permintaan_akuntansi/tampil', $data);
		}

		public function ganti() {
			
			$klien = $_POST['klien'];
			$bulan = $_POST['bulan'];
			$tahun = $_POST['tahun'];
				
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);
			
			$data['pengiriman'] = $this->M_Pengiriman_akuntansi->getAllPengiriman();
			if($klien == null) {
				$permintaan = $this->M_Permintaan_akuntansi->getPerMasaTahun($bulan, $tahun);
			} else {
				$permintaan = $this->M_Permintaan_akuntansi->getPerKlien($bulan, $tahun, $klien);
			}
			$data['permintaan'] = $permintaan;

			if($permintaan == null) {
				$this->session->set_flashdata('empty', 'Belum ada permintaan');
				$this->load->view('empty');
			} else {
				$this->load->view('admin/permintaan_akuntansi/isi', $data);
			}
		}

		public function tambah() {
			
			$data['judul']	= "Form Tambah Permintaan"; 
			$data['header']	= "Kirim Permintaan - Data Akuntansi";
			
			$data['masa']	= $this->M_Permintaan_akuntansi->masa();
			$data['jenis']	= $this->Jenis_data_model->getAllJenisData();
			$data['klien']	= $this->Klien_model->getAllKlien();
			
			$this->form_validation->set_rules('id_klien', 'Klien', 'required');
			$this->form_validation->set_rules('kode_jenis', 'Jenis Data', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/permintaan_akuntansi/tambah', $data);
			} else {
				$this->M_Permintaan_akuntansi->tambahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/permintaan_data_akuntansi'); 
			}
		}
		
		public function ubah($id_permintaan) {

			$data['judul']	= "Form Ubah Permintaan"; 
			$data['header']	= "Perbarui Permintaan";

			$data['masa']		= $this->M_Permintaan_akuntansi->masa();
			$data['klien']		= $this->Klien_model->getAllKlien();
			$data['jenis']		= $this->Jenis_data_model->getAllJenisData();
			$data['permintaan']	= $this->M_Permintaan_akuntansi->getById($id_permintaan);
			
			$this->form_validation->set_rules('id_klien', 'Klien', 'required');
			$this->form_validation->set_rules('kode_jenis', 'Jenis Data', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/permintaan_akuntansi/ubah', $data);
			} else {
				$this->M_Permintaan_akuntansi->ubahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('admin/permintaan_data_akuntansi'); 
			}
		}

		public function detail() {

			$data['judul']		= 'Detail Permintaan';
			$id_permintaan		= $_REQUEST['permintaan'];
			$data['permintaan']	= $this->M_Permintaan_akuntansi->getById($id_permintaan);
			
			$this->load->view('admin/permintaan_akuntansi/detail', $data);
		}
		
		public function hapus($id_permintaan) {

			$this->M_Permintaan_akuntansi->hapusPermintaan($id_permintaan);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/permintaan_data_akuntansi');
		}
	}
?>