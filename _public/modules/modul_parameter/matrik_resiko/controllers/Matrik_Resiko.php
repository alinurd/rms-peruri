<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Matrik_Resiko extends BackendController {
	
	public function __construct()
	{
        parent::__construct();
		
		$this->cboLevelMapping=$this->get_combo('data-combo', 'tingkat-resiko');
		$this->cboIMpact=array(1=>1,2=>2,3=>3,4=>4,5=>5);
		$this->cboLikelihod=$this->get_combo('data-combo', 'occurrence');
		
		$this->set_Tbl_Master(_TBL_LEVEL_COLOR_K3);
		$this->set_Table(_TBL_DATA_COMBO);
		
		$this->set_Open_Tab('Data '.lang('msg_title'));
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'tingkat_resiko_no', 'input'=>'combo', 'combo'=>$this->cboLevelMapping, 'size'=>50));
			$this->addField(array('field'=>'severity_no', 'input'=>'combo', 'combo'=>$this->cboIMpact, 'size'=>50));
			$this->addField(array('field'=>'occurance_no', 'input'=>'combo', 'combo'=>$this->cboLikelihod, 'size'=>50));
			$this->addField(array('field'=>'score', 'input'=>'float', 'decimal'=>1, 'size'=>5));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'tingkat_resiko_no','sp'=>$this->tbl_data_combo,'id_sp'=>'id'));
		$this->addField(array('nmtbl'=>$this->tbl_data_combo, 'field'=>'param1', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_data_combo, 'field'=>'param2', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_data_combo, 'field'=>'data', 'size'=>20, 'show'=>false));
		
		$this->set_Sort_Table($this->tbl_master,'score');
		
		$this->set_Table_List($this->tbl_data_combo,'data');
		$this->set_Table_List($this->tbl_master,'severity_no','','','center');
		$this->set_Table_List($this->tbl_master,'occurance_no');
		$this->set_Table_List($this->tbl_data_combo,'param1','','','center');
		$this->set_Table_List($this->tbl_master,'score','','','center');
		
		$this->set_Close_Setting();
	}
	
	function listBox_SEVERITY_NO($row, $value){
		if (array_key_exists($value, $this->cboIMpact))
			$value = $this->cboIMpact[$value];
		return $value;
	}
	
	function listBox_OCCURANCE_NO($row, $value){
		if (array_key_exists($value, $this->cboLikelihod))
			$value = $this->cboLikelihod[$value];
		return $value;
	}
	
	function listBox_PARAM1($row, $value){
		$result='<div class="label" style="background-color:'.$value.';width:100%;color:'.$row['l_param2'].'">&nbsp;&nbsp;&nbsp;'.$value.'&nbsp;&nbsp;&nbsp;</div>';
		return $result;
	}
}