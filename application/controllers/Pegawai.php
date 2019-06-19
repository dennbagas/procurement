<?php

class Pegawai extends BASE_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
    }

    // halaman pegawai
    public function index()
    {
        $this->load->view('pages/pegawai/pegawai');
    }

    public function pegawai_json()
    {
        // panggil fungsi return_json dari BaseController dengan model 'users_model'
        $data = $this->return_json_users('users_model', 'ms_pegawai');

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // halaman users
    public function user()
    {
        $this->load->view('pages/pegawai/user');
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
        $this->load->view('pages/pegawai/pegawai_tambah');
    }

    public function register_post()
    {
        $this->form_validation->set_rules('nip', 'NIP', 'required|min_length[5]|max_length[10]|is_unique[ms_user.nip]',
            array(
                'required' => 'Kolom %s harus di isi.',
                'is_unique' => '- %s telah digunakan.',
                'min_length' => '- Panjang %s minimal 5 karakter.',
                'max_length' => '- Panjang %s maksimal 10 karakter.',
            ));
        $this->form_validation->set_rules('password', 'Password', 'required',
            array(
                'required' => 'Kolom %s harus di isi.',
            ));

        if ($this->form_validation->run() != false) {
            $nip = $this->input->post('nip');
            $username = $this->input->post('user_name');
            $password = $this->input->post('password');
            $nama = $this->input->post('nama');
            $jenis_kelamin = $this->input->post('jenis_kelamin');
            $alamat = $this->input->post('alamat');

            $this->users_model->register($nip, $username, $password, $nama, $jenis_kelamin, $alamat);

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

            $this->register();
        }
    }

    public function destroy()
    {
        $id = $this->input->post('id');
        $delete = $this->users_model->delete_data($id);

        if ($delete) {
            echo json_encode(['success' => 'OK']);
        }

        echo json_encode(['error' => 'error']);
    }

    public function pegawai_edit($id)
    {
        $data_user = $this->users_model->get_pegawai_edit($id);
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
            $query = $this->users_model->pegawai_update($data);

            if (!$query) {
                echo json_encode(['error' => 'Database Error']);
            } else {
                echo json_encode(['success' => 'Success']);
            }
        }
    }

    public function user_edit($id)
    {
        $data_user = $this->users_model->get_user_edit($id);
        $this->load->view('pages/pegawai/user_edit', ['data_user' => $data_user[0]]);
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

            if (!$query) {
                echo json_encode(['error' => 'Database Error']);
            } else {
                echo json_encode(['success' => 'Success']);
            }
        }
    }
}
