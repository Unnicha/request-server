<?php
	
	class M_Pengiriman_perpajakan extends CI_model {
		
		public function getByMasa($bulan, $tahun, $klien='', $start=0, $limit='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			if($limit) {
				$this->db->limit($limit, $start);
			}
			$dataSent = '(SELECT COUNT(id_data) FROM data_perpajakan WHERE status_kirim!="NULL" AND id_request=id_permintaan) > 0';
			return $this->db->from('permintaan_perpajakan')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->where($dataSent)
							->order_by('id_permintaan', 'ASC')
							->get()->result_array();
		}
		
		public function countPengiriman($bulan, $tahun, $klien='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			$dataSent = '(SELECT COUNT(id_data) FROM data_perpajakan WHERE status_kirim!="NULL" AND id_request=id_permintaan) > 0';
			return $this->db->from('permintaan_perpajakan')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->where($dataSent)
							->count_all_results();
		}
		
		public function getById($id_data) {
			return $this->db->from('data_perpajakan')
							->join('jenis_data', 'jenis_data.kode_jenis = data_perpajakan.id_jenis', 'left')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = data_perpajakan.id_request', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->where(['id_data' => $id_data])
							->get()->row_array();
		}
		
		public function getDetail($id_data) {
			return $this->db->from('pengiriman_perpajakan')
							->join('data_perpajakan', 'pengiriman_perpajakan.kode_data = data_perpajakan.id_data', 'left')
							->where(['id_data' => $id_data])
							->get()->result_array();
		}
		
		public function getNew($id_data) {
			$max = $this->db->select_max('id_pengiriman')
							->where(['kode_data' => $id_data])
							->get('pengiriman_perpajakan')->row_array();
			if($max['id_pengiriman']) {
				$revisi	= substr($max['id_pengiriman'], -2);
				$id		= $id_data . sprintf('%02s', ++$revisi); 
			} else {
				$id		= $id_data . '01'; 
			}
			return $id;
		}
		
		public function getMax($id_data) {
			return $this->db->where(['kode_data' => $id_data])
							->order_by('id_pengiriman', 'DESC')
							->get('pengiriman_perpajakan', 1)
							->row_array();
		}
		
		public function kirim($data) {
			$id_pengiriman = $this->getNew($data['kode_data']);
			$row = [
				'id_pengiriman'			=> $id_pengiriman,
				'pengiriman'			=> substr($id_pengiriman, -2),
				'tanggal_pengiriman'	=> date('d-m-Y H:i'),
				'file'					=> $data['file'],
				'ket_pengiriman'		=> $data['keterangan'],
				'kode_data'				=> $data['kode_data'],
			];
			// jika ada pengiriman, status data=>'no'
			$this->db->update('data_perpajakan', ['status_kirim'=>'no'], ['id_data'=>$data['kode_data']]);
			$this->db->insert('pengiriman_perpajakan', $row);
			return $this->db->affected_rows();
		}
		
		public function konfirmasi($data) {
			$row = [
				'status_kirim' => $data['status'],
			];
			$this->db->update('data_perpajakan', $row, ['id_data' => $data['id_data']]);
			return $this->db->affected_rows();
		}
		
		// public function hapusPengiriman($kode_data) {
		// 	$this->db->where('kode_data', $kode_data);
		// 	$this->db->delete('pengiriman_perpajakan');
		// }
	}
?>