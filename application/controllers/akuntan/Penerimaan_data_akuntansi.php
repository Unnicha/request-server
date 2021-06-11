<?php
	
	class Penerimaan_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('Jenis_data_model');
		}
		
		public function index() {
			
			$data['judul']	= "Penerimaan Data Akuntansi";
			$data['masa']	= $this->Klien_model->getMasa();
			$data['klien']	= $this->Klien_model->getAllKlien();
			$data['lokasi']	= "asset/uploads/";
			
			$this->libtemplate->main('akuntan/penerimaan_akuntansi/tampil', $data);
		}
		
		public function page() {
			$klien	= $_POST['klien'];
			$bulan	= $_POST['bulan'];
			$tahun	= $_POST['tahun'];
			$this->session->set_flashdata('klien', $klien);
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			
			if($klien == null) {
				$id_akuntan	= $this->session->userdata('id_user');
				$masa		= $this->Klien_model->getMasa($bulan);
				$akses		= $this->Akses_model->getByAkuntan($tahun, $id_akuntan);
				if( $akses ) {
					if($masa['id_bulan'] < $akses['masa']) {
						$akses = $this->Akses_model->getByAkuntan(($tahun-1), $id_akuntan);
					}
					if( $akses ) {
						$klien = explode(',', $akses['klien']);
					}
				}
			}
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Pengiriman_akuntansi->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_akuntansi->getByMasa($bulan, $tahun, $klien, $offset, $limit);

			$data = [];
			foreach($pengiriman as $k) {
				$status	= explode('|', $k['status']);
				$badge	= '';
				if(in_array('belum', $status)) {
					//$badge .= '<span class="badge badge-warning">Belum Dikonfirmasi</span><br>';
					$badge .= '<i class="bi bi-exclamation-diamond-fill icon-status mr-1" style="color:#ffc107" data-toggle="tooltip" data-placement="bottom" title="Belum Dikonfirmasi"></i>';
				} if(in_array('kurang', $status)) {
					//$badge .= '<span class="badge badge-danger">Kurang Lengkap</span><br>';
					$badge .= '<i class="bi bi-x-octagon-fill icon-status mr-1" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Kurang Lengkap"></i>';
				} if(in_array('lengkap', $status)) {
					//$badge .= '<span class="badge badge-success">Lengkap</span>';
					$badge .= '<i class="bi bi-check-circle-fill icon-status mr-1" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Lengkap"></i>';
				}
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['request'];
				$row[]	= sprintf("%02s", $k['pembetulan'] + 1);
				$row[]	= $k['tanggal_pengiriman'];
				$row[]	= $badge;
				$row[]	= '
					<a class="btn btn-sm btn-primary btn-detail_pengiriman" data-toggle="tooltip" data-nilai="'.$k['id_pengiriman'].'" data-placement="bottom" title="Detail Pengiriman">
						<i class="bi bi-info-circle"></i>
					</a>';
					
				$data[] = $row;
			}
			$callback	= [
				'draw'			=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'	=> $countData,
				'recordsFiltered'=>$countData,
				'data'			=> $data,
			];
			echo json_encode($callback);
		}
		
		public function klien() {
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$id_akuntan	= $this->session->userdata('id_user');
			
			$bulan		= $this->Klien_model->getMasa($bulan);
			$akses		= $this->Akses_model->getByAkuntan($tahun, $id_akuntan);
			if($bulan['id_bulan'] < ((int)$akses['masa'])) {
				$akses = $this->Akses_model->getByAkuntan($tahun - 1, $id_akuntan);
			}
			if($akses == null) {
				$lists = "<option value=''>--Tidak ada akses--</option>";
			} else {
				$lists		= "<option value=''>Semua Klien</option>";
				$id_klien	= explode(",", $akses['klien']);
				foreach($id_klien as $id) {
					$klien	= $this->Klien_model->getById($id);
					$lists .= "<option value='".$klien['id_klien']."'>".$klien['nama_klien']."</option>"; 
				} 
			}
			echo $lists;
		}
		
		public function konfirmasi($id_pengiriman) {
			$pengiriman		= $this->M_Pengiriman_akuntansi->getById($id_pengiriman);
			$kode_jenis		= explode('|', $pengiriman['kode_jenis']);
			implode(',', $kode_jenis);
			
			$data['judul']			= "Konfirmasi - Data Akuntansi"; 
			$data['id_pengiriman']	= $pengiriman['id_pengiriman'];
			$data['lokasi']			= 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/'; 
			$data['jenis_data']		= $this->Jenis_data_model->getForDetail($kode_jenis);
			$data['format_data']	= explode('|', $pengiriman['format_data']);
			$data['detail']			= explode('|', $pengiriman['detail']);
			$data['file']			= explode('|', $pengiriman['file']);
			$data['status']			= explode('|', $pengiriman['status']);
			$data['keterangan']		= explode('|', $pengiriman['keterangan']);
			$data['jum_data']		= count($data['jenis_data']);
			
			$this->form_validation->set_rules('id_pengiriman', 'ID Pengiriman', 'required');
			$this->form_validation->set_rules('status[]', 'Status', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/penerimaan_akuntansi/konfirmasi', $data);
			} else {
				$this->M_Pengiriman_akuntansi->konfirmasi();
				$this->session->set_flashdata('notification', 'Data berhasil dikonfirmasi!');
				redirect('akuntan/penerimaan_data_akuntansi');
			}
		}
		
		public function detail() {
			$id_pengiriman	= $this->input->post('action', true);
			$pengiriman		= $this->M_Pengiriman_akuntansi->getById($id_pengiriman);
			$bulan			= $this->Klien_model->getMasa($pengiriman['bulan']);
			$kode_jenis		= explode('|', $pengiriman['kode_jenis']);
			implode(',', $kode_jenis);

			//path folder penyimpanan data
			$data['lokasi']			= 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/'; 
			$data['judul']			= 'Detail Pengiriman Data';
			$data['pengiriman']		= $pengiriman;
			$data['bulan']			= $bulan['nama_bulan'];
			$data['jenis_data']		= $this->Jenis_data_model->getForDetail($kode_jenis);
			$data['format_data']	= explode('|', $pengiriman['format_data']);
			$data['detail']			= explode('|', $pengiriman['detail']);
			$data['file']			= explode('|', $pengiriman['file']);
			$data['keterangan']		= explode('|', $pengiriman['keterangan']);
			$data['status']			= ($pengiriman['status']) ? explode('|', $pengiriman['status']) : $pengiriman['status'];
			$data['jum_data']		= count($data['jenis_data']);
			$data['lengkap']		= (empty($data['status']) || in_array('belum', $data['status'])) ? false : true;
			
			$this->load->view('akuntan/penerimaan_akuntansi/detail', $data);
		}
	}
?>