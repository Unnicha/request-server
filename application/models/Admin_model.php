<?php
	
	class Admin_model extends CI_model {
		
		public function getAllAdmin($start=0, $limit='', $kata_cari='') {
			if($kata_cari) {
				$this->db->group_start()
							->like('nama', $kata_cari)
							->or_like('username', $kata_cari)
							->or_like('email_user', $kata_cari)
						->group_end();
			}
			if($limit) $this->db->limit($limit, $start);
			return $this->db->where('level', 'admin')
							->order_by('id_user', 'ASC')
							->get('user')->result_array();
		}
		
		public function countAdmin($kata_cari='') {
			if($kata_cari) {
				$this->db->group_start()
							->like('nama', $kata_cari)
							->or_like('username', $kata_cari)
							->or_like('email_user', $kata_cari)
						->group_end();
			}
			return $this->db->from('user')->where('level', 'admin')
							->count_all_results();
		}
		
		public function getBy($type, $key) {
			if( $type == 'byId' ) {
				return $this->db->where('id_user', $key)->get('user')->row_array();
			} elseif( $type == 'byUsername' ) {
				return $this->db->where('username', $key)->get('user')->row_array();
			} elseif( $type == 'byEmail' ) {
				return $this->db->where('email_user', $key)->get('user')->row_array();
			}
		}
		
		// delsoon
		public function getById($id_user) {
			return $this->db->where('id_user', $id_user)->get('user')->row_array();
		}
		// delsoon
		public function getByUsername($username) {
			return $this->db->where('username', $username)->get('user')->row_array();
		}
		// delsoon
		public function getByEmail($email) {
			return $this->db->get_where('user', ['email_user'=>$email])->row_array();
		}
		
		public function getMax($level) {
			$max = $this->db->select_max('id_user')
							->where('level', $level) 
							->get('user')->row_array();
			
			$tambah		= (int) substr($max['id_user'], 1, 3);
			$baru		= sprintf('%03s', ++$tambah);
			$kode_baru	= '1'.$baru;
			
			return $kode_baru;
		}
		
		public function tambahAdmin($data) {
			$id_user = $this->getMax($data['level']);
			
			$user = [
				'id_user'	=> $id_user,
				'level'		=> $data['level'],
				'username'	=> $data['username'],
				'password'	=> password_hash($data['password'], PASSWORD_DEFAULT),
				'passlength'=> strlen($data['password']),
				'nama'		=> $data['nama'],
				'email_user'=> $data['email'],
			];
			$this->db->insert('user', $user);
			return $this->db->affected_rows();
		}
		
		public function ubahAdmin($data) {
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
		
		// delsoon
		public function ubahPassword($password, $id_user) {
			$this->db->set('password', password_hash($password, PASSWORD_DEFAULT))
					->where('id_user', $id_user)
					->update('user');
		}
		
		public function hapusAdmin($id_user) {
			$this->db->where('id_user', $id_user);
			$this->db->delete('user');
			return $this->db->affected_rows();
		}
		
		public function insertToken($id_user) {
			$token	= substr(sha1(rand()), 0, 30);
			$date	= date('d-m-Y');
			$data	= array(
				'token'		=> $token,
				'id_user'	=> $id_user,
				'date'		=> $date
			);
			$this->db->insert('token', $data);
			
			return $token.$id_user;
		}
		
		public function validToken($token) {
			$tkn		= substr($token, 0, 30);
			$uid		= substr($token, 30);
			$cekToken	= $this->db->get_where('token', [
				'token'		=> $tkn,
				'id_user'	=> $uid
			], 1)->row_array();
			
			if($cekToken == null) {
				return false;
			} else {
				$tokenDate	= strtotime($cekToken['date']);
				$todayDate	= strtotime(date('Y-m-d'));
				
				if($tokenDate != $todayDate) {
					return false;
				} else {
					$user = $this->getById($cekToken['id_user']);
					return $user;
				}
			}
		}
	}
?>