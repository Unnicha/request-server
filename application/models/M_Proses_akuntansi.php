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

		public function getBelum($bulan, $tahun) {
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left')
							->join('proses_akuntansi', 'proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman AND tugas.id_tugas = proses_akuntansi.id_tugas', 'left')
							->join('user', 'proses_akuntansi.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun, 'id_proses'=>null])
							->order_by('pengiriman_akuntansi.id_pengiriman', 'ASC')
							->get()->result_array();
		}

		public function getSedang($bulan, $tahun) {
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left')
							->join('proses_akuntansi', 'proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman AND tugas.id_tugas = proses_akuntansi.id_tugas', 'left')
							->join('user', 'proses_akuntansi.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun])
							->where(['id_proses !='=>null, 'tanggal_selesai'=>null])
							->order_by('pengiriman_akuntansi.id_pengiriman', 'ASC')
							->get()->result_array();
		}

		public function getSelesai($bulan, $tahun) {
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left')
							->join('proses_akuntansi', 'proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman AND tugas.id_tugas = proses_akuntansi.id_tugas', 'left')
							->join('user', 'proses_akuntansi.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun])
							->where(['id_proses !='=>null, 'tanggal_selesai !='=>null])
							->order_by('pengiriman_akuntansi.id_pengiriman', 'ASC')
							->get()->result_array();
		}

		public function getByKlienBelum($bulan, $tahun, $klien) {
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left')
							->join('proses_akuntansi', 'proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman AND tugas.id_tugas = proses_akuntansi.id_tugas', 'left')
							->join('user', 'proses_akuntansi.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun, 'permintaan_akuntansi.id_klien' => $klien])
							->where(['id_proses'=>null])
							->order_by('pengiriman_akuntansi.id_pengiriman', 'ASC')
							->get()->result_array();
		}

		public function getByKlienSedang($bulan, $tahun, $klien) {
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left')
							->join('proses_akuntansi', 'proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman AND tugas.id_tugas = proses_akuntansi.id_tugas', 'left')
							->join('user', 'proses_akuntansi.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun, 'permintaan_akuntansi.id_klien' => $klien])
							->where(['id_proses !='=>null, 'tanggal_selesai'=>null])
							->order_by('pengiriman_akuntansi.id_pengiriman', 'ASC')
							->get()->result_array();
		}

		public function getByKlienSelesai($bulan, $tahun, $klien) {
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left')
							->join('proses_akuntansi', 'proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman AND tugas.id_tugas = proses_akuntansi.id_tugas', 'left')
							->join('user', 'proses_akuntansi.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun, 'permintaan_akuntansi.id_klien' => $klien])
							->where(['id_proses !='=>null, 'tanggal_selesai !='=>null])
							->order_by('pengiriman_akuntansi.id_pengiriman', 'ASC')
							->get()->result_array();
		} 

		public function getById($id_proses) {
			return $this->db->from('proses_akuntansi')
							->join('tugas', 'tugas.id_tugas = proses_akuntansi.id_tugas', 'left')
							->join('pengiriman_akuntansi', 'proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman', 'left')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('user', 'proses_akuntansi.id_akuntan = user.id_user', 'left')
							->where(['id_proses'=>$id_proses])
							->get()->row_array();
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
			];
			$this->db->where('id_proses', $this->input->post('id_proses', true));
			$this->db->update('proses_akuntansi', $data);
		}
		
		public function hapusProses($id_proses) {
			$this->db->where('id_proses', $id_proses);
			$this->db->delete('proses_akuntansi');
		}
	}
?>