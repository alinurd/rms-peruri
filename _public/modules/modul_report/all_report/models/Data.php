<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}

    // function risk_context($post){
    //     $rows = $this->db->where('owner_no', $post['owner_no'])->where('period_no', $post['periode_no'])->get(_TBL_VIEW_RCSA)->result_array();
    //     return $rows;
    // }

    // function risk_criteria($post)
    // {
    //     $rows = $this->db->where('owner_no', $post['owner_no'])->where('period_no', $post['periode_no'])->get(_TBL_VIEW_RCSA)->result_array();
    //     return $rows;
    // }

    // function risk_appetite($post)
    // {
    //     $rows = $this->db->where('owner_no', $post['owner_no'])->where('period_no', $post['periode_no'])->get(_TBL_VIEW_RCSA)->result_array();
    //     return $rows;
    // }
    
	// function risk_efektifitas_control($post)
    // {
    //     $rows = $this->db->where('owner_no', $post['owner_no'])->where('period_no', $post['periode_no'])->get(_TBL_VIEW_RCSA)->result_array();
    //     return $rows;
    // }

	function risk_progress_treatment($post)
    {
		$x=$this->authentication->get_info_user();
		$own=$x['group']['owner']['owner_no'];
 		if($post['owner_no']){
			$own= $post['owner_no'];
		}

		if (!isset($this->owner_child)) {
			$this->owner_child = [];
		}

		if (isset($post['owner_no']) && $post['owner_no']) {
			$this->get_owner_child($post['owner_no']);
			$this->owner_child[] = $post['owner_no'];
			$this->db->where_in('bangga_view_rcsa_detail.owner_no', $this->owner_child);     
		}

		if (isset($data['periode_no']) && $data['periode_no']) {
			$this->db->where('bangga_view_rcsa_detail.period_no', $data['periode_no']);
		}

		$this->db->where('bangga_view_rcsa_detail.sts_propose', 4);

		$this->db->select('
			bangga_rcsa_action.id as id_action, bangga_rcsa_action.proaktif as proaktif, bangga_rcsa_action.reaktif as reaktif, 
			bangga_view_rcsa_detail.* 
		');

		$this->db->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_rcsa_action.rcsa_detail_no', 'left'); 
		return $this->db->get('bangga_rcsa_action')->result_array();
    }

	function risk_early_warning($post)
    {
		
        if($post['owner_no']){
            $this->get_owner_child($post['owner_no']);
            $this->owner_child[] = $post['owner_no'];
            $this->db->where_in('owner_no', $this->owner_child);     
        }

		if (isset($data['periode_no']) && $data['periode_no']) {
			$this->db->where('period_no', $data['periode_no']);
		}

        $this->db->where('sts_propose', 4);
        return $this->db->where('kri !=', null)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
    }

    function risk_parent($post)
    {
        $rows = $this->db->where('owner_no', $post['owner_no'])->where('period_no', $post['periode_no'])->where('sts_propose',4)->get(_TBL_VIEW_RCSA)->result_array();
        return $rows;
    }

    function get_data_risk_register($id)
	{
		$rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
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

	function getMonthlyMonitoringGlobal($q, $month)
	{
 		 
		$data['data'] = $this->db
			->where('rcsa_action_no', $q['id_action'])
			->where('bulan', $month)
			->get('bangga_rcsa_monitoring_treatment')->row_array();

		$data['risk_treatment'] = $this->db
			->where('id_rcsa_action', $q['id_action'])
			->where('bulan', $month)
			->get('bangga_rcsa_treatment')->row_array();

        $data_risk_treatment = $data['risk_treatment'];
        $result = '
			<td colspan="2">
				<table style="width: 100%; border-collapse: collapse;">
					<tr>
						<td style="padding: 10px; vertical-align: top;">
							<div class="input-group">
								<input style="width:100px !important;" readonly type="number" name="target_progress[]" id="target_progress_'.$data['data']['id'].$month.'" class="form-control" placeholder="Progress %" value="'.$data_risk_treatment['target_progress_detail'].'" aria-describedby="basic-addon2">
								<span class="input-group-addon" id="basic-addon2">%</span>
							</div>
						</td>
						<td style="padding: 10px; vertical-align: top;">
							<div class="input-group">
								<input readonly style="width:100px !important;" type="number" name="progress[]" id="progress_'.$data['data']['id'].$month.'" class="form-control" placeholder="Progress %" value="'.$data['data']['progress_detail'].'" aria-describedby="basic-addon2">
								<span class="input-group-addon" id="basic-addon2">%</span>
							</div>
						</td>
					</tr>
					<tr>
						<td style="padding: 10px; vertical-align: top;">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">Rp.</span>
								<input style="width:100px !important;" readonly type="text" name="target_damp_loss[]" id="target_damp_loss_'.$data['data']['id'].$month.'" 
								value="'.number_format($data_risk_treatment['target_damp_loss'], 0, ',', ',').'" class="form-control numeric rupiah" placeholder="Damp Loss" aria-describedby="basic-addon1">
							</div>
						</td>
						<td style="padding: 10px; vertical-align: top;">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">Rp.</span>
								<input readonly style="width:100px !important;" type="text" name="damp_loss[]" id="damp_loss_'.$data['data']['id'].$month.'" 
								value="'.number_format($data['data']['target_progress_detail'], 0, ',', ',').'" class="form-control numeric rupiah" placeholder="Damp Loss" aria-describedby="basic-addon1">
							</div>
						</td>
					</tr>
				</table>
			</td>
		';


 		return $result;
	}

	function getMonthlyMonitoringGlobal_Early($q, $month)
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
		
        $realisasi 	= $data['kri_detail']['realisasi'];
        $level_1 	= range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
        $level_2 	= range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
        $level_3 	= range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
        if ($data['kri'] && $realisasi >0) {
            $krnm = $realisasi;
            if (in_array($realisasi, $level_1)) {
                $result['bgres'] = 'style="background-color: #7FFF00;color: #000;"';
            } elseif (in_array($realisasi, $level_2)) {
                $result['bgres'] = 'style="background-color: #FFFF00;color:#000;"';
            } elseif (in_array($realisasi, $level_3)) {
                $result['bgres'] = 'style="background-color: #FF0000; color: #000;"';
            } else {
                $result['bgres'] = '';
            }
        } else {
            $result['bgres'] = '';
        }
        
		$result['data'] = $realisasi;
        
 		return $result;
	}

	function perubahan_level($post) {
		// Memastikan owner_no ada dalam post
		if (!empty($post['owner_no'])) {
			$this->get_owner_child($post['owner_no']);
			$this->owner_child[] = $post['owner_no'];
			$this->db->where_in('bangga_view_rcsa_action_detail.owner_no', $this->owner_child);
		}
	
		// Memastikan periode_no ada dalam post
		if (isset($post['periode_no']) && $post['periode_no']) {
			$this->db->where('bangga_view_rcsa_action_detail.period_no', $post['periode_no']);
		}
	
		// Menambahkan kondisi untuk status dan bulan
		$this->db->where('bangga_view_rcsa_action_detail.sts_propose', 4);
		$this->db->where('bangga_view_rcsa_action_detail.bulan', $post['bulan']);
	
		// Menambahkan JOIN
		$this->db->join('bangga_rcsa_detail', 'bangga_rcsa_detail.id = bangga_view_rcsa_action_detail.rcsa_detail_no', 'left');
	
		// Mengambil data dari tabel bangga_rcsa_action_detail
		return $this->db->get('bangga_view_rcsa_action_detail')->result_array();
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

	function getMonthlyMonitoringGlobal_PL($id, $month, $inh)
    {
        $act                = $this->db->select('id')->where('rcsa_detail_no', $id)->get('bangga_rcsa_action')->row_array();
        $monitoring         = $this->db->where('rcsa_action_no', $act['id'])->where('bulan', $month)->get('bangga_view_rcsa_action_detail')->row_array();
        $l                  = $this->data->level_action($monitoring['residual_likelihood_action'], $monitoring['residual_impact_action']);
		// doi::dump($l);
        $resLv              = $l['like']['code'] . ' x ' . $l['impact']['code'];
        $keterangan_pl      = $monitoring['keterangan_pl'];
        $lv                 = '
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
                                      <span class="btn " data-toggle="popover" data-content="residual anda tidak penurunan dan kenaikan dari risiko inherent &#x1F603;" style="padding:4px; height:4px 8px;width:100%;">
                <i style=" font-size: 30px;" class="glyphicon glyphicon-resize-horizontal text-primary" aria-hidden="true"></i> 
            </span>

                         ';
        } elseif ($r > $Inh) {
            $pl = ' 

                      <span class="btn " data-toggle="popover" data-content="risiko anda lebih tinggi dari risiko inherent risk &#x1F603;" style="padding:4px; height:4px 8px;width:100%;">
                <i style=" font-size: 30px;" class="fa fa-arrow-up text-danger" aria-hidden="true"></i> 
            </span>

         ';
        } elseif ($r<$Inh) {
            $pl = '
                    <span class="btn " data-toggle="popover" data-content="residual anda turun dari  risiko inherent &#x1F603;
" style="padding:4px; height:4px 8px;width:100%;">
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
            $result['ket'] = ($keterangan_pl) ? $keterangan_pl : "<span style='color:red;'>Belum Di Monitoring</span>";
        }

        return $result;
    }


        
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */