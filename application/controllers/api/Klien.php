<?php
	
	use chriskacerguis\RestServer\RestController;
	
	class Klien extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Klien_model');
		} 
		
		public function index_get() {
			$type	= $this->get('type');
			$key	= $this->get('key');
			$offset	= $this->get('offset');
			$limit	= $this->get('limit');
			$etc	= $this->get('etc');
			
			// menentukan fungsi yang akan dipanggil di model
			if( $type == 'all' || $type == '' ) {
				$klien	= $this->Klien_model->getAllKlien($offset, $limit, $key);
			} elseif( $type == 'count' ) {
				$klien	= $this->Klien_model->countKlien($key);
			} elseif( $type == 'masa' ) {
				$klien	= $this->Klien_model->getMasa($key);
			} elseif( $type == 'unique' ) {
				$klien	= $this->Klien_model->getUnique($etc, $type, $key);
			} else {
				$klien	= $this->Klien_model->getById($key);
			}
			
			// result
			$this->response( [
				'status'	=> true,
				'data'		=> $klien,
			], RestController::HTTP_OK);
		}
		
		public function index_post() {
			$data = [
				// info user
				'level'		=> $this->post('level'),
				'username'	=> $this->post('username'),
				'password'	=> $this->post('password'),
				'nama'		=> $this->post('nama'),
				'email'		=> $this->post('email_user'),
				// info usaha
				'nama_usaha'		=> $this->post('nama_usaha'),
				'kode_klu'			=> $this->post('kode_klu'),
				'no_akte'			=> $this->post('no_akte'),
				'alamat'			=> $this->post('alamat'),
				'telp'				=> $this->post('telp'),
				'no_hp'				=> $this->post('no_hp'),
				'status_pekerjaan'	=> $this->post('status_pekerjaan'),
				// info pimpinan
				'nama_pimpinan'		=> $this->post('nama_pimpinan'),
				'jabatan'			=> $this->post('jabatan'),
				'no_hp_pimpinan'	=> $this->post('no_hp_pimpinan'),
				'email_pimpinan'	=> $this->post('email_pimpinan'),
				// info counterpart
				'nama_counterpart'	=> $this->post('nama_counterpart'),
				'no_hp_counterpart'	=> $this->post('no_hp_counterpart'),
				'email_counterpart'	=> $this->post('email_counterpart'),
			];
			
			if ($this->Klien_model->tambahKlien($data) > 0) {
				$this->response([
					'status' => true,
					'message' => 'Berhasil menambahkan data'
				], RestController::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Gagal menambahkan data'
				], RestController::HTTP_BAD_REQUEST);
			}
		}
		
		public function index_put() {
			if( $this->put('table') == 'user' ) {
				$data = [
					'id_klien'	=> $this->put('id_user'),
					'type'		=> $this->put('type'),
					'value'		=> $this->put('value'),
				];
				$klien = $this->Klien_model->ubahAkun($data);
			} else {
				$data = [
					'id_klien'	=> $this->put('id_user'),
					'type'		=> $this->put('type'),
					
					'nama_usaha'		=> $this->put('nama_usaha'),
					'kode_klu'			=> $this->put('kode_klu'),
					'alamat'			=> $this->put('alamat'),
					'telp'				=> $this->put('telp'),
					'no_hp'				=> $this->put('no_hp'),
					'email'				=> $this->put('email'),
					'no_akte'			=> $this->put('no_akte'),
					'status_pekerjaan'	=> $this->put('status_pekerjaan'),
					
					'nama_pimpinan'		=> $this->put('nama_pimpinan'),
					'jabatan'			=> $this->put('jabatan'),
					'no_hp_pimpinan'	=> $this->put('no_hp_pimpinan'),
					'email_pimpinan'	=> $this->put('email_pimpinan'),
					
					'nama_counterpart'	=> $this->put('nama_counterpart'),
					'no_hp_counterpart'	=> $this->put('no_hp_counterpart'),
					'email_counterpart'	=> $this->put('email_counterpart'),
				];
				
				$klien = $this->Klien_model->ubahProfil($data);
			}
			
			if( $klien > 0 ) {
				$this->response([
					'status'	=> true,
					'message'	=> 'Berhasil update',
				], RestController::HTTP_OK);
			} else {
				$this->response([
					'status'	=> false,
					'message'	=> 'Gagal update',
				], RestController::HTTP_NOT_MODIFIED);
			}
		}
		
		public function index_delete() {
			$id = $this->delete('id_klien');
			if ($id == null) {
				$this->response([
					'status'	=> false,
					'message'	=> 'Berikan kode yang valid',
				], RestController::HTTP_BAD_REQUEST);
			} else {
				if ($this->Klien_model->hapusKlien($id) > 0) {
					$this->response([
						'status'	=> true,
						'message'	=> 'Berhasil dihapus',
				], RestController::HTTP_OK);
				} else {
					$this->response([
						'status'	=> false,
						'message'	=> 'ID tidak ditemukan',
					], RestController::HTTP_BAD_REQUEST);
				}
			} 
		}
	}
?>