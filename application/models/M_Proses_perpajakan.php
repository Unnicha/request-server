<?php
	
	class M_Proses_perpajakan extends CI_model {
		
		public function getByMasa($status, $bulan, $tahun, $klien='', $start='', $limit='') {
			if($klien) {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			if($limit) {
				$this->db->limit($limit, $start);
			}
			
			if($status == 'todo') {
				$this->db->where('status_proses', NULL);
			} elseif($status == 'onproses') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai'=>null]);
			} elseif($status == 'done') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai !='=>null]);
			}
			return $this->db->from('data_perpajakan')
							->join('proses_perpajakan', 'proses_perpajakan.kode_data = data_perpajakan.id_data', 'left')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = data_perpajakan.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_perpajakan.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_perpajakan.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->join('user', 'user.id_user = proses_perpajakan.id_akuntan', 'left')
							->where(['bulan'=>$bulan, 'tahun'=>$tahun, 'status_kirim'=>'yes'])
							->order_by('id_data', 'ASC')
							->get()->result_array();
		}
		
		public function countProses($status, $bulan, $tahun, $klien='') {
			if($klien) {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			if($status == 'todo') {
				$this->db->where('status_proses', NULL);
			} elseif($status == 'onproses') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai'=>null]);
			} elseif($status == 'done') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai !='=>null]);
			}
			
			return $this->db->from('data_perpajakan')
							->join('proses_perpajakan', 'proses_perpajakan.kode_data = data_perpajakan.id_data', 'left')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = data_perpajakan.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_perpajakan.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_perpajakan.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->join('user', 'user.id_user = proses_perpajakan.id_akuntan', 'left')
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
		
		public function tambahProses() {
			$mulai		= $this->input->post('tanggal_mulai', true).' '.$this->input->post('jam_mulai', true);
			$selesai	= $this->input->post('tanggal_selesai', true).' '.$this->input->post('jam_selesai', true);
			$id_data	= $this->input->post('id_data', true);
			$id_user	= $this->input->post('id_user', true);
			$id_proses	= $this->getNew($id_data);
			
			$data = [
				'id_proses'			=> $id_proses,
				'tanggal_proses'	=> date('d-m-Y H:i'),
				'tanggal_mulai'		=> $mulai,
				'tanggal_selesai'	=> ($selesai == ' ') ? '' : $selesai,
				'ket_proses'		=> $this->input->post('keterangan', true),
				'kode_data'			=> $id_data,
				'id_akuntan'		=> $id_user,
			];
			$this->db->insert('proses_perpajakan', $data);
			$row = [
				'status_proses' => ($selesai==' ') ? 'yet' : 'done',
			];
			$this->db->update('data_perpajakan', $row, ['id_data'=>$id_data]);
		}
		
		public function ubahProses() {
			$id_proses	= $this->input->post('id_proses', true);
			$id_data	= $this->input->post('id_data', true);
			$selesai	= $this->input->post('tanggal_selesai', true).' '.$this->input->post('jam_selesai', true);
			$data = [
				'tanggal_selesai'	=> ($selesai == ' ') ? '' : $selesai,
				'ket_proses'		=> $this->input->post('keterangan', true),
			];
			$this->db->update('proses_perpajakan', $data, ['id_proses'=>$id_proses]);
			$this->db->update('data_perpajakan', ['status_proses'=>'done'], ['id_data'=>$id_data]);
		}
		
		public function batalProses($id_data, $id_proses='') {
			$this->db->update('data_perpajakan', ['status_proses' => NULL], ['id_data' => $id_data]);
		}
	}
?>