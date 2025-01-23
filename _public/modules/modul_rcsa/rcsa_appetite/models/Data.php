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

		$rows = $this->db->select('rcsa_no, count(rcsa_no) as jml')->where_in('rcsa_no', $id)->group_by('rcsa_no')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$result['peristiwa']=[];
		foreach($rows as $row){
			$result['peristiwa'][$row['rcsa_no']]=$row['jml'];
		}

		return $result;
	}

	function save_detail($newid, $data, $mode, $old=[]){
		$updf['id'] = $newid;
		$implementasi = $data['implementasi'];
 		foreach ($implementasi as $index => $item) {

			$upimp['rcsa_no'] = $newid;
			$upimp['combo_no'] = $index;

			if (isset($item['bulan'])) {
				$upimp['ket'] = $item['ket'];
				$upimp['combo_no'] = $index;
				$bulanData[$index] = $item['bulan'];
				// save data nya impentasi

				if ($mode=="edit") {
					$wr['rcsa_no'] = $newid;
					$wr['combo_no'] = $index;
					$imp = $this->db
						->select('jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec,ket')
						->where('rcsa_no', $newid)
						->where('combo_no', $index)
						->get(_TBL_RCSA_IMPLEMENTASI)
						->row_array();
						if(!$imp){
						$result = $this->crud->crud_data(array('table' => _TBL_RCSA_IMPLEMENTASI, 'field' => $upimp, 'type' => 'add'));

						}
					$result = $this->crud->crud_data(array('table' => _TBL_RCSA_IMPLEMENTASI, 'field' => $upimp, 'where' => $wr, 'type' => 'update'));

				}else{	
					$result = $this->crud->crud_data(array('table' => _TBL_RCSA_IMPLEMENTASI, 'field' => $upimp, 'type' => 'add'));
				}

			}
		}
		foreach ($bulanData as $index => $bln) {
			$upbln = array();
			foreach ($bln as $resbulan) {
				doi::dump($resbulan);
				$splitData = explode('##', $resbulan);
				$upbln[strtolower($splitData[0])] = $splitData[1].$index;
			}

			$wr['rcsa_no'] = $newid;
			$wr['combo_no'] = $index;
			
			$result = $this->crud->crud_data(array('table' => _TBL_RCSA_IMPLEMENTASI, 'field' => $upbln, 'where' => $wr, 'type' => 'update'));
			// Proses update berdasarkan 'rcsa_no' dan 'combo_no' => $index
		}


		// die();





		// die();
		// $upd['type'] = $tipe;
		if (isset($data['id_edit'])){
			if(count($data['id_edit'])>0){
				foreach($data['id_edit'] as $key=>$row)
				{
					$upd=array();
					// doi::dump($data);
					// die('cek');
					$upd['rcsa_no'] = $newid;
					$upd['sasaran'] = $data['sasaran'][$key];
					$upd['statement'] = $data['statement'][$key];
					$upd['appetite'] = $data['appetite'][$key];
					$upd['appetite_max'] = $data['appetite_max'][$key];
					$upd['tolerance'] = $data['tolerance'][$key];
					$upd['tolerance_max'] = $data['tolerance_max'][$key];
					$upd['limit'] = $data['limit'][$key];
					$upd['limit_max'] = $data['limit_max'][$key];
					// $upd['strategi'] = $data['strategi'][$key];
					// $upd['kebijakan'] = $data['kebijakan'][$key];
					
					if(intval($row)>0)
					{
						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_SASARAN, 'field'=>$upd,'where'=>array('id'=>$row),'type'=>'update'));
					}
					else
					{
						$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_SASARAN, 'field'=>$upd,'type'=>'add'));
					}
				}
			}
		}

		if (isset($data['id_edit_in'])){
			if(count($data['id_edit_in'])>0){
				foreach($data['id_edit_in'] as $key=>$row)
				{
					$upd=array();
					$upd['rcsa_no'] = $newid;
					$upd['stakeholder_type'] = 1;
					$upd['stakeholder'] = $data['stakeholder_in'][$key];
					$upd['peran'] = $data['peran_in'][$key];
					$upd['komunikasi'] = $data['komunikasi_in'][$key];
					$upd['potensi'] = $data['potensi_in'][$key];
					
					if(intval($row)>0)
					{
						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_STAKEHOLDER, 'field'=>$upd,'where'=>array('id'=>$row),'type'=>'update'));
					}
					else
					{
						$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_STAKEHOLDER, 'field'=>$upd,'type'=>'add'));
					}
				}
			}
		}

		if (isset($data['id_edit_ex'])){
			if(count($data['id_edit_ex'])>0){
				foreach($data['id_edit_ex'] as $key=>$row)
				{
					$upd=array();
					$upd['rcsa_no'] = $newid;
					$upd['stakeholder_type'] = 2;
					$upd['stakeholder'] = $data['stakeholder_ex'][$key];
					$upd['peran'] = $data['peran_ex'][$key];
					$upd['komunikasi'] = $data['komunikasi_ex'][$key];
					$upd['potensi'] = $data['potensi_ex'][$key];
					
					if(intval($row)>0)
					{
						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_STAKEHOLDER, 'field'=>$upd,'where'=>array('id'=>$row),'type'=>'update'));
					}
					else
					{
						$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_STAKEHOLDER, 'field'=>$upd,'type'=>'add'));
					}
				}
			}
		}
		if (isset($data['id_edit_p'])){
			if(count($data['id_edit_p'])>0){
				foreach($data['id_edit_p'] as $key=>$row)
				{
					$upd=array();
					$upd['rcsa_no'] = $newid;
					$upd['kriteria_type'] = 1;
					$upd['deskripsi'] = $data['deskripsi_p'][$key];
					$upd['sangat_besar'] = $data['sangat_besar_p'][$key];
					$upd['sangat_kecil'] = $data['sangat_kecil_p'][$key];
					$upd['besar'] = $data['besar_p'][$key];
					$upd['sedang'] = $data['sedang_p'][$key];
					$upd['kecil'] = $data['kecil_p'][$key];
					
					if(intval($row)>0)
					{

						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_KRITERIA, 'field'=>$upd,'where'=>array('id'=>$row),'type'=>'update'));
					}
					else
					{
						$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_KRITERIA, 'field'=>$upd,'type'=>'add'));
					}
				}
			}
		}
		if (isset($data['id_edit_d'])){
			if(count($data['id_edit_d'])>0){
				foreach($data['id_edit_d'] as $key=>$row)
				{
					$upd=array();
					$upd['rcsa_no'] = $newid;
					$upd['kriteria_type'] = 2;
					$upd['deskripsi'] = $data['deskripsi_d'][$key];
					$upd['sub_kriteria_no'] = $data['sub_kriteria_no_d'][$key];
					$upd['sangat_besar'] = $data['sangat_besar_d'][$key];
					$upd['sangat_kecil'] = $data['sangat_kecil_d'][$key];
					$upd['besar'] = $data['besar_d'][$key];
					$upd['sedang'] = $data['sedang_d'][$key];
					$upd['kecil'] = $data['kecil_d'][$key];
					
					if(intval($row)>0)
					{
		
						$upd['update_user'] = $this->authentication->get_info_user('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_KRITERIA, 'field'=>$upd,'where'=>array('id'=>$row),'type'=>'update'));
					}
					else
					{
						$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_KRITERIA, 'field'=>$upd,'type'=>'add'));
					}
				}
			}
		}

		return true;
	}
	function get_data_tanggal($id_rcsa){

		$rows = $this->db->where('rcsa_no', $id_rcsa)->where('keterangan', 'Approve Risk Assessment')->order_by('create_date','DESC')->get(_TBL_LOG_PROPOSE,1)->result_array();
		return $rows;
	}
	function get_data_parent($owner_no){

		$rows = $this->db->select('parent_no')->where('id', $owner_no)->get(_TBL_OWNER)->result_array();
		return $rows;
	}
	function get_data_divisi($parent_no){

		$a = $parent_no[0]['parent_no'];
		$b = "1700";
		
		if ($a == 0) {
			$rows = $this->db->select('name')->where('id', $b)->get(_TBL_OWNER)->row();
		}else{
			$rows = $this->db->select('name')->where('id', $a)->get(_TBL_OWNER)->row();
		}
		return $rows;
		// var_dump($rows);
	}
	function get_data_officer($id_rcsa){
		$rows = $this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->result_array();
		return $rows;
	}




	function get_data_risk_register($id){
		// $rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
	
		$rows = $this->db->where('rcsa_no', $id)->order_by('urgensi_no_kadiv')->get(_TBL_VIEW_REGISTER)->result_array();

		//$rows = $this->db->where('rcsa_no', $id)->group_by('id_rcsa_detail')->order_by('urgensi_no_kadiv')->get(_TBL_VIEW_REGISTER)->result_array();

		foreach($rows as &$row){
			$arrCouse = json_decode($row['risk_couse_no'],true);
			
			$rows_couse=array();
			if ($arrCouse)
				$arrCouse_implode = implode(", ", $arrCouse);	
				$rows_couse  = $this->db->query("SELECT * FROM bangga_library WHERE id IN ($arrCouse_implode) ORDER BY FIELD(id, $arrCouse_implode)")->result_array(); //$this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[] = $rc['description'];
			}
			$row['couse']= implode('### ',$arrCouse);
			
			$arrCouse = json_decode($row['risk_impact_no'],true);
			$rows_couse=array();
			if ($arrCouse)
				$arrCouse_implode = implode(", ", $arrCouse);
				$rows_couse =  $this->db->query("SELECT * FROM bangga_library WHERE id IN ($arrCouse_implode) ORDER BY FIELD(id, $arrCouse_implode)")->result_array();  //$this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['description'];
			}
			$row['impact']=implode('### ',$arrCouse);
			
			$arrCouse = json_decode($row['accountable_unit'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['name'];
			}
			$row['accountable_unit_name']=implode('### ',$arrCouse);
			
			
			$arrCouse = json_decode($row['penangung_no'], true);
			$rows_couse=array();
			if ($arrCouse)
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['name'];
			}
			$row['penanggung_jawab']=implode('### ',$arrCouse);
			
			$arrCouse = json_decode($row['control_no'],true);
			if (!empty($row['note_control']))
				$arrCouse[]=$row['note_control'];
			// $row['control_name']=implode(', ',$arrCouse);
			$row['control_name']=implode('###',$arrCouse);

		}
		unset($row);

		return $rows;
	}
	function get_data_risk_reg_acc($id){
		 $rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
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

			$arrCouse = json_decode($row['inherent_impact'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LEVEL)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['code'];
			}
			// var_dump($arrCouse);
			// $row['impact']=implode('### ',$arrCouse);
			$row['code_impact']=$arrCouse;

			$arrCouse = json_decode($row['control_no'],true);
			if (!empty($row['note_control']))
				$arrCouse[]=$row['note_control'];
			// $row['control_name']=implode(', ',$arrCouse);

			// var_dump($arrCouse);
		// die();
			$row['control_name']=($arrCouse)?implode('###',$arrCouse):"";

		}
		unset($row);

		return $rows;
	}
	function get_realisasi($id){
		$rows = $this->db->where('rcsa_detail_no', $id)->order_by('progress_date')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();

		return $rows;
	}

	function get_peristiwa($rcsa_no){
		// doi::dump($rcsa_no)
		$rows=$this->db->where('rcsa_no',$rcsa_no)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$idArr=[];
		foreach($rows as $row){
			$idArr[]=$row['id'];
		}
		if ($idArr){
			$this->db->where_in('rcsa_detail_no',$idArr);
		}
		$rows_tmp = $this->db->select('rcsa_detail_no, count(id) as jml')->group_by('rcsa_detail_no')->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
		$arrMitigasi=[];
		foreach($rows_tmp as $row){
			$arrMitigasi[$row['rcsa_detail_no']]=$row['jml'];
		}

		if ($idArr){
			$this->db->where_in('rcsa_detail_no',$idArr);
		}
		$rows_tmp = $this->db->select('rcsa_detail_no, count(id) as jml')->group_by('rcsa_detail_no')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		$arrRealisasi=[];
		foreach($rows_tmp as $row){
			$arrRealisasi[$row['rcsa_detail_no']]=$row['jml'];
		}

		$peristiwa =[];
		foreach($rows as $row){
			$peristiwa[$row['sasaran_no']][$row['id']]=$row;
			$jmlMitigasi = 0;
			$jmlRealisasi = 0;
			if (array_key_exists($row['id'], $arrMitigasi)){
				$jmlMitigasi = $arrMitigasi[$row['id']];
			}
			if (array_key_exists($row['id'], $arrRealisasi)){
				$jmlRealisasi = $arrRealisasi[$row['id']];
			}
			$peristiwa[$row['sasaran_no']][$row['id']]['jml_mitigasi']=$jmlMitigasi;
			$peristiwa[$row['sasaran_no']][$row['id']]['jml_realisasi']=$jmlRealisasi;
		}
		$rows=$this->db->where('rcsa_no',$rcsa_no)->get(_TBL_RCSA_SASARAN)->result_array();
		$sasaran =[];
		foreach($rows as $row){
			$sasaran[$row['id']]['nama']=$row['sasaran'];
			if (array_key_exists($row['id'], $peristiwa)){
				$sasaran[$row['id']]['detail'] = $peristiwa[$row['id']];
			}else{
				$sasaran[$row['id']]['detail'] = [];
			}
		}

		return $sasaran;
	}
	
	function simpan_risk_event($data){
		$upd=array();
		$upd['rcsa_no']=$data['rcsa_no'];
		$upd['event_no']=$data['risk_event_no'][0];
		$upd['sasaran_no']=$data['sasaran'];
		$upd['subrisiko']=$data['subrisiko'];
		// $upd['risk_area_id']= $data['area'];
		$upd['kategori_no']= $data['kategori'];
		$upd['sub_kategori']= $data['sub_kategori'];
		$upd['risk_impact_kuantitatif']=str_replace(',','',$data['risk_impact_kuantitatif']);
		// doi::dump($upd);
		$couse=array();
		
		foreach($data['risk_couse_no'] as $key=>$row){
			if (intval($row)>0 && !in_array($row, $couse))
				$couse[]=$row;
		}
		$upd['risk_couse_no']=json_encode($couse);
		
		$impact=array();
		foreach($data['risk_impact_no'] as $key=>$row){
			if (intval($row)>0 && !in_array($row, $impact))
				$impact[]=$row;
		}
		$upd['risk_impact_no']=json_encode($impact);

		if (intval($data['id_edit'])>0){
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$where['id']=$data['id_edit'];
			$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_DETAIL, 'field'=>$upd,'where'=>array('id'=>$data['id_edit']),'type'=>'update'));
			$id=intval($data['id_edit']);
		}else{
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$id=$this->crud->crud_data(array('table'=>_TBL_RCSA_DETAIL, 'field'=>$upd,'type'=>'add'));
			$id=$this->db->insert_id();
		}
		return $id;
	}

	function simpan_risk_level($data){
		$upd=array();
		$upd['rcsa_no']=$data['rcsa_no'];
		$upd['inherent_likelihood']=$data['inherent_likelihood'];
		$upd['inherent_impact']=$data['inherent_impact'];
		$upd['inherent_level']=$data['inherent_level'];
		$upd['note_control']=$data['note_control'];
		$upd['risk_control_assessment']=$data['risk_control_assessment'];
		$upd['treatment_no']=$data['treatment_no'];
		$check_item=array();
		if(array_key_exists('check_item', $data)){
			foreach($data['check_item'] as $row){
				$check_item[]=$row;
			}
		}
		$upd['control_no']=json_encode($check_item);

		if (intval($data['id_edit'])>0){
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$where['id']=$data['id_edit'];
			$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_DETAIL, 'field'=>$upd,'where'=>array('id'=>$data['id_edit']),'type'=>'update'));
			$id=intval($data['id_edit']);
		}
		return $id;
	}

	function simpan_mitigasi($data){
		$upd=array();
		$upd['rcsa_detail_no']=$data['id_detail'];
		$upd['proaktif']=$data['proaktif'];
		$upd['reaktif']=$data['reaktif'];
		$upd['amount']=str_replace(',','',$data['amount']);
		$upd['sumber_daya']=$data['sumber_daya'];
		if (!empty($data['target_waktu']))
			$upd['target_waktu']=date('Y-m-d',strtotime($data['target_waktu']));
		
		$accountable_no=array();
		foreach($data['owner_no_action_accountable'] as $key=>$row){
			$accountable_no[]=$row;
		}
		$upd['accountable_unit']=json_encode($accountable_no);
		
		$accountable_no=array();
		foreach($data['owner_no_action'] as $key=>$row){
			$accountable_no[]=$row;
		}
		$upd['owner_no']=json_encode($accountable_no);
				
		if ((int)$data['id_edit_mitigasi']>0){
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$upd['update_date'] = Doi::now();

			$where['id']=$data['id_edit_mitigasi'];
			$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION, 'field'=>$upd,'where'=>$where,'type'=>'update'));
			$id=intval($data['id_edit_mitigasi']);
			$type="edit";
		}else{
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$id=$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION, 'field'=>$upd,'type'=>'add'));
			$id=$this->db->insert_id();
			$type="add";
		}
		return $id;
	}

	function simpan_realisasi($data){
		$upd=array();

		// Doi::dump($_FILES);
		// Doi::dump($data);die();
		$upd['rcsa_action_no']=$data['rcsa_action_no'];
		$upd['realisasi']=$data['realisasi'];
		$upd['progress_detail']=$data['progress'];
		$upd['status_loss']=$data['status_loss'];
		// $upd['notes']=$data['notes'];
        $upd['keterangan']=$data['keterangan'];

		$sts=$data['progress'];
		if(floatval($data['progress'])>=100)
			$sts=1;
		// $upd['status_no']=$sts;
		$upd['status_no']=$data['status_no'];
		$upd['residual_likelihood_action']=$data['residual_likelihood'];
		$upd['residual_impact_action']=$data['residual_impact'];
		$upd['risk_level_action']=$data['inherent_level'];
		if (!empty($data['progress_date']))
			$upd['progress_date']=date('Y-m-d',strtotime($data['progress_date']));
		
		// $pelaksana_no=array();
		// foreach($data['pelaksana_no'] as $key=>$row){
		// 	$pelaksana_no[]=$row;
		// }
		// $upd['pelaksana_no']=json_encode($pelaksana_no);

		if ((int)$data['id_edit']>0){
			$upd['update_user'] = $this->authentication->get_info_user('username');

			$where['id']=$data['id_edit'];
			$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION_DETAIL, 'field'=>$upd,'where'=>$where,'type'=>'update'));
			$id=intval($data['id_edit']);
			$type="edit";
		}else{
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$id=$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION_DETAIL, 'field'=>$upd,'type'=>'add'));
			$id=$this->db->insert_id();
			$type="add";
		}


		$upd=[];

		$rows = $this->db->where('rcsa_action_no',$data['rcsa_action_no'])->order_by('progress_date', 'desc')->limit(1)->get(_TBL_RCSA_ACTION_DETAIL)->row_array();
		if ($rows){
			$upd['residual_likelihood']=$rows['residual_likelihood_action'];
			$upd['residual_impact']=$rows['residual_impact_action'];
			$upd['risk_level']=$rows['risk_level_action'];
			$upd['status_loss_parent']=$rows['status_loss'];
			$where['id']=$data['detail_rcsa_no'];
			$result=$this->crud->crud_data(array('table'=>_TBL_RCSA_DETAIL, 'field'=>$upd,'where'=>$where,'type'=>'update'));
		}

		// $where['id']=$data['action_no'];
		// $result=$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION, 'field'=>['status_loss'=>$data['status_loss']],'where'=>$where,'type'=>'update'));

		return $id;
	}

	function get_data_risk_register_propose($id){
		$rows = $this->db->where('id', $id)->get(_TBL_RCSA)->row_array();
		$sts=false;
		$ket="";
		if ($rows){
			if ($rows['sts_propose']==1){
				$ket = "Assessment Masih dalam proses Approve di KaDep!!<br/>Tanggal Propose : ".date('d M Y', strtotime($rows['date_propose']));
				$sts=true;

			}elseif ($rows['sts_propose']==2){
				$ket = "Assessment Masih dalam proses Approve di KaDiv!!<br/>Tanggal Propose : ".date('d M Y', strtotime($rows['date_propose_kadep']));
				$sts=true;	
			}elseif ($rows['sts_propose']==3){
				$ket = "Assessment Masih dalam proses Approve di Admin RISK!!<br/>Tanggal Propose : ".date('d M Y', strtotime($rows['date_propose_kadiv']));
				$sts=true;	
			}elseif ($rows['sts_propose']==4){
				$ket = "Assessment Sudah selesai di Aproved Admin RISK pada tanggal ".date('d M Y', strtotime($rows['date_propose_admin']));
				$sts=true;
			}
		}
		$hasil['field']=$ket;
		if (!$sts){
			$rsca_detail_no=[];
			$rows = $this->db->where('rcsa_no', $id)->where('urgensi_no', 0)->where('type', 1)->get(_TBL_VIEW_REGISTER)->result_array();
			// echo $this->db->last_query();
			foreach($rows as &$row){
				$arrCouse = json_decode($row['risk_couse_no'],true);
				if ($arrCouse){
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
					$arrCouse=array();
					foreach($rows_couse as $rc){
						$arrCouse[]=$rc['description'];
					}
				}
				$row['couse']= implode('### ',$arrCouse);
				
				$arrCouse = json_decode($row['risk_impact_no'],true);
				if ($arrCouse){
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
					$arrCouse=array();
					foreach($rows_couse as $rc){
						$arrCouse[]=$rc['description'];
					}
				}
				$row['impact']=implode('### ',$arrCouse);
				
				$arrCouse = json_decode($row['accountable_unit'],true);
				$rows_couse=array();
				if ($arrCouse)
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
				$arrCouse=array();
				foreach($rows_couse as $rc){
					$arrCouse[]=$rc['name'];
				}
				
				$row['penanggung_jawab']=implode('### ',$arrCouse);
				
				$arrCouse = json_decode($row['penangung_no'], true);
				$rows_couse=array();
				if ($arrCouse)
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
				$arrCouse=array();
				foreach($rows_couse as $rc){
					$arrCouse[]=$rc['name'];
				}
				$row['accountable_unit_name']=implode('### ',$arrCouse);
				
				// $row['control_no']=implode('###',$arrCouse);

				$arrCouse = json_decode($row['control_no'],true);

				if (!empty($row['note_control']))
					$arrCouse[]=$row['note_control'];
				// $row['control_name']=implode(', ',$arrCouse);
				$row['control_name']=implode('###',$arrCouse);
				$rsca_detail_no[]=$row['id_rcsa_detail'];
			}
			unset($row);
			$hasil['field']=$rows;
			$hasil['rcsa_detail']=json_encode($rsca_detail_no);
		}
		$hasil['status']=$sts;
		// die($this->db->last_query());
		return $hasil;
	}

	function delete_sasaran($id){		//delete for table sasaran at rcsa/edit
		$query = $this->db->query("DELETE FROM bangga_rcsa_sasaran WHERE id='$id'");
		return $query;
	}

	function delete_stakeholder($id){ //delete for table stakeholder at rcsa/edit
		$query = $this->db->query("DELETE FROM bangga_rcsa_stakeholder WHERE id='$id'");
		return $query;
	}

	function delete_kriteria($id){ //delete for table kriteria at rcsa/edit
		$query = $this->db->query("DELETE FROM bangga_rcsa_kriteria WHERE id='$id'");
		return $query;
	}

	function save_library_new( $data = array(),$newid = 0, $tipe = 1, $mode = 'new', $old_data = array())
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


}
/* End of file app_login_model.php */