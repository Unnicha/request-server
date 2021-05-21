<?php

	class M_Pengiriman_perpajakan extends CI_model {

		public function getAllPengiriman() {
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_permintaan', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('jenis_data', 'permintaan_perpajakan.kode_jenis = jenis_data.kode_jenis', 'left')
							->order_by('id_pengiriman', 'ASC')
							->get()->result_array();
		}

		public function getByMasa($bulan, $tahun, $klien='', $start, $limit) {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_permintaan', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('jenis_data', 'permintaan_perpajakan.kode_jenis = jenis_data.kode_jenis', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->limit($limit, $start)
							->order_by('id_pengiriman', 'ASC')
							->get()->result_array();
		}

		public function countPengiriman($bulan, $tahun, $klien='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_perpajakan.id_klien', $klien);
			}
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_permintaan', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('jenis_data', 'permintaan_perpajakan.kode_jenis = jenis_data.kode_jenis', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->count_all_results();
		}

		public function getById($id_pengiriman) {
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_permintaan', 'left')
							->join('klien', 'permintaan_perpajakan.id_klien = klien.id_klien', 'left')
							->join('jenis_data', 'permintaan_perpajakan.kode_jenis = jenis_data.kode_jenis', 'left')
							->where('id_pengiriman', $id_pengiriman)
							->get()->row_array();
		}

		public function getMax($id_permintaan) { //fungsi untuk membuat id baru dengan autoincrement
			$max = $this->db->select_max('id_pengiriman')
							->where('id_permintaan', $id_permintaan)
							->get('pengiriman_perpajakan')->row_array();
			$kodeMax = $max['id_pengiriman']; //masukkan max id ke variabel

			if($kodeMax == null) {
				$id_pengiriman = $id_permintaan."0";
			} else {
				//ambil kode pembetulan => substr(dari $kodeMax, index ke, sebanyak x char) 
				//jadikan integer => (int) 
				$revisi = (int) substr($kodeMax, -1);
				if($revisi == 9) {
					$id_pengiriman = $id_permintaan;
				} else {
					$id_pengiriman	= $id_permintaan . ++$revisi; //tambahkan kode pembetulan baru
				}
			}
			
			return $id_pengiriman;
		}
		
		public function kirim() {

			$id_permintaan	= $this->input->post('id_permintaan', true);
			$masa			= $this->input->post('masa', true);
			$tahun			= $this->input->post('tahun', true);
			
			$redirect		= "klien/permintaan_data_perpajakan/kirim/".$id_permintaan;
			$id_pengiriman	= $this->getMax($id_permintaan); //ambil id_pengiriman terbesar yang sudah ada
			if($id_pengiriman == $id_permintaan) {
				$this->session->set_flashdata('flash', 'Revisi sudah mencapai batas maksimal. Silahkan hubungi accounting');
				redirect("klien/pengiriman_data_perpajakan/pembetulan/".$id_permintaan);
			} else {
				$pembetulan		= substr($id_pengiriman, -1); //mengambil kode pembetulan dari id_pengiriman
				if($pembetulan > 0) { // error handler
					$redirect	= "klien/pengiriman_data_perpajakan/pembetulan/".$id_permintaan;
				}
				
				$nama_klien		= $this->session->userdata('nama');
				$format_data	= $this->input->post('format_data', true);
				$fileDikirim	= "";
				
				if($format_data == "Softcopy") {
					//cek apakah field File diisi
					if(basename($_FILES['file']['name']) == null) { 
						$this->session->set_flashdata('flash', 'Kolom <b>File</b> harus diisi');
						redirect($redirect); 
					} else {
						$fileDikirim = $this->proses_file($nama_klien, $masa, $tahun);
						if($fileDikirim == null) {
							$this->session->set_flashdata('flash','Format file yang di izinkan hanya <b>XLS</b> dan <b>PDF</b>');
							redirect($redirect); 
						}
					}
				}
				
				if($format_data == "Hardcopy") {
					if($this->input->post('tanggal_ambil', true) == null) {
						$this->session->set_flashdata('flash', 'Kolom <b>Tanggal Ambil</b> harus diisi');
						redirect($redirect); 
					}
				}
				
				$data = [
					'id_pengiriman'		=> $id_pengiriman,
					'tanggal_pengiriman'=> $this->input->post('tanggal_pengiriman', true),
					'pembetulan'		=> $pembetulan,
					'file'				=> $fileDikirim,
					'tanggal_ambil'		=> $this->input->post('tanggal_ambil', true),
					'keterangan2'		=> $this->input->post('keterangan', true),
					'id_permintaan'		=> $this->input->post('id_permintaan', true),
				];
				$this->db->insert('pengiriman_perpajakan', $data);
			}
		}
		
		public function proses_file($nama_klien, $masa, $tahun) {

			$fileData		= $_FILES['file'];
			$folderUpload	= "asset/uploads/".$nama_klien."/".$tahun."/".$masa."/";
			$targetFile		= $folderUpload . basename($fileData['name']);
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
				$newName	= empty($sameName) ? $fileData['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];
				$upload		= move_uploaded_file($fileData['tmp_name'], $folderUpload.$newName);
			}
			return $newName;
		}
		
		public function hapusPengiriman($id_pengiriman) {
			$this->db->where('id_pengiriman', $id_pengiriman);
			$this->db->delete('pengiriman_perpajakan');
		}
	}
?>