<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Status_Action extends BackendController {
	public function __construct()
	{
        parent::__construct();
		$this->cboIcon = array('info'=>'Dark Blue','success'=>'Green','danger'=>'Red','primary'=>'Blue','warning'=>'Yellow');
		$this->set_Tbl_Master(_TBL_STATUS_ACTION);
		
		$this->set_Open_Tab('Data '.lang('msg_title'));
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'status_action', 'size'=>25));
			// $this->addField(array('field'=>'span', 'size'=>25));
			// $this->addField(array('field'=>'icon', 'input'=>'combo', 'combo'=>$this->cboIcon, 'size'=>25));
			$this->addField(array('field'=>'warna', 'input'=>'color', 'size'=>30));
			$this->addField(array('field'=>'urut', 'input'=>'updown', 'size'=>60));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'urut');
		
		$this->set_Table_List($this->tbl_master,'status_action');
		// $this->set_Table_List($this->tbl_master,'span','','','center');
		// $this->set_Table_List($this->tbl_master,'icon','','','center');
		$this->set_Table_List($this->tbl_master,'warna','',10,'center');
		$this->set_Table_List($this->tbl_master,'urut','',10,'center');
		$this->set_Table_List($this->tbl_master,'status','','','center');
		
		$this->set_Close_Setting();		
	}
	
	function listBox_SPAN($row, $value){
		$resulr = '<span class="label label-'.$value.'">'.$value.'</span>';
		return $resulr;
	}
	function listBox_ICON($row, $value){
		$resulr = '<img src="'.img_url($value).'" width="35">';
		return $resulr;
	}

	function listBox_WARNA($row, $value){
		$result='<div class="label" style="background-color:'.$value.';width:100%;">&nbsp;&nbsp;&nbsp;'.$value.'&nbsp;&nbsp;&nbsp;</div>';
		return $result;
	}
}