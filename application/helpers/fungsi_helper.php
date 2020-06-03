<?php


 function cek_alerady_login()
{
	$ci  =& get_instance();
	$user_session = $ci->session->userdata('user_id');
	// var_dump($user_session);die;
	if($user_session){
		
		redirect('Dashboard');
		
	}
	
}

function cek_not_login()
{
	$ci  = &get_instance();
	$user_session =
		$ci->session->userdata('user_id');
	if (!$user_session) {

		redirect('auth/login', 'refresh');
	}
}
