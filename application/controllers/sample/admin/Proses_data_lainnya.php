<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->library('exportproses');
			
			$this->load->model('M_Proses_lainnya');
			$this->load->model('M_Pengiriman_lainnya');
			$this->load->model('Klien_model');
			$this->load->model('Akuntan_model');
			$this->load->model('Akses_model');
		} 
		 
		public function index() {
			
			$data['judul'] = "Proses Data Lainnya"; 
			$this->libtemplate->main('admin/proses_lainnya/tampil', $data);
		}
		
		public function proses() {
			
			$data['header']		= "Proses Data Lainnya";
			$data['sub_header']	= "Daftar proses data yang sedang berjalan";
			$data['masa']		= $this->M_Proses_lainnya->masa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('admin/proses_lainnya/view/onproses', $data);
		}
		
		public function proses2() {
			
			$data['header']		= "Proses Data Lainnya";
			$data['sub_header']	= "Daftar proses data yang sedang berjalan";
			$data['masa']		= $this->M_Proses_lainnya->masa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('admin/proses_lainnya/view_tab', $data);
		}
		
		public function prosesBelum() {
			
			$data['header']		= "Proses Data Lainnya";
			$data['sub_header']	= "Daftar data yang belum diproses";
			$data['masa']		= $this->M_Proses_lainnya->masa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('admin/proses_lainnya/view/belum', $data);
		}
		
		public function prosesSelesai() {
			
			$data['header']		= "Proses Data Lainnya";
			$data['sub_header']	= "Daftar data yang sudah selesai diproses";
			$data['masa']		= $this->M_Proses_lainnya->masa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('admin/proses_lainnya/view/selesai', $data);
		}
		
		public function ganti_tampil() {
			
			$jenis = $_POST['jenis'];
			$lists = $this->proses_admin->ganti_jenis($jenis);
			
			echo $lists; 
		}
		
		public function ganti() {
			
			$bulan = $_REQUEST['bulan'];
			$tahun = $_REQUEST['tahun'];
			$jenis = $_REQUEST['jenis']; // jenis tampilan(per klien/per akuntan)
			$klien = $_REQUEST['klien']; // bisa berupa id_klien atau id_akuntan, tergantung jenis
				
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);
			$this->session->set_flashdata('jenis', $jenis);
			
			$pengiriman	= $this->M_Pengiriman_lainnya->getPerMasa($bulan, $tahun);
			$proses		= $this->M_Proses_lainnya->getPerMasaTahun($bulan, $tahun);
			
			// tampil berdasarkan tab yang sedang aktif
			$status = $this->session->userdata('status'); 
			if($status == 'belum') {
				$proses = $this->M_Proses_lainnya->getBelum($bulan, $tahun);
				// tampilkan berdasarkan jenis tampilan(per klien/per akuntan)
				if($jenis == "Akuntan") {
					$akses = $this->Akses_model->getByAkuntanMasa($klien, $bulan, $tahun);
					if($akses != null) { 
						$proses_belum = [];
						// ambil pengiriman dan proses sesuai id_klien yang bisa diakses akuntan
						$id_klien = explode(",", $akses['klien']);
						foreach($id_klien as $a) {
							foreach($proses as $b => $val) {
								if($val['id_klien'] == $a) {
									array_push($proses_belum, $proses[$b]);
								}
							}
						}
						$proses = $proses_belum;
					}
				} else { 
					if($klien != null) 
						$proses = $this->M_Proses_lainnya->getByKlienBelum($bulan, $tahun, $klien);
				}

				if($proses == null) {
					$this->session->set_flashdata('empty', 'Belum ada pengiriman');
					$this->load->view('empty');
				} else {
					$data['proses'] = $proses;
					$this->load->view('admin/proses_lainnya/isi/belum', $data);
				}
			} 
			else {
				if($status == 'selesai') 
				$proses_selesai = $this->M_Proses_lainnya->getSelesai($bulan, $tahun);
				else
				$proses_selesai = $this->M_Proses_lainnya->getSedang($bulan, $tahun);
				
				if($klien != null) {
					$proses = [];
					if($jenis == 'Akuntan') {
						$akses = $this->Akses_model->getByKlien($klien, $bulan, $tahun);
						$id_klien = explode(",", $akses['klien']);
						foreach($id_klien as $id) {
							foreach($proses_selesai as $p => $val) {
								if($val['id_klien'] == $id)
									array_push($proses, $proses_selesai[$p]);
							}
						}
					}
					$data['proses'] = $proses;
				} else {
					$data['proses'] = $proses_selesai;
				}

				if($data['proses'] == null) {
					$this->session->set_flashdata('empty', 'Belum ada proses');
					$this->load->view('empty');
				} else {
					$redirect = "admin/proses_lainnya/isi/{$status}";
					$this->load->view($redirect, $data);
				}
			}
		}
		
		public function hitung_durasi() {
			$mulai		= $_REQUEST['mulai'];
			if(isset($_REQUEST['selesai'])) {
				$selesai	= $_REQUEST['selesai'];
				$durasi		= $this->proses_admin->durasi($mulai, $selesai);
			} else {
				$durasi		= $this->proses_admin->durasi($mulai);
			}
			echo $durasi;
		}

		public function download() {
			$bulan		= $_REQUEST['bulan'];
			$tahun		= $_REQUEST['tahun'];
			$get		= $_REQUEST['klien'];
			$tampil		= $_REQUEST['tampil'];
			$filename	= strtoupper($bulan).' '.$tahun;

			if($get == null) {
				$klien = $this->Klien_model->getAllKlien(); 
			} else {
				if($tampil == "Akuntan") {
					$akses = $this->Akses_model->getByAkuntanMasa($get, $bulan, $tahun);
					$getNew = explode(",", $akses['klien']);
					$filename = $filename.' '.$akses['nama'];
					foreach($getNew as $e) {
						$klien[] = $this->Klien_model->getById($e);
					}
				} else {
					$get		= $this->Klien_model->getById($get);
					$filename	= $filename.' '.$get['nama_klien'];
					$klien[]	= $get;
				}
			}

			$status = $this->session->userdata('status');
			foreach($klien as $k) {
				if($status == 'belum')
				$perklien = $this->M_Proses_lainnya->getByKlienBelum($bulan, $tahun, $k['id_klien']);
				elseif($status == 'selesai')
				$perklien = $this->M_Proses_lainnya->getByKlienSelesai($bulan, $tahun, $k['id_klien']);
				else
				$perklien = $this->M_Proses_lainnya->getByKlienSedang($bulan, $tahun, $k['id_klien']);
				
				$proses[$k['id_klien']] = $perklien;
			}

			$data['proses']		= $proses;
			$data['bulan']		= $bulan;
			$data['tahun']		= $tahun;
			$data['klien']		= $klien;
			$data['now']		= date('d/m/Y H:i');
			$data['filename']	= 'Proses Data Lainnya '.$filename;
			$data['judul']		= "Proses Data Lainnya";
			
			if($status == 'belum')
			$data['subjudul']	= "Belum Diproses";
			elseif($status == 'selesai')
			$data['subjudul']	= "Selesai Diproses";
			else
			$data['subjudul']	= "Sedang Diproses";

			if(isset($_REQUEST['xls'])) {
				echo "xls";
				return $this->exportproses->exportExcel($data);
			}
			elseif(isset($_REQUEST['pdf']))
				return $this->exportproses->exportPdf($data);
		}
	}
?>