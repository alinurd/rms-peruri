<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Daftar_Corporate_Risk extends BackendController {
	var $type_risk	= 0;
	var $table 		= "";
	var $post 		= array();
	var $sts_cetak 	= false;
	
	public function __construct()
	{
        parent::__construct();

		$this->urgensi		= 0;
		$this->cbo_parent 	= $this->get_combo('parent-input');	
		$this->cbo_event	= $this->get_combo('event_no');
		$this->set_Tbl_Master(_TBL_VIEW_RCSA_DETAIL);
		$this->set_Table(_TBL_LIBRARY);
		$this->tbl_library=_TBL_LIBRARY;
		
		$this->set_Open_Tab('Daftar Top Risk');
		$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 11));
		$this->addField(array('field'=>'event_name', 'input'=>'multitext','size'=>10000));	
		$this->set_Close_Tab();


		$this->addField(array('field'=>'event_no','show' => false));
		$this->addField(array('field' => 'rcsa_owner_no','title'=>'Risk Owner', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'search' => true,'show' => false));
		$this->addField(array('field'=>'event_no', 'show' => true, 'search'=>false));
		$this->addField(array('field'=>'event_name', 'show' => false, 'search'=>false));
		$this->addField(array('field' => 'rcsa_owner_no', 'show' => false));
		$this->addField(array('field' => 'name', 'show' => false));
		$this->addField(array('field' => 'kategori_no', 'show' => false));
		$this->addField(array('field' => 'risk_couse_no', 'show' => false));
		$this->addField(array('field' => 'risk_impact_no', 'show' => false));
		$this->addField(array('field' => 'inherent_analisis_id', 'show' => false));
		$this->addField(array('field' => 'residual_analisis_id', 'show' => false));
		$this->addField(array('field' => 'residual_analisis', 'show' => false));
		$this->addField(array('field' => 'urgensi_no', 'show' => false));
		$this->addField(array('field' => 'warna', 'show' => false));
		$this->addField(array('field' => 'warna_text', 'show' => false));
		$this->addField(array('field' => 'warna_residual', 'show' => false));
		$this->addField(array('field' => 'warna_text_residual', 'show' => false));
		$this->addField(array('field' => 'inherent_analisis', 'show' => false));
			

		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'rcsa_owner_no', 'disabled' => "disabled"));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'update_user', 'readonly' => true));
		$this->set_Sort_Table($this->tbl_master, 'inherent_analisis_id',"DESC");
		$this->set_Sort_Table($this->tbl_master, 'residual_analisis_id',"DESC");
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master,'id_pk'=>'event_no','sp'=>$this->tbl_library,'id_sp'=>'id'));
		$this->set_Where_Table($this->tbl_master, 'urgensi_no', '=', $this->urgensi);
		$this->set_Table_List($this->tbl_master, 'name','Risk Owner',10);
		$this->set_Table_List($this->tbl_master, 'kategori_no','Kategori',10);
		$this->set_Table_List($this->tbl_master, 'event_name','Risk Event',20);
		$this->set_Table_List($this->tbl_master, 'inherent_analisis_id','Risk Level Inherent',10);
		$this->set_Table_List($this->tbl_master, 'residual_analisis_id','Risk Level Residual',10);
		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'rcsa_owner_no');
		$this->_CHANGE_TABLE_MASTER(_TBL_LIBRARY);
		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('delete', false);
		$this->_SET_PRIVILEGE('view', false);
		$this->set_Close_Setting();
	}

	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows)
	{
		$id 				= $rows['l_event_no'];
		$url2 				= base_url($this->modul_name="risk-event-library" . '/edit/'.$id);
		$tombol['propose'] 	= array("default" => true, "url" => $url2,"target"=>"blank", "label" => 'Edit Risiko');
		$tombol['edit'] 	= [];
		$tombol['print'] 	= [];
		$tombol['delete'] 	= [];
		$tombol['view'] 	= [];

		return $tombol;
	}
	
	function listBox_INHERENT_ANALISIS_ID($row, $value)
	{
		$nilai1 = intval($row['l_inherent_analisis_id']);
		$a 		= $row['l_inherent_analisis'];
		$b 		= $row['l_warna'];
		$c 		= $row['l_warna_text'];
		$result = "";
			if ($nilai1 > 0) {
				$result = '<span style="background-color:'.$b.';color:'.$c.'";>' . $a . '</span>';
			}
		return $result;

	}
	function listBox_RESIDUAL_ANALISIS_ID($row, $value)
	{
		$data = $this->db->where('rcsa_detail', $row['l_id'])
                 ->order_by('bulan', 'DESC') // Mengurutkan berdasarkan create_date secara menurun
                 ->limit(1) // Mengambil hanya 1 data terakhir
                 ->get(_TBL_RCSA_ACTION_DETAIL)
                 ->result_array();
		$cek_score 				= $this->data->cek_level_new($data[0]['residual_likelihood_action'], $data[0]['residual_impact_action']);
		$residual_level_risiko  = $this->data->get_master_level(true, $cek_score['id']);

		$a = $residual_level_risiko['level_mapping'];
		$b = $residual_level_risiko['color'];
		$c = $residual_level_risiko['color_text'];
		$result = "";
			if ($cek_score > 0) {
				$result = '<span style="background-color:'.$b.';color:'.$c.'";>' . $a . '</span>';
			}
		return $result;

	}
	

	function listBox_kategori_no($rows, $value){
	
		$data = str_replace('[','', $value);
		$data = str_replace("]",'', $data);
		$data = explode(",", $data);
		$hasil='';
		foreach ($data as $key => $kategori) {
			$id = str_replace('"','', $kategori);	
			if ($kategori != "") {
			$a = $this->data->get_kategori(intval($id));		
			}
		}
		$hasil =$a;
		return $hasil;
	}

	function listBox_EVENT_NAME($row, $value) {
		$id_detail = $row['l_id'];
		$this->db->where('id_detail', $id_detail);
		$cek_event = $this->db->get(_TBL_LOG_UP_RISK_EVENT); 
		$event_name = '';
	
		if ($this->authentication->get_Info_User('is_admin') == 1) {
			if ($cek_event->num_rows() == 0) {
				$event_name = $row['l_event_name'];
			} else { 
				$this->db->where('id_detail', $id_detail);
				$this->db->order_by('create_date', 'DESC');
				$this->db->limit(1);
				$row_event 	= $this->db->get(_TBL_LOG_UP_RISK_EVENT); 
				$data_log 	= $row_event->row();
				$event_no 	= $data_log->event_no;
				$e_name 	= $this->db->select('description')->where('id',$event_no)->get(_TBL_LIBRARY)->row();
				$event_name = $e_name->description;
			}
		} else {
			$event_name = $row['l_event_name'];
		}
	
		$result = $event_name;

		if ($this->authentication->get_Info_User('is_admin') == 1) {
			$result .= '<button class="btn btn-info btn-xs" type="button" style="float: right; border-radius: 50%; width: 25px; height: 25px; padding: 0; display: flex; align-items: center; justify-content: center;" id="ModalEditEvent" data-id="' . $row['l_id'] . '">
							<i class="fa fa-edit" style="font-size: 12px;"></i>
						</button>';
		}
	
		return $result;
	}
	public function get_detail_edit()
	{
		$id 				= $this->input->post('id');
		$detail 			= $this->db->where('id', $id)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['field'] 		= $this->data->get_data_risk_register($id);
		$data['cboper'] 	= [0=>lang('msg_cbo_select')];
		$data['detail'] 	= $detail;

		$this->db->where('id_detail', $id);
		$cek_event = $this->db->get(_TBL_LOG_UP_RISK_EVENT);
		$event_name = '';
		if($cek_event->num_rows() == 0){
			$event_name = $detail['sub_kategori'];
			$e_no = $detail['event_no'];
		}else{
			$this->db->where('id_detail', $id);
			$this->db->order_by('create_date', 'DESC');
			$this->db->limit(1);
			$row_event 	= $this->db->get(_TBL_LOG_UP_RISK_EVENT); 
			$data_log 	= $row_event->row();
			$event_no 	= $data_log->t3;
			$event_name = $event_no;
			$e_no		= $data_log->event_no;
		}

		$data['selected'] 	= $e_no; 
		$data['cboper'] 	= $this->get_combo('tasktonimi', 't4', $event_name);
		$data['log'] 		= $this->db->where('id_detail', $id)->get(_TBL_LOG_UP_RISK_EVENT)->result_array();
		$hasil['detail'] 	=  $this->load->view('detail_edit', $data, true);
		echo json_encode($hasil);
	}

	public function Simpan_Risk_event(){
		$data = $this->input->post();
		$id = $this->data->simpan_risk_event($data);
		$hasil['id'] = $id;
		echo json_encode($hasil);
	}
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */