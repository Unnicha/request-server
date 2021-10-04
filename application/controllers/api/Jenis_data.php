<?php
	
	use chriskacerguis\RestServer\RestController;
	
	class Jenis_data extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Jenis_data_model');
		}
		
		public function index_get() {
			$type	= $this->get('type');
			$key	= $this->get('key');
			$offset	= $this->get('offset');
			$limit	= $this->get('limit');
			
			// menentukan fungsi yang akan dipanggil di model
			if( $type == 'all' || $type == '' ) {
				$jenis	= $this->Jenis_data_model->getAllJenis($offset, $limit, $key);
			} elseif( $type == 'count' ) {
				$jenis	= $this->Jenis_data_model->countJenis($key);
			} elseif( $type == 'kategori' ) {
				$jenis	= $this->Jenis_data_model->kategori();
			} else {
				$jenis	= $this->Jenis_data_model->getBy($type, $key);
			}
			
			// result
			$this->response([
				'status'	=> true,
				'data'		=> $jenis,
			], RestController::HTTP_OK);
		}
		
		public function index_post() {
			$data = [
				'jenis_data'	=> $this->post('jenis_data'),
				'kategori'		=> $this->post('kategori'),
			];
			
			if( $this->Jenis_data_model->tambahJenis($data) > 0) {
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
				'kode_jenis'	=> $this->put('kode_jenis'),
				'jenis_data'	=> $this->put('jenis_data'),
				'kategori'		=> $this->put('kategori'),
			];
			
			if ( $this->Jenis_data_model->ubahJenis($data) > 0) {
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
			$kode_jenis = $this->delete('kode_jenis');
			if ($kode_jenis == null) {
				$this->response([
					'status' => false,
					'message' => 'Berikan kode yang valid'
				], RestController::HTTP_BAD_REQUEST);
			} else {
				if ($this->Jenis_data_model->hapusJenis($kode_jenis) > 0) {
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