<?php

	class Klien_model extends CI_model {

		public function getKlien() {
			return $this->db->get('klien')->result_array();
		}

		public function getAllKlien($start=0, $limit='', $kata_cari='') {
			if($kata_cari) {
				$this->db->like('nama_klien', $kata_cari)
						->or_like('status_pekerjaan', $kata_cari)
						->or_like('jenis_usaha', $kata_cari)
						->or_like('nama_pimpinan', $kata_cari);
			}
			if($limit) $this->db->limit($limit, $start);
			return $this->db->from('klien')
							->join('klu', 'klien.kode_klu = klu.kode_klu', 'left')
							->join('user', 'klien.id_klien = user.id_user', 'left')
							->order_by('id_klien', 'ASC')
							->get()->result_array();
		}

		public function countKlien($kata_cari='') {
			if($kata_cari) {
				$this->db->like('nama_klien', $kata_cari)
						->or_like('status_pekerjaan', $kata_cari)
						->or_like('jenis_usaha', $kata_cari)
						->or_like('nama_pimpinan', $kata_cari);
			}
			return $this->db->from('klien')
							->join('klu', 'klien.kode_klu = klu.kode_klu', 'left')
							->join('user', 'klien.id_klien = user.id_user', 'left')
							->count_all_results();
		}

		public function getById($id_klien) {
			return $this->db->from('klien')
							->join('klu', 'klien.kode_klu = klu.kode_klu', 'left')
							->join('user', 'klien.id_klien = user.id_user', 'left')
							->where('klien.id_klien', $id_klien)
							->get()->row_array();
		}
		
		public function getMasa($masa='') {
			if($masa){
				return $this->db->where(['id_bulan' => $masa])
								->or_where(['nama_bulan' => $masa])
								->get('bulan')->row_array();
			} else {
				return $this->db->get('bulan')->result_array();
			}
		}

		public function getMax($level) {
			$q = "SELECT MAX(id_user) as maxId FROM user WHERE level = '$level' ";
			$max = $this->db->query($q)->row_array();
			$kodeMax = $max['maxId']; 
			
			// ambil kode angka => substr(dari $kodeMax, index 1, sebanyak 3 char) 
			// jadikan integer => (int) 
			$tambah = (int) substr($kodeMax, 1, 3);
			$tambah++;  //kode lama +1
			$baru = sprintf("%03s", $tambah); 
			$kode_baru = "3{$baru}"; 

			return $kode_baru;
		}

		public function tambahKlien() {
			
			$id_klien = $this->getMax($this->input->post('level', true));
			$data1 = [
				"id_klien" => $id_klien,
				"nama_klien" => $this->input->post('nama_klien', true),
				
				"nama_usaha"		=> $this->input->post('nama_usaha', true),
				"kode_klu"			=> $this->input->post('kode_klu', true),
				"no_akte"			=> $this->input->post('no_akte', true),
				"alamat"			=> $this->input->post('alamat', true),
				"telp"				=> $this->input->post('telp', true),
				"no_hp"				=> $this->input->post('no_hp', true),
				"email"				=> $this->input->post('email', true),
				"status_pekerjaan"	=> $this->input->post('status_pekerjaan', true),

				"nama_pimpinan"     => $this->input->post('nama_pimpinan', true),
				"jabatan"           => $this->input->post('jabatan', true),
				"no_hp_pimpinan"    => $this->input->post('no_hp_pimpinan', true),
				"email_pimpinan"    => $this->input->post('email_pimpinan', true),

				"nama_counterpart"  => $this->input->post('nama_counterpart', true),
				"no_hp_counterpart" => $this->input->post('no_hp_counterpart', true),
				"email_counterpart" => $this->input->post('email_counterpart', true),
			];
			$this->db->insert('klien', $data1);
			
			$data2 = [
				"id_user"	=> $id_klien,
				"username"	=> $this->input->post('username', true),
				"password"	=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
				"level"		=> $this->input->post('level', true),
				"nama"		=> $this->input->post('nama_klien', true),
				"email_user"=> $this->input->post('email', true),
			];
			$this->db->insert('user', $data2);
		}

		public function ubahProfilKlien() {
			$data = [
				"id_klien"          => $this->input->post('id_klien', true),
				"nama_klien"        => $this->input->post('nama_klien', true),
				
				"status_pekerjaan"  => $this->input->post('status_pekerjaan', true),
				"kode_klu"          => $this->input->post('kode_klu', true),
				"alamat"            => $this->input->post('alamat', true),
				"no_akte"           => $this->input->post('no_akte', true),
				"telp"              => $this->input->post('telp', true),
				"no_hp"             => $this->input->post('no_hp', true),
				"email"             => $this->input->post('email', true),
				
				"nama_pimpinan"     => $this->input->post('nama_pimpinan', true),
				"jabatan"           => $this->input->post('jabatan', true),
				"no_hp_pimpinan"    => $this->input->post('no_hp_pimpinan', true),
				"email_pimpinan"    => $this->input->post('email_pimpinan', true),
				
				"nama_counterpart"  => $this->input->post('nama_counterpart', true),
				"no_hp_counterpart" => $this->input->post('no_hp_counterpart', true),
				"email_counterpart" => $this->input->post('email_counterpart', true),
			];
			$this->db->where('id_klien', $this->input->post('id_klien', true));
			$this->db->update('klien', $data);
		}

		public function ubahAkunKlien() {
			$id_user = $this->input->post('id_user', true);
			$username = $this->input->post('username', true);

			$this->db->where('username', $username);
			$this->db->where('id_user !=', $id_user);
			$cek_user = $this->db->get('user')->row_array();
			
			if($cek_user != null) { 
				$this->session->set_flashdata('username', 'Username sudah digunakan'); 
				redirect('klien/profile/ganti_username');
			}

			$data = [
				"id_user"	=> $this->input->post('id_user', true),
				"username"	=> $this->input->post('username', true),
				"password"	=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
				"level"		=> $this->input->post('level', true),
				"nama"		=> $this->input->post('nama_klien', true),
				"email_user"=> $this->input->post('email', true),
			];
			$this->db->where('id_user', $id_user);
			$this->db->update('user', $data);
		}
		
		public function hapusDataKlien($id_klien) {
			
			$this->db->where('id_klien', $id_klien);
			$this->db->delete('klien');
			$this->db->where('id_user', $id_klien);
			$this->db->delete('user');
		}
	}
?>