<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function get_parameter_type($id=0){
		$this->db->select('*');
		$this->db->from(_TBL_ALERT_DETAIL);
		$this->db->where('id_at',$id);
		
		$query=$this->db->get();
		$result['field']=$query->result_array();
		return $result;
	}
	
	function save_parameter($newid=0,$data=array())
	{
		$now = new DateTime();
		$tgl= $now->format('Y-m-d H:i:s');
		$result=1;
		
		if (isset($data['id_edit'])){
			if(count($data['id_edit'])>0){
				foreach($data['id_edit'] as $key=>$row)
				{
					$upd['id_apt'] = $data['groups_id'][$key];;
					$upd['id_at'] = $newid;
					
					if(intval($data['id_edit'][$key])>0)
					{
						$upd['update_date'] = $tgl;
						$upd['update_user'] = $this->authentication->get_Info_User('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_ALERT_DETAIL, 'field'=>$upd,'where'=>array('id'=>$data['id_edit'][$key]),'type'=>'update'));
					}
					else
					{
						$upd['create_user'] = $this->authentication->get_Info_User('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_ALERT_DETAIL, 'field'=>$upd,'type'=>'add'));
					}
				}
			}
		}
		return $result;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */