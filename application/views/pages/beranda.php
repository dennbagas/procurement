<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <center>Politeknik Negeri Madiun</center>
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
            Data pada tahun 2019 <div id="div1"></div>
        </div>
    </div>

</section>

<?php
$this->load->view('template/js');
?>

<script>
    jQuery(document).ready(function () {
        $.ajax({
            url: "<?=base_url('beranda/statistik') ?>",
            success: function (response) {
                setChart(response);
            }
        });
    });

    function setChart(data) {
        var json = JSON.parse(data);
        var label = json.label;

        var berita_acara = json.data.berita_acara || 0;
        var nota_dinas_gm = json.data.nota_dinas_gm || 0;
        var nota_dinas_pst = json.data.nota_dinas_pst || 0;
        var nota_dinas_pul = json.data.nota_dinas_pul || 0;
        var surat_gm = json.data.surat_gm || 0;
        var surat_lelang_pl = json.data.surat_lelang_pl || 0;
        var surat_pst = json.data.surat_pst || 0;

        var data = [
            berita_acara,
            nota_dinas_gm,
            nota_dinas_pst,
            nota_dinas_pul,
            surat_gm,
            surat_lelang_pl,
            surat_pst
        ]

        var bgColor = [
            'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'
        ];
        var borderColor = [
            'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'
        ];

        var ctx = $('#myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: json.label,
                datasets: [{
                    label: 'Data Surat Tahun 2019',
                    data: data,
                    backgroundColor: bgColor,
                    borderColor: borderColor,
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
    };
</script>

<?php
$this->load->view('template/foot');
?>