<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left info">
                <!-- Ambil nama dari data session -->
                <p class="text-uppercase" style="font-size:1.6rem;"><?=$this->session->userdata('ses_nama'); ?></p>
                <p style="font-size:1.2rem;"><?=$this->session->userdata('ses_level'); ?></p>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <?php if (current_url() != base_url('beranda')) {
                $this->load->view('template/sidebar/sidebar_surat', ['segment' => $segment]);
            } ?>
        </ul>
    </section>
</aside>
<div class="content-wrapper">