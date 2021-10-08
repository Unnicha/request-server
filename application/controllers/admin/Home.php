<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Home extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('sendmail');
			$this->load->model('Admin_model');
		}
		
		public function index() {
			$username	= $this->session->userdata('username');
			$nama		= $this->session->userdata('nama');
			$user		= $this->Admin_model->getByUsername($username);
			
			if($user == null) {
				redirect('login');
			} else {
				$data['judul']	= 'Selamat Datang';
				$data['nama']	= $nama;
				$this->libtemplate->main('admin/home', $data);
				//$this->sendmail->main();
			}
		}
	}
?>