<?php

	use GuzzleHttp\Client;
	
	class Jenis_data extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Jenis_data_model');
			$this->client = new Client([ 'base_uri' => base_url().'api/' ]);
		}
		
		public function index() {

			$data['judul'] = "Daftar Jenis Data"; 
			$data['header'] = "Jenis Data";
			
			$this->libtemplate->main('admin/jenis_data/tampil', $data);
		}
		
		public function cari() {
			
			$cari = $this->input->post('cari');
			if( $cari ) {
				$response = $this->client->get('admin/jenis_data?cari='.$cari);
			} else { 
				$response = $this->client->get('admin/jenis_data');
			}
			$data['jenis_data'] = json_decode($response->getBody()->getContents(), true);
			
			if( $data['jenis_data'] ) {
				$this->load->view('admin/jenis_data/isi', $data);
			} else {
				echo '<tr>
						<td colspan="10">
							Tidak ada data ditemukan.
						</td>
					</tr>';
			}
		}

		public function tambah() {

			$data['judul'] = 'Form Tambah Jenis Data'; 
			$data['kategori']	= $this->Jenis_data_model->kategori_data();
			
			$this->form_validation->set_rules('jenis_data', 'Jenis Data', 'required');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/jenis_data/tambah', $data);
			} else {
				$response = $this->client->post('admin/jenis_data', ['form_params' => [
					'jenis_data'	=> $this->input->post('jenis_data', true),
					'kategori'		=> $this->input->post('kategori', true),
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil ditambahkan'); 
				} else {
					$this->session->set_flashdata('warning', 'Data gagal ditambahkan'); 
				} 
				redirect('admin/jenis_data'); 
			}
		}
		
		public function ubah($kode_jenis) {

			$response = $this->client->get('admin/jenis_data?kode_jenis='.$kode_jenis);
			if ($response->getStatusCode() == 200) {
				$jenis_data = json_decode($response->getBody()->getContents(), true);
			}

			$response = $this->client->get('admin/jenis_data?kode_jenis=kategori');
			if ($response->getStatusCode() == 200) {
				$kategori = json_decode($response->getBody()->getContents(), true);
			}

			$data['judul']		= 'Form Ubah Jenis Data'; 
			$data['jenis_data']	= $jenis_data; 
			$data['kategori']	= $kategori;
			
			$this->form_validation->set_rules('jenis_data', 'Jenis Data', 'required');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/jenis_data/ubah', $data);
			} else {
				$response = $this->client->put('admin/jenis_data', ['form_params' => [
					'kode_jenis'	=> $this->input->post('kode_jenis', true),
					'jenis_data'	=> $this->input->post('jenis_data', true),
					'kategori'		=> $this->input->post('kategori', true),
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil ditambahkan'); 
				} elseif ($response->getStatusCode() == 304) {
					$this->session->set_flashdata('notification', 'Tidak ada perubahan'); 
				} 
				redirect('admin/jenis_data');
			}
		}
		
		public function hapus($kode_jenis) {

			$response = $this->client->delete('admin/jenis_data', ['form_params' => [
				'kode_jenis' => $kode_jenis
				]]);
			
			if ($response->getStatusCode() == 200) {
				$body = json_decode($response->getBody()->getContents(), true);
				$this->session->set_flashdata('notification', 'Data berhasil dihapus');
				redirect('admin/jenis_data');
			}
		}
	}
?>