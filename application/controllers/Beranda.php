<?php
class Beranda extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        if ($this->session->userdata('masuk') != true) {
            $url = base_url();
            redirect($url);
        }
        $this->load->model('surat_model');
    }

    public function index()
    {
        $this->load->view('pages/beranda');
    }

    public function statistik()
    {
        $raw_data = $this->surat_model->get_statistik();
        foreach ($raw_data as $value) {
            $data[$value['jenis']] = $value['count'];
        }
        
        echo json_encode([
            "data" => $data ?? [],
            "label" => [
                'Berita Acara',
                'Nota Dinas GM',
                'Nota Dinas PST',
                'Nota Dinas PUL',
                'Surat GM',
                'Surat Lelang/PL',
                'Surat PST',
            ],
        ]);
    }
}