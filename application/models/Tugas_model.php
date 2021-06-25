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

		public function getMax($jenis_data, $status) {
			$max = $this->db->select_max('kode_tugas')
							->where(['id_jenis'=>$jenis_data, 'status_pekerjaan'=>$status])
							->get('tugas')->row_array();
			$kodeMax = $max['kode_tugas']; //masukkan max id ke variabel
			
			$kategori = $this->status_pekerjaan(); 
			foreach($kategori as $k => $val) {
				if($val['value'] == $status) {
					$pekerjaan = $kategori[$k];
				}
			}
			$default = $jenis_data . $pekerjaan['id']; 
			//$id_kategori = $this->db->get_where('status_pekerjaan', ['nama_pekerjaan' => $status])->row_array();
			
			if($kodeMax == null) { 
				$newId = $default .'01'; 
			} else { 
				//ambil kode tugas dari kode_tugas => substr("dari $kodeMax", "index ke", "sebanyak x char") 
				//jadikan integer => (int) 
				$tambah = (int) substr($kodeMax, 4, 2);
				$tambah++; //kode pembetulan +1
				$kode_tugas = sprintf("%02s", $tambah); //kode pembetulan baru, jadikan 2 char

				$newId = $default . $kode_tugas; //tambahkan kode pembetulan baru
			}
			return $newId;
		}

		public function status_pekerjaan() {
			$kategori = array(
				array('id' => '1', 'value' => 'Accounting Service'),
				array('id' => '2', 'value' => 'Review'),
				array('id' => '3', 'value' => 'Semi Review'),
			);
			return $kategori;
		}

		public function tambahTugas() {
			$jenis_data	= $this->input->post('kode_jenis', true);
			$status		= $this->input->post('status_pekerjaan', true);
			$kode_tugas	= $this->getMax($jenis_data, $status);
			$hari		= $this->input->post('hari', true);
			$jam		= $this->input->post('jam', true);
			$durasi		= ($hari * 8) + $jam;

			$data = [
				"kode_tugas"		=> $kode_tugas,
				"nama_tugas"		=> $this->input->post('nama_tugas', true),
				"status_pekerjaan"	=> $this->input->post('status_pekerjaan', true),
				"lama_pengerjaan"	=> $durasi,
				"id_jenis"			=> $this->input->post('kode_jenis', true),
			];
			$this->db->insert('tugas', $data);
		}

		public function ubahTugas() {
			$hari		= $this->input->post('hari', true);
			$jam		= $this->input->post('jam', true);
			$durasi		= ($hari * 8) + $jam;
			
			$data = [
				"kode_tugas"		=> $this->input->post('id_tugas', true),
				"nama_tugas"		=> $this->input->post('nama_tugas', true),
				"status_pekerjaan"	=> $this->input->post('status_pekerjaan', true),
				"lama_pengerjaan"	=> $durasi,
				"id_jenis"			=> $this->input->post('kode_jenis', true),
			];
			$this->db->where('kode_tugas', $this->input->post('id_tugas', true));
			$this->db->update('tugas', $data);
		}
		
		public function hapusTugas($kode_tugas) {
			$this->db->where('kode_tugas', $kode_tugas);
			$this->db->delete('tugas');
		}
	}
?>