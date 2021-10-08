<?php
	
	use chriskacerguis\RestServer\RestController;
	
	class Akuntan extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Akuntan_model');
		}
		
		public function index_get() {
			$type	= $this->get('type');
			$key	= $this->get('key');
			$offset	= $this->get('offset');
			$limit	= $this->get('limit');
			
			if( $type == 'all' || $type == '' ) {
				$akuntan = $this->Akuntan_model->getAllAkuntan($offset, $limit, $key);
			} else {
				$key	 = str_replace('%40', '@', $key);
				$akuntan = $this->Akuntan_model->getBy($type, $key);
			}
			
			// result
			$this->response( [
				'status'	=> true,
				'data'		=> $akuntan,
			], RestController::HTTP_OK );
		}
		
		public function index_post() {
			$data = [
				'level'		=> $this->post('level', true),
				'username'	=> $this->post('username', true),
				'password'	=> $this->post('password', true),
				'nama'		=> $this->post('nama', true),
				'email'		=> $this->post('email', true),
			];
			
			if ($this->Akuntan_model->tambahAkuntan($data) > 0) {
				$this->response([
					'status' => true,
					'message' => 'Berhasil menambahkan data',
				], RestController::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Gagal menambahkan data',
				], RestController::HTTP_BAD_REQUEST);
			}
		}
		
		public function index_put() {
			$data = [
				'id'	=> $this->put('id_user'),
				'type'	=> $this->put('type'),
				'value'	=> $this->put('value'),
			];
			
			if( $this->Akuntan_model->ubahAkuntan($data) > 0 ) {
				$this->response([
					'status' => true,
					'message' => 'Berhasil mengubah data'
				], RestController::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Gagal mengubah data'
				], RestController::HTTP_BAD_REQUEST);
			}
		}
		
		public function index_delete() {
			$id_user = $this->delete('id_user');
			if ($id_user == null) {
				$this->response([
					'status' => false,
					'message' => 'Berikan kode yang valid'
				], RestController::HTTP_BAD_REQUEST);
			} else {
				if ($this->Akuntan_model->hapusAkuntan($id_user) > 0) {
					$this->response([
						'status' => true,
					], RestController::HTTP_OK);
				} else {
					$this->response([
						'status' => false,
						'message'=> 'ID tidak ditemukan'
					], RestController::HTTP_BAD_REQUEST);
				}
			} 
		}
	}
?>