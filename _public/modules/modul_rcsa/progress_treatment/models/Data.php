<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}

		public function getDetail($data, $limit, $offset) {
		// Pastikan array owner_child sudah diinisialisasi
		if (!isset($this->owner_child)) {
			$this->owner_child = [];
		}

		// Check if 'owner' is specified in the data
		if (isset($data['owner']) && $data['owner']) {
			$this->get_owner_child($data['owner']);
			$this->owner_child[] = $data['owner'];
			// Apply the 'owner_no' filter
			$this->db->where_in('bangga_view_rcsa_detail.owner_no', $this->owner_child);     
		}

		// Check if 'periode' is specified in the data
		if (isset($data['periode']) && $data['periode']) {
			// Apply the 'tahun' (period) filter
			$this->db->where('bangga_view_rcsa_detail.tahun', $data['periode']);
		}

		// Filter on 'sts_propose' value (status proposal)
		$this->db->where('bangga_view_rcsa_detail.sts_propose', 4);

		// Select specific columns from both tables
		$this->db->select('
			bangga_rcsa_action.id as id_action, bangga_rcsa_action.proaktif as proaktif, bangga_rcsa_action.reaktif as reaktif, 
			bangga_view_rcsa_detail.* 
		');

		// Join with 'bangga_view_rcsa_detail' on 'rcsa_detail_no' field
		$this->db->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_rcsa_action.rcsa_detail_no', 'left'); 

		// Apply limit and offset for pagination
		$this->db->limit($limit, $offset);

		// Execute the query and return the result as an array
		return $this->db->get('bangga_rcsa_action')->result_array();
	}


    public function getDetail_modal($data) {
		// Cek apakah ada 'owner' pada $data
		if ($data['owner']) {
			// Ambil anak-anak dari owner
			$this->get_owner_child($data['owner']);
			$this->owner_child[] = $data['owner'];  // Tambahkan 'owner' ke dalam array owner_child
			// Filter berdasarkan owner_no
			$this->db->where_in('bangga_view_rcsa_detail.owner_no', $this->owner_child);
		}
	
		// Cek apakah ada periode pada $data
		if ($data['periode']) {
			$this->db->where('bangga_view_rcsa_detail.tahun', $data['periode']);
		}
	
		// Filter berdasarkan status 'sts_propose'
		$this->db->where('bangga_view_rcsa_detail.sts_propose', 4);
	
		// Filter berdasarkan triwulan (bulan)
		if (!empty($data['triwulan'])) {
			switch ($data['triwulan']) {
				case 1: // Triwulan 1: Januari - Maret (Bulan 1 - 3)
					$this->db->where('bangga_rcsa_monitoring_treatment.bulan >=', 1);
					$this->db->where('bangga_rcsa_monitoring_treatment.bulan <=', 3);
					break;
				case 2: // Triwulan 2: April - Juni (Bulan 4 - 6)
					$this->db->where('bangga_rcsa_monitoring_treatment.bulan >=', 4);
					$this->db->where('bangga_rcsa_monitoring_treatment.bulan <=', 6);
					break;
				case 3: // Triwulan 3: Juli - September (Bulan 7 - 9)
					$this->db->where('bangga_rcsa_monitoring_treatment.bulan >=', 7);
					$this->db->where('bangga_rcsa_monitoring_treatment.bulan <=', 9);
					break;
				case 4: // Triwulan 4: Oktober - Desember (Bulan 10 - 12)
					$this->db->where('bangga_rcsa_monitoring_treatment.bulan >=', 10);
					$this->db->where('bangga_rcsa_monitoring_treatment.bulan <=', 12);
					break;
			}
		}
	
		// Menggunakan join untuk mendapatkan data terkait
		$this->db->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_rcsa_action.rcsa_detail_no', 'left');
		$this->db->join('bangga_rcsa_monitoring_treatment', 'bangga_rcsa_monitoring_treatment.rcsa_action_no = bangga_rcsa_action.id', 'left');
		$this->db->join('bangga_rcsa_log_treatment', 'bangga_rcsa_log_treatment.id_treatment_monitoring = bangga_rcsa_monitoring_treatment.id', 'left');
	
		if (isset($data['offset'])) {
			$this->db->offset($data['offset']);
		}
	
		// Menambahkan pengurutan berdasarkan bulan
		$this->db->order_by('bangga_rcsa_monitoring_treatment.bulan', 'ASC');
	
		// Eksekusi query
		$query = $this->db->get('bangga_rcsa_action');
	
		// Kembalikan hasil query dalam bentuk array
		return $query->result_array();
	}
	
    
     
    public function count_all_data($data) {
      
        if($data['owner']){
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('bangga_view_rcsa_detail.owner_no', $this->owner_child);     
        }

        if($data['periode']){
            $this->db->where('bangga_view_rcsa_detail.tahun', $data['periode']);
        }
        
        $this->db->where('bangga_view_rcsa_detail.sts_propose', 4);

         // Join with 'owners' table on 'owner_no'
         $this->db->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_rcsa_action.rcsa_detail_no', 'left'); // or 'inner' based on your requirements
    
         // Apply limit and offset for pagination
         $this->db->limit($limit, $offset);
     

        return $this->db->count_all_results('bangga_rcsa_action');
    }
    
    function getMonthlyMonitoringGlobal($q, $month)
	{
 		 
		// doi::dump($q['id_action']);

		$data['data'] = $this->db
			->where('rcsa_action_no', $q['id_action'])
			->where('bulan', $month)
			->get('bangga_rcsa_monitoring_treatment')->row_array();

		$data['risk_treatment'] = $this->db
			->where('id_rcsa_action', $q['id_action'])
			->where('bulan', $month)
			->get('bangga_rcsa_treatment')->row_array();

        $data_risk_treatment = $data['risk_treatment'];
        // doi::dump($data['data']);
      
    
        $result = '
    <td colspan="2">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px; vertical-align: top;">
                    <div class="input-group">
                        <input style="width:100px !important;" readonly type="hidden" name="id_edit[]" id="id_detail_'.$data['data']['id'].$month.'" class="form-control" placeholder="Progress %" value="'.$data['data']['id'].'" aria-describedby="basic-addon2">
                        <input style="width:100px !important;" readonly type="hidden" name="id_detail[]" id="id_detail_'.$data['data']['id'].$month.'_act" class="form-control" placeholder="Progress %" value="'.$q['id'].'" aria-describedby="basic-addon2">
                        <input style="width:100px !important;" readonly type="hidden" name="id_action[]" id="id_action_'.$data['data']['id'].$month.'" class="form-control" placeholder="Progress %" value="'.$data_risk_treatment['id_rcsa_action'].'" aria-describedby="basic-addon2">
                        <input style="width:100px !important;" readonly type="hidden" name="bulan[]" id="bulan_'.$data['data']['id'].$month.'" class="form-control" placeholder="Progress %" value="'.$month.'" aria-describedby="basic-addon2">
                        <input style="width:100px !important;" readonly type="number" name="target_progress[]" id="target_progress_'.$data['data']['id'].$month.'" class="form-control" placeholder="Progress %" value="'.$data_risk_treatment['target_progress_detail'].'" aria-describedby="basic-addon2">
                        <span class="input-group-addon" id="basic-addon2">%</span>
                    </div>
                </td>
                <td style="padding: 10px; vertical-align: top;">
                    <div class="input-group">
                        <input style="width:100px !important;" type="number" name="progress[]" id="progress_'.$data['data']['id'].$month.'" class="form-control" placeholder="Progress %" value="'.$data['data']['progress_detail'].'" aria-describedby="basic-addon2">
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
                        <input style="width:100px !important;" type="text" name="damp_loss[]" id="damp_loss_'.$data['data']['id'].$month.'" 
                        value="'.number_format($data['data']['target_progress_detail'], 0, ',', ',').'" class="form-control numeric rupiah" placeholder="Damp Loss" aria-describedby="basic-addon1">
                    </div>
                </td>
            </tr>
        </table>
    </td>
';


 		return $result;
	}

    public function simpan_tritment($data) {
       
		// Array untuk menampung hasil update
		$upd = [];
		
		// Mendapatkan data dari POST
		$id_action              = $data['rcsa_action_no'];
		$id_detail              = $data['id'];
		$id_edit 		        = $data['id_edit'];
		$month 			        = $data['month'];
		$progress 		        = $data['progress'];
		$damp_lost 		        = str_replace(',', '',$data['damp_loss']);
		
		// Iterasi untuk setiap item dalam array
		foreach ($id_action as $i => $id) {

            $upd_log = [
				'id_detail' 		=> $id_detail[$i],
				'bulan' 			=> $month[$i],
				'tanggal_validasi' 	=> date('Y-m-d H:i:s')
			];

			// Persiapkan data yang akan disimpan
			$upd = [
				'rcsa_detail' => $id_detail[$i],
				'bulan' => $month[$i],
				'rcsa_action_no' => $id,  // Handle empty values
				'progress_detail' => $progress[$i],  // Handle empty values
				'target_progress_detail' => floatval($damp_lost[$i])
			];


			//  Cek apakah data sudah ada
			 $existing_data = $this->db->get_where(_TBL_RCSA_MONITORING_TREATMENT, [
				'id' => $id_edit[$i],
				'bulan' => $month[$i]
			])->row();

			if ($existing_data) {
				$upd['update_user'] = $this->authentication->get_info_user('username');
				$where['rcsa_action_no'] = $id;
				$where['bulan'] = $month[$i];
				$result = $this->crud->crud_data(array('table' => _TBL_RCSA_MONITORING_TREATMENT, 'field' => $upd, 'where' => $where, 'type' => 'update'));
				$id     = $id_edit[$i];
				$type = 'edit';

                $cek_log = $this->db->get_where(_TBL_RCSA_LOG_TREATMENT, [
					'id_treatment_monitoring' => $id_edit[$i],
					'bulan' => $month[$i]
				])->row();

				if($cek_log){
					$upd_log['update_user'] = $this->authentication->get_info_user('username');
					$where_log['id_treatment_monitoring'] = $id;
					$where_log['bulan'] = $month[$i];
					$result_log = $this->crud->crud_data(array('table' => _TBL_RCSA_LOG_TREATMENT, 'field' => $upd_log, 'where' => $where_log, 'type' => 'update'));
				}else{
					$upd_log['id_treatment_monitoring'] = $id;
					$upd_log['create_user'] = $this->authentication->get_info_user('username');
					$log = $this->crud->crud_data(['table' => _TBL_RCSA_LOG_TREATMENT, 'field' => $upd_log, 'type' => 'add']);
				}
				
			} else {
				$upd['create_user'] = $this->authentication->get_info_user('username');
				$id = $this->crud->crud_data(['table' => _TBL_RCSA_MONITORING_TREATMENT, 'field' => $upd, 'type' => 'add']);
				$id = $this->db->insert_id();
				$type = "add";

                $upd_log['id_treatment_monitoring'] = $id;
                $upd_log['create_user'] = $this->authentication->get_info_user('username');
                $log = $this->crud->crud_data(['table' => _TBL_RCSA_LOG_TREATMENT, 'field' => $upd_log, 'type' => 'add']);
			}
	
		}
	
		return $id;  // Mengembalikan ID terakhir yang diupdate/ditambahkan
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
    
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */