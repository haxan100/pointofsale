<?php

Class Fungsi{
	protected $ci;
	public function __construct ()
	{
		$this->ci =& get_instance();
	}
	public function user_login()
	{	
		
		$this->ci->load->model('Model_User');
		$user_id =$this->ci->session->userdata('user_id');
		$user_data= $this->ci->Model_User->get($user_id);
		return $user_data->row() ;
		// var_dump($user_data);die;
		
		
		# code...
	}

}
