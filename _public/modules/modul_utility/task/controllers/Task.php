<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Task extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->cbo_cabang = $this->get_combo('cabang');
		$this->cbo_prioritas = $this->get_combo('prioritas-task');
		$this->cbo_tipe = $this->get_combo('tipe-task');
		$this->cbo_status = $this->get_combo('status-task');
		$this->cbo_status = $this->get_combo('status-task');
		$this->set_Tbl_Master(_TBL_TASK);
		$this->set_Table('cabang');
		$this->set_Table('users');
		
		$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
		
		$this->addField(array('field'=>'cabang_no_tmp', 'type'=>'free', 'input'=>'free', 'default'=>_CABANG_NAMA_, 'size'=>45));
		$this->addField(array('field'=>'cabang_no', 'size'=>30, 'save'=>true, 'show'=>false, 'default'=>_CABANG_NO_));
		$this->addField(array('field'=>'staft_no', 'size'=>30, 'save'=>true, 'show'=>false, 'default'=>_USER_NO_));
		
		$this->addField(array('field'=>'tanggal_mulai', 'default'=>date('d-m-Y H:i'), 'input'=>'datetime', 'type'=>'datetime', 'search'=>true, 'size'=>15));
		$this->addField(array('field'=>'tanggal_selesai', 'default'=>date('d-m-Y H:i'), 'input'=>'datetime', 'type'=>'datetime', 'search'=>true, 'size'=>15));
		$this->addField(array('field'=>'task', 'search'=>true, 'size'=>70));
		$this->addField(array('field'=>'prioritas', 'input'=>'combo', 'combo'=>$this->cbo_prioritas, 'default'=>1, 'search'=>true, 'size'=>15));
		$this->addField(array('field'=>'warna', 'input'=>'color', 'size'=>10));
		$this->addField(array('field'=>'keterangan', 'input'=>'multitext', 'size'=>300));
		$this->addField(array('field'=>'tipe', 'input'=>'combo', 'combo'=>$this->cbo_tipe, 'size'=>300));
		if (_MODE_=='edit')
			$this->addField(array('field'=>'status', 'input'=>'combo', 'combo'=>$this->cbo_status, 'size'=>300));
		else
			$this->addField(array('field'=>'status', 'show'=>false));
		
		$this->addField(array('field'=>'file_attr', 'input'=>'upload', 'type'=>'upload', 'path'=>'events'));
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'cabang_no','sp'=>$this->tbl_cabang,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'staft_no','sp'=>$this->tbl_users,'id_sp'=>'id'));
		$this->addField(array('nmtbl'=>$this->tbl_cabang, 'field'=>'cabang', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_users, 'field'=>'nama_lengkap', 'size'=>20, 'show'=>false));
		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'cabang_no_tmp', 'disabled'=>true));
		$this->set_Where_Table($this->tbl_master, 'staft_no', '=', _USER_NO_);
		$this->set_Sort_Table($this->tbl_master,'tanggal_mulai', 'desc');
		
		$this->set_Table_List($this->tbl_master,'tanggal_mulai');
		$this->set_Table_List($this->tbl_master,'task');
		$this->set_Table_List($this->tbl_master,'prioritas','', 10,'center');
		$this->set_Table_List($this->tbl_master,'tipe','', 5,'center');
		$this->set_Table_List($this->tbl_master,'status','', 5,'center');
		$this->set_Table_List($this->tbl_master,'file_attr','', 10,'center');
		$this->set_Table_List($this->tbl_master,'warna','', 5,'center');
		
		$this->set_Close_Setting();
	}
	
	function MASTER_DATA_LIST($id){
		$this->jml_pemakai=$this->data->get_data_pemakai($id);
	}
	
	function listBox_WARNA($row, $value){
		$result = '<div style="width:100%;background-color:'.$value.'">&nbsp;</div>';
		return $result;
	}
	
	function listBox_STATUS($row, $value){
		if (array_key_exists($value, $this->cbo_status)){
			$value = $this->cbo_status[$value];
		}
		
		return $value;
	}
	
	function listBox_PRIORITAS($row, $value){
		if (array_key_exists($value, $this->cbo_prioritas)){
			$value = $this->cbo_prioritas[$value];
		}
		
		return $value;
	}
	
	function listBox_TIPE($row, $value){
		if (array_key_exists($value, $this->cbo_tipe)){
			$value = $this->cbo_tipe[$value];
		}
		
		return $value;
	}
	
	function listBox_FILE_ATTR($rows, $value){
		if (!empty($value)){
			$value = '<a href="'.base_url('ajax/download/events/'.$value).'" target="_blank">Download</a>';
		}
		return $value;
	}
	
	function updateBox_CABANG_NO_TMP($field, $rows, $value){
		$content = $this->add_Box_Input('text', $field, _CABANG_NAMA_);
		return $content;
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $row){	
		$jml=0;
		if (array_key_exists($row['l_id'], $this->jml_pemakai)){
			$jml=$this->jml_pemakai[$row['l_id']];
		}
		if ($jml>0){$tombol['delete']=array();}
		return $tombol;
	}
}