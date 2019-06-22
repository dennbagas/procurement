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
                'nama_user' => $nama,
                'password' => MD5($password),
                'level' => '0',
            );

            // insert ke tabel user
            $query1 = $this->db->insert(self::$__table_user, $data);
            $last_user_id = $this->db->insert_id();

            $data_pegawai = array(
                'id_user' => $last_user_id,
                'nip' => $nip,
                'nama' => $nama,
                'jenis_kelamin' => '0',
                'alamat' => $nama,
            );

            // insert ke tabel pegawai
            $query2 = $this->db->insert(self::$__table_pegawai, $data_pegawai);
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

    public function bio($id_user)
    {
        $query = $this->db->select('*')
            ->from(self::$__table_pegawai)
            ->where('id_user', $id_user)
            ->limit(1)->get();

        return $query;
    }

    public function register($nip, $username, $password, $nama, $jenis_kelamin, $alamat)
    {
        $data_user = array(
            'nama_user' => $username,
            'password' => MD5($password),
            'level' => '1',
        );
        $query = $this->db->insert(self::$__table_user, $data_user);

        $last_user_id = $this->db->insert_id();
        $attach = $this->insert_pegawai($last_user_id, $nip, $nama, $jenis_kelamin, $alamat);

        return !$query || !$attach ? false : true;
    }

    public function insert_pegawai($id, $nip, $nama, $jenis_kelamin, $alamat)
    {
        $data_pegawai = array(
            'id_user' => $id,
            'nip' => $nip,
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' => $alamat,
        );

        // insert ke table user
        $query = $this->db->insert(self::$__table_pegawai, $data_pegawai);

        return !$query ? false : true;
    }

    private function __getQuery($search, $table)
    {
        $this->db->select('*');
        $this->db->from($table);
        if ($table == self::$__table_user) {
            return $this->db->where("(nama_user LIKE '%$search%')");
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

    public function delete_pegawai($id)
    {
        $this->db->where('nip', $id);
        $this->db->delete('ms_pegawai');

        return !$query ? false : true;
    }
    
    public function delete_user($id)
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
