<?php

class Surat_Gm extends BASE_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('surat_model');
    }

    // halaman surat gm
    public function index()
    {
        $this->load->view('pages/surat/surat_gm/surat_gm');
    }

    public function data_json()
    {
        // panggil fungsi return_json dari BaseController dengan model 'surat_model'
        $data = $this->return_json('surat_model');

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function tambah()
    {
        // load model users_model karena data pegawai ada di users_model
        $this->load->model('users_model');
        // ambil data pegawai untuk di tampilkan di dropdown pemesan
        $pegawai = $this->users_model->get_pegawai();
        foreach ($pegawai as $value) {
            $data['pegawai'][$value['id_pegawai']] = $value['nama'];
        }

        $this->load->view('pages/surat/surat_gm/surat_gm_tambah', $data);
    }

    public function tambah_surat()
    {
        $data = $this->input->post();

        if ($this->surat_model->register($data) != false) {

            $this->session->set_flashdata('message',
                success_message(
                    $message = 'Berhasil Tambah Data',
                    $url = base_url() . 'surat-gm',
                    $link = 'Lihat Daftar Surat'
                )
            );

            redirect('/surat-gm/tambah');

        } else {

            $error = $this->db->error();
            $this->session->set_flashdata('message',
                error_message($message = 'Surat gagal ditambahkan. Error Code (' . $error['code'] . ')')
            );

            $this->tambah();
        }

    }

}