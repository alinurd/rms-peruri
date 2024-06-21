<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	var $tbl_items='';
	public function __construct()
    {
        parent::__construct();
	}
	
	function get_level($id){
		$this->db->select('*');
		$this->db->from(_TBL_LEVEL);
		$this->db->where('id',$id);
		$query=$this->db->get();
		$rows=$query->result();
		$result="-";
		foreach($rows as $row){
			$result=$row->level;
		}
		return $result;
	}
	
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */