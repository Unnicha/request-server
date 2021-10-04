<?php

	use GuzzleHttp\Client;

	class Akuntan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->client = new Client([ 'base_uri' => base_url().'api/' ]);
		} 
		 
		public function index() {

			$data['judul'] = "Daftar Akuntan"; 
			$this->libtemplate->main('admin/akuntan/tampil', $data);
		}
		
		public function cari() {
			
			$cari = $this->input->post('cari');
			if( $cari ) {
				$response = $this->client->get('admin/akuntan?cari='.$cari);
			} else { 
				$response = $this->client->get('admin/akuntan');
			}
			$data['akuntan'] = json_decode($response->getBody()->getContents(), true);
			
			if( $data['akuntan'] ) {
				$this->load->view('admin/akuntan/isi', $data);
			} else {
				echo '<tr>
						<td colspan="10">
							Tidak ada data ditemukan.
						</td>
					</tr>';
			} 
		}

		public function tambah() {
			$data['judul'] = 'Form Tambah Akuntan'; 
			$data['level'] = "akuntan";

			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[8]|max_length[15]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');
			$this->form_validation->set_rules('nama', 'Nama Akuntan', 'required');
			$this->form_validation->set_rules('email', 'Email Akuntan', 'required|valid_email');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akuntan/tambah', $data);
			} else {
				$response = $this->client->post('admin/akuntan', ['form_params' => [
					'level'		=> $this->input->post('level', true),
					'nama'		=> $this->input->post('nama', true),
					'username'	=> $this->input->post('username', true),
					'password'	=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
					'email_user'=> $this->input->post('email', true)
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				} else {
					$this->session->set_flashdata('warning', 'Data gagal ditambahkan!'); 
				} 
				redirect('admin/akuntan');
			}
		}
		
		public function ubah($id_akuntan) {

			$response = $this->client->get('admin/akuntan?id_akuntan='.$id_akuntan);
			if ($response->getStatusCode() == 200) {
				$body = json_decode($response->getBody()->getContents(), true);
			}

			$data['judul'] = 'Ubah Data Akuntan'; 
			$data['akuntan'] = $body;

			$this->form_validation->set_rules('username', 'Username', 'required|min_length[8]|max_length[15]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');
			$this->form_validation->set_rules('nama', 'Nama Akuntan', 'required');
			$this->form_validation->set_rules('email', 'Email Akuntan', 'required|valid_email');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akuntan/ubah', $data);
			} else {
				$response = $this->client->put('admin/akuntan', ['form_params' => [
					'id_user'	=> $this->input->post('id_user', true),
					'level'		=> $this->input->post('level', true),
					'nama'		=> $this->input->post('nama', true),
					'username'	=> $this->input->post('username', true),
					'password'	=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
					'email_user'=> $this->input->post('email', true)
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
					redirect('admin/akuntan');
				} else {
					$this->session->set_flashdata('warning', 'Data gagal diubah!'); 
					redirect('admin/akuntan');
				} 
			}
		}
		
		public function hapus($id_akuntan) {

			$response = $this->client->delete('admin/akuntan', ['form_params' => [
				"id_user" => $id_akuntan
				]]);
			
			if ($response->getStatusCode() == 200) {
				$body = json_decode($response->getBody()->getContents(), true);
				$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
				redirect('admin/akuntan');
			}
		}
	}
?>