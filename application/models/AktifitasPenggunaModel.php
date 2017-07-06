<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class AktifitasPenggunaModel extends CI_Model {
    private $tabel;
    private $tabelID;
    
    public function __construct() {
        $this->tabel='aktifitas_pengguna';
        $this->tabelID='aktID';
    }

    public function tambah($aksi,$tabel,$iddata,$deskripsi) {
        date_default_timezone_set('Asia/Jakarta');
        $data=array('aktID'=>  uniqid(),'aktPenID'=>  $this->session->userdata('masuk_id'),'aktWaktu'=>date('Y-m-d H:i:s'),'aktAksi'=>$aksi,'aktDeskripsi'=>$deskripsi,'aktTabel'=>$tabel,'aktDataID'=>$iddata,'aktIP'=>$_SERVER['REMOTE_ADDR']);
        $this->db->insert($this->tabel,$data);
    }

    public function getall() {
        $query = $this->db->get('aktifitas_pengguna');
        return $query->result();
    }
}   
?>
