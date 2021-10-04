<?php

	use GuzzleHttp\Client;
	
	class Otoritas extends CI_Controller {

		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('paging');

			$this->load->model('Otoritas_model');
			//$this->client = new Client([ 'base_uri' => 'data.hrwconsulting.id/api/' ]);
			$this->client = new Client([ 'base_uri' => base_url().'api/' ]);
		} 
		
		public function index($offset="") {
			
			$level = 'admin';
			$limit = 10;
			if($offset == null) $offset=0;
			$get = [
				'level'		=> $level,
				'limit'		=> $limit,
				'offset'	=> $offset,
			];
			$response = $this->client->get('admin/otoritas');
			
			if ($response->getStatusCode() == 200) {
				$body = json_decode($response->getBody()->getContents(), true);
				//$this->Otoritas_model->ubahOtoritas($body);
				
				$data['judul']	= 'Daftar Admin';
				$data['user']	= $body;
				$this->libtemplate->main('admin/otoritas/tampil', $data);
			}
			
			/* Pagination
			$countData	= count($user);
			$base_url	= base_url('admin/otoritas');
			$this->paging->main($base_url, $countData, $limit);
			$user = $this->Otoritas_model->getPagination($get);
			*/
		}

		public function tambah() {
			$data['judul'] = 'Form Tambah Admin';
			$data['level'] = "admin";
			
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email_user]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/otoritas/tambah', $data);
			} else {
				$response = $this->client->post('admin/otoritas', [
					'form_params' => [
						"level"		=> $this->input->post('level', true),
						"username"	=> $this->input->post('username', true),
						"password"	=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
						"nama"		=> $this->input->post('nama', true),
						"email"		=> $this->input->post('email', true),
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!');
					redirect('admin/otoritas');
				} 
			}
		}

		public function ubah($id_user) {
			$response = $this->client->get('admin/otoritas?id_user='.$id_user);
			
			if ($response->getStatusCode() == 200) {
				$body = json_decode($response->getBody()->getContents(), true);
			}

			$data['judul']	= 'Ubah Data Admin';
			$data['user']	= $body;
			
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/otoritas/ubah', $data);
			} else {
				$response = $this->client->put('admin/otoritas', [
					'form_params' => [
						"id_user"	=> $this->input->post('id_user', true),
						"level"		=> $this->input->post('level', true),
						"username"	=> $this->input->post('username', true),
						"password"	=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
						"nama"		=> $this->input->post('nama', true),
						"email"		=> $this->input->post('email', true),
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil diubah!');
					redirect('admin/otoritas');
				} else {
					echo $response->getStatusCode();
				}
			}
		} 
		
		public function hapus($id_user) {
			if($id_user == $this->session->userdata('id_user')) {
				$this->session->set_flashdata('warning', 'User sedang aktif!'); 
				redirect('admin/otoritas');
			} else {
				$response = $this->client->delete('admin/otoritas', [
					'form_params' => [ 'id_user' => $id_user ]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
					redirect('admin/otoritas');
				} 
			}
		}
	}
?>