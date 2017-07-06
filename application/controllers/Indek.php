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

class Indek extends CI_Controller {

    private $ACL;
    private $task;

    public function __construct() {
        parent::__construct();
        if (!$this->Konfigurasi->cekSessionAkses()) {
            $this->session->sess_destroy();
            redirect('masuk');
        }
        $this->ACL = array("ROOT" => '*',
            "KASUBAGUMUM" => '*'
        );
        $this->task = strtolower($this->uri->segment(2));
        $this->load->model('IndekModel');
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
        return $this->IndekModel->getall();
    }

    public function simpan() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->input->post('indID') == null) {
            $dataid = uniqid();
            $data = array('indID' => $dataid,
                'indNama' => $this->input->post('indNama'),
                'indKet' => $this->input->post('indKet')
            );
            $this->tambah($data);
            $this->AktifitasPenggunaModel->tambah('C', 'indek', $dataid, 'Data Indek Berhasil Ditambah');
            redirect('indek');
        } else {
            $dataid = $this->input->post('indID');
            $data = array('indID' => $dataid,
                'indNama' => $this->input->post('indNama'),
                'indKet' => $this->input->post('indKet')
            );
            $this->ubahbyid($data);
            $this->AktifitasPenggunaModel->tambah('U', 'indek', $dataid, 'Data Indek Berhasil Diubah');
            redirect('indek');
        }
    }

    private function tambah($data) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->IndekModel->tambah($data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Indek Berhasil Ditambah !');
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Indek Gagal Ditambah !');
        }
    }

    private function ubahbyid($data) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->IndekModel->ubahbyid(array('indID' => $this->input->post('indID')), $data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Indek Berhasil Diubah !');
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Indek Gagal Diubah !');
        }
    }

    public function getbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = $this->IndekModel->getbyid($id);
        echo json_encode($data);
    }

    public function hapusbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->IndekModel->hapusbyid($id) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Indek Berhasil Dihapus !');
            $this->AktifitasPenggunaModel->tambah('D', 'indek', $id, 'Data Indek Berhasil Dihapus');
            echo json_encode(array("status" => TRUE));
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Indek Gagal Dihapus !');
            echo json_encode(array("status" => FALSE));
        }
    }

}

?>
