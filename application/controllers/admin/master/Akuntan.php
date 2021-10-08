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
<<<<<<< HEAD
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$cari		= $_POST['search']['value'];
			$countData	= $this->Akuntan_model->countAkuntan($cari); 
			$akuntan	= $this->Akuntan_model->getAllAkuntan($offset, $limit, $cari);
			
=======
			$cari	= $_POST['search']['value'];
			$limit	= $_POST['length'];
			$offset = $_POST['start'];
			
			$countData	= $this->Akuntan_model->countAkuntan($cari); 
			$akuntan	= $this->Akuntan_model->getAllAkuntan($offset, $limit, $cari);

>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
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
<<<<<<< HEAD
			
=======
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			$callback	= [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=> $countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
<<<<<<< HEAD
		
		public function tambah() {
			$data['judul'] = 'Tambah Akuntan'; 
			$data['level'] = "akuntan";
			
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[8]|max_length[20]');
=======

		public function tambah() {
			$data['judul'] = 'Tambah Akuntan'; 
			$data['level'] = "akuntan";

			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email_user]');
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[8]|max_length[15]');
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akuntan/tambah', $data);
			} else {
<<<<<<< HEAD
				$validation = true;
				if( $this->cekUnique('email', $_POST['email']) == false ) {
					$validation = false;
					$this->session->set_flashdata('emailValid', 'invalid');
					$this->session->set_flashdata('emailMsg', 'Email sudah digunakan!');
				}
				if( $this->cekUnique('username', $_POST['username']) == false ) {
					$validation = false;
					$this->session->set_flashdata('usernameValid', 'invalid');
					$this->session->set_flashdata('usernameMsg', 'Username sudah digunakan!');
				}
				
				if( $validation == true ) {
					if($this->Akuntan_model->tambahAkuntan() == true)
					$this->session->set_flashdata('notification', 'Berhasil ditambahkan!');
					else
					$this->session->set_flashdata('warning', 'Gagal ditambahkan!');
					redirect('admin/master/akuntan');
				} else {
					$this->libtemplate->main('admin/akuntan/tambah', $data);
				}
			}
		}
		
		// untuk validasi data baru
		public function cekUnique($type, $key) {
			if( $type == 'username' )
			$result	= $this->Akuntan_model->getBy('byUsername', $key);
			elseif( $type == 'email' )
			$result	= $this->Akuntan_model->getBy('byEmail', $key);
			
			if($result) {
				return false;
			} else {
				return true;
=======
				$this->Akuntan_model->tambahAkuntan();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/master/akuntan');  
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
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
<<<<<<< HEAD
				$cek	= $this->Akuntan_model->getBy('byId', $this->session->userdata('id_user'));
=======
				$cek	= $this->Akuntan_model->getById($this->session->userdata('id_user'));
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($verify == true) {
					redirect('admin/master/akuntan/ubah/'.$_POST['id_user']);
				} else {
<<<<<<< HEAD
					$this->session->set_flashdata('pass', $this->input->post('id_user', true));
=======
					$this->session->set_flashdata('pass', $this->input->post('id', true));
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
					redirect('admin/master/akuntan');
				}
			}
		}
		
		public function ubah($id_user) {
<<<<<<< HEAD
			$data['akuntan']	= $this->Akuntan_model->getBy('byId', $id_user);
=======
			$data['akuntan']	= $this->Akuntan_model->getById($id_user);
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			$data['judul']		= 'Ubah Password';
			
			$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[15]');
			$this->form_validation->set_rules('passconf', 'Password', 'matches[password]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akuntan/ganti_password', $data);
			} else {
<<<<<<< HEAD
				if( $this->Akuntan_model->ubahAkuntan() == true )
				$this->session->set_flashdata('notification', 'Berhasil diubah!');
				else
				$this->session->set_flashdata('warning', 'Gagal diubah!');
=======
				$this->Akuntan_model->ubahAkuntan();
				$this->session->set_flashdata('notification', 'Password berhasil diubah!');
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
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
<<<<<<< HEAD
			if( $this->Akuntan_model->hapusAkuntan($id) == true )
			$this->session->set_flashdata('notification', 'Berhasil dihapus!');
			else
			$this->session->set_flashdata('warning', 'Gagal dihapus!');
			redirect('admin/master/akuntan');
=======
			$this->Akuntan_model->hapusAkuntan($id);
			$this->session->set_flashdata('notification', 'Data akuntan berhasil dihapus!');
			redirect('admin/master/akuntan'); 
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
		}
	}
?>