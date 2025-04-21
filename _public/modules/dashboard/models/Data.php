<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // === Get RCSA Mapping ===
    function filter($data = []){
		if ($data['id_owner'] > 0) {
			$this->get_owner_child($data['id_owner']);
			$this->owner_child[] = $data['id_owner'];
			$this->db->where_in('owner_no', $this->owner_child);
		}
 
		if ($data['id_period'] > 0) {
			$this->db->where('period_no', $data['id_period']);
		}
	}

	function get_map_rcsa($data = [])
	{
		$hasil['inherent'] = '';
		$hasil['residual'] = '';
	
		if ($data) {
			$mapping = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();
	
			// Filter berdasarkan owner jika ada
			$this->filter($data);
			$rows1 = $this->db->select('residual_likelihood, residual_impact, COUNT(*) as jml, norut')
				->from(_TBL_VIEW_RCSA_DETAIL)
				->where('sts_propose', 4)
				->where('sts_heatmap', '1')
				->group_by(['residual_likelihood', 'residual_impact', 'norut'])
				->get()
				->result_array();
	
			$arrData1 = [];
			$arrData2 = [];
			$arrData3 = [];
	
			foreach ($rows1 as $ros) {
				if (isset($ros['residual_likelihood'], $ros['residual_impact'])) {
					$key1 = $ros['residual_likelihood'] . '-' . $ros['residual_impact'];
	
					if (!isset($arrData1[$key1])) {
						$arrData1[$key1] = [
							'jml' => 0,
							'norut' => []
						];
					}
					$arrData1[$key1]['jml'] += (int) $ros['jml'];
					// Tambahkan norut ke array sesuai dengan jumlah jml
        for ($i = 0; $i < (int) $ros['jml']; $i++) {
            $arrData1[$key1]['norut'][] = $ros['norut'];
        }
				}
			}
			//  doi::dump($data);
			$this->filter($data);
			$this->db->where('bulan', $data['bulan']);
			$rows2 = $this->db->select('MAX(rcsa_no) AS rcsa_no, MAX(create_date) AS create_date, risk_level_action, COUNT(risk_level_action) AS jml, norut, residual_likelihood_action, residual_impact_action')
                 ->order_by('create_date', 'desc')
                ->where('sts_propose', 4)
                ->where('urgensi_no', 0)
				->where('sts_heatmap', '1')
				->group_by(['risk_level_action', 'norut','residual_impact_action', 'residual_likelihood_action' ])
                ->get(_TBL_VIEW_RCSA_ACTION_DETAIL)
                ->result_array();

				
			foreach ($rows2 as $ros) {
				if (isset($ros['residual_likelihood_action'], $ros['residual_impact_action'])) {
					$key2 = $ros['residual_likelihood_action'] . '-' . $ros['residual_impact_action'];
	
					if (!isset($arrData2[$key2])) {
						$arrData2[$key2] = [
							'jml' => 0,
							'norut' => []
						];
					}
					$arrData2[$key2]['jml'] += (int) $ros['jml'];
					$arrData2[$key2]['norut'][] = $ros['norut'];
				}
			}
	
			 
			$this->filter($data);
			$rows3 = $this->db->select('b.target_like, b.target_impact, COUNT(*) as jml, a.norut')
				->from(_TBL_VIEW_RCSA_DETAIL . ' a')
				->join('bangga_analisis_risiko b', 'a.id = b.id_detail', 'inner')
				->where('a.sts_propose', 4)
				->where('b.bulan', 12)
				->where('a.sts_heatmap', '1')
				->group_by(['b.target_like', 'b.target_impact', 'a.norut'])
				->get()
				->result_array();
	
			foreach ($rows3 as $ros) {
				if (isset($ros['target_like'], $ros['target_impact'])) {
					$key3 = $ros['target_like'] . '-' . $ros['target_impact'];
	
					if (!isset($arrData3[$key3])) {
						$arrData3[$key3] = [
							'jml' => 0,
							'norut' => []
						];
					}
					$arrData3[$key3]['jml'] += (int) $ros['jml'];
					$arrData3[$key3]['norut'][] = $ros['norut'];
				}
			}
	  
	
			// === Update Mapping with Values ===
			foreach ($mapping as &$row) {
				if (isset($row['like_no'], $row['impact_no'])) {
					$key = $row['like_no'] . '-' . $row['impact_no'];
					 
	
					$row['nilai_1'] = isset($arrData1[$key]) ? implode(', ', $arrData1[$key]['norut']) : '';
					$row['nilai_2'] = isset($arrData2[$key]) ? implode(', ', $arrData2[$key]['norut']) : '';
					$row['nilai_3'] = isset($arrData3[$key]) ? implode(', ', $arrData3[$key]['norut']) : '';
 				}
			}
			unset($row);
	
			$hasil['inherent'] = $this->data->draw_rcsa_unit($mapping, 'Inherent');
			$hasil['current'] = $this->data->draw_rcsa_unit($mapping, 'Current');
			$hasil['residual'] = $this->data->draw_rcsa_unit($mapping, 'Residual');
		}
	
		// doi::dump($hasil);
		return $hasil;
	}

    // === Get Notification ===
    function get_notif($param = array())
    {
        $level = -1;
        $data = [0];
        if (array_key_exists('level_no', $param['owner'])) {
            $level = $param['owner']['level_no'];
        }
        if ($param['owner_child']) {
            $data = explode(",", $param['owner_child']);
        }

        $link = '';
        if ($level == 3) {
            $rows = $this->db->where_in('owner_no', $data)
                ->where('period_no', _TAHUN_NO_)
                ->where('sts_propose', 2)
                ->get(_TBL_RCSA)
                ->result_array();
            $link = '<a href="' . base_url('approve-div') . '"> disini </a>';
        } elseif ($level == 4) {
            $rows = $this->db->where_in('owner_no', $data)
                ->where('period_no', _TAHUN_NO_)
                ->where('sts_propose', 1)
                ->get(_TBL_RCSA)
                ->result_array();
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

    // === Get RCSA Detail ===
    function get_rcsa_detail($id)
    {
        $query = $this->db
            ->select(_TBL_RCSA_ACTION . '.*,' . _TBL_RCSA . '.id as id_rcsa,' . _TBL_RCSA . '.judul_assesment,' . _TBL_STATUS_ACTION . '.status_action,' . _TBL_STATUS_ACTION . '.span')
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

	function cek_level_new($like, $impact)
	{
		$rows = $this->db->where('impact_no', $impact)->where('like_no', $like)->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
        
		// doi::dump($rows);
        return $rows;
	}

	public function level_action($like, $impact)
	{
		// doi::dump($like);
		// doi::dump($impact);
		$result['like'] = $this->db
			->where('id', $like)
 			->get('bangga_level')->row_array();

		$result['impact'] = $this->db
			->where('id', $impact)
 			->get('bangga_level')->row_array();

		return $result;

	}

    // === Get Master Level ===
    function get_master_level($filter = false, $id = 0)
    {
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

        return $rows;
    }

    // === Get Task ===
    function get_task($owner_no = 0)
    {
        $rows['tipe'] = '';
        $group = $this->authentication->get_Info_User('group');

        if ($this->id_param_owner['privilege_owner']['id'] > 1) {
            $query = $this->db
                ->where_in('owner_no', $this->id_param_owner['owner_child_array'])
                ->where('sts_propose', 1)
                ->get(_TBL_VIEW_RCSA)
                ->result();
            $rows['tipe'] = 'propose-div';

            if (!$query) {
                $query = $this->db
                    ->where_in('owner_no', $this->id_param_owner['owner_child_array'])
                    ->where('sts_propose', 2)
                    ->get(_TBL_VIEW_RCSA)
                    ->result();
                $rows['tipe'] = 'approve-div';
            }

            if (!$query) {
                $rows['tipe'] = 'approve-admin';
                $query = $this->db
                    ->where('sts_propose', 3)
                    ->get(_TBL_VIEW_RCSA)
                    ->result();
            }

            $rows['propose'] = $query;
            $query = $this->db
                ->where_in('owner_no', $this->id_param_owner['owner_child_array'])
                ->where_not_in('status', 3)
                ->where('sts_propose >=', 3)
                ->where('period_no', _TAHUN_NO_)
                ->order_by('create_date desc')
                ->get(_TBL_VIEW_RCSA);
            $rows['action'] = $query->result();
        } else {
            $query = $this->db
                ->where('sts_propose <= 3')
                ->where('sts_propose >= 0')
                ->where('date_propose != 0')
                ->get(_TBL_VIEW_RCSA);
            $rows['propose'] = $query->result();

            $query = $this->db
                ->where_not_in('status', 3)
                ->where('sts_propose >=', 3)
                ->where('period_no', _TAHUN_NO_)
                ->order_by('create_date desc')
                ->get(_TBL_VIEW_RCSA);
            $rows['action'] = $query->result();
            $rows['log'] = $this->db->order_by('create_date', 'desc')->limit(10)->get(_TBL_LOG_PROPOSE)->result_array();
        }

        $query = $this->db->where('sticky', '1')->where('status', 1)->get(_TBL_NEWS);
        $rows['news'] = $query->result();

        $query = $this->db->where('tipe_no', 81)->where('status', 1)->order_by('create_date', 'ASC')->get(_TBL_REGULASI);
        $rows['regulasi'] = $query->result();

        return $rows;
    }

    // === Get News ===
    function get_news($id)
    {
        $rows = $this->db->where('id', $id)->get(_TBL_NEWS)->row();
        return $rows;
    }
}

/* End of file model/Data.php */
