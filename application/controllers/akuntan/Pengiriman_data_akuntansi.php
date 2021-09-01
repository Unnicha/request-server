<?php
	
	class Pengiriman_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('exportpengiriman');
			
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('Jenis_data_model');
		}
		
		public function index() {
			$data['judul']	= "Pengiriman Data Akuntansi";
			$data['masa']	= $this->Klien_model->getMasa();
			
			$this->libtemplate->main('akuntan/pengiriman_akuntansi/tampil', $data);
		}
		
		public function page() {
			$klien	= $_POST['klien'];		$this->session->set_flashdata('klien', $klien);
			$tahun	= $_POST['tahun'];		$this->session->set_userdata('tahun', $tahun);
			$bulan	= $_POST['bulan'];		$this->session->set_userdata('bulan', $bulan);
			
			// jika tidak ada klien dipilih, tampilkan data klien berdasarkan akses
			if($klien == null) {
				$id_akuntan	= $this->session->userdata('id_user');
				$masa		= $this->Klien_model->getMasa($bulan);
				$akses		= $this->Akses_model->getByAkuntan($tahun, $id_akuntan);
				if( $akses ) {
					if($masa['id_bulan'] < $akses['masa']) {
						$akses = $this->Akses_model->getByAkuntan(($tahun-1), $id_akuntan);
					}
					if( $akses ) {
						$klien = explode(',', $akses['akuntansi']);
					}
				}
			}
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Pengiriman_akuntansi->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_akuntansi->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			$countDetail= $this->M_Pengiriman_akuntansi->countDetail();
			
			$data = [];
			foreach($pengiriman as $k => $val) {
				$detail	= $countDetail[$k];
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
			$bulan		= $this->Klien_model->getMasa($bulan);
			$akses		= $this->Akses_model->getByAkuntan($tahun, $id_akuntan);
			
			// tampilkan akses berdasarkan bulan yang dipilih
			if($bulan['id_bulan'] < $akses['masa']) {
				$akses = $this->Akses_model->getByAkuntan($tahun - 1, $id_akuntan);
			}
			// select option berdasarkan ada/tidaknya akses
			if($akses == null) {
				$lists = "<option value=''>--Tidak ada akses--</option>";
			} else {
				$lists		= "<option value=''>Semua Klien</option>";
				$id_klien	= explode(",", $akses['akuntansi']);
				foreach($id_klien as $id) {
					$klien	= $this->Klien_model->getById($id);
					$lists .= "<option value='".$klien['id_klien']."'>".$klien['nama_klien']."</option>"; 
				}
			}
			// return list option
			echo $lists;
		}
		
		public function detail() {
			$id_permintaan	= $_REQUEST['id'];
			$permintaan		= $this->M_Permintaan_akuntansi->getById($id_permintaan);
			$isi			= $this->M_Permintaan_akuntansi->getDetail($id_permintaan);
			
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
			$detail		= $this->M_Pengiriman_akuntansi->getById($id_data);
			$pengiriman	= $this->M_Pengiriman_akuntansi->getDetail($id_data);
			
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
			if(count($pengiriman) > 0) {
				if($detail['status_kirim'] != 'yes') {
					$button = '<a href="#" class="btn btn-sm btn-primary btn-konfirm float-md-right" data-id="'.$detail['id_data'].'" data-status="yes" data-toggle="tooltip" data-placement="bottom" title="Konfirmasi kelengkapan data">Konfirmasi</a>';
				} else {
					$button = '<a href="#" class="btn btn-sm btn-danger btn-konfirm float-md-right" data-id="'.$detail['id_data'].'" data-status="no" data-toggle="tooltip" data-placement="bottom" title="Batalkan konfirmasi">Batal Konfirmasi</a>';
				}
			}
			
			$detail['button']	= $button;
			$data['judul']		= "Detail Pengiriman"; 
			$data['detail']		= $detail;
			$data['pengiriman']	= $pengiriman;
			$data['link']		= "asset/uploads/".$detail['nama_klien']."/".$detail['tahun']."/";
			
			$this->libtemplate->main('akuntan/pengiriman_akuntansi/rincian', $data);
		}
		
		public function konfirmasi() {
			$id		= $_POST['id'];
			$status	= $_POST['status'];
			
			if($status == 'yes') {
				$data['judul']	= 'Konfirmasi';
				$data['text']	= 'Apakah data sudah lengkap?';
				$data['button']	= '<a href="#" class="btn btn-success btn-fix" data-id="'.$id.'" data-status="'.$status.'">Lengkap</a>';
			} else {
				$data['judul']	= 'Batal Konfirmasi';
				$data['text']	= 'Batalkan konfirmasi data?';
				$data['button']	= '<a href="#" class="btn btn-primary btn-fix" data-id="'.$id.'" data-status="'.$status.'">Batalkan</a>';
			}
			$this->load->view('akuntan/pengiriman_akuntansi/konfirmasi', $data);
		}
		
		public function fix() {
			$this->M_Pengiriman_akuntansi->konfirmasi($_POST['id'], $_POST['stat']);
			$msg = $_POST['stat'] == 'yes' ? 'Data berhasil dikonfirmasi!' : 'Konfirmasi berhasil dibatalkan!';
			$this->session->set_flashdata('notification', $msg);
		}
		
		// public function export() {
		// 	$masa		= $this->input->post('bulan', true);
		// 	$tahun		= $this->input->post('tahun', true);
		// 	$id			= $this->input->post('klien', true);
		// 	$akuntan	= $this->session->userdata('id_user');
			
		// 	$bulan		= $this->Klien_model->getMasa($masa);
		// 	$filename	= strtoupper(substr($bulan['nama_bulan'], 0, 3)).' '.substr($tahun, 2);
		// 	$klien		= [];
			
		// 	if($id == null) {
		// 		$akses		= $this->Akses_model->getByAkuntan($tahun, $akuntan);
		// 		if($akses) {
		// 			if($masa < $akses['masa'])
		// 			$akses	= $this->Akses_model->getByAkuntan(($tahun - 1), $akuntan);
		// 		}
		// 		if($akses) {
		// 			$filename	= $filename.' '.$akses['nama'];
		// 			$klien		= explode(',', $akses['akuntansi']);
		// 			//implode(',', $klien);
		// 		}
		// 	} else {
		// 		$klien = [$id];
		// 	}
			
		// 	$isi = 0;
		// 	foreach($klien as $id) {
		// 		$pengiriman[$id]	= $this->M_Pengiriman_akuntansi->getAllPengiriman($masa, $tahun, $id);
		// 		if($pengiriman[$id]) {
		// 			$isi = 1;
		// 			foreach($pengiriman[$id] as $p) {
		// 				$datas		= $this->M_Pengiriman_akuntansi->getDetail($p['id_permintaan']);
		// 				$p['child']	= $datas;
		// 			}
		// 		}
		// 	}
		// 	if($isi == 1) {
		// 		$data['masa'] = [
		// 			'bulan'	=> $bulan['nama_bulan'],
		// 			'tahun'	=> $tahun,
		// 		];
		// 		$data['pengiriman']	= $pengiriman;
		// 		$data['now']		= date('d/m/Y H:i');
		// 		$data['filename']	= 'Pengiriman Data Akuntansi '.$filename;
		// 		$data['judul']		= 'Pengiriman Data Akuntansi';
				
		// 		if($_POST['export'] == 'xls') {
		// 			return $this->exportpengiriman->exportExcel($data);
		// 		}
		// 		elseif($_POST['export'] == 'pdf') {
		// 			return $this->exportpengiriman->exportPdf($data);
		// 		}
		// 	} else {
		// 		$this->session->set_flashdata('warning', 'Tidak ada pengiriman data!');
		// 		redirect('akuntan/pengiriman_data_akuntansi');
		// 	}
		// }
	}
?>