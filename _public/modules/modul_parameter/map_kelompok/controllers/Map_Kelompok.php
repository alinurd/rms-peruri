<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Map_Kelompok extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();

		$this->kel = $this->get_combo('data-combo', 'kel-library');

		$this->kel =$this->get_combo('data-combo', 'kel-library');
		$this->subkel =$this->get_combo('data-combo', 'subkel-library');
		$this->set_Tbl_Master('bangga_map_kelompok');
		
		$this->set_Open_Tab('Kelompok Library');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
		$this->addField(array('field' => 'kelompok', 'input' => 'combo:search', 'combo' => $this->kel, 'size' => 70, 'search' => true, 'required' => true));
		$this->addField(array('field' => 'subkelompok', 'input' => 'combo:search', 'combo' => $this->subkel, 'size' => 70, 'search' => true, 'required' => true));
 			$this->addField(array('field'=>'aktif', 'type'=>'string', 'input'=>'boolean', 'search'=>true, 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Where_Table($this->tbl_master, 'aktif','=',1);

		$this->set_Table_List($this->tbl_master,'kelompok');
		$this->set_Table_List($this->tbl_master,'subkelompok');
		$this->set_Table_List($this->tbl_master,'aktif','',10, 'center');
		
		$this->set_Close_Setting();
	}

	function listBox_KELOMPOK($row, $value)
	{
		$result = '';
		if (array_key_exists($value, $this->kel)) {
			$result = $this->kel[$value];
		}
		return $result;
	}

	function listBox_SUBKELOMPOK($row, $value)
	{
		$result = '';
		if (array_key_exists($value, $this->subkel)) {
			$result = $this->subkel[$value];
		}
		return $result;
	}


}