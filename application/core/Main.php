<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Main extends CI_Controller {

        function render_page($content) {
            
            $data = null;
            $level = $this->session->userdata('level');

            $data['header'] = $this->load->view("{$level}/template/header", $data, TRUE);
            $data['content'] = $this->load->view($content, $data, TRUE);
            $data['footer'] = $this->load->view("{$level}/template/footer", $data, TRUE);
            
            $this->load->view('template', $data);
        }
    
    }
?>