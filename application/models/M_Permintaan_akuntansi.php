<?php
	
	class M_Permintaan_akuntansi extends CI_model {
		
		public function getByMasa($bulan, $tahun, $klien='', $start='', $limit='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_akuntansi.id_klien', $klien);
			}
			if($limit) {
				$this->db->limit($limit, $start);
			}
			$allData = '(SELECT COUNT(id_data) FROM data_akuntansi WHERE id_request = id_permintaan)';
			$dataYes = '(SELECT COUNT(id_data) FROM data_akuntansi WHERE status_kirim = "yes" AND id_request = id_permintaan)';
			return $this->db->select('*, '.$allData.' AS jumData')
							->from('permintaan_akuntansi')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_akuntansi.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->where($dataYes.' < '.$allData)
							->order_by('id_permintaan', 'ASC')
							->get()->result_array();
		}
		
		public function countPermintaan($bulan, $tahun, $klien='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_akuntansi.id_klien', $klien);
			}
			$allData = '(SELECT COUNT(id_data) FROM data_akuntansi WHERE id_request = id_permintaan)';
			$dataYes = '(SELECT COUNT(id_data) FROM data_akuntansi WHERE status_kirim = "yes" AND id_request = id_permintaan)';
			return $this->db->from('permintaan_akuntansi')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_akuntansi.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->where($dataYes.' < '.$allData)
							->order_by('id_permintaan', 'ASC')
							->count_all_results();
		}
		
		public function getById($id_permintaan) {
			$allData = '(SELECT COUNT(id_data) FROM data_akuntansi WHERE id_request = id_permintaan)';
			return $this->db->select('*, '.$allData.' AS jumData')
							->from('permintaan_akuntansi')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_akuntansi.id_pengirim = user.id_user', 'left')
							->where(['id_permintaan' => $id_permintaan])
							->get()->row_array();
		}
		
		public function getDetail($id_permintaan) {
			return $this->db->from('data_akuntansi')
							->join('jenis_data', 'jenis_data.kode_jenis = data_akuntansi.id_jenis', 'left')
							->where(['id_request' => $id_permintaan])
							->get()->result_array();
		}
		
		public function countDetail($id_permintaan) {
			$all	= '(SELECT COUNT(id_data) FROM data_akuntansi WHERE id_request = id_permintaan)';
			$yes	= '(SELECT COUNT(id_data) FROM data_akuntansi WHERE id_request = id_permintaan AND status_kirim = "yes")';
			$no		= '(SELECT COUNT(id_data) FROM data_akuntansi WHERE id_request = id_permintaan AND status_kirim = "no")';
			$yet	= '(SELECT COUNT(id_data) FROM data_akuntansi WHERE id_request = id_permintaan AND status_kirim IS NULL)';
			return $this->db->select('('.$all.') AS jumAll, ('.$yes.') AS jumYes, ('.$no.') AS jumNo, ('.$yet.') AS jumNull')
							->from('permintaan_akuntansi')
							->where(['id_permintaan' => $id_permintaan])
							->get()->row_array();
		}
		
		public function getNew($id_klien, $bulan, $tahun) {
			$pre	= substr($tahun, -2) . $bulan . $id_klien;
			$max	= $this->db->select_max('id_permintaan')
								->where(['id_klien' => $id_klien, 'bulan'=>$bulan, 'tahun'=>$tahun])
								->get('permintaan_akuntansi')->row_array();
			
			if($max['id_permintaan']) {
				$tambah	= substr($max['id_permintaan'], -2);
				$new	= $pre .'1'. sprintf('%02s', ++$tambah); //kategori data
			} else {
				$new	= $pre .'1'.'01'; //kategori data
			}
			return $new;
		}
		
		public function tambahPermintaan() {
			$kode_jenis		= $this->input->post('kode_jenis', true);
			$detail			= $this->input->post('detail', true);
			$format_data	= $this->input->post('format_data', true);
			$id_klien		= $this->input->post('id_klien', true);
			$bulan			= date('m');
			$tahun			= date('Y');
			$id_permintaan	= $this->getNew($id_klien, $bulan, $tahun);
			
			// insert permintaan
			$data = [
				'id_permintaan'		=> $id_permintaan,
				'tanggal_permintaan'=> date('d-m-Y H:i'),
				'id_klien'			=> $id_klien,
				'bulan'				=> $bulan,
				'tahun'				=> $tahun,
				'request'			=> substr($id_permintaan, -2),
				// 'jum_data'			=> count($kode_jenis),
				'id_pengirim'		=> $this->input->post('id_user', true),
			];
			$this->db->insert('permintaan_akuntansi', $data);
			
			// insert data
			for($i=0; $i<count($kode_jenis); $i++) {
				$row[] = [
					'id_data'		=> $id_permintaan . sprintf('%02s', $i+1),
					'id_jenis'		=> $kode_jenis[$i],
					'detail'		=> $detail[$i],
					'format_data'	=> $format_data[$i],
					'id_request'	=> $id_permintaan,
				];
			}
			$this->db->insert_batch('data_akuntansi', $row);
		}
		
		public function ubahPermintaan() {
			$id_permintaan	= $this->input->post('id_permintaan', true);
			$id_data		= $this->input->post('id_data', true);
			$detail			= $this->input->post('detail', true);
			$format_data	= $this->input->post('format_data', true);
			
			foreach($id_data as $id => $val) {
				// jika format_data ada lakukan update, jika tidak hapus data
				if(isset($format_data[$id])) {
					$row[] = [
						'detail'		=> $detail[$id],
						'format_data'	=> $format_data[$id],
					];
					$this->db->update('data_akuntansi', $row, ['id_data' => $val]);
				} else {
					$this->db->delete('data_akuntansi', ['id_data' => $val]);
				}
			}
			
			// update jum_data di permitaan
			$data = [
				'jum_data'	=> count($format_data),
			];
			$this->db->update('permintaan_akuntansi', $data, ['id_permintaan' => $id_permintaan]);
		}
		
		public function hapusPermintaan($id_permintaan) { 
			$this->db->delete('permintaan_akuntansi', ['id_permintaan' => $id_permintaan]);
			$this->db->delete('data_akuntansi', ['id_request' => $id_permintaan]);
		}
	}
?>