<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Dashboard_project extends BackendController {
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
		$data['type_dash']=2;
		$data['setting']=$this->crud->get_setting($data);
		$data['post']=$post;
		if (count($data['setting']['rcsa'])>0)
			$data['cbo_project']=$this->get_combo('project_rcsa', $data['setting']['rcsa'][0]);
		else
			$data['cbo_project']=array();
		$data['cbo_owner']=$this->get_combo('parent-input');
		$data['cbo_period']=$this->get_combo('periode');
		
		$this->template->build('dashboard',$data); 
	}
	
	function get_param(){
		$data['kel'] = $this->input->get('idmodal');
		$data['field'] = $data['field']=$this->crud->get_param($data['kel']);
		$result=$this->load->view('statis/list_param',$data,true);
		echo $result;
	}
	
	function get_event_popup(){
		$data['kel'] = $this->input->get('iddetail');
		$data['field'] = $this->data->get_detail_event($data['kel']);
		$result=$this->load->view('list_detail_event',$data,true);
		echo $result;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */