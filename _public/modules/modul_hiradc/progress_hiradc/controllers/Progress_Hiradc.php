<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Progress_Hiradc extends BackendController {
	var $data_combo=false;
	
	public function __construct()
	{
        parent::__construct();
		$this->cboOwner = $this->get_combo('parent-input');
		$this->combo_sts = $this->get_combo('data-combo','status-mitigasi');
		
		$this->set_Tbl_Master(_TBL_VIEW_HIRADC_MITIGASI_DETAIL);
		
		$this->set_Open_Tab('Data Progres Mitigasi');
			$this->addField(array('field'=>'id', 'show'=>false));			
			$this->addField(array('field'=>'id_edit', 'show'=>false));			
			$this->addField(array('field'=>'hiradc_no', 'input'=>'combo', 'combo'=>array(), 'search'=>true, 'show'=>false, 'size'=>20));
			$this->addField(array('field'=>'hiradc_detail_no', 'input'=>'combo', 'combo'=>array(), 'search'=>true, 'show'=>false, 'size'=>20));
			$this->addField(array('field'=>'mitigasi_no', 'input'=>'combo', 'combo'=>array(), 'search'=>true, 'show'=>false, 'size'=>20));
			$this->addField(array('field'=>'owner_no', 'search'=>true, 'show'=>false, 'size'=>20));
			$this->addField(array('field'=>'progress_date', 'type'=>'date', 'input'=>'date', 'search'=>true, 'size'=>40));
			$this->addField(array('field'=>'description', 'search'=>true, 'size'=>40));
			$this->addField(array('field'=>'notes', 'search'=>true, 'size'=>40));
			$this->addField(array('field'=>'progress_detail', 'show'=>false, 'search'=>true, 'size'=>40));
			$this->addField(array('field'=>'status_no', 'input'=>'boolean', 'search'=>true, 'size'=>40));
			$this->addField(array('field'=>'corporate', 'show'=>false, 'size'=>40));
			$this->addField(array('field'=>'sekarang', 'show'=>false, 'size'=>40));
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id_edit');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));		
		
		// $this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'hiradc_owner_no');
		
		$this->set_Sort_Table($this->tbl_master,'mitigasi_no');
		$this->set_Sort_Table($this->tbl_master,'progress_date');
				
		$this->set_Table_List($this->tbl_master,'progress_date');
		$this->set_Table_List($this->tbl_master,'corporate');
		$this->set_Table_List($this->tbl_master,'sekarang');
		$this->set_Table_List($this->tbl_master,'description');
		$this->set_Table_List($this->tbl_master,'notes');
		$this->set_Table_List($this->tbl_master,'progress_detail');
		// $this->set_Table_List($this->tbl_master,'status_no');
		
		$this->_SET_PRIVILEGE('add', false);
		// $this->_SET_PRIVILEGE('delete', false);
		$this->_CHANGE_TABLE_MASTER(_TBL_HIRADC_MITIGASI_DETAIL);
		$this->set_Close_Setting();
		
	}
	
	function POST_DELETE_MANUAL($id){
		$result = $this->data->delete_mitigasi($id);
		return $result;
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows){
		$tombol['view']=array();
		$id = $rows['l_hiradc_no'];
		$url=base_url('/progress-hiradc/progress-mitigasi/edit-detail/'.$id);
		$tombol['edit']['url']=$url;
		
		return $tombol;
	}
	
	function get_title_fields($id=0){
		$cboOwner = $this->get_combo('parent-input');
		$this->data_combo['asses1'][]=['label'=>lang('msg_field_corporate'), 'content'=>$this->data_combo['parent']['corporate']];
		$this->data_combo['asses1'][]=['label'=>lang('msg_field_owner_no'), 'content'=>$this->data_combo['parent']['name']];
		$this->data_combo['asses1'][]=['label'=>lang('msg_field_type'), 'content'=>$this->data_combo['parent']['tipe']];
		$this->data_combo['asses1'][]=['label'=>lang('msg_field_period_no'), 'content'=>$this->data_combo['parent']['periode_name']];
		
		$this->data_combo['asses2'][]=['label'=>lang('msg_field_total_aktifitas'), 'content'=>$this->data_combo['parent']['corporate']];
		$this->data_combo['asses2'][]=['label'=>lang('msg_field_total_mitigasi'), 'content'=>$this->data_combo['parent']['name']];
		$this->data_combo['asses2'][]=['label'=>lang('msg_field_progress_mitigasi'), 'content'=>$this->data_combo['parent']['tipe']];
		$this->data_combo['asses2'][]=['label'=>lang('msg_field_tingkat_resiko'), 'content'=>$this->data_combo['parent']['periode_name']];
	
		if ($id==1){
		$this->data_combo['miti1'][]=['label'=>lang('msg_field_lokasi'), 'content'=>$this->data_combo['mitigasi']['lokasi']];
		$this->data_combo['miti1'][]=['label'=>lang('msg_field_aktifitas'), 'content'=>$this->data_combo['mitigasi']['aktifitas']];
		$this->data_combo['miti1'][]=['label'=>lang('msg_field_bahaya'), 'content'=>$this->data_combo['mitigasi']['bahaya']];
		$this->data_combo['miti1'][]=['label'=>lang('msg_field_resikok3'), 'content'=>$this->data_combo['mitigasi']['resiko']];
		$this->data_combo['miti1'][]=['label'=>lang('msg_field_kondisi'), 'content'=>$this->data_combo['mitigasi']['kondisi']];
		
		$this->data_combo['miti2'][]=['label'=>lang('msg_field_mitigasi_sekarang'), 'content'=>$this->data_combo['mitigasi']['sekarang']];
		$this->data_combo['miti2'][]=['label'=>lang('msg_field_mitigasi_mendatang'), 'content'=>$this->data_combo['mitigasi']['mendatang']];
		$this->data_combo['miti2'][]=['label'=>lang('msg_field_mitigasi_tgl_mulai'), 'content'=>$this->data_combo['mitigasi']['tgl_mulai']];
		$this->data_combo['miti2'][]=['label'=>lang('msg_field_mitigasi_tgl_selesai'), 'content'=>$this->data_combo['mitigasi']['tgl_selesai']];
		$this->data_combo['miti2'][]=['label'=>lang('msg_field_mitigasi_program'), 'content'=>$this->data_combo['mitigasi']['program']];
		$data=array();
		if ($this->data_combo['param'][0]=='edit_detail'){
			$data=$this->data_combo['mitigasi_detail'];
		}
		$this->data_combo['form_miti'][]=['label'=>lang('msg_field_progress_date'), 'content'=>form_input('progress_date', ($data)?$data['progress_date']:date('d-m-Y'),'class="form-control datepicker" id="progress_date" style="width:120px;"').form_hidden(['parent_no'=>$this->uri->segment(5), 'edit_no'=>($data)?$data['id_edit']:0])];
		$this->data_combo['form_miti'][]=['label'=>lang('msg_field_mitigasi_owner_no'), 'content'=>form_dropdown('owner_no', $cboOwner,($data)?explode(',',$data['owner_no']):'','class="form-control select2" multiple="multiple" style="width:100% !important;" id="owner_no"')];
		$this->data_combo['form_miti'][]=['label'=>lang('msg_field_mitigasi_description'), 'content'=>form_input('description', ($data)?$data['description']:'','class="form-control "  id="description"')];
		$this->data_combo['form_miti'][]=['label'=>lang('msg_field_mitigasi_notes'), 'content'=>form_input('note', ($data)?$data['notes']:'','class="form-control "  id="note"')];
		$this->data_combo['form_miti'][]=['label'=>lang('msg_field_mitigasi_progress'), 'content'=>form_input(['type'=>'number','name'=>'progress'],($data)?$data['progress_detail']:0," class='form-control numeric' size='80' style='width:80px !important;' id='progress'")];
		}
	}
	
	function listBox_PROGRESS_DETAIL($row, $value){
		if ($value<=30){ $warna="danger";
		}elseif ($value<=50){ $warna="warning";
		}elseif ($value<=75){ $warna="success";
		}else{
			$warna="primary";
		}
		
		$result = '<div class="progress progress-sl">
					  <div class="progress-bar progress-bar-'.$warna.'" role="progressbar" aria-valuenow="'.$value.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$value.'%;">'.number_format($value).'% Complete
					  </div>
				  </div>';
		
		return $result;
	}
	
	function progress_mitigasi($param=array()){
		$id=0;
		if ($param){
			if(strtolower($param[0])=='add' || strtolower($param[0])=='edit' || strtolower($param[0])=='edit_detail'){
				$parent=(count($param)>1)?$param[1]:0;
				$id=(count($param)>2)?$param[2]:0;
				$view='detail-mitigasi';
				$this->data_combo=$this->data->get_data_mitigasi_detail($param);
				$this->data_combo['param']=$param;
				$this->get_title_fields(1);
				$this->data_combo['mode']=$param[0];
			}elseif(strtolower($param[0]=='save')){
				$post = $this->input->post();
				$parent = $post['parent_no'];
				$result = $this->data->simpan_risk_event($post);
				header('location:'.base_url($this->modul_name.'/risk-event/edit/'.$parent.'/'.$result));
				exit;
			}else{
				$id=$param[0];
				$view='mitigasi';
				$this->data_combo=$this->data->get_data_mitigasi($id);
				$this->get_title_fields();
			}
			$this->template->build($view, $this->data_combo); 
		}else{
			header('location:'.base_url($this->modul_name));
		}
	}

	function save_mitigasi(){
		$post=$this->input->post();
		$data['detail'] = $this->data->save_mitigasi($post);
		$hasil['combo']=$this->load->view('list-mitigasi', $data, true);
		echo json_encode($hasil);
	}

	function get_form_mitigasi(){
		$post=$this->input->post();
		$rows = $this->db->where('id',$post['id'])->get(_TBL_HIRADC_MITIGASI_DETAIL)->row_array();
		$rows['owner'] = explode(",",$rows['owner_no']);
		$hasil=$rows;
		echo json_encode($hasil);
	}
}