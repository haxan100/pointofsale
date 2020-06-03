<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function login()
	{
		cek_alerady_login();
		$this->load->view('Login');
	}
	public function process()

	{
		$username = $this->input->post('username', true);
		$password = $this->input->post('password', true);
		$this->load->model('Model_User');

		$query = $this->Model_User->login($username,$password);
		if($query->num_rows() >0 ){
			// echo "login berhasil";
			$r =$query->row();
			$session = array(
				// 'admin_session' => true, // Buat session authenticated dengan value true
				'user_id' => $r->user_id, // Buat session authenticated
				'username' => $r->username, // Buat session authenticated
				'level' => $r->level,
				'nama_lengkap' => $r->nama_lengkap,
				 // Buat session authenticated
			);

			$this->session->set_userdata($session);
			echo " <script>
				alert('selamat login berhasil');
				window.location='".site_url('dashboard')."';
						
							</script>";

		} else{
			// echo "login gagal";
			echo " <script>
				alert('login Gagal');
				window.location='" . site_url('Auth/login') . "';
						
							</script>";

		}

		
	}
	public function logout()
	{
		# code...
		$this->session->sess_destroy();
		echo " <script>
				alert('Anda Berhasil Logout');
				window.location='" . site_url('Auth/login') . "';
						
							</script>";
		// redirect('auth/login');
	}
	

}
