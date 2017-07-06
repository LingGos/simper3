<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
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
        <!--Animate Header-->
        <link href="<?php echo base_url(); ?>asset/css/AnimatedHeader/normalize.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>asset/css/AnimatedHeader/demo.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>asset/css/AnimatedHeader/component.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>asset/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/metro.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/docs.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/ga.js"></script>
        <style>
            html, body {
                height: auto;
            }
            .page-content {
                padding-top: 3.125rem;
                min-height: 100%;
                height: 100%;
            }
            .login-form {
                width: 28rem;
                height: 22.3rem;
                position: fixed;
                top: 50%;
                margin-top: -9.375rem;
                left: 50%;
                margin-left: -14.0rem;
                background-color: #ffffff;
                opacity: 0;
                -webkit-transform: scale(.8);
                transform: scale(.8);
                border-radius: 15px;
            }
        </style>
        <script>
            $(function() {
                var form = $(".login-form");

                form.css({
                    opacity: 1,
                    "-webkit-transform": "scale(1)",
                    "transform": "scale(1)",
                    "-webkit-transition": ".5s",
                    "transition": ".5s"
                });
            });
        </script>
    </head>
    <body class="bg-white">
        <div class="app-bar green" data-role="appbar">
            <a class="app-bar-element branding"><img src="<?php echo base_url(); ?>_temp/img/logo_pa_pku.png" style="height: 28px; display: inline-block; margin-right: 10px;"><?php echo ' ' . $this->config->item('APP_SHORT_NAME'); ?><sup><?php echo ' ' . $this->config->item('APP_VERSION'); ?></sup></a>
            <span class="app-bar-divider"></span>
            <a class="app-bar-element branding"><?php echo $this->config->item('APP_FULL_NAME'); ?> </a>
        </div>
        <div class="page-content">
<!--            <div class="page-content container demo-1 content large-header" id="large-header">
            <canvas id="demo-canvas"></canvas>-->
            <div class="login-form padding20 block-shadow" style="background-color: #60a917;">
                <form action="<?php echo base_url() ?>masuk/cekmasuk" method="POST" data-role="validator" data-show-required-state="false" data-show-success-state="true" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white">
                    <center><img src="<?php echo base_url(); ?>_temp/img/logo_pa_pku.png" style="height: 90px; display: inline-block;"></center>
                    <center><b><label class="text-light fg-white"><?php echo $this->config->item('APP_COMPANY_NAME'); ?></label></b></center>
                    <center><label class="text-light fg-white" style="font-size: 10px;"><?php echo $this->config->item('APP_SITE_FOOTER'); ?> </label></center>
                    <?php if ($this->session->flashdata("msg_login") != "") { ?>
                        <div class="row" id="notif">
                            <div class="padding10 bg-orange fg-white text-accent" style="font-size: 11px;"><span class="mif-warning"></span> <?php echo $this->session->flashdata("msg_login"); ?></div>
                        </div>
                    <?php } ?>                      
                    <br/>
                    <div class="row">
                        <div class="input-control text full-size">
                            <span class="mif-user prepend-icon"></span>
                            <input type="text" name="penUsername" data-validate-func="required" placeholder="Username" data-validate-hint="Username Tidak Boleh Kosong..!" autofocus style="border-radius: 15px">
                            <button class="button helper-button clear" style="margin-right: 10px;"><span class="mif-cross"></span></button>
                            <span class="input-state-error mif-warning"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-control text full-size">
                            <span class="mif-lock prepend-icon"></span>
                            <input type="password" name="penPassword"data-validate-func="required" placeholder="Password" data-validate-hint="Password Tidak Boleh Kosong..!" style="border-radius: 15px">
                            <button class="button helper-button reveal" style="margin-right: 10px;"><span class="mif-looks"></span></button>
                            <span class="input-state-error mif-warning"></span>
                        </div>
                    </div>
                    <div class="row">
                        <label class="input-control checkbox small-check fg-white">
                            <input type="checkbox" name="penIngat" value="1" >
                            <span class="check"></span>
                            <span class="caption">Ingat Saya ?</span>
                        </label>
                    </div>
                    <div class="row">
                        <center>
                            <div class="form-actions place-right">
                                <button style="border-radius: 15px;" name="penMasukBtn" type="submit" class="button bg-white fg-green"><span class="mif-enter"></span> Masuk</button>
                                <a style="border-radius: 15px;" href="<?php echo base_url(); ?>" class="button warning"><span class="mif-cancel"></span> Batal</a>
                            </div>
                        </center>
                    </div>
                </form>                
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#notif").fadeOut(8000);
            });
        </script>
        <!--Animate Header-->
        <script src="<?php echo base_url(); ?>asset/js/AnimatedHeader/TweenLite.min.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/AnimatedHeader/EasePack.min.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/AnimatedHeader/rAF.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/AnimatedHeader/demo-1.js"></script>
    </body>
</html>