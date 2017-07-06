<?php
defined('BASEPATH') OR exit('No direct script access allowed');
switch ($subview) {
    default:
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Kelola Klasifikasi 
                <div class="dropdown-button place-right active-container orange">
                    <button class="button dropdown-toggle fg-white image-button bg-orange">Tambah Data<span class="icon mif-plus bg-darkOrange fg-white"></span></button>
                    <ul class="split-content d-menu place-left orange" data-role="dropdown" style="display: none;">
                        <li><a onclick="tambahlevel1()">Kode Sub-1</a></li>
                        <li><a onclick="tambahlevel2()">Kode Sub-2</a></li>
                        <li><a onclick="tambahlevel3()">Kode Sub-3</a></li>
                    </ul>
                </div>
            </h1>
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
                <td data-sortable="false" style="width: 140px"><center>Aksi</center></td>
                <td data-sortable="false" style="width: 150px"><center>Nomor</center></td>
                <td data-sortable="false" style="width: 100px">Kode</td>
                <td data-sortable="false">Nama</td>
                <td data-sortable="false">Uraian</td>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($data_query as $row) {
                        ?>
                        <tr>
                            <td class="align-right"><a onclick="tambahitem('<?php echo $row->klaID; ?>')" class="cycle-button mini-button success"><span class="mif-plus"></span></a>&nbsp;<a  onclick="ubah('<?php echo $row->klaID; ?>')" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a onclick="hapus('<?php echo $row->klaID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                            <td><?php echo $no; ?></td>
                            <td class="align-center"><?php echo $row->klaKode; ?></td>
                            <td><?php echo $row->klaNama; ?></td>
                            <td><?php echo ucwords($row->klaUraian); ?></td>
                        </tr>
                        <?php
                        $ci = &get_instance();
                        $ci->load->model('KlasifikasiModel');
                        $data_query2 = $ci->KlasifikasiModel->getbyidparent($row->klaID);
                        $no2 = 1;
                        foreach ($data_query2 as $row2) {
                            ?>
                            <tr>
                                <td class="align-right"><a  onclick="tambahitem('<?php echo $row2->klaID; ?>')" class="cycle-button mini-button success"><span class="mif-plus"></span></a>&nbsp;<a onclick="ubahitem('<?php echo $row2->klaID.'/'.$row->klaID; ?>')" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a onclick="hapus('<?php echo $row2->klaID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                                <td><?php echo $no . '.' . $no2; ?></td>
                                <td class="align-center"><?php echo $row->klaKode.'.'.$row2->klaKode; ?></td>
                                <td><?php echo $row2->klaNama; ?></td>
                                <td><?php echo ucwords($row2->klaUraian); ?></td>
                            </tr>
                            <?php
                            $data_query333 = $ci->KlasifikasiModel->getbyidparent($row2->klaID);
                            $no3 = 1;
                            foreach ($data_query333 as $row3) {
                                ?>
                               <tr>
                                   <td class="align-right"><a style="display: none;"></a>&nbsp;<a onclick="ubahitem('<?php echo $row3->klaID.'/'.$row2->klaID; ?>')" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a onclick="hapus('<?php echo $row3->klaID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                                    <td><?php echo $no . '.' . $no2 . '.' . $no3; ?></td>
                                    <td class="align-center"><?php echo $row->klaKode.'.'.$row2->klaKode.'.'.$row3->klaKode; ?></td>
                                    <td><?php echo $row3->klaNama; ?></td>
                                    <td><?php echo ucwords($row3->klaUraian); ?></td>
                                </tr> 

                                <?php
                                    
                                $no3++;
                            }
                            ?>
                            <?php
                            $no2++;
                        }
                        ?>
                        <?php
                        $no++;
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
                
                function tambahlevel1() {
                    $('#form_tu')[0].reset();
                    $('#btnFormUnit').show();
                    $('#btnDetailUnit').hide();
                    $('#judulTUnit').show();
                    $('#judulUUnit').hide();
                    $('#judulDUnit').hide();
                    $('.kodeinduk').hide();
                    metroDialog.toggle('#modalUnit');
                }
                function ubah(id) {
                    $('#form_tu')[0].reset();
                    $('#btnDetailUnit').hide();
                    $('#btnFormUnit').show();
                    $('#judulTUnit').hide();
                    $('#judulUUnit').show();
                    $('#judulDUnit').hide();
                    $('.kodeinduk').hide();
                    metroDialog.toggle('#modalUnit');
                    $.ajax({
                        url: "<?php echo base_url(); ?>klasifikasi/getbyid/" + id,
                        type: 'POST',
                        dataType: 'JSON',
                        canche: false,
                        success: function(data) {
                            $('[name="klaID"]').val(data.klaID);
                            $('[name="klaKode"]').val(data.klaKode);
                            $('[name="klaNama"]').val(data.klaNama);
                            $('[name="klaUraian"]').val(data.klaUraian);
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
                        url: "<?php echo base_url('klasifikasi/hapusbyid'); ?>/" + idhapus,
                        dataType: "JSON",
                        success: function(data) {
                            location.reload();
                        }, error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error, Terdapat Kesalahan !');
                        }
                    });
                }

                //kelola tambah&ubah item klasifikasi
                function tambahitem(parent_id) {
                    $('#form_tu')[0].reset();
                    $('#btnFormUnit').show();
                    $('#btnDetailUnit').hide();
                    $('#judulTUnit').show();
                    $('#judulUUnit').hide();
                    $('#judulDUnit').hide();
                    $('.kodeinduk').show();
                    $.ajax({
                        url: "<?php echo base_url(); ?>klasifikasi/getbyid/" + parent_id,
                        type: 'POST',
                        dataType: 'JSON',
                        canche: false,
                        success: function(data) {
                            if (data.klaParentID == null || data.klaParentID == "") {
                                $('[name="klaParentID"]').val(parent_id);
                                $('[name="txt_kodeinduk"]').val(data.klaKode + '(' + data.klaNama + ')');
                            } else {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>klasifikasi/getbyid/" + data.klaParentID,
                                    type: 'POST',
                                    dataType: 'JSON',
                                    canche: false,
                                    success: function(datax) {
                                        $('[name="klaParentID"]').val(parent_id);
                                        $('[name="txt_kodeinduk"]').val(datax.klaKode + '(' + datax.klaNama + ') >> ' + data.klaKode + '(' + data.klaNama + ')');
                                    }, error: function(jqXHR, textStatus, errorThrown) {
                                        alert('Error, Terdapat Kesalahan 2 !');
                                    }
                                });
                            }

                        }, error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error, Terdapat Kesalahan 1 !');
                        }
                    });
                    metroDialog.toggle('#modalUnit');
                }
                function ubahitem(idx) {
                    var residx=idx.split('/');
                    var id=residx[0];
                    var parent_id = residx[1];
                    $('#form_tu')[0].reset();
                    $('#btnDetailUnit').hide();
                    $('#btnFormUnit').show();
                    $('#judulTUnit').hide();
                    $('#judulUUnit').show();
                    $('#judulDUnit').hide();
                    $('.kodeinduk').show();
                    metroDialog.toggle('#modalUnit');
                    $.ajax({
                        url: "<?php echo base_url(); ?>klasifikasi/getbyid/" + id,
                        type: 'POST',
                        dataType: 'JSON',
                        canche: false,
                        success: function(data) {
                            $('[name="klaID"]').val(data.klaID);
                            $('[name="klaParentID"]').val(data.klaParentID);
                            $('[name="klaKode"]').val(data.klaKode);
                            $('[name="klaNama"]').val(data.klaNama);
                            $('[name="klaUraian"]').val(data.klaUraian);
                        }, error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error, Terdapat Kesalahan !');
                        }
                    });
                    $.ajax({
                        url: "<?php echo base_url(); ?>klasifikasi/getbyid/" + parent_id,
                        type: 'POST',
                        dataType: 'JSON',
                        canche: false,
                        success: function(data) {
                            if (data.klaParentID == null || data.klaParentID == "") {
                                $('[name="klaParentID"]').val(parent_id);
                                $('[name="txt_kodeinduk"]').val(data.klaKode + '(' + data.klaNama + ')');
                            } else {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>klasifikasi/getbyid/" + data.klaParentID,
                                    type: 'POST',
                                    dataType: 'JSON',
                                    canche: false,
                                    success: function(datax) {
                                        $('[name="klaParentID"]').val(parent_id);
                                        $('[name="txt_kodeinduk"]').val(datax.klaKode + '(' + datax.klaNama + ') >> ' + data.klaKode + '(' + data.klaNama + ')');
                                    }, error: function(jqXHR, textStatus, errorThrown) {
                                        alert('Error, Terdapat Kesalahan 2 !');
                                    }
                                });
                            }

                        }, error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error, Terdapat Kesalahan 1 !');
                        }
                    });

                }

</script>
<div data-role="dialog" id="modalUnit" class="padding20 text-bold" data-close-button="true" data-width="50%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false" data-color="fg-green">
    <div class="row">
        <h3 class="text-light fg-orange" id="judulTUnit"><span class="icon mif-plus small bg-orange fg-white cycle-button"></span> Tambah Klasifikasi</h3>
        <h3 class="text-light fg-orange" id="judulUUnit"><span class="icon mif-pencil small bg-orange fg-white cycle-button"></span> Ubah Klasifikasi</h3>
        <h3 class="text-light fg-orange" id="judulDUnit"><span class="icon mif-list small bg-orange fg-white cycle-button"></span> Detail Klasifikasi</h3>
        <hr class="bg-orange"/>
        <form id="form_tu" method="POST" action="<?php echo base_url() . $view; ?>/simpan" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white">
            <div class="grid">
                <input name="klaID" type="hidden">
                <input name="klaParentID" type="hidden">
                <div class="row cells12 kodeinduk">
                    <div class="cell colspan3"><label>Kode Induk</label><label class="fg-red">*</label></div>
                    <div class="cell colspan7"><div class="input-control text success full-size">
                            <input name="txt_kodeinduk" type="text" readonly value="">
                        </div></div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>Kode </label><label class="fg-red">*</label></div>
                    <div class="cell colspan7"><div class="input-control text success full-size">
                            <input name="klaKode" type="text" data-validate-func="required" data-validate-hint="Data Kode Tidak Boleh Kosong..!">
                            <span class="input-state-error mif-warning"></span>
                        </div></div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>Nama </label><label class="fg-red">*</label></div>
                    <div class="cell colspan7"><div class="input-control text success full-size">
                            <input name="klaNama" type="text" data-validate-func="required" data-validate-hint="Data Nama Tidak Boleh Kosong..!">
                            <span class="input-state-error mif-warning"></span>
                        </div></div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>Keterangan</label><label class="fg-red">*</label></div>
                    <div class="cell colspan9"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                            <textarea name="klaUraian" data-validate-func="required" data-validate-hint="Data Uraian Tidak Boleh Kosong..!"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                <div class="row cells12" id="btnFormUnit">
                    <div class="cell colspan7"></div>
                    <div class="cell colspan5 place-right">
                        <button type="submit" class="button success"><span class="mif-floppy-disk"></span> Simpan</button>
                        <a href="<?php echo base_url() . $view; ?>" class="button alert text-light"><span class="mif-cross"></span> Batal</a>
                    </div>
                </div>
                <div class="row cells12" id="btnDetailUnit">
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
