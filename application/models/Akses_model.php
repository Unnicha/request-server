<?php
	
	class Akses_model extends CI_model {
	
		public function getByMasa($tahun, $start='', $limit='') {
			return $this->db->from('akses')
							->join('user', 'user.id_user = akses.id_akuntan', 'left')
							->where(['tahun'=>$tahun])
							->limit($limit, $start)
							->order_by('id_akses', 'ASC')
							->get()->result_array();
		}
	
		public function countAkses($tahun) {
			return $this->db->from('akses')
							->join('user', 'user.id_user = akses.id_akuntan', 'left')
							->where(['tahun'=>$tahun])
							->count_all_results();
		}
		
		public function getById($id_akses) {
			return $this->db->from('akses')
							->join('user', 'user.id_user = akses.id_akuntan', 'left')
							->join('bulan', 'bulan.id_bulan = akses.masa', 'left')
							->where(['id_akses' => $id_akses])
							->order_by('id_akses', 'ASC')
							->get()->row_array();
		}
		
		public function getByTahun($tahun) {
			return $this->db->select('id_akuntan, nama')
							->from('akses')
							->join('user', 'user.id_user = akses.id_akuntan', 'left')
							->where(['tahun' => $tahun])
							->order_by('id_akses', 'ASC')
							->get()->result_array();
		}
		
		public function getByAkuntan($tahun, $id_akuntan) {
			return $this->db->from('akses')
							->join('user', 'user.id_user = akses.id_akuntan', 'left')
							->where(['tahun' => $tahun, 'id_akuntan' => $id_akuntan])
							->get()->row_array();
		}
		
		//delsoon
		public function getByKlien($id_klien, $bulan, $tahun) {
			return $this->db->from('akses')
							->join('user', 'user.id_user = akses.id_akuntan', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->like('klien', $id_klien)
							->order_by('id_akses', 'ASC')
							->get()->result_array();
		}

		public function tambahAkses() {
			$data = [
				'id_akses'		=> substr($this->input->post('tahun', true), 2, 2) . $this->input->post('id_akuntan', true),
				'masa'			=> $this->input->post('masa', true),
				'tahun'			=> $this->input->post('tahun', true),
				'id_akuntan'	=> $this->input->post('id_akuntan', true),
				'akuntansi'		=> implode(',', $this->input->post('akuntansi', true)),
				'perpajakan'	=> implode(',', $this->input->post('perpajakan', true)),
				'lainnya'		=> implode(',', $this->input->post('lainnya', true)),
			];
			$this->db->insert('akses', $data);
		}
	
		public function ubahAkses() {
			$data = [
				'masa'			=> $this->input->post('masa', true),
				'tahun'			=> $this->input->post('tahun', true),
				'id_akuntan'	=> $this->input->post('id_akuntan', true),
				'akuntansi'		=> implode(',', $this->input->post('akuntansi', true)),
				'perpajakan'	=> implode(',', $this->input->post('perpajakan', true)),
				'lainnya'		=> implode(',', $this->input->post('lainnya', true)),
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