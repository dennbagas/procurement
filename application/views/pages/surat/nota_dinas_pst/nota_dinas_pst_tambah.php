<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');

$nomor_surat = 'PST.001/ND/PL.02/2019';

?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><center>Tambah Surat Nota Dinas PST</center></h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Surat Nota Dinas PST</h3>
        </div>
        <div class="box-body">
            <?=$this->session->flashdata('message'); ?>
            <?=form_open('nota-dinas-pst/tambah_surat', ['class' => 'form-horizontal', 'style' => 'width:70%;margin:auto;']); ?>
            <?=custom_input_readonly(['name' => 'nomor_surat', 'placeholder' => 'Nomor Surat'], $value = $nomor_surat) ?>
            <?=custom_input(['name' => 'tanggal', 'placeholder' => 'Tanggal', 'id' => 'datepicker']) ?>
            <?=custom_dropdown(['label' => 'Kegiatan', 'name' => 'kegiatan'], $options = [
                'ND Pra Aanwijzing' => 'ND Pra Aanwijzing',
                'ND Aanwijzing' => 'ND Aanwijzing',
                'ND Pembuatan HPS/OE (Owner Estimate)' => 'ND Pembuatan HPS/OE (Owner Estimate)',
                'ND Pembukaan Dokumen Penawaran' => 'ND Pembukaan Dokumen Penawaran',
                'ND Evaluasi Dokumen Penawaran' => 'ND Evaluasi Dokumen Penawaran',
                'ND Undangan Negosiasi' => 'ND Undangan Negosiasi',
                'ND Laporan Hasil Lelang' => 'ND Laporan Hasil Lelang',
                'ND Laporan Hasil Penunjukan Langsung' => 'ND Laporan Hasil Penunjukan Langsung',
                'ND Masa Sanggah' => 'ND Masa Sanggah',
            ]) ?>
            <?=custom_input(['name' => 'pekerjaan', 'placeholder' => 'Pekerjaan']) ?>
            <?=custom_input(['name' => 'tujuan', 'placeholder' => 'Tujuan']) ?>
            <?=custom_dropdown(['label' => 'Pemesan', 'name' => 'pemesan'], $options = $pegawai) ?>
            <?=form_hidden('jenis', 'nota_dinas_pst'); ?>
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
    $(function () {
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
    });

    /*
     * Script untuk menampilkan dialog alert
     * setting untuk menampilkan nomor surat yang telah di generate
     * 
     * !!! TODO: buat agar tampil setelah save data berhasil
     */
    $("#submit").click(function () {

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
        })
    });

    // event yang di panggil ketika tombol Copy ditekan
    clipboard.on('success', function (e) {
        Toast.fire({
            type: 'success',
            title: 'Copied: ' + e.text
        })
    });
</script>

<?php
$this->load->view('template/foot');
?>