<?php

    class M_Proses_akuntansi extends CI_model {

        public function getPerMasaTahun($bulan, $tahun) {
            $q = "SELECT * FROM (((proses_akuntansi 
                LEFT JOIN tugas ON tugas.id_tugas = proses_akuntansi.id_tugas) 
                LEFT JOIN (pengiriman_akuntansi 
                LEFT JOIN ((permintaan_akuntansi 
                LEFT JOIN jenis_data ON permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis) 
                LEFT JOIN klien ON permintaan_akuntansi.id_klien = klien.id_klien) 
                ON permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan) 
                ON proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman) 
                LEFT JOIN user ON proses_akuntansi.id_akuntan = user.id_user) 
                WHERE masa = '$bulan' AND tahun = '$tahun' 
                ORDER BY id_proses ASC";
            return $this->db->query($q)->result_array();
        } 

        public function getBelum($bulan, $tahun) {
            $q = "SELECT * FROM (((pengiriman_akuntansi 
                LEFT JOIN ((permintaan_akuntansi 
                LEFT JOIN jenis_data ON permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis) 
                LEFT JOIN klien ON permintaan_akuntansi.id_klien = klien.id_klien) 
                ON permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan) 
                LEFT JOIN tugas ON jenis_data.kode_jenis = tugas.kode_jenis 
                AND klien.status_pekerjaan = tugas.status_pekerjaan) 
                LEFT JOIN (proses_akuntansi 
                LEFT JOIN user ON proses_akuntansi.id_akuntan = user.id_user) 
                ON proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman 
                AND tugas.id_tugas = proses_akuntansi.id_tugas) 
                WHERE masa = '$bulan' AND tahun = '$tahun' 
                AND id_proses IS NULL
                ORDER BY pengiriman_akuntansi.id_pengiriman ASC"; 
            return $this->db->query($q)->result_array();
        }

        public function getSedang($bulan, $tahun) {
            $q = "SELECT * FROM (((pengiriman_akuntansi 
                LEFT JOIN ((permintaan_akuntansi 
                LEFT JOIN jenis_data ON permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis) 
                LEFT JOIN klien ON permintaan_akuntansi.id_klien = klien.id_klien) 
                ON permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan) 
                LEFT JOIN tugas ON jenis_data.kode_jenis = tugas.kode_jenis 
                AND klien.status_pekerjaan = tugas.status_pekerjaan) 
                LEFT JOIN (proses_akuntansi 
                LEFT JOIN user ON proses_akuntansi.id_akuntan = user.id_user) 
                ON proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman 
                AND tugas.id_tugas = proses_akuntansi.id_tugas) 
                WHERE masa = '$bulan' AND tahun = '$tahun' 
                AND id_proses IS NOT NULL AND tanggal_selesai IS NULL
                ORDER BY pengiriman_akuntansi.id_pengiriman ASC"; 
            return $this->db->query($q)->result_array();
        }

        public function getSelesai($bulan, $tahun) {
            $q = "SELECT * FROM (((pengiriman_akuntansi 
                LEFT JOIN ((permintaan_akuntansi 
                LEFT JOIN jenis_data ON permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis) 
                LEFT JOIN klien ON permintaan_akuntansi.id_klien = klien.id_klien) 
                ON permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan) 
                LEFT JOIN tugas ON jenis_data.kode_jenis = tugas.kode_jenis 
                AND klien.status_pekerjaan = tugas.status_pekerjaan) 
                LEFT JOIN (proses_akuntansi 
                LEFT JOIN user ON proses_akuntansi.id_akuntan = user.id_user) 
                ON proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman 
                AND tugas.id_tugas = proses_akuntansi.id_tugas) 
                WHERE masa = '$bulan' AND tahun = '$tahun' 
                AND id_proses IS NOT NULL AND tanggal_selesai IS NOT NULL
                ORDER BY pengiriman_akuntansi.id_pengiriman ASC"; 
            return $this->db->query($q)->result_array();
        }

        public function getByKlienBelum($bulan, $tahun, $klien) {
            $q = "SELECT * FROM (((pengiriman_akuntansi 
                LEFT JOIN ((permintaan_akuntansi 
                LEFT JOIN jenis_data ON permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis) 
                LEFT JOIN klien ON permintaan_akuntansi.id_klien = klien.id_klien) 
                ON permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan) 
                LEFT JOIN tugas ON jenis_data.kode_jenis = tugas.kode_jenis 
                AND klien.status_pekerjaan = tugas.status_pekerjaan) 
                LEFT JOIN (proses_akuntansi 
                LEFT JOIN user ON proses_akuntansi.id_akuntan = user.id_user) 
                ON proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman 
                AND tugas.id_tugas = proses_akuntansi.id_tugas) 
                WHERE masa = '$bulan' AND tahun = '$tahun' 
                AND permintaan_akuntansi.id_klien = '$klien'
                AND id_proses IS NULL
                ORDER BY pengiriman_akuntansi.id_pengiriman ASC"; 
            return $this->db->query($q)->result_array();
        }

        public function getByKlienSedang($bulan, $tahun, $klien) {
            $q = "SELECT * FROM (((pengiriman_akuntansi 
                LEFT JOIN ((permintaan_akuntansi 
                LEFT JOIN jenis_data ON permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis) 
                LEFT JOIN klien ON permintaan_akuntansi.id_klien = klien.id_klien) 
                ON permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan) 
                LEFT JOIN tugas ON jenis_data.kode_jenis = tugas.kode_jenis 
                AND klien.status_pekerjaan = tugas.status_pekerjaan) 
                LEFT JOIN (proses_akuntansi 
                LEFT JOIN user ON proses_akuntansi.id_akuntan = user.id_user) 
                ON proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman 
                AND tugas.id_tugas = proses_akuntansi.id_tugas) 
                WHERE masa = '$bulan' AND tahun = '$tahun' 
                AND permintaan_akuntansi.id_klien = '$klien'
                AND id_proses IS NOT NULL AND tanggal_selesai IS NULL
                ORDER BY pengiriman_akuntansi.id_pengiriman ASC"; 
            return $this->db->query($q)->result_array();
        }

        public function getByKlienSelesai($bulan, $tahun, $klien) {
            $q = "SELECT * FROM (((pengiriman_akuntansi 
                LEFT JOIN ((permintaan_akuntansi 
                LEFT JOIN jenis_data ON permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis) 
                LEFT JOIN klien ON permintaan_akuntansi.id_klien = klien.id_klien) 
                ON permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan) 
                LEFT JOIN tugas ON jenis_data.kode_jenis = tugas.kode_jenis 
                AND klien.status_pekerjaan = tugas.status_pekerjaan) 
                LEFT JOIN (proses_akuntansi 
                LEFT JOIN user ON proses_akuntansi.id_akuntan = user.id_user) 
                ON proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman 
                AND tugas.id_tugas = proses_akuntansi.id_tugas) 
                WHERE masa = '$bulan' AND tahun = '$tahun' 
                AND permintaan_akuntansi.id_klien = '$klien'
                AND id_proses IS NOT NULL AND tanggal_selesai IS NOT NULL
                ORDER BY pengiriman_akuntansi.id_pengiriman ASC"; 
            return $this->db->query($q)->result_array();
        } 

        public function getById($id_proses) {
            $q = "SELECT * FROM (((proses_akuntansi
                LEFT JOIN tugas ON tugas.id_tugas = proses_akuntansi.id_tugas) 
                LEFT JOIN (pengiriman_akuntansi 
                LEFT JOIN ((permintaan_akuntansi 
                LEFT JOIN jenis_data ON permintaan_akuntansi.kode_jenis = jenis_data.kode_jenis) 
                LEFT JOIN klien ON permintaan_akuntansi.id_klien = klien.id_klien) 
                ON permintaan_akuntansi.id_permintaan = pengiriman_akuntansi.id_permintaan) 
                ON proses_akuntansi.id_kirim = pengiriman_akuntansi.id_pengiriman) 
                LEFT JOIN user ON proses_akuntansi.id_akuntan = user.id_user) 
                WHERE id_proses = '$id_proses'";
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
                //('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                // 'September', 'Oktober', 'November', 'Desember');
            );
            return $masa;
        }
        
        public function tambahProses() {

            $id_pengiriman      = $this->input->post('id_pengiriman', true);
            $id_akuntan         = $this->input->post('id_akuntan', true);
            $id_tugas           = $this->input->post('id_tugas', true);
            $tanggal_selesai    = $this->input->post('tanggal_selesai', true);
            $jam_selesai        = $this->input->post('jam_selesai', true);

            $id_tugas   = substr($id_tugas, 3);
            $id_proses  = "{$id_pengiriman}{$id_tugas}{$id_akuntan}";
            $redirect   = "akuntan/proses_akuntansi/mulai/{$id_pengiriman}";

            $flag = 0;
            if($tanggal_selesai != null) {
                if($jam_selesai == null) {
                    $jam_selesai = null;
                    $this->session->set_flashdata('flash', '<b>Jam Selesai</b> harus diisi');
                    redirect($redirect);
                } else {
                    $flag = 1;
                }
            } else {
                $tanggal_selesai = null;
                if($jam_selesai != null) {
                    $this->session->set_flashdata('flash', '<b>Tanggal Selesai</b> harus diisi');
                    redirect($redirect);
                } else {
                    $jam_selesai = null;
                    $flag = 1;
                }
            }

            if($flag == 1) {
                $data = [
                    "id_proses" => $id_proses,
                    "tanggal_mulai" => $this->input->post('tanggal_mulai', true),
                    "jam_mulai" => $this->input->post('jam_mulai', true),
                    "tanggal_selesai" => $tanggal_selesai,
                    "jam_selesai" => $jam_selesai,
                    "id_tugas" => $this->input->post('id_tugas', true),
                    "id_kirim" => $this->input->post('id_pengiriman', true),
                    "id_akuntan" => $this->input->post('id_akuntan', true),
                ];
                $this->db->insert('proses_akuntansi', $data);
            }
        }
        
        public function ubahProses() {
            
            $data = [
                "tanggal_mulai" => $this->input->post('tanggal_mulai', true),
                "jam_mulai" => $this->input->post('jam_mulai', true),
                "tanggal_selesai" => $this->input->post('tanggal_selesai', true),
                "jam_selesai" => $this->input->post('jam_selesai', true),
            ];
            $this->db->where('id_proses', $this->input->post('id_proses', true));
            $this->db->update('proses_akuntansi', $data);
        }
        
        public function hapusProses($id_proses) {

            $this->db->where('id_proses', $id_proses);
            $this->db->delete('proses_akuntansi');
        }
    }
?>