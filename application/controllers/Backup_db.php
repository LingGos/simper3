<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of backup_db
 *
 * @author LingGos
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_db extends CI_Controller {

    private $ACL;
    private $task;

    public function __construct() {
        parent::__construct();
        if (!$this->Konfigurasi->cekSessionAkses()) {
            $this->session->sess_destroy();
            redirect('masuk');
        }
        $this->ACL = array("ROOT" => '*'
        );
        $this->task = strtolower($this->uri->segment(2));
    }

    public function index() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        // Load the DB utility class
        $this->load->dbutil();

        // Backup database dan dijadikan variable
        $backup = $this->dbutil->backup();

        // Load file helper dan menulis ke server untuk keperluan restore
        $this->load->helper('file');
        date_default_timezone_set('Asia/Jakarta');
        $pathfile=config_item('APP_ABSOLUTE_PATH').'\_temp\backup_db\db-simper_'.date("d-M-Y_H-i-s").'.zip';
        write_file($pathfile, $backup);
        if(file_exists($pathfile)){
            $this->session->set_flashdata('msg_sukses', 'Basis Data Berhasil Di Back Up !');
            $this->AktifitasPenggunaModel->tambah('R','all','all','Basis Data Berhasil Di Back Up');
        }else{
            $this->session->set_flashdata('msg_eror', 'Basis Data Gagal Di Back Up !');
        }
        redirect('main');
        
    }
}




        
?>
