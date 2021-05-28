<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			$this->load->library('exportproses');
			
			$this->load->model('M_Proses_perpajakan', 'm_proses');
			$this->load->model('M_Pengiriman_perpajakan');
			$this->load->model('Klien_model');
			$this->load->model('Akuntan_model');
			$this->load->model('Akses_model');
		} 
		 
		public function index() {
			$data['judul'] = "Proses Data Perpajakan"; 
			$this->libtemplate->main('admin/proses_perpajakan/tampil', $data);
		}
		
		public function prosesOn() {
			$unset = ['status', 'tampil', 'akuntan'];
			$this->session->unset_userdata($unset);

			$status		= $_POST['status'];
			$tampil		= $_POST['tampil'];
			$akuntan	= ($_POST['akuntan']) ? $_POST['akuntan'] : '';
			$this->session->set_userdata('status', $status);
			$this->session->set_userdata('tampil', $tampil);
			$this->session->set_userdata('akuntan', $akuntan);
			
			$data['header']	= "Proses Data Perpajakan";
			$data['masa']	= $this->Klien_model->getMasa();

			$this->load->view('admin/proses_perpajakan/view/'.$status, $data);
		}

		public function gantiTampilan() {
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
				$akuntan = $this->session->userdata('akuntan');
				if($akuntan) {
					$akses = $this->Akses_model->getByAkuntan($_POST['tahun'], $akuntan);
					if($akses) {
						$bulan = $this->Klien_model->getMasa($_POST['bulan']);
						if($bulan['id_bulan'] < $akses['masa']) {
							$akses = $this->Akses_model->getByAkuntan(($_POST['tahun'] - 1), $akuntan);
						}
						if($akses) {
							$id_klien	= explode(',', $akses['klien']);
							$klien		= [];
							foreach($id_klien as $id) {
								$klien[] = $this->Klien_model->getById($id);
							}
						} else {
							$lists = "<option value=''>--Tidak Ada Klien--</option>";
						}
					} else {
						$lists = "<option value=''>--Tidak Ada Klien--</option>";
					}
				} else {
					$klien = $this->Klien_model->getAllKlien();
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
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$klien		= $this->input->post('klien', true);
			$jenis		= $this->session->userdata('tampil'); // jenis tampilan(per klien/per akuntan)
			$akuntan	= $this->session->userdata('akuntan');
			$status		= $this->session->userdata('status'); 
			
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			//$this->session->set_flashdata('klien', $klien);
			//$this->session->set_flashdata('jenis', $jenis);
			
			if($jenis == "Akuntan") {
				if($klien == null) {
					$akses = $this->Akses_model->getByAkuntan($tahun, $akuntan);
					if($akses) { 
						$masa = $this->Klien_model->getMasa($bulan);
						if($masa['id_bulan'] < $akses['masa']) {
							$akses = $this->Akses_model->getByAkuntan(($tahun-1), $akuntan);
						}
						if($akses) {
							$klien = explode(",", $akses['klien']);
							implode(",", $klien);
						} else {
							$klien = 'kosong';
						}
					}
				}
			}
			$countData	= $this->m_proses->countProses($status, $bulan, $tahun, $klien);
			$proses		= $this->m_proses->getProses($offset, $limit, $status, $bulan, $tahun, $klien);
			
			$data = [];
			foreach($proses as $k) {
				$hari	= floor($k['lama_pengerjaan'] / 8);
				$jam	= $k['lama_pengerjaan'] % 8;
				$standar= $hari.' hari '.$jam.' jam';

				//HITUNG DURASI
				$mulai		= $k['tanggal_mulai']." ".$k['jam_mulai'];
				$selesai	= $k['tanggal_selesai']." ".$k['jam_selesai'];
				if($k['tanggal_mulai']) {
					if($k['tanggal_selesai']) {
						$durasi	= $this->proses_admin->durasi($mulai, $selesai);
					} else {
						$durasi	= $this->proses_admin->durasi($mulai);
					}
				}
				
				$row	= [];
				$row[]	= ++$offset.'.';
				if($status == 'belum') {
					$row[]	= $k['nama_klien'];
					$row[]	= $k['nama_tugas'];
					$row[]	= $k['jenis_data'];
					$row[]	= $k['pembetulan'];
					$row[]	= $k['format_data'];
					$row[]	= $standar;
				} elseif($status == 'selesai') {
					$row[]	= $k['nama_klien'];
					$row[]	= $k['nama'];
					$row[]	= $k['nama_tugas'];
					$row[]	= $k['pembetulan'];
					$row[]	= $mulai;
					$row[]	= $selesai;
					$row[]	= $durasi;
					$row[]	= $standar;
				} else {
					$row[]	= $k['nama_klien'];
					$row[]	= $k['nama'];
					$row[]	= $k['nama_tugas'];
					$row[]	= $k['pembetulan'];
					$row[]	= $mulai;
					$row[]	= $durasi;
					$row[]	= $standar;
				}
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
			$data['filename']	= 'Proses Data Perpajakan '.$filename;
			$data['judul']		= "Proses Data Perpajakan";
			
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