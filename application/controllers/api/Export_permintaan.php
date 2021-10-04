<?php
	
	use chriskacerguis\RestServer\RestController;
	
	class Export_permintaan extends RestController {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('M_Export');
		}
		
		public function index_get() {
			$type		= $this->get('type');
			$bulan		= $this->get('bulan');
			$tahun		= $this->get('tahun');
			$klien		= $this->get('klien');
			$kategori	= $this->get('kategori');
			$id_data	= $this->get('id_data');
			
			// menentukan fungsi yang akan dipanggil di model
			if( $type == 'all' || $type == '' ) {
				$result	= $this->M_Export->getPermintaan($tahun, $bulan, $klien, $kategori);
			}
			elseif( $type == 'count' ) {
				$result	= $this->M_Export->countPermintaan($tahun, $bulan, $klien, $kategori);
			}
			elseif( $type == 'lastSend' ) {
				$result	= $this->M_Export->maxPengiriman($id_data, $kategori);
			}
			
			// result
			$this->response( [
				'status'	=> true,
				'data'		=> $result,
			], RestController::HTTP_OK);
		}
	}
?>