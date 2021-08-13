<?php
	
	class M_Pengiriman_perpajakan extends CI_model {
		
		public function getByMasa($bulan, $tahun, $klien='', $start='', $limit='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			if($limit) {
				$this->db->limit($limit, $start);
			}
			return $this->db->from('permintaan_perpajakan')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->where('jum_data = jum_ok')
							->order_by('id_permintaan', 'ASC')
							->get()->result_array();
		}
		
		public function countPengiriman($bulan, $tahun, $klien='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			return $this->db->from('permintaan_perpajakan')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('user', 'permintaan_perpajakan.id_pengirim = user.id_user', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->where('jum_data = jum_ok')
							->count_all_results();
		}
		
		public function getById($id_pengiriman) {
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_request', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->where('id_pengiriman', $id_pengiriman)
							->get()->row_array();
		}
		
		public function getByIdData($id_data) {
			return $this->db->from('data_perpajakan')
							->join('jenis_data', 'jenis_data.kode_jenis = data_perpajakan.id_jenis', 'left')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = data_perpajakan.id_request', 'left')
							->where(['id_data' => $id_data])
							->get()->row_array();
		}
		
		public function getDetail($id_data) {
			return $this->db->from('pengiriman_perpajakan')
							->join('data_perpajakan', 'pengiriman_perpajakan.kode_data = data_perpajakan.id_data', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->where(['id_data' => $id_data])
							->get()->result_array();
		}
		
		public function getNew($id_data) { 
			$max = $this->db->select_max('id_pengiriman')
							->where(['kode_data' => $id_data])
							->get('pengiriman_perpajakan')->row_array();
			if($max['id_pengiriman']) {
				$revisi	= substr($max['id_pengiriman'], -2);
				$id		= $id_data . sprintf('%02s', ++$revisi); 
			} else {
				$id		= $id_data . '01'; 
			}
			return $id;
		}
		
		public function getMaxProses($id_data) {
			$pre = substr($id_data, 0, 9);
			$max = $this->db->select_max('id_proses')
							->like('id_proses', $pre)
							->get('proses_perpajakan')->row_array();
			if($max['id_proses'] == null) {
				$id_proses	= $pre.'001';
			} else {
				$tambah		= substr($max['id_proses'], -3);
				$id_proses	= $pre.sprintf('%03s', ++$tambah);
			}
			return $id_proses;
		}
		
		public function kirim() {
			$id_data		= $this->input->post('id_data', true);
			$format_data	= $this->input->post('format_data', true);
			$keterangan		= $this->input->post('keterangan', true);
			$exts			= ['xls', 'xlsx', 'csv', 'pdf', 'rar', 'zip'];
			
			if($format_data == 'Softcopy') {
				$fileName = $_FILES['files']['name'];
				if($fileName != null) {
					// cek file extension
					$targetFile	= basename($fileName);
					$fileExt	= strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
					if(in_array($fileExt, $exts) == false) {
						$callback = 'ERROR';
					} else {
						$upload = $this->proses_file($this->session->userdata('nama'));
					}
				}
			} elseif($format_data == 'Hardcopy') {
				$upload = $this->input->post('tanggal_ambil', true);
			}
			
			if(isset($callback)) {
				return $callback;
			} else {
				if($upload) {
					$id_pengiriman = $this->getNew($id_data);
					$row[] = [
						'id_pengiriman'			=> $id_pengiriman,
						'pengiriman'			=> substr($id_pengiriman, -2),
						'tanggal_pengiriman'	=> date('d-m-Y H:i'),
						'file'					=> $upload,
						'ket_pengiriman'		=> $keterangan,
						'kode_data'				=> $id_data,
					];
					$this->db->insert_batch('pengiriman_perpajakan', $row);
					
					if(substr($id_pengiriman, -2) == '01') {
						$this->db->update('data_perpajakan', ['status'=>'no'], ['id_data'=>$id_data]);
					}
					return 'OK';
				}
			}
		}
		
		public function konfirmasi($id_data, $status='yes') {
			$detail		= $this->getByIdData($id_data);
			$jum_ok		= ($status == 'yes') ? $detail['jum_ok']+1 : $detail['jum_ok']-1;
			$this->db->update('data_perpajakan', ['status'=>$status], ['id_data'=>$id_data]);
			$this->db->update('permintaan_perpajakan', ['jum_ok'=>$jum_ok], ['id_permintaan'=>$detail['id_permintaan']]);
		}
		
		public function proses_file($nama_klien) {
			$fileData		= $_FILES['files'];
			$fileDir		= 'asset/uploads/'.$nama_klien.'/'.date('Y').'/';
			$targetFile		= $fileDir . basename($fileData['name']);
			$extractFile	= pathinfo($targetFile); 
			
			if (!is_dir($fileDir)) { # periksa apakah folder sudah ada
				mkdir($fileDir, 0777, $rekursif = true); # jika tidak ada, buat folder
			}
			
			//cek apakah nama file sudah ada
			$sameName	= 0; // Menyimpan jumlah file dengan nama yang sama dengan file yg diupload
			$handle		= opendir($fileDir);
			while(false !== ($file = readdir($handle))){ // Looping isi file pada directory tujuan
				// jika nama awalan file sama dengan nama file di uplaod
				if(strpos($file,$extractFile['filename']) !== false)
				$sameName++; // Tambah data file yang sama
			}
			// Apabila tidak ada file yang sama ($sameName masih '0') maka nama file sama dengan
			// nama ketika diupload. Jika $sameName > 0 maka pakai format 'namafile($sameName).ext'
			$newName	= empty($sameName) ? $fileData['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];
			$upload		= move_uploaded_file($fileData['tmp_name'], $fileDir.$newName);
			
			return $newName;
		}
		
		public function hapusPengiriman($kode_data) {
			$this->db->where('kode_data', $kode_data);
			$this->db->delete('pengiriman_perpajakan');
		}
	}
?>