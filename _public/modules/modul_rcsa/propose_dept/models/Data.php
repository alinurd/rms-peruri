<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
    {
        parent::__construct();
		$this->arr_Result=array();
	}

	function get_data_risk_register($id){
		$rows = $this->db->where('id', $id)->get(_TBL_RCSA)->row_array();
		$sts=false;
		$ket="";
		if ($rows){
			if ($rows['sts_propose']==1){
				$ket = "Assessment Masih dalam proses Approve di KaDep!!<br/>Tanggal Propose : ".date('d M Y', strtotime($rows['date_propose']));
				$sts=true;
				
			}elseif ($rows['sts_propose']==2){
				$ket = "Assessment Masih dalam proses Approve di KaDiv!!<br/>Tanggal Propose : ".date('d M Y', strtotime($rows['date_propose_kadep']));
				$sts=true;	
			}elseif ($rows['sts_propose']==3){
				$ket = "Assessment Masih dalam proses Approve di Admin RISK!!<br/>Tanggal Propose : ".date('d M Y', strtotime($rows['date_propose_kadiv']));
				$sts=true;	
			}elseif ($rows['sts_propose']==4){
				$ket = "Assessment Sudah selesai di Aproved Admin RISK pada tanggal ".date('d M Y', strtotime($rows['date_propose_admin']));
				$sts=true;
			}
		}
		$hasil['field']=$ket;
		if (!$sts){
			$rows = $this->db->where('rcsa_no', $id)->where('urgensi_no', 0)->where('type', 1)->get(_TBL_VIEW_REGISTER)->result_array();
			// echo $this->db->last_query();
			foreach($rows as &$row){
				$arrCouse = json_decode($row['risk_couse_no'],true);
				if ($arrCouse){
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
					$arrCouse=array();
					foreach($rows_couse as $rc){
						$arrCouse[]=$rc['description'];
					}
				}
				$row['couse']= implode('### ',$arrCouse);
				
				$arrCouse = json_decode($row['risk_impact_no'],true);
				if ($arrCouse){
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
					$arrCouse=array();
					foreach($rows_couse as $rc){
						$arrCouse[]=$rc['description'];
					}
				}
				$row['impact']=implode('### ',$arrCouse);
				
				$arrCouse = json_decode($row['accountable_unit'],true);
				$rows_couse=array();
				if ($arrCouse)
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
				$arrCouse=array();
				foreach($rows_couse as $rc){
					$arrCouse[]=$rc['name'];
				}
				
				$row['penanggung_jawab']=implode('### ',$arrCouse);
				
				$arrCouse = json_decode($row['penangung_no'], true);
				$rows_couse=array();
				if ($arrCouse)
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
				$arrCouse=array();
				foreach($rows_couse as $rc){
					$arrCouse[]=$rc['name'];
				}
				$row['accountable_unit_name']=implode('### ',$arrCouse);
				
				$arrCouse = json_decode($row['control_no'],true);
				if (!empty($row['note_control']))
					$arrCouse[]=$row['note_control'];
				$row['control_name']=implode(', ',$arrCouse);
				
			}
			unset($row);
			$hasil['field']=$rows;
		}
		$hasil['status']=$sts;
		// die($this->db->last_query());
		return $hasil;
	}

	public function prop($rcsa_action_no, $idx)
	{
		$this->db->set('urgensi_no', $idx)->where('id', $rcsa_action_no)->update(_TBL_RCSA_DETAIL);
		return TRUE;
	}
}

/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */