<?php
	
	class Permintaan_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_perpajakan', 'M_Permintaan');
			$this->load->model('M_Pengiriman_perpajakan', 'M_Pengiriman');
			$this->load->model('Klien_model');
			$this->load->model('Jenis_data_model');
		} 
		
		public function index() {
			$data['judul']	= "Permintaan Data Perpajakan";
			$data['masa']	= Globals::bulan();
			$this->libtemplate->main('klien/permintaan_perpajakan/tampil', $data);
		}
		
		public function page() {
			$tahun	= $_POST['tahun'];
			$bulan	= $_POST['bulan'];
			$klien	= $this->session->userdata('id_user');
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
<<<<<<< HEAD
			$countData	= $this->M_Permintaan->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($permintaan as $k) {
				$detail	= $this->M_Permintaan->countDetail($k['id_permintaan']);
=======
			$countData	= $this->M_Permintaan_perpajakan->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_perpajakan->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($permintaan as $k) {
				$detail	= $this->M_Permintaan_perpajakan->countDetail($k['id_permintaan']);
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
				$badge	= '';
				if($detail['jumYes'] > 0)
					$badge .= '<span class="badge badge-success mr-1" data-toggle="tooltip" data-placement="bottom" title="'.$detail['jumYes'].' Data Lengkap">'.$detail['jumYes'].'</span>';
				if($detail['jumNo'] > 0)
					$badge .= '<span class="badge badge-warning mr-1" data-toggle="tooltip" data-placement="bottom" title="'.$detail['jumNo'].' Data Belum Lengkap">'.$detail['jumNo'].'</span>';
				if($detail['jumNull'] > 0)
					$badge .= '<span class="badge badge-danger mr-1" data-toggle="tooltip" data-placement="bottom" title="'.$detail['jumNull'].' Data Belum Dikirim">'.$detail['jumNull'].'</span>';
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['id_permintaan'];
				$row[]	= $k['request'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $k['jumData'];
				$row[]	= $k['nama'];
				$row[]	= $badge;
				$row[]	= '
					<a class="btn-kirim" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Kirim Data">
						<i class="bi bi-cursor-fill icon-medium"></i>
					</a>
					<a class="btn-detail" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Detail">
						<i class="bi bi-info-circle-fill icon-medium"></i>
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
		
		public function detail() {
			$id			= $_REQUEST['id'];
<<<<<<< HEAD
			$permintaan	= $this->M_Permintaan->getById($id);
			$isi		= $this->M_Permintaan->getDetail($id);
			
			foreach($isi as $i => $val) {
				$add[$i] = $this->badge($val['status_kirim']);
=======
			$permintaan	= $this->M_Permintaan_perpajakan->getById($id);
			$isi		= $this->M_Permintaan_perpajakan->getDetail($id);
			
			foreach($isi as $i => $val) {
				if($val['status_kirim'] == 'yes') {
					$badge	= '<span class="badge badge-success">Lengkap</span>';
				} elseif($val['status_kirim'] == 'no') {
					$badge	= '<span class="badge badge-warning">Belum Lengkap</span>';
				} else {
					$badge	= '<span class="badge badge-danger">Belum Dikirim</span>';
				}
				$add[$i] = $badge;
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			}
			$data['judul']		= 'Detail Permintaan';
			$data['permintaan']	= $permintaan;
			$data['detail']		= $isi;
			$data['badge']		= $add;
			$data['link']		= 'klien/permintaan_data_perpajakan/kirim/';
			
			$this->load->view('klien/permintaan_perpajakan/detail', $data);
		}
		
		public function pilih() {
<<<<<<< HEAD
			$isi = $this->M_Permintaan->getDetail($_REQUEST['id']);
			foreach($isi as $i => $val) {
				$add[$i] = $this->badge($val['status_kirim']);
			}
			
=======
			$isi = $this->M_Permintaan_perpajakan->getDetail($_REQUEST['id']);
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
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			$data['judul']		= 'Pilih Data';
			$data['detail']		= $isi;
			$data['badge']		= $add;
			$data['link']		= 'klien/permintaan_data_perpajakan/kirim/';
			
			$this->load->view('klien/permintaan_perpajakan/data', $data);
		}
		
		public function kirim($id_data) {
<<<<<<< HEAD
			$detail		= $this->M_Pengiriman->getById($id_data);
			$pengiriman	= $this->M_Pengiriman->getDetail($id_data);
			
			$detail['badge']	= $this->badge($detail['status_kirim']);
			$data['judul']		= "Kirim Data";
			$data['detail']		= $detail;
			$data['pengiriman']	= $pengiriman;
=======
			$detail = $this->M_Pengiriman_perpajakan->getById($id_data);
			if($detail['status_kirim'] == 'yes') {
				$detail['badge'] = '<span class="badge badge-success">Lengkap</span>';
			} elseif($detail['status_kirim'] == 'no') {
				$detail['badge'] = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$detail['badge'] = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			
			$data['judul']		= "Kirim Data";
			$data['detail']		= $detail;
			$data['pengiriman']	= $this->M_Pengiriman_perpajakan->getDetail($id_data);
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			$data['back']		= 'klien/permintaan_data_perpajakan';
			
			$this->form_validation->set_rules('id_data', 'ID Data', 'required');
			if($detail['format_data'] == 'Hardcopy') {
				$this->form_validation->set_rules('tanggal_ambil', 'Tanggal Ambil', 'required');
			}
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_perpajakan/kirim', $data);
			} else {
<<<<<<< HEAD
				$send = $this->M_Pengiriman->kirim();
				if($send == false) {
					$this->session->set_flashdata('flash', 'Format file tidak sesuai!');
				} elseif($send == true) {
=======
				$send = $this->M_Pengiriman_perpajakan->kirim();
				if($send == 'ERROR') {
					$this->session->set_flashdata('flash', 'Format file tidak sesuai!');
				} elseif($send == 'OK') {
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
					$this->session->set_flashdata('notification', 'Data berhasil dikirim!');
				}
				redirect('klien/permintaan_data_perpajakan/kirim/'.$id_data);
			}
		}
<<<<<<< HEAD
		
		public function download() {
			$year		= $_GET['y'];
			$fileName	= str_replace('%20', ' ', $_GET['f']);
			$klien		= $this->session->userdata('id_user');
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
		
		public function badge($status) {
			if($status == 'yes') {
				$badge = '<span class="badge badge-success">Lengkap</span>';
			} elseif($status == 'no') {
				$badge = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$badge = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			return $badge;
		}
=======
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
	}
?>