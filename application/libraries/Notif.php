<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Notif {
        protected $ci;

        function __construct() {
            $this->ci =& get_instance();
        }
        
        function klien($data = null) {
            
            $this->ci->load->library('session');
            $this->ci->load->model('M_Permintaan_akuntansi');
            $this->ci->load->model('M_Permintaan_perpajakan');
            $this->ci->load->model('M_Permintaan_lainnya');
            $this->ci->load->model('M_Permintaan_akuntansi');
            $this->ci->load->model('M_Permintaan_perpajakan');
            $this->ci->load->model('M_Pengiriman_lainnya');
			
            $permintaan_akuntansi = $this->ci->load->M_Permintaan_akuntansi->jum_unread();
            $permintaan_perpajakan = $this->ci->load->M_Permintaan_perpajakan->jum_unread();
            $permintaan_lainnya = $this->ci->load->M_Permintaan_lainnya->jum_unread();
            $permintaan_akuntansi = $this->ci->load->M_Pengiriman_akuntansi->jum_unread();
            $permintaan_perpajakan = $this->ci->load->M_Pengiriman_perpajakan->jum_unread();
            $pengiriman_lainnya = $this->ci->load->M_Pengiriman_lainnya->jum_unread();

            $level = $this->ci->session->userdata('level');
            $cek = $this->ci->uri->segment('1');

            if($level == null) {
                redirect('login');
            } else {
                if($level == $cek) {
                    $data['head'] = $this->ci->load->view("{$level}/template/header", $data, TRUE);
                    $data['sidebar'] = $this->ci->load->view("{$level}/template/sidebar", $data, TRUE);
                    $data['content'] = $this->ci->load->view($content, $data, TRUE);
                    $data['foot'] = $this->ci->load->view("{$level}/template/footer", $data, TRUE);
                    
                    $this->ci->load->view('template', $data);
                } else {
                    $redirect = base_url("{$level}");
                    redirect($redirect);
                }
            }
        }
    }
?>