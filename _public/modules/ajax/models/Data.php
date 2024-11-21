<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
    {
        parent::__construct();
	}
	
	function get_data_event($tipe,$kelompok=0){	
		$this->db->select(_TBL_LIBRARY.'.*, '._TBL_RISK_TYPE.'.type');
		$this->db->from(_TBL_LIBRARY);
		$this->db->join(_TBL_RISK_TYPE,_TBL_LIBRARY.'.risk_type_no='._TBL_RISK_TYPE.'.id','left');
		if ($kelompok>0)
			$this->db->where(_TBL_LIBRARY.'.risk_type_no',$kelompok);
		$this->db->where(_TBL_LIBRARY.'.type',$tipe);
		
		
		$query=$this->db->get();
		$result['field']=$query->result();
		return $result;
	}
	function get_data_kelevent($id)
	{
		$dt = $this->db
			->select('id,library_no, kategori_risiko, child_no')
			->from('bangga_library_detail')
			->where('kategori_risiko', $id)
			->get()
			->result_array();
// doi::dump($dt);

		if (empty($dt)) {
			$option = '<option value="0">' . lang('msg_cbo_select') . '</option>';
		} else {
			$subkelompokArray = array(); // Array to store the subkelompok values

			foreach ($dt as $dtkel) {
				$subkelompokArray[] = $dtkel['library_no'];
			}

			$sql = $this->db
				->select('*')
				->from(_TBL_LIBRARY)
				// ->where('kelompok', $kelompok)
				->where_in('id', $subkelompokArray)
				->get();

			$rows = $sql->result();
			$option = '<option value="0">' . lang('msg_cbo_select') . '</option>';

			foreach ($rows as $row) {
				$option .= '<option value="' . $row->id . '">' . $row->description . '</option>';
			}
		}
// doi::dump($option);

		$result['combo'] = $option;
		// die('cek ajax');
		return $result;
	}


	function get_data_combo($id, $kelompok)
	{

		$dt = $this->db
		->select('id, subkelompok')
		->from(_TBL_MAP_KELOMPOK)
		->where('kelompok', $id)
		->where('aktif', 1)
		->get()
		->result_array();

		if (empty($dt)) {
			$option = '<option value="0">' . lang('msg_cbo_select') . '</option>';
		} else {
			$subkelompokArray = array(); // Array to store the subkelompok values

			foreach ($dt as $dtkel) {
				$subkelompokArray[] = $dtkel['subkelompok'];
			}

			$sql = $this->db
				->select('*')
				->from(_TBL_DATA_COMBO)
				->where('kelompok', $kelompok)
				->where_in('id', $subkelompokArray)
				->get();

			$rows = $sql->result();
			$option = '<option value="0">' . lang('msg_cbo_select') . '</option>';

			foreach ($rows as $row) {
				$option .= '<option value="' . $row->id . '">' . $row->data . '</option>';
			}
		}

		$result['combo'] = $option;
		return $result;
	}
	function get_lib_event_map($id,$type)
	{
		// doi::dump($id);

		$dt = $this->db
			->select('id, library_no, child_no')
			->from('bangga_library_detail')
			->where('library_no', $id)
 			->get()
			->result_array();

		if (empty($dt)) {
			$option = '<option value="0">' . lang('msg_cbo_select') . '</option>';
		} else {
			$subkelompokArray = array(); // Array to store the subkelompok values

			foreach ($dt as $dtkel) {

				$subkelompokArray[] = $dtkel['child_no'];
			}
			$sql = $this->db
			->select('*')
			->from('bangga_library')
				->where('type', $type)

			->where_in('id', $subkelompokArray)
			->get();

			if ($sql === false) {
				$error = $this->db->error();
				echo 'Database Error: ' . $error['message'];
			} else {
				$rows = $sql->result();
			}


			$option = '<option value="0">' . lang('msg_cbo_select') . '</option>';

			foreach ($rows as $row) {
				$option .= '<option value="' . $row->id . '">' . $row->description . '</option>';
			}
		}
		// doi::dump($option);

		// die('get_lib_event');
		$result['combo'] = $option;
		return $result;
	}


	function get_data_approve_owner($param)
	{
		$result = array();
		$option = '<option value="0">' . lang('msg_cbo_select') . '</option>';

		if ($param > 0) {
			$officers = $this->db
				->select('*')
				->from('bangga_officer')
				->where('owner_no', intval($param))
				->where('id >', 0)
				->get()
				->result();

			foreach ($officers as $officer) {
				$users = $this->db
					->select('*')
					->where('officer_no', $officer->id)
					->where('aktif', 1)
					->get('bangga_users')
					->result_array();

				if (!empty($users)) {
					$groups = $this->db
						->select('*')
						->where('user_no', $users[0]['id'])
						->where('group_no', 24)
						->get('bangga_group_user')
						->result_array();

					if (!empty($groups)) {
						$sqlxx = $this->db
							->select('*')
							->from('bangga_users')
							->where('id', $groups[0]['user_no'])
							->where('aktif', 1)
							->get();
						$groupsname = $this->db
							->select('*')
 							->where('id', $groups[0]['group_no'])
							->where('aktif', 1)

						->get('bangga_groups')
						->result_array();
							// doi::dump($groupsname);
						$resusers = $sqlxx->result();

						foreach ($resusers as $rowxx) {
							$option .= '<option value="' . $rowxx->id . '"><strong>' . htmlspecialchars($rowxx->nama_lengkap) . '</strong> [' . $groupsname[0]['group_name'] . ']</option>';						}
					}
				}
			}
		}

		$result['combo'] = $option;
		return $result;
	}



	function get_map_takstonomi($type, $id)
{
    $data = [];
    if ($type == 1) {
        $data = $this->db
            ->select('id, data')
            ->from(_TBL_DATA_COMBO)
            ->where('pid', $id)
            ->where('kelompok', 'kategori-risiko')
            ->where('aktif', 1)
            ->get()
            ->result_array();
    }

    if (count($data) > 0) {
        $option = '<option value="0">' . lang('msg_cbo_select') . '</option>';
        foreach ($data as $row) {
            $option .= '<option value="' . $row['id'] . '">' . $row['data'] . '</option>';
        }
    } else {
        $option = '<option value="0">' . lang('msg_cbo_select') . '</option>';
    }
 
    $result['combo'] = $option;
    return $result;
}




	function get_data_type_risk($param){
		if ($param>0){
			$sql= $this->db
				  ->select('*')
				  ->from(_TBL_RISK_TYPE)
				  ->where('kelompok', intval($param))
				  ->where('id > ', 0)
				  ->get();
		}else{
			$sql= $this->db
				  ->select('*')
				  ->from(_TBL_RISK_TYPE)
				  ->where('id > ', 0)
				  ->get();
		}
		$rows=$sql->result();
		$option = '<option value="0">'.lang('msg_cbo_select').'</option>';
		foreach($rows as $row){
			$option .= '<option value="'.$row->id.'">'.$row->type.'</option>';
		}
		$result['combo']=$option;
		return $result;
	}
	
	function get_data_project($param){
		$param=explode('-',$param);
		$owner_no=0;
		$period_no=0;
		$type_project=array(1, 2);
		if (count($param)>=2){
			$owner_no=$param[0];
			$period_no=$param[1];
			if (array_key_exists(2, $param))
				$type_project=array($param[2]);
		}
		$sql= $this->db
			  ->select('*')
			  ->from(_TBL_RCSA)
			  ->where('owner_no', intval($owner_no))
			  ->where('period_no', intval($period_no))
			  ->where_in('type', $type_project)
			  ->get();
		$rows=$sql->result();
		$data=array();
		$option = '<option value="0">'.lang('msg_cbo_select').'</option>';
		foreach($rows as $row){
			$option .= '<option value="'.$row->id.'">'.$row->corporate.'</option>';
		}
		$result['combo']=$option;
		return $result;
	}
	
	function get_data_project_hiradc($param){
		$owner_no = intval($param['owner_no']);
		$period_no = intval($param['period_no']);
		$sql= $this->db->where('owner_no', $owner_no)->where('period_no', $period_no)->get(_TBL_HIRADC);
		$rows=$sql->result();
		$data=array();
		$option = '<option value="0">'.lang('msg_cbo_select').'</option>';
		foreach($rows as $row){
			$option .= '<option value="'.$row->id.'">'.$row->corporate.'</option>';
		}
		$result['combo']=$option;
		return $result;
	}
	
	function get_detail_event($dt){
		if ($dt['type_map']=='residual'){
			$filter = 'risk_level';
		}else{
			$filter = 'inherent_level';
		}
		$datas=explode(',',$dt['iddetail']);
		$rcsa_no=explode(',',$dt['rcsa_no']);
		$detail=array();
		$this->db->select('*');
		$this->db->from(_TBL_LEVEL);
		$query = $this->db->get();
		$rows = $query->result_array();
		foreach($rows as $row){
			$detail[$row['id']]=array('title'=>$row['code'] . '-' . $row['level'], 'score'=>$row['score']);
		}
		$this->db->select(_TBL_LIBRARY.'.*,'._TBL_RCSA_DETAIL.'.inherent_likelihood,'._TBL_RCSA_DETAIL.'.inherent_impact,'._TBL_RCSA_DETAIL.'.residual_likelihood,'._TBL_RCSA_DETAIL.'.residual_impact,'._TBL_RCSA_DETAIL.'.nilai_dampak,'._TBL_RCSA.'.*,'.$this->tbl_owner.'.name as owner_name');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->join(_TBL_LIBRARY,_TBL_RCSA_DETAIL.'.event_no='._TBL_LIBRARY.'.id');
		$this->db->join(_TBL_RCSA,_TBL_RCSA_DETAIL.'.rcsa_no='._TBL_RCSA.'.id');
		$this->db->join($this->tbl_owner,_TBL_RCSA.'.owner_no='.$this->tbl_owner.'.id');
		$this->db->where_in(_TBL_RCSA_DETAIL.'.rcsa_no',$rcsa_no);			
		$this->db->where_in(_TBL_RCSA_DETAIL.'.'.$filter,$datas);			
		$this->db->order_by(_TBL_RCSA_DETAIL.'.nilai_dampak','desc');			
		$query=$this->db->get();
		$rows=$query->result_array();
		foreach($rows as &$row){
			$row['inherent_likelihood_text']=(array_key_exists($row['inherent_likelihood'], $detail))?$detail[$row['inherent_likelihood']]['title']:'-';
			$row['inherent_impact_text']=(array_key_exists($row['inherent_impact'], $detail))?$detail[$row['inherent_impact']]['title']:'-';
			
			$row['residual_likelihood_text']=(array_key_exists($row['residual_likelihood'], $detail))?$detail[$row['residual_likelihood']]['title']:'-';
			$row['residual_impact_text']=(array_key_exists($row['residual_impact'], $detail))?$detail[$row['residual_impact']]['title']:'-';
			
			$row['inherent_score']=(array_key_exists($row['inherent_likelihood'], $detail))?$detail[$row['inherent_likelihood']]['score']:'0';
			
			$row['residual_score']=(array_key_exists($row['residual_likelihood'], $detail))?$detail[$row['residual_likelihood']]['score']:'0';
		}
		unset($row);
		$query_tmp['result_detail_map']=$this->db->last_query();
		$this->session->set_userdata($query_tmp);
		return $rows;
	}
	
	function get_detail_event_exposure($dt){
		if ($dt['type_map']=='residual'){
			$filter = 'risk_level';
		}else{
			$filter = 'inherent_level';
		}
		$datas=explode(',',$dt['iddetail']);
		$rcsa_no=explode(',',$dt['rcsa_no']);
		$detail=array();
		$this->db->select('*');
		$this->db->from(_TBL_LEVEL);
		$query = $this->db->get();
		$rows = $query->result_array();
		foreach($rows as $row){
			$detail[$row['id']]=$row['code'] . '-' . $row['level'];
		}
		
		$this->db->select(_TBL_LIBRARY.'.*,'._TBL_RCSA_DETAIL.'.inherent_likelihood,'._TBL_RCSA_DETAIL.'.inherent_impact,'._TBL_RCSA_DETAIL.'.nilai_dampak,'._TBL_RCSA.'.*,'.$this->tbl_owner.'.name as owner_name');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->join(_TBL_LIBRARY,_TBL_RCSA_DETAIL.'.event_no='._TBL_LIBRARY.'.id');
		$this->db->join(_TBL_RCSA,_TBL_RCSA_DETAIL.'.rcsa_no='._TBL_RCSA.'.id');
		$this->db->join($this->tbl_owner,_TBL_RCSA.'.owner_no='.$this->tbl_owner.'.id');
		$this->db->where_in(_TBL_RCSA_DETAIL.'.rcsa_no',$rcsa_no);			
		$this->db->where_in(_TBL_RCSA_DETAIL.'.'.$filter,$datas);			
		$this->db->order_by(_TBL_RCSA_DETAIL.'.nilai_dampak','desc');			
		$query=$this->db->get();
		$rows=$query->result_array();
		foreach($rows as &$row){
			$row['inherent_likelihood']=(array_key_exists($row['inherent_likelihood'], $detail))?$detail[$row['inherent_likelihood']]:'-';
			$row['inherent_impact']=(array_key_exists($row['inherent_impact'], $detail))?$detail[$row['inherent_impact']]:'-';
		}
		unset($row);
		$query_tmp['result_detail_map']=$this->db->last_query();
		$this->session->set_userdata($query_tmp);
		return $rows;
	}
	
	function get_data_detail_action($id=0){
		$detail=array();
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_ACTION_DETAIL);
		$this->db->where('action_no', $id);
		$this->db->order_by('progress');
		$query = $this->db->get();
		$rows = $query->result_array();
		return $rows;
	}
	
	function get_data_detail_map(){
		$detail=array();
		$this->db->select('*');
		$this->db->from(_TBL_LEVEL);
		$query = $this->db->get();
		$rows = $query->result_array();
		foreach($rows as $row){
			$detail[$row['id']]=$row['code'] . '-' . $row['level'];
		}
		
		$sql=$this->session->userdata('result_detail_map');
		$query=$this->db->query($sql);
		$rows=$query->result_array();
		
		foreach($rows as &$row){
			$row['inherent_likelihood']=(array_key_exists($row['inherent_likelihood'], $detail))?$detail[$row['inherent_likelihood']]:'-';
			$row['inherent_impact']=(array_key_exists($row['inherent_impact'], $detail))?$detail[$row['inherent_impact']]:'-';
			$row['inherent_score']=(array_key_exists($row['inherent_likelihood'], $detail))?$detail[$row['inherent_likelihood']]['score']:'0';
			$row['residual_score']=(array_key_exists($row['residual_likelihood'], $detail))?$detail[$row['residual_likelihood']]['score']:'0';
		
		}
		unset($row);
		return $rows;
	}
	
	function get_kel($id){
		$rows = $this->db->where('kelompok', $id)->order_by('id')->get(_TBL_RISK_TYPE)->result_array();
		return $rows;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */