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
				$badge = []; $date = [];
				$detail = $this->M_Pengiriman_lainnya->getDetail($k['id_permintaan']);
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
		
		public function klien() {
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$id_akuntan	= $this->session->userdata('id_user');
			
			$bulan		= $this->Klien_model->getMasa($bulan);
			$akses		= $this->Akses_model->getByAkuntan($tahun, $id_akuntan);
			if($bulan['id_bulan'] < $akses['masa']) {
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
			$pengiriman	= $this->M_Pengiriman_lainnya->getById($id_pengiriman);
			$isi		= $this->M_Pengiriman_lainnya->getDetail($pengiriman['id_permintaan']);
			$lokasi		= 'asset/uploads/'.$pengiriman['nama_klien'].'/'.$pengiriman['tahun'].'/';
			
			foreach($isi as $i => $val) {
				$linkFile = '<a href="'. base_url() . $lokasi . $val['file'].'">'. $val['file'] .'</a>';
				if($val['status'] == 1) {
					$add[] = [
						'file_title'	=> ($val['format_data'] == 'Softcopy') ? 'File' : 'Tanggal Ambil',
						'file'			=> ($val['format_data'] == 'Softcopy') ? $linkFile : $val['file'],
					];
				} else {
					unset($isi[$i]);
				}
			}
			
			$data['judul']			= "Konfirmasi Pengiriman - Data Lainnya"; 
			$data['id_permintaan']	= $pengiriman['id_permintaan'];
			$data['isi']			= $isi;
			$data['add']			= $add;
			
			$this->form_validation->set_rules('id_permintaan', 'ID Permintaan', 'required');
			$this->form_validation->set_rules('status[]', 'Status', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/penerimaan_lainnya/konfirmasi', $data);
			} else {
				if($this->M_Pengiriman_lainnya->konfirmasi() == 'OK') {
					$this->session->set_flashdata('notification', 'Data berhasil dikonfirmasi!');
				}
				redirect('akuntan/penerimaan_data_lainnya');
			}
		}
		
		public function detail() {
			$pengiriman	= $this->M_Pengiriman_lainnya->getById($this->input->post('action', true));
			$isi		= $this->M_Pengiriman_lainnya->getDetail($pengiriman['id_permintaan']);
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
			
			$this->load->view('akuntan/penerimaan_lainnya/detail', $data);
		}
	}
?>