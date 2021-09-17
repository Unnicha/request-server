<?php
	
	class Permintaan_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('Klien_model');
			$this->load->model('Jenis_data_model');
		} 
		
		public function index() {
			$data['judul']	= "Permintaan Data Akuntansi";
			$data['masa']	= $this->Klien_model->getMasa();
			$this->libtemplate->main('klien/permintaan_akuntansi/tampil', $data);
		}
		
		public function page() {
			$tahun	= $_POST['tahun'];
			$bulan	= $_POST['bulan'];
			$klien	= $this->session->userdata('id_user');
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Permintaan_akuntansi->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_akuntansi->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($permintaan as $k) {
				$detail	= $this->M_Permintaan_akuntansi->countDetail($k['id_permintaan']);
				$badge	= '';
				if($detail['jumYes'] > 0)
					$badge .= '<span class="badge badge-success mr-1" data-toggle="tooltip" data-placement="bottom" title="'.$detail['jumYes'].' Data Lengkap">'.$detail['jumYes'].'</span>';
				if($detail['jumNo'] > 0)
					$badge .= '<span class="badge badge-warning mr-1" data-toggle="tooltip" data-placement="bottom" title="'.$detail['jumNo'].' Data Belum Lengkap">'.$detail['jumNo'].'</span>';
				if($detail['jumNull'] > 0)
					$badge .= '<span class="badge badge-danger mr-1" data-toggle="tooltip" data-placement="bottom" title="'.$detail['jumNull'].' Data Belum Dikirim">'.$detail['jumNull'].'</span>';
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['id_permintaan'];
				$row[]	= $k['request'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $k['jumData'];
				$row[]	= $k['nama'];
				$row[]	= $badge;
				$row[]	= '
					<a class="btn-kirim" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Kirim Data">
						<i class="bi bi-cursor-fill icon-medium"></i>
					</a>
					<a class="btn-detail" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Detail">
						<i class="bi bi-info-circle-fill icon-medium"></i>
					</a>';
				
				$data[] = $row;
			}
			$callback = [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=> $countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
		
		public function detail() {
			$id			= $_REQUEST['id'];
			$permintaan	= $this->M_Permintaan_akuntansi->getById($id);
			$isi		= $this->M_Permintaan_akuntansi->getDetail($id);
			
			foreach($isi as $i => $val) {
				if($val['status_kirim'] == 'yes') {
					$badge	= '<span class="badge badge-success">Lengkap</span>';
				} elseif($val['status_kirim'] == 'no') {
					$badge	= '<span class="badge badge-warning">Belum Lengkap</span>';
				} else {
					$badge	= '<span class="badge badge-danger">Belum Dikirim</span>';
				}
				$add[$i] = $badge;
			}
			$data['judul']		= 'Detail Permintaan';
			$data['permintaan']	= $permintaan;
			$data['detail']		= $isi;
			$data['badge']		= $add;
			$data['link']		= 'klien/permintaan_data_akuntansi/kirim/';
			
			$this->load->view('klien/permintaan_akuntansi/detail', $data);
		}
		
		public function pilih() {
			$isi = $this->M_Permintaan_akuntansi->getDetail($_REQUEST['id']);
			foreach($isi as $i => $val) {
				if($val['status_kirim'] == 'yes') {
					$badge	= '<span class="badge badge-success">Lengkap</span>';
				} elseif($val['status_kirim'] == 'no') {
					$badge	= '<span class="badge badge-warning">Belum Lengkap</span>';
				} else {
					$badge	= '<span class="badge badge-danger">Belum Dikirim</span>';
				}
				$add[$i] = $badge;
			}
			$data['judul']		= 'Pilih Data';
			$data['detail']		= $isi;
			$data['badge']		= $add;
			$data['link']		= 'klien/permintaan_data_akuntansi/kirim/';
			
			$this->load->view('klien/permintaan_akuntansi/data', $data);
		}
		
		public function kirim($id_data) {
			$detail = $this->M_Pengiriman_akuntansi->getById($id_data);
			if($detail['status_kirim'] == 'yes') {
				$detail['badge'] = '<span class="badge badge-success">Lengkap</span>';
			} elseif($detail['status_kirim'] == 'no') {
				$detail['badge'] = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$detail['badge'] = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			
			$data['judul']		= "Kirim Data";
			$data['detail']		= $detail;
			$data['pengiriman']	= $this->M_Pengiriman_akuntansi->getDetail($id_data);
			$data['back']		= 'klien/permintaan_data_akuntansi';
			
			$this->form_validation->set_rules('id_data', 'ID Data', 'required');
			if($detail['format_data'] == 'Hardcopy') {
				$this->form_validation->set_rules('tanggal_ambil', 'Tanggal Ambil', 'required');
			}
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_akuntansi/kirim', $data);
			} else {
				$send = $this->M_Pengiriman_akuntansi->kirim();
				if($send == 'ERROR') {
					$this->session->set_flashdata('flash', 'Format file tidak sesuai!');
				} elseif($send == 'OK') {
					$this->session->set_flashdata('notification', 'Data berhasil dikirim!');
				}
				redirect('klien/permintaan_data_akuntansi/kirim/'.$id_data);
			}
		}
	}
?>