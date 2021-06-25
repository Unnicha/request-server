<?php
	
	class M_Pengiriman_akuntansi extends CI_model {
		
		public function getAllPengiriman() {
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_request', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->order_by('id_pengiriman', 'ASC')
							->get()->result_array();
		}
		
		public function getByMasa($bulan, $tahun, $klien='', $start, $limit) {
			if($klien != 'all') {
				$this->db->where_in('permintaan_akuntansi.id_klien', $klien);
			}
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_request', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->limit($limit, $start)
							->order_by('id_pengiriman', 'ASC')
							->get()->result_array();
		}
		
		public function countPengiriman($bulan, $tahun, $klien='') {
			if($klien != 'all') {
				$this->db->where_in('permintaan_akuntansi.id_klien', $klien);
			}
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_request', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->where(['bulan' => $bulan, 'tahun' => $tahun])
							->count_all_results();
		}
		
		public function getById($id_pengiriman) {
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_request', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->where('id_pengiriman', $id_pengiriman)
							->get()->row_array();
		}
		
		public function getDetail($id_permintaan) {
			return $this->db->from('data_akuntansi')
							->join('jenis_data', 'jenis_data.kode_jenis = data_akuntansi.id_jenis', 'left')
							->where(['id_request' => $id_permintaan])
							->get()->result_array();
		}
		
		public function getMax($id_permintaan) { 
			$max = $this->db->select_max('id_pengiriman')
							->where('id_request', $id_permintaan)
							->get('pengiriman_akuntansi')->row_array();
			
			if($max['id_pengiriman'] == null) {
				$id_pengiriman	= $id_permintaan."01";
			} else {
				$revisi			= substr($max['id_pengiriman'], -2);
				$id_pengiriman	= $id_permintaan . sprintf('%02s', ++$revisi); 
			}
			return $id_pengiriman;
		}
		
		public function getMaxProses($id_data) {
			$pre = substr($id_data, 0, 9);
			$max = $this->db->select_max('id_proses')
						->like('id_proses', $pre)
						->get('proses_akuntansi')->row_array();
			
			if($max['id_proses'] == null) {
				$id_proses	= $pre . '001';
			} else {
				$tambah		= substr($max['id_proses'], -3);
				$id_proses	= $pre . sprintf('%03s', ++$tambah);
			}
			return $id_proses;
		}
		
		public function kirim() {
			$id_permintaan	= $this->input->post('id_permintaan', true);
			$format_data	= $this->input->post('format_data', true);
			$id_pengiriman	= $this->getMax($id_permintaan);
			$isi			= $this->getDetail($id_permintaan);
			$exts			= ["xls", "xlsx", "csv", "pdf", "rar", "zip"];
			
			if(isset($_FILES['files'])) {
				$fileName = $_FILES['files']['name'];
				for($i=0; $i<count($fileName); $i++) {
					if($fileName[$i] != null) {
						$file = explode('.', $fileName[$i]);
						if(in_array(strtolower($file[1]), $exts) == false) {
							$msg = 'Format file yang di izinkan : <b>.xls, .xlsx, .csv, .pdf, .rar, .zip</b>';
							$this->session->set_flashdata('flash', $msg);
							$callback = 'ERROR';
						}
					}
				}
			}
			
			if(isset($callback)) {
				return $callback;
			} else {
				$j = 0; $k = 0;
				for($i=0; $i<count($format_data); $i++) {
					if($format_data[$i] == "Softcopy") {
						$upload[$i] = '';
						if($_FILES['files']['name'][$j] != null) {
							$upload[$i] = $this->proses_file($this->session->userdata('nama'), $j);
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
				
				if($upload) {
					$tanggal = date('d-m-Y H:i');
					$j=0;
					foreach($isi as $i) {
						if($i['tanggal_pengiriman'] == null || $i['status'] == 2) {
							if($upload[$j] != null) {
								$row[] = [
									'id_data'			=> $i['id_data'],
									'tanggal_pengiriman'=> $tanggal,
									'file'				=> $upload[$j],
									'ket_file'			=> $this->input->post('keterangan', true)[$j],
									'status'			=> 1,
									'id_kirim'			=> $id_pengiriman,
								];
							}
							$j++;
						}
					}
					$this->db->update_batch('data_akuntansi', $row, 'id_data');
					
					if(isset($_POST['tipe'])) {
						$data = [
							'id_pengiriman'		=> $id_pengiriman,
							'pembetulan'		=> substr($id_pengiriman, -2),
							'id_request'		=> $id_permintaan,
						];
						$this->db->insert('pengiriman_akuntansi', $data);
					}
					return 'OK';
				}
			}
		}
		
		public function konfirmasi() {
			$id_data	= $this->input->post('id_data', true);
			$status		= $this->input->post('status', true);
			$ket		= $this->input->post('keterangan2', true);
			
			for($i=0; $i<count($id_data); $i++) {
				if($status[$i] > 1) {
					if($status[$i] == 3) {
						$id_proses	= $this->getMaxProses($id_data[$i]);
						$this->db->insert('proses_akuntansi', ['id_proses' => $id_proses]);
					}
					$data[] = [
						'id_data'		=> $id_data[$i],
						'status'		=> $status[$i],
						'ket_status'	=> $ket[$i],
						'id_kerja'		=> ($status[$i] == 3) ? $id_proses : null,
					];
				}
			}
			if(isset($data)) {
				$this->db->update_batch('data_akuntansi', $data, 'id_data');
				return 'OK';
			}
		}
		
		public function proses_file($nama_klien, $index) {
			$fileData		= $_FILES['files'];
			$folderUpload	= "asset/uploads/".$nama_klien."/".date('Y')."/";
			$targetFile		= $folderUpload . basename($fileData['name'][$index]);
			$extractFile	= pathinfo($targetFile); 
			
			if (!is_dir($folderUpload)) { # periksa apakah folder sudah ada
				mkdir($folderUpload, 0777, $rekursif = true); # jika tidak ada, buat folder
			}
			
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
			
			return $newName;
		}
		
		public function hapusPengiriman($id_pengiriman) {
			$this->db->where('id_pengiriman', $id_pengiriman);
			$this->db->delete('pengiriman_akuntansi');
		}
	}
?>