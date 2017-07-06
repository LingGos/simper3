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
        $sql = 'SELECT * FROM surat s,perkara p WHERE s.surKategori=? AND s.surTabayun=? AND p.perJsPegID=? AND p.perSurID=s.surID AND s.surTglTerimaKeluar >= ? AND s.surTglTerimaKeluar<=? ORDER BY s.surTglTerimaKeluar ASC';
        $where = array('M','Y',$js, $ci->Konfigurasi->dateToMysql($data['tglawal']), $ci->Konfigurasi->dateToMysql($data['tglakhir']));
        $sublabel = 'Periode ' . (($data['tglawal'] == $data['tglakhir']) ? $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) : $ci->Konfigurasi->MSQLDateToNormal($data['tglawal']) . ' - ' . $ci->Konfigurasi->MSQLDateToNormal($data['tglakhir']));
    } else if ($data['periode'] == 'prb') {
        $sql = 'SELECT * FROM surat s,perkara p WHERE s.surKategori=? AND s.surTabayun=? AND p.perJsPegID=? AND p.perSurID=s.surID AND s.surTglTerimaKeluar>=? AND s.surTglTerimaKeluar<=? ORDER BY s.surTglTerimaKeluar ASC';
        $where = array('M','Y',$js, $data['thnawal'] . '-' . $data['blnawal'] . '-01', $data['thnakhir'] . '-' . $data['blnakhir'] . '-' . $ci->Konfigurasi->getJmlHari($data['blnakhir'], $data['thnakhir']));
        $sublabel = 'Periode ' . (($data['blnawal'] == $data['blnakhir'] && $data['thnawal'] == $data['thnakhir']) ? $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] : $ci->Konfigurasi->getNamaBulan($data['blnawal']) . ' ' . $data['thnawal'] . ' - ' . $ci->Konfigurasi->getNamaBulan($data['blnakhir']) . ' ' . $data['thnakhir']);
    } else if ($data['periode'] == 'prt') {
        $sql = 'SELECT * FROM surat s,perkara p WHERE s.surKategori=? AND s.surTabayun=? AND p.perJsPegID=? AND p.perSurID=s.surID AND YEAR(s.surTglTerimaKeluar)>=? AND YEAR(s.surTglTerimaKeluar)<=? ORDER BY s.surTglTerimaKeluar ASC';
        $where = array('M','Y',$js, $data['thnawal2'], $data['thnakhir2']);
        $sublabel = 'Periode Tahun ' . (($data['thnawal2'] == $data['thnakhir2']) ? $data['thnawal2'] : $data['thnawal2'] . ' - ' . $data['thnakhir2']);
    }
}

?>
<div style="font-size: 14px; font-weight: bold;" align="center">REGISTER TABAYUN MASUK</div><br/>
<div style="font-size: 14px; font-weight: bold;" align="center"><?php echo $sublabel; ?></div><br/>
<table align="center">
    <tr>
        <td class="th" valign="top" align="center" rowspan="2" width="30">No</td>
        <td class="th" valign="top" align="center" colspan="5">Mohon Bantuan Panggilan</td>
        <td class="th" valign="top" align="center" rowspan="2" width="50">Tanggal Sidang / Putus</td>
        <td class="th" valign="top" align="center" colspan="3">Panggilan</td>
        <td class="th" valign="top" align="center" colspan="3">Pengiriman</td>
        <td class="th" valign="top" align="center" rowspan="2" width="40">Hari</td>
    </tr>
    <tr>
        <td class="th" valign="top" align="center" width="70">Tgl. Terima Surat</td>
        <td class="th" valign="top" align="center" width="80">Pengiriman Surat</td>
        <td class="th" valign="top" align="center" width="80">Register Perkara</td>
        <td class="th" valign="top" align="center" width="80">Jenis Relaas</td>
        <td class="th" valign="top" align="center" width="80">Identitas yang dipanggil</td>
        
        <td class="th" valign="top" align="center" width="80">Nama JS/JSP</td>
        <td class="th" valign="top" align="center" width="80">Tanggal JS/ JSP terima surat</td>        
        <td class="th" valign="top" align="center" width="70">Tanggal Panggil</td>
        
        <td class="th" valign="top" align="center" width="70">Tanggal Serahkan Relaas</td>
        <td class="th" valign="top" align="center" width="70">Tanggal Kirim Relaas</td>
        <td class="th" valign="top" align="center" width="80">Nomor Resi</td>
    </tr>
    <?php
    $surat=$ci->LaporanModel->getDataQuery($sql,$where);
    if (count($surat) < 1) {
        echo '<tr><td valign="top" align="left" colspan="14" style="font-size: 14px;"><i>Data Tidak Tersedia</i></td></tr>';
    } else {
        $no = 1;
        foreach ($surat as $row) {
            ?>
    <tr>
                <td valign="top" align="center" width="30"><?php echo $no; ?></td>
                <td valign="top" align="center" width="10"><?php echo $ci->Konfigurasi->dateMysqlToLap($row->surTglTerimaKeluar); ?></td>
                <td valign="top" align="center" width="10"><?php echo $row->surDari; ?></td>
                <td valign="top" align="center" width="10"><?php echo $row->perNoPerkara; ?></td>
                <td valign="top" align="center" width="10"><?php echo $row->perJenisRelaas; ?></td>
                <td valign="top" align="center" width="10"><?php echo $row->perJenisIdentitas; ?></td>
                <td valign="top" align="center" width="10"><?php echo $ci->Konfigurasi->dateMysqlToLap($row->perTglPutusSidangInzage); ?></td>
                <td valign="top" align="center" width="70"><?php echo $ci->PegawaiModel->getbyid($row->perJsPegID)->pegNama; ?></td>
                <td valign="top" align="center" width="50"><?php echo $ci->Konfigurasi->dateMysqlToLap($row->perTglTerimaJs); ?></td>
                <td valign="top" align="center" width="50"><?php echo $ci->Konfigurasi->dateMysqlToLap($row->perTglPanggil); ?></td>
                <td valign="top" align="center" width="50"><?php echo $ci->Konfigurasi->dateMysqlToLap($row->perTglSerahRelaas); ?></td>
                <td valign="top" align="center" width="50"><?php echo $ci->Konfigurasi->dateMysqlToLap($row->perTglKirimRelaas); ?></td>
                <td valign="top" align="center" width="70"><?php echo $row->perNoResi; ?></td>
                <td valign="top" align="center" width="60"><?php echo $ci->Konfigurasi->selisihTgl($row->surTglTerimaKeluar,$row->perTglKirimRelaas).' Hari'; ?></td>
            </tr>
            
            <?php
            $no++;
        }
    }
    ?>
    <tr><td colspan="14" style="border-bottom: 0px;border-left: 0px;border-right: 0px;"></td></tr>  
    <tr><td colspan="14" style="border: 0px;"></td></tr>  
    <tr><td colspan="14" style="border: 0px;"></td></tr>  
    <tr><td colspan="14" style="border: 0px;"></td></tr>  
    <tr><td colspan="14" style="border: 0px;"></td></tr>
    <tr><td colspan="10" style="border: 0px;"></td><td style="border: 0px;" colspan="4">Pekanbaru, <?php echo $ci->Konfigurasi->MSQLDateToNormal(date('Y-m-d')); ?></td></tr>
    <tr><td colspan="10" style="border: 0px;"></td><td style="border: 0px;" colspan="4">Ketua Pengadilan Agama Pekanbaru,</td></tr>
    <tr><td colspan="14" style="border: 0px;"></td></tr>  
    <tr><td colspan="14" style="border: 0px;"></td></tr>  
    <tr><td colspan="14" style="border: 0px;"></td></tr>
    <tr><td colspan="10" style="border: 0px;"></td><td style="border: 0px;" colspan="4"><?php echo $ci->PegawaiModel->getbyid('58d76d351c75f')->pegNama; ?></td></tr>
</table>
