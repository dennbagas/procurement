<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');

// default value
$nip = set_value('nip');
$user_name = set_value('user_name');
$nama = set_value('nama');
$alamat = set_value('alamat');
$jenis_kelamin = set_value('jenis_kelamin');
$password = set_value('password');

?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <center>Tambah Data Pegawai Baru</center>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Data Pegawai Baru</h3>
        </div>
        <div class="box-body">
            <?=$this->session->flashdata('pegawai_message'); ?>
            <?=form_open('pegawai/register_post', ['class' => 'form-horizontal', 'style' => 'width:70%;margin:auto;']); ?>

            <?=custom_input(['name' => 'nip', 'placeholder' => 'NIP', 'value' => $nip]) ?>
            <?=custom_input(['name' => 'nama', 'placeholder' => 'Nama', 'value' => $nama]) ?>
            <?=custom_input(['name' => 'alamat', 'placeholder' => 'Alamat', 'value' => $alamat]) ?>
            <?=custom_dropdown('Jenis Kelamin', [
                'name' => 'jenis_kelamin',
                'value' => $jenis_kelamin,
            ],
            $options = array('0' => 'Laki-laki', '1' => 'Perempuan'),
            $selected = array('0' => 'Laki-laki'))
            ?>
            <?=custom_input(['name' => 'user_name', 'placeholder' => 'Username', 'value' => $user_name]) ?>
            <?=custom_password(['name' => 'password', 'placeholder' => 'Password', 'value' => $password]); ?>
            <?=custom_submit(['name' => 'mysubmit', 'value' => 'Tambah Pegawai']); ?>

            <?=form_close(); ?>
        </div>
    </div>

</section>

<?php
$this->load->view('template/js');
?>
<!--tambahkan custom js disini-->
<?php
$this->load->view('template/foot');
?>