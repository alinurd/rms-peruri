<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Indikator_Stress_Test extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		// $this->kelCombo="Index Komposit";
		$this->sms=[1=>"Semester 1", 2=>"Semester 2"];
		$this->set_Tbl_Master(_TBL_INDIKATOR_STRESS_TEST);
		
		$this->set_Open_Tab('Index Indikator Stress Test');
		$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>true, 'size'=>4));
		$this->addField(array('field'=>'judul','title' => 'Judul', 'required'=>true, 'search'=>true, 'size'=>100));
		$this->addField(array('field'=>'periode', 'title' => 'periode', 'required' => true, 'input'=>'combo', 'combo'=>$this->get_combo('periode'), 'search'=>true, 'size'=>20));
		$this->addField(array('field'=>'semester', 'title' => 'Semester', 'input'=>'combo', 'combo'=>$this->sms, 'search'=>true, 'size'=>20));
		$this->addField(array('field'=>'status', 'type'=>'string', 'input'=>'boolean', 'search'=>true, 'size'=>20));
		$this->addField(array('field'=> 'indikator', 'type' => 'free', 'input' => 'free', 'mode' => 'o', 'size' => 100, 'title' => 'Indikator'));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		$this->set_Sort_Table($this->tbl_master,'id');
		$this->set_Table_List($this->tbl_master,'judul', '', 50);
		$this->set_Table_List($this->tbl_master,'periode', 'Tahun', 10,'center');
		$this->set_Table_List($this->tbl_master,'status','',10, 'center');
		$this->set_Close_Setting(); 
	}
 

	function insertBox_INDIKATOR($field)
	{
		$return = $this->indikator();
		return $return;
	}

	function updateBox_INDIKATOR($field, $rows, $value)
	{
		// doi::dump($rows['l_id']);
		$return = $this->indikator($rows['l_id']);

		return $return;
	}

	function indikator($id = 0)
	{
		$rows = $this->db->where('id', $id)->order_by('id')->get("bangga_indikator_stress_test")->result_array();
 		$data['data']=$rows;
		$result = $this->load->view('indikator', $data, true);
		return $result;
	
	}

	function POST_INSERT_PROCESSOR($id , $new_data){
 		$result = $this->data->save_privilege($id , $new_data);
		if (!$result)
			return $result;
		
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		doi::dump($old_data);
		$result = $this->data->save_privilege($id , $new_data, $old_data);
		if (!$result)
			return $result;
		
		return $result;
	}

	function listBox_PID($row, $value){
		$x="KMPR";
		if($value==1){
			$x="Kinerja";
		} 
		return $x;
	}
	
	function listBox_INDIKATOR($row, $value){
 		$rows = $this->db->where('id_combo', $row['l_id'])->get("bangga_index_komposit")->result_array();
 		
				return count($rows);
	}
	
}