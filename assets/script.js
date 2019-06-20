var clipboard = new ClipboardJS('.btn');
let selDate;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

function toastSuccess(text) {
    return Toast.fire({
        type: 'success',
        title: text
    })
};

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
});

function redirect(url) {
    return window.location.href = url;
};

function generate_datatables(param) {
    return $(param.div).DataTable({
        "processing": true,
        "serverSide": true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [
            [1, 'asc']
        ],
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0,
            className: 'text-center',
        }],
        "ajax": {
            "url": param.url, // URL file untuk proses select datanya
            "type": "POST",
            data: { year: param.year }
        },
        "deferRender": true,
        "aLengthMenu": [
            [10, 25, 50],
            [10, 25, 50]
        ], // Combobox Limit
        "columns": param.columns,
    });
}

// function untuk menampilkan dialog sewaktu tombol delete ditekan
function deleteDialog(param) {
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
                url: param.url,
                type: 'POST',
                data: param.data,
                success: function () {
                    Swal.fire(
                        'Sukses!',
                        'Data Anda berhasil dihapus',
                        'success'
                    ).then(() => {
                        window.location.href = param.redirect
                    });
                }
            });
        }
    });
};

function date_id(date) {
    var bulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    var date = new Date(date);
    var tanggal = date.getDate();
    var xbulan = date.getMonth();
    var tahun = date.getFullYear();

    var bulan = bulan[xbulan];
    return tanggal + ' ' + bulan + ' ' + tahun;
};