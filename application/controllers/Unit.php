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

class Unit extends CI_Controller {

    private $ACL;
    private $task;

    public function __construct() {
        parent::__construct();
        if (!$this->Konfigurasi->cekSessionAkses()) {
            $this->session->sess_destroy();
            redirect('masuk');
        }
        $this->ACL = array("ROOT" => '*',
            "PIMPINAN" => array('aa')
        );
        $this->task = strtolower($this->uri->segment(2));
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
        return $this->UnitModel->getall();
    }

    public function simpan() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->input->post('uniID') == null) {
            $dataid = uniqid();
            $data = array('uniID' => $dataid,
                'uniNama' => $this->input->post('uniNama'),
                'uniJenis' => $this->input->post('uniJenis'),
                'uniKet' => $this->input->post('uniKet')
            );
            $this->tambah($data);
            $this->AktifitasPenggunaModel->tambah('C', 'unit', $dataid, 'Data Unit Berhasil Ditambah');
            redirect('unit');
        } else {
            $dataid = $this->input->post('uniID');
            $data = array('uniID' => $dataid,
                'uniNama' => $this->input->post('uniNama'),
                'uniJenis' => $this->input->post('uniJenis'),
                'uniKet' => $this->input->post('uniKet')
            );
            $this->ubahbyid($data);
            $this->AktifitasPenggunaModel->tambah('U', 'unit', $dataid, 'Data Unit Berhasil Diubah');
            redirect('unit');
        }
    }

    private function tambah($data) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->UnitModel->tambah($data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Unit Berhasil Ditambah !');
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Unit Gagal Ditambah !');
        }
    }

    private function ubahbyid($data) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->UnitModel->ubahbyid(array('uniID' => $this->input->post('uniID')), $data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Unit Berhasil Diubah !');
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Unit Gagal Diubah !');
        }
    }

    public function getbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = $this->UnitModel->getbyid($id);
        echo json_encode($data);
    }

    public function hapusbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->UnitModel->hapusbyid($id) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Unit Berhasil Dihapus !');
            $this->AktifitasPenggunaModel->tambah('D', 'unit', $id, 'Data Unit Berhasil Dihapus');
            echo json_encode(array("status" => TRUE));
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Unit Gagal Dihapus !');
            echo json_encode(array("status" => FALSE));
        }
    }

}

?>
