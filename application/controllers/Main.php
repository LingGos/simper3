<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Main
 *
 * @author LingGos
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    private $ACL;
    private $task;

    public function __construct() {
        parent::__construct();
        if (!$this->Konfigurasi->cekSessionAkses()) {
            $this->session->sess_destroy();
            redirect('masuk');
        }
        $this->ACL = array("ROOT" => '*',
            "PIMPINAN" => '*',
            "SEKRETARIS/PANITERA" => '*',
            "KASUBAG/PANMUD" => '*',
            "KASUBAGUMUM" => '*', 
            "STAFF" => '*',
            "KOORJS" => '*',
            "TAMU" => array('index')
        );
        $this->task = strtolower($this->uri->segment(2));
    }

    public function index() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3))
        );
        
        $this->load->view('main', $data);
//        $this->load->view('main_header', $data);
//        $this->load->view('main_konten', $data);
//        $this->load->view('main_footer', $data);
    }

}

?>
