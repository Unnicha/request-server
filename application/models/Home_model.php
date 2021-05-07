<?php

class Home_model extends CI_model {

    public function create_table() {
        
        $fields = array(
                'id_jenis' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '10'
                ),
                'nama_jenis' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '50'
                ),
                'ket' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                )
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_jenis', TRUE);
            $this->dbforge->create_table('tipe', TRUE);
            //echo "Table sudah Dibuat! "; 
        }
        
        public function getAllJenisPerusahaan() {
            //$q = $this->db->get('tipe');
            //return $q->result_array();
            return $this->db->get('tipe')->result_array();
        }

        public function getById($id_jenis) {
            //get_where(); means select * from 'tablename' where
            //row_array take a row
            //return $this->db->get_where('tipe', ['id_jenis' => '$id_jenis'])->row_array();
            return $this->db->query("SELECT * FROM tipe WHERE id_jenis='$id_jenis'")->row_array();
        }

        public function tambahDataJenisPerusahaan() {
            
            $data = [
                "id_jenis" => $this->input->post('id_jenis', true),
                "nama_jenis" => $this->input->post('nama_jenis', true),
                "ket" => $this->input->post('ket', true),
            ];
            $this->db->insert('tipe', $data);
        }

        public function ubahDataJenisPerusahaan($id_jenis)
        {
            $data = [
                "id_jenis" => $this->input->post('id_jenis', true),
                "nama_jenis" => $this->input->post('nama_jenis', true),
                "ket" => $this->input->post('ket', true),
            ];

            $this->db->where('id_jenis', $this->input->post('id_jenis', true));
            $this->db->update('tipe', $data);
        }
        
        public function hapusDataJenisPerusahaan($id_jenis)
        {
            $this->db->where('id_jenis', $id_jenis);
            $this->db->delete('tipe');
        } 
    }
?>