<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Period extends BackendController {
	public function __construct()
	{
        parent::__construct();
		
		$this->set_Tbl_Master(_TBL_PERIOD);
		
		$this->set_Open_Tab('Data Risk Event Library');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'periode_name', 'size'=>50));
			$this->addField(array('field'=>'start_date', 'input'=>'date', 'type'=>'date', 'size'=>10));
			$this->addField(array('field'=>'end_date', 'input'=>'date', 'type'=>'date', 'size'=>10));
			$this->addField(array('field'=>'description', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'order_no', 'input'=>'updown', 'size'=>90));
			$this->addField(array('field'=>'item_use', 'type'=>'free', 'show'=>false));
			// $this->addField(array('field'=>'status', 'title'=>'Status', 'input'=>'boolean', 'size'=>20));
			$this->addField(array('field'=>'aktif', 'title'=>'Aktif', 'input'=>'boolean', 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_master,'periode_name');
		$this->set_Table_List($this->tbl_master,'description');
		$this->set_Table_List($this->tbl_master,'start_date');
		$this->set_Table_List($this->tbl_master,'end_date');
		$this->set_Table_List($this->tbl_master,'item_use','','','center');
		$this->set_Table_List($this->tbl_master,'aktif','','','center');
		// $this->set_Table_List($this->tbl_master,'status','','','center');
		
		$this->set_Close_Setting();		
	}
	
	function listBox_ITEM_USE($row, $value){
		$result='';
		$value=$this->data->cari_total_dipakai($row['l_id']);
		if ($value['jml']>0)
			$result =  '<span class="badge bg-info">' . $value['jml'] . '</span>';
		return $result;
	}
}