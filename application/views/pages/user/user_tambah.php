<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <center>Tambah User</center>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah User</h3>
        </div>
        <div class="box-body">
            <?=$this->session->flashdata('pegawai_message'); ?>
            <?=form_open('user/register_post', ['id' => 'forms', 'class' => 'form-horizontal', 'style' => 'width:70%;margin:auto;', 'name' => "submit"]); ?>
            <?=custom_dropdown('Nama Pegawai', ['name' => 'id_pegawai'], $options = $list_pegawai, '', ['id' => 'id_pegawai']) ?>
            <?=custom_input(['id' => 'nama_user', 'name' => 'nama_user', 'placeholder' => 'Username']) ?>
            <?=custom_password(['id' => 'password', 'name' => 'password', 'placeholder' => 'Password']); ?>
            <?=custom_submit(['name' => 'mysubmit', 'id' => 'submit'], 'Simpan', '', base_url('user')); ?>

            <?=form_close(); ?>
        </div>
    </div>

</section>

<?php
$this->load->view('template/js');
?>

<?php
$this->load->view('template/foot');
?>