<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
    var $post = [];

	public function __construct()
    {
        parent::__construct();
	}

    function grafik (){

        $rows_couse = $this->db->where_in('id', $this->post['owner_no'])->get(_TBL_OWNER)->result_array();
        $arrCouse=array();
                foreach($rows_couse as $rc){
                    $arrCouse[]=$rc['name'];
                }

        return $arrCouse;
    }
    function bln (){
   $rows_couse1 = $this->db->where_in('id', $this->post['periode_no'])->get(_TBL_PERIOD)->result_array();
        $arrCouse1=array();
                foreach($rows_couse1 as $rc1){
                    $arrCouse1[]=$rc1['periode_name'];
                } 
                return $arrCouse1;
    }
 function judul(){
         

      $rows3 = $this->db->where('id',$this->post['judul_assesment'])->get(_TBL_VIEW_RCSA)->result_array();

        $arrCouse3=array();
           foreach($rows3 as $rc3){
                    $arrCouse3[]=$rc3['judul_assesment'];
                } 
             
                return $arrCouse3;  
    }
     function sasaran(){
         

      $rows4 = $this->db->where('id',$this->post['sasaran'])->get(_TBL_RCSA_SASARAN)->result_array();

        $arrCouse4=array();
           foreach($rows4 as $rc4){
                    $arrCouse4[]=$rc4['sasaran'];
                } 
             
                return $arrCouse4;  
    }
  
         
      function uchiha(){
         

      $rows = $this->db->where_in('rcsa_no',$this->post['judul_assesment'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

        $arrCouse2=array();
                foreach($rows as $key => $rc2){
                    $arrCouse2[$key]=$rc2;
                     // $arrCouse2[$key]['haha']=$baba;

                } 
                return $arrCouse2;  
    }
    
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */