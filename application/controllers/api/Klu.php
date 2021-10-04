<?php
	
	use chriskacerguis\RestServer\RestController;
	
	class Klu extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Klu_model');
		}
		
		public function index_get() {
			$type	= $this->get('type');
			$key	= $this->get('key');
			$offset	= $this->get('offset');
			$limit	= $this->get('limit');
			
			// menentukan fungsi yang akan dipanggil di model
			if( $type == 'all' || $type == '' ) {
				$klu	= $this->Klu_model->getAllKlu($offset, $limit, $key);
			} elseif( $type == 'count' ) {
				$klu	= $this->Klu_model->countKlu($key);
			} else {
				$klu	= $this->Klu_model->getById($key);
			}
			
			// result
			$this->response( [
				'status'	=> true,
				'data'		=> $klu,
			], RestController::HTTP_OK);
		}

		public function index_post() {
			$data = [
				'kode_klu'		=> $this->post('kode_klu'),
				'bentuk_usaha'	=> $this->post('bentuk_usaha'),
				'jenis_usaha'	=> $this->post('jenis_usaha'),
			];
			
			if ($this->Klu_model->tambahKlu($data) > 0) {
				$this->response([
					'status' => true,
					'message' => 'Berhasil ditambahkan'
				], RestController::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Gagal ditambahkan'
				], RestController::HTTP_BAD_REQUEST);
			}
		}
		
		public function index_put() {
			$data = [
				'kode_klu'		=> $this->put('kode_klu'),
				'bentuk_usaha'	=> $this->put('bentuk_usaha'),
				'jenis_usaha'	=> $this->put('jenis_usaha'),
			];
			
			if ( $this->Klu_model->ubahKlu($data) > 0) {
				$this->response([
					'status' => true,
					'message' => 'Berhasil diubah'
				], RestController::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Gagal diubah'
				], RestController::HTTP_NOT_MODIFIED);
			}
		}
		
		public function index_delete() {
			$kode_klu = $this->delete('kode_klu');
			if ($kode_klu == null) {
				$this->response([
					'status' => false,
					'message' => 'Berikan kode yang valid'
				], RestController::HTTP_BAD_REQUEST);
			} else {
				if ($this->Klu_model->hapusKlu($kode_klu) > 0) {
					$this->response([
						'status' => true,
						'message' => 'Berhasil dihapus'
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