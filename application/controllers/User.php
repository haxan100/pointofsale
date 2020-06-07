<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	// protected $ci;
	// public function __construct()
	// {
	// 	$this->ci = &get_instance();
	// }
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_User');
		// $this->load->model('AuthModel');
		// $this->load->model('BidModel');
		// $this->load->model('ProdukModel');
		// $this->load->model('BundlingModel');
		// $this->load->model('UserModel');
		// $this->load->library('image_lib');
		// $this->load->library('pdf');
	}
	public function bizEncrypt($plaintext)
	{
		$tahun = date('Y');
		$bulan = date('m');
		$hari = date('d');
		$jam = date('H');
		$menit = date('i');
		$detik = date('s');
		$pool = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_+&';

		$word1 = '';
		for ($i = 0; $i < 4; $i++) {
			$word1 .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
		}

		$plain = $hari . $bulan . $tahun . $word1 . base64_encode(base64_encode($plaintext)) . $detik . $menit . $jam;
		$enc = base64_encode($plain);
		return $enc;
	}

	public function bizDecrypt($enc)
	{
		$dec64 = base64_decode($enc);
		$substr1 = substr($dec64, 12, strlen($dec64) - 12);
		$substr2 = substr($substr1, 0, strlen($substr1) - 6);
		$dec = base64_decode(base64_decode($substr2));
		return $dec;
	}
	public function passwordMatch($plain_password, $encrypted)
	{
		return $plain_password == $this->bizDecrypt($encrypted);
	}
	public function index()
	{
		cek_not_login();
		$this->load->model('Model_User');
		$data_user['data_user_all'] = $this->Model_User->getAll()->result();
		$data_user['count'] = $this->Model_User->count()->num_rows();
		// var_dump($data_user);die;

		$this->template->load('template', 'user/user_data',$data_user);
	}
	public function tambah_user()
	{

		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
		$email = $this->input->post('email', TRUE);
		$nama_lengkap = $this->input->post('nama_lengkap', TRUE);
		$level = $this->input->post('level', TRUE);
		$alamat = $this->input->post('alamat', TRUE);
		// var_dump($alamat);die;


		$message = 'Gagal menambahkan Admin Baru!<br>Silahkan lengkapi data yang diperlukan.';
		$errorInputs = array();
		$status = true;

		$in = array(
			'nama_lengkap' => $nama_lengkap,
			'username' => $username,
			'password' =>   $this->bizEncrypt($password),
			'email' => $email,
			'level' => $level,
			'alamat' => $alamat,
		);	
		// var_dump($in);die;

		$cek = $this->Model_User->cari_username($username);
		// var_dump($cek);die;

		if ($cek >= 1) {
			$status = false;
			$errorInputs[] = array('#username', 'Username Sudah Ada!');
			$message = 'Username Sudah Ada! ';
		}
		if (empty($username)) {
			$status = false;
			$errorInputs[] = array('#username', 'Silahkan pilih username');
		}
		if (empty($password)) {
			$status = false;
			$errorInputs[] = array('#password', 'Silahkan Masukan Password');
		}
		$noRoleSelected = true;

		// var_dump($in);die();
		if ($status) {
			$this->Model_User->tambah_user($in);	
			
			$message = 'Berhasil  ';
				
		} else {
			$message = 'Username Sudah Ada! ';
		}

			echo json_encode(array(
				'status' => $status,
				'message' => $message,
				'errorInputs' => $errorInputs
			));
	}
	public function getAllUser()
	{
		// if (!$this->isLoggedInAdmin()) {
		// 	echo '403 Forbidden!';
		// 	exit();
		// }
		$dt = $this->Model_User->dt_user($_POST);
		$datatable['draw']            = isset($_POST['draw']) ? $_POST['draw'] : 1;
		$datatable['recordsTotal']    = $dt['totalData'];
		$datatable['recordsFiltered'] = $dt['totalData'];
		$datatable['data']            = array();

		$start  = isset($_POST['start']) ? $_POST['start'] : 0;
		$no = $start + 1;
		foreach ($dt['data']->result() as $row) {
			if( $row->level){
				$level = "admin";
			}else{
				$level ="kasir";
			}
			$fields = array($no++);
			// var_dump($row);die;
			$fields[] = $row->username;
			$fields[] = $row->nama_lengkap;
			$fields[] = $row->email;
			$fields[] = $row->alamat;
			$fields[] = $level;
			$fields[] = '
        <button class="btn btn-warning my-1 btnEditAdmin  text-white" 
					data-user_id="' . $row->user_id . '"
					data-username="' . $row->username . '"
					data-password="' . $this->bizDecrypt($row->password) . '"
					data-email="' . $row->email . '"
					data-nama_lengkap="' . $row->nama_lengkap . '"
					data-alamat="' . $row->alamat . '"
					data-level="' . $row->level . '"
					
        ><i class="far fa-edit"></i> Ubah</button>
        <button class="btn btn-danger my-1 btnHapus text-white" 
					data-user_id="' . $row->user_id . '" 
					data-username="' . $row->username . '"
        ><i class="fas fa-trash"></i> Hapus</button>
        ';

			$datatable['data'][] = $fields;
		}
		echo json_encode($datatable);
		exit();
	}
	public function hapusUser()
	{
		// if (!$this->isLoggedInAdmin()) {
		// 	echo '403 Forbidden!';
		// 	exit();
		// }
		$user_id = $this->input->post('user_id', true);
		$data = $this->Model_User->getUserById($user_id);
		// var_dump($data);die();
		$status = false;
		$message = 'Gagal menghapus User!';
		if (count($data) == 0) {
			$message .= '<br>Tidak terdapat admin yang dimaksud.';
		} else {
			$hasil = $this->Model_User->hapusUser($user_id);
			if ($hasil) {
				$status = true;
				$message = 'Berhasil menghapus User: <b>' . $data[0]->username . '</b>';
			} else {
				$message .= 'Terjadi kesalahan. #ADM09A';
			}
		}
		echo json_encode(array(
			'status' => $status,
			'message' => $message,
		));
	}
	public function suplier()
	{
		cek_not_login();
		$this->load->model('Model_User');
		$data_user['data_user_all'] = $this->Model_User->getAll()->result();

		$data_user['count'] = $this->Model_User->countSuplier()->num_rows();
		// var_dump($data_user);die;

		$this->template->load('template', 'supplier/supplier_data', $data_user);
	}
	public function getAllSuplier()
	{
		// if (!$this->isLoggedInAdmin()) {
		// 	echo '403 Forbidden!';
		// 	exit();
		// }
		$dt = $this->Model_User->dt_suplier($_POST);
		$datatable['draw']            = isset($_POST['draw']) ? $_POST['draw'] : 1;
		$datatable['recordsTotal']    = $dt['totalData'];
		$datatable['recordsFiltered'] = $dt['totalData'];
		$datatable['data']            = array();

		$start  = isset($_POST['start']) ? $_POST['start'] : 0;
		$no = $start + 1;
		foreach ($dt['data']->result() as $row) {

			if ($row->status_suplier) {
				$status = "aktiv";
			} else {
				$status = "tidak aktiv";
			}
			$fields = array($no++);
			// var_dump($row);die;
			$fields[] = $row->nama_suplier;
			$fields[] = $row->alamat_suplier;
			$fields[] = $row->no_telp_suplier;
			$fields[] = $status;
			$fields[] = '
        <button class="btn btn-warning my-1 btnEditAdmin  text-white" 
					data-suplier_id="' . $row->suplier_id . '"
					data-nama_suplier="' . $row->nama_suplier . '"
					data-no_telp_suplier="' . $row->no_telp_suplier . '"
					data-status_suplier="' . $row->status_suplier . '"
					data-alamat_suplier="' . $row->alamat_suplier . '"
					
        ><i class="far fa-edit"></i> Ubah</button>
        <button class="btn btn-danger my-1 btnHapus text-white" 
					data-suplier_id="' . $row->suplier_id . '"
					data-nama_suplier="' . $row->nama_suplier . '"
        ><i class="fas fa-trash"></i> Hapus</button>
        ';

			$datatable['data'][] = $fields;
		}
		echo json_encode($datatable);
		exit();
	}
	public function tambah_suplier()
	{

		$nama_suplier = $this->input->post('nama_suplier', TRUE);
		$status = $this->input->post('status',
			TRUE
		);
		$no_telp = $this->input->post('no_telp', TRUE);
		$alamat = $this->input->post('alamat', TRUE);
		// var_dump($alamat);die;


		$message = 'Gagal menambahkan Suplier Baru!<br>Silahkan lengkapi data yang diperlukan.';
		$errorInputs = array();
		$status = true;

		$in = array(
			'nama_suplier' => $nama_suplier,
			'status_suplier' => $status,
			'no_telp_suplier' => $no_telp,
			'alamat_suplier' => $alamat,
		);
		// var_dump($in);die;

		$cek = $this->Model_User->cari_suplier($nama_suplier, $no_telp);
		// var_dump($cek);die;

		if ($cek >= 1) {
			$status = false;
			$errorInputs[] = array('#suplier', 'suplier Sudah Ada!');
			$message = 'Suplier Sudah Ada! ';
		}
		if (empty($nama_suplier)) {
			$status = false;
			$errorInputs[] = array('#nama_suplier', 'Silahkan isi nama suplier');
		}
		if (empty($no_telp)) {
			$status = false;
			$errorInputs[] = array('#no_telp', 'Silahkan Masukan nomor telpon');
		}

		// var_dump($in);die();
		if ($status) {
			$this->Model_User->tambah_suplier($in);

			$message = 'Berhasil menambah suplier ';
		} else {
			$message = 'Username Sudah Ada! ';
		}

		echo json_encode(array(
			'status' => $status,
			'message' => $message,
			'errorInputs' => $errorInputs
		));
	}
	public function hapusSuplier()
	{
		// if (!$this->isLoggedInAdmin()) {
		// 	echo '403 Forbidden!';
		// 	exit();
		// }
		$suplier_id = $this->input->post('suplier_id', true);
		$data = $this->Model_User->getSuplierById($suplier_id);
		// var_dump($data);die();
		$status = false;
		$message = 'Gagal menghapus Suplier!';
		if (count($data) == 0) {
			$message .= '<br>Tidak terdapat Suplier yang dimaksud.';
		} else {
			$hasil = $this->Model_User->hapusSuplier($suplier_id);
			if ($hasil) {
				$status = true;
				$message = 'Berhasil menghapus Suplier: <b>' . $data[0]->nama_suplier . '</b>';
			} else {
				$message .= 'Terjadi kesalahan. #ADM09A';
			}
		}
		echo json_encode(array(
			'status' => $status,
			'message' => $message,
		));
	}
	public function edit_suplier()
	{

		$suplier_id = $this->input->post('suplier_id', TRUE);
		$nama_suplier = $this->input->post('nama_suplier', TRUE);
		$alamat = $this->input->post('alamat', TRUE);
		$status_suplier = $this->input->post('status', TRUE);
		$no_telpon = $this->input->post('no_telpon', TRUE);
		// var_dump($status_suplier);die;
		$message = 'Gagal menambahkan edit Suplier ';
		$errorInputs = array();
		$status = true;
		$now= date('Y-m-d H:i:s');
		// var_dump($now);die;


		$in = array(
				'nama_suplier' => $nama_suplier,
				'alamat_suplier' => $alamat,
				'status_suplier' => $status_suplier,
				'no_telp_suplier' => $no_telpon,
				'updated' => date('Y-m-d h:i:s'),

			);
		// var_dump($in);die;

		$cek = $this->Model_User->cari_suplier_edit($nama_suplier, $no_telpon, $suplier_id);
		// var_dump($cek);die;

		if ($cek >= 1) {
			$status = false;
			$errorInputs[] = array('#username', 'Username Sudah Ada!');
			$message = 'Suplier Sudah Ada! ';
		}
		if (empty($nama_suplier)) {
			$status = false;
			$errorInputs[] = array('#username', 'Silahkan pilih username');
		}
		if (empty($no_telpon)) {
			$status = false;
			$errorInputs[] = array('#password', 'Silahkan Masukan Password');
		}

		// var_dump($in);die();
		if ($status) {
			$this->Model_User->edit_suplier($in, $suplier_id);

			$message = 'Berhasil mengedit Suplier  ';
		} else {
			$message = 'Suplier Sudah Ada! ';
		}

		echo json_encode(array(
			'status' => $status,
			'message' => $message,
			'errorInputs' => $errorInputs
		));
	}

	}

