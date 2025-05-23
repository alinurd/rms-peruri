<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Change_Password extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		$this->set_Tbl_Master(_TBL_USERS);
		$this->addField(array('field'=>'id', 'show'=>false));
		$this->addField(array('field'=>'username', 'save'=>false, 'size'=>20));
		$this->addField(array('field'=>'password', 'input'=>'pass', 'size'=>20));
		$this->addField(array('field'=>'passwordc', 'type'=>'free', 'input'=>'pass', 'label'=>'l_passwordc'));
	
		$this->tmp_data['primary']=array('tbl'=>$this->tbl_master,'id'=>'id');
		$this->tmp_data['m_tbl'][]=array('master'=>1,'pk'=>$this->tbl_master);
		$this->tmp_data['sort'][]=array('tbl'=>$this->tbl_master,'id'=>'nama_lengkap');
		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'username', 'readonly'=>true));
		
		$this->tmp_data['title'][]=array('username','','15','left');
		$this->tmp_data['title'][]=array('password','','10','left');

		$this->data_fields['master']=$this->tmp_data;
		
		$this->_set_ACTION('edit');
		$this->_SET_PRIVILEGE('tombol_quit', false);
		$this->_SET_PRIVILEGE('tombol_save_quit', false);
		
		
		$js= script_tag(plugin_url("strongpass/strongpass.js"));
		$this->template->append_metadata($js);
	}
	
	public function index()
	{	
		$this->__edit($this->authentication->get_Info_User('identifier'));
	}
	
	function postData_SOURCE_UPDATE(){
		$result=$this->data->get_data($this->authentication->get_Info_User('identifier'),$this->tmp_data);
		return $result;
	}
	
	
	function POST_UPDATE_HANDLE($new_data, $old_data){
		
		$result=true;
		// cek field kosong
		if(!empty($new_data['data']['l_password'])){

			// cek sama
			if ($new_data['data']['l_password'] === $new_data['data']['l_passwordc']){
				$cek = checkPassword($new_data['data']['l_password'], $errors);
				if($cek){
					$errorMessage = implode('<br>', $cek);
					$this->session->set_userdata('result_proses_error', $errorMessage);
					$result = false;
				}else{
					$result = $this->authentication->change_password($new_data['data']['l_password'], '', $old_data['l_id']);
					$this->session->set_userdata('result_proses', 'Data berhasil diedit');
					$result = true;
				}
				
			}else{
				$this->session->set_userdata('result_proses_error', 'Password tidak sama');
				$result = false;
			}
		}else{
			$this->session->set_userdata('result_proses_error', 'Field tidak boleh kosong');
			$result = false;
		}
		return $result;
	}

	
	function POST_UPDATE_REDIRECT_URL($url){
		$url = base_url($this->_Snippets_['modul']);
		return $url;
	}
}