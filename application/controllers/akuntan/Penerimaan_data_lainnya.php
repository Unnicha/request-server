<?php
	
	class Penerimaan_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Pengiriman_lainnya');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('Jenis_data_model');
		}
		
		public function index() {
			
			$data['judul']	= "Penerimaan Data Lainnya";
			$data['masa']	= $this->Klien_model->getMasa();
			$data['klien']	= $this->Klien_model->getAllKlien();
			
			$this->libtemplate->main('akuntan/penerimaan_lainnya/tampil', $data);
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
				$masa		= $this->Klien_model->getMasa($bulan);
				$akses		= $this->Akses_model->getByAkuntan($tahun, $id_akuntan);
				if( $akses ) {
					if($masa['id_bulan'] < $akses['masa']) {
						$akses = $this->Akses_model->getByAkuntan(($tahun-1), $id_akuntan);
					}
					if( $akses ) {
						$klien = explode(',', $akses['klien']);
					}
				}
			}
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Pengiriman_lainnya->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_lainnya->getByMasa($bulan, $tahun, $klien, $offset, $limit);

			$data = [];
			foreach($pengiriman as $k) {
				$badge	= '';
				$status	= explode('|', $k['status']);
				if(in_array(0, $status)) {
					$badge .= '<span class="badge badge-danger">Belum Dikirim</span><br>';
				} if(in_array(1, $status)) {
					$badge .= '<span class="badge badge-warning">Belum Dikonfirmasi</span><br>';
				} if(in_array(2, $status)) {
					$badge .= '<span class="badge badge-danger">Kurang Lengkap</span><br>';
				} if(in_array(3, $status)) {
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
		
		public function klien() {
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$id_akuntan	= $this->session->userdata('id_user');
			
			$bulan		= $this->Klien_model->getMasa($bulan);
			$akses		= $this->Akses_model->getByAkuntan($tahun, $id_akuntan);
			if($bulan['id_bulan'] < ((int)$akses['masa'])) {
				$akses = $this->Akses_model->getByAkuntan($tahun - 1, $id_akuntan);
			}
			if($akses == null) {
				$lists = "<option value=''>--Tidak ada akses--</option>";
			} else {
				$lists		= "<option value=''>Semua Klien</option>";
				$id_klien	= explode(",", $akses['klien']);
				foreach($id_klien as $id) {
					$klien	= $this->Klien_model->getById($id);
					$lists .= "<option value='".$klien['id_klien']."'>".$klien['nama_klien']."</option>"; 
				} 
			}
			echo $lists;
		}
		
		public function konfirmasi($id_pengiriman) {
			$pengiriman		= $this->M_Pengiriman_lainnya->getById($id_pengiriman);
			$kode_jenis		= explode('|', $pengiriman['kode_jenis']);
			foreach($kode_jenis as $kode) {
				$jenis_data[] = $this->Jenis_data_model->getById($kode);
			}
			$lokasi			= 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/'; 
			$format_data	= explode('|', $pengiriman['format_data']);
			$detail			= explode('|', $pengiriman['detail']);
			$file			= explode('|', $pengiriman['file']);
			$status			= explode('|', $pengiriman['status']);
			$keterangan2	= ($pengiriman['keterangan2']) ? explode('|', $pengiriman['keterangan2']) : null;
			
			for($i=0; $i<count($jenis_data); $i++) {
				$linkFile = '<a href="'. base_url() . $lokasi . $file[$i].'">'. $file[$i] .'</a>';
				if($status[$i] == 1 || $status[$i] == 2) {
					$isi[] = [
						'jenis_data'	=> $jenis_data[$i]['jenis_data'],
						'detail'		=> $detail[$i],
						'format_data'	=> $format_data[$i],
						'fileTitle'		=> ($format_data == 'Softcopy') ? 'File' : 'Tanggal Ambil',
						'file'			=> ($format_data == 'Softcopy') ? $linkFile : $file[$i],
						'status'		=> $status[$i],
						'keterangan2'	=> ($keterangan2) ? $keterangan2[$i] : '',
					];
				}
			}
			
			$data['judul']			= "Konfirmasi Pengiriman - Data Lainnya"; 
			$data['id_pengiriman']	= $pengiriman['id_pengiriman'];
			$data['isi']			= $isi;
			$data['status']			= $status;
			$data['tgl_kirim']		= explode('|', $pengiriman['tanggal_pengiriman']);
			
			$this->form_validation->set_rules('id_pengiriman', 'ID Pengiriman', 'required');
			$this->form_validation->set_rules('status[]', 'Status', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/penerimaan_lainnya/konfirmasi', $data);
			} else {
				$this->M_Pengiriman_lainnya->konfirmasi();
				$this->session->set_flashdata('notification', 'Data berhasil dikonfirmasi!');
				redirect('akuntan/penerimaan_data_lainnya');
			}
		}
		
		public function detail() {
			$id_pengiriman	= $this->input->post('action', true);
			$pengiriman		= $this->M_Pengiriman_lainnya->getById($id_pengiriman);
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
				
				if($status[$i] == 0) {
					$badge = '<span class="badge badge-danger">Belum Dikirim</span>';
				} elseif($status[$i] == 1) {
					$badge = '<span class="badge badge-warning">Belum Dikonfirmasi</span>';
				} elseif($status[$i] == 3) {
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
			$data['button']		= (in_array(1, $status)) ? true : false;
			$data['isi']		= $isi;
			
			$this->load->view('akuntan/penerimaan_lainnya/detail', $data);
		}
	}
?>