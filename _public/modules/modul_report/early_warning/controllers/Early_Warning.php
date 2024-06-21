<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Early_Warning extends BackendController
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
		$jml = $this->_Group_['owner']['jml_child'];
		$data = $this->data->get_data_risk_register($id);
		$data['jml'] = $jml;
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
		$id_rcsa = $this->input->post('rcsa_no');
		$id_urgency = $this->input->post('data');
		$note = $this->input->post('note');
		$data['table'] = 'rcsa';
		$data['field']['sts_propose'] = 3;
		$data['field']['date_approve_kadiv'] = date('Y-m-d');
		$data['field']['user_approve_kadiv'] = $this->authentication->get_Info_User("identifier");
		$id_update = [];
		foreach ($id_rcsa as $id) {
			$id_update[$id] = $id;
		}
		$id_updatex = [];
		foreach ($id_update as $id) {
			$id_updatex[] = $id;
		}
		$this->db->where_in('id', $id_updatex);
		$this->db->update($data['table'], $data['field']);
		$this->db->insert('log_propose', ['rcsa_no' => $id_rcsa[0], 'note' => $note, 'petugas_no' => $this->authentication->get_Info_User("identifier"), 'keterangan' => 'Approve Risk Assessment', 'create_user' => $this->authentication->get_Info_User('username')]);
	}

	function revisi_propose()
	{
		$id_rcsa = $this->input->post('rcsa_no');
		$note = $this->input->post('note');
		$data['table'] = 'rcsa';
		$data['field']['sts_propose'] = 1;
		$data['field']['note_approve_kadep'] = $note;
		$data['field']['date_propose_kadep'] = date('Y-m-d');

		$this->db->where_in('id', $id_rcsa);
		$this->db->update($data['table'], $data['field']);
		$sts = $this->db->affected_rows();
		$this->db->insert('log_propose', ['rcsa_no' => $id_rcsa[0], 'note' => $note, 'petugas_no' => $this->authentication->get_Info_User("identifier"), 'keterangan' => 'Revisi to Kadep', 'create_user' => $this->authentication->get_Info_User('username')]);
		echo json_encode('Success');
	}
}

/* End of file welcome.php */
