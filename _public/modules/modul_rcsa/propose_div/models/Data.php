<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->arr_Result = array();
	}

	function cari_total_dipakai($id)
	{
		$rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_RCSA_SASARAN)->result_array();
		$result['sasaran'] = [];
		foreach ($rows as $row) {
			$result['sasaran'][$row['rcsa_no']] = $row['jml'];
		}
		$rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$result['peristiwa'] = [];
		foreach ($rows as $row) {
			$result['peristiwa'][$row['rcsa_no']] = $row['jml'];
		}

		return $result;
	}
	function get_data_tanggal($id_rcsa)
	{

		$rows = $this->db->where('rcsa_no', $id_rcsa)->where('keterangan', 'Approve Risk Assessment')->order_by('create_date', 'DESC')->get(_TBL_LOG_PROPOSE, 1)->result_array();
		return $rows;
	}
	function get_data_parent($owner_no)
	{

		$rows = $this->db->select('parent_no')->where('id', $owner_no)->get(_TBL_OWNER)->result_array();
		return $rows;
	}

	function get_peristiwa($rcsa_no)
	{
		$rows = $this->db->where('rcsa_no', $rcsa_no)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$idArr = [];
		foreach ($rows as $row) {
			$idArr[] = $row['id'];
		}
		if ($idArr) {
			$this->db->where_in('rcsa_detail_no', $idArr);
		}
		$rows_tmp = $this->db->select('rcsa_detail_no, count(id) as jml')->group_by('rcsa_detail_no')->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
		$arrMitigasi = [];
		foreach ($rows_tmp as $row) {
			$arrMitigasi[$row['rcsa_detail_no']] = $row['jml'];
		}

		if ($idArr) {
			$this->db->where_in('rcsa_detail_no', $idArr);
		}
		$rows_tmp = $this->db->select('rcsa_detail_no, count(id) as jml')->group_by('rcsa_detail_no')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		$arrRealisasi = [];
		foreach ($rows_tmp as $row) {
			$arrRealisasi[$row['rcsa_detail_no']] = $row['jml'];
		}

		$peristiwa = [];
		foreach ($rows as $row) {
			$peristiwa[$row['sasaran_no']][$row['id']] = $row;
			$jmlMitigasi = 0;
			$jmlRealisasi = 0;
			if (array_key_exists($row['id'], $arrMitigasi)) {
				$jmlMitigasi = $arrMitigasi[$row['id']];
			}
			if (array_key_exists($row['id'], $arrRealisasi)) {
				$jmlRealisasi = $arrRealisasi[$row['id']];
			}
			$peristiwa[$row['sasaran_no']][$row['id']]['jml_mitigasi'] = $jmlMitigasi;
			$peristiwa[$row['sasaran_no']][$row['id']]['jml_realisasi'] = $jmlRealisasi;
		}
		$rows = $this->db->where('rcsa_no', $rcsa_no)->get(_TBL_RCSA_SASARAN)->result_array();
		$sasaran = [];
		foreach ($rows as $row) {
			$sasaran[$row['id']]['nama'] = $row['sasaran'];
			if (array_key_exists($row['id'], $peristiwa)) {
				$sasaran[$row['id']]['detail'] = $peristiwa[$row['id']];
			} else {
				$sasaran[$row['id']]['detail'] = [];
			}
		}

		return $sasaran;
	}

	function get_data_divisi($parent_no)
	{

		$a = $parent_no[0]['parent_no'];
		$b = "1700";

		if ($a == 0) {
			$rows = $this->db->select('name')->where('id', $b)->get(_TBL_OWNER)->row();
		} else {
			$rows = $this->db->select('name')->where('id', $a)->get(_TBL_OWNER)->row();
		}
		return $rows;
		// var_dump($rows);
	}
	function get_data_officer($id_rcsa)
	{
		$rows = $this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->result_array();
		return $rows;
	}
	function get_data_risk_reg_acc($id)
	{
		$rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		foreach ($rows as &$row) {
			$arrCouse = json_decode($row['risk_couse_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['couse'] = implode('### ', $arrCouse);

			$arrCouse = json_decode($row['risk_impact_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['impact'] = implode('### ', $arrCouse);

			$arrCouse = json_decode($row['inherent_impact'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LEVEL)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['code'];
			}
			// var_dump($arrCouse);
			// $row['impact']=implode('### ',$arrCouse);
			$row['code_impact'] = $arrCouse;

			$arrCouse = json_decode($row['control_no'], true);
			if (!empty($row['note_control']))
				$arrCouse[] = $row['note_control'];
			// $row['control_name']=implode(', ',$arrCouse);
			$row['control_name'] = implode('###', $arrCouse);
		}
		unset($row);

		return $rows;
	}

	function get_data_risk_register($data = 0)
	{
		// $rows = $this->db->where_in('owner_no', $data)->where('period_no', _TAHUN_NO_)->where('sts_propose > 1')->get(_TBL_RCSA)->result_array();
		$this->db->where('id', $data);
		$rows = $this->db->where('sts_propose', 1)->get(_TBL_RCSA)->result_array();
		$sts = false;
		$sts_propose = 1;
		$tgl_propose = date('Y-m-d');
		$tgl_propose_kadiv = date('Y-m-d');
		$ket = "";
		$hasil['field'] = [];
		foreach ($rows as $row) {
			$sts_propose = $row['sts_propose'];
			$tgl_propose = $row['date_propose_kadep'];
			$tgl_propose_kadiv = $row['date_approve_kadiv'];
		}

		if ($rows) {
			if ($sts_propose == 2) {
				$ket = "Assessment Masih dalam proses Approve di KaDiv!!<br/>Tanggal Propose : " . date('d M Y', strtotime($tgl_propose));
				$sts = true;
			} elseif ($sts_propose == 3) {
				$ket = "Assessment  periode tahun <span class='label label-primary'> " . _TAHUN_ . " </span>  sudah selesai di Aproved Kadiv pada tanggal " . date('d M Y', strtotime($tgl_propose_kadiv));
				$sts = true;
			}
		}
		$hasil['field'] = $ket;
		if (!$sts) {

			//$rows = $this->db->where_in('owner_no', $data)->where('urgensi_no <> 0')->where('period_no', _TAHUN_NO_)->where('type', 1)->where('sts_propose',1)->get(_TBL_VIEW_REGISTER)->result_array();
			// $this->db->where_in('owner_no', $data)-

			// $rows = $this->db->where('rcsa_no', 97)
			// ->where('type', 1)
			// ->where('sts_propose', 1)
			// ->group_by('id_rcsa_detail')
			// ->get(_TBL_VIEW_REGISTER)->result_array();

			$query = $this->db->select('id_rcsa_detail, MAX(proaktif) as proaktif')
			->where('rcsa_no', $data)
			->where('type', 1)
			->where('sts_propose', 1)
			->group_by('id_rcsa_detail')
			->get(_TBL_VIEW_REGISTER)->result_array();

			// if ($query === false) {
			// 	$error = $this->db->error();
			// 	print_r($error);
			// } else {
			// 	$result = $query->result_array();
			// 	print_r($result);
			// }


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
					// $row['control_name']=implode(', ',$arrCouse);
					$row['control_name'] = implode('###', $arrCouse);
				}
				unset($row);
				$hasil['field'] = $rows;
			} else {
				$hasil['field'] = "Belum ada Assessment yang Propose!";
				$sts = true;
			}
		}
		$hasil['status'] = $sts;
		// die($this->db->last_query());
		return $hasil;
	}

	public function prop($rcsa_action_no, $idx)
	{

		$this->db->set('urgensi_no_kadep', $idx)->where('id', $rcsa_action_no)->update(_TBL_RCSA_DETAIL);
		return TRUE;
	}
}

/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */