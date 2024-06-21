<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Risk_Type extends BackendController {
	public function __construct()
	{
        parent::__construct();
		
		// $this->kel=array('1'=>'Internal','2'=>'External');
		$this->kel=$this->get_combo('data-combo','kel-library');
		$this->set_Tbl_Master(_TBL_RISK_TYPE);
		
		$this->set_Open_Tab('Data Risk Event Library');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'code', 'size'=>50));
			$this->addField(array('field'=>'kelompok', 'input'=>'combo', 'combo'=>$this->kel, 'size'=>50));
			$this->addField(array('field'=>'type', 'size'=>20));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'size'=>20));
		$this->addField(array('field' => 'subRisiko', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));

		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'type');
		
		$this->set_Table_List($this->tbl_master,'kelompok');
		$this->set_Table_List($this->tbl_master,'code','','','center');
		$this->set_Table_List($this->tbl_master, 'subrisiko', 'Jml subRisiko', 5, 'center');

		$this->set_Table_List($this->tbl_master,'type');
		$this->set_Table_List($this->tbl_master,'status','','','center');
		
		$this->set_Close_Setting();
	}
	public function MASTER_DATA_LIST($arrId, $rows)
	{
		$this->use_list = $this->data->cari_total_dipakai($arrId);
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

	function listBox_KELOMPOK($row, $value){
		$result='';
		if (array_key_exists($value, $this->kel)){
			$result=$this->kel[$value];
		}
		return $result;
	}
	function listBox_SUBRISIKO($rows, $value)
	{
		$id = $rows['l_id'];
		// doi::dump($id);
		$jml = '';
		if (array_key_exists($id, $this->use_list['subrisiko'])) {
			$jml = $this->use_list['subrisiko'][$id];
		}

		return $jml;
	}
	function insertBox_SUBRISIKO($field)
	{
		$content = $this->get_SUBRISIKO();
		return $content;
	}
	 

	function updateBox_SUBRISIKO($field, $row, $value)
	{
		$content = $this->get_subRisiko();
		return $content;
	}

	function get_subRisiko($id = 0)
	{
		$id = $this->uri->segment(3);
		$data['field'] = $this->db->where('risiko_no', $id)->get(_TBL_SUBRISIKO)->result_array();
		$result = $this->load->view('sasaran', $data, true);
		return $result;
	}


	function delete_subrisiko()
	{ //delete from table sasaran in rcsa edit
		$halaman = $this->uri->segment(4); //halaman edit

		$this->data->delete_subrisiko($this->uri->segment(3));
		redirect('/risk-type/edit/' . $halaman);
	}


}