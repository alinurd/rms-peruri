<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function cari_total_dipakai($id)
	{
		$rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_RCSA_SASARAN)->result_array();
		$result['sasaran'] = [];
		foreach ($rows as $row) {
			$result['sasaran'][$row['rcsa_no']] = $row['jml'];
		}

		$rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$result['peristiwa'] = [];
		foreach ($rows as $row) {
			$result['peristiwa'][$row['rcsa_no']] = $row['jml'];
		}

		return $result;
	}

	function save_detail($newid, $data, $mode, $old = [])
	{
		$updf['id'] = $newid;
		// $upd['type'] = $tipe;
		if (isset($data['id_edit'])) {
			if (count($data['id_edit']) > 0) {
				foreach ($data['id_edit'] as $key => $row) {
					$upd = array();
					$upd['rcsa_no'] = $newid;
					$upd['sasaran'] = $data['sasaran'][$key];
					// $upd['strategi'] = $data['strategi'][$key];
					// $upd['kebijakan'] = $data['kebijakan'][$key];

					if (intval($row) > 0) {
						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result = $this->crud->crud_data(array('table' => _TBL_RCSA_SASARAN, 'field' => $upd, 'where' => array('id' => $row), 'type' => 'update'));
					} else {
						$result = $this->crud->crud_data(array('table' => _TBL_RCSA_SASARAN, 'field' => $upd, 'type' => 'add'));
					}
				}
			}
		}

		if (isset($data['id_edit_in'])) {
			if (count($data['id_edit_in']) > 0) {
				foreach ($data['id_edit_in'] as $key => $row) {
					$upd = array();
					$upd['rcsa_no'] = $newid;
					$upd['stakeholder_type'] = 1;
					$upd['stakeholder'] = $data['stakeholder_in'][$key];
					$upd['peran'] = $data['peran_in'][$key];
					$upd['komunikasi'] = $data['komunikasi_in'][$key];
					$upd['potensi'] = $data['potensi_in'][$key];

					if (intval($row) > 0) {
						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result = $this->crud->crud_data(array('table' => _TBL_RCSA_STAKEHOLDER, 'field' => $upd, 'where' => array('id' => $row), 'type' => 'update'));
					} else {
						$result = $this->crud->crud_data(array('table' => _TBL_RCSA_STAKEHOLDER, 'field' => $upd, 'type' => 'add'));
					}
				}
			}
		}

		if (isset($data['id_edit_ex'])) {
			if (count($data['id_edit_ex']) > 0) {
				foreach ($data['id_edit_ex'] as $key => $row) {
					$upd = array();
					$upd['rcsa_no'] = $newid;
					$upd['stakeholder_type'] = 2;
					$upd['stakeholder'] = $data['stakeholder_ex'][$key];
					$upd['peran'] = $data['peran_ex'][$key];
					$upd['komunikasi'] = $data['komunikasi_ex'][$key];
					$upd['potensi'] = $data['potensi_ex'][$key];

					if (intval($row) > 0) {
						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result = $this->crud->crud_data(array('table' => _TBL_RCSA_STAKEHOLDER, 'field' => $upd, 'where' => array('id' => $row), 'type' => 'update'));
					} else {
						$result = $this->crud->crud_data(array('table' => _TBL_RCSA_STAKEHOLDER, 'field' => $upd, 'type' => 'add'));
					}
				}
			}
		}
		if (isset($data['id_edit_p'])) {
			if (count($data['id_edit_p']) > 0) {
				foreach ($data['id_edit_p'] as $key => $row) {
					$upd = array();
					$upd['rcsa_no'] = $newid;
					$upd['kriteria_type'] = 1;
					$upd['deskripsi'] = $data['deskripsi_p'][$key];
					$upd['sangat_besar'] = $data['sangat_besar_p'][$key];
					$upd['sangat_kecil'] = $data['sangat_kecil_p'][$key];
					$upd['besar'] = $data['besar_p'][$key];
					$upd['sedang'] = $data['sedang_p'][$key];
					$upd['kecil'] = $data['kecil_p'][$key];

					if (intval($row) > 0) {

						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result = $this->crud->crud_data(array('table' => _TBL_RCSA_KRITERIA, 'field' => $upd, 'where' => array('id' => $row), 'type' => 'update'));
					} else {
						$result = $this->crud->crud_data(array('table' => _TBL_RCSA_KRITERIA, 'field' => $upd, 'type' => 'add'));
					}
				}
			}
		}
		if (isset($data['id_edit_d'])) {
			if (count($data['id_edit_d']) > 0) {
				foreach ($data['id_edit_d'] as $key => $row) {
					$upd = array();
					$upd['rcsa_no'] = $newid;
					$upd['kriteria_type'] = 2;
					$upd['deskripsi'] = $data['deskripsi_d'][$key];
					$upd['sub_kriteria_no'] = $data['sub_kriteria_no_d'][$key];
					$upd['sangat_besar'] = $data['sangat_besar_d'][$key];
					$upd['sangat_kecil'] = $data['sangat_kecil_d'][$key];
					$upd['besar'] = $data['besar_d'][$key];
					$upd['sedang'] = $data['sedang_d'][$key];
					$upd['kecil'] = $data['kecil_d'][$key];

					if (intval($row) > 0) {

						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result = $this->crud->crud_data(array('table' => _TBL_RCSA_KRITERIA, 'field' => $upd, 'where' => array('id' => $row), 'type' => 'update'));
					} else {
						$result = $this->crud->crud_data(array('table' => _TBL_RCSA_KRITERIA, 'field' => $upd, 'type' => 'add'));
					}
				}
			}
		}

		return true;
	}

	function save_status($id,$status){
		$data = array('sts_heatmap' => $status);
        $this->db->where('id', $id);
		$this->db->update(_TBL_RCSA_DETAIL, $data);
        return  true;
	}
	function get_data_tanggal($id_rcsa)
	{

		$rows = $this->db->where('rcsa_no', $id_rcsa)->where('keterangan', 'Approve Risk Assessment')->order_by('create_date', 'DESC')->get(_TBL_LOG_PROPOSE, 1)->result_array();
		return $rows;
	}
	function get_data_parent($owner_no)
	{

		$rows = $this->db->select('parent_no')->where('id', $owner_no)->get(_TBL_OWNER)->result_array();
		return $rows;
	}
	function get_data_divisi($parent_no)
	{

		$a = $parent_no[0]['parent_no'];
		$b = "1700";

		if ($a == 0) {
			$rows = $this->db->select('name')->where('id', $b)->get(_TBL_OWNER)->row();
		} else {
			$rows = $this->db->select('name')->where('id', $a)->get(_TBL_OWNER)->row();
		}
		return $rows;
		// var_dump($rows);
	}
	function get_data_officer($id_rcsa)
	{
		$rows = $this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->result_array();
		return $rows;
	}




	function get_data_risk_register($id)
	{
		$rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		// $rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_REGISTER)->result_array();
		// doi::dump($rows)
		//$rows = $this->db->where('rcsa_no', $id)->group_by('id_rcsa_detail')->order_by('urgensi_no_kadiv')->get(_TBL_VIEW_REGISTER)->result_array();

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

			$arrCouse = json_decode($row['control_no'], true);
			if (!empty($row['note_control']))
				$arrCouse[] = $row['note_control'];
			// $row['control_name']=implode(', ',$arrCouse);
			$row['control_name'] = implode('###', $arrCouse);
		}
		unset($row);

		return $rows;
	}
	function get_data_risk_reg_acc($id)
	{
		$rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		foreach ($rows as &$row) {
			$arrCouse = json_decode($row['risk_couse_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['couse'] = implode('### ', $arrCouse);

			$arrCouse = json_decode($row['risk_impact_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['impact'] = implode('### ', $arrCouse);

			$arrCouse = json_decode($row['inherent_impact'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LEVEL)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['code'];
			}
			// var_dump($arrCouse);
			// $row['impact']=implode('### ',$arrCouse);
			$row['code_impact'] = $arrCouse;

			$arrCouse = json_decode($row['control_no'], true);
			if (!empty($row['note_control']))
				$arrCouse[] = $row['note_control'];
			// $row['control_name']=implode(', ',$arrCouse);

			// var_dump($arrCouse);
			// die();
			$row['control_name'] = ($arrCouse) ? implode('###', $arrCouse) : "";
		}
		unset($row);

		return $rows;
	}
	function get_realisasi($id)
	{
		$rows = $this->db->where('rcsa_detail_no', $id)->order_by('progress_date')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();

		return $rows;
	}


	function get_peristiwa($rcsa_no)
	{
		// doi::dump($rcsa_no);
		$rows = $this->db->where('rcsa_no', $rcsa_no)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		$idArr = [];
		foreach ($rows as $row) {
			$idArr[] = $row['id'];
		}
		if ($idArr) {
			$this->db->where_in('rcsa_detail_no', $idArr);
		}
		$rows_tmp = $this->db->select('rcsa_detail_no, count(id) as jml')->group_by('rcsa_detail_no')->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
		$arrMitigasi = [];
		foreach ($rows_tmp as $row) {
			$arrMitigasi[$row['rcsa_detail_no']] = $row['jml'];
		}

		if ($idArr) {
			$this->db->where_in('rcsa_detail_no', $idArr);
		}
		$rows_tmp = $this->db->select('rcsa_detail_no, count(id) as jml')->group_by('rcsa_detail_no')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		$arrRealisasi = [];
		foreach ($rows_tmp as $row) {
			$arrRealisasi[$row['rcsa_detail_no']] = $row['jml'];
		}

		$peristiwa = [];
		foreach ($rows as $row) {
			$peristiwa[$row['sasaran_no']][$row['id']] = $row;
			$jmlMitigasi = 0;
			$jmlRealisasi = 0;
			if (array_key_exists($row['id'], $arrMitigasi)) {
				$jmlMitigasi = $arrMitigasi[$row['id']];
			}
			if (array_key_exists($row['id'], $arrRealisasi)) {
				$jmlRealisasi = $arrRealisasi[$row['id']];
			}
			$peristiwa[$row['sasaran_no']][$row['id']]['jml_mitigasi'] = $jmlMitigasi;
			$peristiwa[$row['sasaran_no']][$row['id']]['jml_realisasi'] = $jmlRealisasi;
		}
		$rows = $this->db->where('rcsa_no', $rcsa_no)->get(_TBL_RCSA_SASARAN)->result_array();
		$sasaran = [];
		foreach ($rows as $row) {
			$sasaran[$row['id']]['nama'] = $row['sasaran'];
			if (array_key_exists($row['id'], $peristiwa)) {
				$sasaran[$row['id']]['detail'] = $peristiwa[$row['id']];
			} else {
				$sasaran[$row['id']]['detail'] = [];
			}
		}

		// doi::dump($sasaran);
		// die('odel');
		return $sasaran;
	}
	public function lastCodeLibrary()
	{
		$sql = "select MAX(code) AS max_code from " . _TBL_LIBRARY . "";
		$query = $this->db->query($sql);
		$rows = $query->row_array();
		$code = intval($rows['max_code']);
		return $code;
	}
	public function cekLibEvent($event, $type)
	{
		$query = $this->db
			->select('code')
			->from('bangga_library')
			->where('description', $event)
			->where('type', $type)
			->get();

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	function simpan_risk_event($data)
	{


		$upd = array();
		$updkri = array();
		$lastCode = $this->lastCodeLibrary();
		// doi::dump($data);
		// doi::dump($data);
		// die();

		$upd['tema'] = $data['tema'];
		if ($data['peristiwabaru']) {
			$cekLibEvent = $this->cekLibEvent($data['peristiwabaru'], 1);
			if (!$cekLibEvent) {
				$updlib['description'] = $data['peristiwabaru'];
				$updlib['code'] = $lastCode ? $lastCode + 1 : 1; // Jika $lastCode kosong, mulai dari 1

				$updlib['type'] = 1;
				$updlib['status'] = 1;
				$updlib['kategori_risiko'] = $data['kategori'];

				$updlib['create_user'] = $this->authentication->get_info_user('username');

				$saveUpd = $this->crud->crud_data(['table' => _TBL_LIBRARY, 'field' => $updlib, 'type' => 'add']);
				$idlib = $this->db->insert_id();
				$upddetail = array();
				$upddetail['library_no'] = $idlib;
				$upddetail['kategori_risiko'] = $data['kategori'];
				$upd['update_user'] = $this->authentication->get_info_user('username');
				$result = $this->crud->crud_data(array('table' => _TBL_LIBRARY_DETAIL, 'field' => $upd, 'where' => array('id' => $data['id_edit'][$key]), 'type' => 'update'));
			} else {
				$tab['id'] = 201;
				$tab['msg'] = 'Peristiwa (T3) yang anda masukan sudah ada';
				return $tab;
			}
			$cek_error = $this->db->error();
			// doi::dump($cek_error);
			// doi::dump($updlib);
			// doi::dump($saveUpd);

			$upd['event_no'] = $idlib;
		} else {
			$upd['event_no'] = $data['event_no'];
		}

		// doi::dump($upd['event_no']);
		// die('cel evmt');
		// doi::dump($updetail);



		if ($data['new_cause']) {
			if ($saveUpd) {
				$code = $updlib['code'];
				// doi::dump($code);
			} else {
				$code = $lastCode;
			}
			// $code = $upd['code'];
			$cd = 1; // Mulai dari 1 sebagai offset awal
			foreach ($data['new_cause'] as $datax) {
				if ($datax != "") {
					$cekLibEvent = $this->cekLibEvent($datax, 2);
					$msg = "Risk Cause yang anda masukan sudah ada";
					if (!$cekLibEvent) {
						$updx['description'] = $datax;
						$updx['type'] = 2;
						$updx['code'] = $code + $cd; // Gunakan code yang unik dengan penambahan offset
						$updx['status'] = 1;
						$updx['create_user'] = $this->authentication->get_info_user('username');
						// doi::dump($updx['code']);
						// doi::dump($upd['code']);
						// doi::dump("new_cause");
						// Cek apakah entri dengan kode yang sama sudah ada sebelum menyimpan
						$existingEntry = $this->db->get_where('bangga_library', ['code' => $updx['code'], 'description' => $datax])->row();
						if ($existingEntry) {
							echo "Error-new_cause: Duplicate entry for code {$updx['code']}";
							$msg = "Error-new_cause: Duplicate entry for code {$updx['code']}";
						} else {
							$saveUpdx = $this->crud->crud_data(['table' => 'bangga_library', 'field' => $updx, 'type' => 'add']);
							$idcouse = $this->db->insert_id();
							$error = $this->db->error();
							// doi::dump('saveUpdx'. $error);

							$updetail['library_no'] = $upd['event_no'];
							$updetail['child_no'] = $idcouse;
							$updetail['kategori_risiko'] = $data['kategori'];
							$updetail['create_user'] = $this->authentication->get_info_user('username');
							$saveUpdx1 = $this->crud->crud_data(['table' => 'bangga_library_detail', 'field' => $updetail, 'type' => 'add']);
							$error1 = $this->db->error();
							// doi::dump('saveUpdx1' . $error1);
							if (!empty($error)) {
								echo "Error: " . $error['message'];
							}
						}
					} else {
						$tab['id'] = 201;
						$tab['msg'] = $msg;
						return $tab;
					}
				}

				$cd++;
				$data['risk_couse_no'][] = $idcouse;
			}
		}

		// die('model');
		//proses simpan data impact baru, masukan dulu ke dalam library mapping library, terahir id nyamasukkan ke dalam array
		if ($data['new_impact']) {
			//cek code dulu
			if ($saveUpdx) {
				$code = $updx['code'];
			} elseif ($saveUpd) {
				$code = $updlib['code'];
			} else {
				$code = $lastCode;
			}
			$cd = 1;
			// doi::dump("updx-code: ".$updx['code']);
			// doi::dump("updlib-code: ". $updlib['code']);
			foreach ($data['new_impact'] as $dataxx) {
				// doi::dump($code);
				if ($dataxx != "") {
					$cekLibEvent=$this->cekLibEvent($dataxx, 3);
$msg="risk impcat yang anda masukan sudah ada";
			if(!$cekLibEvent){
				$updxx['description'] = $dataxx;
					$updxx['type'] = 3;
					$updxx['code'] = $code + $cd; // Gunakan code yang unik dengan penambahan offset
					$updxx['status'] = 1;
					$updxx['create_user'] = $this->authentication->get_info_user('username');
					// doi::dump("updxx-code: " . $updxx['code']);

					// Cek apakah entri dengan kode yang sama sudah ada sebelum menyimpan 
					$existingEntry = $this->db->get_where('bangga_library', ['code' => $updxx['code'], 'description' => $dataxx])->row_array();
					// doi::dump("existingEntry: " . $existingEntry);
					if ($existingEntry) {
						echo "Error-new_impact: Duplicate entry for code {$updxx['code']}";
						$msg= "Error-new_impact: Duplicate entry for code {$updxx['code']}";
					} else {
						//simpan data ke library
						// doi::dump($updxx);
						$saveUpdxx = $this->crud->crud_data(['table' => 'bangga_library', 'field' => $updxx, 'type' => 'add']);
						$idimpc = $this->db->insert_id();
						$error = $this->db->error();
						// doi::dump("Error-saveUpdxx: " . $error['message']);

						//mapping library

						$updetailx['library_no'] = $idlib;
						$updetailx['child_no'] = $idimpc;
						$updetailx['kategori_risiko'] = $data['kategori'];
						$updetailx['create_user'] = $this->authentication->get_info_user('username');
						$this->crud->crud_data(['table' => 'bangga_library_detail', 'field' => $updetailx, 'type' => 'add']);
						// doi::dump($updetailx);
						$error = $this->db->error();
						if (!empty($error)) {
							echo "Error: " . $error['message'];
						}
					}
				}else{
			$tab['id'] = 201;
			$tab['msg'] = $msg;
			return $tab;


	}
				}
				$cd++;
				//id impact nya masukan ke dalam array
				$data['risk_impact_no'][] = $idimpc;
			}
		}




		$upd['rcsa_no'] = $data['rcsa_no'];
		$upd['pic_no'] = $data['pic'];
		$upd['sasaran_no'] = $data['sasaran'];
		$upd['subrisiko'] = $data['subrisiko'];
		// $upd['risk_area_id']= $data['area'];
		$upd['kategori_no'] = $data['kategori'];
		if ($data['sub_kategori']) {
			$upd['sub_kategori'] = $data['sub_kategori'];
		}
		// field baru
		$upd['risk_asumsi_perhitungan_dampak'] = $data['risk_asumsi_perhitungan_dampak'];
		$upd['rcm_id'] = $data['proses_bisnis'];
		// $upd['sts_heatmap'] = $data['sts_heatmap'];

		$upd['risk_impact_kuantitatif'] = str_replace(',', '', $data['risk_impact_kuantitatif']);

		$couse = array();

		// doi::dump($data['risk_couse_no']);
		// doi::dump($upd['event_no']);

		if ($data['risk_couse_no']) {
			foreach ($data['risk_couse_no'] as $row) {
				if ($row != "" && $row != "0") {
					$couse[] = $row;
				}
			}
			// Menghapus data duplikat
			$couse = array_unique($couse);
			$upd['risk_couse_no'] = json_encode($couse);
		}
		// doi::dump($upd['risk_couse_no']);

		$impact = array();
		if ($data['risk_impact_no']) {
			foreach ($data['risk_impact_no'] as $row) {
				if ($row != "" && $row != "0") {

					$impact[] = $row;
				}
			}
			$impact = array_unique($impact);

			$upd['risk_impact_no'] = json_encode($impact);
		}
		if (!($data['pi'] < 6 && $data['pi'] > 1)) {
			$upd['pi'] = 1 + 1;
		}
		if (intval($data['id_edit_baru']) != 0) {
			// doi::dump('id_edit ' . $data['id_edit_baru']);
			// doi::dump($data['pi']);

			// die('cek');
			$upd['pi'] = $data['pi'];
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$where['id'] = $data['id_edit'];
			$id = $this->crud->crud_data(array('table' => _TBL_RCSA_DETAIL, 'field' => $upd, 'where' => array('id' => $data['id_edit_baru']), 'type' => 'update'));
			$id = intval($data['id_edit_baru']);
			// $cek_error = $this->db->error();

			// $updkri['update_user'] = $this->authentication->get_info_user('username');
			// $wherekri['rcsa_detail']=$data['id_edit'];
			// $result=$this->crud->crud_data(array('table'=> 'bangga_kri', 'field'=> $updkri,'where'=>array('rcsa_detail'=>$data['id_edit']),'type'=>'update'));

			// doi::dump($cek_error);
			// doi::dump('id_edit ' . $id);
			// doi::dump($upd);
			// die('cek');
			// $upd['sub_kategori'] = $data['sub_kategori'];
		} else {
			$upd['pi'] = 2;
			// die('cek');
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$id = $this->crud->crud_data(array('table' => _TBL_RCSA_DETAIL, 'field' => $upd, 'type' => 'add'));
			$id = $this->db->insert_id();
			$cek_error = $this->db->error();
			// $detail = $this->db->delete('bangga_rcsa_event_sementara', ['rcsa_detail_no' => $data['id_edit_baru']]);

			// $rows = $this->db->where('rcsa_detail_no', $data['id_edit_baru'])->get('bangga_rcsa_event_sementara')->row_array();

			doi::dump("save baru");
			doi::dump($cek_error);
			doi::dump('id_edit ' . $id);
			doi::dump($upd);

			// // Contoh:
			// if ($id > 0
			// ) {
			// 	doi::dump('ok aman');
			// } else {
			// 	doi::dump($cek_error);
			// }
		}

		// die('cek');
		return $id;
	}

	function simpan_risk_level($data)
	{
		$upd = array();
		// if (!($data['pi'] < 6 && $data['pi'] > 3)) {
		// 	$upd['pi'] = 3 + $data['pi'];
		// }
		// doi::dump($data);

		$upd['pi'] =4;
		$upd['rcsa_no'] = $data['rcsa_no'];
		// $upd['inherent_likelihood'] = $data['inherent_likelihood'];
		// $upd['inherent_impact'] = $data['inherent_impact'];
		// $upd['inherent_level'] = $data['inherent_level'];


		// $upd['residual_likelihood'] = $data['residual_likelihood'];
		// $upd['residual_impact'] = $data['residual_impact'];
		$upd['risk_level'] = $data['residual_impact'];
		// $upd['residual_level'] = $data['residual_level'];
		$upd['note_control'] = $data['note_control'];
		$upd['coa'] = str_replace(',', '', $data['coa']);

		$upd['keterangan_coa'] = $data['keterangan_coa'];
		$upd['kode_jasa'] = $data['kode_jasa'];
		$upd['risk_control_assessment'] = $data['risk_control_assessment'];
		$upd['treatment_no'] = $data['treatment_no'];
		$check_item = array();
		if (array_key_exists('check_item', $data)) {
			foreach ($data['check_item'] as $row) {
				$check_item[] = $row;
			}
		}
		$upd['control_no'] = json_encode($check_item);
		doi::dump($data['id_edit_baru']);
		if (intval($data['id_edit_baru']) != 0) {
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$where['id'] = $data['id_edit'];
			$result = $this->crud->crud_data(array('table' => _TBL_RCSA_DETAIL, 'field' => $upd, 'where' => array('id' => $data['id_edit_baru']), 'type' => 'update'));
			$id = intval($data['id_edit_baru']);
			$cek_error = $this->db->error();

			// $updkri['update_user'] = $this->authentication->get_info_user('username');
			// $wherekri['rcsa_detail']=$data['id_edit'];
			// $result=$this->crud->crud_data(array('table'=> 'bangga_kri', 'field'=> $updkri,'where'=>array('rcsa_detail'=>$data['id_edit']),'type'=>'update'));

			// doi::dump($cek_error);
			// doi::dump('id_edit ' . $id);
		}

		// die('cek');
		return $id;
	}

	function simpan_mitigasi($data) {

		$upd = [];
		$updx['pi'] = 6;
		$upd['iskri'] = 1;
		$upd['rcsa_detail_no'] = $data['id_detail'];
		$upd['proaktif'] = $data['proaktif'];
	
		// Cek kondisi edit atau add
		if ((int)$data['id_edit_mitigasi'] > 0) {
			// Jika edit, tambahkan informasi pengguna yang melakukan update
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$upd['update_date'] = Doi::now();
			$where = ['id' => $data['id_edit_mitigasi']];
			$kri['aktif'] = 1;
			$this->crud->crud_data(array('table' => _TBL_RCSA_DETAIL, 'field' => $updx, 'where' => array('id' => $data['id_detail']), 'type' => 'update'));
			$this->crud->crud_data(array('table' => _TBL_KRI, 'field' => $kri, 'where' => array('rcsa_detail' => $data['id_detail']), 'type' => 'update'));
			
			// Update data utama mitigasi
			$result = $this->crud->crud_data(['table' => _TBL_RCSA_ACTION, 'field' => $upd, 'where' => $where, 'type' => 'update']);
			$id = intval($data['id_edit_mitigasi']);
			$type = "edit";
		} else {
			// Jika add, tambahkan informasi pengguna yang membuat data baru
			$upd['create_user'] = $this->authentication->get_info_user('username');
			// Insert data utama mitigasi
			$id = $this->crud->crud_data(['table' => _TBL_RCSA_ACTION, 'field' => $upd, 'type' => 'add']);
			$this->crud->crud_data(array('table' => _TBL_RCSA_DETAIL, 'field' => $updx, 'where' => array('id' => $data['id_detail']), 'type' => 'update'));
			$id = $this->db->insert_id();
			$type = "add";
		}
	
		// Insert atau update data bulanan satu per satu
		$bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		foreach ($bulan as $key => $nama_bulan) {
			$index = $key + 1;
	
			// Mengambil nilai progress dan damp loss atau memberikan nilai default
			$target_progress = isset($data["target_progress{$index}"]) ? (int) $data["target_progress{$index}"] : 0;
			$target_damp_loss = isset($data["target_damp_loss{$index}"]) ? str_replace(',', '', $data["target_damp_loss{$index}"]) : 0;
	
			// Hanya insert atau update jika salah satu nilai diisi
			if ($target_progress || $target_damp_loss) {
				$data_bulanan = [
					'bulan'                => $index,
					'target_progress_detail' => $target_progress,
					'target_damp_loss'     => $target_damp_loss,
					'rcsa_detail_no'       => $data['id_detail'],
					'rcsa_no'              => $data['rcsa_no'],
					'update_user'          => $this->authentication->get_info_user('username')
				];
	
				// Cek apakah data bulanan untuk bulan ini sudah ada
				$existing_data = $this->db->get_where('bangga_rcsa_treatment', [
					'rcsa_detail_no' => $data['id_detail'],
					'bulan' => $index
				])->row();
	
				if ($existing_data) {
					// Jika data bulan sudah ada, lakukan update
					$this->crud->crud_data([
						'table' => 'bangga_rcsa_treatment',
						'field' => $data_bulanan,
						'where' => ['id' => $existing_data->id],
						'type' => 'update'
					]);
				} else {
					// Jika data bulan belum ada, lakukan insert
					$data_bulanan['create_user'] = $this->authentication->get_info_user('username');
					$this->crud->crud_data([
						'table' => 'bangga_rcsa_treatment',
						'field' => $data_bulanan,
						'type' => 'add'
					]);
				}
			}
		}
		
		// Doi::dump($id)
		return $id;
	}
	
	

	function simpan_realisasi($data)
	{


		$upd = array();
		// $files = $_FILES;
		// // die($files);
		// if ($files) {
		// 	$arra_upload = [];

		// 	$i = 0;
		// 	// for ($i = 0; $i < $cpt; $i++) {
		// 	if (!empty($files['userfile']['name'])) {
		// 		$nmFile = $files['userfile']['name'];
		// 		$_FILES['userfile']['name'] = $files['userfile']['name'];
		// 		$_FILES['userfile']['type'] = $files['userfile']['type'];
		// 		$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'];
		// 		$_FILES['userfile']['error'] = $files['userfile']['error'];
		// 		$_FILES['userfile']['size'] = $files['userfile']['size'];
		// 		$upload = upload_image_new(array(
		// 			'nm_file' => 'userfile',
		// 			'size' => 10000000,
		// 			'path' => 'rcsa',
		// 			'thumb' => false,
		// 			'type' => '*'
		// 		), true, $i);
		// 		// die($upload);
		// 		if ($upload) {
		// 			$arra_upload[] = array('name' => $upload['file_name'], 'real_name' => $nmFile);
		// 		}
		// 	}
		// }
		// Doi::dump($arra_upload);
		// Doi::dump($nmFile);
		// // die('model');
		// // Doi::dump($_FILES);
		// $upd = [];
		// if ($arra_upload) {
		// 	$upd['lampiran'] = json_encode($arra_upload);
		// }
		$upd['rcsa_action_no'] = $data['rcsa_action_no'];
		$upd['realisasi'] = $data['realisasi'];
		$upd['progress_detail'] = $data['progress'];
		$upd['status_loss'] = $data['status_loss'];
		// $upd['notes']=$data['notes'];
		$upd['keterangan'] = $data['keterangan'];

		$sts = $data['progress'];
		if (floatval($data['progress']) >= 100)
			$sts = 1;
		// $upd['status_no']=$sts;
		$upd['status_no'] = $data['status_no'];
		$upd['residual_likelihood_action'] = $data['residual_likelihood'];
		$upd['residual_impact_action'] = $data['residual_impact'];
		$upd['risk_level_action'] = $data['inherent_level'];
		if (!empty($data['progress_date']))
			$upd['progress_date'] = date('Y-m-d', strtotime($data['progress_date']));

		// $pelaksana_no=array();
		// foreach($data['pelaksana_no'] as $key=>$row){
		// 	$pelaksana_no[]=$row;
		// }
		// $upd['pelaksana_no']=json_encode($pelaksana_no);

		if ((int)$data['id_edit'] > 0) {
			$upd['update_user'] = $this->authentication->get_info_user('username');

			$where['id'] = $data['id_edit'];
			$result = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'where' => $where, 'type' => 'update'));
			$id = intval($data['id_edit']);
			$type = "edit";
		} else {
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$id = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'type' => 'add'));
			$id = $this->db->insert_id();
			$type = "add";
		}


		$upd = [];

		$rows = $this->db->where('rcsa_action_no', $data['rcsa_action_no'])->order_by('progress_date', 'desc')->limit(1)->get(_TBL_RCSA_ACTION_DETAIL)->row_array();
		if ($rows) {
			$upd['residual_likelihood'] = $rows['residual_likelihood_action'];
			$upd['residual_impact'] = $rows['residual_impact_action'];
			$upd['risk_level'] = $rows['risk_level_action'];
			$upd['status_loss_parent'] = $rows['status_loss'];
			$where['id'] = $data['detail_rcsa_no'];
			$result = $this->crud->crud_data(array('table' => _TBL_RCSA_DETAIL, 'field' => $upd, 'where' => $where, 'type' => 'update'));
		}

		// $where['id']=$data['action_no'];
		// $result=$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION, 'field'=>['status_loss'=>$data['status_loss']],'where'=>$where,'type'=>'update'));

		return $id;
	}

	function get_data_risk_register_propose($id)
	{
		$rows = $this->db->where('id', $id)->get(_TBL_RCSA)->row_array();
		$rows =
			$hasil['user'] = $this->authentication->get_info_user();

		$hasil['rcsa'] = $rows;

		$sts = false;

		$ket = "";
		if ($rows) {
			if ($rows['sts_propose'] == 1) {
				$ket = "Assessment Masih dalam proses Approve di KaDep!!<br/>Tanggal Propose : " . date('d M Y', strtotime($rows['date_propose']));
				$sts = true;
			} elseif ($rows['sts_propose'] == 2) {
				$ket = "Assessment Masih dalam proses Approve di KaDiv!!<br/>Tanggal Propose : " . date('d M Y', strtotime($rows['date_propose_kadep']));
				$sts = true;
			} elseif ($rows['sts_propose'] == 3) {
				$ket = "Assessment Masih dalam proses Approve di Admin RISK!!<br/>Tanggal Propose : " . date('d M Y', strtotime($rows['date_propose_kadiv']));
				$sts = true;
			} elseif ($rows['sts_propose'] == 4) {
				$ket = "Assessment Sudah selesai di Aproved Admin RISK pada tanggal " . date('d M Y', strtotime($rows['date_propose_admin']));
				$sts = true;
			}
		}
		$hasil['field'] = $ket;
		if (!$sts) {
			$rsca_detail_no = [];
			$rows = $this->db->where('rcsa_no', $id)->where('urgensi_no', 0)->where('type', 1)->get(_TBL_VIEW_REGISTER)->result_array();
			// echo $this->db->last_query();
			foreach ($rows as &$row) {
				$arrCouse = json_decode($row['risk_couse_no'], true);
				if ($arrCouse) {
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
					$arrCouse = array();
					foreach ($rows_couse as $rc) {
						$arrCouse[] = $rc['description'];
					}
				}
				$row['couse'] = implode('### ', $arrCouse);

				$arrCouse = json_decode($row['risk_impact_no'], true);
				if ($arrCouse) {
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
					$arrCouse = array();
					foreach ($rows_couse as $rc) {
						$arrCouse[] = $rc['description'];
					}
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

				$row['penanggung_jawab'] = implode('### ', $arrCouse);

				$arrCouse = json_decode($row['penangung_no'], true);
				$rows_couse = array();
				if ($arrCouse)
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
				$arrCouse = array();
				foreach ($rows_couse as $rc) {
					$arrCouse[] = $rc['name'];
				}
				$row['accountable_unit_name'] = implode('### ', $arrCouse);

				// $row['control_no']=implode('###',$arrCouse);

				$arrCouse = json_decode($row['control_no'], true);

				if (!empty($row['note_control']))
					$arrCouse[] = $row['note_control'];
				// $row['control_name']=implode(', ',$arrCouse);
				$row['control_name'] = implode('###', $arrCouse);
				$rsca_detail_no[] = $row['id_rcsa_detail'];
			}
			unset($row);
			$hasil['field'] = $rows;
			$hasil['rcsa_detail'] = json_encode($rsca_detail_no);
		}
		$hasil['status'] = $sts;
		// die($this->db->last_query());
		return $hasil;
	}

	function delete_sasaran($id)
	{		//delete for table sasaran at rcsa/edit
		$query = $this->db->query("DELETE FROM bangga_rcsa_sasaran WHERE id='$id'");
		return $query;
	}

	function delete_stakeholder($id)
	{ //delete for table stakeholder at rcsa/edit
		$query = $this->db->query("DELETE FROM bangga_rcsa_stakeholder WHERE id='$id'");
		return $query;
	}

	function delete_kriteria($id)
	{ //delete for table kriteria at rcsa/edit
		$query = $this->db->query("DELETE FROM bangga_rcsa_kriteria WHERE id='$id'");
		return $query;
	}

	function save_library_new($data = array(), $newid = 0, $tipe = 1, $mode = 'new', $old_data = array())
	{
		var_dump($data);
		// die();
		$updf['id'] = $newid;
		$upd['type'] = $tipe;
		$tgl = Doi::now();
		// Doi::dump($old_data);
		// Doi::dump($data);die();

		if ($mode == 'new') {
			$upd['code'] = $this->cari_code_library($data, $tipe);
		} elseif ($mode == 'edit') {
			// if ($data['l_risk_type_no'] !== $old_data['l_risk_type_no']){
			// $upd['code'] = $this->cari_code_library($data, $tipe); 
			// }
		}
		$this->db->update(_TBL_LIBRARY, $upd, $updf);

		if (isset($data['id_edit'])) {
			if (count($data['id_edit']) > 0) {
				if (count($data['library_no']) > 0) {
					foreach ($data['library_no'] as $key => $row) {
						$upd = array();
						$upd['library_no'] = $newid;;
						$upd['child_no'] = $data['library_no'][$key];;

						if (intval($data['id_edit'][$key]) > 0) {

							$upd['update_date'] = $tgl;
							$upd['update_user'] = $this->authentication->get_info_user('username');
							$result = $this->crud->crud_data(array('table' => _TBL_LIBRARY_DETAIL, 'field' => $upd, 'where' => array('id' => $data['id_edit'][$key]), 'type' => 'update'));
						} else {
							$upd['create_user'] = $this->authentication->get_info_user('username');
							$result = $this->crud->crud_data(array('table' => _TBL_LIBRARY_DETAIL, 'field' => $upd, 'type' => 'add'));
						}
					}
				}

				if (count($data['new_cause']) > 0) {
					foreach ($data['new_cause'] as $key => $row) {

						$tipe1 = 2;
						$upd_cause['description'] = $row;
						$upd_cause['risk_type_no'] = 0;
						$upd_cause['type'] = $tipe1;
						$data['l_risk_type_no'] = 0;
						$upd_cause['code'] = $this->cari_code_library($data, $tipe1);
						$upd_cause['create_user'] = $this->authentication->get_info_user('username');

						$result1 = $this->crud->crud_data(array('table' => _TBL_LIBRARY, 'field' => $upd_cause, 'type' => 'add'));

						if ($result1 != NULL) {
							$upa = array();
							$upa['library_no'] = $newid;;
							$upa['child_no'] = $result1;;


							if (intval($data['new_cause'][$key]) > 0) {
								$upa['update_date'] = $tgl;
								$upa['update_user'] = $this->authentication->get_info_user('username');
								$result1 = $this->crud->crud_data(array('table' => _TBL_LIBRARY_DETAIL, 'field' => $upa, 'where' => array('id' => $data['id_edit'][$key]), 'type' => 'update'));
							} else {
								$upa['create_user'] = $this->authentication->get_info_user('username');

								$resul1 = $this->crud->crud_data(array('table' => _TBL_LIBRARY_DETAIL, 'field' => $upa, 'type' => 'add'));
							}
						}
					}
				}
				if (count($data['new_impact']) > 0) {
					foreach ($data['new_impact'] as $key => $row) {
						$tipe2 = 3;
						$upd_impact['description'] = $row;
						$upd_impact['type'] = 3;
						$upd_impact['risk_type_no'] = 0;
						$data['l_risk_type_no'] = 0;
						$upd_impact['code'] = $this->cari_code_library($data, $tipe2);
						$upd_impact['create_user'] = $this->authentication->get_info_user('username');

						$result2 = $this->crud->crud_data(array('table' => _TBL_LIBRARY, 'field' => $upd_impact, 'type' => 'add'));
						if ($result2 != NULL) {
							$upi = array();
							$upi['library_no'] = $newid;;
							$upi['child_no'] = $result2;;

							if (intval($data['new_cause'][$key]) > 0) {
								$upi['update_date'] = $tgl;
								$upi['update_user'] = $this->authentication->get_info_user('username');
								$result2 = $this->crud->crud_data(array('table' => _TBL_LIBRARY_DETAIL, 'field' => $upi, 'where' => array('id' => $data['id_edit'][$key]), 'type' => 'update'));
							} else {
								$upi['create_user'] = $this->authentication->get_info_user('username');

								$result2 = $this->crud->crud_data(array('table' => _TBL_LIBRARY_DETAIL, 'field' => $upi, 'type' => 'add'));
							}
						}
					}
				}
			}
		}
		return true;
	}

	public function get_rcsa_detail($id, $isPositif = 0)
	{
		$this->db->where('rcsa_no', $id);
		$this->db->where('is_positif', $isPositif);
		$rows = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		return $rows;
	}


	public function get_data_risk_event($id)
	{
		$hasil['field'] = $this->get_rcsa_detail($id, 0);

		$hasil['field_positif'] = $this->get_rcsa_detail($id, 1);
		$rows = $this->db->where('id', intval($id))->get(_TBL_VIEW_RCSA)->row_array();
		$hasil['parent'] = $rows;
		return $hasil;
	}

	function cek_level_new($like, $impact)
	{
		$rows = $this->db->where('impact_no', $impact)->where('like_no', $like)->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
        return $rows;
	}
}
/* End of file app_login_model.php */