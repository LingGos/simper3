<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
        padding-top: 8px;
        padding-bottom: 8px;
    }
    .pad{
        padding : 50px 0px -50px 70px;
    }

    .pad-left{
        padding : 0px 0px 0px 60px;
    }
</style>
<table>
    <tr><td colspan="3" valign="top" align="center" style="width: 100%;border-bottom: 0px;font-size: 20px;"><b>TELAAHAN STAF</b></td></tr>
    <tr><td colspan="3" valign="top" align="center" style="width: 100%;border-bottom: 0px;font-size: 18px;"><b>TENTANG</b></td></tr>
    <tr><td colspan="3" valign="top" align="center" style="width: 100%;font-size: 14px;"><?php echo $ts->telPersoalan; ?></td></tr>
    
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"><b>&nbsp;&nbsp;&nbsp;A.</b></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><b>Persoalan</b></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><?php echo $ts->telPersoalan; ?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"><b>&nbsp;&nbsp;&nbsp;B.</b></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><b>Praanggapan</b></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><?php echo $ts->telPraanggapan; ?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"><b>&nbsp;&nbsp;&nbsp;C.</b></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><b>Fakta yang Mempengaruhi</b></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><?php echo $ts->telFakta; ?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"><b>&nbsp;&nbsp;&nbsp;D.</b></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><b>Analisis</b></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><?php echo $ts->telPersoalan; ?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"><b>&nbsp;&nbsp;&nbsp;E.</b></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><b>Simpulan</b></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><?php echo $ts->telSimpulan; ?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"><b>&nbsp;&nbsp;&nbsp;F.</b></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><b>Saran</b></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-bottom: 0px;"></td>
        <td colspan="2" valign="top" align="left"  style="width: 95%;font-size: 14px;border-bottom: 0px;"><?php echo $ts->telSaran; ?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-top: 0px;border-bottom: 0px;"></td>
        <td valign="top" align="left"  style="width: 60%;font-size: 14px;border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: 0px;"></td>
        <td valign="top" align="left"  style="width: 35%;font-size: 14px;border-top: 0px;border-left: 0px;border-bottom: 0px;"><?php echo  ucwords($ttd['jabatan']);?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-top: 0px;border-bottom: 0px;"></td>
        <td valign="top" align="left"  style="width: 60%;font-size: 14px;border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: 0px;"></td>
        <td valign="top" align="left"  style="width: 35%;font-size: 14px;border-top: 0px;border-left: 0px;border-bottom: 0px;"><?php echo 'Ttd';?></td>
    </tr>
    <tr>
        <td valign="top" align="left"  style="width: 5%;font-size: 14px;border-right: 0px;border-top: 0px;"></td>
        <td valign="top" align="left"  style="width: 60%;font-size: 14px;border-right: 0px;border-top: 0px;border-left: 0px;"></td>
        <td valign="top" align="left"  style="width: 35%;font-size: 14px;border-top: 0px;border-left: 0px;"><?php echo  ucwords($ttd['nama']);?></td>
    </tr>
</table>

