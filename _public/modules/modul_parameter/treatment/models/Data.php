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
	
	// public function index($rows=array(), $search=array(), $param=array())
	// {
		// // // var_dump($param);
		// // $fields=array();
		// // $filter=array();
		// // $where ="";
		// // foreach($rows['fields'] as $key=>$row)
		// // {
			// // $fields[]= $row[0].'.'.$row[1].' as l_'.$row[1];
			// // if (count($search)>0)
			// // {
				// // if ($row[6])
				// // {
					// // if (!empty($search['q_'.$row[1]])){
						// // switch ($row[3]['type']){
							// // case 'string':
							// // case 'text':
								// // $filter[] = $row[0].'.'.$row[1] . " like '%".$search['q_'.$row[1]]."%'";
								// // break;
							// // case 'int':
							// // case 'integer':
							// // case 'float':
								// // $filter[] = $row[0].'.'.$row[1] . " = '".$search['q_'.$row[1]]."'";
								// // break;
							// // case 'date':
								// // $tgl=date('Y-m-d',strtotime($search['q_'.$row[1]]));
								// // $filter[] = $row[0].'.'.$row[1] . " = '".$tgl."'";
								// // break;
						// // }
					// // }
				// // }
			// // }
		// // }
		
		// // $no=1;
		// // $from="";
		// // foreach($rows['m_tbl'] as $key=>$row)
		// // {
			// // if (count($row)==1){
				// // $from=" ".$row['pk']." ";
				// // break;
			// // }else{
				// // if ($no==1){
					// // $from .=" ".$row['pk'].' left join '.$row['sp'].' on '.$row['pk'].'.'.$row['id_pk'].' = '.$row['sp'].'.'.$row['id_sp']." ";
					// // ++$no;
				// // }else{
					// // $from .=" left join ".$row['sp'].' on '.$row['pk'].'.'.$row['id_pk'].' = '.$row['sp'].'.'.$row['id_sp']." ";
				// // }
				// // if (isset($row['show_field'])){
					// // $fields[]= $row['show_field']['tbl'].'.'.$row['show_field']['field'].' as l_'.$row['show_field']['field'];
				// // }
			// // }
		// // }
		
		// // if (count($filter)>0)
		// // {
			// // $where=implode(" and ",$filter);
			// // $where = " where ".$where;
		// // }
		
		// // $this->db->_error_message(); 
		// // $this->db->_error_number(); 
		// // $field=implode(', ',$fields);
		// // $sql = "select {$field} from {$from} {$where} ";
		// // if(!$this->db->query($sql))
		// // {
			// // $x=$this->db->_error_message(); 
			// // $y=$this->db->_error_number(); 
			// // $this->session->set_flashdata('err_no', $y.' Database');
			// // $this->session->set_flashdata('err_desc', $x);
			// // redirect('error');
		// // }
	
		// // $query = $this->db->query($sql);
		
		// // $sess['_'.$param['modul'].'_query_']=$sql;
		// // $this->session->set_userdata($sess);
			
		// // $data['fields']=$query->result_array();
		
		// // return $data;
	// }
	
	function getAllData($query=array())
	{
		$data = $this->db->query("select a.*, b.propinsi, (select count(x.id) from ewarn_distrik x where x.id_kota=a.id) as jml_distrik, (select count(k.id) from ewarn_puskesmas k inner join ewarn_distrik x on k.id_distrik=x.id inner join ewarn_kota y on x.id_kota=y.id where k.id_distrik=a.id) as jml_rs from ewarn_kota a inner join ewarn_propinsi b on a.id_prop=b.id  order by b.propinsi, a.kota");
		$hasil['result_data']=$data->result_array();
		
		return $hasil;
	}

	// function getData($id=0, $rows)
	// {
		// $separat ='';
		// $field='';
		// foreach($rows['fields'] as $key=>$row)
		// {
			// $field .= $separat.$row[0].'.'.$row[1].' as l_'.$row[1];
			// $separat =',';
		// }
		// $sql="select {$field} from {$this->tbl_items} where id={$id} ";
		// $data = $this->db->query($sql);
		
		// $hasil=$data->result_array();
		
		// $d = array();
		// $xx=array();
		// foreach($hasil as $key=>$dt)
		// {
			// foreach($rows['fields'] as $key=>$row)
			// {$xx['l_'.$row[1]]=$dt['l_'.$row[1]];} 
		// }
		// $d['fields']=$xx;
		// return $d;
	// }
	
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