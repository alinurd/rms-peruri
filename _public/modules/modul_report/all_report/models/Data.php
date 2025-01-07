<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}


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
		$cek_score1 		= $this->data->cek_level_new($monitoring['residual_likelihood_action'], $monitoring['residual_impact_action']);
		$residual_level 	= $this->data->get_master_level(true,$cek_score1['id']);
        $resLv              = $residual_level['likelihood'] . ' x ' . $residual_level['impact'];
        $keterangan_pl      = $monitoring['keterangan_pl'];
        $lv                 = '
        <a class="btn" data-toggle="popover" style="padding:4px; height:4px 8px;width:100%;background-color:' . $residual_level['color'] . ';color:' . $residual_level['color_text'] . ';"> &nbsp;</a>';
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

	function cek_level_new($like, $impact)
	{
		$rows = $this->db->where('impact_no', $impact)->where('like_no', $like)->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
        return $rows;
	}

	function get_map_rcsa($data = [])
	{

		// doi::dump($data['owner_no']);
		$hasil['inherent'] = '';
		$hasil['residual'] = '';

		if ($data) {
			$mapping = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();
			if ($data['owner_no'] > 0) {
				$this->get_owner_child($data['owner_no']);
				$this->owner_child[] = $data['owner_no'];
				$this->db->where_in('owner_no', $this->owner_child);
			}
		
			if ($data['id_period'] > 0) {
				$this->db->where('period_no', $data['id_period']);
			}
			$rows = $this->db->select('inherent_level, count(inherent_level) as jml')->group_by(['inherent_level'])->where('sts_propose', 4)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			$arrData = [];
			foreach ($rows as &$ros) {
				$arrData[$ros['inherent_level']] = $ros['jml'];
			}

			foreach ($mapping as &$row) {
				if (array_key_exists($row['id'], $arrData))
					$row['nilai'] = $arrData[$row['id']];
				else
					$row['nilai'] = '';
			}
			unset($row);
			$hasil['inherent'] = $this->data->draw_rcsa($mapping);

			// residual
			$mapping = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();
			if ($data['owner_no'] > 0) {
				$this->get_owner_child($data['owner_no']);
				$this->owner_child[] = $data['owner_no'];
				$this->db->where_in('owner_no', $this->owner_child);
			}
		
			if ($data['id_period'] > 0) {
				$this->db->where('period_no', $data['id_period']);
			}
			$rows = $this->db->select('residual_level, count(residual_level) as jml')->group_by(['residual_level'])->where('sts_propose', 4)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			$arrData = [];
			foreach ($rows as &$ros) {
				$arrData[$ros['residual_level']] = $ros['jml'];
			}

			foreach ($mapping as &$row) {
				if (array_key_exists($row['id'], $arrData))
					$row['nilai'] = $arrData[$row['id']];
				else
					$row['nilai'] = '';
			}
			unset($row);
			$hasil['residual'] = $this->data->draw_rcsa_res($mapping);
		}
		return $hasil;
	}
	

	function get_map_residual1($data = [])
    {
        $hasil['residual1'] = '';
        $mapping1 = $this->db->get(_TBL_VIEW_MATRIK_RCSA)->result_array();

        if ($data['owner_no'] > 0) {
			$this->get_owner_child($data['owner_no']);
			$this->owner_child[] = $data['owner_no'];
			$this->db->where_in('owner_no', $this->owner_child);
		}
	

        // === Filter by Period ===
        if (isset($data['id_period']) && $data['id_period'] > 0) {
            $this->db->where('a.period_no', $data['id_period']);
        }

        // Validasi bulan dan bulanx
        if (isset($data['bulan']) && $data['bulan'] > 0) {
            $this->db->where("b.bulan",$data['bulan']);
        }

    $rows = $this->db->select('b.target_like as target_like, b.target_impact as target_impact, COUNT(*) as jml')
        ->from(_TBL_VIEW_RCSA_DETAIL . ' a') 
        ->join('bangga_analisis_risiko b', 'a.id = b.id_detail', 'inner') // Perbaiki alias di sini
        ->where('a.sts_propose', 4)
        ->where('a.sts_heatmap', '1')
        ->group_by(['b.target_like', 'b.target_impact']) 
        ->get()
        ->result_array();
  
        $arrData = [];
        foreach ($rows as $ros) {

            if (isset($ros['target_like'], $ros['target_impact'])) {
                $key = $ros['target_like'] . '-' . $ros['target_impact']; // Gabungkan likelihood dan impact
                $arrData[$key] = $ros['jml'];
            }
        }

        // === Update Mapping with Inherent Values ===
        foreach ($mapping1 as &$row) {
            // Pastikan kolom likelihood dan impact ada dalam $mapping
            if (isset($row['like_no'], $row['impact_no'])) {
                $key = $row['like_no'] . '-' . $row['impact_no']; // Gabungkan likelihood dan impact untuk mencocokkan
                $row['nilai'] = array_key_exists($key, $arrData) ? $arrData[$key] : ''; 
                
            }
        }

        $hasil['residual1'] = $this->data->draw_rcsa1($mapping1, 'Target');
       
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

        $rows=$this->db->select('periode_name,inherent_analisis_id, inherent_analisis, count(inherent_analisis_id) as jml')->group_by(['inherent_analisis_id', 'inherent_analisis'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

        foreach($master as $key=>$mr){
            foreach($rows as $row){
                if ($row['inherent_analisis_id']==$key){
                    $master[$key]['jml']=$row['jml'];
                }
            }
        }
		$result['periode_name'] = $rows[0]['periode_name'];
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
        $rows=$this->db->where('type',4)->order_by('code')->get(_TBL_LIBRARY)->result_array();
        $master=[];
        foreach($rows as $row){
            $master[$row['id']]=['name'=>$row['description'], 'jml'=>0];
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
        
        $rows=$this->db->select('periode_name,tema, tema_risiko_, count(tema) as jml')->group_by(['tema', 'tema_risiko_'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		$result['periode_name'] = $rows[0]['periode_name'];
        foreach($master as $key=>$mr){
            foreach($rows as $row){
                if ($row['tema']==$key){
                    $master[$key]['jml']=$row['jml'];
                  
                }
            }
        }
        $result['master']=$master;

    
        return $result;
    }

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

		if (isset($data['periode_no']) && $data['periode_no']) {
			$this->db->where('bangga_view_rcsa_detail.period_no', $data['periode_no']);
		}

		$this->db->where('bangga_view_rcsa_detail.sts_propose', 4);

		// $this->db->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_rcsa_action.rcsa_detail_no', 'left'); 
		return $this->db->get('bangga_view_rcsa_detail')->result_array();
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
			// Pastikan id ada dalam comboColor untuk menghindari error
			if (array_key_exists($id, $comboColor)) {
				$master[$id] = [
					'name' => $name, 
					'color' => $comboColor[$id], // Mengambil warna berdasarkan id
					'jml' => 0
				];
			}
		}

		// doi::dump($master);

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

        // $rows=$this->db->select('periode_name,inherent_analisis_id, inherent_analisis, count(inherent_analisis_id) as jml')->group_by(['inherent_analisis_id', 'inherent_analisis'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$rows = $this->db->select('c.periode_name, a.id, a.penilaian_intern_control, COUNT(a.id) AS jml')
							->from('bangga_existing_control a')
							->join('bangga_rcm b', 'a.rcm_id = b.id', 'left') 
							->join('bangga_view_rcsa_detail c', 'b.rcsa_no = c.rcsa_no', 'left') 
							->group_by(['c.periode_name','a.id', 'a.penilaian_intern_control'])
							->get()
							->result_array();

		// doi::dump($rows);

        foreach($master as $key=>$mr){
            foreach($rows as $row){
                if ($row['penilaian_intern_control']==$key){
                    $master[$key]['jml']=$row['jml'];
                }
            }
        }
		// $result['periode_name'] = $rows[0]['periode_name'];
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