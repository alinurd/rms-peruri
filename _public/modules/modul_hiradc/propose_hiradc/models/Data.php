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
	
	function get_hiradc_detail($id){
		$this->db->where('hiradc_no', $id);
		$rows = $this->db->get(_TBL_VIEW_HIRADC_DETAIL)->result_array();
		return $rows;
	}
	
	function get_data_register($id){
		$rows = $this->get_hiradc_detail($id);
		$regulasi = $this->get_combo_model('regulasi');
		$arrRegulasi=array();
		foreach($regulasi as $key=>$row){
			$arrRegulasi[$key]=$row;
		}
		
		$detail = $this->db->where('hiradc_no', $id)->get(_TBL_VIEW_HIRADC_MITIGASI)->result_array();
		$mitigasi=array();
		foreach($detail as $row){
			$row['prioritas'] = json_decode($row['pertimbangan'], true);
			$mitigasi[$row['hiradc_detail_no']][]=$row;
		}
		
		foreach($rows as &$row){
			if (array_key_exists($row['id'], $mitigasi))
				$row['mitigasi'] = $mitigasi[$row['id']];
			else
				$row['mitigasi'] = array();
			
			$regs=json_decode($row['regulasi'], true);
			$isiRegulasi=array();
			foreach ($regs as $reg){
				if (array_key_exists($reg, $arrRegulasi))
					$isiRegulasi[] = $arrRegulasi[$reg];
			}
			$row['isiRegulasi'] = implode('<br/>- ', $isiRegulasi);
		}
		unset($row);
		$hasil['field'] = $rows;
		
		$rows = $this->db->where('id', $id)->get(_TBL_VIEW_HIRADC)->row_array();
		$hasil['parent'] = $rows;
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
	
	function get_map_hiradc(){
		$mapping = $this->db->get(_TBL_VIEW_MATRIK_HIRADC)->result_array();
		foreach ($mapping as &$row){
			$row['nilai']='';
		}
		unset($row);
		$mapping = $this->data->draw_hiradc($mapping);
		return $mapping;
	}
}

/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */