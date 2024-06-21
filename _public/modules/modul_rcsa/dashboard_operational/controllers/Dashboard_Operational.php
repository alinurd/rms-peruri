<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Dashboard_Operational extends BackendController {
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
		$data['type_dash']=1;
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
	
	function get_detail_map(){
		$post=$this->input->post();
		$rows=$this->db->where('inherent_level', $post['id'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		foreach($rows as &$row){
			$arrCouse = json_decode($row['risk_couse_no'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[] = $rc['description'];
			}
			$row['couse']= implode(', ',$arrCouse);
			
			$arrCouse = json_decode($row['risk_impact_no'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['description'];
			}
			$row['impact']=implode(', ',$arrCouse);
		}
		unset($row);
		$hasil['combo'] = $this->load->view('detail', ['data'=>$rows], true);
		
		echo json_encode($hasil);
	}
	
	function get_param(){
		$data['kel'] = $this->input->get('idmodal');
		$data['field'] = $data['field']=$this->crud->get_param($data['kel']);
		$result=$this->load->view('statis/list_param',$data,true);
		echo $result;
	}
	
	// function get_event_popup(){
		// $data['kel'] = $this->input->get('iddetail');
		// $data['field'] = $this->data->get_detail_event($data['kel']);
		// $result=$this->load->view('list_detail_event',$data,true);
		// echo $result;
	// }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */