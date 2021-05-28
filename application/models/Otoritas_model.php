<?php

	class Otoritas_model extends CI_model {

		public function getAllOtoritas($start='', $limit='', $kata_cari='') {
			if($kata_cari) {
				$this->db->group_start()
							->like('nama', $kata_cari)
							->or_like('username', $kata_cari)
							->or_like('email_user', $kata_cari)
						->group_end();
			}
			return $this->db->where('level', 'admin')
							->order_by('id_user', 'ASC')
							->get('user', $limit, $start)->result_array();
		}
		
		public function countOtoritas($kata_cari='') {
			if($kata_cari) {
				$this->db->group_start()
							->like('nama', $kata_cari)
							->or_like('username', $kata_cari)
							->or_like('email_user', $kata_cari)
						->group_end();
			}
			return $this->db->from('user')->where('level', 'admin')->count_all_results();
		}

		public function getPagination($get) {
			return $this->db->get_where('user', ['level'=>$get['level']], $get['limit'], $get['offset'])
							->result_array();
		}

		public function getById($id_user) {
			return $this->db->where('id_user', $id_user)->get('user')->row_array();
		}

		public function getByUsername($username) {
			return $this->db->where('username', $username)->get('user')->row_array();
		}

		public function getByEmail($email) {
			return $this->db->get_where('user', ['email_user'=>$email])->row_array();
		}

		public function insertToken($id_user) {
			$token = substr(sha1(rand()), 0, 30);
			$date = date('d-m-Y');

			$data = array(
				'token'		=> $token,
				'id_user'	=> $id_user,
				'date'		=> $date
			);
			$this->db->insert('token', $data);
			
			return $token.$id_user;
		}

		public function validToken($token) {
			$tkn = substr($token, 0, 30);
			$uid = substr($token, 30);

			$cekToken = $this->db->get_where('token', array(
				'token' => $tkn,
				'id_user' => $uid
			), 1)->row_array();

			if($cekToken == null) {
				return false;
			} else {
				//print_r($cekToken);
				$tokenDate  = strtotime($cekToken['date']);
				$todayDate  = strtotime(date('Y-m-d'));

				if ($tokenDate != $todayDate) {
					return false;
				} else {
					$user = $this->getById($cekToken['id_user']);
					return $user;
				}
			}
		}

		public function getMax($level) {

			$max = $this->db->select_max('id_user', 'maxId')
							->where('level', $level) 
							->get('user')->row_array();
			
			//ambil kode angka => substr(dari $kodeMax, index 1, sebanyak 2 char) 
			//jadikan integer => (int) 
			$tambah = (int) substr($max['maxId'], 1, 3);
			$tambah++;  //kode lama +1
			$baru = sprintf("%03s", $tambah); //kode baru, jadikan 2 char
			$kode_baru = "1".$baru; //tambahkan dengan kode baru

			return $kode_baru;
		}

		public function tambahOtoritas() {
			$level		= $this->input->post('level');
			$id_user	= $this->getMax($level);
			
			$user = [
				"id_user"	=> $id_user,
				"level"		=> $this->input->post('level'),
				"username"	=> $this->input->post('username'),
				"password"	=> password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				"nama"		=> $this->input->post('nama'),
				"email_user"=> $this->input->post('email'),
			];
			$this->db->insert('user', $user);
			return $this->db->affected_rows();
		}

		public function ubahOtoritas() {
			
			$this->db->where('username', $this->input->post('username'));
			$this->db->where('id_user !=', $this->input->post('id_user'));
			$cek_user = $this->db->get('user')->row_array();

			if($cek_user == null) {
				$user = [
					"id_user"	=> $this->input->post('id_user'),
					"level"		=> $this->input->post('level'),
					"username"	=> $this->input->post('username'),
					"password"	=> password_hash($this->input->post('password'), PASSWORD_DEFAULT),
					"nama"		=> $this->input->post('nama'),
					"email_user"=> $this->input->post('email'),
				];
				$this->db->where('id_user', $this->input->post('id_user'));
				$this->db->update('user', $user);

				$sess_id = $this->session->userdata('id_user');
				if($id_user == $sess_id) {
					array_splice($user, 3, 1);
					$this->session->set_userdata($data);
				}
				return $this->db->affected_rows();
			}
			else {
				$this->session->set_flashdata('flash', 'sudah digunakan'); 
				redirect('admin/master/otoritas/ubah/'.$id_user);
			}
		}

		public function ubahPassword($password, $id_user) {
			$this->db->set('password', password_hash($password, PASSWORD_DEFAULT))
					->where('id_user', $id_user)
					->update('user');
		}
		
		public function hapusOtoritas($id_user) {
			$this->db->where('id_user', $id_user);
			$this->db->delete('user');
			return $this->db->affected_rows();
		}
	}
?>