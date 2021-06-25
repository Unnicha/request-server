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
				$btn	= '
				<a href="#" class="btn btn-sm btn-info btn-detail_pengiriman" data-nilai="'.$k['id_pengiriman'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Pengiriman">
						<i class="bi bi-info-circle"></i>
					</a>';
				if($k['pembetulan'] == 1) {
					$btn .= '
					<a href="pengiriman_data_akuntansi/revisi/'.$k['id_permintaan'].'" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Kirim Revisi">
					<i class="bi bi-file-earmark-arrow-up"></i>
					</a>';
				}
				
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
				$row[]	= $k['request'];
				$row[]	= $k['pembetulan'];
				$row[]	= implode('<br>', $date);
				$row[]	= implode('<br>', $badge);
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
		
		public function lengkapi($id_pengiriman) {
			$pengiriman	= $this->M_Pengiriman_akuntansi->getById($id_pengiriman);
			$isi		= $this->M_Pengiriman_akuntansi->getDetail($pengiriman['id_permintaan']);
			$num=0;
			foreach($isi as $i => $val) {
				if($val['status'] == 0 || $val['status'] == 2) {
					if($val['status'] == 0) {
						$badge	= '<span class="badge badge-danger">Belum Dikirim</span>';
					} else {
						$badge	= '<span class="badge badge-warning">Kurang Lengkap</span>';
					}
					
					$add[++$num]	= [ 'status'	=> $badge, ];
				} else {
					unset($isi[$i]);
				}
			}
			
			$data['judul']			= "Lengkapi Permintaan - Data Akuntansi";
			$data['id_permintaan']	= $pengiriman['id_permintaan'];
			$data['isi']			= $isi;
			$data['add']			= $add;
			
			$this->form_validation->set_rules('id_permintaan', 'ID Pengiriman', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/pengiriman_akuntansi/lengkapi', $data);
			} else {
				$send = $this->M_Pengiriman_akuntansi->kirim();
				if($send == 'ERROR') {
					redirect('klien/pengiriman_data_akuntansi/lengkapi/'.$id_pengiriman);
				} else {
					if($send == 'OK') {
						$this->session->set_flashdata('notification', 'Data berhasil dikirim!'); 
					}
					redirect('klien/pengiriman_data_akuntansi'); 
				}
			}
		}
		
		public function revisi($id_permintaan) {
			$permintaan	= $this->M_Permintaan_akuntansi->getById($id_permintaan);
			$isi		= $this->M_Permintaan_akuntansi->getDetail($id_permintaan);
			
			$data['judul']			= "Form Revisi - Data Akuntansi"; 
			$data['permintaan']		= $permintaan;
			$data['isi']			= $isi;
			$data['batal']			= 'klien/pengiriman_data_akuntansi';
			
			$this->form_validation->set_rules('id_permintaan', 'File', 'required');
			$this->form_validation->set_rules('keterangan[]', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_akuntansi/kirim', $data);
			} else {
				$send = $this->M_Pengiriman_akuntansi->kirim();
				if($send == 'ERROR') {
					redirect('klien/pengiriman_data_akuntansi/revisi/'.$id_permintaan);
				} else {
					if($send == 'OK') {
						$this->session->set_flashdata('notification', 'Data berhasil dikirim!'); 
					}
					redirect('klien/pengiriman_data_akuntansi');
				}
			}
		}
		
		public function detail() {
			$pengiriman	= $this->M_Pengiriman_akuntansi->getById($this->input->post('action', true));
			$isi		= $this->M_Pengiriman_akuntansi->getDetail($pengiriman['id_permintaan']);
			$bulan		= $this->Klien_model->getMasa($pengiriman['bulan']);
			$lokasi		= 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/';
			$button		= false;
			$num=0;
			foreach($isi as $i) {
				$linkFile	= '<a href="'. base_url() . $lokasi . $i['file'].'">'. $i['file'] .'</a>';
				
				if($i['status'] == 1) {
					$badge = '<span class="badge badge-warning">Belum Dikonfirmasi</span>';
				} elseif($i['status'] == 2) {
					$badge = '<span class="badge badge-danger">Kurang Lengkap</span>'; $button = true;
				} elseif($i['status'] == 3) {
					$badge = '<span class="badge badge-success">Sudah Dikonfirmasi</span>';
				} else {
					$badge = '<span class="badge badge-danger">Belum Dikirim</span>'; $button = true;
				}
				
				$add[++$num] = [
					'file_title'	=> ($i['format_data'] == 'Softcopy') ? 'File' : 'Tanggal Ambil',
					'file'			=> ($i['format_data'] == 'Softcopy') ? $linkFile : $i['file'],
					'status'		=> $badge,
				];
			}
			
			$data['judul']		= 'Detail Pengiriman Data';
			$data['pengiriman']	= $pengiriman;
			$data['bulan']		= $bulan['nama_bulan'];
			$data['button']		= $button;
			$data['isi']		= $isi;
			$data['add']		= $add;
			
			$this->load->view('klien/pengiriman_akuntansi/detail', $data);
		}
	}
?>