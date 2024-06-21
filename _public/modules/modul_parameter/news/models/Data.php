<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function save_uri_title($newid=0,$data=array())
	{
		$updf['id'] = $newid;
		$upd['uri_title'] = create_unique_slug($data['l_title'], _TBL_NEWS,'uri_title');
		$upd['process_date'] = date('Y-m-d');
		$upd['user_no'] = $this->authentication->get_info_user('username');
		$this->db->update("news",$upd,$updf);
		return true;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */