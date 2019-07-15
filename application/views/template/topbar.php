</head>

<!-- warna tema -->

<body class="skin-blue">
    <div class="wrapper">
        <header class="main-header">
            <a href="#" class="logo"><b>Procurement</b></a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                </a>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="<?=base_url() . 'beranda'; ?>">
                                Beranda <span class="sr-only">(current)</span>
                            </a>
                        </li>

                        <?php
                        // jika level user = admin
                        if ($this->session->userdata('akses') == 'admin') {
                            // maka tampilkan menu admin
                            $this->load->view('template/topbar/topbar_admin');
                        }
                        ?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">Surat <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=base_url('berita-acara') ?>">Berita Acara</a></li>
                                <li><a href="<?=base_url('nota-dinas-gm') ?>">Nota Dinas GM</a></li>
                                <li><a href="<?=base_url('nota-dinas-pst') ?>">Nota Dinas PST</a></li>
                                <li><a href="<?=base_url('nota-dinas-pul') ?>">Nota Dinas PUL</a></li>
                                <li><a href="<?=base_url('surat-gm') ?>">Surat GM</a></li>
                                <li><a href="<?=base_url('surat-lelang-pl') ?>">Surat Lelang PL</a></li>
                                <li><a href="<?=base_url('surat-pst') ?>">Surat PST</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle text-uppercase" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false"><?=$this->session->userdata('ses_nama'); ?>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu" style="width:200px;">
                                <li class="user-body bg-primary" style="padding:10px 20px;margin:-5px 0 10px 0;">
                                    <span>NIP : <?=$this->session->userdata('ses_nip'); ?></span>
                                </li>
                                <li>
                                    <a href="<?=base_url() . 'login/logout'; ?>">
                                        <i class="fa fa-power-off text-danger"></i>
                                        <span>Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>