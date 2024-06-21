<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Asset extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->cbo_cabang = $this->get_combo('cabang');
		$this->set_Tbl_Master('asset');
		$this->set_Table('cabang');
		
		$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
		// if (_CABANG_NO_==0){
			// $this->addField(array('field'=>'cabang_no', 'input'=>'combo', 'combo'=>$this->cbo_cabang, 'required'=>true, 'search'=>true, 'size'=>50));
		// }else{
			$this->addField(array('field'=>'cabang_no_tmp', 'type'=>'free', 'input'=>'free', 'default'=>_CABANG_NAMA_, 'size'=>45));
			$this->addField(array('field'=>'cabang_no', 'size'=>30, 'save'=>true, 'default'=>_CABANG_NO_, 'show'=>false));
		// }
		$this->addField(array('field'=>'asset', 'required'=>true, 'search'=>true, 'size'=>60));
		$this->addField(array('field'=>'tanggal_beli', 'input'=>'date', 'size'=>15));
		$this->addField(array('field'=>'lokasi', 'size'=>35));
		$this->addField(array('field'=>'jumlah', 'input'=>'float', 'type'=>'float', 'size'=>10));
		$this->addField(array('field'=>'harga', 'input'=>'float', 'type'=>'float', 'size'=>25));
		$this->addField(array('field'=>'keterangan', 'input'=>'multitext', 'search'=>true, 'size'=>500));
		$this->addField(array('field'=>'aktif', 'type'=>'int', 'input'=>'boolean', 'search'=>true, 'size'=>20));
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'cabang_no','sp'=>$this->tbl_cabang,'id_sp'=>'id'));
		$this->addField(array('nmtbl'=>$this->tbl_cabang, 'field'=>'cabang', 'size'=>20, 'show'=>false));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'cabang_no_tmp', 'disabled'=>true));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'jumlah', 'span_left_addon'=>' buah', 'align'=>'center'));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'harga', 'span_right_addon'=>'Rp. ', 'align'=>'right'));
		
		$this->set_Sort_Table($this->tbl_master,'asset');
		$this->set_Where_Table($this->tbl_master, 'cabang_no', '=', _CABANG_NO_);
		
		$this->set_Table_List($this->tbl_cabang,'cabang');
		$this->set_Table_List($this->tbl_master,'asset');
		$this->set_Table_List($this->tbl_master,'tanggal_beli');
		$this->set_Table_List($this->tbl_master,'lokasi');
		$this->set_Table_List($this->tbl_master,'jumlah');
		$this->set_Table_List($this->tbl_master,'harga');
		$this->set_Table_List($this->tbl_master,'aktif','',10);
		$this->set_Close_Setting();
	}
	
	function MASTER_DATA_LIST($id){
		$this->jml_pemakai=$this->data->get_data_pemakai($id);
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