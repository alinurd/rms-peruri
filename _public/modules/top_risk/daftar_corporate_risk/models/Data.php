<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}
	
	function get_kategori($id){
		$this->db->select('data');
		$this->db->from(_TBL_DATA_COMBO);
		$this->db->where('id',$id);

		
		$query=$this->db->get()->row();
		$result=$query->data;
				// Doi::dump($this->db->last_query());die();
		return $result;
	}
	// function get_event($id){
	// 	$this->db->select('description');
	// 	$this->db->from(_TBL_LIBRARY);
	// 	$this->db->where('id',$id);

		
	// 	$query=$this->db->get()->row();
	// 	$result=$query->description;
	// 			// Doi::dump($this->db->last_query());die();
	// 	return $result;
	// }

	function get_couse($id){
		$this->db->select('description');
		$this->db->from(_TBL_LIBRARY);
		$this->db->where('id',$id);

		
		$query=$this->db->get()->row();
		$result=$query->description;
				// Doi::dump($this->db->last_query());die();
		return $result;
	}
	function get_impact($id){
		$this->db->select('description');
		$this->db->from(_TBL_LIBRARY);
		$this->db->where('id',$id);

		
		$query=$this->db->get()->row();
		$result=$query->description;
				// Doi::dump($this->db->last_query());die();
		return $result;
	}


	function cek_level_new($like, $impact)
	{
		$rows = $this->db->where('impact_no', $impact)->where('like_no', $like)->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
        
		// doi::dump($rows);
        return $rows;
	}

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

	function get_data_risk_register($id)
	{
		
		$rows = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		foreach ($rows as &$row) {
			$arrCouse = json_decode($row['risk_couse_no'], true);
			
			$rows_couse = array();
			if ($arrCouse)
			
				$arrCouse_implode = implode(", ", $arrCouse);
			$rows_couse  = $this->db->query("SELECT * FROM bangga_library WHERE id IN ($arrCouse_implode) ORDER BY FIELD(id, $arrCouse_implode)")->result_array(); //$this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['couse'] = implode('### ', $arrCouse);

			$arrCouse = json_decode($row['risk_impact_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$arrCouse_implode = implode(", ", $arrCouse);
			$rows_couse =  $this->db->query("SELECT * FROM bangga_library WHERE id IN ($arrCouse_implode) ORDER BY FIELD(id, $arrCouse_implode)")->result_array();  //$this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
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
			$row['accountable_unit_name'] = implode('### ', $arrCouse);


			$arrCouse = json_decode($row['penangung_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['name'];
			}
			$row['penanggung_jawab'] = implode('### ', $arrCouse);

			// $arrCouse = json_decode($row['control_no'], true);
			// $arrCouse = json_decode($row['risk_impact_no'], true);
			if (!empty($row['note_control']))
				$arrCouse =json_decode($row['note_control'], true);
			$row['control_name'] = implode('### ', $arrCouse);
		}
		unset($row);

		return $rows;
	}

	public function simpan_risk_event($data) {
		// Array untuk menampung hasil update
		$upd = [];
		
		// Mendapatkan data dari POST
		$event_no 				= $data['event_no'];
		$id_detail 				= $data['id_detail'];
		$t3 					= $this->db->select('t3')->where('id',$event_no)->get(_TBL_LIBRARY)->row();
		$upd_log = [
			'id_detail' 		=> $id_detail,
			'event_no' 			=> $event_no,
			't3' 				=> $t3->t3,
			'petugas_no'		=> $this->authentication->get_Info_User("identifier"),
			'create_user' 		=> $this->authentication->get_Info_User('username')
		];
		$id = $this->crud->crud_data(['table' => _TBL_LOG_UP_RISK_EVENT, 'field' => $upd_log, 'type' => 'add']);	
		return $id;  // Mengembalikan ID terakhir yang diupdate/ditambahkan
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */