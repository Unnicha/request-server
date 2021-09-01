<?php
	
	class M_Proses_akuntansi extends CI_model {
		
		public function getByMasa($status, $bulan, $tahun, $klien='', $start='', $limit='') {
			if($klien) {
				$this->db->where_in('permintaan_akuntansi.id_klien', $klien);
			}
			if($limit) {
				$this->db->limit($limit, $start);
			}
			
			if($status == 'todo') {
				$this->db->where('status_proses !=', 'done');
			} elseif($status == 'onproses') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai'=>null]);
			} elseif($status == 'done') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai !='=>null]);
			}
			return $this->db->from('data_akuntansi')
							->join('proses_akuntansi', 'proses_akuntansi.kode_data = data_akuntansi.id_data', 'left')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = data_akuntansi.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_akuntansi.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_akuntansi.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->join('user', 'user.id_user = proses_akuntansi.id_akuntan', 'left')
							->where(['bulan'=>$bulan, 'tahun'=>$tahun, 'status_kirim'=>'yes'])
							->order_by('id_data', 'ASC')
							->get()->result_array();
		}
		
		public function countProses($status, $bulan, $tahun, $klien='') {
			if($klien) {
				$this->db->where_in('permintaan_akuntansi.id_klien', $klien);
			}
			if($status == 'todo') {
				$this->db->where('status_proses', NULL);
			} elseif($status == 'onproses') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai'=>null]);
			} elseif($status == 'done') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai !='=>null]);
			}
			
			return $this->db->from('data_akuntansi')
							->join('proses_akuntansi', 'proses_akuntansi.kode_data = data_akuntansi.id_data', 'left')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = data_akuntansi.id_request', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_akuntansi.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_akuntansi.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->join('user', 'user.id_user = proses_akuntansi.id_akuntan', 'left')
							->where(['bulan'=>$bulan, 'tahun'=>$tahun, 'status_kirim'=>'yes'])
							->order_by('id_data', 'ASC')
							->count_all_results();
		}
		
		public function getDetail($id_data) {
			return $this->db->where(['kode_data' => $id_data])
							->order_by('id_proses', 'ASC')
							->get('proses_akuntansi')
							->result_array();
		}
		
		public function getNew($id_data) { 
			$max = $this->db->select_max('id_proses')
							->where(['kode_data' => $id_data])
							->get('proses_akuntansi')->row_array();
			
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
				'tanggal_selesai'	=> ($selesai == ' ') ? null : $selesai,
				'ket_proses'		=> $this->input->post('keterangan', true),
				'kode_data'			=> $id_data,
				'id_akuntan'		=> $id_user,
			];
			$this->db->insert('proses_akuntansi', $data);
			$row = [
				'status_proses' => ($selesai==' ') ? 'yet' : 'done',
			];
			$this->db->update('data_akuntansi', $row, ['id_data'=>$id_data]);
		}
		
		public function ubahProses() {
			$id_proses	= $this->input->post('id_proses', true);
			$id_data	= $this->input->post('id_data', true);
			$data = [
				'tanggal_selesai'	=> $this->input->post('tanggal_selesai', true).' '.$this->input->post('jam_selesai', true),
				'ket_proses'		=> $this->input->post('keterangan', true),
			];
			$this->db->update('proses_akuntansi', $data, ['id_proses'=>$id_proses]);
			$this->db->update('data_akuntansi', ['status_proses'=>'done'], ['id_data'=>$id_data]);
		}
		
		public function batalProses($id_data, $id_proses='') {
			$this->db->update('data_akuntansi', ['status_proses' => 'yet'], ['id_data' => $id_data]);
		}
	}
?>