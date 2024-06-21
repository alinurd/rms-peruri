<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Rcsa_Detail extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();

		$this->tbl_master='rcsa';
		_TBL_OWNER='owner';
		$this->tbl_period='period';
	}
	
	public function index()
	{	
		$id=$this->uri->segment(3);
		$data['judul']="APA KABAR DUNIA";
		$data['data']=$this->data->get_rist_detail($id);
		$this->template->build('risk_event_detail',$data); 
	}
	
	function listBox_STATUS($row, $value){
		if ($value=='1')
			$result='<span class="label label-success"> Aktif</span>';
		else
			$result='<span class="label label-warning"> Off</span>';
		
		return $result;
	}
	
	function cbo_owner(){
		$result=$this->crud->get_cbo('owner',array('id','name'));
		return $result;
	}
	
	function cbo_risk_type(){
		$result=$this->crud->get_cbo('risk_type',array('id','type'));
		return $result;
	}
	
	function cbo_period(){
		$result=$this->crud->get_cbo('period',array('id','periode_name'));
		return $result;
	}
	
	function get_parameters(){
		$id=intval($this->uri->segment(3));
		$data['data_edit']=$this->data->get_data($id);
		$data['cbo_owner']=$this->cbo_owner();
		$data['cbo_type']=$this->cbo_risk_type();
		$data['cbo_period']=$this->cbo_period();
		$result = $this->load->view('view_param',$data,true);
		return $result;
	}
	
	function update_OPTIONAL_CMD($id){
		$result[]='<a class="btn btn-warning btn-flat" style="width:100px;" data-content="Detail Risk Register" data-toggle="popover" href="'.base_url('rcsa/risk-event/'.$id).'" data-original-title="" title=""><strong style="text-shadow: 1px 2px #020202;">START<br/>RISK REGISTER</strong></a>';
		return $result;
	}
	function get_detail_risk(){
		$data=array();
		$content=$this->load->view('rcsa/risk_details',$data,true);
		echo $content;
	}
	
	function save_detail(){
		$post=$this->input->post();
		var_dump($post);
		echo "<br/>&nbsp;<br/>";
		var_dump($_FILES);
	}
	
	function risk_event(){
		$id=$this->uri->segment(3);
		$data=array();
		$data['judul']="APA KABAR DUNIA";
		$data['data']=$this->data->get_rist_detail($id);
		$this->template->build('risk_event_detail',$data); 
	}
	
	function get_data_source(){
		$kel=$this->input->get('idmodal');
		$data['tmp_asal']=$this->input->get('tbl');
		$data['jml']=$this->input->get('jml');
		if ($kel=='owner'){
			$data['field']=$this->data->get_data_owner();
			$data['kel']='owner';
			$content=$this->load->view('list_owner',$data,true);
		}elseif ($kel=='type'){
			$data['field']=$this->data->get_data_owner();
			$data['kel']='type';
			$content=$this->load->view('list_type',$data,true);
		}elseif ($kel=='couse'){
			$data['field']=$this->data->get_data_event(2);
			$data['kel']='couse';
			$content=$this->load->view('list_couse',$data,true);
		}elseif ($kel=='impact'){
			$data['field']=$this->data->get_data_event(3);
			$data['kel']='impact';
			$content=$this->load->view('list_impact',$data,true);
		}elseif ($kel=='event'){
			$data['field']=$this->data->get_data_event(1);
			$data['kel']='event';
			$content=$this->load->view('list_event',$data,true);
		}
		echo $content;
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$result = $this->data->save_param($id , $new_data);
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$result = $this->data->save_param($id , $new_data, $old_data);
		return $result;
	}
}