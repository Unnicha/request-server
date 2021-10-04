<?php
	use GuzzleHttp\Client;
	
	class Admin extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			// $this->load->model('Admin_model');
			$this->client = new Client([ 'base_uri' => base_url().'api/' ]);
		}
		
		public function index() {
			$data['judul'] = "Daftar Admin";
			$this->libtemplate->main('admin/admin/tampil', $data);
		}
		
		public function page() {
			$offset	= $_POST['start'];
			$limit	= $_POST['length'];
			$cari	= $_POST['search']['value'];
			$countData	= $this->Admin_model->countAdmin($cari);
			$admin		= $this->Admin_model->getAllAdmin($offset, $limit, $cari);
			
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
			
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email_user]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/admin/tambah', $data);
			} else {
				$this->Admin_model->tambahAdmin();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!');
				redirect('admin/master/admin');
			}
		}
		
		public function view($id_user) {
			$user		= $this->Admin_model->getById($id_user);
			$passcode	= '';
			for($i=0; $i<$user['passlength']; $i++) {
				$passcode .= '&bull;';
			}
			$user['passcode'] = $passcode;
			
			$data['judul']	= "Profile Admin";
			$data['user']	= $user;
			
			$this->libtemplate->main('admin/admin/view', $data);
		}
		
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
					$this->session->set_flashdata('pass', $this->input->post('id', true));
					redirect('admin/master/admin');
				}
			}
		}
		
		public function ubah($id_user) {
			$data['admin']	= $this->Admin_model->getById($id_user);
			$data['judul']	= 'Ubah Password';
			$data['tipe']	= 'password';
			
			$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[15]');
			$this->form_validation->set_rules('passconf', 'Password', 'matches[password]');
			
			if($this->form_validation->run() == FALSE) {
				$tipe = $this->session->userdata('tipe');
				$this->libtemplate->main('admin/profile/ganti_password', $data);
			} else {
				$tipe = $this->session->userdata('tipe');
				$this->Admin_model->ubahAdmin();
				$this->session->set_flashdata('notification', 'Password berhasil diubah!');
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
			$this->Admin_model->hapusAdmin($id);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/master/admin');
		}
	}
?>