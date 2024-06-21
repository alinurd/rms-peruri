<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Project extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	
	public function __construct()
	{
		$this->load->helper('file');
        parent::__construct();
		$this->project_type_no=1;
		$this->set_Tbl_Master(_TBL_VIEW_RCSA);
		$this->set_Table(_TBL_OWNER);
		$this->set_Table(_TBL_PERIOD);
		
		$this->cbo_periode=$this->get_combo('periode');
		$this->cbo_parent=$this->get_combo('parent-input');
		$this->cbo_type_rutin=$this->get_combo('type-project-rutin');
		$this->cbo_type_investasi=$this->get_combo('investasi');
		$i=0;
		$last_periode=0;
		$mode = $this->uri->segment(2);
		foreach($this->cbo_periode as $key=>$row){
			if ($i==1){
				$last_periode=$key;
			}
			++$i;
		}
		$this->set_Open_Tab('Inisiatif Bisnis');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'corporate', 'title'=>'Nama Project', 'size'=>100, 'required'=>true, 'search'=>true));
			$this->addField(array('field'=>'owner_no', 'title'=>'Nama Risk Owner', 'input'=>'combo:search', 'combo'=>$this->cbo_parent, 'size'=>100, 'search'=>true, 'required'=>true));
			$this->addField(array('field'=>'type', 'show'=>false, 'save'=>true, 'default'=>2));
			$this->addField(array('field'=>'period_no', 'title'=>'Periode', 'input'=>'combo', 'combo'=>$this->cbo_periode, 'size'=>15));
			$this->addField(array('field'=>'start_date', 'title'=>'Tgl Mulai', 'input'=>'date', 'type'=>'date', 'size'=>10, 'required'=>true));
			$this->addField(array('field'=>'end_date', 'title'=>'Tanggal Akhir', 'input'=>'date', 'type'=>'date', 'size'=>10, 'required'=>true));
			$this->addField(array('field'=>'location', 'title'=>'Loaksi',  'size'=>100));
			$this->addField(array('field'=>'pemilik_proyek', 'input'=>'combo:search', 'combo'=>$this->cbo_parent, 'size'=>100, 'required'=>true));
			$this->addField(array('field'=>'nilai_kontrak', 'input'=>'float', 'type'=>'float', 'size'=>20));
			$this->addField(array('field'=>'tujuan', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'inv_latar_belakang', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'profil_mitra', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'inv_kondisi', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'skema_bisnis', 'input'=>'upload', 'size'=>300));
			$this->addField(array('field'=>'analisi_kebutuhan_sumber_daya', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'analisis_bisnis', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'rcsa', 'type'=>'free', 'input'=>'free', 'size'=>300));
			$this->addField(array('field'=>'inv_kesimpulan', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'rekomendasi', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'file_upload', 'input'=>'upload', 'size'=>300));
			$this->addField(array('field'=>'project_type_no', 'show'=>false, 'save'=>true, 'default'=>$this->project_type_no));
			$this->addField(array('field'=>'name', 'show'=>false, 'save'=>false));
			$this->addField(array('field'=>'periode_name', 'show'=>false, 'save'=>false));
		$this->set_Close_Tab();
		
		// }
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));		
		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'type','onChange'=>'disable_period(this.value)'));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'nilai_kontrak', 'span_right_addon'=>' Rp ', 'align'=>'right'));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_master,'name');
		$this->set_Table_List($this->tbl_master,'corporate');
		$this->set_Table_List($this->tbl_master,'periode_name');
		$this->set_Table_List($this->tbl_master,'start_date');
		$this->set_Table_List($this->tbl_master,'end_date');
		$this->set_Table_List($this->tbl_master,'location');
		
		if ($this->id_param_owner['privilege_owner']['id']>1)
			$this->set_Where_Table($this->tbl_master,'owner_no','in',$this->id_param_owner['owner_child']);	
			$this->set_Where_Table($this->tbl_master,'type','=', 2);	
		
		$this->_CHANGE_TABLE_MASTER(_TBL_RCSA);
		
		$this->set_Close_Setting();

		// $js = '<script>$("#img_l_lampiran").remove();</script>';
		// $js .= '<script>$("#l_lampiran_parent").css("padding-top","8px");</script>';
		// $js .= '<script>function check() {  }</script>';
		// $this->template->append_metadata($js);
	}
	
	function PrintBox_FORMAT(){
		$size = array('size'=>array(44,87,19,23,23,69),'align'=>array('center','left','left','center','center','center'));
		return $size;
	}
	
	function get_file(){
		$file     = upload_path_relative() . 'project/'.$this->uri->segment(3);
		$basename = basename($file);
		$length   = sprintf("%u", filesize($file));
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . $basename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Connection: Keep-Alive');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . $length);

		ob_clean();
		set_time_limit(0);
		readfile($file);
	}
	
	function delete_action(){
		$id_rcsa=intval($this->uri->segment(3));
		$id_edit=intval($this->uri->segment(4));
		$id_action=intval($this->uri->segment(5));
		$content=$this->data->delete_action($id_action);
		header('location:'.base_url('project/risk-event/'.$id_rcsa.'/'.$id_edit));
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$result=true;
		
		return $result;
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows){
		$id = $rows['l_id'];
		$url=base_url('project/risk-event');
		$tombol['detail']=array("default"=>false,"url"=>$url,"label"=>"Start Risk Register");
		return $tombol;
	}
	

}