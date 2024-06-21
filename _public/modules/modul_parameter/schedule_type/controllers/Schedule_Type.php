<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Schedule_Type extends BackendController {
	public function __construct()
	{
        parent::__construct();
		$this->set_Tbl_Master(_TBL_SCHEDULE_TYPE);
		
		$this->set_Open_Tab('Data '.lang('msg_title'));
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'type', 'size'=>25));
			$this->addField(array('field'=>'description', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'type');
		
		$this->set_Table_List($this->tbl_master,'type');
		$this->set_Table_List($this->tbl_master,'status','','','center');
		
		$this->set_Close_Setting();		
	}
}