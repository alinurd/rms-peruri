<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function cari_total_dipakai($id){
		$this->db->where('level_risk_no', $id);
		$num_rows = $this->db->count_all_results(_TBL_LEVEL_COLOR);
		$hasil['jml']=$num_rows;
		
		$sql=$this->db
				->select('*')
				->from(_TBL_LEVEL_MAPPING)
				->where('id', $id)
				->get();
		
		$rows=$sql->row();
		$hasil['nama'] = $rows->level_mapping;
		return $hasil;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */