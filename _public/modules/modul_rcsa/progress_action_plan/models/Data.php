<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	var $nm_tbl='';
	var $nm_tbl_user='';
	var $_prefix='';
	var $_modules='';
	public function __construct()
    {
        parent::__construct();
		// _TBL_RCSA="rcsa";
		// _TBL_OWNER="owner";
		// $this->_TBL_RISK_TYPE="risk_risk_type";
		// _TBL_PERIOD="period";
		// _TBL_LIBRARY="library";
		// _TBL_RCSA_DETAIL="rcsa_detail";
		// _TBL_RCSA_level="rcsa_level";
		// $this->bl_rcsa_action="rcsa_action";
		// _TBL_RCSA_ACTION_DETAIL="rcsa_action_detail";
		// _TBL_LEVEL_COLOR="level_color";
		// _TBL_EXISTING_CONTROL="existing_control";
		// _TBL_SCHEDULE_TYPE="schedule_type";
		
	}
	
	function get_tahun_progress(){
		$this->db->select('year(progress_date) as tahun');
		$this->db->from(_TBL_RCSA_ACTION_DETAIL);
		$this->db->distinct();
		$this->db->order_by('year(progress_date)');
		$query = $this->db->get();
		
		$rows=$query->result();
		$arr=array();
		$arr[0]=' - All Year - ';
		foreach($rows as $row){
			$arr[$row->tahun] = $row->tahun;
		}
		return $arr;
	}
	
	function get_bulan_progress(){
		$this->db->select('month(progress_date) as bulan');
		$this->db->from(_TBL_RCSA_ACTION_DETAIL);
		$this->db->distinct();
		$this->db->order_by('month(progress_date)');
		$query = $this->db->get();
		
		$rows=$query->result();
		$arr=array();
		$arr[0]=' - All Month  - ';
		foreach($rows as $row){
			$arr[$row->bulan] = date("F", strtotime(date("Y") ."-". $row->bulan ."-01"));
		}
		return $arr;
	}
	// function get_master_level(){
		// $query = $this->db
				// ->select(_TBL_LEVEL_MAPPING.'.*,'._TBL_LEVEL_COLOR.'.id as id_color,'._TBL_LEVEL_COLOR.'.likelihood,'._TBL_LEVEL_COLOR.'.impact')
				// ->from(_TBL_LEVEL_COLOR)
				// ->join(_TBL_LEVEL_MAPPING, _TBL_LEVEL_COLOR.'.level_risk_no = ' . _TBL_LEVEL_MAPPING . '.id')
				// ->get();
		// $rows=json_encode($query->result_array());
		// // var_dump($rows);die();
		// return $rows;
	// }
	
	function get_id_rcsa_detail($id){
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_ACTION_DETAIL);
		$this->db->where_in('id', $id);
		$this->db->order_by('action_no');
		$query = $this->db->get();
		$rows=$query->result_array();
		$result=array();
		foreach($rows as $row){
			$result[$row['id']]=$row['action_no'];
		}
		return $result;
	}
	
	function get_detail_action($id){
		$this->db->select('action_no, count(id) as jml');
		$this->db->from(_TBL_RCSA_ACTION_DETAIL);
		$this->db->group_by('action_no');
		$this->db->where_in('action_no', $id);
		$this->db->order_by('action_no');
		$query = $this->db->get();
		$rows=$query->result_array();
		$result=array();
		foreach($rows as $row){
			$result[$row['action_no']]=$row['jml'];
		}
		return $result;
	}
	
	function get_rcsa_detail_id($id){
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_ACTION);
		$this->db->where('id', $id);
		$query = $this->db->get();
		$row=$query->row();
		$result=0;
		if ($row){
			$result = $row->rcsa_detail_no;
		}
		return $result;
	}
	function get_rcsa_id($id){
		$this->db->select(_TBL_RCSA . '.*');
		$this->db->from(_TBL_RCSA);
		$this->db->where('id', $id);
		$query = $this->db->get();
		$row=$query->row();
		$result=array();
		if ($row){
			$result['rcsa_no'] = $row->id;
			$result['owner_no'] = $row->owner_no;
			$result['period_no'] = $row->period_no;
		}
		// doi::dump($this->db->last_query());
		return $result;
	}
	
	function get_data_action($id){
		// $sql=$this->db->where('id', $id)
				// ->get(_TBL_RCSA_ACTION_DETAIL);
		// $rows=$sql->row();
		// $id_action = $rows->action_no;
		
		$sql=$this->db
				->select('*')
				->from(_TBL_OWNER)
				->get();
		$rows=$sql->result();
		$arr_owner=array();
		foreach($rows as $row){
			$arr_owner[$row->id] = $row->name;
		}
		
		$result= $this->db->where('id', $id)->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
		foreach($result as &$row){
			$owner_name='';
			$owner_no=json_decode($row['owner_no']);
			foreach ($owner_no as $on){
				$owner_name .= "- " . $arr_owner[$on];
			}
			$row['name']=$owner_name;
		}
		unset($row);
		return $result;
	}
	
	function get_tree_list($param){
		$this->db->select(_TBL_RCSA.'.*,'._TBL_PERIOD.'.periode_name,'._TBL_OWNER.'.name');
		$this->db->from(_TBL_RCSA);
		$this->db->join(_TBL_PERIOD, _TBL_RCSA.'.period_no='._TBL_PERIOD.'.id');
		$this->db->join(_TBL_OWNER, _TBL_RCSA.'.owner_no='._TBL_OWNER.'.id');
		
		if ($param>0){
			$this->db->where(_TBL_RCSA.'.id',$param);
		}
		
		$query=$this->db->get();
		$result=$query->result_array();
		
		foreach($result as &$row){
			$row['detail']=$this->get_risk_action($row['id']);
		}
		
		return $result;
	}
	
	function get_risk_action($id){
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->where('rcsa_no',$id);
		
		$result=array();
		$query=$this->db->get();
		$rows=$query->result_array();
		foreach($rows as $row){
			$this->db->select('*');
			$this->db->from(_TBL_RCSA_ACTION);
			$this->db->where('rcsa_detail_no',$row['id']);
			
			$query_action=$this->db->get();
			$rows_action=$query_action->result_array();
			foreach($rows_action as $action){
				$result[]=array('id_detail'=>$row['rcsa_no'],'id'=>$action['id'], 'title'=>$action['title'], 'proaktif'=>$action['proaktif'], 'reaktif'=>$action['reaktif']);
			}
		}
		return $result;
	}
	
	function get_data_event_detail($id){
		
		$query = $this->db
				->select(_TBL_LEVEL_MAPPING.'.*,'._TBL_LEVEL_COLOR.'.id as id_color')
				->from(_TBL_LEVEL_COLOR)
				->join(_TBL_LEVEL_MAPPING, _TBL_LEVEL_COLOR.'.level_risk_no = ' . _TBL_LEVEL_MAPPING . '.id')
				->get();
		$arr=$query->result_array();
		$arr_level=array();
		foreach($arr as $row){
			$arr_level[$row['id_color']]=$row;
		}
		// Doi::dump($arr);
		
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->where('id',$id);
			
		$query=$this->db->get();
		$result=$query->result_array();
		
		// Doi::dump($result);die();
		foreach($result as &$row){
			$course=json_decode($row['risk_couse_no'],true);
			$impact=json_decode($row['risk_impact_no'],true);
			$attach=json_decode($row['attach'],true);
			$owner=json_decode($row['owner_no'],true);
			$type=json_decode($row['risk_type_no'],true);
			
			$event=array($row['event_no']);
			$row['event_no']=$this->cari_library($event);
			$row['owner_no']=$this->cari_data($owner,_TBL_OWNER);
			$row['risk_type_no']=$this->cari_data($type, _TBL_RISK_TYPE);
			// die();
			$row['risk_couse_no']=$this->cari_library($course);
			$row['risk_impact_no']=$this->cari_library($impact);
			$row['attach']=$attach;

			$row['residual_likelihood_id'] = $row['residual_likelihood'];
			$row['residual_impact_id'] = $row['residual_impact'];
			
			$row['control_no']=json_decode($row['control_no'],true);
			$row['inherent_likelihood']=$this->cari_data_level($row['inherent_likelihood']);
			$row['inherent_impact']=$this->cari_data_level($row['inherent_impact']);
			$row['residual_likelihood']=$this->cari_data_level($row['residual_likelihood']);
			$row['residual_impact']=$this->cari_data_level($row['residual_impact']);
			
			
			$row['level_inherent']=array('level_mapping'=>'-','color'=>'#fff');
			if(array_key_exists($row['inherent_level'], $arr_level))
				$row['level_inherent']=$arr_level[$row['inherent_level']];
			
			$row['level_residual']=array('level_mapping'=>'-','color'=>'#fff');
			if(array_key_exists($row['risk_level'], $arr_level))
				$row['level_residual']=$arr_level[$row['risk_level']];
		}
		unset($row);
		
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
		if (is_array($source)){
			if (count($source)>0 && !is_null($source) && is_array($source)){
				// doi::dump($source);
				foreach($source as $row){
					$this->db->select('*');
					$this->db->from($tbl);
					$this->db->where('id',$row);
					
					$query=$this->db->get();
					$sql=$query->result_array();
					$result[]=$sql;
				}
			}
		}
		return $result;
	}
	
	function cari_data_level($source){
		$this->db->select('*');
		$this->db->from(_TBL_LEVEL);
		$this->db->where('id',$source);
		
		$query=$this->db->get();
		$sql=$query->result_array();
		$result="";
		foreach($sql as $row){
			$result=$row['level'];
		}
		// doi::dump($result,false,true);
		return $result;
	}

	
	function get_rist_level_controls(){
		$this->db->select('*');
		$this->db->from(_TBL_EXISTING_CONTROL);
		$this->db->where('status',1);
		
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}
	
	function get_progress_action($id){
		// $sql=$this->db->where('id', $id)
				// ->get(_TBL_RCSA_ACTION_DETAIL);
		// $rows=$sql->row();
		// $id_action = $rows->action_no;
		
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_ACTION_DETAIL);
		$this->db->where('action_no',$id);
		
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}
	
	function save_action_detail($data){
		// doi::dump($data, false, true);
		$upd=array();
		$upd['action_no']=$data['id_action'];
		$upd['progress_date']=date('Y-m-d',strtotime($data['action_date']));
		$upd['description']=$data['description'];
		$upd['progress']=$data['progress'];
		$upd['notes']=$data['notes'];
		$upd['status_no']=$data['status_no'];
		
		$arra_upload=array();
		$files = $_FILES;
		$cpt = count($_FILES['attac']['name']);
		$path=upload_path_relative().'action/';
		for($i=0; $i<$cpt; $i++)
		{
			$_FILES['userfile']['name']= $files['attac']['name'][$i];
			$_FILES['userfile']['type']= $files['attac']['type'][$i];
			$_FILES['userfile']['tmp_name']= $files['attac']['tmp_name'][$i];
			$_FILES['userfile']['error']= $files['attac']['error'][$i];
			$_FILES['userfile']['size']= $files['attac']['size'][$i]; 
			
			$upload=upload_image('userfile',$data,$path,'',false);
			$arra_upload[]=array('real_name'=>$files['attac']['name'][$i],'name'=>$upload['file_name']);
		}
		if (isset($data['attach_no']))
		{
			foreach($data['attach_no'] as $row){
				// Doi::dump($row);
				$x=explode('###',$row);
				if (count($x)>1)
					$arra_upload[]=array('name'=>$x[0],'real_name'=>$x[1]);
			}
		}
		
		if(count($arra_upload)>0)
			$upd['attach']=json_encode($arra_upload);
		
		if (intval($data['id_action_detail'])>0){
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$upd['update_date'] = Doi::now();
			$where['id']=$data['id_action_detail'];
			$this->db->update(_TBL_RCSA_ACTION_DETAIL, $upd,$where);
			$id=intval($data['id_action_detail']);
			$type="edit";
		}else{
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$this->db->insert(_TBL_RCSA_ACTION_DETAIL, $upd);
			$id=$this->db->insert_id();
			$type="add";
		}
		
		$upd_action['progress']=$data['progress'];
		$upd_action['status_no']=$data['status_no'];
		$where['id']=$data['id_action'];
		$this->db->update(_TBL_RCSA_ACTION, $upd_action,$where);
		
		$upd_action=[];
		$upd_action['residual_likelihood']=$data['residual_likelihood'];
		$upd_action['residual_impact']=$data['residual_impact'];
		$where['id']=$data['id_rcsa_detail'];
		$this->db->update(_TBL_RCSA_DETAIL, $upd_action,$where);
		// Doi::dump($upd_action);
		// Doi::dump($where);
		// die();
		return $id;
	}
	
	function get_data_action_detail($data){
		$this->db->select('*');
		$this->db->from(_TBL_VIEW_RCSA_ACTION_DETAIL);
		$this->db->where('id',$data['id']);
		
		$query=$this->db->get();
		$result=$query->row_array();
		
		if ($result){
			$attach=json_decode($result['attach'],true);
			$result['attach']=$attach;
		}
		
		return $result;
	}
	
	function delete_action($id){
		$this->db->where('id', $id);
		$this->db->delete(_TBL_RCSA_ACTION_DETAIL);
		$jml=$this->db->affected_rows();
		return $jml;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */