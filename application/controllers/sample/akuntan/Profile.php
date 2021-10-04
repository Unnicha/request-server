<?php
	
	class Profile extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Akuntan_model');
		} 
		 
		public function index() {
			$id_akuntan = $this->session->userdata('id_user');

			$data['judul'] = "Profile Akuntan"; 
			$data['akuntan'] = $this->Akuntan_model->getById($id_akuntan); 

			$this->libtemplate->main('akuntan/profile/tampil', $data);
		}
		
		public function ganti_username() {
			
			$id_akuntan = $this->session->userdata('id_user');
			$data['judul'] = 'Ubah Username'; 
			$data['akuntan'] = $this->Akuntan_model->getById($id_akuntan);
			
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[8]|max_length[15]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/profile/ganti_username', $data);
			} else {
				$cek = $this->session->userdata('password');
				$password = $this->input->post('password');
				if($cek == $password) { 
					$this->Akuntan_model->ubahAkuntan();
					$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
					redirect('akuntan/profile'); 
				} else {
					$this->session->set_flashdata('pass', 'Password tidak sesuai!');
					$this->libtemplate->main('akuntan/profile/ganti_username', $data);
				}
			}
		}
		
		public function ganti_password() {

			$id_akuntan = $this->session->userdata('id_user');
			$data['judul'] = 'Ganti Password'; 
			$data['akuntan'] = $this->Akuntan_model->getById($id_akuntan);
			
			$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[15]');
			$this->form_validation->set_rules('passconf', 'Password', 'matches[password]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/profile/ganti_password', $data);
			} else {
				$cek = $this->session->userdata('password');
				$password = $this->input->post('passlama');
				$passbaru = $this->input->post('password');
				if($cek == $password) { 
					$this->session->set_userdata('password', $passbaru);
					$this->Akuntan_model->ubahAkuntan();
					$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
					redirect('akuntan/profile'); 
				} else {
					$this->session->set_flashdata('pass', 'Password tidak sesuai!');
					$this->libtemplate->main('akuntan/profile/ganti_password', $data);
				}
			}
		}
	}
?>