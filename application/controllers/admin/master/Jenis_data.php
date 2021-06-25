<?php
	
	class Jenis_data extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('Jenis_data_model');
		} 
		 
		public function index() {
			$data['judul'] = "Jenis Data"; 
			$this->libtemplate->main('admin/jenis_data/tampil', $data);
		}
		
		public function page() {
			$cari	= $_POST['search']['value'];
			$limit	= $_POST['length'];
			$offset = $_POST['start'];
			
			$countData	= $this->Jenis_data_model->countJenisData($cari); 
			$jenis_data	= $this->Jenis_data_model->getAllJenisData($offset, $limit, $cari);
			$data		= [];
			foreach($jenis_data as $k) {
				//$no = $offset;
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['kode_jenis'];
				$row[]	= $k['jenis_data'];
				$row[]	= $k['kategori'];
				$row[]	= "<a class='btn btn-sm btn-info' href='jenis_data/ubah/".$k['kode_jenis']."' data-toggle='tooltip' data-placement='bottom' title='Ubah'><i class='bi bi-pencil-square'></i></a> <a class='btn btn-sm btn-danger' href='jenis_data/hapus/".$k['kode_jenis']."' onclick='return confirm('Yakin ingin menghapus KLU ".$k['kode_jenis']."?');' data-toggle='tooltip' data-placement='bottom' title='Hapus'><i class='bi bi-trash'></i></a>";

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

			$data['judul'] = 'Form Tambah Jenis Data'; 
			$data['kategori']	= $this->Jenis_data_model->kategori();
			
			$this->form_validation->set_rules('jenis_data', 'Jenis Data', 'required');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/jenis_data/tambah', $data);
			} else {
				$this->Jenis_data_model->tambahJenisData();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/master/jenis_data'); 
			}
		}
		
		public function ubah($kode_jenis) {

			$data['judul']		= 'Form Ubah Jenis Data'; 
			$data['jenis_data']	= $this->Jenis_data_model->getById($kode_jenis); 
			$data['kategori']	= $this->Jenis_data_model->kategori();
			
			$this->form_validation->set_rules('jenis_data', 'Jenis Data', 'required');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/jenis_data/ubah', $data);
			} else {
				$this->Jenis_data_model->ubahJenisData();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('admin/master/jenis_data'); 
			}
		}

		public function detail($kode_jenis) {

			$data['judul'] = 'Detail Jenis Data';
			$data['jenis_data'] = $this->Jenis_data_model->getById($kode_jenis);
			
			$this->libtemplate->main('admin/jenis_data/detail', $data);
		}
		
		public function hapus($kode_jenis) {

			$this->Jenis_data_model->hapusJenisData($kode_jenis);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/master/jenis_data');
		}
	}
?>