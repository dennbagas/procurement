<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <center>Edit Data Pegawai</center>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Data Pegawai</h3>
        </div>
        <div class="box-body">
            <?=$this->session->flashdata('pegawai_message'); ?>
            <?=form_open('', ['id' => 'forms', 'class' => 'form-horizontal', 'style' => 'width:70%;margin:auto;', 'name' => "submit"]); ?>
            <?=form_input(['type' => 'hidden', 'name' => 'id', 'id' => 'id'], $value = $data_user['id_pegawai']) ?>
            <?=custom_input(['id' => 'nip', 'name' => 'nip', 'placeholder' => 'NIP', 'value' => $data_user['nip']]) ?>
            <?=custom_input(['id' => 'nama', 'name' => 'nama', 'placeholder' => 'Nama', 'value' => $data_user['nama']]) ?>
            <?=custom_input(['id' => 'alamat', 'name' => 'alamat', 'placeholder' => 'Alamat', 'value' => $data_user['alamat']]) ?>
            <?=custom_dropdown('Jenis Kelamin', [
                'name' => 'jenis_kelamin',
                'value' => $data_user['jenis_kelamin'],
            ],
                $options = array('0' => 'Laki-laki', '1' => 'Perempuan'),
                $selected = $data_user['jenis_kelamin'], ['id' => 'jenis_kelamin'])
            ?>
            <?=custom_submit(['name' => 'mysubmit', 'id' => 'submit'], 'Simpan', '', base_url('pegawai')); ?>

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
            var url = "<?php echo base_url(); ?>" + "pegawai/pegawai_update";
            var data = {
                // id dari input form
                id_pegawai: $("#id").val(),
                nip: $("#nip").val(),
                nama: $("#nama").val(),
                alamat: $("#alamat").val(),
                jenis_kelamin: $("#jenis_kelamin").val(),
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
        Swal.fire('Sukses', 'Berhasil update data pegawai', 'success')
            .then((result) => redirect("<?=base_url('pegawai') ?>"));
    };
</script>

<?php
$this->load->view('template/foot');
?>