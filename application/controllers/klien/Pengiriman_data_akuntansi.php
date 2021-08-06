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
				$action	= '
					<a class="btn-detail_permintaan" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Detail">
						<i class="bi bi-info-circle-fill" style="font-size:20px; line-height:80%"></i>
					</a>';
				
				if(isset($k['id_pengiriman'])) {
					$badge = '<span class="badge badge-warning">Belum Lengkap</span>';
					//$action .= '<a href="permintaan_data_akuntansi/lengkapi/'.$k['id_pengiriman'].'" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="bottom" title="Lengkapi Data"><i class="bi bi-file-earmark-plus"></i></a>';
				} else {
					$badge = '<span class="badge badge-danger">Belum Dikirim</span>';
					//$action .= '<a href="permintaan_data_akuntansi/kirim/'.$k['id_permintaan'].'" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Kirim Data"><i class="bi bi-file-earmark-arrow-up"></i></a>';
				}
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['id_permintaan'];
				$row[]	= $k['request'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $badge;
				$row[]	= $action;
				
				$data[] = $row;
			}
			$callback	= [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=>$countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
		
		public function detail() {
			$pengiriman	= $this->M_Pengiriman_akuntansi->getById($this->input->post('action', true));
			$isi		= $this->M_Pengiriman_akuntansi->getDetail($pengiriman['id_permintaan']);
			$bulan		= $this->Klien_model->getMasa($pengiriman['bulan']);
			$lokasi		= 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/';
			
			foreach($isi as $i => $val) {
				$linkFile = '<a href="'. base_url() . $lokasi . $val['file'].'">'. $val['file'] .'</a>';
				
				if($val['status'] == 1) {
					$badge = '<span class="badge badge-warning">Belum Dikonfirmasi</span>';
				} elseif($val['status'] == 2) {
					$badge = '<span class="badge badge-danger">Kurang Lengkap</span>';
				} elseif($val['status'] == 3) {
					$badge = '<span class="badge badge-success">Sudah Dikonfirmasi</span>
						<a href="pengiriman_data_akuntansi/revisi/'.$val['id_data'].'" class ="badge badge-primary" data-toggle="tooltip" data-placement="right" title="Kirim Revisi">
							Revisi <i class="bi bi-file-earmark-arrow-up"></i>
						</a>';
				} else {
					$badge = '<span class="badge badge-danger">Belum Dikirim</span>';
				}
				
				$add[$i] = [
					'file_title'	=> ($val['format_data'] == 'Softcopy') ? 'File' : 'Tanggal Ambil',
					'file'			=> ($val['format_data'] == 'Softcopy') ? $linkFile : $val['file'],
					'status'		=> $badge,
				];
			}
			
			$data['judul']		= 'Detail Pengiriman Data';
			$data['pengiriman']	= $pengiriman;
			$data['bulan']		= $bulan['nama_bulan'];
			$data['isi']		= $isi;
			$data['add']		= $add;
			
			$this->load->view('klien/pengiriman_akuntansi/detail', $data);
		}
		
		public function revisi($id_data) {
			$data['judul']	= "Data Akuntansi - Form Revisi"; 
			$data['isi']	= $this->M_Pengiriman_akuntansi->getDetail('', $id_data);
			$data['batal']	= 'klien/pengiriman_data_akuntansi';
			
			$this->form_validation->set_rules('id_permintaan', 'File', 'required');
			$this->form_validation->set_rules('keterangan[]', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/pengiriman_akuntansi/revisi', $data);
			} else {
				$send = $this->M_Pengiriman_akuntansi->kirim();
				if($send == 'ERROR') {
					redirect('klien/pengiriman_data_akuntansi/revisi/'.$id_data);
				} else {
					if($send == 'OK') {
						$this->session->set_flashdata('notification', 'Data berhasil dikirim!'); 
					}
					redirect('klien/pengiriman_data_akuntansi');
				}
			}
		}
	}
?>