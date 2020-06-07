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
	public function satuan()
	{
		cek_not_login();
		$data_user['countSatuan'] = $this->Model_Produk->countSatuan()->num_rows();
		// var_dump($data_user);die;

		$this->template->load('template', 'produk/satuan', $data_user);
	}
	public function getAllSatuan()
	{
		$dt = $this->Model_Produk->dt_satuan($_POST);
		$datatable['draw']            = isset($_POST['draw']) ? $_POST['draw'] : 1;
		$datatable['recordsTotal']    = $dt['totalData'];
		$datatable['recordsFiltered'] = $dt['totalData'];
		$datatable['data']            = array();

		$start  = isset($_POST['start']) ? $_POST['start'] : 0;
		$no = $start + 1;
		foreach ($dt['data']->result() as $row) {

			$fields = array($no++);
			// var_dump($row);die;
			$fields[] = $row->nama_satuan;
			$fields[] = '
        <button class="btn btn-warning my-1 btnEditAdmin  text-white" 
					data-id_satuan="' . $row->id_satuan . '"
					data-nama_satuan="' . $row->nama_satuan . '"
					
        ><i class="far fa-edit"></i> Ubah</button>
        <button class="btn btn-danger my-1 btnHapus text-white" 
					data-id_satuan="' . $row->id_satuan . '" 
					data-nama_satuan="' . $row->nama_satuan . '"
        ><i class="fas fa-trash"></i> Hapus</button>
        ';

			$datatable['data'][] = $fields;
		}
		echo json_encode($datatable);
		exit();
	}
	public function tambah_satuan()
	{

		$nama_satuan = $this->input->post('nama_satuan', TRUE);
		

		$message = 'Gagal menambahkan Satuan  Baru!<br>Silahkan lengkapi data yang diperlukan.';
		$errorInputs = array();
		$status = true;

		$in = array(
			'nama_satuan' => $nama_satuan,
		);
		$cek = $this->Model_Produk->cari_satuan($nama_satuan);

		if ($cek >= 1) {
			$status = false;
			$errorInputs[] = array('#satuan', 'Satuan Sudah Ada!');
			$message = 'Sauan Sudah Ada! ';
		}
		if (empty($nama_satuan)) {
			$status = false;
			$errorInputs[] = array('#nama_satuan', 'Silahkan pilih nama satuan');
		}

		// var_dump($in);die();
		if ($status) {
			$this->Model_Produk->tambah_satuan($in);

			$message = 'Berhasil Menambahkan Satuan ';
		} else {
			$message = 'satuan Sudah Ada! ';
		}

		echo json_encode(array(
			'status' => $status,
			'message' => $message,
			'errorInputs' => $errorInputs
		));
	}
	public function hapusSatuan()
	{
		$id_satuan = $this->input->post('id_satuan', true);
		$data = $this->Model_Produk->getSatuanById($id_satuan);
		// var_dump($data);die();
		$status = false;
		$message = 'Gagal menghapus Satuan!';
		if (count($data) == 0) {
			$message .= '<br>Tidak terdapat Satuan yang dimaksud.';
		} else {
			$hasil = $this->Model_Produk->hapusSatuan($id_satuan);
			if ($hasil) {
				$status = true;
				$message = 'Berhasil menghapus Satuan: <b>' . $data[0]->nama_satuan . '</b>';
			} else {
				$message .= 'Terjadi kesalahan. #ADM10A';
			}
		}
		echo json_encode(array(
			'status' => $status,
			'message' => $message,
		));
	}
	public function edit_satuan()
	{

		$nama_satuan = $this->input->post('nama_satuan', TRUE);
		$id_satuan = $this->input->post(
			'id_satuan',
			TRUE
		);
		// var_dump($nama_satuan,$id_satuan);die;


		$message = 'Gagal menambahkan edit kategori ';
		$errorInputs = array();
		$status = true;

		$in = array(
				'nama_satuan' => $nama_satuan,
			);
		// var_dump($in);die;

		$cek = $this->Model_Produk->cari_satuan_edit($nama_satuan, $id_satuan);
		// var_dump($cek);die;

		if ($cek >= 1) {
			$status = false;
			$errorInputs[] = array('#nama_satuan', 'nama_satuan Sudah Ada!');
			$message = 'Satuan Sudah Ada! ';
		}
		if (empty($nama_satuan)) {
			$status = false;
			$errorInputs[] = array('#satuan', 'Silahkan pilih satuan');
		}
		if (empty($nama_satuan)) {
			$status = false;
			$errorInputs[] = array('#satuan', 'Silahkan Masukan satuan');
		}

		// var_dump($in);die();
		if ($status) {
			$this->Model_Produk->edit_satuan($in, $id_satuan);

			$message = 'Berhasil mengedit satuan  ';
		} else {
			$message = 'satuan Sudah Ada! ';
		}

		echo json_encode(array(
			'status' => $status,
			'message' => $message,
			'errorInputs' => $errorInputs
		));
	}
	public function index()
	{
		$data_user['kategori'] = $this->Model_Produk->get_category()->result();

		$data_user['suplier'] = $this->Model_User->get_suplier()->result();

		// var_dump($data_user['kategori']);die;
		cek_not_login();
		$data_user['countKategori'] = $this->Model_Produk->countProduk()->num_rows();

		$this->template->load('template', 'produk/produk', $data_user);
	}
		public function getAllProduk()
	{
		$dt = $this->Model_Produk->dt_produk($_POST);
		$datatable['draw']            = isset($_POST['draw']) ? $_POST['draw'] : 1;
		$datatable['recordsTotal']    = $dt['totalData'];
		$datatable['recordsFiltered'] = $dt['totalData'];
		$datatable['data']            = array();

		$start  = isset($_POST['start']) ? $_POST['start'] : 0;
		$no = $start + 1;
		foreach ($dt['data']->result() as $row) {
			
			$fields = array($no++);
			// var_dump($row);die;
			$fields[] = $row->kode_produk;
			$fields[] = $row->nama_produk;
			$fields[] = $row->harga_produk;
			$fields[] = $row->kategori;
			$fields[] = $row->status;
			$fields[] = $row->stok;

			$fields[] = '
        <button class="btn btn-warning my-1 btnEditAdmin  text-white" 
			data-kode_produk="' . $row->kode_produk . '"
			data-nama_produk="' . $row->nama_produk . '"
			data-harga="' . $row->harga_produk . '"
			data-kategori="' . $row->kategori . '"
			data-status="' . $row->status . '"
			data-stok="' . $row->stok . '"
					
        ><i class="far fa-edit"></i> Ubah</button>
        <button class="btn btn-danger my-1 btnHapus text-white" 
			data-kode_produk="' . $row->kode_produk . '"
			data-nama_produk="' . $row->nama_produk . '"
        ><i class="fas fa-trash"></i> Hapus</button>
        ';

			$datatable['data'][] = $fields;
		}
		echo json_encode($datatable);
		exit();
	}
	public function tambah_produk()
	{

		$nama_produk = $this->input->post('nama_produk', TRUE);
		$harga_produk = $this->input->post('harga_produk', TRUE);

		$kategori = $this->input->post('kategori', TRUE);
		$suplier = $this->input->post('suplier', TRUE);
		$stok = $this->input->post('stok', TRUE);
		$status = $this->input->post('status', TRUE);
		// var_dump($alamat);die;

		$message = 'Gagal menambahkan Produk Baru!<br>Silahkan lengkapi data yang diperlukan.';
		$errorInputs = array();
		$status = true;

		$in = array(
			'nama_produk' => $nama_produk,
			'harga_produk' => $harga_produk,
			'status' => $status,

			'kategori' => $kategori,
			'suplier' => $suplier,
			'stok' => $stok,
			'created' => date("Y-m-d"),
		);
		// var_dump($in);die;

		$cek = $this->Model_Produk->cari_cek_produk($nama_produk, $kategori);
		// var_dump($cek);die;

		if ($cek >= 1) {
			$status = false;
			$errorInputs[] = array('#slug', 'Kategori Sudah Ada!');
			$message = 'Produk Sudah Ada! ';
		}
		if (empty($nama_produk)) {
			$status = false;
			$errorInputs[] = array('#nama_kategori', 'Silahkan pilih nama produk');
		}
		if (empty($kategori)) {
			$status = false;
			$errorInputs[] = array('#slug', 'Silahkan Masukan Slug ');
		}

		// var_dump($in);die();
		if ($status) {
			$this->Model_Produk->tambah_produk($nama_produk,$harga_produk,$kategori,$suplier,$stok,$status);

			$message = 'Berhasil Menambahkan Produk ';
		} else {
			$message = 'Kategori Sudah Ada! ';
		}

		echo json_encode(array(
			'status' => $status,
			'message' => $message,
			'errorInputs' => $errorInputs
		));
	}

	}

