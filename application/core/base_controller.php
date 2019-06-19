<?php
class BASE_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        if ($this->session->userdata('masuk') != true) {
            $url = base_url();
            redirect($url);
        }
        $this->load->library(array('form_validation'));
        $this->load->helper(array('url', 'form', 'custom_form', 'flash_message', 'string_extractor'));
    }

    /**
     * Fungsi untuk menampilkan dan pencarian di datatable
     * kode di bawah ini disesuaikan dengan
     * spesifikasi dari jQuery datatable
     */
    public function return_json_surat($model, $jenis_surat = null)
    {
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"

        $sql_total = $this->$model->count_all($jenis_surat); // Panggil fungsi count_all pada "Model"
        $sql_data = $this->$model->filter(
            $jenis_surat,
            $search,
            $limit,
            $start,
            $order_field,
            $order_ascdesc
        );

        // Panggil fungsi filter pada "Model"
        $sql_filter = $this->$model->count_filter($jenis_surat, $search); // Panggil fungsi count_filter pada "Model"

        // Data yang akan dikirim kembali ke view
        $callback = array(
            'draw' => $_POST['draw'], // data dari datatablenya
             'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data,
        );

        return $callback; // Convert array $callback ke json
    }

    public function return_json_users($model, $table)
    {
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"

        $sql_total = $this->$model->count_all($table); // Panggil fungsi count_all pada "Model"
        $sql_data = $this->$model->filter(
            $search,
            $limit,
            $start,
            $order_field,
            $order_ascdesc,
            $table
        );

        // Panggil fungsi filter pada "Model"
        $sql_filter = $this->$model->count_filter($search, $table); // Panggil fungsi count_filter pada "Model"

        // Data yang akan dikirim kembali ke view
        $callback = array(
            'draw' => $_POST['draw'], // data dari datatablenya
             'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data,
        );

        return $callback; // Convert array $callback ke json
    }

    public function get_last_number($prefix, $jenis_surat)
    {
        $query = $this->surat_model->get_last_record($jenis_surat);
        
        if ($prefix != '') {
            $last_record = between($prefix, '/', $query);
        } else {
            $last_record = strstr($query, '/', true);
        }

        $last_number = sprintf("%03d", (int)$last_record + 1);
        return $last_number;
    }

    // validation rules saat input dan update surat
    protected static $_validation_rules = [
        [
            'field' => 'nomor_surat',
            'label' => 'Nomor Surat',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom %s harus di isi.',
            ],
        ],

        [
            'field' => 'tanggal',
            'label' => 'Tanggal',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom %s harus di isi.',
            ],
        ],

        [
            'field' => 'kegiatan',
            'label' => 'Kegiatan',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom %s harus di isi.',
            ],
        ],

        [
            'field' => 'pekerjaan',
            'label' => 'Pekerjaan',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom %s harus di isi.',
            ],
        ],

        [
            'field' => 'tujuan',
            'label' => 'Tujuan',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom %s harus di isi.',
            ],
        ],

        [
            'field' => 'jenis',
            'label' => 'Jenis',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom %s harus di isi.',
            ],
        ],

        [
            'field' => 'pemesan',
            'label' => 'Pemesan',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom %s harus di isi.',
            ],
        ],
    ];
}
