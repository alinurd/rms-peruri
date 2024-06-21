<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
    var $post = [];

	public function __construct()
    {
        parent::__construct();
	}

    function coba($post){
      $rows = $this->db->select('*')->where('period_no',$post['periode_no'])->order_by('area_name','ASC')->order_by('sasaran','DESC')->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
      $a = $post['owner_no'];
      foreach($rows as $key => &$row)
    {
      $arrCouse = json_decode($row['owner_no'],true);
      $arrCouse1 = json_decode($row['rcsa_no'],true);
      $rows_couse=array();

      if (in_array($a, $arrCouse)){
            $rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
            $rows_couse1 = $this->db->where_in('id',$arrCouse1)->get(_TBL_RCSA)->result_array();
           
            $arrCouse=array();

            foreach($rows_couse as $rc){
              $arrCouse[] = $rc['name'];
            }
            foreach($rows_couse1 as $rc1){
              $row['judul_assesment'] = $rc1['judul_assesment'];
            }

            
      }else{
        unset($rows[$key]);
      
      }
       $row['owner']= implode('### ',$arrCouse);
      

    }
    unset($row);
    return $rows;

    }
    
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */