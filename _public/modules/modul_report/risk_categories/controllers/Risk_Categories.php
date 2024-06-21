<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Risk_Categories extends BackendController {
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
		$data['korporasi'] = $this->get_combo('parent-input');
		$data['bulan']=$this->get_combo('bulan');
		$data['periode']=$this->get_combo('periode');
		$data['risk_context']=' - select -';
		$this->template->build('info', $data);
	}

	function get_riskcontext(){
		$owner=intval($this->input->post('owner'));
		$period=intval($this->input->post('period'));
		$this->data->owner_child=array();

		if ($owner>0){
			$this->data->owner_child[]=$owner;
		}

		$this->data->get_owner_child($owner);
		$owner_child=$this->data->owner_child;

		if ($owner_child){
			$this->db->where_in('owner_no',$owner_child);
		}else{
			$this->db->where('owner_no',$owner);
		}
		
		if ($period){
			$this->db->where_in('period_no',$period);
		}
		
		$rows = $this->db->get(_TBL_VIEW_RCSA)->result();

		$option = '<option value="0">'.lang('msg_cbo_select').'</option>';
		foreach($rows as $row){
			$option .= '<option value="'.$row->id.'">'.$row->tugas_pic.'</option>';
		}
		$result['combo']=$option;
		echo json_encode($result);
	}

	function get_grafik(){
		$this->data->post=$this->input->post();
		$data=$this->data->grafik();
		$data['post']=$this->input->post();
		$data['bulan']=$this->get_combo('bulan');
		$data['periode']=$this->get_combo('periode');
		$result['combo']=$this->load->view('grafik', $data, true);
		echo json_encode($result);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */