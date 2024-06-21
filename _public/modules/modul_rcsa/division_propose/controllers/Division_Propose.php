<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Division_Propose extends BackendController {
	var $tmp_data=array();
	var $data_fields=array();
	
	public function __construct()
	{
        parent::__construct();
		$this->load->model('data');
		$table=$this->config->item('tbl_suffix').'items';
	}
	
	public function index()
	{	
		$data=array();
		if ($this->input->post())
			$post=$this->input->post();
		else 
			$post=array('owner_no'=>0, 'period_no'=>0, 'project_no'=>0);
		if (isset($post['project_no'])){
			$data['project_no']=$post['project_no'];
		}
		$data['type_dash']=1;
		$data['setting']=$this->crud->get_setting($data);
		if (count($data['setting']['rcsa'])>0)
			$data['cbo_project']=$this->get_combo('project_rcsa', $data['setting']['rcsa'][0]);
		else
			$data['cbo_project']=array();
		
		$data['cbo_owner']=$this->get_combo('parent-input');
		$data['cbo_period']=$this->get_combo('periode');
		$data['post']=$post;
		$data['cbo_likelihood']=$this->get_combo('likelihood');
		$data['cbo_impact']=$this->get_combo('impact');
		$this->template->build('view',$data); 
	}
	
	function send_email(){
		$email=$this->input->get('email');
		$id_rsca=$this->input->get('rsca');
		$data['email']=$email;
		$data['subject']="Send Propose";
		$data['content']="Mengirim Email Propose<br>untuk melihat data silahkan klik link dibawah ini<br/><a href='http://202.152.1.190:8080/approve'> Link </a>";
		$result=Doi::kirim_email($data);
		$result="berhasil";
		$data['table']='rcsa';
		$data['type']='update';
		$data['field']['sts_propose']=1;
		$data['field']['date_propose']=date('Y-m-d');
		$data['where']=array('id'=>$id_rsca);
		$id=$this->crud->crud_data($data);
		echo $result;
	}
	
	function get_param(){
		$data['kel'] = $this->input->get('idmodal');
		$data['field'] = $data['field']=$this->crud->get_param($data['kel']);
		$result=$this->load->view('statis/list_param',$data,true);
		echo $result;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */