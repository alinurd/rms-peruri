<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MX_Model {

	private $user_table;
	private $identifier_field;
	private $username_field;
	private $password_field;
	
	public function __construct()
    {
        parent::__construct();
	}
	
	// public function gey_news(){
	// 	$this->db->select('*');
	// 	$this->db->from('news');
	// 	$this->db->where('stiky',1);
	// 	$this->db->limit(4);
	// 	$this->db->order_by('process_date');
	// 	$query=$this->db->get();
	// 	return $query->result();
	// }
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */