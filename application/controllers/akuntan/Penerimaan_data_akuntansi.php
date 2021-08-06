<?php
	
	class Penerimaan_data_akuntansi extends CI_Controller {
		
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
			$data['judul']	= "Penerimaan Data Akuntansi";
			$data['masa']	= $this->Klien_model->getMasa();
			
			$this->libtemplate->main('akuntan/penerimaan_akuntansi/tampil', $data);
		}
		
		public function page() {
			$klien	= $_POST['klien'];		$this->session->set_flashdata('klien', $klien);
			$tahun	= $_POST['tahun'];		$this->session->set_userdata('tahun', $tahun);
			$bulan	= $_POST['bulan'];		$this->session->set_userdata('bulan', $bulan);
			
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
					<a class="btn btn-sm btn-primary btn-detail_pengiriman" data-toggle="tooltip" data-nilai="'.$k['id_permintaan'].'" data-placement="bottom" title="Detail Pengiriman">
						<i class="bi bi-info-circle"></i>
					</a>';
					
				$data[] = $row;
			}
			$callback = [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=>$countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
		
		public function pageChild() {
			$id_permintaan	= $_GET['id'];
			$permintaan		= $this->M_Permintaan_akuntansi->getById($id_permintaan);
			$isi			= $this->M_Permintaan_akuntansi->getDetail($id_permintaan);
			
			foreach($isi as $i => $val) {
				if($val['status'] == 'yes') {
					$badge	= '<span class="badge badge-success">Lengkap</span>';
				} elseif($val['status'] == 'no') {
					$badge	= '<span class="badge badge-warning">Belum Lengkap</span>';
				} else {
					$badge	= '<span class="badge badge-danger">Belum Dikirim</span>';
				}
				$add[$i] = $badge;
			}
			$data['judul']		= 'Detail Permintaan';
			$data['permintaan']	= $permintaan;
			$data['isi']		= $isi;
			$data['badge']		= $add;
			
			$this->load->view('akuntan/penerimaan_akuntansi/rincian', $data);
		}
		
		public function klien() {
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$id_akuntan	= $this->session->userdata('id_user');
			
			$bulan		= $this->Klien_model->getMasa($bulan);
			$akses		= $this->Akses_model->getByAkuntan($tahun, $id_akuntan);
			if($bulan['id_bulan'] < $akses['masa']) {
				$akses = $this->Akses_model->getByAkuntan($tahun - 1, $id_akuntan);
			}
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
			echo $lists;
		}
		
		public function detail($id_data) {
			$detail		= $this->M_Pengiriman_akuntansi->getByIdData($id_data);
			$pengiriman	= $this->M_Pengiriman_akuntansi->getDetail($id_data);
			if($detail['status'] == 'yes') {
				$detail['badge'] = '<span class="badge badge-success">Lengkap</span>';
			} elseif($detail['status'] == 'no') {
				$detail['badge'] = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$detail['badge'] = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			
			$data['judul']		= "Detail Pengiriman"; 
			$data['detail']		= $detail;
			$data['pengiriman']	= $pengiriman;
			
			$this->libtemplate->main('akuntan/penerimaan_akuntansi/detail', $data);
		}
		
		public function batal() {
			$this->M_Pengiriman_akuntansi->konfirmasi($_POST['id'], 'no');
			$this->session->set_flashdata('notification', 'Konfirmasi berhasil dibatalkan!');
		}
		
		public function export() {
			$masa		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$id			= $this->input->post('klien', true);
			$akuntan	= $this->session->userdata('id_user');
			
			$bulan		= $this->Klien_model->getMasa($masa);
			$filename	= strtoupper(substr($bulan['nama_bulan'], 0, 3)).' '.substr($tahun, 2);
			$klien		= [];
			
			if($id == null) {
				$akses		= $this->Akses_model->getByAkuntan($tahun, $akuntan);
				if($akses) {
					if($masa < $akses['masa'])
					$akses	= $this->Akses_model->getByAkuntan(($tahun - 1), $akuntan);
				}
				if($akses) {
					$filename	= $filename.' '.$akses['nama'];
					$klien		= explode(',', $akses['akuntansi']);
					//implode(',', $klien);
				}
			} else {
				$klien = [$id];
			}
			
			$isi = 0;
			foreach($klien as $id) {
				$pengiriman[$id]	= $this->M_Pengiriman_akuntansi->getAllPengiriman($masa, $tahun, $id);
				if($pengiriman[$id]) {
					$isi = 1;
					foreach($pengiriman[$id] as $p) {
						$datas		= $this->M_Pengiriman_akutansi->getDetail($p['id_permintaan']);
						$p['child']	= $datas;
					}
				}
			}
			if($isi == 1) {
				$data['masa'] = [
					'bulan'	=> $bulan['nama_bulan'],
					'tahun'	=> $tahun,
				];
				$data['pengiriman']	= $pengiriman;
				$data['now']		= date('d/m/Y H:i');
				$data['filename']	= 'Pengiriman Data Akuntansi '.$filename;
				$data['judul']		= 'Pengiriman Data Akuntansi';
				
				if($_POST['export'] == 'xls') {
					return $this->exportpengiriman->exportExcel($data);
				}
				elseif($_POST['export'] == 'pdf') {
					return $this->exportpengiriman->exportPdf($data);
				}
			} else {
				$this->session->set_flashdata('warning', 'Tidak ada pengiriman data!');
				redirect('akuntan/penerimaan_data_akuntansi');
			}
		}
	}
?>