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
		$data['kompositData'] = $this->data->getKompositData();
		$data['realisasi'] = $this->db
			->get('bangga_indexkom_realisasi')
			->result_array();
		$data['levelKPMR'] = [
			['min' =>90, 'max' => 1000, 'label' => "Strong"],
			['min' => 85, 'max' => 90, 'label' => "Satisfactory"],
			['min' => 80, 'max' => 84, 'label' => "Fair"],
			['min' => 75, 'max' => 79, 'label' => "Marginal"],
			['min' => 0, 'max' => 74, 'label' => "Unsatisfactory"],
		];

		$data['levelKinerja'] = [
			['min' => 95, 'max' => 1000, 'label' => "Sangat Baik"],
			['min' => 90, 'max' => 95, 'label' => "Baik"],
			['min' => 80, 'max' => 89, 'label' => "Cukup"],
			['min' => 70, 'max' => 79, 'label' => "Kurang"],
			['min' => 0, 'max' => 70, 'label' => "Buruk"],
		];
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