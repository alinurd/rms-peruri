<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Risk_Loss_Event extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		
		// $this->cbo_owner = $this->get_combo('parent-input');
		$this->cbo_parent = $this->get_combo('parent-input');
		$this->set_Tbl_Master(_TBL_VIEW_RCSA_ACTION_DETAIL);
		
		$this->set_Open_Tab('Data Risk Event Library');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			// $this->addField(array('field' => 'owner_name', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => true, 'search' => true));
			$this->addField(array('field' => 'owner_no','title'=>'Risk Owner', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'search' => true,'show' => true));
			$this->addField(array('field'=>'sasaran', 'size'=>100));
			$this->addField(array('field'=>'event_name', 'title'=>'Risiko', 'size'=>100));
			$this->addField(array('field'=>'reaktif', 'title'=>'Treathment Reaktif', 'size'=>100));
			$this->addField(array('field'=>'progress_date', 'title'=>'Tanggal Terjadi', 'input'=>'date', 'type'=>'data', 'size'=>10));
			$this->addField(array('field'=>'keterangan', 'title'=>'Short Report', 'type'=>'data', 'size'=>100));
			$this->addField(array('field' => 'owner_no', 'show' => false));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'progress_date', 'desc');
		
		$this->set_Table_List($this->tbl_master,'owner_no');
		$this->set_Table_List($this->tbl_master,'sasaran');
		$this->set_Table_List($this->tbl_master,'event_name');
		$this->set_Table_List($this->tbl_master,'reaktif');
		$this->set_Table_List($this->tbl_master,'progress_date');
		$this->set_Table_List($this->tbl_master,'keterangan','Short Report');

		$this->set_Where_Table($this->tbl_master, 'status_loss', '=', 1);
		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('edit', false);
		$this->_SET_PRIVILEGE('delete', false);
		$this->set_Close_Setting();
	}
	function listBox_OWNER_NO($rows, $value){
	
		$data = str_replace('[','', $value);
		$data = str_replace("]",'', $data);
		$data = explode(",", $data);
		$hasil='';
		foreach ($data as $key => $event) {
			$id = str_replace('"','', $event);	
			if ($event != "") {
			$a = $this->data->get_owner(intval($id));
			}
		}
		$hasil=$a;
		return $hasil;
	}
}