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
		
		public function getById($id_permintaan) {
			return $this->db->from('permintaan_perpajakan')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['id_permintaan' => $id_permintaan])
							->get()->row_array();
		}
		
		public function getDetail($id_permintaan) {
			return $this->db->from('data_perpajakan')
							->join('jenis_data', 'jenis_data.kode_jenis = data_perpajakan.id_jenis', 'left')
							->where(['id_request' => $id_permintaan])
							->get()->result_array();
		}
		
		public function getMax($id_klien, $bulan, $tahun) { 
			$max_req = $this->db->select_max('id_permintaan', 'id')
							->where(['id_klien' => $id_klien, 'bulan'=>$bulan, 'tahun'=>$tahun])
							->get('permintaan_perpajakan')->row_array();
			
			$pre		= substr($tahun, -2) . $bulan . $id_klien;
			$max_data	= $this->db->select_max('id_data', 'id')
									->like('id_data', $pre)
									->get('data_perpajakan')->row_array();
			
			if($max_req['id']) {
				$tambah				= substr($max_req['id'], -2);
				$new['permintaan']	= $pre .'2'. sprintf('%02s', ++$tambah);
			} else {
				$new['permintaan']	= $pre .'201';
			}
			
			if($max_data['id']) {
				$new['data']	= $max_data['id'];
			} else {
				$new['data']	= $pre .'2'.'000';
			}
			return $new;
		}
		
		public function tambahPermintaan() { 
			$id_klien		= $this->input->post('id_klien', true);
			$bulan			= $this->input->post('bulan', true);
			$tahun			= $this->input->post('tahun', true);
			$newId			= $this->getMax($id_klien, $bulan, $tahun);
			$id_permintaan	= $newId['permintaan'];
			$id_data		= $newId['data'];
			
			$data = [
				'id_permintaan'		=> $id_permintaan,
				'tanggal_permintaan'=> date('d-m-Y H:i'),
				'id_klien'			=> $id_klien,
				'bulan'				=> $bulan,
				'tahun'				=> $tahun,
				'request'			=> substr($id_permintaan, -2),
				'id_pengirim'		=> $this->input->post('id_user', true),
			];
			
			for($i=0; $i<count($this->input->post('kode_jenis', true)); $i++) {
				$tambah		= substr($id_data, -3);
				$id_data	= substr($id_data, 0, -3) . sprintf('%03s', ++$tambah);
				$row[]		= [
					'id_data'		=> $id_data,
					'id_jenis'		=> $this->input->post('kode_jenis', true)[$i],
					'format_data'	=> $this->input->post('format_data', true)[$i],
					'detail'		=> $this->input->post('detail', true)[$i],
					'id_request'	=> $id_permintaan,
				];
			}
			$this->db->insert('permintaan_perpajakan', $data);
			$this->db->insert_batch('data_perpajakan', $row);
		}
		
		public function hapusPermintaan($id_permintaan) { 
			$this->db->where('id_permintaan', $id_permintaan);
			$this->db->delete('permintaan_perpajakan');
		}
	}
?>