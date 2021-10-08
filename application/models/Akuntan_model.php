<?php

	class Akuntan_model extends CI_model {

		public function getAllAkuntan($start=0, $limit='', $kata_cari='') {
			if($kata_cari) {
				$this->db->group_start()
							->like('nama', $kata_cari)
							->or_like('username', $kata_cari)
							->or_like('email_user', $kata_cari)
						->group_end();
			}
			if($limit) $this->db->limit($limit, $start);
			return $this->db->where('level', 'akuntan')
							->order_by('id_user', 'ASC')
							->get('user')->result_array();
		}
		
		public function countAkuntan($kata_cari='') {
			if($kata_cari) {
				$this->db->group_start()
							->like('nama', $kata_cari)
							->or_like('username', $kata_cari)
							->or_like('email_user', $kata_cari)
						->group_end();
			}
			return $this->db->from('user')->where('level', 'akuntan')
							->count_all_results();
		}
	
		public function getBy($type, $key) {
			if( $type == 'byId') {
				if( is_array($key) )
				return $this->db->where_in('id_user', $key)->get('user')->result_array();
				else
				return $this->db->where('id_user', $key)->get('user')->row_array();
			}
			elseif( $type == 'byEmail' ) {
				return $this->db->where('email_user', $key)->get('user')->row_array();
			}
			elseif( $type == 'byUsername' ) {
				return $this->db->where('username', $key)->get('user')->row_array();
			}
		}
		
		public function getMax($level) {
			$max = $this->db->select_max('id_user')
							->where('level', $level)
							->get('user')->row_array();
			
			$tambah	= (int) substr($max['id_user'], 1, 3);
			$baru	= sprintf('%03s', ++$tambah); 
			$kode	= '2'.$baru;
			return $kode;
		}
	
		public function tambahAkuntan($data) {
			$id_user = $this->getMax( $data['level'] );
			$data = [
				'id_user'		=> $id_user,
				'username'		=> $data['username'],
				'password'		=> password_hash($data['password'], PASSWORD_DEFAULT),
				'passlength'	=> strlen($data['password']),
				'level'			=> $data['level'],
				'nama'			=> $data['nama'],
				'email_user'	=> $data['email'],
			];
			$this->db->insert('user', $data);
			return $this->db->affected_rows();
		}
		
		public function ubahAkuntan($data) {
			if( $data['type'] == 'password' ) {
				$row = [
					'password'		=> password_hash($data['value'], PASSWORD_DEFAULT),
					'passlength'	=> strlen($data['value']),
				];
			} else {
				$row = [
					$data['type'] => $data['value'],
				];
			}
			$this->db->update('user', $row, ['id_user' => $data['id']]);
			return $this->db->affected_rows();
		}
		
		public function hapusAkuntan($id_user) {
			$this->db->where('id_user', $id_user);
			$this->db->delete('user');
			return $this->db->affected_rows();
		}
	}
?>