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

    public function register($nip, $username, $password, $nama, $jenis_kelamin, $alamat)
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
        $attach = $this->insert_user($nip, $username, $password);

        return !$query || !$attach ? false : true;
    }

    public function insert_user($nip, $username, $password)
    {
        $data_user = array(
            'nip' => $nip,
            'nama_user' => $username,
            'level' => '1',
            'password' => MD5($password),
        );

        // insert ke table user
        $query = $this->db->insert(self::$__table_user, $data_user);

        return !$query ? false : true;
    }

    private function __getQuery($search, $table)
    {
        $this->db->select('*');
        $this->db->from($table);
        if ($table == self::$__table_user) {
            return $this->db->where("(nip LIKE '%$search%' OR nama_user LIKE '%$search%')");
        } elseif ($table == self::$__table_pegawai) {
            return $this->db->where("(nip LIKE '%$search%' OR nama LIKE '%$search%')");
        }
    }

    public function filter($search, $limit, $start, $order_field, $order_ascdesc, $table)
    {
        $this->__getQuery($search, $table)
            ->order_by($order_field, $order_ascdesc) // Untuk menambahkan query ORDER BY
            ->limit($limit, $start); // Untuk menambahkan query LIMIT

        $query = $this->db->get();
        return $query->result_array(); // Eksekusi query sql sesuai kondisi diatas
    }

    public function count_all($table)
    {
        // $this->db->where('ms_user.id_user', 261);
        return $this->db->count_all_results($table); // Untuk menghitung semua data users
    }

    public function count_filter($search, $table)
    {
        $this->__getQuery($search, $table);
        return $this->db->get()->num_rows(); // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    public function get_pegawai_edit($nip)
    {
        $query = $this->db->select('*')->from('ms_pegawai')
            ->where('nip', $nip)
            ->get();

        return $query->result_array();
    }

    public function pegawai_update($data)
    {
        // insert ke tabel pegawai
        $this->db->where('nip', $data['nip']);
        $query = $this->db->update(self::$__table_pegawai, $data);

        return !$query ? false : true;
    }

    public function get_user_edit($id_user)
    {
        $query = $this->db->select('id_user, nama_user')->from('ms_user')
            ->where('id_user', $id_user)
            ->get();

        return $query->result_array();
    }

    public function user_update($data)
    {
        $data_user = array(
            'nama_user' => $data['nama_user'],
            'password' => MD5($data['password']),
        );

        $this->db->where('id_user', $data['id_user']);
        // insert ke table user
        $query = $this->db->update(self::$__table_user, $data_user);

        return !$query ? false : true;
    }

    public function delete_data($id)
    {
        $this->db->where('nip', $id);
        $this->db->delete('ms_pegawai');

        return !$query ? false : true;
    }

    // fungsi untuk mengambil data pegawai
    public function get_pegawai()
    {
        $this->db->select('id_user, nama');
        $this->db->from(self::$__table_pegawai);
        $this->db->join('ms_user', 'ms_user.nip = ms_pegawai.nip');
        $this->db->order_by('nama', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }
}
