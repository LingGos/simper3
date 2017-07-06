<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Masuk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('MasukModel');
    }

    public function index() {
        if ($this->session->userdata('masuk_valid') == TRUE && $this->session->userdata('masuk_id') != "" && $this->session->userdata('masuk_ingat') == 1) {
            redirect('main');
        }
        $this->session->sess_destroy();
        $this->load->view('masuk');
    }

    public function cekmasuk() {
        $user = $this->security->xss_clean($this->input->post('penUsername'));
        $pass = $this->security->xss_clean(md5($this->input->post('penPassword')));
        $ingat = $this->security->xss_clean($this->input->post('penIngat'));
        $query = $this->MasukModel->cek_masuk($user, $pass);
        if (count($query) > 0) {
            $query2 = $this->MasukModel->data_pengguna($query->penPegID);
            $data = array(
                'masuk_id' => $query->penID,
                'masuk_pengguna' => $query->penUsername,
                'masuk_password' => $query->penPassword,
                'masuk_nama' => $query2->pegNama,
                'masuk_level' => $query->penLevel,
                'masuk_ingat' => $ingat,
                'masuk_valid' => true
            );
            $this->session->set_userdata($data);
            $this->AktifitasPenggunaModel->tambah('R','pengguna',$query->penID,'Pengguna Berhasil Masuk');
            redirect('main');
        } else {
            $this->session->set_flashdata("msg_login", "Maaf,ID Atau Password Anda Tidak Benar ! ");
            redirect('masuk');
        }
    }

    public function keluar() {
        $this->session->sess_destroy();
        redirect('masuk');
    }

}

?>
