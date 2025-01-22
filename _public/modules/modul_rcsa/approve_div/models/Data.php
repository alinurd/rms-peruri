<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function get_data_tanggal($id_rcsa){

		$rows = $this->db->where('rcsa_no', $id_rcsa)->where('keterangan', 'Approve Risk Assessment')->order_by('create_date','DESC')->get(_TBL_LOG_PROPOSE,1)->result_array();
		return $rows;
	}
	function get_data_parent($owner_no){

		$rows = $this->db->select('parent_no')->where('id', $owner_no)->get(_TBL_OWNER)->result_array();
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
	function get_data_officer($id_rcsa){
		$rows = $this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->result_array();
		return $rows;
	}
	function get_data_risk_reg_acc($id){
		 $rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		 foreach($rows as &$row){
			$arrCouse = json_decode($row['risk_couse_no'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[] = $rc['description'];
			}
			$row['couse']= implode('### ',$arrCouse);
			
			$arrCouse = json_decode($row['risk_impact_no'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['description'];
			}
			$row['impact']=implode('### ',$arrCouse);

			$arrCouse = json_decode($row['inherent_impact'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LEVEL)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['code'];
			}
			// var_dump($arrCouse);
			// $row['impact']=implode('### ',$arrCouse);
			$row['code_impact']=$arrCouse;

			$arrCouse = json_decode($row['control_no'],true);
			if (!empty($row['note_control']))
				$arrCouse[]=$row['note_control'];
			// $row['control_name']=implode(', ',$arrCouse);
			$row['control_name']=implode('###',$arrCouse);

		}
		unset($row);

		return $rows;
	}

	function cari_total_dipakai($id){
		$rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_RCSA_SASARAN)->result_array();
		$result['sasaran']=[];
		foreach($rows as $row){
			$result['sasaran'][$row['rcsa_no']]=$row['jml'];
		}

		$rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$result['peristiwa']=[];
		foreach($rows as $row){
			$result['peristiwa'][$row['rcsa_no']]=$row['jml'];
		}

		return $result;
	}
	// function get_data_risk_register($id, $x)
	// {
	// 	// $rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
	// 	if($x=="approval"){
	// 		$rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_REGISTER)->result_array();
	// 	}else{
	// 		$rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
	// 	}

	// 	// $rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_REGISTER)->result_array();
	// 	// doi::dump($rows)
	// 	//$rows = $this->db->where('rcsa_no', $id)->group_by('id_rcsa_detail')->order_by('urgensi_no_kadiv')->get(_TBL_VIEW_REGISTER)->result_array();

	// 	foreach ($rows as &$row) {
	// 		$arrCouse = json_decode($row['risk_couse_no'], true);

	// 		$rows_couse = array();
	// 		if ($arrCouse)
	// 			$arrCouse_implode = implode(", ", $arrCouse);
	// 		$rows_couse  = $this->db->query("SELECT * FROM bangga_library WHERE id IN ($arrCouse_implode) ORDER BY FIELD(id, $arrCouse_implode)")->result_array(); //$this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
	// 		$arrCouse = array();
	// 		foreach ($rows_couse as $rc) {
	// 			$arrCouse[] = $rc['description'];
	// 		}
	// 		$row['couse'] = implode('### ', $arrCouse);

	// 		$arrCouse = json_decode($row['risk_impact_no'], true);
	// 		$rows_couse = array();
	// 		if ($arrCouse)
	// 			$arrCouse_implode = implode(", ", $arrCouse);
	// 		$rows_couse =  $this->db->query("SELECT * FROM bangga_library WHERE id IN ($arrCouse_implode) ORDER BY FIELD(id, $arrCouse_implode)")->result_array();  //$this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
	// 		$arrCouse = array();
	// 		foreach ($rows_couse as $rc) {
	// 			$arrCouse[] = $rc['description'];
	// 		}
	// 		$row['impact'] = implode('### ', $arrCouse);

	// 		$arrCouse = json_decode($row['accountable_unit'], true);
	// 		$rows_couse = array();
	// 		if ($arrCouse)
	// 			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
	// 		$arrCouse = array();
	// 		foreach ($rows_couse as $rc) {
	// 			$arrCouse[] = $rc['name'];
	// 		}
	// 		$row['accountable_unit_name'] = implode('### ', $arrCouse);


	// 		$arrCouse = json_decode($row['penangung_no'], true);
	// 		$rows_couse = array();
	// 		if ($arrCouse)
	// 			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
	// 		$arrCouse = array();
	// 		foreach ($rows_couse as $rc) {
	// 			$arrCouse[] = $rc['name'];
	// 		}
	// 		$row['penanggung_jawab'] = implode('### ', $arrCouse);

	// 		$arrCouse = json_decode($row['control_no'], true);
	// 		if (!empty($row['note_control']))
	// 			$arrCouse[] = $row['note_control'];
	// 		// $row['control_name']=implode(', ',$arrCouse);
	// 		$row['control_name'] = implode('###', $arrCouse);
	// 	}
	// 	unset($row);

	// 	return $rows;
	// }

	function get_data_risk_register($id)
	{
		$rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		// $rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_REGISTER)->result_array();
		// doi::dump($rows)
		//$rows = $this->db->where('rcsa_no', $id)->group_by('id_rcsa_detail')->order_by('urgensi_no_kadiv')->get(_TBL_VIEW_REGISTER)->result_array();

		foreach ($rows as &$row) {
			$arrCouse = json_decode($row['risk_couse_no'], true);
			
			$rows_couse = array();
			if ($arrCouse)
			
				$arrCouse_implode = implode(", ", $arrCouse);
			$rows_couse  = $this->db->query("SELECT * FROM bangga_library WHERE id IN ($arrCouse_implode) ORDER BY FIELD(id, $arrCouse_implode)")->result_array(); //$this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['couse'] = implode('### ', $arrCouse);

			$arrCouse = json_decode($row['risk_impact_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$arrCouse_implode = implode(", ", $arrCouse);
			$rows_couse =  $this->db->query("SELECT * FROM bangga_library WHERE id IN ($arrCouse_implode) ORDER BY FIELD(id, $arrCouse_implode)")->result_array();  //$this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['impact'] = implode('### ', $arrCouse);

			$arrCouse = json_decode($row['accountable_unit'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['name'];
			}
			$row['accountable_unit_name'] = implode('### ', $arrCouse);


			$arrCouse = json_decode($row['penangung_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['name'];
			}
			$row['penanggung_jawab'] = implode('### ', $arrCouse);

			// $arrCouse = json_decode($row['control_no'], true);
			// $arrCouse = json_decode($row['risk_impact_no'], true);
			if (!empty($row['note_control']))
				$arrCouse =json_decode($row['note_control'], true);
			$row['control_name'] = implode('### ', $arrCouse);
		}
		unset($row);

		return $rows;
	}


	function get_data_risk_register_($data = 0)
	{
		$this->db->where('id', $data);
		$rows = $this->db->where('sts_propose >=2')->get(_TBL_RCSA)->result_array();
		$sts = false;
		$hasil['jml_propose'] = count($rows);
		$this->db->where('id', $data);
		$rows = $this->db->where('sts_propose', 3)->get(_TBL_RCSA)->result_array();
		$sts_propose = 1;
		$tgl_propose = date('Y-m-d');
		$tgl_propose_kadiv = date('Y-m-d');
		$ket = "";
		foreach ($rows as $row) {
			$sts_propose = $row['sts_propose'];
			$tgl_propose = $row['date_propose_kadep'];
			$tgl_propose_kadiv = $row['date_approve_kadiv'];
		}
		// doi::dump($sts_propose);

		if ($rows) {
			if ($sts_propose == 4) {
				$ket = "Semua Assessment periode tahun <span class='label label-primary'> " . _TAHUN_ . " </span> Sudah selesai di Aproved pada tanggal " . date('d M Y', strtotime($tgl_propose_kadiv));
				$sts = true;
			}
		} else {
			 
			$hasil['field'] = 'Belum ada Assessment yang Propose <br> <a href="' . base_url('approve-div') . '" class="btn btn-default" style="text-decoration: none;">Kembali Ke list</a>';
		}

		$hasil['field'] = $ket;
		if (!$sts) {
			// $rows = $this->db->where_in('owner_no', $data)->where('urgensi_no <> 0')->where('period_no', _TAHUN_NO_)->where('sts_propose',2)->get(_TBL_VIEW_REGISTER)->result_array();
			$this->db->where('rcsa_no', $data);
			$rows = $this->db->where('sts_propose', 3)->get(_TBL_VIEW_REGISTER)->result_array();
			// die($this->db->last_query());
			if (count($rows) > 0) {
				foreach ($rows as &$row) {
					$arrCouse = json_decode($row['risk_couse_no'], true);
					if ($arrCouse) {
						$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
						$arrCouse = array();
						foreach ($rows_couse as $rc) {
							$arrCouse[] = $rc['description'];
						}
					}
					$row['couse'] = implode('### ', $arrCouse);

					$arrCouse = json_decode($row['risk_impact_no'], true);
					if ($arrCouse) {
						$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
						$arrCouse = array();
						foreach ($rows_couse as $rc) {
							$arrCouse[] = $rc['description'];
						}
					}
					$row['impact'] = implode('### ', $arrCouse);

					$arrCouse = json_decode($row['accountable_unit'], true);
					$rows_couse = array();
					if ($arrCouse)
						$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
					$arrCouse = array();
					foreach ($rows_couse as $rc) {
						$arrCouse[] = $rc['name'];
					}

					$row['penanggung_jawab'] = implode('### ', $arrCouse);

					$arrCouse = json_decode($row['penangung_no'], true);
					$rows_couse = array();
					if ($arrCouse)
						$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
					$arrCouse = array();
					foreach ($rows_couse as $rc) {
						$arrCouse[] = $rc['name'];
					}
					$row['accountable_unit_name'] = implode('### ', $arrCouse);

					$arrCouse = json_decode($row['control_no'], true);
					if (!empty($row['note_control']))
						$arrCouse[] = $row['note_control'];
					$row['control_name'] = implode(', ', $arrCouse);
				}
				unset($row);
				$hasil['field'] = $rows;
				// Doi::dump($rows);die();
			} else {
				$hasil['field'] = 'Belum ada Assessment yang Propose <br> <a href="' . base_url('approve-div') . '" class="btn btn-default" style="text-decoration: none;">Kembali Ke list</a>';
				$sts = true;
			}
		}
		$hasil['status'] = $sts;
		// die($this->db->last_query());
		return $hasil;
	}

	public function prop($rcsa_action_no, $idx)
	{

		$this->db->set('urgensi_no_kadiv', $idx)->where('id', $rcsa_action_no)->update(_TBL_RCSA_DETAIL);
		return true;
	}
}

/* End of file app_login_model.php */
