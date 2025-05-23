<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Daftar_Top_Risk extends BackendController {
	var $type_risk=0;
	var $table = "";
	var $post = array();
	var $sts_cetak = false;
	
	public function __construct()
	{
        parent::__construct();

		$this->urgensi= 0;
		$this->urgensi1= 0;
		$this->cbo_parent = $this->get_combo('parent-input');
		
		// $this->kel=$this->get_combo('data-combo','kel-library');	
		$this->cbo_event=$this->get_combo('event_no');
		$this->set_Tbl_Master(_TBL_VIEW_RCSA_DETAIL);
		$this->set_Table(_TBL_LIBRARY);
		$this->tbl_library=_TBL_LIBRARY;
		


		$this->set_Open_Tab('Daftar Top Risk');

			$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 11));
			$this->addField(array('field'=>'event_name', 'input'=>'multitext','size'=>10000));
			
			// $this->addField(array('nmtbl'=>$this->tbl_library,'field'=>'description', 'input'=>'multitext','size'=>10000));


			// $this->addField(array('nmtbl'=>$this->tbl_library,'field' => 'update_user', 'search' =>false, 'show' => false, 'default'=>$this->authentication->get_info_user('username')));
		// $this->_CHANGE_TABLE_MASTER(_TBL_LIBRARY);

		$this->set_Close_Tab();
		$this->addField(array('field'=>'event_no','show' => false));
			$this->addField(array('field' => 'rcsa_owner_no','title'=>'Risk Owner', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'search' => true,'show' => false));
			$this->addField(array('field'=>'event_no', 'show' => true, 'search'=>false));
			$this->addField(array('field'=>'event_name', 'show' => false, 'search'=>false));
			$this->addField(array('field' => 'rcsa_owner_no', 'show' => false));
			$this->addField(array('field' => 'name', 'show' => false));
			$this->addField(array('field' => 'tema', 'show' => false));
			$this->addField(array('field' => 'risk_couse_no', 'show' => false));
			$this->addField(array('field' => 'risk_impact_no', 'show' => false));
			$this->addField(array('field' => 'inherent_analisis_id', 'show' => false));
			$this->addField(array('field' => 'residual_analisis_id', 'show' => false));
			$this->addField(array('field' => 'residual_analisis', 'show' => false));
			$this->addField(array('field' => 'residual_likelihood', 'show' => false));
			$this->addField(array('field' => 'residual_impact', 'show' => false));
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
		// $this->set_Where_Table($this->tbl_master, 'urgensi_no_kadiv', '=', $this->urgensi);
		// $this->set_Where_Table($this->tbl_master, 'urgensi_no', '>', $this->urgensi1);
		$this->set_Where_Table($this->tbl_master, 'sts_heatmap', '=', 1);
		$this->set_Table_List($this->tbl_master, 'name','Risk Owner',15);
		$this->set_Table_List($this->tbl_master, 'tema','Kategori');
		$this->set_Table_List($this->tbl_master, 'event_name','Risk Event');
		// $this->set_Table_List($this->tbl_master, 'risk_couse_no','Penyebab');
		// $this->set_Table_List($this->tbl_master, 'risk_impact_no','Akibat');
		$this->set_Table_List($this->tbl_master, 'inherent_analisis_id','Risk Level Inherent',15);
		$this->set_Table_List($this->tbl_master, 'residual_analisis_id','Risk Level Residual',15);
		// $this->set_Table_List($this->tbl_master, 'urgensi_no','Urut');
	

		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'rcsa_owner_no');
		// $this->_CHANGE_FIELD_MASTER(event_name);
		// $this->_CHANGE_TABLE_MASTER(_TBL_LIBRARY);

		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('edit', false);
		$this->_SET_PRIVILEGE('delete', false);
		$this->_SET_PRIVILEGE('view', false);
		// $this->_SET_PRIVILEGE('add', true);
		// $this->_SET_PRIVILEGE('cetak', false);
		$this->tmp_data['setActionprivilege']=false;
		$this->set_Close_Setting();
	}


		function listBox_INHERENT_ANALISIS_ID($row, $value)
	{
		$nilai1 = intval($row['l_inherent_analisis_id']);
		$a = $row['l_inherent_analisis'];
		$b = $row['l_warna'];
		$c = $row['l_warna_text'];
		$result = "";
			if ($nilai1 > 0) {
				$result = '<span style="background-color:'.$b.';color:'.$c.'";>' . $a . '</span>';
			}
		return $result;
	}
	function listBox_RESIDUAL_ANALISIS_ID($row, $value)
	{
		$like = $row['l_residual_likelihood'];
		$impact = $row['l_residual_impact'];
		$level_color = $this->data->cek_level_new($like,$impact);
		$result = '<span style="background-color:'.$level_color['warna_bg'].';color:'.$level_color['warna_txt'].'";>' . $level_color['tingkat'] . '</span>';
		return $result;

	}
	
	
	function listBox_tema($rows, $value){
	
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
	// function listBox_event_no($rows, $value){
	
	// 	$data = str_replace('[','', $value);
	// 	$data = str_replace("]",'', $data);
	// 	$data = explode(",", $data);
	// 	$hasil='';
	// 	foreach ($data as $key => $event) {
	// 		$id = str_replace('"','', $event);	
	// 		if ($event != "") {
	// 		$a = $this->data->get_event(intval($id));
	// 		}
	// 	}
	// 	$hasil=$a;
	// 	return $hasil;
	// }
	function listBox_risk_couse_no($rows, $value){
	
		$data = str_replace('[','', $value);
		$data = str_replace("]",'', $data);
		$data = explode(",", $data);
		$hasil='';
		$hasil.='<ol>';
		
		
		foreach ($data as $key => $couse) {
			$id = str_replace('"','', $couse);	
			
			if ($couse != "") {
			$a = $this->data->get_couse(intval($id));
			
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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */