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
				$this->db->where_in('owner_no', $this->owner_child);
			}
			if ($data['id_period'] > 0) {
				$this->db->where('period_no', $data['id_period']);
			}
			$rows = $this->db->select('residual_likelihood, residual_impact, COUNT(*) as jml')
			->from(_TBL_VIEW_RCSA_DETAIL)
			->where('sts_propose', 4)
			->where('sts_heatmap', '1')
			->group_by(['residual_likelihood', 'residual_impact'])
			->get()
			->result_array();

			$arrData = [];
			foreach ($rows as $ros) {
                if (isset($ros['residual_likelihood'], $ros['residual_impact'])) {
					$key = $ros['residual_likelihood'] . '-' . $ros['residual_impact']; 
					$arrData[$key] = $ros['jml'];
				}
			}
			// === Update Mapping with Inherent Values ===
			foreach ($mapping as &$row) {
				// Pastikan kolom likelihood dan impact ada dalam $mapping
				if (isset($row['like_no'], $row['impact_no'])) {
					$key = $row['like_no'] . '-' . $row['impact_no']; // Gabungkan likelihood dan impact untuk mencocokkan
					$row['nilai'] = array_key_exists($key, $arrData) ? $arrData[$key] : ''; 
					
				}
			}
			unset($row);
			$hasil['inherent'] = $this->data->draw_rcsa($mapping);

			// residual
			$mapping = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();
			if ($data['id_owner'] > 0) {
                $this->get_owner_child($data['id_owner']);
				$this->owner_child[] = $data['id_owner'];
				$this->db->where_in('owner_no', $this->owner_child);
			}

			if ($data['id_period'] > 0) {
				$this->db->where('a.period_no', $data['id_period']);
			}

			// // Validasi bulan dan bulanx
			if (isset($data['bulan']) && $data['bulan'] > 0) {
				$this->db->where("b.bulan",$data['bulan']);
			}else{
				$this->db->where('b.bulan', $current_month);
			}

			$rows = $this->db->select('b.residual_likelihood_action as residual_like, b.residual_impact_action as residual_impact, COUNT(*) as jml')
			->from(_TBL_VIEW_RCSA_DETAIL . ' a') 
			->join('bangga_rcsa_action_detail b', 'a.id = b.rcsa_detail', 'inner') 
			->where('a.sts_propose', 4)
			->where('a.sts_heatmap', '1')
			->group_by(['b.residual_likelihood_action', 'b.residual_impact_action']) 
			->get()
			->result_array();
   
			$arrData = [];
			foreach ($rows as $ros) {
				if (isset($ros['residual_like'], $ros['residual_impact'])) {
					$key = $ros['residual_like'] . '-' . $ros['residual_impact'];
					$arrData[$key] = $ros['jml'];
				}
			}

			// === Update Mapping with Residual Values ===
			foreach ($mapping as &$row) {
				// Pastikan kolom likelihood dan impact ada dalam $mapping
				if (isset($row['like_no'], $row['impact_no'])) {
					$key = $row['like_no'] . '-' . $row['impact_no']; // Gabungkan likelihood dan impact untuk mencocokkan
					$row['nilai'] = array_key_exists($key, $arrData) ? $arrData[$key] : ''; 
					
				}
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
        $mapping1 = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();

        // === Filter by Owner ===
        if (isset($data['id_owner']) && $data['id_owner'] > 0) {
            $this->get_owner_child($data['id_owner']);
			$this->owner_child[] = $data['id_owner'];
			$this->db->where_in('owner_no', $this->owner_child);
        }

        // === Filter by Period ===
        if (isset($data['id_period']) && $data['id_period'] > 0) {
            $this->db->where('a.period_no', $data['id_period']);
        }

        $rows = $this->db->select('b.target_like as target_like, b.target_impact as target_impact, COUNT(*) as jml')
            ->from(_TBL_VIEW_RCSA_DETAIL . ' a') 
            ->join('bangga_analisis_risiko b', 'a.id = b.id_detail', 'inner') // Perbaiki alias di sini
            ->where('a.sts_propose', 4)
            ->where('b.bulan', 12)
            ->where('a.sts_heatmap', '1')
            ->group_by(['b.target_like', 'b.target_impact']) 
            ->get()
            ->result_array();
  
        $arrData = [];
        foreach ($rows as $ros) {

            if (isset($ros['target_like'], $ros['target_impact'])) {
                $key = $ros['target_like'] . '-' . $ros['target_impact']; // Gabungkan likelihood dan impact
                $arrData[$key] = $ros['jml'];
            }
        }

        // === Update Mapping with Inherent Values ===
        foreach ($mapping1 as &$row) {
            // Pastikan kolom likelihood dan impact ada dalam $mapping
            if (isset($row['like_no'], $row['impact_no'])) {
                $key = $row['like_no'] . '-' . $row['impact_no']; // Gabungkan likelihood dan impact untuk mencocokkan
                $row['nilai'] = array_key_exists($key, $arrData) ? $arrData[$key] : ''; 
                
            }
        }

        $hasil['residual1'] = $this->data->draw_rcsa1($mapping1, 'Target');
       
        return $hasil;
    }


	// === Get RCSA Residual 2 Mapping ===
    function get_map_residual2($data = [])
    {
        $hasil['residual2'] = '';

        if ($data) {
            // Fetching RCSA Mapping Data for Residual 2
            $mapping1 = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();

            // === Filter by Owner ===
            if ($data['id_owner'] > 0) {
                $this->get_owner_child($data['id_owner']);
                $this->owner_child[] = $data['id_owner'];
                $this->db->where_in('owner_no', $this->owner_child);
                $this->db->where('urgensi_no_kadiv > 0');
            }

            // === Filter by Period and Month ===
            if ($data['id_period'] > 0) {
                $this->db->where('period_no', $data['id_period']);
            }

            if ($data['bulanx'] > 0) {
                $this->db->where('bulan', $data['bulanx']);
            }

            // === Fetch Data for Residual 2 ===
            $rows = $this->db->select('MAX(rcsa_no) AS rcsa_no, MAX(create_date) AS create_date, risk_level_action, COUNT(risk_level_action) AS jml')
                ->group_by('risk_level_action')
                ->order_by('create_date', 'desc')
                ->where('sts_propose', 4)
                ->where('urgensi_no', 0)
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

            // === Update Residual 2 Mapping ===
            foreach ($mapping1 as &$row) {
                $row['nilai'] = array_key_exists($row['id'], $arrData1) ? $arrData1[$row['id']] : '';
            }

            $hasil['residual2'] = $this->data->draw_rcsa1($mapping1, 'residual2');
        }

        return $hasil;
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
}
/* End of file app_login_model.php */
