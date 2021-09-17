<?php
	class M_Export extends CI_model {
		
		public function kategori($kategori) {
			$data = [
				'data'			=> 'data_'.$kategori,
				'permintaan'	=> 'permintaan_'.$kategori,
				'pengiriman'	=> 'pengiriman_'.$kategori,
				'proses'		=> 'proses_'.$kategori,
			];
			return $data;
		}
		
		public function getPermintaan($tahun, $bulan, $klien, $kategori, $start=0, $limit='') {
			$table = $this->kategori($kategori);
			// if($limit) {
			// 	$this->db->limit($limit, $start);
			// }
			return $this->db->from($table['data'])
							->join($table['permintaan'], $table['permintaan'].'.id_permintaan = '.$table['data'].'.id_request', 'left')
							->join('jenis_data', $table['data'].'.id_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', $table['permintaan'].'.id_klien = klien.id_klien', 'left')
							->join('user', $table['permintaan'].'.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->where_in($table['permintaan'].'.id_klien', $klien)
							->order_by('id_data', 'ASC')
							->get()->result_array();
		}
		
		public function countPermintaan($tahun, $bulan, $klien, $kategori) {
			$table = $this->kategori($kategori);
			return $this->db->from($table['data'])
							->join($table['permintaan'], $table['permintaan'].'.id_permintaan = '.$table['data'].'.id_request', 'left')
							->join('jenis_data', $table['data'].'.id_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', $table['permintaan'].'.id_klien = klien.id_klien', 'left')
							->join('user', $table['permintaan'].'.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->where_in($table['permintaan'].'.id_klien', $klien)
							->count_all_results();
		}
		
		public function maxPengiriman($id_data, $kategori) {
			$table = 'pengiriman_'.$kategori;
			return $this->db->where(['kode_data' => $id_data])
							->order_by('id_pengiriman', 'DESC')
							->get($table, 1)
							->row_array();
		}
		
		public function getProses($tahun, $bulan, $klien, $kategori) {
			$table = $this->kategori($kategori);
			return $this->db->from($table['data'])
							->join($table['permintaan'], $table['permintaan'].'.id_permintaan = '.$table['data'].'.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = '.$table['data'].'.id_jenis', 'left')
							->join('klien', 'klien.id_klien = '.$table['permintaan'].'.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->where(['bulan'=>$bulan, 'tahun'=>$tahun, 'status_kirim'=>'yes'])
							->where_in($table['permintaan'].'.id_klien', $klien)
							->order_by('id_data', 'ASC')
							->get()->result_array();
		}
		
		public function countProses($tahun, $bulan, $klien, $kategori) {
			$table = $this->kategori($kategori);
			return $this->db->from($table['data'])
							->join($table['permintaan'], $table['permintaan'].'.id_permintaan = '.$table['data'].'.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = '.$table['data'].'.id_jenis', 'left')
							->join('klien', 'klien.id_klien = '.$table['permintaan'].'.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->where(['bulan'=>$bulan, 'tahun'=>$tahun, 'status_kirim'=>'yes'])
							->where_in($table['permintaan'].'.id_klien', $klien)
							->count_all_results();
		}
		
		public function detailProses($id_data, $kategori) {
			$table = $this->kategori($kategori);
			return $this->db->from($table['proses'])
							->join('user', 'user.id_user = '.$table['proses'].'.id_akuntan', 'left')
							->where(['kode_data' => $id_data])
							->order_by('id_proses', 'ASC')
							->get()->result_array();
		}
	}
?>