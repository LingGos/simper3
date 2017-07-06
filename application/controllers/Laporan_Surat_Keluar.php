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

class Laporan_Surat_Keluar extends CI_Controller {

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
            "KASUBAGUMUM" => '*'
        );
        $this->task = strtolower($this->uri->segment(2));
        $this->load->model('LaporanModel');
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
            'data_query' => null
        );
        $this->load->view('main', $data);
    }

    public function cetakpdf($jenis, $periode, $tglawal, $tglakhir, $blnawal, $blnakhir, $thnawal, $thnakhir, $thnawal2, $thnakhir2) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }

        $datax = array('jenis' => $jenis, 'periode' => $periode, 'tglawal' => $tglawal, 'tglakhir' => $tglakhir, 'blnawal' => $blnawal,
            'blnakhir' => $blnakhir, 'thnawal' => $thnawal, 'thnakhir' => $thnakhir, 'thnawal2' => $thnawal2, 'thnakhir2' => $thnakhir2, 'kategori' => 'KELUAR'
        );
        if ($jenis == 'ALL') {
            header('Content-Type: text/plain');
            ob_start();
            $data['data'] = $datax;
            $this->load->view('cetak/all_lapsuratmasuk', $data);
            $html = ob_get_contents();
            ob_end_clean();
            require_once('application/libraries/html2pdf/html2pdf.class.php');
            $pdf = new HTML2PDF('L', 'LEGAL', 'en'); //L
            $pdf->setDefaultFont('Arial');
            $pdf->WriteHTML($html);
            $pdf->Output('Tes.pdf', 'I'); //download D
        } else if ($jenis == 'PENTING') {
            header('Content-Type: text/plain');
            ob_start();
            $data['data'] = $datax;
            $this->load->view('cetak/penting_lapsuratmasuk', $data);
            $html = ob_get_contents();
            ob_end_clean();
            require_once('application/libraries/html2pdf/html2pdf.class.php');
            $pdf = new HTML2PDF('L', 'LEGAL', 'en'); //L
            $pdf->setDefaultFont('Arial');
            $pdf->WriteHTML($html);
            $pdf->Output('Tes.pdf', 'I'); //download D
        } else if ($jenis == 'RAHASIA') {
            header('Content-Type: text/plain');
            ob_start();
            $data['data'] = $datax;
            $this->load->view('cetak/rahasia_lapsuratmasuk', $data);
            $html = ob_get_contents();
            ob_end_clean();
            require_once('application/libraries/html2pdf/html2pdf.class.php');
            $pdf = new HTML2PDF('L', 'LEGAL', 'en'); //L
            $pdf->setDefaultFont('Arial');
            $pdf->WriteHTML($html);
            $pdf->Output('Tes.pdf', 'I'); //download D
        } else if ($jenis == 'BIASA') {
            header('Content-Type: text/plain');
            ob_start();
            $data['data'] = $datax;
            $this->load->view('cetak/biasa_lapsuratmasuk', $data);
            $html = ob_get_contents();
            ob_end_clean();
            require_once('application/libraries/html2pdf/html2pdf.class.php');
            $pdf = new HTML2PDF('L', 'LEGAL', 'en'); //L
            $pdf->setDefaultFont('Arial');
            $pdf->WriteHTML($html);
            $pdf->Output('Tes.pdf', 'I'); //download D
        }
    }

    public function cetakexcel($jenis, $periode, $tglawal, $tglakhir, $blnawal, $blnakhir, $thnawal, $thnakhir, $thnawal2, $thnakhir2) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }

        $datax = array('jenis' => $jenis, 'periode' => $periode, 'tglawal' => $tglawal, 'tglakhir' => $tglakhir, 'blnawal' => $blnawal,
            'blnakhir' => $blnakhir, 'thnawal' => $thnawal, 'thnakhir' => $thnakhir, 'thnawal2' => $thnawal2, 'thnakhir2' => $thnakhir2, 'kategori' => 'KELUAR'
        );
        if ($jenis == 'ALL') {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan_Surat_Keluar.xls");
            ob_start();
            $data['data'] = $datax;
            $this->load->view('cetak/all_lapsuratmasuk', $data);
            $html = ob_get_contents();
            ob_end_clean();
            echo $html;
        } else if ($jenis == 'PENTING') {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan_Surat_Keluar.xls");
            ob_start();
            $data['data'] = $datax;
            $this->load->view('cetak/penting_lapsuratmasuk', $data);
            $html = ob_get_contents();
            ob_end_clean();
            echo $html;
        } else if ($jenis == 'RAHASIA') {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan_Surat_Keluar.xls");
            ob_start();
            $data['data'] = $datax;
            $this->load->view('cetak/rahasia_lapsuratmasuk', $data);
            $html = ob_get_contents();
            ob_end_clean();
            echo $html;
        } else if ($jenis == 'BIASA') {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan_Surat_Keluar.xls");
            ob_start();
            $data['data'] = $datax;
            $this->load->view('cetak/biasa_lapsuratmasuk', $data);
            $html = ob_get_contents();
            ob_end_clean();
            echo $html;
        }
    }

    public function cetakchart($jenis, $periode, $tglawal, $tglakhir, $blnawal, $blnakhir, $thnawal, $thnakhir, $thnawal2, $thnakhir2) {
        if (!$this->Konfigurasi->cekModuleAkses($this->ACL, $this->task)) {
            show_404();
        }
        $datax = array('jenis' => $jenis, 'periode' => $periode, 'tglawal' => $tglawal, 'tglakhir' => $tglakhir, 'blnawal' => $blnawal,
            'blnakhir' => $blnakhir, 'thnawal' => $thnawal, 'thnakhir' => $thnakhir, 'thnawal2' => $thnawal2, 'thnakhir2' => $thnakhir2, 'kategori' => 'KELUAR'
        );
        $data = array(
            'bc' => array(strtolower($this->uri->segment(1)), strtolower($this->uri->segment(2)), strtolower($this->uri->segment(3))),
            'view' => strtolower($this->uri->segment(1)),
            'subview' => strtolower($this->uri->segment(2)),
            'subviewid' => strtolower($this->uri->segment(3)),
            'data' => $datax
        );
        $this->load->view('main', $data);
    }

}

?>
