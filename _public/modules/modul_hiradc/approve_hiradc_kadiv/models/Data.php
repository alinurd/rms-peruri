<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
    {
        parent::__construct();
		$this->arr_Result=array();
	}
	
	public function get_setting($rcsa_no=0)
	{
		$this->db->select('*');
		$this->db->from(_TBL_LEVEL);
		$this->db->where('category','likelihood');
		$this->db->order_by('urut','desc');
		
		$query=$this->db->get();
		$likelihoods=$query->result_array();
		
		$result=array();
		foreach($likelihoods as $likelihood){
			$result[]=array('code'=>$likelihood['code'],'isi'=>$this->get_color($likelihood['id'], $rcsa_no));
		}
		$hasil['tbl']=$result;
		$hasil['rekap']=$this->arr_Result;
		
		$this->db->select('*');
		$this->db->from(_TBL_RCSA);
		$this->db->where('id',$rcsa_no);
		$query=$this->db->get();
		$rcsa=$query->result_array();
		
		$hasil['rcsa']=$rcsa;
		
		return $hasil;
	}
	
	function get_color($likelihood, $rcsa_no){
		$this->db->select('*');
		$this->db->from(_TBL_LEVEL);
		$this->db->where('category','impact');
		$this->db->order_by('urut','asc');
		
		$query=$this->db->get();
		$impacts=$query->result_array();
		
		$result=array();
		foreach($impacts as $key=>$impact){
			$this->db->select('*');
			$this->db->from(_TBL_LEVEL_color);
			$this->db->where('impact',$impact['id']);
			$this->db->where('likelihood',$likelihood);
			
			$query=$this->db->get();
			$colors=$query->result_array();
			foreach ($colors as $color){
				$jml=$this->cari_jml_color($impact['id'], $likelihood, $rcsa_no);
				if ($jml>0){ 
					$this->arr_Result[]=array('title'=>$color['title'],'jml'=>$jml);
					$jml="N=".$jml;
				}else{$jml="";}
				$result[]=array('jml'=>$jml,'code'=>$impact['code'],'id'=>$color['id'],'title'=>$color['title'],'color'=>$color['color']);
			}
		}
		return $result;
	}

	function get_data_risk_register($id){
		$rows = $this->db->where('rcsa_no', $id)
						 ->where('urgensi_no', 1)
						 ->get(_TBL_VIEW_REGISTER)
						 ->result_array();
		foreach($rows as &$row){
			$arrCouse = json_decode($row['risk_couse_no'],true);
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['description'];
			}
			$row['couse']= implode(', ',$arrCouse);
			
			$arrCouse = json_decode($row['risk_impact_no'],true);
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['description'];
			}
			$row['impact']=implode(', ',$arrCouse);
			
			$arrCouse = json_decode($row['penangung_no'],true);
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['name'];
			}
			$row['penangung_jawab']=implode(', ',$arrCouse);
			
			$arrCouse = json_decode($row['control_no'],true);
			$row['control_name']=implode(', ',$arrCouse);
			
		}
		unset($row);
		// die($this->db->last_query());
		return $rows;
	}
	
	function cari_jml_color($impact, $likelihood, $rcsa_no){
		$this->db->select('*');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->where('rcsa_no',$rcsa_no);
		$this->db->where('residual_impact',$impact);
		$this->db->where('residual_likelihood',$likelihood);
		
		$query=$this->db->get();
		// die($this->db->last_query());
		return $query->num_rows();
	}

	public function prop($rcsa_action_no)
	{
		$this->db->set('urgensi_no', 0)->where_in('id', $rcsa_action_no)->update(_TBL_RCSA_ACTION);
		return TRUE;
	}

}

/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */