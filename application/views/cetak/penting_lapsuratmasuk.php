<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci = &get_instance();
$ci->load->model('Konfigurasi');
$ci->load->model('PegawaiModel');
$ci->load->model('IndekModel');
$ci->load->model('KlasifikasiModel');
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
$sql = null;
$where = null;
if ($data['kategori'] == 'MASUK') {
    if ($data['periode'] == 'prh') {
        $sql = 'SELECT * FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar >= ? AND surTglTerimaKeluar<=? ORDER BY surTglTerimaKeluar ASC';
        $where = array('M', 'PENTING', $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglakhir']));
        $sublabel = 'Periode ' . (($data['tglawal'] == $data['tglakhir']) ? $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) : $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) . ' - ' . $ci->Konfigurasi->MSQLDateToNormal($data['tglakhir']));
    } else if ($data['periode'] == 'prb') {
        $sql = 'SELECT * FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar>=? AND surTglTerimaKeluar<=? ORDER BY surTglTerimaKeluar ASC';
        $where = array('M', 'PENTING', $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
        $sublabel = 'Periode ' . (($data['blnawal'] == $data['blnakhir'] && $data['thnawal'] == $data['thnakhir']) ? $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] : $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] . ' - ' . $ci->Konfigurasi->getNamaBulan($data['blnakhir']) . ' ' . $data['thnakhir']);
    } else if ($data['periode'] == 'prt') {
        $sql = 'SELECT * FROM surat WHERE surKategori=? AND surJenis=? AND YEAR(surTglTerimaKeluar)>=? AND YEAR(surTglTerimaKeluar)<=? ORDER BY surTglTerimaKeluar ASC';
        $where = array('M', 'PENTING', $data['thnawal2'], $data['thnakhir2']);
        $sublabel = 'Periode Tahun ' . (($data['thnawal2'] == $data['thnakhir2']) ? $data['thnawal2'] : $data['thnawal2'] . ' - ' . $data['thnakhir2']);
    }
} else if ($data['kategori'] == 'KELUAR') {
    if ($data['periode'] == 'prh') {
        $sql = 'SELECT * FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar >= ? AND surTglTerimaKeluar<=? ORDER BY surTglTerimaKeluar ASC';
        $where = array('K', 'PENTING', $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglawal']));
        $sublabel = 'Periode ' . (($data['tglawal'] == $data['tglakhir']) ? $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) : $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) . ' - ' . $ci->Konfigurasi->MSQLDateToNormal($data['tglakhir']));
    } else if ($data['periode'] == 'prb') {
        $sql = 'SELECT * FROM surat WHERE surKategori=? AND surJenis=? AND surTglTerimaKeluar>=? AND surTglTerimaKeluar<=? ORDER BY surTglTerimaKeluar ASC';
        $where = array('K', 'PENTING', $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
        $sublabel = 'Periode ' . (($data['blnawal'] == $data['blnakhir'] && $data['thnawal'] == $data['thnakhir']) ? $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] : $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] . ' - ' . $ci->Konfigurasi->getNamaBulan($data['blnakhir']) . ' ' . $data['thnakhir']);
    } else if ($data['periode'] == 'prt') {
        $sql = 'SELECT * FROM surat WHERE surKategori=? AND surJenis=? AND YEAR(surTglTerimaKeluar)>=? AND YEAR(surTglTerimaKeluar)<=? ORDER BY surTglTerimaKeluar ASC';
        $where = array('K', 'PENTING', $data['thnawal2'], $data['thnakhir2']);
        $sublabel = 'Periode Tahun ' . (($data['thnawal2'] == $data['thnakhir2']) ? $data['thnawal2'] : $data['thnawal2'] . ' - ' . $data['thnakhir2']);
    }
}
?>
<div style="font-size: 14px; font-weight: bold;" align="center">Laporan Surat <?php echo(($data['kategori'] == 'MASUK') ? 'Masuk' : 'Keluar'); ?> (Jenis : Penting)</div><br/>
<div style="font-size: 14px; font-weight: bold;" align="center"><?php echo $sublabel; ?></div><br/>
<table align="center">
    <tr>
        <td class="th" valign="top" align="center" width="30">No</td>
        <td class="th" valign="top" align="center" width="50">No. Urut</td>
        <td class="th" valign="top" align="center" width="100">No. Surat</td>
        <td class="th" valign="top" align="center" width="50">Klasifikasi</td>
        <td class="th" valign="top" align="center" width="50">Indek</td>
        <td class="th" valign="top" align="center" width="200">Perihal</td>
        <td class="th" valign="top" align="center" width="70">Tanggal Surat</td>
        <td class="th" valign="top" align="center" width="70">Tanggal Terima</td>
        <td class="th" valign="top" align="center" width="50">Keamanan</td>
        <td class="th" valign="top" align="center" width="45">Sifat</td>
        <td class="th" valign="top" align="center" width="150">Asal</td>
        <td class="th" valign="top" align="center" width="150">Tujuan</td>
    </tr>
    <?php
    $surat = $ci->LaporanModel->getDataQuery($sql, $where);
    if (count($surat) < 1) {
        echo '<tr><td valign="top" align="left" colspan="12" style="font-size: 14px;"><i>Data Tidak Tersedia</i></td></tr>';
    } else {
        $no = 1;
        foreach ($surat as $row) {
            ?>
            <tr>
                <td valign="top" align="center"><?php echo $no; ?></td>
                <td valign="top" align="center"><?php echo $row->surNoUrut; ?></td>
                <td valign="top" align="center"><?php echo $row->surNomorSurat; ?></td>
                <td valign="top" align="center"><?php echo $ci->KlasifikasiModel->getbyid($row->surKlaID)->klaKode . '.' . $ci->KlasifikasiModel->getbyid($row->surKlaID1)->klaKode . '.' . $ci->KlasifikasiModel->getbyid($row->surKlaID2)->klaKode; ?></td>
                <td valign="top" align="center"><?php echo $ci->IndekModel->getbyid($row->surIndID)->indNama; ?></td>
                <td valign="top" align="center"><?php echo ucwords($row->surPerihal); ?></td>
                <td valign="top" align="center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglSurat); ?></td>
                <td valign="top" align="center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglTerimaKeluar); ?></td>
                <td valign="top" align="center"><?php echo $row->surKeamanan; ?></td>
                <td valign="top" align="center"><?php echo ucwords($row->surSifat); ?></td>
                <td valign="top" align="center"><?php echo ucwords($row->surDari); ?></td>
                <td valign="top" align="center"><?php echo ucwords($row->surKepada); ?></td>
            </tr>
            <?php
            $no++;
        }
    }
    ?>
    <tr><td colspan="11" style="border-bottom: 0px;border-left: 0px;border-right: 0px;"></td></tr>  
    <tr><td colspan="11" style="border: 0px;"></td></tr>  
    <tr><td colspan="11" style="border: 0px;"></td></tr>  
    <tr><td colspan="11" style="border: 0px;"></td></tr>  
    <tr><td colspan="11" style="border: 0px;"></td></tr>
    <tr><td colspan="8" style="border: 0px;"></td><td style="border: 0px;" colspan="3">Pekanbaru, <?php echo $ci->Konfigurasi->MSQLDateToNormal(date('Y-m-d')); ?></td></tr>
    <tr><td colspan="8" style="border: 0px;"></td><td style="border: 0px;" colspan="3">Ketua Pengadilan Agama Pekanbaru,</td></tr>
    <tr><td colspan="11" style="border: 0px;"></td></tr>  
    <tr><td colspan="11" style="border: 0px;"></td></tr>  
    <tr><td colspan="11" style="border: 0px;"></td></tr>
    <tr><td colspan="8" style="border: 0px;"></td><td style="border: 0px;" colspan="3"><?php echo $ci->PegawaiModel->getbyid('58d76d351c75f')->pegNama; ?></td></tr>
</table>


