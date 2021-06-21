<?php
	
	class Pengiriman_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Klien_model');
			$this->load->model('M_Permintaan_perpajakan');
			$this->load->model('M_Pengiriman_perpajakan');
			$this->load->model('Jenis_data_model');
		} 
		
		public function index() {
			
			$data['judul']	= "Pengiriman Data Perpajakan"; 
			$data['masa']	= $this->Klien_model->getMasa();

			$this->libtemplate->main('klien/pengiriman_perpajakan/tampil', $data);
		}
		
		public function page() {
			$bulan	= $_POST['bulan'];
			$tahun	= $_POST['tahun'];
			$klien	= $this->session->userdata('id_user');
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			
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
				if($k['pembetulan'] == 1) {
					$btn .= '
						<a href="pengiriman_data_perpajakan/revisi/'.$k['id_permintaan'].'" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Kirim Revisi">
							<i class="bi bi-file-earmark-arrow-up"></i>
						</a>';
				}
				
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
				foreach($date as $d=>$val) {
					if($val == '') unset($date[$d]);
				}
				sort($date);
				
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
			$permintaan		= $this->M_Permintaan_perpajakan->getById($id_permintaan);
			$kode_jenis		= explode('|', $permintaan['kode_jenis']);
			foreach($kode_jenis as $kode) {
				$jenis_data[] = $this->Jenis_data_model->getById($kode);
			}
			
			$data['judul']			= "Form Revisi - Data Perpajakan"; 
			$data['permintaan']		= $permintaan;
			$data['jenis_data']		= $jenis_data;
			$data['format_data']	= explode('|', $permintaan['format_data']);
			$data['detail']			= explode('|', $permintaan['detail']);
			$data['batal']			= 'klien/pengiriman_data_perpajakan';
			
			$this->form_validation->set_rules('id_permintaan', 'File', 'required');
			$this->form_validation->set_rules('keterangan[]', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_perpajakan/kirim', $data);
				//$this->libtemplate->main('klien/pengiriman_perpajakan/revisi', $data);
			} else {
				$send = $this->M_Pengiriman_perpajakan->kirim();
				if($send == 'ERROR') {
					redirect('klien/pengiriman_data_perpajakan/revisi/'.$id_permintaan);
				} else {
					if($send == 'OK') {
						$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
					}
					redirect('klien/pengiriman_data_perpajakan');
				}
			}
		}
		
		public function lengkapi($id_pengiriman) {
			$pengiriman		= $this->M_Pengiriman_perpajakan->getById($id_pengiriman);
			$kode_jenis		= explode('|', $pengiriman['kode_jenis']);
			foreach($kode_jenis as $kode) {
				$jenis_data[] = $this->Jenis_data_model->getById($kode);
			}
			$formatData		= explode('|', $pengiriman['format_data']);
			$detail			= explode('|', $pengiriman['detail']);
			$status			= explode('|', $pengiriman['status']);
			$keterangan2	= ($pengiriman['keterangan2']) ? explode('|', $pengiriman['keterangan2']) : $pengiriman['keterangan2'];
			
			for($i=0; $i<count($jenis_data); $i++) {
				if($status[$i] == 0 || $status[$i] == 2) {
					if($status[$i] == 0) {
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
			
			$data['judul']			= "Lengkapi Permintaan - Data Perpajakan";
			$data['id_pengiriman']	= $pengiriman['id_pengiriman'];
			$data['isi']			= $isi;
			
			$this->form_validation->set_rules('id_pengiriman', 'ID Pengiriman', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/pengiriman_perpajakan/lengkapi', $data);
			} else {
				$send = $this->M_Pengiriman_perpajakan->ubah();
				if($send == 'ERROR') {
					redirect('klien/pengiriman_data_perpajakan/lengkapi/'.$id_pengiriman);
				} else {
					if($send == 'OK') {
						$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
					}
					redirect('klien/pengiriman_data_perpajakan'); 
				}
			}
		}
		
		public function detail() {
			$pengiriman		= $this->M_Pengiriman_perpajakan->getById($this->input->post('action', true));
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
			$button		= false;
			
			for($i=0; $i<count($jenis_data); $i++) {
				$linkFile	= '<a href="'. base_url() . $lokasi . $files[$i].'">'. $files[$i] .'</a>';
				$fileTitle	= ($formatData[$i] == 'Softcopy') ? 'File' : 'Tanggal Ambil';
				$file		= ($formatData[$i] == 'Softcopy') ? $linkFile : $files[$i];
				
				if($status[$i] == 0) {
					$badge = '<span class="badge badge-danger">Belum Dikirim</span>'; $button = true;
				} elseif($status[$i] == 1) {
					$badge = '<span class="badge badge-warning">Belum Dikonfirmasi</span>';
				} elseif($status[$i] == 3) {
					$badge = '<span class="badge badge-success">Sudah Dikonfirmasi</span>';
				} else {
					$badge = '<span class="badge badge-danger">Kurang Lengkap</span>'; $button = true;
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
			$data['button']		= $button;
			$data['isi']		= $isi;
			
			$this->load->view('klien/pengiriman_perpajakan/detail', $data);
		}
	}
?>