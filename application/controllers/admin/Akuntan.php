<?php
	
	class Akuntan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Akuntan_model');
		} 
		 
		public function index() {

			$data['judul'] = "Daftar Akuntan";
			$this->libtemplate->main('admin/akuntan/tampil', $data);
		}
		
		public function page() {
			$cari	= $_POST['search']['value'];
			$limit	= $_POST['length'];
			$offset = $_POST['start'];
			
			$countData	= $this->Akuntan_model->countAkuntan($cari); 
			$akuntan	= $this->Akuntan_model->getAllAkuntan($offset, $limit, $cari);
			$data		= [];
			foreach($akuntan as $k) {
				//$no = $offset;
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama'];
				$row[]	= $k['username'];
				$row[]	= $k['email_user'];
				$row[]	= '<a class="btn btn-sm btn-info" href="akuntan/ubah/'.$k['id_user'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah"><i class="bi bi-pencil-square"></i></a> <a class="btn btn-sm btn-danger" href="akuntan/hapus/'.$k['id_user'].'" onclick="return confirm("Yakin ingin menghapus data '.$k['nama'].'?");" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="bi bi-trash"></i></a>';

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
			$data['judul'] = 'Form Tambah Akuntan'; 
			$data['level'] = "akuntan";

			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email_user]');
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[8]|max_length[15]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akuntan/tambah', $data);
			} else {
				$this->Akuntan_model->tambahAkuntan();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/akuntan');  
			}
		}
		
		public function ubah($id_akuntan) {
			$data['judul'] = 'Ubah Data Akuntan'; 
			$data['akuntan'] = $this->Akuntan_model->getById($id_akuntan); 
			
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[8]|max_length[15]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akuntan/ubah', $data);
			} else {
				$this->Akuntan_model->ubahAkuntan();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('admin/akuntan'); 
			}
		}
		
		public function hapus($id_akuntan) {
			$this->Akuntan_model->hapusAkuntan($id_akuntan);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/akuntan');
		}
	}
?>