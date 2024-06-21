<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function get_library($id=0, $key=2){
		$this->db->select(_TBL_LIBRARY.'.*, '._TBL_LIBRARY_DETAIL.'.child_no, '._TBL_LIBRARY_DETAIL.'.id as edit_no');
		$this->db->from(_TBL_LIBRARY_DETAIL);
		$this->db->join(_TBL_LIBRARY, _TBL_LIBRARY_DETAIL . '.child_no='. _TBL_LIBRARY . '.id');
		$this->db->where(_TBL_LIBRARY_DETAIL . '.library_no',$id);
		$this->db->where(_TBL_LIBRARY . '.type',$key);
		
		$query=$this->db->get();
		$result['field']=$query->result_array();
		// Doi::dump($this->db->last_query());die();
		return $result;
	}
	function save_map_event($newid = 0, $data = array(), $tipe = 1, $mode = 'new', $old_data = array())
	{

		// doi::dump($newid);
		// doi::dump($data);
		// die('cek');
		if (count($data['l_kategori_risiko']) > 0) {
			foreach ($data['l_kategori_risiko'] as $key => $row) {
				$upd = array();
				$upd['library_no'] = $newid;;
				$upd['event_no	'] = $data['library_no'][$key];;
				if (intval($data['id_edit'][$key]) > 0) {

					$upd['update_date'] = Doi::now();
					$upd['update_user'] = $this->authentication->get_info_user('username');
					$result = $this->crud->crud_data(array('table' => 'bangga_map_kelevent', 'field' => $upd, 'where' => array('id' => $data['id_edit'][$key]), 'type' => 'update'));
				} else {
					$upd['create_user'] = $this->authentication->get_info_user('username');
					$result = $this->crud->crud_data(array('table' => 'bangga_map_kelevent', 'field' => $upd, 'type' => 'add'));
				}
			}
		}
		
		return true;
	}
	function save_library($newid=0,$data=array(), $tipe=1, $mode='new', $old_data=array())
	{
		// var_dump($data);
		// die();
		$updf['id'] = $newid;
		$upd['type'] = $tipe;
		$tgl=Doi::now();
		// Doi::dump($old_data);
		// Doi::dump($data);die();
		
		if ($mode=='[new]'){
			$upd['code'] = $this->cari_code_library($data, $tipe);


		}
		elseif($mode=='edit'){
			// if ($data['l_risk_type_no'] !== $old_data['l_risk_type_no']){
				// $upd['code'] = $this->cari_code_library($data, $tipe); 
			// }
		}
		$this->db->update(_TBL_LIBRARY,$upd,$updf);
		
		if (isset($data['id_edit']))
		{
			if(count($data['id_edit'])>0)
			{
				if (count($data['library_no'])>0)
				{
					foreach($data['library_no'] as $key=>$row)
					{
					$upd=array();
					$upd['library_no'] = $newid;;
					$upd['child_no'] = $data['library_no'][$key];;
					$upd['kategori_risiko'] = $data['l_kategori_risiko'];;
					
					if(intval($data['id_edit'][$key])>0)
						{

						$upd['update_date'] = $tgl;
						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_LIBRARY_DETAIL, 'field'=>$upd,'where'=>array('id'=>$data['id_edit'][$key]),'type'=>'update'));
						}
					else
						{
						$upd['create_user'] = $this->authentication->get_info_user('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_LIBRARY_DETAIL, 'field'=>$upd,'type'=>'add'));
						}
					}
				}
				
				if (count($data['new_cause'])>0) 
				{
					foreach($data['new_cause'] as $key=>$row)
					{
						
						$tipe1 = 2;
						$upd_cause['description'] = $row;
						$upd_cause['risk_type_no'] = 0;
						$upd_cause['type'] = $tipe1;
						$data['l_risk_type_no'] = 0;
						$upd_cause['code'] = $this->cari_code_library($data, $tipe1);
						$upd_cause['create_user'] = $this->authentication->get_info_user('username');

						$result1=$this->crud->crud_data(array('table'=>_TBL_LIBRARY, 'field'=>$upd_cause,'type'=>'add'));

						if ($result1 != NULL) 
						{
						$upa=array();
						$upa['library_no'] = $newid;;
						$upa['child_no'] = $result1;;
						$upa['kategori_risiko'] = $data['l_kategori_risiko'];;


						if(intval($data['new_cause'][$key])>0)
							{
						$upa['update_date'] = $tgl;
						$upa['update_user'] = $this->authentication->get_info_user('username');
						$result1=$this->crud->crud_data(array('table'=>_TBL_LIBRARY_DETAIL, 'field'=>$upa,'where'=>array('id'=>$data['id_edit'][$key]),'type'=>'update'));
							}
						else
							{
						$upa['create_user'] = $this->authentication->get_info_user('username');

						$resul1=$this->crud->crud_data(array('table'=>_TBL_LIBRARY_DETAIL, 'field'=>$upa,'type'=>'add'));
							}
						}	
					}
				}
				if (count($data['new_impact'])>0) 
				{
					foreach($data['new_impact'] as $key=>$row)
					{
						$tipe2 = 3;
						$upd_impact['description'] = $row;
						$upd_impact['type'] = 3;
						$upd_impact['risk_type_no'] = 0;
						$data['l_risk_type_no'] = 0;
						$upd_impact['code'] = $this->cari_code_library($data, $tipe2);
						$upd_impact['create_user'] = $this->authentication->get_info_user('username');
						
						$result2=$this->crud->crud_data(array('table'=>_TBL_LIBRARY, 'field'=>$upd_impact,'type'=>'add'));
						if ($result2 != NULL) 
						{
						$upi=array();
						$upi['library_no'] = $newid;;
						$upi['child_no'] = $result2;;
							$upi['kategori_risiko'] = $data['l_kategori_risiko'];;

						if(intval($data['new_cause'][$key])>0)
							{
						$upi['update_date'] = $tgl;
						$upi['update_user'] = $this->authentication->get_info_user('username');
						$result2=$this->crud->crud_data(array('table'=>_TBL_LIBRARY_DETAIL, 'field'=>$upi,'where'=>array('id'=>$data['id_edit'][$key]),'type'=>'update'));
							}
						else
							{
						$upi['create_user'] = $this->authentication->get_info_user('username');

						$result2=$this->crud->crud_data(array('table'=>_TBL_LIBRARY_DETAIL, 'field'=>$upi,'type'=>'add'));
							}
						}	
					}
				}		
			}
		}		
		return true;
	}
	
	function cari_total_dipakai($id){
		$this->db->where('library_no', $id);
		$this->db->where('type', 2);
		$num_rows = $this->db->count_all_results(_TBL_VIEW_LIBRARY);
		$hasil['jmlCouse']=$num_rows;
		
		$this->db->where('library_no', $id);
		$this->db->where('type', 3);
		$num_rows = $this->db->count_all_results(_TBL_VIEW_LIBRARY);
		$hasil['jmlImpact']=$num_rows;
		
		$sql=$this->db
				->select('*')
				->from(_TBL_LIBRARY)
				->where('id', $id)
				->get();
		
		$rows=$sql->row();
		$hasil['nama_lib'] = $rows->description;
		return $hasil;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */