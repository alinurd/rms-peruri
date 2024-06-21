<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	protected $owner;
	public function __construct()
    {
        parent::__construct();
	}
	
	function get_data_owner($id=array()){
		$sql = $this->db
				->select(_TBL_OWNER.'.name,'._TBL_OWNER.'.id,'._TBL_OWNER.'.parent_no')
				->from(_TBL_OWNER)
				->where_in(_TBL_OWNER.'.id', $id)
				->get();
		
		$rows=$sql->result_array();
		// Doi::dump($this->db->last_query());
		foreach($rows as &$row){
			$this->owner=$row['parent_no'];
			$row['child']=$this->cari_jml_child($row['id']);

			$eksposure = $this->get_eksposure_data($row['id']);
			
			$row['rata_inherent']=$eksposure->inherent;
			$row['rata_residual']=$eksposure->residual;
			$row['inherent_level_likehood']=$eksposure->inherent_level_likehood;
			$row['inherent_level_impact']=$eksposure->inherent_level_impact;
			$row['residual_level_likehood']=$eksposure->residual_level_likehood;
			$row['residual_level_impact']=$eksposure->residual_level_impact;
		}
		unset($row);
		// Doi::dump($rows);
		// arsort($rows);
		// Doi::dump($rows);
		// die();
		return $rows;
	}
	function cari_jml_child($id){
		$query = $this->db->where('parent_no', $id)->get(_TBL_OWNER);
		$rows=$query->result_array();
		return count($rows);
	}
	function get_id_owner(){
		return $this->owner;
	}
	
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */