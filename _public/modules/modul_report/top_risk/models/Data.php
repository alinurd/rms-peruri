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
		$hasil['inherent'] = '';
		$hasil['residual'] = '';

		if ($data) {
			$mapping = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();
			if ($data['id_owner'] > 0) {
				$this->get_owner_child($data['id_owner']);
				$this->owner_child[] = $data['id_owner'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$this->db->where('urgensi_no_kadiv >0');
			} else {
			}
			if ($data['id_period'] > 0) {
				$this->db->where('period_no', $data['id_period']);
			}
			$rows = $this->db->select('inherent_level, count(inherent_level) as jml')->group_by(['inherent_level'])->where('sts_propose', 4)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			// doi::dump($mapping);
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

			// residual
			$mapping = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();
			if ($data['id_owner'] > 0) {
				$this->get_owner_child($data['id_owner']);
				$this->owner_child[] = $data['id_owner'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$this->db->where('urgensi_no_kadiv >0');
			} else {
			}
			if ($data['id_period'] > 0) {
				$this->db->where('period_no', $data['id_period']);
			}
			$rows = $this->db->select('residual_level, count(residual_level) as jml')->group_by(['residual_level'])->where('sts_propose', 4)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			// doi::dump($mapping);
			$arrData = [];
			// die($this->db->last_query());
			foreach ($rows as &$ros) {
				$arrData[$ros['residual_level']] = $ros['jml'];
			}

			foreach ($mapping as &$row) {
				if (array_key_exists($row['id'], $arrData))
					$row['nilai'] = $arrData[$row['id']];
				else
					$row['nilai'] = '';
			}
			unset($row);
			$hasil['residual'] = $this->data->draw_rcsa_res($mapping);
		}
		return $hasil;
		// var_dump($hasil);
	}
	function get_data($id)
	{
		$post = $this->input->post();
		// $rows = $this->db->where('sts_propose', 4)->where('urgensi_no >', 0)->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		if ($post['owner'] > 0) {
			$rows = $this->db->where('sts_propose', 4)->where('urgensi_no >', 0)->where('owner_no', $post['owner'])->where('period_no', $post['tahun'])->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		}else {
			$rows = $this->db->where('sts_propose', 4)->where('urgensi_no >', 0)->where('period_no', $post['tahun'])->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		}
		foreach ($rows as &$row) {
			$arrCouse = json_decode($row['risk_couse_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['couse'] = implode(', ', $arrCouse);

			$arrCouse = json_decode($row['risk_impact_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['impact'] = implode(', ', $arrCouse);
		}
		unset($row);
		$hasil['combo'] = $this->load->view('detail_data', ['data' => $rows], true);

		echo json_encode($hasil);
		
	}
}
/* End of file app_login_model.php */
