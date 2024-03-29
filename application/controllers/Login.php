<?php
class Login extends CI_Controller
{
    // fungsi yang akan di jalankan ketika class ini di panggil
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->model(array('users_model', 'pegawai_model'));
    }

    // fungsi untuk memanggil halaman login
    public function index()
    {
        $this->users_model->activate();
        if ($this->session->userdata('masuk') != false) {
            redirect('beranda');
        } else {
            $this->load->view('pages/login');
        }
    }

    // fungsi untuk authentifikasi
    public function auth()
    {
        // terima data dari input login
        $nama_user = htmlspecialchars($this->input->post('nama_user', true), ENT_QUOTES);
        $password = htmlspecialchars($this->input->post('password', true), ENT_QUOTES);

        // ambil data dari database
        $auth = $this->users_model->login($nama_user, $password);
        // jika ditemukan data, maka ...

        if ($auth->num_rows() > 0) {

            // ... masukkan data ke dalam variabel $data
            $data = $auth->row_array();
            $bio = $this->pegawai_model->bio($data['nip'])->row_array();
            print_r($bio);
            // set user data masuk
            $this->session->set_userdata('masuk', true);

            // jika level == 0
            if ($data['level'] == '0') {
                // maka set session akses sebagai admin
                $this->session->set_userdata('akses', 'admin');
            } else {
                // jika tidak maka set session akses sebagai user
                $this->session->set_userdata('akses', 'user');
            }

            // set session data id user
            $this->session->set_userdata('ses_id', $data['id_user']);

            // set session data id user
            $this->session->set_userdata('ses_nip', $bio['nip']);

            // set session data nama user
            $this->session->set_userdata('ses_nama', $bio['nama']);

            // set session level
            $this->session->set_userdata('ses_level',
                //  jika level == 0
                ($data['level'] == 0)
                // maka set data level "Administrator" untuk ditampilkan
                 ? "Administrator"
                // jika tidak maka set data level "Pegawai" untuk ditampilkan
                 : "Pegawai");

            // redirect halaman ke beranda jika login sukses
            redirect('beranda');

        } else {
            // ... jika data tidak ditemukan maka set pesan login
            echo $this->session->set_flashdata('msg', 'Username Atau Password Salah');
            // kembali ke halaman login
            redirect(base_url());
        }
    }

    // fungsi untuk logout user
    public function logout()
    {
        // hapus data session user
        $this->session->sess_destroy();
        // kembali ke halaman login
        redirect(base_url());
    }

}
