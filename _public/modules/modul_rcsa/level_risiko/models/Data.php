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
    
    function getMonthlyMonitoringGlobal($q, $month)
	{
        $act                = $this->db->select('id')->where('rcsa_detail_no',$q['id'])->get('bangga_rcsa_action')->row_array();
		$data['data']       = $this->db->where('rcsa_action_no', $act['id'])->where('bulan', $month)->get('bangga_view_rcsa_action_detail')->row_array();
        $detail             = $this->db->select('periode_name')->where('id',$q['id'])->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
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
        // var_dump($monthly);
        if (!$monthbefore && $month !=1) {
			$result         = '<i class="  fa fa-times-circle text-danger"></i>';
		} else {
                
            $result = '
            <form id="form_' . $q['id'] . '_' . $month . '" class="form-monitoring" method="POST" style="width: 100%; padding: 0; margin: 0;" action="'.base_url('level_risiko' . '/save').'">
                <input type="hidden" name="rcsa_detail_no" value="' . $q['id'] . '">
                <input type="hidden" name="rcsa_action_no" value="' . $act['id'] . '">
                <input type="hidden" name="id" value="' . $q['id'] . '">
                <input type="hidden" name="rcsa_no" value="' . $q['rcsa_no'] . '">
                <input type="hidden" name="month" value="' . $month . '">
                <input type="hidden" name="id_edit" value="' . $q['id'] . '">
                <input type="hidden" name="inherent_level" id="inherent_level' . $q['id'] . '_' . $month . '" value="' . $monthly['risk_level_action'] . '">
                
                <div style="display: flex; justify-content: space-between; width: 100%; padding: 0; margin-bottom: 10px;">
                    ' . form_dropdown('likehold', $cboLike, $monthly['residual_likelihood_action'], 'class="form-control select2" data-mode="3" id="likehold" data-id="'.$q['id'].'" data-month="' . $month . '" style="width:50%;"') . '
                    ' . form_dropdown('impact', $cboImpact, $monthly['residual_impact_action'], 'class="form-control select2" data-mode="3" id="impact" data-id="'.$q['id'].'" data-month="' . $month . '" style="width:50%"') . '
                </div>
        
                <div style="text-align: center; margin-bottom: 10px;">
                    <span id="targetResidualLabel'.$q['id'].$month. '">
                        <span class="btn" style="display: inline-block; width: 100%; background-color: ' . $monthly['warna_action'] . '; color: ' . $monthly['warna_text_action'] . '; padding: 4px 8px;">
                            ' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']
                        </span>
                    </span>
                </div>
        
                <div style="text-align: center; margin-top: 10px;">
                    <button type="submit" class="btn btn-primary btn-submit" data-id="' . $q['id'] . '" data-month="' . $month . '" style="width: 100%; height: 40px;">Simpan</button>
                </div>
            </form>
        ';
        
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