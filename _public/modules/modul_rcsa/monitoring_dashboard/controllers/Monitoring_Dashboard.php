<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Monitoring_Dashboard extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		$this->cbo_status_action =$this->get_combo('status-action');
		$this->cbo_owner =$this->get_combo('owner');
		
		$this->set_Tbl_Master(_TBL_VIEW_RCSA_MITIGASI);
		$this->set_Table(_TBL_RCSA_DETAIL);
		$this->set_Table(_TBL_RCSA);
		$this->set_Table(_TBL_OWNER);		
		
		$this->tbl_schedule_type=_TBL_SCHEDULE_TYPE;
		$this->tbl_status_action=_TBL_STATUS_ACTION;
		
		$this->set_Open_Tab('Konteks Risiko');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'detail', 'title'=>'Detail', 'type'=>'free', 'show'=>true, 'mode'=>'o'));
			$this->addField(array('field'=>'sub_detail', 'title'=>'Monitoring', 'type'=>'free', 'show'=>true, 'mode'=>'o'));
			$this->addField(array('field'=>'rcsa_detail_no', 'show'=>false, 'size'=>100));
			$this->addField(array('field'=>'event_name', 'show'=>false, 'size'=>100));
			$this->addField(array('field'=>'risk_couse_no', 'show'=>false, 'size'=>100));
			$this->addField(array('field'=>'risk_impact_no', 'show'=>false, 'size'=>100));
			$this->addField(array('field'=>'owner_no', 'show'=>false, 'size'=>100));
			$this->addField(array('field'=>'reaktif', 'show'=>false, 'size'=>100));
			$this->addField(array('field'=>'proaktif', 'show'=>false, 'size'=>100));
			$this->addField(array('field'=>'target_waktu', 'show'=>false, 'size'=>100));
			$this->addField(array('field'=>'status_no', 'input'=>'combo', 'combo'=>$this->cbo_status_action, 'size'=>15));
			$this->addField(array('field'=>'rcsa_owner_no', 'input'=>'combo', 'combo'=>$this->cbo_owner, 'show'=>false, 'size'=>10));
			$this->addField(array('field'=>'officer_no', 'input'=>'float', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'progress', 'input'=>'boolean', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'status_action', 'input'=>'boolean', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'name', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'inherent_analisis', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'attc', 'show'=>false, 'size'=>15));
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'rcsa_detail_no');
		if ($this->id_param_owner['privilege_owner']['id']>1)
			$this->set_Where_Table($this->tbl_master,'rcsa_owner_no','in',$this->id_param_owner['owner_child']);	
		
		$this->set_Table_List($this->tbl_master,'event_name');
		$this->set_Table_List($this->tbl_master,'proaktif');
		$this->set_Table_List($this->tbl_master,'reaktif');
		$this->set_Table_List($this->tbl_master,'progress');
		$this->set_Table_List($this->tbl_master,'status_action');
		
		$this->_SET_PRIVILEGE('add',false);
		$this->_SET_PRIVILEGE('delete',false);
		
		$this->_SET_ACTION_WIDTH('size',15);
		$this->_SET_ACTION_WIDTH('align','center');
		$this->_CHANGE_TABLE_MASTER(_TBL_RCSA_ACTION);
		
		$this->set_Close_Setting();
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows){
		$tombol['view']=array();
		$tombol['edit']['label']='Edit Status';

		return $tombol;
	}
	
	function updateBox_DETAIL($fields, $row, $value){
		$o = $this->load->view('title',['data'=>$row, 'sts'=>1], true);
		return $o;
	}
	
	function updateBox_SUB_DETAIL($fields, $row, $value){
		$o = $this->load->view('title',['data'=>$row, 'sts'=>2], true);
		return $o;
	}
	
	function listBox_PROGRESS($row, $value){
		if ($value<=30){ $warna="danger";
		}elseif ($value<=50){ $warna="warning";
		}elseif ($value<=75){ $warna="success";
		}else{
			$warna="primary";
		}
		
		$result = '<div class="progress progress-sl">
					  <div class="progress-bar progress-bar-'.$warna.'" role="progressbar" aria-valuenow="'.$value.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$value.'%;">'.number_format($value).'% Complete
					  </div>
				  </div>';
		
		return $result;
	}
}