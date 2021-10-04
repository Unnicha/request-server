<?php
	
	class M_Permintaan_perpajakan extends CI_model {
		
		public function getByMasa($bulan, $tahun, $klien='', $start=0, $limit='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			if($limit) {
				$this->db->limit($limit, $start);
			}
			$allData = '(SELECT COUNT(id_data) FROM data_perpajakan WHERE id_request = id_permintaan)';
			$dataYes = '(SELECT COUNT(id_data) FROM data_perpajakan WHERE status_kirim = "yes" AND id_request = id_permintaan)';
			return $this->db->select('*, '.$allData.' AS jumData')
							->from('permintaan_perpajakan')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->where($dataYes.' < '.$allData)
							->order_by('id_permintaan', 'ASC')
							->get()->result_array();
		}
		
		public function countPermintaan($bulan, $tahun, $klien='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			$allData = '(SELECT COUNT(id_data) FROM data_perpajakan WHERE id_request = id_permintaan)';
			$dataYes = '(SELECT COUNT(id_data) FROM data_perpajakan WHERE status_kirim = "yes" AND id_request = id_permintaan)';
			return $this->db->from('permintaan_perpajakan')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->where($dataYes.' < '.$allData)
							->order_by('id_permintaan', 'ASC')
							->count_all_results();
		}
		
		public function getById($id_permintaan) {
			$allData = '(SELECT COUNT(id_data) FROM data_perpajakan WHERE id_request = id_permintaan)';
			return $this->db->select('*, '.$allData.' AS jumData')
							->from('permintaan_perpajakan')
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
		
		public function countDetail($id_permintaan) {
			$all	= '(SELECT COUNT(id_data) FROM data_perpajakan WHERE id_request = id_permintaan)';
			$yes	= '(SELECT COUNT(id_data) FROM data_perpajakan WHERE id_request = id_permintaan AND status_kirim = "yes")';
			$no		= '(SELECT COUNT(id_data) FROM data_perpajakan WHERE id_request = id_permintaan AND status_kirim = "no")';
			$yet	= '(SELECT COUNT(id_data) FROM data_perpajakan WHERE id_request = id_permintaan AND status_kirim IS NULL)';
			return $this->db->select('('.$all.') AS jumAll, ('.$yes.') AS jumYes, ('.$no.') AS jumNo, ('.$yet.') AS jumNull')
							->from('permintaan_perpajakan')
							->where(['id_permintaan' => $id_permintaan])
							->get()->row_array();
		}
		
		public function getNew($id_klien, $bulan, $tahun) {
			$pre	= substr($tahun, -2) . $bulan . $id_klien;
			$max	= $this->db->select_max('id_permintaan')
								->where(['id_klien' => $id_klien, 'bulan'=>$bulan, 'tahun'=>$tahun])
								->get('permintaan_perpajakan')->row_array();
			
			if($max['id_permintaan']) {
				$tambah	= substr($max['id_permintaan'], -2);
				$new	= $pre .'1'. sprintf('%02s', ++$tambah); //kategori data
			} else {
				$new	= $pre .'1'.'01'; //kategori data
			}
			return $new;
		}
		
		public function tambahPermintaan( $data ) {
			$permintaan	= $data['permintaan'];
			$detail		= $data['detail'];
			$id			= $this->getNew($permintaan['id_klien'], $permintaan['bulan'], $permintaan['tahun']);
			
			// insert permintaan
			$table1 = [
				'id_permintaan'		=> $id,
				'tanggal_permintaan'=> date('d-m-Y H:i'),
				'id_klien'			=> $permintaan['id_klien'],
				'bulan'				=> $permintaan['bulan'],
				'tahun'				=> $permintaan['tahun'],
				'request'			=> substr($id, -2),
				'id_pengirim'		=> $permintaan['id_pengirim'],
			];
			$this->db->insert('permintaan_perpajakan', $table1);
			
			// insert data
			$table2 = [];
			foreach($detail as $num => $d) {
				$table2[] = [
					'id_data'		=> $id . sprintf('%02s', $num+1),
					'id_jenis'		=> $d['id_jenis'],
					'detail'		=> $d['detail'],
					'format_data'	=> $d['format_data'],
					'id_request'	=> $id,
				];
			}
			$this->db->insert_batch('data_perpajakan', $table2);
			return $this->db->affected_rows();
		}
		
		public function ubahPermintaan( $data ) {
			$row = [
				'detail'		=> $data['detail'],
				'format_data'	=> $data['format_data'],
			];
			$this->db->update('data_perpajakan', $row, ['id_data' => $data['id_data']]);
			return $this->db->affected_rows();
		}
		
		public function hapusPermintaan($id_permintaan) {
			$this->db->delete('permintaan_perpajakan', ['id_permintaan' => $id_permintaan]);
			$this->db->delete('data_perpajakan', ['id_request' => $id_permintaan]);
			return $this->db->affected_rows();
		}
		
		public function hapusData($id_data) {
			$this->db->delete('data_perpajakan', ['id_data' => $id_data]);
			return $this->db->affected_rows();
		}
	}
?>