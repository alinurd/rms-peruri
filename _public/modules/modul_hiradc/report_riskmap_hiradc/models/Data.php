<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
		$this->arr_Result=array();
	}
	
	function get_data_project($param){
		
		$sql= $this->db
			  ->select('*')
			  ->from(_TBL_RCSA)
			  ->where('owner_no', intval($param['l_owner_no']))
			  ->where('period_no', intval($param['l_periode_no']))
			  ->where_in('type', $param['l_type_project_no'])
			  ->get();
		$rows=$sql->result();
		$data=array();
		$data[]=" - Select - ";
		foreach($rows as $row){
			$data[$row->id]=$row->corporate;
		}
		return $data;
	}
	
	function get_data_report($id=0)
	{
		$this->db->select('*');
		$this->db->from(_TBL_REPORT);
		$this->db->where('type',$id);
		$this->db->order_by('create_date');
		
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
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
		$upd['type'] = 1;
		
		$param['title_sts']=$data['title_sts'];
		$param['title_default']=$data['title_default'];
		$param['title_custom']=$data['title_custom'];
		$param['subtitle_sts']=$data['subtitle_sts'];
		$param['subtitle_default']=$data['subtitle_default'];
		$param['subtitle_custom']=$data['subtitle_custom'];
		$param['date_sts']=$data['date_sts'];
		$param['date_default']=$data['date_default'];
		$param['date_custom']=$data['date_custom'];
		$param['sign_sts']=$data['sign_sts'];
		$param['sign_default']=$data['sign_default'];
		$param['sign_custom']=$data['sign_custom'];
		$param['sign_position']=$data['sign_position'];
		
		$upd['param'] = json_encode($param);
		
		$result=$this->crud->crud_data(array('table'=>_TBL_REPORT, 'field'=>$upd,'where'=>array('id'=>$newid),'type'=>'update'));
		
		return $result;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */