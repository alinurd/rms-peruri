<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}

    function get_realisasi($id,$bulan)
    {
        $rows = $this-> db->where('rcsa_detail_no', $id)->where('bulan', $bulan)->order_by('progress_date')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
        return $rows;
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

    function simpan_realisasi($data){
        $upd                                = [];
		$id 		                        = $data['rcsa_detail_no'];
		$rcsa_no 	                        = $data['rcsa_no'];
		$month 		                        = $data['month'];
		$likehold 	                        = $data['likehold'];
		$impact 	                        = $data['impact'];
		$upd['rcsa_detail'] 				= $id;
		$upd['bulan'] 						= $month;
		$upd['residual_likelihood_action'] 	= $likehold;
		$upd['residual_impact_action'] 		= $impact;
		$upd['create_date'] 				= date('Y-m-d H:i:s');
		$upd['create_user'] 				= $this->authentication->get_info_user('username');
		$upd['rcsa_action_no']              = $data['rcsa_action_no'];
		$upd['risk_level_action']           = $data['inherent_level'];
	
		// doi::dump($upd);
		// die('ctr');
		// Simpan data ke dalam tabel (misalnya, 'level_risiko_data')
		
		if ((int)$data['id_edit'] > 0) {
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$where['id'] = $data['id_edit'];
			$where['bulan'] = $data['month'];
			$result = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'where' => $where, 'type' => 'update'));
			$id = intval($data['id_edit']);
			$type = "edit";
		} else {
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$id = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'type' => 'add'));
			$id = $this->db->insert_id();
			$type = "add";
		}
	
		// $id = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'type' => 'add'));
		// $id = $this->db->insert_id();
		
		$upd = [];
		$rows = $this->db->where('rcsa_action_no', $data['rcsa_action_no'])->order_by('progress_date', 'desc')->limit(1)->get(_TBL_RCSA_ACTION_DETAIL)->row_array();
		if ($rows) {
			$upd['residual_likelihood']     = $rows['residual_likelihood_action'];
			$upd['residual_impact']         = $rows['residual_impact_action'];
			$upd['risk_level']              = $rows['risk_level_action'];
			$upd['status_loss_parent']      = $rows['status_loss'];
			$where['id']                    = $id;
			$result = $this->crud->crud_data(array('table' => _TBL_RCSA_DETAIL, 'field' => $upd, 'where' => $where, 'type' => 'update'));
		}
		return $result;
    }
    
    function getMonthlyMonitoringGlobal($q, $month)
	{
        $act                = $this->db->select('id')->where('rcsa_detail_no',$q['id'])->get('bangga_rcsa_action')->row_array();
		$data['data']       = $this->db->where('rcsa_action_no', $act['id'])->where('bulan', $month)->get('bangga_view_rcsa_action_detail')->row_array();
        $detail             = $this->db->select('periode_name')->where('id',$q['id'])->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
        $cek_id_detail      = $this->db->select('id')->where('rcsa_detail',$q['id'])->where('bulan', $month)->get(_TBL_RCSA_ACTION_DETAIL)->row_array();
		$blnnow             = date('m');
		$thnRcsa            = substr( $detail['periode_name'], 0, 4 );
		$tgl                = 01;
		$dateRcsa           = new DateTime( $thnRcsa . '-' . $month . '-' . $tgl );
		$hariIni            = new DateTime();
		if($hariIni >= $dateRcsa ){
			$data['before'] = $this->db->where('rcsa_action_no', $act['id'])->where('bulan', $month - 1)->get('bangga_view_rcsa_action_detail')->row_array();
		}
        $monthly            = $data['data'];
        $like_impact        = $this->data->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
        $progress_detail    = $like_impact['like']['code'] . ' x ' . $like_impact['impact']['code'];
        $cboLike            = $q['cb_like'];
        $cboImpact          = $q['cb_impact'];
        $monthbefore        = $data['before'];
        $currentMonth       = date('n');
        if (!$monthbefore && $month !=1) {
			$result         = '<i class="  fa fa-times-circle text-danger"></i>';
		} else {
                
            // <form id="form_' . $q['id'] . '_' . $month . '" class="form-monitoring" method="POST" style="width: 100%; padding: 0; margin: 0;">
            $result = '
                <input type="hidden" id="rcsa_detail_no_' . $q['id'] . '_' . $month . '" name="rcsa_detail_no" value="' . $q['id'] . '">
                <input type="hidden" id="rcsa_action_no_' . $q['id'] . '_' . $month . '" name="rcsa_action_no" value="' . $act['id'] . '">
                <input type="hidden" id="id_' . $q['id'] . '_' . $month . '" name="id" value="' . $q['id'] . '">
                <input type="hidden" id="rcsa_no_' . $q['id'] . '_' . $month . '" name="rcsa_no" value="' . $q['rcsa_no'] . '">
                <input type="hidden" id="month_' . $q['id'] . '_' . $month . '" name="month" value="' . $month . '">
                <input type="hidden" id="id_edit_' . $q['id'] . '_' . $month . '" name="id_edit" value="' . (isset($cek_id_detail) ? $cek_id_detail['id'] : 0) . '">
                <input type="hidden" name="inherent_level" id="inherent_level' . $q['id'] . '_' . $month . '" value="' . $monthly['risk_level_action'] . '">
                
                <div style="display: flex; justify-content: space-between; width: 100%; padding: 0; margin-bottom: 10px;">
                    ' . form_dropdown('likehold', $cboLike, $monthly['residual_likelihood_action'], 'class="form-control select2" data-mode="3" id="likehold' . $q['id'] . '_' . $month . '" data-id="' . $q['id'] . '" data-month="' . $month . '" style="width:50%;"') . '
                    ' . form_dropdown('impact', $cboImpact, $monthly['residual_impact_action'], 'class="form-control select2" data-mode="3" id="impact' . $q['id'] . '_' . $month . '" data-id="' . $q['id'] . '" data-month="' . $month . '" style="width:50%"') . '
                </div>

                <div style="text-align: center; margin-bottom: 10px;">
                    <span id="targetResidualLabel' . $q['id'] . $month . '">
                        <span class="btn" style="display: inline-block; width: 100%; background-color: ' . $monthly['warna_action'] . '; color: ' . $monthly['warna_text_action'] . '; padding: 4px 8px;">
                            ' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']
                        </span>
                    </span>
                </div>';

                if(!$monthly || $currentMonth == $monthly['bulan'] ){
                    $result .= '<div style="text-align: center; margin-top: 10px;">
                    <span class="btn btn-primary" id="simpan_level_risiko_' . $q['id'] . '" data-id="' . $q['id'] . '" data-month="' . $month . '" style="width: 100%; height: 40px;"><i class="fa fa-floppy-o" aria-hidden="true"></i></span>
                </div>';
                }

                // </form>
        
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