<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	use chriskacerguis\RestServer\RestController;
	
	class Proses_data_perpajakan extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('M_Proses_perpajakan', 'M_Proses');
		}
		
		public function index_get() {
			$type		= $this->get('type');
			$key		= $this->get('key');
			$status		= $this->get('status');
			$bulan		= $this->get('bulan');
			$tahun		= $this->get('tahun');
			$klien		= $this->get('klien');
			$offset		= $this->get('offset');
			$limit		= $this->get('limit');
			
			// menentukan fungsi yang akan dipanggil di model
			if( $type == 'all' || $type == '' ) {
				$result	= $this->M_Proses->getByMasa($status, $bulan, $tahun, $klien, $offset, $limit);
			}
			elseif( $type == 'count' ) {
				$result	= $this->M_Proses->countProses($status, $bulan, $tahun, $klien);
			}
			elseif( $type == 'byId' ) {
				$result	= $this->M_Proses->getById($key);
			}
			elseif( $type == 'detail' ) {
				$result	= $this->M_Proses->getDetail($key);
			}
			elseif( $type == 'countDetail' ) {
				$result	= $this->M_Proses->countDetail($key);
			}
			
			// result
			$this->response( [
				'status'	=> true,
				'data'		=> $result,
			], RestController::HTTP_OK);
		}
		
		public function index_post() {
			$data = [
				'tanggal_mulai'		=> $this->post('tanggal_mulai'),
				'tanggal_selesai'	=> $this->post('tanggal_selesai'),
				'keterangan'		=> $this->post('keterangan'),
				'kode_data'			=> $this->post('kode_data'),
				'id_akuntan'		=> $this->post('id_akuntan'),
			];
			
			if ($this->M_Proses->simpanProses( $data ) > 0) {
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
		}
		
		public function index_put() {
			$data = [
				'id_proses'			=> $this->put('id_proses'),
				'tanggal_selesai'	=> $this->put('tanggal_selesai'),
				'keterangan'		=> $this->put('keterangan'),
				'kode_data'			=> $this->put('kode_data'),
			];
			
			if($this->put('type') == 'selesai')
			$result = $this->M_Proses->ubahProses( $data );
			elseif($this->put('type') == 'batal')
			$result = $this->M_Proses->batalProses( $data );
			
			if ($result > 0) {
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
		
		// public function index_delete() {
		// 	$id		= $this->delete('id');
		// 	$type	= $this->delete('type');
			
		// 	if ($id === null) {
		// 		$this->response([
		// 			'status'	=> false,
		// 			'message'	=> 'Berikan id yang valid'
		// 		], RestController::HTTP_BAD_REQUEST);
		// 	} else {
		// 		if($type == 'permintaan')
		// 		$result = $this->M_Proses->hapusProses($id);
		// 		else
		// 		$result = $this->M_Proses->hapusData($id);
				
		// 		if ($result > 0) {
		// 			$this->response([
		// 				'status'	=> true,
		// 				'message'	=> 'Berhasil menghapus Admin',
		// 			], RestController::HTTP_OK);
		// 		} else {
		// 			$this->response([
		// 				'status'	=> false,
		// 				'message'	=> 'ID tidak ditemukan',
		// 			], RestController::HTTP_BAD_REQUEST);
		// 		}
		// 	}
		// }
	}
?>