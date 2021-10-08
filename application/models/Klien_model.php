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
			$max = $this->db->select_max('id_user')
							->where('level', $level)
							->get('user')->row_array();
			
			$tambah	= (int) substr($max['id_user'], 1, 3);
			$baru	= sprintf('%03s', ++$tambah); 
			
			return '3'.$baru;
		}
		
		public function getUnique($table, $field, $value) {
			return $this->db->get_where($table, [$field => $value])
							->row_array();
		}
		
		public function tambahKlien( $data ) {
			$id_klien = $this->getMax($data['level']);
			
			$data1 = [
				'id_klien'			=> $id_klien,
				'nama_klien'		=> $data['nama'],
				'email_klien'		=> $data['email'],
				
				'nama_usaha'		=> $data['nama_usaha'],
				'kode_klu'			=> $data['kode_klu'],
				'no_akte'			=> $data['no_akte'],
				'alamat'			=> $data['alamat'],
				'telp'				=> $data['telp'],
				'no_hp'				=> $data['no_hp'],
				'status_pekerjaan'	=> $data['status_pekerjaan'],
				
				'nama_pimpinan'		=> $data['nama_pimpinan'],
				'jabatan'			=> $data['jabatan'],
				'no_hp_pimpinan'	=> $data['no_hp_pimpinan'],
				'email_pimpinan'	=> $data['email_pimpinan'],
				
				'nama_counterpart'	=> $data['nama_counterpart'],
				'no_hp_counterpart'	=> $data['no_hp_counterpart'],
				'email_counterpart'	=> $data['email_counterpart'],
			];
			$this->db->insert('klien', $data1);
			
			$data2 = [
				'id_user'		=> $id_klien,
				'username'		=> $data['username'],
				'password'		=> password_hash($data['password'], PASSWORD_DEFAULT),
				'passlength'	=> strlen($data['password']),
				'level'			=> $data['level'],
				'nama'			=> $data['nama'],
				'email_user'	=> $data['email'],
			];
			$this->db->insert('user', $data2);
			return $this->db->affected_rows();
		}
		
		public function ubahAkun( $data ) {
			$tipe = $data['type'];
			
			if($tipe == 'nama') {
				$row	= [ 'nama'			=> $data['value'] ];
				$row2	= [ 'nama_klien'	=> $data['value'] ];
			} elseif($tipe == 'email') {
				$row	= [ 'email_user'	=> $data['value'] ];
				$row2	= [ 'email_klien'	=> $data['value'] ];
			} elseif($tipe == 'username') {
				$row	= [ 'username'		=> $data['value'] ];
			} elseif($tipe == 'password') {
				$row	= [
					'password'		=> password_hash($data['value'], PASSWORD_DEFAULT),
					'passlength'	=> strlen($data['value']),
				];
			}
			
			if($tipe=='nama' || $tipe=='email') {
				$this->db->where('id_klien', $data['id_klien']);
				$this->db->update('klien', $row2);
			}
			$this->db->where('id_user', $data['id_klien']);
			$this->db->update('user', $row);
			return $this->db->affected_rows();
		}
		
		public function ubahProfil( $data ) {
			if($data['type'] == 'usaha') {
				$row = [
					'nama_usaha'		=> $data['nama_usaha'],
					'kode_klu'			=> $data['kode_klu'],
					'alamat'			=> $data['alamat'],
					'telp'				=> $data['telp'],
					'no_hp'				=> $data['no_hp'],
					'email_klien'		=> $data['email'],
					'no_akte'			=> $data['no_akte'],
					'status_pekerjaan'	=> $data['status_pekerjaan'],
				];
			} elseif($data['type'] == 'pimpinan') {
				$row = [
					'nama_pimpinan'		=> $data['nama_pimpinan'],
					'jabatan'			=> $data['jabatan'],
					'no_hp_pimpinan'	=> $data['no_hp_pimpinan'],
					'email_pimpinan'	=> $data['email_pimpinan'],
				];
			} elseif($data['type'] == 'counterpart') {
				$row = [
					'nama_counterpart'	=> $data['nama_counterpart'],
					'no_hp_counterpart'	=> $data['no_hp_counterpart'],
					'email_counterpart'	=> $data['email_counterpart'],
				];
			}
			
			$this->db->where('id_klien', $data['id_klien'])
					 ->update('klien', $row);
			return $this->db->affected_rows();
		}
		
		public function hapusKlien($id_klien) {
			$this->db->where('id_klien', $id_klien)->delete('klien');
			$this->db->where('id_user', $id_klien)->delete('user');
			return $this->db->affected_rows();
		}
	}
?>