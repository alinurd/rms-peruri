<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
    var $post = [];

	public function __construct()
    {
        parent::__construct();
	}

    function coba($post){
    	// $a = $this->id_param_owner['privilege_owner']['id'] ;
    	// var_dump($a);
    	$a = $this->db->select('id,level_no')->where('id',$post['owner_no'])->get(_TBL_OWNER)->result_array();
    	$b = array();
    	foreach ($a as $key => $value) {
    		$b = $value['level_no'];
    	}
    	
    	// $b = $a['level_no'];
    	// var_dump($b);
// 	if ($b == 3) {

// 			$rows['bobo'] = $this->db->where('owner_no', $post['owner_no'])->where('period_no', $post['periode_no'])->where('sts_next >', 0)->order_by('inherent_analisis', 'ASC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
//    }else{
//    		$rows['bobo'] = $this->db->where('owner_no',$post['owner_no'])->where('period_no',$post['periode_no'])->where('sts_next >',0)->order_by('inherent_analisis','ASC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
//    }
		$rows['bobo'] = $this->db->where('owner_no', $post['owner_no'])->where('period_no', $post['periode_no'])->where('sts_next >', 0)->order_by('inherent_analisis', 'ASC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

 	  $rows['baba'] = array();
		foreach ($rows['bobo'] as $key => $value) {
			if ($b == 3) {
		$this->db->where('owner_no',$post['owner_no']);
	}else{
		$this->db->where('owner_no',$post['owner_no']);
	}
		$this->db->where('period_no',$post['periode_no']);
		$this->db->where('bulan',$post['bulan']);
		$this->db->where('rcsa_detail_no', $value['id']);
		
		$row = $this->db->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();

		if ($row) {
					foreach ($row as $key1 => $value1) {

			$rows['baba'][$value['id']]['status_action_detail']=$value1['status_action_detail'];
			$rows['baba'][$value['id']]['residual_analisis']=$value1['residual_analisis'];
			$rows['baba'][$value['id']]['warna_residual']=$value1['warna_residual'];
			$rows['baba'][$value['id']]['warna_text_residual']=$value1['warna_text_residual'];
			$rows['baba'][$value['id']]['type_name']=$value1['type_name'];
			$rows['baba'][$value['id']]['progress_detail']=$value1['progress_detail'];
		}
		}else{
			$rows['baba'][$value['id']]['status_action_detail']="";
			$rows['baba'][$value['id']]['residual_analisis']="";
			$rows['baba'][$value['id']]['warna_residual']="";
			$rows['baba'][$value['id']]['warna_text_residual']="";
			$rows['baba'][$value['id']]['type_name']="";
			$rows['baba'][$value['id']]['progress_detail']=0;
		}

		}
		// var_dump($rows['baba']);
		// die();
    return $rows;

    }
    
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */