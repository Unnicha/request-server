<?php
	
	class Klien extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Klien_model');
			$this->load->model('Klu_model');
		} 
		 
		public function index() {

			$data['judul'] = "Data Klien"; 
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
						<!-- Detail Profil -->
						<a class="btn btn-sm btn-info btn-detail_profil" data-nilai="'.$k['id_klien'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Profil">
							<i class="bi bi-briefcase-fill"></i>
						</a>
						
						<!-- Detail Akun -->
						<a class="btn btn-sm btn-primary btn-detail_akun" data-value="'.$k['id_klien'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Akun">
							<i class="bi bi-person-fill"></i>
						</a>
						
						<!-- Hapus Klien -->
						<a class="btn btn-sm btn-danger" href="klien/hapus/'.$k['id_klien'].'" onclick="return confirm("Yakin ingin menghapus data klien '.$k['id_klien'].' ?");" data-toggle="tooltip" data-placement="bottom" title="Hapus Klien">
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
			$data['judul'] = 'Tambah Data Klien'; 
			$data['klu'] = $this->Klu_model->getAllKlu(); 
			$data['status_pekerjaan'] = ['Accounting Service', 'Review', 'Semi Review'];
			$data['level'] = "klien";
			
			//$this->form_validation->set_rules('id_klien', 'ID Klien', 'required|is_unique[klien.id_klien]');
			$this->form_validation->set_rules('nama_klien', 'Nama Klien', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[8]|max_length[15]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');

			$this->form_validation->set_rules('status_pekerjaan', 'Status Pekerjaan', 'required');
			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required');
			$this->form_validation->set_rules('telp', 'Nomor Telepon', 'required|numeric');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('no_hp', 'No. HP', 'numeric');
			$this->form_validation->set_rules('no_akte', 'No. Akte', 'numeric');

			$this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'required');
			$this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
			$this->form_validation->set_rules('no_hp_pimpinan', 'No. HP', 'required|numeric');
			$this->form_validation->set_rules('email_pimpinan', 'Email', 'valid_email');

			$this->form_validation->set_rules('no_hp_counterpart', 'No. HP', 'numeric');
			$this->form_validation->set_rules('email_counterpart', 'Email', 'valid_email');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klien/tambah', $data);
			} else {
				$this->Klien_model->tambahKlien();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/master/klien'); 
			}
		}
		
		public function ubah_profil($id_klien) {
			$data['judul'] = 'Ubah Profil Klien';
			$data['klien'] = $this->Klien_model->getById($id_klien);
			$data['klu'] = $this->Klu_model->getAllKlu();
			$data['status_pekerjaan'] = ['Accounting Service', 'Review', 'Semi Review'];
			
			//$this->form_validation->set_rules('id_klien', 'ID Klien', 'required');
			$this->form_validation->set_rules('nama_klien', 'Nama Klien', 'required');
			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required');
			$this->form_validation->set_rules('telp', 'Nomor Telepon', 'required|numeric');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('no_hp', 'No. HP', 'numeric');
			$this->form_validation->set_rules('no_akte', 'No. Akte Terakhir', 'numeric');
			
			$this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'required');
			$this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
			$this->form_validation->set_rules('no_hp_pimpinan', 'No. HP', 'required|numeric');
			$this->form_validation->set_rules('email_pimpinan', 'Email', 'valid_email');

			$this->form_validation->set_rules('no_hp_counterpart', 'No. HP', 'numeric');
			$this->form_validation->set_rules('email_counterpart', 'Email', 'valid_email');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klien/profil/ubah', $data);
			} else {
				$this->Klien_model->ubahProfilKlien();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!');
				redirect('admin/master/klien');
			}
		}
		
		public function ubah_akun($id_klien) {
			$data['judul'] = 'Ubah Akun Klien';
			$data['klien'] = $this->Klien_model->getById($id_klien);
			
			//$this->form_validation->set_rules('id_klien', 'ID Klien', 'required');
			$this->form_validation->set_rules('nama_klien', 'Nama Klien', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[8]|max_length[15]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klien/akun/ubah', $data);
			} else {
				$this->Klien_model->ubahAkunKlien();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('admin/master/klien'); 
			}
		}
		
		public function pilih_klu() {
			$kode_klu = $this->input->post('action', true);
			$klien = $this->Klu_model->getById($kode_klu);

			$data = array(
				'bentuk_usaha' => $klien['bentuk_usaha'],
				'jenis_usaha' => $klien['jenis_usaha'],
			);
			echo json_encode($data);
		}

		public function modal_klu() {
			$cari = "";

			if($this->input->post('cari', true)) {
				$cari = $this->input->post('cari', true);
				$data['klu'] = $this->Klu_model->search($cari);
			}
			else 
				{ $data['klu'] = $this->Klu_model->getAllKlu(); }
			
			$data['cari'] = $cari;

			$this->load->view('admin/klien/pilih_klu', $data);
		}
		
		public function profil() {
			$id_klien = $this->input->post('action', true);
			$data['judul'] = 'Detail Profil Klien';
			$data['klien'] = $this->Klien_model->getById($id_klien);
			
			$this->load->view('admin/klien/profil/detail', $data);
		}
		
		public function akun() {
			$id_klien = $this->input->post('action', true);
			$data['judul'] = 'Detail Akun Klien';
			$data['klien'] = $this->Klien_model->getById($id_klien);
			
			$this->load->view('admin/klien/akun/detail', $data);
		}
		
		public function hapus($id_klien) {
			$this->Klien_model->hapusDataKlien($id_klien);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/master/klien');
		}
	}
?>