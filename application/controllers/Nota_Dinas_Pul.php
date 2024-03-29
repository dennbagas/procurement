<?php

class Nota_Dinas_Pul extends BASE_Controller
{
    // nama surat
    protected static $_nama_surat = 'Nota Dinas PUL';

    // opsi kegiatan surat
    protected static $_kegiatan = [
        'ND Laporan Hasil Proses Lelang' => 'ND Laporan Hasil Proses Lelang',
        'ND Laporan Hasil Penunjukan Langsung' => 'ND Laporan Hasil Penunjukan Langsung',
        'ND Usulan Penetapan Pemenang' => 'ND Usulan Penetapan Pemenang',
        'ND Usulan Penetapan Pelaksana' => 'ND Usulan Penetapan Pelaksana',
        'ND Penetapan Pemenang' => 'ND Penetapan Pemenang',
        'ND Penetapan Pelaksana' => 'ND Penetapan Pelaksana',
        'ND Laporan Berakhirnya Masa Sanggah' => 'ND Laporan Berakhirnya Masa Sanggah',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('surat_model');
        $this->load->helper('date_format_id');
    }

    // halaman berita acara
    public function index($year = null)
    {
        $data['judul'] = self::$_nama_surat;
        $data['year'] = $year;
        $data['segment'] = self::_segment();
        $this->load->view('pages/surat/index', $data);
    }

    public function data_json()
    {
        // panggil fungsi return_json dari BaseController dengan model 'surat_model' dan 'jenis_surat'
        $data = $this->return_json_surat('surat_model', self::_jenis_surat());

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // function untukk tambah data baru
    public function tambah()
    {
        // load model users_model karena data pegawai ada di users_model
        $this->load->model('users_model');

        // title halaman
        $data['judul'] = self::$_nama_surat;

        // segment surat
        $data['segment'] = self::_segment();

        // jenis surat
        $data['jenis_surat'] = self::_jenis_surat();

        // ambil data pegawai untuk di tampilkan di dropdown pemesan
        $data['pegawai'] = self::_list_user();

        // opsi kegiatan
        $data['kegiatan'] = self::$_kegiatan;

        // ambil data bulan sekarang
        $current_month = romawi(self::_current_month());

        // ambil data tahun sekarang
        $current_year = self::_current_year();

        // format nomor surat
        // setting format penomoran surat di tulis di dalam koding dibawah ini
        $prefix_nomor_surat = 'PUL.'; //awalan nomor surat
        $nomor_surat = '/ND/PL.02/' . $current_month . '/' . $current_year . ''; //akhiran  nomor surat

        // ambil data terakhir
        $last_number = $this->get_last_number($prefix_nomor_surat, self::_jenis_surat(), $current_year);

        // format nomor surat
        $data['nomor_surat'] = $prefix_nomor_surat . $last_number . $nomor_surat;

        // tampilkan view
        $this->load->view('pages/surat/tambah_surat', $data);
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

        // title halaman
        $judul = self::$_nama_surat;

        // segment surat
        $segment = self::_segment();

        // jenis surat
        $jenis_surat = self::_jenis_surat();

        // ambil data pegawai untuk di tampilkan di dropdown pemesan
        $list_pegawai = self::_list_user();

        // opsi kegiatan
        $kegiatan = self::$_kegiatan;

        // ambil data surat sesuai dengan id_surat
        $data_surat = $this->surat_model->get_surat_edit($id);

        $data = [
            'judul' => $judul,
            'segment' => $segment,
            'jenis_surat' => $jenis_surat,
            'kegiatan' => $kegiatan,
            'data_surat' => $data_surat[0],
            'pegawai' => $list_pegawai,
        ];

        $this->load->view('pages/surat/edit_surat', $data);

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
        $id = $this->input->post('id_surat');
        $delete = $this->surat_model->delete_surat($id);

        if ($delete) {
            echo json_encode(['success' => 'OK']);
        }
        echo json_encode(['error' => 'error']);
    }
}
