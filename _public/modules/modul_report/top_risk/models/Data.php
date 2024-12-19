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

	function get_map_residual1($data = [])
    {
        $hasil['residual1'] = '';
        $mapping1 = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();

        // === Filter by Owner ===
        if (isset($data['id_owner']) && $data['id_owner'] > 0) {
            $this->get_owner_child($data['id_owner']);
            $this->owner_child[] = $data['id_owner'];
            $this->db->where_in('a.rcsa_owner_no', $this->owner_child);
            $this->db->where('a.urgensi_no_kadiv > 0');
        }

        // === Filter by Period ===
        if (isset($data['id_period']) && $data['id_period'] > 0) {
            $this->db->where('a.period_no', $data['id_period']);
        }

        // Validasi bulan dan bulanx
        if (isset($data['bulan']) && $data['bulan'] > 0 && isset($data['bulanx'])) {
            $this->db->where("b.bulan BETWEEN {$this->db->escape($data['bulan'])} AND {$this->db->escape($data['bulanx'])}");
        }

    $rows = $this->db->select('b.target_like as target_like, b.target_impact as target_impact, COUNT(*) as jml')
        ->from(_TBL_VIEW_RCSA_DETAIL . ' a') 
        ->join('bangga_analisis_risiko b', 'a.id = b.id_detail', 'inner') // Perbaiki alias di sini
        ->where('a.sts_propose', 4)
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
}
/* End of file app_login_model.php */
