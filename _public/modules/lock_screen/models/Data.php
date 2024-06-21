<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	var $tbl_items='';
	var $_prefix='';
	var $_modules='';
	public function __construct()
    {
        parent::__construct();
		$this->_prefix=$this->config->item('tbl_suffix');
		$this->tbl_items=$this->_prefix."items";
		$this->_modules= $this->router->fetch_module();
	}
	
	public function index($rows)
	{
		
	}
	
	function get_rekap()
	{
		$hasil="";
		return $hasil;
	}
}

/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */