<?php
	
	class Penerimaan_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('exportpengiriman');
			
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('Jenis_data_model');
			$this->load->model('Klien_model');
		}
		
		public function index() {
			$data['judul']	= "Penerimaan Data Akuntansi";
			$data['masa']	= $this->Klien_model->getMasa();
			$data['klien']	= $this->Klien_model->getAllKlien();
			
			$this->libtemplate->main('admin/penerimaan_akuntansi/tampil', $data);
		}
		
		public function page() {
			$klien = $_POST['klien'];
			$bulan	= $_POST['bulan'];
			$tahun	= $_POST['tahun'];
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			if($klien == null) 
				{ $klien = 'all'; }
			$countData	= $this->M_Pengiriman_akuntansi->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_akuntansi->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($pengiriman as $k) {
				$badge = []; $date = [];
				$detail = $this->M_Pengiriman_akuntansi->getDetail($k['id_permintaan']);
				foreach($detail as $d) {
					if($d['status'] == 1) {
						$badge[] = '<span class="badge badge-warning">Belum Dikonfirmasi</span>';
					} elseif($d['status'] == 2) {
						$badge[] = '<span class="badge badge-danger">Kurang Lengkap</span>';
					} elseif($d['status'] == 3) {
						$badge[] = '<span class="badge badge-success">Sudah Dikonfirmasi</span>';
					} else {
						$badge[] = '<span class="badge badge-danger">Belum Dikirim</span>';
					}
					
					if($d['tanggal_pengiriman']) {
						$date[] = $d['tanggal_pengiriman'];
					}
				}
				$badge	= array_unique($badge);	sort($badge);
				$date	= array_unique($date);	sort($date);
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['request'];
				$row[]	= $k['pembetulan'];
				$row[]	= implode('<br>', $date);
				$row[]	= implode('<br>', $badge);
				$row[]	= '
					<a class="btn btn-sm btn-primary btn-detail_pengiriman" data-toggle="tooltip" data-nilai="'.$k['id_pengiriman'].'" data-placement="bottom" title="Detail Pengiriman">
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

		public function detail() {
			$pengiriman	= $this->M_Pengiriman_akuntansi->getById($this->input->post('action', true));
			$isi		= $this->M_Pengiriman_akuntansi->getDetail($pengiriman['id_permintaan']);
			$lokasi		= 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/'; 
			$button		= false;
			$num=0;
			foreach($isi as $i) {
				$linkFile = '<a href="'. base_url() . $lokasi . $i['file'].'">'. $i['file'] .'</a>';
				
				if($i['status'] == 1) {
					$badge = '<span class="badge badge-warning">Belum Dikonfirmasi</span>'; $button = true;
				} elseif($i['status'] == 2) {
					$badge = '<span class="badge badge-danger">Kurang Lengkap</span>';
				} elseif($i['status'] == 3) {
					$badge = '<span class="badge badge-success">Sudah Dikonfirmasi</span>';
				} else {
					$badge = '<span class="badge badge-danger">Belum Dikirim</span>';
				}
				
				$add[++$num]	= [
					'file_title'	=> ($i['format_data'] == 'Softcopy') ? 'File' : 'Tanggal Ambil',
					'file'			=> ($i['format_data'] == 'Softcopy') ? $linkFile : $i['file'],
					'status'		=> $badge,
				];
			}
			
			$data['judul']		= 'Detail Pengiriman Data';
			$data['pengiriman']	= $pengiriman;
			$data['button']		= $button;
			$data['isi']		= $isi;
			$data['add']		= $add;
			
			$this->load->view('admin/penerimaan_akuntansi/detail', $data);
		}
		
		public function cetak() {
			$data['bulan']	= $this->input->post('bulan', true);
			$data['tahun']	= $this->input->post('tahun', true);
			$data['klien']	= $this->input->post('klien', true);

			$data['filename']	= "Permintaan Data Akuntansi ".$data['bulan']." ".$data['tahun'];
			$data['judul']		= "Permintaan Data Akuntansi";
			$data['klien']		= $this->Klien_model->getAllKlien();
			foreach($data['klien'] as $k) {
				$perklien	= $this->M_Permintaan_akuntansi->getReqByKlien($data['bulan'], $data['tahun'], $k['id_klien']);
				$permintaan[$k['id_klien']] = $perklien;
			}
			$data['permintaan'] = $permintaan;
			
			if($this->input->post('xls', true))
				return $this->exportpengiriman->exportExcel($data);
			elseif($this->input->post('pdf', true))
				return $this->exportpengiriman->exportPdf($data);
		}
	}
?>