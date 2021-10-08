<?php
	
	class Profile extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('Admin_model');
		}
		
		public function index() {
			$admin		= $this->Admin_model->getById($this->session->userdata('id_user'));
			$passcode	= '';
			for($i=0; $i<$admin['passlength']; $i++) {
				$passcode .= '&bull;';
			}
			$admin['passcode'] = $passcode;
			
			$data['judul']	= "Profile Admin";
			$data['admin']	= $admin;
			
			$this->libtemplate->main('admin/profile/tampil', $data);
		}
		
		// verifikasi admin sebelum melakukan perubahan data
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
				$cek	= $this->Admin_model->getById($this->session->userdata('id_user'));
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
			$data['admin']	= $this->Admin_model->getById($id_user);
			$data['judul']	= 'Ubah '.ucwords($type);
			$data['back']	= 'admin/profile';
			
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
				$this->libtemplate->main('admin/profile/ganti_'.$tipe, $data);
			} else {
				$do_update	= false;
				$tipe		= $this->input->post('tipe', true);
				$nama		= $this->input->post('nama', true);
				$email		= $this->input->post('email', true);
				$username	= $this->input->post('username', true);
				
				if($tipe == 'email' || $tipe == 'username') {
					$key_word	= ($tipe == 'email') ? $email : $username;
					$do_update	= $this->cekUnique($tipe, $key_word);
				} else {
					$do_update = true;
				}
				
				if($do_update == true) {
					$this->Admin_model->ubahAdmin();
					// update session user
					if($tipe == 'nama') {
						$this->session->set_userdata('nama', $nama);
					} elseif($tipe == 'username') {
						$this->session->set_userdata('username', $username);
					}
					$this->session->set_flashdata('notification', ucwords($tipe).' berhasil diubah!');
					redirect('admin/profile');
				} else {
					$this->session->set_flashdata('used', $tipe.' sudah digunakan');
					$this->libtemplate->main('admin/profile/ganti_'.$tipe, $data);
				}
			}
		}
		
		public function cekUnique($type, $key) {
			if( $type == 'username' )
			$result	= $this->Admin_model->getByUsername($key);
			elseif( $type == 'email' )
			$result	= $this->Admin_model->getByEmail($key);
			
			return ($result) ? false : true;
		}
	}
?>