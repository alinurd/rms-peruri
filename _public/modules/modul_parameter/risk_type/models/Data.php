<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	var $tbl_items='';
	var $_prefix='';
	var $_modules='';
	public function __construct()
    {
        parent::__construct();
		$this->_prefix=$this->config->item('tbl_suffix');
		$this->tbl_items=$this->_prefix."siswa";
		$this->_modules= $this->router->fetch_module();
	}
	 
	function getAllData($query=array())
	{
		$data = $this->db->query("select a.*, b.propinsi, (select count(x.id) from ewarn_distrik x where x.id_kota=a.id) as jml_distrik, (select count(k.id) from ewarn_puskesmas k inner join ewarn_distrik x on k.id_distrik=x.id inner join ewarn_kota y on x.id_kota=y.id where k.id_distrik=a.id) as jml_rs from ewarn_kota a inner join ewarn_propinsi b on a.id_prop=b.id  order by b.propinsi, a.kota");
		$hasil['result_data']=$data->result_array();
		
		return $hasil;
	}

	function save_detail($newid, $data, $mode, $old = [])
	{
		// 
	// 	
		$updf['id'] = $newid;
 		if (isset($data['id_edit'])) {
			if (count($data['id_edit']) > 0) {
				foreach ($data['id_edit'] as $key => $row) {
					$upd = array();
					$upd['risiko_no'] = $newid;
					$upd['data'] = $data['data'][$key];

					if (intval($row) > 0) {
						doi::dump($data);
						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result = $this->crud->crud_data(array('table' => _TBL_SUBRISIKO, 'field' => $upd, 'where' => array('id' => $row), 'type' => 'update'));
					} else {
						$result = $this->crud->crud_data(array('table' => _TBL_SUBRISIKO, 'field' => $upd, 'type' => 'add'));
					}
				}
			}
		}
		// die($result);

		return true;
	}
	function delete_subrisiko($id)
	{		//delete for table sasaran at rcsa/edit
		$query = $this->db->query("DELETE FROM bangga_subrisiko WHERE id='$id'");
		return $query;
	}

	function cari_total_dipakai($id)
	{
		$rows = $this->db->select('risiko_no, count(risiko_no) as jml')->where_in('risiko_no', $id)->group_by('risiko_no')->get(_TBL_SUBRISIKO)->result_array();
		$result['subrisiko'] = [];
		foreach ($rows as $row) {
			$result['subrisiko'][$row['risiko_no']] = $row['jml'];
		}
//  doi::dump($result);
		return $result;
	}


	function simpan_data($data=array(),$nm_tbl,$type='tambah')
	{
		if ($type=='delete')
		{
			$this->db->delete($nm_tbl,$data);
		}else
		{
			$upd['id_prop'] = $data["id_prop"];
			$upd['kota'] = $data["kota"];
			$upd['nama_kontak'] = $data["nama_kontak"];
			$upd['jabatan'] = $data["jabatan"];
			$upd['alamat'] = $data["alamat"];
			$upd['telp'] = $data["telp"];
			$upd['hp'] = $data["hp"];
			$upd['email'] = $data["email"];
			$upd['aktif'] = $data["aktif"];
			
			if($type=="edit")
			{
				$this->db->where('id', $data["id"]);
				$this->db->update($nm_tbl,$upd);
			}
			else if($type=="tambah")
			{
				$this->db->insert($nm_tbl,$upd);
			}
		}
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */