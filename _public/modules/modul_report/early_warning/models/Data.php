<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_data_risk_register($data = 0)
	{
		$rows = $this->db->where_in('owner_no', $data)->where('period_no', _TAHUN_NO_)->where('sts_propose >=2')->get(_TBL_RCSA)->result_array();
		$sts = false;
		$hasil['jml_propose'] = count($rows);

		$rows = $this->db->where_in('owner_no', $data)->where('period_no', _TAHUN_NO_)->where('sts_propose', 2)->get(_TBL_RCSA)->result_array();
		$sts_propose = 1;
		$tgl_propose = date('Y-m-d');
		$tgl_propose_kadiv = date('Y-m-d');
		$ket = "";
		foreach ($rows as $row) {
			$sts_propose = $row['sts_propose'];
			$tgl_propose = $row['date_propose_kadep'];
			$tgl_propose_kadiv = $row['date_approve_kadiv'];
		}

		if ($rows) {
			if ($sts_propose == 3) {
				$ket = "Semua Assessment periode tahun <span class='label label-primary'> " . _TAHUN_ . " </span> Sudah selesai di Aproved pada tanggal " . date('d M Y', strtotime($tgl_propose_kadiv));
				$sts = true;
			}
		} else {
			$ket = "Belum ada Assessment yang di propose periode tahun <span class='label label-primary'> " . _TAHUN_ . " </span> ";
			$sts = true;
		}
		$hasil['field'] = $ket;
		if (!$sts) {
			// $rows = $this->db->where_in('owner_no', $data)->where('urgensi_no <> 0')->where('period_no', _TAHUN_NO_)->where('sts_propose',2)->get(_TBL_VIEW_REGISTER)->result_array();

			$rows = $this->db->where_in('owner_no', $data)->where('period_no', _TAHUN_NO_)->where('sts_propose', 2)->get(_TBL_VIEW_REGISTER)->result_array();
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
				$hasil['field'] = "Belum ada Assessment yang Propose pada tahun periode " . _TAHUN_;
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
