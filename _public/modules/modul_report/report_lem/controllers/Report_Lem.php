<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Report_Lem extends BackendController {
	var $tmp_data=array();
	var $data_fields=array();
	
	public function __construct()
	{
        parent::__construct();
		$this->load->model('data');
		$this->type_report=4;
	}
	
	public function index()
	{	
		$data['id_report']=0;
		$data['data_report']=$this->data->get_list_report($this->type_report);
		$this->template->build('report',$data); 
	}
	
	function save_data(){
		$this->form_validation->set_rules('title', 'Period Number', 'required');
		$this->form_validation->set_rules('subtitle', 'Period Number', 'required');
		$this->form_validation->set_rules('person_name', 'Person Name', 'required');
		$this->form_validation->set_rules('position', 'Position', 'required');
		$this->form_validation->set_rules('file_name', 'File Name', 'required');
		
		if($this->form_validation->run()==FALSE){
			$data['id_report']=$this->input->post('report_no');
			$data['field']=$this->input->post();
			$data['field']['param']=$this->input->post();
			$data['data_report']=$this->data->get_list_report($this->type_report);
			$this->template->build('report',$data); 
		}else{
			$result=$this->data->save_data($this->input->post());
			header('location:'.base_url($this->_Snippets_['modul']));
		}
	}
	
	function get_param(){
		$data['kel'] = $this->input->get('idmodal');
		$data['field'] = $data['field']=$this->crud->get_param($data['kel']);
		$result=$this->load->view('statis/list_param',$data,true);
		echo $result;
	}
	
	function edit_report(){
		$data['id_report']=intval($this->uri->segment(3));
		$data['data_report']=$this->data->get_list_report($this->type_report);
		$data['field']=$this->data->get_data_param($data['id_report']);
		// doi::dump($data['field']['param'],false,true);
		$this->template->build('report',$data); 
	}
	
	function SIDEBAR_LEFTx(){
		return TRUE;
	}
	
	function SIDEBAR_RIGHTx(){
		return TRUE;
	}
	
	function print_report(){
		$this->template->var_tmp('posisi',FALSE);
		$param=intval($this->uri->segment(3));
		$data['field']=$this->data->get_data_param($param);
		// doi::dump($data['field'],false,true);
		$data['setting']=$this->data->get_data_report($data['field']['param']);
		// doi::dump($data['setting']);
		// doi::dump($data['field'],false, true);
		
		$this->template->build('report-lem',$data); 
	}
	
	function delete_report(){
		$data['id_report']=intval($this->input->get('id'));
		$result = $this->data->del_template($data['id_report']);
		echo $result;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */