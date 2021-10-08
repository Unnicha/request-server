<?php

	use chriskacerguis\RestServer\RestController;

	class Login extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Otoritas_model');
		} 
		 
		public function index_get() { 
			if( $this->get('username') ) {
				$akuntan = $this->Otoritas_model->getByUsername($this->get('username'));
			} elseif( $this->get('email') ) {
				$akuntan = $this->Otoritas_model->getByEmail($this->get('email'));
			} elseif( $this->get('token') ) {
				$akuntan = $this->Otoritas_model->validToken($this->get('token'));
			}

			if ( $akuntan ) { 
				$response = $this->response( $akuntan, RestController::HTTP_OK);
			} 
		} 

		public function index_post() {
			
			$result = $this->Otoritas_model->insertToken($this->post('id_user'));
			
			if ($result > 0) {
				$this->response('', RestController::HTTP_OK);
			} else {
				$this->response('', RestController::HTTP_BAD_REQUEST);
			}
		}
		
		public function index_put() {
			
			$id_user	= $this->put('id_user'); 
			$password	= $this->put('password'); 
			$akuntan	= $this->Otoritas_model->ubahPassword($password, $id_user); 
			
			if ( $akuntan > 0) {
				$this->response('', RestController::HTTP_OK);
			} else {
				$this->response('', RestController::HTTP_BAD_REQUEST);
			}
		}
		
		public function index_delete() {

			$id_user = $this->delete('id_user');
			if ($id_user == null) {
				$this->response([
					'status' => true,
					'message' => 'Berikan kode yang valid'
				], RestController::HTTP_BAD_REQUEST);
			} else {
				if ($this->Login_model->hapusLogin($id_user) > 0) {
					$this->response([
						'status' => true,
					], RestController::HTTP_OK);
				} else {
					$this->response([
						'status' => true,
						'message'=> 'ID tidak ditemukan'
					], RestController::HTTP_BAD_REQUEST);
				}
			} 
		}
	}
?>