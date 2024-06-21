<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Prioritas_Hiradc extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->cbo_faktor = $this->get_combo('data-combo', 'faktor-prioritas');
		$this->set_Tbl_Master(_TBL_PRIORITAS);
		
		$this->set_Open_Tab('Faktor Prioritas');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'prioritas', 'required'=>true, 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'faktor', 'input'=>'combo:search', 'multiselect'=>true, 'combo'=>$this->cbo_faktor, 'size'=>100));
			$this->addField(array('field'=>'status', 'type'=>'string', 'input'=>'boolean', 'search'=>true, 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'urut');
		
		$this->set_Table_List($this->tbl_master,'prioritas');
		$this->set_Table_List($this->tbl_master,'faktor');
		$this->set_Table_List($this->tbl_master,'status','',10, 'center');
		
		$this->set_Close_Setting();
	}
	
	function listBox_FAKTOR($rows, $value){
		$value=explode(',', $value);
		$rows = $this->db->where_in('id', $value)->get(_TBL_DATA_COMBO)->result_array();
		$arr=array();
		foreach($rows as $row){
			$arr[]=$row['kode'];
		}
		return implode(', ', $arr);
	}
}