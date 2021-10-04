<?php
	
	class Penerimaan_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('exportpengiriman');
			
			$this->load->model('M_Pengiriman_perpajakan');
			$this->load->model('M_Permintaan_perpajakan');
			$this->load->model('Klien_model');
		}

		public function index() {
			
			$data['judul'] = "Penerimaan Data Perpajakan";
			$data['header'] ="Data Perpajakan";
			$data['sub_header'] = "Data yang telah diterima & Data yang harus diambil";

			$data['klien'] = $this->Klien_model->getAllKlien();
			$data['masa'] = $this->M_Pengiriman_perpajakan->masa();
			
			$this->libtemplate->main('admin/penerimaan_perpajakan/tampil', $data);
		}

		public function ganti() {
			
			$klien = $_POST['klien'];
			$bulan = $_POST['bulan'];
			$tahun = $_POST['tahun'];
				
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);
			
			if($klien == null) {
				$pengiriman = $this->M_Pengiriman_perpajakan->getPerMasa($bulan, $tahun);
			} else {
				$pengiriman = $this->M_Pengiriman_perpajakan->getPerKlien($bulan, $tahun, $klien);
			}

			//tidak menampilkan data yang sudah dikirim
			/*
			foreach($data['pengiriman'] as $b) {
				foreach($permintaan as $a => $key) {
					if ($key['id_permintaan'] == $b['id_permintaan']) {
						unset($permintaan[$a]);
					}
				}
			}
			*/
			$data['pengiriman'] = $pengiriman;

			if($pengiriman == null) {
				$this->session->set_flashdata('empty', 'Belum ada data');
				$this->load->view('empty');
			} else {
				$this->load->view('admin/penerimaan_perpajakan/isi', $data);
			}
		}

		public function detail() {
			$id_pengiriman = $_REQUEST['action'];
			$pengiriman = $this->M_Pengiriman_perpajakan->getById($id_pengiriman);

			$data['lokasi'] = "asset/uploads/{$pengiriman['nama_klien']}/{$pengiriman['tahun']}/{$pengiriman['masa']}";
			$data['judul'] = 'Detail Pengiriman Data';
			$data['pengiriman'] = $pengiriman;
			
			if($pengiriman['pembetulan'] == 0) {
				$this->load->view('admin/penerimaan_perpajakan/detail_pengiriman', $data);
			} else {
				$this->load->view('admin/penerimaan_perpajakan/detail_pembetulan', $data);
			}
		}

		public function cetak() {
			$data['bulan']	= $_REQUEST['bulan'];
			$data['tahun']	= $_REQUEST['tahun'];
			$data['klien']	= $_REQUEST['klien'];

			$data['filename']	= 'Permintaan Data Perpajakan '.$data['bulan'].' '.$data['tahun'];
			$data['judul']		= "Permintaan Data Perpajakan";
			$data['klien']		= $this->Klien_model->getAllKlien();
			foreach($data['klien'] as $k) {
				$perklien	= $this->M_Permintaan_perpajakan->getReqByKlien($data['bulan'], $data['tahun'], $k['id_klien']);
				$permintaan[$k['id_klien']] = $perklien;
			}
			$data['permintaan'] = $permintaan;

			if(isset($_REQUEST['xls']))
				return $this->exportpengiriman->exportExcel($data);
			elseif(isset($_REQUEST['pdf']))
				return $this->exportpengiriman->exportPdf($data);
		}
	}
?>