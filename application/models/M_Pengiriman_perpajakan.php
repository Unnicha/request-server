<?php

	class M_Pengiriman_perpajakan extends CI_model {

		public function getAllPengiriman() {
			return $this->db->from('pengiriman_perpajakan')
							->join('permintaan_perpajakan', 'permintaan_perpajakan.id_permintaan = pengiriman_perpajakan.id_request', 'left')
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
				$id_pengiriman	= $id_permintaan."01";
			} else {
				$revisi			= substr($max['id_pengiriman'], -2);
				$id_pengiriman	= $id_permintaan . sprintf('%02s', ++$revisi); 
			}
			return $id_pengiriman;
		}
		
		public function kirim() {
			$id_pengiriman	= $this->getMax($this->input->post('id_permintaan', true));
			$format_data	= explode('|', $this->input->post('format_data', true));
			
			$j = 0; $k = 0;
			for($i=0; $i<count($format_data); $i++) {
				if($format_data[$i] == "Softcopy") {
					$upload[$i] = '';
					if($_FILES['files']['name'][$j] != null) {
						$upload[$i] = $this->proses_file($this->session->userdata('nama'), $j);
						if($upload[$i] == null) {
							$this->session->set_flashdata('flash','Format file yang di izinkan : <b>.xls, .xlsx, .csv, .pdf, .rar, .zip</b>');
							$callback = 'ERROR';
						}
					}
					$j++;
				} elseif($format_data[$i] == "Hardcopy") {
					$upload[$i] = $this->input->post('tanggal_ambil', true)[$k];
					$k++;
				}
			}
			
			$cekUpload	= array_unique($upload);
			if(count($cekUpload)==1 && $cekUpload[0]=='') {
				$upload	= null;
			}
			
			if(isset($callback)) {
				return $callback;
			} else {
				if($upload) {
					$tanggal	= date('d-m-Y H:i');
					foreach($upload as $up) {
						if($up == null) {
							$status[] = 0;	$tanggal_pengiriman[] = '';
						} else {
							$status[] = 1 ;	$tanggal_pengiriman[] = $tanggal;
						}
					}
					
					$data = [
						'id_pengiriman'		=> $id_pengiriman,
						'tanggal_pengiriman'=> implode('|', $tanggal_pengiriman),
						'pembetulan'		=> substr($id_pengiriman, -2),
						'file'				=> implode('|', $upload),
						'keterangan'		=> implode('|', $this->input->post('keterangan', true)),
						'status'			=> implode('|', $status),
						'id_request'		=> $this->input->post('id_permintaan', true),
					];
					$this->db->insert('pengiriman_perpajakan', $data);
					return 'OK';
				}
			}
		}
		
		public function ubah() {
			$pengiriman		= $this->getById($this->input->post('id_pengiriman', true));
			$format_data	= $this->input->post('format_data', true);
			$keterangan		= $this->input->post('keterangan', true);
			
			$j = 0; $k = 0;
			for($i=0; $i<count($format_data); $i++) {
				if($format_data[$i] == "Softcopy") {
					$upload[$i] = '';
					if($_FILES['files']['name'][$j] != null) {
						$upload[$i] = $this->proses_file($this->session->userdata('nama'), $j);
						if($upload[$i] == null) {
							$this->session->set_flashdata('flash','Format file yang di izinkan : <b>.xls, .xlsx, .csv, .pdf, .rar, .zip</b>');
							$callback = 'ERROR';
						}
					}
					$j++;
				} elseif($format_data[$i] == "Hardcopy") {
					$upload[$i] = $this->input->post('tanggal_ambil', true)[$k];
					$k++;
				}
			}
			
			$cekUpload	= array_unique($upload);
			if(count($cekUpload)==1 && $cekUpload[0]=='') {
				$upload	= null;
			}
			
			if(isset($callback)) {
				return $callback;
			} else {
				if($upload) {
					$tanggal = date('d-m-Y H:i');
					foreach($upload as $up) {
						if($up == null) {
							$status[] = 0;	$tanggal_pengiriman[] = '';
						} else {
							$status[] = 1;	$tanggal_pengiriman[] = $tanggal;
						}
					}
					
					$oldTanggal	= explode('|', $pengiriman['tanggal_pengiriman']);
					$oldFile	= explode('|', $pengiriman['file']);
					$oldKet		= explode('|', $pengiriman['keterangan']);
					$oldStatus	= explode('|', $pengiriman['status']);
					$j=0;
					for($i=0; $i<count($oldTanggal); $i++) {
						if($oldStatus[$i] < 3) {
							$oldTanggal[$i]	= $tanggal_pengiriman[$j];
							$oldFile[$i]	= $upload[$j];
							$oldKet[$i]		= $keterangan[$j];
							$oldStatus[$i]	= $status[$j];
							$j++;
						}
					}
					
					$data = [
						'tanggal_pengiriman'=> implode('|', $oldTanggal),
						'file'				=> implode('|', $oldFile),
						'keterangan'		=> implode('|', $oldKet),
						'status'			=> implode('|', $oldStatus),
					];
					$this->db->where('id_pengiriman', $this->input->post('id_pengiriman', true))
							->update('pengiriman_perpajakan', $data);
					return 'OK';
				}
			}
		}
		
		public function konfirmasi() {
			$pengiriman	= $this->getById($this->input->post('id_pengiriman', true));
			$oldTanggal	= explode('|', $pengiriman['tanggal_pengiriman']);
			$oldStatus	= explode('|', $pengiriman['status']);
			$oldKet		= explode('|', $pengiriman['keterangan2']);
			
			$j=0;
			for($i=0; $i<count($oldTanggal); $i++) {
				if($oldTanggal[$i] != '' && $oldStatus[$i] < 3) {
					$oldStatus[$i]	= $this->input->post('status', true)[$j];
					$oldKet[$i]		= $this->input->post('keterangan2', true)[$j];
					$j++;
				} else {
					$oldKet[$i] = (isset($oldKet[$i])) ? $oldKet[$i] : '';
				}
			}
			
			$data = [
				'status'		=> implode('|', $oldStatus),
				'keterangan2'	=> implode('|', $oldKet),
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