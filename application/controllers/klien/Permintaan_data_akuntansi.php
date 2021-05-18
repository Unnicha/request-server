<?php
	
	class Permintaan_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('notif');
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('Klien_model');
		} 
		
		public function index() {
			$data['judul']	= "Permintaan Data Akuntansi";
			$data['masa']	= $this->Klien_model->getMasa();
			
			$this->libtemplate->main('klien/permintaan_akuntansi/tampil', $data);
		}
		
		public function page() {
			$bulan	= $_POST['bulan'];
			$tahun	= $_POST['tahun'];
			$klien	= $this->session->userdata('id_user');
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Permintaan_akuntansi->countForKlien($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_akuntansi->getForKlien($bulan, $tahun, $klien, $offset, $limit);
			
			$data		= [];
			foreach($permintaan as $k) { 
				if( $this->M_Permintaan_akuntansi->getPengiriman($k['id_permintaan']) ) {
					$status = '<i class="bi bi-check-circle-fill icon-status" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Sudah Diterima"></i>';
				} else {
					$status = '<i class="bi bi-hourglass-split icon-status" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Belum Diterima"></i>';
				}

				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['jenis_data'];
				$row[]	= $k['request'];
				$row[]	= $k['format_data'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= '
					<a class="btn btn-sm btn-info btn-detail_permintaan" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Permintaan">
						<i class="bi bi-info-circle"></i>
					</a>
					<a class="btn btn-sm btn-success" href="permintaan_data_akuntansi/kirim/'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Kirim Data">
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
			
			$data['judul'] = "Form Pengiriman Data"; 
			$data['header'] = "Kirim Data";
			$data['permintaan'] = $this->M_Permintaan_akuntansi->getById($id_permintaan);
			
			$this->form_validation->set_rules('tanggal_pengiriman', 'Tanggal Pengiriman', 'required');
			$this->form_validation->set_rules('format_data', 'Format Data', 'required');
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_akuntansi/kirim', $data);
			} else {
				$this->M_Pengiriman_akuntansi->kirim();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('klien/permintaan_data_akuntansi'); 
			}
		}

		public function detail() {
			$data['judul']		= 'Detail Permintaan Data ';
			$id_permintaan		= $this->input->post('permintaan', true);
			$data['permintaan']	= $this->M_Permintaan_akuntansi->getById($id_permintaan);
			
			$this->load->view('klien/permintaan_akuntansi/detail', $data);
		}
	}
?>