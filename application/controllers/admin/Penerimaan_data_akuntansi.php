<?php
	
	class Penerimaan_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('exportpengiriman');
			
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('Klien_model');
		}
		
		public function index() {
			$data['judul']	= "Penerimaan Data Akuntansi";
			$data['klien']	= $this->Klien_model->getAllKlien();
			$data['masa']	= $this->Klien_model->getMasa();
			
			$this->libtemplate->main('admin/penerimaan_akuntansi/tampil', $data);
		}
		
		public function page() {
			$klien = $_POST['klien'];
			$bulan	= $_POST['bulan'];
			$tahun	= $_POST['tahun'];
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			if($klien == null) 
				{ $klien = 'all'; }
			$countData	= $this->M_Pengiriman_akuntansi->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_akuntansi->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($pengiriman as $k) {
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['jenis_data'];
				$row[]	= "Pengiriman ke-".($k['pembetulan'] + 1);
				$row[]	= $k['tanggal_pengiriman'];
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

		public function detail() {
			$id_pengiriman	= $this->input->post('action', true);
			$peng			= $this->M_Pengiriman_akuntansi->getById($id_pengiriman);

			$data['lokasi']	= "asset/uploads/".$peng['nama_klien']."/".$peng['tahun']."/".$peng['masa'];
			$data['judul']	= 'Detail Pengiriman Data';
			$data['pengiriman'] = $peng;
			
			if($peng['pembetulan'] == 0) {
				$this->load->view('admin/penerimaan_akuntansi/detail_pengiriman', $data);
			} else {
				$this->load->view('admin/penerimaan_akuntansi/detail_pembetulan', $data);
			}
		}
		
		public function cetak() {
			$data['bulan']	= $this->input->post('bulan', true);
			$data['tahun']	= $this->input->post('tahun', true);
			$data['klien']	= $this->input->post('klien', true);

			$data['filename']	= "Permintaan Data Akuntansi ".$data['bulan']." ".$data['tahun'];
			$data['judul']		= "Permintaan Data Akuntansi";
			$data['klien']		= $this->Klien_model->getAllKlien();
			foreach($data['klien'] as $k) {
				$perklien	= $this->M_Permintaan_akuntansi->getReqByKlien($data['bulan'], $data['tahun'], $k['id_klien']);
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