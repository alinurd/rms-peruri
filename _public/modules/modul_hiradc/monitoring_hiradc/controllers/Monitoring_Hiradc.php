<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Monitoring_Hiradc extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		$this->cbo_status_action =$this->get_combo('data-combo','status-mitigasi');
		$this->cbo_owner =$this->get_combo('owner');
		
		$this->set_Tbl_Master(_TBL_VIEW_HIRADC_MITIGASI);
		$this->set_Table(_TBL_HIRADC_DETAIL);
		$this->set_Table(_TBL_HIRADC);		
		$this->set_Table(_TBL_OWNER);		
		
		$this->tbl_schedule_type=_TBL_SCHEDULE_TYPE;
		$this->tbl_status_action=_TBL_STATUS_ACTION;
		
		$this->set_Open_Tab('Konteks Risiko');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'hiradc_no', 'show'=>false, 'save'=>false, 'size'=>100));
			$this->addField(array('field'=>'hiradc_detail_no', 'show'=>false, 'size'=>100));
			// $this->addField(array('field'=>'operasional', 'show'=>false, 'size'=>100));
			$this->addField(array('field'=>'sekarang', 'show'=>true, 'size'=>100));
			$this->addField(array('field'=>'mendatang', 'show'=>true, 'size'=>100));
			$this->addField(array('field'=>'pertimbangan', 'show'=>false, 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'progress', 'input'=>'updown', 'show'=>true, 'size'=>75));
			$this->addField(array('field'=>'status_no', 'input'=>'combo', 'combo'=>$this->cbo_status_action, 'size'=>15));
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'hiradc_detail_no','sp'=>$this->tbl_hiradc_detail,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_hiradc_detail,'id_pk'=>'hiradc_no','sp'=>$this->tbl_hiradc,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_hiradc,'id_pk'=>'owner_no','sp'=>$this->tbl_owner,'id_sp'=>'id'));
		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'sekarang', 'readonly'=>true));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'mendatang', 'readonly'=>true));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'progress', 'span_left_addon'=>' %'));
		
		$this->addField(array('nmtbl'=>$this->tbl_hiradc, 'field'=>'corporate', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_owner, 'field'=>'name', 'size'=>20, 'show'=>false));
		
		$this->set_Sort_Table($this->tbl_master,'hiradc_detail_no');
		$this->set_Sort_Table($this->tbl_master,'operasional');
		
		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_owner, 'id');
		
		$this->set_Table_List($this->tbl_hiradc,'corporate');
		$this->set_Table_List($this->tbl_owner,'name');
		// $this->set_Table_List($this->tbl_master,'operasional');
		$this->set_Table_List($this->tbl_master,'sekarang');
		$this->set_Table_List($this->tbl_master,'mendatang');
		$this->set_Table_List($this->tbl_master,'progress');
		$this->set_Table_List($this->tbl_master,'status_no');
		
		$this->_SET_PRIVILEGE('add',false);
		$this->_SET_PRIVILEGE('delete',false);
		
		$this->_SET_ACTION_WIDTH('size',15);
		$this->_SET_ACTION_WIDTH('align','right');
		$this->_CHANGE_TABLE_MASTER(_TBL_HIRADC_MITIGASI);
		$this->set_Close_Setting();
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows){
		$tombol['view']=array();
		$tombol['edit']['label']='Edit Sts';
		$id = $rows['l_hiradc_no'];
		$url=base_url('/progress-hiradc/progress-mitigasi/edit/'.$id);
		$tombol['detail']=array("default"=>false,"url"=>$url,"label"=>"Progress");
		
		return $tombol;
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

	function listBox_STATUS_NOx($row, $value){
		if (array_key_exists($value, $this->cbo_status_action))
			$value = $this->cbo_status_action[$value];
		return $value;
	}
}