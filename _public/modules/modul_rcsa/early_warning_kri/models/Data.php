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


        if ($rows) {

            $updkri['rcsa_detail'] = $data['id'];
            $updkri['realisasi'] = $data['realisasi'];

            $where['rcsa_detail'] = $data['id'];
            $where['bulan'] = $data['bulan'];
            $updkri['update_user'] = $this->authentication->get_info_user('username');
            $res = $this->crud->crud_data(array('table' => _TBL_KRI_DETAIL, 'field' => $updkri, 'where' => $where, 'type' => 'update'));
        } else {

            $kridet['realisasi'] = $data['realisasi'];
            $kridet['rcsa_detail'] = $data['id'];
            $kridet['bulan'] = $data['bulan'];
            // $kridet['action_detail'] = $id;

            $kridet['create_user'] = $this->authentication->get_info_user('username');
            $res = $this->crud->crud_data(array('table' => _TBL_KRI_DETAIL, 'field' => $kridet, 'type' => 'add'));
            $id = $this->db->insert_id();
        }
        $result['bg'] = '';
        if($res){
            $kri = $this->db
            ->where('rcsa_detail',$data['id'])
            ->get(_TBL_KRI)->row_array();
         $data['kri_detail'] = $this->db
        ->where('rcsa_detail', $kri['rcsa_detail'])
        ->where('bulan',  $data['bulan'])
        ->get(_TBL_KRI_DETAIL)->row_array();
        $realisasi = $data['kri_detail']['realisasi'];
       $level_1 = range($kri['min_rendah'], $kri['max_rendah']);
       $level_2 = range($kri['min_menengah'], $kri['max_menengah']);
       $level_3 = range($kri['min_tinggi'], $kri['max_tinggi']);
       if (in_array($realisasi, $level_1)) {
        $result['bg'] = '#7FFF00'; // Warna Aman (hijau)
    } elseif (in_array($realisasi, $level_2)) {
        $result['bg'] = '#FFFF00'; // Warna Hati-Hati (kuning)
    } elseif (in_array($realisasi, $level_3)) {
        $result['bg'] = '#FF0000'; // Warna Bahaya (merah)
    } else {
        $result['bg'] = ''; // Tidak ada warna
    }
     
        }
        


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
 
        $upd['progress_detail'] = $data['progress']; 
        $upd['damp_loss']       = $data['damp_loss']; 

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

        return $this->db->where('kri !=', null)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
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

        return $this->db->where('kri !=', null)->count_all_results(_TBL_VIEW_RCSA_DETAIL);
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

        
        $monthly = $data['data']; 

        $monthbefore = $data['before'];
 

        
        if (!$monthbefore && $month !=1) {
			$result['data'] = '<center><i class="  fa fa-times-circle text-danger"></i></center>';
		} else {
            if (!$monthly) {
                $result['data'] = '<center><i class="  fa fa-times-circle text-warning" title="Level Risiko belum lengkap"></i></center>';

                // $result = '
                // <div class="input-group" width="10px">
                //      <input type="number" name="progress'.$act['id'].$month.'" id="progress'.$act['id'].$month.'" class="form-control" placeholder="" aria-describedby="basic-addon2">
                //      <span class="input-group-addon" id="basic-addon2">%</span>
                //  </div>
                //  <br>
                //  <div class="input-group" width="10px">
                //      <span class="input-group-addon" id="basic-addon1">Rp.</span>
                //      <input type="number" name="damp_loss'.$act['id'].$month.'" id="damp_loss'.$act['id'].$month.'" class="form-control" placeholder="" aria-describedby="basic-addon1">
                //  </div>
                //  <br>
                //   <center><span class="btn btn-primary" id="simpan_realisasi_'.$act['id'].'" data-month="'.$month.'" data-id="'.($act['id'] ?? '').'">
                //   <i class="fa fa-floppy-o" aria-hidden="true"></i> simpan</span></center>
                // ';
            } else {
                $result['data'] = '
                <div width="10px">
                    <input type="number"  name="realisasi'.$q['id'].$month.'" id="realisasi'.$q['id'].$month.'" class="form-control" placeholder="" value="'.$realisasi.'" aria-describedby="basic-addon2"> 
                </div>
                <br>
                  <center><span class="btn btn-primary" id="simpan_realisasi_'.$q['id'].'" data-month="'.$month.'" data-id="'.$q['id'].'">
                  <i class="fa fa-floppy-o" aria-hidden="true"></i> simpan</span></center>
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