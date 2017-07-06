<?php
defined('BASEPATH') OR exit('No direct script access allowed');
switch ($subview) {
    default:
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Kelola Pengguna <a class="image-button warning place-right" onclick="tambah()">Tambah Data<span class="icon mif-plus bg-darkOrange"></span></a></span></h1>
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
            <table class="dataTable border bordered tabel" data-role="datatable" data-auto-width="false">
                <thead>
                    <tr>
                        <td style="width: 120px"><center>Aksi</center></td>
                <td class="sortable-column" style="width: 100px"><center>Nip</center></td>
                <td class="sortable-column  sort-asc"><center>Nama</center></td>
                <td class="sortable-column "><center>Unit</center></td>
                <td ><center>Username</center></td>
                <td class="sortable-column "><center>Level</center></td>
                <td class="sortable-column "><center>Status</center></td>

                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data_query as $row) {
                        ?>
                        <tr>
                            <td class="align-center"><a onclick="ubah('<?php echo $row->penID; ?>')" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a onclick="hapus('<?php echo $row->penID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                            <td class="align-center"><?php echo $row->pegNip; ?></td>
                            <td><?php echo $row->pegNama; ?></td>
                            <td><?php echo $row->uniNama . ' (' . ucwords($row->uniJenis) . ')'; ?></td>
                            <td><?php echo $row->penUsername; ?></td>
                            <td class="align-center"><?php echo $row->penLevel; ?></td>
                            <td class="align-center"><?php echo (($row->penStatus == 'Y') ? '<span class="tag warning">Aktif</span>' : '<span class="tag alert">Tidak Aktif</span>'); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        break;
}
?>
<script type="text/javascript">
                $(document).ready(function() {
                    $("#notif").fadeOut(7000);
                    $('[name="penPegID"]').on("change", function() {
                        if ($('[name="penPegID"]').val() == null || $('[name="penPegID"]').val() == "") {
                            $('[name="penUsername"]').val("");
                            $('[name="penPegID"]').focus();
                        } else {
                            $.ajax({
                                url: "<?php echo base_url(); ?>pengguna/getpegawaibyid/" + $('[name="penPegID"]').val(),
                                dataType: "JSON",
                                type: "POST",
                                canche: false,
                                success: function(data) {
                                    $('[name="penUsername"]').val(data.pegNip);
                                }
                            });
                        }
                    });
                    $('[name="penStatus"]').click(function(e) {
                        var isChecked = $('[name="penStatus"]').is(":checked");
                        if (isChecked == true) {
                            $('[name="penStatus"]').val('Y');
                        } else {
                            $('[name="penStatus"]').val('N');
                        }
                    });
                });
                function tambah() {
                    $('#form_tux')[0].reset();
                    $('#btnFormPegawai').show();
                    $('#btnDetailPegawai').hide();
                    $('#judulTPegawai').show();
                    $('#judulUPegawai').hide();
                    $('#judulDPegawai').hide();
                    metroDialog.toggle('#modalPengguna');
                    $('[name="penPegID"]').focus();
                    $.ajax({
                        url: "<?php echo base_url(); ?>pengguna/getallpegawai",
                        dataType: "JSON",
                        canche: false,
                        success: function(data) {
                            var options = '<option value="">Pilih Pegawai</option>';
                            for (var i = 0; i < data.length; i++) {
                                options += '<option value="' + data[i].pegID + '">' + data[i].pegNip + ' | ' + data[i].pegNama + '</option>';
                            }
                            $('[name="penPegID"]').html(options);
                        }
                    });
                }
                function ubah(id) {
                    $('#form_tux')[0].reset();
                    $('#btnFormPegawai').show();
                    $('#btnDetailPegawai').hide();
                    $('#judulTPegawai').hide();
                    $('#judulUPegawai').show();
                    $('#judulDPegawai').hide();
                    metroDialog.toggle('#modalPengguna');
                    $.ajax({
                        url: "<?php echo base_url(); ?>pengguna/getbyid/" + id,
                        type: 'POST',
                        dataType: 'JSON',
                        canche: false,
                        success: function(datax) {
                            $('[name="penID"]').val(datax.penID);
                            $('[name="penUsername"]').val(datax.penUsername);
                            $('[name="penPassword"]').attr('placeholder', 'Isi Bila Password Dirubah !');
                            $('[name="penPasswordUlang"]').attr('placeholder', 'Isi Bila Password Dirubah !');
                            var level = ['PIMPINAN', 'SEKRETARIS/PANITERA', 'KASUBAG/PANMUD','KASUBAGUMUM', 'STAFF', 'TAMU'];
                            var options = '';
                            for (var i = 0; i < level.length; i++) {
                                if (level[i] == datax.penLevel) {
                                    options += '<option value="' + level[i] + '" selected>' + level[i] + '</option>';
                                } else {
                                    options += '<option value="' + level[i] + '">' + level[i] + '</option>';
                                }
                            }
                            $('[name="penLevel"]').html(options);
                            if (datax.penStatus == 'N') {
                                $('[name="penStatus"]').removeAttr('checked');
                                $('[name="penStatus"]').val('N');
                            }

                            $.ajax({
                                url: "<?php echo base_url(); ?>pengguna/getallpegawai",
                                dataType: "JSON",
                                canche: false,
                                success: function(data) {
                                    var options = '<option value="">Pilih Pegawai</option>';
                                    for (var i = 0; i < data.length; i++) {
                                        if (data[i].pegID == datax.penPegID) {
                                            options += '<option value="' + data[i].pegID + '" selected>' + data[i].pegNip + ' | ' + data[i].pegNama + '</option>';
                                        } else {
                                            options += '<option value="' + data[i].pegID + '">' + data[i].pegNip + ' | ' + data[i].pegNama + '</option>';
                                        }

                                    }
                                    $('[name="penPegID"]').html(options);
                                    $('[name="penPegID"]').attr('disabled', true);
                                }
                            });
                        }, error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error, Terdapat Kesalahan !');
                        }
                    });
                }
                var idhapus;
                function hapus(id) {
                    idhapus = id;
                    metroDialog.toggle('#modal_konfirm');
                }
                function hapusdata() {
                    $.ajax({
                        url: "<?php echo base_url('pengguna/hapusbyid'); ?>/" + idhapus,
                        dataType: "JSON",
                        success: function(data) {
                            location.reload();
                        }, error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error, Terdapat Kesalahan !');
                        }
                    });
                }

</script>
<div data-role="dialog" id="modalPengguna" class="padding20 text-bold" data-close-button="true" data-width="50%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false" data-color="fg-green">
    <div class="row">
        <h3 class="text-light fg-orange" id="judulTPegawai"><span class="icon mif-plus small bg-orange fg-white cycle-button"></span> Tambah Pengguna</h3>
        <h3 class="text-light fg-orange" id="judulUPegawai"><span class="icon mif-pencil small bg-orange fg-white cycle-button"></span> Ubah Pengguna</h3>
        <h3 class="text-light fg-orange" id="judulDPegawai"><span class="icon mif-list small bg-orange fg-white cycle-button"></span> Detail Pengguna</h3>
        <hr class="bg-orange"/>
        <form id="form_tux" method="POST" action="<?php echo base_url() . $view; ?>/simpan" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white">
            <div class="grid">
                <input name="penID" type="hidden">
                <div class="row cells12">
                    <div class="cell colspan3"><label>Pegawai </label><label class="fg-red">*</label></div>
                    <div class="cell colspan7">
                        <div class="input-control success full-size">
                            <select class="full-size" name="penPegID" data-validate-func="required" data-validate-hint="Data Pengguna Tidak Boleh Kosong..!">
                            </select>
                            <span class="input-state-error mif-warning"></span>
                        </div>
                    </div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>Username </label><label class="fg-red">*</label></div>
                    <div class="cell colspan6"><div class="input-control text success full-size">
                            <input name="penUsername" type="text" data-validate-func="required" data-validate-hint="Data Username Tidak Boleh Kosong..!">
                            <span class="input-state-error mif-warning"></span>
                        </div></div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>Password </label><label class="fg-red">*</label></div>
                    <div class="cell colspan5"><div class="input-control text success full-size">
                            <input name="penPassword" type="password" data-validate-func="required" data-validate-hint="Data Password Tidak Boleh Kosong..!">
                            <span class="input-state-error mif-warning"></span>
                        </div></div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>Ulangi Password </label><label class="fg-red">*</label></div>
                    <div class="cell colspan5"><div class="input-control text success full-size">
                            <input name="penPasswordUlang" type="password" data-validate-func="required" data-validate-hint="Data Password Tidak Boleh Kosong..!">
                            <span class="input-state-error mif-warning"></span>
                        </div></div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>Level </label><label class="fg-red">*</label></div>
                    <div class="cell colspan6">
                        <div class="input-control success full-size">
                            <select class="full-size" name="penLevel" data-validate-func="required" data-validate-hint="Data Pengguna Tidak Boleh Kosong..!">
                                <option value="">Pilih Level</option>
                                <option value="PIMPINAN">Pimpinan</option>
                                <option value="SEKRETARIS/PANITERA">Sekretaris/Panitera</option>
                                <option value="KASUBAG/PANMUD">Kasubag/Panmud</option>
                                <option value="KASUBAGUMUM">Kasubag Umum</option>
                                <option value="STAFF">Staff</option>
                                <option value="TAMU">Tamu</option>
                            </select>
                            <span class="input-state-error mif-warning"></span>
                        </div>
                    </div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>Status </label><label class="fg-red">*</label></div>
                    <div class="cell colspan5"><div class="input-control text success full-size">
                            <label class="switch">
                                <input type="checkbox" name="penStatus" value="Y" checked>
                                <span class="check"></span>
                            </label>
                            <span class="input-state-error mif-warning"></span>
                        </div></div>
                </div>
                <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                <div class="row cells12" id="btnFormPegawai">
                    <div class="cell colspan7"></div>
                    <div class="cell colspan5 place-right">
                        <button type="submit" class="button success"><span class="mif-floppy-disk"></span> Simpan</button>
                        <a href="<?php echo base_url() . $view; ?>" class="button alert text-light"><span class="mif-cross"></span> Batal</a>
                    </div>
                </div>
                <div class="row cells12" id="btnDetailPegawai">
                    <div class="cell colspan5"></div>
                    <div class="cell colspan3">
                        <a href="<?php echo base_url() . $view; ?>" class="button alert text-light"><span class="mif-cross"></span> Tutup</a>
                    </div>
                    <div class="cell colspan4"></div>
                </div>
            </div>  
        </form>
    </div>
</div>
<div data-role="dialog" id="modal_konfirm" class="padding20" data-close-button="true" data-type="alert" data-width="30%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false">
    <h3 class="text-light fg-white"><span class="icon mif-question small bg-red fg-white cycle-button"></span> Konfirmasi ?</h3>
    <hr class="bg-orange"/>
    <p>
        Apakah Anda Yakin Ingin Menghapus Data Ini ?
    </p>
    <div class="grid">
        <div class="row cells12">
            <div class="cell colspan4"></div>
            <div class="cell colspan8 place-right">
                <button onclick="hapusdata()" class="button text-accent"><span class="mif-checkmark"></span> Ya</button>
                <button onclick="metroDialog.close('#modal_konfirm')" class="button primary text-accent"><span class="mif-cross"></span> Tidak</button>
            </div>
        </div>
    </div> 
</div>
