<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Output_Index_Komposit extends BackendController
{
	var $type_risk = 0;
	var $table = "";
	var $post = array();
	var $sts_cetak = false;

	public function __construct()
	{
		$this->required = '<sup><span class="required"> *) </span></sup> ';

		parent::__construct();
		$this->cbo_status_action 	= $this->get_combo('status-action');
		$this->cbo_parent 			= $this->get_combo('parent-input');
		$this->cbo_owner 			= $this->get_combo('owner');
		$this->cbo_loss 			= [1 => 'Ya', 0 => 'Tidak'];
		$this->cbo_periode 			= $this->get_combo('periode');
 
	}

	public function index()
	{
		$user=$this->authentication->get_Info_User();
		$data['owner']=$user['group']['owner']['owner_no'];
		$data = $this->data->getParamDrawKomposit();
 		$data['kompositData'] = $this->data->getKompositData();
		$data['realisasi'] = $this->db
			->get('bangga_indexkom_realisasi')
			->result_array();
			$data[]= 
		$this->template->build('home', $data);
	}

	public function simpan(){
		$post 	= $this->input->post();

		$id = $this->data->simpan($post);

		echo json_encode($post);
 

	}
	
	 

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */