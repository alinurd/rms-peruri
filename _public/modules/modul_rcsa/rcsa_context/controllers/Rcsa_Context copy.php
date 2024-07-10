<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Rcsa_Context extends BackendController
{
	var $table = "";
	var $post = array();
	var $sts_cetak = false;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('text');

		$this->load->model('Data'); //membuat load model data
		// Doi::dump($this->authentication->get_info_user());
		$this->nil_tipe = 1;
		$this->set_Tbl_Master(_TBL_VIEW_RCSA);
		$this->cbo_periode = $this->get_combo('periode');
		$this->cbo_parent = $this->get_combo('parent-input');
		$this->cbo_parent_all = $this->get_combo('parent-input-all');
		$this->cbo_type = $this->get_combo('type-project');
		$this->cbo_bulan = $this->get_combo('bulan');
		
		$this->set_Open_Tab('General Information');
		$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 4));
		$this->addField(array('field' => 'judul_assesment', 'size' => 100, 'search' => false));
		$this->addField(array('field' => 'owner_no', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => true, 'search' => true));
		$this->addField(array('field' => 'officer_no', 'show' => false, 'save' => true, 'default' => $this->authentication->get_info_user('identifier')));
		$this->addField(array('field' => 'create_user', 'search' => false, 'default' => $this->authentication->get_info_user('username')));
		$this->addField(array('field' => 'period_no', 'input' => 'combo', 'combo' => $this->cbo_periode, 'size' => 15, 'search' => true, 'required' => false));
		$this->addField(array('field' => 'anggaran_rkap', 'type' => 'float', 'input' => 'float', 'required' => true));
		$this->addField(array('field' => 'owner_pic', 'size' => 100, 'search' => false));
		$this->addField(array('field' => 'anggota_pic', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'tugas_pic', 'input' => 'multitext:sms', 'size' => 10000));
		$this->addField(array('field' => 'tupoksi','title'=>'Pekerjaan di luar Tupoksi', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'sasaran', 'title'=> 'Risk Appetite', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->addField(array('field' => 'tahun_rcsa', 'show' => false));
		$this->addField(array('field' => 'bulan_rcsa', 'show' => false));

		
		// $this->set_Open_Tab('Risk Appetite'); // implementasi_risiko
		// $this->addField(array('field' => 'appetite', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		// $this->set_Close_Tab();

		$this->set_Open_Tab('Rencana Implementasi MR'); // implementasi_risiko
		$this->addField(array('field' => 'implementasi_risiko', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->set_Close_Tab();
		
		$this->addField(array('field' => 'item_use', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
		$this->addField(array('field' => 'register', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
		$this->addField(array('field' => 'status', 'input' => 'boolean', 'size' => 15));
		$this->addField(array('field' => 'name', 'show' => false));
		$this->addField(array('field' => 'periode_name', 'show' => false));
		$this->addField(array('field' => 'sts_propose_text', 'show' => false));
		$this->addField(array('field' => 'sts_propose', 'show' => false));
		$this->set_Close_Tab();

		$this->set_Open_Tab('Isu Internal');
		$this->addField(array('field' => 'man', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'method', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'machine', 'input' => 'multitext',  'size' => 10000));
		$this->addField(array('field' => 'money', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'material', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'market', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'stakeholder_internal', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->set_Close_Tab();

		$this->set_Open_Tab('Isu External');
		$this->addField(array('field' => 'politics', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'economics', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'social', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'tecnology','title' => 'Technology', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'environment','title' => 'Environment', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'legal', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'stakeholder_external', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->set_Close_Tab();

		$this->set_Open_Tab('Kriteria Kemungkinan Risiko ');
		$this->addField(array('field' => 'kriteria_kemungkinan_risiko', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->set_Close_Tab();
		
		$this->set_Open_Tab('Kriteria Dampak Risiko ');
		$this->addField(array('field' => 'kriteria_dampak_risiko', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->set_Close_Tab();

		$this->set_Open_Tab('Dokumen Lainnnya');
		$this->addField(array('field' => 'nm_file', 'input' => 'upload', 'path' => 'regulasix', 'file_type' => 'pdf|pdfx|PDF|docx|doc|', 'file_random' => false));
		$this->set_Close_Tab();
		// $this->addField(array('field' => 'copy', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));



		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master));

		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'anggaran_rkap', 'span_right_addon' => ' Rp ', 'align' => 'right'));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'create_user', 'readonly' => true));

		// $this->set_Sort_Table($this->tbl_master, 'bulan_rcsa','DESC');
		$this->set_Sort_Table($this->tbl_master, 'name', 'ASC');
		$this->set_Table_List($this->tbl_master, 'judul_assesment', 'Judul Assessment ', 25);
		$this->set_Table_List($this->tbl_master, 'name', 'Risk Owner', 20);
		// $this->set_Table_List($this->tbl_master, 'sasaran', 'Jml Sasaran', 5, 'center');
		// $this->set_Table_List($this->tbl_master, 'tupoksi', 'Jml Peristiwa', 5, 'center');
		$this->set_Table_List($this->tbl_master, 'periode_name', 'Periode', 5, 'center');
		// $this->set_Table_List($this->tbl_master, 'copy', 'Copy Data', 5, 'center');
		// $this->set_Table_List($this->tbl_master, 'sts_propose_text', 'Propose', 0, 'center');
		// $this->set_Table_List($this->tbl_master, 'item_use', '', 8, 'center');
		// $this->set_Table_List($this->tbl_master, 'register', 'Risk Register', 5, 'center');

		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		// $this->set_Where_Table($this->tbl_master, 'type', '=', $this->nil_tipe);
		$this->_CHANGE_TABLE_MASTER(_TBL_RCSA);

		$this->set_Close_Setting();
	}

	// function update_OPTIONAL_CMD($id, $row)
	// {
	// 	$owner = $row['l_owner_no'];
	// 	$result[] = array('posisi' => 'right', 'content' => '<a class="btn btn-warning btn-flat" style="width:100%;" data-content="Detail Risk Register" data-toggle="popover" href="' . base_url($this->modul_name . '/risk-event/' . $owner . '/' . $id) . '" data-original-title="" title=""><strong style="text-shadow: 1px 2px #020202;">START<br/>Risk Register</strong></a>');
	// 	return $result;
	// }
	function listBox_COPY($rows, $value)
	{

		$id = $rows['l_id'];

		// $result = '<button class="btn btn-warning" id="btn_unlock" type="button" data-url="'.base_url($this->modul_name . '/unlock_approval/').'"> </button>';

		$result = '<a class="btn btn-warning btn-flat" style="width:100%;" data-content="Detail Risk Register" data-toggle="popover" href="' . base_url($this->modul_name . '/copy/' . $id) . '" data-original-title="" title="Copy Risk Contex"> <i class="fa fa-copy"></i>Copy Data </a>';

		return $result;
	}
	 
	function updateBox_KRITERIA_KEMUNGKINAN_RISIKO($field)
	{
		$content = $this->get_kriteria_kemungkinan_risiko();
		return $content;
	}
	function insertBox_KRITERIA_KEMUNGKINAN_RISIKO($field)
	{
		$content = $this->get_kriteria_kemungkinan_risiko();
		return $content;
	}
	function get_kriteria_kemungkinan_risiko($id = 0)
	{
		$data['kriteria'] = [1 => [
			'name' => 'Sangat Kecil',
			'color' => 'green',
		], 2 => [
			'name' => 'Kecil',
			'color' => 'lightgreen'
		], 3 => [
			'name' => 'Sedang',
			'color' => 'yellow'
		], 4 => [
			'name' => 'Besar',
			'color' => 'orange'
		], 5 => [
			'name' => 'Sangat Besar',
			'color' => 'red'
		]];
		$data['kemungkinan'] = $this->db->where('kelompok', 'kriteria-kemungkinan')->get(_TBL_DATA_COMBO)->result_array();

		$result = $this->load->view('krit_kemungkinan',  $data, true);
		return $result;
	}
	function updateBox_KRITERIA_DAMPAK_RISIKO($field)
	{
		$content = $this->get_kriteria_dampak_risiko();
		return $content;
	}
	function insertBox_KRITERIA_DAMPAK_RISIKO($field)
	{
		$content = $this->get_kriteria_dampak_risiko();
		return $content;
	}

	function get_kriteria_dampak_risiko($id = 0)
	{
		$data['kriteria'] = [1 => [
			'name' => 'Sangat Kecil',
			'color' => 'green',
		], 2 => [
			'name' => 'Kecil',
			'color' => 'lightgreen'
		], 3 => [
			'name' => 'Sedang',
			'color' => 'yellow'
		], 4 => [
			'name' => 'Besar',
			'color' => 'orange'
		], 5 => [
			'name' => 'Sangat Besar',
			'color' => 'red'
		]];
		$data['dampak'] = $this->db->where('kelompok', 'kriteria-dampak')->get(_TBL_DATA_COMBO)->result_array();
		// $data['field'] = $this->db->where('risiko_no', $id)->get(_TBL_SUBRISIKO)->result_array();
		$result = $this->load->view('krit_dampak',  $data, true);
		return $result;
	}

	public function MASTER_DATA_LIST($arrId, $rows)
	{
		$this->use_list = $this->data->cari_total_dipakai($arrId);
	}
	function listBox_PERIODE_NAMEx($rows, $value)
	{
		$value .= '<br/>' . $this->cbo_bulan[$rows['l_bulan_rcsa']] . ' - ' . $rows['l_tahun_rcsa'];
		return $value;
	}
	function listBox_SASARAN($rows, $value)
	{
		$id = $rows['l_id'];
		$jml = '';
		if (array_key_exists($id, $this->use_list['sasaran'])) {
			$jml = $this->use_list['sasaran'][$id];
		}

		return $jml;
	}

	function listBox_TUPOKSI($rows, $value)
	{
		$id = $rows['l_id'];
		$jml = '';
		if (array_key_exists($id, $this->use_list['peristiwa'])) {
			$jml = $this->use_list['peristiwa'][$id];
		}

		return $jml;
	}

	function listBox_STS_PROPOSE_TEXT($row, $value)
	{
		$nilai = intval($row['l_sts_propose']);
		$id = $row['l_id'];
		$jml = '';
		if (array_key_exists($id, $this->use_list['peristiwa'])) {
			$jml = $this->use_list['peristiwa'][$id];
		}
		if (empty($jml)) {
			$hasil = '';
		} else {
			switch ($nilai) {
				case 1:
					$hasil = '<span class="label label-info"> ' . $value . ' </span>';
					break;
				case 2:
					$hasil = '<span class="label label-success"> ' . $value . ' </span>';
					break;
				case 3:
					$hasil = '<span class="label label-warning"> ' . $value . ' </span>';
					break;
				case 4:
					$hasil = '<span class="label label-primary"> ' . $value . ' </span>';
					break;
				default:
					$hasil = '<a href="' . base_url('rcsa/propose/' . $row['l_id']) . '"><span class="label label-danger"> ' . $value . ' </span></a>';
					break;
			}
		}
		return $hasil;
		// return $nilai;
	}

	function propose()
	{
		$id = $this->uri->segment(3);
		$data = $this->data->get_data_risk_register_propose($id);
		$data['id_rcsa'] = $id;
		$this->template->build('register', $data);
	}

	public function copy()
	{
		$id = $this->uri->segment(3);
		$data['rcsa'] = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA)->row_array();
		$data['sasaran'] = $this->db->where('rcsa_no', $id)->get(_TBL_RCSA_SASARAN)->result_array();
   
		$disable='disabled';
 		$data['judul'] = form_input('cjudul', ($data['rcsa']) ? $data['rcsa']['judul_assesment'] : '', 'class="form-control disable" style="width:100%;" id="cjudul"'.$disable);
 		$data['cboowner'] = form_dropdown('owner_no', $this->cbo_parent, ($data['rcsa']) ? $data['rcsa']['owner_no'] : '', 'class="form-control select2 disable"  style="width:100%;"id="cowner"' . $disable);
		$data['tahun'] = form_dropdown('ctahun', $this->cbo_periode, '', 'class="form-control select2" style="width:100%;" id="ctahun"');
		$data['id'] = form_hidden(['id' => $id]);
		$data['detail'] = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		// $field = $this->load->view('copi', $data, true);
		$this->template->build('copi', $data);
		// doi::dump($id);

		// echo json_encode($hasil);
	}


	function simpan_copy() {
		$post = $this->input->post();
		$rcsa = $this->db->where('id', $post['id'])->get(_TBL_RCSA)->row_array();
	
		// Prepare updated RCSA data
		$upd = [
			'period_no' => $post['ctahun'],
			'sts_propose' => 0,
			'date_propose' => '',
			'date_propose_kadep' => '',
			'date_approve_kadiv' => '',
			'date_approve_admin' => '',
			'user_approve' => '',
			'user_approve_kadep' => '',
			'user_approve_kadiv' => '',
			'user_approve_rm' => '',
			'note_approve_kadep' => '',
			'note_approve_kadiv' => '',
			'note_approve_admin' => '',
			'approve_kadep' => '',
			'create_user' => $this->authentication->get_info_user('username')
		];
	
		foreach ($rcsa as $indexarray => $data) {
			if (!in_array($indexarray, ['period_no', 'id', 'sts_propose', 'date_approve_kadiv', 'date_approve_admin', 'user_approve', 'user_approve_kadep', 'user_approve_kadiv', 'user_approve_rm', 'note_approve_kadep', 'note_approve_kadiv', 'note_approve_admin', 'approve_kadep', 'create_user'])) {
				$upd[$indexarray] = $data;
			}
		}
	
		// Insert new RCSA record
		$this->crud->crud_data(['table' => _TBL_RCSA, 'field' => $upd, 'type' => 'add']);
		$rcsa_no = $this->db->insert_id();
	
		// Copy implementasi data
		$arrimplementasi = $this->db->where('rcsa_no', $post['id'])->get(_TBL_RCSA_IMPLEMENTASI)->result_array();
		foreach ($arrimplementasi as $implementasi) {
			$upimplementasi = [];
			foreach ($implementasi as $indexarrayx => $data) {
				if (!in_array($indexarrayx, ['create_user', 'id'])) {
					$upimplementasi[$indexarrayx] = $data;
				}
			}
			$upimplementasi['rcsa_no'] = $rcsa_no;
			$upimplementasi['create_user'] = $this->authentication->get_info_user('username');
			$this->crud->crud_data(['table' => _TBL_RCSA_IMPLEMENTASI, 'field' => $upimplementasi, 'type' => 'add']);
		}
	
		// Copy detail data and related entities
		$arrdetail = $this->db->where('rcsa_no', $post['id'])->get(_TBL_RCSA_DETAIL)->result_array();
		$mapUpdSasaran = [];
	
		foreach ($arrdetail as $detail) {
			$updetail = [];
			foreach ($detail as $index => $data) {
				if (!in_array($index, ['rcsa_no', 'sasaran_no', 'id'])) {
					$updetail[$index] = $data;
				}
			}
			$updetail['rcsa_no'] = $rcsa_no;
			$updetail['create_user'] = $this->authentication->get_info_user('username');
	
			// Insert updated detail into the database
			$this->crud->crud_data(['table' => _TBL_RCSA_DETAIL, 'field' => $updetail, 'type' => 'add']);
			$dedetailtid = $this->db->insert_id();
	
			// Fetch and process sasaran
			$sasaran = $this->db->where('rcsa_no', $post['id'])->where('detail_no', $detail['id'])->get("bangga_view_sasaran_detail")->row_array();
			$upSasaran = [];
			foreach ($sasaran as $index => $data) {
				if (!in_array($index, ['create_user', 'id', 'event_no', 'kategori_no', 'sub_kategori', 'detail_no'])) {
					$upSasaran[$index] = $data;
				}
			}

			$upSasaran['rcsa_no'] = $rcsa_no;
			$upSasaran['create_user'] = $this->authentication->get_info_user('username');
			$sasaran_no = $this->crud->crud_data(['table' => _TBL_RCSA_SASARAN, 'field' => $upSasaran, 'type' => 'add']);
	
			// Update mapUpdSasaran
			if (empty($mapUpdSasaran) || $sasaran['detail_no'] != $mapUpdSasaran[count($mapUpdSasaran) - 1]["referensi"]["detail_id"]) {
				$mapUpdSasaran[] = [
					"referensi" => [
						"detail_id" => $sasaran['detail_no'],
						"sasaran_no" => $sasaran['id'],
					],
					"databaru" => [
						"detail_id" => $dedetailtid,
						"sasaran_no" => $sasaran_no,
					]
				];
			}
	
			// Process actions related to the detail
			$arraction = $this->db->where('rcsa_detail_no', $detail['id'])->get(_TBL_RCSA_ACTION)->result_array();
			foreach ($arraction as $action) {
				$upaction = [];
				foreach ($action as $index => $data) {
					if (!in_array($index, ['rcsa_detail_no', 'id'])) {
						$upaction[$index] = $data;
					}
				}
				$upaction['rcsa_detail_no'] = $dedetailtid;
				$upaction['create_user'] = $this->authentication->get_info_user('username');
				$this->crud->crud_data(['table' => _TBL_RCSA_ACTION, 'field' => $upaction, 'type' => 'add']);
			}
	
			// Process KRI related to the detail
			$arrkri = $this->db->where('rcsa_detail', $detail['id'])->get(_TBL_KRI)->result_array();
			foreach ($arrkri as $kri) {
				$upkri = [];
				foreach ($kri as $index => $data) {
					if (!in_array($index, ['rcsa_detail', 'rcsa_no', 'id'])) {
						$upkri[$index] = $data;
					}
				}
				$upkri['rcsa_detail'] = $dedetailtid;
				$upkri['rcsa_no'] = $rcsa_no;
				$upkri['create_user'] = $this->authentication->get_info_user('username');
				$this->crud->crud_data(['table' => _TBL_KRI, 'field' => $upkri, 'type' => 'add']);
			}
		}
	
		// Update sasaran_no in new details
		doi::dump($mapUpdSasaran);die;
		$upSasaranBaru = [];
		foreach ($mapUpdSasaran as $entry) {
			$wr['id'] = $entry['databaru']['detail_id'];
			$upSasaranBaru['sasaran_no'] = $entry['databaru']['sasaran_no'];
			$this->crud->crud_data(['table' => _TBL_RCSA_DETAIL, 'field' => $upSasaranBaru, 'where' => $wr, 'type' => 'update']);
		}
	
		// Copy stakeholders data
		foreach ([1, 2] as $type) {
			$arrstakeholder = $this->db->where('stakeholder_type', $type)->where('rcsa_no', $post['id'])->get(_TBL_RCSA_STAKEHOLDER)->result_array();
			foreach ($arrstakeholder as $detail) {
				$upStak = [];
				foreach ($detail as $indexarray => $data) {
					if (!in_array($indexarray, ['rcsa_no', 'id'])) {
						$upStak[$indexarray] = $data;
					}
				}
				$upStak['rcsa_no'] = $rcsa_no;
				$upStak['create_user'] = $this->authentication->get_info_user('username');
				$this->crud->crud_data(['table' => _TBL_RCSA_STAKEHOLDER, 'field' => $upStak, 'type' => 'add']);
			}
		}
	
		// Redirect to RCSA list
		header('location:' . base_url('rcsa'));
	}
	

	function simpan_propose()
	{
		$id_rcsa = $this->input->post('id_rcsa');
		$id_urgency = $this->input->post('data');
		$note = $this->input->post('note');

		$data['table'] = 'rcsa';
		$data['type'] = 'update';
		$data['field']['sts_propose'] = 1;
		$data['field']['date_propose'] = date('Y-m-d');
		$data['field']['user_approve'] = $this->authentication->get_Info_User("identifier");
		$data['where'] = array('id' => $id_rcsa);

		$this->crud->crud_data($data);
		$this->db->insert('log_propose', ['rcsa_no' => $id_rcsa, 'note' => $note, 'petugas_no' => $this->authentication->get_Info_User("identifier"), 'keterangan' => 'Propose to Kadep', 'create_user' => $this->authentication->get_Info_User('username')]);

		header('location:' . base_url('rcsa'));
	}

	function listBox_REGISTER($row, $value)
	{
		$id = $row['l_id'];
		$owner = $row['l_owner_no'];
		$result = '<i class="fa fa-search showRegister pointer" data-id="' . $id . '" data-owner="' . $owner . '"></i>';
		return $result;
	}

	function insertBox_SASARAN($field)
	{
		$content = $this->get_sasaran();
		return $content;
	}

	function updateBox_SASARAN($field, $row, $value)
	{
		$content = $this->get_sasaran();
		return $content;
	}

	function get_sasaran($id = 0)
	{
		$id = $this->uri->segment(3);
		$data['field'] = $this->db->where('rcsa_no', $id)->get(_TBL_RCSA_SASARAN)->result_array();
		$result = $this->load->view('sasaran', $data, true);
		return $result;
	}

	function insertBox_STAKEHOLDER_INTERNAL($field)
	{
		$content = $this->get_stakeholder(1);
		return $content;
	}

	function updateBox_STAKEHOLDER_INTERNAL($field, $row, $value)
	{
		$content = $this->get_stakeholder(1);
		return $content;
	}

	function insertBox_STAKEHOLDER_EXTERNAL($field)
	{
		$content = $this->get_stakeholder(2);
		return $content;
	}

	function updateBox_STAKEHOLDER_EXTERNAL($field, $row, $value)
	{
		$content = $this->get_stakeholder(2);
		return $content;
	}
	// implementasi_risiko
	function insertBox_IMPLEMENTASI_RISIKO($field)
	{
		$content = $this->get_implementasi();
		return $content;
	}

	function updateBox_IMPLEMENTASI_RISIKO($field, $row, $value)
	{
		$content = $this->get_implementasi();
		return $content;
	}
	function insertBox_KRITERIA_PROBABILITAS($field)
	{
		$content = $this->get_kriteria(1);
		return $content;
	}

	function updateBox_KRITERIA_PROBABILITAS($field, $row, $value)
	{
		$content = $this->get_kriteria(1);
		return $content;
	}
	function insertBox_KRITERIA_DAMPAK($field)
	{
		$content = $this->get_kriteria(2);
		return $content;
	}

	function updateBox_KRITERIA_DAMPAK($field, $row, $value)
	{
		$content = $this->get_kriteria(2);
		return $content;
	}

	function get_kriteria($type1 = 1, $id = 0)
	{
		$id = $this->uri->segment(3);
		$data['field'] = $this->db->where('kriteria_type', $type1)->where('rcsa_no', $id)->get(_TBL_RCSA_KRITERIA)->result_array();
		$data['type1'] = $type1;
		$result = $this->load->view('kriteria', $data, true);
		return $result;
	}

	function get_stakeholder($type = 1, $id = 0)
	{
		$id = $this->uri->segment(3);
		$data['field'] = $this->db->where('stakeholder_type', $type)->where('rcsa_no', $id)->get(_TBL_RCSA_STAKEHOLDER)->result_array();
		$data['type'] = $type;
		$result = $this->load->view('stakeholder', $data, true);
		return $result;
	}
	function get_implementasi()
	{
		$id = $this->uri->segment(3);
		$mode= $this->uri->segment(2);
		$data['id'] = $id;
		$data['mode'] = $mode;
		$data['combo'] = $this->db
			->where('kelompok', 'implementasi')
			->order_by('kode', 'asc')
			->get(_TBL_DATA_COMBO)
			->result_array();
		
		$result = $this->load->view('implementasi', $data, true);
		return $result;
	}

public function POST_CHECK_BEFORE_INSERT($data)
	{
		$files = $_FILES;
		$result = true;
		$errors = [];
 		if($files['l_nm_file']['type']){
			if($files['l_nm_file']['type'] !="application/pdf")
		// }
		$pesan = "format". $files['l_nm_file']['type']."tidak didukung";


		}

		if (!empty($pesan)){
			$this->session->set_userdata('result_proses_error', $pesan);

			// $this->session->set_userdata(array('result_proses_error'=>$pesan));
			return FALSE;
		}else{
			return TRUE;
		}
	}

	function POST_CHECK_BEFORE_UPDATE($new_data, $old_data){
		$files = $_FILES;

		$result=true;
		if($files['l_nm_file']['name']){
			if ($files['l_nm_file']['name'] !== $old_data['l_username'])
		$files = $_FILES;
		// $result = true;
		$errors = [];
 		if($files['l_nm_file']['type']){
			if($files['l_nm_file']['type'] !="application/pdf")
		// }
		$pesan = "format". $files['l_nm_file']['type']."tidak didukung";


		}

		if (!empty($pesan)){
			$this->session->set_userdata('result_proses_error', $pesan);

			// $this->session->set_userdata(array('result_proses_error'=>$pesan));
			 $result=FALSE;
		}else{
			 $result=TRUE;
			}
		}else{
			$result=TRUE;

		}
		


		return $result;
	}



	function POST_INSERT_PROCESSOR($id, $new_data)
	{
		$result = $this->data->save_detail($id, $new_data, 'new');
		return $result;
	}

	function POST_UPDATE_PROCESSOR($id, $new_data, $old_data)
	{
		$result = $this->data->save_detail($id, $new_data, 'edit', $old_data);
		return $result;
	}

	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows)
	{
		$tombol['print'] = [];
		$id = $rows['l_id'];
		$owner = $rows['l_owner_no'];
		// $url = base_url($this->modul_name . '/risk-event/'.$id.'/'.$owner);
		$url = base_url($this->modul_name . '/copy/' . $id);
		// $tombol['detail'] = array("default" => true, "url" => $url, "label" => "Start Risk Register");
		// $tombol['edit'] = ['default' => false, 'url' => base_url($this->_Snippets_['modul'] . '/edit'), 'label' => 'Edit'];
		// $id = $rows['l_id'];

		// $result = '<button class="btn btn-warning" id="btn_unlock" type="button" data-url="'.base_url($this->modul_name . '/unlock_approval/').'"> </button>';

		// $result = '<a   href="' . base_url($this->modul_name . '/copy/' . $id) . '" data-original-title="" title="Copy Risk Contex"> <i class="fa fa-copy"></i>Copy Data </a>';

		// return $result;
		if (array_key_exists($id, $this->use_list)) {
			if ($this->use_list[$id]['jml'] > 0)
				$tombol['delete'] = [];
		}
		$tombol['copy'] = ['default' => false, 'url' => $url, 'label' => '<a   href="' . base_url($this->modul_name . '/copy/' . $id) . '"title="Duplikat Risk Contex"></i>Copy'];

		return $tombol;
	}

	function risk_event()
	{
		$owner = intval($this->uri->segment(3));
		$id = intval($this->uri->segment(4));
		$data['parent'] = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($id);
		$data['list'] = $this->load->view('list-peristiwa', $data, true);
		$this->template->build('risk-event', $data);
	}

	function add_peristiwa()
	{
		$id_rcsa = $this->input->post('id');
		$id_edit = $this->input->post('edit');
		$rows = $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_RCSA_SASARAN)->result_array();
		$data['sasaran'] = ['- select -'];
		foreach ($rows as $row) {
			$data['sasaran'][$row['id']] = $row['sasaran'];
			$data['statement'][$row['id']] = $row['statement'];
			$data['appetite'][$row['id']] = $row['appetite'];
			$data['tolerance'][$row['id']] = $row['tolerance'];
			$data['limit'][$row['id']] = $row['limit'];
		}

		$couse = [];
		$impact = [];
		$detail = [];
		$sub = [];
		$event = [];
		if ($id_edit > 0) {

			$detail = $this->db->where('id', $id_edit)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
			if ($detail) {
				// doi::dump($detail);
				$couse = json_decode($detail['risk_couse_no'], true);
				$couse_implode = implode(", ", $couse);

				$impact = json_decode($detail['risk_impact_no'], true);
				$impact_implode = implode(", ", $impact);

				$peristiwa = $this->db->where('id', $detail['event_no'])->where('status', 1)->order_by('description')->get(_TBL_LIBRARY)->result_array();
				if ($couse)
					$couse = $this->db->query("SELECT *
					FROM bangga_library
					WHERE id IN ($couse_implode)
					ORDER BY FIELD(id,	$couse_implode)")->result_array(); //$this->db->where_in('id', $couse)->get(_TBL_LIBRARY)->result_array();


				if ($impact)
					$impact = $this->db->query("SELECT *
					FROM bangga_library
					WHERE id IN ($impact_implode)
					ORDER BY FIELD(id,	$impact_implode)")->result_array(); //$this->db->where_in('id', $impact)->get(_TBL_LIBRARY)->result_array();
			}
			$sql = $this->db
				->select('*')
				->from(_TBL_RISK_TYPE)
				->where('kelompok', intval($detail['kategori_no']))
				->where('id > ', 0)
				->get()
				->result_array();
			foreach ($sql as $q) {
				$sub[$q['id']] = $q['type'];
			}
		}
		$sql = $this->db->where('type', 1)->where('status', 1)->order_by('description')->get(_TBL_LIBRARY)->result();
		$no = 0;
		foreach ($sql as $q) {
			$a = $q->description;
			$b = word_limiter($a, 30, '');

			$event[$q->id] = '- ' . $b;
		}

		$data['kategori'] = $this->get_combo('data-combo', 'kel-library');
		$data['sub_kategori'] = $sub;
		$data['area'] = $this->get_combo('parent-input');
		$data['rcsa_no'] = $id_rcsa;
		$data['events'] = $event;
		$data['np'] = $this->get_combo('negatif_poisitf');

		$tblperistiwa = '<table class="table peristiwa" id="tblperistiwa"><tbody>';
		if ($peristiwa) :
			foreach ($peristiwa as $key => $crs) :
				$tambah = '';
				$del = '';
				if ($key == 0) {
					$tambah = '  | <i class="fa fa-plus add-event text-danger pointer"></i>';
					$del = 'del-event ';
				}
				$tblperistiwa .= '<tr class="browse-event"><td style="padding-left:0px;">' . form_textarea('risk_event[]', $crs['description'], " readonly='readonly'  id='risk_event' maxlength='500' size=500 class='form-control' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_event_no[]' => $crs['id']]) . '</td><td class="text-center" width="10%"><i class="fa fa-search browse-event text-primary pointer"></i>  </td></tr>';
			endforeach;
		else :
			$tblperistiwa .= '<tr class="browse-event"><td style="padding-left:0px;">' . form_textarea('risk_event[]', '', " readonly='readonly'  id='risk_event' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_event_no[]' => 0]) . '</td><td class="text-center"  width="10%"><i class="fa fa-search browse-event text-primary pointer"></i> </td></tr>';
		endif;
		$tblperistiwa .= '</tbody></table>';


		$tblCouse = '<table class="table couse" id="tblCouse"><tbody>';
		if ($couse) :
			foreach ($couse as $key => $crs) :
				$tambah = '';
				$del = '';
				if ($key == 0) {
					$tambah = '  | <i class="fa fa-plus add-couse text-danger pointer"></i>';
					$del = 'del-couse ';
				}
				$tblCouse .= '<tr><td style="padding-left:0px;">' . form_textarea('risk_couse[]', $crs['description'], " readonly='readonly'  id='risk_couse' maxlength='500' size=500 class='form-control  browse-couse' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_couse_no[]' => $crs['id']]) . '</td><td class="text-center" width="10%"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash text-success ' . $del . 'pointer"></i>' . $tambah . '</td></tr>';
			endforeach;
		else :
			$tblCouse .= '<tr><td style="padding-left:0px;">' . form_textarea('risk_couse[]', '', " readonly='readonly'  id='risk_couse' maxlength='500' size=500 class='form-control  browse-couse' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_couse_no[]' => 0]) . '</td><td class="text-center"  width="10%"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash text-success del-couse pointer"></i>  | <i class="fa fa-plus add-couse text-danger pointer"></i></td></tr>';
		endif;
		$tblCouse .= '</tbody></table>';

		$tblImpact = '<table class="table peristiwa" id="tblImpact"><tbody>';
		if ($impact) :
			foreach ($impact as $key => $crs) :
				$tambah = '';
				$del = '';
				if ($key == 0) {
					$tambah = '  | <i class="fa fa-plus add-impact text-danger pointer"></i>';
					$del = 'del-impact ';
				}
				$tblImpact .= '<tr><td style="padding-left:0px;">' . form_textarea('risk_impact[]', $crs['description'], " readonly='readonly'  id='risk_impact' maxlength='500' size=500 class='form-control browse-impact' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_impact_no[]' => $crs['id']]) . '</td><td class="text-center" width="10%"><i class="fa fa-search browse-impact pointer text-primary"></i> | <i class="fa fa-trash text-success ' . $del . 'pointer"></i>' . $tambah . '</td></tr>';
			endforeach;
		else :
			$tblImpact .= '<tr><td style="padding-left:0px;">' . form_textarea('risk_impact[]', '', " readonly='readonly'  id='risk_impact' maxlength='500' size=500 class='form-control browse-impact' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_impact_no[]' => 0]) . '</td><td class="text-center"  width="10%"><i class=" fa fa-search browse-impact text-primary pointer"></i> | <i class="fa fa-trash text-success del-impact pointer"></i> | <i class="fa fa-plus add-impact text-danger pointer"></i></td></tr>';
		endif;
		$tblImpact .= '</tbody></table>';

		$data['detail'] = $detail;
		$data['peristiwa'] = $tblperistiwa;
		$data['couse'] = $tblCouse;
		$data['impact'] = $tblImpact;
		$data['id_edit'] = $id_edit;
		$result['peristiwa'] = $this->load->view('peristiwa', $data, true);
		echo json_encode($result);
	}

	function edit_level()
	{
		$id_rcsa = $this->input->post('id');
		$id_edit = $this->input->post('edit');
		$data['detail'] = $this->db->where('id', $id_edit)->get(_TBL_RCSA_DETAIL)->row_array();
		$arrControl = json_decode($data['detail']['control_no'], true);
		$data['id_edit'] = $id_edit;
		$data['rcsa_no'] = $id_rcsa;

		$cboLike = $this->get_combo('likelihood');
		$cboImpact = $this->get_combo('impact');
		$cboTreatment = $this->get_combo('treatment');
		$cboTreatment1 = $this->get_combo('treatment1');
		$cboTreatment2 = $this->get_combo('treatment2');
		$cboRiskControl = $this->get_combo('data-combo', 'control-assesment');
		$inherent_level = $this->data->get_master_level(true, $data['detail']['inherent_level']);
		// var_dump($a);
		if (!$inherent_level) {
			$inherent_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
		}

		$a = $inherent_level['level_mapping'];

		$cboControl = $this->db->where('status', 1)->get(_TBL_EXISTING_CONTROL)->result_array();
		$jml = intval(count($cboControl) / 2);
		$check = '';
		$i = 1;
		$control = array();
		$check .= '<div class="well p100">';
		if (is_array($arrControl))
			$control = $arrControl;
		foreach ($cboControl as $row) {
			if ($i == 1)
				$check .= '<div class="col-md-6">';

			$sts = false;
			foreach ($control as $ctrl) {
				if ($row['component'] == $ctrl) {
					$sts = true;
					break;
				}
			}

			$check .= '<label class="pointer">' . form_checkbox('check_item[]', $row['component'], $sts);
			$check .= '&nbsp;' . $row['component'] . '</label><br/>';
			if ($i == $jml)
				$check .= '</div><div class="col-md-6">';

			++$i;
		}
		$check .= '</div>' . form_textarea("note_control", ($data['detail']) ? $data['detail']['note_control'] : '', ' class="form-control" style="width:100%;height:150px"') . '</div><br/>';


		$data['level_resiko'][] = ['label' => lang('msg_field_inherent_risk'), 'isi' => ' Probabilitas : ' . form_dropdown('inherent_likelihood', $cboLike, ($data['detail']) ? $data['detail']['inherent_likelihood'] : '', ' class="form-control select2" id="inherent_likelihood" style="width:40%;"') . ' Impact: ' . form_dropdown('inherent_impact', $cboImpact, ($data['detail']) ? $data['detail']['inherent_impact'] : '', ' class="form-control select2" id="inherent_impact" style="width:40%;"')];
		$data['level_resiko'][] = ['label' => lang('msg_field_inherent_level'), 'isi' => '<span id="inherent_level_label"><span style="background-color:' . $inherent_level['color'] . ';color:' . $inherent_level['color_text'] . ';">&nbsp;' . $inherent_level['level_mapping'] . '&nbsp;</span></span>' . form_hidden(['inherent_level' => ($data['detail']) ? $data['detail']['inherent_level'] : 0]) . form_hidden(['inherent_name' => ($data['detail']) ? $a : ''])];



		$data['level_resiko'][] = ['label' => lang('msg_field_existing_control'), 'isi' => $check];
		$data['level_resiko'][] = ['label' => lang('msg_field_risk_control_assessment'), 'isi' => form_dropdown('risk_control_assessment', $cboRiskControl, ($data['detail']) ? $data['detail']['risk_control_assessment'] : '', ' class="form-control select2" id="risk_control_assessment" style="width:100%;"')];

		if ($a == "Ekstrem") {
			$data['level_resiko'][] = ['label' => lang('msg_field_treatment'), 'isi' => form_dropdown('treatment_no', $cboTreatment1, ($data['detail']) ? $data['detail']['treatment_no'] : '', ' class="form-control select2" id="treatment_no" style="width:100%;"')];
		} elseif ($a == "Low") {
			$data['level_resiko'][] = ['label' => lang('msg_field_treatment'), 'isi' => form_dropdown('treatment_no', $cboTreatment2, ($data['detail']) ? $data['detail']['treatment_no'] : '', ' class="form-control select2" id="treatment_no" style="width:100%;"')];
		} else {
			$data['level_resiko'][] = ['label' => lang('msg_field_treatment'), 'isi' => form_dropdown('treatment_no', $cboTreatment, ($data['detail']) ? $data['detail']['treatment_no'] : '', ' class="form-control select2" id="treatment_no" style="width:100%;"')];
		}
		$result['peristiwa'] = $this->load->view('level', $data, true);

		echo json_encode($result);
	}

	function list_realisasi()
	{
		$id_rcsa = $this->input->post('id');
		$id_edit = $this->input->post('edit');

		$data['parent'] = $this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->row_array();
		$data['detail'] = $this->db->where('id', $id_edit)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['realisasi'] = $this->data->get_realisasi($id_edit);
		$data['list_realisasi'] = $this->load->view('list-realisasi', $data, true);
		$result['peristiwa'] = $this->load->view('realisasi', $data, true);
		echo json_encode($result);
	}

	// function list_mitigasi(){
	// 	$id_rcsa = $this->input->post('id');
	// 	$id_edit = $this->input->post('edit');
	// 	$data['parent']=$this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->row_array();
	// 	$data['detail']=$this->db->where('id', $id_edit)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
	// 	$data['mitigasi']=$this->db->where('rcsa_detail_no', $id_edit)->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
	// 	$data['list_mitigasi'] = $this->load->view('list-mitigasi', $data, true);
	// 	$result['peristiwa'] = $this->load->view('mitigasi', $data, true);
	// 	echo json_encode($result);
	// }

	function input_realisasi()
	{
		$id = $this->input->post('id');
		$rcsa_detail_no = $this->input->post('rcsa_detail_no');
		$rcsa_no = $this->input->post('rcsa_no');
		$data['owner'] = $this->db->where('id', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['detail'] = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->row_array();
		$rows = $this->db->where('rcsa_detail_no', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_MITIGASI)->row_array();
		$data['cek'] = $this->db->where('rcsa_detail_no', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		$data['id'] = $id;
		$proaktif = [];
		$reaktif = [];
		$proaktif_text = '<ul>';
		$reaktif_text = '<ul>';
		$pilih = 0;
		$no = 0;

		$proaktif[$rows['id']] = $rows['proaktif'];
		$reaktif[$rows['id']] = $rows['reaktif'];
		$reaktif_text .= '<li>' . $rows['reaktif'] . '</li>';
		$proaktif_text .= '<li>' . $rows['proaktif'] . '</li>';

		$proaktif_text .= '</ul>';
		$reaktif_text .= '</ul>';
		$reaktif_text .= form_hidden('rcsa_action_no', $rows['id']);

		$field = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->row_array();
		$inherent_level = $data['detail'];
		if (!$inherent_level) {
			$inherent_level = ['warna_action' => '', 'warna_text_action' => '', 'inherent_analisis_action' => '-'];
		}

		$data['rcsa_detail_no'] = $rcsa_detail_no;
		$data['rcsa_no'] = $rcsa_no;
		$data['edit_no'] = $id;
		$cbo_owner = $this->get_combo('parent-input-all');
		$cboLike = $this->get_combo('likelihood');
		$cboImpact = $this->get_combo('impact');
		$cbo_status = $this->get_combo('status-action');
		$pilih = ($data['detail']) ? $data['detail']['status_loss'] : 1;

		$check_kriteria = '<label class="pointer">' . form_radio('status_loss', 1, ($pilih <= 1) ? true : false, ' id="status_loss"');
		$check_kriteria .= '&nbsp; Ya</label> &nbsp;&nbsp;&nbsp;';
		$check_kriteria .= '<label class="pointer">' . form_radio('status_loss', 0, ($pilih == 0) ? true : false, ' id="status_loss" ');
		$check_kriteria .= '&nbsp; Tidak</label> &nbsp;&nbsp;&nbsp;';

		$data['realisasi'][] = ['show' => true, 'label' => 'Apakah peristiwa ini terjadi ', 'isi' => $check_kriteria];
		$data['realisasi'][] = ['show' => ($pilih == 0) ? true : false, 'label' => 'Proaktif', 'isi' => $proaktif_text];
		$data['realisasi'][] = ['show' => ($pilih == 1) ? true : false, 'label' => 'Reaktif', 'isi' => $reaktif_text];
		$data['realisasi'][] = ['show' => true, 'label' => 'Realisasi', 'isi' => form_input('realisasi', ($data['detail']) ? $data['detail']['realisasi'] : '', 'class="form-control" style="width:100%;" id="realisasi"')];
		// $data['realisasi'][] = ['show'=>true,'label' => 'Tanggal Pelaksanaan', 'isi' => form_input('progress_date', ($field)?$field['progress_date']:date('d-m-Y')," id='progress_date' size='20' class='form-control datepicker' style='width:130px;'")];
		$a = ($field) ? $field['progress_date'] : '';
		$n = date_create($a, timezone_open('Asia/Jakarta'))->format('d-m-Y');
		$data['realisasi'][] = ['show' => true, 'label' => 'Tanggal Pelaksanaan', 'isi' => form_input('progress_date', ($field) ? $n : '', " id='progress_date' size='20' class='form-control datepicker' style='width:130px;'")];
		$data['realisasi'][] = ['show' => true, 'label' => 'Analisa Risiko', 'isi' => ' Probabilitas : ' . form_dropdown('residual_likelihood', $cboLike, ($data['detail']) ? $data['detail']['residual_likelihood_action'] : '', ' class="form-control select2" id="residual_likelihood" style="width:40%;"') . ' Impact: ' . form_dropdown('residual_impact', $cboImpact, ($data['detail']) ? $data['detail']['residual_impact_action'] : '', ' class="form-control select2" id="residual_impact" style="width:40%;"')];
		$data['realisasi'][] = ['show' => true, 'label' => 'Risk Level', 'isi' => '<span id="inherent_level_label"><span style="background-color:' . $inherent_level['warna_action'] . ';color:' . $inherent_level['warna_text_action'] . ';">&nbsp;' . $inherent_level['inherent_analisis_action'] . '&nbsp;</span></span>' . form_hidden(['inherent_level' => ($data['detail']) ? $data['detail']['risk_level_action'] : 0])];

		// $data['realisasi'][] = ['show'=>true,'label' => 'Pelaksanaan Treatment', 'isi' => form_dropdown('pelaksana_no[]', $cbo_owner, ($data['detail']) ? json_decode($data['detail']['pelaksana_no'],true) : '', ' class="form-control select2" id="risk_control_assessment" multiple="multiple" style="width:100%;"')];
		// $data['realisasi'][] = ['show'=>true,'label' => 'Short Report', 'isi' => form_dropdown('notes', $cbo_status, ($data['detail']) ? $data['detail']['notes'] : '', ' class="form-control select2" id="notes" style="width:15%;"')];
		$data['realisasi'][] = ['show' => true, 'label' => 'Short Report', 'isi' => form_dropdown('status_no', $cbo_status, ($data['detail']) ? $data['detail']['status_no'] : '', ' class="form-control select2" id="status_no" style="width:130px;"')];

		$data['realisasi'][] = ['show' => true, 'label' => 'Keterangan', 'isi' => form_input('keterangan', ($data['detail']) ? $data['detail']['keterangan'] : '', 'class="form-control" style="width:100%;" id="keterangan"')];
		// $data['realisasi'][] = ['show'=>true,'label' => 'Short Report', 'isi' => form_input('notes', ($data['detail'])?$data['detail']['notes']:'', 'class="form-control" style="width:100%;" id="notes"')];

		$data['realisasi'][] = ['show' => true, 'label' => 'Attacment', 'isi' => form_upload("attach_realisasi", "")];
		$data['realisasi'][] = ['show' => true, 'label' => 'Progress', 'isi' => form_input(['name' => 'progress', 'id' => 'progress', 'type' => 'number', 'value' => ($data['detail']) ? $data['detail']['progress_detail'] : '', 'class' => 'form-control', 'style' => 'width:15%;'])];

		$b = ($field) ? $field['create_date'] : '';
		$n1 = date_create($b, timezone_open('Asia/Jakarta'))->format('d-m-Y H:i:s');
		$data['realisasi'][] = ['show' => true, 'label' => 'Tanggal Monitoring', 'isi' => form_input('create_date', ($field) ? $n1 : '', " id='create_date' readonly='true' size='30' class='form-control' style='width:160px;'")];

		$hasil['combo'] = $this->load->view('input_realisasi', $data, true);

		echo json_encode($hasil);
		// var_dump($hasil);
	}

	function input_mitigasi()
	{
		$rcsa_no = $this->input->post('id');
		$rcsa_detail_no = $this->input->post('edit');
		$data['owner'] = $this->db->where('id', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['detail'] = $this->db->where('id', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['parent'] = $this->db->where('id', $data['owner']['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->db->where('rcsa_detail_no', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_MITIGASI)->row_array();
		$id = 0;
		$data['rcsa_no_1'] = $rcsa_no;
		if ($data['field']) {
			$rcsa_no = $this->input->post('rcsa_no');
			$id = $data['field']['id'];
		}

		$data['id_detail'] = $rcsa_detail_no;
		$data['rcsa_no'] = $rcsa_no;
		$data['edit_no'] = $id;
		$data['cbo_owner'] = $this->get_combo('parent-input-all');
		$data['list_mitigasi'] = $this->load->view('input_mitigasi', $data, true);
		$result['peristiwa'] = $this->load->view('mitigasi', $data, true);

		echo json_encode($result);
	}

	function delete_peristiwa()
	{
		$rcsa_no = $this->input->post('rcsa_no');
		$id_edit = $this->input->post('edit');
		if ($id_edit > 0) {
			$detail = $this->db->delete(_TBL_RCSA_DETAIL, ['id' => $id_edit]);
		}
		$data['parent'] = $this->db->where('id', $rcsa_no)->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($rcsa_no);
		$result['combo'] = $this->load->view('list-peristiwa', $data, true);
		echo json_encode($result);
	}

	function delete_mitigasi()
	{
		$id_edit = $this->input->post('edit');
		if ($id_edit > 0) {
			$detail = $this->db->delete(_TBL_RCSA_ACTION, ['id' => $id_edit]);
		}
		echo json_encode(['sts' => 1]);
	}

	function delete_realisasi()
	{
		$id_edit = $this->input->post('edit');
		if ($id_edit > 0) {
			$detail = $this->db->delete(_TBL_RCSA_ACTION_DETAIL, ['id' => $id_edit]);
		}
		echo json_encode(['sts' => 1]);
	}


	function list_library()
	{
		$id = $this->input->post('id');
		$rows = $this->db->where('type', 1)->where('risk_type_no', $id)->get(_TBL_LIBRARY)->result();

		$option = '<option value="0">' . lang('msg_cbo_select') . '</option>';
		foreach ($rows as $row) {
			$option .= '<option value="' . $row->id . '">' . $row->description . '</option>';
		}
		$result['combo'] = $option;
		echo json_encode($result);
	}

	function get_library_event()
	{
		// $id = $this->input->post('id');
		// $nilKel = $this->input->post('kel');
		// $rows = $this->db
		// ->select(_TBL_LIBRARY . '.*,' . _TBL_LIBRARY_DETAIL . '.id as id_color,' . _TBL_LIBRARY_DETAIL . '.likelihood,' . _TBL_LIBRARY_DETAIL . '.impact')
		// ->from(_TBL_LIBRARY_DETAIL)
		// ->where(_TBL_LIBRARY_DETAIL . '.id', _TBL_LIBRARY.'id')
		// ->join(_TBL_LIBRARY, _TBL_LIBRARY_DETAIL . '.level_risk_no = ' . _TBL_LIBRARY . '.id')
		// ->get()
		// ->row_array();

		$xx = $this->db->where('type', 1)->where('status', 1)->order_by('description')->get('bangga_view_library')->result_array();

		$peristiwa = $this->db->where('type', 1)->where('status', 1)->order_by('description')->get(_TBL_LIBRARY)->result_array();
		$data['field'] = $peristiwa;
		$cbogroup = $this->get_combo('library', 2);
		$data['cbogroup'] = $cbogroup;
		$data['cbo'] = form_input('', '', ' id="new_cause[]" name="new_cause[]" class="form-control"');
		$data['cbbo'] = form_dropdown('new_cause_no[]', $cbogroup, '', 'class="form-control select4" style="width:100%;"');


		$cbogroup1 = $this->get_combo('library', 3);
		$data['cbogroup'] = $cbogroup1;
		$data['cbo1'] = form_input('', '', ' id="new_impact" name="new_impact[]" class="form-control"');
		$data['cbbii'] = form_dropdown('new_impact_no[]', $cbogroup1, '', 'class="form-control select4"');


		$rok = $this->db->where('status', 1)->order_by('kelompok, type')->get(_TBL_RISK_TYPE)->result_array();
		$arrayX = array('- Pilih-');
		foreach ($rok as $x) {
			$kel = "EXTERNAL";
			if ($x['kelompok'] == 77) {
				$kel = "INTERNAL";
			}
			$arrayX[$kel][$x['id']] = $x['type'];
		}
		$data['nilKel'] = $nilKel;
		$data['cboTypeLibrary'] = $arrayX;
		$hasil['library'] = $this->load->view('list-library-event', $data, true);
		$hasil['title'] = "Event tilte";
		echo json_encode($hasil);
	}
	function get_library()
	{
		$id = $this->input->post('id');
		// doi::dump($id);
		$nilKel = $this->input->post('kel');
		$data['field'] = $this->db->where('library_no', $id)->where('type', $nilKel)->get(_TBL_VIEW_LIBRARY)->result_array();
		$data['kel'] = ($nilKel == 2) ? "Couse" : "Impact";
		$data['event_no'] = $id;
		$rok = $this->db->where('status', 1)->order_by('kelompok, type')->get(_TBL_RISK_TYPE)->result_array();
		$arrayX = array('- Pilih-');
		foreach ($rok as $x) {
			$kel = "EXTERNAL";
			if ($x['kelompok'] == 77) {
				$kel = "INTERNAL";
			}
			$arrayX[$kel][$x['id']] = $x['type'];
		}
		$data['nilKel'] = $nilKel;
		$data['cboTypeLibrary'] = $arrayX;
		$hasil['library'] = $this->load->view('list-library', $data, true);
		$hasil['title'] = ($kel == 2) ? "List " . $data['kel'] : "List " . $data['kel'];
		echo json_encode($hasil);
	}
	public function lastCodeLibrary()
	{
		$query = $this->db
			->select('code')
			->from('bangga_library')
			->order_by('code', 'desc')
			->limit(1)
			->get();

		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$lastCode = $row['code'];
			return $lastCode;
		} else {
			return false;
		}
	}
	public function simpanLibrary()
	{
		$post = $this->input->post();

		$lastCode = $this->lastCodeLibrary();
		// doi::dump($post['cause_no'].lenght);
		// die();
		// Save header type 1
		if (!empty($post['library'])) {
			$upd['description'] = $post['library'];
			$upd['code'] = $lastCode ? $lastCode + 1 : 1; // Jika $lastCode kosong, mulai dari 1
			$upd['type'] = 1;
			$upd['status'] = 1;
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$saveUpd = $this->crud->crud_data(['table' => 'bangga_library', 'field' => $upd, 'type' => 'add']);
			$idhed = $this->db->insert_id();
			// $error = $this->db->error();
			// if (!empty($error)) {
			// 	echo "Error: " . $error['message'];
			// }
		}


		if (!empty($post['cause_name'])) {
			if ($saveUpd) {
				$code = $upd['code'];
				$cd = 1; // Mulai dari 1 sebagai offset awal
				foreach ($post['cause_name'] as $data) {
					if ($data != "") {
						$updx['description'] = $data;
						$updx['type'] = 2;
						$updx['code'] = $code + $cd; // Gunakan code yang unik dengan penambahan offset
						$updx['status'] = 1;
						$updx['create_user'] = $this->authentication->get_info_user('username');

						// Cek apakah entri dengan kode yang sama sudah ada sebelum menyimpan
						$existingEntry = $this->db->get_where('bangga_library', ['code' => $updx['code'], 'description' => $data])->row();
						if ($existingEntry) {
							echo "Error: Duplicate entry for code {$updx['code']}";
						} else {
							$saveUpdx = $this->crud->crud_data(['table' => 'bangga_library', 'field' => $updx, 'type' => 'add']);
							$idcouse = $this->db->insert_id();
							$error = $this->db->error();

							$updetail['library_no'] = $idhed;
							$updetail['child_no'] = $idcouse;
							$updetail['create_user'] = $this->authentication->get_info_user('username');
							$this->crud->crud_data(['table' => 'bangga_library_detail', 'field' => $updetail, 'type' => 'add']);
							$error = $this->db->error();
							// if (!empty($error)) {
							// 	echo "Error: " . $error['message'];
							// }
						}
					}

					$cd++;
				}
			}
		}

		if (!empty($post['impact_name'])) {
			if ($saveUpdx) {
				$code = $updx['code'];
			} elseif ($saveUpd) {
				$code = $upd['code'];
			}


			$cd = 1; // Mulai dari 1 sebagai offset awal
			foreach ($post['impact_name'] as $data) {
				// doi::dump($data)
				if ($data != "") {
					$updxx['description'] = $data;
					$updxx['type'] = 3;
					$updxx['code'] = $code + $cd; // Gunakan code yang unik dengan penambahan offset
					$updxx['status'] = 1;
					$updxx['create_user'] = $this->authentication->get_info_user('username');

					// Cek apakah entri dengan kode yang sama sudah ada sebelum menyimpan 
					$existingEntry = $this->db->get_where('bangga_library', ['code' => $updxx['code'], 'description' => $data])->row();
					if ($existingEntry) {
						echo "Error: Duplicate entry for code {$updxx['code']}";
					} else {
						$saveUpdxx = $this->crud->crud_data(['table' => 'bangga_library', 'field' => $updxx, 'type' => 'add']);
						$idimpc = $this->db->insert_id();
						$error = $this->db->error();

						$updetailx['library_no'] = $idhed;
						$updetailx['child_no'] = $idimpc;
						$updetailx['create_user'] = $this->authentication->get_info_user('username');
						$this->crud->crud_data(['table' => 'bangga_library_detail', 'field' => $updetailx, 'type' => 'add']);
						// $error = $this->db->error();
						// if (!empty($error)) {
						// 	echo "Error: " . $error['message'];
						// }
					}
				}
				$cd++;
			}
		}


		// Save cause no
		if (!empty($post['cause_no'])) {
			if ($saveUpd) {
				foreach ($post['cause_no'] as $data) {
					$updetailxxx['library_no'] = $idhed;
					$updetailxxx['child_no'] = $data;
					$updetailxxx['create_user'] = $this->authentication->get_info_user('username');
					$this->crud->crud_data(['table' => 'bangga_library_detail', 'field' => $updetailxxx, 'type' => 'add']);
					// $error = $this->db->error();
					// if (!empty($error)) {
					// 	echo "Error: " . $error['message'];
					// }
				}
			}
		}
		if (!empty($post['impact_no'])) {
			if ($saveUpd) {
				foreach ($post['impact_no'] as $data) {
					$updetailxxxx['library_no'] = $idhed;
					$updetailxxxx['child_no'] = $data;
					$updetailxxxx['create_user'] = $this->authentication->get_info_user('username');
					$this->crud->crud_data(['table' => 'bangga_library_detail', 'field' => $updetailxxxx, 'type' => 'add']);
					$error = $this->db->error();
					// if (!empty($error)) {
					// 	echo "Error: " . $error['message'];
					// }
				}
			}
		}


		$data['id'] = $idhed;
		$data['event_no'] = $post['event_no'];
		$data['kel'] = 0;
		$data['event'] = $post['library'];

		echo json_encode($data);
	}




	public function simpan_library()
	{
		// $this->data->save_library_new($post, $mode="new");
		$post = $this->input->post();
		// save header  type 1

		if ($post['library']) {
			// doi::dump('masuk ke save 1');

			$upd['description'] = $post['library'];
			$upd['type'] = 1;
			$upd['status'] = 0;
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$this->crud->crud_data(['table' => _TBL_LIBRARY, 'field' => $upd, 'type' => 'add']);
			$id = $this->db->insert_id();
			doi::dump($upd);
			doi::dump($id);
		}
		die($id);

		$upd['create_user'] = $this->authentication->get_info_user('username');
		$this->crud->crud_data(['table' => _TBL_LIBRARY, 'field' => $upd, 'type' => 'add']);
		$id = $this->db->insert_id();

		$upd = [];
		if ($post['kel'] > 1) {
			$upd['library_no'] = $post['event_no'];
			$upd['child_no'] = $id;
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$this->crud->crud_data(['table' => _TBL_LIBRARY_DETAIL, 'field' => $upd, 'type' => 'add']);
		}

		$data['id'] = $id;
		$data['event_no'] = $post['event_no'];
		$data['kel'] = $post['kel'];
		$data['event'] = $post['library'];

		echo json_encode($data);
	}

	function simpan_peristiwa()
	{
		$post = $this->input->post();
		// $id = $this->data->simpan_risk_event($post);

		if (($post['sasaran'] == 0) ||  ($post['kategori'] == 0)  || ($post['risk_event_no'][0] == 0)) {
			//	$id = $this->data->simpan_risk_event($post);
			$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
			$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);
			$result['combo'] = $this->load->view('list-peristiwa', $data, true);

			$result['combo'] .= '	<script>
							alert("Data tidak boleh ada yang kosong")
							</script>';

			$result['back'] = false;
		} else {

			//		var_dump($post['risk_couse_no']);

			$id = $this->data->simpan_risk_event($post);
			$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
			$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);
			$result['combo'] = $this->load->view('list-peristiwa', $data, true);
			$result['back'] = true;
		}

		// $id = $this->data->simpan_risk_event($post);
		// $data['parent']=$this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		// $data['field']=$this->data->get_peristiwa($post['rcsa_no']);
		// $result['combo'] = $this->load->view('list-peristiwa', $data, true);
		echo json_encode($result);
	}

	function simpan_level()
	{
		$post = $this->input->post();
		$id = $this->data->simpan_risk_level($post);
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);
		$result['combo'] = $this->load->view('list-peristiwa', $data, true);
		echo json_encode($result);
	}

	function simpan_mitigasi()
	{
		$post = $this->input->post();
		$id = $this->data->simpan_mitigasi($post);
		$data['parent'] = $this->db->where('id', $post['rcsa_no_1'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($post['rcsa_no_1']);
		// $data['detail']=$this->db->where('id', $post['id_detail'])->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		// $data['mitigasi']=$this->db->where('rcsa_detail_no', $post['id_detail'])->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
		// $result['combo'] = $this->load->view('list-mitigasi', $data, true);
		$result['combo'] = $this->load->view('list-peristiwa', $data, true);
		echo json_encode($result);
	}

	function close_mitigasi()
	{
		$post = $this->input->post();
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);
		$result['combo'] = $this->load->view('list-peristiwa', $data, true);
		echo json_encode($result);
	}

	function simpan_realisasi()
	{
		$post = $this->input->post();
		$id = $this->data->simpan_realisasi($post);
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['detail'] = $this->db->where('id', $post['detail_rcsa_no'])->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['realisasi'] = $this->data->get_realisasi($post['detail_rcsa_no']);
		$result['combo'] = $this->load->view('list-realisasi', $data, true);
		echo json_encode($result);
	}

	function close_realisasi()
	{
		$post = $this->input->post();
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);
		$result['combo'] = $this->load->view('list-peristiwa', $data, true);
		echo json_encode($result);
	}

	function cek_level()
	{
		$post = $this->input->post();
		$rows = $this->db->where('impact_no', $post['impact'])->where('like_no', $post['likelihood'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();

		$result['level_text'] = '-';
		$result['level_no'] = 0;
		$result['level_resiko'] = '-';

		if ($rows) {
			$result['level_text'] = "<span style='background-color:" . $rows['warna_bg'] . ";color:" . $rows['warna_txt'] . ";'>&nbsp;" . $rows['tingkat'] . "&nbsp;</span>";
			$result['level_no'] = $rows['id'];
			$result['level_name'] = $rows['tingkat'];
			$cboTreatment = $this->get_combo('treatment');
			$cboTreatment1 = $this->get_combo('treatment1');
			$cboTreatment2 = $this->get_combo('treatment2');

			if ($result['level_name'] == "Ekstrem") {
				$result['level_resiko'] = $cboTreatment1;
			} elseif ($result['level_name'] == "Low") {
				$result['level_resiko'] = $cboTreatment2;
			} else {
				$result['level_resiko'] = $cboTreatment;
			}
		}

		echo json_encode($result);
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
	function cetak_register()
	{

		$tipe = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$parent = $this->uri->segment(5);
		$data = $this->db->where('id', $id)->get(_TBL_RCSA)->row_array();
		$rows = $this->db->where('id', $data['owner_no'])->get(_TBL_OWNER)->row_array();
		$nama = $nama = 'Risk-Register-' . url_title($rows['name']);

		$id_rcsa = $id;
		$data['id'] = $id;
		$data['tipe'] = $tipe;

		$data['owner'] = $parent;
		$data['fieldxx'] = $this->data->get_data_risk_reg_acc($id_rcsa);
		$data['fields'] = $this->data->get_data_officer($id_rcsa);
		$data['field'] = $this->data->get_data_risk_register($id);
		$data['tgl'] = $this->data->get_data_tanggal($id);

		$data['divisi'] =  $this->db->where('id', $parent)->get(_TBL_OWNER)->row();


		$hasil = $this->load->view('list_risk_register', $data, true);
		$cetak = 'register_' . $tipe;
		$this->$cetak($hasil, $nama);
	}

	function register_excel($data, $nama = "Risk-Assesment")
	{
		header("Content-type:appalication/vnd.ms-excel");
		header("content-disposition:attachment;filename=" . $nama . ".xls");

		$html = $data;
		echo $html;
		exit;
	}

	function register_pdf($data, $nama = "Risk-Assesment")
	{
		$this->load->library('pdf');
		$tgl = date('d-m-Y');
		// $this->nmFile = _MODULE_NAME_ . '-' . $nama .'-'.$tgl.".pdf";
		$this->nmFile = $nama . '-' . $tgl . ".pdf";
		$this->pdfFilePath = download_path_relative($this->nmFile);

		$html = '<style>
				table {
					border-collapse: collapse;
				}

				// .test table > th > td {
				// 	border: 1px solid #ccc;
				// }
				</style>';


		// $html .= '<table width="100%" border="1"><tr><td width="100%" style="padding:20px;">';
		$html .= $data;
		// $html .= '</td></tr></table>';

		// die($html);
		$align = array();
		$format = array();
		$no_urut = 0;

		// die($html);
		$pdf = $this->pdf->load();
		$pdf->AddPage(
			'L', // L - landscape, P - portrait
			'',
			'',
			'',
			'',
			10, // margin_left
			10, // margin right
			10, // margin top
			10, // margin bottom
			5, // margin header
			5
		); // margin footer
		$pdf->SetHeader('');
		// $pdf->SetHTMLHeader('');
		// $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822));
		// $pdf->SetHTMLFooter('<h1>ini Footer</h1>');
		$pdf->SetFooter('|{PAGENO} Dari {nb} Halaman|');
		$pdf->debug = true;
		$pdf->WriteHTML($html);
		ob_clean();

		$pdf->Output($this->pdfFilePath, 'F');
		redirect($this->pdfFilePath);

		return true;
	}


	function delete_sasaran()
	{ //delete from table sasaran in rcsa edit
		$halaman = $this->uri->segment(4); //halaman edit

		$this->data->delete_sasaran($this->uri->segment(3));
		redirect('/rcsa-context/edit/' . $halaman);
	}

	function delete_stakeholder()
	{ //delete from table stackholder in rcsa-context edit
		$halaman = $this->uri->segment(4); //halaman edit

		$this->data->delete_stakeholder($this->uri->segment(3));
		redirect('/rcsa-context/edit/' . $halaman);
	}

	function delete_kriteria()
	{ //delete from table kriteria in rcsa-context edit
		$halaman = $this->uri->segment(4); //halaman edit

		$this->data->delete_kriteria($this->uri->segment(3));
		redirect('/rcsa-context/edit/' . $halaman);
	}
}
