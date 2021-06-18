<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Home extends CI_Controller {	
		
		public function __construct() {
			parent::__construct();
			$this->load->library('sendmail');
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
				$this->libtemplate->main('admin/home', $data);
				//$this->sendmail->main();
			}
		}
	}

?>