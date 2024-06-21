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

        // Doi::dump($_FILES);

         $upd['damp_loss'] = $data['damp_loss'];
        $upd['risk_control'] = $data['risk_control'];
        $upd['rcsa_action_no'] = $data['rcsa_action_no'];
        $upd['bulan'] = $data['bulan'];
        $upd['realisasi'] = $data['realisasi'];
        $upd['progress_detail'] = $data['progress'];
        $upd['status_loss'] = $data['status_loss'];
        // $upd['notes']=$data['notes'];
        $upd['keterangan'] = $data['keterangan'];
        $upd['perlakuan_risiko'] = $data['perlakuan_risiko'];

        $sts = $data['progress'];
        if (floatval($data['progress']) >= 100)
        $sts = 1;
        // $upd['status_no']=$sts;
        $upd['rcsa_detail'] = $data['detail_rcsa_no'];

        $upd['status_no'] = $data['status_no'];
        $upd['residual_likelihood_action'] = $data['residual_likelihood'];
        $upd['residual_impact_action'] = $data['residual_impact'];
        $upd['risk_level_action'] = $data['inherent_level'];
        if (!empty($data['progress_date']))
        $upd['progress_date'] = date('Y-m-d', strtotime($data['progress_date']));

        if ((int)$data['id_edit'] > 0) {
            // die('model');

            $upd['update_user'] = $this->authentication->get_info_user('username');
            
            $where['id'] = $data['id_edit'];
            $result = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'where' => $where, 'type' => 'update'));
            $id = intval($data['id_edit']);

            $type = "edit";
        } else {
            $upd['create_user'] = $this->authentication->get_info_user('username');
            $id = $this->crud->crud_data(array('table' => _TBL_RCSA_ACTION_DETAIL, 'field' => $upd, 'type' => 'add'));
            $id = $this->db->insert_id();
            $type = "add";
        }


        $upd = [];

        $rows = $this->db->where('rcsa_action_no', $data['rcsa_action_no'])->order_by('progress_date', 'desc')->limit(1)->get(_TBL_RCSA_ACTION_DETAIL)->row_array();
        if ($rows) {
            $upd['residual_likelihood'] = $rows['residual_likelihood_action'];
            $upd['residual_impact'] = $rows['residual_impact_action'];
            $upd['risk_level'] = $rows['risk_level_action'];
            $upd['status_loss_parent'] = $rows['status_loss'];
            $where['id'] = $data['detail_rcsa_no'];
            $result = $this->crud->crud_data(array('table' => _TBL_RCSA_DETAIL, 'field' => $upd, 'where' => $where, 'type' => 'update'));
        }

        // $where['id']=$data['action_no'];
        // $result=$this->crud->crud_data(array('table'=>_TBL_RCSA_ACTION, 'field'=>['status_loss'=>$data['status_loss']],'where'=>$where,'type'=>'update'));

        return $result;
    }
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */