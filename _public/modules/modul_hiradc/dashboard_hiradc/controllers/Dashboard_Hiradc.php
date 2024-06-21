<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Dashboard_Hiradc extends BackendController {
	var $tmp_data=array();
	var $data_fields=array();
	
	public function __construct()
	{
        parent::__construct();
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
		$data['mapping']=$this->data->get_map_hiradc();
		
		$this->template->build('dashboard',$data); 
	}
	
	function get_detail_map(){
		$id = intval($this->input->post('id'));
		$tahun = intval($this->input->post('tahun'));
		$tahun = $this->db->where('id', $tahun)->get(_TBL_PERIOD)->row_array();
		$rows = $this->db->where('severity_no', $id)->get(_TBL_VIEW_HIRADC_MITIGASI)->result_array();
		$arr=[];
		foreach($rows as $row){
			$arr[$row['hiradc_detail_no']][]=$row;
		}
		
		$rows = $this->db->where('severity_no', $id)->get(_TBL_VIEW_HIRADC_DETAIL)->result_array();
		foreach($rows as &$row){
			if (array_key_exists($row['id'], $arr)){
				$row['mitigasi'] = $arr[$row['id']];
			}
		}
		unset($row);
		
		$hasil['combo'] = $this->load->view("detail", ['data'=>$rows, 'tahun'=>$tahun], true);
		echo json_encode($hasil);
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