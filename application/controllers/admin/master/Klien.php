<?php
	
	class Klien extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Klien_model');
			$this->load->model('Klu_model');
			$this->load->model('Admin_model');
		} 
		 
		public function index() {
			$data['judul'] = "Daftar Klien"; 
			$data['klien_modal'] = $this->Klien_model->getAllKlien(); 
			
			$this->libtemplate->main('admin/klien/tampil', $data);
		}
		
		public function page() {
			$cari	= $_POST['search']['value'];
			$limit	= $_POST['length'];
			$offset = $_POST['start'];
			
			$countData	= $this->Klien_model->countKlien($cari); 
			$klien		= $this->Klien_model->getAllKlien($offset, $limit, $cari);
			
			$data		= [];
			foreach($klien as $k) {
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['status_pekerjaan'];
				$row[]	= $k['jenis_usaha'];
				$row[]	= $k['nama_pimpinan'];
				$row[]	= '
						<a href="klien/view/'.$k['id_klien'].'" data-toggle="tooltip" data-placement="bottom" title="Detail">
							<i class="bi bi-info-circle-fill icon-medium"></i>
						</a>
						<a class="btn-hapus" data-id="'.$k['id_klien'].'" data-nama="'.$k['nama'].'" data-toggle="tooltip" data-placement="bottom" title="Hapus Klien">
							<i class="bi bi-trash icon-medium"></i>
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
			$data['judul']				= 'Tambah Klien'; 
			$data['klu']				= $this->Klu_model->getAllKlu(); 
			$data['status_pekerjaan']	= ['Accounting Service', 'Review', 'Semi Review'];
			$data['level']				= "klien";
			
			$this->form_validation->set_rules('nama_counterpart', 'Nama', 'required');
			$this->form_validation->set_rules('no_hp_counterpart', 'No. HP', 'required|numeric');
			$this->form_validation->set_rules('email_counterpart', 'Email', 'required|valid_email');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klien/tambah', $data);
			} else {
<<<<<<< HEAD
				if($this->Klien_model->tambahKlien() == true)
				$this->session->set_flashdata('notification', 'Berhasil ditambahkan!'); 
				else
				$this->session->set_flashdata('warning', 'Gagal ditambahkan!'); 
=======
				$this->Klien_model->tambahKlien();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
				redirect('admin/master/klien'); 
			}
		}
		
		public function pilih_klu() {
			$kode_klu	= $this->input->post('action', true);
			$klien		= $this->Klu_model->getById($kode_klu);
			
			$data = array(
				'bentuk_usaha' => $klien['bentuk_usaha'],
				'jenis_usaha' => $klien['jenis_usaha'],
			);
			echo json_encode($data);
		}
		
		public function cekUnique() {
<<<<<<< HEAD
			$table	= $this->input->post('table');
			$field	= $this->input->post('field');
			$value	= $this->input->post('value');
			$cek	= $this->Klien_model->cekUnique($table, $field, $value);
			$result = ( $cek ) ? false : true;
=======
			$result = $this->Klien_model->cekUnique($_REQUEST['table'], $_REQUEST['field'], $_REQUEST['value']);
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			echo json_encode($result);
		}
		
		public function view($id_user) {
			$user		= $this->Klien_model->getById($id_user);
			$passcode	= '';
			for($i=0; $i<$user['passlength']; $i++) {
				$passcode .= '&bull;';
			}
			$user['passcode'] = $passcode;
			
			$data['judul']	= "Profile Klien";
			$data['user']	= $user;
			
			$this->libtemplate->main('admin/klien/view', $data);
		}
		
		public function verification() {
			$data['judul']		= 'Verifikasi';
			$data['subjudul']	= 'Beritahu kami bahwa ini benar Anda';
			$data['tipe']		= $this->input->post('type', true);
			$data['input']		= $this->input->post('input', true);
			$data['id_user']	= $this->input->post('id', true);
			$this->session->set_userdata('tipe', $data['tipe']);
			$this->session->set_userdata('input', $data['input']);
			
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->load->view('admin/klien/verif', $data);
			} else {
				$cek	= $this->Admin_model->getById($this->session->userdata('id_user'));
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($verify == true) {
					redirect('admin/master/klien/ubah/'.$_POST['id_user']);
				} else {
					$this->session->set_flashdata('pass', 'Password salah!');
					redirect('admin/master/klien/view/'.$_POST['id_user']);
				}
			}
		}
		
		public function ubah($id_user) {
			$type			= $this->session->userdata('tipe');
			$data['judul']	= 'Ubah '.ucwords($type);
			$data['klien']	= $this->Klien_model->getById($id_user);
			$data['klu']	= $this->Klu_model->getAllKlu(); 
<<<<<<< HEAD
			
			$data['table']	= $this->session->userdata('input');
			$data['status']	= ['Accounting Service', 'Review', 'Semi Review'];
			$data['tipe']	= $type;
			$data['back']	= 'admin/master/klien/view/'.$id_user;
=======
			$data['status']	= ['Accounting Service', 'Review', 'Semi Review'];
			$data['table']	= $this->session->userdata('input');
			$data['tipe']	= $type;
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			
			if($type == 'nama') {
				$this->form_validation->set_rules('nama', 'Nama', 'required');
			} elseif($type == 'email') {
<<<<<<< HEAD
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			} elseif($type == 'username') {
				$this->form_validation->set_rules('username', 'Username', 'required|min_length[8]');
=======
				$this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email_user]|valid_email');
			} elseif($type == 'username') {
				$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[8]');
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			} elseif($type == 'password') {
				$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[15]');
				$this->form_validation->set_rules('passconf', 'Password', 'matches[password]');
			} elseif($type == 'usaha') {
				$this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'required');
				$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required');
				$this->form_validation->set_rules('alamat', 'Alamat', 'required');
				$this->form_validation->set_rules('telp', 'Nomor Telepon', 'required|numeric');
				$this->form_validation->set_rules('no_hp', 'No. HP', 'numeric');
				$this->form_validation->set_rules('no_akte', 'No. Akte', 'numeric');
				$this->form_validation->set_rules('status_pekerjaan', 'Status Pekerjaan', 'required');
			} elseif($type == 'pimpinan') {
				$this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'required');
				$this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
				$this->form_validation->set_rules('no_hp_pimpinan', 'No. HP', 'required|numeric');
				$this->form_validation->set_rules('email_pimpinan', 'Email', 'valid_email');
			} elseif($type == 'counterpart') {
				$this->form_validation->set_rules('no_hp_counterpart', 'No. HP', 'numeric');
				$this->form_validation->set_rules('email_counterpart', 'Email', 'valid_email');
			}
			
			if($this->form_validation->run() == FALSE) {
<<<<<<< HEAD
				$type = $this->session->userdata('tipe');
				$this->libtemplate->main('klien/profile/ganti_'.$type, $data);
			} else {
				$do_update	= false;
				$type		= $this->session->userdata('tipe');
				$email		= $this->input->post('email');
				$username	= $this->input->post('username');
				
				if($type == 'email' || $type == 'username') {
					$key = ($type == 'email') ? $email : $username;
					
					if ($type == 'username')
					$result	= $this->Admin_model->getByUsername($key);
					elseif ($type == 'email')
					$result	= $this->Admin_model->getByEmail($key);
					
					$do_update = ($result) ? false : true;
				} else {
					$do_update = true;
				}
				
				if($do_update == true) {
					$table	= $this->input->post('table');
					if($table == 'user') {
						$this->Klien_model->ubahAkun();
					} elseif($table == 'profil') {
						$this->Klien_model->ubahProfil();
					}
					$this->session->set_flashdata('notification', ucwords($type).' berhasil diubah!');
					redirect('admin/master/klien/view/'.$this->input->post('id_klien'));
				} else {
					$this->session->set_flashdata('used', $type.' sudah digunakan');
					$this->libtemplate->main('klien/profile/ganti_'.$type, $data);
				}
=======
				$this->libtemplate->main('klien/profile/ganti_'.$type, $data);
			} else {
				if($this->input->post('table') == 'user') {
					$this->Klien_model->ubahAkun();
				} elseif($this->input->post('table') == 'profil') {
					$this->Klien_model->ubahProfile();
				}
				$this->session->set_flashdata('notification', ucwords($type).' berhasil diubah!');
				redirect('admin/master/klien/view/'.$this->input->post('id_klien'));
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			}
		}
		
		public function hapus() {
			$id				= $_REQUEST['id'];
			$data['text']	= 'Yakin ingin menghapus klien <b>'.$_REQUEST['nama'].' ?</b>';
			$data['button']	= '
				<a href="klien/fix_hapus/'.$id.'" class="btn btn-danger">Hapus</a>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal" tabindex="1">Batal</button>
			';
			
			$this->load->view('admin/template/confirm', $data);
		}
		
		public function fix_hapus($id) {
			$this->Klien_model->hapusDataKlien($id);
			$this->session->set_flashdata('notification', 'Klien berhasil dihapus!');
			redirect('admin/master/klien');
		}
	}
?>