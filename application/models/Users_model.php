<?php
class Users_model extends CI_Model
{
    private static $__table_user = 'ms_user';

    // fungsi aktifasi
    public function activate()
    {
        $count = $this->db->get(self::$__table_user);
        if ($count->num_rows() == 0) {

            $nip = '000000';
            $nama = 'administrator';
            $password = '123456';

            $data_pegawai = array(
                'nip' => $nip,
                'nama' => $nama,
                'jenis_kelamin' => '0',
                'alamat' => $nama,
            );

            // insert ke tabel pegawai
            $query1 = $this->db->insert(self::$__table_pegawai, $data_pegawai);

            $data = array(
                'nip' => $nip,
                'nama_user' => $nama,
                'password' => MD5($password),
                'level' => '0',
            );

            // insert ke tabel user
            $query2 = $this->db->insert(self::$__table_user, $data);
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

    public function register_user($data)
    {
        $data_user = array(
            'nip' => $data['nip'],
            'nama_user' => $data['nama_user'],
            'password' => MD5($data['password']),
            'level' => '1',
        );
        // insert ke table user
        $query = $this->db->insert(self::$__table_user, $data_user);

        return !$query ? false : true;
    }

    private function __getQuery($search)
    {
        $this->db->select('*');
        $this->db->from(self::$__table_user);
        return $this->db->where("(nama_user LIKE '%$search%')");

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
        return $this->db->count_all_results(); // Untuk menghitung semua data users
    }

    public function count_filter($search)
    {
        $this->__getQuery($search);
        return $this->db->get()->num_rows(); // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
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

    public function delete_user($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('ms_user');

        return !$query ? false : true;
    }

    public function get_user_edit($id_user)
    {
        $query = $this->db->select('id_user, nama_user, nip')->from('ms_user')
            ->where('id_user', $id_user)
            ->get();

        return $query->result_array();
    }
}
