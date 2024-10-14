<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}

    function get_realisasi($id,$bulan)
    {
        $rows = $this-> db->where('rcsa_detail_no', $id)->where('bulan', $bulan)->order_by('progress_date')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
// doi::dump($id);
        return $rows;
    }
    function simpan_realisasi_kri($data)
    {
        $rows = $this->db->where('rcsa_detail', $data['id'])->where('bulan', $data['bulan'])->get(_TBL_KRI_DETAIL)->row_array();
        // doi::dump($data);
        // doi::dump($rows);
        // die('cek');

if($rows){

    // doi::dump('edit');
    $updkri['rcsa_detail'] = $data['id'];
    $updkri['realisasi'] = $data['realisasi'];

            $where['rcsa_detail'] = $data['id'];
            $where['bulan'] = $data['bulan'];
            $updkri['update_user'] = $this->authentication->get_info_user('username');
            $result = $this->crud->crud_data(array('table' => _TBL_KRI_DETAIL, 'field' => $updkri, 'where' => $where, 'type' => 'update'));
        }else{
    // doi::dump('add');

            $kridet['realisasi'] = $data['realisasi'];
            $kridet['rcsa_detail'] = $data['id'];
            $kridet['bulan'] = $data['bulan'];
            // $kridet['action_detail'] = $id;

            $kridet['create_user'] = $this->authentication->get_info_user('username');
            $result = $this->crud->crud_data(array('table' => _TBL_KRI_DETAIL, 'field' => $kridet, 'type' => 'add'));
            $id = $this->db->insert_id();
}
// die();
        return $result;

        // Doi::dump($data);

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
    function simpan_realisasi($data)
    {
        $upd = array();

        // Doi::dump($_FILES);

         $upd['damp_loss'] = $data['damp_loss'];
        $upd['risk_control'] = $data['risk_control'];
        $upd['rcsa_action_no'] = $data['rcsa_action_no'];
        $upd['bulan'] = $data['bulan'];
        $upd['realisasi'] = $data['realisasi'];
        $upd['progress_detail'] = $data['progress'];
        $upd['status_loss'] = $data['status_loss'];
        // $upd['notes']=$data['notes'];
        $upd['keterangan'] = $data['keterangan'];
        $upd['perlakuan_risiko'] = $data['perlakuan_risiko'];

        $sts = $data['progress'];
        if (floatval($data['progress']) >= 100)
        $sts = 1;
        // $upd['status_no']=$sts;
        $upd['rcsa_detail'] = $data['detail_rcsa_no'];

        $upd['status_no'] = $data['status_no'];
        $upd['residual_likelihood_action'] = $data['residual_likelihood'];
        $upd['residual_impact_action'] = $data['residual_impact'];
        $upd['risk_level_action'] = $data['inherent_level'];
        if (!empty($data['progress_date']))
        $upd['progress_date'] = date('Y-m-d', strtotime($data['progress_date']));

        if ((int)$data['id_edit'] > 0) {
            // die('model');

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

        return $result;
    }

    public function getDetail($data, $limit, $offset) {

        if($data['periode']){
            $this->db->where('tahun', $data['periode']);
        }

        if($data['owner']){
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('owner_no', $this->owner_child);     
        }

        $this->db->where('sts_propose', 4);

        $this->db->limit($limit, $offset);

        return $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
    }
     
    public function count_all_data($data) {
        if($data['periode']){
            $this->db->where('tahun', $data['periode']);
        }
        if($data['owner']){
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('owner_no', $this->owner_child);     
        }
        $this->db->where('sts_propose', 4);

        return $this->db->count_all_results(_TBL_VIEW_RCSA_DETAIL);
    }
    
    function getMonthlyMonitoringGlobal($q, $month)
	{
 		 
		$act = $this->db
			->select('id')
			->where('rcsa_detail_no',$q['id'])
 			->get('bangga_rcsa_action')->row_array();


		$data['kri'] = $this->db
			->where('rcsa_detail',$q['id'])
			->get(_TBL_KRI)->row_array();
 		$data['kri_detail'] = $this->db
		->where('rcsa_detail', $data['kri']['rcsa_detail'])
		->where('bulan',  $month)
		->get(_TBL_KRI_DETAIL)->row_array();

		$data['data'] = $this->db
			->where('rcsa_action_no', $act['id'])
			->where('bulan', $month)
			->get('bangga_view_rcsa_action_detail')->row_array();

 
			$detail = $this->db
			->select('periode_name')
			->where('id',$q['id'])
 			->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
			
		$blnnow = date('m');
		$thnRcsa   = substr( $detail['periode_name'], 0, 4 );
		$tgl           = 01;

		$dateRcsa  = new DateTime( $thnRcsa . '-' . $month . '-' . $tgl );
		$hariIni   = new DateTime();
		// doi::dump($dateRcsa);
		// doi::dump($hariIni);
		if($hariIni >= $dateRcsa ){
			
		

		// if ($blnnow >= $month) {


			$data['before'] = $this->db
				->where('rcsa_action_no', $act['id'])
				->where('bulan', $month - 1)
				->get('bangga_view_rcsa_action_detail')->row_array();
		}

        $realisasi = $data['kri_detail']['realisasi'];
        $level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
        $level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
        $level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
        if ($data['kri']) {
            $krnm = "K R I";
            if (in_array($realisasi, $level_1)) {
                $bgres = 'style="background-color: #7FFF00;color: #000;"';
            } elseif (in_array($realisasi, $level_2)) {
                $bgres = 'style="background-color: #FFFF00;color:#000;"';
            } elseif (in_array($realisasi, $level_3)) {
                $bgres = 'class="bg-danger" style=" color: #000;"';
            } else {
                $bgres = '';
            }
        } else {
            $bgres = '';
        }

        $monthly = $data['data'];
        $like_impact = $this->data->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
        $progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
        $progress_detail = $like_impact['like']['code'] . ' x ' . $like_impact['impact']['code'];

        $monthbefore = $data['before'];

        if (!$monthbefore && $month !=1) {
			$result = '<i class="  fa fa-times-circle text-danger"></i>';
		} else {
        if (!$monthly) {
            $result = '<a style="z-index: -1;" href="' . base_url('risk_monitoring/update/' . $q['id'] . '/' . $q['rcsa_no'] . '/' . $month) . '" class=" style="z-index: -1;"propose pointer btn btn-light" data-id="' . $q['id'] . '"><i class="icon-pencil"></i></a>';
        } else {
            $result = '<a class="propose" href="' . base_url('risk_monitoring/update/' . $q['id'] . '/' . $q['rcsa_no'] . '/' . $month) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
        }
    }

 		return $result;
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
/* Location: ./application/models/app_login_model.php */