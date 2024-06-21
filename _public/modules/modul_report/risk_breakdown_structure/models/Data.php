<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}
	function get_data_parent($owner){

		$rows = $this->db->select('parent_no')->where('id', $owner)->get(_TBL_OWNER)->result_array();
		return $rows;
	}
	function get_data_tanggal($id){

		$rows = $this->db->where('rcsa_no', $id)->where('keterangan', 'Approve Risk Assessment')->order_by('create_date','DESC')->get(_TBL_LOG_PROPOSE,1)->result_array();
		return $rows;
	}
	function get_data_divisi($parent_no){

		$a = $parent_no[0]['parent_no'];
		$b = "1700";
		
		if ($a == 0) {
			$rows = $this->db->select('name')->where('id', $b)->get(_TBL_OWNER)->row();
		}else{
			$rows = $this->db->select('name')->where('id', $a)->get(_TBL_OWNER)->row();
		}
		return $rows;
		// var_dump($rows);
	}
	
	function cari_total_dipakai($id){
		$rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_RCSA_SASARAN)->result_array();
		$result['sasaran']=[];
		foreach($rows as $row){
			$result['sasaran'][$row['rcsa_no']]=$row['jml'];
		}

		$rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_RCSA_DETAIL)->result_array();
		$result['peristiwa']=[];
		foreach($rows as $row){
			$result['peristiwa'][$row['rcsa_no']]=$row['jml'];
		}

		return $result;
	}
		function get_data_ishikawa($id_rcsa){

		$rows = $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		return $rows;
	}
		function get_data_officer($id_rcsa){
		$rows = $this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->result_array();
		return $rows;
	}

	
	function get_data_risk_ishikawa($id_rcsa){
		$rows = $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$arrCouse=array();
		$owner_no=array();
		// $owner_name=array();
		$sasaran=array();
		$event=array();
		foreach($rows as $key => $rc){
			if (!in_array($rc['owner_no'], $owner_no)) {
				$haha=[];

				foreach ($rows as $key1 => $value1) {
					if (!in_array($value1['sasaran_no'], $sasaran)) {
							$haha[]=$value1['sasaran'];
					}
					$event[]=[
						'sasaran'=>$value1['sasaran'],
						
						'kategori'=>$value1['kategori'],
						'risiko'=>$value1['event_name']
					];
					$sasaran[]=$value1['sasaran_no'];
				}
				$arrCouse[]=[
				'name'=>$rc['name'],
				'periode'=>$rc['periode_name'],
				'judul'=>$rc['judul_assesment'],
				'sasaran'=>$haha,
				'event'=>$event

				];
			}
			$owner_no[]=$rc['owner_no'];
			
			

		}	
	
// var_dump($arrCouse);
		return $arrCouse;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */