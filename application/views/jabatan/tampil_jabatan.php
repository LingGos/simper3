<div class="row">
    <ul class="breadcrumbs" style="background-color: #eeeeee; color: #60a917">
        <li><a href="#"><span class="icon mif-home"></span></a></li>
        <li><a href="#">Breadcrumbs 1</a></li>
        <li><a href="#">Breadcrumbs 2</a></li>
    </ul>
</div>
<div class="row padding20">
    <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Kelola Jabatan <a class="image-button warning place-right" onclick="metroDialog.toggle('#dialog3')">Tambah Data<span class="icon mif-plus bg-darkOrange"></span></a></span></h1>
    <hr class="thin bg-orange">
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
            <tr>
                <td class="align-center"><a href="" class="cycle-button mini-button success"><span class="mif-eye"></span></a>&nbsp;<a href="" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a href="" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                <td class="align-center">123890723212</td>
                <td>Ketua</td>
                <td>Ketua Pengadilan Agma PKU</td>
            </tr>
        </tbody>
    </table>
</div>
<div data-role="dialog" id="dialog3" class="padding20 text-bold" data-close-button="true" data-width="50%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false" data-color="fg-green">
    <div class="row">
        <h3 class="text-light fg-orange"><span class="icon mif-plus small bg-orange fg-white cycle-button"></span> Tambah Jabatan</h3>
        <hr class="bg-orange"/>
        <form data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white">
            <div class="grid">
                <div class="row cells12">
                    <div class="cell colspan3"><label>Nama </label><label class="fg-red">*</label></div>
                    <div class="cell colspan7"><div class="input-control text success full-size">
                            <input type="text" data-validate-func="required" data-validate-hint="Data Nama Tidak Boleh Kosong..!">
                            <span class="input-state-error mif-warning"></span>
                        </div></div>
                </div>
                <div class="row cells12">
                    <div class="cell colspan3"><label>Keterangan</label></div>
                    <div class="cell colspan9"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                            <textarea></textarea>
                        </div>
                    </div>
                </div>
                <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                <div class="row cells12">
                    <div class="cell colspan7"></div>
                    <div class="cell colspan5 place-right">
                        <button  name="penMasukBtn" type="submit" class="button success"><span class="mif-floppy-disk"></span> Simpan</button>
                        <button  name="penMasukBtn" type="button" class="button alert"><span class="mif-cross"></span> Batal</button>
                    </div>
                </div>
            </div>  
        </form>
    </div>
</div>