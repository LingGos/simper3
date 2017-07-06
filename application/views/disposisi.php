<script type="text/javascript">
    function CariList(filter,ls,sub_ls,jml_sub_ls){
        var i,j,jj;
        jj=0;
        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < ls.length; i++) {
            var ada=false;
            for (j = 0; j < jml_sub_ls ; j++) {
                if (sub_ls[jj].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    ada=true;
                } 
                jj=jj+1;
            }   
            if (ada) {
                ls[i].style.display = "";
            } else {
                ls[i].style.display = "none";
            }
        }
    }
    function CariList3() {
        // Declare variables
        var filter, ls, sub_ls,jml_sub_ls, i,j,jj;
        filter = document.getElementById('DataCari3').value.toUpperCase();
        ls = $(".ls3");
        sub_ls = $('.sub_ls3');
        jml_sub_ls=4;
        CariList(filter,ls,sub_ls,jml_sub_ls);
    }
    function CariList2() {
        // Declare variables
        var filter, ls, sub_ls,jml_sub_ls, i,j,jj;
        filter = document.getElementById('DataCari2').value.toUpperCase();
        ls = $(".ls2");
        sub_ls = $('.sub_ls2');
        jml_sub_ls=4;
        CariList(filter,ls,sub_ls,jml_sub_ls);
    }
    function CariList1() {
        // Declare variables
        var filter, ls, sub_ls,jml_sub_ls, i,j,jj;
        filter = document.getElementById('DataCari1').value.toUpperCase();
        ls = $(".ls1");
        sub_ls = $('.sub_ls1');
        jml_sub_ls=4;
        CariList(filter,ls,sub_ls,jml_sub_ls);
    }
</script>
<style type="text/css">
.listview-outlook .list .list-content .list-title, .listview-outlook .list .list-content .list-subtitle, .listview-outlook .list .list-content .list-remark
{
    overflow: visible;
    display: inline-block;
}
.tag{
    border-radius: 10px;
    font-size: 11px;
    width: auto;
    height: 16px;
    margin-right: 5px;
}
</style>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci = &get_instance();
$ci->load->model('Konfigurasi');
$ci->load->model('SuratMasukModel');
$ci->load->model('PenggunaModel');
$ci->load->model('PegawaiModel');
switch ($subview) {
    default :
        ?>
        <br/>
        <div class="tabcontrol2" data-role="tabcontrol">
            <ul class="tabs">
                <li ><a href="#frame_5_1"><span class="mif-2x mif-list2"></span> Semua Disposisi</a></li>
                <li class="active"><a href="#frame_5_2"><span class="mif-2x mif-download"></span> Disposisi Masuk</a></li>
                <li><a href="#frame_5_3"><span class="mif-2x mif-upload"></span> Disposisi Terkirim</a></li>
            </ul>
            <div class="frames">
                <div class="frame" id="frame_5_1">
                    <div class="row">
                        <div class="input-control text full-size">
                            <span class="mif-search prepend-icon"></span>
                            <input type="text" placeholder="Cari ..." onkeyup="CariList1()" id="DataCari1" autofocus>
                        </div>

                    </div>
                    <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                        <div class="listview-outlook set-border" style="width: 100%; height: 500px;overflow:hidden; overflow-y:scroll; padding: 5px;" data-role="listview" data-on-list-click="window.location.href = list.find('.list-href').text()">
                            <?php
                                    foreach ($data_query as $v) {
                                      $surat=$ci->SuratMasukModel->getbyid($v->disSumSukID);
                                      $href='';
                                      if($surat->surKategori=='M'){
                                          $href=$href.'surat_masuk/';
                                          if($surat->surTabayun=='Y'){
                                              $href=$href.'detailx_ptabayun/';
                                          }else{
                                              if($surat->surJenis=='PENTING'){
                                                  $href=$href.'detailx_pumum/';
                                              }else if ($surat->surJenis=='RAHASIA') {
                                                  $href=$href.'detailx_rahasia/';
                                              }  else {
                                                  $href=$href.'detailx_biasa/';
                                              }
                                          }
                                      }  else {
                                          $href=$href.'surat_keluar/';
                                          if($surat->surTabayun=='Y'){
                                              $href=$href.'detailx_ptabayun/';
                                          }else{
                                              if($surat->surJenis=='PENTING'){
                                                  $href=$href.'detailx_pumum/';
                                              }else if ($surat->surJenis=='RAHASIA') {
                                                  $href=$href.'detailx_rahasia/';
                                              }  else {
                                                  $href=$href.'detailx_biasa/';
                                              }
                                          }
                                      }
                            ?>
                            <a class="list ls1">
                                <div class="list-content">
                                    <span class="list-href" style="display: none"><?php echo base_url().$href.$v->disID;?></span>
                                    <span class="list-title sub_ls1">Nomor : <?php echo $surat->surNomorSurat;?></span>
                                    <span class="list-subtitle sub_ls1">Perihal : <?php echo $surat->surPerihal;?></span>
                                    <span class="list-subtitle sub_ls1"><span class="tag info">Tgl Terima/Keluar Surat : <?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($surat->surTglTerimaKeluar);?></span><span class="tag info">Jenis : <?php echo $surat->surJenis;?></span><span class="tag info">Surat : <?php echo (($surat->surTabayun=='Y')?'Tabayun':'Umum');?></span><span class="tag info">Sifat : <?php echo (($surat->surSifat=='KILAT')?'Kilat(1x24 JAM)':(($surat->surSifat=='SEGERA')?'Segera(2x24 JAM)':(($surat->surSifat=='PENTING')?'Penting(3x24 JAM)':'Biasa')));?></span></span><span class="tag <?php echo (($v->disBuka=='Y')?'info':'alert');?> fg-white" style="position: absolute;right: 100px;"><?php echo (($v->disBuka=='Y')?'Sudah Dibaca':'Belum Dibaca');?></span><span class="mif-2x <?php echo (($this->session->userdata("masuk_id")==$v->disDariPenID)?'mif-upload fg-orange':'mif-download fg-green');?>" style="position: absolute;right: 70px;"></span>
                                    <span class="list-remark sub_ls1">Tgl Disposisi : <?php echo $v->disTgl;?> / <?php echo (($this->session->userdata("masuk_id")==$v->disDariPenID)?'Tujuan Disposis : ':'Asal Disposis : ').$ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($this->session->userdata("masuk_id"))->penPegID)->pegNama;?></span>
                                </div>
                            </a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="frame" id="frame_5_2">
                    <div class="row">
                        <div class="input-control text full-size">
                            <span class="mif-search prepend-icon"></span>
                            <input type="text" placeholder="Cari ..." onkeyup="CariList2()" id="DataCari2" autofocus>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                        <div class="listview-outlook set-border" style="width: 100%; height: 500px;overflow:hidden; overflow-y:scroll; padding: 5px;" data-role="listview" data-on-list-click="window.location.href = list.find('.list-href').text()">
                            <?php
                                    foreach ($data_query_masuk as $v) {
                                      $surat=$ci->SuratMasukModel->getbyid($v->disSumSukID);
                                      $href='';
                                      if($surat->surKategori=='M'){
                                          $href=$href.'surat_masuk/';
                                          if($surat->surTabayun=='Y'){
                                              $href=$href.'detailx_ptabayun/';
                                          }else{
                                              if($surat->surJenis=='PENTING'){
                                                  $href=$href.'detailx_pumum/';
                                              }else if ($surat->surJenis=='RAHASIA') {
                                                  $href=$href.'detailx_rahasia/';
                                              }  else {
                                                  $href=$href.'detailx_biasa/';
                                              }
                                          }
                                      }  else {
                                          $href=$href.'surat_keluar/';
                                          if($surat->surTabayun=='Y'){
                                              $href=$href.'detailx_ptabayun/';
                                          }else{
                                              if($surat->surJenis=='PENTING'){
                                                  $href=$href.'detailx_pumum/';
                                              }else if ($surat->surJenis=='RAHASIA') {
                                                  $href=$href.'detailx_rahasia/';
                                              }  else {
                                                  $href=$href.'detailx_biasa/';
                                              }
                                          }
                                      }
                            ?>
                            <a class="list ls2">
                                <div class="list-content">
                                    <span class="list-href" style="display: none"><?php echo base_url().$href.$v->disID;?></span>
                                    <span class="list-title sub_ls2">Nomor : <?php echo $surat->surNomorSurat;?></span>
                                    <span class="list-subtitle sub_ls2">Perihal : <?php echo $surat->surPerihal;?></span>
                                    <span class="list-subtitle sub_ls2"><span class="tag info">Tgl Terima/Keluar Surat : <?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($surat->surTglTerimaKeluar);?></span><span class="tag info">Jenis : <?php echo $surat->surJenis;?></span><span class="tag info">Surat : <?php echo (($surat->surTabayun=='Y')?'Tabayun':'Umum');?></span><span class="tag info">Sifat : <?php echo (($surat->surSifat=='KILAT')?'Kilat(1x24 JAM)':(($surat->surSifat=='SEGERA')?'Segera(2x24 JAM)':(($surat->surSifat=='PENTING')?'Penting(3x24 JAM)':'Biasa')));?></span></span><span class="tag <?php echo (($v->disBuka=='Y')?'info':'alert');?> fg-white" style="position: absolute;right: 100px;"><?php echo (($v->disBuka=='Y')?'Sudah Dibaca':'Belum Dibaca');?></span>
                                    <span class="list-remark sub_ls2">Tgl Disposisi : <?php echo $v->disTgl;?> / <?php echo (($this->session->userdata("masuk_id")==$v->disDariPenID)?'Tujuan Disposis : ':'Asal Disposisi : ').$ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($this->session->userdata("masuk_id"))->penPegID)->pegNama;?></span>
                                </div>
                            </a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="frame" id="frame_5_3">
                    <div class="row">
                        <div class="input-control text full-size">
                            <span class="mif-search prepend-icon"></span>
                            <input type="text" placeholder="Cari ..." onkeyup="CariList3()" id="DataCari3" autofocus>
                        </div>

                    </div>
                    <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                        <div class="listview-outlook set-border" style="width: 100%; height: 500px;overflow:hidden; overflow-y:scroll; padding: 5px;" data-role="listview" data-on-list-click="window.location.href = list.find('.list-href').text()">
                            <?php
                                    foreach ($data_query_terkirim as $v) {
                                      $surat=$ci->SuratMasukModel->getbyid($v->disSumSukID);
                                      $href='';
                                      if($surat->surKategori=='M'){
                                          $href=$href.'surat_masuk/';
                                          if($surat->surTabayun=='Y'){
                                              $href=$href.'detailx_ptabayun/';
                                          }else{
                                              if($surat->surJenis=='PENTING'){
                                                  $href=$href.'detailx_pumum/';
                                              }else if ($surat->surJenis=='RAHASIA') {
                                                  $href=$href.'detailx_rahasia/';
                                              }  else {
                                                  $href=$href.'detailx_biasa/';
                                              }
                                          }
                                      }  else {
                                          $href=$href.'surat_keluar/';
                                          if($surat->surTabayun=='Y'){
                                              $href=$href.'detailx_ptabayun/';
                                          }else{
                                              if($surat->surJenis=='PENTING'){
                                                  $href=$href.'detailx_pumum/';
                                              }else if ($surat->surJenis=='RAHASIA') {
                                                  $href=$href.'detailx_rahasia/';
                                              }  else {
                                                  $href=$href.'detailx_biasa/';
                                              }
                                          }
                                      }
                            ?>
                            <a class="list ls3">
                                <div class="list-content">
                                    <span class="list-href" style="display: none"><?php echo base_url().$href.$v->disID;?></span>
                                    <span class="list-title sub_ls3">Nomor : <?php echo $surat->surNomorSurat;?></span>
                                    <span class="list-subtitle sub_ls3">Perihal : <?php echo $surat->surPerihal;?></span>
                                    <span class="list-subtitle sub_ls3"><span class="tag info">Tgl Keluar Surat : <?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($surat->surTglTerimaKeluar);?></span><span class="tag info">Jenis : <?php echo $surat->surJenis;?></span><span class="tag info">Surat : <?php echo (($surat->surTabayun=='Y')?'Tabayun':'Umum');?></span><span class="tag info">Sifat : <?php echo (($surat->surSifat=='KILAT')?'Kilat(1x24 JAM)':(($surat->surSifat=='SEGERA')?'Segera(2x24 JAM)':(($surat->surSifat=='PENTING')?'Penting(3x24 JAM)':'Biasa')));?></span></span><span class="tag <?php echo (($v->disBuka=='Y')?'info':'alert');?> fg-white" style="position: absolute;right: 100px;"><?php echo (($v->disBuka=='Y')?'Sudah Dibaca':'Belum Dibaca');?></span>
                                    <span class="list-remark sub_ls3">Tgl Disposisi : <?php echo $v->disTgl;?> / <?php echo (($this->session->userdata("masuk_id")==$v->disDariPenID)?'Tujuan Disposis : ':'Asal Disposis : ').$ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($this->session->userdata("masuk_id"))->penPegID)->pegNama;?></span>
                                </div>
                            </a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <?php
        break;
}
?>
