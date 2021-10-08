<?php
	
	class Tugas_model extends CI_model {
		
		public function getAllTugas($start='', $limit='', $kata_cari='') {
			if($kata_cari) {
				$this->db->like('nama_tugas', $kata_cari)
							->or_like('status_pekerjaan', $kata_cari)
							->or_like('lama_pengerjaan', $kata_cari)
							->or_like('jenis_data', $kata_cari);
			}
			return $this->db->from('tugas')
							->join('jenis_data', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->order_by('kode_tugas', 'ASC')
							->limit($limit, $start)
							->get()->result_array();
		}
		
		public function countTugas($kata_cari='') {
			if($kata_cari) {
				$this->db->like('nama_tugas', $kata_cari)
							->or_like('status_pekerjaan', $kata_cari)
							->or_like('lama_pengerjaan', $kata_cari)
							->or_like('jenis_data', $kata_cari);
			}
			return $this->db->from('tugas')
							->join('jenis_data', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->count_all_results();
		}
		
		public function getById($kode_tugas) {
			return $this->db->from('tugas')
							->join('jenis_data', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->where('kode_tugas', $kode_tugas)
							->get()->row_array();
		}
		
		public function getMax($jenis_data) {
			$max = $this->db->select_max('kode_tugas')
							->where(['id_jenis'=>$jenis_data])
							->get('tugas')->row_array();
			
			$tambah	= $max['kode_tugas'] ? substr($max['kode_tugas'], 3) : 0;
			$new	= sprintf('%02s', ++$tambah);
			
			return $jenis_data . $new;
		}
		
		public function tambahTugas($data) {
			$row = [
				'kode_tugas'			=> $this->getMax($data['id_jenis']),
				'nama_tugas'			=> $data['nama_tugas'],
				'accounting_service'	=> $data['accounting_service'],
				'review'				=> $data['review'],
				'semi_review'			=> $data['semi_review'],
				'id_jenis'				=> $data['id_jenis'],
			];
			$this->db->insert('tugas', $row);
			return $this->db->affected_rows();
		}
		
		public function ubahTugas($data) {
			$row = [
				'nama_tugas'			=> $data['nama_tugas'],
				'accounting_service'	=> $data['accounting_service'],
				'review'				=> $data['review'],
				'semi_review'			=> $data['semi_review'],
				'id_jenis'				=> $data['id_jenis'],
			];
			$this->db->where('kode_tugas', $data['kode_tugas'])
					->update('tugas', $row);
			return $this->db->affected_rows();
		}
		
		public function hapusTugas($kode_tugas) {
			$this->db->where('kode_tugas', $kode_tugas);
			$this->db->delete('tugas');
			return $this->db->affected_rows();
		}
	}
?>