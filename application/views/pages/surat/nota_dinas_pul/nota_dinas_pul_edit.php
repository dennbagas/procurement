<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');

$tanggal = date_id($data_surat['tanggal']);
$segment_url = base_url($segment);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div style="float:left;">
        <a href="<?=$segment_url ?>" class="btn btn-sm btn-primary">
            <i class="fa fa-arrow-circle-left"></i>
            Kembali
        </a>
    </div>
    <h1>
        <center>Edit Surat Nota Dinas PUL</center>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Surat Nota Dinas PUL</h3>
        </div>
        <div class="box-body">
            <?=$this->session->flashdata('message'); ?>
            <?=form_open('', ['id' => 'forms', 'class' => 'form-horizontal', 'style' => 'width:70%;margin:auto;', 'name' => "submit"]); ?>
            <?=custom_input_readonly(['name' => 'nomor_surat', 'placeholder' => 'Nomor Surat', 'id' => 'nomor_surat'], $value = $data_surat['nomor_surat']) ?>
            <?=custom_input(['name' => 'tanggal', 'placeholder' => 'Tanggal', 'id' => 'datepicker'], $value = $tanggal) ?>
            <?=custom_dropdown('Kegiatan', ['name' => 'kegiatan'], $options = [
                'ND Laporan Hasil Proses Lelang' => 'ND Laporan Hasil Proses Lelang',
                'ND Laporan Hasil Proses Penunjukan Langsung' => 'ND Laporan Hasil Proses Penunjukan Langsung',
                'ND Usulan Penetapan Pemenang' => 'ND Usulan Penetapan Pemenang',
                'ND Usulan Penetapan Pelaksana' => 'ND Usulan Penetapan Pelaksana',
                'ND Penetapan Pemenang' => 'ND Penetapan Pemenang',
                'ND Penetapan Pelaksana' => 'ND Penetapan Pelaksana',
                'ND Laporan Berakhirnya Masa Sanggah' => 'ND Laporan Berakhirnya Masa Sanggah',
            ], $data_surat['kegiatan'], ['id' => 'kegiatan'])
            ?>
            <?=custom_input(['name' => 'pekerjaan', 'placeholder' => 'Pekerjaan', 'id' => 'pekerjaan'], $value = $data_surat['pekerjaan']) ?>
            <?=custom_input(['name' => 'tujuan', 'placeholder' => 'Tujuan', 'id' => 'tujuan'], $value = $data_surat['tujuan']) ?>
            <?=custom_dropdown('Pemesan', ['name' => 'pemesan'],
                $options = $pegawai, $data_surat['nip'], ['id' => 'pemesan'])
            ?>
            <?=form_input(['type' => 'hidden', 'name' => 'id', 'id' => 'id'], $value = $data_surat['id_surat']) ?>
            <?=form_input(['type' => 'hidden', 'name' => 'tanggal', 'id' => 'altValue'], $value = $data_surat['tanggal']) ?>
            <?=custom_submit(['name' => 'mysubmit', 'value' => 'Simpan', 'id' => 'submit']); ?>
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
            var url = "<?php echo base_url(); ?>" + "nota-dinas-pul/update";
            var data = {
                // id dari input form
                id: $("#id").val(),
                nomor_surat: $("#nomor_surat").val(),
                tanggal: $("#altValue").val(),
                kegiatan: $("#kegiatan").val(),
                pekerjaan: $("#pekerjaan").val(),
                tujuan: $("#tujuan").val(),
                pemesan: $("#pemesan").val(),
                jenis: 'nota_dinas_pul',
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
                    }
                }
            });
        });

    });

    /*
     * Script untuk menampilkan dialog
     */
    function showSuccesDialog() {
        Swal.fire('Sukses', 'Berhasil update data surat', 'success')
            .then((result) => redirect("<?=$segment_url?>"));
    };
</script>

<?php
$this->load->view('template/foot');
?>