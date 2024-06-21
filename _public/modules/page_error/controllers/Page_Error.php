<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_Error extends  CI_Controller {
	public function __construct() { 
		parent::__construct(); 
		if (!$this->authentication->is_loggedin() && $this->router->fetch_module()!=='auth')
		{
			header('location:'.base_url().'auth');
		}
	}
	  
	public function index()
	{
		$sql['message']='Modul ' . current_url() . ' Not Found';
		$sql['type']='page_error/error_404';			
		$sql['priority']=1;
		$sql['priority_name']='Error 404 Module';
		save_debug($sql);
		
		$this->template->build('page_error/error_404'); 
	}
	
	public function error_auth(){
		$sql['message']='Modul ' . current_url() . ' Tidak diijinkan';
		$sql['type']='page_error/error_auth';			
		$sql['priority']=1;
		$sql['priority_name']='Error Authentication';
		save_debug($sql);
		$this->template->build('page_error/error_auth'); 
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */