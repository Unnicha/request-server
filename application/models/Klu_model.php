<?php
	
	class Klu_model extends CI_model {
		
		public function getAllKlu($start=0, $limit='', $kata_cari='') {
			if($kata_cari) {
				$this->db->like('kode_klu', $kata_cari)
						->or_like('bentuk_usaha', $kata_cari)
						->or_like('jenis_usaha', $kata_cari);
			}
			if($limit) $this->db->limit($limit, $start);
			return $this->db->order_by('kode_klu', 'ASC')
							->get('klu')->result_array();
		}
		
		public function countKlu($kata_cari='') {
			if($kata_cari) {
				$this->db->like('kode_klu', $kata_cari)
						->or_like('bentuk_usaha', $kata_cari)
						->or_like('jenis_usaha', $kata_cari);
			}
			return $this->db->from('klu')->count_all_results();
		}
		
		public function getById($kode_klu) {
			return $this->db->get_where('klu', ['kode_klu'=>$kode_klu])
							->row_array();
		}
		
		public function tambahKlu($data) {
			$this->db->insert('klu', $data);
			return $this->db->affected_rows();
		}
		
		public function ubahKlu($data) {
			$this->db->where('kode_klu', $data['kode_klu'])
					->update('klu', $data);
			return $this->db->affected_rows();
		}
		
		public function hapusKlu($kode_klu) {
			$this->db->where('kode_klu', $kode_klu)
					->delete('klu');
			return $this->db->affected_rows();
		}
	}
?>