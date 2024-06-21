<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Event extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->load->library('googlemaps');
		$this->cbo_cabang = $this->get_combo('cabang');
		$this->cbo_tipe = $this->get_combo('tipe-event');
		$this->set_Tbl_Master(_TBL_EVENTS);
		$this->set_Table('cabang');
		$this->set_Table('users');
		
		$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
		
		$this->addField(array('field'=>'cabang_no_tmp', 'type'=>'free', 'input'=>'free', 'default'=>_CABANG_NAMA_, 'size'=>45));
		$this->addField(array('field'=>'cabang_no', 'size'=>30, 'save'=>true, 'show'=>false, 'default'=>_CABANG_NO_));
		$this->addField(array('field'=>'staft_no', 'size'=>30, 'save'=>true, 'show'=>false, 'default'=>_USER_NO_));
		
		$this->addField(array('field'=>'tanggal', 'input'=>'datetime', 'type'=>'datetime', 'search'=>true, 'size'=>20));
		$this->addField(array('field'=>'event', 'search'=>true, 'size'=>50));
		$this->addField(array('field'=>'lokasi', 'required'=>true, 'search'=>true, 'size'=>60));
		$this->addField(array('field'=>'tipe', 'input'=>'combo', 'combo'=>$this->cbo_tipe, 'default'=>1, 'search'=>true, 'size'=>15));
		$this->addField(array('field'=>'warna', 'input'=>'color', 'size'=>30));
		$this->addField(array('field'=>'keterangan', 'input'=>'html', 'size'=>300));
		$this->addField(array('field'=>'file_attr', 'input'=>'upload', 'type'=>'upload', 'path'=>'events'));
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'cabang_no','sp'=>$this->tbl_cabang,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'staft_no','sp'=>$this->tbl_users,'id_sp'=>'id'));
		$this->addField(array('nmtbl'=>$this->tbl_cabang, 'field'=>'cabang', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_users, 'field'=>'nama_lengkap', 'size'=>20, 'show'=>false));
		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'cabang_no_tmp', 'disabled'=>true));
		
		$this->set_Sort_Table($this->tbl_master,'tanggal', 'desc');
		
		$this->set_Table_List($this->tbl_master,'tanggal');
		$this->set_Table_List($this->tbl_users,'nama_lengkap');
		$this->set_Table_List($this->tbl_master,'event');
		$this->set_Table_List($this->tbl_master,'lokasi');
		$this->set_Table_List($this->tbl_master,'tipe','', 10,'center');
		$this->set_Table_List($this->tbl_master,'warna','', 5,'center');
		$this->set_Table_List($this->tbl_master,'file_attr','', 10,'center');
		$this->set_Map();
		$this->set_Close_Setting();
		
		$js= script_tag(plugin_url("ckeditor/ckeditor.js"));
		$js .= '<script> 
				var url = "'.base_url().'";
				CKEDITOR.replace("editor1",
				{
					filebrowserBrowseUrl  : url + "ajax/media?type=Images",
					filebrowserUploadUrl  : url +  "ajax/upload?type=Images",
					toolbar : "Full", /* this does the magic */
					uiColor : "#9AB8F3"
				});
				
				CKEDITOR.stylesSet.add( "my_styles_custom",
				[
					// Block-level styles
					{ name : "huruf", element : "body", styles : { "font-family" : "Helvetica,Arial,sans-serif" } },
					{ name : "Red Title" , element : "h3", styles : { "color" : "Red" } },
				]);
				</script>';
		$this->template->append_metadata($js);
	}
	
	function MASTER_DATA_LIST($id){
		$this->jml_pemakai=$this->data->get_data_pemakai($id);
	}
	
	function listBox_WARNA($row, $value){
		$result = '<div style="width:100%;background-color:'.$value.'">&nbsp;</div>';
		return $result;
	}
	
	function listBox_FILE_ATTR($rows, $value){
		if (!empty($value)){
			$value = '<a href="'.base_url('ajax/download/events/'.$value).'" target="_blank">Download</a>';
		}
		return $value;
	}
	
	function updateBox_CABANG_NO_TMP($field, $rows, $value){
		$content = $this->add_Box_Input('text', $field, _CABANG_NAMA_);
		return $content;
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $row){	
		$jml=0;
		if (array_key_exists($row['l_id'], $this->jml_pemakai)){
			$jml=$this->jml_pemakai[$row['l_id']];
		}
		if ($jml>0){$tombol['delete']=array();}
		return $tombol;
	}
}