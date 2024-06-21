<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Manual_Top_Risk extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		$this->nil_tipe=1;
		$this->set_Tbl_Master(_TBL_VIEW_TOP_RISK);
		$this->cbo_periode=$this->get_combo('periode');
		$this->cbo_parent=$this->get_combo('parent-input');
		$this->cbo_event=$this->get_combo('library', 1);
		$this->cbo_like=$this->get_combo('likelihood');
		$this->cbo_impact=$this->get_combo('impact');
		$this->cbo_type=$this->get_combo('type-project');
		
		$this->set_Open_Tab('Manual Top Risk');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'periode_name', 'size'=>100, 'show'=>false, 'search'=>true));
			$this->addField(array('field'=>'area_name', 'size'=>100, 'show'=>false, 'search'=>true));
			$this->addField(array('field'=>'event_name', 'size'=>100, 'show'=>false, 'search'=>true));
			$this->addField(array('field'=>'warna', 'size'=>100, 'show'=>false, 'search'=>true));
			$this->addField(array('field'=>'warna_text', 'size'=>100, 'show'=>false, 'search'=>true));
			$this->addField(array('field'=>'inherent_analisis', 'size'=>100, 'show'=>false, 'search'=>true));
			$this->addField(array('field'=>'periode_no', 'input'=>'combo:search', 'combo'=>$this->cbo_periode, 'size'=>100, 'required'=>true, 'search'=>true));
			$this->addField(array('field'=>'owner_no', 'input'=>'combo:search', 'combo'=>$this->cbo_parent, 'size'=>100, 'required'=>true, 'search'=>true));
			$this->addField(array('field'=>'event_no', 'input'=>'combo:search', 'combo'=>$this->cbo_event, 'size'=>100, 'required'=>true, 'search'=>true));
			$this->addField(array('field'=>'risk_couse_no', 'size'=>100));
			$this->addField(array('field'=>'risk_impact_no', 'size'=>100));
			$this->addField(array('field'=>'inherent_likelihood', 'input'=>'combo:search', 'combo'=>$this->cbo_like, 'size'=>100, 'required'=>true, 'search'=>true));
			$this->addField(array('field'=>'inherent_impact', 'input'=>'combo:search', 'combo'=>$this->cbo_impact, 'size'=>100, 'required'=>true, 'search'=>true));
			$this->addField(array('field'=>'inherent_level', 'show'=>false, 'save'=>true));
			$this->addField(array('field'=>'inherent_level_free', 'input'=>'free', 'type'=>'free', 'size'=>100));
		$this->set_Close_Tab();
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_master,'periode_name');
		$this->set_Table_List($this->tbl_master,'area_name');
		$this->set_Table_List($this->tbl_master,'event_name');
		$this->set_Table_List($this->tbl_master,'inherent_analisis');
		
		// $this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		$this->_CHANGE_TABLE_MASTER(_TBL_TOP_RISK);
		
		$this->set_Close_Setting();
	}
	

	public function MASTER_DATA_LIST($arrId, $rows)
    {
        $this->use_list =$this->data->cari_total_dipakai($arrId);
    }
	
	function updateBox_RISK_COUSE_NO($field, $rows, $value){
		$couse = json_decode($value, true);
		if ($couse)
			$couse = $this->db->where_in('id',$couse)->get(_TBL_LIBRARY)->result_array();
			
		$tblCouse = '<table class="table" id="tblCouse"><tbody>';
		if ($couse):
			foreach($couse as $key=>$crs):
				$tambah='';
				$del='';
				if ($key==0){
					$tambah ='  | <i class="fa fa-plus add-couse text-danger pointer"></i>';
					$del='del-couse ';
				}
				$tblCouse .='<tr><td style="padding-left:0px;">'.form_textarea('risk_couse[]', $crs['description']," id='risk_couse' maxlength='500' size=500 class='form-control' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'").form_hidden(['risk_couse_no[]'=>$crs['id']]).'</td><td class="text-center" width="10%"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash text-success '.$del.'pointer"></i>'.$tambah.'</td></tr>';
			endforeach;
		else:
			$tblCouse .='<tr><td style="padding-left:0px;">'.form_textarea('risk_couse[]', ''," id='risk_couse' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'").form_hidden(['risk_couse_no[]'=>0]).'</td><td class="text-center"  width="10%"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash text-success del-couse pointer"></i>  | <i class="fa fa-plus add-couse text-danger pointer"></i></td></tr>';
		endif;
		$tblCouse .= '</tbody></table>';
		
		return $tblCouse;
	}
	
	function insertBox_RISK_COUSE_NO($field){
		$couse = [];
	
		$tblCouse = '<table class="table" id="tblCouse"><tbody>';		
		$tblCouse .='<tr><td style="padding-left:0px;">'.form_textarea('risk_couse[]', ''," id='risk_couse' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'").form_hidden(['risk_couse_no[]'=>0]).'</td><td class="text-center"  width="10%"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash text-success del-couse pointer"></i>  | <i class="fa fa-plus add-couse text-danger pointer"></i></td></tr>';
		$tblCouse .= '</tbody></table>';
		
		return $tblCouse;
	}
	
	
	function insertBox_INHERENT_LEVEL_FREE($field){
		$couse = '';
		
		return $couse;
	}
	
	function updateBox_INHERENT_LEVEL_FREE($field, $rows, $value){
		$label = $rows['l_inherent_analisis'];
		$color = $rows['l_warna'];
		$color_text = $rows['l_warna_text'];
		$couse = '<span style="background-color:'.$color.';color:'.$color_text.'">  &nbsp;&nbsp;'.$label.' &nbsp;&nbsp;</span>';
		
		return $couse;
	}
	
	function insertBox_RISK_IMPACT_NO($field){
		$impact = [];
		
		$tblImpact = '<table class="table" id="tblImpact"><tbody>';
		$tblImpact .='<tr><td style="padding-left:0px;">'.form_textarea('risk_impact[]', ''," id='risk_impact' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'").form_hidden(['risk_impact_no[]'=>0]).'</td><td class="text-center"  width="10%"><i class=" fa fa-search browse-impact text-primary pointer"></i> | <i class="fa fa-trash text-success del-impact pointer"></i> | <i class="fa fa-plus add-impact text-danger pointer"></i></td></tr>';
		$tblImpact .= '</tbody></table>';
		
		return $tblImpact;
	}
	
	function updateBox_RISK_IMPACT_NO($field, $rows, $value){
		$impact = json_decode($value, true);
		if ($impact)
			$impact = $this->db->where_in('id',$impact)->get(_TBL_LIBRARY)->result_array();
			
		$tblImpact = '<table class="table" id="tblImpact"><tbody>';
		if ($impact):
			foreach($impact as $key=>$crs):
				$tambah='';
				$del='';
				if ($key==0){
					$tambah ='  | <i class="fa fa-plus add-impact text-danger pointer"></i>';
					$del='del-impact ';
				}
				$tblImpact .='<tr><td style="padding-left:0px;">'.form_textarea('risk_impact[]', $crs['description']," id='risk_impact' maxlength='500' size=500 class='form-control' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'").form_hidden(['risk_impact_no[]'=>$crs['id']]).'</td><td class="text-center" width="10%"><i class="fa fa-search browse-impact pointer text-primary"></i> | <i class="fa fa-trash text-success '.$del.'pointer"></i>'.$tambah.'</td></tr>';
			endforeach;
		else:
			$tblImpact .='<tr><td style="padding-left:0px;">'.form_textarea('risk_impact[]', ''," id='risk_impact' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'").form_hidden(['risk_impact_no[]'=>0]).'</td><td class="text-center"  width="10%"><i class=" fa fa-search browse-impact text-primary pointer"></i> | <i class="fa fa-trash text-success del-impact pointer"></i> | <i class="fa fa-plus add-impact text-danger pointer"></i></td></tr>';
		endif;
		$tblImpact .= '</tbody></table>';
		
		return $tblImpact;
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
	
	function AFTER_INPUT_RENDER($id){
		$data['master_level']=$this->data->get_master_level();
		$hasil=$this->load->view('param',$data,true);
		return $hasil;
	}
	
	function risk_event($param=array()){
		$id=0;
		if ($param){
			if(strtolower($param[0])=='add' || strtolower($param[0])=='edit'){
				$parent=(count($param)>1)?$param[1]:0;
				$id=(count($param)>2)?$param[2]:0;
				$view='input-risk-event';
				$this->data_combo=$this->data->get_data_risk_event_detail($id, $parent);
				$this->Title_Event($this->data_combo['parent']);
				$this->data_combo['mode']=$param[0];
				$this->data_combo['master_level']=$this->data->get_master_level();
				$this->data_combo['list_mitigasi']=$this->load->view('mitigasi', $this->data_combo, true);
				$this->Element_Risk_Event($this->data_combo['detail'], $parent);
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
				$this->Title_Event($this->data_combo['parent']);
			}
			$this->template->build($view, $this->data_combo); 
		}else{
			header('location:'.base_url($this->modul_name));
		}
	}
	
	function Title_Event($param){
		$this->data_combo['judul'][1][]=['label'=>lang('msg_field_corporate'), 'konten'=>$param['corporate']];
		$this->data_combo['judul'][1][]=['label'=>lang('msg_field_owner_no'), 'konten'=>$param['name']];
		$this->data_combo['judul'][1][]=['label'=>lang('msg_field_type'), 'konten'=>$param['type_name']];
		$this->data_combo['judul'][1][]=['label'=>lang('msg_field_period_no'), 'konten'=>$param['periode_name']];
		$this->data_combo['judul'][2][]=['label'=>lang('msg_field_total_aktifitas'), 'konten'=>$param['corporate']];
		$this->data_combo['judul'][2][]=['label'=>lang('msg_field_total_mitigasi'), 'konten'=>$param['name']];
		$this->data_combo['judul'][2][]=['label'=>lang('msg_field_progress_mitigasi'), 'konten'=>$param['type_name']];
		$this->data_combo['judul'][2][]=['label'=>lang('msg_field_tingkat_resiko'), 'konten'=>$param['periode_name']];
	}
	
	function Element_Risk_Event($data=array(), $parent=0){
		$param = $this->data_combo['parent'];
		$cboArea=$this->get_combo('parent-input');
		$cboEvent=$this->get_combo('library', 1);
		$cboLike=$this->get_combo('likelihood');
		$cboImpact=$this->get_combo('impact');
		$cboTreatment=$this->get_combo('treatment');
		$cboRiskControl=$this->get_combo('data-combo','control-assesment');
		$cboControl=$this->data->get_rist_level_controls();	
		
		$couse = json_decode($data['risk_couse_no'], true);
		if ($couse)
			$couse = $this->db->where_in('id',$couse)->get(_TBL_LIBRARY)->result_array();
		$impact = json_decode($data['risk_impact_no'], true);
		if ($impact)
			$impact = $this->db->where_in('id',$impact)->get(_TBL_LIBRARY)->result_array();
		$attact = json_decode($data['attach'], true);
		$arrControl = json_decode($data['control_no'], true);
		$inherent_level=$this->data->get_master_level(true, $data['inherent_level']);
		$this->data_combo['hidden']=form_hidden(['id_edit'=>($data)?$data['id']:0,'parent_no'=>$parent,'mode'=>$this->data_combo['mode']]);
		
		$uri_id = (int)$this->uri->segment(4);
		$id_owner= $this->data->owner_id($uri_id);
		$cbo_owner = $this->data->owner_hierarcy((int)$id_owner[0]['owner_no']);

		$this->data_combo['identi'][]=['label'=>lang('msg_field_risk_area'), 'isi'=>form_dropdown('risk_area_id', $cbo_owner, ($data)?$data['risk_area_id']:'','class="from-control select2" style="width:100%;" id="risk_area_id"')];
		$this->data_combo['identi'][]=['label'=>lang('msg_field_risk_event'), 'isi'=>form_dropdown('event_no', $cboEvent, ($data)?$data['event_no']:'','class="from-control select2" style="width:100%;" id="event_no"')];
		
		$tblCouse = '<table class="table" id="tblCouse"><tbody>';
		if ($couse):
			foreach($couse as $key=>$crs):
				$tambah='';
				$del='';
				if ($key==0){
					$tambah ='  | <i class="fa fa-plus add-couse text-danger pointer"></i>';
					$del='del-couse ';
				}
				$tblCouse .='<tr><td style="padding-left:0px;">'.form_textarea('risk_couse[]', $crs['description']," id='risk_couse' maxlength='500' size=500 class='form-control' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'").form_hidden(['risk_couse_no[]'=>$crs['id']]).'</td><td class="text-center" width="10%"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash text-success '.$del.'pointer"></i>'.$tambah.'</td></tr>';
			endforeach;
		else:
			$tblCouse .='<tr><td style="padding-left:0px;">'.form_textarea('risk_couse[]', ''," id='risk_couse' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'").form_hidden(['risk_couse_no[]'=>0]).'</td><td class="text-center"  width="10%"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash text-success del-couse pointer"></i>  | <i class="fa fa-plus add-couse text-danger pointer"></i></td></tr>';
		endif;
		$tblCouse .= '</tbody></table>';
		
		$tblImpact = '<table class="table" id="tblImpact"><tbody>';
		if ($impact):
			foreach($impact as $key=>$crs):
				$tambah='';
				$del='';
				if ($key==0){
					$tambah ='  | <i class="fa fa-plus add-impact text-danger pointer"></i>';
					$del='del-impact ';
				}
				$tblImpact .='<tr><td style="padding-left:0px;">'.form_textarea('risk_impact[]', $crs['description']," id='risk_impact' maxlength='500' size=500 class='form-control' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'").form_hidden(['risk_impact_no[]'=>$crs['id']]).'</td><td class="text-center" width="10%"><i class="fa fa-search browse-impact pointer text-primary"></i> | <i class="fa fa-trash text-success '.$del.'pointer"></i>'.$tambah.'</td></tr>';
			endforeach;
		else:
			$tblImpact .='<tr><td style="padding-left:0px;">'.form_textarea('risk_impact[]', ''," id='risk_impact' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'").form_hidden(['risk_impact_no[]'=>0]).'</td><td class="text-center"  width="10%"><i class=" fa fa-search browse-impact text-primary pointer"></i> | <i class="fa fa-trash text-success del-impact pointer"></i> | <i class="fa fa-plus add-impact text-danger pointer"></i></td></tr>';
		endif;
		$tblImpact .= '</tbody></table>';
		
		$tblAttact = '<table class="table" id="tblAttact"><tbody>';
		if ($attact):
			foreach($attact as $key=>$crs):
				$tambah='';
				$del='';
				if ($key==0){
					$tambah ='  | <i class="fa fa-plus add-attact text-danger pointer"></i>';
					$del='del-attact ';
				}
				$tblAttact .='<tr><td style="padding-left:0px;"><span class="preview_file pointer" data-url="'.base_url('ajax/download_preview').'" data-target="rcsa" data-file="'.$crs['name'].'">'.$crs['real_name'].'</span>'.form_hidden(['att_name[]'=>$crs['name'], 'att_real_name[]'=>$crs['real_name']]).' &nbsp; <a href="'.base_url('ajax/download/rcsa/'.$crs['name']).'" target="_blank"> <i class="fa fa-download pointer text-info"></i></a></td><td class="text-center" width="10%"><i class="fa fa-trash text-success '.$del.'"></i>'.$tambah.'</td></tr>';
			endforeach;
		else:
			$tblAttact .='<tr><td style="padding-left:0px;">'.form_upload('attact[]').'</td><td class="text-center"  width="10%"><i class=" fa fa-trash del-attact text-primary pointer"></i> | <i class="fa fa-plus add-attact text-danger pointer"></i></td></tr>';
		endif;
		$tblAttact .= '</tbody></table>';
		
		$jml=intval(count($cboControl)/2);
		$check ='';
		$i=1;
		$control=array();
		$check .='<div class="well p100">';
		if (is_array($arrControl))
			$control=$arrControl;
		foreach($cboControl as $row){
			if ($i==1)
				$check .='<div class="col-md-6">';
			
			$sts=false;
			foreach($control as $ctrl){
				if ($row['component']==$ctrl){
					$sts=true;
					break;
				}
			}
			
			$check .= '<label class="pointer">'.form_checkbox('check_item[]', $row['component'], $sts);
			$check .= '&nbsp;'.$row['component'].'</label><br/>';
			if ($i==$jml)
				$check .='</div><div class="col-md-6">';
			
			++$i;
		}
		$check .='</div>'.form_input("note_control", ($data)?$data['note_control']:'', ' class="form-control" style="width:100%;"').'</div><br/>';
		$this->data_combo['identi'][]=['label'=>lang('msg_field_risk_couse'), 'isi'=>$tblCouse];
		$this->data_combo['identi'][]=['label'=>lang('msg_field_risk_impact'), 'isi'=>$tblImpact];
		$this->data_combo['identi'][]=['label'=>lang('msg_field_risk_attacment'), 'isi'=>$tblAttact];
		
		$this->data_combo['level_resiko'][]=['label'=>lang('msg_field_inherent_risk'), 'isi'=>' Probabilitas : '.form_dropdown('inherent_likelihood', $cboLike, ($data)?$data['inherent_likelihood']:'',' class="form-control select2" id="inherent_likelihood"').' Impact: '.form_dropdown('inherent_impact', $cboImpact, ($data)?$data['inherent_impact']:'',' class="form-control select2" id="inherent_impact"')];
		$this->data_combo['level_resiko'][]=['label'=>lang('msg_field_inherent_level'), 'isi'=>'<span id="inherent_level_label"><span style="background-color:'.$inherent_level['color'].';color:'.$inherent_level['color_text'].';">&nbsp;'.$inherent_level['level_mapping'].'&nbsp;</span></span>'.form_hidden(['inherent_level'=>($data)?$data['inherent_level']:0])];
		
		$this->data_combo['level_resiko'][]=['label'=>lang('msg_field_existing_control'), 'isi'=>$check];
		$this->data_combo['level_resiko'][]=['label'=>lang('msg_field_risk_control_assessment'), 'isi'=>form_dropdown('risk_control_assessment', $cboRiskControl, ($data)?$data['risk_control_assessment']:'',' class="form-control select2" id="risk_control_assessment"')];
		$this->data_combo['level_resiko'][]=['label'=>lang('msg_field_treatment'), 'isi'=>form_dropdown('treatment_no', $cboTreatment, ($data)?$data['treatment_no']:'',' class="form-control select2" id="treatment_no"')];
	}
	
	function get_form_mitigasi(){
		$post=$this->input->post();
		$rcsa_detail=$this->uri->segment(4);
		$data = $this->data->get_data_mitigasi($post['id_edit'], $post['id']);
		$data['parent']=$post['parent'];
		
		$data['owner'] = $this->db->where('id', $data['parent'])->get(_TBL_RCSA)->row_array();
		
		$data['id']=$post['id'];
		$data['id_edit']=$post['id_edit'];
		$data['cbo_owner']=$this->get_combo('parent-input-all');
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
	
	function delete_event(){
		$id = $this->input->post('id');
		$this->crud->crud_data(array('table'=>_TBL_RCSA_DETAIL, 'where'=>array('id'=>$id),'type'=>'delete'));
		$hasil['combo'] ="Data berhasil di hapus!";
		$hasil['sts'] =true;
		echo json_encode($hasil);
	}
	
	function delete_mitigasi(){
		$id = $this->input->post('id');
		$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION, 'where'=>array('id'=>$id),'type'=>'delete'));
		$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION_DETAIL, 'where'=>array('action_no'=>$id),'type'=>'delete'));
		$hasil['combo'] ="Data berhasil di hapus!";
		$hasil['sts'] =true;
		echo json_encode($hasil);
	}
	
	function get_library(){
		$id = $this->input->post('id');
		$nilKel = $this->input->post('kel');
		$data['field'] = $this->db->where('library_no', $id)->where('type', $nilKel)->get(_TBL_VIEW_LIBRARY)->result_array();
		$data['kel']=($nilKel==2)?"Couse":"Impact";
		$data['event_no']=$id;
		$rok=$this->db->where('status',1)->order_by('kelompok, type')->get(_TBL_RISK_TYPE)->result_array();
		$arrayX=array('- Pilih-');
		foreach($rok as $x){
			$kel="EXTERNAL";
			if ($x['kelompok']==77){
				$kel="INTERNAL";
			}
			$arrayX[$kel][$x['id']] = $x['type'];
		}
		$data['nilKel']=$nilKel;
		$data['cboTypeLibrary']=$arrayX;
		$hasil['library'] = $this->load->view('list-library', $data, true);
		$hasil['title'] = ($kel==2)?"List ".$data['kel']:"List ".$data['kel'];
		echo json_encode($hasil);
	}
	
	function get_library_part(){
		$id = $this->input->post('id');
		$event_no = $this->input->post('event');
		$nilKel = $this->input->post('kel');
		if ($id==0)
			$data['field'] = $this->db->where('library_no', $event_no)->where('type', $nilKel)->get(_TBL_VIEW_LIBRARY)->result_array();
		else
			$data['field'] = $this->db->where('library_no', $event_no)->where('risk_type_no', $id)->where('type', $nilKel)->get(_TBL_VIEW_LIBRARY)->result_array();
		$data['kel']=($nilKel==2)?"Couse":"Impact";
		$hasil['combo'] = $this->load->view('list-library-part', $data, true);
		echo json_encode($hasil);
	}
	
	function get_register(){
		$id_rcsa=$this->input->post('id');
		$data['field'] = $this->data->get_data_risk_register($id_rcsa);
		$data['id_rcsa'] = $id_rcsa;
		$data['id'] = $id_rcsa;
		$xx=array('field'=>$data['field'], 'rcsa'=>$data['id_rcsa']);
		$this->session->set_userdata('result_risk_register', $xx);
		$result['register'] = $this->load->view('list_risk_register',$data,true);
		echo json_encode($result);
	}

	function owner_hierarcy()
	{
		$owner = $this->data->owner_hierarcy(1430);
		
		doi::dump(array_filter($owner),false, true);
	}
	
	function cetak_register(){
		$tipe=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		
		$data['field']=$this->data->get_data_risk_register($id);
		$data['id']=$id;
		$hasil=$this->load->view('list_risk_register', $data, true);
		$cetak = 'register_'.$tipe;
		$this->$cetak($hasil);
	}
	
	function register_excel($data){
		header("Content-type:appalication/vnd.ms-excel");
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
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$couse=array();
		foreach($new_data['risk_couse_no'] as $key=>$row){
			if (intval($row)>0 && !in_array($row, $couse))
				$couse[]=$row;
		}
		$upd['risk_couse_no']=json_encode($couse);
		
		$impact=array();
		foreach($new_data['risk_impact_no'] as $key=>$row){
			if (intval($row)>0 && !in_array($row, $impact))
				$impact[]=$row;
		}
		
		$upd['risk_impact_no']=json_encode($impact);
		$result=$this->crud->crud_data(array('table'=>$this->tbl_master, 'field'=>$upd,'where'=>array('id'=>$id),'type'=>'update'));
		
		return true;
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$couse=array();
		foreach($new_data['risk_couse_no'] as $key=>$row){
			if (intval($row)>0 && !in_array($row, $couse))
				$couse[]=$row;
		}
		$upd['risk_couse_no']=json_encode($couse);
		
		$impact=array();
		foreach($new_data['risk_impact_no'] as $key=>$row){
			if (intval($row)>0 && !in_array($row, $impact))
				$impact[]=$row;
		}
		
		$upd['risk_impact_no']=json_encode($impact);
		$result=$this->crud->crud_data(array('table'=>$this->tbl_master, 'field'=>$upd,'where'=>array('id'=>$id),'type'=>'update'));
		
		return true;
	}
	
}