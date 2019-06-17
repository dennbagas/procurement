<?php
class Surat_model extends CI_model
{
    private $__table_surat = 'tr_surat';
    private $__table_pegawai = 'ms_pegawai';

    private function __getQuery($search)
    {
        return $this->db->select('*')
            ->from('tr_surat')
            ->join('ms_pegawai', 'ms_pegawai_id_pegawai = ms_pegawai.id_pegawai')
            ->where("(
                nomor_surat LIKE '%$search%'
                OR tanggal LIKE '%$search%'
                OR nama LIKE '%$search%'
                OR kegiatan LIKE '%$search%'
                OR pekerjaan LIKE '%$search%'
                OR tujuan LIKE '%$search%')
            ");
    }

    public function register($data)
    {
        $query_data = array(
            'nomor_surat' => $data['nomor_surat'],
            'tanggal' => $data['tanggal'],
            'kegiatan' => $data['kegiatan'],
            'pekerjaan' => $data['pekerjaan'],
            'tujuan' => $data['tujuan'],
            'ms_pegawai_id_pegawai' => $data['pemesan'],
            'jenis' => $data['jenis'],
        );

        $query = $this->db->insert($this->__table_surat, $query_data);

        if (!$query) {
            return false;
        } else {
            return true;
        }
    }

    public function get_surat_edit($id)
    {
        $query = $this->__getQuery('')->where('id_surat', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_surat($data)
    {
        $query_data = array(
            'nomor_surat' => $data['nomor_surat'],
            'tanggal' => $data['tanggal'],
            'kegiatan' => $data['kegiatan'],
            'pekerjaan' => $data['pekerjaan'],
            'tujuan' => $data['tujuan'],
            'ms_pegawai_id_pegawai' => $data['pemesan'],
            'jenis' => $data['jenis'],
        );

        $this->db->where('id_surat', $data['id']);
        $query = $this->db->update($this->__table_surat, $query_data);

        if (!$query) {
            return false;
        } else {
            return true;
        }
    }

    public function filter($jenis_surat, $search, $limit, $start, $order_field, $order_ascdesc)
    {
        $this->__getQuery($search)
            ->where('jenis', $jenis_surat)
            ->order_by($order_field, $order_ascdesc) // Untuk menambahkan query ORDER BY
            ->limit($limit, $start); // Untuk menambahkan query LIMIT

        $query = $this->db->get();
        return $query->result_array(); // Eksekusi query sql sesuai kondisi diatas
    }

    public function count_all($jenis_surat)
    {
        $this->db->where('jenis', $jenis_surat);
        return $this->db->count_all_results($this->__table_surat); // Untuk menghitung semua data users
    }

    public function count_filter($jenis_surat, $search)
    {
        $this->__getQuery($search)->where('jenis', $jenis_surat);
        return $this->db->get()->num_rows(); // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    public function delete_surat($id)
    {
        $this->db->where('id_surat', $id);
        $query = $this->db->delete('tr_surat');
        if (!$query) {
            return false;
        }

        return true;
    }

    public function get_last_record($jenis_surat)
    {
        $this->db->select('*')
            ->from('tr_surat')
            ->join('ms_pegawai', 'ms_pegawai_id_pegawai = ms_pegawai.id_pegawai')
            ->where('jenis', $jenis_surat)
            ->order_by('id_surat', 'DESC')
            ->limit(1);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['nomor_surat'] ?? 0;
    }
}