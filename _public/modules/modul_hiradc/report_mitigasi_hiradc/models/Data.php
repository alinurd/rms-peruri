<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	var $privilege_owner="";
	public function __construct()
    {
        parent::__construct();
		$this->type_report=3;
		$this->arr_Result=array();
	}

	function get_data_project($param){
		
		$this->db->select('*');
		$this->db->from(_TBL_RCSA);
		$this->db->where('owner_no', intval($param['l_owner_no']));
		$this->db->where('period_no', intval($param['l_periode_no']));
		if (intval($param['l_type_project_no'])<3)
			$this->db->where_in('type', $param['l_type_project_no']);
		
		$sql = $this->db->get();
		$rows=$sql->result();
		$data=array();
		$data[]=" - Select - ";
		foreach($rows as $row){
			$data[$row->id]=$row->corporate;
		}
		return $data;
	}
	
	function get_data_param($id){
		$this->db->select(_TBL_REPORT . '.*,'._TBL_OWNER.'.name as owner_name,'._TBL_PERIOD.'.periode_name');
		$this->db->from(_TBL_REPORT);
		$this->db->join(_TBL_OWNER, _TBL_REPORT . '.owner_no=' . _TBL_OWNER . '.id','left');
		$this->db->join(_TBL_PERIOD, _TBL_REPORT . '.periode_no=' . _TBL_PERIOD . '.id','left');
		$this->db->where(_TBL_REPORT . '.id',$id);
		$this->db->order_by(_TBL_REPORT . '.create_date desc');
		
		$query=$this->db->get();
		$result=$query->result_array();
		foreach($result as &$row){
			$row['param']=json_decode($row['param'],TRUE);
		}
		unset($row);
		if ($result)
			return $result[0];
		else
			return $result;
	}
	
	function save_data($newid=0, $data=array(), $old=array())
	{
		// doi::dump($data);
		$param=array();
		$upd['type'] = 3;
		
		// $param['cut_off']=$data['cut_off'];
		// $param['level_no']=$data['level_no'];
		// $param['level_name']=$data['level_name'];
		// $param['type_no']=$data['type_no'];
		// $param['type_name']=$data['type_name'];
		
		$param['sts_action_plan']=$data['sts_action_plan'];
		$param['sts_progress']=$data['sts_progress'];
		$param['sts_risk_detail']=$data['sts_risk_detail'];
		$param['sts_risk_level']=$data['sts_risk_level'];
		$param['sts_attachment']=$data['sts_attachment'];
		
		$param['title']=$data['title'];
		$param['subtitle']=$data['subtitle'];
		$param['person_name']=$data['person_name'];
		$param['position']=$data['position'];
		
		$upd['param'] = json_encode($param);
		
		$result=$this->crud->crud_data(array('table'=>_TBL_REPORT, 'field'=>$upd,'where'=>array('id'=>$newid),'type'=>'update'));
		
		return $result;
	}

	function get_param($data){
		$this->db->select('*');
		if ($data=='owner'){
			$this->db->from(_TBL_OWNER);
			$this->db->where('status',1);
			$id_param=explode(',',$this->authentication->get_info_user('id_param_level'));
			$sts_param = $this->authentication->get_info_user('sts_param');
			if ($sts_param =="0")
				$this->db->where_in('id',$id_param);
		}elseif ($data=='period'){
			$this->db->from(_TBL_PERIOD);
			$this->db->where('status',1);
		}elseif ($data=='level'){
			$this->db->from(_TBL_LEVEL_COLOR);
		}else{
			$this->db->from(_TBL_RISK_TYPE);
			$this->db->where('status',1);
		}
		
		
		$query=$this->db->get();
		$result=$query->result();
		// die($this->db->last_query());
		return $result;
	}
	
	function get_data_report($data){
		// Doi::dump($data);die();
		
		if($this->id_param_owner){
			$this->privilege_owner = $this->id_param_owner['privilege_owner']['id'];
		}
		
		$this->owner_child=array();
		
		if ($data['owner_no']>0){
			$this->owner_child[]=$data['owner_no'];
		}
		
		if ($data['type_view_no']==2 && $this->privilege_owner<=2 && $data['owner_no']>0){
			$this->get_owner_child($data['owner_no']);
		}
		$owner_child=$this->owner_child;
		
		$field=array();
		$field[]=_TBL_RCSA . '.corporate';
		$field[]='rcsa_action_detail.action_no';
		if ($data['param']['sts_action_plan']==1){$field[]='rcsa_action_detail.description';}
		if ($data['param']['sts_progress']==1){$field[]='rcsa_action_detail.progress';}
		if ($data['param']['sts_risk_detail']==1){$field[]='rcsa_detail.event_no';}
		if ($data['param']['sts_risk_level']==1){$field[]='rcsa_detail.risk_level';}
		if ($data['param']['sts_attachment']==1){$field[]=' rcsa_action_detail.attach';}
		$field[]=' rcsa_action.title';
		$field[]=' rcsa_action_detail.progress_date';
		
		$field=implode(',',$field);
		
		$this->db->select($field);
		$this->db->from(_TBL_RCSA);
		$this->db->join(_TBL_RCSA_DETAIL,_TBL_RCSA_DETAIL.'.rcsa_no='._TBL_RCSA.'.id');
		$this->db->join(_TBL_LEVEL_COLOR,_TBL_RCSA_DETAIL.'.risk_level='._TBL_LEVEL_COLOR.'.id','left');
		$this->db->join(_TBL_RCSA_ACTION,_TBL_RCSA_ACTION.'.rcsa_detail_no='._TBL_RCSA_DETAIL.'.id');
		$this->db->join(_TBL_RCSA_ACTION_DETAIL,_TBL_RCSA_ACTION_DETAIL.'.action_no='._TBL_RCSA_ACTION.'.id','left');
		
		if (is_array($data['param'])){
			if (array_key_exists('owner_no',$data)){
				if ($data['type_view_no']==3)
					$this->db->where(_TBL_RCSA.'.owner_no',$data['owner_no']);
				elseif ($data['type_view_no']==2)
					$this->db->where_in(_TBL_RCSA.'.owner_no',$owner_child);
				
			}
			if ($data['periode_no']>0){
				$this->db->where(_TBL_RCSA.'.period_no',$data['periode_no']);
			}
			if ($data['type_project_no']>0){
				if (intval($data['type_project_no'])<3)
					$this->db->where(_TBL_RCSA.'.type',$data['type_project_no']);
			}
		}
		$this->db->order_by(_TBL_LEVEL_COLOR.'.score', 'desc');
		$this->db->order_by(_TBL_RCSA.'.id');
		
		$query=$this->db->get();
		$result=$query->result_array();
		foreach($result as &$row){
			$event=array($row['event_no']);
			$row['event_no']=$this->cari_library($event);
			$row['risk_level']=$this->cari_level($row['risk_level']);
		}
		unset($row);
		// Doi::dump($result);
		// die();
		return $result;
	}
	
	function cari_level($id){
		$result='';
		$this->db->select(_TBL_LEVEL_MAPPING.'.*');
		$this->db->from(_TBL_LEVEL_COLOR);
		$this->db->join(_TBL_LEVEL_MAPPING,_TBL_LEVEL_COLOR.'.level_risk_no='._TBL_LEVEL_MAPPING.'.id');
		$this->db->where(_TBL_LEVEL_COLOR.'.id',$id);
		
		$query=$this->db->get();
		$sql=$query->result_array();
		if ($sql)
			$result = $sql[0];
		else
			$result = $sql;
		return $result;
	}
	
	function cari_library($source){
		$result=array();
		if (count($source)>0 && !is_null($source)){
			foreach($source as $row){
				$this->db->select('*');
				$this->db->from(_TBL_LIBRARY);
				$this->db->where('id',$row);
				
				$query=$this->db->get();
				$sql=$query->result_array();
				foreach($sql as $r){
					$result[]=array('id'=>$r['id'],'code'=>$r['code'],'name'=>$r['description']);
				}
			}
		}
		return $result;
	}
	
	function cari_data($source, $tbl){
		$result=array();
		if (count($source)>0 && !is_null($source)){
			foreach($source as $row){
				$this->db->select('*');
				$this->db->from($tbl);
				$this->db->where('id',$row);
				
				$query=$this->db->get();
				$sql=$query->result_array();
				$result[]=$sql;
			}
		}
		// doi::dump($source);
		return $result;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */