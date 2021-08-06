<?php

	class M_Proses_perpajakan extends CI_model {

		public function getByMasa($status, $bulan, $tahun, $klien='', $start, $limit) {
			if($klien) {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			if($status == 'belum') {
				$this->db->where(['tanggal_mulai'=>null]);
			} elseif($status == 'onproses') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai'=>null]);
			} elseif($status == 'selesai') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai !='=>null]);
			}
			
			return $this->db->from('data_perpajakan')
							->join('proses_perpajakan', 'proses_perpajakan.id_proses = data_perpajakan.id_kerja', 'left')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = data_perpajakan.id_request', 'left')
							->join('pengiriman_perpajakan', 'pengiriman_perpajakan.id_pengiriman = data_perpajakan.id_kirim', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_perpajakan.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_perpajakan.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->join('user', 'user.id_user = proses_perpajakan.id_akuntan', 'left')
							->where(['status'=>3, 'bulan'=>$bulan, 'tahun'=>$tahun])
							->order_by('id_proses', 'ASC')
							->get()->result_array();
		}

		public function countProses($status='', $bulan, $tahun, $klien='') {
			if($klien) {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			if($status == 'belum') {
				$this->db->where(['tanggal_mulai'=>null]);
			} elseif($status == 'onproses') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai'=>null]);
			} elseif($status == 'selesai') {
				$this->db->where(['tanggal_mulai !='=>null, 'tanggal_selesai !='=>null]);
			}
			
			return $this->db->from('data_perpajakan')
							->join('proses_perpajakan', 'proses_perpajakan.id_proses = data_perpajakan.id_kerja', 'left')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = data_perpajakan.id_request', 'left')
							->join('pengiriman_perpajakan', 'pengiriman_perpajakan.id_pengiriman = data_perpajakan.id_kirim', 'left')
							->join('jenis_data', 'jenis_data.kode_jenis = data_perpajakan.id_jenis', 'left')
							->join('klien', 'klien.id_klien = permintaan_perpajakan.id_klien', 'left')
							->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
							->join('user', 'user.id_user = proses_perpajakan.id_akuntan', 'left')
							->where(['status'=>3, 'tahun'=>$tahun])
							->where_in('bulan', $bulan)
							->count_all_results();
		}

		public function getById($id_proses, $id_klien='', $tahun='', $bulan='') {
			$this->db->select('*, user.nama AS nama_akuntan')->from('data_perpajakan')
					->join('proses_perpajakan', 'proses_perpajakan.id_proses = data_perpajakan.id_kerja', 'left')
					->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = data_perpajakan.id_request', 'left')
					->join('pengiriman_perpajakan', 'pengiriman_perpajakan.id_pengiriman = data_perpajakan.id_kirim', 'left')
					->join('jenis_data', 'jenis_data.kode_jenis = data_perpajakan.id_jenis', 'left')
					->join('klien', 'klien.id_klien = permintaan_perpajakan.id_klien', 'left')
					->join('tugas', 'tugas.id_jenis = jenis_data.kode_jenis', 'left')
					->join('user', 'user.id_user = proses_perpajakan.id_akuntan', 'left');
			if($id_proses) {
				return $this->db->where(['id_proses' => $id_proses])->get()->row_array();
			} else {
				return $this->db->where(['klien.id_klien' => $id_klien, 'tahun' => $tahun, 'bulan' => $bulan])
								->get()->result_array();
			}
		}
		
		public function tambahProses() {
			$mulai		= $this->input->post('tanggal_mulai', true).' '.$this->input->post('jam_mulai', true);
			$selesai	= $this->input->post('tanggal_selesai', true).' '.$this->input->post('jam_selesai', true);
			
			$data = [
				'tanggal_proses'	=> date('d-m-Y H:i'),
				'tanggal_mulai'		=> $mulai,
				'tanggal_selesai'	=> ($selesai == ' ') ? null : $selesai,
				'ket_proses'		=> $this->input->post('keterangan3', true),
				'id_akuntan'		=> $this->session->userdata('id_user'),
			];
			$this->db->where('id_proses', $this->input->post('id_proses', true))
					->update('proses_perpajakan', $data);
		}
		
		public function ubahProses() {
			$data = [
				'tanggal_selesai'	=> $this->input->post('tanggal_selesai', true).' '.$this->input->post('jam_selesai', true),
				'ket_proses'		=> $this->input->post('keterangan3', true),
			];
			$this->db->where('id_proses', $this->input->post('id_proses', true))
					->update('proses_perpajakan', $data);
		}

		public function batalProses($data) {
			if($data['jenis_proses'] == 'onproses') {
				$max = $this->db->select_max('idt_proses')
								->where('id_proses', $data['id_proses'])
								->get('trash_proses_perpajakan')->row_array();
				if($max) {
					$idt		= substr($max['idt_proses'], -2);
					$idt_proses	= $data['id_proses'] . ++$idt;
				} else {
					$idt_proses	= $data['id_proses'] . '00';
				}
				
				$trow = [
					'idt_proses'		=> $idt_proses,
					'tanggal_cancel'	=> date('d-m-Y H:i'),
					'id_proses'			=> $data['id_proses'],
					'tanggal_proses'	=> $data['tanggal_proses'],
					'tanggal_mulai'		=> $data['tanggal_mulai'],
					'tanggal_selesai'	=> $data['tanggal_selesai'],
					'ket_proses'		=> $data['ket_proses'],
					'id_data'			=> $data['id_data'],
					'id_disposer3'		=> $data['id_disposer3'],
				];
				$this->db->insert('trash_proses_perpajakan', $trow);
				$this->db->delete('proses_perpajakan', ['id_proses' => $data['id_proses']]);
			} else {
				$selesai		= $data['temp_selesai'].'|'.$data['tanggal_selesai'];
				$mulai			= $data['temp_mulai'].'|'.date('d/m/Y H:i');
				$temp_selesai	= $data['temp_selesai'] ? $selesai : $data['tanggal_selesai'];
				$temp_mulai		= $data['temp_mulai'] ? $mulai : date('d/m/Y H:i');
				$row = [
					'temp_selesai'		=> $temp_selesai,
					'temp_mulai'		=> $temp_mulai,
					'tanggal_selesai'	=> null,
				];
				$this->db->update('proses_perpajakan', $row, ['id_proses' => $data['id_proses']]);
			}
		}
	}
?>