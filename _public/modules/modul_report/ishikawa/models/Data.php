<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
    var $post = [];

	public function __construct()
    {
        parent::__construct();
	}


    function grafik(){
        $result=[];
        $rcsa_no = $this->post['risk_context'];
        $rows=$this->db->where('rcsa_no',$rcsa_no)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$idArr=[];
		foreach($rows as $row){
			$idArr[]=$row['id'];
		}
		if ($idArr){
			$this->db->where_in('rcsa_detail_no',$idArr);
		}
		$rows_tmp = $this->db->select('rcsa_detail_no, count(id) as jml')->group_by('rcsa_detail_no')->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
		$arrMitigasi=[];
		foreach($rows_tmp as $row){
			$arrMitigasi[$row['rcsa_detail_no']]=$row['jml'];
		}

		if ($idArr){
			$this->db->where_in('rcsa_detail_no',$idArr);
		}
		$rows_tmp = $this->db->select('rcsa_detail_no, count(id) as jml')->group_by('rcsa_detail_no')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		$arrRealisasi=[];
		foreach($rows_tmp as $row){
			$arrRealisasi[$row['rcsa_detail_no']]=$row['jml'];
		}

        $peristiwa =[];
		foreach($rows as $key=>$row){
			$peristiwa[$row['sasaran_no']][$key]['id']=$row['id'];
            $peristiwa[$row['sasaran_no']][$key]['name']=$row['event_name'];
			// $jmlMitigasi = 0;
			// $jmlRealisasi = 0;
			// if (array_key_exists($row['id'], $arrMitigasi)){
			// 	$jmlMitigasi = $arrMitigasi[$row['id']];
			// }
			// if (array_key_exists($row['id'], $arrRealisasi)){
			// 	$jmlRealisasi = $arrRealisasi[$row['id']];
			// }
			// $peristiwa[$row['sasaran_no']][$row['id']]['jml_mitigasi']=$jmlMitigasi;
			// $peristiwa[$row['sasaran_no']][$row['id']]['jml_realisasi']=$jmlRealisasi;
		}
		$rows=$this->db->where('rcsa_no',$rcsa_no)->get(_TBL_RCSA_SASARAN)->result_array();
		$sasaran =[];
		foreach($rows as $key => $row){
			$sasaran[$key]['id']=$row['id'];
			$sasaran[$key]['name']=$row['sasaran'];
			if (array_key_exists($row['id'], $peristiwa)){
				$sasaran[$key]['children'] = $peristiwa[$row['id']];
			}else{
				$sasaran[$key]['children'] = [];
			}
        }
        
        $result['master']=$sasaran;

        return $result;
    }
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */