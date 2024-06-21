<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Faktor_Prioritas extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->kelCombo="faktor-prioritas";
		$this->set_Tbl_Master(_TBL_DATA_COMBO);
		
		$this->set_Open_Tab('Faktor Prioritas');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'kelompok', 'show'=>false, 'save'=>true, 'default'=>$this->kelCombo));
			$this->addField(array('field'=>'kode', 'required'=>true, 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'data', 'required'=>true, 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'aktif', 'type'=>'string', 'input'=>'boolean', 'default'=>'Y', 'search'=>true, 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Where_Table($this->tbl_master,'kelompok','=',$this->kelCombo);
		$this->set_Sort_Table($this->tbl_master,'urut');
		
		$this->set_Table_List($this->tbl_master,'kode');
		$this->set_Table_List($this->tbl_master,'data');
		$this->set_Table_List($this->tbl_master,'aktif','',10, 'center');
		
		$this->set_Close_Setting();
	}
}