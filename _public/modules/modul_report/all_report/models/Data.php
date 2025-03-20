<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}

	// RISK PARENT
	function risk_parent($post)
    {
		if (!empty($post['owner_no'])) {
			$this->get_owner_child($post['owner_no']);
			$this->owner_child[] = $post['owner_no'];
			$this->db->where_in('owner_no', $this->owner_child);
		}
	
		if (isset($post['periode_no']) && $post['periode_no']) {
			$this->db->where('period_no', $post['periode_no']);
		}

        $rows = $this->db->where('sts_propose',4)->get(_TBL_VIEW_RCSA)->result_array();
        return $rows;
    }

	// RISK PROGRESS TREATMENT
	function risk_progress_treatment($post)
    {
		$x		=$this->authentication->get_info_user();
		$own	=$x['group']['owner']['owner_no'];
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

		if (isset($post['periode_no']) && $post['periode_no']) {
			$this->db->where('bangga_view_rcsa_detail.period_no', $post['periode_no']);
		}

		$this->db->where('bangga_view_rcsa_detail.sts_propose', 4);

		$this->db->select('
			bangga_rcsa_action.id as id_action, bangga_rcsa_action.proaktif as proaktif, bangga_rcsa_action.reaktif as reaktif, 
			bangga_view_rcsa_detail.* 
		');

		$this->db->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_rcsa_action.rcsa_detail_no', 'left'); 
		return $this->db->get('bangga_rcsa_action')->result_array();
    }

	// RISK EARLY WARNING
	function risk_early_warning($post)
    {
		
        if($post['owner_no']){
            $this->get_owner_child($post['owner_no']);
            $this->owner_child[] = $post['owner_no'];
            $this->db->where_in('owner_no', $this->owner_child);     
        }

		if (isset($post['periode_no']) && $post['periode_no']) {
			$this->db->where('period_no', $post['periode_no']);
		}

        $this->db->where('sts_propose', 4);
        return $this->db->where('kri !=', null)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
    }

	// RISK TAKSTONOMI
    function risk_tasktonomi($post){
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
		if (isset($post['periode_no']) && $post['periode_no']) {
			$this->db->where('bangga_view_rcsa_detail.period_no', $post['periode_no']);
		}
		$this->db->where('bangga_view_rcsa_detail.sts_propose', 4); 
		return $this->db->get('bangga_view_rcsa_detail')->result_array();
	}

	// GET DATA RISK REGISTER
    function get_data_risk_register($id)
	{
		$rows = $this->db->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		foreach ($rows as &$row) {
			$arrCouse 	= json_decode($row['risk_couse_no'], true);
			$rows_couse = array();
			if ($arrCouse)
			$arrCouse_implode 	= implode(", ", $arrCouse);
			$rows_couse  		= $this->db->query("SELECT * FROM bangga_library WHERE id IN ($arrCouse_implode) ORDER BY FIELD(id, $arrCouse_implode)")->result_array(); //$this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse 			= array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] 	= $rc['description'];
			}
			$row['couse'] 		= implode('### ', $arrCouse);
			$arrCouse 			= json_decode($row['risk_impact_no'], true);
			$rows_couse 		= array();
			if ($arrCouse)
			$arrCouse_implode 	= implode(", ", $arrCouse);
			$rows_couse 		=  $this->db->query("SELECT * FROM bangga_library WHERE id IN ($arrCouse_implode) ORDER BY FIELD(id, $arrCouse_implode)")->result_array();  //$this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse 			= array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['impact'] 		= implode('### ', $arrCouse);
			$arrCouse 			= json_decode($row['accountable_unit'], true);
			$rows_couse 		= array();
			if ($arrCouse)
			$rows_couse 		= $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse 			= array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['name'];
			}
			$row['accountable_unit_name'] = implode('### ', $arrCouse);
			$arrCouse 			= json_decode($row['penangung_no'], true);
			$rows_couse 		= array();
			if ($arrCouse)
			$rows_couse 		= $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse 			= array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['name'];
			}
			$row['penanggung_jawab'] = implode('### ', $arrCouse);
			if (!empty($row['note_control']))
				$arrCouse =json_decode($row['note_control'], true);
			$row['control_name'] = implode('### ', $arrCouse);
		}
		unset($row);
		return $rows;
	}

	// GET MONTHLY PROGRESS TREATMENT
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

	// GET MONTHLY EARLY WARNING
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

	// IKHTISAR PERUBAHAN LEVEL
	public function perubahan_level($post) {
		if (!empty($post['owner_no'])) {
			$this->get_owner_child($post['owner_no']);
			$this->owner_child[] = $post['owner_no'];
			$this->db->where_in('bangga_view_rcsa_action_detail.owner_no', $this->owner_child);
		}
		if (isset($post['periode_no']) && $post['periode_no']) {
			$this->db->where('bangga_view_rcsa_action_detail.period_no', $post['periode_no']);
		}
		$this->db->where('bangga_view_rcsa_action_detail.sts_propose', 4);
		$this->db->where('bangga_view_rcsa_action_detail.bulan', $post['bulan']);
		$this->db->join('bangga_rcsa_detail', 'bangga_rcsa_detail.id = bangga_view_rcsa_action_detail.rcsa_detail_no', 'left');
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

	// GET MONTHLY IKHTISAR PERUBAHAN LEVEL
	function getMonthlyMonitoringGlobal_PL($id, $month, $inh)
    {
        $act                = $this->db->select('id')->where('rcsa_detail_no', $id)->get('bangga_rcsa_action')->row_array();
        $monitoring         = $this->db->where('rcsa_action_no', $act['id'])->where('bulan', $month)->get('bangga_view_rcsa_action_detail')->row_array();
        $l                  = $this->data->level_action($monitoring['residual_likelihood_action'], $monitoring['residual_impact_action']);
		$cek_score1 		= $this->data->cek_level_new($monitoring['residual_likelihood_action'], $monitoring['residual_impact_action']);
		$residual_level 	= $this->data->get_master_level(true,$cek_score1['id']);
        $resLv              = $residual_level['likelihood'] . ' x ' . $residual_level['impact'];
        $keterangan_pl      = $monitoring['keterangan_pl'];
        $lv                 = '
        <a class="btn" data-toggle="popover" style="padding:4px; height:4px 8px;width:100%;background-color:' . $residual_level['color'] . ';color:' . $residual_level['color_text'] . ';">&nbsp;</a>';
        $r = 0;
        if ($residual_level['level_mapping'] == "High") {
            $r = 5;
        } elseif ($residual_level['level_mapping'] == "Moderate to High") {
            $r = 4;
        } elseif ($residual_level['level_mapping'] == "Moderate") {
            $r = 3;
        } elseif ($residual_level['level_mapping'] == "Low to Moderate") {
            $r = 2;
        } elseif ($residual_level['level_mapping'] == "Low") {
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
					<span class="btn " data-toggle="popover" data-content="residual anda turun dari  risiko inherent &#x1F603;" style="padding:4px; height:4px 8px;width:100%;">
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

	// CEK LEVEL
	function cek_level_new($like, $impact)
	{
		$rows = $this->db->where('impact_no', $impact)->where('like_no', $like)->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
        return $rows;
	}

	function filter($data = []){
		if ($data['owner_no'] > 0) {
			$this->get_owner_child($data['owner_no']);
			$this->owner_child[] = $data['owner_no'];
			$this->db->where_in('owner_no', $this->owner_child);
		}
 
		if ($data['periode_no'] > 0) {
			$this->db->where('period_no', $data['periode_no']);
		}
	}

	// GET MAP INHERENT & RESIDUAL
	function get_map_rcsa($data = [])
	{
		// doi::dump($data['bulan']);

		$hasil['inherent'] = '';
		$hasil['current'] = '';
		$hasil['residual'] = '';
	
		if ($data) {
			$mapping = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();
	
			// Filter berdasarkan owner jika ada
			$this->filter($data);
			$rows1 = $this->db->select('residual_likelihood, residual_impact, COUNT(*) as jml, norut')
				->from(_TBL_VIEW_RCSA_DETAIL)
				->where('sts_propose', 4)
				->where('sts_heatmap', '1')
				->group_by(['residual_likelihood', 'residual_impact', 'norut'])
				->get()
				->result_array();
	
			$arrData1 = [];
			$arrData2 = [];
			$arrData3 = [];
	
			foreach ($rows1 as $ros) {
				if (isset($ros['residual_likelihood'], $ros['residual_impact'])) {
					$key1 = $ros['residual_likelihood'] . '-' . $ros['residual_impact'];
	
					if (!isset($arrData1[$key1])) {
						$arrData1[$key1] = [
							'jml' => 0,
							'norut' => []
						];
					}
					$arrData1[$key1]['jml'] += (int) $ros['jml'];
					// Tambahkan norut ke array sesuai dengan jumlah jml
        for ($i = 0; $i < (int) $ros['jml']; $i++) {
            $arrData1[$key1]['norut'][] = $ros['norut'];
        }
				}
			}
			//  doi::dump($data);
			$this->filter($data);
			// $this->db->where('bulan', $data['bulan2']);
			$current_month = date('n');
			// === Filter by Period ===
			
			// // Validasi bulan dan bulanx
			if (isset($data['bulan']) && $data['bulan'] > 0) {
				$this->db->where("bulan",$data['bulan']);
			}else{
				$this->db->where('bulan', $current_month);
			}
			$rows2 = $this->db->select('MAX(rcsa_no) AS rcsa_no, MAX(create_date) AS create_date, risk_level_action, COUNT(risk_level_action) AS jml, norut, residual_likelihood_action, residual_impact_action')
                 ->order_by('create_date', 'desc')
                ->where('sts_propose', 4)
                ->where('urgensi_no', 0)
				->where('sts_heatmap', '1')
				->group_by(['risk_level_action', 'norut','residual_impact_action', 'residual_likelihood_action' ])
                ->get(_TBL_VIEW_RCSA_ACTION_DETAIL)
                ->result_array(); 			
				
			foreach ($rows2 as $ros) {
				if (isset($ros['residual_likelihood_action'], $ros['residual_impact_action'])) {
					$key2 = $ros['residual_likelihood_action'] . '-' . $ros['residual_impact_action'];
	
					if (!isset($arrData2[$key2])) {
						$arrData2[$key2] = [
							'jml' => 0,
							'norut' => []
						];
					}
					$arrData2[$key2]['jml'] += (int) $ros['jml'];
					$arrData2[$key2]['norut'][] = $ros['norut'];
				}
			}
	
			 
			$this->filter($data);
			$rows3 = $this->db->select('b.target_like, b.target_impact, COUNT(*) as jml, a.norut')
				->from(_TBL_VIEW_RCSA_DETAIL . ' a')
				->join('bangga_analisis_risiko b', 'a.id = b.id_detail', 'inner')
				->where('a.sts_propose', 4)
				->where('b.bulan', 12)
				->where('a.sts_heatmap', '1')
				->group_by(['b.target_like', 'b.target_impact', 'a.norut'])
				->get()
				->result_array();
	
			foreach ($rows3 as $ros) {
				if (isset($ros['target_like'], $ros['target_impact'])) {
					$key3 = $ros['target_like'] . '-' . $ros['target_impact'];
	
					if (!isset($arrData3[$key3])) {
						$arrData3[$key3] = [
							'jml' => 0,
							'norut' => []
						];
					}
					$arrData3[$key3]['jml'] += (int) $ros['jml'];
					$arrData3[$key3]['norut'][] = $ros['norut'];
				}
			}
	  
	
			// === Update Mapping with Values ===
			foreach ($mapping as &$row) {
				if (isset($row['like_no'], $row['impact_no'])) {
					$key = $row['like_no'] . '-' . $row['impact_no'];
					 
	
					$row['nilai_1'] = isset($arrData1[$key]) ? implode(', ', $arrData1[$key]['norut']) : '';
					$row['nilai_2'] = isset($arrData2[$key]) ? implode(', ', $arrData2[$key]['norut']) : '';
					$row['nilai_3'] = isset($arrData3[$key]) ? implode(', ', $arrData3[$key]['norut']) : '';
 				}
			}
			unset($row);
			$hasil['inherent'] = $this->data->draw_rcsa_unit($mapping, 'Inherent');
			$hasil['current'] = $this->data->draw_rcsa_unit($mapping, 'Current');
			$hasil['residual'] = $this->data->draw_rcsa_unit($mapping, 'Residual');
		}
		return $hasil;
	}
	
 

	
	function grafik($data){
        $result=[];
        $rows=$this->db->order_by('urut')->get(_TBL_LEVEL_MAPPING)->result_array();
        $master=[];
        foreach($rows as $row){
            $master[$row['id']]=['name'=>$row['level_mapping'], 'color'=>$row['color'], 'jml'=>0];
        }
        
        $this->owner_child=array();

		if ($data['owner_no']>0){
			$this->owner_child[]=$data['owner_no'];
		}

		$this->get_owner_child($data['owner_no']);
		$owner_child=$this->owner_child;

		if ($owner_child){
			$this->db->where_in('owner_no',$owner_child);
		}else{
			$this->db->where('owner_no',$data['owner_no']);
		}
		
		if ($data['periode_no'] > 0){
			$this->db->where_in('period_no',$data['periode_no']);
        }

        $rows=$this->db->select('inherent_analisis_id, inherent_analisis, count(inherent_analisis_id) as jml')->group_by(['inherent_analisis_id', 'inherent_analisis'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

        foreach($master as $key=>$mr){
            foreach($rows as $row){
                if ($row['inherent_analisis_id']==$key){
                    $master[$key]['jml']=$row['jml'];
                }
            }
        }

				$result['periode_name'] = ($data['periode_no'] > 0) ? $data['tahun'] : "";
        $result['master']=$master;

        // setelah progress
        $rows=$this->db->order_by('urut')->get(_TBL_LEVEL_MAPPING)->result_array();
        $master=[];
        foreach($rows as $row){
            $master[$row['id']]=['name'=>$row['level_mapping'], 'color'=>$row['color'], 'jml'=>0];
        }
        
        $this->owner_child=array();

		if ($data['owner_no']>0){
			$this->owner_child[]=$data['owner_no'];
		}

		$this->get_owner_child($data['owner_no']);
		$owner_child=$this->owner_child;

		if ($owner_child){
			$this->db->where_in('owner_no',$owner_child);
		}else{
			$this->db->where('bangga_view_rcsa_detail.owner_no',$data['owner_no']);
		}
		
		if ($data['periode_no'] > 0){
			$this->db->where_in('bangga_view_rcsa_detail.period_no',$data['periode_no']);
        }

            $this->db->select('
            bangga_rcsa_action_detail.id,
            bangga_rcsa_action_detail.residual_impact_action, 
            bangga_rcsa_action_detail.residual_likelihood_action, 
            bangga_view_rcsa_detail.id AS rcsa_detail_id,
            bangga_view_rcsa_detail.owner_no,
            bangga_view_rcsa_detail.period_no,
            bangga_level_color.level_risk_no,
            COUNT(bangga_rcsa_action_detail.id) AS jml
        ');
        $this->db->from('bangga_rcsa_action_detail');
        $this->db->join('bangga_view_rcsa_detail', 'bangga_rcsa_action_detail.rcsa_detail = bangga_view_rcsa_detail.id', 'left');
        $this->db->join('bangga_level_color', 'bangga_rcsa_action_detail.residual_impact_action = bangga_level_color.impact AND bangga_rcsa_action_detail.residual_likelihood_action = bangga_level_color.likelihood', 'left');
        $this->db->group_by('
            bangga_rcsa_action_detail.id,  
            bangga_rcsa_action_detail.residual_impact_action, 
            bangga_rcsa_action_detail.residual_likelihood_action, 
            bangga_view_rcsa_detail.id, 
            bangga_view_rcsa_detail.owner_no, 
            bangga_view_rcsa_detail.period_no,
            bangga_level_color.level_risk_no
        ');
        
        // Mendapatkan hasil
        $rows = $this->db->get()->result_array();
        
        foreach($master as $key=>$mr){
			foreach($rows as $index=>$row){
				// doi::dump($index);
                if ($rows[$index]['level_risk_no']==$key){
                    $master[$key]['jml']+=$row['jml'];
                }
            }
        }
		
        $result['master2']=$master;

		
        return $result;
    }


	function grafik_categories($data){
        $result=[];
        $rows=$this->db->where('kelompok','kategori-risiko')->order_by('id')->get(_TBL_DATA_COMBO)->result_array();
        $master=[];
        foreach($rows as $row){
            $master[$row['id']]=['name'=>$row['data'], 'jml'=>0];
        }
        
        $this->owner_child=array();

		if ($data['owner_no']>0){
			$this->owner_child[]=$data['owner_no'];
		}

		$this->get_owner_child($data['owner_no']);
		$owner_child=$this->owner_child;

		if ($owner_child){
			$this->db->where_in('owner_no',$owner_child);
		}else{
			$this->db->where('owner_no',$data['owner_no']);
		}
		
		if ($data['periode_no']){
			$this->db->where_in('period_no',$data['periode_no']);
        }
        
        $rows=$this->db->select('kategori_no, kategori, count(kategori_no) as jml')->group_by(['kategori_no', 'kategori'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		$result['periode_name'] = ($data['periode_no'] > 0) ? $data['tahun'] : "";
        foreach($master as $key=>$mr){
            foreach($rows as $row){
                if ($row['kategori_no']==$key){
                    $master[$key]['jml']=$row['jml'];
                  
                }
            }
        }
        $result['master']=$master;

    
        return $result;
    }

	

	function grapik_efektifitas_control($data){
		$cboPenilaian = [
			'1' => 'Cukup & Efektif',
			'2' => 'Cukup & Efektif Sebagian',
			'3' => 'Cukup & Tidak Efektif',
			'4' => 'Tidak Cukup & Efektif Sebagian',
			'5' => 'Tidak Cukup & Tidak Efektif'
		];

		$comboColor = [
			'1' => '#00712D',    // Cukup & Efektif
			'2' => '#06D001',    // Sebagian
			'3' => '#FEEC37',    // Cukup & Tidak Efektif
			'4' => '#ffa000',    // Tidak Cukup & Efektif Sebagian
			'5' => '#B8001F'     // Tidak Cukup & Tidak Efektif
		];

		$result = [];
		$master = [];

		// Mengisi master dengan data dari cboPenilaian dan comboColor
		foreach ($cboPenilaian as $id => $name) {
			if (array_key_exists($id, $comboColor)) {
				$master[$id] = [
					'name' => $name, 
					'color' => $comboColor[$id],
					'jml' => 0
				];
			}
		}

			$this->owner_child=array();

			if ($data['owner_no']>0){
				$this->owner_child[]=$data['owner_no'];
			}

			$this->get_owner_child($data['owner_no']);
			$owner_child=$this->owner_child;

			if ($owner_child){
				$this->db->where_in('c.owner_no',$owner_child);
			}else{
				$this->db->where('c.owner_no',$data['owner_no']);
			}
		
			if ($data['periode_no'] > 0){
				$this->db->where_in('c.period_no',$data['periode_no']);
			}

  
			$rows = $this->db->select('c.periode_name, a.penilaian_intern_control, COUNT(DISTINCT a.id) AS jml')
                 ->from('bangga_existing_control a')
                 ->join('bangga_rcm b', 'a.rcm_id = b.id', 'left')
                 ->join('bangga_view_rcsa_detail c', 'b.rcsa_no = c.rcsa_no', 'left')
                 ->group_by(['c.periode_name', 'a.penilaian_intern_control']) // Mengelompokkan berdasarkan periode_name dan penilaian_intern_control
                 ->get()
                 ->result_array();

			foreach($master as $key=>$mr){
					foreach($rows as $row){
							if ($row['penilaian_intern_control']==$key){
									$master[$key]['jml']=$row['jml'];
							}
					}
			}
        $result['master']=$master;
        return $result;
    }

	function grapik_progress_treatment($data){
		$result = [];

		// doi::dump($data);
		// die;

		// Dapatkan owner_child berdasarkan owner_no
		$this->owner_child = [];
		if ($data['owner_no'] > 0) {
			$this->owner_child[] = $data['owner_no'];
		}

		$this->get_owner_child($data['owner_no']);
		$owner_child = $this->owner_child;

		// Filter berdasarkan owner_no
		if ($owner_child) {
			$this->db->where_in('c.owner_no', $owner_child);
		} else {
			$this->db->where('c.owner_no', $data['owner_no']);
		}

		// Filter berdasarkan periode dan bulan
		if (!empty($data['periode_no'])) {
			$this->db->where('c.period_no', $data['periode_no']);
		}

		$rows = $this->db
			->select("
				a.bulan, 
				c.owner_no, 
				c.period_no,
				CASE
					WHEN (a.progress_detail < b.target_progress_detail) 
						OR (a.progress_detail = b.target_progress_detail AND a.target_progress_detail < b.target_damp_loss) THEN 'Kurang'
					WHEN a.progress_detail = b.target_progress_detail AND a.target_progress_detail = b.target_damp_loss THEN 'Sama'
					WHEN (a.progress_detail > b.target_progress_detail) 
						OR (a.progress_detail = b.target_progress_detail AND a.target_progress_detail > b.target_damp_loss) THEN 'Lebih'
					ELSE 'Tidak Diketahui'
				END AS kategori, 
				1 AS jml", false) // Setiap baris dianggap sebagai jumlah 1
			->from('bangga_rcsa_monitoring_treatment a')
			->join(
				'bangga_rcsa_treatment b', 
				'a.rcsa_action_no = b.id_rcsa_action AND a.bulan = b.bulan', 
				'left'
			)
			->join(
				'bangga_view_rcsa_detail c', 
				'b.rcsa_detail_no = c.id', 
				'left'
			)
			->order_by('a.bulan', 'ASC')
			->get()
			->result_array();

			

		// Daftar bulan dari Januari hingga Desember
		$bulan = [
			1 => 'Jan',
			2 => 'Feb',
			3 => 'Mar',
			4 => 'Apr',
			5 => 'May',
			6 => 'Jun',
			7 => 'Jul',
			8 => 'Aug',
			9 => 'Sep',
			10 => 'Oct',
			11 => 'Nov',
			12 => 'Dec'
		];

		// Inisialisasi default untuk setiap kategori
		$dataKategori = [
			'Kurang' => array_fill_keys(array_values($bulan), 0),
			'Sama' => array_fill_keys(array_values($bulan), 0),
			'Lebih' => array_fill_keys(array_values($bulan), 0),
		];

		// doi::dump($dataKategori);

		// Proses hasil query
		foreach ($rows as $row) {

			$bulanKey = $bulan[(int)$row['bulan']] ?? null;
			$kategori = $row['kategori'];
			$jml = (int)$row['jml'];

			// doi::dump($kategori);
			// Tambahkan jumlah berdasarkan bulan
			if ($bulanKey && isset($dataKategori[$kategori])) {
				$dataKategori[$kategori][$bulanKey] += $jml;
			}
		}

		// doi::dump();

		// Format hasil untuk master
		$result['master'] = $dataKategori;
		return $result;
	}


        
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */