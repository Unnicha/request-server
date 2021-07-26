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
			$data['klien']	= $this->Klien_model->getAllKlien();
			
			$this->libtemplate->main('admin/akses/tampil', $data);
		}
		
		public function page() {
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$cari		= $_POST['search']['value'];
			$countData	= $this->Akses_model->countAkses($_POST['tahun']); 
			$akses		= $this->Akses_model->getByMasa($_POST['tahun'], $offset, $limit);
			$this->session->set_userdata('tahun', $_POST['tahun']);
			
			$data = [];
			foreach($akses as $k) {
				$bulan = $this->Klien_model->getMasa($k['masa']);
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama'];
				$row[]	= $bulan['nama_bulan'];
				$row[]	= '<a href="#" class="btn-detail" data-nilai="'.$k['id_akses'].'">Details</a>';
				$row[]	= '
					<a class="btn btn-sm btn-info" href="akses/ubah/'.$k['id_akses'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah">
						<i class="bi bi-pencil-square"></i>
					</a>

					<a class="btn btn-sm btn-danger btn-hapus" data-id="'.$k['id_akses'].'" data-nama="'.$k['nama'].' tahun '.$k['tahun'].'" data-toggle="tooltip" data-placement="bottom" title="Hapus">
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
		
		public function akuntan() {
			$akuntan	= $this->Akuntan_model->getAllAkuntan();
			foreach($akuntan as $a => $val) {
				if($this->Akses_model->getByAkuntan($_POST['tahun'], $val['id_user']))
				unset($akuntan[$a]);
			}
			
			$lists = "<option value=''>--Tidak Ada Akuntan--</option>";
			if($akuntan) {
				$lists = "<option value=''>--Pilih Akuntan--</option>";
				foreach($akuntan as $a) {
					$lists .= "<option value='".$a['id_user']."'>".$a['nama']."</option>"; 
				}
			}
			echo $lists;
		}

		public function tambah() {
			$data['judul']		= 'Form Tambah Akses'; 
			$data['masa']		= $this->Klien_model->getMasa();
			$data['klien']		= $this->Klien_model->getAllKlien();
			
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
			$data['bulan']	= $this->Klien_model->getMasa($data['akses']['masa'])['nama_bulan'];
			
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('id_akuntan', 'ID Akuntan', 'required');
			$this->form_validation->set_rules('klien[]', 'Klien', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akses/ubah', $data);
			} else {
				$this->Akses_model->ubahAkses();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!');
				redirect('admin/master/akses');
			}
		}

		public function detail() {
			$akses		= $this->Akses_model->getById($_POST['action']);
			$akuntansi	= explode(',', $akses['akuntansi']);
			$perpajakan	= explode(',', $akses['perpajakan']);
			$lainnya	= explode(',', $akses['lainnya']);
			$jum		= (count($akuntansi) > count($perpajakan)) ? count($akuntansi) : count($perpajakan);
			$akses['jum']	= ($jum > count($lainnya)) ? $jum : count($lainnya);
			
			$data['judul']		= 'Detail Akses';
			$data['akses']		= $akses;
			$data['akuntansi']	= $this->Klien_model->getById($akuntansi);
			$data['perpajakan']	= $this->Klien_model->getById($perpajakan);
			$data['lainnya']	= $this->Klien_model->getById($lainnya);
			
			$this->load->view('admin/akses/detail', $data);
		}
		
		public function hapus($id_akses) {
			$this->Akses_model->hapusAkses($id_akses);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/master/akses');
		}
	}
?>