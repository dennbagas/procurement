<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');

$segment_url = base_url($segment);
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
                        <th>
                            <center>No.</center>
                        </th>
                        <th>
                            <center>Nomor Surat</center>
                        </th>
                        <th>
                            <center>Tanggal</center>
                        </th>
                        <th>
                            <center>Kegiatan</center>
                        </th>
                        <th>
                            <center>Pekerjaan</center>
                        </th>
                        <th>
                            <center>Tujuan</center>
                        </th>
                        <th>
                            <center>Pemesan</center>
                        </th>
                        <th>
                            <center>Action</center>
                        </th>
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
        var tabel = generate_datatables({
            div: "#example",
            url: "<?php echo base_url('surat-pst/data_json') ?>",
            columns: [{
                "data": "id_surat"
            }, {
                "width": "85px",
                "data": "nomor_surat"
            }, {
                "data": "tanggal",
                "render": function (data, type, row) {
                    return date_id(data);
                }
            }, {
                "data": "kegiatan",
                "orderable": false
            }, {
                "data": "pekerjaan",
                "orderable": false
            }, {
                "data": "tujuan",
                "orderable": false
            }, {
                "data": "nama"
            }, {
                "width": "78px",
                "data": "id_surat",
                "orderable": false,
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = '<a href="<?php echo base_url("surat-pst/edit/' + data +
                        '") ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> | ' +
                        '<button class="btn btn-sm btn-danger" onclick="delete_data(' +
                        data + ')"><i class="fa fa-trash"></i></button>'

                    return html
                },
            }],
        });

        // t.on('draw.dt', function () {
        //     var PageInfo = $('#example').DataTable().page.info();
        //     t.column(0, {
        //         page: 'current'
        //     }).nodes().each(function (cell, i) {
        //         cell.innerHTML = i + 1 + PageInfo.start;
        //     });
        // });

        tabel.on('draw.dt', function () {
            var PageInfo = $('#example').DataTable().page.info();
            tabel.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        }).draw();
    });

    function delete_data(id_surat) {
        var urlRedirect = "<?=$segment_url?>";
        var url = "<?php echo base_url('surat-pst/destroy') ?>";
        deleteDialog({
            url: url,
            data: {
                id: id_surat
            },
            redirect: urlRedirect,
        })
    };
</script>

<?php
$this->load->view('template/foot');
?>