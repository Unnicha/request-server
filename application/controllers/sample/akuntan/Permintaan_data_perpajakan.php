<?php
	
	class Permintaan_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');

			$this->load->model('M_Permintaan_perpajakan');
			$this->load->model('M_Pengiriman_perpajakan');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('Jenis_data_model');
		} 
		 
		public function index() {
			
			$data['judul'] = "Permintaan Data Perpajakan";
			//$data['header'] = "Data Perpajakan";
			$data['header'] = $data['judul'];
			$data['sub_header'] = "Daftar permintaan data yang belum dipenuhi.";

			$data['klien'] = $this->Klien_model->getAllKlien();
			$data['masa'] = $this->M_Permintaan_perpajakan->masa();
			
			$this->libtemplate->main('akuntan/permintaan_perpajakan/tampil', $data);
		}

		public function ganti() {
			
			$data['pengiriman'] = $this->M_Pengiriman_perpajakan->getAllPengiriman();
			
			$klien = $_POST['klien'];
			$bulan = $_POST['bulan'];
			$tahun = $_POST['tahun'];
				
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);

			if($klien == null) {
				$id_akuntan	= $this->session->userdata('id_user');
				$akses		= $this->Akses_model->getByAkuntanMasa($id_akuntan, $bulan, $tahun);
				if($akses == null) {
					$data['permintaan'] = null;
				} else {
					$permintaan = $this->M_Permintaan_perpajakan->getPerMasaTahun($bulan, $tahun);
					$data['permintaan'] = [];
					$id_klien = explode(",", $akses['klien']);
					foreach($id_klien as $id) { 
						foreach($permintaan as $p => $val) {
							if($val['id_klien'] == $id)
							array_push($data['permintaan'], $permintaan[$p]);
						}
					} 
				}
			} else {
				$data['permintaan'] = $this->M_Permintaan_perpajakan->getPerKlien($bulan, $tahun, $klien);
			}

			if($data['permintaan'] == null) {
				$this->session->set_flashdata('empty', 'Belum ada permintaan');
				$this->load->view('empty');
			} else {
				$this->load->view('akuntan/permintaan_perpajakan/isi', $data);
			}
		}

		public function klien() {
			
			$bulan	= $_REQUEST['bulan'];
			$tahun	= $_REQUEST['tahun'];
			
			$id_akuntan	= $this->session->userdata('id_user');
			$akses		= $this->Akses_model->getByAkuntanMasa($id_akuntan, $bulan, $tahun);
			if($akses == null) {
				$lists	= "<option value=''>--Tidak ada akses--</option>";
			} else {
				$lists	= "<option value=''>--Pilih Klien--</option>";
				$id_klien	= explode(",", $akses['klien']);
				foreach($id_klien as $id) {
					$klien = $this->Klien_model->getById($id);
					$lists .= "<option value='".$klien['id_klien']."'>".$klien['nama_klien']."</option>"; 
				} 
			}
			echo $lists;
		}

		public function tambah() {
			
			$data['judul']	= "Kirim Permintaan Data Perpajakan"; 
			$data['masa']	= $this->M_Permintaan_perpajakan->masa();
			$data['jenis']	= $this->Jenis_data_model->getAllJenisData();
			
			$this->form_validation->set_rules('tanggal_permintaan', 'Tanggal Permintaan', 'required');
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/permintaan_perpajakan/tambah', $data);
			} else {
				$this->M_Permintaan_perpajakan->tambahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('akuntan/permintaan_data_perpajakan'); 
			}
		}
		
		public function ubah($id_permintaan) {
			$data['judul'] = "Perbarui Permintaan Data Perpajakan"; 
			$data['permintaan'] = $this->M_Permintaan_perpajakan->getById($id_permintaan); 
			$data['masa'] = $this->M_Permintaan_perpajakan->masa();
			$data['jenis'] = $this->Jenis_data_model->getAllJenisData();
			$data['klien'] = $this->Klien_model->getAllKlien();
			
			$this->form_validation->set_rules('tanggal_permintaan', 'Tanggal Permintaan', 'required');
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/permintaan_perpajakan/ubah', $data);
			} else {
				$this->M_Permintaan_perpajakan->ubahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('akuntan/permintaan_data_perpajakan'); 
			}
		}

		public function detail() {
			$id_permintaan = $_REQUEST['permintaan'];
			$data['judul'] = 'Detail Permintaan';
			$data['permintaan'] = $this->M_Permintaan_perpajakan->getById($id_permintaan);
			
			$this->load->view('akuntan/permintaan_perpajakan/detail', $data);
		}
		
		public function hapus($id_permintaan) {
			$this->M_Permintaan_perpajakan->hapusPermintaan($id_permintaan);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('akuntan/permintaan_data_perpajakan');
		}
	}
?>