<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Approve_Hiradc_Kadiv extends BackendController {
	var $tmp_data=array();
	var $data_fields=array();
	
	public function __construct()
	{

        parent::__construct();
		$this->set_Tbl_Master(_TBL_RCSA);
		$this->set_Table(_TBL_OWNER);
		$this->set_Table(_TBL_PERIOD);		
		
		$this->set_Open_Tab('Konteks Risiko');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'corporate', 'size'=>100, 'search'=>true));
			$this->addField(array('field'=>'owner_no', 'size'=>100, 'search'=>true));
			$this->addField(array('field'=>'type', 'size'=>15));
			$this->addField(array('field'=>'period_no', 'size'=>15));
			$this->addField(array('field'=>'start_date', 'input'=>'date', 'type'=>'date', 'size'=>10, 'search'=>true));
			$this->addField(array('field'=>'end_date', 'input'=>'date', 'type'=>'date', 'size'=>10, 'search'=>true));
			$this->addField(array('field'=>'nilai_kontrak', 'input'=>'float', 'size'=>15));
			$this->addField(array('field'=>'sts_approve', 'input'=>'boolean', 'size'=>15, 'search'=>true));
		$this->set_Close_Tab();	
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'owner_no','sp'=>$this->tbl_owner,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'period_no','sp'=>$this->tbl_period,'id_sp'=>'id'));
		
		$this->addField(array('nmtbl'=>$this->tbl_owner, 'field'=>'name', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_period, 'field'=>'periode_name', 'size'=>20, 'show'=>false));
		
		if ($this->id_param_owner['privilege_owner']['id']>1)
			$this->set_Where_Table($this->tbl_master,'owner_no','in',$this->id_param_owner['owner_child']);	
		
		$this->set_Where_Table($this->tbl_master,'sts_propose','=',2);	
		
		$this->set_Table_List($this->tbl_owner,'name');
		$this->set_Table_List($this->tbl_master,'corporate');
		$this->set_Table_List($this->tbl_master,'sts_approve');
		$this->set_Table_List($this->tbl_master,'start_date');
		$this->set_Table_List($this->tbl_master,'end_date');
		$this->set_Table_List($this->tbl_master,'nilai_kontrak');
		
		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('delete', false);
		$this->set_Close_Setting();
	}
	
	function listBox_STS_APPROVE($row, $value){
		if ($value==1){
			$ket="<span class='label label-info'>Approved</span>";
		}elseif ($value==2){
			$ket="<span class='label label-danger'>Not Appv</span>";
		}else{
			$ket="<span class='label label-default'>-</span>";
		}
		
		return $ket;
	}
	
	public function action_detail()
	{	
		$data=array();
		$data['project_no']=$this->uri->segment(3);
		$data['judul']=$this->data->data_judul_project($data['project_no']);
		$data['setting']=$this->crud->get_setting($data);
		$data['field']= $this->data->get_data_risk_register($data['project_no']);
		$data['cbo_likelihood']=$this->get_combo('likelihood');
		$data['cbo_impact']=$this->get_combo('impact');
		// doi::dump($data['field'], false, true);
		$this->template->build('view',$data);  
	}
	
	function save_notes(){
		$post=$this->input->post();
		$rcsa_action_id = $post['rcsa_action_no'];
		$data['table']="rcsa";
		$data['type']="update";
		$data['field']['sts_approve']=intval($post['stsApp']);
		$data['field']['sts_propose']=0;
		$data['field']['date_approve']=date('Y-m-d');
		$data['field']['note_approve']= $this->input->post('notes');
		$data['field']['user_approve']= $this->authentication->get_info_user('username');
		$data['where']['id']=$this->input->post('rcsa_no');
		$id=$this->crud->crud_data($data);

		$this->data->prop($rcsa_action_id);
		

		header('location:'.base_url('approve-div'));
	}
	
	function get_param(){
		$data['kel'] = $this->input->get('idmodal');
		$data['field'] = $data['field']=$this->crud->get_param($data['kel']);
		$result=$this->load->view('statis/list_param',$data,true);
		echo $result;
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows){
		$rcsa_detail_no=$rows['l_id'];
		
		$url=base_url('approve-div/action-detail');
		$tombol['print']=array();
		$tombol['view']=array();
		$tombol['delete']=array();
		$tombol['edit']=array("default"=>true,"url"=>$url,"label"=>"Project Detail");
		return $tombol;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

