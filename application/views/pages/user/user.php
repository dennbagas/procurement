<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <center>Daftar User</center>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar User</h3>
            <div class="box-tools pull-right">
                <a href="<?=base_url() . 'user/tambah' ?>" class="btn btn-success">
                    <i class="fa fa-pencil"></i> <span>Tambah Data</span>
                </a>
            </div>
        </div>
        <div class="box-body">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>
                            <center>NIP</center>
                        </th>
                        <th>
                            <center>Username</center>
                        </th>
                        <th>
                            <center>Role</center>
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

        tabel = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?php echo base_url('user/users_json') ?>", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [
                [10, 25, 50],
                [10, 25, 50]
            ], // Combobox Limit
            "columns": [
                {
                    "data": "nip"
                },
                {
                    "data": "nama_user"
                },
                {
                    "data": "level",
                    "render": function (data, type, row) { // Tampilkan kolom Role
                        let level = (data == 0) ? "Administrator" : "Pegawai";
                        return level;
                    },
                    "orderable": true
                },
                {
                    "data": "id_user",
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = '<center><a href="<?php echo base_url("user/user_edit/' + data +
                            '") ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> | ' +
                            '<button class="btn btn-sm btn-danger" onclick="deleteDialog(' +
                            data + ')"><i class="fa fa-trash"></i></button></center>';

                        return html
                    },
                    "orderable": false
                },
            ],
        });
    });

    function deleteDialog(data) {
        // console.log(data);
        Swal.fire({
            title: 'Anda yakin ingin menghapus?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(async (result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo base_url('user/user_destroy') ?>",
                    type: 'POST',
                    data: {
                        id: data
                    },
                    success: function (result) {
                        Swal.fire(
                            'Deleted!',
                            'Data Anda berhasil dihapus',
                            'success'
                        ).then((result) => {
                            window.location.href = "<?php echo base_url("user"); ?>";
                        });
                    }
                });

            }
        });
    };
</script>

<?php
$this->load->view('template/foot');
?>