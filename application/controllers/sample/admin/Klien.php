<?php

	use GuzzleHttp\Client;
	
	class Klien extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->client = new Client([ 'base_uri' => base_url().'api/' ]);
		} 
		 
		public function index() {

			$data['judul'] = "Data Klien"; 
			//$data['klien_modal'] = $this->Klien_model->getAllKlien(); 
			$this->libtemplate->main('admin/klien/tampil', $data);
		}
		
		public function cari() {
			
			$cari = $this->input->post('cari');
			if( $cari ) {
				$response = $this->client->get('admin/klien?cari='.$cari);
			} else { 
				$response = $this->client->get('admin/klien');
			}
			$data['klien'] = json_decode($response->getBody()->getContents(), true);
			
			if( $data['klien'] ) {
				$this->load->view('admin/klien/isi', $data);
			} else {
				echo '<tr>
						<td colspan="10">
							Tidak ada data ditemukan.
						</td>
					</tr>';
			} 
		}

		public function tambah() {
			
			$response = $this->client->get('admin/klu');
			if ($response->getStatusCode() == 200) {
				$data['klu'] = json_decode($response->getBody()->getContents(), true);
			}
			$response = $this->client->get('admin/tugas?id_tugas=kategori');
			if ($response->getStatusCode() == 200) {
				$data['status_pekerjaan'] = json_decode($response->getBody()->getContents(), true);
			}

			$data['judul'] = 'Tambah Data Klien'; 
			$data['level'] = 'klien';
			
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
				$response = $this->client->post('admin/klien', ['form_params' => [
					'nama_klien'	=> $this->input->post('nama_klien', true),
					'username'		=> $this->input->post('username', true),
					'password'		=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
					'level'			=> $this->input->post('level', true),
					
					'nama_usaha'		=> $this->input->post('nama_usaha', true),
					'kode_klu'			=> $this->input->post('kode_klu', true),
					'no_akte'			=> $this->input->post('no_akte', true),
					'alamat'			=> $this->input->post('alamat', true),
					'telp'				=> $this->input->post('telp', true),
					'no_hp'				=> $this->input->post('no_hp', true),
					'email'				=> $this->input->post('email', true),
					'status_pekerjaan'	=> $this->input->post('status_pekerjaan', true),
	
					'nama_pimpinan'		=> $this->input->post('nama_pimpinan', true),
					'jabatan'			=> $this->input->post('jabatan', true),
					'no_hp_pimpinan'	=> $this->input->post('no_hp_pimpinan', true),
					'email_pimpinan'	=> $this->input->post('email_pimpinan', true),
	
					'nama_counterpart'	=> $this->input->post('nama_counterpart', true),
					'no_hp_counterpart'	=> $this->input->post('no_hp_counterpart', true),
					'email_counterpart'	=> $this->input->post('email_counterpart', true),
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil ditambahkan'); 
				} else {
					$this->session->set_flashdata('warning', 'Data gagal ditambahkan'); 
				}
				redirect('admin/klien'); 
			}
		}
		
		public function ubah_profil($id_klien) {
			
			$response = $this->client->get('admin/klien?id_klien='.$id_klien);
			if ($response->getStatusCode() == 200) {
				$data['klien'] = json_decode($response->getBody()->getContents(), true);
			}
			$response = $this->client->get('admin/klu');
			if ($response->getStatusCode() == 200) {
				$data['klu'] = json_decode($response->getBody()->getContents(), true);
			}
			$response = $this->client->get('admin/tugas?id_tugas=kategori');
			if ($response->getStatusCode() == 200) {
				$data['status_pekerjaan'] = json_decode($response->getBody()->getContents(), true);
			}

			$data['judul'] = 'Ubah Profil Klien';
			
			$this->form_validation->set_rules('nama_klien', 'Nama Klien', 'required');
			$this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'required');
			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required');
			$this->form_validation->set_rules('no_akte', 'No. Akte Terakhir', 'numeric');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required');
			$this->form_validation->set_rules('telp', 'Nomor Telepon', 'required|numeric');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('no_hp', 'No. HP', 'numeric');
			
			$this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'required');
			$this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
			$this->form_validation->set_rules('no_hp_pimpinan', 'No. HP', 'required|numeric');
			$this->form_validation->set_rules('email_pimpinan', 'Email', 'valid_email');

			$this->form_validation->set_rules('no_hp_counterpart', 'No. HP', 'numeric');
			$this->form_validation->set_rules('email_counterpart', 'Email', 'valid_email');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klien/profil/ubah', $data);
			} else {
				$response = $this->client->put('admin/klien', ['form_params' => [
					'id_klien'		=> $this->input->post('id_klien', true),
					'nama_klien'	=> $this->input->post('nama_klien', true), 
					
					'nama_usaha'		=> $this->input->post('nama_usaha', true),
					'kode_klu'			=> $this->input->post('kode_klu', true),
					'no_akte'			=> $this->input->post('no_akte', true),
					'alamat'			=> $this->input->post('alamat', true),
					'telp'				=> $this->input->post('telp', true),
					'email'				=> $this->input->post('email', true),
					'no_hp'				=> $this->input->post('no_hp', true),
					'status_pekerjaan'	=> $this->input->post('status_pekerjaan', true),
	
					'nama_pimpinan'		=> $this->input->post('nama_pimpinan', true),
					'jabatan'			=> $this->input->post('jabatan', true),
					'no_hp_pimpinan'	=> $this->input->post('no_hp_pimpinan', true),
					'email_pimpinan'	=> $this->input->post('email_pimpinan', true),
	
					'nama_counterpart'	=> $this->input->post('nama_counterpart', true),
					'no_hp_counterpart'	=> $this->input->post('no_hp_counterpart', true),
					'email_counterpart'	=> $this->input->post('email_counterpart', true),
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil diubah'); 
				} else {
					$this->session->set_flashdata('notification', 'Tidak ada perubahan'); 
				}
				redirect('admin/klien');
			}
		}
		
		public function ubah_akun($id_klien) {
			
			$response = $this->client->get('admin/klien?id_klien='.$id_klien);
			if ($response->getStatusCode() == 200) {
				$data['klien'] = json_decode($response->getBody()->getContents(), true);
			}

			$data['judul'] = 'Ubah Akun Klien';
			
			$this->form_validation->set_rules('nama_klien', 'Nama Klien', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[8]|max_length[15]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klien/akun/ubah', $data);
			} else {
				$response = $this->client->put('admin/klien', ['form_params' => [ 
					'ubah'			=> 'akun',
					'id_user'		=> $this->input->post('id_klien', true),
					'nama'			=> $this->input->post('nama_klien', true),
					'username'		=> $this->input->post('username', true),
					'password'		=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
					'level'			=> $this->input->post('level', true),
					'email'			=> $this->input->post('email', true),
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil diubah'); 
				} else {
					$this->session->set_flashdata('notification', 'Tidak ada perubahan'); 
				}
				redirect('admin/klien');
			}
		}
		
		public function pilih_klu() {

			$kode_klu = $this->input->post('action'); 
			$response = $this->client->get('admin/klu?kode_klu='.$kode_klu);
			if ($response->getStatusCode() == 200) {
				$klu = json_decode($response->getBody()->getContents(), true);
			}

			$data = array(
				'bentuk_usaha' => $klu['bentuk_usaha'],
				'jenis_usaha' => $klu['jenis_usaha'],
			);
			echo json_encode($data);
		}
		
		public function detail($jenis) {
			
			$id_klien = $this->input->post('action');
			$response = $this->client->get('admin/klien?id_klien='.$id_klien);
			if ($response->getStatusCode() == 200) {
				$data['klien'] = json_decode($response->getBody()->getContents(), true);
			}

			if($jenis == 'profil') {
				$data['judul'] = 'Detail Profil Klien';
				$this->load->view('admin/klien/profil/detail', $data);
			} else {
				$data['judul'] = 'Detail Akun Klien';
				$this->load->view('admin/klien/akun/detail', $data);
			}
			
		} 
		
		public function hapus($id_klien) {

			$response = $this->client->delete('admin/klien', ['form_params'=>['id_klien' => $id_klien]]);
			
			if ($response->getStatusCode() == 200) {
				$body = json_decode($response->getBody()->getContents(), true);
				$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
				redirect('admin/klien');
			}
		}
	}
?>