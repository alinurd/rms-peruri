<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Propose_Div extends BackendController
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
			$this->addField(array('field' => 'period_no','title'=>'Periode', 'input' => 'combo', 'combo' => $this->cbo_periode, 'size' => 15, 'search' => true, 'required' => true));
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
		$this->set_Where_Table($this->tbl_master, 'sts_propose', '=', 1);

		$this->set_Table_List($this->tbl_master, 'name','Risk Owner');
		$this->set_Table_List($this->tbl_master, 'sasaran', 'Jumlah Sasaran', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'tupoksi', 'Jumlah Peristiwa', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'periode_name','Periode','8');
		// $this->set_Table_List($this->tbl_master, 'sts_propose_text', 'Propose', 0, 'center');
		$this->set_Table_List($this->tbl_master, 'register', 'Risk Register', 10, 'center');

		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		$this->_CHANGE_TABLE_MASTER(_TBL_RCSA);

		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('delete', false);

		$this->set_Close_Setting();

	}

	function get_register()
	{
		$id_rcsa = $this->input->post('id');
		$owner_no = $this->input->post('owner_no');
		$data['field'] = $this->data->get_data_risk_register($id_rcsa);
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

	public function MASTER_DATA_LIST($arrId, $rows)
	{
		$this->use_list = $this->data->cari_total_dipakai($arrId);
	}

	function listBox_REGISTER($row, $value)
	{
		$id = $row['l_id'];
		$owner = $row['l_owner_no'];
		$result = '<i class="fa fa-search showRegister pointer" data-id="' . $id . '" data-owner="' . $owner . '"></i>';
		return $result;
	}

	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows)
	{
		$id = $rows['l_id'];
		$owner = $rows['l_owner_no'];

		$url = base_url($this->modul_name . '/propose');
		$tombol['detail'] = array("default" => true, "url" => $url, "label" => "Propose");
		
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

	public function propose()
	{
		$data = array();
		$id = $this->uri->segment(3);
		// doi::dump($id);
		$data = $this->data->get_data_risk_register($id);
		$owner = (is_array($data['field']) && !empty($data['field']))?$data['field'][0]['owner_no']:0;

		$data['sts_parent'] = 0;
		// Doi::dump($this->authentication->get_Info_User());die();
		// $id = explode(",", $this->_Group_['owner_child']);
		if($this->authentication->get_Info_User('is_admin')){
			$data['sts_parent'] = 1;
		}

		$parent = 0;
		if (array_key_exists('parent_no', $this->id_param_owner['owner']))
			$parent = intval($this->id_param_owner['owner']['parent_no']);
		if ($parent > 0) {
			$rows = $this->db->where('owner_no', $parent)->get(_TBL_OFFICER)->row();
			if ($rows)
				$data['sts_parent'] = 1;
		}

		$data['level_no'] = -1;
		if (array_key_exists('level_no', $this->_Group_['owner']))
			$data['level_no'] = $this->_Group_['owner']['level_no'];

		$data['rcsa_no'] = $id;
		$data['owner_no'] = $owner;
		$data['cboLike'] = $this->get_combo('likelihood');
		$data['cboImpact'] = $this->get_combo('impact');
		$data['master_level'] = $this->data->get_master_level();
		$data['propose'] = $this->load->view('register', $data, true);
		$this->template->build('view', $data);
	}

	function simpan_register()
	{
		$post = $this->input->post();
		foreach ($post['aksi'] as $key => $row) {
			$data['field'] = [];
			$data['table'] = 'rcsa_detail';
			$data['field']['inherent_likelihood'] = $post['like'][$key];
			$data['field']['inherent_impact'] = $post['impact'][$key];
			$data['field']['inherent_level'] = $post['level'][$key];

			$this->db->where('id', $post['detail'][$key]);
			$this->db->update($data['table'], $data['field']);

			$data['field'] = [];
			$data['table'] = 'rcsa_action';
			$data['field']['proaktif'] = $post['proaktif'][$key];
			$data['field']['reaktif'] = $post['reaktif'][$key];

			$this->db->where('id', $post['aksi'][$key]);
			$this->db->update($data['table'], $data['field']);
		}
		$hasil = ['Berhasil Update data'];
		return json_encode($hasil);
	}

	function send_email()
	{
		$email = $this->input->get('email');
		$id_rsca = $this->input->get('rsca');
		$data['email'] = $email;
		$data['subject'] = "Send Propose";
		$data['content'] = "Mengirim Email Propose<br>untuk melihat data silahkan klik link dibawah ini<br/><a href='http://202.152.1.190:8080/approve'> Link </a>";
		$result = Doi::kirim_email($data);
		$result = "berhasil";
		$data['table'] = 'rcsa';
		$data['type'] = 'update';
		$data['field']['sts_propose'] = 1;
		$data['field']['date_propose'] = date('Y-m-d');
		$data['where'] = array('id' => $id_rsca);
		$id = $this->crud->crud_data($data);
		echo $result;
	}

	function get_param()
	{
		$data['kel'] = $this->input->get('idmodal');
		$data['field'] = $data['field'] = $this->crud->get_param($data['kel']);
		$result = $this->load->view('statis/list_param', $data, true);
		echo $result;
	}

	// function get_register()
	// {
	// 	$data = array();
	// 	$id = explode(",", $this->_Group_['owner_child']);
	// 	$data = $this->data->get_data_risk_register($id);
	// 	$data['level_no'] = -1;
	// 	if (array_key_exists('level_no', $this->_Group_['owner']))
	// 		$data['level_no'] = $this->_Group_['owner']['level_no'];
	// 	$register = $this->load->view('register', $data, true);
	// 	echo json_encode($register);
	// }

	function save_propose()
	{

		$percek = [];
		$perdek = [];
		$id_rcsa = $this->input->post('rcsa_no');
		$peristiwa = $this->data->get_peristiwa($id_rcsa);
		foreach ($peristiwa as $key=>$row) {
			foreach ($row['detail'] as $ros) {
				$perdek['inherent_level'][] = $ros['inherent_level'];
				$perdek['risk_control'][] = $ros['risk_control'];
				$perdek['sts_next'][] = $ros['sts_next'];	
			}
		}
		// echo json_encode($perdek); 
		$cek1 = in_array(0, $perdek['inherent_level']);
		$cek2 = in_array("", $perdek['risk_control']);
		$cek3 = in_array("", $perdek['risk_control']);
		if ($cek1 && $cek2 && $cek3) {
			$percek['status'] = "Silahkan lengkapi Risk Analysis, Risk Evaluasi, dan Risk Treatment pada masing-masing Risk Identify. Klik OK untuk melengkapi!";

			echo json_encode($percek['status']);
			die();
		} 

		$id_urgency = $this->input->post('data');
		$note = $this->input->post('note');
		$data['table'] = 'rcsa';
		$data['field']['sts_propose'] = 2;
		$data['field']['note_approve_kadep'] = $note;
		$data['field']['date_propose_kadep'] = date('Y-m-d');
		$data['field']['user_approve_kadep'] = $this->authentication->get_Info_User("identifier");

		$this->db->where('id', $id_rcsa);
		$this->db->update($data['table'], $data['field']);

		$this->db->insert('log_propose', ['rcsa_no' => $id_rcsa, 'note' => $note, 'petugas_no' => $this->authentication->get_Info_User("identifier"), 'keterangan' => 'Propose to Kadiv', 'create_user' => $this->authentication->get_Info_User('username')]);
		$percek['status'] = 1;
		echo json_encode($percek['status']);
		// header('location:'.base_url('propose-div'));
	}

	function revisi_propose()
	{
		$id_rcsa = $this->input->post('rcsa_no');
		$note = $this->input->post('note');

		$data['table'] = 'rcsa';
		$data['field']['sts_propose'] = 0;
		$data['field']['note_approve_kadep'] = $note;
		$data['field']['date_propose_kadep'] = date('Y-m-d');

		$this->db->where_in('id', $id_rcsa);
		$this->db->update($data['table'], $data['field']);
		$this->db->affected_rows();

		
		
		$this->db->insert('log_propose', ['rcsa_no' => $id_rcsa, 'note' => $note, 'petugas_no' => $this->authentication->get_Info_User("identifier"), 'keterangan' => 'Revisi to Risk Agent', 'create_user' => $this->authentication->get_Info_User('username')]);
	
		// header('location:'.base_url('propose-div'));
		// echo json_encode('Success');
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
