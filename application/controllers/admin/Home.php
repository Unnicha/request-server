<<<<<<< HEAD
<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Home extends CI_Controller {
=======
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Home extends CI_Controller {	
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
		
		public function __construct() {
			parent::__construct();
			$this->load->library('sendmail');
<<<<<<< HEAD
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
=======
		}

		public function index() {

			$username	= $this->session->userdata('username');
			$nama_user	= $this->session->userdata('nama');
			$user	= $this->db->get_where('user', ['username'=>$username])->row_array();
			if($user == null) {
				redirect('login');
			} else {
				$data['judul'] = 'Selamat Datang';
				$data['nama'] = $nama_user;
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
				$this->libtemplate->main('admin/home', $data);
				//$this->sendmail->main();
			}
		}
	}
<<<<<<< HEAD
=======

>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
?>