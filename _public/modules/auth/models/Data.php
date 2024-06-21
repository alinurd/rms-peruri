<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	
	public function __construct()
    {
        parent::__construct();
	
	}
	
	function cari_content($data)
	{
		$this->db->select('*');
		$this->db->from('news');
		$this->db->where('uri_title',$data);
		
		$query=$this->db->get();
		$result=$query->result_array();
		
		return $result[0];
	}
	
	public function get_news(){
		$this->db->select('*');
		$this->db->from('news');
		$this->db->where('sticky',1);
		$this->db->where('status',1);
		// $this->db->limit($limit);
		// $this->db->order_by('process_date','desc');
		$query=$this->db->get();
		return $query->result();
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */