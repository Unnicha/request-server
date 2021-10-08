<?php

	class Jenis_data_model extends CI_model {

		public function getAllJenis($start=0, $limit='', $kata_cari='') {
			if($kata_cari) {
				$this->db->like('kode_jenis', $kata_cari)
						->or_like('jenis_data', $kata_cari)
						->or_like('kategori', $kata_cari);
			}
			if($limit) $this->db->limit($limit, $start);
			return $this->db->order_by('kode_jenis', 'ASC')
							->get('jenis_data')->result_array();
		}

		public function countJenis($kata_cari='') {
			if($kata_cari) {
				$this->db->like('kode_jenis', $kata_cari)
						->or_like('jenis_data', $kata_cari)
						->or_like('kategori', $kata_cari);
			}
			return $this->db->from('jenis_data')->count_all_results();
		}
		
		public function getBy($type, $key) {
			if($type == 'byId') {
				return $this->db->get_where('jenis_data', ['kode_jenis' => $key])->row_array();
			} elseif($type == 'byKategori') {
				return $this->db->get_where('jenis_data', ['kategori' => $key])->result_array();
			}
		}
		
		public function getById($kode_jenis) {
			return $this->db->get_where('jenis_data', ['kode_jenis'=>$kode_jenis])->row_array();
		}
		
		public function getByKategori($kategori) {
			return $this->db->get_where('jenis_data', ['kategori'=>$kategori])->result_array();
		}
		
		public function getMax($kategori) {
			$max = $this->db->select_max('kode_jenis')
							->where('kategori', $kategori)
							->get('jenis_data')->row_array();
			
			$tambah	= $max['kode_jenis'] ? substr($max['kode_jenis'], 1) : 0;
			$baru	= sprintf('%02s', ++$tambah);
			$arr	= $this->kategori();
			$result	= array_search($kategori, $arr);
			
			return $result . $baru;
		}
		
		public function kategori() {
			return [
				'1' => 'Data Akuntansi',
				'2' => 'Data Perpajakan',
				'3' => 'Data Lainnya'
			];
		}
		
		public function tambahJenis($data) {
			$data = [
				'kode_jenis'	=> $this->getMax($data['kategori']),
				'jenis_data'	=> $data['jenis_data'],
				'kategori'		=> $data['kategori'],
			];
			$this->db->insert('jenis_data', $data);
			return $this->db->affected_rows();
		}
		
		public function ubahJenis($data) {
			$this->db->where('kode_jenis', $data['kode_jenis'])
					->update('jenis_data', ['jenis_data' => $data['jenis_data']]);
			return $this->db->affected_rows();
		}
		
		public function hapusJenis($kode_jenis) {
			$this->db->where('kode_jenis', $kode_jenis)->delete('jenis_data');
			return $this->db->affected_rows();
		}
	}
?>