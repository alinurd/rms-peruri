<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Report_Risk_Library extends BackendController {
	var $type_risk=0;
	var $table = "";
	var $post = array();
	var $sts_cetak = false;
	
	public function __construct()
	{
        parent::__construct();

		$this->type_risk=1;
		$this->cbo_parent = $this->get_combo('parent-input');
			
 		$data['cboper'] = $this->get_combo('peristiwa');
 		$data['kategori'] = $this->get_combo('data-combo', 'kel-library');

		$this->set_Tbl_Master(_TBL_VIEW_RCSA_DETAIL);
		$this->set_Table(_TBL_LIBRARY);


			$this->set_Open_Tab('Report Risk Library');
			$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 4));
			$this->addField(array('field' => 'owner_no','title'=>'Risk Owner', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => true, 'search' => true));
			$this->addField(array('field' => 'create_user', 'search' =>false, 'default'=>$this->authentication->get_info_user('username')));
			$this->addField(array('field' => 'kategori_no','title'=>'Kategori', 'input' => 'combo:search', 'combo' => $data['kategori'], 'size' => 100, 'required' => true, 'search' => true));
			$this->addField(array('field' => 'event_no','title'=>'peristiwa', 'input' => 'combo:search', 'combo' => $data['cboper'], 'size' => 100, 'required' => true, 'search' => true));
			
			$this->addField(array('field' => 'kategori', 'show' => false));
			$this->addField(array('field' => 'tema_risiko', 'show' => false));
			$this->addField(array('field' => 'name', 'show' => false));
			$this->addField(array('field' => 'sasaran', 'show' => false));
			$this->addField(array('field' => 'event_name', 'show' => false));
			$this->addField(array('field' => 'risk_couse_no', 'show' => false));
			$this->addField(array('field' => 'risk_impact_no', 'show' => false));
			$this->addField(array('field' => 'tema_risiko_t2_gabungan', 'show' => false));
			$this->addField(array('field' => 't2_t3', 'show' => false));
			
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master));
		$this->set_Sort_Table($this->tbl_master, 'name','ASC');

		$this->set_Table_List($this->tbl_master, 'name','Risk Owner',10);
		$this->set_Table_List($this->tbl_master, 'sasaran','Sasaran');
		// $this->set_Table_List($this->tbl_master, 'event_name', 'Peristiwa');
		$this->set_Table_List($this->tbl_master, 'event_name', 'Sub-Kelompok Risiko (T4)');
		$this->set_Table_List($this->tbl_master, 'tema_risiko', 'Tema Risiko (T1)');
		$this->set_Table_List($this->tbl_master, 'tema_risiko_t2_gabungan', 'Kategori Risiko(T2)');
		$this->set_Table_List($this->tbl_master, 't2_t3', 'Kelompok Risiko (T3)');
		$this->set_Table_List($this->tbl_master, 'risk_couse_no','Risk Cause');
		$this->set_Table_List($this->tbl_master, 'risk_impact_no','Risk Impact');
	

		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'rcsa_owner_no');
		$this->_CHANGE_TABLE_MASTER(_TBL_VIEW_RCSA_DETAIL);

		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('edit', false);
		$this->_SET_PRIVILEGE('delete', false);
		$this->_SET_PRIVILEGE('view', false);
		$this->tmp_data['setActionprivilege']=false;
		$this->set_Close_Setting();
	}

	function listBox_risk_couse_no($rows, $value){
	
		$data = str_replace('[','', $value);
		$data = str_replace("]",'', $data);
		$data = explode(",", $data);
		$hasil='';
		$hasil.='<ol>';
		// var_dump($data);
		
		foreach ($data as $key => $couse) {
			$id = str_replace('"','', $couse);	
			// var_dump($couse);
			if ($couse != "") {
			$a = $this->data->get_couse(intval($id));
			// var_dump($a);
			$hasil.='<li>'.$a.'</li>';
			}
		}
		

		$hasil.='</ol>';
		return $hasil;
	}
	function listBox_risk_impact_no($rows, $value){
		$data = str_replace('[','', $value);
		$data = str_replace("]",'', $data);
		$data = explode(",", $data);
		$hasil='';
		$hasil.='<ol>';
		foreach ($data as $key => $impact) {
			$id = str_replace('"','', $impact);
			if ($impact != "") {
			$a = $this->data->get_impact(intval($id));
			$hasil.='<li>'.$a.'</li>';
			}
		}
		$hasil.='</ol>';
		return $hasil;
	}


	function export_excel(){
		$x=$this->uri->segment(3);
		if($x=="03b1c481204dde3b5409239b7840475d"){
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=trttftftf.xls");
		$query = $this->db->select('a.id, a.description, a.code, a.create_date, a.t1, a.t2, a.t3, b.child_no, b.library_no')
						  ->from(_TBL_LIBRARY . ' as a')
						  ->join(_TBL_LIBRARY_DETAIL . ' as b', 'b.library_no = a.id', 'left')
						  ->where('a.type', 1)
						  ->get()
						  ->result_array();
	
 		$lib = [];
		$all_child_no = []; 
	
		foreach ($query as $row) {
			$id = $row['id'];
	
			if (!isset($lib[$id])) {
				$lib[$id] = [
					'id' => $row['id'],
					'peristiwa' => $row['description'],
					't1' => $row['t1'],
					't2' => $row['t2'],
					't3' => $row['t3'],
					'create_date' => $row['create_date'],
					'code' => $row['code'],
					'child_no' => []
				];
			}
	
			if (!is_null($row['child_no'])) {
				$lib[$id]['child_no'][] = $row['child_no'];
				$all_child_no[] = $row['child_no'];  
			}
		}
	
 		$lib = array_values($lib);
	
 		if (!empty($all_child_no)) {
			$rows = $this->db->select('id, description, type')
							 ->where_in('id', $all_child_no)
							 ->get(_TBL_LIBRARY)
							 ->result_array();
	
 			$child_details = [];
			foreach ($rows as $row) {
				$child_details[$row['id']] = [
					'description' => $row['description'],
					'type' => $row['type']
				];
			}
	
 			foreach ($lib as &$item) {
				foreach ($item['child_no'] as &$child) {
					$child = [
						'id' => $child,
						'description' => isset($child_details[$child]) ? $child_details[$child]['description'] : null,
						'type' => isset($child_details[$child]) ? $child_details[$child]['type'] : null
					];
				}
			}
		}
	
 		$data['library_data'] = $lib;
	 
		$result = $this->load->view('reportx', $data, true);
		echo $result;
		}else{
			header('location:' . base_url($this->modul_name));
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */