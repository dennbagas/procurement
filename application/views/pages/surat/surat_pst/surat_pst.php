<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <center>
            Surat PST
        </center>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Surat PST</h3>
            <div class="box-tools pull-right">
                <a href="<?=base_url() . 'surat-pst/tambah' ?>" class="btn btn-success">
                    <i class="fa fa-pencil"></i> <span>Tambah Data</span>
                </a>
            </div>
        </div>
        <div class="box-body">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Pekerjaan</th>
                        <th>Tujuan</th>
                        <th>Pemesan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</section>

<?php
$this->load->view('template/js');
?>

<script>
    $(document).ready(function () {
        var tabel = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?php echo base_url('surat-pst/data_json') ?>", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [
                [10, 25, 50],
                [10, 25, 50]
            ], // Combobox Limit
            "columns": [{
                    "data": "id_surat",
                    "orderable": false
                },
                {
                    "data": "nomor_surat"
                },
                {
                    "data": "tanggal"
                },
                {
                    "data": "kegiatan",
                    "orderable": false
                },
                {
                    "data": "pekerjaan",
                    "orderable": false
                },
                {
                    "data": "tujuan",
                    "orderable": false
                },
                {
                    "data": "nama"
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = "<a href=''>EDIT</a> | "
                        html += "<a href=''>DELETE</a>"

                        return html
                    },
                    "orderable": false
                },
            ],
        }, );

        tabel.on('order.dt search.dt', function () {
            tabel.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>

<?php
$this->load->view('template/foot');
?>