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
		$user=$this->authentication->get_Info_User();
		$this->owner=$user['group']['owner']['owner_no'];
		$this->tw=4;
		if ($this->input->get('triwulan')) {
            $this->tw = $this->input->get('triwulan');
        }
		if ($this->input->get('owner')) {
            $this->owner = $this->input->get('owner');
        }
		if ($this->input->get('periode')) {
            $this->periode = $this->input->get('periode');
        }
		$this->bln='November - Triwulan 4';
	}

	public function index()
	{
		$user=$this->authentication->get_Info_User();
		$data['owner']=$user['group']['owner']['owner_no'];
		$data = $this->data->getParamDrawKomposit();
 		$data['kompositData'] = $this->data->getKompositData();
		$data['realisasi'] = $this->db
		
		->where('owner', $this->owner)
		->where('tw', $this->tw)
			->get('bangga_indexkom_realisasi')
			->result_array();

			// $data['owner']=$this->owner;
			$data['tw']=$this->tw;
			$data['bln']=$this->bln;
			$data['periode']=$this->periode;
			
			$data['cboPeriod']    = $this->cbo_periode;
			$data['cboOwner']     = $this->cbo_parent;
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