<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Daftar Pegawai
        <small></small>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-body">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>
                            <center>id</center>
                        </th>
                        <th>
                            <center>NIP</center>
                        </th>
                        <th>
                            <center>Nama</center>
                        </th>
                        <th>
                            <center>Jenis Kelamin</center>
                        </th>
                        <th>
                            <center>Alamat</center>
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
                "url": "<?php echo base_url('pegawai/pegawai_json') ?>", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [
                [10, 25, 50],
                [10, 25, 50]
            ], // Combobox Limit
            "columns": [{
                    "data": "id_user"
                },
                {
                    "data": "nip"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "jenis_kelamin",
                    "render": function (data, type, row) { // Tampilkan kolom Role
                        let jenis_kelamin = (data == 0) ? "Laki-laki" : "Wanita";
                        return jenis_kelamin;
                    },
                    "orderable": false
                },
                {
                    "data": "alamat",
                    "orderable": false
                },
                {
                    "data": "level",
                    "render": function (data, type, row) { // Tampilkan kolom Role
                        let level = (data == 0) ? "Administrator" : "Pegawai";
                        return level;
                    },
                    "orderable": false
                },
                {
                    "data": "id_user",
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html =
                            '<center><button class="btn btn-sm btn-danger" onclick="deleteDialog(' + data + ')"><i class="fa fa-trash"></i></button></center>';

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
                    url: '<?php echo base_url('pegawai/destroy') ?>',
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
                            window.location.href = "<?php echo base_url(); ?>" + "pegawai";
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