<?php

class Pegawai_Model extends CI_Model
{
    private static $__table_pegawai = 'ms_pegawai';

    public function bio($id_pegawai)
    {
        $query = $this->db->select('*')
            ->from(self::$__table_pegawai)
            ->where('id_pegawai', $id_pegawai)
            ->limit(1)->get();

        return $query;
    }

    private function __getQuery($search)
    {
        $this->db->select('*');
        $this->db->from(self::$__table_pegawai);
        return $this->db->where("(nip LIKE '%$search%' OR nama LIKE '%$search%')");

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

    public function register_pegawai($data)
    {
        $data_pegawai = array(
            'nip' => $data['nip'],
            'nama' => $data['nama'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'alamat' => $data['alamat'],
        );
        // insert ke table pegawai
        $query = $this->db->insert(self::$__table_pegawai, $data_pegawai);

        return !$query ? false : true;
    }

    public function get_pegawai_edit($id_pegawai)
    {
        $query = $this->db->select('*')->from('ms_pegawai')
            ->where('id_pegawai', $id_pegawai)
            ->get();

        return $query->result_array();
    }

    public function pegawai_update($data)
    {
        // insert ke tabel pegawai
        $this->db->where('id_pegawai', $data['id_pegawai']);
        $query = $this->db->update(self::$__table_pegawai, $data);

        return !$query ? false : true;
    }

    public function delete_pegawai($id)
    {
        $this->db->where('id_pegawai', $id);
        $this->db->delete('ms_pegawai');

        return !$query ? false : true;
    }

    // fungsi untuk mengambil data pegawai
    public function get_pegawai()
    {
        $this->db->select('id_pegawai, nama');
        $this->db->from(self::$__table_pegawai);
        $this->db->order_by('nama', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }
}
