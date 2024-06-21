<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	
	function get_irp_detail($id){
		$this->db->where('irp_no', $id);
		$rows = $this->db->get(_TBL_VIEW_IRP_DETAIL)->result_array();
		return $rows;
	}
	
	function get_data_register($id){
		$rows = $this->get_irp_detail($id);
		
		$detail = $this->db->where('irp_no', $id)->get(_TBL_VIEW_IRP_MITIGASI)->result_array();
		$mitigasi=array();
		foreach($detail as $row){
			$mitigasi[$row['irp_detail_no']][]=$row;
		}
		
		foreach($rows as &$row){
			if (array_key_exists($row['id'], $mitigasi))
				$row['mitigasi'] = $mitigasi[$row['id']];
			else
				$row['mitigasi'] = array();
		}
		unset($row);
		return $rows;
	}
	
	function get_data_risk_event($id){
		$hasil['field'] = $this->get_IRP_detail($id);;
		$rows = $this->db->where('id', $id)->get(_TBL_VIEW_IRP)->row_array();
		$hasil['parent'] = $rows;
		return $hasil;
	}
	
	function get_data_risk_event_detail($id, $parent){
		$this->db->where('id', $id);
		$rows = $this->db->get(_TBL_VIEW_IRP_DETAIL)->row_array();
		$hasil['detail'] = $rows;
		// $id = $rows['IRP_no'];
		$rows = $this->db->where('id', $parent)->get(_TBL_VIEW_IRP)->row_array();
		$hasil['parent'] = $rows;
		$rows = $this->db->where('irp_detail_no', $id)->get(_TBL_VIEW_IRP_MITIGASI)->result_array();
		$hasil['mitigasi'] = $rows;
		// Doi::dump($rows);die($this->db->last_query());
		return $hasil;
	}
	
	function get_data_list_mitigasi($id){
		$rows = $this->db->where('irp_detail_no', $id)->get(_TBL_VIEW_IRP_MITIGASI)->result_array();
		$hasil['mitigasi'] = $rows;
		return $hasil;
	}
	
	function get_data_mitigasi($id){
		$reg_isi=array();
		$rows = $this->db->where('id', $id)->get(_TBL_VIEW_IRP_MITIGASI)->row_array();
		$hasil['field'] = $rows;
		return $hasil;
	}
	
	function cari_total_dipakai($id){
		$num_rows = $this->get_IRP_detail($id);;
		$hasil['jml']=count($num_rows);
		
		$sql=$this->db
				->select('*')
				->from(_TBL_IRP)
				->where('id', $id)
				->get();
		
		$rows=$sql->row();
		$hasil['nama'] = $rows->corporate;
		return $hasil;
	}
	
	function simpan_risk_event($data){
		$mode= $data['mode'];
		$id_edit= $data['id_edit'];
		$upd=array();
		$upd['irp_no']=$data['parent_no'];
		$upd['area_no']=$data['area_no'];
		$upd['aktifitas_no']=$data['aktifitas_no'];
		$upd['aset_no']=$data['aset_no'];
		$upd['fungsi_kritis']=$data['fungsi_kritis'];
		$upd['kerawanan']=$data['kerawanan'];
		$upd['ancaman_no']=$data['ancaman_no'];
		$upd['dampak_no']=$data['dampak_no'];
		$upd['kemungkinan_no']=$data['kemungkinan_no'];
		$upd['level_resiko']=$data['level_resiko'];
		$upd['status_no']=$data['status_no'];
		if ($id_edit==0){
			$result=$this->crud->crud_data(array('table'=>_TBL_IRP_DETAIL, 'field'=>$upd,'type'=>'add'));
		}else{
			$this->crud->crud_data(array('table'=>_TBL_IRP_DETAIL, 'field'=>$upd,'where'=>array('id'=>$id_edit),'type'=>'update'));
			$result=$id_edit;
		}
		return $result;
	}
	
	function save_mitigasi($data){
		
		$ins=array();
		$id_edit=$data['id_edit'];
		$ins['irp_detail_no']=$data['id_detail'];	
		$ins['pengendalian']=$data['pengendalian'];
		$ins['mitigasi']=$data['mitigasi'];
		$ins['update_user']=$this->authentication->get_info_user('user_name');
		if ($id_edit==0){
			$result=$this->crud->crud_data(array('table'=>_TBL_IRP_MITIGASI, 'field'=>$ins,'type'=>'add'));
		}else{
			$ins['update_date']=Doi::now();
			$this->crud->crud_data(array('table'=>_TBL_IRP_MITIGASI, 'field'=>$ins,'where'=>array('id'=>$id_edit),'type'=>'update'));
			$result=$id_edit;
		}
		
		$hasil=$this->data->get_data_list_mitigasi($data['id_detail']);
		return $hasil;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */