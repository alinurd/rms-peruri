<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Officer extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		$this->load->helper('file');
		$this->data_group=$this->data->get_group(-1);
		$this->data_group=$this->data_group['field'];
		$this->cbo_posisi = $this->get_combo('posisi');
		$this->cbo_owner = $this->get_combo('parent-input');
		$this->cbo_group = $this->get_combo('user');
		$this->data_user=array('id'=>0, 'username'=>'');
		
		$this->set_Tbl_Master(_TBL_OFFICER);
		$this->set_Tbl_Master_Child(_TBL_OFFICER);
		$this->set_Table(_TBL_OWNER);
		$this->set_Table(_TBL_POSISI);
		$this->set_Table(_TBL_USERS);
		
		$this->cbo_parent = $this->get_combo('parent');
		$this->data->set_officer_data();
		$this->arr_officer=$this->data->get_officer_data();
		
		$this->set_Open_Tab('Data Owner');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			if ($this->_Preference_['list_photo']==1)
				$this->addField(array('field'=>'photo', 'input'=>'upload', 'path'=>'staft', 'file_thumb'=>true));
			
			$this->addField(array('field'=>'owner_no', 'input'=>'combo:search', 'combo'=>$this->cbo_owner, 'search'=>true, 'size'=>100));
			$this->addField(array('field'=>'officer_name', 'search'=>true, 'required'=>true, 'size'=>50));
			$this->addField(array('field'=>'nip', 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'position_no', 'input'=>'combo', 'combo'=>$this->cbo_posisi, 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'address', 'input'=>'multitext', 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'phone', 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'ext', 'search'=>true, 'size'=>10));
			$this->addField(array('field'=>'mobile', 'search'=>true, 'size'=>10));
			$this->addField(array('field'=>'email', 'search'=>true, 'size'=>15));
			$this->addField(array('field'=>'fax', 'search'=>true, 'size'=>10));
			$this->addField(array('field'=>'user_name', 'type'=>'free', 'title' => 'Username', 'search'=>true, 'size'=>20));
			$this->addField(array('field'=>'sandi', 'title'=>'Kata Sandi','type'=>'free', 'input'=>'pass', 'size'=>20));
			$this->addField(array('field'=>'sandic','title'=>'Konfirmasi Kata Sandi', 'type'=>'free', 'input'=>'pass', 'size'=>20));
			$this->addField(array('field'=>'user',  'type'=>'free','search'=>true, 'size'=>50));
			$this->addField(array('field'=>'status','input'=>'boolean', 'size'=>50));
			$this->addField(array('field'=>'user_no', 'show'=>false));
			$this->addField(array('field'=>'sts_owner','title' => 'Status Owner', 'input'=>'boolean', 'size'=>50));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'owner_no','sp'=>$this->tbl_owner,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'position_no','sp'=>$this->tbl_posisi,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'id','sp'=>$this->tbl_users,'id_sp'=>'officer_no', 'left'));
		
		$this->addField(array('nmtbl'=>$this->tbl_owner, 'field'=>'name', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_posisi, 'field'=>'posisi', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_users, 'field'=>'username', 'size'=>20, 'show'=>false));
		
		$this->set_Accordion(array('field'=>'user_name', 'label'=>'AUTHENTICATION'));
		
		$this->set_Sort_Table($this->tbl_master,'nip');
		
		if ($this->_Preference_['list_photo']==1)
			$this->set_Table_List($this->tbl_master,'photo','Photo',0,'center', true, true);
		
		$this->set_Table_List($this->tbl_owner,'name','Risk Owner');
		$this->set_Table_List($this->tbl_master,'nip');
		$this->set_Table_List($this->tbl_master,'officer_name');
		$this->set_Table_List($this->tbl_users,'username');
		$this->set_Table_List($this->tbl_posisi,'posisi');
		$this->set_Table_List($this->tbl_master,'user');
		$this->set_Table_List($this->tbl_master,'status','','','center');
		
		if ($this->id_param_owner['privilege_owner']['id']>1)
			$this->set_Where_Table($this->tbl_master,'id','in',$this->id_param_owner['owner_child']);		
		
		$this->set_Close_Setting();
		
		$js= script_tag(plugin_url("strongpass/strongpass.js"));
		$this->template->append_metadata($js);
	}
	
	function printBox_USER($row, $value){
		return $value;
	}
	
	function subDelete_PROCESSOR($id){
		$result = $this->data->delete_data($id['iddel']);
		return $result;
	}
	
	function listBox_USER($row, $value){
		$group='';
		$no=0;
		foreach($this->data_group as $dg){
			if ($dg['user_no']==$row['l_user_no']){
				if($no==0)
					$group .= $dg['group_name'];
				else
					$group .= "/" . $dg['group_name'];
				++$no;
			}
		}
		return $group;
	}
	
	function insertBox_USER_NAME($field){
		$content = form_input($field['label'],' '," size='{$field['size']}' class='form-control'  id='{$field['label']}'");
		return $content;
	}
	
	function insertBox_USER($field){
		return $this->user_group();
		
	}
	
	function updateBox_USER($field, $row, $value){
		return $this->user_group($row);
	}
	
	function user_group($param=[])
	{
		$id=0;
		if ($param)
			$id=$param['l_user_no'];
		// $id=intval($this->uri->segment(3));
		// $data_user=$this->data->cari_data_users($id);
		// $id=0;
		// if ($data_user){
			// $id=$data_user['id'];
		// }
		$data=$this->data->get_group($id);

		$data['angka']="10";
		$data['cbogroup']=$this->get_combo('groups');
		$result=$this->load->view('groups',$data,true);
		return $result;
	}
	
	function updateBox_USER_NAME($field, $row, $value){
		$this->data_user=$this->data->cari_data_users($row['l_id']);
		$users='';
		$id=0;
		if ($this->data_user){
			$users=$this->data_user['username'];
			$id=$this->data_user['id'];
		}
		$content = form_input($field['label'],$users," size='{$field['size']}' class='form-control'  id='{$field['label']}'");
		$content .= form_hidden(array($field['label'].'_old'=>$users));
		$content .= form_hidden(array('id_users'=>$id));
		// echo $content;
		// Doi::dump($row);die();
		return $content;
	}
	
	function listBox_PHOTO($row, $value){
		// $id=$row['l_id'];
		// $nf=$this->data->get_img_file_name($id);
		$o='';
		if (!empty($value))
			$o=show_image($value,160, 50);
		return $o;
	}
	
	function isi_photo(){
		$id=intval($this->uri->segment(3));
		
		$o = '
		<script type="text/javascript">
				function showMyImage(fileInput) {
			        var files = fileInput.files;
			        for (var i = 0; i < files.length; i++) {           
			            var file = files[i];
			            var imageType = /image.*/;     
			            if (!file.type.match(imageType)) {
			                continue;
			            }           
			            var img=document.getElementById("thumbnil");            
			            img.file = file;    
			            var reader = new FileReader();
			            reader.onload = (function(aImg) { 
			                return function(e) { 
			                    aImg.src = e.target.result; 
			                }; 
			            })(img);
			            reader.readAsDataURL(file);
			        }    
			    }
		</script>';
		
		$nmfile=$this->data->get_img_file_name($id);
		$o .= '<img id="thumbnil" style="width:40%; margin-top:10px;"  src="'.staft_url($nmfile).'" alt="image"/>';
		$o .=form_upload("img_profile",'','onchange="showMyImage(this)"');
		return $o;;
	}
	
	function POST_CHECK_BEFORE_INSERT($data){
		$result = true;
		$cek_user = $this->authentication->username_check($data['l_user_name']);
		$errors =array();
		if (!$cek_user){
			$errors[] = "User Name telah terdaftar";
		}
		
		if (!empty($data['l_sandi']) && !empty($data['l_sandic'])){
			if ($data['l_sandi'] == $data['l_sandic']){
				checkPassword($data['l_sandi'], $errors);
			}else{
				$errors[] = "Password tidak sama!";
			}
		}
		if (count($errors)>0){
			foreach($errors as $err){
				$this->_set_pesan($err);
			}
			$result = false;
		}
		// Doi::dump($errors);
		// die("hasilnya ".$result);
		return $result;
	}
	
	function POST_CHECK_BEFORE_UPDATE($new_data, $old_data){
		$result=true;
		$cek_user=true;
		if ($new_data['l_user_name'] !== $old_data['l_username']){
			$cek_user = $this->authentication->username_check($new_data['l_user_name']);
		}
		
		$errors =array();
		if (!$cek_user){
			$errors[] = "User Name telah terdaftar";
		}
		
		if (!empty($new_data['l_sandi']) && !empty($new_data['l_sandic'])){
			if ($new_data['l_sandi'] == $new_data['l_sandic']){
				checkPassword($new_data['l_sandi'], $errors);
			}else{
				$errors[] = "Password tidak sama!";
			}
		}
		if (count($errors)>0){
			foreach($errors as $err){
				$this->_set_pesan($err);
			}
			$result = false;
		}
		
		return $result;
	}
	
	function POST_DELETE_PROCESSOR($id){
		$rows = $this->crud->crud_data(array('table'=>_TBL_USERS, 'where_in'=>array('id'=>'officer_no', 'value'=>$id),'type'=>'delete'));
		return true;
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$result=true;
		$password ='';
		$this->data->set_sts_save('add');
		if (!empty($new_data['l_sandi'])){
			$password = $this->authentication->get_password($new_data['l_sandi']);
		}
		$result_img=array();
		if ($result && !empty($_FILES['img_profile']['name'])){
			$result_img = upload_image('img_profile', $new_data);
		}
		
		$result = $this->data->save_login($id , $new_data, $result_img, $password);
		
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		// Doi::dump($new_data);
		$result=true;
		$password ='';
		if (isset($new_data['id_users']))
			$this->data->set_sts_save('edit');
		else
			$this->data->set_sts_save('add');
		
		if (!empty($new_data['l_sandi']))
			$password = $this->authentication->change_password($new_data['l_sandi'], "officer_no", $id);
			
		$result=$this->data->save_login($id , $new_data, $result_img, "");
		
		// die($password);
		$result_img=array();
		if ($result && !empty($_FILES['img_profile']['name'])){
			$result_img=upload_image('img_profile', $new_data);
		}
		
		return $result;
	}
}