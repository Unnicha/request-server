<<<<<<< HEAD
<?php defined('BASEPATH') OR exit('No direct script access allowed');
=======
<?php
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5

	class Home extends CI_Controller { 
		
		public function __construct() {
			parent::__construct();
<<<<<<< HEAD
			$this->load->model('Akuntan_model');
		}
		
		public function index() {
			$id_user	= $this->session->userdata('id_user');
			$nama_user	= $this->session->userdata('nama');
			$user		= $this->Akuntan_model->getBy('byId', $id_user);
=======
		}
		
		public function index() {
			$username	= $this->session->userdata('username');
			$nama_user	= $this->session->userdata('nama');
			$user		= $this->db->get_where('user', ['username'=>$username])->row_array();
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
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