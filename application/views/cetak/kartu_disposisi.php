<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci = &get_instance();
$ci->load->model('Konfigurasi');
$ci->load->model('SuratMasukModel');
?>
<style type="text/css">
    table{
        /*width:  500px;*/
        border: solid 5px black;
        border-collapse: collapse;
    }

    th{
        text-align: center;
        border: solid 1px black;
        background: #cccccc;
        border-collapse: collapse;
        padding: 5px;
    }

    td{
        text-align: left;
        border: solid 1.5px black;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .pad{
        padding : 50px 0px -50px 70px;
    }

    .pad-left{
        padding : 0px 0px 0px 60px;
    }
</style>
<table>
    <tr><td colspan="6" valign="top" align="center" style="width: 745px;border-bottom: 0px;font-size: 22px;">Pengadilan Agama Pekanbaru Klas 1A</td></tr>
    <tr><td colspan="6" valign="top" align="center" style="width: 745px;border-bottom: 0px;font-size: 16px;">Jl.Datuk Setia Maharja / Parit Indah, Kota Pekanbaru</td></tr>
    <tr><td colspan="6" valign="top" align="center" style="width: 745px;font-size: 14px;">Telepon : 0761-572855, Faksimile : 0761-839718</td></tr>
    <tr><td colspan="6" valign="top" align="center" style="width: 745px;font-size: 20px;">LEMBAR DISPOSISI</td></tr>
    <tr>
        <td valign="top" align="left" style="width: 120px;font-size: 14px;border-right: 0px;">Nomor Agenda</td>
        <td valign="top" align="center" style="width: 5px;font-size: 14px;border-right: 0px;">:</td>
        <td valign="top" align="left" style="width: 200px;font-size: 14px;"><?php echo $surat->surNoUrut; ?></td>
        <td valign="top" align="left" style="width: 120px;font-size: 14px;border-right: 0px;">Tingkat Keamanan</td>
        <td valign="top" align="center" style="width: 5px;font-size: 14px;border-right: 0px;">:</td>
        <td valign="top" align="left" style="width: 225px;font-size: 14px;"><?php echo $surat->surKeamanan; ?></td>
    </tr>
    <tr>
        <td valign="top" align="left" style="width: 120px;font-size: 14px;border-right: 0px;">Tgl Penerimaan</td>
        <td valign="top" align="center" style="width: 5px;font-size: 14px;border-right: 0px;">:</td>
        <td valign="top" align="left" style="width: 225px;font-size: 14px;"><?php echo $ci->Konfigurasi->MSQLDateToNormal($surat->surTglTerimaKeluar); ?></td>
        <td valign="top" align="left" style="width: 120px;font-size: 14px;border-right: 0px;">Tgl Penyelesaian</td>
        <td valign="top" align="center" style="width: 5px;font-size: 14px;border-right: 0px;">:</td>
        <td valign="top" align="left" style="width: 225px;font-size: 14px;"><?php echo (($surat->surTglPenyelesaian != null || $surat->surTglPenyelesaian != '') ? $ci->Konfigurasi->MSQLDateToNormal($surat->surTglPenyelesaian) : ' -- '); ?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 130px;font-size: 14px;border-right: 0px;border-bottom: 0px;">Tanggal & No. Surat</td>
        <td valign="top" align="center" style="width: 5px;font-size: 14px;border-right: 0px;border-bottom: 0px;">:</td>
        <td valign="top" align="left" colspan="4" style="width: 500px;font-size: 14px;border-bottom: 0px;"><?php echo $ci->Konfigurasi->MSQLDateToNormal($surat->surTglSurat) . ' / ' . $surat->surNomorSurat; ?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 130px;font-size: 14px;border-right: 0px;border-bottom: 0px;">Dari</td>
        <td valign="top" align="center" style="width: 5px;font-size: 14px;border-right: 0px;border-bottom: 0px;">:</td>
        <td valign="top" align="left" colspan="4" style="width: 500px;font-size: 14px;border-bottom: 0px;"><?php echo $surat->surDari; ?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 130px;font-size: 14px;border-right: 0px;border-bottom: 0px;">Ringkasan Isi</td>
        <td valign="top" align="center" style="width: 5px;font-size: 14px;border-right: 0px;border-bottom: 0px;">:</td>
        <td valign="top" align="left" colspan="4" style="width: 500px;font-size: 14px;border-bottom: 0px;"><?php echo $surat->surRingkas; ?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 130px;font-size: 14px;border-right: 0px;">Lampiran</td>
        <td valign="top" align="center" style="width: 5px;font-size: 14px;border-right: 0px;">:</td>
        <td valign="top" align="left" colspan="4" style="width: 100px;font-size: 14px;"><?php echo (($surat->surLampiran == 'Y') ? 'Ada' : 'Tidak Ada'); ?></td>
    </tr>
    <tr>
        <td valign="top" align="center" colspan="3" style="font-size: 14px;"><b>Disposisi</b></td>
        <td valign="top" align="center" colspan="2" style="font-size: 14px;"><b>Diteruskan Kepada</b></td>
        <td valign="top" align="center" style="font-size: 14px;"><b>Paraf</b></td>
    </tr>
    <?php
    if (count($disposisi) < 1) {
        echo '<tr><td valign="top" align="left" colspan="6" style="font-size: 14px;"><i>Disposisi Tidak Ada</i></td></tr>';
    } else {
        $no = 1;
        foreach ($disposisi as $row) {
            ?>
            <tr>
                <td valign="top" align="left" colspan="3" style="font-size: 14px;"><?php echo (($row->disUraian == null) ? '<i>---Tidak Ada---</i>' : $row->disUraian); ?></td>
                <td valign="top" align="left" colspan="2" style="font-size: 14px;"><?php echo $no . '. ';?><?php echo $ci->DisposisiModel->get_disposisi_getPegawai($row->disKepadaPenID)->pegNama;?></td>
                <td valign="top" align="center" style="font-size: 14px;">Ttd</td>
            </tr>
            <?php
            $no++;
        }
    }
    ?>
</table>