<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pengguna
 *
 * @author LingGos
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

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
        $this->load->model('PenggunaModel');
        $this->load->model('PegawaiModel');
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
        return $this->PenggunaModel->getall();
    }

    public function getpegawaibyid($id) {
        echo json_encode($this->PegawaiModel->getbyid($id));
    }

    public function getallpegawai() {
        echo json_encode($this->PegawaiModel->getall());
    }

    public function simpan() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->input->post('penPassword') != $this->input->post('penPasswordUlang')) {
            $this->session->set_flashdata('msg_eror', 'Data Pengguna Gagal Ditambah, Password Tidak Valid !');
            redirect('pengguna');
            exit();
        }
        if ($this->input->post('penID') == null) {
            $dataid = uniqid();
            $data = array('penID' => $dataid,
                'penPegID' => $this->input->post('penPegID'),
                'penUsername' => $this->input->post('penUsername'),
                'penPassword' => md5($this->input->post('penPassword')),
                'penLevel' => $this->input->post('penLevel'),
                'penStatus' => (($this->input->post('penStatus') == NULL || $this->input->post('penStatus') == "") ? 'N' : 'Y')
            );
            $this->tambah($data);
            $this->AktifitasPenggunaModel->tambah('C', 'pengguna', $dataid, 'Data Pengguna Berhasil Ditambah');
            redirect('pengguna');
        } else {
            $dataid = $this->input->post('penID');
            $data = array();
            if ($this->input->post('penPassword') == null || $this->input->post('penPassword') == "") {
                $data = array('penID' => $dataid,
                    'penLevel' => $this->input->post('penLevel'),
                    'penStatus' => (($this->input->post('penStatus') == NULL || $this->input->post('penStatus') == "") ? 'N' : 'Y')
                );
            } else {
                $data = array('penID' => $dataid,
                    'penUsername' => $this->input->post('penUsername'),
                    'penPassword' => md5($this->input->post('penPassword')),
                    'penLevel' => $this->input->post('penLevel'),
                    'penStatus' => (($this->input->post('penStatus') == NULL || $this->input->post('penStatus') == "") ? 'N' : 'Y')
                );
            }
            $this->ubahbyid($data);
            $this->AktifitasPenggunaModel->tambah('U', 'pengguna', $dataid, 'Data Pengguna Berhasil Diubah');
            redirect('pengguna');
        }
    }

    private function tambah($data) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->PenggunaModel->tambah($data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Pengguna Berhasil Ditambah !');
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Pengguna Gagal Ditambah !');
        }
    }

    private function ubahbyid($data) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->PenggunaModel->ubahbyid(array('penID' => $this->input->post('penID')), $data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Pengguna Berhasil Diubah !');
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Pengguna Gagal Diubah !');
        }
    }

    public function getbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = $this->PenggunaModel->getbyid($id);
        echo json_encode($data);
    }
    public function getbyidforprofil($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = $this->PenggunaModel->getbyidforprofil($id);
        echo json_encode($data);
    }

    public function hapusbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->PenggunaModel->hapusbyid($id) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Pengguna Berhasil Dihapus !');
            $this->AktifitasPenggunaModel->tambah('D', 'pengguna', $id, 'Data Pengguna Berhasil Dihapus');
            echo json_encode(array("status" => TRUE));
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Pengguna Gagal Dihapus !');
            echo json_encode(array("status" => FALSE));
        }
    }
    public function ubahsandi() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->input->post('penPasswordNew') != $this->input->post('penPasswordUlangNew')) {
            $this->session->set_flashdata('msg_eror', 'Sandi Gagal Diubah, Password Baru Tidak Valid !');
            redirect('main');
            exit();
        }
        $sandiLama=$this->PenggunaModel->getbyid($this->input->post('penID'));
        if($sandiLama->penPassword != md5($this->input->post('penPasswordNew'))){
            $this->session->set_flashdata('msg_eror', 'Sandi Gagal Diubah, Password Lama Tidak Valid !');
            redirect('main');
            exit();
        }
        $dataid = $this->input->post('penID');
        $data = array('penID' => $dataid,
                    'penPassword' => md5($this->input->post('penPasswordNew'))
                );
        if ($this->PenggunaModel->ubahbyid(array('penID' => $this->input->post('penID')), $data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Password Berhasil Diubah !');
            $this->AktifitasPenggunaModel->tambah('U', 'pengguna', $dataid, 'Data Pengguna (Sandi) Berhasil Diubah');
            redirect('main');
        } else {
            $this->session->set_flashdata('msg_eror', 'Password Gagal Diubah !');
        }
    }
    public function ubahprofil() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $datapenid = $this->input->post('penID');
        $datapen = array('penID' => $datapenid,
                    'penUsername' => $this->input->post('penUsername')
                );
        $datapegid = $this->input->post('pegID');
        $datapeg = array('pegID' => $datapegid,
                    'pegNama' => $this->input->post('pegNama'),
                    'pegEmail' => $this->input->post('pegEmail'),
                    'pegKet' => $this->input->post('pegKet')
                );
        
        if ($this->PenggunaModel->ubahbyid(array('penID' => $this->input->post('penID')), $datapen) > 0 && $this->PegawaiModel->ubahbyid(array('pegID' => $this->input->post('pegID')), $datapeg) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Profil Berhasil Diubah !');
            $this->AktifitasPenggunaModel->tambah('U', 'pengguna,pegawai', $datapenid, 'Data Pengguna & Pegawai(Profil) Berhasil Diubah');
            redirect('main');
        } else {
            $this->session->set_flashdata('msg_eror', 'Password Gagal Diubah !');
        }
    }

}

?>
