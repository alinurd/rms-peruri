<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class User_Online extends BackendController {
	var $tmp_data=array();
	var $data_fields=array();
	
	public function __construct()
	{
        parent::__construct();
		ini_set('max_execution_time', 0); 
		ini_set('memory_limit', '256M');	
		$this->load->library('googlemaps');
	}
	
	public function index(){
		$data['maps']=$this->data_peta();
		$this->template->build('analisa', $data);
	}
	
	function data_peta($kel="puskesmas", $data=array()){
		$ada=false;
		$config['zoom'] = '5';
		$config['center'] = '-1.362176,117.817383';
		// $config['map_div_id'] = 'map_canvas_'.$kel;
		$data=$this->data->get_lokasi_user($kel);
		
		$config['sensor'] = true;
		$config['map_height'] = 380;
		$config['map_name'] = "map_".$kel;
		$config['cluster'] = true;
		$config['apiKey'] = 'AIzaSyD-9SGqwku28lZF3C9wwwaD0JK2pUXPVwo';
		$config['disableMapTypeControl'] = true;
		$config['disableNavigationControl'] = true;
		$config['disableScaleControl'] = true;
		$config['disableStreetViewControl'] = true;
		$config['places'] = TRUE;
		$config['markers'] = array();
		$this->googlemaps->initialize($config);
		  
		if (count($data)>0){
			foreach($data as $row){
				$marker = array();
				if (!empty($row['lat']) && !empty($row['lng'])){
					$marker['position'] = $row['lat'] . ',' . $row['lng'];
					$this->googlemaps->add_marker($marker);
				}
			}
		}
		if ($kel=='ebs'){
			$data_ebs=$this->data->get_lokasi_alert($kel, 1);
			$data['table_map'] = $this->load->view('analisa_ebs/table_map', array('field'=>$data_ebs), true);
		}
		
		// Doi::dump($data);
		// die();
		$data['map_'.$kel] = $this->googlemaps->create_map();		
		return $data;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */