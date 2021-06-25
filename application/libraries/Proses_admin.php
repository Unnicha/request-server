<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_admin {
		protected $ci;

		function __construct() {
			$this->ci =& get_instance();
		}

		function durasi($mulai, $selesai) {
			$mulai			= date_create_from_format("d/m/Y H:i", $mulai);
			$tanggal_mulai	= date_format($mulai, "d/m/Y H:i");
			$waktu_mulai	= date_format($mulai, "H:i");
			
			$selesai		= date_create_from_format("d/m/Y H:i", $selesai);
			$tanggal_selesai= date_format($selesai, "d/m/Y H:i");
			$waktu_selesai	= date_format($selesai, "H:i");

			$durasi			= date_diff($tanggal_mulai, $tanggal_selesai);
			$durasi_hari	= $durasi->days;
			
			// HITUNG HARI
			$hari_selesai	= date_format($tanggal_selesai, "w");
			$hari_selesai	= ($waktu_selesai < $waktu_mulai) ? $hari_selesai - 1 : $hari_selesai;
			$mingguTengah	= ($durasi_hari<$hari_selesai) ? $durasi_hari-$hari_selesai : $durasi_hari; 
			$minggu_awal	= $mingguTengah % 7; 
			$minggu_utuh	= floor($mingguTengah / 7); 
			$cut_awal		= 2;
			if($durasi_hari < 5) {
				if($hari_selesai == 6) {
					$cut_awal = 1;
				} elseif($hari_selesai > 0) {
					$cut_awal = 0; 
				}
			} else {

			}
			$dikurang = ($minggu_utuh * 2) + $cut_awal; 
			
			// HITUNG JAM
			$jam_start	= date_create("08:30");
			$jam_end	= date_create("17:30");

			if($jam_mulai < $jam_selesai) {
				if($jam_mulai < $jam_start) {
					$durasi_jam = 0;
					if($jam_selesai >= $jam_start && $jam_selesai <= $jam_end) {
						$diff		= date_diff($jam_selesai, $jam_start);
						$diff		= date_create("$diff->h:$diff->i");
						$istirahat	= $this->cekIstirahat($diff, $waktu_mulai, $waktu_selesai);
						$durasi_jam		= date_format($istirahat, "G");
						$durasi_menit	= date_format($istirahat, "i");
					}
					elseif($jam_selesai < $jam_start)
						$durasi_hari = $durasi_hari + 1;
				}
				elseif($jam_mulai > $jam_end) {
					$durasi_jam = 0;
				} else {
					if($jam_selesai > $jam_end) {
						$diff			= date_diff($jam_end, $jam_mulai);
						$diff			= date_create("$diff->h:$diff->i");
						$istirahat		= $this->cekIstirahat($diff, $waktu_mulai, $waktu_selesai);
						$durasi_jam		= date_format($istirahat, "G");
						$durasi_menit	= date_format($istirahat, "i");
					} else {
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
					$durasi_jam		= 0;
					$durasi_hari	= $durasi_hari + 1;
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
				} else {
					$diff = date_diff($jam_mulai, $jam_end);
					$diff = date_create("$diff->h:$diff->i");
					
					if($jam_selesai < $jam_start) {
						$istirahat		= $this->cekIstirahat($diff, $waktu_mulai, $waktu_selesai);
						$durasi_jam		= date_format($istirahat, "G");
						$durasi_menit	= date_format($istirahat, "i");
					} else {
						$diff2			= date_diff($jam_selesai, $jam_start);
						$result			= date_add($diff, date_interval_create_from_date_string("$diff2->h hours $diff2->i minutes"));
						$istirahat		= $this->cekIstirahat($result, $waktu_mulai, $waktu_selesai);
						$durasi_jam		= date_format($istirahat, "G");
						$durasi_menit	= date_format($istirahat, "i");
					}
				}
			}
			
			$total_hari		= $durasi_hari - $dikurang;
			return $total	= "$total_hari hari $durasi_jam jam $durasi_menit min";
		} 
		// end durasi

		function cekIstirahat($selisih, $jam_mulai, $jam_selesai) {
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
				} else {
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