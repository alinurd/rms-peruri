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
		$this->get_parameters();
		$this->set_Tbl_Master(_TBL_RCSA);
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
			$this->addField(array('field'=>'corporate', 'title'=>'Nama Project', 'size'=>27, 'required'=>true, 'search'=>true));
			$this->addField(array('field'=>'owner_no', 'title'=>'Nama Risk Owner', 'input'=>'combo:search', 'combo'=>$this->cbo_parent, 'size'=>100, 'search'=>true, 'required'=>true));
			$this->addField(array('field'=>'type', 'input'=>'combo', 'combo'=>$this->cbo_type_rutin, 'size'=>15));
			$this->addField(array('field'=>'period_no', 'title'=>'Periode', 'input'=>'combo', 'combo'=>$this->cbo_periode, 'size'=>15));
			$this->addField(array('field'=>'start_date', 'title'=>'Tgl Mulai', 'input'=>'date', 'type'=>'date', 'size'=>10, 'required'=>true));
			$this->addField(array('field'=>'end_date', 'title'=>'Tanggal Akhir', 'input'=>'date', 'type'=>'date', 'size'=>10, 'required'=>true));
			$this->addField(array('field'=>'lokasi', 'title'=>'Loaksi',  'size'=>100));
			$this->addField(array('field'=>'pemilik_proyek', 'input'=>'combo:search', 'combo'=>$this->cbo_parent, 'size'=>100, 'required'=>true));
			$this->addField(array('field'=>'nilai_kontrak', 'input'=>'float', 'type'=>'float', 'size'=>20));
			$this->addField(array('field'=>'tujuan', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'latar_belakang', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'profil_mitra', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'kondisi', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'skema_bisnis', 'input'=>'upload', 'size'=>300));
			$this->addField(array('field'=>'analisi_kebutuhan_sumber_daya', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'analisis_bisnis', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'rcsa', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'kesimpulan', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'rekomendasi', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'item_use', 'input'=>'free', 'type'=>'free', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'upload_dokument', 'input'=>'upload', 'size'=>300));
		$this->set_Close_Tab();
		$this->set_Open_Tab('Investasi');
			$this->addField(array('field'=>'barang_jasa','titel'=>'Nama Barang / Jasa', 'size'=>27));
			$this->addField(array('field'=>'jumlah_kebutuhan', 'size'=>27));
			$this->addField(array('field'=>'user_pengguna','titel'=>'Nama Pengguna', 'input'=>'combo:search', 'combo'=>$this->cbo_parent, 'size'=>100));
			$this->addField(array('field'=>'rincian_pelaksanaan', 'size'=>27));
			$this->addField(array('field'=>'anggaran', 'input'=>'float', 'size'=>20));
			$this->addField(array('field'=>'diskripsi', 'input'=>'multitext', 'size'=>300));

			$this->addField(array('field'=>'jenis_investasi', 'input'=>'free', 'size'=>30));
			$this->addField(array('field'=>'inv_tujuan', 'input'=>'multitext', 'size'=>300));
			$this->addField(array('field'=>'inv_latar_belakang', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'inv_kondisi', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'inv_aspek_strategis', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'inv_aspek_bisnis', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'inv_spesifikasi_teknis', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'rcsa', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'inv_kesimpulan', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'inv_rekomendasi', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'upload_dokument', 'input'=>'upload', 'size'=>300));
		$this->set_Close_Tab();
		// }
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'owner_no','sp'=>$this->tbl_owner,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'period_no','sp'=>$this->tbl_period,'id_sp'=>'id'));
		
		$this->addField(array('nmtbl'=>$this->tbl_owner, 'field'=>'name', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_period, 'field'=>'periode_name', 'size'=>20, 'show'=>false));
		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'type','onChange'=>'disable_period(this.value)'));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'nilai_kontrak', 'span_right_addon'=>' Rp ', 'align'=>'right'));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'anggaran', 'span_right_addon'=>' Rp ', 'align'=>'center'));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'target_laba', 'span_right_addon'=>' Rp ', 'align'=>'center'));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_owner,'name');
		$this->set_Table_List($this->tbl_master,'corporate');
		// $this->set_Table_List($this->tbl_master,'type');
		$this->set_Table_List($this->tbl_master,'start_date');
		$this->set_Table_List($this->tbl_master,'end_date');
		$this->set_Table_List($this->tbl_master,'location');
		$this->set_Table_List($this->tbl_master,'item_use');
		
		if ($this->id_param_owner['privilege_owner']['id']>1)
			$this->set_Where_Table($this->tbl_master,'owner_no','in',$this->id_param_owner['owner_child']);	
			$this->set_Where_Table($this->tbl_master,'type','=', 2);	
		
		$this->set_Close_Setting();

		$js = '<script>$("#img_l_lampiran").remove();</script>';
		$js .= '<script>$("#l_lampiran_parent").css("padding-top","8px");</script>';
		$js .= '<script>function check() {  }</script>';
		$this->template->append_metadata($js);
	}
	
	function PrintBox_FORMAT(){
		$size = array('size'=>array(44,87,19,23,23,69),'align'=>array('center','left','left','center','center','center'));
		return $size;
	}
	
	function insertBox_TYPE($field){
		$content = $this->radio_type($field);
		return $content;
	}

	function insertBox_JENIS_INVESTASI($field){
		$arr_invest = $this->data->jenis_investasi();
		$i = 0;
		$content = '<div class="well w100">';
		foreach ($arr_invest as $key => $value) {
			$content .= form_checkbox( 'l_jenis_investasi[]', 
										$arr_invest[$i]['type'], 
										false, 
										'id='.str_replace(' ', '_', $arr_invest[$i]['type']) );
			$content .= form_label($arr_invest[$i]['type'], str_replace(' ', '_', $arr_invest[$i]['type']));
			$content .= '<br/>';
			$i++;
		}
		$content .= '</div>';

		return $content;
	}
	
	function updateBox_JENIS_INVESTASI($field,$row,$value){
		$arr_value = explode(',', $value);
		$arr_invest = $this->data->jenis_investasi();
		$i = 0;
		$content = '<div class="well w100">';
		foreach ($arr_invest as $key => $value) {
			$checked = (in_array($arr_invest[$i]['type'], $arr_value) ? TRUE : FALSE ); 
			$content .= form_checkbox( 'l_jenis_investasi[]', $arr_invest[$i]['type'], $checked, 'id='.str_replace(' ', '_', $arr_invest[$i]['type']) );
			$content .= form_label($arr_invest[$i]['type'], str_replace(' ', '_', $arr_invest[$i]['type']));
			$content .= '<br/>';
			$i++;
		}
		$content .= '</div>';

		return $content;
	}
	
	function updateBox_TYPE($field, $row, $value){
		$content = $this->radio_type($field, $row, $value);
		return $content;
	}
	
	function radio_type($field, $row=array(), $value='1'){
		$attributes = array(
		        'class' => 'label-type',
		        'style' => 'color: #005398; 
		        			left: 1px; 
		        			top: 8px; 
		        			position: absolute; 
		        			font-weight: bold;'
		);
		$content = form_radio($field['label'], 2, true, 'id="'.$field['label'].'_2" class="hidden"');
		$content .= form_label('Project', '2', $attributes);
		return $content;
	}
	
	function listBox_TYPE($row, $value){
		if ($value=='1')
			$result='Rutin';
		else
			$result='Project';
		
		return $result;
	}
	
	function listBox_LOCATION($row, $value){
		$this->db->select('*');
		$this->db->from($this->tbl_owner);
		$this->db->where('id',$value);
		$query=$this->db->get();
		$rows=$query->result_array();
		
		$result= $rows[0]['name'];
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
		$result[]=array('posisi'=>'right', 'content'=>'<a class="btn btn-warning btn-flat" style="width:100%;" data-content="Detail Risk Register" data-toggle="popover" href="'.base_url('project/risk-event/'.$id).'" data-original-title="" title=""><strong style="text-shadow: 1px 2px #020202;">START<br/>Risk Register</strong></a>');
		return $result;
	}
	
	function get_detail_risk(){
		$data=array();
		$id_rcsa=intval($this->input->get('rcsa'));
		$id_edit=intval($this->input->get('id_edit'));
		$data['judul']="&nbsp;";
		$data['id_rcsa']=$id_rcsa;
		$data['id_event_detail']=$id_edit;
		$data['data_risk_detail']=$this->data->get_rist_detail($id_edit,2);
		// Doi::dump($data); die();
		$content=$this->load->view('project/edit_event',$data,true);
		echo $content;
	}
	
	function delete_event(){
		$rcsa=intval($this->uri->segment(3));
		$id_edit=intval($this->uri->segment(4));
		$result=$this->data->delete_event($id_edit);
		header('location:'.base_url('project/risk-event/'.$rcsa));
	}
	
	function save_detail(){
		$post=$this->input->post();
		// Doi::dump($post);die();
		$result=$this->data->save_even_detail($post);
		if($result==0){
			header('location:'.base_url('project/risk-event/'.$post['id_rcsa']));
		}else{
			header('location:'.base_url('project/risk-event/'.$post['id_rcsa'].'/'.$result));
		}
	}
	
	function save_level(){
		$post=$this->input->post();
		// var_dump($post);die();
		$result=$this->data->save_even_level($post);
		$this->session->set_userdata('tab_rcsa','level');
		if($result==0){
			header('location:'.base_url('project/risk-event/'.$post['id_rcsa_level']));
		}else{
			header('location:'.base_url('project/risk-event/'.$post['id_rcsa_level'].'/'.$result));
		}
	}
	
	function change_tab(){
		$tipe=$this->input->get('tipe');
		$this->session->set_userdata('tab_rcsa',$tipe);
	}
	
	function save_action(){
		$post=$this->input->post();
		$path=upload_path_relative().'project/';
		// doi::dump($_FILES,false,true);
		$upload=array();
		if(!empty($_FILES['attac']['name']))
			$upload=upload_image('attac',$post, $path,'',false);

		$result=$this->data->save_event_action($post, $upload);
		header('location:'.base_url('project/risk-event/'.$post['id_rcsa_action'].'/'.$post['id_rcsa_detail_action']));
	}
	
	function risk_event(){
		$data=array();
		$id_rcsa=intval($this->uri->segment(3));
		$id_edit=intval($this->uri->segment(4));
		$data['judul']=$this->data->data_judul_project($id_rcsa);
		$data['id_owner']=$this->data->parent_child_owner($id_rcsa);
		$data['id_rcsa']=$id_rcsa;
		$data['id_event_detail']=$id_edit;
		
		if ($id_rcsa<=0)
			header('location:'.base_url('project'));
		
		$data['data_tree']=$this->data->get_tree_data($id_rcsa);
		$data['data_risk_detail']=$this->data->get_rist_detail($id_edit,2);
		$data['data_owners']=$this->data->get_data_owner_id($id_rcsa);
		$data['master_level']=$this->data->get_master_level();
		// echo json_encode($data);die();
		if ($id_edit>0 && count($data['data_risk_detail'])>0){
			$data['data_risk_level']=$this->data->get_rist_level($id_edit);
			$data['data_risk_level_control']=$this->data->get_rist_level_controls();
			$data['cboAssesmen']=$this->get_combo('data-combo','control-assesment');
			
			// Doi::dump($data);
			// die();
			$data['risk_level']=$this->load->view('risk_level',$data,true);
			
			$data['data_risk_action']=$this->data->get_risk_action($id_edit);
			$data['risk_action']=$this->load->view('risk_action',$data,true);
			$data['event_detail']=$this->load->view('edit_event',$data,true);
		}else{
			$data['event_detail']=$this->load->view('add_event',$data,true);
		}
		
		$data['tree_event']=$this->load->view('tree_event',$data,true);
		// doi::dump($data['judul'],false,true);
		$this->template->build('risk_event_detail',$data); 
	}
	// risk register
	function get_data_risk_register(){
		$id_rcsa=$this->input->get('id-rcsa');
		$data['field'] = $this->data->get_data_risk_register($id_rcsa);
		$data['fields'] = $this->data->risk_register_field($id_rcsa);
		$data['rcsa'] = $this->data->get_data($id_rcsa);
		$data['id_rcsa'] = $id_rcsa;
		$xx=array('field'=>$data['field'], 'rcsa'=>$data['rcsa']);
		$this->session->set_userdata('result_risk_register', $xx);
		$result = $this->load->view('list_risk_register',$data,true);
		echo $result;
	}
	
	function get_data_source(){
		$parent_id = $this->input->get('parent');
		$kel=$this->input->get('idmodal');
		$data['tmp_asal']=$this->input->get('tbl');
		$data['jml']=$this->input->get('jml');
		$data['parent']=intval($this->input->get('parent'));
		$data['risk_type']=$this->get_combo('risk_type');

		if ($kel =='area') {
			$data['field']=$this->data->get_data_owners($parent_id);
			// doi::dump($data['field'], false, true);
			$data['kel']='owner';
			$content=$this->load->view('list_owner',$data,true);
		}

		if ($kel=='owner'){
			$data['field']=$this->data->get_data_owners($parent_id);
			$data['kel']='owner';
			$content=$this->load->view('list_owner',$data,true);
		}elseif ($kel=='type'){
			$data['field']=$this->data->get_data_owner();
			$data['kel']='type';
			$content=$this->load->view('list_type',$data,true);
		}elseif ($kel=='couse'){
			$data['field']=$this->data->get_data_event(2, $data['parent']);
			$data['kel']='couse';
			$content=$this->load->view('list_couse',$data,true);
		}elseif ($kel=='impact'){
			$data['field']=$this->data->get_data_event(3, $data['parent']);
			$data['kel']='impact';
			$content=$this->load->view('list_impact',$data,true);
		}elseif ($kel=='event'){
			$data['field']=$this->data->get_data_event(1, $data['parent']);
			$data['kel']='event';
			$content=$this->load->view('list_event',$data,true);
		}
		echo $content;
	}
	
	function get_input_action(){
		$id=$this->input->get('id');
		$id_rcsa=$this->input->get('rcsa');
		$id_edit=$this->input->get('event_detail');
		
		$data['id_rcsa']=$id_rcsa;
		$data['id_event_detail']=$id_edit;
		$data['id_event_action']=$id;
		
		$data['cbo_schedule']=$this->get_combo('schedule');
		$data['cbo_officer']=$this->get_combo('officer');
		
		$data['field']=$this->data->get_data_action($id);
		
		if (count($data['field'])==0){
			$data['field']=array('title'=>'','description'=>'','attc'=>'','schedule_no'=>'','schedule_detail'=>'','owner_no'=>array(),'accountable_unit'=>array(),'officer_no'=>'','amount'=>0,'target_waktu'=>date('d-m-Y'),'nilai_dampak'=>0, 'proaktif'=>'', 'reaktif'=>'');
		}else{
			$data['field']=$data['field'][0];
		}
		// Doi::dump($data);die();
		// Doi::dump($data['field']);die();
		$result=$this->load->view('form_action',$data,TRUE);
		echo $result;
	}
	
	function get_risk_level(){
		$row=$this->data->get_data_level($this->input->get());
		$content = '<span> - </span>';
		$id=0;
		foreach($row as $row){
			$content = '<span style="width:30px;background-color:'.$row['color'].';color:'.$row['color_text'].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.strtoupper($row['level_mapping']).'&nbsp;&nbsp;&nbsp;&nbsp;</span>';
			$id=$row['id'];
		}
		
		echo $content."###".$id;
	}
	
	function get_inherent_risk_level (){
		$data=$this->input->post();
		$id_combo=$this->data->get_combo_inpact($data);
		$data['impact']=$id_combo;
		$row=$this->data->get_data_level($data);
		$content = '<span> - </span>';
		$id=0;
		foreach($row as $row){
			$content = '<span style="width:30px;background-color:'.$row['color'].';color:'.$row['color_text'].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.strtoupper($row['level_mapping']).'&nbsp;&nbsp;&nbsp;&nbsp;</span>';
			$id=$row['id'];
		}
		
		
		echo $content."###".$id."###".$id_combo;
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
	
	function POST_INSERT_PROCESSOR($id , $new_data, $old_data){
		$result=true;
		if (intval($new_data['param_copy_rcsa'])>0){
			$result = $this->data->save_param($id , $new_data, $old_data);
		}
		return $result;
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows){
		$id = $rows['l_id'];
		$url=base_url('project/risk-event');
		$tombol['detail']=array("default"=>false,"url"=>$url,"label"=>"Start Risk Register");
		return $tombol;
	}
	
	function add_library(){
		// $data['field']
		$data['cbo']=$this->get_combo('risk_type');
		$content=$this->load->view('add_library',$data,true);
		echo $content;
	}
	
	function add_library_event(){
		$data['cbo']=$this->get_combo('risk_type');
		
		$data['cbogroup']=$this->get_combo('library', 2);
		$data['cbogroup_impact']=$this->get_combo('library', 3);
		$data['cause']=$this->load->view('cause',$data,true);
		$data['impact']=$this->load->view('impact',$data,true);
		
		$content=$this->load->view('add_library_event',$data,true);
		echo $content;
	}
	
	function add_library_cause(){
		$data['event_no']=$this->input->post('event_no');
		$data['jml']=$this->input->post('jml');
		$data['cbo']=$this->get_combo('risk_type');
		$data['cbogroup']=$this->get_combo('library', 2);
		$data['title']=$this->data->get_library_detail($data['event_no']);
		$data['cause']=$this->load->view('cause',$data,true);
		$content=$this->load->view('add_library_cause',$data,true);
		echo $content;
	}
	
	function add_library_impact(){
		$data['event_no']=$this->input->post('event_no');
		$data['jml']=$this->input->post('jml');
		$data['cbo']=$this->get_combo('risk_type');
		$data['cbogroup_impact']=$this->get_combo('library', 3);
		$data['title']=$this->data->get_library_detail($data['event_no']);
		$data['impact']=$this->load->view('impact',$data,true);
		$content=$this->load->view('add_library_impact',$data,true);
		echo $content;
	}
	
	function save_add_library($data=array()){
		if (!$data){
			$data=$this->input->post();
		}
		$result = $this->data->save_library($data);
		return $result;
	}
	
	function save_add_library_event(){
		$mode=$this->input->post('mode');
		$id_rcsa=intval($this->uri->segment(3));
		$data['parent']=$id_rcsa;
		if ($mode=='save')
			$id = $this->save_add_library($this->input->post());
		// doi::dump("idnya : ".$id);
		$result=$this->data->get_data_event_satu($id);
		// Doi::dump($result);
		$data['kel']='event';
		// $content=$this->load->view('list_event',$data,true);
		$content = json_encode(array('id'=>$result->id,'name'=>$result->code.' - '.$result->description));
		echo $content;
	}
	
	function save_add_library_cause(){
		$mode=$this->input->post('mode');
		$data['parent']=$this->input->post('add_event_no');//$id_rcsa;
		$data['jml']=$this->input->post('jml');//$id_rcsa;
		if ($mode=='save' || $mode=='save_db')
			$this->save_add_library($this->input->post());
		
		$data['field']=$this->data->get_data_event(2, $data['parent']);
		$data['kel']='couse';
		$content=$this->load->view('list_couse',$data,true);
			
		echo $content;
	}
	
	function save_add_library_impact(){
		$mode=$this->input->post('mode');
		$data['parent']=$this->input->post('add_event_no');//$id_rcsa;
		$data['jml']=$this->input->post('jml');//$id_rcsa;
		if ($mode=='save' || $mode=='save_db')
			$this->save_add_library($this->input->post());
		
		$data['field']=$this->data->get_data_event(3, $data['parent']);
		$data['kel']='impact';
		$content=$this->load->view('list_impact',$data,true);
			
		echo $content;
	}
	
	function cari_rcsa(){
		$x=$this->data->get_rcsa($this->input->post('id'));
		echo json_encode($x);
	}
	
	function get_download_file(){
		$this->load->helper('download');
		$nmfile=$this->uri->segment(3);
		$path=upload_path_relative().'project/';
		// die($path.$nmfile);
		force_download($path.$nmfile, null);
	}
	
	function cetak_register(){
		$type=$this->uri->segment(3);
		$id_rcsa=$this->uri->segment(4);
		$data['field'] = $this->data->get_data_risk_register($id_rcsa);
		$data['rcsa'] = $this->data->get_data($id_rcsa);
		// $data = $this->session->userdata('result_risk_register');
		// Doi::dump($data);die("oke");
		$this->$type($data);
	}
	
	function pdf($data){
		// Doi::dump($data);die();	
		$nmFile="list_risk_register.pdf";
		$pdfFilePath = download_path_relative($nmFile);
		
		$pdf = $this->pdf->load();
		$pdf->defaultheaderfontsize=10;
		$pdf->defaultheaderfontstyle='B';
		$pdf->defaultheaderline=0;
		$pdf->defaultfooterfontsize=10;
		$pdf->defaultfooterfontstyle='BI';
		$pdf->defaultfooterline=0;
		
		//cover page
		// $pdf->SetMargins(25, 30, 25);
		$pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            6, // margin_left
            6, // margin right
            6, // margin top
            6, // margin bottom
            5, // margin header
            5); // margin footer
		
		// $html ='<table width="100%"><tr><td rowspan="3"><img src="'.img_url('logo_lap.jp').'"></td>';
		// $html .='<td>'.$this->authentication->get_Preference['nama_kantor'].'</td></tr>';
		// $html .='<tr><td>'.$this->authentication->get_Preference['alamat_kantor'].'</td></tr>';
		// $html .='<tr><td>Telp: '.$this->authentication->get_Preference['telp_kantor'].' email: '.$this->authentication->get_Preference['email_kantor'].'</td></tr></table><br/>';
		
		$html  ='<table width="100%"><tr><td rowspan="3" width="11%"><img src="'.img_url('logo_report.png').'"></td>';
		$html .='<td>'.$this->authentication->get_Preference('nama_kantor').'</td></tr>';
		$html .='<tr><td>Kantor Pusat</td></tr>';
		$html .='<tr><td>&nbsp;</td></tr></table><br/>';
		
		$html .= "<strong><h2 style='margin:0px;'>Risk Register</h2></strong><br/>";
		// $rows  = $data;
		
		$html  .='<table class="table" width="100%">
		<tr>
			<td colspan="3"><strong><h2 style="margin:0px;">PROYEK</h2></strong></td>
			<td colspan="3"><strong><h2 style="margin:0px;">SASARAN</h2></strong></td>
		</tr>
		<tr>
			<td width="15%">Nama Proyek</td><td width="4%">:</td><td><strong>'.$data['rcsa']['corporate'].'</strong></td>
			<td>Laba</td><td>:</td><td colspan="2"><strong>'.number_format($data['rcsa']['target_laba']).'</strong></td>
		</tr>
		<tr>
			<td>Pelaksana</td><td>:</td><td><strong>'.$data['rcsa']['name_owner'].'</strong></td>
			<td>Lokasi</td><td>:</td><td colspan="2"><strong>'.$data['rcsa']['max_periode'].'</strong></td>
		</tr>
		<tr><td>Pemilik Proyek</td><td>:</td><td colspan="5">'.$data['rcsa']['location'].'</strong></td></tr>
		<tr><td>Nilai Kontrak</td><td>:</td><td colspan="5"><strong>'.number_format($data['rcsa']['nilai_kontrak']).'</strong></td></tr>
	</table>';
			
		$pdf->writeHTML($html);
		
		
		$html = '<br/>
	<table class="table" border="1" width="100%">
		<thead>
			<tr>
				<th rowspan="2" width="5%" style="text-align:center;">No.</th>
				<th rowspan="2" width="15%">Identifikasi Risiko</th>
				<th rowspan="2" width="5%">No</th>
				<th>Peristiwa Risiko</th>
				<th rowspan="2">Sebab Risiko</th>
				<th rowspan="2">Dampak Risiko</th>
				<th rowspan="2">Nilai Dampak<br/>(juta Rp)</th>
				<th colspan="2">Level Inherent</th>
				<th rowspan="2">Risk Exposure</th>
				<th colspan="2">Level Residual</th>
				<th rowspan="2">Risk Exposure</th>
				<th rowspan="2">Action Plan (Mitigasi) / Accountable Unit / Target</th>
			</tr>
			<tr>
				<th>Nama dan Uraian peristiwa</th>
				<th>Probabilitas</th>
				<th>Consequence</th>
				<th>Probabilitas</th>
				<th>Consequence</th>
			</tr>
		</thead>
		<tbody>';
			$i=1;
			$ttl_exposure=0;
			$ttl_exposure_residual=0;
			$ttl_nil_dampak=0;
			foreach($data['field'] as $keys=>$row)
			{ 
				$html .= '<tr>
					<td valign="top" rowspan="'.count($row->detail['risk_event']).'">'.$i.'</td>
					<td valign="top"  rowspan="'.count($row->detail['risk_event']).'">'.$row->type.'</td>'; 
				$no=1;
				foreach ($row->detail['risk_event'] as $key=>$sub){
					$nil_inherent_likelihood=explode('#',$row->detail['inherent_likelihood'][$key]);
					$nil_inherent_impact=explode('#',$row->detail['inherent_impact'][$key]);
					$exposure=floatval($row->detail['nilai_dampak'][$key]) * ($nil_inherent_likelihood[0]/100);
					$ttl_exposure += $exposure;
					
					$nil_residual_likelihood=explode('#',$row->detail['residual_likelihood'][$key]);
					$nil_residual_impact=explode('#',$row->detail['residual_impact'][$key]);
					$exposure_residual=floatval($row->detail['nilai_dampak'][$key]) * ($nil_residual_likelihood[0]/100);
					
					$ttl_exposure_residual += $exposure_residual;
					
					$nil_inherent_likelihood_tmp='';
					if (count($nil_inherent_likelihood)>1){$nil_inherent_likelihood_tmp=$nil_inherent_likelihood[1];}
					$nil_inherent_impact_tmp='';
					if (count($nil_inherent_impact)>1){$nil_inherent_impact_tmp=$nil_inherent_impact[1];}
					
					$nil_residual_likelihood_tmp='';
					if (count($nil_residual_likelihood)>1){$nil_residual_likelihood_tmp=$nil_residual_likelihood[1];}
					$nil_residual_impact_tmp='';
					if (count($nil_residual_impact)>1){$nil_residual_impact_tmp=$nil_residual_impact[1];}
					
					$nil_dampak=0;
					if(floatval($row->detail['nilai_dampak'][$key])>0)
						$nil_dampak=number_format($row->detail['nilai_dampak'][$key]/1000000);
					
					$ttl_nil_dampak += floatval($nil_dampak);
					
					if ($no>1){
						$html .= '<tr>';
					}
					$html .= '<td valign="top"  width="5%">'.$no.'</td>
					<td valign="top" >'.$sub['description'].'</td>
					<td valign="top" >'.$row->detail['risk_couse'][$key].'</td>
					<td valign="top" >'.$row->detail['risk_impact'][$key].'</td>
					<td valign="top"  class="text-right">'.$nil_dampak.'</td>
					<td valign="top"  class="text-center">'.$nil_inherent_likelihood_tmp.'</td>
					<td valign="top"  class="text-center">'.$nil_inherent_impact_tmp.'</td>
					<td valign="top"  class="text-right">'.number_format($exposure).'</td>
					<td valign="top"  class="text-center">'.$nil_residual_likelihood_tmp.'</td>
					<td valign="top"  class="text-center">'.$nil_residual_impact_tmp.'</td>
					<td valign="top"  class="text-right">'.number_format($exposure_residual).'</td>
					<td valign="top" >
					<table border="0" width="100%">';
					
					foreach($row->detail['action'][$sub['id']] as $act){
						$html .= '<tr>
							<td valign="top" >'.$act['title'].'</td>
							<td valign="top" >'.$act['owner_no'].'</td>
							<td valign="top" >'.$act['target_waktu'].'</td>
						</tr>';
					}
					$html .= '</table>
					</td>
					</tr>';
				++$no;
			}
		$html .= '</tr>';
			++$i;
			}
			
		
		$html .= '<tr><td colspan="6">TOTAL</td><td>'.number_format($ttl_nil_dampak).'<td><td>'.number_format($ttl_exposure).'<td></tr></tbody></table>';
	
		$pdf->writeHTML($html);
		$footer = 'Tanggal pencetakkan : '.date('d-m-Y h:m:s');
		$pdf->SetFooter($footer);
		$pdf->SetHeader('PLANET PETS SHOP');
		
		$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); 
		
		ob_clean();
		$pdf->Output($pdfFilePath, 'i'); 
		// redirect(download_url($nmFile));
		return true;
	}
	
	function excel($data){
		// Doi::dump($data);die();
		$nmfile="List-risk-register";
		$koor=array();
		$this->load->library('PHPExcel');
		$sheet = $this->phpexcel->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->setTitle($nmfile);
		$sheet->setShowGridlines(FALSE);
		
		$style_title = array('font' =>array('color' =>array('rgb' => '050504'),'bold' => true,'size'=>'11'),'alignment' => array('wrap'=> true, 'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER),'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FFFD9B')));
					 
		$style_content = array('font' =>array('color' =>array('rgb' => '050504'),'size'=>'10'),'alignment' => array('wrap'=> true),'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
					 
		$brs=0;
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath(img_path('logo_report.png'));
		// $objDrawing->setHeight(55);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setOffsetX(10);     
		$objDrawing->setWorksheet($sheet);
		
		
		$sheet->getStyle('A1:AZ1000')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$sheet->setCellValue('B'.++$brs,$this->authentication->get_Preference('nama_kantor'));
		$sheet->setCellValue('B'.++$brs,'Kantor Pusat');
		$sheet->setCellValue('B'.++$brs,' ');
		++$brs;
		++$brs;
		$sheet->setCellValue('A'.$brs,'RISK REGISTER');
		++$brs;
		
		$koor['col1']="A";
		$koor['row1']=$brs;
		
		$kol=0;
		$sheet->setCellValue(huruf_kolom($kol+1).$brs,'PROYEJ');
		$sheet->setCellValue(huruf_kolom($kol+1).++$brs,'Nama Proyek');
		$sheet->setCellValue(huruf_kolom($kol+3).$brs,':');
		$sheet->setCellValue(huruf_kolom($kol+4).$brs,$data['rcsa']['corporate']);
		$sheet->setCellValue(huruf_kolom($kol+1).++$brs,'Pelaksana');
		$sheet->setCellValue(huruf_kolom($kol+3).$brs,':');
		$sheet->setCellValue(huruf_kolom($kol+4).$brs,$data['rcsa']['name_owner']);
		$sheet->setCellValue(huruf_kolom($kol+1).++$brs,'Pemilik Proyek');
		$sheet->setCellValue(huruf_kolom($kol+3).$brs,':');
		$sheet->setCellValue(huruf_kolom($kol+4).$brs,$data['rcsa']['location']);
		$sheet->setCellValue(huruf_kolom($kol+1).++$brs,'Nilai Kontrak');
		$sheet->setCellValue(huruf_kolom($kol+3).$brs,':');
		$sheet->setCellValue(huruf_kolom($kol+4).$brs,$data['rcsa']['nilai_kontrak']);
		$sheet->setCellValue(huruf_kolom($kol+3).$brs,':');
		$sheet->setCellValue(huruf_kolom($kol+1).++$brs,'Laba');
		$sheet->setCellValue(huruf_kolom($kol+4).$brs,$data['rcsa']['target_laba']);
		$sheet->setCellValue(huruf_kolom($kol+3).$brs,':');
		$sheet->setCellValue(huruf_kolom($kol+1).++$brs,'Lokasi');
		$sheet->setCellValue(huruf_kolom($kol+4).$brs,$data['rcsa']['max_periode']);
		
		$sheet->getColumnDimension('A')->setWidth(9);
		$sheet->getColumnDimension('B')->setWidth(35);
		$sheet->getColumnDimension('C')->setWidth(5);
		$sheet->getColumnDimension('D')->setWidth(35);
		$sheet->getColumnDimension('E')->setWidth(35);
		$sheet->getColumnDimension('F')->setWidth(35);
		$sheet->getColumnDimension('G')->setWidth(18);
		$sheet->getColumnDimension('H')->setWidth(13);
		$sheet->getColumnDimension('I')->setWidth(17);
		$sheet->getColumnDimension('J')->setWidth(13);
		$sheet->getColumnDimension('K')->setWidth(13);
		$sheet->getColumnDimension('L')->setWidth(17);
		$sheet->getColumnDimension('M')->setWidth(13);
		$sheet->getColumnDimension('N')->setWidth(5);
		$sheet->getColumnDimension('O')->setWidth(35);
		$sheet->getColumnDimension('P')->setWidth(35);
		$sheet->getColumnDimension('Q')->setWidth(30);
		
		++$brs;
		++$brs;
		$kol=0;
		$koor['col1']="A";
		$koor['row1']=$brs;
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"No.");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Identifikasi Risiko");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"No.");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Peristiwa Risiko:");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"Nama dan Uraian Peristiwa Risiko");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Sebab Risiko");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Dampak/Konsekwensi");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs," Nilai Dampak");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"(juta Rp)");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Level Risiko");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"(Likehood)");
		$sheet->setCellValue(huruf_kolom(++$kol).($brs+1),"(Consequence)");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Risk");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"Exposure");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Level Risiko");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"(Likehood)");
		$sheet->setCellValue(huruf_kolom(++$kol).($brs+1),"(Consequence)");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Risk");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"Exposure");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Action Plan");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"No");
		$sheet->setCellValue(huruf_kolom(++$kol).($brs+1),"Mitigasi");
		$sheet->setCellValue(huruf_kolom(++$kol).($brs+1),"Accountable Unit");
		$sheet->setCellValue(huruf_kolom(++$kol).($brs+1),"Target");
		
		$sheet->mergeCells('A'.$brs.':A'.($brs+1));
		$sheet->mergeCells('B'.$brs.':B'.($brs+1));
		$sheet->mergeCells('C'.$brs.':C'.($brs+1));
		$sheet->mergeCells('E'.$brs.':E'.($brs+1));
		$sheet->mergeCells('F'.$brs.':F'.($brs+1));
		$sheet->mergeCells('H'.$brs.':I'.$brs);
		$sheet->mergeCells('K'.$brs.':L'.$brs);
		$sheet->mergeCells('N'.$brs.':Q'.$brs);
		++$brs;
		
		$koor['col2']=huruf_kolom($kol);
		$koor['row2']=$brs;
		$sheet->getStyle($koor['col1'].$koor['row1'].':'.$koor['col2'].$koor['row2'])->applyFromArray($style_title);
		
		++$brs;
		$i=1;
		$koor['col1']="A";
		$koor['row1']=$brs;
		$ttl_nil_dampak=0;
		$ttl_exposure=0;
		$ttl_exposure_residual=0;
		
		// Doi::dump("JUmlahnya : " . count($data['field']));
		foreach($data['field'] as $keys=>$row)
		{ 
			$kol=0;
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$i);
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row->type);
			$col_row_1=$brs;
			$no=1;
			
			// Doi::dump("JUmlahnya : " . count($row->detail['risk_event']));
			foreach ($row->detail['risk_event'] as $key=>$sub){
				$kol_sub=$kol;
				$nil_inherent_likelihood=explode('#',$row->detail['inherent_likelihood'][$key]);
				$nil_inherent_impact=explode('#',$row->detail['inherent_impact'][$key]);
				$exposure=floatval($row->detail['nilai_dampak'][$key]) * ($nil_inherent_likelihood[0]/100);
				$ttl_exposure += $exposure;
				
				$nil_residual_likelihood=explode('#',$row->detail['residual_likelihood'][$key]);
				$nil_residual_impact=explode('#',$row->detail['residual_impact'][$key]);
				$exposure_residual=floatval($row->detail['nilai_dampak'][$key]) * ($nil_residual_likelihood[0]/100);
				
				$nil_dampak=0;
				if(floatval($row->detail['nilai_dampak'][$key])>0)
					$nil_dampak=$row->detail['nilai_dampak'][$key]/1000000;
				
				$ttl_nil_dampak += floatval($nil_dampak);
					
				$ttl_exposure_residual += $exposure_residual;
				
				$nil_inherent_likelihood_tmp='';
				if (count($nil_inherent_likelihood)>1){$nil_inherent_likelihood_tmp=$nil_inherent_likelihood[1];}
				$nil_inherent_impact_tmp='';
				if (count($nil_inherent_impact)>1){$nil_inherent_impact_tmp=$nil_inherent_impact[1];}
				
				$nil_residual_likelihood_tmp='';
				if (count($nil_residual_likelihood)>1){$nil_residual_likelihood_tmp=$nil_residual_likelihood[1];}
				$nil_residual_impact_tmp='';
				if (count($nil_residual_impact)>1){$nil_residual_impact_tmp=$nil_residual_impact[1];}
				
				if ($no>1){++$brs;}
				
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$no);
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$sub['description']);
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,str_replace('<br>','\r',$row->detail['risk_couse'][$key]));
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,str_replace('<br>','\r',$row->detail['risk_impact'][$key]));
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$nil_dampak);
				$sheet->getStyle(huruf_kolom($kol_sub).$brs)->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$nil_inherent_likelihood_tmp);
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$nil_inherent_impact_tmp);
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$exposure);
				$sheet->getStyle(huruf_kolom($kol_sub).$brs)->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$nil_residual_likelihood_tmp);
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$nil_residual_impact_tmp);
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$exposure_residual);
				$sheet->getStyle(huruf_kolom($kol_sub).$brs)->getNumberFormat()->setFormatCode('#,##0.00');
				$no_act=0;
				$sts_act=false;
				foreach($row->detail['action'][$sub['id']] as $act){
					$kol_act=$kol_sub;
					$sheet->setCellValue(huruf_kolom(++$kol_act).$brs, ++$no_act);
					$sheet->setCellValue(huruf_kolom(++$kol_act).$brs,$act['title']);
					$sheet->setCellValue(huruf_kolom(++$kol_act).$brs,$act['owner_no']);
					$sheet->setCellValue(huruf_kolom(++$kol_act).$brs,$act['target_waktu']);
					++$brs;
					$sts_act=true;
				}
				if ($sts_act)
					--$brs;
				else
					++$brs;
				++$no;
			}
			$col_row_2=($brs-1);
			if ($col_row_2<$col_row_1)
				$col_row_2=$col_row_1;
			// echo $col_col_1.$col_row_1.':'.$col_col_2.$col_row_2 . '<br>';
			$sheet->mergeCells('A'.$col_row_1.':A'.$col_row_2);
			$sheet->mergeCells('B'.$col_row_1.':B'.$col_row_2);
			++$i;
			++$brs;
		}
		// die();
		$sheet->setCellValue(huruf_kolom(6).$brs,'T O T A L');
		$sheet->setCellValue(huruf_kolom(7).$brs,$ttl_nil_dampak);
		$sheet->setCellValue(huruf_kolom(10).$brs,$ttl_exposure);
		$sheet->setCellValue(huruf_kolom(13).$brs,$ttl_exposure_residual);
		$sheet->getStyle(huruf_kolom(7).$brs)->getNumberFormat()->setFormatCode('#,##0.00');
		$sheet->getStyle(huruf_kolom(10).$brs)->getNumberFormat()->setFormatCode('#,##0.00');
		$sheet->getStyle(huruf_kolom(13).$brs)->getNumberFormat()->setFormatCode('#,##0.00');
		
		
		$koor['col2']=huruf_kolom($kol_act);
		$koor['row2']=$brs;
		$sheet->getStyle($koor['col1'].$koor['row1'].':'.$koor['col2'].$koor['row2'])->applyFromArray($style_content);
		
		++$brs;
		// die();
		ob_clean();
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=\"$nmfile.xls\"");
		header("Cache-Control: max-age=0");
		$writer = new PHPExcel_Writer_Excel5($this->phpexcel);
		$writer->save('php://output'); 
		return true;
	}
}