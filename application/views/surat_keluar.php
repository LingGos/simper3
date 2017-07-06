<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci = &get_instance();
$ci->load->model('Konfigurasi');
$ci->load->model('SuratMasukModel');
$ci->load->model('PenggunaModel');
$ci->load->model('PegawaiModel');
$ci->load->model('IndekModel');
$ci->load->model('DisposisiModel');
$ci->load->model('KlasifikasiModel');
switch ($subview) {
    case 'ubah_pumum':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Ubah Surat Masuk </h1>
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
            <form id="form_suratmasukpre" method="POST" action="<?php echo base_url() . $view; ?>/simpan_pumum" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white" enctype="multipart/form-data">
                <div class="grid no-margin-top">
                    <input name="surID" type="hidden" value="<?php echo $data_query->surID; ?>">
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Surat Keluar (Rujukan) </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="js-select full-size" name="surIndukID">
                                    <option value="">Pilih Nomor Surat Masuk (Jika Ada)</option>
                                    <?php
                                    $data = $ci->SuratKeluarModel->getall_suratkeluar();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->surID . '" ' . (($row->surID == $data_query->surIndukID) ? 'selected' : '') . '>' . $row->surNomorSurat . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Indeks </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="js-select full-size" name="surIndID" data-validate-func="required" data-validate-hint="Data Indek Tidak Boleh Kosong..!">
                                    <option value="">Pilih Indeks</option>
                                    <?php
                                    $data = $ci->SuratMasukModel->getall_indek();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->indID . '" ' . (($row->indID == $data_query->surIndID) ? 'selected' : '') . '>' . $row->indNama . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Kode Klasifikasi </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class=" js-select full-size" name="surKlaID" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-1 Tidak Boleh Kosong..!">
                                    <option value="">Pilih Kode Sub-1</option>
                                    <?php
                                    $data = $ci->KlasifikasiModel->getall();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->klaID . '" ' . (($row->klaID == $data_query->surKlaID) ? 'selected' : '') . '>' . $row->klaKode.' | ' .$row->klaNama.'</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="js-select full-size" name="surKlaID1" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-2 Tidak Boleh Kosong..!">
                                    <option value="">Pilih Kode Sub-2</option>
                                    <?php
                                    $data = $ci->KlasifikasiModel->getbyidparent($data_query->surKlaID);
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->klaID . '" ' . (($row->klaID == $data_query->surKlaID1) ? 'selected' : '') . '>' . $row->klaKode.' | ' .$row->klaNama.'</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKlaID2" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-3 Tidak Boleh Kosong..!">
                                    <option value="">Pilih Kode Sub-3</option>
                                    <?php
                                    $data = $ci->KlasifikasiModel->getbyidparent($data_query->surKlaID1);
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->klaID . '" ' . (($row->klaID == $data_query->surKlaID2) ? 'selected' : '') . '>' . $row->klaKode.' | ' .$row->klaNama.'</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Urut </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNoUrut" type="number" data-validate-func="required" data-validate-hint="Data Nomor Urut Tidak Boleh Kosong..!" value="<?php echo $data_query->surNoUrut;?>">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;" ><label>Perihal </label><label class="fg-red">*</label></div>
                        <div class="cell colspan6">
                            <div class="input-control text success full-size">
                                <input name="surPerihal" value="<?php echo $data_query->surPerihal; ?>" type="text" data-validate-func="required" data-validate-hint="Data Perihal Tidak Boleh Kosong..!" >
                                <span class="input-state-error mif-warning"></span>
                            </div></div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Ringkasan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan9"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surRingkas" id="surRingkas" data-validate-func="required" data-validate-hint="Data Ringkasan Tidak Boleh Kosong..!"><?php echo $data_query->sumRingkas; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surRingkas', {width: 700, height: 100});
                                CKEDITOR.instances['surRingkas'].setData('<?php echo $data_query->surRingkas; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Lampiran </label><label class="fg-red">*</label></div>
                        <div class="cell colspan1">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surLampiran" value="Y" <?php echo (($data_query->surLampiran == 'Y') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Ada</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="N" name="surLampiran" <?php echo (($data_query->surLampiran == 'N') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Tidak Ada</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Surat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" value="<?php echo $ci->Konfigurasi->dateToFormHtml($data_query->surTglSurat); ?>" name="surTglSurat" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Surat </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNomorSurat" value="<?php echo $data_query->surNomorSurat; ?>" type="text" data-validate-func="required" data-validate-hint="Data Nomor Surat Tidak Boleh Kosong..!">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Asal Surat(Dari)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surDari" id="surDari" data-validate-func="required" data-validate-hint="Data Dari Tidak Boleh Kosong..!"><?php echo $data_query->surDari; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surDari', {width: 700, height: 100});
                                CKEDITOR.instances['surDari'].setData('<?php echo $data_query->surDari; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Tujuan Surat(Kepada)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKepada" id="surKepada" data-validate-func="required" data-validate-hint="Data Kepada Tidak Boleh Kosong..!"><?php echo $data_query->surKepada; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surKepada', {width: 700, height: 100});
                                CKEDITOR.instances['surKepada'].setData('<?php echo $data_query->surKepada; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tingkat Keamanan </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKeamanan" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="" <?php echo (($data_query->surKeamanan == '') ? 'selected' : '') ?>>Pilih Keamanan</option>
                                    <option value="SR" <?php echo (($data_query->surKeamanan == 'SR') ? 'selected' : '') ?>>SR</option>
                                    <option value="R" <?php echo (($data_query->surKeamanan == 'R') ? 'selected' : '') ?>>R</option>
                                    <option value="K" <?php echo (($data_query->surKeamanan == 'K') ? 'selected' : '') ?>>K</option>
                                    <option value="B" <?php echo (($data_query->surKeamanan == 'B') ? 'selected' : '') ?>>B</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Sifat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surSifat" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="" <?php echo (($data_query->surSifat == '') ? 'selected' : '') ?>>Pilih Sifat</option>
                                    <option value="KILAT" <?php echo (($data_query->surSifat == 'KILAT') ? 'selected' : '') ?>>Kilat (1 x 24)</option>
                                    <option value="SEGERA" <?php echo (($data_query->surSifat == 'SEGERA') ? 'selected' : '') ?>>Segera (2 x 24)</option>
                                    <option value="PENTING" <?php echo (($data_query->surSifat == 'PENTING') ? 'selected' : '') ?>>Penting (3 x 24)</option>
                                    <option value="BIASA" <?php echo (($data_query->surSifat == 'BIASA') ? 'selected' : '') ?>>Biasa</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis File </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surJenisFile" value="SC" <?php echo (($data_query->surJenisFile == 'SC') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Soft Copy</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="HC" name="surJenisFile" <?php echo (($data_query->surJenisFile == 'HC') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Hard Copy</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Unggah File </label></div>
                        <div class="cell colspan5">
                            <div class="input-control file success full-size" data-role="input">
                                <input type="file" name="surFile" placeholder="Pilih File Bila File Surat Sebelumnya Ingin Diganti !">
                                <button class="button"><span class="mif-folder"></span></button>
                            </div>
                        </div>
                        <div class="cell colspan3" style="margin-top: 14px;">
                            <label class="fg-red mif-warning"> Hanya File (.pdf) & ukuran max 5Mb </label>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3" style="margin-top: 0px;"></div>
                        <div class="cell colspan5" style="margin-bottom: 10px;"><a class="fg-blue" target="blank" href="<?php echo base_url('surat_masuk/bukafile/' . $data_query->surID); ?>">Klik Lihat File Surat Sebelumnya ...</a></div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Terima</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="surTglTerimaKeluar" value="<?php echo $ci->Konfigurasi->dateToFormHtml($data_query->surTglTerimaKeluar); ?>" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 110px;margin-top: 5px;"><label>Keterangan</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKet" id="surKet"><?php echo $data_query->surKet; ?></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('surKet', {width: 700, height: 100});
                                CKEDITOR.instances['surKet'].setData('<?php echo $data_query->surKet; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <h4> Data Telaah Staff</h4>
                        <hr/>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Tentang</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telTentang" id="telTentang" data-validate-func="required" data-validate-hint="Data Tentang Tidak Boleh Kosong..!"><?php echo $data_query2->telTentang; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telTentang', {width: 800, height: 150});
                                CKEDITOR.instances['telTentang'].setData('<?php echo $data_query2->telTentang; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Persoalan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telPersoalan" id="telPersoalan" data-validate-func="required" data-validate-hint="Data Persoalan Tidak Boleh Kosong..!"><?php echo $data_query2->telPersoalan; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telPersoalan', {width: 800, height: 150});
                                CKEDITOR.instances['telPersoalan'].setData('<?php echo $data_query2->telPersoalan; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Praanggapan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telPraanggapan" id="telPraanggapan" data-validate-func="required" data-validate-hint="Data Praanggapan Tidak Boleh Kosong..!"><?php echo $data_query2->telPraanggapan; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telPraanggapan', {width: 800, height: 150});
                                CKEDITOR.instances['telPraanggapan'].setData('<?php echo $data_query2->telPraanggapan; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Fakta</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telFakta" id="telFakta" data-validate-func="required" data-validate-hint="Data Fakta Tidak Boleh Kosong..!"><?php echo $data_query2->telFakta; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telFakta', {width: 800, height: 150});
                                CKEDITOR.instances['telFakta'].setData('<?php echo $data_query2->telFakta; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Analisis</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telAnalisis" id="telAnalisis" data-validate-func="required" data-validate-hint="Data Analisis Tidak Boleh Kosong..!"><?php echo $data_query2->telAnalisis; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telAnalisis', {width: 800, height: 150});
                                CKEDITOR.instances['telAnalisis'].setData('<?php echo $data_query2->telAnalisis; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Simpulan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telSimpulan" id="telSimpulan" data-validate-func="required" data-validate-hint="Data Simpulan Tidak Boleh Kosong..!"><?php echo $data_query2->telSimpulan; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telSimpulan', {width: 800, height: 150});
                                CKEDITOR.instances['telSimpulan'].setData('<?php echo $data_query2->telSimpulan; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Saran</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telSaran" id="telSaran" data-validate-func="required" data-validate-hint="Data Saran Tidak Boleh Kosong..!"><?php echo $data_query2->telSaran; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telSaran', {width: 800, height: 150});
                                CKEDITOR.instances['telSaran'].setData('<?php echo $data_query2->telSaran; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                    <div class="row cells12 bg-green fg-white padding10" style="height: 60px;" >
                        <div class="cell colspan3"></div>
                        <div class="cell colspan9">
                            <button type="submit" class="button text-light fg-green"><span class="mif-floppy-disk"></span> Simpan</button>
                            <a href="<?php echo base_url() . $view; ?>" class="button warning text-light"><span class="mif-cross"></span> Batal</a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>
        <?php
        break;
    case 'ubah_ptabayun':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Ubah Surat Masuk </h1>
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
            <form id="form_suratmasukpre" method="POST" action="<?php echo base_url() . $view; ?>/simpan_ptabayun" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white" enctype="multipart/form-data">
                <div class="grid no-margin-top">
                    <input name="surID" type="hidden" value="<?php echo $data_query->surID; ?>">
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Surat Keluar (Rujukan) </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surIndukID">
                                    <option value="">Pilih Nomor Surat Keluar (Jika Ada)</option>
                                    <?php
                                    $data = $ci->SuratMasukModel->getall_suratkeluar();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->surID . '" ' . (($row->surID == $data_query->surIndukID) ? 'selected' : '') . '>' . $row->surNomorSurat . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Indeks </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surIndID" data-validate-func="required" data-validate-hint="Data Indek Tidak Boleh Kosong..!">
                                    <option value="">Pilih Indeks</option>
                                    <?php
                                    $data = $ci->SuratMasukModel->getall_indek();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->indID . '" ' . (($row->indID == $data_query->surIndID) ? 'selected' : '') . '>' . $row->indNama . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Kode Klasifikasi </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKlaID" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-1 Tidak Boleh Kosong..!">
                                    <option value="">Pilih Kode Sub-1</option>
                                    <?php
                                    $data = $ci->KlasifikasiModel->getall();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->klaID . '" ' . (($row->klaID == $data_query->surKlaID) ? 'selected' : '') . '>' . $row->klaKode.' | ' .$row->klaNama.'</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKlaID1" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-2 Tidak Boleh Kosong..!">
                                    <option value="">Pilih Kode Sub-2</option>
                                    <?php
                                    $data = $ci->KlasifikasiModel->getbyidparent($data_query->surKlaID);
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->klaID . '" ' . (($row->klaID == $data_query->surKlaID1) ? 'selected' : '') . '>' . $row->klaKode.' | ' .$row->klaNama.'</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKlaID2" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-3 Tidak Boleh Kosong..!">
                                    <option value="">Pilih Kode Sub-3</option>
                                    <?php
                                    $data = $ci->KlasifikasiModel->getbyidparent($data_query->surKlaID1);
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->klaID . '" ' . (($row->klaID == $data_query->surKlaID2) ? 'selected' : '') . '>' . $row->klaKode.' | ' .$row->klaNama.'</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Urut </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNoUrut" type="number" data-validate-func="required" data-validate-hint="Data Nomor Urut Tidak Boleh Kosong..!" value="<?php echo $data_query->surNoUrut;?>">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;" ><label>Perihal </label><label class="fg-red">*</label></div>
                        <div class="cell colspan6">
                            <div class="input-control text success full-size">
                                <input name="surPerihal" value="<?php echo $data_query->surPerihal; ?>" type="text" data-validate-func="required" data-validate-hint="Data Perihal Tidak Boleh Kosong..!" >
                                <span class="input-state-error mif-warning"></span>
                            </div></div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Ringkasan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan9"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surRingkas" id="surRingkas" data-validate-func="required" data-validate-hint="Data Ringkasan Tidak Boleh Kosong..!"><?php echo $data_query->sumRingkas; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surRingkas', {width: 700, height: 100});
                                CKEDITOR.instances['surRingkas'].setData('<?php echo $data_query->surRingkas; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Lampiran </label><label class="fg-red">*</label></div>
                        <div class="cell colspan1">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surLampiran" value="Y" <?php echo (($data_query->surLampiran == 'Y') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Ada</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="N" name="surLampiran" <?php echo (($data_query->surLampiran == 'N') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Tidak Ada</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Surat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" value="<?php echo $ci->Konfigurasi->dateToFormHtml($data_query->surTglSurat); ?>" name="surTglSurat" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Surat </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNomorSurat" value="<?php echo $data_query->surNomorSurat; ?>" type="text" data-validate-func="required" data-validate-hint="Data Nomor Surat Tidak Boleh Kosong..!">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Asal Surat(Dari)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control text success full-size">
                                <input name="surDari" type="text" data-validate-func="required" data-validate-hint="Data Asal Surat Tidak Boleh Kosong..!" placeholder="PA. Padang" value="<?php echo $data_query->surDari;?>">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tujuan Surat(Kepada)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control text success full-size">
                                <input name="surKepada" type="text" value="<?php echo $data_query->surKepada;?>" data-validate-func="required" data-validate-hint="Data Asal Surat Tidak Boleh Kosong..!" placeholder="PA. Pekanbaru" readonly>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tingkat Keamanan </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKeamanan" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="" <?php echo (($data_query->surKeamanan == '') ? 'selected' : '') ?>>Pilih Keamanan</option>
                                    <option value="SR" <?php echo (($data_query->surKeamanan == 'SR') ? 'selected' : '') ?>>SR</option>
                                    <option value="R" <?php echo (($data_query->surKeamanan == 'R') ? 'selected' : '') ?>>R</option>
                                    <option value="K" <?php echo (($data_query->surKeamanan == 'K') ? 'selected' : '') ?>>K</option>
                                    <option value="B" <?php echo (($data_query->surKeamanan == 'B') ? 'selected' : '') ?>>B</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Sifat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surSifat" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="" <?php echo (($data_query->surSifat == '') ? 'selected' : '') ?>>Pilih Sifat</option>
                                    <option value="KILAT" <?php echo (($data_query->surSifat == 'KILAT') ? 'selected' : '') ?>>Kilat (1 x 24)</option>
                                    <option value="SEGERA" <?php echo (($data_query->surSifat == 'SEGERA') ? 'selected' : '') ?>>Segera (2 x 24)</option>
                                    <option value="PENTING" <?php echo (($data_query->surSifat == 'PENTING') ? 'selected' : '') ?>>Penting (3 x 24)</option>
                                    <option value="BIASA" <?php echo (($data_query->surSifat == 'BIASA') ? 'selected' : '') ?>>Biasa</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis File </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surJenisFile" value="SC" <?php echo (($data_query->surJenisFile == 'SC') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Soft Copy</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="HC" name="surJenisFile" <?php echo (($data_query->surJenisFile == 'HC') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Hard Copy</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Unggah File </label></div>
                        <div class="cell colspan5">
                            <div class="input-control file success full-size" data-role="input">
                                <input type="file" name="surFile" placeholder="Pilih File Bila File Surat Sebelumnya Ingin Diganti !">
                                <button class="button"><span class="mif-folder"></span></button>
                            </div>
                        </div>
                        <div class="cell colspan3" style="margin-top: 14px;">
                            <label class="fg-red mif-warning"> Hanya File (.pdf) & ukuran max 5Mb </label>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3" style="margin-top: 0px;"></div>
                        <div class="cell colspan5" style="margin-bottom: 10px;"><a class="fg-blue" target="blank" href="<?php echo base_url('surat_masuk/bukafile/' . $data_query->surID); ?>">Klik Lihat File Surat Sebelumnya ...</a></div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Terima</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="surTglTerimaKeluar" value="<?php echo $ci->Konfigurasi->dateToFormHtml($data_query->surTglTerimaKeluar); ?>" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 110px;margin-top: 5px;"><label>Keterangan</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKet" id="surKet"><?php echo $data_query->surKet; ?></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('surKet', {width: 700, height: 100});
                                CKEDITOR.instances['surKet'].setData('<?php echo $data_query->surKet; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <h4> Data Detail Tabayun</h4>
                        <hr/>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Perkara</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control text success full-size">
                                <input name="perNoPerkara" type="text" data-validate-func="required" data-validate-hint="Data No Perkara Tidak Boleh Kosong..!" placeholder="Nomor Perkara" value="<?php echo $data_query2->perNoPerkara; ?>">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis Tabayun (Relaas)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="perJenisRelaas" data-validate-func="required" data-validate-hint="Data Jenis Relaas Tidak Boleh Kosong..!">
                                    <option value="" <?php echo (($data_query2->perJenisRelaas == '') ? 'selected' : '') ?>>Pilih Jenis Relaas</option>
                                    <option value="pemberitahuan" <?php echo (($data_query2->perJenisRelaas == 'pemberitahuan') ? 'selected' : '') ?>>Pemberitahuan</option>
                                    <option value="panggilan" <?php echo (($data_query2->perJenisRelaas == 'panggilan') ? 'selected' : '') ?>>Panggilan</option>
                                    <option value="inzage" <?php echo (($data_query2->perJenisRelaas == 'inzage') ? 'selected' : '') ?>>Inzage</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Terima</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="perTglPutusSidangInzage" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!" value="<?php echo $ci->Konfigurasi->dateToFormHtml($data_query2->perTglPutusSidangInzage); ?>">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis Identitas</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="perJenisIdentitas" data-validate-func="required" data-validate-hint="Data Jenis Relaas Tidak Boleh Kosong..!">
                                    <option value="" <?php echo (($data_query2->perJenisIdentitas == '') ? 'selected' : '') ?>>Pilih Jenis Identitas</option>
                                    <option value="penggugat" <?php echo (($data_query2->perJenisIdentitas == 'penggugat') ? 'selected' : '') ?>>Penggugat</option>
                                    <option value="tergugat" <?php echo (($data_query2->perJenisIdentitas == 'tergugat') ? 'selected' : '') ?>>Tergugat</option>
                                    <option value="pemohon" <?php echo (($data_query2->perJenisIdentitas == 'pemohon') ? 'selected' : '') ?>>Pemohon</option>
                                    <option value="termohon" <?php echo (($data_query2->perJenisIdentitas == 'termohon') ? 'selected' : '') ?>>Termohon</option>
                                    <option value="turut_tergugat" <?php echo (($data_query2->perJenisIdentitas == 'turut_tergugat') ? 'selected' : '') ?>>Turut Tergugat</option>
                                    <option value="pemohon_banding" <?php echo (($data_query2->perJenisIdentitas == 'pemohon_banding') ? 'selected' : '') ?>>Pemohon Banding</option>
                                    <option value="termohon_banding" <?php echo (($data_query2->perJenisIdentitas == 'termohon_banding') ? 'selected' : '') ?>>Termohon Banding</option>
                                    <option value="pemohon_kasasi" <?php echo (($data_query2->perJenisIdentitas == 'pemohon_kasasi') ? 'selected' : '') ?>>Pemohon Kasasi</option>
                                    <option value="termohon_kasasi" <?php echo (($data_query2->perJenisIdentitas == 'termohon_kasasi') ? 'selected' : '') ?>>Termohon Kasasi</option>
                                    <option value="pemohon_pk" <?php echo (($data_query2->perJenisIdentitas == 'pemohon_pk') ? 'selected' : '') ?>>Pemohon Pk</option>
                                    <option value="termohon_pk" <?php echo (($data_query2->perJenisIdentitas == 'termohon_pk') ? 'selected' : '') ?>>Termohon Pk</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nama Ybs</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control text success full-size">
                                <input name="perNama" type="text" data-validate-func="required" data-validate-hint="Data Nama Tidak Boleh Kosong..!" placeholder="Ahmad Zaki ETC bin Apitdin" value="<?php echo $data_query2->perNama;?>">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Keterangan Tabayun</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="perKet" id="perKet"><?php echo $data_query2->perKet; ?></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('perKet', {width: 700, height: 100});
                                CKEDITOR.instances['perKet'].setData('<?php echo $data_query2->perKet; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                    <div class="row cells12 bg-green fg-white padding10" style="height: 60px;" >
                        <div class="cell colspan3"></div>
                        <div class="cell colspan9">
                            <button type="submit" class="button text-light fg-green"><span class="mif-floppy-disk"></span> Simpan</button>
                            <a href="<?php echo base_url() . $view; ?>" class="button warning text-light"><span class="mif-cross"></span> Batal</a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>
        <?php
        break;
    case 'ubah_rahasia':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Ubah Surat Masuk </h1>
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
            <form id="form_suratmasukpre" method="POST" action="<?php echo base_url() . $view; ?>/simpan_rahasia" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white" enctype="multipart/form-data">
                <div class="grid no-margin-top">
                    <input name="surID" type="hidden" value="<?php echo $data_query->surID; ?>">
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Surat Keluar (Rujukan) </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surIndukID">
                                    <option value="">Pilih Nomor Surat Keluar (Jika Ada)</option>
                                    <?php
                                    $data = $ci->SuratMasukModel->getall_suratkeluar();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->surID . '" ' . (($row->surID == $data_query->surIndukID) ? 'selected' : '') . '>' . $row->surNomorSurat . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Urut </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNoUrut" type="number" data-validate-func="required" data-validate-hint="Data Nomor Urut Tidak Boleh Kosong..!" value="<?php echo $data_query->surNoUrut;?>">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Asal Surat(Dari)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surDari" id="surDari" data-validate-func="required" data-validate-hint="Data Dari Tidak Boleh Kosong..!"><?php echo $data_query->surDari; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surDari', {width: 700, height: 100});
                                CKEDITOR.instances['surDari'].setData('<?php echo $data_query->surDari; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Tujuan Surat(Kepada)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKepada" id="surKepada" data-validate-func="required" data-validate-hint="Data Kepada Tidak Boleh Kosong..!"><?php echo $data_query->surKepada; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surKepada', {width: 700, height: 100});
                                CKEDITOR.instances['surKepada'].setData('<?php echo $data_query->surKepada; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tingkat Keamanan </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKeamanan" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="" <?php echo (($data_query->surKeamanan == '') ? 'selected' : '') ?>>Pilih Keamanan</option>
                                    <option value="SR" <?php echo (($data_query->surKeamanan == 'SR') ? 'selected' : '') ?>>SR</option>
                                    <option value="R" <?php echo (($data_query->surKeamanan == 'R') ? 'selected' : '') ?>>R</option>
                                    <option value="K" <?php echo (($data_query->surKeamanan == 'K') ? 'selected' : '') ?>>K</option>
                                    <option value="B" <?php echo (($data_query->surKeamanan == 'B') ? 'selected' : '') ?>>B</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Sifat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surSifat" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="" <?php echo (($data_query->surSifat == '') ? 'selected' : '') ?>>Pilih Sifat</option>
                                    <option value="KILAT" <?php echo (($data_query->surSifat == 'KILAT') ? 'selected' : '') ?>>Kilat (1 x 24)</option>
                                    <option value="SEGERA" <?php echo (($data_query->surSifat == 'SEGERA') ? 'selected' : '') ?>>Segera (2 x 24)</option>
                                    <option value="PENTING" <?php echo (($data_query->surSifat == 'PENTING') ? 'selected' : '') ?>>Penting (3 x 24)</option>
                                    <option value="BIASA" <?php echo (($data_query->surSifat == 'BIASA') ? 'selected' : '') ?>>Biasa</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Terima</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="surTglTerimaKeluar" value="<?php echo $ci->Konfigurasi->dateToFormHtml($data_query->surTglTerimaKeluar); ?>" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 110px;margin-top: 5px;"><label>Keterangan</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKet" id="surKet"><?php echo $data_query->surKet; ?></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('surKet', {width: 700, height: 100});
                                CKEDITOR.instances['surKet'].setData('<?php echo $data_query->surKet; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                    <div class="row cells12 bg-green fg-white padding10" style="height: 60px;" >
                        <div class="cell colspan3"></div>
                        <div class="cell colspan9">
                            <button type="submit" class="button text-light fg-green"><span class="mif-floppy-disk"></span> Simpan</button>
                            <a href="<?php echo base_url() . $view; ?>" class="button warning text-light"><span class="mif-cross"></span> Batal</a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>
        <?php
        break;
    case 'ubah_biasa':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Ubah Surat Masuk </h1>
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
            <form id="form_suratmasukpre" method="POST" action="<?php echo base_url() . $view; ?>/simpan_biasa" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white" enctype="multipart/form-data">
                <div class="grid no-margin-top">
                    <input name="surID" type="hidden" value="<?php echo $data_query->surID; ?>">
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Surat Keluar (Rujukan) </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surIndukID">
                                    <option value="">Pilih Nomor Surat Keluar (Jika Ada)</option>
                                    <?php
                                    $data = $ci->SuratMasukModel->getall_suratkeluar();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->surID . '" ' . (($row->surID == $data_query->surIndukID) ? 'selected' : '') . '>' . $row->surNomorSurat . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Urut </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNoUrut" type="number" data-validate-func="required" data-validate-hint="Data Nomor Urut Tidak Boleh Kosong..!" value="<?php echo $data_query->surNoUrut;?>">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;" ><label>Perihal </label><label class="fg-red">*</label></div>
                        <div class="cell colspan6">
                            <div class="input-control text success full-size">
                                <input name="surPerihal" value="<?php echo $data_query->surPerihal; ?>" type="text" data-validate-func="required" data-validate-hint="Data Perihal Tidak Boleh Kosong..!" >
                                <span class="input-state-error mif-warning"></span>
                            </div></div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Ringkasan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan9"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surRingkas" id="surRingkas" data-validate-func="required" data-validate-hint="Data Ringkasan Tidak Boleh Kosong..!"><?php echo $data_query->sumRingkas; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surRingkas', {width: 700, height: 100});
                                CKEDITOR.instances['surRingkas'].setData('<?php echo $data_query->surRingkas; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Lampiran </label><label class="fg-red">*</label></div>
                        <div class="cell colspan1">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surLampiran" value="Y" <?php echo (($data_query->surLampiran == 'Y') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Ada</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="N" name="surLampiran" <?php echo (($data_query->surLampiran == 'N') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Tidak Ada</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Surat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" value="<?php echo $ci->Konfigurasi->dateToFormHtml($data_query->surTglSurat); ?>" name="surTglSurat" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Surat </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNomorSurat" value="<?php echo $data_query->surNomorSurat; ?>" type="text" data-validate-func="required" data-validate-hint="Data Nomor Surat Tidak Boleh Kosong..!">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Asal Surat(Dari)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surDari" id="surDari" data-validate-func="required" data-validate-hint="Data Dari Tidak Boleh Kosong..!"><?php echo $data_query->surDari; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surDari', {width: 700, height: 100});
                                CKEDITOR.instances['surDari'].setData('<?php echo $data_query->surDari; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Tujuan Surat(Kepada)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKepada" id="surKepada" data-validate-func="required" data-validate-hint="Data Kepada Tidak Boleh Kosong..!"><?php echo $data_query->surKepada; ?></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surKepada', {width: 700, height: 100});
                                CKEDITOR.instances['surKepada'].setData('<?php echo $data_query->surKepada; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tingkat Keamanan </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKeamanan" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="" <?php echo (($data_query->surKeamanan == '') ? 'selected' : '') ?>>Pilih Keamanan</option>
                                    <option value="SR" <?php echo (($data_query->surKeamanan == 'SR') ? 'selected' : '') ?>>SR</option>
                                    <option value="R" <?php echo (($data_query->surKeamanan == 'R') ? 'selected' : '') ?>>R</option>
                                    <option value="K" <?php echo (($data_query->surKeamanan == 'K') ? 'selected' : '') ?>>K</option>
                                    <option value="B" <?php echo (($data_query->surKeamanan == 'B') ? 'selected' : '') ?>>B</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Sifat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surSifat" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="" <?php echo (($data_query->surSifat == '') ? 'selected' : '') ?>>Pilih Sifat</option>
                                    <option value="KILAT" <?php echo (($data_query->surSifat == 'KILAT') ? 'selected' : '') ?>>Kilat (1 x 24)</option>
                                    <option value="SEGERA" <?php echo (($data_query->surSifat == 'SEGERA') ? 'selected' : '') ?>>Segera (2 x 24)</option>
                                    <option value="PENTING" <?php echo (($data_query->surSifat == 'PENTING') ? 'selected' : '') ?>>Penting (3 x 24)</option>
                                    <option value="BIASA" <?php echo (($data_query->surSifat == 'BIASA') ? 'selected' : '') ?>>Biasa</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis File </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surJenisFile" value="SC" <?php echo (($data_query->surJenisFile == 'SC') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Soft Copy</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="HC" name="surJenisFile" <?php echo (($data_query->surJenisFile == 'HC') ? 'checked' : '') ?>>
                                    <span class="check"></span>
                                    <span class="caption">Hard Copy</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Terima</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="surTglTerimaKeluar" value="<?php echo $ci->Konfigurasi->dateToFormHtml($data_query->surTglTerimaKeluar); ?>" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Keterangan</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKet" id="surKet"><?php echo $data_query->surKet; ?></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('surKet', {width: 700, height: 100});
                                CKEDITOR.instances['surKet'].setData('<?php echo $data_query->surKet; ?>');
                            </script>
                        </div>
                    </div>
                    <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                    <div class="row cells12 bg-green fg-white padding10" style="height: 60px;" >
                        <div class="cell colspan3"></div>
                        <div class="cell colspan9">
                            <button type="submit" class="button text-light fg-green"><span class="mif-floppy-disk"></span> Simpan</button>
                            <a href="<?php echo base_url() . $view; ?>" class="button warning text-light"><span class="mif-cross"></span> Batal</a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>
        <?php
        break;
    case 'detail_pumum':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Detail Surat Masuk </h1>
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
            <div class="tabcontrol2" data-role="tabcontrol">
                <ul class="tabs">
                    <li class="active"><a href="#tab-smd-detail"><span class="mif-list2"></span> Detail Surat</a></li>
                    <li><a href="#tab-smd-telaah"><span class="mif-pencil"></span> Telaah Staff</a></li>
                    <li><a href="#tab-smd-file"><span class="mif-file-pdf"></span> File Surat</a></li>
                    <li><a href="#tab-smd-disposisi"><span class="mif-users"></span> Detail Disposisi</a></li>
                </ul>
                <div class="frames">
                    <div class="frame" id="tab-smd-detail">
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <div class="grid no-margin-top">
                                <div class="row cells12 no-margin" style="display: none;">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px"></label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Surat Keluar (Rujukan)</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surIndukID == null) ? '-' : $data_query->surIndukID); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Indek</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->IndekModel->getbyid($data_query->surIndID)->indNama; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Kode Klasifikasi</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->KlasifikasiModel->getbyid($data_query->surKlaID)->klaKode.'/'.$ci->KlasifikasiModel->getbyid($data_query->surKlaID1)->klaKode.'/'.$ci->KlasifikasiModel->getbyid($data_query->surKlaID2)->klaKode ; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">No. Urut</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surNoUrut; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Jenis Surat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surJenis == 'PENTING') ? '<span class="tag success">Penting</span>' : (($data_query->surJenis == 'RAHASIA') ? '<span class="tag warning">Rahasia</span>' : '<span class="tag info">Biasa</span>')); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Surat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surTabayun == 'Y') ? '<span class="tag warning">Tabayun</span>' : '<span class="tag success">Umum</span>'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Perihal</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surPerihal; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Ringkasan</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surRingkas; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Lampiran</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surLampiran == 'Y') ? 'Ada' : 'Tidak Ada'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tanggal Surat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglSurat); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Nomor Surat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surNomorSurat; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Asal Surat(Dari)</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surDari; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tujuan Surat(Kepada)</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surKepada; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Pelaksana</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surPelaksanaPenID !=null)?$ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($data_query->surPelaksanaPenID)->penPegID)->pegNama:'-'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tingkat Keamanan</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surKeamanan; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Sifat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surSifat == 'KILAT') ? '<span class="tag alert">Kilat (1 x 24)</span>' : (($data_query->surSifat == 'SEGERA') ? '<span class="tag warning">Segera (2 x 24)</span>' : (($data_query->surSifat == 'PENTING') ? '<span class="tag info">Penting (3 x 24)</span>' : '<span class="tag success">Biasa</span>'))); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Pengelolah Surat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($data_query->surPengolahPenID)->penPegID)->pegNama; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Jenis File</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surJenisFile == 'SC') ? '<span class="tag warning">Soft-Copy</span>' : '<span class="tag info">Hard-Copy</span>'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Unggah File</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surFile; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tanggal Terima</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglTerimaKeluar); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tanggal Input</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglInput); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tanggal Penyelesaian</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surTglPenyelesaian != null) ? '<span class="tag success" data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Info ?|Target Penyelesaian Tgl : ' . $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglPenyelesaian) . ' ">'.$ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglPenyelesaian).'</span>' : '<span class="tag info">Disposisi</span>'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Status</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surTglSelesai != null) ? '<span class="tag success" data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Info ?|Diselesaikan Tgl : ' . $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglSelesai) . ' ">Selesai</span>' : '<span class="tag info">Disposisi</span>'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Keterangan</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surKet; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="frame" id="tab-smd-telaah">
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <div class="grid no-margin-top">
                                <div class="row cells12 no-margin">
                                    <a class="image-button warning place-right" target="_blank" href="<?php echo base_url() ?>surat_masuk/cetak_telaah_staff/<?php echo strtolower($this->uri->segment(3)); ?>">Cetak Telaah Staff<span class="icon mif-printer bg-darkOrange"></span></a>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Pembuat Telaah Staff</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($data_query2->telPenID)->penPegID)->pegNama; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tentang</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query2->telTentang;?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Persoalan</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query2->telPersoalan;?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Praanggapan</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query2->telPraanggapan; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Fakta</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query2->telFakta; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Analisis</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query2->telAnalisis; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Simpulan</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query2->telSimpulan; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Saran</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label></label><?php echo $data_query2->telSaran; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="frame bg-green" id="tab-smd-file">
                        <div class="row border bordered" style="margin-bottom: 10px;">
                            <object data="<?php echo base_url() . '_temp/surat_masuk/' . $data_query->surFile; ?>" type="application/pdf" title="your_title" align="top" height="620" width="100%" frameborder="0" scrolling="auto" ></object>
                        </div>
                    </div>
                    <div class="frame" id="tab-smd-disposisi">
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <div class="grid" style="margin-top: 3px;">
                                <div class="row cells12">
                                    <?php
                                    $data = $ci->DisposisiModel->get_disposisi($data_query->surID);
                                    if (count($data) <= 0 && $this->session->userdata('masuk_level')=='KASUBAGUMUM') {
                                    ?>
                                    <a class="image-button success place-left" onclick="sm_tambah_disposisi('<?php echo $data_query->surID;?>')">Lanjut Disposisi<span class="icon mif-user-check bg-darkGreen"></span></a>&nbsp;
                                    <?php
                                    }else if(count($data) > 0 && $data[(count($data)-1)]->disKepadaPenID==$this->session->userdata('masuk_id')){
                                     ?>
                                    <a class="image-button success place-left" onclick="sm_tambah_disposisi('<?php echo $data_query->surID;?>')">Lanjut Disposisi<span class="icon mif-user-check bg-darkGreen"></span></a>&nbsp;
                                    <a class="image-button alert" onclick="sm_tolak_disposisi('<?php echo $data[(count($data)-1)]->disID;?>')">Tolak Disposisi<span class="icon mif-user-minus bg-darkRed"></span></a>
                                    <?php   
                                    }
                                    ?>
                                    <a class="image-button warning place-right" target="_blank" href="<?php echo base_url() ?>disposisi/cetak_disposisi/<?php echo strtolower($this->uri->segment(3)); ?>">Cetak<span class="icon mif-printer bg-darkOrange"></span></a>
                                </div>
                            </div>
                            <table class="table border bordered sortable-markers-on-left tabel">
                                <thead>
                                    <tr>
                                        <th><center>No</center></th>
                                        <th><center>Asal Disposisi</center></th>
                                        <th><center>Tujuan Disposisi</center></th>
                                        <th><center>Tgl Disposisi</center></th>
                                        <th><center>Isi Disposisi</center></th>
                                        <th><center>File Lampiran</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data = $ci->DisposisiModel->get_disposisi($data_query->surID);
                                    if (count($data) <= 0) {
                                        ?>
                                        <tr><td colspan="6">Data Tidak Tersedia</td></tr>
                                        <?php
                                    } else {
                                        $no = 0;
                                        foreach ($data as $row) {
                                            $tgl = explode(' ', $row->disTgl);
                                            $no++;
                                            ?>
                                            <tr>
                                                <td class="align-center"><?php echo $no; ?></td>
                                                <td class="align-center"><?php echo $ci->DisposisiModel->get_disposisi_getPegawai($row->disDariPenID)->pegNama; ?></td>
                                                <td class="align-center"><?php echo $ci->DisposisiModel->get_disposisi_getPegawai($row->disKepadaPenID)->pegNama; ?></td>
                                                <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($tgl[0]) . ' / ' . substr($tgl[1], 0, 5) . ' WIB'; ?></td>
                                                <td class="align-center"><?php echo (($row->disUraian == null || $row->disUraian == '') ? '---' : $row->disUraian); ?></td>
                                                <?php if ($row->disNamaFile == null || $row->disNamaFile == '') { ?>
                                                    <td class="align-center">---</td>
                                                <?php } else { ?>
                                                    <td class="align-center"><a data-role="hint" data-hint-background="bg-orange" data-hint-color="fg-white" data-hint-mode="2" data-hint="Perhatian!|Klik Untuk Buka File" target="blank" href="<?php echo base_url(); ?>disposisi/bukafile_disposisi/<?php echo $row->disNamaFile; ?>">[File]</a></td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        </div>
        <?php
        break;
    case 'detail_ptabayun':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Detail Surat Masuk </h1>
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
            <div class="tabcontrol2" data-role="tabcontrol">
                <ul class="tabs">
                    <li class="active"><a href="#tab-smd-detail"><span class="mif-list2"></span> Detail Surat</a></li>
                    <li><a href="#tab-smd-telaah"><span class="mif-pencil"></span> Detail Perkara</a></li>
                    <li><a href="#tab-smd-file"><span class="mif-file-pdf"></span> File Surat</a></li>
                    <li><a href="#tab-smd-disposisi"><span class="mif-users"></span> Detail Disposisi</a></li>
                </ul>
                <div class="frames">
                    <div class="frame" id="tab-smd-detail">
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <div class="grid no-margin-top">
                                <div class="row cells12 no-margin" style="display: none;">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px"></label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Surat Keluar (Rujukan)</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surIndukID == null) ? '-' : $data_query->surIndukID); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Indek</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->IndekModel->getbyid($data_query->surIndID)->indNama; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Kode Klasifikasi</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->KlasifikasiModel->getbyid($data_query->surKlaID)->klaKode.'/'.$ci->KlasifikasiModel->getbyid($data_query->surKlaID1)->klaKode.'/'.$ci->KlasifikasiModel->getbyid($data_query->surKlaID2)->klaKode ; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">No. Urut</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surNoUrut; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Jenis Surat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surJenis == 'PENTING') ? '<span class="tag success">Penting</span>' : (($data_query->surJenis == 'RAHASIA') ? '<span class="tag warning">Rahasia</span>' : '<span class="tag info">Biasa</span>')); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Surat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surTabayun == 'Y') ? '<span class="tag warning">Tabayun</span>' : '<span class="tag success">Umum</span>'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Perihal</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surPerihal; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Ringkasan</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surRingkas; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Lampiran</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surLampiran == 'Y') ? 'Ada' : 'Tidak Ada'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tanggal Surat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglSurat); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Nomor Surat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surNomorSurat; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Asal Surat(Dari)</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surDari; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tujuan Surat(Kepada)</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surKepada; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Pelaksana</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surPelaksanaPenID !=null)?$ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($data_query->surPelaksanaPenID)->penPegID)->pegNama:'-'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tingkat Keamanan</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surKeamanan; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Sifat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surSifat == 'KILAT') ? '<span class="tag alert">Kilat (1 x 24)</span>' : (($data_query->surSifat == 'SEGERA') ? '<span class="tag warning">Segera (2 x 24)</span>' : (($data_query->surSifat == 'PENTING') ? '<span class="tag info">Penting (3 x 24)</span>' : '<span class="tag success">Biasa</span>'))); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Pengelolah Surat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($data_query->surPengolahPenID)->penPegID)->pegNama; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Jenis File</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surJenisFile == 'SC') ? '<span class="tag warning">Soft-Copy</span>' : '<span class="tag info">Hard-Copy</span>'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Unggah File</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surFile; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tanggal Terima</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglTerimaKeluar); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tanggal Input</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglInput); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tanggal Penyelesaian</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surTglPenyelesaian != null) ? '<span class="tag success" data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Info ?|Target Penyelesaian Tgl : ' . $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglPenyelesaian) . ' ">'.$ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglPenyelesaian).'</span>' : '<span class="tag info">Disposisi</span>'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Status</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surTglSelesai != null) ? '<span class="tag success" data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Info ?|Diselesaikan Tgl : ' . $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglSelesai) . ' ">Selesai</span>' : '<span class="tag info">Disposisi</span>'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Keterangan</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surKet; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="frame" id="tab-smd-telaah">
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <div class="grid no-margin-top">
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">No. Perkara</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query2->perNoPerkara ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Jenis Relaas</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo ucwords($data_query2->perJenisRelaas); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tgl. Putus/Sidang/Inzage</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query2->perTglPutusSidangInzage); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Jenis Identitas Pihak</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo ucwords($data_query2->perJenisIdentitas); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Nama Pihak</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo ucwords($data_query2->perNama); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Kordinator Relaas</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query2->perKorPenID!=null)?$ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($data_query2->perKorPenID)->penPegID)->pegNama:'Belum Ditunjuk'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Jurusita / JSP Relaas</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query2->perJsPenID!=null)?$ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($data_query2->perJsPenID)->penPegID)->pegNama:'Belum Ditunjuk'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tgl. Terima Relaas</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query2->perTglTerimaJs!=null)?$ci->Konfigurasi->MSQLDateToNormalInUnix($data_query2->perTglTerimaJs):'Belum Ditentukan'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tgl. Panggil Relaas</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query2->perTglPanggil!=null)?$ci->Konfigurasi->MSQLDateToNormalInUnix($data_query2->perTglPanggil):'Belum Ditentukan'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tgl. Serah Relaas</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query2->perTglSerahRelaas!=null)?$ci->Konfigurasi->MSQLDateToNormalInUnix($data_query2->perTglSerahRelaas):'Belum Ditentukan'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">Tgl. Kirim Relaas</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query2->perTglKirimRelaas!=null)?$ci->Konfigurasi->MSQLDateToNormalInUnix($data_query2->perTglKirimRelaas):'Belum Ditentukan'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">No. Resi</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query2->perNoResi!=null)?$data_query2->perNoResi:'Belum Tersedia');?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 270px; height: 40px;"><label style="margin-left: 10px">No. Resi</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query2->perKet!=null)?$data_query2->perKet:'Tidak Tersedia');?></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="frame bg-green" id="tab-smd-file">
                        <div class="row border bordered" style="margin-bottom: 10px;">
                            <object data="<?php echo base_url() . '_temp/surat_masuk/' . $data_query->surFile; ?>" type="application/pdf" title="your_title" align="top" height="620" width="100%" frameborder="0" scrolling="auto" ></object>
                        </div>
                    </div>
                    <div class="frame" id="tab-smd-disposisi">
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <div class="grid" style="margin-top: 3px;">
                                <div class="row cells12">
                                    <?php
                                    $data = $ci->DisposisiModel->get_disposisi($data_query->surID);
                                    if (count($data) <= 0 && $this->session->userdata('masuk_level')=='KASUBAGUMUM') {
                                    ?>
                                    <a class="image-button success place-left" onclick="sm_tambah_disposisi('<?php echo $data_query->surID;?>')">Lanjut Disposisi<span class="icon mif-user-check bg-darkGreen"></span></a>&nbsp;
                                    <?php
                                    }else if(count($data) > 0 && $data[(count($data)-1)]->disKepadaPenID==$this->session->userdata('masuk_id')){
                                    $data = array('disBuka' => 'Y');
                                    $ci->DisposisiModel->ubahbyid(array('disID' => ($data[(count($data)-1)]->disID)), $data);
                                    ?>
                                    <a class="image-button success place-left" onclick="sm_tambah_disposisi('<?php echo $data_query->surID;?>')">Lanjut Disposisi<span class="icon mif-user-check bg-darkGreen"></span></a>&nbsp;
                                    <a class="image-button alert" onclick="sm_tolak_disposisi('<?php echo $data[(count($data)-1)]->disID;?>')">Tolak Disposisi<span class="icon mif-user-minus bg-darkRed"></span></a>
                                    <?php   
                                    }
                                    ?>
                                    <a class="image-button warning place-right" target="_blank" href="<?php echo base_url() ?>disposisi/cetak_disposisi/<?php echo strtolower($this->uri->segment(3)); ?>">Cetak Disposisi<span class="icon mif-printer bg-darkOrange"></span></a>
                                </div>
                            </div>
                            <table class="table border bordered sortable-markers-on-left tabel">
                                <thead>
                                    <tr>
                                        <th><center>No</center></th>
                                        <th><center>Asal Disposisi</center></th>
                                        <th><center>Tujuan Disposisi</center></th>
                                        <th><center>Tgl Disposisi</center></th>
                                        <th><center>Isi Disposisi</center></th>
                                        <th><center>File Lampiran</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($data) <= 0) {
                                        ?>
                                        <tr><td colspan="6">Data Tidak Tersedia</td></tr>
                                        <?php
                                    } else {
                                        $no = 0;
                                        foreach ($data as $row) {
                                            $tgl = explode(' ', $row->disTgl);
                                            $no++;
                                            ?>
                                            <tr>
                                                <td class="align-center"><?php echo $no; ?></td>
                                                <td class="align-center"><?php echo $ci->DisposisiModel->get_disposisi_getPegawai($row->disDariPenID)->pegNama; ?></td>
                                                <td class="align-center"><?php echo $ci->DisposisiModel->get_disposisi_getPegawai($row->disKepadaPenID)->pegNama; ?></td>
                                                <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($tgl[0]) . ' / ' . substr($tgl[1], 0, 5) . ' WIB'; ?></td>
                                                <td class="align-center"><?php echo (($row->disUraian == null || $row->disUraian == '') ? '---' : $row->disUraian); ?></td>
                                                <?php if ($row->disNamaFile == null || $row->disNamaFile == '') { ?>
                                                    <td class="align-center">---</td>
                                                <?php } else { ?>
                                                    <td class="align-center"><a data-role="hint" data-hint-background="bg-orange" data-hint-color="fg-white" data-hint-mode="2" data-hint="Perhatian!|Klik Untuk Buka File" target="blank" href="<?php echo base_url(); ?>disposisi/bukafile_disposisi/<?php echo $row->disNamaFile; ?>">[File]</a></td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        </div>
        <?php
        break;    
    case 'detail_biasa':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Detail Surat Masuk </h1>
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
            <div class="tabcontrol2" data-role="tabcontrol">
                <ul class="tabs">
                    <li class="active"><a href="#frame_5_1"><span class="mif-list2"></span> Detail Surat</a></li>
                    <li><a href="#frame_5_2"><span class="mif-file-pdf"></span> File Surat</a></li>
                    <li><a href="#frame_5_3"><span class="mif-users"></span> Detail Disposisi</a></li>
                </ul>
                <div class="frames">
                    <div class="frame" id="frame_5_1">
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <div class="grid no-margin-top">
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Surat Keluar (Rujukan) </label></div>
                                    <div class="cell colspan3" style="margin-top: 15px;">
                                        <label><?php echo (($data_query->surIndukID == null) ? '-' : $data_query->surIndukID); ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Indek </label></div>
                                    <div class="cell colspan3" style="margin-top: 15px;">
                                        <label><?php echo $ci->IndekModel->getbyid($data_query->surIndID)->indNama; ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Kode Klasifikasi </label></div>
                                    <div class="cell colspan3" style="margin-top: 15px;">
                                        <label><?php echo $ci->KlasifikasiModel->getbyid($data_query->surKlaID)->klaKode.'/'.$ci->KlasifikasiModel->getbyid($data_query->surKlaID1)->klaKode.'/'.$ci->KlasifikasiModel->getbyid($data_query->surKlaID2)->klaKode ; ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>No. Urut </label></div>
                                    <div class="cell colspan3" style="margin-top: 15px;">
                                        <label><?php echo $data_query->surNoUrut; ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis Surat</label><label class="fg-red">*</label></div>
                                    <div class="cell colspan3" style="margin-top: 15px;">
                                        <label><?php echo (($data_query->surJenis == 'PENTING') ? '<span class="tag success">Penting</span>' : (($data_query->surJenis == 'RAHASIA') ? '<span class="tag warning">Rahasia</span>' : '<span class="tag info">Biasa</span>')); ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Surat</label><label class="fg-red">*</label></div>
                                    <div class="cell colspan3" style="margin-top: 15px;">
                                        <label><?php echo (($data_query->surTabayun == 'Y') ? '<span class="tag warning">Tabayun</span>' : '<span class="tag success">Umum</span>'); ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;" ><label>Perihal </label><label class="fg-red">*</label></div>
                                    <div class="cell colspan6" style="margin-top: 15px;">
                                        <label><?php echo $data_query->surPerihal; ?></label>
                                    </div>
                                </div>
                                <div class="row no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 277px;"><label style="margin-left: 10px">Ringkasan</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surRingkas; ?></label></td>
                                        </tr>
                                    </table>
                                </div> 
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Lampiran </label><label class="fg-red">*</label></div>
                                    <div class="cell colspan2" style="margin-top: 15px;">
                                        <label><?php echo (($data_query->surLampiran == 'Y') ? 'Ada' : 'Tidak Ada'); ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Surat</label><label class="fg-red">*</label></div>
                                    <div class="cell colspan3" style="margin-top: 15px;">
                                        <label><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglSurat); ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Surat </label><label class="fg-red">*</label></div>
                                    <div class="cell colspan4" style="margin-top: 15px;">
                                        <label><?php echo $data_query->surNomorSurat; ?></label>
                                    </div>
                                </div>
                                <div class="row no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 277px;"><label style="margin-left: 10px">Asal Surat(Dari)</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surDari; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 277px;"><label style="margin-left: 10px">Tujuan Surat(Kepada)</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surKepada; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 277px;"><label style="margin-left: 10px">Pelaksana</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surPelaksanaPenID !=null)?$ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($data_query->surPelaksanaPenID)->penPegID)->pegNama:'-'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tingkat Keamanan </label><label class="fg-red">*</label></div>
                                    <div class="cell colspan2" style="margin-top: 15px;">
                                        <label><?php echo $data_query->surKeamanan; ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Sifat</label><label class="fg-red">*</label></div>
                                    <div class="cell colspan3" style="margin-top: 15px;">
                                        <label><?php echo (($data_query->surSifat == 'KILAT') ? '<span class="tag alert">Kilat (1 x 24)</span>' : (($data_query->surSifat == 'SEGERA') ? '<span class="tag warning">Segera (2 x 24)</span>' : (($data_query->surSifat == 'PENTING') ? '<span class="tag info">Penting (3 x 24)</span>' : '<span class="tag success">Biasa</span>'))); ?></label>
                                    </div>
                                </div>
                                <div class="row no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 277px;"><label style="margin-left: 10px">Pengelolah Surat</label><label class="fg-red">*</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo (($data_query->surPelaksanaPenID !=null)?$ci->PegawaiModel->getbyid($ci->PenggunaModel->getbyid($data_query->surPengolahPenID)->penPegID)->pegNama:'-'); ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis File </label><label class="fg-red">*</label></div>
                                    <div class="cell colspan2" style="margin-top: 15px;">
                                        <label><?php echo (($data_query->surJenisFile == 'SC') ? '<span class="tag warning">Soft-Copy</span>' : '<span class="tag info">Hard-Copy</span>'); ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Unggah File </label><label class="fg-red">*</label></div>
                                    <div class="cell colspan5" style="margin-top: 15px;">
                                        <label><?php echo $data_query->surFile; ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Terima</label><label class="fg-red">*</label></div>
                                    <div class="cell colspan3" style="margin-top: 15px;">
                                        <label><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglTerimaKeluar); ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Input</label><label class="fg-red">*</label></div>
                                    <div class="cell colspan3" style="margin-top: 15px;">
                                        <label><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglInput); ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Penyelesaian</label></div>
                                    <div class="cell colspan5" style="margin-top: 15px;">
                                        <label><?php echo (($data_query->surTglPenyelesaian != null) ? '<span class="tag success" data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Info ?|Target Penyelesaian Tgl : ' . $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglPenyelesaian) . ' ">'.$ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglPenyelesaian).'</span>' : '<span class="tag info">Disposisi</span>'); ?></label>
                                    </div>
                                </div>
                                <div class="row cells12 no-margin">
                                    <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Status</label></div>
                                    <div class="cell colspan5" style="margin-top: 15px;">
                                        <label><?php echo (($data_query->surTglSelesai != null) ? '<span class="tag success" data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Info ?|Diselesaikan Tgl : ' . $ci->Konfigurasi->MSQLDateToNormalInUnix($data_query->surTglSelesai) . ' ">Selesai</span>' : '<span class="tag info">Disposisi</span>'); ?></label>
                                    </div>
                                </div>
                                <div class="row no-margin">
                                    <table style="margin-top: 5px;margin-bottom: 0px;">
                                        <tr>
                                            <td class="bg-green fg-white" style="width: 277px;"><label style="margin-left: 10px">Keterangan</label></td>
                                            <td style="width:25px"></td>
                                            <td><label><?php echo $data_query->surKet; ?></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="frame bg-green" id="frame_5_2">
                        <div class="row border bordered" style="margin-bottom: 10px;">
                            <object data="<?php echo base_url() . '_temp/surat_masuk/' . $data_query->surFile; ?>" type="application/pdf" title="your_title" align="top" height="620" width="100%" frameborder="0" scrolling="auto" ></object>
                        </div>
                    </div>
                    <div class="frame" id="frame_5_3">
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <div class="grid" style="margin-top: 3px;">
                                <div class="row cells12">
                                    <a class="image-button warning place-right" target="_blank" href="<?php echo base_url() ?>surat_masuk/cetak_disposisi/<?php echo strtolower($this->uri->segment(3)); ?>">Cetak Disposisi<span class="icon mif-printer bg-darkOrange"></span></a>
                                </div>
                            </div>
                            <table class="table border bordered sortable-markers-on-left tabel">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Asal Disposisi</th>
                                        <th>Tujuan Disposisi</th>
                                        <th>Tgl Disposisi</th>
                                        <th>Isi Disposisi</th>
                                        <th>File Lampiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ci = &get_instance();
                                    $ci->load->model('SuratMasukModel');
                                    $data = $ci->SuratMasukModel->get_disposisi($data_query->surID);
                                    if (count($data) <= 0) {
                                        ?>
                                        <tr><td colspan="6">Data Tidak Tersedia</td></tr>
                                        <?php
                                    } else {
                                        $no = 0;
                                        foreach ($data as $row) {
                                            $tgl = explode(' ', $row->disTgl);
                                            $no++;
                                            ?>
                                            <tr>
                                                <td class="align-center"><?php echo $no; ?></td>
                                                <td class="align-center"><?php echo $ci->SuratMasukModel->get_disposisi_getPegawai($row->disDariPenID)->pegNama; ?></td>
                                                <td class="align-center"><?php echo $ci->SuratMasukModel->get_disposisi_getPegawai($row->disKepadaPenID)->pegNama; ?></td>
                                                <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($tgl[0]) . ' / ' . substr($tgl[1], 0, 5) . ' WIB'; ?></td>
                                                <td class="align-center"><?php echo (($row->disUraian == null || $row->disUraian == '') ? '---' : $row->disUraian); ?></td>
                                                <?php if ($row->disNamaFile == null || $row->disNamaFIle == '') { ?>
                                                    <td>---</td>
                                                <?php } else { ?>
                                                    <td><a data-role="hint" data-hint-background="bg-orange" data-hint-color="fg-white" data-hint-mode="2" data-hint="Perhatian!|Klik Untuk Buka File" target="blank" href="<?php echo base_url(); ?>surat_masuk/bukafile_disposisi/<?php echo $row->disNamaFile; ?>">[File]</a></td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        </div>
        <?php
        break;
    case 'tambah_pumum':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Tambah Surat Masuk </h1>
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
            <form id="form_suratmasukpre" method="POST" action="<?php echo base_url() . $view; ?>/simpan_pumum" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white" enctype="multipart/form-data">
                <div class="grid no-margin-top">
                    <input name="surID" type="hidden">
                    <input name="surTabayun" type="hidden" value="N">
                    <input name="surJenis" type="hidden" value="PENTING">
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Surat Keluar (Rujukan) </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surIndukID">
                                    <option value="">Pilih Nomor Surat Keluar (Jika Ada)</option>
                                    <?php
                                    $data = $ci->SuratMasukModel->getall_suratkeluar();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->surID . '">' . $row->surNomorSurat . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Indeks </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surIndID" data-validate-func="required" data-validate-hint="Data Indek Tidak Boleh Kosong..!">
                                    <option value="">Pilih Indeks</option>
                                    <?php
                                    $data = $ci->SuratMasukModel->getall_indek();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->indID . '">' . $row->indNama . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Kode Klasifikasi </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKlaID" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-1 Tidak Boleh Kosong..!">
                                    <option value="">Pilih Kode Sub-1</option>
                                    <?php
                                    $data = $ci->KlasifikasiModel->getall();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->klaID . '">' . $row->klaKode.' | ' .$row->klaNama.'</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKlaID1" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-2 Tidak Boleh Kosong..!">
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKlaID2" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-3 Tidak Boleh Kosong..!">
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Urut </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNoUrut" type="number" data-validate-func="required" data-validate-hint="Data Nomor Urut Tidak Boleh Kosong..!" value="<?php echo $ci->SuratMasukModel->get_NoUrut();?>">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;" ><label>Perihal </label><label class="fg-red">*</label></div>
                        <div class="cell colspan6">
                            <div class="input-control text success full-size">
                                <input name="surPerihal" type="text" data-validate-func="required" data-validate-hint="Data Perihal Tidak Boleh Kosong..!">
                                <span class="input-state-error mif-warning"></span>
                            </div></div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Ringkasan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan9"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surRingkas" id="surRingkas" data-validate-func="required" data-validate-hint="Data Ringkasan Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surRingkas', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Lampiran </label><label class="fg-red">*</label></div>
                        <div class="cell colspan1">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surLampiran" value="Y" checked>
                                    <span class="check"></span>
                                    <span class="caption">Ada</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="N" name="surLampiran">
                                    <span class="check"></span>
                                    <span class="caption">Tidak Ada</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Surat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="surTglSurat" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Surat </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNomorSurat" type="text" data-validate-func="required" data-validate-hint="Data Nomor Surat Tidak Boleh Kosong..!">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Asal Surat(Dari)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surDari" id="surDari" data-validate-func="required" data-validate-hint="Data Dari Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surDari', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Tujuan Surat(Kepada)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKepada" id="surKepada" data-validate-func="required" data-validate-hint="Data Kepada Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surKepada', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tingkat Keamanan </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKeamanan" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="">Pilih Keamanan</option>
                                    <option value="SR">SR</option>
                                    <option value="R">R</option>
                                    <option value="K">K</option>
                                    <option value="B">B</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Sifat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surSifat" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="">Pilih Sifat</option>
                                    <option value="KILAT">Kilat (1 x 24)</option>
                                    <option value="SEGERA">Segera (2 x 24)</option>
                                    <option value="PENTING">Penting (3 x 24)</option>
                                    <option value="BIASA">Biasa</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis File </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surJenisFile" value="SC" checked>
                                    <span class="check"></span>
                                    <span class="caption">Soft Copy</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="HC" name="surJenisFile">
                                    <span class="check"></span>
                                    <span class="caption">Hard Copy</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Unggah File </label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control file success full-size" data-role="input">
                                <input type="file" name="surFile" data-validate-func="required" data-validate-hint="Data File Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-folder"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                        <div class="cell colspan3" style="margin-top: 14px;">
                            <label class="fg-red mif-warning"> Hanya File (.pdf) & ukuran max 5Mb </label>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Terima</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="surTglTerimaKeluar" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 110px;margin-top: 5px;"><label>Keterangan</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKet" id="surKet"></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('surKet', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <h4> Data Telaah Staff</h4>
                        <hr/>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Tentang</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telTentang" id="telTentang" data-validate-func="required" data-validate-hint="Data Tentang Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telTentang', {width: 800, height: 150});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Persoalan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telPersoalan" id="telPersoalan" data-validate-func="required" data-validate-hint="Data Persoalan Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telPersoalan', {width: 800, height: 150});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Praanggapan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telPraanggapan" id="telPraanggapan" data-validate-func="required" data-validate-hint="Data Praanggapan Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telPraanggapan', {width: 800, height: 150});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Fakta</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telFakta" id="telFakta" data-validate-func="required" data-validate-hint="Data Fakta Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telFakta', {width: 800, height: 150});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Analisis</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telAnalisis" id="telAnalisis" data-validate-func="required" data-validate-hint="Data Analisis Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telAnalisis', {width: 800, height: 150});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Simpulan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telSimpulan" id="telSimpulan" data-validate-func="required" data-validate-hint="Data Simpulan Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telSimpulan', {width: 800, height: 150});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 195px;margin-top: 5px;"><label>Saran</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="telSaran" id="telSaran" data-validate-func="required" data-validate-hint="Data Saran Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('telSaran', {width: 800, height: 150});
                            </script>
                        </div>
                    </div>
                    
                    <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                    <div class="row cells12 bg-green fg-white padding10" style="height: 60px;" >
                        <div class="cell colspan3"></div>
                        <div class="cell colspan9">
                            <button type="submit" class="button text-light fg-green"><span class="mif-floppy-disk"></span> Simpan</button>
                            <a href="<?php echo base_url() . $view; ?>" class="button warning text-light"><span class="mif-cross"></span> Batal</a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>
        <?php
        break;
    case 'tambah_ptabayun':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Tambah Surat Masuk </h1>
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
            <form id="form_suratmasukpre" method="POST" action="<?php echo base_url() . $view; ?>/simpan_ptabayun" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white" enctype="multipart/form-data">
                <div class="grid no-margin-top">
                    <input name="surID" type="hidden">
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Surat Keluar (Rujukan) </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surIndukID">
                                    <option value="">Pilih Nomor Surat Keluar (Jika Ada)</option>
                                    <?php
                                    $data = $ci->SuratMasukModel->getall_suratkeluar();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->surID . '">' . $row->surNomorSurat . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Indeks </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surIndID" data-validate-func="required" data-validate-hint="Data Indek Tidak Boleh Kosong..!">
                                    <option value="">Pilih Indeks</option>
                                    <?php
                                    $data = $ci->SuratMasukModel->getall_indek();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->indID . '">' . $row->indNama . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Kode Klasifikasi </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKlaID" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-1 Tidak Boleh Kosong..!">
                                    <option value="">Pilih Kode Sub-1</option>
                                    <?php
                                    $data = $ci->KlasifikasiModel->getall();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->klaID . '">' . $row->klaKode.' | ' .$row->klaNama.'</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKlaID1" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-2 Tidak Boleh Kosong..!">
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKlaID2" data-validate-func="required" data-validate-hint="Kode Klasifikasi Sub-3 Tidak Boleh Kosong..!">
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Urut </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNoUrut" type="number" data-validate-func="required" data-validate-hint="Data Nomor Urut Tidak Boleh Kosong..!" value="<?php echo $ci->SuratMasukModel->get_NoUrut();?>">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;" ><label>Perihal </label><label class="fg-red">*</label></div>
                        <div class="cell colspan6">
                            <div class="input-control text success full-size">
                                <input name="surPerihal" type="text" data-validate-func="required" data-validate-hint="Data Perihal Tidak Boleh Kosong..!">
                                <span class="input-state-error mif-warning"></span>
                            </div></div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Ringkasan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan9"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surRingkas" id="surRingkas" data-validate-func="required" data-validate-hint="Data Ringkasan Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surRingkas', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Lampiran </label><label class="fg-red">*</label></div>
                        <div class="cell colspan1">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surLampiran" value="Y" checked>
                                    <span class="check"></span>
                                    <span class="caption">Ada</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="N" name="surLampiran">
                                    <span class="check"></span>
                                    <span class="caption">Tidak Ada</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Surat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="surTglSurat" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Surat </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNomorSurat" type="text" data-validate-func="required" data-validate-hint="Data Nomor Surat Tidak Boleh Kosong..!">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Asal Surat(Dari)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control text success full-size">
                                <input name="surDari" type="text" data-validate-func="required" data-validate-hint="Data Asal Surat Tidak Boleh Kosong..!" placeholder="PA. Padang">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tujuan Surat(Kepada)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control text success full-size">
                                <input name="surKepada" value="PA. Pekanbaru" type="text" data-validate-func="required" data-validate-hint="Data Asal Surat Tidak Boleh Kosong..!" placeholder="PA. Pekanbaru" readonly>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tingkat Keamanan </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKeamanan" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="">Pilih Keamanan</option>
                                    <option value="SR">SR</option>
                                    <option value="R">R</option>
                                    <option value="K">K</option>
                                    <option value="B">B</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Sifat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surSifat" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="">Pilih Sifat</option>
                                    <option value="KILAT">Kilat (1 x 24)</option>
                                    <option value="SEGERA">Segera (2 x 24)</option>
                                    <option value="PENTING">Penting (3 x 24)</option>
                                    <option value="BIASA">Biasa</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis File </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surJenisFile" value="SC" checked>
                                    <span class="check"></span>
                                    <span class="caption">Soft Copy</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="HC" name="surJenisFile">
                                    <span class="check"></span>
                                    <span class="caption">Hard Copy</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Unggah File </label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control file success full-size" data-role="input">
                                <input type="file" name="surFile" data-validate-func="required" data-validate-hint="Data File Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-folder"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                        <div class="cell colspan3" style="margin-top: 14px;">
                            <label class="fg-red mif-warning"> Hanya File (.pdf) & ukuran max 5Mb </label>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Terima</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="surTglTerimaKeluar" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Keterangan</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKet" id="surKet"></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('surKet', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <h4> Data Detail Tabayun</h4>
                        <hr/>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Perkara</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control text success full-size">
                                <input name="perNoPerkara" type="text" data-validate-func="required" data-validate-hint="Data No Perkara Tidak Boleh Kosong..!" placeholder="Nomor Perkara">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis Tabayun (Relaas)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="perJenisRelaas" data-validate-func="required" data-validate-hint="Data Jenis Relaas Tidak Boleh Kosong..!">
                                    <option value="">Pilih Jenis Relaas</option>
                                    <option value="pemberitahuan">Pemberitahuan</option>
                                    <option value="panggilan">Panggilan</option>
                                    <option value="inzage">Inzage</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Terima</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="perTglPutusSidangInzage" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis Identitas</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="perJenisIdentitas" data-validate-func="required" data-validate-hint="Data Jenis Relaas Tidak Boleh Kosong..!">
                                    <option value="">Pilih Jenis Identitas</option>
                                    <option value="penggugat">Penggugat</option>
                                    <option value="tergugat">Tergugat</option>
                                    <option value="pemohon">Pemohon</option>
                                    <option value="termohon">Termohon</option>
                                    <option value="turut_tergugat">Turut Tergugat</option>
                                    <option value="pemohon_banding">Pemohon Banding</option>
                                    <option value="termohon_banding">Termohon Banding</option>
                                    <option value="pemohon_kasasi">Pemohon Kasasi</option>
                                    <option value="termohon_kasasi">Termohon Kasasi</option>
                                    <option value="pemohon_pk">Pemohon Pk</option>
                                    <option value="termohon_pk">Termohon Pk</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nama Ybs</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5">
                            <div class="input-control text success full-size">
                                <input name="perNama" type="text" data-validate-func="required" data-validate-hint="Data Nama Tidak Boleh Kosong..!" placeholder="Ahmad Zaki ETC bin Apitdin">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Keterangan Tabayun</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="perKet" id="perKet"></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('perKet', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                    <div class="row cells12 bg-green fg-white padding10" style="height: 60px;" >
                        <div class="cell colspan3"></div>
                        <div class="cell colspan9">
                            <button type="submit" class="button text-light fg-green"><span class="mif-floppy-disk"></span> Simpan</button>
                            <a href="<?php echo base_url() . $view; ?>" class="button warning text-light"><span class="mif-cross"></span> Batal</a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>
        <?php
        break;    
    case 'tambah_rahasia':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Tambah Surat Masuk </h1>
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
            <form id="form_suratmasukpre" method="POST" action="<?php echo base_url() . $view; ?>/simpan_rahasia" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white" enctype="multipart/form-data">
                <div class="grid no-margin-top">
                    <input name="surID" type="hidden">
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Surat Keluar (Rujukan) </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surIndukID">
                                    <option value="">Pilih Nomor Surat Keluar (Jika Ada)</option>
                                    <?php
                                    $data = $ci->SuratMasukModel->getall_suratkeluar();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->surID . '">' . $row->surNomorSurat . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Urut </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNoUrut" type="number" data-validate-func="required" data-validate-hint="Data Nomor Urut Tidak Boleh Kosong..!" value="<?php echo $ci->SuratMasukModel->get_NoUrut();?>">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Asal Surat(Dari)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surDari" id="surDari" data-validate-func="required" data-validate-hint="Data Dari Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surDari', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Tujuan Surat(Kepada)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKepada" id="surKepada" data-validate-func="required" data-validate-hint="Data Kepada Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surKepada', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tingkat Keamanan </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKeamanan" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="">Pilih Keamanan</option>
                                    <option value="SR">SR</option>
                                    <option value="R">R</option>
                                    <option value="K">K</option>
                                    <option value="B">B</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Sifat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surSifat" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="">Pilih Sifat</option>
                                    <option value="KILAT">Kilat (1 x 24)</option>
                                    <option value="SEGERA">Segera (2 x 24)</option>
                                    <option value="PENTING">Penting (3 x 24)</option>
                                    <option value="BIASA">Biasa</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Terima</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="surTglTerimaKeluar" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Keterangan</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKet" id="surKet"></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('surKet', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                    <div class="row cells12 bg-green fg-white padding10" style="height: 60px;" >
                        <div class="cell colspan3"></div>
                        <div class="cell colspan9">
                            <button type="submit" class="button text-light fg-green"><span class="mif-floppy-disk"></span> Simpan</button>
                            <a href="<?php echo base_url() . $view; ?>" class="button warning text-light"><span class="mif-cross"></span> Batal</a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>
        <?php
        break;
    case 'tambah_biasa':
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Tambah Surat Masuk </h1>
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
            <form id="form_suratmasukpre" method="POST" action="<?php echo base_url() . $view; ?>/simpan_biasa" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white" enctype="multipart/form-data">
                <div class="grid no-margin-top">
                    <input name="surID" type="hidden">
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Surat Keluar (Rujukan) </label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surIndukID">
                                    <option value="">Pilih Nomor Surat Keluar (Jika Ada)</option>
                                    <?php
                                    $data = $ci->SuratMasukModel->getall_suratkeluar();
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->surID . '">' . $row->surNomorSurat . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Urut </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNoUrut" type="number" data-validate-func="required" data-validate-hint="Data Nomor Urut Tidak Boleh Kosong..!" value="<?php echo $ci->SuratMasukModel->get_NoUrut();?>">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;" ><label>Perihal </label><label class="fg-red">*</label></div>
                        <div class="cell colspan6">
                            <div class="input-control text success full-size">
                                <input name="surPerihal" type="text" data-validate-func="required" data-validate-hint="Data Perihal Tidak Boleh Kosong..!">
                                <span class="input-state-error mif-warning"></span>
                            </div></div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Ringkasan</label><label class="fg-red">*</label></div>
                        <div class="cell colspan9"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surRingkas" id="surRingkas" data-validate-func="required" data-validate-hint="Data Ringkasan Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surRingkas', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Lampiran </label><label class="fg-red">*</label></div>
                        <div class="cell colspan1">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surLampiran" value="Y" checked>
                                    <span class="check"></span>
                                    <span class="caption">Ada</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="N" name="surLampiran">
                                    <span class="check"></span>
                                    <span class="caption">Tidak Ada</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Surat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="surTglSurat" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Nomor Surat </label><label class="fg-red">*</label></div>
                        <div class="cell colspan4">
                            <div class="input-control text success full-size">
                                <input name="surNomorSurat" type="text" data-validate-func="required" data-validate-hint="Data Nomor Surat Tidak Boleh Kosong..!">
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Asal Surat(Dari)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surDari" id="surDari" data-validate-func="required" data-validate-hint="Data Dari Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surDari', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Tujuan Surat(Kepada)</label><label class="fg-red">*</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKepada" id="surKepada" data-validate-func="required" data-validate-hint="Data Kepada Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                            <script>
                                CKEDITOR.replace('surKepada', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tingkat Keamanan </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surKeamanan" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="">Pilih Keamanan</option>
                                    <option value="SR">SR</option>
                                    <option value="R">R</option>
                                    <option value="K">K</option>
                                    <option value="B">B</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Sifat</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control success full-size">
                                <select class="full-size js-select" name="surSifat" data-validate-func="required" data-validate-hint="Data Keamanan Tidak Boleh Kosong..!">
                                    <option value="">Pilih Sifat</option>
                                    <option value="KILAT">Kilat (1 x 24)</option>
                                    <option value="SEGERA">Segera (2 x 24)</option>
                                    <option value="PENTING">Penting (3 x 24)</option>
                                    <option value="BIASA">Biasa</option>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Jenis File </label><label class="fg-red">*</label></div>
                        <div class="cell colspan2">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" name="surJenisFile" value="SC" checked>
                                    <span class="check"></span>
                                    <span class="caption">Soft Copy</span>
                                </label>
                            </div>
                        </div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size">
                                <label class="input-control radio small-check">
                                    <input type="radio" value="HC" name="surJenisFile">
                                    <span class="check"></span>
                                    <span class="caption">Hard Copy</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="margin-top: 5px;"><label>Tanggal Terima</label><label class="fg-red">*</label></div>
                        <div class="cell colspan3">
                            <div class="input-control text success full-size" data-role="datepicker">
                                <input type="text" name="surTglTerimaKeluar" data-validate-func="required" data-validate-hint="Data Tanggal Tidak Boleh Kosong..!">
                                <button class="button"><span class="mif-calendar"></span></button>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cells12 no-margin">
                        <div class="cell colspan3 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Keterangan</label></div>
                        <div class="cell colspan5"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="surKet" id="surKet"></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('surKet', {width: 700, height: 100});
                            </script>
                        </div>
                    </div>
                    <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                    <div class="row cells12 bg-green fg-white padding10" style="height: 60px;" >
                        <div class="cell colspan3"></div>
                        <div class="cell colspan9">
                            <button type="submit" class="button text-light fg-green"><span class="mif-floppy-disk"></span> Simpan</button>
                            <a href="<?php echo base_url() . $view; ?>" class="button warning text-light"><span class="mif-cross"></span> Batal</a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>
        <?php
        break;
    default:
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Kelola Surat Keluar </h1>
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
            <br/>
        <div class="tabcontrol2" data-role="tabcontrol">
            <ul class="tabs">
                <li class="active"><a href="#frame_5_1"><span class="mif-list"></span> Semua Surat</a></li>
                <li><a href="#frame_5_2"><span class="mif-list"></span> Tabayun</a></li>
                <li><a href="#frame_5_3"><span class="mif-list"></span> Penting</a></li>
                 <?php
                if($this->session->userdata('masuk_level')=='KASUBAGUMUM' || $this->session->userdata('masuk_level')=='PIMPINAN'){
                ?>
                <li><a href="#frame_5_4"><span class="mif-list"></span> Rahasia</a></li>
                <li><a href="#frame_5_5"><span class="mif-list"></span> Biasa</a></li>
                <?php } ?>
            </ul>
            <div class="frames">
                <div class="frame" id="frame_5_1">
                   <div class="row">
                       <?php
                       if($this->session->userdata('masuk_level')=='KASUBAGUMUM'){
                       ?>
                        <div class="grid" style="margin-top: 3px;">
                            <div class="row cells12">
                                <div class="dropdown-button place-left">
                                    <button class="button dropdown-toggle fg-white image-button bg-blue">Tambah Surat<span class="icon mif-plus bg-darkBlue fg-white"></span></button>
                                    <ul class="split-content d-menu place-left" data-role="dropdown">
                                    <li>
                                        <a class="dropdown-toggle">Penting</a>
                                        <ul class="d-menu place-left" data-role="dropdown">
                                            <li><a href="<?php echo base_url() ?>surat_masuk/tambah_pumum">Umum</a></li>
                                            <li><a href="<?php echo base_url() ?>surat_masuk/tambah_ptabayun">Tabayun</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="<?php echo base_url() ?>surat_masuk/tambah_rahasia">Rahasia</a></li>
                                    <li><a href="<?php echo base_url() ?>surat_masuk/tambah_biasa">Biasa</a></li>
                                </ul>
                            </div>
                            </div>
                        </div>
                       <?php } ?>
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <table class="dataTable border bordered tabel" data-role="datatable" data-auto-width="false">
                                <thead>
                                    <tr>
                                        <td style="width: 120px"><center>Aksi</center></td>
                                <td class="align-center sort-asc" style="width: 110px"><center>Jenis Surat</center></td>
                                <td class="align-center sort-asc"style="width: 90px"><center>No Urut</center></td>
                                <td class="align-center sort-asc"><center>Nomor Surat</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Surat</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Diterima</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Input</center></td>
                                <td class="align-center sort-asc"><center>Sifat Surat</center></td>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data_query as $row) {
                                        ?>
                                        <tr>
                                            <?php
                                           
                       if($this->session->userdata('masuk_level')=='KASUBAGUMUM'){
                       
                                            if($row->surJenis == 'PENTING' && $row->surTabayun == 'N'){
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Ubah Data" href="<?php echo base_url('surat_masuk/ubah_pumum/' . $row->surID); ?>" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_pumum/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-red" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Hapus" onclick="hapusstaff('<?php echo $row->surID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                                            <?php
                                            }else if ($row->surJenis == 'PENTING' && $row->surTabayun == 'Y') {
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Ubah Data" href="<?php echo base_url('surat_masuk/ubah_ptabayun/' . $row->surID); ?>" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_ptabayun/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-red" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Hapus" onclick="hapusstaff('<?php echo $row->surID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                                            <?php
                                            }else if($row->surJenis == 'RAHASIA' && $row->surTabayun == 'N'){
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Ubah Data" href="<?php echo base_url('surat_masuk/ubah_rahasia/' . $row->surID); ?>" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_rahasia/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-red" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Hapus" onclick="hapusstaff('<?php echo $row->surID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                                            <?php
                                            }else{
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Ubah Data" href="<?php echo base_url('surat_masuk/ubah_biasa/' . $row->surID); ?>" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_biasa/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-red" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Hapus" onclick="hapusstaff('<?php echo $row->surID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                                            <?php
                                            }
                       }else{
                           if($row->surJenis == 'PENTING' && $row->surTabayun == 'N'){
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_pumum/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a></td> 
                                            <?php
                                            }else if ($row->surJenis == 'PENTING' && $row->surTabayun == 'Y') {
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_ptabayun/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a></td> 
                                            <?php
                                            }else if($row->surJenis == 'RAHASIA' && $row->surTabayun == 'N'){
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_rahasia/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a></td> 
                                            <?php
                                            }else{
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_biasa/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a></td> 
                                            <?php
                                            }
                       }
                                            ?>
                                            <td class="align-center"><?php echo (($row->surJenis == 'PENTING' && $row->surTabayun == 'Y') ? '<span class="tag warning">Tabayun</span>' : (($row->surJenis == 'PENTING' && $row->surTabayun == 'N') ? '<span class="tag success">Penting</span>' : (($row->surJenis == 'RAHASIA')?'<span class="tag alert">Rahasia</span>':'<span class="tag info">Biasa</span>'))); ?>
                                            <td class="align-center"><?php echo $row->surNoUrut; ?></td>
                                            <td class="align-center"><?php echo (($row->surNomorSurat != null)?$row->surNomorSurat:'--'); ?></td>
                                            <td class="align-center"><?php echo (($ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglSurat)!=null)?$ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglSurat):'--'); ?></td>
                                            <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglTerimaKeluar); ?></td>
                                            <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglInput); ?></td>
                                            <td class="align-center"><?php echo (($row->surSifat == 'KILAT') ? '<span class="tag alert">Kilat (1 x 24)</span>' : (($row->surSifat == 'SEGERA') ? '<span class="tag warning">Segera (2 x 24)</span>' : (($row->surSifat == 'PENTING') ? '<span class="tag info">Penting (3 x 24)</span>' : '<span class="tag success">Biasa</span>'))); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
                <div class="frame" id="frame_5_2">
                    <div class="row">
                        <?php
                       if($this->session->userdata('masuk_level')=='KASUBAGUMUM'){
                       ?>
                        <div class="grid" style="margin-top: 3px;">
                            <div class="row cells12">
                                <div class="dropdown-button place-right">
                                    <a class="button fg-white image-button bg-blue" href="<?php echo base_url() ?>surat_masuk/tambah_ptabayun">Tambah<span class="icon mif-plus bg-darkBlue fg-white"></span></a>
                                </div>
                            </div>
                        </div>
                       <?php } ?>
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <table class="dataTable border bordered tabel" data-role="datatable" data-auto-width="false">
                                <thead>
                                    <tr>
                                        <td style="width: 120px"><center>Aksi</center></td>
                                <td class="align-center sort-asc"style="width: 90px"><center>No Urut</center></td>
                                <td class="align-center sort-asc"><center>Nomor Surat</center></td>
                                <td class="align-center sort-asc"><center>Nomor Perkara</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Surat</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Diterima</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Input</center></td>
                                <td class="align-center sort-asc"><center>Sifat Surat</center></td>
                                <td class="align-center sort-asc" style="width: 85px"><center>Status</center></td>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data_query=$ci->SuratKeluarModel->getall_tabayun($this->session->userdata('masuk_id'));
                                    foreach ($data_query as $row) {
                                        ?>
                                        <tr>
                                            <?php
                                            if($this->session->userdata('masuk_level')=='KASUBAGUMUM'){
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Ubah Data" href="<?php echo base_url('surat_masuk/ubah_ptabayun/' . $row->surID); ?>" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_ptabayun/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-red" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Hapus" onclick="hapusstaff('<?php echo $row->surID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                                            <?php
                                            }else{
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_ptabayun/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a></td> 
                                            <?php
                                            }
                                            ?>
                                            <td class="align-center"><?php echo $row->surNoUrut; ?></td>
                                            <td class="align-center"><?php echo $row->surNomorSurat; ?></td>
                                            <td class="align-center"><?php echo $row->perNoPerkara; ?></td>
                                            <td class="align-center"><?php echo (($ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglSurat)!=null)?$ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglSurat):'--'); ?></td>
                                            <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglTerimaKeluar); ?></td>
                                            <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglInput); ?></td>
                                            <td class="align-center"><?php echo (($row->surSifat == 'KILAT') ? '<span class="tag alert">Kilat (1 x 24)</span>' : (($row->surSifat == 'SEGERA') ? '<span class="tag warning">Segera (2 x 24)</span>' : (($row->surSifat == 'PENTING') ? '<span class="tag info">Penting (3 x 24)</span>' : '<span class="tag success">Biasa</span>'))); ?>
                                            <td class="align-center"><?php echo 'xxxx';?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="frame" id="frame_5_3">
                    <div class="row">
                        <?php
                       if($this->session->userdata('masuk_level')=='KASUBAGUMUM'){
                       ?>
                        <div class="grid" style="margin-top: 3px;">
                            <div class="row cells12">
                                <div class="dropdown-button place-right">
                                    <a class="button fg-white image-button bg-blue" href="<?php echo base_url() ?>surat_masuk/tambah_pumum">Tambah<span class="icon mif-plus bg-darkBlue fg-white"></span></a>
                                </div>
                            </div>
                        </div>
                       <?php } ?>
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <table class="dataTable border bordered tabel" data-role="datatable" data-auto-width="false">
                                <thead>
                                    <tr>
                                        <td style="width: 120px"><center>Aksi</center></td>
                                <td class="align-center sort-asc"style="width: 90px"><center>No Urut</center></td>
                                <td class="align-center sort-asc"><center>Nomor Surat</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Surat</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Diterima</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Input</center></td>
                                <td class="align-center sort-asc"><center>Sifat Surat</center></td>
                                <td class="align-center sort-asc" style="width: 85px"><center>Status</center></td>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data_query=$ci->SuratKeluarModel->getall_penting($this->session->userdata('masuk_id'));
                                    foreach ($data_query as $row) {
                                        ?>
                                        <tr>
                                             <?php
                                            if($this->session->userdata('masuk_level')=='KASUBAGUMUM'){
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Ubah Data" href="<?php echo base_url('surat_masuk/ubah_pumum/' . $row->surID); ?>" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_pumum/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-red" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Hapus" onclick="hapusstaff('<?php echo $row->surID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td>
                                            <?php
                                            }else{
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_pumum/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a></td>
                                            <?php
                                            }
                                            ?>
                                            <td class="align-center"><?php echo $row->surNoUrut; ?></td>
                                            <td class="align-center"><?php echo $row->surNomorSurat; ?></td>
                                            <td class="align-center"><?php echo (($ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglSurat)!=null)?$ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglSurat):'--'); ?></td>
                                            <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglTerimaKeluar); ?></td>
                                            <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglInput); ?></td>
                                            <td class="align-center"><?php echo (($row->surSifat == 'KILAT') ? '<span class="tag alert">Kilat (1 x 24)</span>' : (($row->surSifat == 'SEGERA') ? '<span class="tag warning">Segera (2 x 24)</span>' : (($row->surSifat == 'PENTING') ? '<span class="tag info">Penting (3 x 24)</span>' : '<span class="tag success">Biasa</span>'))); ?>
                                            <td class="align-center"><?php echo 'xxxx';?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                if($this->session->userdata('masuk_level')=='KASUBAGUMUM' || $this->session->userdata('masuk_level')=='PIMPINAN'){
                ?>
                
                <div class="frame" id="frame_5_4">
                   <div class="row">
                       <?php
                if($this->session->userdata('masuk_level')=='KASUBAGUMUM'){
                ?>
                        <div class="grid" style="margin-top: 3px;">
                            <div class="row cells12">
                                <div class="dropdown-button place-right">
                                    <a class="button fg-white image-button bg-blue" href="<?php echo base_url() ?>surat_masuk/tambah_rahasia">Tambah<span class="icon mif-plus bg-darkBlue fg-white"></span></a>
                                </div>
                            </div>
                        </div>
                <?php } ?>
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <table class="dataTable border bordered tabel" data-role="datatable" data-auto-width="false">
                                <thead>
                                    <tr>
                                        <td style="width: 120px"><center>Aksi</center></td>
                                <td class="align-center sort-asc"style="width: 90px"><center>No Urut</center></td>
                                <td class="align-center sort-asc"><center>Asal Surat</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tujuan Surat</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Diterima</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Input</center></td>
                                <td class="align-center sort-asc"><center>Sifat Surat</center></td>
                                <td class="align-center sort-asc" style="width: 85px"><center>Status</center></td>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data_query=$ci->SuratKeluarModel->getall_rabi($this->session->userdata('masuk_id'),'RAHASIA');
                                    foreach ($data_query as $row) {
                                        ?>
                                        <tr>
                                            <?php
                                            if($this->session->userdata('masuk_level')=='KASUBAGUMUM'){
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Ubah Data" href="<?php echo base_url('surat_masuk/ubah_rahasia/' . $row->surID); ?>" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_rahasia/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-red" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Hapus" onclick="hapusstaff('<?php echo $row->surID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                                           <?php
                                            }else{
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_rahasia/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a></td> 
                                           <?php
                                            }
                                            ?>
                                            <td class="align-center"><?php echo $row->surNoUrut; ?></td>
                                            <td class="align-center"><?php echo $row->surDari; ?></td>
                                            <td class="align-center"><?php echo $row->surKepada; ?></td>
                                            <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglTerimaKeluar); ?></td>
                                            <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglInput); ?></td>
                                            <td class="align-center"><?php echo (($row->surSifat == 'KILAT') ? '<span class="tag alert">Kilat (1 x 24)</span>' : (($row->surSifat == 'SEGERA') ? '<span class="tag warning">Segera (2 x 24)</span>' : (($row->surSifat == 'PENTING') ? '<span class="tag info">Penting (3 x 24)</span>' : '<span class="tag success">Biasa</span>'))); ?>
                                            <td class="align-center"><?php echo 'xxxx';?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="frame" id="frame_5_5">
                    <div class="row">
                        <?php
                if($this->session->userdata('masuk_level')=='KASUBAGUMUM'){
                ?>
                        <div class="grid" style="margin-top: 3px;">
                            <div class="row cells12">
                                <div class="dropdown-button place-right">
                                    <a class="button fg-white image-button bg-blue" href="<?php echo base_url() ?>surat_masuk/tambah_biasa">Tambah<span class="icon mif-plus bg-darkBlue fg-white"></span></a>
                                </div>
                            </div>
                        </div>
                <?php } ?>
                        <div class="row" style="margin-bottom: 50px;margin-top: 10px;">
                            <table class="dataTable border bordered tabel" data-role="datatable" data-auto-width="false">
                                <thead>
                                    <tr>
                                        <td style="width: 120px"><center>Aksi</center></td>
                                <td class="align-center sort-asc"style="width: 90px"><center>No Urut</center></td>
                                <td class="align-center sort-asc"><center>Nomor Surat</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Surat</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Diterima</center></td>
                                <td class="align-center sort-asc" style="width: 140px"><center>Tgl Input</center></td>
                                <td class="align-center sort-asc"><center>Sifat Surat</center></td>
                                <td class="align-center sort-asc" style="width: 85px"><center>Status</center></td>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data_query=$ci->SuratKeluarModel->getall_rabi($this->session->userdata('masuk_id'),'BIASA');
                                    foreach ($data_query as $row) {
                                        ?>
                                        <tr>
                                            <?php
                                            if($this->session->userdata('masuk_level')=='KASUBAGUMUM'){
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-blue" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Ubah Data" href="<?php echo base_url('surat_masuk/ubah_biasa/' . $row->surID); ?>" class="cycle-button mini-button primary"><span class="mif-pencil"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_biasa/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a>&nbsp;<a data-role="hint" data-hint-background="bg-red" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Hapus" onclick="hapusstaff('<?php echo $row->surID; ?>')" class="cycle-button mini-button alert"><span class="mif-cross"></span></a></td> 
                                            <?php
                                            }else{
                                            ?>
                                            <td class="align-center"><a data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Klik Detail" href="<?php echo base_url('surat_masuk/detail_biasa/' . $row->surID); ?>" class="cycle-button mini-button success"><span class="mif-eye"></span></a></td> 
                                            <?php
                                            }
                                            ?>
                                            <td class="align-center"><?php echo $row->surNoUrut; ?></td>
                                            <td class="align-center"><?php echo $row->surNomorSurat; ?></td>
                                            <td class="align-center"><?php echo (($ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglSurat)!=null)?$ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglSurat):'--'); ?></td>
                                            <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglTerimaKeluar); ?></td>
                                            <td class="align-center"><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix($row->surTglInput); ?></td>
                                            <td class="align-center"><?php echo (($row->surSifat == 'KILAT') ? '<span class="tag alert">Kilat (1 x 24)</span>' : (($row->surSifat == 'SEGERA') ? '<span class="tag warning">Segera (2 x 24)</span>' : (($row->surSifat == 'PENTING') ? '<span class="tag info">Penting (3 x 24)</span>' : '<span class="tag success">Biasa</span>'))); ?>
                                            <td class="align-center"><?php echo 'xxxx';?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>   
        </div>
        <?php
        break;
}
?>
<script type="text/javascript">
                                $(document).ready(function() {
                                    $("#notif").fadeOut(7000);
                                    
                                    $("#formsm_tambah_disposisi").on('submit', (function (e) {
                                    e.preventDefault();
                                    for ( disUraian in CKEDITOR.instances ){
                                        CKEDITOR.instances[disUraian].updateElement();
                                    }
                                    var base_url='<?php echo base_url();?>';
                                    var disSumSukID = $('input[name="disSumSukID"]').val();
                                    var disKepadaPenID = $("select[name=disKepadaPenID]").val();
                                    var disNamaFile=$('input[name=disNamaFile]');
//                                    var disUraian = CKEDITOR.instances.disUraian.getData();
                                    if((disSumSukID != null || disSumSukID !='') && (disKepadaPenID != null || disKepadaPenID != '') && (disUraian != null || disUraian != '')){
                                        $.ajax({
                                           url: base_url+'disposisi/simpan_disposisi/',
                                           type: "POST",
                                           data: new FormData($(this)[0]),
                                           dataType: "json",
                                           cache: false,
                                           contentType: false,
                                           processData: false,
                                           success: function (data)
                                           {
                                               metroDialog.close('#modalsm_tambah_disposisi');
                                               if(data.status==true){
                                                    document.getElementById("pesan_modalsmd_info_sukses").innerHTML=data.msg;
                                                    metroDialog.toggle('#modalsmd_info_sukses');
                                               }else{
                                                   document.getElementById("pesan_modalsmd_info_gagal").innerHTML=data.msg;
                                                   metroDialog.toggle('#modalsmd_info_gagal');
                                               }
                                           }
                                           ,error: function ()
                                           {
//                                               alert("Terjadi Kesalahan,Data Disposisi Gagal Dikirim");
                                               location.reload();
//                                                   window.location.href = base_url+'surat_masuk/'+disSumSukID;
                                           }
                                       });
                                    }else{
                                        metroDialog.close('#modalsm_tambah_disposisi');
                                        document.getElementById("pesan_modalsmd_info_info").innerHTML='DATA INPUT TIDAK VALID';
                                        metroDialog.toggle('#modalsmd_info_sukses');
                                    }
                                    
                                   
                                }));
                                
                                $('select[name=surKlaID]').on("change",function(){
                                var id=$(this).val();    
                                if(id=="" || id==null){
                                     $("select[name=surKlaID1]").html("<option value=''>Pilih Klasifikasi Sub-1</option>");
                                     $("select[name=surKlaID2]").html("<option value=''>Pilih Klasifikasi Sub-1</option>");
                                     $("select[name=surKlaID]").focus();
                                }else{
                                 $.getJSON("<?php echo base_url(); ?>klasifikasi/getbyidparent/"+$(this).val(),null,function(results){
                                     $("select[name=surKlaID1]").html(results.res.msg);
                                     $("select[name=surKlaID2]").html("<option value=''>Pilih Klasifikasi Sub-2</option>");
                                     $("select[name=surKlaID1]").focus();
                                 }); 
                               }              
                             });
                             $('select[name=surKlaID1]').on("change",function(){
                                var id=$(this).val();    
                                if(id=="" || id==null){
                                     $("select[name=surKlaID2]").html("<option value=''>Pilih Klasifikasi Sub-2</option>");
                                     $("select[name=surKlaID1]").focus();
                                }else{
                                 $.getJSON("<?php echo base_url(); ?>klasifikasi/getbyidparent/"+$(this).val(),null,function(results){
                                     $("select[name=surKlaID2]").html(results.res.msg);
                                     $("select[name=surKlaID2]").focus();
                                 }); 
                               }              
                             });
                                });
                                function sm_tambah_disposisi(id) {
                                    $('#formsm_tambah_disposisi')[0].reset();
                                    CKEDITOR.replace('disUraian', {width: 420, height: 100});
                                    metroDialog.toggle('#modalsm_tambah_disposisi');
                                }
                                var id_tolak_disposisi;
                                function sm_tolak_disposisi(id) {
                                    id_tolak_disposisi=id;
                                     metroDialog.toggle('#modal_konfirm_tolak_disposisi');
                                }
                                function tolak_disposisi() {
                                    $.ajax({
                                        url: "<?php echo base_url('disposisi/hapusbyid'); ?>/" + id_tolak_disposisi,
                                        dataType: "JSON",
                                        success: function(data) {
                                        metroDialog.close('#modal_konfirm_tolak_disposisi');
                                               if(data.status > 0){
                                                    document.getElementById("pesan_modalsmd_info_sukses").innerHTML='Disposisi Berhasil Ditolak';
                                                    metroDialog.toggle('#modalsmd_info_sukses');
                                               }else{
                                                   document.getElementById("pesan_modalsmd_info_gagal").innerHTML='Disposisi Gagal Ditolak';
                                                   metroDialog.toggle('#modalsmd_info_gagal');
                                               }
                                        }, error: function(jqXHR, textStatus, errorThrown) {
//                                            alert('Error, Terdapat Kesalahan !');
                                            location.reload();
                                        }
                                    });
                                }
                                function reload_page(){
                                    location.reload();
                                }
                                
                                function ubahstaff(id) {
                                    $('#form_suratmasukpreEdit')[0].reset();
                                    metroDialog.toggle('#ModalSuratMasukPreStaffEdit');
                                    $.ajax({
                                        url: "<?php echo base_url(); ?>surat_masuk/getbyid_suratmasukpre/" + id,
                                        type: 'POST',
                                        dataType: 'JSON',
                                        canche: false,
                                        success: function(datax) {
                                            $('[name="smpID"]').val(datax.smpID);
                                            $('[name="smpKet"]').val(datax.smpKet);
                                        }, error: function(jqXHR, textStatus, errorThrown) {
                                            alert('Error, Terdapat Kesalahan !');
                                        }
                                    });
                                }
//                                oke
                                var idhapus;
                                function hapusstaff(id) {
                                    idhapus = id;
                                    metroDialog.toggle('#modal_konfirm');
                                }
                                function hapusdatastaff() {
                                    $.ajax({
                                        url: "<?php echo base_url('surat_masuk/hapusbyid'); ?>/" + idhapus,
                                        dataType: "JSON",
                                        success: function(data) {
                                            location.reload();
                                        }, error: function(jqXHR, textStatus, errorThrown) {
//                                            alert('Error, Terdapat Kesalahan !');
                                             location.reload();
                                        }
                                    });
                                }

</script>
<div data-role="dialog" id="modalsm_tambah_disposisi" class="padding20 text-bold" data-close-button="false" data-width="50%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false" data-color="fg-green">
    <div class="row">
        <h3 class="text-light fg-orange" id="judulTSuratMasukPreStaff"><span class="icon mif-users small bg-orange fg-white cycle-button"></span> Disposisi Surat</h3>
        <hr class="bg-orange"/>
        <form id="formsm_tambah_disposisi" method="POST" action="" data-role="validator" data-show-required-state="true" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white" enctype="multipart/form-data">
            <div class="grid">
                <input name="disSumSukID" type="hidden" value="<?php echo $data_query->surID;?>">
                <div class="row cells12 no-margin">
                        <div class="cell colspan4 bg-green fg-white padding10"><label>Dari </label><label class="fg-red">*</label></div>
                        <div class="cell colspan6">
                            <div class="input-control success full-size" style="margin-top: 15px;">
                                <label><?php echo $this->session->userdata('masuk_nama'); ?></label>
                            </div>
                        </div>
                </div>
                <div class="row cells12 no-margin">
                        <div class="cell colspan4 bg-green fg-white padding10"><label>Tanggal / Pukul </label><label class="fg-red">*</label></div>
                        <div class="cell colspan6">
                            <div class="input-control success full-size" style="margin-top: 15px;">
                                <label><?php echo $ci->Konfigurasi->MSQLDateToNormalInUnix(date('Y-m-d')).' / '.date('H:i:s'); ?></label>
                            </div>
                        </div>
                </div>
                <div class="row cells12 no-margin">
                        <div class="cell colspan4 bg-green fg-white padding10"><label>Tujuan </label><label class="fg-red">*</label></div>
                        <div class="cell colspan7">
                            <div class="input-control success full-size">
                                <select class="js-select full-size" name="disKepadaPenID" data-validate-func="required" data-validate-hint="Data Indek Tidak Boleh Kosong..!">
                                    <option value="">Pilih Tujuan Disposisi</option>
                                    <?php
                                    $data = $ci->DisposisiModel->getall_tujuan_disposisi($this->session->userdata('masuk_id'));
                                    foreach ($data as $row) {
                                        echo '<option value="' . $row->penID . '">' . $row->uniNama.' | '.$row->pegNama . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                </div>
                <div class="row cells12 no-margin">
                    <div class="cell colspan4 bg-green fg-white padding10"><label>File Lampiran</label></div>
                    <div class="cell colspan8">
                        <div class="input-control file success full-size" data-role="input">
                            <input type="file" name="disNamaFile">
                            <button class="button"><span class="mif-folder"></span></button>
                        </div>
                        <label class="fg-red mif-warning"> Format File (pdf, ms.word, ms.exel, rar & zip) & Size max 5Mb </label>
                    </div>
                </div>
                <div class="row cells12 no-margin">
                        <div class="cell colspan4 bg-green fg-white padding10" style="height: 145px;margin-top: 5px;"><label>Uraian</label><label class="fg-red">*</label></div>
                        <div class="cell colspan8"><div class="input-control textarea success full-size" data-role="input" data-text-auto-resize="true" data-text-max-height="100">
                                <textarea name="disUraian" id="disUraian" data-validate-func="required" data-validate-hint="Data Ringkasan Tidak Boleh Kosong..!"></textarea>
                                <span class="input-state-error mif-warning"></span>
                            </div>
                        </div>
                    </div>
                <div class="row"><span class="icon mif-warning mini fg-red place-left"><label class="text-italic"> Tanda <b>*</b> Harus Diisi !</label></span></div>
                <div class="row cells12">
                    <div class="cell colspan7"></div>
                    <div class="cell colspan5 place-right no-margin">
                        <button type="submit" class="button success"><span class="mif-floppy-disk"></span> Simpan</button>
                        <a href="<?php echo base_url() . $view.'/'.$subview.'/'.$data_query->surID; ?>" class="button alert text-light"><span class="mif-cross"></span> Batal</a>
                    </div>
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
                <button onclick="hapusdatastaff()" class="button text-accent"><span class="mif-checkmark"></span> Ya</button>
                <button onclick="metroDialog.close('#modal_konfirm')" class="button primary text-accent"><span class="mif-cross"></span> Tidak</button>
            </div>
        </div>
    </div> 
</div>
<div data-role="dialog" id="modal_konfirm_tolak_disposisi" class="padding20" data-close-button="true" data-type="alert" data-width="30%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false">
    <h3 class="text-light fg-white"><span class="icon mif-question small bg-red fg-white cycle-button"></span> Konfirmasi ?</h3>
    <hr class="bg-orange"/>
    <p>
        Apakah Anda Yakin Ingin Menolak Disposisi Ini ?
    </p>
    <div class="grid">
        <div class="row cells12">
            <div class="cell colspan4"></div>
            <div class="cell colspan8 place-right">
                <button onclick="tolak_disposisi()" class="button text-accent"><span class="mif-checkmark"></span> Ya</button>
                <button onclick="metroDialog.close('#modal_konfirm_tolak_disposisi')" class="button primary text-accent"><span class="mif-cross"></span> Tidak</button>
            </div>
        </div>
    </div> 
</div>
<div data-role="dialog" id="modalsmd_info_sukses" class="padding20" data-close-button="false" data-type="success" data-width="30%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false">
    <h3 class="text-light fg-white"><span class="fg-white"></span> Informasi</h3>
    <hr class="bg-yellow"/>
    <p id="pesan_modalsmd_info_sukses" class="fg-white text-light"></p>
    <div class="grid">
        <div class="row cells12">
                <center><button onclick="reload_page()" class="button warning text-accent"><span class="mif-cross"></span> Tutup</button></center>
        </div>
    </div> 
</div>
<div data-role="dialog" id="modalsmd_info_gagal" class="padding20" data-close-button="false" data-type="warning" data-width="30%" data-show="false" data-overlay="true" data-overlay-color="op-gray" data-overlay-click-close="false">
    <h3 class="text-light fg-white"><span class="fg-white"></span> Informasi</h3>
    <hr class="bg-yellow"/>
    <p id="pesan_modalsmd_info_gagal" class="fg-white text-light"></p>
    <div class="grid">
        <div class="row cells12">
                <center><button onclick="reload_page()" class="button warning text-accent"><span class="mif-cross"></span> Tutup</button></center>
        </div>
    </div> 
</div>
