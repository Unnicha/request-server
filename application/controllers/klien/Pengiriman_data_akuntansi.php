<?php
	
	class Pengiriman_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Klien_model');
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('Jenis_data_model');
		} 
		
		public function index() {
			
			$data['judul']	= "Pengiriman Data Akuntansi"; 
			$data['masa']	= $this->Klien_model->getMasa();
			$data['lokasi']	= "asset/uploads";

			$this->libtemplate->main('klien/pengiriman_akuntansi/tampil', $data);
		}
		
		public function page() {
			$bulan	= $_POST['bulan'];
			$tahun	= $_POST['tahun'];
			$klien	= $this->session->userdata('id_user');
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Pengiriman_akuntansi->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_akuntansi->getByMasa($bulan, $tahun, $klien, $offset, $limit);

			$data = [];
			foreach($pengiriman as $k) {
				$btn	= '
					<a href="#" class="btn btn-sm btn-info btn-detail_pengiriman" data-nilai="'.$k['id_pengiriman'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Pengiriman">
						<i class="bi bi-info-circle"></i>
					</a>';
				if($k['pembetulan'] == 0) {
					$btn .= '
						<a href="pengiriman_data_akuntansi/pembetulan/'.$k['id_permintaan'].'" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Kirim Revisi">
							<i class="bi bi-file-earmark-arrow-up"></i>
						</a>';
				}
				
				$status	= explode('|', $k['status']);
				$badge	= '';
				if(in_array('belum', $status)) {
					//$badge .= '<span class="badge badge-warning">Belum Dikonfirmasi</span><br>';
					$badge .= '<i class="bi bi-exclamation-diamond-fill icon-status mr-1" style="color:#ffc107" data-toggle="tooltip" data-placement="bottom" title="Belum Dikonfirmasi"></i>';
				} if(in_array('kurang', $status)) {
					//$badge .= '<span class="badge badge-danger">Kurang Lengkap</span><br>';
					$badge .= '<i class="bi bi-x-octagon-fill icon-status mr-1" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Kurang Lengkap"></i>';
				} if(in_array('lengkap', $status)) {
					//$badge .= '<span class="badge badge-success">Lengkap</span>';
					$badge .= '<i class="bi bi-check-circle-fill icon-status mr-1" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Lengkap"></i>';
				}
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['request'];
				$row[]	= sprintf("%02s", $k['pembetulan'] + 1);
				$row[]	= $k['tanggal_pengiriman'];
				$row[]	= $badge;
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
			$permintaan		= $this->M_Permintaan_akuntansi->getById($id_permintaan);
			$kode_jenis		= explode('|', $permintaan['kode_jenis']);
			implode(',', $kode_jenis);
			
			$data['judul']			= "Form Revisi - Data Akuntansi"; 
			$data['permintaan']		= $permintaan;
			$data['jenis_data']		= $this->Jenis_data_model->getForDetail($kode_jenis);
			$data['format_data']	= explode('|', $permintaan['format_data']);
			$data['detail']			= explode('|', $permintaan['detail']);
			$data['jum_data']		= count($data['jenis_data']);
			
			$this->form_validation->set_rules('id_permintaan', 'File', 'required');
			$this->form_validation->set_rules('keterangan[]', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/pengiriman_akuntansi/pembetulan', $data);
			} else {
				if($this->M_Pengiriman_akuntansi->kirim() == 'ok') {
					$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
					redirect('klien/pengiriman_data_akuntansi');
				} else {
					redirect('klien/pengiriman_data_akuntansi/pembetulan/'.$id_permintaan);
				}
			}
		}
		
		public function lengkapi($id_pengiriman) {
			$pengiriman		= $this->M_Pengiriman_akuntansi->getById($id_pengiriman);
			$kode_jenis		= explode('|', $pengiriman['kode_jenis']);
			implode(',', $kode_jenis);
			
			$data['judul']			= "Form Revisi - Data Akuntansi"; 
			$data['id_pengiriman']	= $pengiriman['id_pengiriman'];
			$data['lokasi']			= 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/'; 
			$data['jenis_data']		= $this->Jenis_data_model->getForDetail($kode_jenis);
			$data['format_data']	= explode('|', $pengiriman['format_data']);
			$data['detail']			= explode('|', $pengiriman['detail']);
			$data['file']			= explode('|', $pengiriman['file']);
			$data['status']			= explode('|', $pengiriman['status']);
			$data['keterangan']		= explode('|', $pengiriman['keterangan']);
			$data['jum_data']		= count($data['jenis_data']);
			
			$this->form_validation->set_rules('id_pengiriman', 'ID Pengiriman', 'required');
			$this->form_validation->set_rules('status[]', 'Status', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/pengiriman_akuntansi/lengkapi', $data);
			} else {
				if($this->M_Pengiriman_akuntansi->kirim() == 'ok') {
					$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
					redirect('klien/pengiriman_data_akuntansi'); 
				} else {
					redirect('klien/pengiriman_data_akuntansi/lengkapi/'.$id_pengiriman);
				}
			}
		}
		
		public function detail() {
			$id_pengiriman	= $this->input->post('action', true);
			$pengiriman		= $this->M_Pengiriman_akuntansi->getById($id_pengiriman);
			$bulan			= $this->Klien_model->getMasa($pengiriman['bulan']);
			$kode_jenis		= explode('|', $pengiriman['kode_jenis']);
			implode(',', $kode_jenis);

			//path folder penyimpanan data
			$data['lokasi']			= 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/'; 
			$data['judul']			= 'Detail Pengiriman Data';
			$data['pengiriman']		= $pengiriman;
			$data['bulan']			= $bulan['nama_bulan'];
			$data['jenis_data']		= $this->Jenis_data_model->getForDetail($kode_jenis);
			$data['format_data']	= explode('|', $pengiriman['format_data']);
			$data['detail']			= explode('|', $pengiriman['detail']);
			$data['file']			= explode('|', $pengiriman['file']);
			$data['keterangan']		= explode('|', $pengiriman['keterangan']);
			$data['status']			= explode('|', $pengiriman['status']);
			$data['jum_data']		= count($data['jenis_data']);
			$data['lengkap']		= (empty($data['status']) || in_array('belum', $data['status'])) ? false : true;
			
			$this->load->view('klien/pengiriman_akuntansi/detail', $data);
		}
	}
?>