<?php
	
	class Pengiriman_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Klien_model');
			$this->load->model('M_Permintaan_lainnya');
			$this->load->model('M_Pengiriman_lainnya');
			$this->load->model('Jenis_data_model');
		} 
		
		public function index() {
			
			$data['judul']	= "Pengiriman Data Lainnya"; 
			$data['masa']	= $this->Klien_model->getMasa();

			$this->libtemplate->main('klien/pengiriman_lainnya/tampil', $data);
		}
		
		public function page() {
			$bulan	= $_POST['bulan'];
			$tahun	= $_POST['tahun'];
			$klien	= $this->session->userdata('id_user');
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Pengiriman_lainnya->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_lainnya->getByMasa($bulan, $tahun, $klien, $offset, $limit);

			$data = [];
			foreach($pengiriman as $k) {
				$btn	= '
					<a href="#" class="btn btn-sm btn-info btn-detail_pengiriman" data-nilai="'.$k['id_pengiriman'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Pengiriman">
						<i class="bi bi-info-circle"></i>
					</a>';
				if($k['pembetulan'] == 1) {
					$btn .= '
						<a href="pengiriman_data_lainnya/revisi/'.$k['id_permintaan'].'" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Kirim Revisi">
							<i class="bi bi-file-earmark-arrow-up"></i>
						</a>';
				}
				
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
				foreach($date as $d=>$val) {
					if($val == '') unset($date[$d]);
				}
				sort($date);
				/*
				$tanggal	= array_unique($date);
				$tanggal_pengiriman	= '';
				for($i=0; $i<count($date); $i++) {
					if(isset($tanggal[$i]) && $tanggal[$i] != '') {
						$tanggal_pengiriman .= $tanggal[$i];
						if(isset($tanggal[$i+1]) && $tanggal[$i+1] != '')
						{ $tanggal_pengiriman .= '<br>'; }
					}
				}*/
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['request'];
				$row[]	= $k['pembetulan'];
				$row[]	= $date[0];
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
		
		public function revisi($id_permintaan) {
			$permintaan		= $this->M_Permintaan_lainnya->getById($id_permintaan);
			$kode_jenis		= explode('|', $permintaan['kode_jenis']);
			foreach($kode_jenis as $kode) {
				$jenis_data[] = $this->Jenis_data_model->getById($kode);
			}
			
			$data['judul']			= "Form Revisi - Data Lainnya"; 
			$data['permintaan']		= $permintaan;
			$data['jenis_data']		= $jenis_data;
			$data['format_data']	= explode('|', $permintaan['format_data']);
			$data['detail']			= explode('|', $permintaan['detail']);
			$data['batal']			= 'klien/pengiriman_data_lainnya';
			
			$this->form_validation->set_rules('id_permintaan', 'File', 'required');
			$this->form_validation->set_rules('keterangan[]', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_lainnya/kirim', $data);
				//$this->libtemplate->main('klien/pengiriman_lainnya/revisi', $data);
			} else {
				$send = $this->M_Pengiriman_lainnya->kirim();
				if($send == 'ERROR') {
					redirect('klien/pengiriman_data_lainnya/revisi/'.$id_permintaan);
				} else {
					if($send == 'OK') {
						$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
					}
					redirect('klien/pengiriman_data_lainnya');
				}
			}
		}
		
		public function lengkapi($id_pengiriman) {
			$pengiriman		= $this->M_Pengiriman_lainnya->getById($id_pengiriman);
			$kode_jenis		= explode('|', $pengiriman['kode_jenis']);
			foreach($kode_jenis as $kode) {
				$jenis_data[] = $this->Jenis_data_model->getById($kode);
			}
			$formatData		= explode('|', $pengiriman['format_data']);
			$detail			= explode('|', $pengiriman['detail']);
			$status			= explode('|', $pengiriman['status']);
			$keterangan2	= ($pengiriman['keterangan2']) ? explode('|', $pengiriman['keterangan2']) : $pengiriman['keterangan2'];
			
			for($i=0; $i<count($jenis_data); $i++) {
				if($status[$i] == 'kosong' || $status[$i] == 'kurang') {
					if($status[$i] == 'kosong') {
						$badge	= '<span class="badge badge-danger">Belum Dikirim</span>';
					} else {
						$badge	= '<span class="badge badge-warning">Kurang Lengkap</span>';
					}
					
					$isi[]	= [
						'jenis_data'	=> $jenis_data[$i]['jenis_data'],
						'detail'		=> $detail[$i],
						'format_data'	=> $formatData[$i],
						'note'			=> (is_array($keterangan2)) ? $keterangan2[$i] : $keterangan2,
						'status'		=> $status[$i],
						'statusBadge'	=> $badge,
					];
				}
			}
			
			$data['judul']			= "Lengkapi Permintaan - Data Lainnya";
			$data['id_pengiriman']	= $pengiriman['id_pengiriman'];
			$data['isi']			= $isi;
			
			$this->form_validation->set_rules('id_pengiriman', 'ID Pengiriman', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/pengiriman_lainnya/lengkapi', $data);
			} else {
				$send = $this->M_Pengiriman_lainnya->ubah();
				if($send == 'ERROR') {
					redirect('klien/pengiriman_data_lainnya/lengkapi/'.$id_pengiriman);
				} else {
					if($send == 'OK') {
						$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
					}
					redirect('klien/pengiriman_data_lainnya'); 
				}
			}
		}
		
		public function detail() {
			$pengiriman		= $this->M_Pengiriman_lainnya->getById($this->input->post('action', true));
			$bulan			= $this->Klien_model->getMasa($pengiriman['bulan']);
			$kode_jenis		= explode('|', $pengiriman['kode_jenis']);
			foreach($kode_jenis as $kode) {
				$jenis_data[] = $this->Jenis_data_model->getById($kode);
			}
			
			$lokasi		= 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/'; 
			$detail		= explode('|', $pengiriman['detail']);
			$formatData	= explode('|', $pengiriman['format_data']);
			$tanggal	= explode('|', $pengiriman['tanggal_pengiriman']);
			$files		= explode('|', $pengiriman['file']);
			$keterangan	= explode('|', $pengiriman['keterangan']);
			$status		= explode('|', $pengiriman['status']);
			
			for($i=0; $i<count($jenis_data); $i++) {
				$linkFile	= '<a href="'. base_url() . $lokasi . $files[$i].'">'. $files[$i] .'</a>';
				$fileTitle	= ($formatData[$i] == 'Softcopy') ? 'File' : 'Tanggal Ambil';
				$file		= ($formatData[$i] == 'Softcopy') ? $linkFile : $files[$i];
				
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
					'file_title'	=> $fileTitle,
					'file'			=> $file,
					'note'			=> $keterangan[$i],
					'status'		=> $badge,
				];
			}
			
			$data['judul']		= 'Detail Pengiriman Data';
			$data['pengiriman']	= $pengiriman;
			$data['bulan']		= $bulan['nama_bulan'];
			$data['button']		= (in_array('kosong', $status) || in_array('kurang', $status)) ? true : false;
			$data['isi']		= $isi;
			
			$this->load->view('klien/pengiriman_lainnya/detail', $data);
		}
	}
?>