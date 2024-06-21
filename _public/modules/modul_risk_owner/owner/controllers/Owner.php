<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Owner extends BackendController {
	var $table="";
	var $post=array();
	var $arr_officer=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		$this->load->helper('file');
		$this->set_Tbl_Master(_TBL_VIEW_OWNER_CHILD);
		
		$this->cbo_parent = $this->get_combo('parent');
		$this->cbo_level = $this->get_combo('data-combo','level-owner');
		$this->data->set_officer_data();
		$this->arr_officer=$this->data->get_officer_data();
		
		$this->set_Open_Tab('Data Owner');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'parent_no', 'input'=>'combo:search', 'combo'=>$this->cbo_parent, 'required'=>true, 'search'=>true,'title'=>'Direktorat Group', 'size'=>100));
			$this->addField(array('field'=>'level_owner', 'input'=>'combo','combo'=>$this->cbo_level, 'default'=>90, 'search'=>true, 'size'=>50));
			if ($this->_Preference_['list_photo']==1)
				$this->addField(array('field'=>'photo', 'input'=>'upload', 'path'=>'staft', 'file_thumb'=>true));
			
			$this->addField(array('field'=>'name', 'size'=>50));
			$this->addField(array('field'=>'parent_name', 'size'=>50, 'show' => false));
			$this->addField(array('field'=>'leader_name', 'size'=>50));
			$this->addField(array('field'=>'owner_code', 'size'=>30));
			$this->addField(array('field'=>'address', 'input'=>"multitext", 'size'=>500));
			$this->addField(array('field'=>'phone', 'size'=>10));
			$this->addField(array('field'=>'mobile', 'size'=>10));
			$this->addField(array('field'=>'email', 'size'=>15));
			$this->addField(array('field'=>'website', 'size'=>20));
			$this->addField(array('field'=>'fax', 'size'=>10));
			$this->addField(array('field'=>'item_use', 'type'=>'free', 'show'=>false,'size'=>100));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'size'=>30));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		// $this->addField(array('nmtbl'=>_TBL_OWNER_TYPE, 'field'=>'type', 'size'=>20, 'show'=>false));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		// if ($this->_Preference_['list_photo']==1)
			// $this->set_Table_List($this->tbl_master,'photo','Photo',0,'center', true, true);
		// $this->set_Table_List($this->tbl_master,'parent_no','Direktorat Group');
		$this->set_Table_List($this->tbl_master,'parent_name', 'Direktorat Group');
		$this->set_Table_List($this->tbl_master,'name', 'Nama Owner');
		$this->set_Table_List($this->tbl_master,'leader_name', '', 8, 'center');
		$this->set_Table_List($this->tbl_master,'phone');
		$this->set_Table_List($this->tbl_master,'email');
		$this->set_Table_List($this->tbl_master,'status', '', 8, 'center');
		$this->set_Table_List($this->tbl_master,'item_use', '', 8, 'center');
			
		if ($this->id_param_owner['privilege_owner']['id'] > 1 )
			$this->set_Where_Table($this->tbl_master,'id','in',$this->id_param_owner['owner_child']);
		
		$this->_CHANGE_TABLE_MASTER(_TBL_OWNER);
		$this->set_Close_Setting();
	}
	
	function listBox_LEADER_NAME($row, $value){
		$id=$row['l_id'];
		$value='';
		if (array_key_exists($id, $this->arr_officer)){
			$value=ucwords($this->arr_officer[$id]['officer_name']);
		}
		return $value;
	}
	
	function listBox_PHOTO($row, $value){
		$id=$row['l_id'];
		$photo='';
		if (array_key_exists($id, $this->arr_officer)){
			$photo=$this->arr_officer[$id]['photo'];
		}
		$value=show_image($value,160, 50);
		return $value;
	}
	
	function list_MANIPULATE_ACTION(){
		$tombol['left'][]='<a class="add btn btn-primary btn-flat" href="'.base_url('owner/menu-posisi').'" data-toggle="popover" data-content="Atur Menu Posisi"><i class="fa fa-list"></i> Posisi Owner </a>&nbsp;&nbsp;';
		return $tombol;
	}
	
	function menu_posisi(){
		$this->_SET_PRIVILEGE('add', false);
		$data = $this->input->post();
		// Doi::dump($data);
		if ($data){
			$this->simpan_nilai($data);
		}else{
			$this->session->set_userdata(['pos_posisi_owner'=>1]);
			$data['field']=$this->data->get_data_posisi_menu();
			$outpute = '';
			foreach($data['field'] as $row){
				$outpute .= $this->buildItem($row);
			}
			$data['tree'] = $outpute;
			$data['source_tree'] = json_encode($data['field']);
			$tombol = $this->_get_list_action_button();
			$data['action']=$tombol;
			// $result=$this->load->view("menu", $data, TRUE);
			$this->template->build('owner',$data); 
			// return $result;
		}
	}
	
	function buildItem($ad) {
		$o=show_image($ad['photo'],60, 30);
		$icon='';
		$del='';
		if ($ad['status']==0){
			$icon = ' &nbsp;<i class="fa fa-times-circle text-danger"></i> ';
		}
		
		if (!array_key_exists('children', $ad)) {
			$del=" | <a href='".base_url($this->modul_name.'/delete/'.$ad['id'])."' class='delete_modul text-danger'> <i class='fa fa-trash'></i></a>";
		}
		
		
		$html = "<li class='dd-item dd3-item' data-id='" . $ad['id'] . "'>";
		$html .= "<div class='dd-handle dd3-handle'></div><div class='dd3-content'>" . ucwords(strtolower($ad['title'])) . $icon . "  <span class='pull-right' style='margin-top:-5px;'>".$ad['name']." - ".$o." | <a href='".base_url($this->modul_name.'/edit/'.$ad['id'])."' class='edit_modul'><i class='fa fa-pencil-square-o'></i></a>".$del."</span></div>";
		if (array_key_exists('children', $ad)) {	
			$html .= "<ol class='dd-list'>";
			foreach($ad['children'] as $row){
				$html .= $this->buildItem($row);
			}
			$html .= "</ol>";
		}	
		$html .= "</li>";
		return $html;
	}
	
	function simpan_nilai($post){
		$result = $this->data->simpan_nilai($post);
		unset($_POST);
		if ($post['l_save']=="Simpan"){
			header('location:'.base_url($this->uri->uri_string));
		}else{
			header('location:'.base_url('owner'));
		}
		exit();
	}
	
	function listBox_PARENT_NO($row, $value){
		$this->level=array();
		$this->cari_parent($value);
		$arr=array();
		for($i=count($this->level)-1;$i>=0;$i--){
			$arr[]=$this->level[$i];
		}
		$result=implode(' | ',$arr);
		return $result;
	}
	
	function PrintBox_PARENT_NO($row, $value){
		
		$result="-";
		return $result;
	}
	
	function cari_parent($parent=0){
		$this->db->select('*');
		$this->db->from($this->tbl_master);
		$this->db->where('id',$parent);
		$query=$this->db->get();
		$rows=$query->result();
		foreach($rows as $row){
			$this->level[]=$row->name;
			if ($row->parent_no>0)
				$this->cari_parent($row->parent_no);
		}
	}
	
	function POST_CHECK_BEFORE_DELETE($ids=array()){
		$ada=false;
		// Doi::dump($ids);die();
		foreach($ids as $row){
			$value=$this->data->cari_total_dipakai($row);
			if ($value['jml']>0){
				$this->_set_pesan('Owner : ' . $value['nama_owner']);
				$ada=true;
			}
		}
		if ($ada)
			$this->_set_pesan('Tidak bisa dihapus');
		
		return !$ada;
	}
	
	function listBox_ITEM_USE($row, $value){
		$result='';
		$id=$row['l_id'];
		if (array_key_exists($id, $this->data_owner))
			$result =  '<span class="badge bg-blue">' . $this->data_owner[$id] . '</span>';
		return $result;
	}
	
	function PrintBox_ITEM_USEx($row, $value){
		$id=$row['l_id'];
		$result = $this->data_owner[$id];
		return $result;
	}
	
	function MASTER_DATA_LIST(){
		// $this->session->set_userdata(['pos_posisi_owner'=>0]);
		$this->data_owner = $this->data->get_data_owner();
	}
	
	function POST_UPDATE_REDIRECT_URL($url, $id, $mode){
		$asal = $this->session->userdata('pos_posisi_owner');
		if ($asal==1){
			$url=base_url('owner/menu-posisi/');
		}elseif ($mode=="Simpan_Quit"){
			$url=base_url("owner");
		}
		return $url;
	}
}