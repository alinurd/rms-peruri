<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function save_library($newid=0,$data=array(), $tipe=1, $mode='new', $old_data=array())
	{
		$updf['id'] = $newid;
		$upd['type'] = $tipe;
		if ($mode=='new'){
			$upd['code'] = $this->cari_code_library($data, $tipe);
		}
		// elseif($mode=='edit'){
		// 	if ($data['l_risk_type_no'] !== $old_data['l_risk_type_no']){
		// 		$upd['code'] = $this->cari_code_library($data, $tipe);
		// 	}
		// }
		$this->db->update("library",$upd,$updf);
		return true;
	}
	
	function cari_total_dipakai($id){
		$this->db->where('child_no', $id);
		$num_rows = $this->db->count_all_results(_TBL_LIBRARY_DETAIL);
		$hasil['jml']=$num_rows;
		
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