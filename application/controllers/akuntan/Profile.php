<?php
	
	class Profile extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('Akuntan_model');
			$this->load->model('Admin_model');
		}
		
		public function index() {
			$akuntan	= $this->Akuntan_model->getBy('byId', $this->session->userdata('id_user'));
			$passcode	= '';
			for($i=0; $i<$akuntan['passlength']; $i++) {
				$passcode .= '&bull;';
			}
			$akuntan['passcode'] = $passcode;
			
			$data['judul']		= "Profile Akuntan";
			$data['akuntan']	= $akuntan;
			
			$this->libtemplate->main('akuntan/profile/tampil', $data);
		}
		
		public function verification() {
			$data['judul']		= 'Verifikasi';
			$data['subjudul']	= 'Beritahu kami bahwa ini benar Anda';
			$data['tipe']		= $this->input->post('type', true);
			$data['id_user']	= $this->input->post('id', true);
			$this->session->set_userdata('tipe', $data['tipe']);
			
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->load->view('akuntan/profile/verif', $data);
			} else {
				$cek	= $this->Akuntan_model->getBy('byId', $this->session->userdata('id_user'));
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($verify == true) {
					redirect('akuntan/profile/ubah/'.$_POST['id_user']);
				} else {
					$this->session->set_flashdata('pass', 'Password salah!');
					redirect('akuntan/profile');
				}
			}
		}
		
		public function ubah($id_user) {
			$type				= $this->session->userdata('tipe');
			$data['akuntan']	= $this->Akuntan_model->getBy('byId', $id_user);
			$data['judul']		= 'Ubah '.ucwords($type);
			
			if($type == 'nama') {
				$this->form_validation->set_rules('nama', 'Nama', 'required');
			} elseif($type == 'email') {
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			} elseif($type == 'username') {
				$this->form_validation->set_rules('username', 'Username', 'required|min_length[8]');
			} elseif($type == 'password') {
				$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[15]');
				$this->form_validation->set_rules('passconf', 'Password', 'matches[password]');
			}
			
			if($this->form_validation->run() == FALSE) {
				$tipe = $this->session->userdata('tipe');
				$this->libtemplate->main('akuntan/profile/ganti_'.$tipe, $data);
			} else {
				$tipe = $this->session->userdata('tipe');
				$email		= $this->input->post('email');
				$username	= $this->input->post('username');
				
				if($tipe == 'email' || $tipe == 'username') {
					$key = ($tipe == 'email') ? $email : $username;
					
					if ($tipe == 'username')
					$result	= $this->Admin_model->getByUsername($key);
					elseif ($tipe == 'email')
					$result	= $this->Admin_model->getByEmail($key);
					
					$do_update = ($result) ? false : true;
				} else {
					$do_update = true;
				}
				
				if ($do_update == true) {
					$this->Akuntan_model->ubahAkuntan();
					// update session user
					if($tipe == 'nama') {
						$this->session->set_userdata('nama', $this->input->post('nama', true));
					} elseif($tipe == 'username') {
						$this->session->set_userdata('username', $this->input->post('username', true));
					}
					$this->session->set_flashdata('notification', ucwords($tipe).' berhasil diubah!');
					redirect('akuntan/profile');
				} else {
					$this->session->set_flashdata('used', $tipe.' sudah digunakan');
					$this->libtemplate->main('akuntan/profile/ganti_'.$tipe, $data);
				}
			}
		}
	}
?>