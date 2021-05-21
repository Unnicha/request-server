<?php

	class M_Permintaan_lainnya extends CI_model {

		public function getAllPermintaan() { 
			return $this->db->from('permintaan_lainnya')
							->join('jenis_data', 'permintaan_lainnya.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_lainnya.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_lainnya.id_pengirim = user.id_user', 'left')
							->order_by('id_permintaan', 'ASC')
							->get()->result_array();
		}

		public function getByMasa($bulan, $tahun, $klien='', $start, $limit) {
			if($klien != 'all') {
				$this->db->where_in('permintaan_lainnya.id_klien', $klien);
			}
			return $this->db->from('permintaan_lainnya')
							->join('jenis_data', 'permintaan_lainnya.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_lainnya.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_lainnya.id_pengirim = user.id_user', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->limit($limit, $start)
							->order_by('id_permintaan', 'ASC')
							->get()->result_array();
		}

		public function countPermintaan($bulan, $tahun, $klien='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_lainnya.id_klien', $klien);
			}
			return $this->db->from('permintaan_lainnya')
							->join('jenis_data', 'permintaan_lainnya.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_lainnya.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_lainnya.id_pengirim = user.id_user', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->count_all_results();
		}

		// TANPA PENGIRIMAN
		public function getForKlien($bulan, $tahun, $klien='', $start, $limit) {
			if($klien) {
				$this->db->where_in('permintaan_lainnya.id_klien', $klien);
			}
			return $this->db->from('permintaan_lainnya')
							->join('jenis_data', 'permintaan_lainnya.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_lainnya.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_lainnya.id_pengirim = user.id_user', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->where("NOT EXISTS (SELECT * FROM pengiriman_lainnya 
								WHERE pengiriman_lainnya.id_permintaan = permintaan_lainnya.id_permintaan
								)")
							->limit($limit, $start)	
							->order_by('id_permintaan', 'ASC')
							->get()->result_array();
		}

		// TANPA PENGIRIMAN
		public function countForKlien($bulan, $tahun, $klien='') {
			if($klien) {
				$this->db->where_in('permintaan_lainnya.id_klien', $klien);
			}
			return $this->db->from('permintaan_lainnya')
							->join('jenis_data', 'permintaan_lainnya.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_lainnya.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_lainnya.id_pengirim = user.id_user', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->where("NOT EXISTS (SELECT * FROM pengiriman_lainnya 
								WHERE pengiriman_lainnya.id_permintaan = permintaan_lainnya.id_permintaan
								)")
							->count_all_results();
		}

		public function getPengiriman($id_permintaan) {
			return $this->db->get_where('pengiriman_lainnya', ['id_permintaan'=>$id_permintaan])
							->row_array();
		}

		public function getById($id_permintaan) {
			return $this->db->from('permintaan_lainnya')
							->join('jenis_data', 'permintaan_lainnya.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_lainnya.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_lainnya.id_pengirim = user.id_user', 'left')
							->where(['id_permintaan' => $id_permintaan])
							->get()->row_array();
		}

		//delete soon
		public function getReqByKlien($masa, $tahun, $klien) {
			$q = "SELECT * FROM ((((permintaan_lainnya
				LEFT JOIN jenis_data ON permintaan_lainnya.kode_jenis = jenis_data.kode_jenis) 
				LEFT JOIN klien ON permintaan_lainnya.id_klien = klien.id_klien) 
				LEFT JOIN user ON permintaan_lainnya.id_pengirim = user.id_user) 
				LEFT JOIN pengiriman_lainnya 
				ON permintaan_lainnya.id_permintaan = pengiriman_lainnya.id_permintaan) 
				WHERE masa = '$masa' AND tahun = '$tahun' 
				AND permintaan_lainnya.id_klien = '$klien' 
				ORDER BY permintaan_lainnya.id_permintaan ASC"; 
			return $this->db->query($q)->result_array();
		}

		//fungsi untuk membuat id baru dengan autoincrement
		public function getMax($id_permintaan, $masa, $tahun, $kode_jenis, $id_klien) { 
			$max = $this->db->select_max('id_permintaan', 'max_id')
							->where(['masa'=>$masa, 'tahun'=>$tahun])
							->where(['kode_jenis'=>$kode_jenis, 'id_klien'=>$id_klien])
							->get('permintaan_lainnya')->row_array();

			if($max['max_id']) {
				$tambah = (int) substr($max['max_id'], -2);
				$data['request'] = ++$tambah; //kode pembetulan +1
			} else {
				$data['request'] = "1";
			}
			$data['id'] = $id_permintaan.(sprintf("%02s", $data['request']));
			return $data;
		}

		public function tambahPermintaan() { 
			$kode_jenis	= $this->input->post('kode_jenis', true);
			$id_klien	= $this->input->post('id_klien', true);
			$level		= $this->input->post('level', true);

			$masa			= $this->input->post('masa', true);
			$tahun			= $this->input->post('tahun', true);
			$bulan			= $this->db->get_where('bulan', ['nama_bulan' => $masa])->row_array();
			$masa			= sprintf('%02s', $bulan['id_bulan']);
			$id_permintaan	= substr($tahun, -2) . $masa . $id_klien . $kode_jenis;

			$new = $this->getMax($id_permintaan, $bulan['nama_bulan'], $tahun, $kode_jenis, $id_klien);
			$data = [
				'id_permintaan'		=> $new['id'],
				'tanggal_permintaan'=> $this->input->post('tanggal_permintaan', true),
				'masa'				=> $this->input->post('masa', true),
				'tahun'				=> $this->input->post('tahun', true),
				'format_data'		=> $this->input->post('format_data', true),
				'request'			=> $new['request'],
				'keterangan'		=> $this->input->post('keterangan', true),
				'kode_jenis'		=> $this->input->post('kode_jenis', true),
				'id_klien'			=> $this->input->post('id_klien', true),
				'id_pengirim'		=> $this->input->post('id_user', true),
			];
			$this->db->insert('permintaan_lainnya', $data);
		}
		
		public function hapusPermintaan($id_permintaan) { 
			$this->db->where('id_permintaan', $id_permintaan);
			$this->db->delete('permintaan_lainnya');
		}
	}
?>