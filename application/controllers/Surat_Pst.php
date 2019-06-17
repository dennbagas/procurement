<?php

class Surat_Pst extends BASE_Controller
{
    // nama surat
    protected static $_segment = 'surat-pst';
    // jenis surat
    protected static $_jenis_surat = 'surat_pst';
    // format nomor surat
    protected static $_prefix_nomor_surat = 'PST.'; //awalan nomor surat
    protected static $_nomor_surat = '/PL.02/2019-B'; //akhiran  nomor surat

    public function __construct()
    {
        parent::__construct();
        $this->load->model('surat_model');
        $this->load->helper('date_format_id');
    }

    // halaman surat pst
    public function index()
    {
        $data['segment'] = self::$_segment;
        $this->load->view('pages/surat/surat_pst/surat_pst', $data);
    }

    public function data_json()
    {
        // panggil fungsi return_json dari BaseController dengan model 'surat_model' dan 'jenis_surat'
        $data = $this->return_json_surat('surat_model', self::$_jenis_surat);

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // function untukk tambah data baru
    public function tambah()
    {
        // load model users_model karena data pegawai ada di users_model
        $this->load->model('users_model');

        $data['segment'] = self::$_segment;

        // ambil data pegawai untuk di tampilkan di dropdown pemesan
        $pegawai = $this->users_model->get_pegawai();
        foreach ($pegawai as $value) {
            $data['pegawai'][$value['id_pegawai']] = $value['nama'];
        }

        // ambil data terakhir
        $last_number = $this->get_last_number(self::$_prefix_nomor_surat, self::$_jenis_surat);

        // format nomor surat
        $data['nomor_surat'] = self::$_prefix_nomor_surat . $last_number . self::$_nomor_surat;

        // tampilkan view
        $this->load->view('pages/surat/surat_pst/surat_pst_tambah', $data);
    }

    public function simpan()
    {
        // validasi input
        $this->form_validation->set_rules(self::$_validation_rules);

        // ambil data dari post request
        $data = $this->input->post();

        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $this->surat_model->register($data);
            echo json_encode(['success' => 'OK']);
        }
    }

    // function untuk edit data surat
    public function edit($id)
    {
        $this->load->model('users_model');

        $segment = self::$_segment;

        // ambil data pegawai untuk di tampilkan di dropdown pemesan
        $pegawai = $this->users_model->get_pegawai();
        foreach ($pegawai as $value) {
            $list_pegawai[$value['id_pegawai']] = $value['nama'];
        }

        // ambil data surat sesuai dengan id_surat
        $data_surat = $this->surat_model->get_surat_edit($id);

        $data = ['data_surat' => $data_surat[0], 'pegawai' => $list_pegawai, 'segment' => $segment];
        $this->load->view('pages/surat/surat_pst/surat_pst_edit', $data);
    }

    public function update()
    {
        // validasi input
        $this->form_validation->set_rules(self::$_validation_rules);

        // ambil data dari post request
        $data = $this->input->post();

        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            // update data
            $query = $this->surat_model->update_surat($data);

            if (!$query) {
                echo json_encode(['error' => 'Database Error']);
            } else {
                echo json_encode(['success' => 'Success']);
            }
        }
    }

    // function untuk hapus data
    public function destroy()
    {
        $id = $this->input->post('id');
        $delete = $this->surat_model->delete_surat($id);

        if ($delete) {
            echo json_encode(['success' => 'OK']);
        }
        echo json_encode(['error' => 'error']);
    }
}