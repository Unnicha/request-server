<?php
	
	class M_Proses_perpajakan extends CI_model {
		
		public function getByMasa($status, $bulan, $tahun, $klien='', $start=0, $limit='') {
			if($klien)
			$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			if($limit)
			$this->db->limit($limit, $start);
			
			if($status == 'todo') {
				$this->db->where('status_proses', NULL);
			} elseif($status == 'onproses') {
				$this->db->where('status_proses', 'yet');
			} elseif($status == 'done') {
				$this->db->where('status_proses', 'done');
			}
			return $this->db->from('data_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = data_perpajakan.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_perpajakan.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_perpajakan.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->where(['bulan'=>$bulan, 'tahun'=>$tahun, 'status_kirim'=>'yes'])
							->order_by('id_data', 'ASC')
							->get()->result_array();
		}
		
		public function countProses($status, $bulan, $tahun, $klien='') {
			if($klien)
			$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			
			if($status == 'todo') {
				$this->db->where('status_proses', NULL);
			} elseif($status == 'onproses') {
				$this->db->where('status_proses', 'yet');
			} elseif($status == 'done') {
				$this->db->where('status_proses', 'done');
			}
			
			return $this->db->from('data_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = data_perpajakan.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_perpajakan.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_perpajakan.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->where(['bulan'=>$bulan, 'tahun'=>$tahun, 'status_kirim'=>'yes'])
							->order_by('id_data', 'ASC')
							->count_all_results();
		}
		
		public function getById($id_proses) {
			return $this->db->from('proses_perpajakan')
							->join('data_perpajakan', 'proses_perpajakan.kode_data = data_perpajakan.id_data', 'left')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = data_perpajakan.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_perpajakan.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_perpajakan.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->join('user', 'user.id_user = proses_perpajakan.id_akuntan', 'left')
							->where(['id_proses' => $id_proses])
							->get()->row_array();
		}
		
		public function getDetail($id_data) {
			return $this->db->from('proses_perpajakan')
							->join('user', 'user.id_user = proses_perpajakan.id_akuntan', 'left')
							->where(['kode_data' => $id_data])
							->order_by('id_proses', 'ASC')
							->get()->result_array();
		}
		
		public function getNew($id_data) {
			$max = $this->db->select_max('id_proses')
							->where(['kode_data' => $id_data])
							->get('proses_perpajakan')->row_array();
			
			$add	= ($max['id_proses']) ? substr($max['id_proses'], -2) : '0';
			$id		= $id_data . sprintf('%02s', ++$add);
			return $id;
		}
		
		public function simpanProses( $data ) {
			$row1 = [
				'id_proses'			=> $this->getNew($data['kode_data']),
				'tanggal_proses'	=> date('d-m-Y H:i'),
				'tanggal_mulai'		=> $data['tanggal_mulai'],
				'tanggal_selesai'	=> $data['tanggal_selesai'],
				'ket_proses'		=> $data['keterangan'],
				'kode_data'			=> $data['kode_data'],
				'id_akuntan'		=> $data['id_akuntan'],
			];
			$this->db->insert('proses_perpajakan', $row1);
			
			$row2 = [
				'status_proses' => ( $data['tanggal_selesai'] ) ? 'done' : 'yet',
				// 'status_proses' => $data['tanggal_selesai'],
			];
			$this->db->update('data_perpajakan', $row2, ['id_data' => $data['kode_data']]);
			return $this->db->affected_rows();
		}
		
		public function ubahProses( $data ) {
			$row1 = [
				'tanggal_selesai'	=> $data['tanggal_selesai'],
				'ket_proses'		=> $data['keterangan'],
			];
			$this->db->update('proses_perpajakan', $row1, ['id_proses' => $data['id_proses']]);
			
			$row2 = ['status_proses' => 'done'];
			$this->db->update('data_perpajakan', $row2, ['id_data' => $data['kode_data']]);
		}
		
		public function batalProses( $data ) {
			$row = ['status_proses' => NULL];
			$this->db->update('data_perpajakan', $row, ['id_data' => $data['kode_data']]);
		}
	}
?>