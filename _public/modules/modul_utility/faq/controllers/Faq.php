<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Faq extends BackendController {
	public function __construct()
	{
        parent::__construct();
	}
	
	public function index(){
		$data['faq']=$this->data->get_faq();
		$this->template->build('faq', $data);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */