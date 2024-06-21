<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
    {
        parent::__construct();
		
	}
	
	function get_data_mitigasi($id){
		$rows = $this->db->where('hiradc_no', $id)->order_by('hiradc_detail_no','id')->get(_TBL_VIEW_HIRADC_MITIGASI)->result_array();
		$rows_hiradc=array();
		if ($rows){
			$rows_hiradc = $this->db->where('id', $id)->get(_TBL_VIEW_HIRADC)->row_array();
		}
		$hasil['detail']=$rows;
		$hasil['parent']=$rows_hiradc;
		return $hasil;
	}
	
	function get_data_mitigasi_detail($param){
		$rows = $this->db->where('id', $param[2])->order_by('hiradc_detail_no','id')->get(_TBL_VIEW_HIRADC_MITIGASI)->row_array();
		$rows_detail = $this->db->where('id', $param[2])->order_by('id','id_edit')->get(_TBL_VIEW_HIRADC_MITIGASI_DETAIL)->result_array();
		$rows_hiradc=array();
		if ($rows){
			$rows_hiradc = $this->db->where('id', $param[1])->get(_TBL_VIEW_HIRADC)->row_array();
		}
		$mitigasi_detail=array();
		if ($param[0]=="edit_detail"){
			$mitigasi_detail = $this->db->where('id_edit', $param[2])->get(_TBL_VIEW_HIRADC_MITIGASI_DETAIL)->row_array();
		}
		$hasil['detail']=$rows_detail;
		$hasil['mitigasi_detail']=$mitigasi_detail;
		$hasil['mitigasi']=$rows;
		$hasil['parent']=$rows_hiradc;
		return $hasil;
	}
	
	function save_mitigasi($data){
		$ins=array();
		$id_edit=$data['edit_no'];
		$ins['mitigasi_no']=$data['parent_no'];	
		$ins['owner_no']=implode(',',$data['owner_no']);
		$ins['description']=$data['description'];
		$ins['progress']=$data['progress'];
		$ins['progress_date']=date('Y-m-d', strtotime($data['progress_date']));
		$ins['notes']=$data['note'];
		$ins['update_user']=$this->authentication->get_info_user('user_name');
		if ($id_edit==0){
			$result=$this->crud->crud_data(array('table'=>_TBL_HIRADC_MITIGASI_DETAIL, 'field'=>$ins,'type'=>'add'));
		}else{
			$ins['update_date']=Doi::now();
			$this->crud->crud_data(array('table'=>_TBL_HIRADC_MITIGASI_DETAIL, 'field'=>$ins,'where'=>array('id'=>$id_edit),'type'=>'update'));
			$result=$id_edit;
		}
		
		$rows = $this->db->where('mitigasi_no', $data['parent_no'])->order_by('progress','desc')->limit(1)->get(_TBL_HIRADC_MITIGASI_DETAIL)->row();
		$this->crud->crud_data(array('table'=>_TBL_HIRADC_MITIGASI, 'field'=>array('progress'=>$rows->progress),'where'=>array('id'=>$data['parent_no']),'type'=>'update'));
		
		$rows = $this->db->where('id', $data['parent_no'])->order_by('id','id_edit')->get(_TBL_VIEW_HIRADC_MITIGASI_DETAIL)->result_array();
		return $rows;
	}
	
	function delete_mitigasi($id){
		$data=['tbl'=>_TBL_HIRADC_MITIGASI_DETAIL, 'id'=>'id'];
		$result=$this->crud->delete_data($data, $id);
		return $result;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */