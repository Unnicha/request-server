<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Profile extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('Klien_model');
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
			$data['input']		= $this->input->post('input', true);
			
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->load->view('klien/profile/verif', $data);
			} else {
				$cek	= $this->Klien_model->getById($this->session->userdata('id_user'));
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($verify == true) {
					redirect('klien/profile/ganti_'.$this->input->post('tipe', true)); 
				} else {
					$this->session->set_flashdata('pass', 'Password salah!');
					$this->session->set_flashdata('passVal', 'Password salah!');
					$this->session->set_flashdata('tipe', $this->input->post('tipe', true));
					$this->session->set_flashdata('input', $this->input->post('input', true));
					redirect('klien/profile');
				}
			}
		}
		
		public function ganti_nama() {
			$data['judul']	= 'Ubah Nama'; 
			$data['klien']	= $this->Klien_model->getById($this->session->userdata('id_user'));
			
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/profile/ganti_nama', $data);
			} else {
				$this->Klien_model->ubahKlien();
				$this->session->set_userdata('nama', $this->input->post('nama', true));
				$this->session->set_flashdata('notification', 'Nama berhasil diubah!'); 
				redirect('klien/profile');
			}
		}
		
		public function ganti_email() {
			$data['judul']	= 'Ubah Email'; 
			$data['klien']	= $this->Klien_model->getById($this->session->userdata('id_user'));
			
			$this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email_user]|valid_email');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/profile/ganti_email', $data);
			} else {
				$this->Klien_model->ubahKlien();
				$this->session->set_flashdata('notification', 'Email berhasil diubah!'); 
				redirect('klien/profile');
			}
		}
		
		public function ganti_username() {
			$data['judul']	= 'Ubah Username'; 
			$data['klien']	= $this->Klien_model->getById($this->session->userdata('id_user'));
			
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[8]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/profile/ganti_username', $data);
			} else {
				$this->Klien_model->ubahKlien();
				$this->session->set_userdata('username', $this->input->post('username', true));
				$this->session->set_flashdata('notification', 'Username berhasil diubah!'); 
				redirect('klien/profile');
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
				$this->Klien_model->ubahKlien();
				$this->session->set_flashdata('notification', 'Password berhasil diubah!');
				redirect('klien/profile');
			}
		}
		
		public function ganti_usaha() {
			$id_klien = $this->session->userdata('id_user');
			$data['judul'] = 'Ubah Info Usaha'; 
			$data['klien'] = $this->Klien_model->getById($id_klien);
			
			$this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'required');
			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required');
			$this->form_validation->set_rules('no_akte', 'No. Akte', 'required');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required');
			$this->form_validation->set_rules('telp', 'Telepon', 'required');
			$this->form_validation->set_rules('no_hp', 'No. HP', 'required');
			$this->form_validation->set_rules('status_pekerjaan', 'Status Pekerjaan', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/profile/ganti_usaha', $data);
			} else {
				$this->Klien_model->ubahKlien();
				$this->session->set_flashdata('notification', 'Info berhasil diubah!');
				redirect('klien/profile');
			}
		}
		
		public function ganti_pimpinan() {
			$id_klien = $this->session->userdata('id_user');
			$data['judul'] = 'Ubah Info Pimpinan'; 
			$data['klien'] = $this->Klien_model->getById($id_klien);
			
			$this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'required');
			$this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
			$this->form_validation->set_rules('no_hp_pimpinan', 'No. HP', 'required');
			$this->form_validation->set_rules('email_pimpinan', 'Email', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/profile/ganti_pimpinan', $data);
			} else {
				$this->Klien_model->ubahKlien();
				$this->session->set_flashdata('notification', 'Info berhasil diubah!');
				redirect('klien/profile');
			}
		}
		
		public function ganti_counter() {
			$id_klien = $this->session->userdata('id_user');
			$data['judul'] = 'Ubah Info Counterpart'; 
			$data['klien'] = $this->Klien_model->getById($id_klien);
			
			$this->form_validation->set_rules('nama_counterpart', 'Nama Counterpart', 'required');
			$this->form_validation->set_rules('no_hp_counterpart', 'No. HP', 'required');
			$this->form_validation->set_rules('email_counterpart', 'Email', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/profile/ganti_counter', $data);
			} else {
				$this->Klien_model->ubahKlien();
				$this->session->set_flashdata('notification', 'Info berhasil diubah!');
				redirect('klien/profile');
			}
		}
	}
?>