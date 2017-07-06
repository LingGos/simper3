<?php
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');
$ci = &get_instance();
$ci->load->model('Konfigurasi');
$ci->load->model('LaporanModel');

switch ($subview) {
    case 'cetakchart':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Chart Diagram Surat Keluar </h1>
            <hr class="thin bg-orange">
            <?php if ($this->session->flashdata("msg_sukses") != "") { ?>
                <div class="row" id="notif">
                    <div class="padding10 bg-green fg-white text-light"><span class="mif-warning"></span> <?php echo $this->session->flashdata("msg_sukses"); ?></div>
                </div>
            <?php } else if ($this->session->flashdata("msg_eror") != "") { ?>
                <div class="row" id="notif">
                    <div class="padding10 bg-red fg-white text-light"><span class="mif-warning"></span> <?php echo $this->session->flashdata("msg_eror"); ?></div>
                </div>
            <?php } ?>
            <br />
            <?php
            $sql_all = $sql_penting = $sql_biasa = $sql_rahasia = null;
            $where_all = $where_penting = $where_biasa = $where_rahasia = array();
            if ($data['jenis'] == 'ALL') {
                echo '<center><h3>Diagram Jumlah Semua Surat Keluar</h3></center>';
                if ($data['periode'] == 'prh') {
                    $sql_all = 'SELECT surTglTerimaKeluar,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surTglTerimaKeluar >= ? AND surTglTerimaKeluar<=? GROUP BY surTglTerimaKeluar ORDER BY surTglTerimaKeluar ASC';
                    $where_all = array('K', $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglakhir']));
                    $sql_penting = 'SELECT surTglTerimaKeluar,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar >= ? AND surTglTerimaKeluar<=? GROUP BY surTglTerimaKeluar ORDER BY surTglTerimaKeluar ASC';
                    $where_penting = array('K', 'PENTING', $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglakhir']));
                    $sql_biasa = 'SELECT surTglTerimaKeluar,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar >= ? AND surTglTerimaKeluar<=? GROUP BY surTglTerimaKeluar ORDER BY surTglTerimaKeluar ASC';
                    $where_biasa = array('K', 'BIASA', $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglakhir']));
                    $sql_rahasia = 'SELECT surTglTerimaKeluar,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar >= ? AND surTglTerimaKeluar<=? GROUP BY surTglTerimaKeluar ORDER BY surTglTerimaKeluar ASC';
                    $where_rahasia = array('K', 'RAHASIA', $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglakhir']));
                    $sublabel = 'Periode ' . (($data['tglawal'] == $data['tglakhir']) ? $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) : $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) . ' - ' . $ci->Konfigurasi->MSQLDateToNormal($data['tglakhir']));

                    $data_all = $ci->LaporanModel->getDataQuery($sql_all, $where_all);
                    $data_penting = $ci->LaporanModel->getDataQuery($sql_penting, $where_penting);
                    $data_rahasia = $ci->LaporanModel->getDataQuery($sql_rahasia, $where_rahasia);
                    $data_biasa = $ci->LaporanModel->getDataQuery($sql_biasa, $where_biasa);

                    $tglawal = $ci->Konfigurasi->dateToMysql($data['tglawal']);
                    $tglakhir = $ci->Konfigurasi->dateToMysql($data['tglakhir']);
                    $data_tgl = $ci->Konfigurasi->getRentangHari($tglawal, $tglakhir);

                    $data_all_tgl = array();
                    $data_all_jml = array();
                    $i = 0;
                    foreach ($data_all as $v) {
                        $data_all_tgl[$i] = $v->surTglTerimaKeluar;
                        $data_all_jml[$i] = $v->surJml;
                        $i++;
                    }
                    $data_penting_tgl = array();
                    $data_penting_jml = array();
                    $i = 0;
                    foreach ($data_penting as $v) {
                        $data_penting_tgl[$i] = $v->surTglTerimaKeluar;
                        $data_penting_jml[$i] = $v->surJml;
                        $i++;
                    }
                    $data_biasa_tgl = array();
                    $data_biasa_jml = array();
                    $i = 0;
                    foreach ($data_biasa as $v) {
                        $data_biasa_tgl[$i] = $v->surTglTerimaKeluar;
                        $data_biasa_jml[$i] = $v->surJml;
                        $i++;
                    }
                    $data_rahasia_tgl = array();
                    $data_rahasia_jml = array();
                    $i = 0;
                    foreach ($data_rahasia as $v) {
                        $data_rahasia_tgl[$i] = $v->surTglTerimaKeluar;
                        $data_rahasia_jml[$i] = $v->surJml;
                        $i++;
                    }
                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_all = array();
                    $data_surat_salin_penting = array();
                    $data_surat_salin_biasa = array();
                    $data_surat_salin_rahasia = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td>Tanggal :' . date_format(date_create($data_tgl), "d/m/Y") . '</td>';
                        $data_surat_salin_all[$i] = ((in_array($data_tgl, $data_all_tgl)) ? $data_all_jml[array_search($data_tgl, $data_all_tgl)] : 0);
                        $data_surat_salin_penting[$i] = ((in_array($data_tgl, $data_penting_tgl)) ? $data_penting_jml[array_search($data_tgl, $data_penting_tgl)] : 0);
                        $data_surat_salin_biasa[$i] = ((in_array($data_tgl, $data_biasa_tgl)) ? $data_biasa_jml[array_search($data_tgl, $data_biasa_tgl)] : 0);
                        $data_surat_salin_rahasia[$i] = ((in_array($data_tgl, $data_rahasia_tgl)) ? $data_rahasia_jml[array_search($data_tgl, $data_rahasia_tgl)] : 0);

                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :SEMUA</td>';
                    foreach ($data_surat_salin_all as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :PENTING</td>';
                    foreach ($data_surat_salin_penting as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :BIASA</td>';
                    foreach ($data_surat_salin_biasa as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :RAHASIA</td>';
                    foreach ($data_surat_salin_rahasia as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                } else if ($data['periode'] == 'prb') {
                    $sql_all = 'SELECT MONTH(surTglTerimaKeluar) AS bln,YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surTglTerimaKeluar>=? AND surTglTerimaKeluar<=? GROUP BY MONTH(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_all = array('K', $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
                    $sql_penting = 'SELECT MONTH(surTglTerimaKeluar)  AS bln,YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar>=? AND surTglTerimaKeluar<=? GROUP BY MONTH(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_penting = array('K', 'PENTING', $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
                    $sql_biasa = 'SELECT MONTH(surTglTerimaKeluar) AS bln,YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar>=? AND surTglTerimaKeluar<=? GROUP BY MONTH(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_biasa = array('K', 'BIASA', $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
                    $sql_rahasia = 'SELECT MONTH(surTglTerimaKeluar) AS bln,YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar>=? AND surTglTerimaKeluar<=? GROUP BY MONTH(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_rahasia = array('K', 'RAHASIA', $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
                    $sublabel = 'Periode ' . (($data['blnawal'] == $data['blnakhir'] && $data['thnawal'] == $data['thnakhir']) ? $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] : $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] . ' - ' . $ci->Konfigurasi->getNamaBulan($data['blnakhir']) . ' ' . $data['thnakhir']);

                    $data_all = $ci->LaporanModel->getDataQuery($sql_all, $where_all);
                    $data_penting = $ci->LaporanModel->getDataQuery($sql_penting, $where_penting);
                    $data_rahasia = $ci->LaporanModel->getDataQuery($sql_rahasia, $where_rahasia);
                    $data_biasa = $ci->LaporanModel->getDataQuery($sql_biasa, $where_biasa);

                    $tglawal = $data['thnawal'] . '-' . $data['blnawal'];
                    $tglakhir = $data['thnakhir'] . '-' . $data['blnakhir'];
                    $data_tgl = $ci->Konfigurasi->getRentangBulan($tglawal, $tglakhir);

                    $data_all_tgl = array();
                    $data_all_jml = array();
                    $i = 0;
                    foreach ($data_all as $v) {
                        $data_all_tgl[$i] = date_format(date_create($v->thn . '-' . $v->bln), "Y-m");
                        $data_all_jml[$i] = $v->surJml;
                        $i++;
                    }
                    $data_penting_tgl = array();
                    $data_penting_jml = array();
                    $i = 0;
                    foreach ($data_penting as $v) {
                        $data_penting_tgl[$i] = date_format(date_create($v->thn . '-' . $v->bln), "Y-m");
                        $data_penting_jml[$i] = $v->surJml;
                        $i++;
                    }
                    $data_biasa_tgl = array();
                    $data_biasa_jml = array();
                    $i = 0;
                    foreach ($data_biasa as $v) {
                        $data_biasa_tgl[$i] = date_format(date_create($v->thn . '-' . $v->bln), "Y-m");
                        $data_biasa_jml[$i] = $v->surJml;
                        $i++;
                    }
                    $data_rahasia_tgl = array();
                    $data_rahasia_jml = array();
                    $i = 0;
                    foreach ($data_rahasia as $v) {
                        $data_rahasia_tgl[$i] = date_format(date_create($v->thn . '-' . $v->bln), "Y-m");
                        $data_rahasia_jml[$i] = $v->surJml;
                        $i++;
                    }
                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_all = array();
                    $data_surat_salin_penting = array();
                    $data_surat_salin_biasa = array();
                    $data_surat_salin_rahasia = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td><b>Periode :' . $ci->Konfigurasi->getNamaBulanInUnix(substr($data_tgl, 5, 2)) . ' ' . substr($data_tgl, 0, 4) . '</b></td>';
                        $data_surat_salin_all[$i] = ((in_array($data_tgl, $data_all_tgl)) ? $data_all_jml[array_search($data_tgl, $data_all_tgl)] : 0);
                        $data_surat_salin_penting[$i] = ((in_array($data_tgl, $data_penting_tgl)) ? $data_penting_jml[array_search($data_tgl, $data_penting_tgl)] : 0);
                        $data_surat_salin_biasa[$i] = ((in_array($data_tgl, $data_biasa_tgl)) ? $data_biasa_jml[array_search($data_tgl, $data_biasa_tgl)] : 0);
                        $data_surat_salin_rahasia[$i] = ((in_array($data_tgl, $data_rahasia_tgl)) ? $data_rahasia_jml[array_search($data_tgl, $data_rahasia_tgl)] : 0);

                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :SEMUA</td>';
                    foreach ($data_surat_salin_all as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :PENTING</td>';
                    foreach ($data_surat_salin_penting as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :BIASA</td>';
                    foreach ($data_surat_salin_biasa as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :RAHASIA</td>';
                    foreach ($data_surat_salin_rahasia as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                } else if ($data['periode'] == 'prt') {
                    $sql_all = 'SELECT YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND YEAR(surTglTerimaKeluar)>=? AND YEAR(surTglTerimaKeluar)<=? GROUP BY YEAR(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_all = array('K', $data['thnawal2'], $data['thnakhir2']);
                    $sql_penting = 'SELECT YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND YEAR(surTglTerimaKeluar)>=? AND YEAR(surTglTerimaKeluar)<=? GROUP BY YEAR(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_penting = array('K', 'PENTING', $data['thnawal2'], $data['thnakhir2']);
                    $sql_biasa = 'SELECT YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND YEAR(surTglTerimaKeluar)>=? AND YEAR(surTglTerimaKeluar)<=? GROUP BY YEAR(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_biasa = array('K', 'BIASA', $data['thnawal2'], $data['thnakhir2']);
                    $sql_rahasia = 'SELECT YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND YEAR(surTglTerimaKeluar)>=? AND YEAR(surTglTerimaKeluar)<=? GROUP BY YEAR(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_rahasia = array('K', 'RAHASIA', $data['thnawal2'], $data['thnakhir2']);
                    $sublabel = 'Periode Tahun ' . (($data['thnawal2'] == $data['thnakhir2']) ? $data['thnawal2'] : $data['thnawal2'] . ' - ' . $data['thnakhir2']);

                    $data_all = $ci->LaporanModel->getDataQuery($sql_all, $where_all);
                    $data_penting = $ci->LaporanModel->getDataQuery($sql_penting, $where_penting);
                    $data_rahasia = $ci->LaporanModel->getDataQuery($sql_rahasia, $where_rahasia);
                    $data_biasa = $ci->LaporanModel->getDataQuery($sql_biasa, $where_biasa);

                    $tglawal = $data['thnawal2'];
                    $tglakhir = $data['thnakhir2'];
                    $data_tgl = $ci->Konfigurasi->getRentangTahun($tglawal, $tglakhir);

                    $data_all_tgl = array();
                    $data_all_jml = array();
                    $i = 0;
                    foreach ($data_all as $v) {
                        $data_all_tgl[$i] = $v->thn;
                        $data_all_jml[$i] = $v->surJml;
                        $i++;
                    }
                    $data_penting_tgl = array();
                    $data_penting_jml = array();
                    $i = 0;
                    foreach ($data_penting as $v) {
                        $data_penting_tgl[$i] = $v->thn;
                        $data_penting_jml[$i] = $v->surJml;
                        $i++;
                    }
                    $data_biasa_tgl = array();
                    $data_biasa_jml = array();
                    $i = 0;
                    foreach ($data_biasa as $v) {
                        $data_biasa_tgl[$i] = $v->thn;
                        $data_biasa_jml[$i] = $v->surJml;
                        $i++;
                    }
                    $data_rahasia_tgl = array();
                    $data_rahasia_jml = array();
                    $i = 0;
                    foreach ($data_rahasia as $v) {
                        $data_rahasia_tgl[$i] = $v->thn;
                        $data_rahasia_jml[$i] = $v->surJml;
                        $i++;
                    }
                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_all = array();
                    $data_surat_salin_penting = array();
                    $data_surat_salin_biasa = array();
                    $data_surat_salin_rahasia = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td>Tahun :' . $data_tgl . '</td>';
                        $data_surat_salin_all[$i] = ((in_array($data_tgl, $data_all_tgl)) ? $data_all_jml[array_search($data_tgl, $data_all_tgl)] : 0);
                        $data_surat_salin_penting[$i] = ((in_array($data_tgl, $data_penting_tgl)) ? $data_penting_jml[array_search($data_tgl, $data_penting_tgl)] : 0);
                        $data_surat_salin_biasa[$i] = ((in_array($data_tgl, $data_biasa_tgl)) ? $data_biasa_jml[array_search($data_tgl, $data_biasa_tgl)] : 0);
                        $data_surat_salin_rahasia[$i] = ((in_array($data_tgl, $data_rahasia_tgl)) ? $data_rahasia_jml[array_search($data_tgl, $data_rahasia_tgl)] : 0);

                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat:SEMUA</td>';
                    foreach ($data_surat_salin_all as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat:PENTING</td>';
                    foreach ($data_surat_salin_penting as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat:BIASA</td>';
                    foreach ($data_surat_salin_biasa as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat:RAHASIA</td>';
                    foreach ($data_surat_salin_rahasia as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                }
            } else if ($data['jenis'] == 'PENTING') {
                echo '<center><h3>Diagram Jumlah Surat Keluar (Jenis : Penting)</h3></center>';
                if ($data['periode'] == 'prh') {
                    $sql_penting = 'SELECT surTglTerimaKeluar,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar >= ? AND surTglTerimaKeluar<=? GROUP BY surTglTerimaKeluar ORDER BY surTglTerimaKeluar ASC';
                    $where_penting = array('M', 'PENTING', $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglakhir']));
                    $sublabel = 'Periode ' . (($data['tglawal'] == $data['tglakhir']) ? $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) : $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) . ' - ' . $ci->Konfigurasi->MSQLDateToNormal($data['tglakhir']));

                    $data_penting = $ci->LaporanModel->getDataQuery($sql_penting, $where_penting);

                    $tglawal = $ci->Konfigurasi->dateToMysql($data['tglawal']);
                    $tglakhir = $ci->Konfigurasi->dateToMysql($data['tglakhir']);
                    $data_tgl = $ci->Konfigurasi->getRentangHari($tglawal, $tglakhir);

                    $data_penting_tgl = array();
                    $data_penting_jml = array();
                    $i = 0;
                    foreach ($data_penting as $v) {
                        $data_penting_tgl[$i] = $v->surTglTerimaKeluar;
                        $data_penting_jml[$i] = $v->surJml;
                        $i++;
                    }

                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_penting = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td>Tanggal :' . date_format(date_create($data_tgl), "d/m/Y") . '</td>';
                        $data_surat_salin_penting[$i] = ((in_array($data_tgl, $data_penting_tgl)) ? $data_penting_jml[array_search($data_tgl, $data_penting_tgl)] : 0);
                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :PENTING</td>';
                    foreach ($data_surat_salin_penting as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                } else if ($data['periode'] == 'prb') {
                    $sql_penting = 'SELECT MONTH(surTglTerimaKeluar)  AS bln,YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar>=? AND surTglTerimaKeluar<=? GROUP BY MONTH(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_penting = array('K', 'PENTING', $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
                    $sublabel = 'Periode ' . (($data['blnawal'] == $data['blnakhir'] && $data['thnawal'] == $data['thnakhir']) ? $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] : $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] . ' - ' . $ci->Konfigurasi->getNamaBulan($data['blnakhir']) . ' ' . $data['thnakhir']);

                    $data_penting = $ci->LaporanModel->getDataQuery($sql_penting, $where_penting);

                    $tglawal = $data['thnawal'] . '-' . $data['blnawal'];
                    $tglakhir = $data['thnakhir'] . '-' . $data['blnakhir'];
                    $data_tgl = $ci->Konfigurasi->getRentangBulan($tglawal, $tglakhir);

                    $data_penting_tgl = array();
                    $data_penting_jml = array();
                    $i = 0;
                    foreach ($data_penting as $v) {
                        $data_penting_tgl[$i] = date_format(date_create($v->thn . '-' . $v->bln), "Y-m");
                        $data_penting_jml[$i] = $v->surJml;
                        $i++;
                    }
                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_penting = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td><b>Periode :' . $ci->Konfigurasi->getNamaBulanInUnix(substr($data_tgl, 5, 2)) . ' ' . substr($data_tgl, 0, 4) . '</b></td>';
                        $data_surat_salin_penting[$i] = ((in_array($data_tgl, $data_penting_tgl)) ? $data_penting_jml[array_search($data_tgl, $data_penting_tgl)] : 0);
                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :PENTING</td>';
                    foreach ($data_surat_salin_penting as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                } else if ($data['periode'] == 'prt') {
                    $sql_penting = 'SELECT YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND YEAR(surTglTerimaKeluar)>=? AND YEAR(surTglTerimaKeluar)<=? GROUP BY YEAR(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_penting = array('K', 'PENTING', $data['thnawal2'], $data['thnakhir2']);
                    $sublabel = 'Periode Tahun ' . (($data['thnawal2'] == $data['thnakhir2']) ? $data['thnawal2'] : $data['thnawal2'] . ' - ' . $data['thnakhir2']);

                    $data_penting = $ci->LaporanModel->getDataQuery($sql_penting, $where_penting);

                    $tglawal = $data['thnawal2'];
                    $tglakhir = $data['thnakhir2'];
                    $data_tgl = $ci->Konfigurasi->getRentangTahun($tglawal, $tglakhir);

                    $data_penting_tgl = array();
                    $data_penting_jml = array();
                    $i = 0;
                    foreach ($data_penting as $v) {
                        $data_penting_tgl[$i] = $v->thn;
                        $data_penting_jml[$i] = $v->surJml;
                        $i++;
                    }
                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_penting = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td>Tahun :' . $data_tgl . '</td>';
                        $data_surat_salin_penting[$i] = ((in_array($data_tgl, $data_penting_tgl)) ? $data_penting_jml[array_search($data_tgl, $data_penting_tgl)] : 0);
                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat:PENTING</td>';
                    foreach ($data_surat_salin_penting as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                }
            } else if ($data['jenis'] == 'RAHASIA') {
                echo '<center><h3>Diagram Jumlah Surat Keluar (Jenis : Rahasia)</h3></center>';
                if ($data['periode'] == 'prh') {
                    $sql_rahasia = 'SELECT surTglTerimaKeluar,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar >= ? AND surTglTerimaKeluar<=? GROUP BY surTglTerimaKeluar ORDER BY surTglTerimaKeluar ASC';
                    $where_rahasia = array('K', 'RAHASIA', $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglakhir']));
                    $sublabel = 'Periode ' . (($data['tglawal'] == $data['tglakhir']) ? $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) : $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) . ' - ' . $ci->Konfigurasi->MSQLDateToNormal($data['tglakhir']));

                    $data_rahasia = $ci->LaporanModel->getDataQuery($sql_rahasia, $where_rahasia);

                    $tglawal = $ci->Konfigurasi->dateToMysql($data['tglawal']);
                    $tglakhir = $ci->Konfigurasi->dateToMysql($data['tglakhir']);
                    $data_tgl = $ci->Konfigurasi->getRentangHari($tglawal, $tglakhir);

                    $data_rahasia_tgl = array();
                    $data_rahasia_jml = array();
                    $i = 0;
                    foreach ($data_rahasia as $v) {
                        $data_rahasia_tgl[$i] = $v->surTglTerimaKeluar;
                        $data_rahasia_jml[$i] = $v->surJml;
                        $i++;
                    }
                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_rahasia = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td>Tanggal :' . date_format(date_create($data_tgl), "d/m/Y") . '</td>';
                        $data_surat_salin_rahasia[$i] = ((in_array($data_tgl, $data_rahasia_tgl)) ? $data_rahasia_jml[array_search($data_tgl, $data_rahasia_tgl)] : 0);
                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :RAHASIA</td>';
                    foreach ($data_surat_salin_rahasia as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                } else if ($data['periode'] == 'prb') {
                    $sql_rahasia = 'SELECT MONTH(surTglTerimaKeluar) AS bln,YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar>=? AND surTglTerimaKeluar<=? GROUP BY MONTH(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_rahasia = array('K', 'RAHASIA', $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
                    $sublabel = 'Periode ' . (($data['blnawal'] == $data['blnakhir'] && $data['thnawal'] == $data['thnakhir']) ? $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] : $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] . ' - ' . $ci->Konfigurasi->getNamaBulan($data['blnakhir']) . ' ' . $data['thnakhir']);

                    $data_rahasia = $ci->LaporanModel->getDataQuery($sql_rahasia, $where_rahasia);

                    $tglawal = $data['thnawal'] . '-' . $data['blnawal'];
                    $tglakhir = $data['thnakhir'] . '-' . $data['blnakhir'];
                    $data_tgl = $ci->Konfigurasi->getRentangBulan($tglawal, $tglakhir);

                    $data_rahasia_tgl = array();
                    $data_rahasia_jml = array();
                    $i = 0;
                    foreach ($data_rahasia as $v) {
                        $data_rahasia_tgl[$i] = date_format(date_create($v->thn . '-' . $v->bln), "Y-m");
                        $data_rahasia_jml[$i] = $v->surJml;
                        $i++;
                    }
                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_rahasia = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td><b>Periode :' . $ci->Konfigurasi->getNamaBulanInUnix(substr($data_tgl, 5, 2)) . ' ' . substr($data_tgl, 0, 4) . '</b></td>';
                        $data_surat_salin_rahasia[$i] = ((in_array($data_tgl, $data_rahasia_tgl)) ? $data_rahasia_jml[array_search($data_tgl, $data_rahasia_tgl)] : 0);
                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :RAHASIA</td>';
                    foreach ($data_surat_salin_rahasia as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                } else if ($data['periode'] == 'prt') {
                    $sql_rahasia = 'SELECT YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND YEAR(surTglTerimaKeluar)>=? AND YEAR(surTglTerimaKeluar)<=? GROUP BY YEAR(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_rahasia = array('K', 'RAHASIA', $data['thnawal2'], $data['thnakhir2']);
                    $sublabel = 'Periode Tahun ' . (($data['thnawal2'] == $data['thnakhir2']) ? $data['thnawal2'] : $data['thnawal2'] . ' - ' . $data['thnakhir2']);

                    $data_rahasia = $ci->LaporanModel->getDataQuery($sql_rahasia, $where_rahasia);

                    $tglawal = $data['thnawal2'];
                    $tglakhir = $data['thnakhir2'];
                    $data_tgl = $ci->Konfigurasi->getRentangTahun($tglawal, $tglakhir);

                    $data_rahasia_tgl = array();
                    $data_rahasia_jml = array();
                    $i = 0;
                    foreach ($data_rahasia as $v) {
                        $data_rahasia_tgl[$i] = $v->thn;
                        $data_rahasia_jml[$i] = $v->surJml;
                        $i++;
                    }
                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_rahasia = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td>Tahun :' . $data_tgl . '</td>';
                        $data_surat_salin_rahasia[$i] = ((in_array($data_tgl, $data_rahasia_tgl)) ? $data_rahasia_jml[array_search($data_tgl, $data_rahasia_tgl)] : 0);
                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat:RAHASIA</td>';
                    foreach ($data_surat_salin_rahasia as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                }
            } else if ($data['jenis'] == 'BIASA') {
                echo '<center><h3>Diagram Jumlah Surat Keluar (Jenis : Biasa)</h3></center>';
                if ($data['periode'] == 'prh') {
                    $sql_biasa = 'SELECT surTglTerimaKeluar,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar >= ? AND surTglTerimaKeluar<=? GROUP BY surTglTerimaKeluar ORDER BY surTglTerimaKeluar ASC';
                    $where_biasa = array('K', 'BIASA', $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglakhir']));
                    $sublabel = 'Periode ' . (($data['tglawal'] == $data['tglakhir']) ? $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) : $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) . ' - ' . $ci->Konfigurasi->MSQLDateToNormal($data['tglakhir']));

                    $data_biasa = $ci->LaporanModel->getDataQuery($sql_biasa, $where_biasa);

                    $tglawal = $ci->Konfigurasi->dateToMysql($data['tglawal']);
                    $tglakhir = $ci->Konfigurasi->dateToMysql($data['tglakhir']);
                    $data_tgl = $ci->Konfigurasi->getRentangHari($tglawal, $tglakhir);

                    $data_biasa_tgl = array();
                    $data_biasa_jml = array();
                    $i = 0;
                    foreach ($data_biasa as $v) {
                        $data_biasa_tgl[$i] = $v->surTglTerimaKeluar;
                        $data_biasa_jml[$i] = $v->surJml;
                        $i++;
                    }
                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_biasa = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td>Tanggal :' . date_format(date_create($data_tgl), "d/m/Y") . '</td>';
                        $data_surat_salin_biasa[$i] = ((in_array($data_tgl, $data_biasa_tgl)) ? $data_biasa_jml[array_search($data_tgl, $data_biasa_tgl)] : 0);
                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :BIASA</td>';
                    foreach ($data_surat_salin_biasa as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                } else if ($data['periode'] == 'prb') {
                    $sql_biasa = 'SELECT MONTH(surTglTerimaKeluar) AS bln,YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar>=? AND surTglTerimaKeluar<=? GROUP BY MONTH(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_biasa = array('K', 'BIASA', $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
                    $sublabel = 'Periode ' . (($data['blnawal'] == $data['blnakhir'] && $data['thnawal'] == $data['thnakhir']) ? $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] : $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] . ' - ' . $ci->Konfigurasi->getNamaBulan($data['blnakhir']) . ' ' . $data['thnakhir']);

                    $data_biasa = $ci->LaporanModel->getDataQuery($sql_biasa, $where_biasa);

                    $tglawal = $data['thnawal'] . '-' . $data['blnawal'];
                    $tglakhir = $data['thnakhir'] . '-' . $data['blnakhir'];
                    $data_tgl = $ci->Konfigurasi->getRentangBulan($tglawal, $tglakhir);

                    $data_biasa_tgl = array();
                    $data_biasa_jml = array();
                    $i = 0;
                    foreach ($data_biasa as $v) {
                        $data_biasa_tgl[$i] = date_format(date_create($v->thn . '-' . $v->bln), "Y-m");
                        $data_biasa_jml[$i] = $v->surJml;
                        $i++;
                    }
                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_biasa = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td><b>Periode :' . $ci->Konfigurasi->getNamaBulanInUnix(substr($data_tgl, 5, 2)) . ' ' . substr($data_tgl, 0, 4) . '</b></td>';
                        $data_surat_salin_biasa[$i] = ((in_array($data_tgl, $data_biasa_tgl)) ? $data_biasa_jml[array_search($data_tgl, $data_biasa_tgl)] : 0);
                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat :BIASA</td>';
                    foreach ($data_surat_salin_biasa as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                } else if ($data['periode'] == 'prt') {
                    $sql_biasa = 'SELECT YEAR(surTglTerimaKeluar) AS thn,COUNT(*) AS surJml FROM surat WHERE surKategori=? AND surJenis=? AND YEAR(surTglTerimaKeluar)>=? AND YEAR(surTglTerimaKeluar)<=? GROUP BY YEAR(surTglTerimaKeluar) ORDER BY surTglTerimaKeluar ASC';
                    $where_biasa = array('K', 'BIASA', $data['thnawal2'], $data['thnakhir2']);
                    $sublabel = 'Periode Tahun ' . (($data['thnawal2'] == $data['thnakhir2']) ? $data['thnawal2'] : $data['thnawal2'] . ' - ' . $data['thnakhir2']);

                    $data_biasa = $ci->LaporanModel->getDataQuery($sql_biasa, $where_biasa);

                    $tglawal = $data['thnawal2'];
                    $tglakhir = $data['thnakhir2'];
                    $data_tgl = $ci->Konfigurasi->getRentangTahun($tglawal, $tglakhir);

                    $data_biasa_tgl = array();
                    $data_biasa_jml = array();
                    $i = 0;
                    foreach ($data_biasa as $v) {
                        $data_biasa_tgl[$i] = $v->thn;
                        $data_biasa_jml[$i] = $v->surJml;
                        $i++;
                    }
                    echo '<center><h4>' . $sublabel . '</h4></center>';
                    echo '<table id="surma" style="display: none;">';
                    echo '<tr>';
                    echo '<td>Jml Surat : </td>';
                    $data_surat_salin_biasa = array();
                    $i = 0;
                    foreach ($data_tgl as $data_tgl) {
                        echo '<td>Tahun :' . $data_tgl . '</td>';
                        $data_surat_salin_biasa[$i] = ((in_array($data_tgl, $data_biasa_tgl)) ? $data_biasa_jml[array_search($data_tgl, $data_biasa_tgl)] : 0);
                        $i++;
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Jenis Surat:BIASA</td>';
                    foreach ($data_surat_salin_biasa as $v) {
                        echo '<td>' . $v . '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                }
            }
            ?>
            <script src="<?php echo base_url(); ?>asset/js/chart/fusioncharts/jquery-1.4.js"></script>
            <script src="<?php echo base_url(); ?>asset/js/chart/fusioncharts/jquery.fusioncharts.js"></script>
            <script>
                $('#surma').convertToFusionCharts({
                    swfPath: "<?php echo base_url(); ?>asset/js/chart/fusioncharts/Charts/",
                    type: "MSColumn3D",
                    width: "1200",
                    height: "450",
                    dataFormat: "HTMLTable",
                });
            </script>
        </div>
        <?php
        break;
    default:
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Laporan Surat Keluar </h1>
            <hr class="thin bg-orange">
            <?php if ($this->session->flashdata("msg_sukses") != "") { ?>
                <div class="row" id="notif">
                    <div class="padding10 bg-green fg-white text-light"><span class="mif-warning"></span> <?php echo $this->session->flashdata("msg_sukses"); ?></div>
                </div>
            <?php } else if ($this->session->flashdata("msg_eror") != "") { ?>
                <div class="row" id="notif">
                    <div class="padding10 bg-red fg-white text-light"><span class="mif-warning"></span> <?php echo $this->session->flashdata("msg_eror"); ?></div>
                </div>
            <?php } ?>
            <br />
            <div class="row grid">
                <div class="row cells12 no-margin">
                    <div class="cell colspan2 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis Surat </label><label class="fg-red">*</label></div>
                    <div class="cell colspan4">
                        <div class="input-control success full-size">
                            <select class="js-select full-size" name="lapJenis">
                                <option value="ALL" selected>Semua</option>
                                <option value="PENTING">Penting</option>
                                <option value="RAHASIA">Rahasia</option>
                                <option value="BIASA">Biasa</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row cells12 no-margin">
                    <div class="cell colspan2 bg-green fg-white padding10" style="margin-top: 5px;"><label>Periode Laporan </label><label class="fg-red">*</label></div>
                    <div class="cell colspan4">
                        <div class="input-control success full-size">
                            <select class="js-select full-size" name="lapPeriode">
                                <option value="prh">Per Rentang Hari</option>
                                <option value="prb">Per Rentang Bulan</option>
                                <option value="prt">Per Rentang Tahun</option>
                            </select>
                            <span class="input-state-error mif-warning"></span>
                        </div>
                    </div>
                </div>
                <div class="row cells12 no-margin selector-prh" style="">
                    <div class="cell colspan2 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal </label><label class="fg-red">*</label></div>
                    <div class="cell colspan2">
                        <div class="input-control text success full-size" data-role="datepicker">
                            <input type="text" name="lapTglAwal" value="<?php echo date('Y.m.d'); ?>">
                            <button class="button"><span class="mif-calendar"></span></button>
                        </div>
                    </div>
                    <div class="cell colspan1" style="margin-top: 14px;"><center><b>S/D</b></center></div>
                    <div class="cell colspan2">
                        <div class="input-control text success full-size" data-role="datepicker">
                            <input type="text" name="lapTglAkhir" value="<?php echo date('Y.m.d'); ?>">
                            <button class="button"><span class="mif-calendar"></span></button>
                        </div>
                    </div>
                </div>
                <div class="row cells12 no-margin selector-prb" style="display: none;">
                    <div class="cell colspan2 bg-green fg-white padding10" style="margin-top: 5px;"><label>Bulan & Tahun </label><label class="fg-red">*</label></div>
                    <div class="cell colspan1">
                        <div class="input-control success full-size">
                            <select class="full-size js-select" name="lapBulanAwal">
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    echo'<option value="' . $i . '" ' . (($i == intval(date('m'))) ? "selected" : "") . '>' . $ci->Konfigurasi->getNamaBulan($i) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell colspan1">
                        <div class="input-control success full-size">
                            <select class="full-size js-select" name="lapTahunAwal">
                                <?php
                                for ($i = (intval(date('Y')) - 20); $i <= intval(date('Y')); $i++) {
                                    echo'<option value="' . $i . '" ' . (($i == intval(date('Y'))) ? "selected" : "") . '>' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell colspan1" style="margin-top: 14px;"><center><b>S/D</b></center></div>
                    <div class="cell colspan1">
                        <div class="input-control success full-size">
                            <select class="full-size js-select" name="lapBulanAkhir">
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    echo'<option value="' . $i . '" ' . (($i == intval(date('m'))) ? "selected" : "") . '>' . $ci->Konfigurasi->getNamaBulan($i) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell colspan1">
                        <div class="input-control success full-size">
                            <select class="full-size js-select" name="lapTahunAkhir">
                                <?php
                                for ($i = (intval(date('Y')) - 20); $i <= intval(date('Y')); $i++) {
                                    echo'<option value="' . $i . '" ' . (($i == intval(date('Y'))) ? "selected" : "") . '>' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row cells12 no-margin selector-prt" style="display: none;">
                    <div class="cell colspan2 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tahun </label><label class="fg-red">*</label></div>
                    <div class="cell colspan1">
                        <div class="input-control success full-size">
                            <select class="full-size js-select" name="lapTahun2Awal">
                                <?php
                                for ($i = (intval(date('Y')) - 20); $i <= intval(date('Y')); $i++) {
                                    echo'<option value="' . $i . '" ' . (($i == intval(date('Y'))) ? "selected" : "") . '>' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell colspan1" style="margin-top: 14px;"><center><b>S/D</b></center></div>
                    <div class="cell colspan1">
                        <div class="input-control success full-size">
                            <select class="full-size js-select" name="lapTahun2Akhir">
                                <?php
                                for ($i = (intval(date('Y')) - 20); $i <= intval(date('Y')); $i++) {
                                    echo'<option value="' . $i . '" ' . (($i == intval(date('Y'))) ? "selected" : "") . '>' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                <div class="row cells12" id="btnFormUnit">
                    <div class="cell colspan2"></div>
                    <div class="cell colspan10 place-right">
                        <a target="_blank" data-uri="<?php echo base_url() . $view; ?>/cetakpdf" class="button success pdf"><span class="mif-file-pdf"></span> Export PDF</a>
                        <a target="_blank" data-uri="<?php echo base_url() . $view; ?>/cetakexcel" class="button info excel"><span class="mif-file-excel"></span> Export Excel</a>
                        <a data-uri="<?php echo base_url() . $view; ?>/cetakchart" class="button warning chart"><span class="mif-chart-bars2"></span> Chart</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#notif").fadeOut(7000);

        $('select[name=lapTahun]').on("change", function() {
            var id = $(this).val();
            if (id == "" || id == null) {
                $("select[name=labBulan]").html("<option value=''>Pilih Periode Tahun Dahulu</option>");
                $("select[name=lapTahun]").focus();
            } else if (id == "ALL" || id === 'ALL') {
                $("select[name=lapBulan]").html("<option value='ALL'>Semua</option>");
                $("select[name=lapType]").focus();
            } else {
                var html = '<option value="ALL">Semua</option><option value="01">Januari</option><option value="02">Februari</option><option value="03">Maret</option><option value="04">April</option><option value="05">Mei</option><option value="06">Juni</option><option value="07">Juli</option><option value="08">Agustus</option><option value="09">September</option><option value="10">Oktober</option><option value="11">November</option><option value="12">Desember</option>';
                $("select[name=lapBulan]").html(html);
                $("select[name=lapBulan]").focus();
            }
        });
        $(function() {
            $arr = ['pdf', 'excel', 'chart'];
            $.each($arr, function(i, v) {
                $("." + v).on("click", function() {
                    validate($(this).data("uri"));
                });
            });

        });
        $('select[name=lapPeriode]').on("change", function() {
            if ($(this).val() == 'prh') {
                $(".selector-prh").show("slow", function() {
                });
                $(".selector-prb").hide("slow", function() {
                });
                $(".selector-prt").hide("slow", function() {
                });
            } else if ($(this).val() == 'prb') {
                $(".selector-prb").show("slow", function() {
                });
                $(".selector-prh").hide("slow", function() {
                });
                $(".selector-prt").hide("slow", function() {
                });
            } else if ($(this).val() == 'prt') {
                $(".selector-prt").show("slow", function() {
                });
                $(".selector-prb").hide("slow", function() {
                });
                $(".selector-prh").hide("slow", function() {
                });
            }
        });
        function validate(ref) {
            //ex code :$("#jenis").attr("style", "box-shadow:rgba(255, 0, 0, 0.76) 0px 0px 2px 1px !important");
            var res = true;
            var jenis = $('select[name=lapJenis]').val();
            var periode = $('select[name=lapPeriode]').val();
            var lapTglAwal = $('[name="lapTglAwal"]').val();
            var lapTglAkhir = $('[name="lapTglAkhir"]').val();
            var lapBulanAwal = $('select[name=lapBulanAwal]').val();
            var lapBulanAkhir = $('select[name=lapBulanAkhir]').val();
            var lapTahunAwal = $('select[name=lapTahunAwal]').val();
            var lapTahunAkhir = $('select[name=lapTahunAkhir]').val();
            var lapTahun2Awal = $('select[name=lapTahun2Awal]').val();
            var lapTahun2Akhir = $('select[name=lapTahun2Akhir]').val();

            if (!jenis || !periode) {
                res = false;
            }
            if (periode == 'prh' && !lapTglAwal && lapTglAwal && !lapTglAkhir) {
                res = false;
            }
            if (periode == 'prb' && !lapBulanAwal && !lapBulanAkhir && !lapTahunAwal && !lapTahunAkhir) {
                res = false;
            }
            if (periode == 'prt' && !lapTahun2Awal && !lapTahun2Akhir) {
                res = false;
            }

            if (res) {
                // URL-->tahun/bulan/jenis/proyek/tipe/karyawan
                window.open(ref + "/" + jenis + "/" + periode + "/" + lapTglAwal + "/" + lapTglAkhir + "/" + lapBulanAwal + "/" + lapBulanAkhir + "/" + lapTahunAwal + "/" + lapTahunAkhir + "/" + lapTahun2Awal + "/" + lapTahun2Akhir);
            }
        }


    });

</script>
