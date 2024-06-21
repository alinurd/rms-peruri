<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	
	function get_hiradc_detail($id){
		$this->db->where('hiradc_no', $id);
		$rows = $this->db->get(_TBL_VIEW_HIRADC_DETAIL)->result_array();
		return $rows;
	}
	
	function get_data_register($id){
		$rows = $this->get_hiradc_detail($id);
		$regulasi = $this->get_combo_model('regulasi');
		$arrRegulasi=array();
		foreach($regulasi as $key=>$row){
			$arrRegulasi[$key]=$row;
		}
		
		$detail = $this->db->where('hiradc_no', $id)->get(_TBL_VIEW_HIRADC_MITIGASI)->result_array();
		$mitigasi=array();
		foreach($detail as $row){
			$row['prioritas'] = json_decode($row['pertimbangan'], true);
			$mitigasi[$row['hiradc_detail_no']][]=$row;
		}
		
		foreach($rows as &$row){
			if (array_key_exists($row['id'], $mitigasi))
				$row['mitigasi'] = $mitigasi[$row['id']];
			else
				$row['mitigasi'] = array();
			
			$regs=json_decode($row['regulasi'], true);
			$isiRegulasi=array();
			foreach ($regs as $reg){
				if (array_key_exists($reg, $arrRegulasi))
					$isiRegulasi[] = $arrRegulasi[$reg];
			}
			$row['isiRegulasi'] = implode('<br/>- ', $isiRegulasi);
		}
		unset($row);
		return $rows;
	}
	
	function get_data_risk_event($id){
		$hasil['field'] = $this->get_hiradc_detail($id);;
		$rows = $this->db->where('id', $id)->get(_TBL_VIEW_HIRADC)->row_array();
		$hasil['parent'] = $rows;
		return $hasil;
	}
	
	function get_data_risk_event_detail($id, $parent){
		$this->db->where('id', $id);
		$rows = $this->db->get(_TBL_VIEW_HIRADC_DETAIL)->row_array();
		$hasil['detail'] = $rows;
		$rows = $this->db->where('id', $parent)->get(_TBL_VIEW_HIRADC)->row_array();
		$hasil['parent'] = $rows;
		$rows = $this->db->where('hiradc_detail_no', $id)->get(_TBL_VIEW_HIRADC_MITIGASI)->result_array();
		$hasil['mitigasi'] = $rows;
		return $hasil;
	}
	
	function get_data_list_mitigasi($id){
		$rows = $this->db->where('hiradc_detail_no', $id)->get(_TBL_VIEW_HIRADC_MITIGASI)->result_array();
		$hasil['mitigasi'] = $rows;
		return $hasil;
	}
	
	function get_data_mitigasi($id){
		$reg_isi=array();
		$rows = $this->db->where('id', $id)->get(_TBL_VIEW_HIRADC_MITIGASI)->row_array();
		$hasil['field'] = $rows;
		$rows = $this->db->where('aktif', 1)->where('kelompok','faktor-prioritas')->order_by('urut')->get(_TBL_DATA_COMBO)->result_array();
		$faktor="";
		foreach($rows as $row){
			$check=false;
			if (is_array($reg_isi)){
				if (in_array($row['id'], $reg_isi))
					$check=true;
			}
			$faktor .= form_checkbox('pertimbangan[]', $row['id'], $check, 'id="regulasi" ');
			$faktor .= form_label($row['kode'].'. '.$row['data'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	', $row['id'], ' ').'"<br/>';
		}
		
		$hasil['faktor'] = $faktor;
		$program = 0;
		if ($hasil['field']){
			$program = $hasil['field']['program_no'];
		}
		$hasil['cboProgram']=form_dropdown('program_no', $this->get_combo_model('data-combo','prioritas-hiradc'),$program, 'class="form-control" id="program_no"');
		
		return $hasil;
	}
	
	function cari_total_dipakai($id){
		$sql=$this->db->select('hiradc_no, name, count(id) as jml')->WHERE_IN('hiradc_no', $id)->group_by(['hiradc_no','name'])->get(_TBL_VIEW_HIRADC_DETAIL)->result_array();
		
		$hasil=array();
		foreach($sql as $row):
			$hasil[$row['hiradc_no']] = ['jml'=>$row['jml'],'nama'=>'name'];
		endforeach;
		return $hasil;
	}
	
	function simpan_risk_event($data){
		$mode= $data['mode'];
		$id_edit= $data['id_edit'];
		$upd=array();
		// Doi::dump($data);die();
		$upd['hiradc_no']=$data['parent_no'];
		$upd['area_no']=$data['area_no'];
		$upd['aktifitas']=$data['aktifitas'];
		$upd['bahaya_no']=$data['bahaya_no'];
		$upd['event_no']=$data['event_no'];
		$upd['kondisi_no']=$data['kondisi_no'];
		$upd['tr_no']=$data['tr_no'];
		$upd['srd_no']=$data['srd_no'];
		$upd['bp_no']=$data['bp_no'];
		$upd['lp_no']=$data['lp_no'];
		$upd['cp_no']=$data['cp_no'];
		$upd['severity']=$data['severity'];
		$upd['severity_no']=$data['severity_no'];
		$upd['occorunce_no']=$data['occorunce_no'];
		$upd['score_resiko']=str_replace(',','',$data['score_resiko']);
		$upd['risk_impact']=$data['risk_impact'];
		$regulasi = json_encode(array());
		if (isset($data['regulasi']))
			$regulasi = json_encode($data['regulasi']);
		$upd['regulasi']=$regulasi;
		$upd['status_no']=$data['status_no'];
		if ($id_edit==0){
			$result=$this->crud->crud_data(array('table'=>_TBL_HIRADC_DETAIL, 'field'=>$upd,'type'=>'add'));
		}else{
			$this->crud->crud_data(array('table'=>_TBL_HIRADC_DETAIL, 'field'=>$upd,'where'=>array('id'=>$id_edit),'type'=>'update'));
			$result=$id_edit;
		}
		// Doi::dump("edit ".$result);
		// Doi::dump("nonya ".$id_edit);
		// Doi::dump($upd);
		// die();
		return $result;
	}
	
	function save_mitigasi($data){
		
		$ins=array();
		$id_edit=$data['id_edit'];
		$ins['hiradc_detail_no']=$data['id_detail'];	
		$ins['operasional']=$data['operasional'];
		$ins['sekarang']=$data['sekarang'];
		$ins['mendatang']=$data['mendatang'];
		$ins['tgl_mulai']=date('Y-m-d', strtotime($data['tgl_mulai']));
		$ins['tgl_selesai']=date('Y-m-d', strtotime($data['tgl_selesai']));
		$ins['pertimbangan']=json_encode($data['pendukung']);
		$ins['program_no']=$data['program'];
		$ins['update_user']=$this->authentication->get_info_user('user_name');
		if ($id_edit==0){
			$result=$this->crud->crud_data(array('table'=>_TBL_HIRADC_MITIGASI, 'field'=>$ins,'type'=>'add'));
		}else{
			$ins['update_date']=Doi::now();
			$this->crud->crud_data(array('table'=>_TBL_HIRADC_MITIGASI, 'field'=>$ins,'where'=>array('id'=>$id_edit),'type'=>'update'));
			$result=$id_edit;
		}
		
		$hasil=$this->data->get_data_list_mitigasi($data['id_detail']);
		return $hasil;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */