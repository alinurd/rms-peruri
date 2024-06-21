<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function get_data_pemakai($id){
		$hasil=array();
		return $hasil;
	}
	
	function data_get_code_agen($id){
		$query = $this->db->where('uri_title','agen_no_last')->get($this->tbl_preference);
		$rows=$query->result_array();
		$last_no=1;
		if ($rows){
			foreach($rows as $row){
				$last_no=intval($row['value'])+1;
			}
		}
		$query = $this->db->where('uri_title','format_agen')->get($this->tbl_preference);
		$rows=$query->result_array();
		$format='';
		if ($rows){
			foreach($rows as $row){
				$format=$row['value'];
			}
		}
		
		$arrbln=array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12);
		
		$format = str_replace('#no#', $last_no, $format);
		$format = str_replace('#blnR#', romanic_number(date('n')), $format);
		$format = str_replace('#bln#', intval(date('n')), $format);
		$format = str_replace('#thn#', date('Y'), $format);
		
		$this->crud->crud_data(array('table'=>$this->tbl_preference, 'field'=>array('value'=>$last_no),'where'=>array('uri_title'=>'agen_no_last'),'type'=>'update'));
		
		return $format;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */