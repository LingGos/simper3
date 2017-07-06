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

class Pegawai extends CI_Controller {

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
        $this->load->model('PegawaiModel');
        $this->load->model('UnitModel');
    }

    public function index() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => $this->getall()
        );
        $this->load->view('main', $data);
    }
    private function getall() {
        return $this->PegawaiModel->getall();   
    }
    public function getallunit() {
        echo json_encode($this->UnitModel->getall());   
    }
    public function simpan() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->input->post('pegID') == null) {
            $dataid=uniqid();
            $data = array('pegID' => $dataid,
                'pegNip' => $this->input->post('pegNip'),
                'pegNama' => $this->input->post('pegNama'),
                'pegUniID' => $this->input->post('pegUniID'),
                'pegNoHP' => $this->input->post('pegNoHP'),
                'pegEmail' => $this->input->post('pegEmail'),
                'pegKet' => $this->input->post('pegKet')
            );
            $this->tambah($data);
            $this->AktifitasPenggunaModel->tambah('C','pegawai',$dataid,'Data Pegawai Berhasil Ditambah');
            redirect('pegawai');
        } else {
            $dataid=$this->input->post('pegID');
            $data = array('pegID' => $dataid,
                'pegNip' => $this->input->post('pegNip'),
                'pegNama' => $this->input->post('pegNama'),
                'pegUniID' => $this->input->post('pegUniID'),
                'pegNoHP' => $this->input->post('pegNoHP'),
                'pegEmail' => $this->input->post('pegEmail'),
                'pegKet' => $this->input->post('pegKet')
            );
            $this->ubahbyid($data);
            $this->AktifitasPenggunaModel->tambah('U','pegawai',$dataid,'Data Pegawai Berhasil Diubah');
            redirect('pegawai');
        }
    }

    private function tambah($data) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->PegawaiModel->tambah($data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Pegawai Berhasil Ditambah !');
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Pegawai Gagal Ditambah !');
        }
    }

    private function ubahbyid($data) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->PegawaiModel->ubahbyid(array('pegID' => $this->input->post('pegID')), $data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Pegawai Berhasil Diubah !');
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Pegawai Gagal Diubah !');
        }
    }

    public function getbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = $this->PegawaiModel->getbyid($id);
        echo json_encode($data);
    }

    public function hapusbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->PegawaiModel->hapusbyid($id) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Pegawai Berhasil Dihapus !');
            $this->AktifitasPenggunaModel->tambah('D','pegawai',$id,'Data Pegawai Berhasil Dihapus');
            echo json_encode(array("status" => TRUE));
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Pegawai Gagal Dihapus !');
            echo json_encode(array("status" => FALSE));
        }
    }

}

?>
