<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->model('M_account'); //call model	
	}

	public function index() {

		//Fungsi Login
		$valid = $this->form_validation;
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$valid->set_rules('username', 'Username','required');
		$valid->set_rules('password', 'Password','required');

		if($valid->run()) {
			$this->login_libraries->login($username, $password);
		}
			// jika database table users terisi minimal satu maka view nya login
		$this->load->view('autentifikasi/login_form');
	}

	public function logout() {
		$this->login_libraries->logout();
	}
}
