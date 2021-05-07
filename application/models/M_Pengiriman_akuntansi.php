<?php

	class M_Pengiriman_akuntansi extends CI_model {

		public function getAllPengiriman() {
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->order_by('id_pengiriman', 'ASC')
							->get()->result_array();
		}

		public function getByMasa($bulan, $tahun, $klien='', $start='', $limit='') {
			if($klien) {
				$this->db->where('permintaan_akuntansi.id_klien', $klien);
			}
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->limit($limit, $start)
							->order_by('id_pengiriman', 'ASC')
							->get()->result_array();
		}

		public function countPengiriman($bulan, $tahun, $klien='') {
			if($klien) {
				$this->db->where('permintaan_akuntansi.id_klien', $klien);
			}
			return $this->db->from('pengiriman_akuntansi')
							->join('permintaan_akuntansi', 'permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan', 'left')
							->join('klien', 'permintaan_akuntansi.id_klien = klien.id_klien', 'left')
							->join('jenis_data', 'permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis', 'left')
							->where(['masa' => $bulan, 'tahun' => $tahun])
							->count_all_results();
		}

		public function getPerMasa($bulan, $tahun) {
			$q = "SELECT * FROM (pengiriman_akuntansi 
				LEFT JOIN ((permintaan_akuntansi 
				LEFT JOIN jenis_data ON permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis) 
				LEFT JOIN klien ON permintaan_akuntansi.id_klien = klien.id_klien) 
				ON permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan) 
				WHERE masa = '$bulan' AND tahun = '$tahun' 
				ORDER BY id_pengiriman ASC";
			return $this->db->query($q)->result_array();
		}

		public function getPerKlien($bulan, $tahun, $klien) {
			$q = "SELECT * FROM (pengiriman_akuntansi 
				LEFT JOIN ((permintaan_akuntansi 
				LEFT JOIN jenis_data ON permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis) 
				LEFT JOIN klien ON permintaan_akuntansi.id_klien = klien.id_klien) 
				ON permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan) 
				WHERE permintaan_akuntansi.masa = '$bulan' 
				AND permintaan_akuntansi.tahun = '$tahun' 
				AND permintaan_akuntansi.id_klien = '$klien' 
				ORDER BY id_pengiriman ASC";
			return $this->db->query($q)->result_array();
		}

		public function getById($id_pengiriman) {
			$q = "SELECT * FROM ((pengiriman_akuntansi 
				LEFT JOIN ((permintaan_akuntansi 
				LEFT JOIN jenis_data ON permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis) 
				LEFT JOIN klien ON permintaan_akuntansi.id_klien = klien.id_klien) 
				ON permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan) 
				LEFT JOIN tugas ON tugas.kode_jenis = jenis_data.kode_jenis 
					AND klien.status_pekerjaan = tugas.status_pekerjaan)  
				WHERE id_pengiriman = '$id_pengiriman'";
			return $this->db->query($q)->row_array();
		}
		
		public function masa() {
			$masa = array(
				array('id'=> '01', 'value'=>'Januari'), 
				array('id'=> '02', 'value'=>'Februari'), 
				array('id'=> '03', 'value'=>'Maret'), 
				array('id'=> '04', 'value'=>'April'), 
				array('id'=> '05', 'value'=>'Mei'), 
				array('id'=> '06', 'value'=>'Juni'), 
				array('id'=> '07', 'value'=>'Juli'), 
				array('id'=> '08', 'value'=>'Agustus'), 
				array('id'=> '09', 'value'=>'September'), 
				array('id'=> '10', 'value'=>'Oktober'), 
				array('id'=> '11', 'value'=>'November'), 
				array('id'=> '12', 'value'=>'Desember'), 
			);
			return $masa;
		}

		public function getMax($id_permintaan) { //fungsi untuk membuat id baru dengan autoincrement

			//mengambil max id_pengiriman berdasarkan id_permintaan
			$q = "SELECT max(id_pengiriman) as maxId FROM pengiriman_akuntansi 
				WHERE id_permintaan = '$id_permintaan' ";
			$max = $this->db->query($q)->row_array();
			$kodeMax = $max['maxId']; //masukkan max id ke variabel

			if($kodeMax == null) {
				$id_pengiriman = "{$id_permintaan}00";
			} else {
				//ambil kode pembetulan => substr(dari $kodeMax, index ke, sebanyak x char) 
				//jadikan integer => (int) 
				$tambah = (int) substr($kodeMax, 11, 2);
				$tambah++;  //kode pembetulan +1
				$pembetulan = sprintf("%02s", $tambah); //kode pembetulan baru, jadikan 2 char

				$id_pengiriman = "{$id_permintaan}{$pembetulan}"; //tambahkan kode pembetulan baru
			}
			
			return $id_pengiriman;
		}
		
		public function proses_file($nama_klien, $masa, $tahun) {

			$fileData = $_FILES['file'];
			$folderUpload = "asset/uploads/{$nama_klien}/{$tahun}/{$masa}/";
			$targetFile = $folderUpload . basename($fileData['name']);
			$extractFile = pathinfo($targetFile); 
			
			# periksa apakah folder sudah ada
			if (!is_dir($folderUpload)) {
				# jika tidak maka folder harus dibuat terlebih dahulu
				mkdir($folderUpload, 0777, $rekursif = true);
			}
			
			//cek apakah extensi file sesuai
			$exts = array("xls", "xlsx", "csv", "pdf", "rar", "zip");
			if(!in_array(strtolower($extractFile['extension']), $exts)){ 
				$newName = "";
			}
			else {
				//cek apakah nama file sudah ada
				$sameName = 0; // Menyimpan banyaknya file dengan nama yang sama dengan file yg diupload
				$handle = opendir($folderUpload);
				while(false !== ($file = readdir($handle))){ // Looping isi file pada directory tujuan
					// jika nama awalan file sama dengan nama file di uplaod
					if(strpos($file,$extractFile['filename']) !== false)
					$sameName++; // Tambah data file yang sama
				}
				/* Apabila tidak ada file yang sama ($sameName masih '0') maka nama file pakai 
				* nama ketika diupload, jika $sameName > 0 maka pakai format "namafile($sameName).ext */
				$newName = empty($sameName) ? $fileData['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];
		
				$upload = move_uploaded_file($fileData['tmp_name'], $folderUpload.$newName);
			}
			return $newName;
		}
		
		public function kirim() {

			$id_permintaan = $this->input->post('id_permintaan', true);
			$masa = $this->input->post('masa', true);
			$tahun = $this->input->post('tahun', true);

			$redirect = "klien/permintaan_data_akuntansi/kirim/{$id_permintaan}"; //jika terjadi eror kirim
			$id_pengiriman = $this->getMax($id_permintaan); //ambil id_pengiriman terbesar yang sudah ada
			$pembetulan = substr($id_pengiriman, 11, 2); //mengambil kode pembetulan (index[10])
			if($pembetulan > 0) { // error handler
				$redirect = "klien/pengiriman_data_akuntansi/pembetulan/{$id_permintaan}"; 
			}
			
			$nama_klien = $this->session->userdata('nama');
			$format_data = $this->input->post('format_data', true);
			$fileDikirim = "";

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
				"id_pengiriman" => $id_pengiriman,
				"tanggal_pengiriman" => $this->input->post('tanggal_pengiriman', true),
				"pembetulan" => $pembetulan,
				"file" => $fileDikirim,
				"tanggal_ambil" => $this->input->post('tanggal_ambil', true),
				"keterangan2" => $this->input->post('keterangan', true),
				"id_permintaan" => $this->input->post('id_permintaan', true),
			];
			$this->db->insert('pengiriman_akuntansi', $data);
		}
		
		public function ubahPengiriman() {

			$data = [
				"id_pengiriman" => $id_pengiriman,
				"tanggal_pengiriman" => $this->input->post('tanggal_pengiriman', true),
				"pembetulan" => $pembetulan,
				"file" => $fileDikirim,
				"tanggal_ambil" => $this->input->post('tanggal_ambil', true),
				"keterangan2" => $this->input->post('keterangan', true),
				"id_permintaan" => $this->input->post('id_permintaan', true),
			];
			$this->db->where('id_pengiriman', $this->input->post('id_pengiriman'));
			$this->db->update('pengiriman_akuntansi', $data);
		}
		
		public function hapusPengiriman($id_pengiriman) {
			$this->db->where('id_pengiriman', $id_pengiriman);
			$this->db->delete('pengiriman_akuntansi');
		}
	}
?>