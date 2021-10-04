<?php
	
	require 'vendor/autoload.php';
	use GuzzleHttp\Client;
	
	class Akses extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->client = new Client([ 'base_uri' => base_url().'api/' ]);
			
			$this->load->model('Akses_model');
			$this->load->model('Akuntan_model');
			$this->load->model('Klien_model');
		} 
		 
		public function index() {
			
			$response = $this->client->get('admin/akses?id_akses=masa');
			if ($response->getStatusCode() == 200) {
				$masa = json_decode($response->getBody()->getContents(), true);
			}
			
			$data['judul']		= "Daftar Akses Klien"; 
			$data['header']		= "Akses Klien";
			$data['subheader']	= "Daftar Akses Data Klien per Bulan";
			$data['masa']		= $masa;
			
			$this->libtemplate->main('admin/akses/tampil', $data);
		}
		
		public function ganti() {
			
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			
			$sess_data = [
				'bulan' => $bulan,
				'tahun' => $tahun,
			];
			$this->session->set_userdata($sess_data);
			
			//$data['klien'] = $this->Klien_model->getAllKlien();
			//$data['akses'] = $this->Akses_model->getPerMasaTahun($bulan, $tahun);
			
			$response = $this->client->get('admin/akses?bulan='.$bulan.'&tahun='.$tahun);
			if ($response->getStatusCode() == 200) {
				$data['akses'] = json_decode($response->getBody()->getContents(), true);
			}

			if($data['akses'] == null) {
				$this->session->set_flashdata('empty', 'Belum ada akses');
				$this->load->view('empty');
			} else {
				$this->load->view('admin/akses/isi', $data);
			}
		}

		public function tambah() {

			$response = $this->client->get('admin/klien');
			if ($response->getStatusCode() == 200) {
				$data['klien'] = json_decode($response->getBody()->getContents(), true);
			}
			$response = $this->client->get('admin/akuntan');
			if ($response->getStatusCode() == 200) {
				$data['akuntan'] = json_decode($response->getBody()->getContents(), true);
			}
			$response = $this->client->get('admin/akses?id_akses=masa');
			if ($response->getStatusCode() == 200) {
				$data['masa'] = json_decode($response->getBody()->getContents(), true);
			} 

			$data['judul'] = 'Form Tambah Akses'; 
			
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('id_akuntan', 'ID Akuntan', 'required');
			$this->form_validation->set_rules('klien[]', 'Klien', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akses/tambah', $data);
			} else {
				$response = $this->client->post('admin/tugas', ['form_params' => [
					'masa'			=> $this->input->post('masa', true),
					'tahun'			=> $this->input->post('tahun', true),
					'id_akuntan'	=> $this->input->post('id_akuntan', true),
					'klien'			=> implode(',', $this->input->post('klien[]', true)),
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil diubah'); 
				} else {
					$this->session->set_flashdata('warning', 'Data gagal diubah'); 
				} 
				redirect('admin/akses');  
			}
		}
		
		public function ubah($id_akses) {
			$data['judul'] = 'Ubah Akses Akuntan'; 
			$data['akses'] = $this->Akses_model->getById($id_akses); 
			$data['akuntan'] = $this->Akuntan_model->getAllAkuntan('akuntan');
			$data['klien'] = $this->Klien_model->getAllKlien();
			$data['masa'] = $this->Akses_model->masa();
			
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('id_akuntan', 'ID Akuntan', 'required');
			$this->form_validation->set_rules('klien[]', 'Klien', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akses/ubah', $data);
			} else {
				$this->Akses_model->ubahAkses();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); //tampilkan pesan sukses
				redirect('admin/akses'); // Kembali ke fungsi index() controller Akuntan
			}
		}

		public function detail() {
			$id_akuntan = $_REQUEST['id_akuntan'];
			$data['judul'] = 'Daftar Klien ';
			$data['akuntan'] = $this->Akuntan_model->getById($id_akuntan);
			$data['klien'] = $this->Klien_model->getAllKlien();
			
			$this->load->view('admin/akuntan/detail', $data);
		}
		
		public function hapus($id_akses) {
			$this->Akses_model->hapusAkses($id_akses);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/akses');
		}
	}
?>