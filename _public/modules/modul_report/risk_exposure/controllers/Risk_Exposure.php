<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Risk_Exposure extends BackendController {
	var $tmp_data=array();
	var $data_fields=array();

	public function __construct()
	{
        parent::__construct();
		
		// $this->load->model('data');
		// $table=$this->config->item('tbl_suffix').'items';
	}

	public function index()
	{	
		$post=$this->input->post();
		if (!$post){
			$post = $this->session->userdata('post_exposure');
			if (!$post){
				$post['owner_no']=419;
				$post['period_no']=0;
				$post['type_no']=3;
			}
		}else{
			$this->session->set_userdata(array('post_exposure'=>$post));
		}
		// Doi::dump($post);
		$this->session->set_userdata(array('urutan_map_eksposure_inherent'=>array()));
		$this->session->set_userdata(array('urutan_map_eksposure_residual'=>array()));
		$this->load->library('map');
		$this->map->get_child($post);
		$data['cbo_owner']=$this->get_combo('parent-input');
		$data['cbo_period']=$this->get_combo('periode');
		$data['cbo_type']=$this->get_combo('type-project');
		$data['post']=$post;
		$data['setting']=$this->map->get_setting();
		$data['urut']=0;
		$this->_set_session_map_inherent(0, $post['owner_no'], 'map');
		$this->_set_session_map_residual(0, $post['owner_no'], 'map');
		$data['step']=$this->_get_step_map($data['urut'], 'inherent');
		$data['step_residual']=$this->_get_step_map($data['urut'], 'residual');
		$this->template->build('dashboard',$data); 
	}
	
	function _set_session_map_inherent($no, $isi, $type, $nama="", $mode="normal"){
		$data = $this->session->userdata('urutan_map_eksposure_inherent');
		$data[$no]['key']=$isi;
		$data[$no]['name']=$nama;
		$data[$no]['type']=$type;
		$data[$no]['mode']=$mode;
		
		$this->session->set_userdata(array('urutan_map_eksposure_inherent'=>$data));
	}
	
	function _set_session_map_residual($no, $isi, $type, $nama="", $mode="normal"){
		$data = $this->session->userdata('urutan_map_eksposure_residual');
		$data[$no]['key']=$isi;
		$data[$no]['name']=$nama;
		$data[$no]['type']=$type;
		$data[$no]['mode']=$mode;
		
		$this->session->set_userdata(array('urutan_map_eksposure_residual'=>$data));
	}
	
	function _get_session_map($no, $type="inherent"){
		$data = $this->session->userdata('urutan_map_eksposure_'.$type);
		if (is_array($data)){
			if (array_key_exists($no, $data)){
				$result = $data[$no]['key'];
			}else{
				$result=419;
			}
		}else{
			$result=419;
		}
		return $result;
	}
	
	function _get_step_map($urut, $type='inherent'){
		$data = $this->session->userdata('urutan_map_eksposure_'.$type);
		$result = '<ul class="steps">';
		$i=0;
		foreach($data as $key=>$row){
			$class="done";
			if ($urut==$key){
				$class="active";
			}elseif ($key>$urut){
				$class="undone";
			}
			if ($i==0){
				$ket="Home";
			}else{
				$ket="Level ".$i;
			}
			
			if($row['mode']=='detail'){
				$class .=' li_step_detail';
			}else{$class .= ' li_step';}
			$result .='<li class="'.$class.'" data-urut="'.++$i.'" data-type="'.$row['type'].'"  data-id="'.$row['key'].'" typemap="'.$type.'"><a href="#">'.$ket.'</a></li>';
		}
		$result .='</ul>';
		return $result;
	}
	
	function get_detail(){
		$id=$this->input->post('id');
		$owner=$this->input->post('owner');
		$data['type']=$this->input->post('type');
		$urut=intval($this->input->post('urut'))+1;
		$data['id']=$id;
		$data['urut']=$urut;
		$name="_set_session_map_".$data['type'];
		$this->$name($urut, $id, 'list');
		$arr_id = explode(',', $id);
		$this->data->set_officer_data();
		$data['field']=$this->data->get_data_owner($arr_id);
		$data['owner']=$this->data->get_owner_data($owner);
		$result['tabel']=$this->load->view("detail", $data, true);
		$result['step']=$this->_get_step_map($urut, $data['type']);
		
		echo json_encode($result);
	}
	
	public function get_next_risk()
	{	
		$id=$this->input->post('id');
		$urut=intval($this->input->post('urut'))+1;
		
		$post['owner_no']=$id;
		$post['period_no']=$this->input->post("period");
		$post['type_no']=$this->input->post("type_no");
			
		$this->load->library('map');
		
		$this->map->get_child($post);
		
		$data['type']=$this->input->post('type');
		$data['urut']=$urut;
		$name="_set_session_map_".$data['type'];
		$this->$name($urut, $id, 'map');
		$data['setting']=$this->map->get_setting();
		$result['tabel'] = $this->load->view('next_map',$data, true); 
		$result['step']=$this->_get_step_map($urut, $data['type']);
		echo json_encode($result);
	}
	
	function get_back_detail(){
		$urut=intval($this->input->post('urut'))-1;
		$data['type']=$this->input->post('type');
		$id=$this->_get_session_map($urut, $data['type']);
		$data['id']=$id;
		$data['urut']=$urut;
		$arr_id = explode(',', $id);
		$this->data->set_officer_data();
		$data['field']=$this->data->get_data_owner($arr_id);
		$owner=$this->data->get_id_owner();
		$data['owner']=$this->data->get_owner_data($owner);
		$result['tabel']=$this->load->view("detail", $data, true);
		$result['step']=$this->_get_step_map($urut, $data['type']);
		echo json_encode($result);
	}
	
	public function get_back_risk()
	{	
		$urut=intval($this->input->post('urut'))-1;
		$data['type']=$this->input->post('type');
		$id=$this->_get_session_map($urut, $data['type']);
		
		$post['owner_no']=$id;
		$post['period_no']=$this->input->post("period");
		$post['type_no']=$this->input->post("type_no");
			
		$this->load->library('map');
		$this->map->get_child($post);
		
		$data['urut']=$urut;
		
		$data['setting']=$this->map->get_setting();
		$result['tabel'] = $this->load->view('next_map',$data, true); 
		$result['step']=$this->_get_step_map($urut, $data['type']);
		echo json_encode($result);
	}
	
	function get_event_exposure(){
		if ($this->input->post())
			$post=$this->input->post();
		else 
			$post=array('owner_no'=>0);
		
		$type_map=$post['type_map'];
		$post=array('rcsa_no'=>$post['owner_no'], 'project_no'=>-1,'type_map'=>4,'type_dash'=>3);
		
		$data=$post;
		$urut=intval($this->input->post('urut'))+1;
		$data['urut']=$urut;
		$name="_set_session_map_".$type_map;
		$this->$name($urut, $post['rcsa_no'], 'map', '', 'detail');
		
		$this->data->set_officer_data();
		
		$data['setting']=$this->crud->get_setting($post);
		$data['type_dash']=0;
		$data['urut']=$urut;
		$data['type_map']=$type_map;
		$data['owner']=$this->data->get_owner_data($post['rcsa_no']);
		$result['tabel'] = $this->load->view('map_detail',$data, true);
		$result['step']=$this->_get_step_map($urut, $type_map);
		echo json_encode($result);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */