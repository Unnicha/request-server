<?php
	
	use chriskacerguis\RestServer\RestController;
	
	class Pengiriman_data_lainnya extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('M_Pengiriman_lainnya', 'M_Pengiriman');
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
				$result	= $this->M_Pengiriman->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			}
			elseif( $type == 'countAll' ) {
				$result	= $this->M_Pengiriman->countPengiriman($bulan, $tahun, $klien);
			}
			elseif( $type == 'byId' ) {
				$result	= $this->M_Pengiriman->getById($key);
			}
			elseif( $type == 'detail' ) {
				$result	= $this->M_Pengiriman->getDetail($key);
			}
			elseif( $type == 'countDetail' ) {
				$result	= $this->M_Pengiriman->countDetail($key);
			}
			
			// result
			$this->response( [
				'status'	=> true,
				'data'		=> $result,
			], RestController::HTTP_OK);
		}
		
		public function index_post() {
			$format = $this->post('format_data');
			if( empty($format) ) {
				$info	= [];
				$info	= json_decode($this->post('file_info'), true);
				$klien	= $info['klien'];
				
				// simpan file
				$fileData		= $_FILES['file_data'];
				$fileDir		= 'asset/uploads/'.$klien.'/'.date('Y').'/';
				$targetFile		= $fileDir . basename($fileData['name']);
				$extractFile	= pathinfo($targetFile); 
				if (!is_dir($fileDir)) {
					mkdir($fileDir, 0777, $rekursif = true);
				}
				
				$sameName	= 0;
				$handle		= opendir($fileDir);
				while(false !== ($file = readdir($handle))){
					if(strpos($file,$extractFile['filename']) !== false)
					$sameName++;
				}
				$newName = empty($sameName) ? $fileData['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];
				move_uploaded_file($fileData['tmp_name'], $fileDir.$newName);
				
				// simpan info file di database
				$data = [
					'file'			=> $newName,
					'keterangan'	=> $info['keterangan'],
					'kode_data'		=> $info['kode_data'],
				];
			} else {
				$data = [
					'format_data'	=> $this->post('format_data'),
					'file'			=> $this->post('file'),
					'keterangan'	=> $this->post('keterangan'),
					'kode_data'		=> $this->post('kode_data'),
				];
			}
			
			if ($this->M_Pengiriman->kirim( $data ) > 0) {
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
				'id_data'	=> $this->put('id_data'),
				'status'	=> $this->put('status'),
			];
			
			if ($this->M_Pengiriman->konfirmasi( $data ) > 0) {
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
		// 		$result = $this->M_Pengiriman->hapusPengiriman($id);
		// 		else
		// 		$result = $this->M_Pengiriman->hapusData($id);
				
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