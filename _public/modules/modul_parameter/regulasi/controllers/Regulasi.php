<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Regulasi extends BackendController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->cboLevelMapping = $this->get_combo('data-combo', 'tingkat-resiko');
		$this->cboIMpact = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
		$this->cboLikelihod = $this->get_combo('data-combo', 'occurrence');
		$this->cboTipe = $this->get_combo('data-combo', 'tipe-regulasi');
		
		$this->load->helper(array('form', 'url'));
		// $this->cboTipe = $this->get_combo('data-combo', 'tipe-regulasi');

		$this->set_Tbl_Master(_TBL_REGULASI);

		$this->set_Open_Tab('Data ' . lang('msg_title'));
		$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 4));
		$this->addField(array('field' => 'tipe_no', 'input' => 'combo', 'combo' => $this->cboTipe, 'size' => 30));
		$this->addField(array('field' => 'title', 'size' => 50));
		$this->addField(array('field' => 'nm_file', 'input' => 'upload', 'path' => 'regulasi', 'file_type' => 'pdf|ppt|PDF|docx|doc|', 'file_random' => false));
		$this->addField(array('field' => 'poto', 'input' => 'upload', 'path' => 'regulasi', 'file_type' => 'img', 'file_random' => false));
		// if ($this->_Preference_['list_photo'] == 1)
		// 	$this->addField(array('field' => 'poto', 'input' => 'upload', 'path' => 'staft', 'file_thumb' => true));
		// 			$this->addField(array('field' => 'nm_real_file', 'show' => false));
		$this->addField(array('field' => 'att_file', 'show' => false));
		$this->addField(array('field' => 'keterangan', 'input' => 'multitext', 'size' => 500));
		$this->addField(array('field' => 'status', 'input' => 'boolean', 'size' => 15));
		$this->set_Close_Tab();

		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master));

		$this->set_Sort_Table($this->tbl_master, 'id', 'desc');

		$this->set_Table_List($this->tbl_master, 'tipe_no', '', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'title');
		$this->set_Table_List($this->tbl_master, 'nm_file', '', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'status', '', 10, 'center');

		$this->set_Close_Setting();
	}

	function listBox_TIPE_NO($rows, $value)
	{
		if (array_key_exists($value, $this->cboTipe))
			$value = $this->cboTipe[$value];
		return $value;
	}

	function listBox_NM_FILE($rows, $value)
	{
		$title = $rows['l_title'];
		if (!empty($value))
			$value = '<a target="_blank" href="' . regulasi_url($value) . '">Show</a><br/>';
		return $value;
	}
}
