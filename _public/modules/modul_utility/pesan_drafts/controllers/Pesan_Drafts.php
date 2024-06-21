<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Pesan_Drafts extends BackendController {
	public function __construct()
	{
        parent::__construct();
		$this->set_Tbl_Master('pesan_inbox');
		$this->set_Table('user');
		
		$this->addField(array('field'=>'id', 'show'=>false));
		$this->addField(array('field'=>'from', 'default'=>$this->authentication->get_Info_User('nama_lengkap'), 'search'=>true, 'size'=>40));
		$this->addField(array('field'=>'type', 'default'=>'1', 'show'=>false));
		$this->addField(array('field'=>'real_to', 'show'=>false));
		$this->addField(array('field'=>'to', 'input'=>'combo:search', 'combo'=>array("satu", "dua", "tiga", "empat"),'multiselect'=>true, 'search'=>true, 'size'=>100));
		$this->addField(array('field'=>'subject', 'size'=>100));
		$this->addField(array('field'=>'content', 'input'=>'html', 'size'=>100));
		$this->addField(array('field'=>'tanggal', 'show'=>false));
		$this->addField(array('field'=>'attact', 'input'=>'upload', 'path'=>'inbox', 'size'=>20));
		$this->addField(array('field'=>'star', 'size'=>20, 'show'=>false));
		$this->addField(array('field'=>'important', 'size'=>30, 'show'=>false));
		$this->addField(array('field'=>'read', 'size'=>30, 'show'=>false));
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		$this->set_Where_Table($this->tbl_master, 'type', '=', 0);
		$this->set_Where_Table($this->tbl_master, 'real_to', '=', $this->authentication->get_Info_User('identifier'));
		$this->set_Sort_Table($this->tbl_master,'tanggal', 'desc');
		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'from', 'align'=>'center', 'upper'=>true, 'disabled'=>true));
		
		$this->set_Table_List($this->tbl_master,'star');
		$this->set_Table_List($this->tbl_master,'important');
		$this->set_Table_List($this->tbl_master,'from');
		$this->set_Table_List($this->tbl_master,'subject');
		$this->set_Table_List($this->tbl_master,'tanggal');
		$this->set_Table_List($this->tbl_master,'attact');
		
		$this->_SET_PRIVILEGE('edit', false);
		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('tombol_save', false);
		$this->_SET_PRIVILEGE('tombol_add', false);
		
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
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$upt=array();
		
		$sql = $this->db->where('id', $id)->get($this->tbl_master);
		$rows = $sql->row();
		
		$nm_file = $rows->attact;
		$result = true;
		$kelompok=0;	
		if (_CABANG_NO_>0){
			$kelompok=1;	
		}
		$upt['from']=$this->authentication->get_Info_User('identifier');
		$result = $this->crud->crud_data(array('table'=>$this->tbl_master, 'field'=>array('kelompok'=>$kelompok), 'where'=>array('id'=>$id),'type'=>'update'));
		
		if (is_array($new_data['l_to'])){
			foreach ($new_data['l_to'] as $row){
				$upt=array();
				$upt['kelompok']=$kelompok;
				$upt['type']=0;
				$upt['from']=$this->authentication->get_Info_User('identifier');
				$upt['real_to']=$row;
				$upt['attact']=$nm_file;
				$upt['subject']=$new_data['l_subject'];
				$upt['content']=$new_data['l_content'];
				$upt['tanggal']=date('Y-m-d H:i:s');
				$result = $this->crud->crud_data(array('table'=>$this->tbl_master, 'field'=>$upt, 'type'=>'add'));
			}
		}
		return true;
	}
	
	function POST_UPDATE_PROCESSORx($id , $new_data, $old_data){
		$result = $this->data->save_detail_kelas($id, $new_data);
		return $result;
	}
}