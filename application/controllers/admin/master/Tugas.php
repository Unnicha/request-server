<?php
	
	class Tugas extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Tugas_model');
			$this->load->model('Jenis_data_model');
		}
		
		public function index() {
			$data['judul'] = "Daftar Tugas"; 
			$this->libtemplate->main('admin/tugas/tampil', $data);
		}
		
		public function page() {
			$cari	= $_POST['search']['value'];
			$limit	= $_POST['length'];
			$offset = $_POST['start'];
			
			$countData	= $this->Tugas_model->countTugas($cari); 
			$tugas		= $this->Tugas_model->getAllTugas($offset, $limit, $cari);
			$data		= [];
			foreach($tugas as $k) {
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_tugas'];
				$row[]	= $k['jenis_data'];
				$row[]	= $k['accounting_service'].' jam';
				$row[]	= $k['review'].' jam';
				$row[]	= $k['semi_review'].' jam';
				$row[]	= '
					<a class="btn btn-sm btn-info" href="tugas/ubah/'.$k['kode_tugas'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah">
						<i class="bi bi-pencil-square"></i>
					</a>
					<a class="btn btn-sm btn-danger btn-hapus" data-id="'.$k['kode_tugas'].'" data-nama="'.$k['nama_tugas'].'" data-toggle="tooltip" data-placement="bottom" title="Hapus">
						<i class="bi bi-trash"></i>
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

		public function tambah() {
			$data['judul']		= 'Tambah Data Tugas'; 
			$data['jenis_data']	= $this->Jenis_data_model->getAllJenisData();
			
			$this->form_validation->set_rules('nama_tugas', 'Nama Tugas', 'required');
			$this->form_validation->set_rules('kode_jenis', 'Kode Jenis', 'required');
			$this->form_validation->set_rules('hari[]', 'Hari', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/tugas/tambah', $data);
			} else {
				$this->Tugas_model->tambahTugas();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/master/tugas'); 
			}
		}
		
		public function ubah($kode_tugas) {
			$tugas		= $this->Tugas_model->getById($kode_tugas);
			$hari[0]	= floor($tugas['accounting_service'] / 8);	$jam[0] = $tugas['accounting_service'] % 8;
			$hari[1]	= floor($tugas['review'] / 8);				$jam[1] = $tugas['review'] % 8;
			$hari[2]	= floor($tugas['semi_review'] / 8);			$jam[2] = $tugas['semi_review'] % 8;
			
			$data['judul']	= 'Ubah Data Tugas'; 
			$data['tugas']	= $tugas;
			$data['hari']	= $hari;
			$data['jam']	= $jam;
			
			$this->form_validation->set_rules('nama_tugas', 'Nama Tugas', 'required');
			$this->form_validation->set_rules('kode_jenis', 'Kode Jenis', 'required');
			$this->form_validation->set_rules('hari[]', 'Hari', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/tugas/ubah', $data);
			} else {
				$this->Tugas_model->ubahTugas();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('admin/master/tugas'); 
			}
		}

		public function detail($kode_tugas) {
			$data['judul'] = 'Detail Tugas';
			$data['tugas'] = $this->Tugas_model->getById($kode_tugas);
			
			$this->libtemplate->main('admin/tugas/detail', $data);
		}
		
		public function hapus() {
			$this->Tugas_model->hapusTugas($_POST['id']);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
		}
	}
?>