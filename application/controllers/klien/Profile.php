<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Profile extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');

			$this->load->model('Klien_model');
		} 
		 
		public function index() {

			$id_klien = $this->session->userdata('id_user');

			$data['judul'] = "Profile Klien"; 
			$data['klien'] = $this->Klien_model->getById($id_klien); 
			
			$this->libtemplate->main('klien/profile/tampil', $data);
		}
		
		public function ganti_username() {
			
			$id_klien = $this->session->userdata('id_user');
			$data['judul'] = 'Ubah Username'; 
			$data['klien'] = $this->Klien_model->getById($id_klien);
			
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[8]|max_length[15]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/profile/ganti_username', $data);
			} else {
				$cek = $this->session->userdata('password');
				$password = $this->input->post('password', true);
				if($cek == $password) { 
					$this->Klien_model->ubahAkunKlien();
					$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
					redirect('klien/profile'); 
				} else {
					$this->session->set_flashdata('pass', 'Password tidak sesuai!');
					$this->libtemplate->main('klien/profile/ganti_username', $data);
				}
			}
		}
		
		public function ganti_password() {

			$id_klien = $this->session->userdata('id_user');
			$data['judul'] = 'Ganti Password'; 
			$data['klien'] = $this->Klien_model->getById($id_klien);
			
			$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[15]');
			$this->form_validation->set_rules('passconf', 'Password', 'matches[password]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/profile/ganti_password', $data);
			} else {
				$cek = $this->session->userdata('password');
				$password = $this->input->post('passlama', true);
				$passbaru = $this->input->post('password', true);
				if($cek == $password) { 
					$this->session->set_userdata('password', $passbaru);
					$this->Klien_model->ubahAkunKlien();
					$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
					redirect('klien/profile'); 
				} else {
					$this->session->set_flashdata('pass', 'Password tidak sesuai!');
					$this->libtemplate->main('klien/profile/ganti_password', $data);
				}
			}
		}
	}
?>