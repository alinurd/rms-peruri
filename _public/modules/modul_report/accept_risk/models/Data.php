<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}
	
	function cari_total_dipakai($id){
		$rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_RCSA_SASARAN)->result_array();
		$result['sasaran']=[];
		foreach($rows as $row){
			$result['sasaran'][$row['rcsa_no']]=$row['jml'];
		}

		// $rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		// var_dump($rows);
		$result['peristiwa']=[];
		foreach($rows as $row){
			$result['peristiwa'][$row['rcsa_no']]=$row['jml'];
		}

		return $result;
	}
	function get_data_risk_pd($id){
		$rows = $this->db->where('rcsa_no', $id)->where('treatment_no',1)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		foreach($rows as &$row){
			$arrCouse = json_decode($row['risk_couse_no'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[] = $rc['description'];
			}
			$row['couse']= implode('### ',$arrCouse);
			
			$arrCouse = json_decode($row['risk_impact_no'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['description'];
			}
			$row['impact']=implode('### ',$arrCouse);

		}
		unset($row);
		return $rows;
	}
	function get_data_tanggal($id_rcsa){

		$rows = $this->db->where('rcsa_no', $id_rcsa)->where('keterangan', 'Approve Risk Assessment')->order_by('create_date','DESC')->get(_TBL_LOG_PROPOSE,1)->result_array();
		return $rows;
	}
		function get_data_ishikawa($id_rcsa){

		$rows = $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		return $rows;
	}
		function get_data_officer($id_rcsa){
		$rows = $this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->result_array();
		return $rows;
	}

	
	function get_data_accept_risk($id_rcsa) {
		// Ambil data dari tabel RCSA Detail
		$rows = $this->db->where('rcsa_no', $id_rcsa)
						 ->order_by('sasaran_no', 'ASC')
						 ->get(_TBL_VIEW_RCSA_DETAIL)
						 ->result_array();
		
		$arrCouse = [];
		$owner_no = [];
		$sasaran = [];
		$event = [];
	
		// Membuat cache untuk kategori Couse dan Impact
		$couse_cache = [];
		$impact_cache = [];
	
		foreach ($rows as $rc) {
			if (!in_array($rc['owner_no'], $owner_no)) {
				// Tempat untuk menyimpan sasaran yang unik untuk owner
				$haha = [];
	
				// Loop untuk memproses setiap row yang memiliki sasaran unik
				foreach ($rows as $value1) {
					if (!in_array($value1['sasaran_no'], $sasaran)) {
						$haha[] = $value1['sasaran'];
	
						// Ambil Couse (sebab risiko) dari library, jika belum ada di cache
						$arCouse = json_decode($value1['risk_couse_no'], true);
						$rows_couse = [];
						if ($arCouse) {
							// Menggunakan cache untuk Couse
							$missing_couses = array_diff($arCouse, array_keys($couse_cache));
							if ($missing_couses) {
								$rows_couse = $this->db->where_in('id', $missing_couses)
													   ->get(_TBL_LIBRARY)
													   ->result_array();
								// Menyimpan hasil query ke cache
								foreach ($rows_couse as $rc1) {
									$couse_cache[$rc1['id']] = $rc1['description'];
								}
							}
						}
	
						// Menggabungkan Couse
						$couse_descriptions = array_map(function($id) use ($couse_cache) {
							return $couse_cache[$id];
						}, $arCouse);
						$value1['couse'] = implode('### ', $couse_descriptions);
	
						// Ambil Impact (dampak risiko) dari library, jika belum ada di cache
						$arImpact = json_decode($value1['risk_impact_no'], true);
						$rows_impact = [];
						if ($arImpact) {
							// Menggunakan cache untuk Impact
							$missing_impacts = array_diff($arImpact, array_keys($impact_cache));
							if ($missing_impacts) {
								$rows_impact = $this->db->where_in('id', $missing_impacts)
														->get(_TBL_LIBRARY)
														->result_array();
								// Menyimpan hasil query ke cache
								foreach ($rows_impact as $rc2) {
									$impact_cache[$rc2['id']] = $rc2['description'];
								}
							}
						}
	
						// Menggabungkan Impact
						$impact_descriptions = array_map(function($id) use ($impact_cache) {
							return $impact_cache[$id];
						}, $arImpact);
						$value1['impact'] = implode('### ', $impact_descriptions);
	
						// Menambahkan event dengan informasi lengkap dan key yang konsisten
						$event[] = [
							'sasaran' => $value1['sasaran'],
							'couse' => $value1['couse'],
							'impact' => $value1['impact'],
							'tema_risiko' => $value1['tema_risiko'],  // Menyertakan key yang konsisten
							'kategori' => $value1['kategori'],
							'sub_kategori' => $value1['sub_kategori'],
							'risiko' => $value1['event_name']
						];
	
						// Menambahkan sasaran yang sudah diproses
						$sasaran[] = $value1['sasaran_no'];
					}
				}
	
				// Menyusun hasil untuk owner yang bersangkutan
				$arrCouse[] = [
					'name' => $rc['name'],
					'periode' => $rc['periode_name'],
					'judul' => $rc['judul_assesment'],
					'sasaran' => $haha,
					'event' => $event
				];
			}
	
			// Menambahkan owner_no yang sudah diproses
			$owner_no[] = $rc['owner_no'];
		}
	
		return $arrCouse;
	}
	
	
// 	function get_data_accept_risk($id_rcsa){
// 		// $rows = $this->db->where('rcsa_no', $id_rcsa)->where('treatment_no',1)->order_by('sasaran_no','ASC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
// 		$rows = $this->db->where('rcsa_no', $id_rcsa)->order_by('sasaran_no','ASC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
// 		$arrCouse=array();
// 		$owner_no=array();
// 		$sasaran=array();
// 		$event=array();
// 		// doi::dump($rows);
// 		foreach($rows as $key => $rc){

// 			if (!in_array($rc['owner_no'], $owner_no)) {
// 				$haha=[];

// 				foreach ($rows as $key1 => $value1) {
// 					if (!in_array($value1['sasaran_no'], $sasaran)) {
// 							$haha[]=$value1['sasaran'];
							
// 					}
// 			$arCouse = json_decode($value1['risk_couse_no'],true);
// 			$rows_couse=array();
// 			if ($arCouse)
// 				$rows_couse = $this->db->where_in('id', $arCouse)->get(_TBL_LIBRARY)->result_array();
// 				$arCouse=array();
// 				foreach($rows_couse as $rc1){
// 				$arCouse[] = $rc1['description'];
// 			}
// 			$value1['couse']= implode('### ',$arCouse);

// 			$arCouse1 = json_decode($value1['risk_impact_no'],true);
// 			$rows_couse1=array();
// 			if ($arCouse1)
// 				$rows_couse1 = $this->db->where_in('id', $arCouse1)->get(_TBL_LIBRARY)->result_array();
// 				$arCouse1=array();
// 				foreach($rows_couse1 as $rc2){
// 				$arCouse1[] = $rc2['description'];
// 			}
// 			$value1['impact']= implode('### ',$arCouse1);

// 					$event[]=[
// 						'sasaran'=>$value1['sasaran'],
// 						'couse'=>$value1['couse'],
// 						'impact'=>$value1['impact'],
// 						'kategori'=>$value1['kategori'],
// 						'sub_kategori'=>$value1['sub_kategori'],
// 						'risiko'=>$value1['event_name']
// 					];
// 					$sasaran[]=$value1['sasaran_no'];
// 				}
// 				$arrCouse[]=[
// 				'name'=>$rc['name'],
// 				'periode'=>$rc['periode_name'],
// 				'judul'=>$rc['judul_assesment'],
// 				'sasaran'=>$haha,
				
// 				'event'=>$event

// 				];
// 			}
// 			$owner_no[]=$rc['owner_no'];
			
			

// 		}	
// 	// doi::dump($arCouse);
// // var_dump($rc['couse']);;
// 		return $arrCouse;
// 	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */