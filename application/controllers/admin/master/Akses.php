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
			$tahun		= $_POST['tahun'];
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			// $cari		= $_POST['search']['value'];
			$countData	= $this->Akses_model->countAkses($tahun);
			$akses		= $this->Akses_model->getByTahun($offset, $limit, $tahun);
			$this->session->set_userdata('tahun', $tahun);
			
			$data = [];
			foreach($akses as $k) {
				$bulan = Globals::bulan($k['masa']);
				
				$akuntansi	= '';
				$perpajakan	= '';
				$lainnya	= '';
				$a			= $this->Akuntan_model->getBy('byId', explode(',', $k['akuntansi']));
				$b			= $this->Akuntan_model->getBy('byId', explode(',', $k['perpajakan']));
				$c			= $this->Akuntan_model->getBy('byId', explode(',', $k['lainnya']));
				
				foreach($a as $i => $val) {
					$akuntansi .= ($i>0) ? ' - '.$val['nama'] : $val['nama'];
				}
				foreach($b as $i => $val) {
					$perpajakan .= ($i>0) ? ' - '.$val['nama'] : $val['nama'];
				}
				foreach($c as $i => $val) {
					$lainnya .= ($i>0) ? ' - '.$val['nama'] : $val['nama'];
				}
				
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $bulan['nama'];
				$row[]	= $akuntansi;
				$row[]	= $perpajakan;
				$row[]	= $lainnya;
				// $row[]	= '<a href="#" class="btn-detail" data-nilai="'.$k['id_akses'].'">Details</a>';
				$row[]	= '
					<a href="akses/ubah/'.$k['id_akses'].'" data-toggle="tooltip" data-placement="bottom" title="Ubah">
						<i class="bi bi-pencil-square icon-medium"></i>
					</a>
					<a class="btn-hapus" data-id="'.$k['id_akses'].'" data-nama="'.$k['nama_klien'].' tahun '.$k['tahun'].'" data-toggle="tooltip" data-placement="bottom" title="Hapus">
						<i class="bi bi-trash icon-medium"></i>
					</a>';
				
				$data[] = $row;
			}
			
			$callback	= [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=> $countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
		
		public function getKlien() {
			$klien = $this->Klien_model->getAllKlien();
			foreach($klien as $a => $val) {
				if($this->Akses_model->getByKlien($_POST['tahun'], $val['id_klien']))
				unset($klien[$a]);
			}
			
			$lists = "<option value=''>--Tidak Ada Klien--</option>";
			if($klien) {
				$lists = "<option value=''>--Pilih Klien--</option>";
				foreach($klien as $a) {
					$lists .= "<option value='".$a['id_klien']."'>".$a['nama_klien']."</option>"; 
				}
			}
			echo $lists;
		}

		public function tambah() {
			$data['judul']		= 'Tambah Akses'; 
			$data['masa']		= Globals::bulan();
			$data['akuntan']	= $this->Akuntan_model->getAllAkuntan();
			
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('id_klien', 'Klien', 'required');
			$this->form_validation->set_rules('akuntansi[]', 'PJ Akuntansi', 'required');
			$this->form_validation->set_rules('perpajakan[]', 'PJ Perpajakan', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akses/tambah', $data);
			} else {
				if($this->Akses_model->tambahAkses() == true)
				$this->session->set_flashdata('notification', 'Berhasil ditambahkan!'); 
				else
				$this->session->set_flashdata('warning', 'Gagal ditambahkan!'); 
				redirect('admin/master/akses');
			}
		}
		
		public function ubah($id_akses) {
			$akses	= $this->Akses_model->getById($id_akses);
			$bulan	= Globals::bulan($akses['masa']);
			
			$data['judul']		= 'Ubah Akses Klien'; 
			$data['akses']		= $akses; 
			$data['akuntan']	= $this->Akuntan_model->getAllAkuntan();
			$data['bulan']		= $bulan['nama'];
			
			$this->form_validation->set_rules('id_akses', 'ID Akses', 'required');
			$this->form_validation->set_rules('masa', 'Masa', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'required');
			$this->form_validation->set_rules('id_klien', 'ID Akuntan', 'required');
			$this->form_validation->set_rules('akuntansi[]', 'PJ Akuntansi', 'required');
			$this->form_validation->set_rules('perpajakan[]', 'PJ Perpajakan', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/akses/ubah', $data);
			} else {
				if($this->Akses_model->ubahAkses() == true)
				$this->session->set_flashdata('notification', 'Berhasil diubah!');
				else
				$this->session->set_flashdata('warning', 'Gagal diubah!');
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
		
		public function hapus() {
			$id				= $_REQUEST['id'];
			$data['text']	= 'Yakin ingin menghapus akses <b>'.$_REQUEST['nama'].' ?</b>';
			$data['button']	= '
				<a href="akses/fix_hapus/'.$id.'" class="btn btn-danger">Hapus</a>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal" tabindex="1">Batal</button>
			';
			
			$this->load->view('admin/template/confirm', $data);
		}
		
		public function fix_hapus($id) {
			if($this->Admin_model->hapusAkses($id) == true)
			$this->session->set_flashdata('notification', 'Berhasil dihapus!');
			else
			$this->session->set_flashdata('warning', 'Gagal dihapus!');
			redirect('admin/master/akses');
		}
	}
?>