<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Kategori_Kejadian extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->kelCombo = "kat-kejadian";
		$this->set_Tbl_Master(_TBL_DATA_COMBO);
		
		$this->set_Open_Tab('Kategori Kejadian');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'kelompok', 'show'=>false, 'save'=>true, 'default'=>$this->kelCombo));
			$this->addField(array('field'=>'data', 'required'=>true, 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'aktif', 'type'=>'string', 'input'=>'boolean', 'search'=>true, 'size'=>20));
			$this->addField(array('field'=> 'param1', 'type'=>'string', 'input'=>'boolean', 'show'=> false, 'size'=>20));
		// $this->addField(array('field' => 'cause', 'title' => 'Risk Event', 'type' => 'free', 'search' => false, 'mode' => 'o'));

		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Where_Table($this->tbl_master,'kelompok','=',$this->kelCombo);
		$this->set_Sort_Table($this->tbl_master,'urut');
		
		// $this->set_Table_List($this->tbl_master,'kode');
		$this->set_Table_List($this->tbl_master,'data');
		// $this->set_Table_List($this->tbl_master, 'param1', 'Jumlah Event', 10, 'center');

		$this->set_Table_List($this->tbl_master,'aktif','',10, 'center');
		
		$this->set_Close_Setting();
	}


}