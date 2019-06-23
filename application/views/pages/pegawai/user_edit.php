<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <center>Edit User</center>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit User</h3>
        </div>
        <div class="box-body">
            <?=$this->session->flashdata('pegawai_message'); ?>
            <?=form_open('', ['id' => 'forms', 'class' => 'form-horizontal', 'style' => 'width:70%;margin:auto;', 'name' => "submit"]); ?>
            <?=form_input(['type' => 'hidden', 'name' => 'id', 'id' => 'id'], $value = $data_user['id_user']) ?>
            <?=custom_input(['id' => 'nama_user', 'name' => 'user_name', 'placeholder' => 'Username', 'value' => $data_user['nama_user']]) ?>
            <?=custom_password(['id' => 'password', 'name' => 'password', 'placeholder' => 'Password']); ?>
            <?=custom_submit(['name' => 'mysubmit', 'id' => 'submit'], 'Simpan', '', base_url('pegawai/user')); ?>

            <?=form_close(); ?>
        </div>
    </div>

</section>

<?php
$this->load->view('template/js');
?>

<script>
    jQuery(document).ready(function () {
        $("#submit").click(function (event) {
            event.preventDefault();
            var url = "<?php echo base_url(); ?>" + "pegawai/user_update";
            var data = {
                // id dari input form
                id_user: $("#id").val(),
                nama_user: $("#nama_user").val(),
                password: $("#password").val(),
            };

            $.ajax({
                url: url,
                data: data,
                type: "POST",
                dataType: 'json',
                success: function (res) {
                    if (res.error != null) {
                        Swal.fire('', res.error, 'warning')
                    } else if (res.success != null) {
                        showSuccesDialog();
                        $("#submit").hide();
                    }
                }
            });
        });

    });

    /*
     * Script untuk menampilkan dialog
     */
    function showSuccesDialog() {
        Swal.fire('Sukses', 'Berhasil update data user', 'success')
            .then((result) => redirect("<?=base_url('pegawai/user') ?>"));
    };
</script>

<?php
$this->load->view('template/foot');
?>