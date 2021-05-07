<?php
	
	class Akses_model extends CI_model {
	
		public function getByMasa($bulan, $tahun, $start='', $limit='') {
			return $this->db->from('akses')
							->join('user', 'user.id_user = akses.id_akuntan', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun])
							->limit($limit, $start)
							->order_by('id_akses', 'ASC')
							->get()->result_array();
		}
	
		public function countAkses($bulan, $tahun) {
			return $this->db->from('akses')
							->join('user', 'user.id_user = akses.id_akuntan', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun])
							->count_all_results();
		}
	
		public function getById($id_akses) {
			return $this->db->from('akses')
							->join('user', 'user.id_user = akses.id_akuntan', 'left')
							->where(['id_akses' => $id_akses])
							->order_by('id_akses', 'ASC')
							->get()->row_array();
		}
	
		public function getByAkuntan($id_akuntan, $bulan, $tahun) {
			return $this->db->from('akses')
							->join('user', 'user.id_user = akses.id_akuntan', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun, 'id_akuntan' => $id_akuntan])
							->get()->row_array();
		}
	
		public function getByKlien($id_klien, $bulan, $tahun) {
			return $this->db->from('akses')
							->join('user', 'user.id_user = akses.id_akuntan', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->like('klien', $id_klien)
							->order_by('id_akses', 'ASC')
							->get()->result_array();
		}
		
		public function getMasa($masa='') {
			if($masa){
				return $this->db->get_where('bulan', ['nama_bulan' => $masa])->row_array();
			} else {
				return $this->db->get('bulan')->result_array();
			}
		}

		public function tambahAkses() {
			$bulan		= $this->getMasa( $this->input->post('masa', true) );
			$masa		= sprintf('%02s', $bulan['id_bulan']);
			$tahun		= substr($this->input->post('tahun', true), 2, 2);
			$id_akses	= "{$tahun}{$masa}{$this->input->post('id_akuntan', true)}";
			
			$cek = $this->getById($id_akses);
			if($cek == null) {
				$data = [
					"id_akses"	=> $id_akses,
					"masa"		=> $this->input->post('masa', true),
					"tahun"		=> $this->input->post('tahun', true),
					"id_akuntan"=> $this->input->post('id_akuntan', true),
					"klien"		=> implode(",", $this->input->post('klien', true)),
				];
				$this->db->insert('akses', $data);
			} else {
				$this->session->set_flashdata('sudah', 'sudah ada'); 
				redirect('admin/akses/tambah');  
			}
		}
	
		public function ubahAkses() {
			$data = [
				"id_akses"	=> $this->input->post('id_akses', true),
				"masa"		=> $this->input->post('masa', true),
				"tahun"		=> $this->input->post('tahun', true),
				"id_akuntan"=> $this->input->post('id_akuntan', true),
				"klien"		=> implode(",", $this->input->post('klien', true)),
			];
			$this->db->where('id_akses', $this->input->post('id_akses', true));
			$this->db->update('akses', $data);
		}
		
		public function hapusAkses($id_akses) {
			$this->db->where('id_akses', $id_akses);
			$this->db->delete('akses');
		}
	}
?>