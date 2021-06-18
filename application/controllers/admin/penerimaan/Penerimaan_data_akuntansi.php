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
				$badge	= '';
				$status	= explode('|', $k['status']);
				if(in_array('kosong', $status)) {
					$badge .= '<span class="badge badge-danger">Belum Dikirim</span><br>';
				} if(in_array('belum', $status)) {
					$badge .= '<span class="badge badge-warning">Belum Dikonfirmasi</span><br>';
				} if(in_array('kurang', $status)) {
					$badge .= '<span class="badge badge-danger">Kurang Lengkap</span><br>';
				} if(in_array('lengkap', $status)) {
					$badge .= '<span class="badge badge-success">Sudah Dikonfirmasi</span>';
				}
				
				$date		= explode('|', $k['tanggal_pengiriman']);
				foreach($date as $d => $val) {
					if($val == '') unset($date[$d]);
				}
				sort($date);
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['request'];
				$row[]	= $k['pembetulan'];
				$row[]	= $date[0];
				$row[]	= $badge;
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
			$id_pengiriman	= $this->input->post('action', true);
			$pengiriman		= $this->M_Pengiriman_akuntansi->getById($id_pengiriman);
			$kode_jenis		= explode('|', $pengiriman['kode_jenis']);
			foreach($kode_jenis as $kode) {
				$jenis_data[] = $this->Jenis_data_model->getById($kode);
			}
			
			$lokasi			= 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/'; 
			$detail			= explode('|', $pengiriman['detail']);
			$tanggal		= explode('|', $pengiriman['tanggal_pengiriman']);
			$formatData		= explode('|', $pengiriman['format_data']);
			$files			= explode('|', $pengiriman['file']);
			$keterangan		= explode('|', $pengiriman['keterangan']);
			$status			= explode('|', $pengiriman['status']);
			$keterangan2	= ($pengiriman['keterangan2']) ? explode('|', $pengiriman['keterangan2']) : null;
			
			for($i=0; $i<count($jenis_data); $i++) {
				$linkFile = '<a href="'. base_url() . $lokasi . $files[$i].'">'. $files[$i] .'</a>';
				
				if($status[$i] == 'kosong') {
					$badge = '<span class="badge badge-danger">Belum Dikirim</span>';
				} elseif($status[$i] == 'belum') {
					$badge = '<span class="badge badge-warning">Belum Dikonfirmasi</span>';
				} elseif($status[$i] == 'lengkap') {
					$badge = '<span class="badge badge-success">Sudah Dikonfirmasi</span>';
				} else {
					$badge = '<span class="badge badge-danger">Kurang Lengkap</span>';
				}
				
				$isi[]	= [
					'jenis_data'	=> $jenis_data[$i]['jenis_data'],
					'detail'		=> $detail[$i],
					'tanggal'		=> $tanggal[$i],
					'format'		=> $formatData[$i],
					'file_title'	=> ($formatData[$i] == 'Softcopy') ? 'File' : 'Tanggal Ambil',
					'file'			=> ($formatData[$i] == 'Softcopy') ? $linkFile : $files[$i],
					'note'			=> $keterangan[$i],
					'status'		=> $status[$i],
					'statusBadge'	=> $badge,
					'keterangan'	=> ($keterangan2) ? $keterangan2[$i] : '',
				];
			}
			
			$data['judul']		= 'Detail Pengiriman Data';
			$data['pengiriman']	= $pengiriman;
			$data['button']		= (in_array('belum', $status)) ? true : false;
			$data['isi']		= $isi;
			
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