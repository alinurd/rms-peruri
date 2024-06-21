<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Treatment extends BackendController {
	public function __construct()
	{
        parent::__construct();
		$this->set_Tbl_Master(_TBL_TREATMENT);
		
		$this->set_Open_Tab('Data '.lang('msg_title'));
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'treatment', 'size'=>25));
			$this->addField(array('field'=>'sts_next', 'input'=>'boolean', 'default'=>1, 'size'=>20));
			$this->addField(array('field'=>'warna', 'input'=>'color', 'size'=>30));
			$this->addField(array('field'=>'urut', 'input'=>'updown', 'size'=>60));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'treatment');
		
		$this->set_Table_List($this->tbl_master,'treatment');
		$this->set_Table_List($this->tbl_master,'sts_next','',10,'center');
		$this->set_Table_List($this->tbl_master,'warna','',10,'center');
		$this->set_Table_List($this->tbl_master,'urut','',10,'center');
		$this->set_Table_List($this->tbl_master,'status','',10,'center');
		
		$this->set_Close_Setting();
	}

	function listBox_WARNA($row, $value){
		$result='<div class="label" style="background-color:'.$value.';width:100%;">&nbsp;&nbsp;&nbsp;'.$value.'&nbsp;&nbsp;&nbsp;</div>';
		return $result;
	}
}