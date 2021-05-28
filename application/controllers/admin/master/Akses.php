<?php
	
	class Akses extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Akses_model');
			$this->load->model('Akuntan_model');
			$this->load->model('Klien_model');
		} 
		 
		public function index() {
			$data['judul']	= "Akses Klien";
			$data['klien']	= $this->Klien_model->getKlien();
			
			$this->libtemplate->main('admin/akses/tampil', $data);
		}
		
		public function page() {
			$tahun	= $_POST['tahun'];
			$this->session->set_userdata('tahun', $tahun);
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->Akses_model->countAkses($tahun); 
			$akses		= $this->Akses_model->getByMasa($tahun, $offset, $limit);
			
			$data = [];
			foreach($akses as $k) {
				$klien = [];
				$id_klien = explode(",", $k['klien']);
				foreach($id_klien as $id) {
					$get		= $this->Klien_model->getById($id);
					$klien[]	= $get['nama_klien'];
				}
				$bulan = $this->Klien_model->getMasa($k['masa']);

				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama'];
				$row[]	= $bulan['nama_bulan']; // menampilkan nama bulan
				$row[]	= '<a href="#">Details</a>';
				$row[]	= $klien;
				$row[]	= '
					<a class="btn btn-sm btn-info" href="akses/ubah/'.$k['id_akses'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah">
						<i class="bi bi-pencil-square"></i>
					</a>

					<a class="btn btn-sm btn-danger" href="akses/hapus/'.$k['id_akses'].'" onclick="return confirm("Yakin ingin menghapus akses '.$k['nama'].'?");" data-toggle="tooltip" data-placement="bottom" title="Hapus">
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
			$data['judul']		= 'Form Tambah Akses'; 
			$data['masa']		= $this->Klien_model->getMasa();
			$data['klien']		= $this->Klien_model->getAllKlien();
			$data['akuntan']	= $this->Akuntan_model->getAllAkuntan('akuntan');
			
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('id_akuntan', 'ID Akuntan', 'required');
			$this->form_validation->set_rules('klien[]', 'Klien', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akses/tambah', $data);
			} else {
				$this->Akses_model->tambahAkses();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/master/akses');  
			}
		}
		
		public function ubah($id_akses) {
			$data['judul']	= 'Ubah Akses Akuntan'; 
			$data['akses']	= $this->Akses_model->getById($id_akses); 
			$data['klien']	= $this->Klien_model->getAllKlien();
			
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('id_akuntan', 'ID Akuntan', 'required');
			$this->form_validation->set_rules('klien[]', 'Klien', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akses/ubah', $data);
			} else {
				$this->Akses_model->ubahAkses();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); //tampilkan pesan sukses
				redirect('admin/master/akses'); // Kembali ke fungsi index() controller Akuntan
			}
		}
		
		public function hapus($id_akses) {
			$this->Akses_model->hapusAkses($id_akses);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/master/akses');
		}
	}
?>