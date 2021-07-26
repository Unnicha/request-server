<?php
	
	class Profile extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('Otoritas_model');
		}
		
		public function index() {
			$admin		= $this->Otoritas_model->getById($this->session->userdata('id_user'));
			$passcode	= '';
			for($i=0; $i<$admin['passlength']; $i++) {
				$passcode .= '&bull;';
			}
			$admin['passcode'] = $passcode;
			
			$data['judul']	= "Profile Admin";
			$data['admin']	= $admin;
			
			$this->libtemplate->main('admin/profile/tampil', $data);
		}
		
		public function verification() {
			$data['judul']		= 'Verifikasi';
			$data['subjudul']	= 'Beritahu kami bahwa ini benar Anda';
			$data['tipe']		= $this->input->post('type', true);
			$data['id_user']	= $this->input->post('id', true);
			$this->session->set_userdata('tipe', $data['tipe']);
			
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->load->view('admin/profile/verif', $data);
			} else {
				$cek	= $this->Otoritas_model->getById($this->session->userdata('id_user'));
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($verify == true) {
					redirect('admin/profile/ubah/'.$_POST['id_user']);
				} else {
					$this->session->set_flashdata('pass', 'Password salah!');
					redirect('admin/profile');
				}
			}
		}
		
		public function ubah($id_user) {
			$type			= $this->session->userdata('tipe');
			$data['admin']	= $this->Otoritas_model->getById($id_user);
			$data['judul']	= 'Ubah '.ucwords($type);
			
			if($type == 'nama') {
				$this->form_validation->set_rules('nama', 'Nama', 'required');
			} elseif($type == 'email') {
				$this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email_user]|valid_email');
			} elseif($type == 'username') {
				$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[8]');
			} elseif($type == 'password') {
				$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[15]');
				$this->form_validation->set_rules('passconf', 'Password', 'matches[password]');
			}
			
			if($this->form_validation->run() == FALSE) {
				$tipe = $this->session->userdata('tipe');
				$this->libtemplate->main('admin/profile/ganti_'.$tipe, $data);
			} else {
				$this->Otoritas_model->ubahOtoritas();
				$tipe = $this->session->userdata('tipe');
				if($tipe == 'nama') {
					$this->session->set_userdata('nama', $this->input->post('nama', true));
				} elseif($tipe == 'username') {
					$this->session->set_userdata('username', $this->input->post('username', true));
				}
				$this->session->set_flashdata('notification', ucwords($tipe).' berhasil diubah!');
				redirect('admin/profile');
			}
		}
	}
?>