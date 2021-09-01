<?php
	
	class Pengiriman_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('exportpengiriman');
			
			$this->load->model('M_Pengiriman_perpajakan');
			$this->load->model('M_Permintaan_perpajakan');
			$this->load->model('Jenis_data_model');
			$this->load->model('Klien_model');
		}
		
		public function index() {
			$data['judul']	= "Pengiriman Data Perpajakan";
			$data['masa']	= $this->Klien_model->getMasa();
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
			$countData	= $this->M_Pengiriman_perpajakan->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_perpajakan->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
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
			$permintaan		= $this->M_Permintaan_perpajakan->getById($id_permintaan);
			$isi			= $this->M_Permintaan_perpajakan->getDetail($id_permintaan);
			
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
			$detail			= $this->M_Pengiriman_perpajakan->getById($id_data);
			$pengiriman		= $this->M_Pengiriman_perpajakan->getDetail($id_data);
			
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
		// 	$this->M_Pengiriman_perpajakan->konfirmasi($_REQUEST['id'], $_REQUEST['stat']);
		// 	$msg = $_REQUEST['stat'] == 'yes' ? 'Data berhasil dikonfirmasi!' : 'Konfirmasi berhasil dibatalkan!';
		// 	$this->session->set_flashdata('notification', $msg);
		// }
		
		public function cetak() {
			$data['bulan']	= $this->input->post('bulan', true);
			$data['tahun']	= $this->input->post('tahun', true);
			$data['klien']	= $this->input->post('klien', true);
			
			$data['filename']	= "Permintaan Data Perpajakan ".$data['bulan']." ".$data['tahun'];
			$data['judul']		= "Permintaan Data Perpajakan";
			$data['klien']		= $this->Klien_model->getAllKlien();
			foreach($data['klien'] as $k) {
				$perklien	= $this->M_Permintaan_perpajakan->getReqByKlien($data['bulan'], $data['tahun'], $k['id_klien']);
				$permintaan[$k['id_klien']] = $perklien;
			}
			$data['permintaan'] = $permintaan;
			
			if($this->input->post('xls', true))
				return $this->exportpengiriman->exportExcel($data);
			elseif($this->input->post('pdf', true))
				return $this->exportpengiriman->exportPdf($data);
		}
	}
?>