<?php
	
	class Permintaan_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_akuntansi', 'M_Permintaan');
			$this->load->model('M_Pengiriman_akuntansi', 'M_Pengiriman');
			$this->load->model('Klien_model');
			$this->load->model('Jenis_data_model');
		} 
		
		public function index() {
			$data['judul']	= "Permintaan Data Akuntansi";
			$data['masa']	= Globals::bulan();
			$this->libtemplate->main('klien/permintaan_akuntansi/tampil', $data);
		}
		
		public function page() {
			$tahun	= $_POST['tahun'];
			$bulan	= $_POST['bulan'];
			$klien	= $this->session->userdata('id_user');
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Permintaan->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($permintaan as $k) {
				$detail	= $this->M_Permintaan->countDetail($k['id_permintaan']);
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
			$permintaan	= $this->M_Permintaan->getById($id);
			$isi		= $this->M_Permintaan->getDetail($id);
			
			foreach($isi as $i => $val) {
				$add[$i] = $this->badge($val['status_kirim']);
			}
			$data['judul']		= 'Detail Permintaan';
			$data['permintaan']	= $permintaan;
			$data['detail']		= $isi;
			$data['badge']		= $add;
			$data['link']		= 'klien/permintaan_data_akuntansi/kirim/';
			
			$this->load->view('klien/permintaan_akuntansi/detail', $data);
		}
		
		public function pilih() {
			$isi = $this->M_Permintaan->getDetail($_REQUEST['id']);
			foreach($isi as $i => $val) {
				$add[$i] = $this->badge($val['status_kirim']);
			}
			
			$data['judul']		= 'Pilih Data';
			$data['detail']		= $isi;
			$data['badge']		= $add;
			$data['link']		= 'klien/permintaan_data_akuntansi/kirim/';
			
			$this->load->view('klien/permintaan_akuntansi/data', $data);
		}
		
		public function kirim($id_data) {
			$detail		= $this->M_Pengiriman->getById($id_data);
			$pengiriman	= $this->M_Pengiriman->getDetail($id_data);
			
			$detail['badge']	= $this->badge($detail['status_kirim']);
			$data['judul']		= "Kirim Data";
			$data['detail']		= $detail;
			$data['pengiriman']	= $pengiriman;
			$data['back']		= 'klien/permintaan_data_akuntansi';
			
			$this->form_validation->set_rules('id_data', 'ID Data', 'required');
			if($detail['format_data'] == 'Hardcopy') {
				$this->form_validation->set_rules('tanggal_ambil', 'Tanggal Ambil', 'required');
			}
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_akuntansi/kirim', $data);
			} else {
				$send = $this->M_Pengiriman->kirim();
				if($send == false) {
					$this->session->set_flashdata('flash', 'Format file tidak sesuai!');
				} elseif($send == true) {
					$this->session->set_flashdata('notification', 'Data berhasil dikirim!');
				}
				redirect('klien/permintaan_data_akuntansi/kirim/'.$id_data);
			}
		}
		
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
	}
?>