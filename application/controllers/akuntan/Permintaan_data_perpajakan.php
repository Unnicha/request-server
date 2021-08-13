<?php
	
	class Permintaan_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_perpajakan');
			$this->load->model('M_Pengiriman_perpajakan');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('Jenis_data_model');
		}
		
		public function index() {
			$data['judul']	= "Permintaan Data Perpajakan";
			$data['masa']	= $this->Klien_model->getMasa();
			
			$this->libtemplate->main('akuntan/permintaan_perpajakan/tampil', $data);
		}
		
		public function page() {
			$klien	= $_POST['klien'];		$this->session->set_flashdata('klien', $klien);
			$tahun	= $_POST['tahun'];		$this->session->set_userdata('tahun', $tahun);
			$bulan	= $_POST['bulan'];		$this->session->set_userdata('bulan', $bulan);
			
			if($klien == null) {
				$id_akuntan	= $this->session->userdata('id_user');
				$akses		= $this->Akses_model->getByAkuntan($tahun, $id_akuntan);
				if( $akses ) {
					if($bulan < $akses['masa']) {
						$akses	= $this->Akses_model->getByAkuntan(($tahun-1), $id_akuntan);
					}
					if( $akses ) {
						$klien	= explode(',', $akses['perpajakan']);
					}
				}
			}
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Permintaan_perpajakan->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_perpajakan->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($permintaan as $k) {
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['id_permintaan'];
				$row[]	= $k['request'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $k['nama'];
				$row[]	= '
					<a class="btn btn-sm btn-primary btn-detail_permintaan" data-toggle="tooltip" data-nilai="'.$k['id_permintaan'].'" data-placement="bottom" title="Detail Permintaan">
						<i class="bi bi-info-circle"></i>
					</a>
					<a href="permintaan_data_perpajakan/edit/'.$k['id_permintaan'].'" class="btn-edit" data-toggle="tooltip" data-placement="bottom" title="Edit Permintaan">
						<i class="bi bi-pencil-square" style="font-size:20px; line-height:80%"></i>
					</a>';
				
				$data[] = $row;
			}
			
			$callback = [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=>$countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
		
		public function pageChild() {
			$id_permintaan	= $_GET['id'];
			$permintaan		= $this->M_Permintaan_perpajakan->getById($id_permintaan);
			$isi			= $this->M_Permintaan_perpajakan->getDetail($id_permintaan);
			
			foreach($isi as $i => $val) {
				if($val['status'] == 'yes') {
					$badge	= '<span class="badge badge-success">Lengkap</span>';
				} elseif($val['status'] == 'no') {
					$badge	= '<span class="badge badge-warning">Belum Lengkap</span>';
				} else {
					$badge	= '<span class="badge badge-danger">Belum Dikirim</span>';
				}
				$add[$i] = $badge;
			}
			$data['judul']		= 'Detail Permintaan';
			$data['permintaan']	= $permintaan;
			$data['isi']		= $isi;
			$data['badge']		= $add;
			$data['link']		= 'akuntan/permintaan_data_perpajakan/detail/';
			
			$this->load->view('akuntan/permintaan_perpajakan/rincian', $data);
		}
		
		public function klien() {
			$bulan		= ($_POST['bulan']) ? $_POST['bulan'] : date('m');
			$tahun		= ($_POST['tahun']) ? $_POST['tahun'] : date('Y');
			$id_akuntan	= $this->session->userdata('id_user');
			
			$bulan		= $this->Klien_model->getMasa($bulan);
			$akses		= $this->Akses_model->getByAkuntan($tahun, $id_akuntan);
			if($bulan['id_bulan'] < $akses['masa']) {
				$akses = $this->Akses_model->getByAkuntan(($tahun-1), $id_akuntan);
			}
			
			if($akses == null) {
				$lists	= "<option value=''>--Tidak ada akses--</option>";
			} else {
				$lists		= "<option value=''>--".$_POST['jenis']." Klien--</option>";
				$id_klien	= explode(",", $akses['perpajakan']);
				foreach($id_klien as $id) {
					$klien	= $this->Klien_model->getById($id);
					$lists .= "<option value='".$klien['id_klien']."'>".$klien['nama_klien']."</option>"; 
				} 
			}
			echo $lists;
		}

		public function tambah() {
			$data['judul']	= "Kirim Permintaan - Data Perpajakan"; 
			$data['jenis']	= $this->Jenis_data_model->getByKategori('Data Perpajakan');
			$bulan			= $this->Klien_model->getMasa(date('m'));
			$data['bulan']	= $bulan['nama_bulan'];
			
			$this->form_validation->set_rules('id_klien', 'Klien', 'required');
			$this->form_validation->set_rules('kode_jenis[]', 'Jenis Data', 'required');
			$this->form_validation->set_rules('format_data[]', 'Format Data', 'required');
			$this->form_validation->set_rules('detail[]', 'Keterangan', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/permintaan_perpajakan/tambah', $data);
			} else {
				$this->M_Permintaan_perpajakan->tambahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('akuntan/permintaan_data_perpajakan'); 
			}
		}
		
		public function edit($id_permintaan) {
			$data['judul']		= "Edit Permintaan";
			$data['jenis']		= $this->Jenis_data_model->getByKategori('Data Perpajakan');
			$data['permintaan']	= $this->M_Permintaan_perpajakan->getById($id_permintaan);
			$data['detail']		= $this->M_Permintaan_perpajakan->getDetail($id_permintaan);
			
			$this->form_validation->set_rules('id_permintaan', 'ID Permintaan', 'required');
			$this->form_validation->set_rules('detail[]', 'Keterangan', 'required');
			$this->form_validation->set_rules('format_data[]', 'Format Data', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/permintaan_perpajakan/edit', $data);
			} else {
				$this->M_Permintaan_perpajakan->ubahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('akuntan/permintaan_data_perpajakan');
			}
		}
		
		public function detail($id_data) {
			$detail		= $this->M_Pengiriman_perpajakan->getByIdData($id_data);
			$pengiriman	= $this->M_Pengiriman_perpajakan->getDetail($id_data);
			if($detail['status'] == 'yes') {
				$detail['badge'] = '<span class="badge badge-success">Lengkap</span>';
			} elseif($detail['status'] == 'no') {
				$detail['badge'] = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$detail['badge'] = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			$button = '';
			if(count($pengiriman) > 0) {
				if($detail['status'] != 'yes') {
					$button = '<a href="#" class="btn btn-primary btn-konfirm" data-id="'.$detail['id_data'].'" data-status="yes" data-toggle="tooltip" data-placement="bottom" title="Konfirmasi kelengkapan data">Konfirmasi</a>';
				} else {
					$button = '<a href="#" class="btn btn-danger btn-konfirm" data-id="'.$detail['id_data'].'" data-status="no" data-toggle="tooltip" data-placement="bottom" title="Batalkan konfirmasi">Batalkan</a>';
				}
			}
			$detail['button']	= $button;
			
			$data['judul']		= "Detail Pengiriman"; 
			$data['detail']		= $detail;
			$data['pengiriman']	= $pengiriman;
			$data['link']		= "asset/uploads/".$detail['nama_klien']."/".$detail['tahun']."/";
			
			$this->libtemplate->main('akuntan/permintaan_perpajakan/detail', $data);
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
			$this->load->view('akuntan/permintaan_perpajakan/konfirmasi', $data);
		}
		
		public function fix() {
			$this->M_Pengiriman_perpajakan->konfirmasi($_POST['id'], $_POST['stat']);
			$msg = $_POST['stat'] == 'yes' ? 'Data berhasil dikonfirmasi!' : 'Konfirmasi berhasil dibatalkan!';
			$this->session->set_flashdata('notification', $msg);
		}
	}
?>