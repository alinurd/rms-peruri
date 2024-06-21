<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Risk_Impact_Library extends BackendController {
	var $type_risk=0;
	var $risk_type=[];
	public function __construct() {
        parent::__construct();
		$this->type_risk=3;
		$this->kel=$this->get_combo('data-combo','kel-library');
		$this->cbo_risk_type=$this->get_combo('risk_type');
		
		$this->set_Tbl_Master(_TBL_LIBRARY);
		$this->set_Table(_TBL_RISK_TYPE);
		
		$this->set_Open_Tab('Data Risk Event Library');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			// $this->addField(array('field'=>'kel', 'type'=>'free', 'input'=>'combo', 'combo'=>$this->kel, 'size'=>50));
			// $this->addField(array('field'=>'risk_type_no', 'input'=>'combo', 'combo'=>$this->cbo_risk_type, 'size'=>50));
			$this->addField(array('field'=>'code', 'search'=>false, 'size'=>10));
			$this->addField(array('field'=>'description', 'input'=>'multitext', 'search'=>true, 'size'=>500));
			$this->addField(array('field'=>'notes','show'=>false, 'input'=>'multitext', 'search'=>false, 'size'=>500));
			$this->addField(array('field'=>'item_use', 'type'=>'free', 'show'=>false, 'search'=>false));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'size'=>40));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		$this->set_Where_Table($this->tbl_master, 'type', '=', $this->type_risk);
		
		// $this->set_Table_List($this->tbl_master,'kel');
		// $this->set_Table_List($this->tbl_risk_type,'type');
		$this->set_Table_List($this->tbl_master,'code', '', 5);
		$this->set_Table_List($this->tbl_master,'description', '', 40);
		// $this->set_Table_List($this->tbl_master,'notes');
		$this->set_Table_List($this->tbl_master,'item_use');
		$this->set_Table_List($this->tbl_master,'status');
		
		$this->set_Close_Setting();
	}
	
	function MASTER_DATA_LIST($id, $field){
		$rows = $this->db->get(_TBL_RISK_TYPE)->result_array();
		$this->risk_type=[];
		foreach($rows as $row){
			$this->risk_type[$row['id']]=$row['kelompok'];
		}
	}
	
	function listBox_KEL($rows, $value){
		$value = $rows['l_risk_type_no'];
		$hasil='';
		if (array_key_exists($value, $this->risk_type))
			$hasil=$this->kel[$this->risk_type[$value]];
		return $hasil;
	}
	
	
	function updateBox_KEL($field, $rows, $value){
		$id=$rows['l_risk_type_no'];
		$rows = $this->db->where('id', $id)->get(_TBL_RISK_TYPE)->row_array();
		
		if ($rows){$value = $rows['kelompok'];}
				
		$content = $this->add_Box_Input('combo', $field, $value);
		return $content;
	}
	
	function insertBox_CODE($field){
		$content = form_input($field['label'],' '," size='{$field['size']}' class='form-control'  id='{$field['label']}' readonly='readonly' ");
		return $content;
	}
	
	function updateBox_CODE($field, $row, $value){
		$content = form_input($field['label'], $value," size='{$field['size']}' class='form-control'  id='{$field['label']}' readonly='readonly' ");
		return $content;
	}
	
	function listBox_STATUS($row, $value){
		if ($value=='1')
			$result='<span class="label label-success"> Aktif</span>';
		else
			$result='<span class="label label-warning"> Off</span>';
		
		return $result;
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$result = $this->data->save_library($id , $new_data, $this->type_risk, 'new');
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$result = $this->data->save_library($id , $new_data, $this->type_risk, 'edit', $old_data);
		return $result;
	}
	
	function POST_CHECK_BEFORE_UPDATE($new_data, $old_data){
		$result=true;
		if ($old_data['l_code'] !== $new_data['l_code'])
		{
			$result = $this->crud->cek_double_data_library($new_data['l_code'], 2);
		}
		return $result;
	}
	
	function POST_CHECK_BEFORE_DELETE($ids=array()){
		$ada=false;
		foreach($ids as $row){
			$value=$this->data->cari_total_dipakai($row);
			if ($value['jml']>0){
				$this->_set_pesan('Cause : ' . $value['nama_lib']);
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