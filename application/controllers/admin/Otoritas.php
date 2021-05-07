<?php

	class Otoritas extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');

			$this->load->model('Otoritas_model');
		} 
		
		public function index() {

			$data['judul'] = "Daftar Admin";
			$this->libtemplate->main('admin/otoritas/tampil', $data);
		}
		
		public function page() {
			$cari	= $_POST['search']['value'];
			$limit	= $_POST['length'];
			$offset = $_POST['start'];
			
			$countData	= $this->Otoritas_model->countOtoritas($cari); 
			$otoritas	= $this->Otoritas_model->getAllOtoritas($offset, $limit, $cari);
			$data		= [];
			foreach($otoritas as $k) {
				//$no = $offset;
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama'];
				$row[]	= $k['username'];
				$row[]	= $k['email_user'];
				$row[]	= '<a class="btn btn-sm btn-info" href="otoritas/ubah/'.$k['id_user'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah"><i class="bi bi-pencil-square"></i></a> <a class="btn btn-sm btn-danger" href="otoritas/hapus/'.$k['id_user'].'" onclick="return confirm("Yakin ingin menghapus Admin '.$k['nama'].'?");" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="bi bi-trash"></i></a>';

				$data[] = $row;
			}
			$callback	= [
				'draw'			=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'	=> $countData,
				'recordsFiltered'=>$countData,
				'data'			=> $data,
			];
			echo json_encode($callback);
		}

		public function tambah() {
			$data['judul'] = 'Form Tambah Admin';
			$data['level'] = 'admin';
			
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email_user]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/otoritas/tambah', $data);
			} else {
				$this->Otoritas_model->tambahOtoritas();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!');
				redirect('admin/otoritas');
			}
		}

		public function ubah($id_user) {
			$data['judul']	= 'Ubah Data Admin';
			$data['user']	= $this->Otoritas_model->getById($id_user);

			$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/otoritas/ubah', $data);
			} else {
				$this->Otoritas_model->ubahOtoritas();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!');
				redirect('admin/otoritas');
			}
		}
		
		public function detail() {
			$id_user		= $this->input->post('id_user', true);
			$data['judul']	= "Detail Admin";
			$data['user']	= $this->Otoritas_model->getById($id_user);
			
			$this->load->view('admin/otoritas/detail', $data);
		}
		
		public function hapus($id_user) {
			$this->Otoritas_model->hapusOtoritas($id_user);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/otoritas');
		}
	}
?>