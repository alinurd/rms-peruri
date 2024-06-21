<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Owner_Type extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		
		$this->tbl_master=$this->db->dbprefix('owner_type');
		
		$this->tmp_data['fields'][]=array('nmtbl'=>$this->tbl_master, 'field'=>'id', 'title'=>'id', 'input'=>array('type'=>'int','input'=>'text'), 'show'=>false, 'required'=>false, 'search'=>false, 'help'=>false, 'size'=>4, 'label'=>'l_id');
		$this->tmp_data['fields'][]=array('nmtbl'=>$this->tbl_master, 'field'=>'parent_no', 'title'=>'Parent', 'input'=>array('type'=>'string','input'=>'combo','combo'=>$this->get_combo('parent')), 'show'=>true, 'required'=>true, 'search'=>true, 'help'=>true, 'size'=>40, 'label'=>'l_parent_no');
		$this->tmp_data['fields'][]=array('nmtbl'=>$this->tbl_master, 'field'=>'type', 'title'=>'Owner Type', 'input'=>array('type'=>'string','input'=>'text'), 'show'=>true, 'required'=>true, 'search'=>true, 'help'=>true, 'size'=>40, 'label'=>'l_type');
		$this->tmp_data['fields'][]=array('nmtbl'=>$this->tbl_master, 'field'=>'status', 'title'=>'Status', 'input'=>array('type'=>'int','input'=>'boolean'), 'show'=>true, 'required'=>false, 'search'=>true, 'help'=>true, 'size'=>40, 'label'=>'l_status');
		
		$this->tmp_data['primary']=array('tbl'=>$this->tbl_master,'id'=>'id','info'=>true);
		
		$this->tmp_data['m_tbl'][]=array('master'=>1,'pk'=>$this->tbl_master);
		
		$this->tmp_data['sort'][]=array('tbl'=>$this->tbl_master,'id'=>'type');
		
		$this->tmp_data['title'][]=array($this->tbl_master,'parent_no');
		$this->tmp_data['title'][]=array($this->tbl_master,'type');
		$this->tmp_data['title'][]=array($this->tbl_master,'status');
		
		$this->data_fields['master']=$this->tmp_data;
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
	
	function cari_parent($parent=0){
		$this->db->select('*');
		$this->db->from($this->tbl_master);
		$this->db->where('id',$parent);
		$query=$this->db->get();
		$rows=$query->result();
		foreach($rows as $row){
			$this->level[]=$row->type;
			if ($row->parent_no>0)
				$this->cari_parent($row->parent_no);
		}
	}
}