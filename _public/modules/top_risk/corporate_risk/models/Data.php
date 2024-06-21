<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model
{
	public function __construct()
	{
		parent::__construct();
		// _TBL_RCSA_DETAIL="rcsa_detail";
	}

	function get_map_rcsa($data = [])
	{
		$hasil['inherent']='';
		$hasil['residual']='';
		
		if ($data) {
			$mapping = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();
			if ($data['id_owner'] > 0) {
				$this->get_owner_child($data['id_owner']);
				$this->owner_child[] = $data['id_owner'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$this->db->where('urgensi_no_kadiv >0');
			} else {
				$this->db->where('urgensi_no >0');
			}
			if ($data['id_period'] > 0)
				$this->db->where('period_no', $data['id_period']);
			// if ($data['bulan'] > 0)
			// 	$this->db->where('bulan', $data['bulan']);

			$rows = $this->db->select('inherent_level, count(inherent_level) as jml')->group_by(['inherent_level'])->where('sts_propose', 4)->where('urgensi_no >', 0)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			$arrData = [];
			// die($this->db->last_query());
			foreach ($rows as &$ros) {
				$arrData[$ros['inherent_level']] = $ros['jml'];
			}

			foreach ($mapping as &$row) {
				if (array_key_exists($row['id'], $arrData))
					$row['nilai'] = $arrData[$row['id']];
				else
					$row['nilai'] = '';
			}
			unset($row);
			$hasil['inherent'] = $this->data->draw_rcsa($mapping);
			
			$mapping = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();
			
			if ($data['id_owner'] > 0) {
				$this->get_owner_child($data['id_owner']);
				$this->owner_child[] = $data['id_owner'];
				$this->db->where_in('owner_no', $this->owner_child);
				// $this->db->where('urgensi_no_kadiv >0');
			} else {
				// $this->db->where('urgensi_no >0');
			}
			if ($data['id_period'] > 0)
				$this->db->where('period_no', $data['id_period']);
			if ($data['bulan'] > 0)
				$this->db->where('bulan', $data['bulan']);
			
			// $rows = $this->db->select('risk_level, count(risk_level) as jml')->group_by(['risk_level'])->where('sts_propose', 4)->where('urgensi_no >', 0)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			$rows = $this->db->select('risk_level_action, count(risk_level_action) as jml')->group_by(['risk_level_action'])->where('sts_propose', 4)->where('urgensi_no >', 0)->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			
			$arrData = [];
			// die($this->db->last_query());
			foreach ($rows as &$ros) {
				$arrData[$ros['risk_level_action']] = $ros['jml'];
			}

			foreach ($mapping as &$row) {
				if (array_key_exists($row['id'], $arrData))
					$row['nilai'] = $arrData[$row['id']];
				else
					$row['nilai'] = '';
			}
			unset($row);
			$hasil['residual'] = $this->data->draw_rcsa($mapping, 'residual');

		}
		return $hasil;
		// var_dump($hasil);
	}
}
/* End of file app_login_model.php */
