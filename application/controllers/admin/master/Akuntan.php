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
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['id_user'];
				$row[]	= $k['nama'];
				$row[]	= $k['username'];
				$row[]	= $k['email_user'];
				$row[]	= '
				<a class="btn-ubah" data-id="'.$k['id_user'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah Password">
					<i class="bi bi-key-fill icon-medium"></i>
				</a>
				<a class="btn-hapus" data-id="'.$k['id_user'].'" data-nama="'.$k['nama'].'" data-toggle="tooltip" data-placement="bottom" title="Hapus">
					<i class="bi bi-trash icon-medium"></i>
				</a>';

				$data[] = $row;
			}
			$callback	= [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=> $countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}

		public function tambah() {
			$data['judul'] = 'Tambah Akuntan'; 
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
				redirect('admin/master/akuntan');  
			}
		}
		
		public function verif() {
			$data['judul']		= 'Verifikasi';
			$data['subjudul']	= 'Beritahu kami bahwa ini benar Anda';
			$data['id_user']	= $this->input->post('id', true);
			
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->load->view('admin/akuntan/verif', $data);
			} else {
				$cek	= $this->Akuntan_model->getById($this->session->userdata('id_user'));
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($verify == true) {
					redirect('admin/master/akuntan/ubah/'.$_POST['id_user']);
				} else {
					$this->session->set_flashdata('pass', $this->input->post('id', true));
					redirect('admin/master/akuntan');
				}
			}
		}
		
		public function ubah($id_user) {
			$data['akuntan']	= $this->Akuntan_model->getById($id_user);
			$data['judul']		= 'Ubah Password';
			
			$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[15]');
			$this->form_validation->set_rules('passconf', 'Password', 'matches[password]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akuntan/ganti_password', $data);
			} else {
				$this->Akuntan_model->ubahAkuntan();
				$this->session->set_flashdata('notification', 'Password berhasil diubah!');
				redirect('admin/master/akuntan');
			}
		}
		
		public function hapus() {
			$id				= $_REQUEST['id'];
			$data['judul']	= 'Hapus Akuntan';
			$data['text']	= 'Yakin ingin menghapus <b>akuntan '.$_REQUEST['nama'].' ?</b>';
			$data['button']	= '
				<a href="akuntan/fix_hapus/'.$id.'" class="btn btn-danger">Hapus</a>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal" tabindex="1">Batal</button>
			';
			
			$this->load->view('admin/template/confirm', $data);
		}
		
		public function fix_hapus($id) {
			$this->Akuntan_model->hapusAkuntan($id);
			$this->session->set_flashdata('notification', 'Data akuntan berhasil dihapus!');
			redirect('admin/master/akuntan'); 
		}
	}
?>