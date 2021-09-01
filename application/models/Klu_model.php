<?php
	
	class Klu_model extends CI_model {
		
		public function getAllKlu($start='', $limit='', $kata_cari='') {
			if($kata_cari) {
				$this->db->like('kode_klu', $kata_cari)
						->or_like('bentuk_usaha', $kata_cari)
						->or_like('jenis_usaha', $kata_cari);
			}
			return $this->db->order_by('kode_klu', 'ASC')
							->get('klu', $limit, $start)->result_array();
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
			return $this->db->get_where('klu', ['kode_klu'=>$kode_klu])->row_array();
		}
		
		public function tambahDataKlu() {
			$data = [
				"kode_klu" => $this->input->post('kode_klu', true),
				"bentuk_usaha" => $this->input->post('bentuk_usaha', true),
				"jenis_usaha" => $this->input->post('jenis_usaha', true),
			];
			$this->db->insert('klu', $data);
		}
		
		public function ubahDataKlu() {
			$data = [
				"kode_klu" => $this->input->post('kode_klu', true),
				"bentuk_usaha" => $this->input->post('bentuk_usaha', true),
				"jenis_usaha" => $this->input->post('jenis_usaha', true),
			];
			$this->db->where('kode_klu', $this->input->post('kode_klu', true));
			$this->db->update('klu', $data);
		}
		
		public function hapusDataKlu($kode_klu) {
			$this->db->where('kode_klu', $kode_klu);
			$this->db->delete('klu');
		}
	}
?>