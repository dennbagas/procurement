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
        $this->load->view('pages/pegawai');
    }

    public function pegawai_json()
    {
        // panggil fungsi return_json dari BaseController dengan model 'users_model'
        $data = $this->return_json_users('users_model');

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function register()
    {
        $this->load->view('pages/registrasi');
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
            $password = $this->input->post('password');
            $nama = $this->input->post('nama');
            $jenis_kelamin = $this->input->post('jenis_kelamin');
            $alamat = $this->input->post('alamat');

            $this->users_model->register($nip, $password, $nama, $jenis_kelamin, $alamat);

            $this->session->set_flashdata('pegawai_message', success_message(
                $message = 'Berhasil Registrasi Pegawai',
                $url = base_url() . 'pegawai',
                $link = 'Lihat Daftar Pegawai'
            ));

            redirect('/pegawai/register');

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
}
