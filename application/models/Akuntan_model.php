<?php

	class Akuntan_model extends CI_model {

		public function getAllAkuntan($start='', $limit='', $kata_cari='') {
			if($kata_cari) {
				$this->db->group_start()
							->like('nama', $kata_cari)
							->or_like('username', $kata_cari)
							->or_like('email_user', $kata_cari)
						->group_end();
			}
			return $this->db->where('level', 'akuntan')
							->order_by('id_user', 'ASC')
							->get('user', $limit, $start)->result_array();
		}

		public function countAkuntan($kata_cari='') {
			if($kata_cari) {
				$this->db->group_start()
							->like('nama', $kata_cari)
							->or_like('username', $kata_cari)
							->or_like('email_user', $kata_cari)
						->group_end();
			}
			return $this->db->from('user')->where('level', 'akuntan')->count_all_results();
		}
	
		public function getById($id_user) {
			return $this->db->get_where('user', ['id_user' => $id_user])->row_array();
		}
	
		public function getMax($level) {
			$max = $this->db->select_max('id_user', 'maxId')
							->where('level', $level)
							->get('user')->row_array();
			$kodeMax = $max['maxId']; 
			
			//ambil kode angka => substr(dari $kodeMax, index 1, sebanyak 3 char) 
			//jadikan integer => (int) 
			$tambah = (int) substr($kodeMax, 1, 3);
			$baru = sprintf('%03s', ++$tambah); 
			$kode_baru = '2'.$baru;
	
			return $kode_baru;
		}
	
		public function tambahAkuntan() {
			$id_user = $this->getMax($this->input->post('level', true));
			$data = [
				'id_user'	=> $id_user,
				'username'	=> $this->input->post('username', true),
				'password'	=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
				'level'		=> $this->input->post('level', true),
				'nama'		=> $this->input->post('nama', true),
				'email_user'=> $this->input->post('email', true),
			];
			$this->db->insert('user', $data);
		}
	
		public function ubahAkuntanFull() {
			$this->db->where('username', $this->input->post('username', true));
			$this->db->where('id_user !=', $this->input->post('id_user', true));
			$cek_user = $this->db->get('user')->row_array();
			
			if($cek_user != null) { 
				$this->session->set_flashdata('username', 'Username sudah digunakan'); 
				redirect('akuntan/profile/ganti_username');
			}
			
			$data = [
				'id_user'	=> $this->input->post('id_user', true),
				'username'	=> $this->input->post('username', true),
				'password'	=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
				'level'		=> $this->input->post('level', true),
				'nama'		=> $this->input->post('nama', true),
				'email_user'=> $this->input->post('email', true),
			];
			$this->db->where('id_user', $this->input->post('id_user', true));
			$this->db->update('user', $data);
		}
	
		public function ubahAkuntan() {
			$tipe = $this->input->post('tipe', true);
			if($tipe == 'nama') {
				$data = [ 'nama' => $this->input->post('nama', true) ];
			} elseif($tipe == 'email') {
				$data = [ 'email_user' => $this->input->post('email', true) ];
			} elseif($tipe == 'username') {
				$data = [ 'username' => $this->input->post('username', true) ];
			} else {
				$data = [
					'password'		=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
					'passlength'	=> strlen($this->input->post('password', true)),
				];
			}
			$this->db->where('id_user', $this->input->post('id_user', true));
			$this->db->update('user', $data);
		}
		
		public function hapusAkuntan($id_user) {
			$this->db->where('id_user', $id_user);
			$this->db->delete('user');
		}
	}
?>