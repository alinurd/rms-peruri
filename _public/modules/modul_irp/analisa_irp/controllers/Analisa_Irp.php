<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Analisa_Irp extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		
		$this->set_Tbl_Master(_TBL_IRP);
		$this->set_Table(_TBL_OWNER);
		$this->set_Table(_TBL_PERIOD);
		
		$this->cbo_periode=$this->get_combo('periode');
		$this->cbo_parent=$this->get_combo('parent-input');
		$this->cbo_type=$this->get_combo('type-project');
		
		$i=0;
		$last_periode=0;
		$mode = $this->uri->segment(2);
		foreach($this->cbo_periode as $key=>$row){
			if ($i==1){
				$last_periode=$key;
			}
			++$i;
		}
		$this->set_Open_Tab('Konteks Risiko');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'corporate', 'size'=>100));
			$this->addField(array('field'=>'owner_no', 'input'=>'combo:search', 'combo'=>$this->cbo_parent, 'size'=>100));
			$this->addField(array('field'=>'period_no', 'input'=>'combo', 'combo'=>$this->cbo_periode, 'size'=>15));
			$this->addField(array('field'=>'start_date', 'input'=>'date', 'type'=>'date', 'size'=>10));
			$this->addField(array('field'=>'end_date', 'input'=>'date', 'type'=>'date', 'size'=>10));
			$this->addField(array('field'=>'location', 'input'=>'combo:search', 'combo'=>$this->cbo_parent, 'size'=>100));
			$this->addField(array('field'=>'deskripsi', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'participant', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'facilitator', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'item_use', 'input'=>'free', 'type'=>'free', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'register', 'input'=>'free', 'type'=>'free', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'size'=>15));
		$this->set_Close_Tab();
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'owner_no','sp'=>$this->tbl_owner,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'period_no','sp'=>$this->tbl_period,'id_sp'=>'id'));
		
		$this->addField(array('nmtbl'=>$this->tbl_owner, 'field'=>'name', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_period, 'field'=>'periode_name', 'size'=>20, 'show'=>false));
			
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_owner,'name');
		$this->set_Table_List($this->tbl_master,'corporate');
		$this->set_Table_List($this->tbl_master,'start_date');
		$this->set_Table_List($this->tbl_master,'end_date');
		$this->set_Table_List($this->tbl_master,'location');
		$this->set_Table_List($this->tbl_master,'item_use');
		$this->set_Table_List($this->tbl_master,'register');
		
		
		if ($this->id_param_owner['privilege_owner']['id']>1)
			$this->set_Where_Table($this->tbl_master,'owner_no','in',$this->id_param_owner['owner_child']);	
		
		$this->set_Close_Setting();	
	}
	
	function PrintBox_FORMAT(){
		$size = array('size'=>array(44,87,19,23,23,69),'align'=>array('center','left','left','center','center','center'));
		return $size;
	}
	
	function get_register(){
		$id=$this->input->post('id');
		$data['field']=$this->data->get_data_register($id);
		$hasil['register']=$this->load->view('risk-register', $data, true);
		echo json_encode($hasil);
	}
	
	function insertBox_TYPE($field){
		$content = $this->radio_type($field);
		return $content;
	}
	
	function updateBox_TYPE($field, $row, $value){
		$content = $this->radio_type($field, $row, $value);
		return $content;
	}
	
	function radio_type($field, $row=array(), $value='1'){
		$check_1=false;
		$check_2=false;

		if ($value=="1")
			$check_1=true;
		elseif ($value=="2")
			$check_2=true;
		
		// $check_2=true;
		$content = form_radio($field['label'], 1, $check_1, 'id="'.$field['label'].'_1" ');
		$content .= form_label('Hiradc &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	', '1', ' ');
		$content .= form_radio($field['label'], 2, $check_2, 'id="'.$field['label'].'_2"');
		$content .= form_label('IADL','2');
		
		return $content;
	}
	
	function listBox_TYPE($row, $value){
		if ($value=='1')
			$result='HIRADC';
		else
			$result='IADL';
		
		return $result;
	}
	
	function listBox_REGISTER($row, $value){
		$id=$row['l_id'];
		$result = '<i class="fa fa-search showRegister pointer" data-id="'.$id.'"></i>';
		return $result;
	}
	
	function POST_CHECK_BEFORE_DELETE($ids=array()){
		$ada=false;
		// Doi::dump($ids);die();
		foreach($ids as $row){
			$value=$this->data->cari_total_dipakai($row);
			if ($value['jml']>0){
				$this->_set_pesan('Risk Register : ' . $value['nama']);
				$ada=true;
			}
		}
		if ($ada)
			$this->_set_pesan('Tidak bisa dihapus');
		
		return !$ada;
	}
	
	function listBox_ITEM_USE($row, $value){
		$result='';
		$value=$this->data->cari_total_dipakai($row['l_id']);
		if ($value['jml']>0)
			$result =  '<span class="badge bg-info">' . $value['jml'] . '</span>';
		return $result;
	}
	
	function PrintBox_ITEM_USE($row, $value){
		$value=$this->data->cari_total_dipakai($row['l_id']);
		return $value['jml'];
	}
	
	function get_parameters(){
		
		$id=intval($this->uri->segment(3));
		$data['data_edit']=$this->data->get_data($id);
		$data['cbo_owner']=$this->get_combo('parent-input-all');
		$data['cbo_type']=$this->get_combo('risk_tipe');
		$data['cbo_period']=$this->get_combo('periode');
		$data['cbo_level_like']=$this->get_combo('likelihood');
		$data['cbo_level_impact']=$this->get_combo('impact');
		$data['cbo_level_impact_baru']=$this->data->cbo_level_impact_baru($id);
		$data['cbo_treatment']=$this->get_combo('treatment');
		$data['cbo_rcsa']=array('- Select -');
		
		$result = $this->load->view('view_param',$data,true);
		return $result;
	}
	
	function update_OPTIONAL_CMD($id){
		$result[]=array('posisi'=>'right', 'content'=>'<a class="btn btn-warning btn-flat" style="width:100%;" data-content="Detail Risk Register" data-toggle="popover" href="'.base_url($this->modul_name.'/risk-event/'.$id).'" data-original-title="" title=""><strong style="text-shadow: 1px 2px #020202;">START<br/>Risk Register</strong></a>');
		return $result;
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows){
		$id = $rows['l_id'];
		$url=base_url($this->modul_name.'/risk-event');
		$url2=base_url($this->modul_name.'/risk-register');
		$tombol['detail']=array("default"=>false,"url"=>$url,"label"=>"Start Risk Register");
		// $tombol['detail_preview']=array("default"=>false,"url"=>$url2,"label"=>"View Risk Register");
		return $tombol;
	}
	
	function delete_event(){
		$rcsa=intval($this->uri->segment(3));
		$id_edit=intval($this->uri->segment(4));
		$result=$this->data->delete_event($id_edit);
		header('location:'.base_url('rcsa/risk-event/'.$rcsa));
	}
	
	function risk_event($param=array()){
		$id=0;
		if ($param){
			if(strtolower($param[0])=='add' || strtolower($param[0])=='edit'){
				$parent=(count($param)>1)?$param[1]:0;
				$id=(count($param)>2)?$param[2]:0;
				$view='input-risk-event';
				$this->data_combo=$this->data->get_data_risk_event_detail($id, $parent);
				$this->data_combo['mode']=$param[0];
				$this->data_combo['list_mitigasi']=$this->load->view('mitigasi', $this->data_combo, true);
				$this->element_risk_event($this->data_combo['detail'], $parent);
			}elseif(strtolower($param[0]=='save')){
				$post = $this->input->post();
				$parent = $post['parent_no'];
				$result = $this->data->simpan_risk_event($post);
				header('location:'.base_url($this->modul_name.'/risk-event/edit/'.$parent.'/'.$result));
			}else{
				$id=$param[0];
				$view='risk-event';
				$this->data_combo=$this->data->get_data_risk_event($id);
			}
			$this->template->build($view, $this->data_combo); 
		}else{
			header('location:'.base_url($this->modul_name));
		}
	}
	
	function get_form_mitigasi(){
		$post=$this->input->post();
		$data = $this->data->get_data_mitigasi($post['id_edit']);
		$data['parent']=$post['parent'];
		$data['id']=$post['id'];
		$data['id_edit']=$post['id_edit'];
		$hasil['combo']=$this->load->view('input_mitigasi', $data, true);
		echo json_encode($hasil);
	}
	function get_mitigasi(){
		$post=$this->input->post();
		$data=$this->data->get_data_list_mitigasi($post['id']);
		$hasil['combo']=$this->load->view('mitigasi', $data, true);
		echo json_encode($hasil);
	}
	function save_mitigasi(){
		$post=$this->input->post();
		$data = $this->data->save_mitigasi($post);
		$hasil['combo']=$this->load->view('mitigasi', $data, true);
		echo json_encode($hasil);
	}
	
	function element_risk_event($data=array(), $parent=0){
		$cboLokasi = $this->get_combo('parent-input');
		$cboAktivitas = $this->get_combo('data-combo', 'aktifitas-hiradc');
		$cboAset = $this->get_combo('data-combo', 'aset-irp');
		$cboEvent = $this->get_combo('library', 1);
		
		$cboDampak = $this->get_combo('data-combo', 'dampak-irp');
		$cboKemungkinan = $this->get_combo('data-combo', 'kemungkinan-irp');
		$cboStatus = $this->get_combo('data-combo', 'status-hiradc');
		
		
		$class='class="form-control select3" style="width:100%;" ';
		$tingkat="";
		$status="";
		$this->data_combo['identifikasi'][]=array('label'=>lang('msg_field_lokasi'), 'isi'=>form_dropdown('area_no', $cboLokasi, ($data)?$data['area_no']:'',''.$class.' id="area_no"'));
		$this->data_combo['identifikasi'][]=array('label'=>lang('msg_field_aktifitas'), 'isi'=>form_dropdown('aktifitas_no', $cboAktivitas, ($data)?$data['aktifitas_no']:'',''.$class.' id="aktifitas_no"'));
		$this->data_combo['identifikasi'][]=array('label'=>lang('msg_field_aset'), 'isi'=>form_dropdown('aset_no', $cboAset, ($data)?$data['aset_no']:'',''.$class.' id="aset_no"'));
		$this->data_combo['identifikasi'][]=array('label'=>lang('msg_field_fungsi_kritis'), 'isi'=>form_input('fungsi_kritis', ($data)?$data['fungsi_kritis']:'','class="form-control" id="fungsi_kritis"'));
		$this->data_combo['identifikasi'][]=array('label'=>lang('msg_field_kerawanan'), 'isi'=>form_input('kerawanan', ($data)?$data['kerawanan']:'','class="form-control" id="kerawanan"'));
		$this->data_combo['identifikasi'][]=array('label'=>lang('msg_field_ancaman'), 'isi'=>form_dropdown('ancaman_no', $cboEvent, ($data)?$data['ancaman_no']:'',''.$class.' id="ancaman_no"'));
		
		$this->data_combo['hidden']=form_hidden(array('id_edit'=>($data)?$data['id']:0,'parent_no'=>$parent,'mode'=>$this->data_combo['mode']));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_dampak'), 'isi'=>form_dropdown('dampak_no', $cboDampak, ($data)?$data['dampak_no']:'',''.$class.' id="dampak_no"'));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_kemungkinan'), 'isi'=>form_dropdown('kemungkinan_no', $cboKemungkinan, ($data)?$data['kemungkinan_no']:'',''.$class.' id="kemungkinan_no"'));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_score'), 'isi'=>form_input('score_resiko', ($data)?$data['score_resiko']:'','class="form-control text-center" style="width:15%;" readonly="readonly" id="score_resiko"'));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_tingkat_resiko'), 'isi'=>'<div id="resiko" style="width:100%;">'.$tingkat.'</div>');
	}
	
	function get_severity(){
		$post = $this->input->post();
		$tr = $post['tr_no'];
		$srd = $post['srd_no'];
		$bp = $post['bp_no'];
		$lp = $post['lp_no'];
		$cp = $post['cp_no'];
		$occorunce = $post['occorunce_no'];
		
		$rows = $this->db->select('param1')->where('id', $tr)->or_where('id', $srd)->or_where('id', $bp)->or_where('id', $lp)->or_where('id', $cp)->get(_TBL_DATA_COMBO)->result_array();
		$severity=0;
		if ($rows){
			$no=0;
			$ttl=1;
			foreach($rows as $row){
				++$no;
				$ttl*=$row["param1"];
			}
			$ttl=number_format($ttl/$no,1);
			$severity = $ttl;
		}
		
		$rows = $this->db->where('id', $occorunce)->get(_TBL_DATA_COMBO)->row_array();
		$score=0;
		if ($rows){
			$score = floatval($rows['param1']);
		}
		$score = $severity * $score;
		
		$rows = $this->db->select('data, param1, param2, tingkat_resiko_no, score')->from(_TBL_LEVEL_COLOR_K3)->join(_TBL_DATA_COMBO, _TBL_LEVEL_COLOR_K3.'.tingkat_resiko_no='._TBL_DATA_COMBO.'.id')->order_by('score', 'desc')->get()->result_array();
		
		$tingkat=0;
		$resiko="";
		$bgcolor="";
		$color="";
		foreach($rows as $row){
			// echo $score ." <= ". $row['score']."<br/>";
			if($row['score'] <=$score){
				$tingkat=$row['tingkat_resiko_no'];
				$resiko=strtoupper($row['data']);
				$bgcolor=$row['param1'];
				$color=$row['param2'];
				break 1;
			}
		}
		
		$stsPenting = "-";
		$stsPenting_no = 0;
		$regulasi=(isset($post['regulasi']))?1:0;
		$rows = $this->db->where('kelompok', 'status-hiradc')->get(_TBL_DATA_COMBO)->result_array();
		foreach($rows as $row){
			$faktor=explode(',', $row['param1']);
			if (in_array($tingkat, $faktor) && $regulasi==$row['param2']){
				$stsPenting = $row['data'];
				$stsPenting_no = $row['id'];
				break 1;
			}
		}
		
		$data['severity'] = number_format($severity,1);
		$data['score_resiko'] = number_format($score,1);
		$data['risk_impact'] = $tingkat;
		$data['resiko'] = '<span style="background:'.$bgcolor.';color:'.$color.';padding:5px 25px;"> '.$resiko.' </span>';
		$data['statusNo'] = $stsPenting_no;
		$data['statusText'] = '<span class="bg-orange" style="padding:5px 25px;"> '.$stsPenting.' </span>';
		
		echo json_encode($data);
	}
}