<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_User');
		$this->load->model('Model_Produk');
		// $this->load->model('BidModel');
		// $this->load->model('ProdukModel');
		// $this->load->model('BundlingModel');
		// $this->load->model('UserModel');
		// $this->load->library('image_lib');
		// $this->load->library('pdf');
	}

	public function index()
	{
		// cek_not_login();

		$ci  = &get_instance();
		$data['countKategori'] = $this->Model_Produk->countProduk()->num_rows();

		$data['produk'] = $this->Model_Produk->countProduk()->num_rows();
		
		$data['user'] = $this->Model_User->getAll()->result();

		$user_session = $ci->session->userdata('user_id');
		if ($user_session) {
		// var_dump(count($data['user']));
		// die;
		$this->template->load('template', 'Menu/dashboard',$data);
			// redirect('Dashboard');
		}
		else{
			redirect('Auth/login');

		}
	}

}
