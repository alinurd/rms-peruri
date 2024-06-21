<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function cari_total_dipakai($id){
		$this->db->where('period_no', $id);
		$num_rows = $this->db->count_all_results(_TBL_RCSA);
		$hasil['jml']=$num_rows;
		
		$sql=$this->db
				->select('*')
				->from(_TBL_PERIOD)
				->where('id', $id)
				->get();
		
		$rows=$sql->row();
		$hasil['nama'] = $rows->periode_name;
		return $hasil;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */