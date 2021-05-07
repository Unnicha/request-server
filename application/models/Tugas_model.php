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
							->join('jenis_data', 'tugas.kode_jenis = jenis_data.kode_jenis', 'left')
							->order_by('id_tugas', 'ASC')
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
							->join('jenis_data', 'tugas.kode_jenis = jenis_data.kode_jenis', 'left')
							->count_all_results();
		}

		public function getById($id_tugas) {
			$q = "SELECT * FROM tugas 
				LEFT JOIN jenis_data ON tugas.kode_jenis = jenis_data.kode_jenis
				WHERE id_tugas = '$id_tugas'";
			return $this->db->query($q)->row_array();
		}

		public function getByStatus($status) {
			return $this->db->query("SELECT * FROM tugas WHERE status_pekerjaan ='$status'")->row_array();
		}

		public function getByPengiriman() { // still on process

			$q = "SELECT * FROM (tugas 
				LEFT JOIN (pengiriman 
				LEFT JOIN ((permintaan 
				LEFT JOIN jenis_data ON permintaan.kode_jenis = jenis_data.kode_jenis) 
				LEFT JOIN klien ON klien.id_klien = permintaan.id_klien) 
				ON pengiriman.id_permintaan = permintaan.id_permintaan) 
				ON pengiriman.kode_jenis = tugas.kode_jenis) 
				ORDER BY id_tugas ASC"; 
			return $this->db->query($q)->result_array();
		}

		public function getMax($jenis_data, $status) {

			//mengambil max id_tugas
			$q = "SELECT max(id_tugas) as maxId FROM tugas 
				WHERE kode_jenis = '$jenis_data' 
				AND status_pekerjaan = '$status' ";
			$max = $this->db->query($q)->row_array();
			$kodeMax = $max['maxId']; //masukkan max id ke variabel
			
			$kategori = $this->status_pekerjaan(); 
			foreach($kategori as $k => $val) {
				if($val['value'] == $status) {
					$pekerjaan = $kategori[$k];
				}
			}
			$default = "{$jenis_data}{$pekerjaan['id']}"; 
			//$id_kategori = $this->db->get_where('status_pekerjaan', ['nama_pekerjaan' => $status])->row_array();
			
			if($kodeMax == null) { 
				$newId = "{$default}01"; 
			} else { 
				//ambil kode tugas dari id_tugas => substr("dari $kodeMax", "index ke", "sebanyak x char") 
				//jadikan integer => (int) 
				$tambah = (int) substr($kodeMax, 4, 2);
				$tambah++; //kode pembetulan +1
				$kode_tugas = sprintf("%02s", $tambah); //kode pembetulan baru, jadikan 2 char

				$newId = "{$default}{$kode_tugas}"; //tambahkan kode pembetulan baru
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
			
			$jenis_data = $this->input->post('kode_jenis', true);
			$status     = $this->input->post('status_pekerjaan', true);
			$id_tugas   = $this->getMax($jenis_data, $status);

			$hari = $this->input->post('hari', true);
			$jam = $this->input->post('jam', true);
			$lama_pengerjaan = ($hari * 8) + $jam;

			$data = [
				"id_tugas" => $id_tugas,
				"nama_tugas" => $this->input->post('nama_tugas', true),
				"status_pekerjaan" => $this->input->post('status_pekerjaan', true),
				"lama_pengerjaan" => $lama_pengerjaan,
				"kode_jenis" => $this->input->post('kode_jenis', true),
			];
			$this->db->insert('tugas', $data);
		}

		public function ubahTugas() {
			
			$hari = $this->input->post('hari', true);
			$jam = $this->input->post('jam', true);
			$lama_pengerjaan = ($hari * 8) + $jam;
			
			$data = [
				"id_tugas" => $this->input->post('id_tugas', true),
				"nama_tugas" => $this->input->post('nama_tugas', true),
				"status_pekerjaan" => $this->input->post('status_pekerjaan', true),
				"lama_pengerjaan" => $lama_pengerjaan,
				"kode_jenis" => $this->input->post('kode_jenis', true),
			];
			$this->db->where('id_tugas', $this->input->post('id_tugas', true));
			$this->db->update('tugas', $data);
		}
		
		public function hapusTugas($id_tugas) {
			
			$this->db->where('id_tugas', $id_tugas);
			$this->db->delete('tugas');
		}
	}
?>