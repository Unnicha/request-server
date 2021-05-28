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
				$row[]	= $k['status_pekerjaan'];
				$row[]	= $k['jenis_data'];
				$row[]	= $k['lama_pengerjaan'];
				$row[]	= '<a class="btn btn-sm btn-info" href="tugas/ubah/'.$k['id_tugas'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah"><i class="bi bi-pencil-square"></i></a> <a class="btn btn-sm btn-danger" href="tugas/hapus/'.$k['id_tugas'].'" onclick="return confirm("Yakin ingin menghapus KLU '.$k['id_tugas'].'?");" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="bi bi-trash"></i></a>';

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
			$data['kategori']	= ['Accounting Service', 'Review', 'Semi Review'];
			$data['jenis_data']	= $this->Jenis_data_model->getAllJenisData();

			$this->form_validation->set_rules('nama_tugas', 'Nama Tugas', 'required');
			$this->form_validation->set_rules('kode_jenis', 'Kode Jenis', 'required');
			$this->form_validation->set_rules('status_pekerjaan', 'Status Pekerjaan', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/tugas/tambah', $data);
			} else {
				$this->Tugas_model->tambahTugas();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/master/tugas'); 
			}
		}
		
		public function ubah($id_tugas) {

			$data['judul']		= 'Ubah Data Tugas'; 
			$tugas				= $this->Tugas_model->getById($id_tugas);
			$lama_pengerjaan	= $tugas['lama_pengerjaan'];
			$data['hari']		= floor($lama_pengerjaan / 8);
			$data['jam']		= $lama_pengerjaan % 8;
			$data['tugas']		= $tugas;

			$this->form_validation->set_rules('nama_tugas', 'Nama Tugas', 'required');
			$this->form_validation->set_rules('status_pekerjaan', 'Status Pekerjaan', 'required');
			$this->form_validation->set_rules('kode_jenis', 'Kode Jenis', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/tugas/ubah', $data);
			} else {
				$this->Tugas_model->ubahTugas();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('admin/master/tugas'); 
			}
		}

		public function detail($id_tugas) {

			$data['judul'] = 'Detail Tugas';
			$data['tugas'] = $this->Tugas_model->getById($id_tugas);
			
			$this->libtemplate->main('admin/tugas/detail', $data);
		}
		
		public function hapus($id_tugas) {
			$this->Tugas_model->hapusTugas($id_tugas);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/master/tugas');
		}
	}
?>