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

		public function getByStatus($status) {
			return $this->db->get_where('tugas', ['status_pekerjaan'=>$status])->result_array();
		}

		public function getMax($jenis_data) {
			$max = $this->db->select_max('kode_tugas')
							->where(['id_jenis'=>$jenis_data])
							->get('tugas')->row_array();
			
			$tambah	= $max['kode_tugas'] ? substr($max['kode_tugas'], 3) : 0;
			$new	= sprintf("%02s", ++$tambah);
			
			return $newId = $jenis_data . $new;
		}

		public function tambahTugas() {
			$kode_tugas	= $this->getMax($this->input->post('kode_jenis', true));
			$durasi		= [];
			for($i=0; $i<count($_POST['hari']); $i++) {
				$durasi[] = ($_POST['hari'][$i] * 8) + $_POST['jam'][$i];
			}
			
			$data = [
				"kode_tugas"		=> $kode_tugas,
				"nama_tugas"		=> $this->input->post('nama_tugas', true),
				"accounting_service"=> $durasi[0],
				"review"			=> $durasi[1],
				"semi_review"		=> $durasi[2],
				"id_jenis"			=> $this->input->post('kode_jenis', true),
			];
			$this->db->insert('tugas', $data);
		}

		public function ubahTugas() {
			$durasi = [];
			for($i=0; $i<count($_POST['hari']); $i++) {
				$durasi[] = ($_POST['hari'][$i] * 8) + $_POST['jam'][$i];
			}
			
			$data = [
				"nama_tugas"		=> $this->input->post('nama_tugas', true),
				"accounting_service"=> $durasi[0],
				"review"			=> $durasi[1],
				"semi_review"		=> $durasi[2],
				"id_jenis"			=> $this->input->post('kode_jenis', true),
			];
			$this->db->where('kode_tugas', $this->input->post('kode_tugas', true));
			$this->db->update('tugas', $data);
		}
		
		public function hapusTugas($kode_tugas) {
			$this->db->where('kode_tugas', $kode_tugas);
			$this->db->delete('tugas');
		}
	}
?>