<?php
	
	class Akses_model extends CI_model {
	
		public function getByTahun($start=0, $limit='', $tahun) {
			if($limit) $this->db->limit($limit, $start);
			return $this->db->from('akses')
							->join('klien', 'klien.id_klien = akses.kode_klien', 'left')
							->where(['tahun'=>$tahun])
							->order_by('id_akses', 'ASC')
							->get()->result_array();
		}
		
		public function countAkses($tahun) {
			return $this->db->from('akses')
							->join('klien', 'klien.id_klien = akses.kode_klien', 'left')
							->where(['tahun'=>$tahun])
							->count_all_results();
		}
		
		public function getBy($type, $id, $tahun, $bulan, $kategori) {
			$this->db->from('akses')
					->join('klien', 'klien.id_klien = akses.kode_klien', 'left')
					->join('bulan', 'bulan.id_bulan = akses.masa', 'left');
			
			if($type == 'byId') {
				return $this->db->where('id_akses', $id)->get()->row_array();
			}
			elseif($type == 'byKlien') {
				return $this->db->where(['id_klien'=>$id, 'tahun'=>$tahun])
								->get()->row_array();
			}
			elseif($type == 'byAkuntan') {
				return $this->db->where(['tahun' => $tahun, 'masa <=' => $bulan])
								->like($kategori, $id)
								->order_by('id_akses', 'ASC')
								->get()->result_array();
			}
			return '';
		}
		
		// delsoon
		public function getById($id_akses) {
			return $this->db->from('akses')
							->join('klien', 'klien.id_klien = akses.kode_klien', 'left')
							->join('bulan', 'bulan.id_bulan = akses.masa', 'left')
							->where(['id_akses' => $id_akses])
							->get()->row_array();
		}
		// delsoon
		public function getByKlien($tahun, $id_klien) {
			return $this->db->from('akses')
							->join('klien', 'klien.id_klien = akses.kode_klien', 'left')
							->where(['id_klien'=>$id_klien, 'tahun'=>$tahun])
							->get()->row_array();
		}
		// delsoon
		public function getByAkuntan($tahun, $bulan, $id_akuntan, $kategori) {
			return $this->db->from('akses')
							->join('klien', 'klien.id_klien = akses.kode_klien', 'left')
							->where(['tahun' => $tahun, 'masa <=' => $bulan])
							->like($kategori, $id_akuntan)
							->order_by('id_akses', 'ASC')
							->get()->result_array();
		}
		
		public function tambahAkses($data) {
			$data = [
				'id_akses'		=> substr($data['tahun'], 2, 2) . $data['kode_klien'],
				'kode_klien'	=> $data['kode_klien'],
				'masa'			=> $data['masa'],
				'tahun'			=> $data['tahun'],
				'akuntansi'		=> $data['akuntansi'],
				'perpajakan'	=> $data['perpajakan'],
				'lainnya'		=> $data['lainnya'],
			];
			$this->db->insert('akses', $data);
			return $this->db->affected_rows();
		}
	
		public function ubahAkses($data) {
			$data = [
				'id_akses'		=> $data['id_akses'],
				'kode_klien'	=> $data['kode_klien'],
				'masa'			=> $data['masa'],
				'tahun'			=> $data['tahun'],
				'akuntansi'		=> $data['akuntansi'],
				'perpajakan'	=> $data['perpajakan'],
				'lainnya'		=> $data['lainnya'],
			];
			$this->db->where('id_akses', $data['id_akses'])
					->update('akses', $data);
			return $this->db->affected_rows();
		}
		
		public function hapusAkses($id_akses) {
			$this->db->where('id_akses', $id_akses)->delete('akses');
			return $this->db->affected_rows();
		}
	}
?>