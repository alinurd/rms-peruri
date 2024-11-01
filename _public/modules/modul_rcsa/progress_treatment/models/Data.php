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
 
        // $upd['target_progress_detail'] = $data['target_progress']; 
        // $upd['target_damp_loss']       = $data['target_damp_loss']; 
        $upd['progress_detail']        = $data['progress']; 
        $upd['damp_loss']              = $data['damp_loss']; 

        $sts = $data['progress'];
        if (floatval($data['progress']) >= 100)
        $sts = 1;
        // $upd['status_no']=$sts;
        //  if (!empty($data['progress_date']))
 
        if ((int)$data['id_edit'] > 0) {
            // die('model');

            $upd['update_user'] = $this->authentication->get_info_user('username');
            
            $where['id'] = $data['id_edit'];
            $where['bulan'] = $data['month'];
            $result = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'where' => $where, 'type' => 'update'));
            $id = intval($data['id_edit']);

            $type = "edit";
        }  

        // $where['id']=$data['action_no'];
        // $result=$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION, 'field'=>['status_loss'=>$data['status_loss']],'where'=>$where,'type'=>'update'));

        return $result;
    }

    public function getDetail($data, $limit, $offset) {

      

        if($data['owner']){
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('owner_no', $this->owner_child);     
        }

        if($data['periode']){
            $this->db->where('tahun', $data['periode']);
        }
        $this->db->where('sts_propose', 4);

        $this->db->limit($limit, $offset);

        return $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
    }
     
    public function count_all_data($data) {
      
        if($data['owner']){
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('owner_no', $this->owner_child);     
        }

        if($data['periode']){
            $this->db->where('tahun', $data['periode']);
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

		$data['data'] = $this->db
			->where('rcsa_action_no', $act['id'])
			->where('bulan', $month)
			->get('bangga_view_rcsa_action_detail')->row_array();

		$data['risk_treatment'] = $this->db
			->where('rcsa_detail_no', $q['id'])
			->where('bulan', $month)
			->get('bangga_rcsa_treatment')->row_array();

		$detail = $this->db
			->select('periode_name')
			->where('id',$q['id'])
 			->get(_TBL_VIEW_RCSA_DETAIL)->row_array();

        // Cek apakah bulan ada dalam lost event
        $cek_ = $this->db
            ->select('damp_loss')
            ->where('rcsa_action_no', $act['id'])
            ->where('bulan', $month)
            ->get(_TBL_RCSA_ACTION_DETAIL)
            ->row_array();
			
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
 

        $monthly = $data['data']; 
        $data_risk_treatment = $data['risk_treatment'];
        $monthbefore = $data['before'];
        $currentMonth = date('n');

 
 

        
        if (!$monthbefore && $month !=1) {
			$result = '<td colspan="2" style="vertical-align:middle;"><center><i class="  fa fa-times-circle text-danger"></i></center></td>';
		} else {
            if (!$monthly) {
                $result = '<td colspan="2" style="vertical-align:middle;"><center><i class="  fa fa-times-circle text-warning" title="Level Risiko belum lengkap"></i></center></td>';

            } else {
                $result = '
                    <td colspan="2">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 10px; vertical-align: top;">
                                    <div class="input-group">
                                        <input readonly type="number" name="target_progress'.$data['data']['id'].$month.'" id="target_progress'.$data['data']['id'].$month.'" class="form-control" placeholder="Progress %" value="'.$data_risk_treatment['target_progress_detail'].'" aria-describedby="basic-addon2">
                                        <span class="input-group-addon" id="basic-addon2">%</span>
                                    </div>
                                </td>
                                <td style="padding: 10px; vertical-align: top;">
                                    <div class="input-group">
                                        <input type="number" name="progress'.$data['data']['id'].$month.'" id="progress'.$data['data']['id'].$month.'" class="form-control" placeholder="Progress %" value="'.$data['data']['progress_detail'].'" aria-describedby="basic-addon2">
                                        <span class="input-group-addon" id="basic-addon2">%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; vertical-align: top;">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">Rp.</span>
                                        <input readonly type="text" name="target_damp_loss'.$data['data']['id'].$month.'" id="target_damp_loss'.$data['data']['id'].$month.'" 
                                        value="'.number_format($data_risk_treatment['target_damp_loss'],0,',',',').'" class="form-control numeric rupiah" placeholder="Damp Loss" aria-describedby="basic-addon1">
                                    </div>
                                </td>
                                <td style="padding: 10px; vertical-align: top;">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">Rp.</span>
                                        <input type="text" name="damp_loss'.$data['data']['id'].$month.'" id="damp_loss'.$data['data']['id'].$month.'" 
                                        value="'.number_format($data['data']['damp_loss'],0,',',',').'" class="form-control numeric rupiah" placeholder="Damp Loss" aria-describedby="basic-addon1">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <div style="text-align: center; margin-top: 15px;">
                            <button type="button" class="btn btn-primary" id="simpan_realisasi_'.$data['data']['id'].'" data-month="'.$month.'" data-id="'.$data['data']['id'].'">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            </button>
                        </div>
                    </td>
                ';



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