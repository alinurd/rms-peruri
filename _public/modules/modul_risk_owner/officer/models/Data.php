<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
		$this->sts_save='';
	}
	
	function get_group($iduser=-1){
		$this->db->select(_TBL_GROUP_USER.'.*,'._TBL_GROUPS.'.group_name');
		$this->db->from(_TBL_GROUP_USER);
		$this->db->join(_TBL_GROUPS,_TBL_GROUP_USER.'.group_no='._TBL_GROUPS.'.id');
		if ($iduser>-1)
		$this->db->where(_TBL_GROUP_USER . '.user_no',$iduser);
		
		$query=$this->db->get();
		$result['field']=$query->result_array();
		return $result;
	}
	
	function cari_data_users($data){
		$query = $this->db->select('*')
				->where('officer_no',$data)
				->get(_TBL_USERS);
		$rows = $query->row();
		return (array) $rows;
	}
	
	function set_sts_save($sts){
		$this->sts_save=$sts;
	}
	
	function get_img_file_name($id){
		$query = $this->db->select('*')
				->where('id',$id)
				->get(_TBL_OFFICER);
		$rows = $query->result();
		$nm='';
		foreach($rows as $row){
			$nm=$row->photo;
		}
		return $nm;
	}
	
	function save_login($newid=0,$data=array(), $img, $pass='')
	{
		// echo $this->sts_save;
		// Doi::dump($data);die();
		$now = new DateTime();
		$tgl= $now->format('Y-m-d H:i:s');
		$upd=array();
		if (! empty($img['file_name'])){
			$upi['photo']=$img['file_name'];
			$this->db->where('id',$newid);
			$this->db->update(_TBL_OFFICER,$upi);
			$upd['photo'] = $img['file_name'];
			$photo=$img['file_name'];
		}
		
		
		if ($this->sts_save=='add' && !empty($data['l_user_name'])){
			$upd['username'] = trim($data['l_user_name']);
			if (!empty($pass))
				$upd['password'] = $pass;
			
			$upd['nama_lengkap'] = $data['l_officer_name'];
			$upd['nip'] = $data['l_nip'];
			$upd['officer_no'] = $newid;
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$id_user=$this->crud->crud_data(array('table'=>_TBL_USERS, 'field'=>$upd,'type'=>'add'));
			$result=$this->crud->crud_data(array('table'=>_TBL_OFFICER, 'field'=>['user_no'=>$id_user],'where'=>array('id'=>$newid),'type'=>'update'));
		}elseif ($this->sts_save=='edit'){
			if (!empty($data['l_user_name'])){
				$upd['username'] = trim($data['l_user_name']);
			}
			if (!empty($pass)){
				$upd['password'] = $pass;
			}
			
			$upd['nama_lengkap'] = $data['l_officer_name'];
			$upd['nip'] = $data['l_nip'];
			$upd['aktif'] = $data['l_status'];
			$upd['officer_no'] = $newid;
			$upd['update_date'] = $tgl;
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$result=$this->crud->crud_data(array('table'=>_TBL_USERS, 'field'=>$upd,'where'=>array('id'=>$data['id_users']),'type'=>'update'));
			$id_user = $data['id_users'];
		}
		
		$upd=array();
		if (isset($data['id_edit'])){
			if(count($data['id_edit'])>0){
				foreach($data['id_edit'] as $key=>$row)
				{
					$upd['group_no'] = $data['groups_id'][$key];;
					$upd['user_no'] = $id_user;
					
					if(intval($data['id_edit'][$key])>0)
					{
						$upd['update_date'] = $tgl;
						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_GROUP_USER, 'field'=>$upd,'where'=>array('id'=>$data['id_edit'][$key]),'type'=>'update'));
					}
					else
					{
						$upd['create_user'] = $this->authentication->get_Info_User('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_GROUP_USER, 'field'=>$upd,'type'=>'add'));
					}
				}
			}
		}
		
		return true;
	}
	
	function delete_data($id){
		$this->db->where('id', $id);
		$this->db->delete(_TBL_GROUP_USER);
		$jml=$this->db->affected_rows();
		$hasil['sts']=0;
		$hasil['ket']='Gagal Mengahapus';
			
		if ($jml>0){
			$hasil['sts']=$jml;
			$hasil['ket']='data berhasil dihapus';
		}
		return $hasil;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */