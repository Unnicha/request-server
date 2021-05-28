<?php
	
	class Klu extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('paging');
			
			$this->load->model('Klu_model');
		} 
		 
		public function index() {
			$data['judul'] = "Klasifikasi Lapangan Usaha";
			$this->libtemplate->main('admin/klu/tampil', $data);
		}
		
		public function page() {
			$cari	= $_POST['search']['value'];
			$limit	= $_POST['length'];
			$offset = $_POST['start'];
			
			$countData	= $this->Klu_model->countKlu($cari); 
			$klu		= $this->Klu_model->getAllKlu($offset, $limit, $cari);
			$data		= [];
			foreach($klu as $k) {
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['kode_klu'];
				$row[]	= $k['bentuk_usaha'];
				$row[]	= $k['jenis_usaha'];
				$row[]	= '<a class="btn btn-sm btn-info" href="klu/ubah/'.$k['kode_klu'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah"><i class="bi bi-pencil-square"></i></a> <a class="btn btn-sm btn-danger" href="klu/hapus/'.$k['kode_klu'].'" onclick="return confirm("Yakin ingin menghapus KLU '.$k['kode_klu'].'?");" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="bi bi-trash"></i></a>';

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
			$data['judul'] = 'Form Tambah KLU'; 
			
			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required|is_unique[klu.kode_klu]', array( 'is_unique' => '%s Sudah Ada.' ));
			$this->form_validation->set_rules('bentuk_usaha', 'Bentuk Usaha', 'required');
			$this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klu/tambah', $data);
			} else {
				$this->Klu_model->tambahDataKlu();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/master/klu'); 
			}
		}
		
		public function ubah($kode_klu) {
			$data['judul'] = 'Form Ubah KLU'; 
			$data['klu'] = $this->Klu_model->getById($kode_klu);
			
			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required|numeric');
			$this->form_validation->set_rules('bentuk_usaha', 'Bentuk Usaha', 'required');
			$this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klu/ubah', $data);
			} else {
				$this->Klu_model->ubahDataKlu();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('admin/master/klu'); 
			}
		}

		public function detail($kode_klu) {
			$data['judul'] = 'Detail KLU';
			$data['klu'] = $this->Klu_model->getById($kode_klu);
			
			$this->libtemplate->main('admin/klu/detail', $data);
		}
		
		public function hapus($kode_klu) {
			$this->Klu_model->hapusDataKlu($kode_klu);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/master/klu');
		}
	}
?>