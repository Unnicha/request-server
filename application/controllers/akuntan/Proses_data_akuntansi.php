<?php
	
	class Proses_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('proses_admin');
			
			$this->load->model('M_Proses_akuntansi');
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('Jenis_data_model');
			$this->load->model('Tugas_model');
		} 
		 
		public function index() {
			
			$data['judul'] = "Proses Data Akuntansi"; 
			$this->libtemplate->main('akuntan/proses_akuntansi/tampil', $data);
		}

		public function proses() {
			
			$data['header'] = "Proses Data Akuntansi";
			$data['masa'] = $this->M_Proses_akuntansi->masa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('akuntan/proses_akuntansi/view/onproses', $data);
		}
		
		public function prosesBelum() {
			
			$data['header'] = "Proses Data Akuntansi";
			$data['masa'] = $this->M_Proses_akuntansi->masa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('akuntan/proses_akuntansi/view/belum', $data);
		}
		
		public function prosesSelesai() {
			
			$data['header'] = "Proses Data Akuntansi";
			$data['masa'] = $this->M_Proses_akuntansi->masa();
			
			$this->session->unset_userdata('status');
			$status = $_POST['status'];
			$this->session->set_userdata('status', $status);
			
			$this->load->view('akuntan/proses_akuntansi/view/selesai', $data);
		}
		
		public function ganti_akses() {
			
			$bulan = $_POST['bulan'];
			$tahun = $_POST['tahun'];
			$klien = $this->Klien_model->getAllKlien();

			$sess_id = $this->session->userdata('id_user');
			$akses = $this->Akses_model->getByAkuntan($sess_id, $bulan, $tahun);
			
			if($akses == null) {
				$lists = "<option value=''>--Tidak ada akses--</option>";
			} else {
				$id_klien = explode(",",$akses['klien']);
				$lists = "<option value=''>--Semua Klien--</option>";
				if($id_klien != null) {
					foreach($klien as $k) {
						foreach($id_klien as $data => $id) {
							if($k['id_klien'] == $id) 
							$lists .= "<option value='".$k['id_klien']."'>".$k['nama_klien']."</option>"; 
						}
					}
				}
			}
			echo json_encode($lists); 
		}

		public function ganti() {
			
			$klien = $this->input->post('klien', true);
			$bulan = $this->input->post('bulan', true);
			$tahun = $this->input->post('tahun', true);
				
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);
			
			$sess_id = $this->session->userdata('id_user');
			$akses = $this->Akses_model->getByAkuntan($sess_id, $bulan, $tahun);
			
			//cek apakah akuntan punya akses pada bulan tsb.
			if($akses['klien'] == null) {
				$this->session->set_flashdata('empty', 'Tidak ada akses');
				$this->load->view('empty'); 
			} else {
				$id_klien = explode(",", $akses['klien']);
				$status = $this->session->userdata('status');
				
				if($status == "belum") {
					$data['pengiriman']=[];
					//tampilkan data sesuai klien yang ingin ditampilkan
					//jika dipilih 'Semua Klien', tampilkan data klien yang bisa diakses
					if($klien == null) {
						$pengiriman = $this->M_Proses_akuntansi->getBelum($bulan, $tahun);
						foreach($id_klien as $id) {
							foreach($pengiriman as $a => $key) {
								if($key['id_klien'] == $id) {
									array_push($data['pengiriman'], $pengiriman[$a]);
								}
							}
						}
					} else {
						$data['pengiriman'] = $this->M_Proses_akuntansi->getByKlienBelum($bulan, $tahun, $klien);
					} 

					if($data['pengiriman'] == null) {
						$this->session->set_flashdata('empty', 'Tidak ada data');
						$this->load->view('empty');
					} else {
						$this->load->view('akuntan/proses_akuntansi/isi/belum', $data);
					}
				} else {
					if($status == 'selesai') {
						$proses = $this->M_Proses_akuntansi->getByKlienSelesai($bulan, $tahun, $klien);
						$proses_selesai = $this->M_Proses_akuntansi->getSelesai($bulan, $tahun);
					} else {
						$proses = $this->M_Proses_akuntansi->getByKlienSedang($bulan, $tahun, $klien);
						$proses_selesai = $this->M_Proses_akuntansi->getSedang($bulan, $tahun);
					}
					
					if($klien == null) {
						$data['proses'] = [];
						foreach($id_klien as $id) {
							foreach($proses_selesai as $p => $val) {
								if($val['id_klien'] == $id)
									array_push($data['proses'], $proses_selesai[$p]);
							}
						}
					} else {
						$data['proses'] = $proses;
					}

					if($data['proses'] == null) {
						$this->session->set_flashdata('empty', 'Belum ada proses');
						$this->load->view('empty');
					} else {
						$redirect = "akuntan/proses_akuntansi/isi/{$status}";
						$this->load->view($redirect, $data);
					}
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
		
		public function mulai($id_pengiriman) {
			
			$data['judul'] = "Mulai Proses Data"; 
			$data['pengiriman'] = $this->M_Pengiriman_akuntansi->getById($id_pengiriman);

			$this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/proses_akuntansi/tambah', $data);
			} else {
				$this->M_Proses_akuntansi->tambahProses();
				$this->session->set_flashdata('notification', 'Proses data dimulai!');
				redirect('akuntan/proses_data_akuntansi');
			}
		}
		
		public function selesai($id_proses) {
			
			$data['judul'] = "Perbarui Proses Data"; 
			$data['pengiriman'] = $this->M_Proses_akuntansi->getById($id_proses);
			
			$this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/proses_akuntansi/ubah', $data);
			} else {
				$this->M_Proses_akuntansi->ubahProses();
				$this->session->set_flashdata('notification', 'Proses data selesai!');
				redirect('akuntan/proses_data_akuntansi');
			}
		}

		public function detail() {
			$id_proses = $this->input->post('action', true);
			$data['proses'] = $this->M_Proses_akuntansi->getById($id_proses);
			$data['judul'] = 'Detail Proses';
			
			$this->load->view('akuntan/proses_akuntansi/detail', $data);
		}
		
		public function hapus($id_proses) {
			$this->M_Proses_akuntansi->hapusProses($id_proses);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('akuntan/proses_data_akuntansi');
		}
	}
?>