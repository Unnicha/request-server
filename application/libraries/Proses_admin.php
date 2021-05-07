<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_admin {
		protected $ci;

		function __construct() {
			$this->ci =& get_instance();
		}

		function ganti_jenis($jenis) {

			$this->ci->load->model('Klien_model');
			$this->ci->load->model('Akuntan_model');
			
			$lists = "<option value=''>--Semua ".$jenis."--</option>";
			if($jenis == "Klien") {
				$klien = $this->ci->Klien_model->getAllKlien();
				foreach($klien as $k) {
					$lists .= "<option value='".$k['id_klien']."'>".$k['nama_klien']."</option>"; 
				}
			} else {
				$akuntan = $this->ci->Akuntan_model->getAllAkuntan();
				foreach($akuntan as $k) {
					$lists .= "<option value='".$k['id_user']."'>".$k['nama']."</option>"; 
				}
			}
			return $lists;
		}
		// end ganti_jenis

		function durasi($mulai, $selesai = null) {

			$mulai			= explode(" ", $mulai);
			$waktu_mulai	= $mulai[1];
			$mulai			= explode("/", $mulai[0]);
			$tanggal_mulai	= date_create("$mulai[1]/$mulai[0]/$mulai[2] $waktu_mulai");
			
			if($selesai == null || $selesai == " ") {
				$selesai	= explode(" ", (date("d/m/Y H:i")));
			} else {
				$selesai	= explode(" ", $selesai);
			}
			$waktu_selesai	= $selesai[1];
			$selesai		= explode("/", $selesai[0]);
			$tanggal_selesai= date_create("$selesai[1]/$selesai[0]/$selesai[2] $waktu_selesai");

			$durasi			= date_diff($tanggal_mulai, $tanggal_selesai);
			$durasi_hari	= $durasi->days;
			//$durasi_jam		= $durasi->h;
			//$durasi_menit	= $durasi->i;
			
			$hari_selesai	= date("w", mktime(0,0,0,$selesai[1],$selesai[0],$selesai[2])); // (H,i,s,m,d,Y)
			//$jam_mulai	= explode(":", $waktu_mulai);
			//$jam_selesai	= explode(":", $waktu_selesai);
			$jam_mulai		= date_create($waktu_mulai);
			$jam_selesai	= date_create($waktu_selesai);
			$dikurang		= 0;
			
			// HITUNG HARI
			if($jam_selesai < $jam_mulai) { $hari_selesai = $hari_selesai - 1; }
			$tengah			= $durasi_hari - $hari_selesai; 
			if($tengah < 0) { $tengah = $durasi_hari; }
			$minggu_awal	= $tengah % 7; 
			$minggu_utuh	= floor($tengah / 7); 
			$cut_awal		= 2;  
			//if($jam_selesai[0] < $jam_mulai[0]) { $hari_selesai = $hari_selesai + 1; } 
			if($durasi_hari < 5) { 
				if($hari_selesai < 6 && $hari_selesai > 0) 
					$cut_awal = 0; 
			}
			$dikurang = ($minggu_utuh * 2) + $cut_awal; 
			

			// HITUNG JAM
			$jam_start	= date_create("08:30");
			$jam_end	= date_create("17:30");

			if($jam_mulai < $jam_selesai) { // A
				if($jam_mulai < $jam_start) { // A.1
					$durasi_jam = 0;
					if($jam_selesai >= $jam_start && $jam_selesai <= $jam_end) {
						$diff		= date_diff($jam_selesai, $jam_start);
						$diff		= date_create("$diff->h:$diff->i");
						$istirahat	= $this->cekIstirahat($diff, $waktu_mulai, $waktu_selesai);
						$durasi_jam		= date_format($istirahat, "G");
						$durasi_menit	= date_format($istirahat, "i");
					}
					elseif($jam_selesai < $jam_start) // A.1.1
						$durasi_hari = $durasi_hari + 1;
				}
				elseif($jam_mulai > $jam_end) { // A.2
					$durasi_jam = 0;
				}
				else { // A.3
					if($jam_selesai > $jam_end) {
						$diff			= date_diff($jam_end, $jam_mulai);
						$diff			= date_create("$diff->h:$diff->i");
						$istirahat		= $this->cekIstirahat($diff, $waktu_mulai, $waktu_selesai);
						$durasi_jam		= date_format($istirahat, "G");
						$durasi_menit	= date_format($istirahat, "i");
					}
					else { // A.3.3
						$diff			= date_diff($jam_selesai, $jam_mulai);
						$diff			= date_create("$diff->h:$diff->i");
						$istirahat		= $this->cekIstirahat($diff, $waktu_mulai, $waktu_selesai);
						$durasi_jam		= date_format($istirahat, "G");
						$durasi_menit	= date_format($istirahat, "i");
					}
				}
			}
			elseif($jam_mulai > $jam_selesai) {
				if($jam_mulai < $jam_start) {
					$durasi_jam  = 0;
					$durasi_hari = $durasi_hari + 1;
				}
				elseif($jam_mulai > $jam_end) {
					$durasi_jam = 0;
					if($jam_selesai >= $jam_start && $jam_selesai <= $jam_end) {
						$diff			= date_diff($jam_selesai, $jam_start);
						$diff			= date_create("$diff->h:$diff->i");
						$istirahat		= $this->cekIstirahat($diff, $waktu_mulai, $waktu_selesai);
						$durasi_jam 	= date_format($istirahat, "G");
						$durasi_menit	= date_format($istirahat, "i");
					}
					elseif($jam_selesai > $jam_end)
						$durasi_hari = $durasi_hari + 1;
				}
				else { // $jam_mulai >= $jam_start && $jam_mulai <= $jam_end
					$diff = date_diff($jam_mulai, $jam_end);
					$diff = date_create("$diff->h:$diff->i");
					if($jam_selesai < $jam_start) {
						$istirahat		= $this->cekIstirahat($diff, $waktu_mulai, $waktu_selesai);
						$durasi_jam		= date_format($istirahat, "G");
						$durasi_menit	= date_format($istirahat, "i");
					}
					else {
						$diff2			= date_diff($jam_selesai, $jam_start);
						$result			= date_add($diff, date_interval_create_from_date_string("$diff2->h hours $diff2->i minutes"));
						//$selisih		= date_create("$result->h:$result->m");
						$istirahat		= $this->cekIstirahat($result, $waktu_mulai, $waktu_selesai);
						$durasi_jam		= date_format($istirahat, "G");
						$durasi_menit	= date_format($istirahat, "i");
					}
				}
			}

			$total_hari		= $durasi_hari - $dikurang;
			return $total	= "$total_hari h $durasi_jam j  $durasi_menit m";
		} 
		// end durasi

		function cekIstirahat($selisih, $jam_mulai, $jam_selesai) {
			//$selisih		= date_create("$diff->h:$diff->i");
			$waktu_mulai	= explode(":", $jam_mulai);
			$waktu_selesai	= explode(":", $jam_selesai);
			
			if($jam_mulai < $jam_selesai) {
				if($waktu_mulai[0] < 12) {
					if($waktu_selesai[0] == 12) 
						$selisih = date_add($selisih, date_interval_create_from_date_string("-$waktu_selesai[1] minutes"));
					elseif($waktu_selesai[0] > 12) 
						$selisih = date_add($selisih, date_interval_create_from_date_string("-1 hours"));
				} 
				elseif($waktu_mulai[0] == 12) {
					$selisih = date_add($selisih, date_interval_create_from_date_string("-$waktu_mulai[1] minutes"));
				}
			}
			elseif($jam_mulai > $jam_selesai) {
				if($waktu_mulai[0] < 12) {
					if($waktu_selesai[0] < 12) 
						$selisih = date_add($selisih, date_interval_create_from_date_string("-1 hours"));
				}
				elseif($waktu_mulai[0] == 12) {
					if($waktu_selesai[0] < 12) {
						$menit	= 60 - $waktu_mulai[1];
						$selisih = date_add($selisih, date_interval_create_from_date_string("-$menit minutes"));
					}
					elseif($waktu_selesai[0] == 12) 
					$menit	= (60 - $waktu_mulai[1]) + $waktu_selesai[1];
				}
				else {
					if($waktu_selesai[0] == 12)
						$selisih = date_add($selisih, date_interval_create_from_date_string("-$waktu_selesai[1] minutes"));
					elseif($waktu_selesai > 12)
						$selisih = date_add($selisih, date_interval_create_from_date_string("-1 hours"));
				}
			}
			return $selisih;
		}
		// end cekIstirahat
	}
?>