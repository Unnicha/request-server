<?php
	
	class Profile extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('Akuntan_model');
		}
		
		public function index() {
			$akuntan	= $this->Akuntan_model->getById($this->session->userdata('id_user'));
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
			
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->load->view('akuntan/profile/verif', $data);
			} else {
				$cek	= $this->Akuntan_model->getById($this->session->userdata('id_user'));
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($verify == true) {
					redirect('akuntan/profile/ganti_'.$this->input->post('tipe', true)); 
				} else {
					$this->session->set_flashdata('pass', 'Password salah!');
					$this->session->set_flashdata('passVal', 'Password salah!');
					$this->session->set_flashdata('tipe', $this->input->post('tipe', true));
					redirect('akuntan/profile');
				}
			}
		}
		
		public function ubah($id_user) {
			$type				= $this->session->userdata('tipe');
			$data['akuntan']	= $this->Akuntan_model->getById($id_user);
			$data['judul']		= 'Akuntan '.$data['akuntan']['nama'].' - Ubah '.ucwords($type);
			
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
				$this->libtemplate->main('akuntan/profile/ganti_'.$tipe, $data);
			} else {
				$tipe = $this->session->userdata('tipe');
				$this->Akuntan_model->ubahAkuntan();
				$this->session->set_flashdata('notification', ucwords($tipe).' berhasil diubah!');
				redirect('admin/master/akuntan/view/'.$_POST['id_user']);
			}
		}
	}
?>