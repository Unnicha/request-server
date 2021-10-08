<?php
	
	use chriskacerguis\RestServer\RestController;
	
	class Tugas extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Tugas_model');
		}
		
		public function index_get() {
			$type	= $this->get('type');
			$key	= $this->get('key');
			$offset	= $this->get('offset');
			$limit	= $this->get('limit');
			
			// menentukan fungsi yang akan dipanggil di model
			if( $type == 'all' || $type == '' ) {
				$tugas	= $this->Tugas_model->getAllTugas($offset, $limit, $key);
			} elseif( $type == 'count' ) {
				$tugas	= $this->Tugas_model->countTugas($key);
			} else {
				$tugas	= $this->Tugas_model->getById($key);
			}
			
			// result
			$this->response( [
				'status'	=> true,
				'data'		=> $tugas,
			], RestController::HTTP_OK);
		}
		
		public function index_post() {
			$data = [ 
				'nama_tugas'			=> $this->post('nama_tugas'),
				'accounting_service'	=> $this->post('accounting_service'),
				'review'				=> $this->post('review'),
				'semi_review'			=> $this->post('semi_review'),
				'id_jenis'				=> $this->post('id_jenis'),
			];
			
			if ($this->Tugas_model->tambahTugas($data) > 0) {
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
				'kode_tugas'			=> $this->put('kode_tugas'),
				'nama_tugas'			=> $this->put('nama_tugas'),
				'accounting_service'	=> $this->put('accounting_service'),
				'review'				=> $this->put('review'),
				'semi_review'			=> $this->put('semi_review'),
				'id_jenis'				=> $this->put('id_jenis'),
			];
			
			if ( $this->Tugas_model->ubahTugas($data) > 0) {
				$this->response([
					'status'	=> true,
					'message'	=> 'Berhasil diubah',
				], RestController::HTTP_OK);
			} else {
				$this->response([
					'status'	=> false,
					'message'	=> 'Gagal diubah',
				], RestController::HTTP_NOT_MODIFIED);
			}
		}
		
		public function index_delete() {
			$id = $this->delete('kode_tugas');
			if ($id == null) {
				$this->response([
					'status'	=> false,
					'message'	=> 'Berikan kode yang valid',
				], RestController::HTTP_BAD_REQUEST);
			} else {
				if ($this->Tugas_model->hapusTugas($id) > 0) {
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