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
			$hariMulai		= date_format($tanggal_mulai, "N"); //string
			$hariSelesai	= date_format($tanggal_selesai, "N"); //string
			$hariSelesai	= ($waktu_selesai < $waktu_mulai) ? $hariSelesai - 1 : $hariSelesai;
			$minggu			= ($durasi_hari > $hariSelesai) ? $durasi_hari - $hariSelesai : $durasi_hari;
			
			if($minggu == $durasi_hari) {
				if($hariMulai < 6) {
					$dikurang = 0;
				} else {
					$dikurang = $hariSelesai - 5;
				}
			} else {
				$jumWeek	= ceil($minggu / 7);
				$cut		= 0;
				if($hariMulai > 5) {
					$cut = $hariMulai - 5;
				}
				if($hariSelesai > 5) {
					$cut = $cut + ($hariSelesai - 5);
				}
				$dikurang = ($jumWeek * 2) + $cut;
			}
			$hari = $durasi_hari - $dikurang;
			
			// HITUNG JAM
			$jam_start	= date_create("08:30");
			$jam_end	= date_create("17:30");
			$breakTime	= date_create('00:00');
			$breakStart	= date_create('12:00');
			$breakEnd	= date_create('13:00');
			
			$mulai		= ($waktu_mulai < $jam_start) ? $jam_start : $waktu_mulai;
			$mulai		= ($mulai > $jam_end) ? $jam_end : $waktu_mulai;
			$selesai	= ($waktu_selesai < $jam_start) ? $jam_start : $waktu_selesai;
			$selesai	= ($selesai > $jam_end) ? $jam_end : $waktu_selesai;
			
			if($mulai == $selesai) {
				return "$hari,0,0";
			} else {
				if($mulai < $selesai) {
					$waktu = date_diff($mulai, $selesai);
					if($mulai < $breakStart) {
						if($selesai > $breakEnd) {
							$breakTime	= date_create('01:00');
						} elseif($selesai > $breakStart) {
							$breakTime	= date_diff($selesai, $breakStart);
							$breakTime	= date_create($breakTime->format('%H:%I'));
						}
					} elseif($mulai>$breakStart && $mulai<$breakEnd) {
						if($selesai > $breakEnd) {
							$breakTime	= date_diff($mulai, $breakEnd);
							$breakTime	= date_create($breakTime->format('%H:%I'));
						} elseif($selesai > $breakStart) {
							$waktu		= date_diff($mulai, $mulai);
						}
					}
					$waktu	= date_diff(date_create($waktu->format('%H:%I')), $breakTime);
				} else {
					$dur1	= date_diff($waktu_mulai, $jam_end);
					$dur2	= date_diff($waktu_selesai, $jam_start);
					$waktu	= date_add(date_create($dur1->format("%h:%i")), date_interval_create_from_date_string($dur2->format("%H hours %i minutes")));
					$waktu	= date_diff($waktu, $breakTime);
					
					if($mulai < $breakStart) {
						$breakTime	= date_create('01:00');
					} elseif($mulai > $breakEnd) {
						if($selesai > $breakEnd) {
							$breakTime	= date_create('01:00');
						} elseif($selesai > $breakStart) {
							$breakTime	= date_diff($selesai, $breakStart);
						}
					} else {
						$breakTime	= date_diff($mulai, $breakEnd);
						if($selesai > $breakStart) {
							$breakTime	= date_diff($mulai, $breakEnd);
						}
						$breakTime	= date_create($breakTime->format('%H:%I'));
					}
					$waktu	= date_diff(date_create($waktu->format('%H:%I')), $breakTime);
				}
				return "$hari,$waktu->h,$waktu->i";
			}
		}
		// end durasi
		
		function addDurasi($dur, $add) {
			$add	= explode(',', $add);
			$dur	= explode(',', $dur);
			
			$menit		= ($dur[2] + $add[2]) % 60;
			$jamAdd		= floor(($dur[2] + $add[2]) / 60);
			$jam		= ($dur[1] + $add[1] + $jamAdd) % 8;
			$hariAdd	= floor(($dur[1] + $add[1] + $jamAdd) / 8);
			$hari		= $dur[0] + $add[0] + $hariAdd;
			
			return "$hari,$jam,$menit";
		}
	}
?>