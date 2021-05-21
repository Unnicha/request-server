<?php
	
	class Pengiriman_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Klien_model');
			$this->load->model('M_Permintaan_perpajakan');
			$this->load->model('M_Pengiriman_perpajakan');
		} 
		
		public function index() {
			
			$data['judul']	= "Pengiriman Data Perpajakan"; 
			$data['masa']	= $this->Klien_model->getMasa();
			$data['lokasi']	= "asset/uploads";

			$this->libtemplate->main('klien/pengiriman_perpajakan/tampil', $data);
		}
		
		public function page() {
			$bulan	= $_POST['bulan'];
			$tahun	= $_POST['tahun'];
			$klien	= $this->session->userdata('id_user');
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			//$this->session->set_flashdata('klien', $klien);
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Pengiriman_perpajakan->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_perpajakan->getByMasa($bulan, $tahun, $klien, $offset, $limit);

			$data = [];
			foreach($pengiriman as $k) {
				$btn	= '
					<a href="#" class="btn btn-sm btn-info btn-detail_pengiriman" data-nilai="'.$k['id_pengiriman'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Pengiriman">
						<i class="bi bi-info-circle"></i>
					</a>';
				if($k['pembetulan'] == 0) {
					$btn .= '
						<a href="pengiriman_data_perpajakan/pembetulan/'.$k['id_permintaan'].'" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Kirim Revisi">
							<i class="bi bi-file-earmark-arrow-up"></i>
						</a>';
				}

				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['jenis_data'];
				$row[]	= "Pengiriman ke-".($k['pembetulan'] + 1);
				$row[]	= $k['tanggal_pengiriman'];
				$row[]	= $btn;
					
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
		
		public function pembetulan($id_permintaan) {
			$data['judul']		= "Form Kirim Revisi"; // judul halaman
			$data['masa']		= $this->Klien_model->getMasa();
			$data['permintaan']	= $this->M_Permintaan_perpajakan->getById($id_permintaan);
						
			$this->form_validation->set_rules('tanggal_pengiriman', 'Tanggal Pengiriman', 'required');
			$this->form_validation->set_rules('format_data', 'Format Data', 'required');
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');
			

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/pengiriman_perpajakan/pembetulan', $data);
			} else {
				$this->M_Pengiriman_perpajakan->kirim();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('klien/pengiriman_data_perpajakan'); 
			}
		}
		
		public function detail() {
			$id_pengiriman	= $_POST['action'];
			$pengiriman		= $this->M_Pengiriman_perpajakan->getById($id_pengiriman);

			//path folder penyimpanan data
			$data['lokasi'] = 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/'.$pengiriman['masa']; 
			$data['judul']		= 'Detail Pengiriman Data';
			$data['pengiriman']	= $pengiriman;
			
			$this->load->view('klien/pengiriman_perpajakan/detail_pengiriman', $data);
		}
	}
?>