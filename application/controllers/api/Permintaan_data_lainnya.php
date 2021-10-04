<?php
	
	use chriskacerguis\RestServer\RestController;
	
	class Permintaan_data_lainnya extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('M_Permintaan_lainnya');
		}
		
		public function index_get() {
			$type		= $this->get('type');
			$key		= $this->get('key');
			$bulan		= $this->get('bulan');
			$tahun		= $this->get('tahun');
			$klien		= $this->get('klien');
			$offset		= $this->get('offset');
			$limit		= $this->get('limit');
			
			// menentukan fungsi yang akan dipanggil di model
			if( $type == 'all' || $type == '' ) {
				$result	= $this->M_Permintaan_lainnya->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			}
			elseif( $type == 'countAll' ) {
				$result	= $this->M_Permintaan_lainnya->countPermintaan($bulan, $tahun, $klien);
			}
			elseif( $type == 'byId' ) {
				$result	= $this->M_Permintaan_lainnya->getById($key);
			}
			elseif( $type == 'detail' ) {
				$result	= $this->M_Permintaan_lainnya->getDetail($key);
			}
			elseif( $type == 'countDetail' ) {
				$result	= $this->M_Permintaan_lainnya->countDetail($key);
			}
			
			// result
			$this->response( [
				'status'	=> true,
				'data'		=> $result,
			], RestController::HTTP_OK);
		}
		
		public function index_post() {
			$data = [
				'permintaan'	=> $this->post('permintaan'),
				'detail'		=> $this->post('detail'),
			];
			
			if ($this->M_Permintaan_lainnya->tambahPermintaan( $data ) > 0) {
				$this->response([
					'status' => true,
					'message' => 'Berhasil menambahkan data',
				], RestController::HTTP_CREATED);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Gagal menambahkan data',
				], RestController::HTTP_BAD_REQUEST);
			}
		}
		
		public function index_put() {
			$data = [
				'id_data'		=> $this->put('id_data'),
				'detail'		=> $this->put('detail'),
				'format_data'	=> $this->put('format_data'),
			];
			
			if ($this->M_Permintaan_lainnya->ubahPermintaan( $data ) > 0) {
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
			$id		= $this->delete('id');
			$type	= $this->delete('type');
			
			if ($id === null) {
				$this->response([
					'status'	=> false,
					'message'	=> 'Berikan id yang valid'
				], RestController::HTTP_BAD_REQUEST);
			} else {
				if($type == 'permintaan')
				$result = $this->M_Permintaan_lainnya->hapusPermintaan($id);
				else
				$result = $this->M_Permintaan_lainnya->hapusData($id);
				
				if ($result > 0) {
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