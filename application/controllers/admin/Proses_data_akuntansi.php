<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->library('exportproses');
			
			$this->load->model('M_Proses_akuntansi', 'm_proses');
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('Klien_model');
			$this->load->model('Akuntan_model');
			$this->load->model('Akses_model');
		} 
		 
		public function index() {
			$data['judul'] = "Proses Data Akuntansi"; 
			$this->libtemplate->main('admin/proses_akuntansi/tampil', $data);
		}
		
		public function prosesOn() {
			$status		= $_POST['status'];
			$tampil		= $_POST['tampil'];
			$akuntan	= ($_POST['akuntan']) ? $_POST['akuntan'] : '';
			$this->session->set_userdata('status', $status);
			$this->session->set_userdata('tampil', $tampil);
			$this->session->set_userdata('akuntan', $akuntan);
			
			$data['header']	= "Proses Data Akuntansi";
			$data['masa']	= $this->Klien_model->getMasa();

			$this->load->view('admin/proses_akuntansi/view/'.$status, $data);
		}
		
		public function prosesYet() {
			$data['header']		= "Proses Data Akuntansi";
			$data['sub_header']	= "Daftar data yang belum diproses";
			$data['masa']		= $this->Klien_model->getMasa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('admin/proses_akuntansi/view/belum', $data);
		}
		
		public function prosesDone() {
			$data['header']		= "Proses Data Akuntansi";
			$data['sub_header']	= "Daftar data yang sudah selesai diproses";
			$data['masa']		= $this->Klien_model->getMasa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('admin/proses_akuntansi/view/selesai', $data);
		}

		public function gantiAkuntan() {
			$lists	= "<option value=''>--Semua ".$_POST['tampil']."--</option>";
			if($_POST['tampil'] == 'Akuntan') {
				$akuntan	= $this->Akuntan_model->getAllAkuntan();
				foreach($akuntan as $a) {
					$lists	.= "<option value='".$a['id_user']."'>".$a['nama']."</option>"; 
				}
			}
			
			echo $lists;
		}
		
		public function gantiKlien() {
			$lists = "<option value=''>--Semua Klien--</option>";
			$klien = '';
			if($this->session->userdata('tampil') == "Akuntan") {
				$akuntan	= $this->session->userdata('akuntan');
				$akses		= $this->Akses_model->getByAkuntan($_POST['tahun'], $akuntan);
				if($akses) {
					$bulan = $this->Klien_model->getMasa($_POST['bulan']);
					if($bulan['id_bulan'] < $akses['masa']) {
						$akses = $this->Akses_model->getByAkuntan(($_POST['tahun'] - 1), $akuntan);
					}
					$id_klien	= explode(',', $akses['klien']);
					$klien		= [];
					foreach($id_klien as $id) {
						$klien[] = $this->Klien_model->getById($id);
					}
				} else {
					$lists = "<option value=''>--Tidak Ada Klien--</option>";
				}
			} else {
				$klien = $this->Klien_model->getAllKlien();
			}
			
			if($klien) {
				foreach($klien as $k) {
					$lists .= "<option value='".$k['id_klien']."'>".$k['nama_klien']."</option>"; 
				}
			}
			
			echo $lists; 
		}
		
		public function page() {
			
			$bulan = $this->input->post('bulan', true);
			$tahun = $this->input->post('tahun', true);
			$jenis = $this->input->post('jenis', true); // jenis tampilan(per klien/per akuntan)
			$klien = $this->input->post('klien', true); // bisa berupa id_klien atau id_akuntan, tergantung jenis
			
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);
			$this->session->set_flashdata('jenis', $jenis);
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			
			if($jenis == "Akuntan") {
				$akses = $this->Akses_model->getByAkuntan($tahun, $klien);
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
			}
			$status		= $this->session->userdata('status'); 
			if($status == 'belum') {
				$proses = $this->m_proses->getBelum($bulan, $tahun);
				// tampilkan berdasarkan jenis tampilan(per klien/per akuntan)
				if($jenis == "Akuntan") {
					$akses = $this->Akses_model->getByAkuntan($tahun, $klien);
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
						$proses = $this->m_proses->getBelumByKlien($bulan, $tahun, $klien);
				}
			} 
			else {
				if($status == 'selesai')  {
					$proses			= $this->m_proses->getByKlienSelesai($bulan, $tahun, $klien);
					$proses_selesai	= $this->m_proses->getSelesai($bulan, $tahun);
				}
				else {
					$proses			= $this->m_proses->getByKlienSedang($bulan, $tahun, $klien);
					$proses_selesai	= $this->m_proses->getSedang($bulan, $tahun);
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
					$redirect = "admin/proses_akuntansi/isi/".$status;
					$this->load->view($redirect, $data);
				}
			}

			if($klien == null) 
				{ $klien = 'all'; }
			$countData	= $this->M_Permintaan_akuntansi->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_akuntansi->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data		= [];
			foreach($permintaan as $k) { 
				if( $this->M_Permintaan_akuntansi->getPengiriman($k['id_permintaan']) ) {
					$status = '<i class="bi bi-check-circle-fill icon-status" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Sudah Diterima"></i>';
				} else {
					$status = '<i class="bi bi-hourglass-split icon-status" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Belum Diterima"></i>';
				}

				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['jenis_data'];
				$row[]	= $k['request'];
				$row[]	= $k['format_data'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $status;
				$row[]	= '
					<a class="btn btn-sm btn-primary btn-detail_permintaan" data-toggle="tooltip" data-nilai="'.$k['id_permintaan'].'" data-placement="bottom" title="Detail Permintaan">
						<i class="bi bi-info-circle"></i>
					</a>

					<a href="permintaan_data_akuntansi/hapus/'.$k['id_permintaan'].'" class="btn btn-sm btn-danger " onclick="return confirm("Yakin ingin menghapus permintaan '.$k['jenis_data'].' untuk '.$k['nama_klien'].'?");" data-toggle="tooltip" data-placement="bottom" title="Hapus">
						<i class="bi bi-trash"></i>
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
				$proses = $this->m_proses->getBelum($bulan, $tahun);
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
						$proses = $this->m_proses->getByKlienBelum($bulan, $tahun, $klien);
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
					$proses			= $this->m_proses->getByKlienSelesai($bulan, $tahun, $klien);
					$proses_selesai	= $this->m_proses->getSelesai($bulan, $tahun);
				}
				else {
					$proses			= $this->m_proses->getByKlienSedang($bulan, $tahun, $klien);
					$proses_selesai	= $this->m_proses->getSedang($bulan, $tahun);
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
					$redirect = "admin/proses_akuntansi/isi/".$status;
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
				$perklien = $this->m_proses->getByKlienBelum($bulan, $tahun, $k['id_klien']);
				elseif($status == 'selesai')
				$perklien = $this->m_proses->getByKlienSelesai($bulan, $tahun, $k['id_klien']);
				else
				$perklien = $this->m_proses->getByKlienSedang($bulan, $tahun, $k['id_klien']);
				
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