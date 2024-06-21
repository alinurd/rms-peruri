<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Level_mapping extends BackendController {
	public function __construct()
	{
        parent::__construct();
		$this->set_Tbl_Master(_TBL_LEVEL_MAPPING);
		
		$this->set_Open_Tab('Data '.lang('msg_title'));
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'level_mapping', 'size'=>25));
			$this->addField(array('field'=>'color', 'input'=>'color', 'size'=>10));
			$this->addField(array('field'=>'color_text', 'size'=>10));
			$this->addField(array('field'=>'item_use', 'type'=>'free', 'show'=>false, 'size'=>20));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'level_mapping');
		
		$this->set_Table_List($this->tbl_master,'level_mapping');
		$this->set_Table_List($this->tbl_master,'color','','','center');
		$this->set_Table_List($this->tbl_master,'status','','','center');
		$this->set_Table_List($this->tbl_master,'item_use','','','center');
		
		$this->set_Close_Setting();
	}
	
	function listBox_COLOR($row, $value){
		$result='<div class="label" style="background-color:'.$value.';width:100%;"><span style="color:'.$row['l_color_text'].'">&nbsp;&nbsp;&nbsp;'.$value.'&nbsp;&nbsp;&nbsp;</span></div>';
		return $result;
	}
	
	function POST_CHECK_BEFORE_DELETE($ids=array()){
		$ada=false;
		// Doi::dump($ids);die();
		foreach($ids as $row){
			$value=$this->data->cari_total_dipakai($row);
			if ($value['jml']>0){
				$this->_set_pesan('Type : ' . $value['nama']);
				$ada=true;
			}
		}
		if ($ada)
			$this->_set_pesan('Tidak bisa dihapus');
		
		return !$ada;
	}
	
	function listBox_ITEM_USE($row, $value){
		$result='';
		$value=$this->data->cari_total_dipakai($row['l_id']);
		if ($value['jml']>0)
			$result =  '<span class="badge bg-info">' . $value['jml'] . '</span>';
		return $result;
	}
	
}