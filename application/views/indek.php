<?php
defined('BASEPATH') OR exit('No direct script access allowed');
switch ($subview) {
    default:
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Kelola Indek <a class="image-button warning place-right" onclick="tambah()">Tambah Data<span class="icon mif-plus bg-darkOrange"></span></a></span></h1>
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
            <table class="dataTable border bordered" data-role="datatable" data-auto-width="false">
                <thead>
                <tr>
                <td style="width: 120px"><center>Aksi</center></td>
                <td class="sortable-column " style="width: 100px">ID</td>
                <td class="sortable-column sort-asc">Nama</td>
                <td class="sortable-column">Keterangan</td>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data_query as $row) {
                        ?>
                        <tr>
                            <td class="align-center"><a onclick="ubah('<?php echo $row->indID; ?>')" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a onclick="hapus('<?php echo $row->indID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                            <td class="align-center"><?php echo $row->indID; ?></td>
                            <td><?php echo $row->indNama; ?></td>
                            <td><?php echo $row->indKet; ?></td>
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
                    $('#form_tu')[0].reset();
                    $('#btnFormUnit').show();
                    $('#btnDetailUnit').hide();
                    $('#judulTUnit').show();
                    $('#judulUUnit').hide();
                    $('#judulDUnit').hide();
                    metroDialog.toggle('#modalUnit');
                }
                function ubah(id) {
                    $('#form_tu')[0].reset();
                    $('#btnDetailUnit').hide();
                    $('#btnFormUnit').show();
                    $('#judulTUnit').hide();
                    $('#judulUUnit').show();
                    $('#judulDUnit').hide();
                    metroDialog.toggle('#modalUnit');
                    $.ajax({
                        url: "<?php echo base_url(); ?>indek/getbyid/" + id,
                        type: 'POST',
                        dataType: 'JSON',
                        canche: false,
                        success: function(data) {
                            $('[name="indID"]').val(data.indID);
                            $('[name="indNama"]').val(data.indNama);
                            $('[name="indKet"]').val(data.indKet);
                            
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
                        url: "<?php echo base_url('indek/hapusbyid'); ?>/" + idhapus,
                        dataType: "JSON",
                        success: function(data) {
                            location.reload();
                        }, error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error, Terdapat Kesalahan !');
                        }
                    });
                }
</script>
<div data-role="dialog" id="modalUnit" class="padding20 text-bold" data-close-button="true" data-width="50%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false" data-color="fg-green">
    <div class="row">
        <h3 class="text-light fg-orange" id="judulTUnit"><span class="icon mif-plus small bg-orange fg-white cycle-button"></span> Tambah Indek</h3>
        <h3 class="text-light fg-orange" id="judulUUnit"><span class="icon mif-pencil small bg-orange fg-white cycle-button"></span> Ubah Indek</h3>
        <h3 class="text-light fg-orange" id="judulDUnit"><span class="icon mif-list small bg-orange fg-white cycle-button"></span> Detail Indek</h3>
        <hr class="bg-orange"/>
        <form id="form_tu" method="POST" action="<?php echo base_url() . $view; ?>/simpan" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white">
            <div class="grid">
                <input name="indID" type="hidden">
                <div class="row cells12">
                    <div class="cell colspan3"><label>Nama </label><label class="fg-red">*</label></div>
                    <div class="cell colspan7"><div class="input-control text success full-size">
                            <input name="indNama" type="text" data-validate-func="required" data-validate-hint="Data Nama Tidak Boleh Kosong..!">
                            <span class="input-state-error mif-warning"></span>
                        </div></div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>Keterangan</label></div>
                    <div class="cell colspan9"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                            <textarea name="indKet"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                <div class="row cells12" id="btnFormUnit">
                    <div class="cell colspan7"></div>
                    <div class="cell colspan5 place-right">
                        <button type="submit" class="button success"><span class="mif-floppy-disk"></span> Simpan</button>
                        <a href="<?php echo base_url().$view; ?>" class="button alert text-light"><span class="mif-cross"></span> Batal</a>
                    </div>
                </div>
                <div class="row cells12" id="btnDetailUnit">
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
