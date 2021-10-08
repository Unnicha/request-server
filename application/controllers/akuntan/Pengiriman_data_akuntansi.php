<?php
	
	class Pengiriman_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
<<<<<<< HEAD
			
			$this->load->model('M_Permintaan_akuntansi', 'M_Permintaan');
			$this->load->model('M_Pengiriman_akuntansi', 'M_Pengiriman');
=======
			$this->load->library('exportpengiriman');
			
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('M_Pengiriman_akuntansi');
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('Jenis_data_model');
		}
		
		public function index() {
			$data['judul']	= "Pengiriman Data Akuntansi";
<<<<<<< HEAD
			$data['masa']	= Globals::bulan();
=======
			$data['masa']	= $this->Klien_model->getMasa();
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			
			$this->libtemplate->main('akuntan/pengiriman_akuntansi/tampil', $data);
		}
		
		public function page() {
			$klien	= $_POST['klien'];		$this->session->set_flashdata('klien', $klien);
			$tahun	= $_POST['tahun'];		$this->session->set_userdata('tahun', $tahun);
			$bulan	= $_POST['bulan'];		$this->session->set_userdata('bulan', $bulan);
			
			// jika tidak ada klien dipilih, tampilkan data klien berdasarkan akses
			if($klien == null) {
				$klien	= [];
				$id		= $this->session->userdata('id_user');
				$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan, $id, 'akuntansi');
				$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $id, 'akuntansi');
				if( $akses ) {
					foreach($akses as $a) {
						$klien[] = $a['kode_klien'];
					}
				} else $klien = null;
			}
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
<<<<<<< HEAD
			$countData	= $this->M_Pengiriman->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($pengiriman as $val) {
				$detail	= $this->M_Permintaan->countDetail($val['id_permintaan']);
=======
			$countData	= $this->M_Pengiriman_akuntansi->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_akuntansi->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($pengiriman as $val) {
				$detail	= $this->M_Permintaan_akuntansi->countDetail($val['id_permintaan']);
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
				$badge	= '';
				if($detail['jumYes'] > 0)
					$badge .= '<span class="badge badge-success mr-1" data-toggle="tooltip" data-placement="bottom" title="Lengkap">'.$detail['jumYes'].'</span>';
				if($detail['jumNo'] > 0)
					$badge .= '<span class="badge badge-warning mr-1" data-toggle="tooltip" data-placement="bottom" title="Belum Lengkap">'.$detail['jumNo'].'</span>';
				if($detail['jumNull'] > 0)
					$badge .= '<span class="badge badge-danger mr-1" data-toggle="tooltip" data-placement="bottom" title="Belum Dikirim">'.$detail['jumNull'].'</span>';
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $val['nama_klien'];
				$row[]	= $val['id_permintaan'];
				$row[]	= $val['request'];
				$row[]	= $val['tanggal_permintaan'];
				$row[]	= $detail['jumAll'];
				$row[]	= $badge;
				$row[]	= '
					<a class="btn-detail" data-toggle="tooltip" data-nilai="'.$val['id_permintaan'].'" data-placement="bottom" title="Detail Pengiriman">
						<i class="bi bi-info-circle-fill" style="font-size:20px; line-height:80%"></i>
					</a>';
					
				$data[] = $row;
			}
			
			$callback = [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=> $countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
		
		public function klien() {
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$id_akuntan	= $this->session->userdata('id_user');
			
<<<<<<< HEAD
			$bulan	= Globals::bulan($bulan);
			$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan['id'], $id_akuntan, 'akuntansi');
			$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan['id'], $id_akuntan, 'akuntansi');
=======
			$bulan	= $this->Klien_model->getMasa($bulan)['id_bulan'];
			$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan, $id_akuntan, 'akuntansi');
			$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $id_akuntan, 'akuntansi');
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			
			$lists	= "<option value=''>--Tidak ada akses--</option>";
			if( $akses ) {
				$lists		= "<option value=''>--Semua Klien--</option>";
				foreach($akses as $a) {
					$lists .= "<option value='".$a['id_klien']."'>".$a['nama_klien']."</option>"; 
				}
			}
			echo $lists;
		}
		
		public function detail() {
			$id_permintaan	= $_REQUEST['id'];
<<<<<<< HEAD
			$permintaan		= $this->M_Permintaan->getById($id_permintaan);
			$isi			= $this->M_Permintaan->getDetail($id_permintaan);
=======
			$permintaan		= $this->M_Permintaan_akuntansi->getById($id_permintaan);
			$isi			= $this->M_Permintaan_akuntansi->getDetail($id_permintaan);
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			
			// tampilan bagde masing2 data(isi) berdasarkan status pengiriman
			foreach($isi as $i => $val) {
				if($val['status_kirim'] == 'yes') {
					$badge	= '<span class="badge badge-success">Lengkap</span>';
				} elseif($val['status_kirim'] == 'no') {
					$badge	= '<span class="badge badge-warning">Belum Lengkap</span>';
				} else {
					$badge	= '<span class="badge badge-danger">Belum Dikirim</span>';
				}
				// masukkan badge ke array
				$add[$i] = $badge;
			}
			
			$data['judul']		= 'Detail Pengiriman';
			$data['permintaan']	= $permintaan;
			$data['detail']		= $isi;
			$data['badge']		= $add;
			$data['link']		= 'akuntan/pengiriman_data_akuntansi/detail/';
			
			$this->load->view('akuntan/pengiriman_akuntansi/detail', $data);
		}
		
		public function detail_pengiriman($id_data) {
<<<<<<< HEAD
			$detail		= $this->M_Pengiriman->getById($id_data);
			$pengiriman	= $this->M_Pengiriman->getDetail($id_data);
=======
			$detail		= $this->M_Pengiriman_akuntansi->getById($id_data);
			$pengiriman	= $this->M_Pengiriman_akuntansi->getDetail($id_data);
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			
			// tampilan bagde berdasarkan status pengiriman
			if($detail['status_kirim'] == 'yes') {
				$detail['badge'] = '<span class="badge badge-success">Lengkap</span>';
			} elseif($detail['status_kirim'] == 'no') {
				$detail['badge'] = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$detail['badge'] = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			
			// tampilkan button berdasarkan status pengiriman
			$button = '';
			if(count($pengiriman)>0 && $detail['status_proses'] != 'done') {
				if($detail['status_kirim'] != 'yes') {
<<<<<<< HEAD
					$button = '<a class="btn btn-sm btn-primary btn-konfirm float-md-right" data-id="'.$detail['id_data'].'" data-status="yes" data-toggle="tooltip" data-placement="bottom" title="Konfirmasi kelengkapan data">Konfirmasi</a>';
				} else {
					$button = '<a class="btn btn-sm btn-danger btn-konfirm float-md-right" data-id="'.$detail['id_data'].'" data-status="no" data-toggle="tooltip" data-placement="bottom" title="Batalkan konfirmasi">Batal Konfirmasi</a>';
=======
					$button = '<a href="#" class="btn btn-sm btn-primary btn-konfirm float-md-right" data-id="'.$detail['id_data'].'" data-status="yes" data-toggle="tooltip" data-placement="bottom" title="Konfirmasi kelengkapan data">Konfirmasi</a>';
				} else {
					$button = '<a href="#" class="btn btn-sm btn-danger btn-konfirm float-md-right" data-id="'.$detail['id_data'].'" data-status="no" data-toggle="tooltip" data-placement="bottom" title="Batalkan konfirmasi">Batal Konfirmasi</a>';
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
				}
			}
			
			$detail['button']	= $button;
			$data['judul']		= "Detail Pengiriman"; 
			$data['detail']		= $detail;
			$data['pengiriman']	= $pengiriman;
			$data['link']		= "asset/uploads/".$detail['nama_klien']."/".$detail['tahun']."/";
			
			$this->libtemplate->main('akuntan/pengiriman_akuntansi/rincian', $data);
		}
		
<<<<<<< HEAD
		public function export() {
			$klien	= $_REQUEST['klien'];
			$bulan	= $_REQUEST['bulan'];
			$tahun	= $_REQUEST['tahun'];
			
			if($klien == null) {
				$klien	= [];
				$id		= $this->session->userdata('id_user');
				$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan, $id, 'akuntansi');
				$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $id, 'akuntansi');
				if( $akses ) {
					foreach($akses as $a) {
						$klien[] = $a['kode_klien'];
					}
				} else $klien = null;
			}
			$result	= $this->M_Pengiriman->getByMasa($bulan, $tahun, $klien);
			echo json_encode($result);
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
		
=======
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
		public function konfirmasi() {
			$id		= $_POST['id'];
			$status	= $_POST['status'];
			
			if($status == 'yes') {
				$data['judul']	= 'Konfirmasi';
				$data['text']	= 'Apakah data sudah lengkap?';
<<<<<<< HEAD
				$data['button']	= '<a class="btn btn-success btn-fix" data-id="'.$id.'" data-status="'.$status.'">Lengkap</a>';
			} else {
				$data['judul']	= 'Batal Konfirmasi';
				$data['text']	= 'Batalkan konfirmasi data?';
				$data['button']	= '<a class="btn btn-primary btn-fix" data-id="'.$id.'" data-status="'.$status.'">Batalkan</a>';
=======
				$data['button']	= '<a href="#" class="btn btn-success btn-fix" data-id="'.$id.'" data-status="'.$status.'">Lengkap</a>';
			} else {
				$data['judul']	= 'Batal Konfirmasi';
				$data['text']	= 'Batalkan konfirmasi data?';
				$data['button']	= '<a href="#" class="btn btn-primary btn-fix" data-id="'.$id.'" data-status="'.$status.'">Batalkan</a>';
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			}
			$this->load->view('akuntan/pengiriman_akuntansi/konfirmasi', $data);
		}
		
		public function fix() {
<<<<<<< HEAD
			$this->M_Pengiriman->konfirmasi($_POST['id'], $_POST['stat']);
			$msg = ($_POST['stat'] == 'yes') ? 'Data berhasil dikonfirmasi!' : 'Konfirmasi berhasil dibatalkan!';
=======
			$this->M_Pengiriman_akuntansi->konfirmasi($_POST['id'], $_POST['stat']);
			$msg = $_POST['stat'] == 'yes' ? 'Data berhasil dikonfirmasi!' : 'Konfirmasi berhasil dibatalkan!';
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			$this->session->set_flashdata('notification', $msg);
		}
	}
?>