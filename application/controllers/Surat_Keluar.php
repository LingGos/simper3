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

class Surat_Keluar extends CI_Controller {

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
            "KOORJS"=>'*',
            'JS/JSP'=>'*'
        );
        $this->task = strtolower($this->uri->segment(2));
        $this->load->model('SuratKeluarModel');
        $this->load->model('DisposisiModel');
        require 'application/libraries/fpdf/fpdf.php';
        
    }
    //oke
    public function index() {  
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => $this->SuratKeluarModel->getall($this->session->userdata('masuk_id'))
        );
        $this->load->view('main', $data);
    }
    //oke
    public function tambah_pumum() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => null
        );
        $this->load->view('main', $data);
    }
    public function tambah_ptabayun() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => null
        );
        $this->load->view('main', $data);
    }
    public function tambah_rahasia() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => null
        );
        $this->load->view('main', $data);
    }
    public function tambah_biasa() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => null
        );
        $this->load->view('main', $data);
    }
    //oke
    public function simpan_pumum() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->input->post('surID') == null) {
            $dataid = uniqid();
            if ($_FILES["surFile"]["type"] != 'application/pdf') {
                $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah, Karna File Erorr : Format File Surat Hanya .pdf');
                redirect('surat_masuk');
                exit();
            }
            if ($_FILES["surFile"]["size"] > 5263380) {
                $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah, Karna File Erorr : Ukuran File Surat Maksimal 5 MB ');
                redirect('surat_masuk');
                exit();
            }

            $namafile = explode('.', str_replace(' ', '', $_FILES["surFile"]["name"]));
            $surFile = $dataid . '_' . str_replace(' ', '', $_FILES["surFile"]["name"]);
            $path = config_item('APP_PATH_FILE_SURAT_MASUK');

            $config['file_name'] = $dataid . '_' . $namafile[0];
            $config['upload_path'] = "./_temp/surat_masuk/";
            $config['allowed_types'] = "pdf";
            $config['max_size'] = "5263380";
            //rename protected function _file_mime_type pada system/libraries/upload.php
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('surFile');
            if (!file_exists($path . $surFile)) {
                $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah, Karna File Erorr : ' + $this->upload->display_errors('<p>', '</p>'));
            } else {
                $surTglSurat = explode('.', $this->input->post('surTglSurat'));
                $surTglTerimaKeluar = explode('.', $this->input->post('surTglTerimaKeluar'));
                $data = array('surID' => $dataid,
                    'surKategori' => 'M',
                    'surIndukID' => (($this->input->post('surIndukID') == "") ? null : $this->input->post('surIndukID')),
                    'surIndID' => $this->input->post('surIndID'),
                    'surKlaID' => $this->input->post('surKlaID'),
                    'surKlaID1' => $this->input->post('surKlaID1'),
                    'surKlaID2' => $this->input->post('surKlaID2'),
                    'surNoUrut' => $this->input->post('surNoUrut'),
                    'surTabayun'=>'N',
                    'surJenis' => 'PENTING',
                    'surPerihal' => $this->input->post('surPerihal'),
                    'surRingkas' => $this->input->post('surRingkas'),
                    'surLampiran' => $this->input->post('surLampiran'),
                    'surTglSurat' => $surTglSurat[0] . '-' . $surTglSurat[1] . '-' . $surTglSurat[2],
                    'surNomorSurat' => $this->input->post('surNomorSurat'),
                    'surDari' => $this->input->post('surDari'),
                    'surKepada' => $this->input->post('surKepada'),
                    'surPelaksanaPenID' => null,
                    'surKeamanan' => $this->input->post('surKeamanan'),
                    'surSifat' => $this->input->post('surSifat'),
                    'surPengolahPenID' => $this->session->userdata('masuk_id'),
                    'surJenisFile' => $this->input->post('surJenisFile'),
                    'surFile' => $surFile,
                    'surTglTerimaKeluar' => $surTglTerimaKeluar[0] . '-' . $surTglTerimaKeluar[1] . '-' . $surTglTerimaKeluar[2],
                    'surTglInput' => date('Y-m-d'),
                    'surTglPenyelesaian' => null,
                    'surTglSelesai' => null,
                    'surKet' => $this->input->post('surKet')
                );
                if ($this->SuratMasukModel->tambah($data) > 0) {
                    $data1 = array('telID' => uniqid(),
                    'telSumID' => $dataid,
                    'telPenID' => $this->session->userdata('masuk_id'),
                    'telTentang' => $this->input->post('telTentang'),
                    'telPersoalan' => $this->input->post('telPersoalan'),
                    'telPraanggapan' => $this->input->post('telPraanggapan'),
                    'telFakta' => $this->input->post('telFakta'),
                    'telAnalisis' => $this->input->post('telAnalisis'),
                    'telSimpulan' => $this->input->post('telSimpulan'),
                    'telSaran'=>$this->input->post('telSaran')
                    );
                    if ($this->SuratMasukModel->tambah_telaah_staff($data1) > 0) {
                        $this->session->set_flashdata('msg_sukses', 'Data Surat Berhasil Ditambah !');
                        $this->AktifitasPenggunaModel->tambah('C', 'surat', $dataid, 'Data Surat Masuk Berhasil Ditambah');
                    }else {
                        unlink($path . $surFile);
                        $this->SuratMasukModel->hapusbyid($dataid);
                        $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah !');
                    }
                } else {
                    unlink($path . $surFile);
                    $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah !');
                }
            }
            redirect('surat_masuk');
        } else {
            $dataid = $this->input->post('surID');
            $datasur = $this->SuratMasukModel->getbyid($dataid);

            //cek kondisi
            if ($_FILES["surFile"]["name"] != null || $_FILES["surFile"]["name"] != '') {
                if ($_FILES["surFile"]["type"] != 'application/pdf') {
                    $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah, Karna File Erorr : Format File Surat Hanya .pdf');
                    redirect('surat_masuk');
                    exit();
                }
                if ($_FILES["surFile"]["size"] > 5263380) {
                    $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Dibah, Karna File Erorr : Ukuran File Surat Maksimal 5 MB ');
                    redirect('surat_masuk');
                    exit();
                }

                $namafile = explode('.', str_replace(' ', '', $_FILES["surFile"]["name"]));
                $surFile = $dataid . '_' . str_replace(' ', '', $_FILES["surFile"]["name"]);
                $path = config_item('APP_PATH_FILE_SURAT_MASUK');

                $config['file_name'] = $dataid . '_' . $namafile[0];
                $config['upload_path'] = "./_temp/surat_masuk/";
                $config['allowed_types'] = "pdf";
                $config['max_size'] = "5263380";

                unlink($path . $datasur->surFile); //delete file surat lama
                //rename protected function _file_mime_type pada system/libraries/upload.php
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $this->upload->do_upload('surFile');
                if (!file_exists($path . $surFile)) {
                    $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah, Karna File Erorr : ' + $this->upload->display_errors('<p>', '</p>'));
                } else {
                    $data = array(
                        'surIndukID' => (($this->input->post('surIndukID') == "") ? null : $this->input->post('surIndukID')),
                        'surIndID' => $this->input->post('surIndID'),
                        'surKlaID' => $this->input->post('surKlaID'),
                        'surKlaID1' => $this->input->post('surKlaID1'),
                        'surKlaID2' => $this->input->post('surKlaID2'),
                        'surNoUrut' => $this->input->post('surNoUrut'),
                        'surPerihal' => $this->input->post('surPerihal'),
                        'surRingkas' => $this->input->post('surRingkas'),
                        'surLampiran' => $this->input->post('surLampiran'),
                        'surTglSurat' => $this->Konfigurasi->dateToMysql($this->input->post('surTglSurat')),
                        'surNomorSurat' => $this->input->post('surNomorSurat'),
                        'surDari' => $this->input->post('surDari'),
                        'surKepada' => $this->input->post('surKepada'),
                        'surKeamanan' => $this->input->post('surKeamanan'),
                        'surSifat' => $this->input->post('surSifat'),
                        'surPengolahPenID' => $this->session->userdata('masuk_id'),
                        'surJenisFile' => $this->input->post('surJenisFile'),
                        'surFile' => $surFile,
                        'surTglTerimaKeluar' => $this->Konfigurasi->dateToMysql($this->input->post('surTglTerimaKeluar')),
                        'surKet' => $this->input->post('surKet')
                    );
                    if ($this->SuratMasukModel->ubahbyid(array('surID' => $this->input->post('surID')), $data) > 0) {
                        $data1 = array('telPenID' => $this->session->userdata('masuk_id'),
                            'telTentang' => $this->input->post('telTentang'),
                            'telPersoalan' => $this->input->post('telPersoalan'),
                            'telPraanggapan' => $this->input->post('telPraanggapan'),
                            'telFakta' => $this->input->post('telFakta'),
                            'telAnalisis' => $this->input->post('telAnalisis'),
                            'telSimpulan' => $this->input->post('telSimpulan'),
                            'telSaran'=>$this->input->post('telSaran')
                            );
                        if ($this->SuratMasukModel->ubahbyid_telaah_staff(array('telSumID' => $this->input->post('surID')), $data1) > 0) {
                            $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Berhasil Diubah !');
                            $this->AktifitasPenggunaModel->tambah('U', 'surat', $dataid, 'Data Surat Masuk Berhasil Diubah');
                        }  else {
                            $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Gagal Diubah !');
                        }
                    } else {
                        unlink($path . $surFile);
                        $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah !');
                    }
                }
            } else {
                $data = array(
                        'surIndukID' => (($this->input->post('surIndukID') == "") ? null : $this->input->post('surIndukID')),
                        'surIndID' => $this->input->post('surIndID'),
                        'surKlaID' => $this->input->post('surKlaID'),
                        'surKlaID1' => $this->input->post('surKlaID1'),
                        'surKlaID2' => $this->input->post('surKlaID2'),
                        'surNoUrut' => $this->input->post('surNoUrut'),
                        'surPerihal' => $this->input->post('surPerihal'),
                        'surRingkas' => $this->input->post('surRingkas'),
                        'surLampiran' => $this->input->post('surLampiran'),
                        'surTglSurat' => $this->Konfigurasi->dateToMysql($this->input->post('surTglSurat')),
                        'surNomorSurat' => $this->input->post('surNomorSurat'),
                        'surDari' => $this->input->post('surDari'),
                        'surKepada' => $this->input->post('surKepada'),
                        'surKeamanan' => $this->input->post('surKeamanan'),
                        'surSifat' => $this->input->post('surSifat'),
                        'surPengolahPenID' => $this->session->userdata('masuk_id'),
                        'surJenisFile' => $this->input->post('surJenisFile'),
                        'surTglTerimaKeluar' => $this->Konfigurasi->dateToMysql($this->input->post('surTglTerimaKeluar')),
                        'surKet' => $this->input->post('surKet')
                    );
                if ($this->SuratMasukModel->ubahbyid(array('surID' =>$dataid), $data) > 0) {
                        $data1 = array('telPenID' => $this->session->userdata('masuk_id'),
                            'telTentang' => $this->input->post('telTentang'),
                            'telPersoalan' => $this->input->post('telPersoalan'),
                            'telPraanggapan' => $this->input->post('telPraanggapan'),
                            'telFakta' => $this->input->post('telFakta'),
                            'telAnalisis' => $this->input->post('telAnalisis'),
                            'telSimpulan' => $this->input->post('telSimpulan'),
                            'telSaran'=>$this->input->post('telSaran')
                            );
                        if ($this->SuratMasukModel->ubahbyid_telaah_staff(array('telSumID' => $this->input->post('surID')), $data1) > 0) {
                            $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Berhasil Diubah !');
                            $this->AktifitasPenggunaModel->tambah('U', 'surat', $dataid, 'Data Surat Masuk Berhasil Diubah');
                        }  else {
                            $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Gagal Diubah !');
                        }
                    } else {
                        $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah !');
                    }
            }
            redirect('surat_masuk');
        }
    }
    public function simpan_ptabayun() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->input->post('surID') == null) {
            $dataid = uniqid();
            if ($_FILES["surFile"]["type"] != 'application/pdf') {
                $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah, Karna File Erorr : Format File Surat Hanya .pdf');
                redirect('surat_masuk');
                exit();
            }
            if ($_FILES["surFile"]["size"] > 5263380) {
                $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah, Karna File Erorr : Ukuran File Surat Maksimal 5 MB ');
                redirect('surat_masuk');
                exit();
            }

            $namafile = explode('.', str_replace(' ', '', $_FILES["surFile"]["name"]));
            $surFile = $dataid . '_' . str_replace(' ', '', $_FILES["surFile"]["name"]);
            $path = config_item('APP_PATH_FILE_SURAT_MASUK');

            $config['file_name'] = $dataid . '_' . $namafile[0];
            $config['upload_path'] = "./_temp/surat_masuk/";
            $config['allowed_types'] = "pdf";
            $config['max_size'] = "5263380";
            //rename protected function _file_mime_type pada system/libraries/upload.php
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('surFile');
            if (!file_exists($path . $surFile)) {
                $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah, Karna File Erorr : ' + $this->upload->display_errors('<p>', '</p>'));
            } else {
                $surTglSurat = explode('.', $this->input->post('surTglSurat'));
                $surTglTerimaKeluar = explode('.', $this->input->post('surTglTerimaKeluar'));
                $data = array('surID' => $dataid,
                    'surKategori' => 'M',
                    'surIndukID' => (($this->input->post('surIndukID') == "") ? null : $this->input->post('surIndukID')),
                    'surIndID' => $this->input->post('surIndID'),
                    'surKlaID' => $this->input->post('surKlaID'),
                    'surKlaID1' => $this->input->post('surKlaID1'),
                    'surKlaID2' => $this->input->post('surKlaID2'),
                    'surNoUrut' => $this->input->post('surNoUrut'),
                    'surTabayun'=>'Y',
                    'surJenis' => 'PENTING',
                    'surPerihal' => $this->input->post('surPerihal'),
                    'surRingkas' => $this->input->post('surRingkas'),
                    'surLampiran' => $this->input->post('surLampiran'),
                    'surTglSurat' => $surTglSurat[0] . '-' . $surTglSurat[1] . '-' . $surTglSurat[2],
                    'surNomorSurat' => $this->input->post('surNomorSurat'),
                    'surDari' => $this->input->post('surDari'),
                    'surKepada' => $this->input->post('surKepada'),
                    'surPelaksanaPenID' => null,
                    'surKeamanan' => $this->input->post('surKeamanan'),
                    'surSifat' => $this->input->post('surSifat'),
                    'surPengolahPenID' => $this->session->userdata('masuk_id'),
                    'surJenisFile' => $this->input->post('surJenisFile'),
                    'surFile' => $surFile,
                    'surTglTerimaKeluar' => $surTglTerimaKeluar[0] . '-' . $surTglTerimaKeluar[1] . '-' . $surTglTerimaKeluar[2],
                    'surTglInput' => date('Y-m-d'),
                    'surTglPenyelesaian' => null,
                    'surTglSelesai' => null,
                    'surKet' => $this->input->post('surKet')
                );
                if ($this->SuratMasukModel->tambah($data) > 0) {
                    $data1 = array('perID' => uniqid(),
                    'perSurID' => $dataid,
                    'perNoPerkara' =>$this->input->post('perNoPerkara'),
                    'perJenisRelaas' => $this->input->post('perJenisRelaas'),
                    'perTglPutusSidangInzage' => $this->Konfigurasi->dateToMysql($this->input->post('perTglPutusSidangInzage')),
                    'perJenisIdentitas' => $this->input->post('perJenisIdentitas'),
                    'perNama' => $this->input->post('perNama'),
                    'perKorPenID' =>null,
                    'perJsPenID' => null,
                    'perTglTerimaJs' => null,
                    'perTglPanggil' => null,
                    'perTglSerahRelaas' => null,
                    'perTglKirimRelaas' => null,
                    'perNoResi' => null,
                    'perKet' => $this->input->post('perKet'),
                    'perStatus' => 'terima'
                    );        
                    if($this->SuratMasukModel->tambah_perkara($data1) > 0){
                        $this->session->set_flashdata('msg_sukses', 'Data Surat Berhasil Ditambah !');
                        $this->AktifitasPenggunaModel->tambah('C', 'surat', $dataid, 'Data Surat Masuk Berhasil Ditambah');
                    }else{
                        unlink($path . $surFile);
                        $this->SuratMasukModel->hapusbyid($dataid);
                        $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah !');
                    }
                } else {
                    unlink($path . $surFile);
                    $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah !');
                }
            }
            redirect('surat_masuk');
        } else {
            $dataid = $this->input->post('surID');
            $datasur = $this->SuratMasukModel->getbyid($dataid);

            //cek kondisi
            if ($_FILES["surFile"]["name"] != null || $_FILES["surFile"]["name"] != '') {
                if ($_FILES["surFile"]["type"] != 'application/pdf') {
                    $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah, Karna File Erorr : Format File Surat Hanya .pdf');
                    redirect('surat_masuk');
                    exit();
                }
                if ($_FILES["surFile"]["size"] > 5263380) {
                    $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Dibah, Karna File Erorr : Ukuran File Surat Maksimal 5 MB ');
                    redirect('surat_masuk');
                    exit();
                }

                $namafile = explode('.', str_replace(' ', '', $_FILES["surFile"]["name"]));
                $surFile = $dataid . '_' . str_replace(' ', '', $_FILES["surFile"]["name"]);
                $path = config_item('APP_PATH_FILE_SURAT_MASUK');

                $config['file_name'] = $dataid . '_' . $namafile[0];
                $config['upload_path'] = "./_temp/surat_masuk/";
                $config['allowed_types'] = "pdf";
                $config['max_size'] = "5263380";

                unlink($path . $datasur->surFile); //delete file surat lama
                //rename protected function _file_mime_type pada system/libraries/upload.php
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $this->upload->do_upload('surFile');
                if (!file_exists($path . $surFile)) {
                    $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah, Karna File Erorr : ' + $this->upload->display_errors('<p>', '</p>'));
                } else {
                    $data = array(
                        'surIndukID' => (($this->input->post('surIndukID') == "") ? null : $this->input->post('surIndukID')),
                        'surIndID' => $this->input->post('surIndID'),
                        'surKlaID' => $this->input->post('surKlaID'),
                        'surKlaID1' => $this->input->post('surKlaID1'),
                        'surKlaID2' => $this->input->post('surKlaID2'),
                        'surNoUrut' => $this->input->post('surNoUrut'),
                        'surPerihal' => $this->input->post('surPerihal'),
                        'surRingkas' => $this->input->post('surRingkas'),
                        'surLampiran' => $this->input->post('surLampiran'),
                        'surTglSurat' => $this->Konfigurasi->dateToMysql($this->input->post('surTglSurat')),
                        'surNomorSurat' => $this->input->post('surNomorSurat'),
                        'surDari' => $this->input->post('surDari'),
                        'surKeamanan' => $this->input->post('surKeamanan'),
                        'surSifat' => $this->input->post('surSifat'),
                        'surPengolahPenID' => $this->session->userdata('masuk_id'),
                        'surJenisFile' => $this->input->post('surJenisFile'),
                        'surFile' => $surFile,
                        'surTglTerimaKeluar' => $this->Konfigurasi->dateToMysql($this->input->post('surTglTerimaKeluar')),
                        'surKet' => $this->input->post('surKet')
                    );
                    if ($this->SuratMasukModel->ubahbyid(array('surID' => $this->input->post('surID')), $data) > 0) {
                        $data1 = array(
                            'perNoPerkara' =>$this->input->post('perNoPerkara'),
                            'perJenisRelaas' => $this->input->post('perJenisRelaas'),
                            'perTglPutusSidangInzage' => $this->Konfigurasi->dateToMysql($this->input->post('perTglPutusSidangInzage')),
                            'perJenisIdentitas' => $this->input->post('perJenisIdentitas'),
                            'perNama' => $this->input->post('perNama'),
                            'perKet' => $this->input->post('perKet'),
                            );        
                            if($this->SuratMasukModel->ubahbyid_perkara(array('perSurID' => $this->input->post('surID')), $data1) > 0){
                                $this->session->set_flashdata('msg_sukses', 'Data Surat Berhasil Diubah !');
                                $this->AktifitasPenggunaModel->tambah('U', 'surat', $dataid, 'Data Surat Masuk Berhasil Diubah');
                            }  else {
                                $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah !');
                            }
                    } else {
                        unlink($path . $surFile);
                        $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah !');
                    }
                }
            } else {
                $data = array(
                        'surIndukID' => (($this->input->post('surIndukID') == "") ? null : $this->input->post('surIndukID')),
                        'surIndID' => $this->input->post('surIndID'),
                        'surKlaID' => $this->input->post('surKlaID'),
                        'surKlaID1' => $this->input->post('surKlaID1'),
                        'surKlaID2' => $this->input->post('surKlaID2'),
                        'surNoUrut' => $this->input->post('surNoUrut'),
                        'surPerihal' => $this->input->post('surPerihal'),
                        'surRingkas' => $this->input->post('surRingkas'),
                        'surLampiran' => $this->input->post('surLampiran'),
                        'surTglSurat' => $this->Konfigurasi->dateToMysql($this->input->post('surTglSurat')),
                        'surNomorSurat' => $this->input->post('surNomorSurat'),
                        'surDari' => $this->input->post('surDari'),
                        'surKeamanan' => $this->input->post('surKeamanan'),
                        'surSifat' => $this->input->post('surSifat'),
                        'surPengolahPenID' => $this->session->userdata('masuk_id'),
                        'surJenisFile' => $this->input->post('surJenisFile'),
                        'surTglTerimaKeluar' => $this->Konfigurasi->dateToMysql($this->input->post('surTglTerimaKeluar')),
                        'surKet' => $this->input->post('surKet')
                    );
                    if ($this->SuratMasukModel->ubahbyid(array('surID' => $this->input->post('surID')), $data) > 0) {
                        $data1 = array(
                            'perNoPerkara' =>$this->input->post('perNoPerkara'),
                            'perJenisRelaas' => $this->input->post('perJenisRelaas'),
                            'perTglPutusSidangInzage' => $this->Konfigurasi->dateToMysql($this->input->post('perTglPutusSidangInzage')),
                            'perJenisIdentitas' => $this->input->post('perJenisIdentitas'),
                            'perNama' => $this->input->post('perNama'),
                            'perKet' => $this->input->post('perKet'),
                            );        
                            if($this->SuratMasukModel->ubahbyid_perkara(array('perSurID' => $this->input->post('surID')), $data1) > 0){
                                $this->session->set_flashdata('msg_sukses', 'Data Surat Berhasil Diubah !');
                                $this->AktifitasPenggunaModel->tambah('U', 'surat', $dataid, 'Data Surat Masuk Berhasil Diubah');
                            }  else {
                                $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah !');
                            }
                    } else {
                        $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah !');
                    }
            }
            redirect('surat_masuk');
        }
    }
    public function simpan_rahasia() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->input->post('surID') == null) {
            $dataid = uniqid();
            $data = array('surID' => $dataid,
                'surKategori' => 'M',
                'surIndukID' => (($this->input->post('surIndukID') == "") ? null : $this->input->post('surIndukID')),
                'surIndID' => null,
                'surKlaID' => null,
                'surKlaID1' => null,
                'surKlaID2' => null,
                'surNoUrut' => $this->input->post('surNoUrut'),
                'surTabayun'=>'N',
                'surJenis' => 'RAHASIA',
                'surPerihal' => null,
                'surRingkas' => null,
                'surLampiran' => null,
                'surTglSurat' => null,
                'surNomorSurat' => null,
                'surDari' => $this->input->post('surDari'),
                'surKepada' => $this->input->post('surKepada'),
                'surPelaksanaPenID' => null,
                'surKeamanan' => $this->input->post('surKeamanan'),
                'surSifat' => $this->input->post('surSifat'),
                'surPengolahPenID' => $this->session->userdata('masuk_id'),
                'surJenisFile' => 'HC',
                'surFile' => null,
                'surTglTerimaKeluar' => $this->Konfigurasi->dateToMysql($this->input->post('surTglTerimaKeluar')),
                'surTglInput' => date('Y-m-d'),
                'surTglPenyelesaian' => null,
                'surTglSelesai' => null,
                'surKet' => $this->input->post('surKet')
            );
            if ($this->SuratMasukModel->tambah($data) > 0) {
                $this->session->set_flashdata('msg_sukses', 'Data Surat Berhasil Ditambah !');
                $this->AktifitasPenggunaModel->tambah('C', 'surat', $dataid, 'Data Surat Masuk Berhasil Ditambah');
            } else {
                $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah !');
            }
            redirect('surat_masuk');
        } else {
            $dataid = $this->input->post('surID');
            $data = array(
                'surIndukID' => (($this->input->post('surIndukID') == "") ? null : $this->input->post('surIndukID')),
                'surNoUrut' => $this->input->post('surNoUrut'),
                'surDari' => $this->input->post('surDari'),
                'surKepada' => $this->input->post('surKepada'),
                'surKeamanan' => $this->input->post('surKeamanan'),
                'surSifat' => $this->input->post('surSifat'),
                'surPengolahPenID' => $this->session->userdata('masuk_id'),
                'surTglTerimaKeluar' => $this->Konfigurasi->dateToMysql($this->input->post('surTglTerimaKeluar')),
                'surKet' => $this->input->post('surKet')
                 );
            if ($this->SuratMasukModel->ubahbyid(array('surID' => $dataid), $data) > 0) {
                $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Berhasil Diubah !');
                $this->AktifitasPenggunaModel->tambah('U', 'surat', $dataid, 'Data Surat Masuk Berhasil Diubah');
            } else {
                $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah !');
            }
            redirect('surat_masuk');
        }
    }
    public function simpan_biasa() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        if ($this->input->post('surID') == null) {
            $dataid = uniqid();
                $data = array('surID' => $dataid,
                    'surKategori' => 'M',
                    'surIndukID' => (($this->input->post('surIndukID') == "") ? null : $this->input->post('surIndukID')),
                    'surIndID' => null,
                    'surKlaID' => null,
                    'surKlaID1' => null,
                    'surKlaID2' => null,
                    'surNoUrut' => $this->input->post('surNoUrut'),
                    'surTabayun'=>'N',
                    'surJenis' => 'BIASA',
                    'surPerihal' => $this->input->post('surPerihal'),
                    'surRingkas' => $this->input->post('surRingkas'),
                    'surLampiran' => $this->input->post('surLampiran'),
                    'surTglSurat' =>  $this->Konfigurasi->dateToMysql($this->input->post('surTglSurat')),
                    'surNomorSurat' => $this->input->post('surNomorSurat'),
                    'surDari' => $this->input->post('surDari'),
                    'surKepada' => $this->input->post('surKepada'),
                    'surPelaksanaPenID' => null,
                    'surKeamanan' => $this->input->post('surKeamanan'),
                    'surSifat' => $this->input->post('surSifat'),
                    'surPengolahPenID' => $this->session->userdata('masuk_id'),
                    'surJenisFile' => $this->input->post('surJenisFile'),
                    'surFile' => null,
                    'surTglTerimaKeluar' =>  $this->Konfigurasi->dateToMysql($this->input->post('surTglTerimaKeluar')),
                    'surTglInput' => date('Y-m-d'),
                    'surTglPenyelesaian' => null,
                    'surTglSelesai' => null,
                    'surKet' => $this->input->post('surKet')
                );
                if ($this->SuratMasukModel->tambah($data) > 0) {
                    $this->session->set_flashdata('msg_sukses', 'Data Surat Berhasil Ditambah !');
                    $this->AktifitasPenggunaModel->tambah('C', 'surat', $dataid, 'Data Surat Masuk Berhasil Ditambah');
                } else {
                    $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Ditambah !');
                }
            redirect('surat_masuk');
        } else {
            $dataid = $this->input->post('surID');
            $data = array(
                'surIndukID' => (($this->input->post('surIndukID') == "") ? null : $this->input->post('surIndukID')),
                'surPerihal' => $this->input->post('surPerihal'),
                'surRingkas' => $this->input->post('surRingkas'),
                'surLampiran' => $this->input->post('surLampiran'),
                'surTglSurat' => $this->Konfigurasi->dateToMysql($this->input->post('surTglSurat')),
                'surNomorSurat' => $this->input->post('surNomorSurat'),
                'surDari' => $this->input->post('surDari'),
                'surKepada' => $this->input->post('surKepada'),
                'surKeamanan' => $this->input->post('surKeamanan'),
                'surSifat' => $this->input->post('surSifat'),
                'surPengolahPenID' => $this->session->userdata('masuk_id'),
                'surJenisFile' => $this->input->post('surJenisFile'),
                'surTglTerimaKeluar' => $this->Konfigurasi->dateToMysql($this->input->post('surTglTerimaKeluar')),
                'surKet' => $this->input->post('surKet')
            );
        if ($this->SuratMasukModel->ubahbyid(array('surID' => $dataid), $data) > 0) {
            $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Berhasil Diubah !');
            $this->AktifitasPenggunaModel->tambah('U', 'surat', $dataid, 'Data Surat Masuk Berhasil Diubah');
        } else {
            $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Diubah !');
        }
        redirect('surat_masuk');
        }
    }
    //oke
    public function bukafile($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = $this->SuratMasukModel->getbyid($id);
        $this->output
                ->set_content_type('application/pdf')
                ->set_output(file_get_contents(config_item('APP_PATH_FILE_SURAT_MASUK') . $data->surFile));
    }
    public function getbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = $this->SuratMasukModel->getbyid($id);
        echo json_encode($data);
    }
    public function hapusbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $cekdis = $this->db->query('SELECT * FROM disposisi WHERE disSumSukID=?', array($id));
        if (count($cekdis->row()) > 0) {
            $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Dihapus, Data Memiliki Relasi!');
            echo json_encode(array("status" => FALSE));
        } else {
            $ceksur = $this->db->query('SELECT * FROM surat WHERE surIndukID=?', array($id));
            if(count($ceksur->row()) > 0){
                $this->session->set_flashdata('msg_eror', 'Data Surat Masuk Gagal Dihapus, Data Memiliki Relasi!');
                echo json_encode(array("status" => FALSE));
            }else{
                $data=  $this->SuratMasukModel->getbyid($id);
                if($data->surJenis=='PENTING' && $data->surTabayun=='N'){
                    if($this->SuratMasukModel->hapusbyid($id)>0 && $this->SuratMasukModel->hapusbyid_telaah_staff($id)>0){
                        unlink(config_item('APP_PATH_FILE_SURAT_MASUK') . $data->surFile);
                        $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Berhasil Dihapus !');
                        $this->AktifitasPenggunaModel->tambah('D', 'surat & telaah staff', $id, 'Data Surat Masuk Berhasil Dihapus');
                        echo json_encode(array("status" => TRUE));
                    }  else {
                        $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Gagal Dihapus !');
                        echo json_encode(array("status" => FALSE));
                    }
                }  else if($data->surJenis=='PENTING' && $data->surTabayun=='Y'){
                    if($this->SuratMasukModel->hapusbyid($id)>0 && $this->SuratMasukModel->hapusbyid_perkara($id)>0){
                        unlink(config_item('APP_PATH_FILE_SURAT_MASUK') . $data->surFile);
                        $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Berhasil Dihapus !');
                        $this->AktifitasPenggunaModel->tambah('D', 'surat & perkara', $id, 'Data Surat Masuk Berhasil Dihapus');
                        echo json_encode(array("status" => TRUE));
                    }  else {
                        $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Gagal Dihapus !');
                        echo json_encode(array("status" => FALSE));
                    }
                }else{
                    if($this->SuratMasukModel->hapusbyid($id)>0){
                        $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Berhasil Dihapus !');
                        $this->AktifitasPenggunaModel->tambah('D', 'surat', $id, 'Data Surat Masuk Berhasil Dihapus');
                        echo json_encode(array("status" => TRUE));
                    }  else {
                        $this->session->set_flashdata('msg_sukses', 'Data Surat Masuk Gagal Dihapus !');
                        echo json_encode(array("status" => FALSE));
                    }
                }
            }
        }
    }
    //oke
    public function detail_pumum($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array('disBuka' => 'Y');
        if($this->DisposisiModel->ubahbyid(array('disID' => $id), $data)<0){
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => $this->SuratMasukModel->getbyid($id),
            'data_query2' => $this->SuratMasukModel->getbyid_telaah_staff($id)
        );
        $this->load->view('main', $data);
    }
    public function detail_ptabayun($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }

        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => $this->SuratMasukModel->getbyid($id),
            'data_query2' => $this->SuratMasukModel->getbyid_perkara($id)
        );
        $this->load->view('main', $data);
    }
    public function detail_rahasia($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }

        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => $this->SuratMasukModel->getbyid($id)
        );
        $this->load->view('main', $data);
    }
    public function detail_biasa($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }

        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => $this->SuratMasukModel->getbyid($id)
        );
        $this->load->view('main', $data);
    }
    public function detailx_pumum($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array('disBuka' => 'Y');
        if($this->DisposisiModel->ubahbyid(array('disID' => $id), $data)<0){
            show_404();
        }
        $idsurat=$this->DisposisiModel->getbyid($id)->disSumSukID;
        echo "<script>window.location.href ='". base_url()."surat_masuk/detail_pumum/".$idsurat."';</script>";
    }
    public function detailx_ptabayun($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array('disBuka' => 'Y');
        if($this->DisposisiModel->ubahbyid(array('disID' => $id), $data)<0){
            show_404();
        }
        $idsurat=$this->DisposisiModel->getbyid($id)->disSumSukID;
        echo "<script>window.location.href ='". base_url()."surat_masuk/detail_ptabayun/".$idsurat."';</script>";
    }
    //oke
    public function ubah_pumum($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => $this->SuratMasukModel->getbyid($id),
            'data_query2' => $this->SuratMasukModel->getbyid_telaah_staff($id)
            );
            $this->load->view('main', $data);
    }
    public function ubah_ptabayun($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => $this->SuratMasukModel->getbyid($id),
            'data_query2' => $this->SuratMasukModel->getbyid_perkara($id)
            );
        $this->load->view('main', $data);
    }
    public function ubah_rahasia($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => $this->SuratMasukModel->getbyid($id)
            );
            $this->load->view('main', $data);
    }
    public function ubah_biasa($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data_query' => $this->SuratMasukModel->getbyid($id)
            );
            $this->load->view('main', $data);
    }
    public function cetak_telaah_staff($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        header('Content-Type: application/pdf');
        ob_start();
        $data['ts'] = $this->SuratMasukModel->getbyid_telaah_staff($id);
        $data['ttd'] = array('jabatan'=>$this->UnitModel->getbyid($this->PegawaiModel->getbyid(($this->PenggunaModel->getbyid($data['ts']->telPenID)->penPegID))->pegUniID)->uniNama,'nama'=>  $this->PegawaiModel->getbyid(($this->PenggunaModel->getbyid($data['ts']->telPenID)->penPegID))->pegNama);
        $this->load->view('cetak/telaah_staff', $data);
        $html = ob_get_contents();
        ob_end_clean();
        require_once('application/libraries/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('P','A4','en');
        $pdf->setDefaultFont('Arial');
        $pdf->WriteHTML($html);
        $pdf->Output('Tes.pdf', 'I');//download D
    }
}

?>
