<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci = &get_instance();
$ci->load->model('Konfigurasi');
$ci->load->model('PegawaiModel');
$ci->load->model('LaporanModel');
?>
<style type="text/css">
    table{
        border-collapse: collapse;
    }

    .th{
        background: #009900;
        padding: 5px;
        color: #FFFFFF;
        font-weight: bold;
    }

    td{
        font-size: 10pt;
        text-align: left;
        border: solid 1.5px black;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .judulheader{
        padding-top: 0px;
        text-align: center;
        padding-bottom: 5px;
        font-weight: bold;
    }
</style>
<div style="padding : 65px 0px -60px 300px;"><img style="width:105px;height:105px;" src=<?php echo base_url(); ?>_temp/img/logo_pa_pku.png"/><img style="width:105px;height:105px;margin-left: 500px;" src=<?php echo base_url(); ?>_temp/img/logo-iso-papbr.jpg"/></div>
<div class="judulheader" style="font-size: 16pt;"><?php echo config_item('APP_COMPANY_NAME'); ?><br></div>
<div class="judulheader" style="font-size: 12pt;"><?php echo config_item('APP_COMPANY_ADDRES'); ?><br></div>
<div class="judulheader" style="font-size: 10pt;font-style: italic;"><?php echo config_item('APP_COMPANY_WEBMAIL'); ?><br></div>
<hr style="100">
<br/>
<?php
if($data['js']=="ALL"){
    if ($data['periode'] == 'prh') {
        $sql = 'SELECT * FROM surat s,perkara p WHERE s.surKategori=? AND s.surTabayun=? AND p.perSurID=s.surID AND s.surTglTerimaKeluar >= ? AND s.surTglTerimaKeluar<=? ORDER BY s.surTglTerimaKeluar ASC';
        $where = array('M','Y', $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglakhir']));
        $sublabel = 'Periode ' . (($data['tglawal'] == $data['tglakhir']) ? $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) : $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) . ' - ' . $ci->Konfigurasi->MSQLDateToNormal($data['tglakhir']));
    } else if ($data['periode'] == 'prb') {
        $sql = 'SELECT * FROM surat s,perkara p WHERE s.surKategori=? AND s.surTabayun=? AND p.perSurID=s.surID AND s.surTglTerimaKeluar>=? AND s.surTglTerimaKeluar<=? ORDER BY s.surTglTerimaKeluar ASC';
        $where = array('M','Y', $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
        $sublabel = 'Periode ' . (($data['blnawal'] == $data['blnakhir'] && $data['thnawal'] == $data['thnakhir']) ? $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] : $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] . ' - ' . $ci->Konfigurasi->getNamaBulan($data['blnakhir']) . ' ' . $data['thnakhir']);
    } else if ($data['periode'] == 'prt') {
        $sql = 'SELECT * FROM surat s,perkara p WHERE s.surKategori=? AND s.surTabayun=? AND p.perSurID=s.surID AND YEAR(s.surTglTerimaKeluar)>=? AND YEAR(s.surTglTerimaKeluar)<=? ORDER BY s.surTglTerimaKeluar ASC';
        $where = array('M','Y', $data['thnawal2'], $data['thnakhir2']);
        $sublabel = 'Periode Tahun ' . (($data['thnawal2'] == $data['thnakhir2']) ? $data['thnawal2'] : $data['thnawal2'] . ' - ' . $data['thnakhir2']);
    }
}  else {
    $js=$data['js'];
    if ($data['periode'] == 'prh') {
        $sql = 'SELECT * FROM surat s,perkara p WHERE s.surKategori=? AND s.surTabayun=? AND p.perJsPenID=? AND p.perSurID=s.surID AND s.surTglTerimaKeluar >= ? AND s.surTglTerimaKeluar<=? ORDER BY s.surTglTerimaKeluar ASC';
        $where = array('M','Y',$js, $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglakhir']));
        $sublabel = 'Periode ' . (($data['tglawal'] == $data['tglakhir']) ? $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) : $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) . ' - ' . $ci->Konfigurasi->MSQLDateToNormal($data['tglakhir']));
    } else if ($data['periode'] == 'prb') {
        $sql = 'SELECT * FROM surat s,perkara p WHERE s.surKategori=? AND s.surTabayun=? AND p.perJsPenID=? AND p.perSurID=s.surID AND s.surTglTerimaKeluar>=? AND s.surTglTerimaKeluar<=? ORDER BY s.surTglTerimaKeluar ASC';
        $where = array('M','Y',$js, $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
        $sublabel = 'Periode ' . (($data['blnawal'] == $data['blnakhir'] && $data['thnawal'] == $data['thnakhir']) ? $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] : $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] . ' - ' . $ci->Konfigurasi->getNamaBulan($data['blnakhir']) . ' ' . $data['thnakhir']);
    } else if ($data['periode'] == 'prt') {
        $sql = 'SELECT * FROM surat s,perkara p WHERE s.surKategori=? AND s.surTabayun=? AND p.perJsPenID=? AND p.perSurID=s.surID AND YEAR(s.surTglTerimaKeluar)>=? AND YEAR(s.surTglTerimaKeluar)<=? ORDER BY s.surTglTerimaKeluar ASC';
        $where = array('M','Y',$js, $data['thnawal2'], $data['thnakhir2']);
        $sublabel = 'Periode Tahun ' . (($data['thnawal2'] == $data['thnakhir2']) ? $data['thnawal2'] : $data['thnawal2'] . ' - ' . $data['thnakhir2']);
    }
}

?>
<div style="font-size: 14px; font-weight: bold;" align="center">PENANGANAN DELEGASI BANTUAN PANGGILAN / PEMBERITAHUAN</div><br/>
<div style="font-size: 14px; font-weight: bold;" align="center"><?php echo $sublabel; ?></div><br/>
<table align="center">
    <tr>
        <td class="th" valign="top" align="center" rowspan="2" width="40">No</td>
        <td class="th" valign="top" align="center" rowspan="2" width="320">Pengadilan Agama</td>
        <td class="th" valign="top" align="center" rowspan="2" width="200">Nomor Register</td>
        <td class="th" valign="top" align="center" colspan="2" width="300">Tanggal</td>
        <td class="th" valign="top" align="center" rowspan="2" width="100">Lama Pelaksanaan</td>
        <td class="th" valign="top" align="center" rowspan="2" width="200">Nomor Resi</td>
    </tr>
    <tr>
        <td class="th" valign="top" align="center">Diterima Perintah</td>
        <td class="th" valign="top" align="center">Kirim Relaas</td>
    </tr>
    <?php
    $surat=$ci->LaporanModel->getDataQuery($sql,$where);
    if (count($surat) < 1) {
        echo '<tr><td valign="top" align="left" colspan="7" style="font-size: 14px;"><i>Data Tidak Tersedia</i></td></tr>';
    } else {
        $no = 1;
        foreach ($surat as $row) {
            ?>
            <tr>
                <td valign="top" align="center"><?php echo $no; ?></td>
                <td valign="top" align="center"><?php echo $row->surDari; ?></td>
                <td valign="top" align="center"><?php echo $row->perNoPerkara; ?></td>
                <td valign="top" align="center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglTerimaKeluar); ?></td>
                <td valign="top" align="center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->perTglKirimRelaas); ?></td>
                <td valign="top" align="center"><?php echo $ci->Konfigurasi->selisihTgl($row->surTglTerimaKeluar,$row->perTglKirimRelaas).' Hari'; ?></td>
                <td valign="top" align="center"><?php echo $row->perNoResi; ?></td>
            </tr>
            <?php
            $no++;
        }
    }
    ?>
    <tr><td colspan="7" style="border-bottom: 0px;border-left: 0px;border-right: 0px;"></td></tr>  
    <tr><td colspan="7" style="border: 0px;"></td></tr>  
    <tr><td colspan="7" style="border: 0px;"></td></tr>  
    <tr><td colspan="7" style="border: 0px;"></td></tr>  
    <tr><td colspan="7" style="border: 0px;"></td></tr>
    <tr><td colspan="5" style="border: 0px;"></td><td style="border: 0px;" colspan="2">Pekanbaru, <?php echo $ci->Konfigurasi->MSQLDateToNormal(date('Y-m-d')); ?></td></tr>
    <tr><td colspan="5" style="border: 0px;"></td><td style="border: 0px;" colspan="2">Ketua Pengadilan Agama Pekanbaru,</td></tr>
    <tr><td colspan="7" style="border: 0px;"></td></tr>  
    <tr><td colspan="7" style="border: 0px;"></td></tr>  
    <tr><td colspan="7" style="border: 0px;"></td></tr>
    <tr><td colspan="5" style="border: 0px;"></td><td style="border: 0px;" colspan="2"><?php echo $ci->PegawaiModel->getbyid('58d76d351c75f')->pegNama; ?></td></tr>
</table>
