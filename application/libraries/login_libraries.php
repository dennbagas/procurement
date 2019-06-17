<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Login_Libraries {
	// SET SUPER GLOBAL
	var $CI = NULL;

	/**
	* Class constructor
	*
	* @return void
	*/
	public function __construct() {
		$this->CI =& get_instance();
	}

	/*
	* Cek username dan password pada table login, jika ada set session berdasar data user dari
	* table login.
	* @param string username dari input form
	* @param string password dari input form
	*/
	public function login($username, $password) {

		//cek username dan password
		$query = $this->CI->db->get_where('users', array('username'=>$username,'password' => md5($password)));

		if($query->num_rows() == 1) {
			//ambil data user berdasar username
			$row = $this->CI->db->query('SELECT id FROM users where username = "'.$username.'"');
			$admin = $row->row();
			$id = $admin->id;

			//set session user
			$this->CI->session->set_userdata('username', $username);
			$this->CI->session->set_userdata('id_login', uniqid(rand()));
			$this->CI->session->set_userdata('id', $id);

			//redirect ke halaman pst
			redirect(site_url('homecontroller'));
		}else{
			//jika tidak ada, set notifikasi dalam flashdata.
			$this->CI->session->set_flashdata('pesan','username atau password Anda salah, silahkan coba lagi');

			//redirect ke halaman login
			redirect(site_url('login'));
		}
		return false;
	}

	/**
	* Cek session login jika tidak ada, set notifikasi dalam flashdata, lalu dialihkan ke halaman
	* login
	*/
	public function cek_login() {

		//cek session username
		if($this->CI->session->userdata('username') == '') {

			//set notifikasi
			$this->CI->session->set_flashdata('pesan','Anda belum login');

			//alihkan ke halaman login
			redirect(site_url('login'));
		}
	}

	/** Hapus session, lalu set notifikasi kemudian dialihkan
	* ke halaman login
	*/
	public function logout() {
		$this->CI->session->unset_userdata('username');
		$this->CI->session->unset_userdata('id_login');
		$this->CI->session->unset_userdata('id');
		$this->CI->session->set_flashdata('pesan','Anda berhasil logout');
		redirect(site_url('login'));
	}
}