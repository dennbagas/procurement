<?php

class User extends BASE_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        if ($this->session->userdata('akses') != 'admin') {
            $url = base_url('beranda');
            redirect($url);
        }
    }

    // halaman users
    public function index()
    {
        $this->load->view('pages/user/user');
    }

    public function users_json()
    {
        // panggil fungsi return_json dari BaseController dengan model 'users_model'
        $data = $this->return_json_users('users_model', 'ms_user');

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function tambah()
    {
        // tampilkan view
        $data['list_pegawai'] = self::_list_pegawai();
        $this->load->view('pages/user/user_tambah', $data);
    }

    public function register_post()
    {
        $this->form_validation->set_rules('nip', 'NIP', 'is_unique[ms_user.nip]',
            array(
                'is_unique' => '- Pegawai ini telah memiliki username & password.',
            ));

        $data = $this->input->post();

        if ($this->form_validation->run() != false) {
            $this->users_model->register_user($data);

            $this->session->set_flashdata('pegawai_message', success_message(
                $message = 'Berhasil Registrasi User',
                $url = base_url() . 'user',
                $link = 'Lihat Daftar User'
            ));

            redirect('/user/tambah');

        } else {

            $error = $this->db->error();
            $this->session->set_flashdata('pegawai_message',
                error_message($message = 'Gagal registrasi. ' . validation_errors())
            );

            $this->tambah();
        }
    }

    public function user_edit($id)
    {
        $data_user = $this->users_model->get_user_edit($id);
        $this->load->view('pages/user/user_edit', ['data_user' => $data_user[0]]);
    }

    public function user_update()
    {
        $this->form_validation->set_rules('nama_user', 'Username', 'required',
            array(
                'required' => 'Kolom %s harus di isi.',
            ));

        $this->form_validation->set_rules('password', 'Password', 'required',
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
            $query = $this->users_model->user_update($data);

            echo $query ? json_encode(['success' => 'Success']) : json_encode(['error' => 'Database Error']);
        }
    }

    public function user_destroy()
    {
        $id = $this->input->post('id');
        $delete = $this->users_model->delete_user($id);

        echo $delete ? json_encode(['success' => 'OK']) : json_encode(['error' => 'error']);
    }
}
