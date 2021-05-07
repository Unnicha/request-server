<?php
	
	class Permintaan_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');

			$this->load->model('M_Permintaan_lainnya');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('Jenis_data_model');
		} 
		 
		public function index() {
			
			$data['judul'] = "Permintaan Data Lainnya";
			$data['masa']	= $this->Klien_model->getMasa();
			$data['klien']	= $this->Klien_model->getAllKlien();
			
			$this->libtemplate->main('akuntan/permintaan_lainnya/tampil', $data);
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
				$akses		= $this->Akses_model->getByAkuntan($id_akuntan, $bulan, $tahun);
				if( $akses ) {
					$klien = explode(',', $akses['klien']);
				}
			}
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Permintaan_lainnya->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_lainnya->getByMasa($bulan, $tahun, $klien, $offset, $limit);

			$data		= [];
			foreach($permintaan as $k) { 
				if( $this->M_Permintaan_lainnya->getPengiriman($k['id_permintaan']) ) {
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
			
			$bulan	= $this->input->post('bulan', true);
			$tahun	= $this->input->post('tahun', true);
			
			$id_akuntan	= $this->session->userdata('id_user');
			$akses		= $this->Akses_model->getByAkuntan($id_akuntan, $bulan, $tahun);
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
			
			$data['judul']	= "Kirim Permintaan Data Lainnya"; 
			$data['masa']	= $this->Klien_model->getMasa();
			$data['jenis']	= $this->Jenis_data_model->getAllJenisData();
			
			$this->form_validation->set_rules('tanggal_permintaan', 'Tanggal Permintaan', 'required');
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/permintaan_lainnya/tambah', $data);
			} else {
				$this->M_Permintaan_lainnya->tambahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('akuntan/permintaan_data_lainnya'); 
			}
		}

		public function detail() {
			$id_permintaan		= $this->input->post('permintaan', true);
			$data['judul']		= 'Detail Permintaan';
			$data['permintaan']	= $this->M_Permintaan_lainnya->getById($id_permintaan);
			
			$this->load->view('akuntan/permintaan_lainnya/detail', $data);
		}
		
		public function hapus($id_permintaan) {
			$this->M_Permintaan_lainnya->hapusPermintaan($id_permintaan);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('akuntan/permintaan_data_lainnya');
		}
	}
?>