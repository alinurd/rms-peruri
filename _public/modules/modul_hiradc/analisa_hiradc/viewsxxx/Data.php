<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function cari_total_dipakai($id){
		$this->db->where('rcsa_no', $id);
		$num_rows = $this->db->count_all_results(_TBL_RCSA_DETAIL);
		$hasil['jml']=$num_rows;
		
		$sql=$this->db
				->select('*')
				->from(_TBL_RCSA)
				->where('id', $id)
				->get();
		
		$rows=$sql->row();
		$hasil['nama'] = $rows->corporate;
		return $hasil;
	}
	
	function get_combo_inpact($data){
		$nil_dampak= floatval(str_replace(',','',$data['nil_dampak']));
		$this->db->where('id',$data['rcsa_no']);
		$query = $this->db->get(_TBL_RCSA);
		$rows=$query->row();
		$target_laba=0;
		if ($rows){
			$target_laba = $rows->target_laba;
		}
		
		$this->db->where('category','impact');
		$this->db->order_by('bottom_value');
		$query = $this->db->get(_TBL_LEVEL);
		$rows=$query->result();
		
		$hasil=0;
		$jml_mak=count($rows)-1;
		foreach($rows as $key=>$row)
		{
			$awal=(intval($row->bottom_value)/100) * $target_laba;
			$akhir=(intval($row->upper_value)/100) * $target_laba;
			
			if ($nil_dampak<=$akhir){
				$hasil=$row->id;
				break;
			}
			if ($key==$jml_mak){
				$hasil=$row->id;
				break;
			}
				
		}
		return $hasil;
	}
	
	function get_rcsa($param){
		$sql= $this->db
			  ->select('*')
			  ->from(_TBL_RCSA)
			  ->get();
		$rows=$sql->result();
		$data=array();
		$data[]=array('value'=>0,'text'=>" - Select - ");
		foreach($rows as $row){
			$data[]=array('value'=>$row->id,'text'=>$row->corporate);
		}
		$result['options']=$data;
		return $result;
	}
	
	function get_data_risk_register($id){
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
		
		$this->db->select(_TBL_RCSA_action.'.*');
		$this->db->from(_TBL_RCSA_action);
		$this->db->join(_TBL_RCSA_DETAIL, _TBL_RCSA_action.'.rcsa_detail_no='._TBL_RCSA_DETAIL.'.id');
		$this->db->where(_TBL_RCSA_DETAIL.'.rcsa_no',$id);
		$this->db->order_by(_TBL_RCSA_action.'.rcsa_detail_no');
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
		
		$this->db->select(_TBL_RCSA_DETAIL.'.*, ' . _TBL_LIBRARY . '.description, '. _TBL_LIBRARY . '.risk_type_no');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->join(_TBL_LIBRARY, _TBL_RCSA_DETAIL.'.event_no='._TBL_LIBRARY.'.id');
		$this->db->join($this->tbl_risk_type,_TBL_LIBRARY.'.risk_type_no='.$this->tbl_risk_type.'.id');
		$this->db->where(_TBL_RCSA_DETAIL.'.rcsa_no',$id);
		$this->db->order_by(_TBL_LIBRARY.'.id');
		$query=$this->db->get();
		$rows=$query->result();
		$arr_risk_event=array();
		foreach ($rows as $row){
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
		
		$this->db->select(_TBL_LIBRARY.'.risk_type_no, '.$this->tbl_risk_type.'.type');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->join(_TBL_LIBRARY,_TBL_RCSA_DETAIL.'.event_no='._TBL_LIBRARY.'.id');
		$this->db->join($this->tbl_risk_type,_TBL_LIBRARY.'.risk_type_no='.$this->tbl_risk_type.'.id');
		$this->db->where(_TBL_RCSA_DETAIL.'.rcsa_no',$id);
		$this->db->group_by(array('risk_type_no','type'));
		$query=$this->db->get();
		$rows=$query->result();
		foreach ($rows as &$row){
			// $row['detail']=$this->cari_detail_risk_register($row['risk_type_no']);
			$row->detail=$arr_risk_event[$row->risk_type_no];
			
		}		
		unset($row);
		return $rows;
	}
	
	function cari_detail_risk_register($id){
		
	}
	
	function save_param($newid=0,$data=array(), $old=array())
	{
		$upd['param_initial'] = $data['param_initial'];
		$upd['param_copy_risk'] = 0;
		$upd['param_copy_risk_level'] = 0;
		$upd['param_copy_action_info'] = 0;
		$upd['param_copy_action_sched'] = 0;
		$upd['param_risk_owner_no'] = 0;
		$upd['param_copy_period'] = 0;
		$upd['param_type_copy'] = 0;
		$upd['param_period_no'] = 0;
		
		if (intval($data['param_initial'])==2){
			$upd['param_period_no'] = $data['param_period_no'];
		}elseif (intval($data['param_initial'])==3){
			$upd['param_risk_owner_no'] = $data['param_risk_owner_no'];
			$upd['param_copy_period'] = $data['param_copy_period'];
			$upd['param_type_copy'] = $data['param_type_copy'];
			if (intval($data['param_type_copy'])==2){
				$upd['param_copy_risk'] = $data['param_copy_risk'];
				$upd['param_copy_risk_level'] = $data['param_copy_risk_level'];
				$upd['param_copy_action_info'] = $data['param_copy_action_info'];
				$upd['param_copy_action_sched'] = $data['param_copy_action_sched'];
			}
		}
		
		$result=$this->crud->crud_data(array('table'=>_TBL_RCSA, 'field'=>$upd,'where'=>array('id'=>$newid),'type'=>'update'));
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
	
	function get_data_owner(){
		$this->db->select('*');
		$this->db->from(_TBL_OWNER);
		$id_param=explode(',',$this->authentication->get_info_user('id_param_level'));
		$sts_param = $this->authentication->get_info_user('sts_param');
			if ($sts_param =="0")
				$this->db->where_in('id',$id_param);
		
		$query=$this->db->get();
		$result=$query->result();
		return $result;
	}
	
	function get_data_event($tipe, $parent=0){
		$this->db->where('id',$parent);
		$sql = $this->db->get(_TBL_LIBRARY);
		$result['title'] = $sql->row(); 
		// Doi::dump($result['title']);die();
		if ($tipe==1){
			$this->db->select(_TBL_LIBRARY.'.*, '.$this->tbl_risk_type.'.type');
			$this->db->from(_TBL_LIBRARY);
			$this->db->join($this->tbl_risk_type,_TBL_LIBRARY.'.risk_type_no='.$this->tbl_risk_type.'.id','left');
			$this->db->where(_TBL_LIBRARY.'.type',$tipe);
		}else{
			$this->db->select(_TBL_LIBRARY.'.*, '.$this->tbl_risk_type.'.type');
			$this->db->from(_TBL_LIBRARY_DETAIL);
			$this->db->join(_TBL_LIBRARY, _TBL_LIBRARY_DETAIL.'.child_no='._TBL_LIBRARY.'.id');
			$this->db->join($this->tbl_risk_type,_TBL_LIBRARY.'.risk_type_no='.$this->tbl_risk_type.'.id','left');
			$this->db->where(_TBL_LIBRARY.'.type',$tipe);
			$this->db->where(_TBL_LIBRARY_DETAIL.'.library_no',$parent);
		}
		
		$query=$this->db->get();
		$result['field']=$query->result();
		return $result;
	}
	
	function get_data_level($data){
		$this->db->select(_TBL_LEVEL_color.'.id,'._TBL_LEVEL_mapping.'.level_mapping,'._TBL_LEVEL_mapping.'.color,'._TBL_LEVEL_mapping.'.color_text');
		$this->db->from(_TBL_LEVEL_color);
		$this->db->join(_TBL_LEVEL_mapping,_TBL_LEVEL_mapping.'.id='._TBL_LEVEL_color.'.level_risk_no');
		$this->db->where('impact',$data['impact']);
		$this->db->where('likelihood',$data['likelihood']);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}
	
	function get_rist_detail($id, $type){
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_DETAIL);
		if ($type==1)
			$this->db->where('rcsa_no',$id);
		else
			$this->db->where('id',$id);
			
		$query=$this->db->get();
		// die($this->db->last_query())
		$result=$query->result_array();
		
		
		foreach($result as &$row){
			$course=json_decode($row['risk_couse_no'],true);
			$impact=json_decode($row['risk_impact_no'],true);
			$attach=json_decode($row['attach'],true);
			
			$event=array($row['event_no']);
			$row['event_no']=$this->cari_library($event);
			$row['owner_no']=json_decode($row['owner_no'],true);
			$row['risk_type_no']=json_decode($row['risk_type_no'],true);
			$row['risk_couse_no']=$this->cari_library($course);
			$row['risk_impact_no']=$this->cari_library($impact);
			$row['attach']=$attach;
		}
		unset($row);
		// Doi::dump($result);die();
		return $result;
	}
	
	function get_tree_data($id){
		$this->db->select('event_no,rcsa_no,id');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->where('rcsa_no',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		
		foreach($result as &$row){
			$event=array($row['event_no']);
			$row['event_no']=$this->cari_library($event);
		}
		unset($row);
		// doi::dump($this->db->last_query());
		// Doi::dump($result);die();
		
		return $result;
	}
	
	function cari_level($id){
		$this->db->select(_TBL_LEVEL_mapping.'.*');
		$this->db->from(_TBL_LEVEL_color);
		$this->db->join(_TBL_LEVEL_mapping,_TBL_LEVEL_mapping.'.id='._TBL_LEVEL_color.'.level_risk_no');
		$this->db->where(_TBL_LEVEL_color.'.id',$id);
		
		$query=$this->db->get();
		$sql=$query->result_array();
		// echo $this->db->last_query();
		// doi::dump($sql);
		return $sql;
	}
	
	
	function get_library_detail($source){
		$this->db->select('*');
		$this->db->from(_TBL_LIBRARY);
		$this->db->where('id',$source);
		$query=$this->db->get();
		$result=$query->row();
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
	
	function get_rist_level($id){
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->where('id',$id);
			
		$query=$this->db->get();
		$result=$query->result_array();
		
		foreach($result as &$row){
			$row['control_no']=json_decode($row['control_no'],true);
			$row['inherent_level_text']=$this->cari_level($row['inherent_level']);
			$row['risk_level_text']=$this->cari_level($row['risk_level']);
		}
		// doi::dump($result,false,true);
		return $result;
	}
	
	function get_rist_action($id){
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_action);
		$this->db->where('rcsa_no',$id);
			
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}
	
	function get_rist_level_controls(){
		$this->db->select('*');
		$this->db->from($this->tbl_existing_control);
		$this->db->where('status',1);
		
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}
	
	function delete_data($id){
		$this->db->where_in('id', $id);
		$this->db->delete(_TBL_RCSA);
		$jml=$this->db->affected_rows();
		return $jml;
	}
	
	function delete_event($id){
		$this->db->where_in('id', $id);
		$this->db->delete(_TBL_RCSA_DETAIL);
		$jml=$this->db->affected_rows();
		return $jml;
	}
	
	function get_risk_action($id){
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_action);
		$this->db->where('rcsa_detail_no',$id);
		
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}
	
	function get_data_action($id){
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_action);
		$this->db->where('id',$id);
		
		$query=$this->db->get();
		$result=$query->result_array();
		foreach ($result as &$row){
			$row['owner_no']=json_decode($row['owner_no']);
		}
		unset($row);
		return $result;
	}
	
	function save_even_detail($data){
		$upd=array();
		// Doi::dump($data);die();
		$upd['rcsa_no']=$data['id_rcsa'];
		$upd['event_no']=$data['risk_event_id'];
		
		$couse=array();
		foreach($data['risk_couse_id'] as $key=>$row){
			if (intval($row)>0 && !in_array($row, $couse))
				$couse[]=$row;
		}
		$upd['risk_couse_no']=json_encode($couse);
		
		$impact=array();
		foreach($data['risk_impact_id'] as $key=>$row){
			if (intval($row)>0 && !in_array($row, $impact))
				$impact[]=$row;
		}
		
		$upd['risk_impact_no']=json_encode($impact);
		
		$arra_upload=array();
		$files = $_FILES;
		$cpt = count($_FILES['attac']['name']);
		$path=upload_path_relative().'rcsa/';
		for($i=0; $i<$cpt; $i++)
		{
			$_FILES['userfile']['name']= $files['attac']['name'][$i];
			$_FILES['userfile']['type']= $files['attac']['type'][$i];
			$_FILES['userfile']['tmp_name']= $files['attac']['tmp_name'][$i];
			$_FILES['userfile']['error']= $files['attac']['error'][$i];
			$_FILES['userfile']['size']= $files['attac']['size'][$i]; 
			
			$upload=upload_image('userfile',$data,$path,'',false);
			
			if($upload){
				$arra_upload[]=array('name'=>$upload['file_name'], 'real_name'=>$files['attac']['name'][$i]);
			}
		}
		
		if (isset($data['attach_no']))
		{
			foreach($data['attach_no'] as $row){
				$x=explode('###',$row);
				if(!empty($x[0]) && !empty($x[1]))
					$arra_upload[]=array('name'=>$x[0],'real_name'=>$x[1]);
			}
		}
		
		if(count($arra_upload)>0)
			$upd['attach']=json_encode($arra_upload);
		
		if (intval($data['id_event_detail'])>0){
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$upd['update_date'] = Doi::now();
			$where['id']=$data['id_event_detail'];
			$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_DETAIL, 'field'=>$upd,'where'=>array('id'=>$data['id_event_detail']),'type'=>'update'));
			$id=intval($data['id_event_detail']);
			$type="edit";
		}else{
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$id=$this->crud->crud_data(array('table'=>_TBL_RCSA_DETAIL, 'field'=>$upd,'type'=>'add'));
			// $id=$this->db->insert_id();
			$type="add";
		}
		return $id;
	}
	
	function save_even_level($data){
		$upd=array();
		$upd['inherent_likelihood']=$data['inherent_likelihood'];
		$upd['inherent_impact']=$data['inherent_impact'];
		$upd['inherent_level']=$data['inherent_level'];
		$upd['residual_likelihood']=$data['residual_likelihood'];
		$upd['residual_impact']=$data['residual_impact'];
		$upd['risk_level']=$data['risk_level'];
		$upd['treatment_no']=$data['treatment_no'];
		$upd['nilai_dampak']=str_replace(',','',$data['nilai_dampak']);
		
		$check_item=array();
		if(array_key_exists('check_item', $data)){
			foreach($data['check_item'] as $row){
				$check_item[]=$row;
			}
		}
		$upd['control_no']=json_encode($check_item);
		
		$upd['update_user'] = $this->authentication->get_info_user('username');
		$upd['update_date'] = Doi::now();
		$where['id']=$data['id_event_detail_level'];
		$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_DETAIL, 'field'=>$upd,'where'=>$where,'type'=>'update'));
		$id=intval($data['id_event_detail_level']);
		
		return $id;
	}
	
	function save_event_action($data, $upload=array()){
		$upd=array();
		$upd['rcsa_detail_no']=$data['id_rcsa_detail_action'];
		$upd['title']=$data['title'];
		$upd['amount']=str_replace(',','',$data['amount']);
		$upd['description']=$data['description'];
		$upd['schedule_no']=$data['schedule_no'];
		if (!empty($data['target_waktu']))
			$upd['target_waktu']=date('Y-m-d',strtotime($data['target_waktu']));
		$upd['schedule_detail']=$data['schedule_detail'];
		
		$owner_no=array();
		foreach($data['owner_no_action'] as $key=>$row){
			$owner_no[]=$row;
		}
		
		$upd['owner_no']=json_encode($owner_no);
		// $upd['officer_no']=$data['officer_no'];
		
		if(!empty($upload)){
			$upd['attc']=$upload['file_name'];
		}
		
		if ((int)$data['id_event_detail_action']>0){
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$upd['update_date'] = Doi::now();

			$where['id']=$data['id_event_detail_action'];
			$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_action, 'field'=>$upd,'where'=>$where,'type'=>'update'));
			$id=intval($data['id_event_detail_action']);
			$type="edit";
		}else{
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$id=$this->crud->crud_data(array('table'=>_TBL_RCSA_action, 'field'=>$upd,'type'=>'add'));
			$id=$this->db->insert_id();
			$type="add";
		}
		$hasil_kirim = $this->send_email_action();
		return $id;
	}
	
	function save_library($data){
		if ($data['mode']!=='save_db'){
			$upd['type']=$data['add_type_library'];
			$upd['risk_type_no']=$data['add_risk_type'];
			$upd['description']=$data['add_description'];
			$upd['status']=1;
			$id=$this->crud->crud_data(array('table'=>_TBL_LIBRARY, 'field'=>$upd,'type'=>'add'));
		}else{
			$id=$data['add_event_no'];
		}
		// $id=$this->db->insert_id();
		
		if (isset($data['id_edit'])){
			if(count($data['id_edit'])>0){
				foreach($data['id_edit'] as $key=>$row)
				{
					$upd=array();
					$upd['library_no'] = $id;;
					$upd['child_no'] = $data['library_no'][$key];;
					
					$upd['create_user'] = $this->authentication->get_info_user('username');
					$result=$this->crud->crud_data(array('table'=>_TBL_LIBRARY_DETAIL, 'field'=>$upd,'type'=>'add'));
				}
			}
		}elseif(isset($data['add_event_no'])){
			$upd=array();
			$upd['library_no'] = $data['add_event_no'];
			$upd['child_no'] = $id;
			
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$result=$this->crud->crud_data(array('table'=>_TBL_LIBRARY_DETAIL, 'field'=>$upd,'type'=>'add'));
		}
		
		return $id;
	}
	
	function send_email_action(){
		$email='tridicom@yahoo.com';
		$data['email']=$email;
		$data['subject']="Send Propose";
		$data['content']="Mengirim Email Propose<br>untuk melihat data silahkan klik link dibawah ini<br><a href='http:\\risk.abutiara.com'>Linknya Nih</a>";
		$result=Doi::kirim_email($data);
		return $result;
	}
	
	function delete_action($id){
		$this->db->where_in('id', $id);
		$this->db->delete(_TBL_RCSA_action);
		$jml=$this->db->affected_rows();
		return $jml;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */