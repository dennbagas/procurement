<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <center>Beranda</center>
    </h1>
</section>

<section class="content">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Statistik Pembuatan Surat</h3>
        </div>
        <div class="box-body">
            <canvas id="myChart" width="10" height="3"></canvas>
        </div>
        <div class="box-footer">
            Data pada tahun 2019
        </div>
    </div>

</section>

<?php
$this->load->view('template/js');
?>

<script>
    jQuery(document).ready(function () {

        var ctx = $('#myChart');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Berita Acara', 'Nota Dinas GM', 'Nota Dinas PST', 'Nota Dinas PUL', 'Surat GM', 'Surat Lelang/PL', 'Surat PST'],
                datasets: [{
                    label: 'Data Surat Tahun 2019',
                    data: [12, 19, 3, 5, 2, 3, 200],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    });
</script>

<?php
$this->load->view('template/foot');
?>