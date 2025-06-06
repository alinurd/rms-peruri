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
            $this->db->where('periode_name', $data['periode']);
        }
        $this->db->where('sts_propose', 4);

        $this->db->limit($limit, $offset);

        return $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
    }

    public function getDetail_modal($data, $limit, $offset) {

		// Cek apakah ada 'owner' pada $data
		if ($data['owner']) {
			// Ambil anak-anak dari owner
			$this->get_owner_child($data['owner']);
			$this->owner_child[] = $data['owner'];
			// Filter berdasarkan owner_no
			$this->db->where_in('bangga_view_rcsa_action_detail.owner_no', $this->owner_child);
		} 

		// Cek apakah ada periode pada $data
		if ($data['periode']) {
			$this->db->where('bangga_period.periode_name', $data['periode']);
		}

		// Filter on 'sts_propose' value
        $this->db->where('bangga_view_rcsa_action_detail.sts_propose', 4);

		// Filter berdasarkan triwulan (bulan)
		if (!empty($data['triwulan'])) {
			switch ($data['triwulan']) {
				case 1: // Triwulan 1: Januari - Maret (Bulan 1 - 3)
					$this->db->where('bangga_view_rcsa_action_detail.bulan >=', 1);
					$this->db->where('bangga_view_rcsa_action_detail.bulan <=', 3);
					break;
				case 2: // Triwulan 2: April - Juni (Bulan 4 - 6)
					$this->db->where('bangga_view_rcsa_action_detail.bulan >=', 4);
					$this->db->where('bangga_view_rcsa_action_detail.bulan <=', 6);
					break;
				case 3: // Triwulan 3: Juli - September (Bulan 7 - 9)
					$this->db->where('bangga_view_rcsa_action_detail.bulan >=', 7);
					$this->db->where('bangga_view_rcsa_action_detail.bulan <=', 9);
					break;
				case 4: // Triwulan 4: Oktober - Desember (Bulan 10 - 12)
					$this->db->where('bangga_view_rcsa_action_detail.bulan >=', 10);
					$this->db->where('bangga_view_rcsa_action_detail.bulan <=', 12);
					break;
			}
		}

		$this->db->join('bangga_rcsa_log_level_risiko', 'bangga_rcsa_log_level_risiko.id_action_detail = bangga_view_rcsa_action_detail.id', 'left'); // Ganti dengan nama tabel yang sesuai
		$this->db->join('bangga_period', 'bangga_period.id = bangga_view_rcsa_action_detail.period_no', 'left'); // Ganti dengan nama tabel yang sesuai
		$this->db->limit($limit, $offset);
		$this->db->order_by('bangga_view_rcsa_action_detail.bulan', 'ASC');

		// Ambil data setelah join dan filter
		$query = $this->db->get('bangga_view_rcsa_action_detail');

	
		// Kembalikan hasil dalam bentuk array
		return $query->result_array();
	}
	
	
	
	
	

    
    public function count_all_data($data) {
      
        if($data['owner']){
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('owner_no', $this->owner_child);     
        }

        if($data['periode']){
            $this->db->where('periode_name', $data['periode']);
        }
        
        $this->db->where('sts_propose', 4);

        return $this->db->count_all_results(_TBL_VIEW_RCSA_DETAIL);
    }

    // function simpan_realisasi($data){
    //     $upd                                = [];
	// 	$id 		                        = $data['rcsa_detail_no'];
	// 	$rcsa_no 	                        = $data['rcsa_no'];
	// 	$month 		                        = $data['month'];
	// 	$likehold 	                        = $data['likehold'];
	// 	$impact 	                        = $data['impact'];
	// 	$upd['rcsa_detail'] 				= $id;
	// 	$upd['bulan'] 						= $month;
	// 	$upd['residual_likelihood_action'] 	= $likehold;
	// 	$upd['residual_impact_action'] 		= $impact;
	// 	$upd['create_date'] 				= date('Y-m-d H:i:s');
	// 	$upd['create_user'] 				= $this->authentication->get_info_user('username');
	// 	$upd['rcsa_action_no']              = $data['rcsa_action_no'];
	// 	$upd['risk_level_action']           = $data['inherent_level'];
	
	// 	// doi::dump($upd);
	// 	// die('ctr');
	// 	// Simpan data ke dalam tabel (misalnya, 'level_risiko_data')
		
	// 	if ((int)$data['id_edit'] > 0) {
	// 		$upd['update_user'] = $this->authentication->get_info_user('username');
	// 		$where['id'] = $data['id_edit'];
	// 		$where['bulan'] = $data['month'];
	// 		$result = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'where' => $where, 'type' => 'update'));
	// 		$id = intval($data['id_edit']);
	// 		$type = "edit";
	// 	} else {
	// 		$upd['create_user'] = $this->authentication->get_info_user('username');
	// 		$id = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'type' => 'add'));
	// 		$id = $this->db->insert_id();
	// 		$type = "add";
	// 	}
	
	// 	// $id = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'type' => 'add'));
	// 	// $id = $this->db->insert_id();
		
	// 	$upd = [];
	// 	$rows = $this->db->where('rcsa_action_no', $data['rcsa_action_no'])->order_by('progress_date', 'desc')->limit(1)->get(_TBL_RCSA_ACTION_DETAIL)->row_array();
	// 	if ($rows) {
	// 		$upd['residual_likelihood']     = $rows['residual_likelihood_action'];
	// 		$upd['residual_impact']         = $rows['residual_impact_action'];
	// 		$upd['risk_level']              = $rows['risk_level_action'];
	// 		$upd['status_loss_parent']      = $rows['status_loss'];
	// 		$where['id']                    = $id;
	// 		$result = $this->crud->crud_data(array('table' => _TBL_RCSA_DETAIL, 'field' => $upd, 'where' => $where, 'type' => 'update'));
	// 	}
	// 	return $result;
    // }

	public function simpan_realisasi($data) {
		// Array untuk menampung hasil update
		$upd = [];
		
		// Mendapatkan data dari POST
		$rcsa_detail_no 		= $data['rcsa_detail_no'];
		$rcsa_no 				= $data['rcsa_no'];
		$month 					= $data['month'];
		$likehold 				= $data['likehold'];
		$impact 				= $data['impact'];
		$id_edit 				= $data['id_edit'];
		$rcsa_action_no 		= $data['rcsa_action_no'];
		$nilai_impact 			= str_replace(',', '',$data['nilai_impact']);
		$nilai_likelihood 		= str_replace(',', '',$data['nilai_likelihood']);
		$nilai_exposure 		= str_replace(',', '',$data['nilai_exposure']);
		// Iterasi untuk setiap item dalam array
		foreach ($rcsa_detail_no as $i => $id) {

			$upd_log = [
				'id_detail' 		=> $id,
				'bulan' 			=> $month[$i],
				'tanggal_validasi' 	=> date('Y-m-d H:i:s')
			];

			// Persiapkan data yang akan disimpan
			$upd = [
				'rcsa_detail' 					=> $id,
				'bulan' 						=> $month[$i],
				'residual_likelihood_action' 	=> $likehold[$i],  // Handle empty values
				'residual_impact_action' 		=> $impact[$i],
				'nilai_impact' 					=> $nilai_impact[$i],
				'nilai_likelihood' 				=> $nilai_likelihood[$i],
				'nilai_exposure' 				=> $nilai_exposure[$i],
				'rcsa_action_no'				=> $rcsa_action_no[$i]
			];

			 // Cek apakah data sudah ada
			 $existing_data = $this->db->get_where(_TBL_RCSA_ACTION_DETAIL, [
				'id' => $id_edit[$i],
				'bulan' => $month[$i]
			])->row();
		
			if ($existing_data) {
				$upd['update_user'] = $this->authentication->get_info_user('username');
				$where['id'] = $id_edit[$i];
				$where['bulan'] = $month[$i];
				$result = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'where' => $where, 'type' => 'update'));
				$id = $id_edit[$i];
				$type = 'edit';

				$cek_log = $this->db->get_where(_TBL_RCSA_LOG_LEVEL_RISIKO, [
					'id_action_detail' => $id_edit[$i],
					'bulan' => $month[$i]
				])->row();

				if($cek_log){
					$upd_log['update_user'] = $this->authentication->get_info_user('username');
					$where_log['id_action_detail'] = $id;
					$where_log['bulan'] = $month[$i];
					$result_log = $this->crud->crud_data(array('table' => _TBL_RCSA_LOG_LEVEL_RISIKO, 'field' => $upd_log, 'where' => $where_log, 'type' => 'update'));
				}else{
					$upd_log['id_action_detail'] = $id;
					$upd_log['create_user'] = $this->authentication->get_info_user('username');
					$log = $this->crud->crud_data(['table' => _TBL_RCSA_LOG_LEVEL_RISIKO, 'field' => $upd_log, 'type' => 'add']);
				}

				
				
			} else {
				$upd['create_user'] = $this->authentication->get_info_user('username');
				$id = $this->crud->crud_data(['table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'type' => 'add']);
				$id = $this->db->insert_id();
				$type = "add";
				
				$upd_log['id_action_detail'] = $id;
				$upd_log['create_user'] = $this->authentication->get_info_user('username');
				$log = $this->crud->crud_data(['table' => _TBL_RCSA_LOG_LEVEL_RISIKO, 'field' => $upd_log, 'type' => 'add']);
				
			}
	
		}
	
		return $id;  // Mengembalikan ID terakhir yang diupdate/ditambahkan
	}
	
	
    
    function getMonthlyMonitoringGlobal($q, $month)
	{
		// Fetch action and risk data
		$act 				= $this->db->select('id')->where('rcsa_detail_no', $q['id'])->get('bangga_rcsa_action')->row_array();
		$data['data'] 		= $this->db->where('rcsa_action_no', $act['id'])->where('bulan', $month)->get('bangga_view_rcsa_action_detail')->row_array();
		$data['data_awal'] 	= $this->db->where('id_detail', $q['id'])->where('bulan', $month)->get('bangga_analisis_risiko')->row_array();
		
		if($data['data']){
			$monthly			= $data['data'];
			$like 				= $monthly['residual_likelihood_action'];
			$impact    			= $monthly['residual_impact_action'];
			$nilai_impact    	= $monthly['nilai_impact'];
			$nilai_likelihood   = $monthly['nilai_likelihood'];
			$nilai_exposure    	= $monthly['nilai_exposure'];
		}else{
			$monthly			= $data['data_awal'];
			$like 				= $monthly['target_like'];
			$impact    			= $monthly['target_impact'];
			$nilai_impact    	= $monthly['nilai_impact'];
			$nilai_likelihood   = $monthly['nilai_likelihood'];
			$nilai_exposure    	= $monthly['nilai_exposure'];
		}

		$like_impact 		= $this->data->level_action($like, $impact);
		$cek_level 			= $this->data->cek_level_new($like, $impact);
		$progress_detail 	= $like_impact['impact']['code'] . ' x ' . $like_impact['like']['code'];
		$cboLike 			= $q['cb_like'];   
		$cboImpact			= $q['cb_impact'];  

		// Fetching details for the target residual level
		$cek_id_detail 		= $this->db->select('id')->where('rcsa_detail', $q['id'])->where('bulan', $month)->get(_TBL_RCSA_ACTION_DETAIL)->row_array();

		// Preparing the HTML form result
		$result = '
			<input type="hidden" id="rcsa_detail_no_' . $q['id'] . '_' . $month . '" name="rcsa_detail_no[]" value="' . $q['id'] . '">
			<input type="hidden" id="rcsa_action_no_' . $q['id'] . '_' . $month . '" name="rcsa_action_no[]" value="' . $act['id'] . '">
			<input type="hidden" id="id_' . $q['id'] . '_' . $month . '" name="id[]" value="' . $q['id'] . '">
			<input type="hidden" id="rcsa_no_' . $q['id'] . '_' . $month . '" name="rcsa_no[]" value="' . $q['rcsa_no'] . '">
			<input type="hidden" id="month_' . $q['id'] . '_' . $month . '" name="month[]" value="' . $month . '">
			<input type="hidden" id="id_edit_' . $q['id'] . '_' . $month . '" name="id_edit[]" value="' . (isset($cek_id_detail) ? $cek_id_detail['id'] : 0) . '">
			<input type="hidden" name="inherent_level[]" id="inherent_level' . $q['id'] . '_' . $month . '" value="' . $data['data']['risk_level_action'] . '">
			
			<div style="display: flex; justify-content: space-between; width: 100%; padding: 0; margin-bottom: 10px;">
				<div class="input-group" style="width:50%">
					<span class="input-group-addon" id="basic-addon1">Rp.</span>
					<input style="max-width: 100px;" type="text" name="nilai_impact[]" value="'.number_format($nilai_impact).'" id="nilai_impact' . $q['id'] . '_' . $month . '" data-id="' . $q['id'] . '" data-month="' . $month . '" class="nilai_impact form-control numeric rupiah" aria-describedby="basic-addon1">
				</div>
				<div class="input-group" style="width:50%">
					<input style="max-width: 105px;" type="text" name="nilai_likelihood[]" id="nilai_likelihood' . $q['id'] . '_' . $month . '" data-id="' . $q['id'] . '" data-month="' . $month . '" value="'.number_format($nilai_likelihood).'" class="nilai_likelihood form-control" aria-describedby="basic-addon2">
					<span class="input-group-addon" id="basic-addon2">%</span>
				</div>
			</div>
			<div style="display: flex; justify-content: space-between; width: 100%; padding: 0; margin-bottom: 10px;">
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1">Rp.</span>
					<input style="width:240px !important;" type="text" name="nilai_exposure[]" id="nilai_exposure' . $q['id'] . '_' . $month . '" data-id="' . $q['id'] . '" data-month="' . $month . '" value="'.number_format($nilai_exposure).'" class="nilai_exposure form-control numeric rupiah" aria-describedby="basic-addon1" readonly>
				</div>
			</div>
			
			<div style="display: flex; justify-content: space-between; width: 100%; padding: 0; margin-bottom: 10px;">
				' . form_dropdown('impact[]', $cboImpact, $impact, 'class="form-control select2" data-mode="3" id="impact' . $q['id'] . '_' . $month . '" data-id="' . $q['id'] . '" data-month="' . $month . '" style="width: 50%;"') . '
				' . form_dropdown('likehold[]', $cboLike, $like, 'class="form-control select2" data-mode="3" id="likehold' . $q['id'] . '_' . $month . '" data-id="' . $q['id'] . '" data-month="' . $month . '" style="width: 50%;"') . '
			</div>
			
			<div style="text-align: center; margin-bottom: 10px;">
				<span id="targetResidualLabel' . $q['id'] . $month . '">
					<span class="btn" style="display: inline-block; width: 100%; background-color: ' . $cek_level['warna_bg'] . '; color: ' . $cek_level['warna_txt'] . '; padding: 4px 8px;">
						' . $cek_level['tingkat'] . ' [' . $progress_detail . ']
					</span>
				</span>
			</div>';


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

        // doi::dump($result);
		return $result;

	}

    function cek_level_new($like, $impact)
	{
		$rows = $this->db->where('impact_no', $impact)->where('like_no', $like)->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
        
		// doi::dump($rows);
        return $rows;
	}

    
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */