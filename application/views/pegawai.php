<?php
defined('BASEPATH') OR exit('No direct script access allowed');
switch ($subview) {
    default:
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Kelola Pegawai <a class="image-button warning place-right" onclick="tambah()">Tambah Data<span class="icon mif-plus bg-darkOrange"></span></a></span></h1>
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
                <td class="sortable-column " style="width: 100px">Nip</td>
                <td class="sortable-column sort-asc">Nama</td>
                <td class="sortable-column sort-asc">Unit</td>
                <td class="sortable-column sort-asc">No. Hp</td>
                <td class="sortable-column sort-asc">Email</td>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data_query as $row) {
                        ?>
                        <tr>
                            <td class="align-center"><a onclick="detail('<?php echo $row->pegID; ?>')" class="cycle-button mini-button success"><span class="mif-eye"></span></a>&nbsp;<a onclick="ubah('<?php echo $row->pegID; ?>')" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a onclick="hapus('<?php echo $row->pegID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                            <td class="align-center"><?php echo $row->pegNip; ?></td>
                            <td><?php echo $row->pegNama; ?></td>
                            <td><?php echo $row->uniNama . ' (' . ucwords($row->uniJenis) . ')'; ?></td>
                            <td><?php echo $row->pegNoHP; ?></td>
                            <td><?php echo $row->pegEmail; ?></td>
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
                });
                function tambah() {
                    $('#form_tux')[0].reset();
                    $('#btnFormPegawai').show();
                    $('#btnDetailPegawai').hide();
                    $('#judulTPegawai').show();
                    $('#judulUPegawai').hide();
                    $('#judulDPegawai').hide();
                    metroDialog.toggle('#modalPegawai');
                    $.ajax({
                        url: "<?php echo base_url(); ?>pegawai/getallunit",
                        dataType: "JSON",
                        canche: false,
                        success: function(data) {
                            var options = '<option></option>';
                            for (var i = 0; i < data.length; i++) {
                                options += '<option value="' + data[i].uniID + '">' + data[i].uniNama + '</option>';
                            }
                            $('[name="pegUniID"]').html(options);
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
                    metroDialog.toggle('#modalPegawai');
                    $.ajax({
                        url: "<?php echo base_url(); ?>pegawai/getbyid/" + id,
                        type: 'POST',
                        dataType: 'JSON',
                        canche: false,
                        success: function(datax) {
                            $('[name="pegID"]').val(datax.pegID);
                            $('[name="pegNip"]').val(datax.pegNip);
                            $('[name="pegNama"]').val(datax.pegNama);
                            $('[name="pegNoHP"]').val(datax.pegNoHP);
                            $('[name="pegEmail"]').val(datax.pegEmail);
                            $('[name="pegKet"]').val(datax.pegKet);
                            $.ajax({
                                url: "<?php echo base_url(); ?>pegawai/getallunit",
                                dataType: "JSON",
                                canche: false,
                                success: function(data) {
                                    var options = '';
                                    for (var i = 0; i < data.length; i++) {
                                        if (data[i].uniID == datax.pegUniID) {
                                            options += '<option value="' + data[i].uniID + '" selected>' + data[i].uniNama + '</option>';
                                        } else {
                                            options += '<option value="' + data[i].uniID + '">' + data[i].uniNama + '</option>';
                                        }

                                    }
                                    $('[name="pegUniID"]').html(options);
                                }
                            });
                        }, error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error, Terdapat Kesalahan !');
                        }
                    });
                }
                function detail(id) {
                    $('#form_tux')[0].reset();
                    $('#btnDetailPegawai').show();
                    $('#btnFormPegawai').hide();
                    $('#judulTPegawai').hide();
                    $('#judulUPegawai').hide();
                    $('#judulDPegawai').show();
                    metroDialog.toggle('#modalPegawai');
                    $.ajax({
                        url: "<?php echo base_url(); ?>pegawai/getbyid/" + id,
                        type: 'POST',
                        dataType: 'JSON',
                        canche: false,
                        success: function(datax) {
                            $('[name="pegID"]').val(datax.pegID);
                            $('[name="pegNip"]').val(datax.pegNip);
                            $('[name="pegNama"]').val(datax.pegNama);
                            $('[name="pegNoHP"]').val(datax.pegNoHP);
                            $('[name="pegEmail"]').val(datax.pegEmail);
                            $('[name="pegKet"]').val(datax.pegKet);
                            $.ajax({
                                url: "<?php echo base_url(); ?>pegawai/getallunit",
                                dataType: "JSON",
                                canche: false,
                                success: function(data) {
                                    var options = '';
                                    for (var i = 0; i < data.length; i++) {
                                        if (datax.pegUniID == data[i].uniID) {
                                            options += '<option value="' + data[i].uniID + '" selected>' + data[i].uniNama + '</option>';
                                        } else {
                                            options += '<option value="' + data[i].uniID + '">' + data[i].uniNama + '</option>';
                                        }

                                    }
                                    $('[name="pegUniID"]').html(options);
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
                        url: "<?php echo base_url('pegawai/hapusbyid'); ?>/" + idhapus,
                        dataType: "JSON",
                        success: function(data) {
                            location.reload();
                        }, error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error, Terdapat Kesalahan !');
                        }
                    });
                }

</script>
<div data-role="dialog" id="modalPegawai" class="padding10 text-bold" data-close-button="true" data-width="50%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false" data-color="fg-green">
    <div class="row">
        <h3 class="text-light fg-orange" id="judulTPegawai"><span class="icon mif-plus small bg-orange fg-white cycle-button"></span> Tambah Pegawai</h3>
        <h3 class="text-light fg-orange" id="judulUPegawai"><span class="icon mif-pencil small bg-orange fg-white cycle-button"></span> Ubah Pegawai</h3>
        <h3 class="text-light fg-orange" id="judulDPegawai"><span class="icon mif-list small bg-orange fg-white cycle-button"></span> Detail Pegawai</h3>
        <hr class="bg-orange"/>
        <form id="form_tux" method="POST" action="<?php echo base_url() . $view; ?>/simpan" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white">
            <div class="grid">
                <input name="pegID" type="hidden">
                <div class="row cells12">
                    <div class="cell colspan3"><label>Nip </label><label class="fg-red">*</label></div>
                    <div class="cell colspan5"><div class="input-control text success full-size">
                            <input name="pegNip" type="number" data-validate-func="required" data-validate-hint="Data Nip Tidak Boleh Kosong..!">
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
                    <div class="cell colspan3"><label>Unit </label><label class="fg-red">*</label></div>
                    <div class="cell colspan4">
                        <div class="input-control success full-size">
                            <select class="js-select full-size" name="pegUniID" data-validate-func="required" data-validate-hint="Data Unit Tidak Boleh Kosong..!">
                                <option value="">Pilih Unit</option>
                            </select>
                            <span class="input-state-error mif-warning"></span>
                        </div>
                    </div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>No. HP </label><label class="fg-red">*</label></div>
                    <div class="cell colspan7">
                        <div class="input-control text success full-size">
                            <input name="pegNoHP" type="number" data-validate-func="required" data-validate-hint="Data No.HP Tidak Boleh Kosong..!">
                            <span class="input-state-error mif-warning"></span>
                        </div>
                    </div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>Email </label><label class="fg-red">*</label></div>
                    <div class="cell colspan7">
                        <div class="input-control text success full-size">
                            <input name="pegEmail" type="email" data-validate-func="required" data-validate-hint="Data Email Tidak Boleh Kosong..!">
                            <span class="input-state-error mif-warning"></span>
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
                        <a href="<?php echo base_url().$view; ?>" class="button alert text-light"><span class="mif-cross"></span> Batal</a>
                    </div>
                </div>
                <div class="row cells12" id="btnDetailPegawai">
                    <div class="cell colspan5"></div>
                    <div class="cell colspan3">
                        <a href="<?php echo base_url().$view; ?>" class="button alert text-light"><span class="mif-cross"></span> Tutup</a>
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
