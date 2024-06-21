<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Sub_Kriteria_Dampak extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->kelCombo="sub-kriteria-dampak";
		$this->kriteria_dampak=$this->get_combo('data-combo', 'kriteria-dampak');
		$this->set_Tbl_Master(_TBL_VIEW_COMBO);
		
		$this->set_Open_Tab('Sub Kriteria Dampak');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'kelompok', 'show'=>false, 'save'=>true, 'default'=>$this->kelCombo));
			$this->addField(array('field'=>'pid', 'title' => 'Kriteria Dampak', 'required' => true, 'input'=>'combo', 'combo'=>$this->kriteria_dampak, 'search'=>true, 'size'=>20));
			$this->addField(array('field' => 'parent_name', 'show' => false));
			$this->addField(array('field'=>'data', 'required'=>true, 'search'=>true, 'size'=>50));
			// $this->addField(array('field'=>'param1', 'input'=>'color', 'search'=>false, 'size'=>50));
			// $this->addField(array('field'=>'urut', 'input'=>'updown', 'search'=>false, 'size'=>60));
			$this->addField(array('field'=>'aktif', 'type'=>'string', 'input'=>'boolean', 'search'=>true, 'size'=>20));
			$this->addField(array('field' => 'risiko', 'type' => 'free', 'input' => 'free', 'mode' => 'o', 'size' => 100, 'title' => 'Nilai Dampak'));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));

		
		$this->set_Where_Table($this->tbl_master,'kelompok','=',$this->kelCombo);
		$this->set_Sort_Table($this->tbl_master,'id');
		
		// $this->set_Table_List($this->tbl_master,'kode');
		$this->set_Table_List($this->tbl_master,'data', '', 50);
		$this->set_Table_List($this->tbl_master,'parent_name', 'Kriteria Dampak', 10);
		// $this->set_Table_List($this->tbl_master,'param1','',10, 'center');
		// $this->set_Table_List($this->tbl_master,'urut','',10, 'center');
		$this->set_Table_List($this->tbl_master,'aktif','',10, 'center');

		$this->_CHANGE_TABLE_MASTER(_TBL_DATA_COMBO);

		$this->set_Close_Setting();
	}

	function listBox_PARAM1($row, $value){
		$result='<div class="label" style="background-color:'.$value.';width:100%;">&nbsp;&nbsp;&nbsp;'.$value.'&nbsp;&nbsp;&nbsp;</div>';
		return $result;
	}

	function insertBox_RISIKO($field)
	{
		$return = $this->risiko();
		return $return;
	}

	function updateBox_RISIKO($field, $rows, $value)
	{
		$return = $this->risiko($rows['l_id']);

		return $return;
	}

	function risiko($id = 0)
	{
		if ($id) {
			$rows = $this->db->where('sub_dampak_id', $id)->order_by('criteria_risiko')->get(_TBL_AREA)->result_array();
		} else {
			$rows = [];
		}

		$tblCouse = '';
		$tblCouse .= '<table class="table" id="tblCouse">
		<thead>
			<tr>
				<td width="15%">Level</td>
				<td>Deskripsi</td>
			</tr>
		</thead>
		<tbody>';
		$kriteria = [1 => 'Sangat Kecil', 2 => 'Kecil', 3 => 'Sedang', 4 => 'Besar', 5 => 'Sangat Besar'];
		if ($rows) {
			foreach ($rows as $key => $crs) {
				$tambah = '';
				$del = '';

				$tblCouse .= '<tr>
					<td style="padding-left:0px;">' . form_input('criteria_risikos[]', $kriteria[$key+1], "class='form-control' id='kel' readonly").form_hidden('criteria_risiko['.($key+1).']', $key+1, "class='form-control' id='kel'") . '</td>
					<td style="padding-left:0px;">' . form_input('area['.($key+1).']', $crs['area'], " id='risk_couse' class='form-control' ") . form_hidden(['risk_couse_no['.($key+1).']' => $crs['id']]) . '</td></tr>';
			};
		} else {
			foreach ($kriteria as $keye => $crs) {
				$tambah = '';
				$del = '';

				$tblCouse .= '<tr>
					<td style="padding-left:0px;">' . form_input('criteria_risikos[]', $crs, "class='form-control' id='kel' readonly") .form_hidden('criteria_risiko['.$keye.']', $keye, "class='form-control' id='kel'"). '</td>
					<td style="padding-left:0px;">' . form_input('area['.$keye.']', '', " id='risk_couse' class='form-control' ") . form_hidden(['risk_couse_no['.$keye.']' => '']) . '</td></tr>';
			};
		};
		$tblCouse .= '</tbody></table>';

		$riskCouse = form_input('area[]', '', " id='risk_couse' class='form-control'");
		$riskKel = form_dropdown('criteria_risiko[]', [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5], [], " id='kel' class='form-control'");
		$riskCouse_no = form_hidden(['risk_couse_no[]' => '']);

		$tblCouse .= '<script>
		var riskCouse = "' . addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $riskCouse)) . '";
		var riskKel = "' . addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $riskKel)) . '";
		var riskCouse_no = "' . addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $riskCouse_no)) . '";
		</script>';

		return $tblCouse;
	}

	function POST_INSERT_PROCESSOR($id , $new_data){
		$result = $this->data->save_privilege($id , $new_data);
		if (!$result)
			return $result;
		
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$result = $this->data->save_privilege($id , $new_data, $old_data);
		if (!$result)
			return $result;
		
		return $result;
	}
}