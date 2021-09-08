<?php

	class Klien_model extends CI_model {

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
							->order_by('nama_klien', 'ASC')
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
			$this->db->from('klien')
					->join('klu', 'klien.kode_klu = klu.kode_klu', 'left')
					->join('user', 'klien.id_klien = user.id_user', 'left')
					->where_in('id_klien', $id_klien);
			
			$many = (is_array($id_klien)) ? true : false;
			if($many == true) {
				return $this->db->get()->result_array();
			} else {
				return $this->db->get()->row_array();
			}
		}
		
		public function getId() {
			$klien		= $this->db->select('id_klien')->get('klien')->result_array();
			$id_klien	= [];
			foreach($klien as $k) {
				$id_klien[] = $k['id_klien'];
			}
			return $id_klien;
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
			$max = $this->db->select_max('id_user', 'maxId')
							->where('level', $level)
							->get('user')->row_array();
			
			$tambah	= (int) substr($max['maxId'], 1, 3);
			$baru	= sprintf('%03s', ++$tambah); 
			
			return '3'.$baru;
		}
		
		public function cekUnique($table, $field, $value) {
			$cek = $this->db->get_where($table, [$field => $value])->row_array();
			if($cek) {
				return false;
			} else {
				return true;
			}
		}
		
		public function tambahKlien() {
			$id_klien = $this->getMax($this->input->post('level', true));
			$data1 = [
				'id_klien'			=> $id_klien,
				'nama_klien'		=> $this->input->post('nama_klien', true),
				'email_klien'		=> $this->input->post('email', true),
				
				'nama_usaha'		=> $this->input->post('nama_usaha', true),
				'kode_klu'			=> $this->input->post('kode_klu', true),
				'no_akte'			=> $this->input->post('no_akte', true),
				'alamat'			=> $this->input->post('alamat', true),
				'telp'				=> $this->input->post('telp', true),
				'no_hp'				=> $this->input->post('no_hp', true),
				'status_pekerjaan'	=> $this->input->post('status_pekerjaan', true),
				
				'nama_pimpinan'		=> $this->input->post('nama_pimpinan', true),
				'jabatan'			=> $this->input->post('jabatan', true),
				'no_hp_pimpinan'	=> $this->input->post('no_hp_pimpinan', true),
				'email_pimpinan'	=> $this->input->post('email_pimpinan', true),
				
				'nama_counterpart'	=> $this->input->post('nama_counterpart', true),
				'no_hp_counterpart'	=> $this->input->post('no_hp_counterpart', true),
				'email_counterpart'	=> $this->input->post('email_counterpart', true),
			];
			$this->db->insert('klien', $data1);
			
			$data2 = [
				'id_user'		=> $id_klien,
				'username'		=> $this->input->post('username', true),
				'password'		=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
				'passlength'	=> strlen($this->input->post('password', true)),
				'level'			=> $this->input->post('level', true),
				'nama'			=> $this->input->post('nama_klien', true),
				'email_user'	=> $this->input->post('email', true),
			];
			$this->db->insert('user', $data2);
		}
		
		public function ubahAkun() {
			$tipe	= $this->input->post('tipe', true);
			
			if($tipe == 'nama') {
				$data	= [ 'nama' => $this->input->post('nama', true) ];
				$data2	= [ 'nama_klien' => $this->input->post('nama', true) ];
			} elseif($tipe == 'email') {
				$data	= [ 'email_user' => $this->input->post('email', true) ];
				$data2	= [ 'email_klien' => $this->input->post('email', true) ];
			} elseif($tipe == 'username') {
				$data	= [ 'username' => $this->input->post('username', true) ];
			} elseif($tipe == 'password') {
				$data	= [
					'password'		=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
					'passlength'	=> strlen($this->input->post('password', true)),
				];
			}
			
			if($tipe=='nama' || $tipe=='email') {
				$this->db->where('id_klien', $this->input->post('id_klien', true));
				$this->db->update('klien', $data2);
			}
			$this->db->where('id_user', $this->input->post('id_klien', true));
			$this->db->update('user', $data);
		}
		
		public function ubahProfile() {
			$tipe	= $this->input->post('tipe', true);
			
			if($tipe == 'usaha') {
				$data = [
					'nama_usaha'		=> $this->input->post('nama_usaha', true),
					'kode_klu'			=> $this->input->post('kode_klu', true),
					'alamat'			=> $this->input->post('alamat', true),
					'telp'				=> $this->input->post('telp', true),
					'no_hp'				=> $this->input->post('no_hp', true),
					'no_akte'			=> $this->input->post('no_akte', true),
					'status_pekerjaan'	=> $this->input->post('status_pekerjaan', true),
				];
			} elseif($tipe == 'pimpinan') {
				$data = [
					'nama_pimpinan'		=> $this->input->post('nama_pimpinan', true),
					'jabatan'			=> $this->input->post('jabatan', true),
					'no_hp_pimpinan'	=> $this->input->post('no_hp_pimpinan', true),
					'email_pimpinan'	=> $this->input->post('email_pimpinan', true),
				];
			} elseif($tipe == 'counter') {
				$data = [
					'nama_counterpart'	=> $this->input->post('nama_counterpart', true),
					'no_hp_counterpart'	=> $this->input->post('no_hp_counterpart', true),
					'email_counterpart'	=> $this->input->post('email_counterpart', true),
				];
			}
			$this->db->where('id_klien', $this->input->post('id_klien', true));
			$this->db->update('klien', $data);
		}
		
		public function hapusDataKlien($id_klien) {
			$this->db->where('id_klien', $id_klien)->delete('klien');
			$this->db->where('id_user', $id_klien)->delete('user');
		}
	}
?>