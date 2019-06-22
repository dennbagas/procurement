<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');

$segment_url = base_url($segment);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <center>Tambah Surat PST</center>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Surat PST</h3>
        </div>
        <div class="box-body">
            <?=$this->session->flashdata('message'); ?>
            <?=form_open('', ['id' => 'forms','class' => 'form-horizontal', 'style' => 'width:70%;margin:auto;', 'name' => "submit"]); ?>
            <?=custom_input_readonly(['name' => 'nomor_surat', 'placeholder' => 'Nomor Surat', 'id' => 'nomor_surat'], $value = $nomor_surat) ?>
            <?=custom_input(['name' => 'tanggal', 'placeholder' => 'Tanggal', 'id' => 'datepicker', 'autocomplete' => 'off']) ?>
            <?=custom_dropdown('Kegiatan', ['name' => 'kegiatan'], $options = [
                'Pengumuman Hasil Evaluasi Dokumen Penawaran&Undangan Negosiasi/Klarifikasi' => 'Pengumuman Hasil Evaluasi Dokumen Penawaran&Undangan Negosiasi/Klarifikasi',
                'Pengumuman Peniliaian Teknis' => 'Pengumuman Peniliaian Teknis',
            ], '', ['id' => 'kegiatan']) ?>
            <?=custom_input(['name' => 'pekerjaan', 'placeholder' => 'Pekerjaan', 'id' => 'pekerjaan']) ?>
            <?=custom_input(['name' => 'tujuan', 'placeholder' => 'Tujuan', 'id' => 'tujuan']) ?>
            <?=custom_dropdown('Pemesan', ['name' => 'pemesan'],
                $options = $pegawai, 'Pengumuman Hasil Evaluasi Dokumen Penawaran&Undangan Negosiasi/Klarifikasi', ['id' => 'pemesan']) ?>
            <?=form_hidden('jenis', 'surat_pst'); ?>
            <?=form_input(['type' => 'hidden', 'name' => 'tanggal', 'id' => 'altValue']) ?>
            <?=custom_submit(['name' => 'mysubmit', 'value' => 'Tambah', 'id' => 'submit']); ?>
            <?=form_close(); ?>
        </div>
    </div>
</section>

<?php
$this->load->view('template/js');
?>

<script>
    jQuery(document).ready(function () {
        /*
         * Script untuk menampilkan datepicker
         * setting format tanggal, nama hari dan bulan dalam bahasa indonesia
         */
        $("#datepicker").datepicker({
            dayNamesMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                "September", "Oktober", "November", "Desember"
            ],
            dateFormat: "dd MM yy",
            altFormat: "yy-mm-dd",
            altField: '#altValue',
        });

        $("#submit").click(function (event) {
            event.preventDefault();
            var url = "<?php echo base_url(); ?>" + "surat-pst/simpan";
            var data = {
                nomor_surat: $("#nomor_surat").val(),
                tanggal: $("#altValue").val(),
                kegiatan: $("#kegiatan").val(),
                pekerjaan: $("#pekerjaan").val(),
                tujuan: $("#tujuan").val(),
                pemesan: $("#pemesan").val(),
                jenis: 'surat_pst',
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
                        showCopyDialog();
                    }
                }
            });
        });

    });

    /*
     * Script untuk menampilkan dialog alert
     * setting untuk menampilkan nomor surat yang telah di generate
     *
     */
    function showCopyDialog() {

        // variabel untuk body dialog
        let body = '<div style="font-size:2rem;">Nomor Surat Anda</div>' +
            '<div style="font-size:2.5rem; margin:10px; padding:15px; border:1px solid #000">' +
            '<b><?=$nomor_surat ?></b>' + '</div>' +
            '<span style="font-size:1.4rem;">Klik tombol dibawah untuk menyalin.</span>';

        // variabel untuk footer dialog
        let footer = '<button data-clipboard-text="<?=$nomor_surat ?>"' +
            'class=" btn btn-primary"' +
            'style="font-size:2rem;">' +
            'Copy Nomor Surat' +
            '</button>';

        // panggil dialog dengan konfigurasi di atas
        Swal.fire({
            type: 'success',
            showConfirmButton: false,
            html: body,
            footer: footer,
            allowOutsideClick: false,
        })
    };

    // event yang di panggil ketika tombol Copy ditekan
    clipboard.on('success', function (e) {
        $("#submit").hide();
        Toast.fire({
                type: 'success',
                title: 'Copied: ' + e.text
            })
            .then(() => redirect("<?=$segment_url?>"))
            .catch(() => redirect("<?=$segment_url?>"));
    });
</script>

<?php
$this->load->view('template/foot');
?>