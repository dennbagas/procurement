<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Procurement | Log in</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/AdminLTE.min.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
  <?php 
    // masukkan flash data ke dalam variabel $verification
  $verification = $this->session->flashdata('pesan');
  ?>
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
      ? '<p class="text-danger mt-3" style="margin: 10px 20px;">'
      .$this->session->flashdata('pesan').'
      </p>' 
                  // jika salah maka jalankan tanda :
      : '' ;
      ?>
      <?php echo form_open('login');?>
      <div class="form-group">
        <input type="username" class="form-control" placeholder="Username" required>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
      </div>
      <?php echo form_close();?>
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
