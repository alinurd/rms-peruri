<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	var $nm_tbl='';
	var $nm_tbl_user='';
	var $_prefix='';
	var $_modules='';
	public function __construct()
    {
        parent::__construct();
		$this->_modules= $this->router->fetch_module();
	}
	
	function get_data_posisi_menu(){
		$this->db->select('*');
		$this->db->from(_TBL_OFFICER);
		$this->db->where('sts_owner', 1);
		$this->db->order_by('owner_no');
		$query=$this->db->get();
		$rows=$query->result_array();
		$arr_photo=array();
		foreach($rows as $pht){
			$arr_photo[$pht['owner_no']]=$pht;
		}
		
		$this->level=array();
		$this->db->select('*');
		$this->db->from(_TBL_OWNER);
		$this->db->order_by('no');
		$query=$this->db->get();
		$rows=$query->result_array();
		foreach($rows as $row){
			$tel = $row['name'];
			$photo="";
			$name="";
			if (array_key_exists($row['id'], $arr_photo)){
				$photo=$arr_photo[$row['id']]['photo'];
				$name=$arr_photo[$row['id']]['officer_name'];
			}
			
			$input[] = array("id" => $row['id'], "title" => $tel, "slug" => $row['parent_no'], "photo" => $photo, "name" => $name, "status" => $row['status'], "act" => '');
		}
		
		$result = _tree($input);
		// Doi::dump($result);die();
		return $result;
	}
	
	function get_group($iduser=0){
		$this->db->select('*');
		$this->db->from(_TBL_GROUP_USER);
		$this->db->where('user_no',$iduser);
		
		$query=$this->db->get();
		$result['field']=$query->result_array();
		return $result;
	}
	
	function get_img_file_name($id){
		$query = $this->db->select('*')
				->where('id',$id)
				->get(_TBL_USERS);
		$rows = $query->result();
		$nm='';
		foreach($rows as $row){
			$nm=$row->photo;
		}
		return $nm;
	}
	
	function save_group($newid=0,$data=array(), $img)
	{
		$now = new DateTime();
		$tgl= $now->format('Y-m-d H:i:s');
		
		if (! empty($img['file_name'])){
			$upi['photo']=$img['file_name'];
			$this->db->where('id',$newid);
			$this->db->update(_TBL_USERS,$upi);
			
			$result=$this->crud->crud_data(array('table'=>_TBL_OWNER, 'field'=>$upi,'where'=>array('id'=>$newid),'type'=>'update'));
					
		}
		
		if (isset($data['id_edit'])){
			if(count($data['id_edit'])>0){
				foreach($data['id_edit'] as $key=>$row)
				{
					$upd['group_no'] = $data['groups_id'][$key];;
					$upd['user_no'] = $newid;
					
					if(intval($data['id_edit'][$key])>0)
					{
						$upd['update_date'] = $tgl;
						$upd['update_user'] = $this->authentication->get_info_user('username');
						$this->db->where('id', $data['id_edit'][$key]);
						$this->db->update(_TBL_GROUP_USER,$upd);
						$type="update";
					}
					else
					{
						$upd['create_user'] = $this->authentication->get_info_user('username');
						$this->db->insert(_TBL_GROUP_USER,$upd);
						$type="insert";
					}
					if ($this->db->_error_message()){
						$msg="Gagal memproses data<br>".$this->db->_error_message(); 
						$sql['message']=$this->db->last_query();
						$sql['priority']=1;
						$sql['priority_name']='Gawat';
						$sql['type']=$type;
						$this->crud->save_log($sql);
						$id=0;
						return false;
					}else{
						return true;
					}
				}
			}
		}else{
			return true;
		}
	}
	
	function delete_data($id){
		$this->db->where_in('id', $id);
		$this->db->delete(_TBL_GROUP_USER);
		$jml=$this->db->affected_rows();
		return $jml;
	}
	
	function cari_total_dipakai($id){
		$this->db->where('owner_no', $id);
		$num_rows = $this->db->count_all_results(_TBL_OFFICER);
		$hasil['jml']=$num_rows;
		
		$sql=$this->db
				->select('*')
				->from(_TBL_OWNER)
				->where('id', $id)
				->get();
		
		$rows=$sql->row();
		$hasil['nama_owner'] = $rows->name;
		return $hasil;
	}
	
	function get_data_owner(){
		$sql=$this->db
				->select(_TBL_OWNER.'.id,'._TBL_OWNER.'.name, count('._TBL_OFFICER.'.id) as jml')
				->from(_TBL_OFFICER)
				->join(_TBL_OWNER, _TBL_OFFICER .'.owner_no = ' . _TBL_OWNER.'.id')
				->where(_TBL_OWNER . '.status', 1)
				->group_by(_TBL_OWNER . '.id', 1)
				->get();
		
		$rows=$sql->result();
		// die($this->db->last_query());
		$arr_owner=array();
		foreach($rows as $row){
			$arr_owner[$row->id] = $row->jml;
		}
		
		return $arr_owner;
	}
	
	function simpan_nilai($data){
		$output_data = stripslashes($data['nestable-output']);
		$rows = json_decode($output_data);
		$type='update';
		$n = 0;
		$upd=array();
		foreach($rows as $row) { 
			$n++; 
			$n1 = 0;
			$update_id = $row->id;
			$upd['parent_no']=0;
			$upd['no']=$n;
			$upd['level_no']=1;
			$upd['urut']=++$noall;
			$where['id']=$row->id;
			$result=$this->crud->crud_data(array('table'=>_TBL_OWNER, 'field'=>$upd,'where'=>$where,'type'=>$type));
			$noall=0;
			if(!empty($row->children)){
			foreach ($row->children as $vchild){ 
				$n1++; 
				$n2 = 0;
				$upd['parent_no']=$row->id;
				$upd['no']=$n1;
				$upd['level_no']=2;
				$upd['urut']=++$noall;
				$where['id']=$vchild->id;
				// Doi::dump($upd);
				$result=$this->crud->crud_data(array('table'=>_TBL_OWNER, 'field'=>$upd,'where'=>$where,'type'=>$type));
				if(!empty($vchild->children)){
				foreach ($vchild->children as $vchild1){ 
					$n2++; 
					$n3 = 0;
					$upd['parent_no']=$vchild->id;
					$upd['no']=$n2;
					$upd['level_no']=3;
					$upd['urut']=++$noall;
					$where['id']=$vchild1->id;
					// Doi::dump($upd);
					$result=$this->crud->crud_data(array('table'=>_TBL_OWNER, 'field'=>$upd,'where'=>$where,'type'=>$type));
					if(!empty($vchild1->children)){
					foreach ($vchild1->children as $vchild2){ 
						$n3++; 
						$n4 = 0;
						$upd['parent_no']=$vchild1->id;
						$upd['no']=$n3;
						$upd['level_no']=4;
						$upd['urut']=++$noall;
						$where['id']=$vchild2->id;
						// Doi::dump($upd);
						$result=$this->crud->crud_data(array('table'=>_TBL_OWNER, 'field'=>$upd,'where'=>$where,'type'=>$type));
						if(!empty($vchild2->children)){
						foreach ($vchild2->children as $vchild3){ 
							$n4++;
							$n5=0;
							$upd['parent_no']=$vchild2->id;
							$upd['no']=$n4;
							$upd['level_no']=5;
							$upd['urut']=++$noall;
							$where['id']=$vchild3->id;
							// Doi::dump($upd);
							$result=$this->crud->crud_data(array('table'=>_TBL_OWNER, 'field'=>$upd,'where'=>$where,'type'=>$type));
							if(!empty($vchild3->children)){
							foreach ($vchild3->children as $vchild4){ 
								$n5++;
								$n6=0;
								$upd['parent_no']=$vchild3->id;
								$upd['no']=$n5;
								$upd['level_no']=6;
								$upd['urut']=++$noall;
								$where['id']=$vchild4->id;
								// Doi::dump($upd);
								$result=$this->crud->crud_data(array('table'=>_TBL_OWNER, 'field'=>$upd,'where'=>$where,'type'=>$type));
							}
							}
						}
						}
					}
					}
				}
				}
			}
			}
		}
		return TRUE ;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */