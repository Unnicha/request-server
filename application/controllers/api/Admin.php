<?php
	
	use chriskacerguis\RestServer\RestController;
	
	class Admin extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Admin_model');
		}
		
		public function index_get() {
			$type	= $this->get('type');
			$key	= $this->get('key');
			$offset	= $this->get('offset');
			$limit	= $this->get('limit');
			
			// menentukan fungsi yang akan dipanggil di model
			if( $type == 'all' || $type == '' ) {
				$admin	= $this->Admin_model->getAllAdmin($offset, $limit, $key);
			} elseif( $type == 'count' ) {
				$admin	= $this->Admin_model->countAdmin($key);
			} elseif( $type == 'token' ) {
				$admin	= $this->Admin_model->validToken($key);
			} else {
				$admin	= $this->Admin_model->getBy($type, $key);
			}
			
			// result
			$this->response( [
				'status'	=> true,
				'data'		=> $admin,
			], RestController::HTTP_OK);
		}
		
		public function index_post() {
			if($this->post('type') == 'data') {
				$data = [
					'level'		=> $this->post('level'),
					'username'	=> $this->post('username'),
					'password'	=> $this->post('password'),
					'nama'		=> $this->post('nama'),
					'email'		=> $this->post('email'),
				];
				
				if ($this->Admin_model->tambahAdmin($data) > 0) {
					$this->response([
						'status'	=> true,
						'message'	=> 'Berhasil menambahkan data',
					], RestController::HTTP_CREATED);
				} else {
					$this->response([
						'status'	=> false,
						'message'	=> 'Gagal menambahkan data',
					], RestController::HTTP_BAD_REQUEST);
				}
			} else {
				$id		= $this->post('id_user');
				$result	= $this->Admin_model->insertToken($id);
				if ( $result ) {
					$this->response([
						'status'	=> true,
						'message'	=> 'Berhasil menambahkan data',
						'data'		=> $result,
					], RestController::HTTP_CREATED);
				} else {
					$this->response([
						'status'	=> false,
						'message'	=> 'Gagal menambahkan data',
					], RestController::HTTP_BAD_REQUEST);
				}
			}
		}
		
		public function index_put() {
			$data = [
				'id'	=> $this->put('id_user'),
				'type'	=> $this->put('type'),
				'value'	=> $this->put('value'),
			];
			
			if ($this->Admin_model->ubahAdmin($data) > 0) {
				$this->response([
					'status'	=> true,
					'message'	=> 'Berhasil update',
				], RestController::HTTP_OK);
			} else {
				$this->response([
					'status'	=> false,
					'message'	=> 'Gagal memperbarui',
				], RestController::HTTP_NOT_MODIFIED);
			}
		}
		
		public function index_delete() {
			$id = $this->delete('id_user');
			
			if ($id === null) {
				$this->response([
					'status'	=> false,
					'message'	=> 'Berikan id yang valid'
				], RestController::HTTP_BAD_REQUEST);
			} else {
				if ($this->Admin_model->hapusAdmin($id) > 0) {
					$this->response([
						'status'	=> true,
						'message'	=> 'Berhasil menghapus Admin',
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