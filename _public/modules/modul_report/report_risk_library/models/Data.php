<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}

	function get_couse($id){
		$this->db->select('description');
		$this->db->from(_TBL_LIBRARY);
		$this->db->where('id',$id);

		
		$query=$this->db->get()->row();
		$result=$query->description;
				// Doi::dump($this->db->last_query());die();
		return $result;
	}
	function get_impact($id){
		$this->db->select('description');
		$this->db->from(_TBL_LIBRARY);
		$this->db->where('id',$id);

		
		$query=$this->db->get()->row();
		$result=$query->description;
				// Doi::dump($this->db->last_query());die();
		return $result;
	}
	


}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */