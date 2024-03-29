<?php

class Pegawai extends BASE_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pegawai_model');
        if ($this->session->userdata('akses') != 'admin') {
            $url = base_url('beranda');
            redirect($url);
        }
    }

    // halaman pegawai
    public function index()
    {
        $this->load->view('pages/pegawai/pegawai');
    }

    public function pegawai_json()
    {
        // panggil fungsi return_json dari BaseController dengan model 'pegawai_model'
        $data = $this->return_json_users('pegawai_model', 'ms_pegawai');

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function tambah()
    {
        // tampilkan view
        $this->load->view('pages/pegawai/pegawai_tambah');
    }

    public function register_post()
    {
        $this->form_validation->set_rules('nip', 'NIP', 'required|min_length[5]|max_length[10]|is_unique[ms_pegawai.nip]',
            array(
                'required' => 'Kolom %s harus di isi.',
                'is_unique' => '- %s telah digunakan.',
                'min_length' => '- Panjang %s minimal 5 karakter.',
                'max_length' => '- Panjang %s maksimal 10 karakter.',
            ));

        $data = $this->input->post();

        if ($this->form_validation->run() != false) {
            $this->pegawai_model->register_pegawai($data);

            $this->session->set_flashdata('pegawai_message', success_message(
                $message = 'Berhasil Registrasi Pegawai',
                $url = base_url() . 'pegawai',
                $link = 'Lihat Daftar Pegawai'
            ));

            redirect('/pegawai/tambah');

        } else {

            $error = $this->db->error();
            $this->session->set_flashdata('pegawai_message',
                error_message($message = 'Gagal registrasi. ' . validation_errors())
            );

            $this->tambah();
        }
    }

    public function pegawai_edit($id)
    {
        $data_user = $this->pegawai_model->get_pegawai_edit($id);
        $this->load->view('pages/pegawai/pegawai_edit', ['data_user' => $data_user[0]]);
    }

    public function pegawai_update()
    {
        $this->form_validation->set_rules('nip', 'NIP', 'required',
            array(
                'required' => 'Kolom %s harus di isi.',
            ));

        // ambil data dari post request
        $data = $this->input->post();

        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            // update data
            $query = $this->pegawai_model->pegawai_update($data);

            echo $query ? json_encode(['success' => 'Success']) : json_encode(['error' => 'Database Error']);
        }
    }

    public function pegawai_destroy()
    {
        $id = $this->input->post('id');
        $delete = $this->pegawai_model->delete_pegawai($id);

        echo $delete ? json_encode(['success' => 'OK']) : json_encode(['error' => 'error']);
    }
}
