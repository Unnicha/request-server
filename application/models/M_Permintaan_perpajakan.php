<?php

	class M_Permintaan_perpajakan extends CI_model {

		public function getAllPermintaan() { 
			return $this->db->from('permintaan_perpajakan')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->order_by('id_permintaan', 'ASC')
							->get()->result_array();
		}

		public function getByMasa($bulan, $tahun, $klien='', $start, $limit) {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			return $this->db->from('permintaan_perpajakan')
							->join('pengiriman_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_request', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun, 'id_pengiriman' => null])
							->limit($limit, $start)
							->order_by('id_permintaan', 'ASC')
							->get()->result_array();
		}

		public function countPermintaan($bulan, $tahun, $klien='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			return $this->db->from('permintaan_perpajakan')
							->join('pengiriman_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_request', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun, 'id_pengiriman' => null])
							->count_all_results();
		}

		// TANPA PENGIRIMAN
		public function getForKlien($bulan, $tahun, $klien='', $start, $limit) {
			if($klien) {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			return $this->db->from('permintaan_perpajakan')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->where("NOT EXISTS (SELECT * FROM pengiriman_perpajakan 
								WHERE pengiriman_perpajakan.id_permintaan = permintaan_perpajakan.id_permintaan
								)")
							->limit($limit, $start)	
							->order_by('id_permintaan', 'ASC')
							->get()->result_array();
		}

		// TANPA PENGIRIMAN
		public function countForKlien($bulan, $tahun, $klien='') {
			if($klien) {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			return $this->db->from('permintaan_perpajakan')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->where("NOT EXISTS (SELECT * FROM pengiriman_perpajakan 
								WHERE pengiriman_perpajakan.id_permintaan = permintaan_perpajakan.id_permintaan
								)")
							->count_all_results();
		}
		
		public function getById($id_permintaan) {
			return $this->db->from('permintaan_perpajakan')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['id_permintaan' => $id_permintaan])
							->get()->row_array();
		}
		
		//delete soon
		public function getReqByKlien($masa, $tahun, $klien) {
			$q = "SELECT * FROM ((((permintaan_perpajakan
				LEFT JOIN jenis_data ON permintaan_perpajakan.kode_jenis = jenis_data.kode_jenis) 
				LEFT JOIN klien ON permintaan_perpajakan.id_klien = klien.id_klien) 
				LEFT JOIN user ON permintaan_perpajakan.id_pengirim = user.id_user) 
				LEFT JOIN pengiriman_perpajakan 
				ON permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_permintaan) 
				WHERE masa = '$masa' AND tahun = '$tahun' 
				AND permintaan_perpajakan.id_klien = '$klien' 
				ORDER BY permintaan_perpajakan.id_permintaan ASC"; 
			return $this->db->query($q)->result_array();
		}

		public function getMax($id_klien, $bulan, $tahun) { 
			$max = $this->db->select_max('id_permintaan')
							->where(['id_klien' => $id_klien, 'bulan'=>$bulan, 'tahun'=>$tahun])
							->get('permintaan_perpajakan')->row_array();
			
			if($max['id_permintaan']) {
				$tambah	= substr($max['id_permintaan'], -3);
				$newId	= substr($tahun, -2) . $bulan . $id_klien . ++$tambah;
			} else {
				$newId	= substr($tahun, -2) . $bulan . $id_klien . "201";
			}
			return $newId;
		}

		public function tambahPermintaan() { 
			$id_klien		= $this->input->post('id_klien', true);
			$bulan			= $this->input->post('bulan', true);
			$tahun			= $this->input->post('tahun', true);
			$id_permintaan	= $this->getMax($id_klien, $bulan, $tahun);
			
			$data = [
				'id_permintaan'		=> $id_permintaan,
				'tanggal_permintaan'=> date('d-m-Y H:i'),
				'id_klien'			=> $id_klien,
				'bulan'				=> $bulan,
				'tahun'				=> $tahun,
				'kode_jenis'		=> implode('|', $this->input->post('kode_jenis', true)),
				'format_data'		=> implode('|', $this->input->post('format_data', true)),
				'detail'			=> implode('|', $this->input->post('detail', true)),
				'request'			=> substr($id_permintaan, -2),
				'id_pengirim'		=> $this->input->post('id_user', true),
			];
			$this->db->insert('permintaan_perpajakan', $data);
		}
		
		public function hapusPermintaan($id_permintaan) { 
			$this->db->where('id_permintaan', $id_permintaan);
			$this->db->delete('permintaan_perpajakan');
		}
	}
?>