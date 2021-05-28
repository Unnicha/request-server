<?php

	class M_Proses_akuntansi extends CI_model {

		public function getPerMasaTahun($bulan, $tahun) { // not used
			return $this->db->from('proses_akuntansi')
							->join('tugas', 'tugas.id_tugas = proses_akuntansi.id_tugas', 'left')
							->join('pengiriman_akuntansi', 'proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman', 'left')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('user', 'proses_akuntansi.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun])
							->order_by('id_proses', 'ASC')
							->get()->result_array();
		}

		public function getProses($start, $limit, $status, $bulan, $tahun, $klien='') {
			if($klien) {
				$this->db->where_in('permintaan_akuntansi.id_klien', $klien);
			}
			if($status == 'belum') {
				$this->db->where(['id_proses'=>null]);
			} elseif($status == 'selesai') {
				$this->db->where(['id_proses !='=>null, 'tanggal_selesai !='=>null]);
			} else {
				$this->db->where(['id_proses !='=>null, 'tanggal_selesai'=>null]);
			}
			
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'id_permintaan', 'left')
							->join('jenis_data', 'kode_jenis', 'left')
							->join('klien', 'id_klien', 'left')
							->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left')
							->join('proses_akuntansi', 'proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman AND tugas.id_tugas = proses_akuntansi.id_tugas', 'left')
							->join('user', 'proses_akuntansi.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun])
							->order_by('pengiriman_akuntansi.id_pengiriman', 'ASC')
							->limit($limit, $start)
							->get()->result_array();
		}

		public function countProses($status, $bulan, $tahun, $klien='') {
			if($klien) {
				$this->db->where_in('permintaan_akuntansi.id_klien', $klien);
			}
			if($status == 'belum') {
				$this->db->where(['id_proses'=>null]);
			} elseif($status == 'selesai') {
				$this->db->where(['id_proses !='=>null, 'tanggal_selesai !='=>null]);
			} else {
				$this->db->where(['id_proses !='=>null, 'tanggal_selesai'=>null]);
			}
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left')
							->join('proses_akuntansi', 'proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman AND tugas.id_tugas = proses_akuntansi.id_tugas', 'left')
							->join('user', 'proses_akuntansi.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun])
							->count_all_results();
		}

		public function getById($id, $pengiriman=false) {
			$this->db->from('pengiriman_akuntansi')
					->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
					->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
					->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
					->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left');
			if($pengiriman == true) {
				$this->db->where(['id_pengiriman'=>$id]);
			} else {
				$this->db->join('proses_akuntansi', 'proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman AND tugas.id_tugas = proses_akuntansi.id_tugas', 'left')
						->where(['id_proses'=>$id]);
			}
			return $this->db->get()->row_array();
		}
		
		public function tambahProses() {

			$id_pengiriman		= $this->input->post('id_pengiriman', true);
			$id_akuntan			= $this->input->post('id_akuntan', true);
			$id_tugas			= $this->input->post('id_tugas', true);
			$tanggal_selesai	= $this->input->post('tanggal_selesai', true);
			$jam_selesai		= $this->input->post('jam_selesai', true);

			$id_tugas	= substr($id_tugas, 3);
			$id_proses	= $id_pengiriman . $id_tugas . $id_akuntan;
			$redirect	= 'akuntan/proses_akuntansi/mulai/'.$id_pengiriman;

			$flag = 0;
			if($tanggal_selesai != null) {
				if($jam_selesai == null) {
					$jam_selesai = null;
					$this->session->set_flashdata('flash', '<b>Jam Selesai</b> harus diisi');
					redirect($redirect);
				} else {
					$flag = 1;
				}
			} else {
				$tanggal_selesai = null;
				if($jam_selesai != null) {
					$this->session->set_flashdata('flash', '<b>Tanggal Selesai</b> harus diisi');
					redirect($redirect);
				} else {
					$jam_selesai = null;
					$flag = 1;
				}
			}

			if($flag == 1) {
				$data = [
					'id_proses'			=> $id_proses,
					'tanggal_mulai'		=> $this->input->post('tanggal_mulai', true),
					'jam_mulai'			=> $this->input->post('jam_mulai', true),
					'tanggal_selesai'	=> $tanggal_selesai,
					'jam_selesai'		=> $jam_selesai,
					'keterangan3'		=> $this->input->post('keterangan3', true),
					'id_tugas'			=> $this->input->post('id_tugas', true),
					'id_kirim'			=> $this->input->post('id_pengiriman', true),
					'id_akuntan'		=> $this->input->post('id_akuntan', true),
				];
				$this->db->insert('proses_akuntansi', $data);
			}
		}
		
		public function ubahProses() {
			$data = [
				'tanggal_mulai'		=> $this->input->post('tanggal_mulai', true),
				'jam_mulai'			=> $this->input->post('jam_mulai', true),
				'tanggal_selesai'	=> $this->input->post('tanggal_selesai', true),
				'jam_selesai'		=> $this->input->post('jam_selesai', true),
				'keterangan3'		=> $this->input->post('keterangan3', true),
			];
			$this->db->where('id_proses', $this->input->post('id_proses', true));
			$this->db->update('proses_akuntansi', $data);
		}
		
		public function batalProses($data) {
			$this->session->set_flashdata('notification', 'Proses berhasil dibatalkan!'); 
		}
	}
?>