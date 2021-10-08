<?php
	
	class Permintaan_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('Klien_model');
			$this->load->model('Akses_model');
			$this->load->model('Jenis_data_model');
		}
		
		public function index() {
			$data['judul']	= "Permintaan Data Akuntansi";
<<<<<<< HEAD
			$data['masa']	= Globals::bulan();
=======
			$data['masa']	= $this->Klien_model->getMasa();
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			
			$this->libtemplate->main('akuntan/permintaan_akuntansi/tampil', $data);
		}
		
		public function page() {
			$klien	= $_POST['klien'];		$this->session->set_flashdata('klien', $klien);
			$tahun	= $_POST['tahun'];		$this->session->set_userdata('tahun', $tahun);
			$bulan	= $_POST['bulan'];		$this->session->set_userdata('bulan', $bulan);
			
			if($klien == null) {
				$klien	= [];
				$id		= $this->session->userdata('id_user');
				$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan, $id, 'akuntansi');
				$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $id, 'akuntansi');
				if( $akses ) {
					foreach($akses as $a) {
						$klien[] = $a['kode_klien'];
					}
				} else $klien = null;
			}
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Permintaan_akuntansi->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_akuntansi->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($permintaan as $k) {
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['id_permintaan'];
				$row[]	= $k['request'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $k['jumData'];
				$row[]	= $k['nama'];
				$row[]	= '
					<a class="btn-detail" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Permintaan">
						<i class="bi bi-info-circle-fill" style="font-size:20px; line-height:80%"></i>
					</a>
					<a href="permintaan_data_akuntansi/edit/'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Edit Permintaan">
						<i class="bi bi-pencil-square icon-medium"></i>
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
		
		public function klien() {
			$bulan		= isset($_POST['bulan']) ? $_POST['bulan'] : date('m');
			$tahun		= isset($_POST['tahun']) ? $_POST['tahun'] : date('Y');
			$id_akuntan	= $this->session->userdata('id_user');
			
<<<<<<< HEAD
			$bulan	= Globals::bulan($bulan);
			$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan['id'], $id_akuntan, 'akuntansi');
			$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan['id'], $id_akuntan, 'akuntansi');
=======
			$bulan	= $this->Klien_model->getMasa($bulan)['id_bulan'];
			$akses	= $this->Akses_model->getByAkuntan($tahun, $bulan, $id_akuntan, 'akuntansi');
			$akses	= ($akses) ? $akses : $this->Akses_model->getByAkuntan(($tahun-1), $bulan, $id_akuntan, 'akuntansi');
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			
			$lists	= "<option value=''>--Tidak ada akses--</option>";
			if( $akses ) {
				$lists		= "<option value=''>--".$_POST['jenis']." Klien--</option>";
				foreach($akses as $a) {
					$lists .= "<option value='".$a['id_klien']."'>".$a['nama_klien']."</option>"; 
				}
			}
			echo $lists;
		}
		
		public function tambah() {
			$data['judul']	= "Tambah Permintaan"; 
			$data['jenis']	= $this->Jenis_data_model->getByKategori('Data Akuntansi');
			
			$this->form_validation->set_rules('id_klien', 'Klien', 'required');
			$this->form_validation->set_rules('kode_jenis[]', 'Jenis Data', 'required');
			$this->form_validation->set_rules('format_data[]', 'Format Data', 'required');
			$this->form_validation->set_rules('detail[]', 'Keterangan', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/permintaan_akuntansi/tambah', $data);
			} else {
				$this->M_Permintaan_akuntansi->tambahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('akuntan/permintaan_data_akuntansi'); 
			}
		}
		
		public function edit($id_permintaan) {
			$data['judul']		= "Edit Permintaan";
			$data['jenis']		= $this->Jenis_data_model->getByKategori('Data Akuntansi');
			$data['permintaan']	= $this->M_Permintaan_akuntansi->getById($id_permintaan);
			$data['detail']		= $this->M_Permintaan_akuntansi->getDetail($id_permintaan);
			
			$this->form_validation->set_rules('id_permintaan', 'ID Permintaan', 'required');
			$this->form_validation->set_rules('detail[]', 'Keterangan', 'required');
			$this->form_validation->set_rules('format_data[]', 'Format Data', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('akuntan/permintaan_akuntansi/edit', $data);
			} else {
				$this->M_Permintaan_akuntansi->ubahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('akuntan/permintaan_data_akuntansi');
			}
		}
		
		public function detail() {
			$id_permintaan	= $_REQUEST['id'];
			$permintaan		= $this->M_Permintaan_akuntansi->getById($id_permintaan);
			$isi			= $this->M_Permintaan_akuntansi->getDetail($id_permintaan);
			
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
			
			$this->load->view('akuntan/permintaan_akuntansi/detail', $data);
		}
	}
?>