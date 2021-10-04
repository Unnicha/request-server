<?php

	use GuzzleHttp\Client;
	
	class Tugas extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->client = new Client([ 'base_uri' => base_url().'api/' ]);
		} 
		 
		public function index() {

			$data['judul'] = "Daftar Tugas"; 
			$this->libtemplate->main('admin/tugas/tampil', $data);
		}
		
		public function cari() {
			
			$cari = $this->input->post('cari');
			if( $cari ) {
				$response = $this->client->get('admin/tugas?cari='.$cari);
			} else { 
				$response = $this->client->get('admin/tugas');
			}
			$data['tugas'] = json_decode($response->getBody()->getContents(), true);
			
			if( $data['tugas'] ) {
				$this->load->view('admin/tugas/isi', $data);
			} else {
				echo '<tr>
						<td colspan="10">
							Tidak ada data ditemukan.
						</td>
					</tr>';
			}
		}

		public function tambah() {

			$response = $this->client->get('admin/tugas?id_tugas=kategori');
			if ($response->getStatusCode() == 200) {
				$kategori = json_decode($response->getBody()->getContents(), true);
			} else {
				$kategori = ['eror', 'eror'];
			}
			
			$response = $this->client->get('admin/jenis_data');
			if ($response->getStatusCode() == 200) {
				$jenis_data = json_decode($response->getBody()->getContents(), true);
			}

			$data['judul']		= 'Tambah Data Tugas'; 
			$data['kategori']	= $kategori;
			$data['jenis_data']	= $jenis_data;

			$this->form_validation->set_rules('nama_tugas', 'Nama Tugas', 'required');
			$this->form_validation->set_rules('kode_jenis', 'Kode Jenis', 'required');
			$this->form_validation->set_rules('status_pekerjaan', 'Status Pekerjaan', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/tugas/tambah', $data);
			} else {
				$response = $this->client->post('admin/tugas', ['form_params' => [
					'nama_tugas'		=> $this->input->post('nama_tugas', true),
					'kode_jenis'		=> $this->input->post('kode_jenis', true),
					'status_pekerjaan'	=> $this->input->post('status_pekerjaan', true),
					'hari'				=> $this->input->post('hari', true),
					'jam'				=> $this->input->post('jam', true),
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil diubah'); 
				} else {
					$this->session->set_flashdata('warning', 'Data gagal diubah'); 
				} 
				redirect('admin/tugas'); 
			}
		}
		
		public function ubah($id_tugas) {

			$response = $this->client->get('admin/tugas?id_tugas='.$id_tugas);
			if ($response->getStatusCode() == 200) {
				$tugas = json_decode($response->getBody()->getContents(), true);
			}

			$data['judul']		= 'Ubah Data Tugas'; 
			$data['hari']		= floor($tugas['lama_pengerjaan'] / 8);
			$data['jam']		= $tugas['lama_pengerjaan'] % 8;
			$data['tugas']		= $tugas;

			$this->form_validation->set_rules('nama_tugas', 'Nama Tugas', 'required');
			$this->form_validation->set_rules('status_pekerjaan', 'Status Pekerjaan', 'required');
			$this->form_validation->set_rules('kode_jenis', 'Kode Jenis', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/tugas/ubah', $data);
			} else {
				$response = $this->client->put('admin/tugas', ['form_params' => [
					'id_tugas'			=> $this->input->post('id_tugas', true),
					'nama_tugas'		=> $this->input->post('nama_tugas', true),
					'kode_jenis'		=> $this->input->post('kode_jenis', true),
					'status_pekerjaan'	=> $this->input->post('status_pekerjaan', true),
					'hari'				=> $this->input->post('hari', true),
					'jam'				=> $this->input->post('jam', true),
					]
				]);
				
				if ($response->getStatusCode() == 200) {
					$this->session->set_flashdata('notification', 'Data berhasil diubah'); 
				} elseif ($response->getStatusCode() == 304) {
					$this->session->set_flashdata('notification', 'Tidak ada perubahan'); 
				} 
				redirect('admin/tugas'); 
			}
		}

		public function detail($id_tugas) {

			$data['judul'] = 'Detail Tugas';
			$data['tugas'] = $this->Tugas_model->getById($id_tugas);
			
			$this->libtemplate->main('admin/tugas/detail', $data);
		}
		
		public function hapus($id_tugas) {

			$response = $this->client->delete('admin/tugas', ['form_params'=>["id_tugas" => $id_tugas]]);
			
			if ($response->getStatusCode() == 200) {
				$body = json_decode($response->getBody()->getContents(), true);
				$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
				redirect('admin/tugas');
			}
		}
	}
?>