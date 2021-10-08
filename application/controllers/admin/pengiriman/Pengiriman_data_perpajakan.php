<?php
	
	class Pengiriman_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('M_Pengiriman_perpajakan', 'M_Pengiriman');
			$this->load->model('M_Permintaan_perpajakan', 'M_Permintaan');
			$this->load->model('Jenis_data_model');
			$this->load->model('Klien_model');
		}
		
		public function index() {
			$data['judul']	= "Pengiriman Data Perpajakan";
			$data['masa']	= Globals::bulan();
			$data['klien']	= $this->Klien_model->getAllKlien();
			
			$this->libtemplate->main('admin/pengiriman_perpajakan/tampil', $data);
		}
		
		public function page() {
			$klien	= $_REQUEST['klien'];		$this->session->set_flashdata('klien', $klien);
			$bulan	= $_REQUEST['bulan'];		$this->session->set_userdata('bulan', $bulan);
			$tahun	= $_REQUEST['tahun'];		$this->session->set_userdata('tahun', $tahun);
			
			$limit		= $_REQUEST['length'];
			$offset		= $_REQUEST['start'];
			$klien		= ($klien == null) ? 'all' : $klien;
			$countData	= $this->M_Pengiriman->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($pengiriman as $k) {
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['id_permintaan'];
				$row[]	= $k['request'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $k['nama'];
				$row[]	= '
					<a class="btn-detail" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Pengiriman">
						<i class="bi bi-info-circle-fill icon-medium"></i>
					</a>';
					
				$data[] = $row;
			}
			
			$callback	= [
				'draw'				=> $_REQUEST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=> $countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
		
		public function detail() {
			$id_permintaan	= $_REQUEST['id'];
			$permintaan		= $this->M_Permintaan->getById($id_permintaan);
			$isi			= $this->M_Permintaan->getDetail($id_permintaan);
			
			foreach($isi as $i => $val) {
				if($val['status_kirim'] == 'yes') {
					$badge	= '<span class="badge badge-success">Lengkap</span>';
				} elseif($val['status_kirim'] == 'no') {
					$badge	= '<span class="badge badge-warning">Belum Lengkap</span>';
				} else {
					$badge	= '<span class="badge badge-danger">Belum Dikirim</span>';
				}
				$add[$i] = $badge;
			}
			$data['judul']		= 'Detail Pengiriman';
			$data['permintaan']	= $permintaan;
			$data['detail']		= $isi;
			$data['badge']		= $add;
			$data['link']		= 'admin/pengiriman/pengiriman_data_perpajakan/detail/';
			
			$this->load->view('admin/pengiriman_perpajakan/detail', $data);
		}
		
		public function rincian($id_data) {
			$detail			= $this->M_Pengiriman->getById($id_data);
			$pengiriman		= $this->M_Pengiriman->getDetail($id_data);
			
			if($detail['status_kirim'] == 'yes') {
				$detail['badge'] = '<span class="badge badge-success">Lengkap</span>';
			} elseif($detail['status_kirim'] == 'no') {
				$detail['badge'] = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$detail['badge'] = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			
			$button = '';
			if(count($pengiriman) > 0) {
				if($detail['status_kirim'] != 'yes') {
					$button = '<a href="#" class="btn btn-sm btn-primary btn-konfirm" data-id="'.$detail['id_data'].'" data-status="yes" data-toggle="tooltip" data-placement="bottom" title="Konfirmasi kelengkapan data">Konfirmasi</a>';
				} else {
					$button = '<a href="#" class="btn btn-sm btn-danger btn-konfirm" data-id="'.$detail['id_data'].'" data-status="no" data-toggle="tooltip" data-placement="bottom" title="Batalkan konfirmasi">Batal Konfirmasi</a>';
				}
			}
			$detail['button']	= $button;
			
			$data['judul']		= "Detail Pengiriman"; 
			$data['detail']		= $detail;
			$data['pengiriman']	= $pengiriman;
			$data['link']		= "asset/uploads/".$detail['nama_klien']."/".$detail['tahun']."/";
			
			$this->libtemplate->main('admin/pengiriman_perpajakan/rincian', $data);
		}
		
		public function download() {
			$klien		= $_GET['k'];
			$year		= $_GET['y'];
			$fileName	= str_replace('%20', ' ', $_GET['f']);
			$fileDir	= 'asset/download/';
			$existance	= false;
			
			$this->M_Pengiriman->download($klien, $year, $fileName);
			if( is_dir($fileDir) ) {
				$handle = opendir($fileDir);
				while( ($fileExist = readdir($handle) !== false	)){ // Looping isi file pada directory
					if($fileExist == $fileName)
						$existance = true;
				}
			}
			
			if( $existance == true ){ // file does not exist
				$ext = pathinfo($fileName, PATHINFO_EXTENSION);
				header("Cache-Control: public");
				header("Content-Description: File Transfer");
				header("Content-Disposition: attachment; filename=$fileName");
				header("Content-Type: application/".$ext);
				header("Content-Transfer-Encoding: binary");
				// read the file from disk
				readfile($fileName);
				unlink('asset/download/'.$fileName);
			} else {
				die('file not found');
			}
		}
		
		// public function konfirmasi() {
		// 	$id		= $_REQUEST['id'];
		// 	$status	= $_REQUEST['status'];
			
		// 	if($status == 'yes') {
		// 		$data['judul']	= 'Konfirmasi';
		// 		$data['text']	= 'Apakah data sudah lengkap?';
		// 		$data['button']	= '<a href="#" class="btn btn-success btn-fix" data-id="'.$id.'" data-status="'.$status.'">Lengkap</a>';
		// 	} else {
		// 		$data['judul']	= 'Batal Konfirmasi';
		// 		$data['text']	= 'Batalkan konfirmasi data?';
		// 		$data['button']	= '<a href="#" class="btn btn-primary btn-fix" data-id="'.$id.'" data-status="'.$status.'">Batalkan</a>';
		// 	}
		// 	$this->load->view('admin/template/confirm', $data);
		// }
		
		// public function fix() {
		// 	$this->M_Pengiriman->konfirmasi($_REQUEST['id'], $_REQUEST['stat']);
		// 	$msg = $_REQUEST['stat'] == 'yes' ? 'Data berhasil dikonfirmasi!' : 'Konfirmasi berhasil dibatalkan!';
		// 	$this->session->set_flashdata('notification', $msg);
		// }
	}
?>