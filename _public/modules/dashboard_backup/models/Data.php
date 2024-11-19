<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model
{
	public function __construct()
	{
		parent::__construct();
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
 
 
	function get_map_residual1($data = [])
	{
		$hasil['residual1'] = '';

		// doi::dump($data);
		if ($data) {

			$mapping1 = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();

			if ($data['id_owner'] > 0) {
				$this->get_owner_child($data['id_owner']);
				$this->owner_child[] = $data['id_owner'];
				$this->db->where_in('owner_no', $this->owner_child);
				$this->db->where('urgensi_no_kadiv >0');
			} else {
				// $this->db->where('urgensi_no >0');
			}
			if ($data['id_period'] > 0){
				$this->db->where('period_no', $data['id_period']);

			}			
			if ($data['bulan'] > 0){
				$this->db->where('bulan', $data['bulan']);
			}

			$rows = $this->db->select('MAX(rcsa_no) AS rcsa_no,MAX(create_date) AS create_date, risk_level_action, COUNT(risk_level_action) AS jml')
				->group_by('risk_level_action')
				->order_by('create_date', 'desc')
				->where('sts_propose', 4)
				->where('urgensi_no ', 0)
				->get(_TBL_VIEW_RCSA_ACTION_DETAIL)
				->result_array();

			$arrData1 = [];
			$groupedData1 = [];
			foreach ($rows as $row) {
				$rcsa_no = $row['rcsa_no'];
				if (!isset($groupedData1[$rcsa_no]) || $row['create_date'] > $groupedData1[$rcsa_no]['create_date']) {
					$groupedData1[$rcsa_no] = $row;
				}
			}

			foreach ($groupedData1 as $ros) {
				$arrData1[$ros['risk_level_action']] = $ros['jml'];
			}

			foreach ($mapping1 as &$row) {
				if (array_key_exists($row['id'], $arrData1))
					$row['nilai'] = $arrData1[$row['id']];
				else
					$row['nilai'] = '';
			}
			unset($row);
			$hasil['residual1'] = $this->data->draw_rcsa1($mapping1, 'residual1');


			// $hasil['bulan'] = $data['bulan'];
		}

		// doi::dump($hasil);
		// var_dump($hasil);
		return $hasil;
	}
	function get_map_residual2($data = [])
	{
		$hasil['residual2'] = '';

		// doi::dump($data);
		if ($data) {

			$mapping1 = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();

			if ($data['id_owner'] > 0) {
				$this->get_owner_child($data['id_owner']);
				$this->owner_child[] = $data['id_owner'];
				$this->db->where_in('owner_no', $this->owner_child);
				$this->db->where('urgensi_no_kadiv >0');
			} else {
				// $this->db->where('urgensi_no >0');
			}
			if ($data['id_period'] > 0){
				$this->db->where('period_no', $data['id_period']);

			}			
			if ($data['bulanx'] > 0){
				$this->db->where('bulan', $data['bulanx']);
			}

			$rows = $this->db->select('MAX(rcsa_no) AS rcsa_no,MAX(create_date) AS create_date, risk_level_action, COUNT(risk_level_action) AS jml')
				->group_by('risk_level_action')
				->order_by('create_date', 'desc')
				->where('sts_propose', 4)
				->where('urgensi_no ', 0)
				->get(_TBL_VIEW_RCSA_ACTION_DETAIL)
				->result_array();

			$arrData1 = [];
			$groupedData1 = [];
			foreach ($rows as $row) {
				$rcsa_no = $row['rcsa_no'];
				if (!isset($groupedData1[$rcsa_no]) || $row['create_date'] > $groupedData1[$rcsa_no]['create_date']) {
					$groupedData1[$rcsa_no] = $row;
				}
			}

			foreach ($groupedData1 as $ros) {
				$arrData1[$ros['risk_level_action']] = $ros['jml'];
			}

			foreach ($mapping1 as &$row) {
				if (array_key_exists($row['id'], $arrData1))
					$row['nilai'] = $arrData1[$row['id']];
				else
					$row['nilai'] = '';
			}
			unset($row);
			$hasil['residual2'] = $this->data->draw_rcsa1($mapping1, 'residual2');


			// $hasil['bulan'] = $data['bulan'];
		}

		// doi::dump($hasil);
		// var_dump($hasil);
		return $hasil;
	}
 


	function get_notif($param = array())
	{
		$level = -1;
		$data = [0];
		if (array_key_exists('level_no', $param['owner']))
			$level = $param['owner']['level_no'];
		if ($param['owner_child'])
			$data = explode(",", $param['owner_child']);

		$link = '';
		if ($level == 3) {
			$rows = $this->db->where_in('owner_no', $data)->where('period_no', _TAHUN_NO_)->where('sts_propose', 2)->get(_TBL_RCSA)->result_array();
			$link = '<a href="' . base_url('approve-div') . '"> disini </a>';
		} elseif ($level == 4) {
			$rows = $this->db->where_in('owner_no', $data)->where('period_no', _TAHUN_NO_)->where('sts_propose', 1)->get(_TBL_RCSA)->result_array();
			$link = '<a href="' . base_url('propose-div') . '"> disini </a>';
		} else {
			$rows = [];
		}

		$ket = "";
		if ($rows) {
			$ket = "Anda memiliki list Assessment yang perlu di Approve, klik " . $link . " untuk melihat ";
		}

		return $ket;
	}

	function get_rcsa_detail($id)
	{
		$query = $this->db
			->select(_TBL_RCSA_ACTION . '.*,' . _TBL_RCSA . '.id as id_rcsa,'  . _TBL_RCSA . '.judul_assesment,' . _TBL_STATUS_ACTION . '.status_action,' . _TBL_STATUS_ACTION . '.span')
			->from(_TBL_RCSA_ACTION)
			->join(_TBL_RCSA_DETAIL, _TBL_RCSA_ACTION . '.rcsa_detail_no = ' . _TBL_RCSA_DETAIL . '.id')
			->join(_TBL_RCSA, _TBL_RCSA_DETAIL . '.rcsa_no = ' . _TBL_RCSA . '.id')
			->join(_TBL_STATUS_ACTION, _TBL_RCSA_ACTION . '.status_no = ' . _TBL_STATUS_ACTION . '.id')
			->where('rcsa_no', $id)
			->order_by(_TBL_RCSA_ACTION . '.create_date desc')
			->get()
			->result();

		return $query;
	}
	function get_master_level($filter = false, $id = 0)
	{
		// doi::dump($id);
		if ($filter) {
			$rows = $this->db
				->select(_TBL_LEVEL_MAPPING . '.*,' . _TBL_LEVEL_COLOR . '.id as id_color,' . _TBL_LEVEL_COLOR . '.likelihood,' . _TBL_LEVEL_COLOR . '.impact')
				->from(_TBL_LEVEL_COLOR)
				->where(_TBL_LEVEL_COLOR . '.id', $id)
				->join(_TBL_LEVEL_MAPPING, _TBL_LEVEL_COLOR . '.level_risk_no = ' . _TBL_LEVEL_MAPPING . '.id')
				->get()
				->row_array();
		} else {
			$query = $this->db
				->select(_TBL_LEVEL_MAPPING . '.*,' . _TBL_LEVEL_COLOR . '.id as id_color,' . _TBL_LEVEL_COLOR . '.likelihood,' . _TBL_LEVEL_COLOR . '.impact')
				->from(_TBL_LEVEL_COLOR)
				->join(_TBL_LEVEL_MAPPING, _TBL_LEVEL_COLOR . '.level_risk_no = ' . _TBL_LEVEL_MAPPING . '.id')
				->get();
			$rows = json_encode($query->result_array());
		}
		// var_dump($rows);die();
		return $rows;
	}

	function get_task($owner_no = 0)
	{
		$rows['tipe'] = '';
		// $a = $this->id_param_owner['privilege_owner']['id'] ;
		// var_dump($a);
		$group = $this->authentication->get_Info_User('group');
		// if ($group['privilege_owner']['id']>=2){
		// 	$this->set_Where_Table($tbl,$field,'in',$group['owner_child']);
		// }
		if ($this->id_param_owner['privilege_owner']['id'] > 1) {
			// if ($group['privilege_owner']['id'] > 1) {
			// $a = $this->db->where('parent_no',$owner_no)->get(_TBL_OWNER)->result();
			// var_dump($a);
			$query = $this->db
				// ->where('approve_kadep', $owner_no)
				// ->where('user_approve', 1)
				// ->where_in('owner_no', $this->id_param_owner['owner_child'])
				->where_in('owner_no', $this->id_param_owner['owner_child_array'])
				// ->where_in('owner_no', $group['owner_child'])
				->where('sts_propose', 1)
				// ->where('user_approve_kadep', NULL)
				->get(_TBL_VIEW_RCSA)->result();
			$rows['tipe'] = 'propose-div';


			if (!$query) {
				$query = $this->db
					// ->where('approve_kadiv', $owner_no)
					// ->where('user_approve_kadep', $owner_no)
					// ->where('user_approve', 1)
					->where_in('owner_no', $this->id_param_owner['owner_child_array'])
					// ->where_in('owner_no', $group['owner_child'])
					->where('sts_propose', 2)
					->get(_TBL_VIEW_RCSA)->result();
				$rows['tipe'] = 'approve-div';
				// var_dump($owner_no);
			}
			if (!$query) {
				$rows['tipe'] = 'approve-admin';
				$query = $this->db
					// ->where('approve_rm', $owner_no)
					->where('sts_propose', 3)
					->get(_TBL_VIEW_RCSA)->result();
			}
			$rows['propose'] = $query;
			$query = $this->db
				// ->where_in('owner_no', $this->id_param_owner['owner_child_array'])
				->where_in('owner_no', $this->id_param_owner['owner_child_array'])
				// ->where_in('owner_no', $group['owner_child'])
				->where_not_in('status', 3)
				->where('sts_propose >=', 3)
				->where('period_no', _TAHUN_NO_)
				->order_by('create_date desc')
				->get(_TBL_VIEW_RCSA);


			// $query = $this->db
			// ->select(_TBL_RCSA_ACTION . '.*,' . _TBL_RCSA . '.id as id_rcsa,' . _TBL_RCSA . '.corporate,' . _TBL_STATUS_ACTION . '.status_action,' . _TBL_STATUS_ACTION . '.span')
			// ->from(_TBL_RCSA_ACTION)
			// ->join(_TBL_RCSA_DETAIL, _TBL_RCSA_ACTION .'.rcsa_detail_no = ' . _TBL_RCSA_DETAIL . '.id')
			// ->join(_TBL_RCSA, _TBL_RCSA_DETAIL .'.rcsa_no = ' . _TBL_RCSA . '.id')
			// ->join(_TBL_STATUS_ACTION, _TBL_RCSA_ACTION .'.status_no = ' . _TBL_STATUS_ACTION . '.id')
			// ->where_in(_TBL_RCSA . '.owner_no',$this->id_param_owner['owner_child_array'])
			// ->where_not_in('status_no',3)
			// ->where('sts_propose >=',3)
			// ->order_by(_TBL_RCSA_ACTION . '.create_date desc')
			// ->get();

			$rows['action'] = $query->result();
		} else {

			$query = $this->db
				->where('sts_propose<=3')
				// ->where('sts_propose>=1')
				->where('sts_propose>=0')
				->where('date_propose !=0')
				->get(_TBL_VIEW_RCSA);
			$rows['propose'] = $query->result();

			$query = $this->db
				->where_not_in('status', 3)
				->where('sts_propose >=', 3)
				->where('period_no', _TAHUN_NO_)
				->order_by('create_date desc')
				->get(_TBL_VIEW_RCSA);

			// $query = $this->db
			// ->select(_TBL_RCSA_ACTION . '.*,' . _TBL_RCSA . '.id as id_rcsa,'  . _TBL_RCSA . '.corporate,'. _TBL_STATUS_ACTION . '.status_action,' . _TBL_STATUS_ACTION . '.span')
			// ->from(_TBL_RCSA_ACTION)
			// ->join(_TBL_RCSA_DETAIL, _TBL_RCSA_ACTION .'.rcsa_detail_no = ' . _TBL_RCSA_DETAIL . '.id')
			// ->join(_TBL_RCSA, _TBL_RCSA_DETAIL .'.rcsa_no = ' . _TBL_RCSA . '.id')
			// ->join(_TBL_STATUS_ACTION, _TBL_RCSA_ACTION .'.status_no = ' . _TBL_STATUS_ACTION . '.id')
			// ->where_not_in('status_no',3)
			// ->where('sts_propose>=',3)
			// ->order_by(_TBL_RCSA_ACTION . '.create_date desc')
			// ->get();
			$rows['action'] = $query->result();

			$rows['log'] = $this->db->order_by('create_date', 'desc')->limit(10)->get(_TBL_LOG_PROPOSE)->result_array();
		}

		$query = $this->db->where('sticky', '1')->where('status', 1)->get(_TBL_NEWS);
		$rows['news'] = $query->result();
		$query = $this->db->where('tipe_no', 81)->where('status', 1)->order_by('create_date', 'ASC')->get(_TBL_REGULASI);
		$rows['regulasi'] = $query->result();

		//Doi::dump($rows);
		return $rows;
	}
 
	function get_news($id)
	{
		$rows = $this->db->where('id', $id)->get(_TBL_NEWS)->row();
		return $rows;
	}
}
/* End of file app_login_model.php */
