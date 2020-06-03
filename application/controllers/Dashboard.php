<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		// cek_not_login();

		$ci  = &get_instance();
		$user_session = $ci->session->userdata('user_id');
		if ($user_session) {
		// var_dump($user_session);
		// die;
		$this->template->load('template', 'Menu/dashboard');
			// redirect('Dashboard');
		}
		else{
			redirect('Auth/login');

		}
	}

}
