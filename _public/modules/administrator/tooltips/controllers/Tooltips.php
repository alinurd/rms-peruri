<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Tooltips extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->load->library("datacombo");
		$this->cbo_modul = $this->datacombo->_COMBO_MODUL('nm_modul');
		$this->cbo_aksi = $this->get_combo('aksi-tooltips');
		$this->set_Tbl_Master(_TBL_TOOLTIPS);
		
		$this->set_Open_Tab('Data Tooltips');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'modul_no', 'input'=>'combo:search', 'combo'=>$this->cbo_modul, 'size'=>100));
			$this->addField(array('field'=>'aksi_no', 'input'=>'combo', 'combo'=>$this->cbo_aksi, 'size'=>10));
			$this->addField(array('field'=>'isi', 'input'=>'html', 'size'=>500));
			$this->addField(array('field'=>'urut', 'input'=>'updown','search'=>true, 'size'=>80));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'search'=>true, 'size'=>40));
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'modul_no');
		$this->set_Sort_Table($this->tbl_master,'aksi_no');
		$this->set_Table_List($this->tbl_master,'modul_no');
		$this->set_Table_List($this->tbl_master,'aksi_no');
		$this->set_Table_List($this->tbl_master,'urut');
		$this->set_Table_List($this->tbl_master,'status','',10, 'center');
		
		$this->set_Close_Setting();
		
		$js= script_tag(plugin_url("ckeditor/ckeditor.js"));
		$js .= '<script> 
				var url = "'.base_url().'";
				CKEDITOR.replace("l_isi",
				{
					filebrowserBrowseUrl  : url + "ajax/media?type=Images",
					filebrowserUploadUrl  : url +  "ajax/upload?type=Images",
					toolbar : "Full", /* this does the magic */
					uiColor : "#9AB8F3"
				});
				</script>';
		$this->template->append_metadata($js);
	}	
	
	function listBox_AKSI_NO($rows, $value){
		if (array_key_exists($value, $this->cbo_aksi))
			$value = $this->cbo_aksi[$value];
		elseif ($value==0){$value="Semua Aksi";}
		return $value;
	}
	
	function listBox_MODUL_NO($rows, $value){
		if (array_key_exists($value, $this->cbo_modul))
			$value = $this->cbo_modul[$value];
		elseif ($value==0){$value="Semua Modul";}
		
		return $value;
	}
}