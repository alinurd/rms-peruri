<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Severity_Cp extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->kelCombo="severity-cp";
		$this->set_Tbl_Master(_TBL_DATA_COMBO);
		
		$this->set_Open_Tab('Severiti Citra Perusahaan');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'kelompok', 'show'=>false, 'save'=>true, 'default'=>$this->kelCombo));
			$this->addField(array('field'=>'data', 'required'=>true, 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'param1', 'input'=>'updown', 'size'=>80));
			$this->addField(array('field'=>'urut', 'input'=>'updown', 'size'=>80));
			$this->addField(array('field'=>'aktif', 'type'=>'string', 'input'=>'boolean', 'default'=>'Y', 'search'=>true, 'size'=>20));
			$this->addField(array('field'=>'item_use', 'type'=>'free', 'show'=>false));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Where_Table($this->tbl_master,'kelompok','=',$this->kelCombo);
		$this->set_Sort_Table($this->tbl_master,'urut');
		
		$this->set_Table_List($this->tbl_master,'data');
		$this->set_Table_List($this->tbl_master,'param1','',7, 'center');
		$this->set_Table_List($this->tbl_master,'urut','',7, 'center');
		$this->set_Table_List($this->tbl_master,'item_use','',7, 'center');
		$this->set_Table_List($this->tbl_master,'aktif','',7, 'center');
		
		$this->set_Close_Setting();
	}
	
	function listBox_ITEM_USE($row, $value){
		$result='';
		$value=$this->db->where('tr_no', $row['l_id'])->get(_TBL_HIRADC_DETAIL)->num_rows();
		if ($value>0)
			$result =  '<span class="badge bg-info">' . $value . '</span>';
		return $result;
	}
}