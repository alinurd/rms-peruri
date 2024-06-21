<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
    {
        parent::__construct();
	}
	
	function cari_total_dipakai($id){
		$this->db->where('inherent_likelihood', $id);
		$this->db->or_where('inherent_impact', $id);
		$num_rows = $this->db->count_all_results(_TBL_RCSA_DETAIL);
		$hasil['jml']=$num_rows;
		
		$sql=$this->db
				->select('*')
				->from(_TBL_LEVEL)
				->where('id', $id)
				->get();
		
		$rows=$sql->row();
		$hasil['nama'] = $rows->category . ' - ' . $rows->level;
		return $hasil;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */