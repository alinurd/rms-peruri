<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Level extends BackendController {
	public function __construct()
	{
        parent::__construct();
		$this->cboCategory = array(''=>' - select - ','likelihood'=>'Probabilitas','impact'=>'Impact');
		$this->set_Tbl_Master(_TBL_LEVEL);
		
		$this->set_Open_Tab('Data '.lang('msg_title'));
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'category', 'input'=>'combo', 'combo'=>$this->cboCategory, 'size'=>50));
			$this->addField(array('field'=>'code', 'size'=>50));
			$this->addField(array('field'=>'level', 'size'=>20));
			$this->addField(array('field'=>'description', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'score', 'input'=>'int', 'size'=>20));
			$this->addField(array('field'=>'bottom_value', 'input'=>'int', 'size'=>20));
			$this->addField(array('field'=>'upper_value', 'input'=>'int', 'size'=>20));
			$this->addField(array('field'=>'urut', 'input'=>'updown', 'size'=>90));
			$this->addField(array('field'=>'item_use', 'show'=>false, 'type'=>'free', 'size'=>20));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'category');
		$this->set_Sort_Table($this->tbl_master,'urut');
		
		$this->set_Table_List($this->tbl_master,'category');
		$this->set_Table_List($this->tbl_master,'code','','','center');
		$this->set_Table_List($this->tbl_master,'level');
		$this->set_Table_List($this->tbl_master,'score');
		$this->set_Table_List($this->tbl_master,'bottom_value');
		$this->set_Table_List($this->tbl_master,'upper_value');
		$this->set_Table_List($this->tbl_master,'urut');
		$this->set_Table_List($this->tbl_master,'status','','','center');
		
		$this->set_Close_Setting();		
	}
	
	function POST_CHECK_BEFORE_DELETE($ids=array()){
		$ada=false;
		foreach($ids as $row){
			$value=$this->data->cari_total_dipakai($row);
			if ($value['jml']>0){
				$this->_set_pesan('Level : ' . $value['nama']);
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