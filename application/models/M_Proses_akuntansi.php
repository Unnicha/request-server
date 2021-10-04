<?php
	
	class M_Proses_akuntansi extends CI_model {
		
		public function getByMasa($status, $bulan, $tahun, $klien='', $start=0, $limit='') {
			if($klien)
			$this->db->where_in('permintaan_akuntansi.id_klien', $klien);
			if($limit)
			$this->db->limit($limit, $start);
			
			if($status == 'todo') {
				$this->db->where('status_proses', NULL);
			} elseif($status == 'onproses') {
				$this->db->where('status_proses', 'yet');
			} elseif($status == 'done') {
				$this->db->where('status_proses', 'done');
			}
			return $this->db->from('data_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = data_akuntansi.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_akuntansi.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_akuntansi.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->where(['bulan'=>$bulan, 'tahun'=>$tahun, 'status_kirim'=>'yes'])
							->order_by('id_data', 'ASC')
							->get()->result_array();
		}
		
		public function countProses($status, $bulan, $tahun, $klien='') {
			if($klien)
			$this->db->where_in('permintaan_akuntansi.id_klien', $klien);
			
			if($status == 'todo') {
				$this->db->where('status_proses', NULL);
			} elseif($status == 'onproses') {
				$this->db->where('status_proses', 'yet');
			} elseif($status == 'done') {
				$this->db->where('status_proses', 'done');
			}
			
			return $this->db->from('data_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = data_akuntansi.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_akuntansi.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_akuntansi.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->where(['bulan'=>$bulan, 'tahun'=>$tahun, 'status_kirim'=>'yes'])
							->order_by('id_data', 'ASC')
							->count_all_results();
		}
		
		public function getById($id_proses) {
			return $this->db->from('proses_akuntansi')
							->join('data_akuntansi', 'proses_akuntansi.kode_data = data_akuntansi.id_data', 'left')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = data_akuntansi.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_akuntansi.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_akuntansi.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->join('user', 'user.id_user = proses_akuntansi.id_akuntan', 'left')
							->where(['id_proses' => $id_proses])
							->get()->row_array();
		}
		
		public function getDetail($id_data) {
			return $this->db->from('proses_akuntansi')
							->join('user', 'user.id_user = proses_akuntansi.id_akuntan', 'left')
							->where(['kode_data' => $id_data])
							->order_by('id_proses', 'ASC')
							->get()->result_array();
		}
		
		public function getNew($id_data) {
			$max = $this->db->select_max('id_proses')
							->where(['kode_data' => $id_data])
							->get('proses_akuntansi')->row_array();
			
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
			$this->db->insert('proses_akuntansi', $row1);
			
			$row2 = [
				'status_proses' => ( $data['tanggal_selesai'] ) ? 'done' : 'yet',
				// 'status_proses' => $data['tanggal_selesai'],
			];
			$this->db->update('data_akuntansi', $row2, ['id_data' => $data['kode_data']]);
			return $this->db->affected_rows();
		}
		
		public function ubahProses( $data ) {
			$row1 = [
				'tanggal_selesai'	=> $data['tanggal_selesai'],
				'ket_proses'		=> $data['keterangan'],
			];
			$this->db->update('proses_akuntansi', $row1, ['id_proses' => $data['id_proses']]);
			
			$row2 = ['status_proses' => 'done'];
			$this->db->update('data_akuntansi', $row2, ['id_data' => $data['kode_data']]);
		}
		
		public function batalProses( $data ) {
			$row = ['status_proses' => NULL];
			$this->db->update('data_akuntansi', $row, ['id_data' => $data['kode_data']]);
		}
	}
?>