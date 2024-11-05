<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Kinerja extends BackendController
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

	public function index() { 
 		$data['kompositData'] = $this->data->getKompositData();
		 		$this->template->build('home', $data);
	}

	public function save(){
		$post 	= $this->input->post();

		$id = $this->data->simpan_realisasi($post);
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['detail'] = $this->db->where('id', $post['detail_rcsa_no'])->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['realisasi'] = $this->data->get_realisasi($post['detail_rcsa_no'], $post['bulan']);
		// $result['combo'] = $this->load->view('list-realisasi', $data, true);
		echo json_encode($data);


		
		// 	var_dump($simpan);
		// exit;
		// echo "<script>
		// 	alert('Berhasil proses data!');
		// 	window.location.href = '" . base_url("level_risiko/index") . "';
		// </script>";

	}
	
	public function simpan(){
		$post 	= $this->input->post();

		$id = $this->data->simpan($post);

		echo json_encode($post);

	}

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */