<?php
	
	class Permintaan_data_lainnya extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_lainnya');
			$this->load->model('M_Pengiriman_lainnya');
			$this->load->model('Klien_model');
			$this->load->model('Jenis_data_model');
		} 
		 
		public function index() {
			$data['judul']	= "Permintaan Data Lainnya";
			$data['masa']	= $this->Klien_model->getMasa();
			$data['klien']	= $this->Klien_model->getAllKlien();
			
			$this->libtemplate->main('admin/permintaan_lainnya/tampil', $data);
		}
		
		public function page() {
			$klien	= $_POST['klien'];
			$bulan	= $_POST['bulan'];
			$tahun	= $_POST['tahun'];
			$this->session->set_flashdata('klien', $klien);
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			
			$offset		= $_POST['start'];
			$limit		= $_POST['length'];
			$klien		= ($klien == null) ? 'all' : $klien;
			$countData	= $this->M_Permintaan_lainnya->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_lainnya->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
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
					<a class="btn-detail" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Permintaan">
						<i class="bi bi-info-circle" style="font-size:20px; line-height:80%"></i>
					</a>
					<a href="permintaan_data_lainnya/edit/'.$k['id_permintaan'].'" class="btn-edit" data-toggle="tooltip" data-placement="bottom" title="Edit Permintaan">
						<i class="bi bi-pencil-square" style="font-size:20px; line-height:80%"></i>
					</a>
					<a class="btn-hapus" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Hapus">
						<i class="bi bi-trash" style="font-size:20px; line-height:80%"></i>
					</a>';
				
				$data[] = $row;
			}
			
			$callback	= [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=>$countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
		
		public function pageChild() {
			$id_permintaan	= $_GET['id'];
			$permintaan		= $this->M_Permintaan_lainnya->getById($id_permintaan);
			$isi			= $this->M_Permintaan_lainnya->getDetail($id_permintaan);
			
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
			$data['link']		= 'admin/permintaan/permintaan_data_lainnya/detail/';
			
			$this->load->view('admin/permintaan_lainnya/rincian', $data);
		}
		
		public function detail($id_data) {
			$detail		= $this->M_Pengiriman_lainnya->getByIdData($id_data);
			$pengiriman	= $this->M_Pengiriman_lainnya->getDetail($id_data);
			
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
			
			$this->libtemplate->main('admin/permintaan_lainnya/detail', $data);
		}
		
		public function tambah() {
			$data['judul']	= "Buat Permintaan Baru";
			$data['klien']	= $this->Klien_model->getAllKlien();
			$data['jenis']	= $this->Jenis_data_model->getByKategori('Data Lainnya');
			
			$this->form_validation->set_rules('id_klien', 'Klien', 'required');
			$this->form_validation->set_rules('kode_jenis[]', 'Jenis Data', 'required');
			$this->form_validation->set_rules('format_data[]', 'Format Data', 'required');
			$this->form_validation->set_rules('detail[]', 'Keterangan', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/permintaan_lainnya/tambah', $data);
			} else {
				$this->M_Permintaan_lainnya->tambahPermintaan();
				$this->session->set_flashdata('notification', 'Permintaan berhasil dibuat!'); 
				redirect('admin/permintaan/permintaan_data_lainnya'); 
			}
		}
		
		public function edit($id_permintaan) {
			$data['judul']		= "Edit Permintaan";
			$data['jenis']		= $this->Jenis_data_model->getByKategori('Data Lainnya');
			$data['permintaan']	= $this->M_Permintaan_lainnya->getById($id_permintaan);
			$data['detail']		= $this->M_Permintaan_lainnya->getDetail($id_permintaan);
			
			$this->form_validation->set_rules('id_permintaan', 'ID Permintaan', 'required');
			$this->form_validation->set_rules('detail[]', 'Keterangan', 'required');
			$this->form_validation->set_rules('format_data[]', 'Format Data', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/permintaan_lainnya/ubah', $data);
			} else {
				$this->M_Permintaan_lainnya->ubahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('admin/permintaan/permintaan_data_lainnya');
			}
		}
		
		public function hapus() {
			$id				= $_POST['permintaan'];
			$data['judul']	= 'Hapus Permintaan';
			$data['text']	= 'Yakin ingin menghapus permintaan?';
			$data['button']	= '
				<a href="permintaan_data_lainnya/fix_hapus/'.$id.'" class="btn btn-danger">Hapus</a>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal" tabindex="1">Batal</button>
			';
			
			$this->load->view('admin/template/confirm', $data);
		}
		
		public function fix_hapus($id_permintaan) {
			$detail = $this->M_Permintaan_lainnya->getDetail($id_permintaan);
			foreach($detail as $d) {
				$this->M_Pengiriman_lainnya->hapusPengiriman($d['id_data']);
			}
			$this->M_Permintaan_lainnya->hapusPermintaan($id_permintaan);
			$this->session->set_flashdata('notification', 'Permintaan berhasil dihapus!'); 
			redirect('admin/permintaan/permintaan_data_lainnya'); 
		}
	}
?>