<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Profile extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('Klien_model');
			$this->load->model('Admin_model');
		}
		
		public function index() {
			$klien		= $this->Klien_model->getById($this->session->userdata('id_user'));
			$passcode	= '';
			for($i=0; $i<$klien['passlength']; $i++) {
				$passcode .= '&bull;';
			}
			$klien['passcode'] = $passcode;
			
			$data['judul']	= "Profile Klien";
			$data['klien']	= $klien;
			
			$this->libtemplate->main('klien/profile/tampil', $data);
		}
		
		public function verification() {
			$data['judul']		= 'Verifikasi';
			$data['subjudul']	= 'Beritahu kami bahwa ini benar Anda';
			$data['tipe']		= $this->input->post('type', true);
			$data['id_user']	= $this->input->post('id', true);
			$this->session->set_userdata('tipe', $data['tipe']);
			
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->load->view('klien/profile/verif', $data);
			} else {
				$cek	= $this->Klien_model->getById($this->session->userdata('id_user'));
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($verify == true) {
					redirect('klien/profile/ubah/'.$_POST['id_user']);
				} else {
					$this->session->set_flashdata('pass', 'Password salah!');
					redirect('klien/profile');
				}
			}
		}
		
		public function ubah($id_user) {
			$type			= $this->session->userdata('tipe');
			$data['klien']	= $this->Klien_model->getById($id_user);
			$data['judul']	= 'Ubah '.ucwords($type);
			$data['tipe']	= $type;
			$data['table']	= 'user';
			$data['back']	= 'klien/profile';
			
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
				$this->libtemplate->main('klien/profile/ganti_'.$tipe, $data);
			} else {
				$tipe		= $this->session->userdata('tipe');
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
					$this->Klien_model->ubahAkun();
					// update session user
					if($tipe == 'nama') {
						$this->session->set_userdata('nama', $this->input->post('nama', true));
					} elseif($tipe == 'username') {
						$this->session->set_userdata('username', $this->input->post('username', true));
					}
					$this->session->set_flashdata('notification', ucwords($tipe).' berhasil diubah!');
					redirect('klien/profile');
				} else {
					$this->session->set_flashdata('used', $tipe.' sudah digunakan');
					$this->libtemplate->main('klien/profile/ganti_'.$tipe, $data);
				}
			}
		}
	}
?>