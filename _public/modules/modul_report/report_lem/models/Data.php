<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
		$this->type_report=4;
		$this->arr_Result=array();
	}

	function get_list_report($id=0)
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
		$this->db->select('*');
		$this->db->from(_TBL_REPORT);
		$this->db->where('id',$id);
		$this->db->order_by('create_date');
		
		$query=$this->db->get();
		$result=$query->result_array();
		foreach($result as &$row){
			$row['param']=json_decode($row['param'],TRUE);
		}
		
		return $result[0];
	}
	
	function save_data($data=array())
	{
		// doi::dump($data,false, true);
		$param=array();
		$upd['type'] = $this->type_report;
		$upd['template_name'] = $data['template_name'];
		$param['sts_risk_owner']=$data['sts_risk_owner'];
		$param['sts_lost_event']=$data['sts_lost_event'];
		$param['sts_amount']=$data['sts_amount'];
		$param['sts_cause']=$data['sts_cause'];
		$param['sts_date']=$data['sts_date'];
		$param['sts_action_plan']=$data['sts_action_plan'];
		
		$param['title']=$data['title'];
		$param['subtitle']=$data['subtitle'];
		$param['person_name']=$data['person_name'];
		$param['position']=$data['position'];
		$param['file_name']=$data['file_name'];
		
		$upd['param'] = json_encode($param);
		
		$id=intval($data['id']);
		if($id>0)
		{
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$upd['update_date'] = Doi::now();
			$this->db->where('id', $data["id"]);
			$this->db->update(_TBL_REPORT,$upd);
			$type="add";
		}
		else
		{
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$this->db->insert(_TBL_REPORT,$upd);
			$id=$this->db->insert_id();
			$type="edit";
		}
		
		if ($this->db->_error_message()){
			$msg=lang('msg_failed_save')."<br>".$this->db->_error_message(); 
			$this->session->set_userdata(array('result_proses_error'=>$msg));
			$sql['message']=$this->db->last_query();
			$sql['priority']=1;
			$sql['priority_name']='Gawat';
			$sql['type']=$type;
			save_log($sql);
			$id=0;
		}else{
			// echo " masuk ";
			if ($type=='edit'){
				$msg=lang('msg_success_save_edit');
			}elseif ($type=='add'){
				$msg=lang('msg_success_save_add');
			}else{
				$msg="Unknow type";
			}
			$this->session->set_userdata(array('result_proses'=>$msg));
		}
		
		return $id;
	}
	
	function del_template($id){
		$where['id']=$id;
		$this->db->delete(_TBL_REPORT,$where);
		$jml=$this->db->affected_rows();
		$sql['message']=$this->db->last_query();
		if ($jml>0){
			$pesan= $jml.' record berhasil dihapus';
			$sql['priority_name']='Info';
			$sql['priority']=3;
			$sql['type']='Delete';
			$sql['jml']=$jml;
			save_log($sql);
			$result=true;
		}else{
			$pesan= 'Gagal menghapus record';
			$sql['priority']=1;
			$sql['priority_name']='Gawat';
			$sql['type']='Fail Delete';
			$sql['jml']=0;
			save_log($sql);
			$result=false;
		}
		// doi::dump($sql['message'],false,true);
		return $pesan;
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
	
	function get_data_report($param){
		if ($param['sts_risk_owner']==1){$field[]='risk_owner.name';}
		if ($param['sts_lost_event']==1){$field[]='risk_loss_event.loss_description';}
		if ($param['sts_amount']==1){$field[]='risk_loss_event.amount';}
		if ($param['sts_cause']==1){$field[]=' risk_loss_event.cause_description';}
		if ($param['sts_date']==1){$field[]='risk_loss_event.date';}
		if ($param['sts_action_plan']==1){$field[]='risk_loss_event.action_plan';}
		
		$field=implode(',',$field);
		
		$this->db->select($field);
		$this->db->from(_TBL_OWNER);
		$this->db->join(_TBL_LOSS_EVENT,_TBL_LOSS_EVENT.'.owner_no='._TBL_OWNER.'.id');
		$id_param=explode(',',$this->authentication->get_info_user('id_param_level'));
		$sts_param = $this->authentication->get_info_user('sts_param');
			if ($sts_param =="0")
				$this->db->where_in(_TBL_OWNER.'.id',$id_param);
		
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */