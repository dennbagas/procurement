<?php
class Users_model extends CI_Model
{
    private $__table_user = 'ms_user';
    private $__table_pegawai = 'ms_pegawai';

    public function activate()
    {
        // date_default_timezone_set('ASIA/JAKARTA');
        $data = array(
            'nip' => '000000',
            'username' => 'Administrator',
            'level' => '0',
            // 'created_at' => date('2019-06-01 00:00:00'),
             'password' => MD5('123456'),
        );
        return $this->db->insert($this->__table_user, $data);
    }

    public function login($nip, $password)
    {
        $query = $this->db->query("SELECT * FROM $this->__table_user WHERE nip='$nip' AND password=MD5('$password') LIMIT 1");
        return $query;
    }

    public function bio($id_user)
    {
        $query = $this->db->query("SELECT * FROM $this->__table_pegawai WHERE ms_user_id_user='$id_user' LIMIT 1");
        return $query;
    }

    public function register($nip, $password, $nama, $jenis_kelamin, $alamat)
    {
        $data_user = array(
            'nip' => $nip,
            'level' => '1',
            'password' => MD5($password),
        );

        $query = $this->db->insert($this->__table_user, $data_user);
        if (!$query) {
            return false;
        }

        $last_user_id = $this->db->insert_id();

        $attach = $this->insert_pegawai($last_user_id, $nama, $jenis_kelamin, $alamat);
        if (!$attach) {
            return false;
        }

        return true;
    }

    public function insert_pegawai($id_user, $nama, $jenis_kelamin, $alamat)
    {
        $data_pegawai = array(
            'ms_user_id_user' => $id_user,
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' => $alamat,
        );

        $query = $this->db->insert($this->__table_pegawai, $data_pegawai);

        if (!$query) {
            return false;
        }

        return true;
    }

    private function __getQuery($search)
    {
        return $this->db->select('*')
            ->from('ms_user')
        // ->where('ms_user.id_user', 261)
            ->join('ms_pegawai', 'ms_pegawai.ms_user_id_user = ms_user.id_user')
            ->where("(id_user LIKE '%$search%' OR nama LIKE '%$search%')");
    }

    public function filter($search, $limit, $start, $order_field, $order_ascdesc)
    {
        $this->__getQuery($search)
            ->order_by($order_field, $order_ascdesc) // Untuk menambahkan query ORDER BY
            ->limit($limit, $start); // Untuk menambahkan query LIMIT

        $query = $this->db->get();
        return $query->result_array(); // Eksekusi query sql sesuai kondisi diatas
    }

    public function count_all()
    {
        // $this->db->where('ms_user.id_user', 261);
        return $this->db->count_all_results($this->__table_user); // Untuk menghitung semua data users
    }

    public function count_filter($search)
    {
        $this->__getQuery($search);
        return $this->db->get()->num_rows(); // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    public function delete_data($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('ms_user');
        if (!$query) {
            return false;
        }

        return true;
    }

    // fungsi untuk mengambil data pegawai
    public function get_pegawai()
    {
        $this->db->select('id_pegawai, nama');
        $this->db->from($this->__table_pegawai);
        $this->db->where('ms_user_id_user is NOT NULL', null, false);
        $this->db->order_by('nama', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }
}
