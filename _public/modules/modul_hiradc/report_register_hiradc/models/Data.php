<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	var $privilege_owner=array();
	public function __construct()
    {
        parent::__construct();
		$this->type_report=2;
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
		if ($result)
			return $result[0];
		else
			return $result;
	}
	
	function save_data($newid=0, $data=array(), $old=array())
	{
		// doi::dump($data,false, true);
		$param=array();
		$upd['type'] = 2;
		$param['sts_risk_event']=$data['sts_risk_event'];
		$param['risk_event']=$data['risk_event'];
		$param['sts_risk_couse']=$data['sts_risk_couse'];
		$param['risk_couse']=$data['risk_couse'];
		$param['sts_risk_impact']=$data['sts_risk_impact'];
		$param['risk_impact']=$data['risk_impact'];
		$param['sts_nilai_dampak']=$data['sts_nilai_dampak'];
		$param['nilai_dampak']=$data['nilai_dampak'];
		$param['sts_risk_type']=$data['sts_risk_type'];
		$param['risk_type']=$data['risk_type'];
		$param['sts_risk_owner']=$data['sts_risk_owner'];
		$param['risk_owner']=$data['risk_owner'];
		$param['sts_risk_level']=$data['sts_risk_level'];
		$param['risk_level']=$data['risk_level'];
		$param['sts_risk_controls']=$data['sts_risk_controls'];
		$param['risk_controls']=$data['risk_controls'];
		$param['sts_residual_risk_level']=$data['sts_residual_risk_level'];
		$param['residual_risk_level']=$data['residual_risk_level'];
		$param['sts_action']=$data['sts_action'];
		$param['action']=$data['action'];
		$param['sts_progress']=$data['sts_progress'];
		$param['progress']=$data['progress'];
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
			$id_param=explode(',',$this->authentication->get_info_user('id_param_level'));
			$sts_param = $this->authentication->get_info_user('sts_param');
			if ($sts_param =="0")
				$this->db->where_in('id',$id_param);
		}else{
			$this->db->from(_TBL_PERIOD);
		}
		$this->db->where('status',1);
		
		$query=$this->db->get();
		$result=$query->result();
		return $result;
	}
	
	function get_data_report($param){
		
		if ($param['sts_risk_event']==1){$field[]='risk_rcsa_detail.event_no';}
		if ($param['sts_risk_couse']==1){$field[]='risk_rcsa_detail.risk_couse_no';}
		if ($param['sts_risk_impact']==1){$field[]='risk_rcsa_detail.risk_impact_no';}
		if ($param['sts_nilai_dampak']==1){$field[]='risk_rcsa_detail.nilai_dampak';}
		if ($param['sts_risk_type']==1){$field[]='risk_rcsa_detail.risk_type_no';}
		if ($param['sts_risk_owner']==1){$field[]='risk_rcsa_detail.owner_no';}
		if ($param['sts_risk_controls']==1){$field[]='risk_rcsa_detail.control_no';}
		if ($param['sts_risk_level']==1){$field[]='risk_rcsa_detail.risk_level';}
		if ($param['sts_residual_risk_level']==1){$field[]='risk_rcsa_detail.inherent_level';}
		if ($param['sts_action']==1){$field[]='risk_rcsa_action.title';}
		if ($param['sts_progress']==1){$field[]=' risk_rcsa_action.progress';}
		
		$field=implode(',',$field);
		$this->db->select($field);
		$this->db->from(_TBL_RCSA);
		$this->db->join(_TBL_RCSA_DETAIL,_TBL_RCSA_DETAIL.'.rcsa_no='._TBL_RCSA.'.id');
		$this->db->join(_TBL_RCSA_ACTION,_TBL_RCSA_ACTION.'.rcsa_detail_no='._TBL_RCSA_DETAIL.'.id');
		
		if (is_array($param)){
			if (array_key_exists('owner_no',$param)){
				$this->db->where(_TBL_RCSA.'.owner_no',$param['owner_no']);
			}
			if (array_key_exists('period_no',$param)){
				$this->db->where(_TBL_RCSA.'.period_no',$param['period_no']);
			}
		}
		
		$query=$this->db->get();
		$result=$query->result_array();
		// die($this->db->last_query());die();
		foreach($result as &$row){
			$course=json_decode($row['risk_couse_no'],true);
			$impact=json_decode($row['risk_impact_no'],true);
			$owner=json_decode($row['owner_no'],true);
			$type=json_decode($row['risk_type_no'],true);
			
			$event=array($row['event_no']);
			$row['event_no']=$this->cari_library($event);
			$row['owner_no']=$this->cari_data($owner,_TBL_OWNER);
			$row['risk_type_no']=$this->cari_data($type,_TBL_RISK_TYPE);
			$row['risk_couse_no']=$this->cari_library($course);
			$row['risk_impact_no']=$this->cari_library($impact);
			if (isset($row['inherent_level']))
				$row['inherent_level']=$this->cari_level($row['inherent_level']);
			else
				$row['inherent_level']="";
			if (isset($row['risk_level']))
				$row['risk_level']=$this->cari_level($row['risk_level']);
			else
				$row['risk_level']="";
		}
		return $result;
	}
	
	function cari_level($id){
		$result='';
		$this->db->select(_TBL_LEVEL_MAPPING.'.level_mapping');
		$this->db->from(_TBL_LEVEL_COLOR);
		$this->db->join(_TBL_LEVEL_MAPPING,_TBL_LEVEL_COLOR.'.level_risk_no='._TBL_LEVEL_MAPPING.'.id');
		$this->db->where(_TBL_LEVEL_COLOR.'.id',$id);
		
		$query=$this->db->get();
		$sql=$query->result_array();
		foreach($sql as $r){
			$result=$r['level_mapping'];
		}
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
	
	function get_data($id=0){
		$this->db->select(_TBL_RCSA.'.*,'._TBL_OWNER.'.name as name_owner');
		$this->db->from(_TBL_RCSA);
		$this->db->join(_TBL_OWNER, _TBL_RCSA.'.owner_no='._TBL_OWNER.'.id');
		$this->db->where(_TBL_RCSA.'.id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		if(count($result)>0)
			return $result[0];
		else
			return $result;
	}
	
	function get_data_risk_register($id){
		
		$this->db->select(_TBL_REPORT . '.*,'._TBL_OWNER.'.name as owner_name,'._TBL_PERIOD.'.periode_name');
		$this->db->from(_TBL_REPORT);
		$this->db->join(_TBL_OWNER, _TBL_REPORT . '.owner_no=' . _TBL_OWNER . '.id','left');
		$this->db->join(_TBL_PERIOD, _TBL_REPORT . '.periode_no=' . _TBL_PERIOD . '.id','left');
		$this->db->where(_TBL_REPORT . '.id',$id);
		$this->db->order_by(_TBL_REPORT . '.create_date desc');
		
		$query=$this->db->get();
		$param=$query->result_array();
		$id_rcsa=0;
		foreach ($param as &$row){
			$row['param']=json_decode($row['param'],TRUE);
			$id_rcsa=intval($row['rcsa_no']);
			$id_owner=intval($row['owner_no']);
		}
		unset($row);
		
		if($this->id_param_owner){
			$this->privilege_owner = $this->id_param_owner['privilege_owner']['id'];
		}
		
		$this->owner_child=array();
		
		if ($id_owner>0){
			$this->owner_child[]=$id_owner;
		}
		
		if ($param[0]['type_view_no']==2 && $this->privilege_owner<=2 && $id_owner>0){
			$this->get_owner_child($id_owner);
		}
		$owner_child=$this->owner_child;
				
		$detail=array();
		$this->db->select('*');
		$this->db->from(_TBL_LEVEL);
		$query = $this->db->get();
		$rows = $query->result_array();
		foreach($rows as $row){
			$detail[$row['id']]=$row['score'].'#'.$row['code'].'-'.$row['level'];
		}
		
		$risk_owner=array();
		$this->db->select('*');
		$this->db->from(_TBL_OWNER);
		$query = $this->db->get();
		$rows = $query->result_array();
		foreach($rows as $row){
			$risk_owner[$row['id']]=$row['name'];
		}
		
		$library=array();
		$this->db->select('*');
		$this->db->from(_TBL_LIBRARY);
		$query = $this->db->get();
		$rows = $query->result_array();
		foreach($rows as $row){
			$library[$row['id']]=$row['description'];
		}
		
		$this->db->select(_TBL_RCSA_ACTION.'.*');
		$this->db->from(_TBL_RCSA_ACTION);
		$this->db->join(_TBL_RCSA_DETAIL, _TBL_RCSA_ACTION.'.rcsa_detail_no='._TBL_RCSA_DETAIL.'.id');
		$this->db->join(_TBL_RCSA, _TBL_RCSA_DETAIL.'.rcsa_no='._TBL_RCSA.'.id');
		if ($param[0]['type_view_no']==3)
			$this->db->where(_TBL_RCSA_DETAIL.'.rcsa_no',$id_rcsa);
		elseif ($param[0]['type_view_no']==2)
			$this->db->where_in(_TBL_RCSA.'.owner_no',$owner_child);
		
		if ($param[0]['periode_no']>0){
			$this->db->where(_TBL_RCSA.'.period_no',$param[0]['periode_no']);
		}
		if ($param[0]['type_project_no']>0){
			if (intval($param[0]['type_project_no'])<3)
				$this->db->where(_TBL_RCSA.'.type',$param[0]['type_project_no']);
		}
			
		$this->db->order_by(_TBL_RCSA_ACTION.'.rcsa_detail_no');
		$query=$this->db->get();
		$rows=$query->result_array();
		$arr_action=array();
		foreach ($rows as $row){
			$owner_no=json_decode($row['owner_no']);
			$arr_owner=array();
			foreach ($owner_no as $xx){
				if (array_key_exists($xx, $risk_owner))
					$arr_owner[]=$risk_owner[$xx];
			}
			$arr_action[$row['rcsa_detail_no']][]=array('title'=>$row['title'], 'target_waktu'=>$row['target_waktu'], 'owner_no'=>implode(', ', $arr_owner));
		}
		
		$this->db->select(_TBL_RCSA_DETAIL.'.*, ' . _TBL_LIBRARY . '.description, '. _TBL_LIBRARY . '.risk_type_no, '._TBL_RCSA.'.corporate');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->join(_TBL_RCSA, _TBL_RCSA_DETAIL.'.rcsa_no='._TBL_RCSA.'.id');
		$this->db->join(_TBL_LIBRARY, _TBL_RCSA_DETAIL.'.event_no='._TBL_LIBRARY.'.id');
		$this->db->join(_TBL_RISK_TYPE,_TBL_LIBRARY.'.risk_type_no='._TBL_RISK_TYPE.'.id');
		if ($param[0]['type_view_no']==3)
			$this->db->where(_TBL_RCSA_DETAIL.'.rcsa_no',$id_rcsa);
		elseif ($param[0]['type_view_no']==2)
			$this->db->where_in(_TBL_RCSA.'.owner_no',$owner_child);
		
		if ($param[0]['periode_no']>0){
			$this->db->where(_TBL_RCSA.'.period_no',$param[0]['periode_no']);
		}
		if ($param[0]['type_project_no']>0){
			if (intval($param[0]['type_project_no'])<3)
				$this->db->where(_TBL_RCSA.'.type',$param[0]['type_project_no']);
		}
		
		$this->db->order_by(_TBL_RCSA_DETAIL.'.rcsa_no');
		$this->db->order_by(_TBL_LIBRARY.'.id');
		$query=$this->db->get();
		
		$rows=$query->result();
		$arr_risk_event=array();
		foreach ($rows as $row){
			// $arr_risk_event[$row->risk_type_no]['corporate'][]=$row->corporate;
			$arr_risk_event[$row->risk_type_no]['risk_event'][]=array('id'=>$row->id,'description'=>$row->description);
			$risk_couse=json_decode($row->risk_couse_no);
			$result="";
			if (is_array($risk_couse)){
				$arr_couse=array();
				foreach($risk_couse as $rc){
					if (array_key_exists($rc, $library)){
						$arr_couse[]=$library[$rc];
					}
				}
				$result=implode('<br>', $arr_couse);
			}
			$arr_risk_event[$row->risk_type_no]['risk_couse'][]=$result;
			
			$result="";
			$risk_impact=json_decode($row->risk_impact_no);
			if (is_array($risk_impact)){
				$arr_impact=array();
				foreach($risk_impact as $rc){
					if (array_key_exists($rc, $library)){
						$arr_impact[]=$library[$rc];
					}
				}
				$result=implode('<br>', $arr_impact);
			}
			$arr_risk_event[$row->risk_type_no]['risk_impact'][]=$result;
			
			
			$arr_risk_event[$row->risk_type_no]['nilai_dampak'][]=$row->nilai_dampak;
			
			if (!empty($row->inherent_likelihood))
				$arr_risk_event[$row->risk_type_no]['inherent_likelihood'][]=$detail[$row->inherent_likelihood];
			else
				$arr_risk_event[$row->risk_type_no]['inherent_likelihood'][]=0;
			
			if (!empty($row->inherent_impact))
				$arr_risk_event[$row->risk_type_no]['inherent_impact'][]=$detail[$row->inherent_impact];
			else
				$arr_risk_event[$row->risk_type_no]['inherent_impact'][]=0;
			
			if (array_key_exists($row->id, $arr_action))
				$arr_risk_event[$row->risk_type_no]['action'][$row->id]=$arr_action[$row->id];
			else
				$arr_risk_event[$row->risk_type_no]['action'][$row->id]=array();
			
			
		}
		
		$this->db->select(_TBL_RCSA_DETAIL.'.rcsa_no,'. _TBL_RCSA.'.corporate,'. _TBL_LIBRARY.'.risk_type_no, '._TBL_RISK_TYPE.'.type');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->join(_TBL_RCSA,_TBL_RCSA_DETAIL.'.rcsa_no='._TBL_RCSA.'.id');
		$this->db->join(_TBL_LIBRARY,_TBL_RCSA_DETAIL.'.event_no='._TBL_LIBRARY.'.id');
		$this->db->join(_TBL_RISK_TYPE,_TBL_LIBRARY.'.risk_type_no='._TBL_RISK_TYPE.'.id');
		if ($param[0]['type_view_no']==3)
			$this->db->where(_TBL_RCSA_DETAIL.'.rcsa_no',$id_rcsa);
		elseif ($param[0]['type_view_no']==2)
			$this->db->where_in(_TBL_RCSA.'.owner_no',$owner_child);
		
		if ($param[0]['periode_no']>0){
			$this->db->where(_TBL_RCSA.'.period_no',$param[0]['periode_no']);
		}
		if ($param[0]['type_project_no']>0){
			if (intval($param[0]['type_project_no'])<3)
				$this->db->where(_TBL_RCSA.'.type',$param[0]['type_project_no']);
		}
		
		$this->db->group_by(array(_TBL_RCSA_DETAIL.'.rcsa_no', _TBL_LIBRARY.'.risk_type_no',_TBL_RISK_TYPE.'.type'));
		$query=$this->db->get();
		// echo $this->db->last_query();
		$rows=$query->result();
		foreach ($rows as &$row){
			// $row['detail']=$this->cari_detail_risk_register($row['risk_type_no']);
			$row->detail=$arr_risk_event[$row->risk_type_no];
			
		}		
		unset($row);
		// Doi::dump($param);die();
		$result=array();
		$result['param']=$param[0];
		$result['data']=$rows;
		$result['id_rcsa']=$id_rcsa;
		
		return $result;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */