<?php
	
	class Login extends CI_Controller {
	
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('sendmail');
			$this->load->model('Admin_model');
		} 
	
		public function index() {
			if ($this->input->post() == NULL) {
				$this->load->view('login');
			} 
			else {
				$cek	= $this->Admin_model->getByUsername($this->input->post('username', true));
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($cek == null || $verify == false) {
					$this->session->set_flashdata('flash', 'tidak sesuai');
					redirect('login');
				} else {
					$sess = [
						'id_user' => $cek['id_user'],
						'username' => $this->input->post('username', true),
						'nama' => $cek['nama'],
						'level' => $cek['level'],
					];
					$this->session->set_userdata($sess);
					// update hashing password
					$this->Admin_model->ubahPassword($this->input->post('password', true), $cek['id_user']);
					
					switch ($cek['level']) { // redirect ke home berdasarkan level user
						case "admin"	: redirect('admin/home'); break;
						case "akuntan"	: redirect('akuntan/home'); break;
						case "klien"	: redirect('klien/home'); break;
					}
				}
			}
		}
	
		public function forget_password() {
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			
			if($this->form_validation->run() == FALSE) {
				$this->load->view('reset_password/forget_pass');
			} else {
				$cek = $this->Admin_model->getByEmail($this->input->post('email', true));
				if($cek == null) {
					$this->session->set_flashdata('flash', 'terkait');
					redirect('login/forget_password');
				} else {
					//$this->sendmail->confirm($this->input->post('email']), true);
					//$this->send_email($cek);
					//$token = $this->m_account->insertToken($userInfo->id_user);
					$token  = $this->Admin_model->insertToken($cek['id_user']);
					$code   = $this->base64url_encode($token);
					$url    = base_url().'login/reset_password/token/'.$code;
					$link   = '<a href="' . $url . '">' . $url . '</a>'; 
					$send   = $this->sendmail->resetPassword($cek, $link);
					if($send == true) { 
						$this->load->view('reset_password/email_sent');
					} else { 
						echo $send; 
					}
				}
			}
		}
	
		public function reset_password() {
			$token		= $this->base64url_decode($this->uri->segment(4));
			$cleanToken	= $this->security->xss_clean($token);
			$user_info	= $this->Admin_model->validToken($cleanToken); 
	
			if (!$user_info) {
				$this->session->set_flashdata('sukses', 'Token tidak valid atau kadaluarsa');
				//redirect('login');
			} else {
				//redirect();
				$this->form_validation->set_rules('password', 'Password', 'required');
				$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');
				
				if($this->form_validation->run() == FALSE) {
					$this->load->view('reset_password/reset_password', $user_info);
				} else {
					$this->Admin_model->ubahPassword($this->input->post('password', true), $user_info['id_user']);
					$this->load->view('reset_password/reset_success');
				}
			}
		}
	
		public function base64url_encode($data) {
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
		}
	
		public function base64url_decode($data) {
			return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
		}
		
		public function logout() {
			session_destroy();
			redirect('login');
		}
	}
?>