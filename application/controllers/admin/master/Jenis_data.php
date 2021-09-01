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
			
			$data = [];
			foreach($jenis_data as $k) {
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['kode_jenis'];
				$row[]	= $k['jenis_data'];
				$row[]	= $k['kategori'];
				$row[]	= '
					<a href="jenis_data/ubah/'.$k['kode_jenis'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah">
						<i class="bi bi-pencil-square icon-medium"></i>
					</a>
					<a class="btn-hapus" data-id="'.$k['kode_jenis'].'" data-nama="'.$k['jenis_data'].'" data-toggle="tooltip" data-placement="bottom" title="Hapus">
						<i class="bi bi-trash icon-medium"></i>
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
			$data['judul']		= 'Form Tambah Jenis Data'; 
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
			$data['judul']		= 'Detail Jenis Data';
			$data['jenis_data']	= $this->Jenis_data_model->getById($kode_jenis);
			
			$this->libtemplate->main('admin/jenis_data/detail', $data);
		}
		
		public function hapus() {
			$id				= $_REQUEST['id'];
			$data['text']	= 'Yakin ingin menghapus jenis data <b>'.$_REQUEST['nama'].' ?</b>';
			$data['button']	= '
				<a href="jenis_data/fix_hapus/'.$id.'" class="btn btn-danger">Hapus</a>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal" tabindex="1">Batal</button>
			';
			
			$this->load->view('admin/template/confirm', $data);
		}
		
		public function fix_hapus($id) {
			$this->Jenis_data_model->hapusJenisData($id);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/master/jenis_data'); 
		}
	}
?>