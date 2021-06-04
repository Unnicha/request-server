<?php

	class M_Proses_perpajakan extends CI_model {

		public function getPerMasaTahun($bulan, $tahun) { // not used
			return $this->db->from('proses_perpajakan')
							->join('tugas', 'tugas.id_tugas = proses_perpajakan.id_tugas', 'left')
							->join('pengiriman_perpajakan', 'proses_perpajakan.id_kirim = pengiriman_perpajakan.id_pengiriman', 'left')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_permintaan', 'left')
							->join('jenis_data', 'permintaan_perpajakan.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'proses_perpajakan.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun])
							->order_by('id_proses', 'ASC')
							->get()->result_array();
		}

		public function getProses($start, $limit, $status, $bulan, $tahun, $klien='') {
			if($klien) {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			if($status == 'belum') {
				$this->db->where(['id_proses'=>null]);
			} elseif($status == 'selesai') {
				$this->db->where(['id_proses !='=>null, 'tanggal_selesai !='=>null]);
			} else {
				$this->db->where(['id_proses !='=>null, 'tanggal_selesai'=>null]);
			}
			
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'id_permintaan', 'left')
							->join('jenis_data', 'kode_jenis', 'left')
							->join('klien', 'id_klien', 'left')
							->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left')
							->join('proses_perpajakan', 'proses_perpajakan.id_kirim = pengiriman_perpajakan.id_pengiriman AND tugas.id_tugas = proses_perpajakan.id_tugas', 'left')
							->join('user', 'proses_perpajakan.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun])
							->order_by('pengiriman_perpajakan.id_pengiriman', 'ASC')
							->limit($limit, $start)
							->get()->result_array();
		}

		public function countProses($status, $bulan, $tahun, $klien='') {
			if($klien) {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			if($status == 'belum') {
				$this->db->where(['id_proses'=>null]);
			} elseif($status == 'selesai') {
				$this->db->where(['id_proses !='=>null, 'tanggal_selesai !='=>null]);
			} else {
				$this->db->where(['id_proses !='=>null, 'tanggal_selesai'=>null]);
			}
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_permintaan', 'left')
							->join('jenis_data', 'permintaan_perpajakan.kode_jenis = jenis_data.kode_jenis', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left')
							->join('proses_perpajakan', 'proses_perpajakan.id_kirim = pengiriman_perpajakan.id_pengiriman AND tugas.id_tugas = proses_perpajakan.id_tugas', 'left')
							->join('user', 'proses_perpajakan.id_akuntan = user.id_user', 'left')
							->where(['masa'=>$bulan, 'tahun'=>$tahun])
							->count_all_results();
		}

		public function getById($id, $pengiriman=false) {
			$this->db->from('pengiriman_perpajakan')
					->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_permintaan', 'left')
					->join('jenis_data', 'permintaan_perpajakan.kode_jenis = jenis_data.kode_jenis', 'left')
					->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
					->join('tugas', 'jenis_data.kode_jenis = tugas.kode_jenis AND klien.status_pekerjaan = tugas.status_pekerjaan', 'left');
			if($pengiriman == true) {
				$this->db->where(['id_pengiriman'=>$id]);
			} else {
				$this->db->join('proses_perpajakan', 'proses_perpajakan.id_kirim = pengiriman_perpajakan.id_pengiriman AND tugas.id_tugas = proses_perpajakan.id_tugas', 'left')
						->where(['id_proses'=>$id]);
			}
			return $this->db->get()->row_array();
		}
		
		public function tambahProses() {
			$id_pengiriman	= $this->input->post('id_pengiriman', true);
			$id_akuntan		= $this->input->post('id_akuntan', true);
			$id_tugas		= $this->input->post('id_tugas', true);
			$mulai			= $this->input->post('tanggal_mulai', true).' '.$this->input->post('jam_mulai', true);
			$selesai		= $this->input->post('tanggal_selesai', true).' '.$this->input->post('jam_selesai', true);
			
			$id_tugas	= substr($id_tugas, 3);
			$id_proses	= $id_pengiriman . $id_tugas . $id_akuntan;
			
			$flag = 0;
			if( $this->input->post('tanggal_selesai', true) ) {
				if($this->input->post('jam_selesai', true) == null) {
					$this->session->set_flashdata('jam_selesai', '<b>Jam Selesai</b> harus diisi');
					redirect('akuntan/proses_data_perpajakan/mulai/'.$id_pengiriman);
				} else {
					$flag = 1;
				}
			} else {
				$selesai = null;
				if($this->input->post('jam_selesai', true) != null) {
					$this->session->set_flashdata('tanggal_selesai', '<b>Tanggal Selesai</b> harus diisi');
					redirect('akuntan/proses_data_perpajakan/mulai/'.$id_pengiriman);
				} else {
					$flag = 1;
				}
			}

			if($flag == 1) {
				$data = [
					'id_proses'			=> $id_proses,
					'tanggal_proses'	=> date('d-m-Y H:i'),
					'tanggal_mulai'		=> $mulai,
					'tanggal_selesai'	=> $selesai,
					'keterangan3'		=> $this->input->post('keterangan3', true),
					'id_tugas'			=> $this->input->post('id_tugas', true),
					'id_kirim'			=> $this->input->post('id_pengiriman', true),
					'id_akuntan'		=> $this->input->post('id_akuntan', true),
				];
				$this->db->insert('proses_perpajakan', $data);
			}
		}
		
		public function ubahProses() {
			$data = [
				//'tanggal_proses'	=> date('d-m-Y H:i'),
				'tanggal_mulai'		=> $this->input->post('tanggal_mulai', true).' '.$this->input->post('jam_mulai', true),
				'tanggal_selesai'	=> $this->input->post('tanggal_selesai', true).' '.$this->input->post('jam_selesai', true),
				'keterangan3'		=> $this->input->post('keterangan3', true),
			];
			$this->db->where('id_proses', $this->input->post('id_proses', true));
			$this->db->update('proses_perpajakan', $data);
		}
		
		public function batalMulaiProses($data) {
			$max = $this->db->select_max('idt_proses')
							->where('id_proses', $data['id_proses'])
							->get('trash_proses_perpajakan')->row_array();
			if($max) {
				$idt		= substr($max['idt_proses'], -2);
				$idt_proses	= $data['id_proses'] . ++$idt;
			} else {
				$idt_proses	= $data['id_proses'] . '00';
			}

			$row = [
				'idt_proses'		=> $idt_proses,
				'tanggal_cancel'	=> date('d-m-Y H:i'),
				'id_proses'			=> $data['id_proses'],
				'tanggal_proses'	=> $data['tanggal_proses'],
				'tanggal_mulai'		=> $data['tanggal_mulai'],
				'tanggal_selesai'	=> $data['tanggal_selesai'],
				'keterangan3'		=> $data['keterangan3'],
				'id_tugas'			=> $data['id_tugas'],
				'id_kirim'			=> $data['id_kirim'],
				'id_akuntan'		=> $data['id_akuntan'],
				'id_disposer3'		=> $data['id_disposer3'],
			];
			$this->db->insert('trash_proses_perpajakan', $row);
			
			$this->db->delete('proses_perpajakan', ['id_proses' => $data['id_proses']]);
			$this->session->set_flashdata('notification', 'Proses berhasil dibatalkan!'); 
		}

		public function batalSelesaiProses($data) {
			$max = $this->db->select_max('idt_proses')
							->where('id_proses', $data['id_proses'])
							->get('trash_proses_perpajakan')->row_array();
			if($max) {
				$idt		= substr($max['idt_proses'], -2);
				$idt_proses	= $data['id_proses'] . ++$idt;
			} else {
				$idt_proses	= $data['id_proses'] . '00';
			}

			$row = [
				'idt_proses'		=> $idt_proses,
				'tanggal_cancel'	=> date('d-m-Y H:i'),
				'id_proses'			=> $data['id_proses'],
				'tanggal_proses'	=> $data['tanggal_proses'],
				'tanggal_mulai'		=> $data['tanggal_mulai'],
				'tanggal_selesai'	=> $data['tanggal_selesai'],
				'keterangan3'		=> $data['keterangan3'],
				'id_tugas'			=> $data['id_tugas'],
				'id_kirim'			=> $data['id_kirim'],
				'id_akuntan'		=> $data['id_akuntan'],
				'id_disposer3'		=> $data['id_disposer3'],
			];
			$this->db->insert('trash_proses_perpajakan', $row);

			$this->db->where(['id_proses' => $data['id_proses']])
					->update('proses_perpajakan', ['tanggal_selesai' => null]);
			$this->session->set_flashdata('notification', 'Proses berhasil dibatalkan!'); 
		}
	}
?>