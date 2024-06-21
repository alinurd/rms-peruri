<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
    {
        parent::__construct();
		// _TBL_RCSA_DETAIL="rcsa_detail";
	}
	
	function get_map_rcsa($data=[]){
		$mapping = $this->db->get(_TBL_VIEW_MATRIK_TOP)->result_array();
		
		if ($data){
			$rows = $this->db->where('owner_no', $data['id_owner'])->where('period_no', $data['id_period'])->get('bangga_view_top_risk')->result_array();
			
			foreach ($mapping as &$row){
				$row['nilai']='';
			}
			unset($row);
		}
		$mapping = $this->data->draw_rcsa($mapping);
		return $mapping;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */