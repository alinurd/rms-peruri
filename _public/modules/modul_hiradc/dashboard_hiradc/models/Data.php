<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
    {
        parent::__construct();
	}
	
	function get_detail_event($dt){
		$datas=explode(',',$dt);
		$detail=array();
		foreach($datas as $data){
			$this->db->select(_TBL_LIBRARY.'.*');
			$this->db->from(_TBL_RCSA_DETAIL);
			$this->db->join(_TBL_LIBRARY,_TBL_RCSA_DETAIL.'.event_no='._TBL_LIBRARY.'.id');
			$this->db->where(_TBL_LIBRARY.'.id',$data);			
			$query=$this->db->get();
			$rows=$query->result_array();
			foreach($rows as $row){
				$detail[]=$row;
			}
		}
		return $detail;
	}
	
	function get_map_hiradc(){
		$mapping = $this->db->get(_TBL_VIEW_MATRIK_HIRADC)->result_array();
		// foreach ($mapping as &$row){
			// $row['nilai']='';
		// }
		// unset($row);
		$mapping = $this->data->draw_hiradc($mapping);
		return $mapping;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */