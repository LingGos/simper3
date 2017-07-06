<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="Metro, a sleek, intuitive, and powerful framework for faster and easier web development for Windows Metro Style.">
        <meta name="keywords" content="HTML, CSS, JS, JavaScript, framework, metro, front-end, frontend, web development">
        <meta name="author" content="Sergey Pimenov and Metro UI CSS contributors">
        <link rel='shortcut icon' type='image/x-icon' href='../favicon.ico' />
        <title><?php echo config_item('APP_FULL_NAME'); ?></title>
        <link href="<?php echo base_url(); ?>asset/css/metro.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>asset/css/metro-icons.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>asset/css/metro-responsive.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>asset/css/metro-schemes.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>asset/css/metro-colors.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>asset/css/docs.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>asset/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/metro.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/select2.min.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/docs.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/ga.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/ckeditor/ckeditor.js"></script>
        <!--<script src="<?php // echo base_url(); ?>asset/js/chart/loader.js"></script>-->
        
        <style>
            html, body {
                height: auto;
            }
            .ppage-content {
                padding-top: 3.0rem;
                padding-bottom: 4.0rem;
                height: auto;
                background-color: #ffffff;
                margin-left: 40px;margin-right: 40px;margin-bottom: 10px;
            }
            
            .tabel tr:nth-child(odd){
                background:#ffffff; /* Baris ganjil Dihitung dari Header*/
            }
            .tabel tr:nth-child(even){
              background:#e8ebed; /* Baris Genap */
            }

        </style>
        <script>
            function pushMessage(t) {
                var mes = 'Info|Implement independently';
                $.Notify({
                    caption: mes.split("|")[0],
                    content: mes.split("|")[1],
                    type: t
                });
            }
            function no_submit() {
                return false;
            }
            function notifyOnErrorInput(input) {
                var message = input.data('validateHint');
                $.Notify({
                    caption: 'Error',
                    content: message,
                    type: 'alert'
                });
            }
        </script>
    </head>
    <body class="bg-grayDark">
        <script>
        $(function(){
            $(".js-select").select2({
                placeholder: "Pilih",
                allowClear: true
            });
        });
        </script>
        <div class="app-bar fixed-top green" data-role="appbar" >
            <a class="app-bar-element branding"><img src="<?php echo base_url(); ?>_temp/img/logo_pa_pku.png" style="height: 28px; display: inline-block; margin-right: 10px;"><?php echo ' ' . $this->config->item('APP_SHORT_NAME'); ?></a>
            <span class="app-bar-divider"></span>
            <ul class="app-bar-menu">
                <li><a href="<?php echo base_url(); ?>main">Beranda</a></li>
                <?php if ($this->session->userdata('masuk_level') == "ROOT") { ?>
                    <li>
                        <a href="" class="dropdown-toggle">Konfigurasi</a>
                        <ul class="d-menu" data-role="dropdown">
                            <li><a onclick="backupdb()" >Simpan Basis Data</a></li>
                            <li><a href="<?php echo base_url(); ?>notifikasi">Notifikasi</a></li>
                            <li><a href="<?php echo base_url(); ?>aktifitas_pengguna">Aktifitas Pengguna</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if ($this->session->userdata('masuk_level') == "ROOT" || $this->session->userdata('masuk_level') == "KASUBAGUMUM") { ?>
                    <li>
                        <a href="" class="dropdown-toggle">Master</a>
                        <ul class="d-menu" data-role="dropdown">
                            <?php if ($this->session->userdata('masuk_level') == "ROOT") { ?>
                                <li><a href="<?php echo base_url(); ?>unit">Unit</a></li>
                                <li><a href="<?php echo base_url(); ?>pegawai">Pegawai</a></li>
                                <li><a href="<?php echo base_url(); ?>pengguna">Pengguna</a></li>
                            <?php } ?>
                            <li>
                                <a class="dropdown-toggle">Surat</a>
                                <ul class="d-menu" data-role="dropdown">
                                    <li><a href="<?php echo base_url(); ?>indek">Indek</a></li>
                                    <li><a href="<?php echo base_url(); ?>klasifikasi">Klasifikasi</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <li>
                    <a href="" class="dropdown-toggle">Kelola Surat</a>
                    <ul class="d-menu" data-role="dropdown">
                        <li><a href="<?php echo base_url(); ?>surat_masuk">Surat Masuk</a></li>
                        <li><a href="<?php echo base_url(); ?>surat_keluar">Surat Keluar</a></li>
                    </ul>
                </li>
                
                <li id="notif_disposisi"></li>
                <?php if ($this->session->userdata('masuk_level') == "ROOT" || $this->session->userdata('masuk_level') == "KASUBAGUMUM" || $this->session->userdata('masuk_level') == "PIMPINAN" || $this->session->userdata('masuk_level')=='SEKRETARIS/PANITERA') { ?>    
                <li>
                    <a href="" class="dropdown-toggle">Laporan</a>
                    <ul class="d-menu" data-role="dropdown">
                        <li><a href="<?php echo base_url(); ?>laporan_surat_masuk">Surat Masuk</a></li>
                        <li><a href="<?php echo base_url(); ?>laporan_surat_keluar">Surat Keluar</a></li>
                        <li><a href="<?php echo base_url(); ?>laporan_tabayun_masuk">Tabayun Masuk</a></li>
                    </ul>
                </li>
            <?php } ?>
                <?php if ($this->session->userdata('masuk_level') == "KOORJS" || $this->session->userdata('masuk_level') == "JS/JSP") { ?>    
                <li>
                    <a href="" class="dropdown-toggle">Laporan</a>
                    <ul class="d-menu" data-role="dropdown">
                        <li><a href="<?php echo base_url(); ?>laporan_tabayun_masuk">Tabayun Masuk</a></li>
                    </ul>
                </li>
            <?php } ?>
                <?php if ($this->session->userdata('masuk_level') == "PIMPINAN") { ?>
                    <li>
                        <a href="" class="dropdown-toggle">SIPP Suport</a>
                        <ul class="d-menu" data-role="dropdown">
                            <li><a href="<?php echo base_url(); ?>sippmediasi">Laporan Mediasi</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <div class="app-bar-element place-right">
                <span class="dropdown-toggle"><span class="mif-user-check icon"></span> <?php echo $this->session->userdata("masuk_nama"); ?></span>
                <div class="app-bar-drop-container place-right no-margin-top block-shadow fg-green bg-white" data-role="dropdown" data-no-close="true" style="width: 220px">
                    <ul class="unstyled-list fg-green" style="font-size: 20px;">
                        <li style="margin-bottom: 8px;"><a onclick="editprofil('<?php echo $this->session->userdata("masuk_id") ?>')" class="fg-green fg-hover-orange">Profil</a></li>
                        <li style="margin-bottom: 8px;"><a onclick="editsandi('<?php echo $this->session->userdata("masuk_id") ?>')" class="fg-green fg-hover-orange">Ubah Sandi</a></li>
                        <li><a href="<?php echo base_url(); ?>masuk/keluar" class="fg-green fg-hover-orange">Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="ppage-content">
            <?php // echo var_dump($bc); ?>
            <div class="row">
                <ul class="breadcrumbs fg-green " style="background: #e3dc00;height: 45px;">
                    <li><a href="#"><span class="icon mif-home"></span></a></li>
                    <?php
                    $url = null;
                    foreach ($bc as $value) {
                        if (!empty($url)) {
                            $url = $url . '/' . $value;
                        } else {
                            $url = $url . $value;
                        }
                        if (!empty($value)) {
                            $arrValue = explode('_', $value);
                            $stgValue = null;
                            foreach ($arrValue as $v) {
                                if (empty($stgValue)) {
                                    $stgValue = $v;
                                } else {
                                    $stgValue = $stgValue . ' ' . $v;
                                }
                            }
//                            echo '<li><a href="' . base_url() . $url . '">' . ucwords($stgValue) . '</a></li>';
                            echo '<li>' . ucwords($stgValue) . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>

            <?php
            if ($view == 'main') {
                $this->load->view('beranda');
            } else {
                $this->load->view($view);
            }
            ?>
            <div data-role="dialog" id="modalEditProfil" class="padding20 text-bold" data-close-button="true" data-width="50%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false" data-color="fg-green">
                <div class="row">
                    <h3 class="text-light fg-orange"><span class="icon mif-pencil small bg-orange fg-white cycle-button"></span> Ubah Profil</h3>
                    <hr class="bg-orange"/>
                    <form id="form_profil" method="POST" action="<?php echo base_url(); ?>/pengguna/ubahprofil" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white">
                        <div class="grid">
                            <input name="penID" type="hidden">
                            <input name="pegID" type="hidden">
                            <div class="row cells12">
                                <div class="cell colspan3"><label>Nip </label><label class="fg-red">*</label></div>
                                <div class="cell colspan7">
                                    <div class="input-control text success full-size">
                                        <input name="pegNip" type="text" data-validate-func="required" data-validate-hint="Data Nip Tidak Boleh Kosong..!" disabled>
                                        <span class="input-state-error mif-warning"></span>
                                    </div></div>
                            </div>
                            <div class="row cells12">
                                <div class="cell colspan3"><label>Username </label><label class="fg-red">*</label></div>
                                <div class="cell colspan7">
                                    <div class="input-control text success full-size">
                                        <input name="penUsername" type="text" data-validate-func="required" data-validate-hint="Data Username Tidak Boleh Kosong..!">
                                        <span class="input-state-error mif-warning"></span>
                                    </div></div>
                            </div>
                            <div class="row cells12">
                                <div class="cell colspan3"><label>Nama </label><label class="fg-red">*</label></div>
                                <div class="cell colspan7">
                                    <div class="input-control text success full-size">
                                        <input name="pegNama" type="text" data-validate-func="required" data-validate-hint="Data Nama Tidak Boleh Kosong..!">
                                        <span class="input-state-error mif-warning"></span>
                                    </div></div>
                            </div>
                            <div class="row cells12">
                                <div class="cell colspan3"><label>Email </label></div>
                                <div class="cell colspan7">
                                    <div class="input-control text success full-size">
                                        <input name="pegEmail" type="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row cells12">
                                <div class="cell colspan3"><label>Keterangan</label></div>
                                <div class="cell colspan9"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                        <textarea name="pegKet"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                            <div class="row cells12" id="btnFormPegawai">
                                <div class="cell colspan7"></div>
                                <div class="cell colspan5 place-right">
                                    <button type="submit" class="button success"><span class="mif-floppy-disk"></span> Simpan</button>
                                    <a href="<?php echo base_url().'main'; ?>" class="button alert text-light"><span class="mif-cross"></span> Batal</a>
                                </div>
                            </div>
                        </div>  
                    </form>
                </div>
            </div>
            <div data-role="dialog" id="modalEditSandi" class="padding20 text-bold" data-close-button="true" data-width="50%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false" data-color="fg-green">
                <div class="row">
                    <h3 class="text-light fg-orange"><span class="icon mif-pencil small bg-orange fg-white cycle-button"></span> Ubah Sandi</h3>
                    <hr class="bg-orange"/>
                    <form id="form_sandi" method="POST" action="<?php echo base_url(); ?>pengguna/ubahsandi" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white">
                        <div class="grid">
                            <input name="penID" type="hidden">
                            <div class="row cells12">
                                <div class="cell colspan4"><label>Password Lama</label><label class="fg-red">*</label></div>
                                <div class="cell colspan7"><div class="input-control text success full-size">
                                        <input name="penPasswordOld" type="password" data-validate-func="required" data-validate-hint="Data Password Tidak Boleh Kosong..!">
                                        <span class="input-state-error mif-warning"></span>
                                    </div></div>
                            </div>
                            <div class="row cells12">
                                <div class="cell colspan4"><label>Password Baru</label><label class="fg-red">*</label></div>
                                <div class="cell colspan7"><div class="input-control text success full-size">
                                        <input name="penPasswordNew" type="password" data-validate-func="required" data-validate-hint="Data Password Tidak Boleh Kosong..!">
                                        <span class="input-state-error mif-warning"></span>
                                    </div></div>
                            </div>
                            <div class="row cells12">
                                <div class="cell colspan4"><label>Ulangi Password Baru </label><label class="fg-red">*</label></div>
                                <div class="cell colspan7"><div class="input-control text success full-size">
                                        <input name="penPasswordUlangNew" type="password" data-validate-func="required" data-validate-hint="Data Password Tidak Boleh Kosong..!">
                                        <span class="input-state-error mif-warning"></span>
                                    </div></div>
                            </div>
                            <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                            <div class="row cells12" id="btnFormPegawai">
                                <div class="cell colspan7"></div>
                                <div class="cell colspan5 place-right">
                                    <button type="submit" class="button success"><span class="mif-floppy-disk"></span> Simpan</button>
                                    <a href="<?php echo base_url().'main'; ?>" class="button alert text-light"><span class="mif-cross"></span> Batal</a>
                                </div>
                            </div>
                        </div>  
                    </form>
                </div>
            </div>
            <div data-role="dialog" id="modal_konfirm_db" class="padding20" data-close-button="true" data-type="success" data-width="30%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false">
                <h3 class="text-light fg-white"><span class="icon mif-question small bg-green fg-white cycle-button"></span> Konfirmasi ?</h3>
                <hr class="bg-white"/>
                <p>
                    Apakah Anda Yakin Ingin Mem-Back Up Basis Data ?
                </p>
                <div class="grid">
                    <div class="row cells12">
                        <div class="cell colspan4"></div>
                        <div class="cell colspan8 place-right">
                            <button onclick="backupbasisdata()" class="button text-accent"><span class="mif-checkmark"></span> Ya</button>
                            <button onclick="metroDialog.close('#modal_konfirm_db')" class="button warning text-accent"><span class="mif-cross"></span> Tidak</button>
                        </div>
                    </div>
                </div> 
            </div>

            <script type="text/javascript">
            $(".tabel tr").not(':first').hover(
                    function() {
                        $(this).css("background", "rgba(122, 214, 29, 0.61)");
                    },
                    function() {
                        $(this).css("background", "");
                    }
            );
            $(function() {
                $('table').DataTable({
                    destroy: true,
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                    "language": {
                        "emptyTable": "Data Tidak Tersedia (Kosong)",
                        "info": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                        "infoEmpty": "Menampilkan 0 - 0 Dari 0 Data",
                        "infoFiltered": "(Pencarian Dari _MAX_ Total Data)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Tampilkan _MENU_ Data",
                        "loadingRecords": "Loading...",
                        "processing": "Processing...",
                        "search": "Pencarian :",
                        "zeroRecords": "Data Yang Dicari Tidak Tersedia",
                        "paginate": {
                            "first": "Awal",
                            "last": "Akhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        }
                    }
                });
            });
            function backupdb() {
                metroDialog.toggle('#modal_konfirm_db');
            }
            function backupbasisdata() {
                window.location.replace('<?php echo base_url() ?>backup_db');
            }
            function editprofil(id) {
                $('#form_profil')[0].reset();
                metroDialog.toggle('#modalEditProfil');
                $.ajax({
                    url: "<?php echo base_url(); ?>pengguna/getbyidforprofil/" + id,
                    type: 'POST',
                    dataType: 'JSON',
                    canche: false,
                    success: function(datax) {
                        $('[name="penID"]').val(datax.penID);
                        $('[name="pegID"]').val(datax.pegID);
                        $('[name="pegNip"]').val(datax.pegNip);
                        $('[name="penUsername"]').val(datax.penUsername);
                        $('[name="pegNama"]').val(datax.pegNama);
                        $('[name="pegEmail"]').val(datax.pegEmail);
                        $('[name="pegKet"]').val(datax.pegKet);
                    }, error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error, Terdapat Kesalahan !');
                    }
                });
            }
            function editsandi(id) {
                $('#form_sandi')[0].reset();
                metroDialog.toggle('#modalEditSandi');
                $('[name="penID"]').val(id);
            }
            setTimeout(function() {Ajax();}, 10000);
            function Ajax(){
                    var $http,$self = arguments.callee;
                    if (window.XMLHttpRequest) {
                        $http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        try {
                            $http = new ActiveXObject('Msxml2.XMLHTTP');
                        } catch(e) {
                            $http = new ActiveXObject('Microsoft.XMLHTTP');
                        }
                    }
                    if ($http) {
                        $http.onreadystatechange = function()
                        {
                            if (/4|^complete$/.test($http.readyState)) {
                                document.getElementById('notif_disposisi').innerHTML = $http.responseText;
                                setTimeout(function(){$self();}, 10000);
                            }

                        };
                        $http.open('GET', '<?php echo base_url();?>disposisi/notifikasi' + '?' + new Date().getTime(), true);
                        $http.send(null);
                    }
                    else  {
                        document.getElementById('notif_disposisi').innerHTML = $http.responseText;
                    }
                }
            </script>
        </div>
        <div class="row cells12">
            <center><h5 class="text-light fg-white"><?php echo $this->config->item('APP_SITE_FOOTER'); ?> </h5></center>
        </div>
    </body>
</html>