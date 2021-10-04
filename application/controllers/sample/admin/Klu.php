<?php

	use GuzzleHttp\Client;

	class Klu extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->client = new Client([ 'base_uri' => base_url().'api/' ]);
		} 
		 
		public function index() {

			$data['judul']	= "Klasifikasi Lapangan Usaha"; 
			$this->libtemplate->main('admin/klu/tampil', $data);
		}
		
		public function cari() {
			
			$cari = $this->input->post('cari');
			if( $cari ) {
				$response = $this->client->get('admin/klu?cari='.$cari);
			} else { 
				$response = $this->client->get('admin/klu');
			}
			$data['klu'] = json_decode($response->getBody()->getContents(), true);
			
			if( $data['klu'] ) {
				$this->load->view('admin/klu/isi', $data);
			} else {
				echo '<tr>
						<td colspan="10">
							Tidak ada data ditemukan.
						</td>
					</tr>';
			} 
		}

		public function tambah() {
			
			$data['judul'] = 'Form Tambah KLU'; 

			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required|is_unique[klu.kode_klu]');
			$this->form_validation->set_rules('bentuk_usaha', 'Bentuk Usaha', 'required');
			$this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klu/tambah', $data);
			} else {
				$response = $this->client->post('admin/klu', [
					'form_params' => [
						'kode_klu'		=> $this->input->post('kode_klu', true),
						'bentuk_usaha'	=> $this->input->post('bentuk_usaha', true),
						'jenis_usaha'	=> $this->input->post('jenis_usaha', true)
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil ditambahkan'); 
					redirect('admin/klu');
				} else {
					echo $response->getStatusCode();
				}
			}
		}
		
		public function ubah($kode_klu) {
			
			$response = $this->client->get('admin/klu?kode_klu='.$kode_klu);
			if ($response->getStatusCode() == 200) {
				$body = json_decode($response->getBody()->getContents(), true);
			}
			
			$data['judul']	= 'Form Ubah KLU'; 
			$data['klu']	= $body;
			
			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required|numeric');
			$this->form_validation->set_rules('bentuk_usaha', 'Bentuk Usaha', 'required');
			$this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klu/ubah', $data);
			} else {
				$response = $this->client->put('admin/klu', [
					'form_params' => [
						'kode_klu'		=> $this->input->post('kode_klu', true),
						'bentuk_usaha'	=> $this->input->post('bentuk_usaha', true),
						'jenis_usaha'	=> $this->input->post('jenis_usaha', true),
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil diubah'); 
				} else {
					$this->session->set_flashdata('notification', 'Tidak ada perubahan'); 
				}
				redirect('admin/klu');
			}
		}

		public function detail($kode_klu) {
			$response = $this->client->get('admin/klu', ['form_params' => [ 'kode_klu' => $kode_klu ]]);
			
			if ($response->getStatusCode() == 200) {
				$body = json_decode($response->getBody()->getContents(), true);
			}
			
			$data['judul']	= 'Detail KLU';
			$data['klu']	= $body;
			
			$this->libtemplate->main('admin/klu/detail', $data);
		}
		
		public function hapus($kode_klu) {
			$response = $this->client->delete('admin/klu', ['form_params' => [ 'kode_klu' => $kode_klu ]]);
			
			if ($response->getStatusCode() == 200) {
				$body = json_decode($response->getBody()->getContents(), true);
				$this->session->set_flashdata('notification', 'Data berhasil dihapus');
				redirect('admin/klu');
			}
		}
	}
?>