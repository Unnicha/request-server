<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Proses_admin {
		protected $ci;

		function __construct() {
			$this->ci =& get_instance();
		}

		function durasi($mulai, $selesai=null) {
			$tanggal_mulai	= date_create_from_format("d/m/Y H:i", $mulai);
			$waktu_mulai	= date_create(date_format($tanggal_mulai, "H:i"));
			
			$selesai		= ($selesai) ? $selesai : date('d/m/Y H:i');
			$tanggal_selesai= date_create_from_format("d/m/Y H:i", $selesai);
			$waktu_selesai	= date_create(date_format($tanggal_selesai, "H:i"));
			
			$durasi			= date_diff($tanggal_mulai, $tanggal_selesai);
			$durasi_hari	= $durasi->days; //string

			// HITUNG HARI
			$hariMulai		= date_format($tanggal_mulai, "w"); //string
			$hariSelesai	= date_format($tanggal_selesai, "w"); //string
			$hariSelesai	= ($waktu_selesai < $waktu_mulai) ? $hariSelesai - 1 : $hariSelesai;
			$mingguAwal		= ($durasi_hari > $hariSelesai) ? $durasi_hari - $hariSelesai : $durasi_hari;
			
			if($mingguAwal == $durasi_hari) {
				if($hariMulai > 0 && $hariMulai < 6) {
					$dikurang = 0;
				} else {
					if($hariSelesai < 6) {
						$dikurang = 1;
					} else {
						$dikurang = 2;
					}
				}
			} else {
				$jumMinggu = ceil($mingguAwal / 7);
				$cut = 0;
				if($hariMulai == 0) {
					$cut = $cut + 1;
				}
				if($hariSelesai == 6) {
					$cut = $cut + 1;
				}
				$dikurang = ($jumMinggu * 2) + $cut;
			}
			$hari = $durasi_hari - $dikurang;

			// HITUNG JAM
			$jam_start	= date_create("08:30");
			$jam_end	= date_create("17:30");
			$breakTime	= date_create('01:00');
			$breakStart	= date_create('12:00');
			$breakEnd	= date_create('13:00');
			
			if($waktu_mulai < $jam_start) {
				$waktu_mulai = $jam_start;
			} elseif($waktu_mulai>$breakStart && $waktu_mulai<$breakEnd) {
				$waktu_mulai = $breakEnd;
			}
			if($waktu_selesai > $jam_end) {
				$waktu_selesai = $jam_end;
			} elseif($waktu_selesai>$breakStart && $waktu_selesai<$breakEnd) {
				$waktu_selesai = $breakStart;
			}
			$waktu	= date_diff($waktu_mulai, $waktu_selesai);
			
			if($waktu_mulai < $breakEnd && $waktu_selesai > $breakEnd) {
				$waktu	= date_diff(date_create($waktu->format('%H:%I')), $breakTime);
			}
			
			return "$hari $waktu->h $waktu->i";
		} 
		// end durasi
		
		function addDurasi($dur='', $add) {
			$add = explode(' ', $add);
			if($dur) {
				$dur = explode(' ', $dur);
				
				$min		= ($dur[2] + $add[2]) % 60;
				$jamAdd		= floor(($dur[2] + $add[2]) % 60);
				$jam		= ($dur[1] + $jamAdd) % 8;
				$hariAdd	= floor(($dur[1] + $jamAdd) % 8);
				$hari		= $dur[0] + $hariAdd;
				
				return "$hari $jam $min";
			} else {
				return "$add[0] $add[1] $add[2]";
			}
		}
	}
?>