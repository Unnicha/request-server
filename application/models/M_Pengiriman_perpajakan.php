<?php

	class M_Pengiriman_perpajakan extends CI_model {

		public function getAllPengiriman() {
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_permintaan', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->order_by('id_pengiriman', 'ASC')
							->get()->result_array();
		}
		
		public function getByMasa($bulan, $tahun, $klien='', $start, $limit) {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_request', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->limit($limit, $start)
							->order_by('id_pengiriman', 'ASC')
							->get()->result_array();
		}
		
		public function countPengiriman($bulan, $tahun, $klien='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_request', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->count_all_results();
		}
		
		public function getById($id_pengiriman) {
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_request', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->where('id_pengiriman', $id_pengiriman)
							->get()->row_array();
		}
		
		public function getMax($id_permintaan) { 
			$max = $this->db->select_max('id_pengiriman')
							->where('id_request', $id_permintaan)
							->get('pengiriman_perpajakan')->row_array();
			
			if($max['id_pengiriman'] == null) {
				$id_pengiriman = $id_permintaan."0";
			} else {
				$revisi = substr($max['id_pengiriman'], -1);
				if($revisi == 9) {
					$id_pengiriman = $id_permintaan;
				} else {
					$id_pengiriman	= $id_permintaan . ++$revisi; 
				}
			}
			return $id_pengiriman;
		}
		
		public function kirim() {
			$id_permintaan	= $this->input->post('id_permintaan', true);
			$id_pengiriman	= $this->getMax($id_permintaan);
			$format_data	= explode('|', $this->input->post('format_data', true));
			$tanggal_ambil	= $this->input->post('tanggal_ambil', true);
			$files			= $this->input->post('files', true);
			$nama_klien		= $this->session->userdata('nama');
			
			if($id_pengiriman == $id_permintaan) {
				$this->session->set_flashdata('flash', 'Revisi sudah mencapai batas maksimal. Silahkan hubungi accounting');
				$callback = 'ERROR';
			} else {
				$j = 0; $k = 0;
				for($i=0; $i<count($format_data); $i++) {
					if($format_data[$i] == "Softcopy") {
						$upload[$i] = $this->proses_file($nama_klien, $j);
						if($upload[$i] == null) {
							$this->session->set_flashdata('flash','Format file yang di izinkan : <b>.xls, .xlsx, .csv, .pdf, .rar, .zip</b>');
							$callback = 'ERROR';
						}
						$j++;
					} elseif($format_data[$i] == "Hardcopy") {
						$upload[$i] = $tanggal_ambil[$k];
						$k++;
					}
				}
				
				if($upload == null) {
					return '';
				} elseif($callback) {
					return $callback;
				} else {
					$data = [
						'id_pengiriman'		=> $id_pengiriman,
						'tanggal_pengiriman'=> date('d-m-Y H:i'),
						'pembetulan'		=> substr($id_pengiriman, -1),
						'file'				=> implode('|', $tanggal_ambil),
						'keterangan'		=> implode('|', $this->input->post('keterangan', true)),
						'id_request'		=> $this->input->post('id_permintaan', true),
					];
					$this->db->insert('pengiriman_perpajakan', $data);
					return 'OK';
				}
			}
		}
		
		public function konfirmasi() {
			$data = [
				'status'		=> implode('|', $this->input->post('status', true)),
				'keterangan2'	=> implode('|', $this->input->post('keterangan2', true)),
			];
			$this->db->where('id_pengiriman', $this->input->post('id_pengiriman', true))
					->update('pengiriman_perpajakan', $data);
		}
		
		public function proses_file($nama_klien, $index) {
			$fileData		= $_FILES['files'];
			$folderUpload	= "asset/uploads/".$nama_klien."/".date('Y')."/";
			$targetFile		= $folderUpload . basename($fileData['name'][$index]);
			$extractFile	= pathinfo($targetFile); 
			
			if (!is_dir($folderUpload)) { # periksa apakah folder sudah ada
				mkdir($folderUpload, 0777, $rekursif = true); # jika tidak ada, buat folder
			}
			
			//cek apakah extensi file sesuai
			$exts = array("xls", "xlsx", "csv", "pdf", "rar", "zip");
			if(!in_array(strtolower($extractFile['extension']), $exts)){ 
				$newName = "";
			}
			else {
				//cek apakah nama file sudah ada
				$sameName	= 0; // Menyimpan jumlah file dengan nama yang sama dengan file yg diupload
				$handle		= opendir($folderUpload);
				while(false !== ($file = readdir($handle))){ // Looping isi file pada directory tujuan
					// jika nama awalan file sama dengan nama file di uplaod
					if(strpos($file,$extractFile['filename']) !== false)
					$sameName++; // Tambah data file yang sama
				}
				// Apabila tidak ada file yang sama ($sameName masih '0') maka nama file sama dengan
				// nama ketika diupload. Jika $sameName > 0 maka pakai format "namafile($sameName).ext"
				$newName	= empty($sameName) ? $fileData['name'][$index] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];
				$upload		= move_uploaded_file($fileData['tmp_name'][$index], $folderUpload.$newName);
			}
			return $newName;
		}
		
		public function hapusPengiriman($id_pengiriman) {
			$this->db->where('id_pengiriman', $id_pengiriman);
			$this->db->delete('pengiriman_perpajakan');
		}
	}
?>