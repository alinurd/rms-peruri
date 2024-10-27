<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Index_Komposit extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->kelCombo="Index Komposit";
		$this->pid=[0=>"KPMR", 1=>"Kinerja"];

		$this->kriteria_dampak=$this->get_combo('data-combo', 'kriteria-dampak');
		$this->set_Tbl_Master(_TBL_VIEW_COMBO);
		
		$this->set_Open_Tab('Index Komposit');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'kelompok', 'show'=>false, 'save'=>true, 'default'=>$this->kelCombo));
			$this->addField(array('field'=>'pid', 'title' => 'Jenis', 'required' => true, 'input'=>'combo', 'combo'=>$this->pid, 'search'=>true, 'size'=>20));
			$this->addField(array('field' => 'parent_name', 'show' => false));
			$this->addField(array('field'=>'data','title' => 'Judul', 'required'=>true, 'search'=>true, 'size'=>50));
			// $this->addField(array('field'=>'param1', 'input'=>'color', 'search'=>false, 'size'=>50));
			// $this->addField(array('field'=>'urut', 'input'=>'updown', 'search'=>false, 'size'=>60));
			$this->addField(array('field'=>'aktif', 'type'=>'string', 'input'=>'boolean', 'search'=>true, 'size'=>20));
			$this->addField(array('field' => 'param', 'type' => 'free', 'input' => 'free', 'mode' => 'o', 'size' => 100, 'title' => 'Parameter'));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));

		
		$this->set_Where_Table($this->tbl_master,'kelompok','=',$this->kelCombo);
		$this->set_Sort_Table($this->tbl_master,'id');
		
		// $this->set_Table_List($this->tbl_master,'kode');
		$this->set_Table_List($this->tbl_master,'data', '', 50);
		$this->set_Table_List($this->tbl_master,'parent_name', 'Kriteria Dampak', 10);
		// $this->set_Table_List($this->tbl_master,'param1','',10, 'center');
		// $this->set_Table_List($this->tbl_master,'urut','',10, 'center');
		$this->set_Table_List($this->tbl_master,'aktif','',10, 'center');

		$this->_CHANGE_TABLE_MASTER(_TBL_DATA_COMBO);

		$this->set_Close_Setting();
	}
 

	function insertBox_PARAM($field)
	{
		$return = $this->param();
		return $return;
	}

	function updateBox_PARAM($field, $rows, $value)
	{
		$return = $this->param($rows['l_id']);

		return $return;
	}

	function param($id = 0)
	{
		$rows = $this->db->where('id_combo', $id)->order_by('urut')->get("bangga_index_komposit")->result_array();
 		$data['data']=$rows;
		$result = $this->load->view('param', $data, true);
		return $result;
	
	}

	function POST_INSERT_PROCESSOR($id , $new_data){
 		$result = $this->data->save_privilege($id , $new_data);
		if (!$result)
			return $result;
		
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$result = $this->data->save_privilege($id , $new_data, $old_data);
		if (!$result)
			return $result;
		
		return $result;
	}
}