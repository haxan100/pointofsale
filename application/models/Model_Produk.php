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


}
