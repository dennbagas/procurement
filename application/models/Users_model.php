<?php
class Users_model extends CI_Model
{
    private static $__table_user = 'ms_user';
    private static $__table_pegawai = 'ms_pegawai';

    // fungsi aktifasi
    public function activate()
    {
        $count = $this->db->get(self::$__table_user);
        if ($count->num_rows() == 0) {

            $nip = '000000';
            $nama = 'administrator';
            $password = '123456';

            $data = array(
                'nip' => $nip,
                'nama_user' => $nama,
                'level' => '0',
                'password' => MD5($password),
            );

            $data_pegawai = array(
                'nip' => $nip,
                'nama' => $nama,
                'jenis_kelamin' => '0',
                'alamat' => $nama,
            );

            // insert ke tabel pegawai
            $query2 = $this->db->insert(self::$__table_pegawai, $data_pegawai);

            // insert ke tabel user
            $query1 = $this->db->insert(self::$__table_user, $data);
        }
    }

    public function login($nama_user, $password)
    {
        $query = $this->db->select('*')
            ->from(self::$__table_user)
            ->where('nama_user', $nama_user)
            ->where('password', MD5($password))
            ->limit(1)->get();

        return $query;
    }

    public function bio($nip)
    {
        $query = $this->db->select('*')
            ->from(self::$__table_pegawai)
            ->where('nip', $nip)
            ->limit(1)->get();

        return $query;
    }

    public function register($nip, $nama, $jenis_kelamin, $alamat, $nama_user, $password)
    {
        $data_pegawai = array(
            'nip' => $nip,
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' => $alamat,
        );

        // insert ke tabel pegawai
        $query = $this->db->insert(self::$__table_pegawai, $data_pegawai);

        // panggil fungsi insert_user
        $attach = $this->insert_user($nip, $nama_user, $password);

        return !$query || !$attach ? false : true;
    }

    public function insert_user($nip, $nama_user, $password)
    {
        $data_user = array(
            'nip' => $nip,
            'nama_user' => $nama_user,
            'level' => '1',
            'password' => password_hash($password, PASSWORD_BCRYPT),
        );

        // insert ke table user
        $query = $this->db->insert(self::$__table_user, $data_user);

        return !$query ? false : true;
    }

    private function __getQuery($search)
    {
        return $this->db->select('*')
            ->from('ms_user')
            ->join('ms_pegawai', 'ms_pegawai.nip = ms_user.nip')
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
        return $this->db->count_all_results(self::$__table_user); // Untuk menghitung semua data users
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

        return !$query ? false : true;
    }

    // fungsi untuk mengambil data pegawai
    public function get_pegawai()
    {
        $this->db->select('nip, nama');
        $this->db->from(self::$__table_pegawai);
        $this->db->order_by('nama', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }
}
