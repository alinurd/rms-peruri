<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model
{
	public function __construct()
	{
		parent::__construct();
		// _TBL_RCSA_DETAIL="rcsa_detail";
	}

	function filter($data = []){
		if ($data['id_owner'] > 0) {
			$this->get_owner_child($data['id_owner']);
			$this->owner_child[] = $data['id_owner'];
			$this->db->where_in('owner_no', $this->owner_child);
		}

		// Filter berdasarkan period jika ada
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
					$arrData1[$key1]['norut'][] = $ros['norut'];
				}
			}
	
			 
			$this->filter($data);
			$rows2 = $this->db->select('b.target_like, b.target_impact, COUNT(*) as jml, a.norut')
				->from(_TBL_VIEW_RCSA_DETAIL . ' a')
				->join('bangga_analisis_risiko b', 'a.id = b.id_detail', 'inner')
				->where('a.sts_propose', 4)
				->where('b.bulan', 12)
				->where('a.sts_heatmap', '1')
				->group_by(['b.target_like', 'b.target_impact', 'a.norut'])
				->get()
				->result_array();
	
			foreach ($rows2 as $ros) {
				if (isset($ros['target_like'], $ros['target_impact'])) {
					$key2 = $ros['target_like'] . '-' . $ros['target_impact'];
	
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
			$this->db->where('bulan', $data['bulan']);
	
			$rows3 = $this->db->select('MAX(rcsa_no) AS rcsa_no, MAX(create_date) AS create_date, risk_level_action, COUNT(risk_level_action) AS jml, norut, residual_likelihood_action, residual_impact_action')
                 ->order_by('create_date', 'desc')
                ->where('sts_propose', 4)
                ->where('urgensi_no', 0)
				->group_by(['risk_level_action', 'norut','residual_impact_action', 'residual_likelihood_action' ])
                ->get(_TBL_VIEW_RCSA_ACTION_DETAIL)
                ->result_array();
	
 			
				
			foreach ($rows3 as $ros) {
				if (isset($ros['residual_likelihood_action'], $ros['residual_impact_action'])) {
					$key3 = $ros['residual_likelihood_action'] . '-' . $ros['residual_impact_action'];
	
					if (!isset($arrData2[$key3])) {
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
	
			$hasil['inherent'] = $this->data->draw_rcsa_unit($mapping);
		}
	
		return $hasil;
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
	
	public function get_child_owner($data) {
        // Memastikan $data adalah integer
        $owner_id = intval($data);

        // Melakukan query untuk mendapatkan pemilik anak
        $this->db->select('*');
        $this->db->from('bangga_owner'); // Ganti dengan nama tabel yang sesuai
        $this->db->where('parent_no', $owner_id);
        $this->db->where('status', 1); // Misalnya, hanya mengambil yang aktif

        // Menjalankan query
        $query = $this->db->get();

        // Memeriksa apakah query berhasil
        if ($query !== false) {
            return $query->result_array(); // Mengembalikan hasil sebagai array asosiatif
        } else {
            // Jika query gagal, Anda bisa menangani kesalahan di sini
            log_message('error', 'Query failed: ' . $this->db->last_query());
            return $this->db->last_query(); // Mengembalikan array kosong jika terjadi kesalahan
        }
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
}
/* End of file app_login_model.php */
