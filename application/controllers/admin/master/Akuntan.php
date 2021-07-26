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
				$row[]	= $k['nama'];
				$row[]	= $k['username'];
				$row[]	= $k['email_user'];
				$row[]	= '
				<a class="btn btn-sm btn-info" href="akuntan/view/'.$k['id_user'].'" data-toggle="tooltip" data-placement="bottom" title="Edit">
					<i class="bi bi-pencil-square"></i>
				</a>
				<a class="btn btn-sm btn-danger btn-hapus" data-id="'.$k['id_user'].'" data-nama="'.$k['nama'].'" data-toggle="tooltip" data-placement="bottom" title="Hapus">
					<i class="bi bi-trash"></i>
				</a>';

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
				redirect('admin/master/akuntan');  
			}
		}
		
		public function view($id_user) {
			$user		= $this->Akuntan_model->getById($id_user);
			$passcode	= '';
			for($i=0; $i<$user['passlength']; $i++) {
				$passcode .= '&bull;';
			}
			$user['passcode'] = $passcode;
			
			$data['judul']	= "Profile Akuntan";
			$data['user']	= $user;
			
			$this->libtemplate->main('admin/akuntan/view', $data);
		}
		
		public function verification() {
			$data['judul']		= 'Verifikasi';
			$data['subjudul']	= 'Beritahu kami bahwa ini benar Anda';
			$data['tipe']		= $this->input->post('type', true);
			$data['id_user']	= $this->input->post('id', true);
			$this->session->set_userdata('tipe', $data['tipe']);
			
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->load->view('admin/akuntan/verif', $data);
			} else {
				$cek	= $this->Akuntan_model->getById($this->session->userdata('id_user'));
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($verify == true) {
					redirect('admin/master/akuntan/ubah/'.$_POST['id_user']);
				} else {
					$this->session->set_flashdata('pass', 'Password salah!');
					redirect('admin/master/akuntan');
				}
			}
		}
		
		public function ubah($id_user) {
			$type				= $this->session->userdata('tipe');
			$data['akuntan']	= $this->Akuntan_model->getById($id_user);
			$data['judul']		= 'Akuntan '.$data['akuntan']['nama'].' - Ubah '.ucwords($type);
			
			if($type == 'nama') {
				$this->form_validation->set_rules('nama', 'Nama', 'required');
			} elseif($type == 'email') {
				$this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email_user]|valid_email');
			} elseif($type == 'username') {
				$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[8]');
			} elseif($type == 'password') {
				$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[15]');
				$this->form_validation->set_rules('passconf', 'Password', 'matches[password]');
			}
			
			if($this->form_validation->run() == FALSE) {
				$tipe = $this->session->userdata('tipe');
				$this->libtemplate->main('akuntan/profile/ganti_'.$tipe, $data);
			} else {
				$tipe = $this->session->userdata('tipe');
				$this->Akuntan_model->ubahAkuntan();
				$this->session->set_flashdata('notification', ucwords($tipe).' berhasil diubah!');
				redirect('admin/master/akuntan/view/'.$_POST['id_user']);
			}
		}
		
		public function hapus() {
			$this->Akuntan_model->hapusAkuntan($_POST['id']);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
		}
	}
?>