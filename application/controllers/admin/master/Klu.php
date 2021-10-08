<?php
	
	class Klu extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
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
				$row[]	= '
					<a href="klu/ubah/'.$k['kode_klu'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah">
						<i class="bi bi-pencil-square icon-medium"></i>
					</a>
					<a class="btn-hapus" data-id="'.$k['kode_klu'].'" data-nama="'.$k['bentuk_usaha'].' - '.$k['jenis_usaha'].'" data-toggle="tooltip" data-placement="bottom" title="Hapus">
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
			$data['judul'] = 'Tambah KLU'; 
			
<<<<<<< HEAD
			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required');
=======
			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required|is_unique[klu.kode_klu]', array( 'is_unique' => '%s Sudah Ada.' ));
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			$this->form_validation->set_rules('bentuk_usaha', 'Bentuk Usaha', 'required');
			$this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klu/tambah', $data);
			} else {
<<<<<<< HEAD
				if($this->Klu_model->tambahKlu() == true)
				$this->session->set_flashdata('notification', 'Berhasil ditambahkan!');
				else
				$this->session->set_flashdata('warning', 'Gagal ditambahkan!');
=======
				$this->Klu_model->tambahDataKlu();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
				redirect('admin/master/klu'); 
			}
		}
		
		public function ubah($kode_klu) {
			$data['judul']	= 'Ubah KLU'; 
			$data['klu']	= $this->Klu_model->getById($kode_klu);
			
			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required|numeric');
			$this->form_validation->set_rules('bentuk_usaha', 'Bentuk Usaha', 'required');
			$this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klu/ubah', $data);
			} else {
<<<<<<< HEAD
				if($this->Klu_model->ubahKlu() == true)
				$this->session->set_flashdata('notification', 'Berhasil diubah!'); 
				else
				$this->session->set_flashdata('warning', 'Gagal diubah!'); 
=======
				$this->Klu_model->ubahDataKlu();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
				redirect('admin/master/klu'); 
			}
		}
		
		public function hapus() {
			$id				= $_REQUEST['id'];
			$data['text']	= 'Yakin ingin menghapus KLU <b>'.$_REQUEST['nama'].' ?</b>';
			$data['button']	= '
				<a href="klu/fix_hapus/'.$id.'" class="btn btn-danger">Hapus</a>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal" tabindex="1">Batal</button>
				';
				
			$this->load->view('admin/template/confirm', $data);
		}
		
		public function fix_hapus($id) {
<<<<<<< HEAD
			if($this->Klu_model->hapusKlu($id) == true)
			$this->session->set_flashdata('notification', 'Berhasil dihapus!');
			else
			$this->session->set_flashdata('warning', 'Gagal dihapus!');
=======
			$this->Klu_model->hapusDataKlu($id);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
>>>>>>> 71b3ac856dc6eb0d4274e4826fabc8425989f9c5
			redirect('admin/master/klu');
		}
	}
?>