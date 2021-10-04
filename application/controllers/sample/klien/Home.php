<?php

	class Home extends CI_Controller {   
		
		public function __construct() {
			parent::__construct();
					}

		public function index() {

			$username = $this->session->userdata('username');
			$password = $this->session->userdata('password');
			$nama_user = $this->session->userdata('nama');
			
			$user = $this->cekLogin($username, $password);
			if ($user == null) {
				redirect('login');
			}
			else {
				$data['judul'] = 'Selamat Datang';
				$data['nama'] = $nama_user;
				
				$this->libtemplate->main('klien/home', $data);
			}
		}

		public function cekLogin($username, $password) {
			
			$this->db->where('username', $username);
			$this->db->where('password', $password);
			$cek = $this->db->get('user')->row_array();

			return $cek;
		}
	}

?>