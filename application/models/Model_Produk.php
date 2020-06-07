<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Produk extends CI_Model
{

	public function login($username,$password)
	{
		$this->db->select('*');
		$this->db->from('user');
		
		$this->db->where('username', $username);		
		$this->db->where('password', md5($password));
		$query = $this->db->get();
		return($query);
		
		
	}

	public function get($id=null)
	{
		$this->db->select('*');
		$this->db->from('user');
		if($id != null){
			$this->db->where('user_id', $id);		


		}
		$query = $this->db->get();
		return ($query);


	}

	public function countKategori()
	{
		$query = $this->db->query('SELECT * FROM kategori');
		// echo $query->num_rows();
		$query->num_rows();
		return ($query);
	}

	public function getAll()
	{
		$this->db->select('*');
		$this->db->from('user');
		$query = $this->db->get();
		// var_dump($this->db->last_query());die();
				return $query;
	}
	public function cari_kategori($nama_kategori,$slug)
	{
		$this->db->where('slug_kategori', $slug);
		$this->db->where('nama_kategori', $nama_kategori);
		return $this->db->get('kategori')->num_rows();
		// var_dump($lastquery);die;
	}
	public function tambah_kategori($in)
	{

		if ($this->db->insert('kategori', $in)) {
			$status =  true;
		} else {
			var_dump($this->db->error());
			die();
			$status = false;
		}
		return $status;
	}

	public function getUserById($id_admin)
	{
		$this->db->where('user_id', $id_admin);
		return $this->db->get('user')->result();
	}
	public function hapusUser($id_admin)
	{
		$this->db->where('user_id', $id_admin);
		return $this->db->delete('user');
	}

	public function dt_kategori($post)
	{
		$from = 'kategori k';
		// untuk sort
		$columns = array(
			'slug_kategori',
			'nama_kategori',
		);

		// untuk search
		$columnsSearch = array(
			'slug_kategori',
			'nama_kategori',
		);

		// custom SQL
		$sql = "SELECT * FROM {$from} ";

		$where = "";

		$whereTemp = "";
		if (isset($post['date']) && $post['date'] != '') {
			$date = explode(' / ', $post['date']);
			if (count($date) == 1) {
				$whereTemp .= "(created_at LIKE '%" . $post['date'] . "%')";
			} else {
				// $whereTemp .= "(created_at BETWEEN '".$date[0]."' AND '".$date[1]."')";
				$whereTemp .= "(date_format(created_at, \"%Y-%m-%d\") >='$date[0]' AND date_format(created_at, \"%Y-%m-%d\") <= '$date[1]')";
			}
		}
		if ($whereTemp != '' && $where != '') $where .= " AND (" . $whereTemp . ")";
		else if ($whereTemp != '') $where .= $whereTemp;

		// search
		if (isset($post['search']['value']) && $post['search']['value'] != '') {
			$search = $post['search']['value'];
			// create parameter pencarian kesemua kolom yang tertulis
			// di $columns
			$whereTemp = "";
			for ($i = 0; $i < count($columnsSearch); $i++) {
				$whereTemp .= $columnsSearch[$i] . ' LIKE "%' . $search . '%"';

				// agar tidak menambahkan 'OR' diakhir Looping
				if ($i < count($columnsSearch) - 1) {
					$whereTemp .= ' OR ';
				}
			}
			if ($where != '') $where .= " AND (" . $whereTemp . ")";
			else $where .= $whereTemp;
		}
		if ($where != '') $sql .= ' WHERE (' . $where . ')';


		//SORT Kolom
		$sortColumn = isset($post['order'][0]['column']) ? $post['order'][0]['column'] : 1;
		$sortDir    = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : 'asc';

		$sortColumn = $columns[$sortColumn - 1];

		$sql .= " ORDER BY {$sortColumn} {$sortDir}";

		$count = $this->db->query($sql);
		// hitung semua data
		$totaldata = $count->num_rows();

		// memberi Limit
		$start  = isset($post['start']) ? $post['start'] : 0;
		$length = isset($post['length']) ? $post['length'] : 10;


		$sql .= " LIMIT {$start}, {$length}";


		$data  = $this->db->query($sql);

		return array(
			'totalData' => $totaldata,
			'data' => $data,
		);
	}

	public function	cari_kategori_edit($nama_kategori, $id_kategori)
	{
		$this->db->where('id_kategori !=', $id_kategori);
		$this->db->where('nama_kategori ', $nama_kategori);
		return $this->db->get('kategori')->num_rows();
		// var_dump($lastquery);die;
	}
	public function edit_kategori($in, $id_kategori)
	{
		$this->db->where('id_kategori', $id_kategori);

		return $this->db->update('kategori', $in);
	}
	public function getKategoriById($id_kategori)
	{
		$this->db->where('id_kategori', $id_kategori);
		return $this->db->get('kategori')->result();
	}
	public function hapusKategori($id_kategori)
	{
		$this->db->where('id_kategori', $id_kategori);
		return $this->db->delete('kategori');
	}
	public function countSatuan()
	{
		$query = $this->db->query('SELECT * FROM satuan');
		// echo $query->num_rows();
		$query->num_rows();
		return ($query);
	}
	public function dt_satuan($post)
	{
		$from = 'satuan k';
		// untuk sort
		$columns = array(
			
			'id_satuan',
			'nama_satuan',
		);

		// untuk search
		$columnsSearch = array(
			'id_satuan',
			
			'nama_satuan',
		);

		// custom SQL
		$sql = "SELECT * FROM {$from} ";

		$where = "";

		$whereTemp = "";
		if (isset($post['date']) && $post['date'] != '') {
			$date = explode(' / ', $post['date']);
			if (count($date) == 1) {
				$whereTemp .= "(created_at LIKE '%" . $post['date'] . "%')";
			} else {
				// $whereTemp .= "(created_at BETWEEN '".$date[0]."' AND '".$date[1]."')";
				$whereTemp .= "(date_format(created_at, \"%Y-%m-%d\") >='$date[0]' AND date_format(created_at, \"%Y-%m-%d\") <= '$date[1]')";
			}
		}
		if ($whereTemp != '' && $where != '') $where .= " AND (" . $whereTemp . ")";
		else if ($whereTemp != '') $where .= $whereTemp;

		// search
		if (isset($post['search']['value']) && $post['search']['value'] != '') {
			$search = $post['search']['value'];
			// create parameter pencarian kesemua kolom yang tertulis
			// di $columns
			$whereTemp = "";
			for ($i = 0; $i < count($columnsSearch); $i++) {
				$whereTemp .= $columnsSearch[$i] . ' LIKE "%' . $search . '%"';

				// agar tidak menambahkan 'OR' diakhir Looping
				if ($i < count($columnsSearch) - 1) {
					$whereTemp .= ' OR ';
				}
			}
			if ($where != '') $where .= " AND (" . $whereTemp . ")";
			else $where .= $whereTemp;
		}
		if ($where != '') $sql .= ' WHERE (' . $where . ')';


		//SORT Kolom
		$sortColumn = isset($post['order'][0]['column']) ? $post['order'][0]['column'] : 1;
		$sortDir    = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : 'asc';

		$sortColumn = $columns[$sortColumn - 1];

		$sql .= " ORDER BY {$sortColumn} {$sortDir}";

		// var_dump($sql);
		
		// var_dump($this->db->last_query());die();
		$count = $this->db->query($sql);
		// hitung semua data
		$totaldata = $count->num_rows();
		

		// memberi Limit
		$start  = isset($post['start']) ? $post['start'] : 0;
		$length = isset($post['length']) ? $post['length'] : 10;

		$sql .= " LIMIT {$start}, {$length}";


		$data  = $this->db->query($sql);

		return array(
			'totalData' => $totaldata,
			'data' => $data,
		);
	}
	public function cari_satuan($nama_satuan)
	{
		
		$this->db->where('nama_satuan', $nama_satuan);
		return $this->db->get('satuan')->num_rows();
		
	}
	public function tambah_satuan($in)
	{

		if ($this->db->insert('satuan', $in)) {
			$status =  true;
		} else {
			var_dump($this->db->error());
			die();
			$status = false;
		}
		return $status;
	}
	public function getSatuanById($id_satuan)
	{
		$this->db->where('id_satuan', $id_satuan);
		return $this->db->get('satuan')->result();
	}
	public function hapusSatuan($id_satuan)
	{
		$this->db->where('id_satuan', $id_satuan);
		return $this->db->delete('satuan');
	}
	public function
	cari_satuan_edit($nama_satuan, $id_satuan)
	{
		$this->db->where('id_satuan !=', $id_satuan);
		$this->db->where('nama_satuan ', $nama_satuan);
		return $this->db->get('satuan')->num_rows();
		// var_dump($lastquery);die;
	}
	public function edit_satuan($in, $id_satuan)
	{
		$this->db->where('id_satuan', $id_satuan);

		return $this->db->update('satuan', $in);
	}
	public function countProduk()
	{
		$query = $this->db->query('SELECT * FROM produk');
		// echo $query->num_rows();
		$query->num_rows();
		return ($query);
	}
	function get_category()
	{
		$query = $this->db->get('kategori');
		return $query;
	}
	public function dt_produk($post)
	{
		$from = 'produk k';
		// untuk sort
		$columns = array(
			'kode_produk',
			'nama_produk',
			'harga_produk',
			'gambar',
			'deskripsi',
			'kategori',
			'suplier',
			'status',
			'stok',
		);

		// untuk search
		$columnsSearch = array(
			'kode_produk',
			'nama_produk',
			'harga_produk',
			'gambar',
			'deskripsi',
			'kategori',
			'suplier',
			'status',
			'stok',
		);

		// custom SQL
		$sql = "SELECT * FROM {$from} ";

		$where = "";

		$whereTemp = "";
		if (isset($post['date']) && $post['date'] != '') {
			$date = explode(' / ', $post['date']);
			if (count($date) == 1) {
				$whereTemp .= "(created_at LIKE '%" . $post['date'] . "%')";
			} else {
				// $whereTemp .= "(created_at BETWEEN '".$date[0]."' AND '".$date[1]."')";
				$whereTemp .= "(date_format(created_at, \"%Y-%m-%d\") >='$date[0]' AND date_format(created_at, \"%Y-%m-%d\") <= '$date[1]')";
			}
		}
		if ($whereTemp != '' && $where != '') $where .= " AND (" . $whereTemp . ")";
		else if ($whereTemp != '') $where .= $whereTemp;

		// search
		if (isset($post['search']['value']) && $post['search']['value'] != '') {
			$search = $post['search']['value'];
			// create parameter pencarian kesemua kolom yang tertulis
			// di $columns
			$whereTemp = "";
			for ($i = 0; $i < count($columnsSearch); $i++) {
				$whereTemp .= $columnsSearch[$i] . ' LIKE "%' . $search . '%"';

				// agar tidak menambahkan 'OR' diakhir Looping
				if ($i < count($columnsSearch) - 1) {
					$whereTemp .= ' OR ';
				}
			}
			if ($where != '') $where .= " AND (" . $whereTemp . ")";
			else $where .= $whereTemp;
		}
		if ($where != '') $sql .= ' WHERE (' . $where . ')';


		//SORT Kolom
		$sortColumn = isset($post['order'][0]['column']) ? $post['order'][0]['column'] : 1;
		$sortDir    = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : 'asc';

		$sortColumn = $columns[$sortColumn - 1];

		$sql .= " ORDER BY {$sortColumn} {$sortDir}";

		$count = $this->db->query($sql);
		// hitung semua data
		$totaldata = $count->num_rows();

		// memberi Limit
		$start  = isset($post['start']) ? $post['start'] : 0;
		$length = isset($post['length']) ? $post['length'] : 10;


		$sql .= " LIMIT {$start}, {$length}";


		$data  = $this->db->query($sql);

		return array(
			'totalData' => $totaldata,
			'data' => $data,
		);
	}
	public function
	cari_cek_produk($nama_produk, $kategori)
	{

		$this->db->where('nama_produk', $nama_produk);
		$this->db->where('kategori', $kategori);
		return $this->db->get('produk')->num_rows();
	}
	public function select_max()
	{
		$this->db->select_max('kode_produk');
		return $this->db->get('produk');
	}
	public function
	tambah_produk($nama_produk, $harga_produk, $kategori, $suplier, $stok,$status)
	{

		$kode_produk = $this->select_max()->result()[0]->kode_produk == 'NULL'
		? 1
			: substr($this->select_max()->result()[0]->kode_produk, 3, 9);
			
			if (!$kode_produk) $kode_produk = 0;
			$kode_produk = intval(preg_replace('/\D/', '', $kode_produk) + 1);
			$newID = 'A' . date('y');


			if ($kode_produk < 100000000) $newID .= '0';
			if ($kode_produk < 10000000) $newID .= '0';
			if ($kode_produk < 1000000) $newID .= '0';
			if ($kode_produk < 100000) $newID .= '0';
			if ($kode_produk < 10000) $newID .= '0';
			if ($kode_produk < 1000) $newID .= '0';
			if ($kode_produk < 100) $newID .= '0';
			if ($kode_produk < 10) $newID .= '0';
			$newID .= $kode_produk;

			var_dump($newID);die;


		$data = array(

			'kode_produk' => $newID,
			'nama_produk' => $nama_produk,
			'harga_produk' => $harga_produk,
			'status' => $status,

			'kategori' => $kategori,
			'suplier' => $suplier,
			'stok' => $stok,
			'created' => date("Y-m-d"),
		);
			// var_dump($data);die();


		if ($this->db->insert('produk', $data)) {
			$data['sukses'] = true;
		} else {
			$data['sukses'] = false;

			// var_dump($this->db->error());die();

		}

		return $data;

	}
}
