<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Lock_Screen extends BackendController {
	var $tmp_data=array();
	var $data_fields=array();
	
	public function __construct()
	{
        parent::__construct();
		
		$this->template->set_layout('lock');
	}
	
	public function index()
	{	
		$sts = $this->session->userdata('lock_screen');
		if (!$sts){
			$redirect_to = isset($_GET["redirect_to"])?$_GET["redirect_to"]:"";
			if(!empty($redirect_to)){
				$redirect_to = urldecode($redirect_to);
			}else{
				$redirect_to = base_url();
			}
			
			$sts_lock=true;
			$this->session->set_userdata(array('lock_screen' => $sts_lock,'lock_screen_url' => $redirect_to));
		}
		$this->template->build('lock_screen'); 
	}
	
	function open_lock(){
		$pass=$this->input->post('sandi');
		$result=$this->authentication->cek_password($pass);
		if ($result){
			$sts_lock=false;
			$this->session->set_userdata(array('lock_screen' => $sts_lock,'lock_screen_url' => base_url()));
			
			$redirect_to = $this->session->userdata('lock_screen_url');
			
			header('location:' . $redirect_to);
		}else{
			header('location:' . base_url('lock-screen'));
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */