<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left info">
                <!-- Ambil nama dari data session -->
                <p class="text-uppercase" style="font-size:1.6rem;"><?= $this->session->userdata('ses_nama'); ?></p>
                <p style="font-size:1.2rem;"><?= $this->session->userdata('ses_level'); ?></p>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <?php
// $this->load->view('template/sidebar/sidebar_berita_acara'); ?>

            <li>
                <a href="#">
                    <i class="fa fa-th"></i> <span>Tahun 2021</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-th"></i> <span>Tahun 2020</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-th"></i> <span>Tahun 2019</span>
                </a>
            </li>

        </ul>
    </section>
</aside>
<div class="content-wrapper">