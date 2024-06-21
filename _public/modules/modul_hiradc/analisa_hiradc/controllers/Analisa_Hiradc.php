<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Analisa_Hiradc extends BackendController {
	var $use_list=array();
	public function __construct()
	{
        parent::__construct();
		
		$this->set_Tbl_Master(_TBL_HIRADC);
		$this->set_Table(_TBL_OWNER);
		$this->set_Table(_TBL_PERIOD);
		
		$this->cbo_periode=$this->get_combo('periode');
		$this->cbo_parent=$this->get_combo('parent-input');
		$this->cbo_type=$this->get_combo('type-hiradc', true);
		
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
			$this->addField(array('field'=>'corporate', 'size'=>100, 'search'=>true));
			$this->addField(array('field'=>'owner_no', 'input'=>'combo:search', 'search'=>true, 'combo'=>$this->cbo_parent, 'size'=>100));
			$this->addField(array('field'=>'type', 'input'=>'radio', 'combo'=>$this->cbo_type, 'size'=>15));
			$this->addField(array('field'=>'period_no', 'input'=>'combo', 'combo'=>$this->cbo_periode, 'size'=>15));
			$this->addField(array('field'=>'start_date', 'input'=>'date', 'type'=>'date', 'size'=>10));
			$this->addField(array('field'=>'end_date', 'input'=>'date', 'type'=>'date', 'size'=>10));
			$this->addField(array('field'=>'item_use', 'input'=>'free', 'type'=>'free', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'register', 'input'=>'free', 'type'=>'free', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'size'=>15));
		$this->set_Close_Tab();
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'owner_no','sp'=>$this->tbl_owner,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'period_no','sp'=>$this->tbl_period,'id_sp'=>'id'));
		
		$this->addField(array('nmtbl'=>$this->tbl_owner, 'field'=>'name', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_period, 'field'=>'periode_name', 'size'=>20, 'show'=>false));
		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'type','onChange'=>'disable_period(this.value)'));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'nilai_kontrak', 'span_right_addon'=>' Rp ', 'align'=>'right'));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'target_laba', 'span_right_addon'=>' Rp ', 'align'=>'center'));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_owner,'name');
		$this->set_Table_List($this->tbl_master,'corporate');
		$this->set_Table_List($this->tbl_master,'type');
		$this->set_Table_List($this->tbl_master,'start_date');
		$this->set_Table_List($this->tbl_master,'end_date');
		$this->set_Table_List($this->tbl_master,'item_use', '', 8, 'center');
		$this->set_Table_List($this->tbl_master,'register', '', 8, 'center');
		
		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_owner, 'id');		
		$this->set_Close_Setting();	
	}
	
	function get_register(){
		$id=$this->input->post('id');
		$data['field']=$this->data->get_data_register($id);
		$data['id']=$id;
		$hasil['register']=$this->load->view('risk-register', $data, true);
		echo json_encode($hasil);
	}
	
	function listBox_TYPE($row, $value){
		if (array_key_exists($value, $this->cbo_type)):
			$value=$this->cbo_type[$value];
		endif;
		return $value;
	}
	
	function listBox_REGISTER($row, $value){
		$id=$row['l_id'];
		$result = '<i class="fa fa-search showRegister pointer" data-id="'.$id.'"></i>';
		return $result;
	}
	
	function POST_CHECK_BEFORE_DELETE($ids=array()){
		$ada=false;
		foreach($ids as $row):
			if (array_key_exists($row, $this->use_list)):
				if ($this->use_list[$row]['jml']>0):
					$this->_set_pesan('Risk Register : ' . $this->use_list[$row]['nama']);
					$ada=true;
				endif;
			endif;
		endforeach;
		if ($ada)
			$this->_set_pesan('Tidak bisa dihapus');
		
		return !$ada;
	}
	
	public function MASTER_DATA_LIST($arrId, $rows)
    {
        $this->use_list =$this->data->cari_total_dipakai($arrId);
    }
	
	function listBox_ITEM_USE($row, $value){
		$result='';
		if (array_key_exists($row['l_id'], $this->use_list)):
			if ($this->use_list[$row['l_id']]['jml']>0):
				$result =  '<span class="badge bg-green">' . $this->use_list[$row['l_id']]['jml'] . '</span>';
			endif;
		endif;
		return $result;
	}
	
	function PrintBox_ITEM_USE($row, $value){
		$result='';
		if (array_key_exists($row['l_id'], $this->use_list)):
			if ($this->use_list[$row['l_id']]['jml']>0):
				$result =  $this->use_list[$row['l_id']]['jml'];
			endif;
		endif;
		return $result;
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
				exit;
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
		$data['tingkat_no']=$post['tingkat_resiko'];
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
		$cboBahaya = $this->get_combo('data-combo', 'bahaya-k3');
		$cboEvent = $this->get_combo('library', 1);
		$cboKondisi = $this->get_combo('data-combo', 'kondisi-hiradc');
		
		$cboTpp = $this->get_combo('data-combo', 'severity-tpp');
		$cboSd = $this->get_combo('data-combo', 'severity-sd');
		$cboBp = $this->get_combo('data-combo', 'severity-bp');
		$cboLp = $this->get_combo('data-combo', 'severity-lp');
		$cboCp = $this->get_combo('data-combo', 'severity-cp');
		$cboOccurrence = $this->get_combo('data-combo', 'occurrence');
		$cboTingkatResiko = $this->get_combo('data-combo', 'tingkat-resiko');
		$cboStatus = $this->get_combo('data-combo', 'status-hiradc');
		
		$rows=$this->db->where('status',1)->where('tipe_no',82)->get(_TBL_REGULASI)->result_array();
		$regulasi='';
		$reg_isi = json_decode($data['regulasi'], true);
		foreach($rows as $row){
			$check=false;
			if (is_array($reg_isi)){
				if (in_array($row['id'], $reg_isi))
					$check=true;
			}
			$regulasi .= form_checkbox('regulasi[]', $row['id'], $check, 'id="regulasi" ');
			$regulasi .= form_label($row['title'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	', $row['id'], ' ').'<span class="pull-right pointer text-danger preview_file" data-url="'.base_url('ajax/download_preview').'" data-target="regulasi" data-file="'.$row['nm_file'].'" style="font-size:80%;"> [Preview]</span><br/>';
		}
		$class='class="form-control select2" style="width:100%;" ';
		$tingkat="";
		$tingkat_tmp="";
		$status="";
		if ($data){
			$tingkat_tmp=$data['risk_impact'];
			$tingkat='<span style="background:'.$data['warna'].';color:'.$data['warna_text'].';padding:5px 25px;"> '.$data['tingkat'].' </span>';
			$status='<span class="bg-orange" style="padding:5px 25px;"> '.$data['penting'].' </span>';
		}
		$this->data_combo['identifikasi'][]=array('label'=>lang('msg_field_lokasi'), 'isi'=>form_dropdown('area_no', $cboLokasi, ($data)?$data['area_no']:'',''.$class.' id="area_no"'));
		$this->data_combo['identifikasi'][]=array('label'=>lang('msg_field_aktifitas'), 'isi'=>form_input('aktifitas', ($data)?$data['aktifitas']:'','class="form-control" id="aktifitas"'));
		$this->data_combo['identifikasi'][]=array('label'=>lang('msg_field_bahaya'), 'isi'=>form_dropdown('bahaya_no', $cboBahaya, ($data)?$data['bahaya_no']:'',''.$class.' id="bahaya_no"'));
		$this->data_combo['identifikasi'][]=array('label'=>lang('msg_field_resikok3'), 'isi'=>form_dropdown('event_no', $cboEvent, ($data)?$data['event_no']:'',''.$class.' id="event_no"'));
		$this->data_combo['identifikasi'][]=array('label'=>lang('msg_field_kondisi'), 'isi'=>form_dropdown('kondisi_no', $cboKondisi, ($data)?$data['kondisi_no']:'',''.$class.' id="kondisi_no"'));
		
		$this->data_combo['hidden']=form_hidden(array('id_edit'=>($data)?$data['id']:0,'parent_no'=>$parent,'mode'=>$this->data_combo['mode'],'tingkat_resiko_tmp'=>$tingkat_tmp,'severity_no'=>($data)?$data['severity_no']:''));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_tpp'), 'isi'=>form_dropdown('tr_no', $cboTpp, ($data)?$data['tr_no']:'',''.$class.' id="tr_no"'));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_sd'), 'isi'=>form_dropdown('srd_no', $cboSd, ($data)?$data['srd_no']:'',''.$class.' id="srd_no"'));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_bp'), 'isi'=>form_dropdown('bp_no', $cboBp, ($data)?$data['bp_no']:'',''.$class.' id="bp_no"'));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_lp'), 'isi'=>form_dropdown('lp_no', $cboLp, ($data)?$data['lp_no']:'',''.$class.' id="lp_no"'));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_cp'), 'isi'=>form_dropdown('cp_no', $cboCp, ($data)?$data['cp_no']:'',''.$class.' id="cp_no"'));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_occorunce'), 'isi'=>form_dropdown('occorunce_no', $cboOccurrence, ($data)?$data['occorunce_no']:'',''.$class.' id="occorunce_no"'));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_severity'), 'isi'=>form_input('severity', ($data)?$data['severity']:'','class="form-control text-center" style="width:15%;" readonly="readonly" id="severity"'));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_score'), 'isi'=>form_input('score_resiko', ($data)?$data['score_resiko']:'','class="form-control text-center" style="width:15%;" readonly="readonly" id="score_resiko"'));
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_tingkat_resiko'), 'isi'=>form_dropdown('risk_impact', $cboTingkatResiko, ($data)?$data['risk_impact']:'','class="form-control hide" style="width:100%;" id="risk_impact"').'<div id="resiko" style="width:100%;">'.$tingkat.'</div>');
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_regulasi'), 'isi'=>$regulasi);
		$this->data_combo['level_resiko'][]=array('label'=>lang('msg_field_penting'), 'isi'=>form_dropdown('status_no', $cboStatus, ($data)?$data['status_no']:'','class="form-control hide" style="width:100%;" id="status_no"').'<div id="statusText" style="width:100%;">'.$status.'</div>');
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
		
		$rows = $this->db->select('data, param1, param2, tingkat_resiko_no, score, '._TBL_LEVEL_COLOR_K3.'.id as severity_no')->from(_TBL_LEVEL_COLOR_K3)->join(_TBL_DATA_COMBO, _TBL_LEVEL_COLOR_K3.'.tingkat_resiko_no='._TBL_DATA_COMBO.'.id')->order_by('score', 'desc')->get()->result_array();
		
		$severity_no=0;
		$tingkat=0;
		$resiko="";
		$bgcolor="";
		$color="";
		foreach($rows as $row){
			// echo $score ." <= ". $row['score']."<br/>";
			if($row['score'] <=$score){
				$severity_no=$row['severity_no'];
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
		$data['severity_no'] = $severity_no;
		$data['resiko'] = '<span style="background:'.$bgcolor.';color:'.$color.';padding:5px 25px;"> '.$resiko.' </span>';
		$data['statusNo'] = $stsPenting_no;
		$data['statusText'] = '<span class="bg-orange" style="padding:5px 25px;"> '.$stsPenting.' </span>';
		
		echo json_encode($data);
	}
	
	function cetak_register(){
		$tipe=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		
		$data['field']=$this->data->get_data_register($id);
		$data['id']=$id;
		$hasil=$this->load->view('risk-register', $data, true);
		$cetak = 'register_'.$tipe;
		$this->$cetak($hasil);
	}
	
	function register_excel($data){
		header("Content-type=appalication/vnd.ms-excel");
        header("content-disposition:attachment;filename=laporantransaksi.xls");
		
		$html = $data;
		echo $html;
		exit;
	}
	
	function register_pdf($data){
		$this->load->library('pdf');
		$tgl=date('Ymdhs');
		$this->nmFile=_MODULE_NAME_.'-'.$tgl.".pdf";
		$this->pdfFilePath = download_path_relative($this->nmFile);
		
		$html = '<style>
				table {
					border-collapse: collapse;
				}

				.test table > th > td {
					border: 1px solid #ccc;
				}
				</style>';
		
		
		$html .= '<table width="100%" border="1"><tr><td width="100%" style="padding:20px;">';
		$html .= $data;
		$html .= '</td></tr></table>';
		
		// die($html);
		$align=array();
		$format=array();
		$no_urut=0;
		
		// die($html);
		$pdf = $this->pdf->load('en-GB-x,legal,,,5,5,5,5,6,3');
		$pdf->SetHeader('');
		$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); 
		$pdf->WriteHTML($html); 
		ob_clean();
		
		$pdf->Output($this->pdfFilePath, 'F'); 
		redirect($this->pdfFilePath);
		
		return true;
	}
}