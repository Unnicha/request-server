<?php
	
	class Admin extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('Admin_model');
		}
		
		public function index() {
			$data['judul'] = "Daftar Admin";
			$this->libtemplate->main('admin/admin/tampil', $data);
		}
		
		// menampilkan dataTables
		public function page() {
			$offset		= $_POST['start'];
			$limit		= $_POST['length'];
			$cari		= $_POST['search']['value'];
			$admin		= $this->Admin_model->getAllAdmin($offset, $limit, $cari);
			$countData	= $this->Admin_model->countAdmin($cari);
			
			$data = [];
			foreach($admin as $k) {
				$hapus	= '
					<a class="btn-ubah" data-id="'.$k['id_user'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah Password">
						<i class="bi bi-key-fill icon-medium"></i>
					</a>
					<a class="btn-hapus" data-id="'.$k['id_user'].'" data-nama="'.$k['nama'].'" data-toggle="tooltip" data-placement="bottom" title="Hapus">
					<i class="bi bi-trash icon-medium"></i>
					</a>';
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama'];
				$row[]	= $k['username'];
				$row[]	= $k['email_user'];
				$row[]	= $k['id_user'] == 1001 ? '' : $hapus;
				
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
			$data['judul']	= 'Tambah Admin';
			$data['level']	= 'admin';
			
			$this->session->unset_userdata([
				'emailValid', 'emailMsg',
				'usernameValid', 'usernameMsg',
			]);
			
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[8]|max_length[20]');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/admin/tambah', $data);
			} else {
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
				
				if($validation == true) {
					if( $this->Admin_model->tambahAdmin() == true ) {
						$this->session->set_flashdata('notification', 'Berhasil ditambahkan!');
					} else {
						$this->session->set_flashdata('warning', 'Gagal ditambahkan!');
					}
					redirect('admin/master/admin');
				} else {
					$this->libtemplate->main('admin/admin/tambah', $data);
				}
			}
		}
		
		// untuk validasi data baru
		public function cekUnique($type, $key) {
			if( $type == 'username' )
			$result	= $this->Admin_model->getByUsername($key);
			elseif( $type == 'email' )
			$result	= $this->Admin_model->getByEmail($key);
			
			if($result) {
				return false;
			} else {
				return true;
			}
		}
		
		// verifikasi admin sebelum melakukan perubahan data
		public function verif() {
			$data['judul']		= 'Verifikasi';
			$data['subjudul']	= 'Beritahu kami bahwa ini benar Anda';
			$data['id_user']	= $this->input->post('id', true);
			
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->load->view('admin/admin/verif', $data);
			} else {
				$cek	= $this->Admin_model->getById($this->session->userdata('id_user'));
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($verify == true) {
					redirect('admin/master/admin/ubah/'.$_POST['id_user']);
				} else {
					$this->session->set_flashdata('pass', $this->input->post('id_user', true));
					// $this->session->set_flashdata('msg', 'Password salah!');
					redirect('admin/master/admin');
				}
			}
		}
		
		public function ubah($id_user) {
			$data['admin']	= $this->Admin_model->getById($id_user);
			$data['judul']	= 'Ubah Password';
			$data['tipe']	= 'password';
			$data['back']	= 'admin/master/admin';
			
			$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[15]');
			$this->form_validation->set_rules('passconf', 'Password', 'matches[password]');
			
			if($this->form_validation->run() == FALSE) {
				$tipe = $this->session->userdata('tipe');
				$this->libtemplate->main('admin/profile/ganti_password', $data);
			} else {
				if( $this->Admin_model->ubahAdmin() == true ) {
					$this->session->set_flashdata('notification', 'Berhasil diubah!');
				} else {
					$this->session->set_flashdata('warning', 'Gagal diubah!');
				}
				redirect('admin/master/admin');
			}
		}
		
		public function hapus() {
			$id				= $_REQUEST['id'];
			$data['text']	= 'Yakin ingin menghapus admin <b>'.$_REQUEST['nama'].' ?</b>';
			$data['button']	= '
				<a href="admin/fix_hapus/'.$id.'" class="btn btn-danger">Hapus</a>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal" tabindex="1">Batal</button>
				';
				
			$this->load->view('admin/template/confirm', $data);
		}
		
		public function fix_hapus($id) {
			if( $this->Admin_model->hapusAdmin($id) == true ) {
				$this->session->set_flashdata('notification', 'Berhasil dihapus!');
			} else {
				$this->session->set_flashdata('warning', 'Gagal dihapus!');
			}
			redirect('admin/master/admin');
		}
	}
?>