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
			$hasil['inherent'] = $this->data->draw_rcsa_unit($mapping);

			 
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
