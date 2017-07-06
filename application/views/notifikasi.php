<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row padding20">
    <?php if ($this->session->flashdata("msg_sukses") != "") { ?>
        <div class="row" id="notif">
            <div class="padding10 bg-green fg-white text-light"><span class="mif-warning"></span> <?php echo $this->session->flashdata("msg_sukses"); ?></div>
        </div>
    <?php } else if ($this->session->flashdata("msg_eror") != "") { ?>
        <div class="row" id="notif">
            <div class="padding10 bg-red fg-white text-light"><span class="mif-warning"></span> <?php echo $this->session->flashdata("msg_eror"); ?></div>
        </div>
    <?php } ?>
    <h2 class="text-light fg-orange" style="margin-top: 2px;"> <?php echo config_item('APP_FULL_NAME'); ?> (<?php echo config_item('APP_SHORT_NAME'); ?>)</h2>
    <hr class="thin bg-orange">
    <div class="row grid">
        <div class="grid">
                <div class="row cells3">
                    <div class="cell">
                        <div class="window success">
                            <div class="window-caption">
                                <span class="window-caption-icon"><span class="mif-info"></span></span>
                                <span class="window-caption-title">Informasi Detail Peranggkat Gammu</span>
                            </div>
                            <div class="window-content" style="height: 100px">
                                <?php
//                                $hasil=array();
//                                exec("c:\C:\gammu\bin\gammu.exe -c c:\C:\gammu\bin\gammurc gammu getussd *888#", $hasil);
//                                $index=0;
//                               // proses filter hasil output
//                               for ($i=0; $i<=count($hasil)-1; $i++)
//                               {
//                                  if (substr_count($hasil[$i], 'Service reply') > 0) $index = $i;
//                               }
//
//                               // menampilkan sisa pulsa
//                               echo $hasil[$index];
 
//                               require_once(APPPATH.'libraries/gammu/gammu.php');
//                               $gammu_bin = 'C:/gammu/bin/gammu.exe';
//                               $gammu_config= 'C:/gammu/gammurc.txt';
//                               $gammu_config_section	= '1'; // for default section please set "blank" value --> $gammu_config_section = '';
//                               $sms = new gammu($gammu_bin,$gammu_config,$gammu_config_section);
                                // Identify Device information
//                               $sms->Identify($response);
//                               echo '<pre>';
//                               print_r($response);
//                               echo '</pre>';
                                //Get SMS from Device
//                                $response = $sms->Get();
//                                echo '<pre>';print_r($response); echo '</pre>';
                                //Sending SMS
//                                $sms->Send('+6281380830000','Test!',$response);
//                                echo '<pre>';
//                                print_r($response); echo '</pre>';
                                //Get Phone -> ME = Phone Memory; SM = Sim Card;  options list => DC|MC|RC|ON|VM|SM|ME|MT|FD|SL
//                                $response = $sms->phoneBook('SE');
//                                echo '<pre>';print_r($response); echo '</pre>';
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="cell">
                        <div class="window success">
                            <div class="window-caption">
                                <span class="window-caption-icon"><span class="mif-info"></span></span>
                                <span class="window-caption-title">Status Service Gammu</span>
                            </div>
                            <div class="window-content" style="height: 100px">
                                Terhubung/Terputus
                            </div>
                        </div>
                    </div>

                    <div class="cell">
                        <div class="window success">
                            <div class="window-caption">
                                <span class="window-caption-icon"><span class="mif-info"></span></span>
                                <span class="window-caption-title">Synyal Gammu</span>
                            </div>
                            <div class="window-content" style="height: 100px">
                                Angka Persentase
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="row">
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </div>
</div>
