<?php
defined('BASEPATH') or exit('No direct script access allowed');
// masukkan flash data ke dalam variabel $verification
$verification = $this->session->flashdata('msg');
?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Procurement | Log in</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet"
      type="text/css" />
    <link href="<?php echo base_url('assets/font-awesome-4.3.0/css/font-awesome.min.css') ?>" rel="stylesheet"
      type="text/css" />
    <link href="<?php echo base_url('assets/AdminLTE-2.0.5/dist/css/AdminLTE.min.css') ?>" rel="stylesheet"
      type="text/css" />
    <link href="<?php echo base_url('assets/AdminLTE-2.0.5/dist/css/skins/_all-skins.min.css') ?>" rel="stylesheet"
      type="text/css" />

    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>

  <body class="hold-transition login-page">

    <div class="login-box">
      <div class="login-logo">
        <img src="<?php echo base_url(); ?>assets/image/logo.png">
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body" style="margin-top: 5rem">
        <?php
        // Cetak jika ada notifikasi
        echo ($verification)
        // jika benar maka jalankan tanda ?
        ? '<p class="text-danger text-center" style="margin: 10px 20px;">'
        . $verification . '</p>'
        // jika salah maka jalankan tanda :
        : '';
        ?>
        <?php echo form_open('login/auth'); ?>
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
            <input type="nip" name="nip" class="form-control" placeholder="NIP" required>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <?php echo form_close(); ?>
      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  </body>

</html>