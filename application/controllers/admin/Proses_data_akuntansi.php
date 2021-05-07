<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->library('exportproses');
			
			$this->load->model('M_Proses_akuntansi');
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('Klien_model');
			$this->load->model('Akuntan_model');
			$this->load->model('Akses_model');
		} 
		 
		public function index() {
			
			$data['judul'] = "Proses Data Akuntansi"; 
			$this->libtemplate->main('admin/proses_akuntansi/tampil', $data);
		}
		
		public function proses() {
			
			$data['header']		= "Proses Data Akuntansi";
			$data['sub_header']	= "Daftar proses data yang sedang berjalan";
			$data['masa']		= $this->M_Proses_akuntansi->masa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('admin/proses_akuntansi/view/onproses', $data);
		}
		
		public function proses2() {
			
			$data['header']		= "Proses Data Akuntansi";
			$data['sub_header']	= "Daftar proses data yang sedang berjalan";
			$data['masa']		= $this->M_Proses_akuntansi->masa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('admin/proses_akuntansi/view_tab', $data);
		}
		
		public function prosesBelum() {
			
			$data['header']		= "Proses Data Akuntansi";
			$data['sub_header']	= "Daftar data yang belum diproses";
			$data['masa']		= $this->M_Proses_akuntansi->masa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('admin/proses_akuntansi/view/belum', $data);
		}
		
		public function prosesSelesai() {
			
			$data['header']		= "Proses Data Akuntansi";
			$data['sub_header']	= "Daftar data yang sudah selesai diproses";
			$data['masa']		= $this->M_Proses_akuntansi->masa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('admin/proses_akuntansi/view/selesai', $data);
		}
		
		public function ganti_tampil() {
			
			$jenis = $_POST['jenis'];
			$lists = $this->proses_admin->ganti_jenis($jenis);
			
			echo $lists; 
		}
		
		public function ganti() {
			
			$bulan = $this->input->post('bulan', true);
			$tahun = $this->input->post('tahun', true);
			$jenis = $this->input->post('jenis', true); // jenis tampilan(per klien/per akuntan)
			$klien = $this->input->post('klien', true); // bisa berupa id_klien atau id_akuntan, tergantung jenis
				
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);
			$this->session->set_flashdata('jenis', $jenis);
			
			// tampil berdasarkan tab yang sedang aktif
			$status = $this->session->userdata('status'); 
			if($status == 'belum') {
				$proses = $this->M_Proses_akuntansi->getBelum($bulan, $tahun);
				// tampilkan berdasarkan jenis tampilan(per klien/per akuntan)
				if($jenis == "Akuntan") {
					$akses = $this->Akses_model->getByAkuntan($klien, $bulan, $tahun);
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
						$proses = $this->M_Proses_akuntansi->getByKlienBelum($bulan, $tahun, $klien);
				}

				if($proses == null) {
					$this->session->set_flashdata('empty', 'Belum ada pengiriman');
					$this->load->view('empty');
				} else {
					$data['proses'] = $proses;
					$this->load->view('admin/proses_akuntansi/isi/belum', $data);
				}
			} 
			else {
				if($status == 'selesai')  {
					$proses			= $this->M_Proses_akuntansi->getByKlienSelesai($bulan, $tahun, $klien);
					$proses_selesai	= $this->M_Proses_akuntansi->getSelesai($bulan, $tahun);
				}
				else {
					$proses			= $this->M_Proses_akuntansi->getByKlienSedang($bulan, $tahun, $klien);
					$proses_selesai	= $this->M_Proses_akuntansi->getSedang($bulan, $tahun);
				}
				
				if($klien != null) {
					if($jenis == 'Akuntan') {
						$proses = [];
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
					$redirect = "admin/proses_akuntansi/isi/{$status}";
					$this->load->view($redirect, $data);
				}
			}
		}
		
		public function hitung_durasi() {
			$mulai		= $this->input->post('mulai', true);
			if($this->input->post('selesai', true)) {
				$selesai	= $this->input->post('selesai', true);
				$durasi		= $this->proses_admin->durasi($mulai, $selesai);
			} else {
				$durasi		= $this->proses_admin->durasi($mulai);
			}
			echo $durasi;
		}

		public function download() {
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$get		= $this->input->post('klien', true);
			$tampil		= $this->input->post('tampil', true);
			$filename	= strtoupper($bulan).' '.$tahun;

			if($get == null) {
				$klien = $this->Klien_model->getAllKlien(); 
			} else {
				if($tampil == "Akuntan") {
					$akses = $this->Akses_model->getByAkuntan($get, $bulan, $tahun);
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
				$perklien = $this->M_Proses_akuntansi->getByKlienBelum($bulan, $tahun, $k['id_klien']);
				elseif($status == 'selesai')
				$perklien = $this->M_Proses_akuntansi->getByKlienSelesai($bulan, $tahun, $k['id_klien']);
				else
				$perklien = $this->M_Proses_akuntansi->getByKlienSedang($bulan, $tahun, $k['id_klien']);
				
				$proses[$k['id_klien']] = $perklien;
			}

			$data['proses']		= $proses;
			$data['bulan']		= $bulan;
			$data['tahun']		= $tahun;
			$data['klien']		= $klien;
			$data['now']		= date('d/m/Y H:i');
			$data['filename']	= 'Proses Data Akuntansi '.$filename;
			$data['judul']		= "Proses Data Akuntansi";
			
			if($status == 'belum')
			$data['subjudul']	= "Belum Diproses";
			elseif($status == 'selesai')
			$data['subjudul']	= "Selesai Diproses";
			else
			$data['subjudul']	= "Sedang Diproses";

			if($this->input->post('xls', true)) {
				echo "xls";
				return $this->exportproses->exportExcel($data);
			}
			elseif($this->input->post('pdf', true))
				return $this->exportproses->exportPdf($data);
		}
	}
?>