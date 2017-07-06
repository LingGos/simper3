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

class Klasifikasi extends CI_Controller {

    private $ACL;
    private $task;

    public function __construct() {
        parent::__construct();
        if (!$this->Konfigurasi->cekSessionAkses()) {
            $this->session->sess_destroy();
            redirect('masuk');
        }
        $this->ACL = array("ROOT" => '*',
            "KASUBAG/PANMUD" => '*',
            "KASUBAGUMUM" => '*'
        );
        $this->task = strtolower($this->uri->segment(2));
        $this->load->model('KlasifikasiModel');
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
        return $this->KlasifikasiModel->getall();
    }

    public function simpan() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->input->post('klaID') == null) {
            $dataid = uniqid();
            $data = array();
            if ($this->input->post('klaParentID') == null || $this->input->post('klaParentID') == "") {
                $data = array('klaID' => $dataid,
                    'klaParentID' => null,
                    'klaKode' => $this->input->post('klaKode'),
                    'klaNama' => $this->input->post('klaNama'),
                    'klaUraian' => $this->input->post('klaUraian')
                );
            } else {
                $data = array('klaID' => $dataid,
                    'klaParentID' => $this->input->post('klaParentID'),
                    'klaKode' => $this->input->post('klaKode'),
                    'klaNama' => $this->input->post('klaNama'),
                    'klaUraian' => $this->input->post('klaUraian')
                );
            }

            $this->tambah($data);
            $this->AktifitasPenggunaModel->tambah('C', 'klasifikasi', $dataid, 'Data Klasifikasi Berhasil Ditambah');
            redirect('klasifikasi');
        } else {
            $dataid = $this->input->post('klaID');
            $data = array();
            if ($this->input->post('klaParentID') == null || $this->input->post('klaParentID') == "") {
                $data = array('klaID' => $dataid,
                    'klaParentID' => null,
                    'klaKode' => $this->input->post('klaKode'),
                    'klaNama' => $this->input->post('klaNama'),
                    'klaUraian' => $this->input->post('klaUraian')
                );
            } else {
                $data = array('klaID' => $dataid,
                    'klaParentID' => $this->input->post('klaParentID'),
                    'klaKode' => $this->input->post('klaKode'),
                    'klaNama' => $this->input->post('klaNama'),
                    'klaUraian' => $this->input->post('klaUraian')
                );
            }
            $this->ubahbyid($data);
            $this->AktifitasPenggunaModel->tambah('U', 'klasifikasi', $dataid, 'Data Klasifikasi Berhasil Diubah');
            redirect('klasifikasi');
        }
    }

    private function tambah($data) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->KlasifikasiModel->tambah($data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Klasifikasi Berhasil Ditambah !');
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Klasifikasi Gagal Ditambah !');
        }
    }

    private function ubahbyid($data) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->KlasifikasiModel->ubahbyid(array('klaID' => $this->input->post('klaID')), $data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Klasifikasi Berhasil Diubah !');
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Klasifikasi Gagal Diubah !');
        }
    }

    public function getbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = $this->KlasifikasiModel->getbyid($id);
        echo json_encode($data);
    }

    public function hapusbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->KlasifikasiModel->hapusbyid($id) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Klasifikasi Berhasil Dihapus !');
            $this->AktifitasPenggunaModel->tambah('D', 'klasifikasi', $id, 'Data Klasifikasi Berhasil Dihapus');
            echo json_encode(array("status" => TRUE));
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Klasifikasi Gagal Dihapus !');
            echo json_encode(array("status" => FALSE));
        }
    }
    public function getbyidparent($id) {
        $data=$this->KlasifikasiModel->getbyidparent($id);
            if(count($data) > 0){
                $str = "<option value=''>Pilih</option>";
                    foreach ($data as $v){
                        $str .="<option value=".$v->klaID.">".$v->klaKode.' | '.$v->klaNama."</option>";
                    }
                    echo '{"res":{"msg":"'.$str.'"}}';
            }else{
                    $str = "<option value=''>Data Tidak Tersedia</option>";
                    echo '{"res":{"msg":"'.$str.'"}}';
            }
            
    }

}

?>
