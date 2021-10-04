<?php

	use GuzzleHttp\Client;

	class Login extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('sendmail');
			$this->client = new Client([ 'base_uri' => base_url().'api/' ]);
			$this->load->model('Otoritas_model');
		} 
		
		public function index() {
			
			if ($this->input->post() == NULL) {
				$this->load->view('login');
			} else {
				$password = $this->input->post('password');
				$username = $this->input->post('username');

				$response = $this->client->get('login?username='.$username);
				if ($response->getStatusCode() == 200) {
					$cek = json_decode($response->getBody()->getContents(), true);
				} 
				$verify = password_verify($password, $cek['password']);
	
				if($cek == null || $verify == false) {
					$this->session->set_flashdata('flash', 'tidak sesuai');
					redirect('login');
				} else {
					$sess = [
						'id_user'	=> $cek['id_user'],
						'username'	=> $cek['username'],
						'nama'		=> $cek['nama'],
						'level'		=> $cek['level'],
					];
					$this->session->set_userdata($sess); // set ke session

					// update hashing password
					$response = $this->client->put('login', ['form_params' => [
						'id_user'	=> $cek['id_user'],
						'password'	=> password_hash($password, PASSWORD_DEFAULT),
					]]);
					
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
				$response = $this->client->get('login?email='.$this->input->post('email'));
				if ($response->getStatusCode() == 200) {
					$cek = json_decode($response->getBody()->getContents(), true);
				} 
				
				if($cek == null) {
					$this->session->set_flashdata('flash', 'terkait');
					redirect('login/forget_password');
				} else {
					$response = $this->client->post('login?id_user='.$cek['id_user']);
					$token	= json_decode($response->getBody()->getContents(), true);
					//$token	= $this->Otoritas_model->insertToken($cek['id_user']);
					$code	= $this->base64url_encode($token);
					$url	= base_url().'login/reset_password/token/'.$code;
					$link	= '<a href="' . $url . '">' . $url . '</a>'; 
					$send	= $this->sendmail->resetPassword($cek, $link);
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
			//$user_info	= $this->Otoritas_model->validToken($cleanToken); 
			
			$response = $this->client->get('login?token='.$cleanToken);
			if ($response->getStatusCode() == 200) {
				$user_info = json_decode($response->getBody()->getContents(), true);
			} 

			if (!$user_info) {
				$this->session->set_flashdata('sukses', 'Token tidak valid atau kadaluarsa');
				//redirect('login');
			} else {
				$this->form_validation->set_rules('password', 'Password', 'required');
				$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');
				
				if($this->form_validation->run() == FALSE) {
					$this->load->view('reset_password/reset_password', $user_info);
				} else {
					$response = $this->client->put('login', ['form_params' => [
						'password'	=> password_hash($this->input->post('password'), PASSWORD_DEFAULT),
						'id_user'	=> $user_info['id_user'],
					]]);
					//$this->Otoritas_model->ubahPassword($this->input->post('password'), $user_info['id_user']);
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