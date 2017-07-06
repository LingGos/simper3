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

class Disposisi extends CI_Controller {

    private $ACL;
    private $task;
    private $db2;

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
            'JS/JSP' => '*'
        );
        $this->db2 = $this->load->database('db_gateway_papbr', TRUE);
        $this->task = strtolower($this->uri->segment(2));
        $this->load->model('DisposisiModel');
        $this->load->model('SuratMasukModel');
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
            'data_query' => $this->DisposisiModel->getall_byiduser($this->session->userdata('masuk_id')),
            'data_query_masuk' => $this->DisposisiModel->getall_byiduser_masuk($this->session->userdata('masuk_id')),
            'data_query_terkirim' => $this->DisposisiModel->getall_byiduser_terkirim($this->session->userdata('masuk_id'))
        );
        $this->load->view('main', $data);
    }

    public function simpan_disposisi() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $hasil = array();
        $dataid = uniqid();
        $hasil['status'] = true;
        if ($_FILES["disNamaFile"]["name"] != null) {

            if ($_FILES["disNamaFile"]["size"] > 5263380) {
                $hasil['msg'] = 'Data Gagal Di Kirim, Karna File Erorr : Ukuran File Surat Maksimal 5 MB ';
                $hasil['status'] = false;
            } else {
                $filetype = array('application/pdf', 'application/zip', 'application/x-zip', 'application/rar', 'application/x-rar', 'application/msword', 'application/rtf', 'application/vnd.ms-word', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.oasis.opendocument.text', 'application/vnd.oasis.opendocument.spreadsheet');
                if (in_array(strtolower($_FILES["disNamaFile"]["type"]), $filetype)) {
                    $namafile = explode('.', str_replace(' ', '', $_FILES["disNamaFile"]["name"]));
//                    $disNamaFile = $dataid . '_' . str_replace(' ', '', $_FILES["disNamaFile"]["name"]);
                    $disNamaFile = $dataid . '.' .$namafile[1];
                    $path = config_item('APP_PATH_FILE_DISPOSISI');

//                    $config['file_name'] = $dataid . '_' . $namafile[0];
                    $config['file_name'] = $dataid;
                    $config['upload_path'] = "./_temp/disposisi/";
                    $config['allowed_types'] = "*";
                    $config['max_size'] = "5263380";
                    //rename protected function _file_mime_type pada system/libraries/upload.php
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $this->upload->do_upload('disNamaFile');
                    if (!file_exists($path . $disNamaFile)) {
                        $hasil['status'] = false;
                        $hasil['msg'] = 'Data Disposisi Gagal Dikirim, Karna File Erorr : ' + $this->upload->display_errors('<p>', '</p>');
                    } else {
                        $data = array(
                            'disID' => $dataid,
                            'disSumSukID' => $_POST['disSumSukID'],
                            'disBuka' => 'N',
                            'disUraian' => $_POST['disUraian'],
                            'disDariPenID' => $this->session->userdata('masuk_id'),
                            'disKepadaPenID' => $_POST['disKepadaPenID'],
                            'disTgl' => date('Y-m-d H:i:s'),
                            'disNamaFile' => $disNamaFile
                        );
                        if ($this->DisposisiModel->tambah($data) > 0) {
                            $hasil['msg'] = 'Data Disposisi Sukses Dikirim!';
                            //KIRIM NOTIF
                            $disposisi = $this->DisposisiModel->getbyid($dataid);
                            $this->kirim_pesan_notif($disposisi, 'LANJUT');
                        } else {
                            unlink($path . $disNamaFile);
                            $hasil['status'] = false;
                            $hasil['msg'] = 'Data Disposisi Gagal Dikirim!';
                        }
                    }
                } else {
                    $hasil['msg'] = 'Data Gagal Di Kirim, Karna File Erorr : Tidak Memenuhi Standar! ';
                    $hasil['status'] = false;
                }
            }
        } else {
            $data = array(
                'disID' => $dataid,
                'disSumSukID' => $_POST['disSumSukID'],
                'disBuka' => 'N',
                'disUraian' => $_POST['disUraian'],
                'disDariPenID' => $this->session->userdata('masuk_id'),
                'disKepadaPenID' => $_POST['disKepadaPenID'],
                'disTgl' => date('Y-m-d H:i:s'),
                'disNamaFile' => null
            );
            if ($this->DisposisiModel->tambah($data) > 0) {
                $hasil['msg'] = 'Data Disposisi Sukses Dikirim!';
                //KIRIM NOTIF
                $disposisi = $this->DisposisiModel->getbyid($dataid);
                $this->kirim_pesan_notif($disposisi, 'LANJUT');
            } else {
//                unlink($path . $disNamaFile);
                $hasil['status'] = false;
                $hasil['msg'] = 'Data Disposisi Gagal Dikirim!';
            }
        }
        echo json_encode($hasil);
    }

    public function simpan_disposisi2() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $hasil = array();
        $dataid = uniqid();
        $hasil['status'] = true;
        if ($_FILES["disNamaFile2"]["name"] != null) {

            if ($_FILES["disNamaFile2"]["size"] > 5263380) {
                $hasil['msg'] = 'Data Gagal Di Kirim, Karna File Erorr : Ukuran File Surat Maksimal 5 MB ';
                $hasil['status'] = false;
            } else {
                $filetype = array('application/pdf', 'application/zip', 'application/x-zip', 'application/rar', 'application/x-rar', 'application/msword', 'application/rtf', 'application/vnd.ms-word', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.oasis.opendocument.text', 'application/vnd.oasis.opendocument.spreadsheet');
                if (in_array(strtolower($_FILES["disNamaFile2"]["type"]), $filetype)) {
                    $namafile = explode('.', str_replace(' ', '', $_FILES["disNamaFile2"]["name"]));
//                    $disNamaFile = $dataid . '_' . str_replace(' ', '', $_FILES["disNamaFile2"]["name"]);
                    $disNamaFile = $dataid . '.' .$namafile[1];
                    $path = config_item('APP_PATH_FILE_DISPOSISI');

//                    $config['file_name'] = $dataid . '_' . $namafile[0];
                    $config['file_name'] = $dataid;
                    $config['upload_path'] = "./_temp/disposisi/";
                    $config['allowed_types'] = "*";
                    $config['max_size'] = "5263380";
                    //rename protected function _file_mime_type pada system/libraries/upload.php
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $this->upload->do_upload('disNamaFile2');
                    if (!file_exists($path . $disNamaFile)) {
                        $hasil['status'] = false;
                        $hasil['msg'] = 'Data Disposisi Gagal Dikirim, Karna File Erorr : ' + $this->upload->display_errors('<p>', '</p>');
                    } else {
                        $data = array(
                            'disID' => $dataid,
                            'disSumSukID' => $_POST['disSumSukID2'],
                            'disBuka' => 'N',
                            'disUraian' => $_POST['disUraian2'],
                            'disDariPenID' => $this->session->userdata('masuk_id'),
                            'disKepadaPenID' => $_POST['disKepadaPenID2'],
                            'disTgl' => date('Y-m-d H:i:s'),
                            'disNamaFile' => $disNamaFile
                        );
                        $data2 = array(
                            'surTglPenyelesaian' => $this->Konfigurasi->dateToMysql($_POST['surTglPenyelesaian']),
                            'surPelaksanaPenID' => $_POST['disKepadaPenID2']
                        );
                        if ($this->DisposisiModel->tambah($data) > 0 && $this->SuratMasukModel->ubahbyid(array('surID' => $_POST['disSumSukID2']), $data2) > 0) {
                            $hasil['msg'] = 'Data Disposisi Sukses Dikirim!';
                            //KIRIM NOTIF
                            $disposisi = $this->DisposisiModel->getbyid($dataid);
                            $this->kirim_pesan_notif($disposisi, 'LANJUT');
                        } else {
                            unlink($path . $disNamaFile);
                            $hasil['status'] = false;
                            $hasil['msg'] = 'Data Disposisi Gagal Dikirim!';
                        }
                    }
                } else {
                    $hasil['msg'] = 'Data Gagal Di Kirim, Karna File Erorr : Tidak Memenuhi Standar! ';
                    $hasil['status'] = false;
                }
            }
        } else {
            $data = array(
                'disID' => $dataid,
                'disSumSukID' => $_POST['disSumSukID2'],
                'disBuka' => 'N',
                'disUraian' => $_POST['disUraian2'],
                'disDariPenID' => $this->session->userdata('masuk_id'),
                'disKepadaPenID' => $_POST['disKepadaPenID2'],
                'disTgl' => date('Y-m-d H:i:s'),
                'disNamaFile' => null
            );
            $data2 = array(
                'surTglPenyelesaian' => $this->Konfigurasi->dateToMysql($_POST['surTglPenyelesaian']),
                'surPelaksanaPenID' => $_POST['disKepadaPenID2']
            );
            if ($this->DisposisiModel->tambah($data) > 0 && $this->SuratMasukModel->ubahbyid(array('surID' => $_POST['disSumSukID2']), $data2) > 0) {
                $hasil['msg'] = 'Data Disposisi Sukses Dikirim!';
                //KIRIM NOTIF
                $disposisi = $this->DisposisiModel->getbyid($dataid);
                $this->kirim_pesan_notif($disposisi, 'LANJUT');
            } else {
                $hasil['status'] = false;
                $hasil['msg'] = 'Data Disposisi Gagal Dikirim!';
            }
        }
        echo json_encode($hasil);
    }
    
    public function simpan_disposisi3() {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $hasil = array();
        $dataid = uniqid();
        $hasil['status'] = true;
        if ($_FILES["disNamaFile3"]["name"] != null) {

            if ($_FILES["disNamaFile3"]["size"] > 5263380) {
                $hasil['msg'] = 'Data Gagal Di Kirim, Karna File Erorr : Ukuran File Surat Maksimal 5 MB ';
                $hasil['status'] = false;
            } else {
                $filetype = array('application/pdf', 'application/zip', 'application/x-zip', 'application/rar', 'application/x-rar', 'application/msword', 'application/rtf', 'application/vnd.ms-word', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.oasis.opendocument.text', 'application/vnd.oasis.opendocument.spreadsheet');
                if (in_array(strtolower($_FILES["disNamaFile3"]["type"]), $filetype)) {
                    $namafile = explode('.', str_replace(' ', '', $_FILES["disNamaFile3"]["name"]));
//                    $disNamaFile = $dataid . '_' . str_replace(' ', '', $_FILES["disNamaFile2"]["name"]);
                    $disNamaFile = $dataid . '.' .$namafile[1];
                    $path = config_item('APP_PATH_FILE_DISPOSISI');

//                    $config['file_name'] = $dataid . '_' . $namafile[0];
                    $config['file_name'] = $dataid;
                    $config['upload_path'] = "./_temp/disposisi/";
                    $config['allowed_types'] = "*";
                    $config['max_size'] = "5263380";
                    //rename protected function _file_mime_type pada system/libraries/upload.php
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $this->upload->do_upload('disNamaFile3');
                    if (!file_exists($path . $disNamaFile)) {
                        $hasil['status'] = false;
                        $hasil['msg'] = 'Data Disposisi Gagal Dikirim, Karna File Erorr : ' + $this->upload->display_errors('<p>', '</p>');
                    } else {
                        $data = array(
                            'disID' => $dataid,
                            'disSumSukID' => $_POST['disSumSukID3'],
                            'disBuka' => 'N',
                            'disUraian' => $_POST['disUraian3'],
                            'disDariPenID' => $this->session->userdata('masuk_id'),
                            'disKepadaPenID' => $_POST['perKorPenID'],
                            'disTgl' => date('Y-m-d H:i:s'),
                            'disNamaFile' => $disNamaFile
                        );
                        $data2 = array(
                            'surTglPenyelesaian' => $this->Konfigurasi->dateToMysql($_POST['surTglPenyelesaian3']),
                            'surPelaksanaPenID' => $_POST['perKorPenID']
                        );
                        
                        $data3 = array(
                            'perTglTerimaJs' => date('Y-m-d'),
                            'perKorPenID' => $_POST['perKorPenID'],
                            'perJsPegID' => $_POST['perJsPegID'],
                        );
                        if ($this->DisposisiModel->tambah($data) > 0 && $this->SuratMasukModel->ubahbyid(array('surID' => $_POST['disSumSukID3']), $data2) > 0 && $this->SuratMasukModel->ubahbyid_perkara(array('perSurID' => $_POST['disSumSukID3']), $data3) > 0) {
                            $hasil['msg'] = 'Data Disposisi Sukses Dikirim!';
                            //KIRIM NOTIF
                            $disposisi = $this->DisposisiModel->getbyid($dataid);
                            $this->kirim_pesan_notif($disposisi, 'LANJUT');
                        } else {
                            unlink($path . $disNamaFile);
                            $hasil['status'] = false;
                            $hasil['msg'] = 'Data Disposisi Gagal Dikirim!';
                        }
                    }
                } else {
                    $hasil['msg'] = 'Data Gagal Di Kirim, Karna File Erorr : Tidak Memenuhi Standar! ';
                    $hasil['status'] = false;
                }
            }
        } else {
            $data = array(
                            'disID' => $dataid,
                            'disSumSukID' => $_POST['disSumSukID3'],
                            'disBuka' => 'N',
                            'disUraian' => $_POST['disUraian3'],
                            'disDariPenID' => $this->session->userdata('masuk_id'),
                            'disKepadaPenID' => $_POST['perKorPenID'],
                            'disTgl' => date('Y-m-d H:i:s'),
                            'disNamaFile' => null
                        );
            $data2 = array(
                'surTglPenyelesaian' => $this->Konfigurasi->dateToMysql($_POST['surTglPenyelesaian3']),
                'surPelaksanaPenID' => $_POST['perKorPenID']
            );
            $data3 = array(
                'perTglTerimaJs' => date('Y-m-d'),
                'perKorPenID' => $_POST['perKorPenID'],
                'perJsPegID' => $_POST['perJsPegID'],
            );
            if ($this->DisposisiModel->tambah($data) > 0 && $this->SuratMasukModel->ubahbyid(array('surID' => $_POST['disSumSukID3']), $data2) > 0 && $this->SuratMasukModel->ubahbyid_perkara(array('perSurID' => $_POST['disSumSukID3']), $data3) > 0) {
                $hasil['msg'] = 'Data Disposisi Sukses Dikirim!';
                //KIRIM NOTIF
                $disposisi = $this->DisposisiModel->getbyid($dataid);
                $this->kirim_pesan_notif($disposisi, 'LANJUT');
            } else {
                $hasil['status'] = false;
                $hasil['msg'] = 'Data Disposisi Gagal Dikirim!';
            }
        }
        echo json_encode($hasil);
    }
    //oke
    public function cetak_disposisi($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        header('Content-Type: text/plain');
        ob_start();
        $data['surat'] = $this->SuratMasukModel->getbyid($id);
        $data['disposisi'] = $this->DisposisiModel->get_disposisi($id);
        $this->load->view('cetak/kartu_disposisi', $data);
        $html = ob_get_contents();
        ob_end_clean();
        require_once('application/libraries/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('P', 'A4', 'en');
        $pdf->setDefaultFont('Arial');
        $pdf->WriteHTML($html);
        $pdf->Output('Tes.pdf', 'I'); //download D
    }

    public function bukafile_disposisi($file) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $this->load->helper('file');
        $ext = get_mime_by_extension(config_item('APP_PATH_FILE_DISPOSISI') . $file);
        if ($ext == 'application/pdf') {
            $this->output
                    ->set_content_type('application/pdf')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/zip') {
            $this->output
                    ->set_content_type('application/zip')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/x-zip') {
            $this->output
                    ->set_content_type('application/x-zip')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/rar') {
            $this->output
                    ->set_content_type('application/rar')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/x-rar') {
            $this->output
                    ->set_content_type('application/x-rar')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/msword') {
            $this->output
                    ->set_content_type('application/msword')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/rtf') {
            $this->output
                    ->set_content_type('application/rtf')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/vnd.ms-word') {
            $this->output
                    ->set_content_type('application/vnd.ms-word')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            $this->output
                    ->set_content_type('application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/vnd.ms-excel') {
            $this->output
                    ->set_content_type('application/vnd.ms-excel')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            $this->output
                    ->set_content_type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/vnd.ms-powerpoint') {
            $this->output
                    ->set_content_type('application/vnd.ms-powerpoint')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
            $this->output
                    ->set_content_type('application/vnd.openxmlformats-officedocument.presentationml.presentation')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/vnd.oasis.opendocument.text') {
            $this->output
                    ->set_content_type('application/vnd.oasis.opendocument.text')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        } else if ($ext == 'application/vnd.oasis.opendocument.spreadsheet') {
            $this->output
                    ->set_content_type('application/vnd.oasis.opendocument.spreadsheet')
                    ->set_output(file_get_contents(config_item('APP_PATH_FILE_DISPOSISI') . $file));
        }
    }

    public function notifikasi() {
        $this->load->model('DisposisiModel');
        $data = $this->DisposisiModel->get_countnotif($this->session->userdata('masuk_id'));
        $html = '';
        if (count($data) > 0) {
            $html = '<a data-role="hint" data-hint-background="bg-orange" data-hint-color="fg-white" data-hint-mode="2" data-hint="<b>Hai, ' . $this->session->userdata('masuk_nama') . ' ?<br/> Anda Memiliki ' . count($data) . ' Disposisi Masuk</b>" href="' . base_url() . 'disposisi">Disposisi <span class="mif-bell mif-ani-ring"></span>&nbsp;<span class="tag warning" style="border-radius: 10px;margin-top: 20px;">' . count($data) . '</span></a>';
            $html = $html . '<div hidden="hidden"><audio controls="controls" autoplay="autoplay"><source src="' . base_url() . '_temp/sound/sound.mp3" type="audio/mpeg" /><embed src="' . base_url() . '_temp/sound/sound.mp3" /></audio></div>';
        } else {
            $html = '<a href="' . base_url() . 'disposisi">Disposisi </a>';
        }
        echo $html;
    }

    public function hapusbyid($id) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $path = config_item('APP_PATH_FILE_DISPOSISI');
        $disposisi = $this->DisposisiModel->getbyid($id);
        $status = 0;
        if ($this->DisposisiModel->hapusbyid($id) > 0) {
            $status = 1;
            if($disposisi->disNamaFile!=null){
                unlink($path.$disposisi->disNamaFile);
            }
            //KIRIM NOTIF DISPOSISI DITOLAK
            $this->kirim_pesan_notif($disposisi, 'TOLAK');
        }
        $data = array('status' => $status);
        echo json_encode($data);
    }

    public function kirim_pesan_notif($disposisi, $status) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $surat = $this->SuratMasukModel->getbyid($disposisi->disSumSukID);
        $pegawai_dari = $this->PegawaiModel->getbyid($this->PenggunaModel->getbyid($disposisi->disDariPenID)->penPegID);
        $pegawai_kpd = $this->PegawaiModel->getbyid($this->PenggunaModel->getbyid($disposisi->disKepadaPenID)->penPegID);
        $subjek = '[INFO DISPOSISI SURAT PAPBR]';
        $pesan = null;
        $nohp = null;
        $email = null;
        $namaemail = null;
        $waktu = $this->Konfigurasi->getNamaHari(date('Y-m-d'), '-') . ', ' . $this->Konfigurasi->MSQLDateToNormalInUnix(date('Y-m-d')) . ' Pukul ' . date('H:i') . ' WIB.';
        if ($status == 'TOLAK') {
            $this->pesan = 'Assalamualaikum, ' . ucwords($pegawai_dari->pegNama) . '., Disposisi Anda Kepada ' . ucwords($pegawai_kpd->pegNama) . ', Ditolak Pada ' . $waktu . ' Dengan No.Surat : ' . $surat->surNomorSurat . '. Mohon Silahkan Dicek Kembali, Terima Kasih.';
            $this->nohp = $pegawai_dari->pegNoHP;
            $this->email = $pegawai_dari->pegEmail;
            $this->namaemail = $pegawai_dari->pegNama;
        } else {
            $this->pesan = 'Assalamualaikum, ' . ucwords($pegawai_kpd->pegNama) . '., Anda Mendapatkan Disposisi Dari ' . ucwords($pegawai_dari->pegNama) . ', Pada ' . $waktu . ' Dengan No.Surat : ' . $surat->surNomorSurat . '. Mohon Silahkan Dicek, Terima Kasih.';
            $this->nohp = $pegawai_kpd->pegNoHP;
            $this->email = $pegawai_kpd->pegEmail;
            $this->namaemail = $pegawai_kpd->pegNama;
        }
        if (config_item('APP_NOTIF_SMS') == 'Y') {
            $data = array('nohp' => $this->nohp, 'pesan' => $this->pesan);
            $this->DisposisiModel->kirim_pesan_sms($data);
        }
        if (config_item('APP_NOTIF_GMAIL') == 'Y') {
            if ($this->Konfigurasi->cek_koneksi_internet()) {
                require_once(APPPATH . 'libraries/PHPMailer/PHPMailerAutoload.php');
                //Create a new PHPMailer instance
                $mail = new PHPMailer;
                //Tell PHPMailer to use SMTP
                $mail->isSMTP();
                //Enable SMTP debugging
                // 0 = off (for production use)
                // 1 = client messages
                // 2 = client and server messages
                $mail->SMTPDebug = 2;
                //Ask for HTML-friendly debug output
                $mail->Debugoutput = 'html';
                //Set the hostname of the mail server
                $mail->Host = 'smtp.gmail.com';
                // use
                // $mail->Host = gethostbyname('smtp.gmail.com');
                // if your network does not support SMTP over IPv6
                //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
                $mail->Port = 587;
                //Set the encryption system to use - ssl (deprecated) or tls
                $mail->SMTPSecure = 'tls';
                //Whether to use SMTP authentication
                $mail->SMTPAuth = true;
                //Username to use for SMTP authentication - use full email address for gmail
                $mail->Username = config_item('APP_GMAIL_USER');
                //Password to use for SMTP authentication
                $mail->Password = config_item('APP_GMAIL_PASS');
                //Set who the message is to be sent from
                $mail->setFrom(config_item('APP_GMAIL_USER'), 'Admin SIMPER PAPBR');

                //Set an alternative reply-to address
                $mail->addReplyTo(config_item('APP_GMAIL_USER'), 'Admin SIMPER PAPBR');

                //Set who the message is to be sent to
                $mail->addAddress($this->email, ucwords($this->namaemail));

                //Set the subject line
                $mail->Subject = $subjek;

                //Read an HTML message body from an external file, convert referenced images to embedded,
                //convert HTML into a basic plain-text alternative body
                $mail->msgHTML('<p><h3>Pengadilan Agama Pekanbaru Klas 1A</h3><br/><b>' . $this->pesan . '</b></p>');
                //Replace the plain text body with one created manually
                //$mail->AltBody = 'TES SIMPER NOTIFIKASI xxx';
                //Attach an image file
                //$mail->addAttachment('phpmailer_mini.png');
                //send the message, check for errors
                $mail->send();
//            if (!$mail->send()) {
//                echo "Mailer Error: " . $mail->ErrorInfo;
//            } else {
//                echo "Message sent!";
//            }
            }
        }
    }

}

?>
