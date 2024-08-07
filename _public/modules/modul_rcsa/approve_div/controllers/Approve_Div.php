<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Approve_Div extends BackendController
{
	var $tmp_data = array();
	var $data_fields = array();

	public function __construct()
	{
		parent::__construct();
		// Doi::dump($this->authentication->get_info_user());
		$this->nil_tipe = 1;
		$this->set_Tbl_Master(_TBL_VIEW_RCSA);
		$this->cbo_periode = $this->get_combo('periode');
		$this->cbo_parent = $this->get_combo('parent-input');
		$this->cbo_parent_all = $this->get_combo('parent-input-all');
		$this->cbo_type = $this->get_combo('type-project');

		$this->set_Open_Tab('RCSA');
			$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 4));
			$this->addField(array('field' => 'owner_no','title'=>'Risk Owner', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => true, 'search' => true));
			$this->addField(array('field' => 'officer_no', 'show'=>false, 'save'=>true, 'default'=>$this->authentication->get_info_user('identifier')));
			$this->addField(array('field' => 'create_user', 'search' =>false, 'default'=>$this->authentication->get_info_user('username')));
			$this->addField(array('field' => 'period_no','title'=>'Periode',  'input' => 'combo', 'combo' => $this->cbo_periode, 'size' => 15, 'search' => true, 'required' => true));
			$this->addField(array('field' => 'anggaran_rkap', 'type'=>'float', 'size' => 100, 'required' => true, 'search' => false));
			$this->addField(array('field' => 'owner_pic', 'size' => 100, 'search' => false));
			$this->addField(array('field' => 'anggota_pic', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'tugas_pic', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'tupoksi', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'sasaran', 'type' => 'free', 'input' => 'free', 'mode' =>'e'));
			
			$this->addField(array('field' => 'item_use', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
			$this->addField(array('field' => 'register', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
			$this->addField(array('field' => 'status', 'input' => 'boolean', 'size' => 15));
			$this->addField(array('field' => 'name', 'show' => false));
			$this->addField(array('field' => 'periode_name', 'show' => false));
			$this->addField(array('field' => 'sts_propose_text', 'show' => false));
			$this->addField(array('field' => 'sts_propose', 'show' => false));
		$this->set_Close_Tab();
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master));

		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'anggaran_rkap', 'span_right_addon' => ' Rp ', 'align' => 'right'));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'create_user', 'readonly' => true));

		$this->set_Sort_Table($this->tbl_master, 'urut_owner');
		if ($this->id_param_owner['privilege_owner']['id'] > 1 && intval($this->id_param_owner['owner']['sts_owner'])==1) {
            $this->set_Where_Table($this->tbl_master, 'owner_no', 'in', $this->id_param_owner['owner_child']);
		}
		$use=$this->authentication->get_info_user('id');
		// doi::dump($use);
		$this->set_Where_Table($this->tbl_master, 'sts_propose', '=', 3);
		// $this->set_Where_Table($this->tbl_master, 'target_user', '=', $use);

		// $this->set_Table_List($this->tbl_master, 'id', 'target_user');
		// $this->set_Table_List($this->tbl_master, 'target_user', 'target user');
		$this->set_Table_List($this->tbl_master, 'name','Risk Owner');
		$this->set_Table_List($this->tbl_master, 'sasaran', 'Jumlah Sasaran', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'tupoksi', 'Jumlah Peristiwa', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'periode_name','Periode','8');
		$this->set_Table_List($this->tbl_master, 'sts_propose_text', 'Status Propose', 0, 'center');
		$this->set_Table_List($this->tbl_master, 'register', 'Risk Register', 10, 'center');

		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		$this->_CHANGE_TABLE_MASTER(_TBL_RCSA);

		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('delete', false);

		$this->set_Close_Setting();

	}

	public function MASTER_DATA_LIST($arrId, $rows)
	{
		$this->use_list = $this->data->cari_total_dipakai($arrId);
	}

	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows)
	{
		$id = $rows['l_id'];
		$url = base_url($this->modul_name . '/approval');
		$tombol['detail'] = array("default" => true, "url" => $url, "label" => "Approval");
		
		$tombol['delete'] = [];
		$tombol['edit'] = [];
		$tombol['print'] = [];
		$tombol['view'] = [];
		
		return $tombol;
	}

	function listBox_SASARAN($rows, $value){
		$id=$rows['l_id'];
		$jml='';
		if (array_key_exists($id, $this->use_list['sasaran'])){
			$jml = $this->use_list['sasaran'][$id];
		}

		return $jml;
	}
	function listBox_TUPOKSI($rows, $value){
		$id=$rows['l_id'];
		$jml='';
		if (array_key_exists($id, $this->use_list['peristiwa'])){
			$jml = $this->use_list['peristiwa'][$id];
		}

		return $jml;
	}

	public function approval()
	{
		$data = array();
		$id = explode(",", $this->_Group_['owner_child']);
		$id = $this->uri->segment(3);
		$jml = (array_key_exists('jml_child',$this->_Group_['owner']))?$this->_Group_['owner']['jml_child']:0;
		$data['field'] = $this->data->get_data_risk_register($id, "approval");
		// Doi::dump($data);
		$log = $this->db->where('rcsa_no', $id)->where('keterangan', "Propose to Kadiv")->get("bangga_log_propose")->row_array();
		$data['log'] = $log;
		$data['jml'] = $jml;
		$data['rcsa_no'] = $id;
		$data['propose'] = $this->load->view('register', $data, true);
		$this->template->build('view', $data);
	}
	function listBox_REGISTER($row, $value)
	{
		$id = $row['l_id'];
		$owner = $row['l_owner_no'];
		$result = '<i class="fa fa-search showRegister pointer" data-id="' . $id . '" data-owner="' . $owner . '"></i>';
		return $result;
	}

	function get_register()
	{
		$id_rcsa = $this->input->post('id');
		$owner_no = $this->input->post('owner_no');
		$data['field'] = $this->data->get_data_risk_register($id_rcsa, "showRegister");
		// $data['field'] = $this->data->get_data_risk_register_list($id_rcsa);
		$data['fieldxx'] = $this->data->get_data_risk_reg_acc($id_rcsa);
		$data['tgl'] = $this->data->get_data_tanggal($id_rcsa);

		$data['id_rcsa'] = $id_rcsa;
		$data['id'] = $id_rcsa;

		$parent_no = $this->data->get_data_parent($owner_no);
		$data['owner'] = $parent_no[0]['parent_no'];
		$data['divisi'] = $this->data->get_data_divisi($parent_no);
		$data['fields'] = $this->data->get_data_officer($id_rcsa);
		
		$data['tipe'] = 'cetak';
		$xx = array('field' => $data['field'], 'rcsa' => $data['id_rcsa']);
		$this->session->set_userdata('result_risk_register', $xx);

		$data['log'] = $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_LOG_PROPOSE)->result_array();
		$result['register'] = $this->load->view('list_risk_register', $data, true);
		echo json_encode($result);
	}

	// function get_register()
	// {
	// 	$data = array();
	// 	$id = explode(",", $this->_Group_['owner_child']);
	// 	$data = $this->data->get_data_risk_register($id);
	// 	$register = $this->load->view('register', $data, true);
	// 	echo json_encode($register);
	// }

	function propose()
	{
		$id_rcsa = $this->input->post('rcsa_no');
		$id_urgency = $this->input->post('rcsa_detail_no');
		$note = $this->input->post('note');
		$data['table'] = 'rcsa';
		$data['field']['sts_propose'] = 4;
		$data['field']['date_approve_kadiv'] = date('Y-m-d');
		$data['field']['user_approve_kadiv'] = $this->authentication->get_Info_User("identifier");
		$id_update = [];
		// foreach ($id_rcsa as $id) {
		// 	$id_update[$id] = $id;
		// }
		// $id_updatex = [];
		// foreach ($id_update as $id) {
		// 	$id_updatex[] = $id;
		// }
		$this->db->where('id', $id_rcsa);
		$this->db->update($data['table'], $data['field']);
		$this->db->insert('log_propose', ['rcsa_no' => $id_rcsa, 'note' => $note, 'petugas_no' => $this->authentication->get_Info_User("identifier"), 'keterangan' => 'Approve Risk Assessment', 'create_user' => $this->authentication->get_Info_User('username')]);
		
		$sts = $this->db->affected_rows();
		if ($sts) {
			for ($i = 0; $i < count($id_urgency); $i++) {
				$this->data->prop($id_urgency[$i], ($i + 1));
			}

			$this->db->insert('log_propose', ['rcsa_no' => $id_rcsa, 'note' => '', 'petugas_no' => $this->authentication->get_Info_User("identifier"), 'keterangan' => 'Approve RM', 'create_user' => $this->authentication->get_Info_User('username')]);

			echo json_encode('Success');
		} else {
			echo json_encode('Error');
		}
	}

	function revisi_propose()
	{
		$id_rcsa = $this->input->post('rcsa_no');
		$note = $this->input->post('note');
		$data['table'] = 'rcsa';
		$data['field']['sts_propose'] = 5;
		$data['field']['note_approve_kadep'] = $note;
		$data['field']['date_propose_kadep'] = date('Y-m-d');

		$this->db->where_in('id', $id_rcsa);
		$this->db->update($data['table'], $data['field']);
		$sts = $this->db->affected_rows();
		$this->db->insert('log_propose', ['rcsa_no' => $id_rcsa, 'note' => $note, 'petugas_no' => $this->authentication->get_Info_User("identifier"), 'keterangan' => 'Revisi from Kadiv to Risk Agent ', 'create_user' => $this->authentication->get_Info_User('username')]);
		echo json_encode('Success');
	}

	function show_riskRisContext(){
		$data['info']=$this->db->where('id', $this->input->post('id'))->get(_TBL_VIEW_RCSA)->row_array();
		$data['sasaran']=$this->db->where('rcsa_no', $this->input->post('id'))->get(_TBL_RCSA_SASARAN)->result_array();
		$data['internal']=$this->db->where('rcsa_no', $this->input->post('id'))->where('stakeholder_type', 1)->get(_TBL_RCSA_STAKEHOLDER)->result_array();
		$data['external']=$this->db->where('rcsa_no', $this->input->post('id'))->where('stakeholder_type', 2)->get(_TBL_RCSA_STAKEHOLDER)->result_array();
		$data['probabilitas']=$this->db->where('rcsa_no', $this->input->post('id'))->where('kriteria_type', 1)->get(_TBL_RCSA_KRITERIA)->result_array();
		$data['dampak']=$this->db->where('rcsa_no', $this->input->post('id'))->where('kriteria_type', 2)->get(_TBL_RCSA_KRITERIA)->result_array();

		$isi=$this->load->view('template/view-risk-context', $data, true);
		echo json_encode(['combo'=>$isi]);
	}
}

/* End of file welcome.php */
