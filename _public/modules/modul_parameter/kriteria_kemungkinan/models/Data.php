<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function get_used_data($id){
		$rows = $this->db->select('jabatan, jabatan_no, count(jabatan) as jml')->from(_TBL_KARYAWAN)->join(_TBL_JABATAN, _TBL_KARYAWAN.'.jabatan_no='._TBL_JABATAN.'.id')->group_by('jabatan')->get()->result_array();
		
		
		$hasil=array();
		foreach($rows as $row){
			$hasil[$row['jabatan_no']] = $row['jml'];
		}
		return $hasil;
	}
	
	function data_history($id, $limit=10){
		$page = intval($this->uri->segment(4));
		$rows = $this->db->where('jabatan_no', $id);
		$query = $this->db->get(_TBL_KARYAWAN);
		$this->total=$query->num_rows();
		
		$rows = $this->db->where('jabatan_no', $id)->order_by('nama_karyawan')->limit($limit, $page)->get(_TBL_KARYAWAN)->result_array();
		return $rows;
	}
	
	function get_total(){
		return $this->total;
	}

	function save_privilege($newid=0,$data=array(), $old_data=array())
	{
		if (isset($data['risk_couse_no'])){
			if(count($data['risk_couse_no'])>0){
				$no=0;
				foreach($data['criteria_risiko'] as $key=>$row){
					if (!empty($data['area'][$key])){
						$upd['km_id'] = $newid;
						$upd['area'] = $data['area'][$key];
						$upd['criteria_risiko'] = $data['criteria_risiko'][$key];
					
						
						if(intval($data['risk_couse_no'][$key])>0)
						{
						
							$upd['update_user'] = $this->authentication->get_Info_User('username');
							$where['id'] = $data['risk_couse_no'][$key];
							$this->crud->crud_data(array('table'=>_TBL_AREA_KM, 'field'=>$upd, 'where'=>$where,'type'=>'update'));

						}
						else
						{
							$upd['create_user'] = $this->authentication->get_Info_User('username');
							
							$this->crud->crud_data(array('table'=>_TBL_AREA_KM, 'field'=>$upd,'type'=>'add'));

						}

		
					}
				}
			}
		}
		return true;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */