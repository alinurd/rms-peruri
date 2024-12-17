<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Kelompok_Library extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->kelCombo = "kategori-risiko";
		$this->set_Tbl_Master(_TBL_DATA_COMBO);
 		$this->cbo_risk_type=$this->get_combo('library_t1');

		$this->set_Open_Tab('Kelompok Risiko (T3)');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'kelompok', 'show'=>false, 'save'=>true, 'default'=>$this->kelCombo));
			$this->addField(array('field'=>'pid', 'input'=>'combo', 'title'=>'Kategori Risiko T2','show'=>true , 'required'=>true,  'combo'=>$this->cbo_risk_type, 'size'=>50));
			$this->addField(array('field'=>'data', 'title'=>'Kelompok T3', 'required'=>true, 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'aktif', 'type'=>'string', 'input'=>'boolean', 'search'=>true, 'size'=>20));
			$this->addField(array('field'=> 'param1', 'type'=>'string', 'input'=>'boolean', 'show'=> false, 'size'=>20));
		// $this->addField(array('field' => 'cause', 'title' => 'Risk Event', 'type' => 'free', 'search' => false, 'mode' => 'o'));

		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Where_Table($this->tbl_master,'kelompok','=',$this->kelCombo);
		$this->set_Sort_Table($this->tbl_master,'urut');
		
		// $this->set_Table_List($this->tbl_master,'kode');
		$this->set_Table_List($this->tbl_master,'pid', '',20, '');
		$this->set_Table_List($this->tbl_master,'data');
		// $this->set_Table_List($this->tbl_master, 'param1', 'Jumlah Event', 10, 'center');

		$this->set_Table_List($this->tbl_master,'aktif','',10, 'center');
		
		$this->set_Close_Setting();
	}

	function listBox_PID($row, $value)
	{
		$pid = $this->db->where_in('id', $value)->get(_TBL_LIBRARY)->row_array();
 		$result =  '<span class="text-danger">unknow</span>'; 
		if($pid){
			$result=$pid['description'];
		}
		
		return $result;
	}
	function listBox_PARAM1($row, $value)
	{
		$this->db->where('bangga_library_detail' . '.kategori_risiko', $row['l_id']);
		$num_rows = $this->db->count_all_results('bangga_library_detail');
		$hasil['jmlCouse'] = $num_rows;
		
 		$result =  '<span class="badge bg-info">' . $num_rows . '</span>'; 
		return $result;
	}

	function get_cause()
	{
		$id = $this->uri->segment(3);
		$data = $this->data->get_library($id, 1);
		$data['angka'] = "10";
		$data['cbogroup'] = $this->get_combo('library', 1);
		$result = $this->load->view('cause', $data, true);
		return $result;
	}

	function insertBox_CAUSE($field)
	{
		$content = $this->get_cause();
		return $content;
	}

	function updateBox_CAUSE($field, $row, $value)
	{
		$content = $this->get_cause();
		return $content;
	}

	function POST_INSERT_PROCESSOR($id, $new_data)
	{

		$result = $this->data->save_map_event($id, $new_data, $this->type_risk, 'new');
		return $result;
	}

	function POST_UPDATE_PROCESSOR($id, $new_data, $old_data)
	{
		$result = $this->data->save_map_event($id, $new_data, $this->type_risk, 'edit', $old_data);
		return $result;
	}
}