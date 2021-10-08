<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Home extends CI_Controller { 
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Akuntan_model');
		}
		
		public function index() {
			$id_user	= $this->session->userdata('id_user');
			$nama_user	= $this->session->userdata('nama');
			$user		= $this->Akuntan_model->getBy('byId', $id_user);
			if ($user == null) {
				redirect('login');
			}
			else {
				$data['judul'] = 'Selamat Datang';
				$data['nama'] = $nama_user;
				
				$this->libtemplate->main('akuntan/home', $data);
			}
		}
	}

?>