<?php
	
	use chriskacerguis\RestServer\RestController;
	
	class Akses extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Akses_model');
		}
		
		public function index_get() {
			$type		= $this->get('type');
			$id			= $this->get('id');
			$bulan		= $this->get('bulan');
			$tahun		= $this->get('tahun');
			$offset		= $this->get('offset');
			$limit		= $this->get('limit');
			$kategori	= $this->get('kategori');
			
			// menentukan fungsi yang akan dipanggil di model
			if( $type == 'all' || $type == '' ) {
				$admin	= $this->Akses_model->getByTahun($offset, $limit, $tahun);
			} elseif( $type == 'count' ) {
				$admin	= $this->Akses_model->countAkses($tahun);
			} else {
				$admin	= $this->Akses_model->getBy($type, $id, $tahun, $bulan, $kategori);
			}
			
			// result
			$this->response( [
				'status'	=> true,
				'data'		=> $admin,
			], RestController::HTTP_OK);
		}
		
		public function index_post() {
			$data = [
				'kode_klien'	=> $this->post('kode_klien'),
				'masa'			=> $this->post('masa'),
				'tahun'			=> $this->post('tahun'),
				'akuntansi'		=> $this->post('akuntansi'),
				'perpajakan'	=> $this->post('perpajakan'),
				'lainnya'		=> $this->post('lainnya'),
			];
			
			if ($this->Akses_model->tambahAkses($data) > 0) {
				$this->response([
					'status' => true,
					'message' => 'Berhasil ditambahkan',
				], RestController::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Gagal ditambahkan',
				], RestController::HTTP_BAD_REQUEST);
			}
		}
		
		public function index_put() {
			$data = [
				'id_akses'		=> $this->put('id_akses'),
				'kode_klien'	=> $this->put('kode_klien'),
				'masa'			=> $this->put('masa'),
				'tahun'			=> $this->put('tahun'),
				'akuntansi'		=> $this->put('akuntansi'),
				'perpajakan'	=> $this->put('perpajakan'),
				'lainnya'		=> $this->put('lainnya'),
			];
			
			if ( $this->Akses_model->ubahAkses($data) > 0) {
				$this->response([
					'status' => true,
					'message' => 'Berhasil diupdate',
				], RestController::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Gagal diupdate',
				], RestController::HTTP_NOT_MODIFIED);
			}
		}
		
		public function index_delete() {
			$id = $this->delete('id_akses');
			if ($id == null) {
				$this->response([
					'status'	=> false,
					'message'	=> 'Berikan kode yang valid',
				], RestController::HTTP_BAD_REQUEST);
			} else {
				if ($this->Akses_model->hapusAkses($id) > 0) {
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