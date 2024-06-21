<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function get_rcsa_detail($id){
		$this->db->where('rcsa_no', $id);
		$rows = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		return $rows;
	}
	
	function cari_total_dipakai($id){
		$sql=$this->db->select('rcsa_no, name, count(id) as jml')->WHERE_IN('rcsa_no', $id)->group_by(['rcsa_no','name'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		
		$hasil=array();
		foreach($sql as $row):
			$hasil[$row['rcsa_no']] = ['jml'=>$row['jml'],'nama'=>'name'];
		endforeach;
		return $hasil;
	}
	
	function get_data_risk_event($id){
		$hasil['field'] = $this->get_rcsa_detail($id);;
		$rows = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA)->row_array();
		$hasil['parent'] = $rows;
		return $hasil;
	}
	
	function get_data_risk_event_detail($id, $parent){
		$this->db->where('id', $id);
		$rows = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$hasil['detail'] = $rows;
		$rows = $this->db->where('id', $parent)->get(_TBL_VIEW_RCSA)->row_array();
		$hasil['parent'] = $rows;
		$rows = $this->db->where('rcsa_detail_no', $id)->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
		$hasil['mitigasi'] = $rows;
		return $hasil;
	}
	
	function get_rist_level_controls(){
		$result = $this->db->where('status',1)->get(_TBL_EXISTING_CONTROL)->result_array();
		return $result;
	}
	
	function get_master_level($filter=false, $id=0){
		if ($filter){
			$rows = $this->db
				->select(_TBL_LEVEL_MAPPING.'.*,'._TBL_LEVEL_COLOR.'.id as id_color,'._TBL_LEVEL_COLOR.'.likelihood,'._TBL_LEVEL_COLOR.'.impact')
				->from(_TBL_LEVEL_COLOR)
				->where(_TBL_LEVEL_COLOR.'.id', $id)
				->join(_TBL_LEVEL_MAPPING, _TBL_LEVEL_COLOR.'.level_risk_no = ' . _TBL_LEVEL_MAPPING . '.id')
				->get()
				->row_array();
		}else{
			$query = $this->db
				->select(_TBL_LEVEL_MAPPING.'.*,'._TBL_LEVEL_COLOR.'.id as id_color,'._TBL_LEVEL_COLOR.'.likelihood,'._TBL_LEVEL_COLOR.'.impact')
				->from(_TBL_LEVEL_COLOR)
				->join(_TBL_LEVEL_MAPPING, _TBL_LEVEL_COLOR.'.level_risk_no = ' . _TBL_LEVEL_MAPPING . '.id')
				->get();
			$rows=json_encode($query->result_array());
		}
		// var_dump($rows);die();
		return $rows;
	}
	
	function get_data_list_mitigasi($id){
		$rows = $this->db->where('rcsa_detail_no', $id)->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
		$hasil['mitigasi'] = $rows;
		return $hasil;
	}
	
	function get_data_mitigasi($id, $rcsa_detail){
		$reg_isi=array();
		$rows = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA_MITIGASI)->row_array();
		$hasil['field'] = $rows;
		
		$rows = $this->db->where('id', $rcsa_detail)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$arrCouse = json_decode($rows['risk_couse_no'],true);
		$rows_couse=array();
		if ($arrCouse)
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
		$arrCouse=array();
		foreach($rows_couse as $rc){
			$arrCouse[] = $rc['description'];
		}
		$rows['couse']= implode('<br/>',$arrCouse);
		
		$arrCouse = json_decode($rows['risk_impact_no'],true);
		$rows_couse=array();
		if ($arrCouse)
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
		$arrCouse=array();
		foreach($rows_couse as $rc){
			$arrCouse[]=$rc['description'];
		}
		$rows['impact']=implode('<br/>',$arrCouse);
		
		$arrCouse = json_decode($rows['control_no'],true);
		$rows['control_name']=implode(', ',$arrCouse);
			
		$hasil['rcsa'] = $rows;
		return $hasil;
	}
	
	function simpan_risk_event($data){
		$upd=array();
		$upd['rcsa_no']=$data['parent_no'];
		$upd['event_no']=$data['event_no'];
		
		$couse=array();
		foreach($data['risk_couse_no'] as $key=>$row){
			if (intval($row)>0 && !in_array($row, $couse))
				$couse[]=$row;
		}
		$upd['risk_couse_no']=json_encode($couse);
		
		$impact=array();
		foreach($data['risk_impact_no'] as $key=>$row){
			if (intval($row)>0 && !in_array($row, $impact))
				$impact[]=$row;
		}
		
		$upd['risk_impact_no']=json_encode($impact);
		$upd['risk_area_id']= $data['risk_area_id'];
		
		$arra_upload=array();
		$files = $_FILES;
		if ($files){
			$cpt = count($_FILES['attact']['name']);
			$path=rcsa_path_relative().'rcsa/';
			for($i=0; $i<$cpt; $i++)
			{	
				if (!empty($files['attact']['name'][$i])){
					$nmFile = $files['attact']['name'][$i];
					$_FILES['userfile']['name']= $files['attact']['name'][$i];
					$_FILES['userfile']['type']= $files['attact']['type'][$i];
					$_FILES['userfile']['tmp_name']= $files['attact']['tmp_name'][$i];
					$_FILES['userfile']['error']= $files['attact']['error'][$i];
					$_FILES['userfile']['size']= $files['attact']['size'][$i]; 
					$upload=upload_image_new(array('nm_file'=>'userfile', 'size'=>10000000, 'path'=>'rcsa','thumb'=>false, 'type'=>'*'), TRUE, $i);
					if($upload){
						$arra_upload[]=array('name'=>$upload['file_name'],'real_name'=>$nmFile);
					}
				}
			}
		}
							
			
		if (isset($data['att_name']))
		{
			foreach($data['att_name'] as $key=>$row){
				$arra_upload[]=array('name'=>$data['att_name'][$key],'real_name'=>$data['att_real_name'][$key]);
			}
		}
		
		if(count($arra_upload)>0)
			$upd['attach']=json_encode($arra_upload);
		
		$upd['inherent_likelihood']=$data['inherent_likelihood'];
		$upd['inherent_impact']=$data['inherent_impact'];
		$upd['inherent_level']=$data['inherent_level'];
		$upd['note_control']=$data['note_control'];
		$upd['risk_control_assessment']=$data['risk_control_assessment'];
		$upd['treatment_no']=$data['treatment_no'];
		
		$check_item=array();
		if(array_key_exists('check_item', $data)){
			foreach($data['check_item'] as $row){
				$check_item[]=$row;
			}
		}
		$upd['control_no']=json_encode($check_item);
		
		if (intval($data['id_edit'])>0){
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$upd['update_date'] = Doi::now();
			$where['id']=$data['id_edit'];
			$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_DETAIL, 'field'=>$upd,'where'=>array('id'=>$data['id_edit']),'type'=>'update'));
			$id=intval($data['id_edit']);
			$type="edit";
		}else{
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$id=$this->crud->crud_data(array('table'=>_TBL_RCSA_DETAIL, 'field'=>$upd,'type'=>'add'));
			$id=$this->db->insert_id();
			$type="add";
		}
		return $id;
	}
	
	function save_mitigasi($data){
		$upd=array();
		$upd['rcsa_detail_no']=$data['id_detail_mitigasi'];
		$upd['proaktif']=$data['proaktif'];
		$upd['reaktif']=$data['reaktif'];
		$upd['amount']=str_replace(',','',$data['amount']);
		$upd['schedule_no']=$data['schedule_no'];
		if (!empty($data['target_waktu']))
			$upd['target_waktu']=date('Y-m-d',strtotime($data['target_waktu']));
		
		$accountable_no=array();
		foreach($data['owner_no_action'] as $key=>$row){
			$accountable_no[]=$row;
		}
		$upd['accountable_unit']=json_encode($accountable_no);
		
		$accountable_no=array();
		foreach($data['owner_no_action_accountable'] as $key=>$row){
			$accountable_no[]=$row;
		}
		$upd['owner_no']=json_encode($accountable_no);
				
		if ((int)$data['id_edit_mitigasi']>0){
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$upd['update_date'] = Doi::now();

			$where['id']=$data['id_edit_mitigasi'];
			$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION, 'field'=>$upd,'where'=>$where,'type'=>'update'));
			$id=intval($data['id_edit_mitigasi']);
			$type="edit";
		}else{
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$id=$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION, 'field'=>$upd,'type'=>'add'));
			$id=$this->db->insert_id();
			$type="add";
		}
		$hasil=$this->data->get_data_list_mitigasi($data['id_detail_mitigasi']);
		return $hasil;
	}
	
	function get_data_risk_register($id){
		$rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_REGISTER)->result_array();
		foreach($rows as &$row){
			$arrCouse = json_decode($row['risk_couse_no'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[] = $rc['description'];
			}
			$row['couse']= implode(', ',$arrCouse);
			
			$arrCouse = json_decode($row['risk_impact_no'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['description'];
			}
			$row['impact']=implode(', ',$arrCouse);
			
			$arrCouse = json_decode($row['accountable_unit'],true);
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['name'];
			}
			$row['accountable_unit_name']=implode(', ',$arrCouse);
			
			$arrCouse = json_decode($row['penanggung_no'],true);
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['name'];
			}
			$row['penanggung_jawab']=implode(', ',$arrCouse);
			
			$arrCouse = json_decode($row['control_no'],true);
			$row['control_name']=implode(', ',$arrCouse);
			
		}
		unset($row);
		// die($this->db->last_query());
		return $rows;
	}
	
	function risk_register_field($id_rcsa=0) {

		$data = array();

		$rows = $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_VIEW_REGISTER)->result_array();
		$arrcouse=$this->get_combo_model('library', 2);
		$arrimpact=$this->get_combo_model('library', 3);
		$arrpic=$this->get_combo_model('owner');
		$arraccountableunit=$this->get_combo_model('owner');

		foreach ($rows as &$row){
			$couse = json_decode($row['risk_couse_no'], true);
			$txt=array();
			if (is_array($couse) || is_object($couse))
			{
				foreach ($couse as $lib){
					if (array_key_exists($lib,$arrcouse))
						$txt[]=$arrcouse[$lib];
				}
				$row['couse_no']=implode('<br/>', $txt);
			}
			
			$impact = json_decode($row['risk_impact_no'], true);
			$txt=array();
			if (is_array($impact) || is_object($impact))
			{
				foreach ($impact as $lib){
					if (array_key_exists($lib,$arrimpact))
						$txt[]=$arrimpact[$lib];
				}
				$row['impact_no']=implode('<br/>', $txt);
			}

			$pic = json_decode($row['pic'], true);
			// Doi::dump($pic);
			$txt=array();
			if (is_array($pic) || is_object($pic))
			{
				foreach ($pic as $lib){
					if (array_key_exists($lib,$arrpic))
						$txt[]=$arrpic[$lib];
				}
				$row['pic']=implode('<br/>', $txt);
			}

			$accountable_unit = json_decode($row['accountable_unit'], true);
			$txt=array();
			if (is_array($accountable_unit) || is_object($accountable_unit))
			{
				foreach ($accountable_unit as $lib){
					if (array_key_exists($lib,$arraccountableunit))
						$txt[]=$arrpic[$lib];
				}
				$row['accountable_unit']=implode('<br/>', $txt);
			}
			
			$penanggung_no = json_decode($row['penanggung_no'], true);
			$txt=array();
			if (is_array($penanggung_no) || is_object($penanggung_no))
			{
				foreach ($penanggung_no as $lib){
					if (array_key_exists($lib, $arraccountableunit))
						$txt[]=$arrpic[$lib];
				}
				$row['penanggung_no']=implode('<br/>', $txt);
			}
		}

		return $rows;
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

	function owner_hierarcy($id=0){
		$rows = $this->db->where('parent_id', $id)->get(_TBL_VIEW_OWNER)->result();
		$result = array();
		foreach ($rows as $owner) {
			
				if (isset($owner->parent_name))
					$result[$owner->parent_id] = $owner->parent_name;
				if (isset($owner->lv_1_name))
					$result[$owner->lv_1_id] = str_repeat("&nbsp;", 4) . $owner->lv_1_name;
				if (isset($owner->lv_2_name))
					$result[$owner->lv_2_id] = str_repeat("&nbsp;", 8) . $owner->lv_2_name;
				if (isset($owner->lv_3_name))
					$result[$owner->lv_3_id] = str_repeat("&nbsp;", 12) . $owner->lv_3_name;
		}
		//$res = array_map("unserialize", array_unique(array_map("serialize", $result)));
		return $result;
			
	}

	function owner_id($id=0){
		$this->db->select('owner_no');
		$this->db->from(_TBL_RCSA);
		$this->db->where(_TBL_RCSA.'.id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}

}
/* End of file app_login_model.php */