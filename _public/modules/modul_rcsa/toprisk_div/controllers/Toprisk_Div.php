<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Toprisk_Div extends BackendController
{
	var $tmp_data = array();
	var $data_fields = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('data');
		$table = $this->config->item('tbl_suffix') . 'items';
	}

	public function index()
	{
		$data = array();
		$id = explode(",", $this->_Group_['owner_child']);
		$data = $this->data->get_data_risk_register($id);
		// Doi::dump($data);die();
		$data['propose'] = $this->load->view('register', $data, true);
		$this->template->build('view', $data);
	}


	function get_register()
	{
		$data = array();
		$id = explode(",", $this->_Group_['owner_child']);
		$data = $this->data->get_data_risk_register($id);
		$register = $this->load->view('register', $data, true);
		echo json_encode($register);
	}

	function propose()
	{
		// $id_rcsa = $this->input->post('rcsa_no');
		$id_urgency = $this->input->post('data');

		for ($i = 0; $i < count($id_urgency); $i++) {
			$this->data->prop($id_urgency[$i], ($i + 1));
		}

		$this->db->insert('log_propose', ['rcsa_no' => $id_rcsa[0], 'note' => '', 'petugas_no' => $this->authentication->get_Info_User("identifier"), 'keterangan' => 'Set top risk divisi', 'create_user' => $this->authentication->get_Info_User('username')]);

		echo json_encode('Success');
	}
}

/* End of file welcome.php */
