<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
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
		$this->load->model('Model_Produk');
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
	public function kategori()
	{
		cek_not_login();
		$this->load->model('Model_User');
		$data_user['data_user_all'] = $this->Model_User->getAll()->result();
		$data_user['countKategori'] = $this->Model_Produk->countKategori()->num_rows();
		// var_dump($data_user);die;

		$this->template->load('template', 'produk/kategori',$data_user);
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
	public function hapusKategori()
	{
		$id_kategori = $this->input->post('id_kategori', true);
		$data = $this->Model_Produk->getKategoriById($id_kategori);
		// var_dump($data);die();
		$status = false;
		$message = 'Gagal menghapus Kategori!';
		if (count($data) == 0) {
			$message .= '<br>Tidak terdapat Kategori yang dimaksud.';
		} else {
			$hasil = $this->Model_Produk->hapusKategori($id_kategori);
			if ($hasil) {
				$status = true;
				$message = 'Berhasil menghapus Kategori: <b>' . $data[0]->nama_kategori . '</b>';
			} else {
				$message .= 'Terjadi kesalahan. #ADM09A';
			}
		}
		echo json_encode(array(
			'status' => $status,
			'message' => $message,
		));
	}
	public function getAllKategori()
	{
		$dt = $this->Model_Produk->dt_kategori($_POST);
		$datatable['draw']            = isset($_POST['draw']) ? $_POST['draw'] : 1;
		$datatable['recordsTotal']    = $dt['totalData'];
		$datatable['recordsFiltered'] = $dt['totalData'];
		$datatable['data']            = array();

		$start  = isset($_POST['start']) ? $_POST['start'] : 0;
		$no = $start + 1;
		foreach ($dt['data']->result() as $row) {
			
			$fields = array($no++);
			// var_dump($row);die;
			$fields[] = $row->slug_kategori;
			$fields[] = $row->nama_kategori;
			$fields[] = '
        <button class="btn btn-warning my-1 btnEditAdmin  text-white" 
					data-id_kategori="' . $row->id_kategori . '"
					data-slug_kategori="' . $row->slug_kategori . '"
					data-nama_kategori="' . $row->nama_kategori . '"
					
        ><i class="far fa-edit"></i> Ubah</button>
        <button class="btn btn-danger my-1 btnHapus text-white" 
					data-id_kategori="' . $row->id_kategori . '" 
					data-nama_kategori="' . $row->nama_kategori . '"
        ><i class="fas fa-trash"></i> Hapus</button>
        ';

			$datatable['data'][] = $fields;
		}
		echo json_encode($datatable);
		exit();
	}
	public function tambah_kategori()
	{

		$nama_kategori = $this->input->post('nama_kategori', TRUE);
		$slug = $this->input->post('slug', TRUE);
		// var_dump($alamat);die;

		$message = 'Gagal menambahkan Kategori Baru!<br>Silahkan lengkapi data yang diperlukan.';
		$errorInputs = array();
		$status = true;

		$in = array(
			'nama_kategori' => $nama_kategori,
			'slug_kategori' => $slug,
			'created' => date("Y-m-d"),
		);
		// var_dump($in);die;

		$cek = $this->Model_Produk->cari_kategori($nama_kategori , $slug);
		// var_dump($cek);die;

		if ($cek >= 1) {
			$status = false;
			$errorInputs[] = array('#slug', 'Kategori Sudah Ada!');
			$message = 'Username Sudah Ada! ';
		}
		if (empty($nama_kategori)) {
			$status = false;
			$errorInputs[] = array('#nama_kategori', 'Silahkan pilih nama kategori');
		}
		if (empty($slug)) {
			$status = false;
			$errorInputs[] = array('#slug', 'Silahkan Masukan Slug ');
		}

		// var_dump($in);die();
		if ($status) {
			$this->Model_Produk->tambah_kategori($in);

			$message = 'Berhasil Menambahkan Kategori ';
		} else {
			$message = 'Kategori Sudah Ada! ';
		}

		echo json_encode(array(
			'status' => $status,
			'message' => $message,
			'errorInputs' => $errorInputs
		));
	}
	public function edit_kategori()
	{

		$slug = $this->input->post('slug', TRUE);
		$nama_kategori = $this->input->post('nama_kategori', TRUE);
		$id_kategori = $this->input->post('id_kategori',
			TRUE
		);
		// var_dump($alamat);die;


		$message = 'Gagal menambahkan edit kategori ';
		$errorInputs = array();
		$status = true;

		$in = array(
			'nama_kategori' => $nama_kategori,
			'slug_kategori' => $slug,
		);
		// var_dump($in);die;

		$cek = $this->Model_Produk->cari_kategori_edit($nama_kategori,$id_kategori);
		// var_dump($cek);die;

		if ($cek >= 1) {
			$status = false;
			$errorInputs[] = array('#username', 'Username Sudah Ada!');
			$message = 'Kategori Sudah Ada! ';
		}
		if (empty($nama_kategori)) {
			$status = false;
			$errorInputs[] = array('#username', 'Silahkan pilih username');
		}
		if (empty($slug)) {
			$status = false;
			$errorInputs[] = array('#password', 'Silahkan Masukan Password');
		}

		// var_dump($in);die();
		if ($status) {
			$this->Model_Produk->edit_kategori($in,$id_kategori);

			$message = 'Berhasil mengedit kategori  ';
		} else {
			$message = 'Username Sudah Ada! ';
		}

		echo json_encode(array(
			'status' => $status,
			'message' => $message,
			'errorInputs' => $errorInputs
		));
	}

	}

