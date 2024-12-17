<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Level_Color extends BackendController {
	
	public function __construct()
	{
        parent::__construct();
		
		$this->cboLevelMapping=$this->get_combo('level_mapping');
		$this->cboIMpact=$this->get_combo('impact');
		$this->cboLikelihod=$this->get_combo('likelihood');
		
		$this->set_Tbl_Master(_TBL_LEVEL_COLOR);
		$this->set_Table(_TBL_LEVEL_MAPPING);
		
		$this->set_Open_Tab('Data '.lang('msg_title'));
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'level_risk_no', 'input'=>'combo', 'combo'=>$this->cboLevelMapping, 'size'=>50));
			$this->addField(array('field'=>'impact','search'=>true, 'input'=>'combo', 'combo'=>$this->cboIMpact, 'size'=>50));
			$this->addField(array('field'=>'likelihood','search'=>true, 'input'=>'combo', 'combo'=>$this->cboLikelihod, 'size'=>50));
			$this->addField(array('field'=>'score', 'size'=>20));
			$this->addField(array('field'=>'urut', 'size'=>20, 'show'=>false));
			$this->addField(array('field'=>'urut_res', 'show'=>false, 'title'=>'Urut Residual', 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'level_risk_no','sp'=>$this->tbl_level_mapping,'id_sp'=>'id'));
		$this->addField(array('nmtbl'=>$this->tbl_level_mapping, 'field'=>'color', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_level_mapping, 'field'=>'color_text', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_level_mapping, 'field'=>'level_mapping', 'size'=>20, 'show'=>false));
		
		$this->set_Sort_Table($this->tbl_master,'score');
		
		$this->set_Table_List($this->tbl_level_mapping,'level_mapping', '', 15);
		$this->set_Table_List($this->tbl_master,'impact', '', 15);
		$this->set_Table_List($this->tbl_master,'likelihood', '', 15);
		$this->set_Table_List($this->tbl_master,'urut', '', 5, 'center');
		$this->set_Table_List($this->tbl_master,'urut_res', '', 5, 'center');
		$this->set_Table_List($this->tbl_level_mapping,'color','',5,'center');
		$this->set_Table_List($this->tbl_master,'score','',5,'center');
		
		$this->set_Close_Setting();
	}
	
	function listBox_IMPACT($row, $value){
		$result=$this->data->get_level($value);
		return $result;
	}
	
	function listBox_LIKELIHOOD($row, $value){
		$result=$this->data->get_level($value);
		return $result;
	}
	
	function listBox_COLOR($row, $value){
		$result='<div class="label" style="background-color:'.$row['l_color'].';width:100%;color:'.$row['l_color_text'].'">&nbsp;&nbsp;&nbsp;'.$row['l_color'].'&nbsp;&nbsp;&nbsp;</div>';
		return $result;
	}
}