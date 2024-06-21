<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	var $nm_tbl='';
	var $nm_tbl_user='';
	var $_prefix='';
	var $_modules='';
	public function __construct()
    {
        parent::__construct();
		$this->nm_tbl="rcsa";
		$this->nm_tbl_owner="owner";
		$this->nm_tbl_library="library";
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
		
		$this->db->where('id', $newid);
		$this->db->update($this->nm_tbl,$upd);
		if ($this->db->_error_message()){
			die($this->db->_error_message());
			return false;
		}else{
			return true;
		}
	}
	
	function get_data($id=0){
		$this->db->select('*');
		$this->db->from($this->nm_tbl);
		$this->db->where('id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		if(count($result)>0)
			return $result[0];
		else
			return $result;
	}
	
	function get_data_owner(){
		$this->db->select('*');
		$this->db->from($this->nm_tbl_owner);
		$id_param=explode(',',$this->authentication->get_info_user('id_param_level'));
		$this->db->where_in('id',$id_param);
		$query=$this->db->get();
		$result=$query->result();
		return $result;
	}
	
	function get_data_event($tipe){
		$this->db->select('*');
		$this->db->from($this->nm_tbl_library);
		$this->db->where('type',$tipe);
		$query=$this->db->get();
		$result=$query->result();
		return $result;
	}
	
	
	function get_rist_detail($id){
		return true;
	}
	
	function delete_data($id){
		$this->db->where_in('id', $id);
		$this->db->delete($this->nm_tbl);
		$jml=$this->db->affected_rows();
		return $jml;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */