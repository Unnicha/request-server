<?php
	
	class Permintaan_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('notif');
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_lainnya');
			$this->load->model('M_Pengiriman_lainnya');
			$this->load->model('Klien_model');
			$this->load->model('Jenis_data_model');
		} 
		
		public function index() {
			$data['judul']	= "Permintaan Data Lainnya";
			$data['masa']	= $this->Klien_model->getMasa();
			$this->libtemplate->main('klien/permintaan_lainnya/tampil', $data);
		}
		
		public function page() {
			$tahun	= $_POST['tahun'];
			$bulan	= $_POST['bulan'];
			$klien	= $this->session->userdata('id_user');
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Permintaan_lainnya->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_lainnya->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data		= [];
			foreach($permintaan as $k) {
				if( $k['id_pengiriman'] ) {
					$status = '<span class="badge badge-success">Sudah Dikirim</span>';
				} else {
					$status = '<span class="badge badge-warning">Belum Dikirim</span>';
				}

				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['request'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $status;
				$row[]	= '
					<a class="btn btn-sm btn-info btn-detail_permintaan" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Permintaan">
						<i class="bi bi-info-circle"></i>
					</a>
					<a class="btn btn-sm btn-success" href="permintaan_data_lainnya/kirim/'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Kirim Data">
						<i class="bi bi-file-earmark-arrow-up"></i>
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
		
		public function kirim($id_permintaan) {
			$permintaan		= $this->M_Permintaan_lainnya->getById($id_permintaan);
			$kode_jenis		= explode('|', $permintaan['kode_jenis']);
			foreach($kode_jenis as $kode) {
				$jenis_data[] = $this->Jenis_data_model->getById($kode);
			}
			
			$data['judul']			= "Form Pengiriman - Data Lainnya"; 
			$data['permintaan']		= $permintaan;
			$data['jenis_data']		= $jenis_data;
			$data['format_data']	= explode('|', $permintaan['format_data']);
			$data['detail']			= explode('|', $permintaan['detail']);
			$data['batal']			= 'klien/permintaan_data_lainnya';
			
			$this->form_validation->set_rules('id_permintaan', 'File', 'required');
			$this->form_validation->set_rules('keterangan[]', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_lainnya/kirim', $data);
			} else {
				$send = $this->M_Pengiriman_lainnya->kirim();
				if($send == 'ERROR') {
					redirect('klien/permintaan_data_lainnya/kirim/'.$id_permintaan);
				} else {
					if($send == 'OK') {
						$this->session->set_flashdata('notification', 'Data berhasil dikirim!');
					}
					redirect('klien/permintaan_data_lainnya');
				}
			}
		}
		
		public function detail() {
			$id_permintaan	= $this->input->post('permintaan', true);
			$permintaan		= $this->M_Permintaan_lainnya->getById($id_permintaan);
			$bulan			= $this->Klien_model->getMasa($permintaan['bulan']);
			$kode_jenis		= explode('|', $pengiriman['kode_jenis']);
			foreach($kode_jenis as $kode) {
				$jenis_data[] = $this->Jenis_data_model->getById($kode);
			}
			
			$data['judul']			= 'Detail Permintaan';
			$data['permintaan']		= $permintaan;
			$data['bulan']			= $bulan['nama_bulan'];
			$data['jenis_data']		= $jenis_data;
			$data['format_data']	= explode('|', $permintaan['format_data']);
			$data['detail']			= explode('|', $permintaan['detail']);
			
			$this->load->view('klien/permintaan_lainnya/detail', $data);
		}
	}
?>