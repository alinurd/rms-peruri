<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Send_Item extends BackendController {
	var $list_from=array();
	public function __construct()
	{
        parent::__construct();
		$this->cbo_karyawan=$this->get_combo('kontak');
		$this->set_Tbl_Master('pesan_inbox');
		$this->set_Table('user');
		
		$this->addField(array('field'=>'id', 'show'=>false));
		$this->addField(array('field'=>'from', 'default'=>$this->authentication->get_Info_User('nama_lengkap'), 'search'=>true, 'size'=>40));
		$this->addField(array('field'=>'type', 'default'=>'1', 'show'=>false));
		$this->addField(array('field'=>'real_to', 'show'=>false));
		$this->addField(array('field'=>'to', 'input'=>'combo:search', 'combo'=>$this->cbo_karyawan,'multiselect'=>true, 'search'=>true, 'size'=>100));
		$this->addField(array('field'=>'subject', 'size'=>100));
		$this->addField(array('field'=>'content', 'input'=>'html', 'size'=>100));
		$this->addField(array('field'=>'tanggal', 'show'=>false));
		$this->addField(array('field'=>'attact', 'input'=>'upload', 'path'=>'inbox', 'size'=>20));
		$this->addField(array('field'=>'star', 'size'=>20, 'show'=>false));
		$this->addField(array('field'=>'read', 'size'=>30, 'show'=>false));
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		$this->set_Where_Table($this->tbl_master, 'type', '=', 1);
		$this->set_Where_Table($this->tbl_master, 'from', '=', $this->authentication->get_Info_User('identifier'));
		$this->set_Sort_Table($this->tbl_master,'tanggal', 'desc');
		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'from', 'align'=>'center', 'upper'=>true, 'disabled'=>true));
		
		$this->set_Table_List($this->tbl_master,'star', '', 5, 'center');
		$this->set_Table_List($this->tbl_master,'to', '', 20);
		$this->set_Table_List($this->tbl_master,'subject');
		$this->set_Table_List($this->tbl_master,'attact', '', 5, 'center');
		$this->set_Table_List($this->tbl_master,'tanggal', '', 10, 'center');
		
		$this->_SET_PRIVILEGE('edit', false);
		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('tombol_save', false);
		$this->_SET_PRIVILEGE('tombol_add', false);
		
		$this->set_Close_Setting();
		
		if ($this->uri->segment(2)=='add' || $this->uri->segment(2)=='edit'){
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
	}
	
	function MASTER_DATA_LIST($id, $data){
		$arr=array();
		foreach($data['fields'] as $row){
			$arr[]=$row['l_from'];
		}
		if ($arr){
			$this->list_from=$this->data->get_data_from($arr);
		}
	}
	
	function download_attct(){
		$this->load->helper('download');
		$id = $this->uri->segment(3);
		$nm_file = $this->data->get_file_attct($id);
		if (file_exists(inbox_path_relative($nm_file))) {
			force_download(inbox_path_relative($nm_file), null, true);
		}
	}
	
	function listBox_TANGGAL($rows, $value){
		$value = time_ago($value);
		return $value;
	}
	
	function listBox_TO($rows, $value){
		$arr=explode(',',$value);
		$nama = array();
		foreach($arr as $row){
			if(array_key_exists($row, $this->cbo_karyawan)){
				$nama []=$this->cbo_karyawan[$row];
			}
		}
		$value = implode(' | ', $nama);
		return $value;
	}
	
	function listBox_STAR($rows, $value){
		$id = $rows['l_id'];
		if ($value==1){
			$value = '<a class="bintang pointer" data-id="'.$id.'" data-sts="yes"><i class="fa fa-star text-yellow"></i></a>';
		}else{
			$value = '<a class="bintang pointer" data-id="'.$id.'" data-sts="no"><i class="fa fa-star-o text-yellow"></i></a>';
		}
		return $value;
	}
	
	function listBox_ATTACT($rows, $value){
		$id = $rows['l_id'];
		if (!empty($value)){
			$value = '<a href="'.base_url($this->modul_name.'/download-attct/'.$id).'" target="_blank"><i class="fa fa-paperclip"></i></a>';
		}else{
			$value = '';
		}
		return $value;
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
		$upt['kelompok']=$kelompok;
		$result = $this->crud->crud_data(array('table'=>$this->tbl_master, 'field'=>$upt, 'where'=>array('id'=>$id),'type'=>'update'));
		
		if (is_array($new_data['l_to'])){
			foreach ($new_data['l_to'] as $row){
				$upt=array();
				$upt['parent_no']=$id;
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