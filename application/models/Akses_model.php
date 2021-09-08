<?php
	
	class Akses_model extends CI_model {
	
		public function getByTahun($tahun, $start=0, $limit='', $kata_cari='') {
			if($kata_cari) {
				$this->db->like('nama_klien', $kata_cari)
						->or_like('status_pekerjaan', $kata_cari)
						->or_like('jenis_usaha', $kata_cari)
						->or_like('nama_pimpinan', $kata_cari);
			}
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
		
		public function getById($id_akses) {
			return $this->db->from('akses')
							->join('klien', 'klien.id_klien = akses.kode_klien', 'left')
							->join('bulan', 'bulan.id_bulan = akses.masa', 'left')
							->where(['id_akses' => $id_akses])
							->get()->row_array();
		}
		
		public function getByKlien($tahun, $id_klien) {
			return $this->db->from('akses')
							->join('klien', 'klien.id_klien = akses.kode_klien', 'left')
							->where(['id_klien'=>$id_klien, 'tahun'=>$tahun])
							->get()->row_array();
		}
		
		public function getByAkuntan($tahun, $bulan, $id_akuntan, $kategori) {
			return $this->db->from('akses')
							->join('klien', 'klien.id_klien = akses.kode_klien', 'left')
							->where(['tahun' => $tahun, 'masa <=' => $bulan])
							->like($kategori, $id_akuntan)
							->order_by('id_akses', 'ASC')
							->get()->result_array();
		}
		
		public function tambahAkses() {
			$data = [
				'id_akses'		=> substr($this->input->post('tahun', true), 2, 2) . $this->input->post('id_klien', true),
				'kode_klien'	=> $this->input->post('id_klien', true),
				'masa'			=> $this->input->post('masa', true),
				'tahun'			=> $this->input->post('tahun', true),
				'akuntansi'		=> implode(',', $this->input->post('akuntansi', true)),
				'perpajakan'	=> implode(',', $this->input->post('perpajakan', true)),
				'lainnya'		=> implode(',', $this->input->post('lainnya', true)),
			];
			$this->db->insert('akses', $data);
		}
	
		public function ubahAkses() {
			$data = [
				'kode_klien'	=> $this->input->post('id_klien', true),
				'masa'			=> $this->input->post('masa', true),
				'tahun'			=> $this->input->post('tahun', true),
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