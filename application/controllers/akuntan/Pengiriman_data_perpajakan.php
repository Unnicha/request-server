<?php
	
	class Pengiriman_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('exportpengiriman');
			
			$this->load->model('M_Permintaan_perpajakan');
			$this->load->model('M_Pengiriman_perpajakan');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('Jenis_data_model');
		}
		
		public function index() {
			$data['judul']	= "Pengiriman Data Perpajakan";
			$data['masa']	= $this->Klien_model->getMasa();
			
			$this->libtemplate->main('akuntan/pengiriman_perpajakan/tampil', $data);
		}
		
		public function page() {
			$klien	= $_POST['klien'];		$this->session->set_flashdata('klien', $klien);
			$tahun	= $_POST['tahun'];		$this->session->set_userdata('tahun', $tahun);
			$bulan	= $_POST['bulan'];		$this->session->set_userdata('bulan', $bulan);
			
			// jika tidak ada klien dipilih, tampilkan data klien berdasarkan akses
			if($klien == null) {
				$klien	= [];
				$id		= $this->session->userdata('id_user');
				$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan, $id, 'perpajakan');
				$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $id, 'perpajakan');
				if( $akses ) {
					foreach($akses as $a) {
						$klien[] = $a['kode_klien'];
					}
				} else $klien = null;
			}
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Pengiriman_perpajakan->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_perpajakan->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($pengiriman as $val) {
				$detail	= $this->M_Permintaan_perpajakan->countDetail($val['id_permintaan']);
				$badge	= '';
				if($detail['jumYes'] > 0)
					$badge .= '<span class="badge badge-success mr-1" data-toggle="tooltip" data-placement="bottom" title="Lengkap">'.$detail['jumYes'].'</span>';
				if($detail['jumNo'] > 0)
					$badge .= '<span class="badge badge-warning mr-1" data-toggle="tooltip" data-placement="bottom" title="Belum Lengkap">'.$detail['jumNo'].'</span>';
				if($detail['jumNull'] > 0)
					$badge .= '<span class="badge badge-danger mr-1" data-toggle="tooltip" data-placement="bottom" title="Belum Dikirim">'.$detail['jumNull'].'</span>';
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $val['nama_klien'];
				$row[]	= $val['id_permintaan'];
				$row[]	= $val['request'];
				$row[]	= $val['tanggal_permintaan'];
				$row[]	= $detail['jumAll'];
				$row[]	= $badge;
				$row[]	= '
					<a class="btn-detail" data-toggle="tooltip" data-nilai="'.$val['id_permintaan'].'" data-placement="bottom" title="Detail Pengiriman">
						<i class="bi bi-info-circle-fill" style="font-size:20px; line-height:80%"></i>
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
		
		public function klien() {
			$bulan		= $this->input->post('bulan', true);
			$tahun		= $this->input->post('tahun', true);
			$id_akuntan	= $this->session->userdata('id_user');
			
			$bulan	= $this->Klien_model->getMasa($bulan)['id_bulan'];
			$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan, $id_akuntan, 'perpajakan');
			$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $id_akuntan, 'perpajakan');
			
			$lists	= "<option value=''>--Tidak ada akses--</option>";
			if( $akses ) {
				$lists		= "<option value=''>--Semua Klien--</option>";
				foreach($akses as $a) {
					$lists .= "<option value='".$a['id_klien']."'>".$a['nama_klien']."</option>"; 
				}
			}
			echo $lists;
		}
		
		public function detail() {
			$id_permintaan	= $_REQUEST['id'];
			$permintaan		= $this->M_Permintaan_perpajakan->getById($id_permintaan);
			$isi			= $this->M_Permintaan_perpajakan->getDetail($id_permintaan);
			
			// tampilan bagde masing2 data(isi) berdasarkan status pengiriman
			foreach($isi as $i => $val) {
				if($val['status_kirim'] == 'yes') {
					$badge	= '<span class="badge badge-success">Lengkap</span>';
				} elseif($val['status_kirim'] == 'no') {
					$badge	= '<span class="badge badge-warning">Belum Lengkap</span>';
				} else {
					$badge	= '<span class="badge badge-danger">Belum Dikirim</span>';
				}
				// masukkan badge ke array
				$add[$i] = $badge;
			}
			
			$data['judul']		= 'Detail Pengiriman';
			$data['permintaan']	= $permintaan;
			$data['detail']		= $isi;
			$data['badge']		= $add;
			$data['link']		= 'akuntan/pengiriman_data_perpajakan/detail/';
			
			$this->load->view('akuntan/pengiriman_perpajakan/detail', $data);
		}
		
		public function detail_pengiriman($id_data) {
			$detail		= $this->M_Pengiriman_perpajakan->getById($id_data);
			$pengiriman	= $this->M_Pengiriman_perpajakan->getDetail($id_data);
			
			// tampilan bagde berdasarkan status pengiriman
			if($detail['status_kirim'] == 'yes') {
				$detail['badge'] = '<span class="badge badge-success">Lengkap</span>';
			} elseif($detail['status_kirim'] == 'no') {
				$detail['badge'] = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$detail['badge'] = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			
			// tampilkan button berdasarkan status pengiriman
			$button = '';
			if(count($pengiriman)>0 && $detail['status_proses'] != 'done') {
				if($detail['status_kirim'] != 'yes') {
					$button = '<a href="#" class="btn btn-sm btn-primary btn-konfirm float-md-right" data-id="'.$detail['id_data'].'" data-status="yes" data-toggle="tooltip" data-placement="bottom" title="Konfirmasi kelengkapan data">Konfirmasi</a>';
				} else {
					$button = '<a href="#" class="btn btn-sm btn-danger btn-konfirm float-md-right" data-id="'.$detail['id_data'].'" data-status="no" data-toggle="tooltip" data-placement="bottom" title="Batalkan konfirmasi">Batal Konfirmasi</a>';
				}
			}
			
			$detail['button']	= $button;
			$data['judul']		= "Detail Pengiriman"; 
			$data['detail']		= $detail;
			$data['pengiriman']	= $pengiriman;
			$data['link']		= "asset/uploads/".$detail['nama_klien']."/".$detail['tahun']."/";
			
			$this->libtemplate->main('akuntan/pengiriman_perpajakan/rincian', $data);
		}
		
		public function konfirmasi() {
			$id		= $_POST['id'];
			$status	= $_POST['status'];
			
			if($status == 'yes') {
				$data['judul']	= 'Konfirmasi';
				$data['text']	= 'Apakah data sudah lengkap?';
				$data['button']	= '<a href="#" class="btn btn-success btn-fix" data-id="'.$id.'" data-status="'.$status.'">Lengkap</a>';
			} else {
				$data['judul']	= 'Batal Konfirmasi';
				$data['text']	= 'Batalkan konfirmasi data?';
				$data['button']	= '<a href="#" class="btn btn-primary btn-fix" data-id="'.$id.'" data-status="'.$status.'">Batalkan</a>';
			}
			$this->load->view('akuntan/pengiriman_perpajakan/konfirmasi', $data);
		}
		
		public function fix() {
			$this->M_Pengiriman_perpajakan->konfirmasi($_POST['id'], $_POST['stat']);
			$msg = $_POST['stat'] == 'yes' ? 'Data berhasil dikonfirmasi!' : 'Konfirmasi berhasil dibatalkan!';
			$this->session->set_flashdata('notification', $msg);
		}
	}
?>