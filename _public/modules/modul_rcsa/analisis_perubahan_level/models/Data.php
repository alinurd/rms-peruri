<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_realisasi($id, $bulan)
    {
        $rows = $this->db->where('rcsa_detail_no', $id)->where('bulan', $bulan)->order_by('progress_date')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
        return $rows;
    }


    public function getDetail($data, $limit, $offset)
    {



        if ($data['owner']) {
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('owner_no', $this->owner_child);
        }

        if ($data['periode']) {
            $this->db->where('tahun', $data['periode']);
        }
        $this->db->where('sts_propose', 4);

        $this->db->limit($limit, $offset);

        return $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
    }


    public function count_all_data($data)
    {

        if ($data['owner']) {
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('owner_no', $this->owner_child);
        }

        if ($data['periode']) {
            $this->db->where('tahun', $data['periode']);
        }

        $this->db->where('sts_propose', 4);

        return $this->db->count_all_results(_TBL_VIEW_RCSA_DETAIL);
    }

    function getMonthlyMonitoringGlobal($id, $month, $inh)
    {
        $act                = $this->db->select('id')->where('rcsa_detail_no', $id)->get('bangga_rcsa_action')->row_array();
        $monitoring       = $this->db->where('rcsa_action_no', $act['id'])->where('bulan', $month)->get('bangga_view_rcsa_action_detail')->row_array();
        $l        = $this->data->level_action($monitoring['residual_likelihood_action'], $monitoring['residual_impact_action']);
        $resLv    = $l['like']['code'] . ' x ' . $l['impact']['code'];
        $keterangan_pl=$monitoring['keterangan_pl'];
        $lv = '
        <a class="btn" data-toggle="popover" data-content="
        <center>
        ' . $resLv . '<br> 
        ' . $monitoring['inherent_analisis_action'] . '
        </center>
        " style="padding:4px; height:4px 8px;width:100%;background-color:' . $monitoring['warna_action'] . ';color:' . $monitoring['warna_text_action'] . ';"> &nbsp;</a>';
        $r = 0;
        if ($monitoring['inherent_analisis_action'] == "High") {
            $r = 5;
        } elseif ($monitoring['inherent_analisis_action'] == "Moderate to High") {
            $r = 4;
        } elseif ($monitoring['inherent_analisis_action'] == "Moderate") {
            $r = 3;
        } elseif ($monitoring['inherent_analisis_action'] == "Low to Moderate") {
            $r = 2;
        } elseif ($monitoring['inherent_analisis_action'] == "Low") {
            $r = 1;
        }

        if ($inh == "High") {
            $Inh = 5;
        } elseif ($inh == "Moderate to High") {
            $Inh = 4;
        } elseif ($inh == "Moderate") {
            $Inh = 3;
        } elseif ($inh == "Low to Moderate") {
            $Inh = 2;
        } elseif ($inh == "Low") {
            $Inh = 1;
        }

        if ($r == $Inh) {
            $pl = ' 
                                      <span class="btn " data-toggle="popover" data-content="level risiko stabil" style="padding:4px; height:4px 8px;width:100%;">
                <i style=" font-size: 30px;" class="glyphicon glyphicon-resize-horizontal text-primary" aria-hidden="true"></i> 
            </span>

                         ';
        } elseif ($r > $Inh) {
            $pl = ' 

                      <span class="btn " data-toggle="popover" data-content="terjadi kenaikan level risiko" style="padding:4px; height:4px 8px;width:100%;">
                <i style=" font-size: 30px;" class="fa fa-arrow-up text-danger" aria-hidden="true"></i> 
            </span>

         ';
        } elseif ($r<$Inh) {
            $pl = '
                    <span class="btn " data-toggle="popover" data-content="terjadi penurunan level risiko" style="padding:4px; height:4px 8px;width:100%;">
                <i style=" font-size: 30px;" class="fa fa-arrow-down text-success" aria-hidden="true"></i> 
            </span>';
        } else {
            $result['pl']         = '<center> <i class="  fa fa-times-circle text-danger"></i></center>';
        }
         if (!$monitoring || empty($l['impact'])|| empty($l['like'])) {
            $result['lv']           = '<center>-</center>';
            $result['pl']           = '<center> <i class="  fa fa-times-circle text-danger"></i></center>';
            $result['ket']          = '<center> <i class="  fa fa-times-circle text-danger"></i></center>';
        } else {
            $result['lv'] = $lv;
            $result['pl'] = $pl;
            $result['ket'] = '
                <div style="text-align: center; margin-bottom: 10px;">

                 <textarea name="keterangan_' . $id . '' . $month . '"   rows="4" cols="2" style="width: 100%;">'.$keterangan_pl.'</textarea>
                </div>
                <br>
                  <center><span class="btn btn-primary text-white" id="simpan_realisasi_' . $id . '" data-month="' . $month . '" data-id="' . $id . '">
                  <i class="fa fa-floppy-o" aria-hidden="true"></i> </span></center>
         ';
        }

        return $result;
    }

    public function level_action($like, $impact)
    {
        $result['like'] = $this->db
            ->where('id', $like)
            ->get('bangga_level')->row_array();

        $result['impact'] = $this->db
            ->where('id', $impact)
            ->get('bangga_level')->row_array();

        return $result;
    }

    function simpan_realisasi($data){
        $upd                                = [];
		$id 		                        = $data['id'];  
		$month 		                        = $data['month'];  
		$upd['keterangan_pl'] 				= $data['keterangan']; 
	 
        $monitoring       = $this->db->where('rcsa_detail', $id)->where('bulan', $month)->get('bangga_rcsa_action_detail')->row_array();

		if ((int)$monitoring > 0) {
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$where['rcsa_detail'] = $id;
			$where['bulan'] = $month;
			$result = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'where' => $where, 'type' => 'update'));
			$id = $id; 
		} else {
		    $upd['create_date'] = date('Y-m-d H:i:s');
 			$upd['create_user'] = $this->authentication->get_info_user('username');
			$result = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'type' => 'add'));
			$id = $this->db->insert_id();
			$type = "add";
		}
		return $result;
    }

}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */