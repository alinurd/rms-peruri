<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Top_Risk extends BackendController
{
	var $tmp_data = array();
	var $data_fields = array();

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array();
		if ($this->input->post())
			$post = $this->input->post();
		else
			$post = array('owner_no' => 0, 'period_no' => 0,'bulan' =>0, 'project_no' => 0);
		if (isset($post['project_no'])) {
			$data['project_no'] = $post['project_no'];
		}
		$data['type_dash'] = 1;
		$data['setting'] = $this->crud->get_setting($data);
		$data['post'] = $post;
		if (count($data['setting']['rcsa']) > 0)
			$data['cbo_project'] = $this->get_combo('project_rcsa', $data['setting']['rcsa'][0]);
		else
			$data['cbo_project'] = array();
		$data['cbo_owner'] = $this->get_combo('parent-input');

		if ($this->id_param_owner['privilege_owner']['id'] == 1) {
			$data['cbo_owner'][0] = 'Perum Peruri ';
		}
		$data['cbo_bulan']=$this->get_combo('bulan');
		$data['cbo_period'] = $this->get_combo('periode');
		$hoho = $data['cbo_owner']; 
		foreach ($hoho as $key => $value) {
 			$owner_id = $key;
			}	
		
		if ($this->id_param_owner['privilege_owner']['id'] == 1){
			$data['cbo_owner'][0] = 'Perum Peruri ';
			$param = ['id_period' => _TAHUN_NO_,'bulan' => date('n'), 'id_owner' => 0];
		}else{
			$param = ['id_period' => _TAHUN_NO_,'bulan' => date('n'), 'id_owner' => $owner_id ];
		}
		$data['mapping'] = $this->data->get_map_rcsa($param);
		$this->template->build('dashboard', $data);
	}

	function get_map()
	{
		$post = $this->input->post();
		//$id_rcsa =$post=$this->input->post('id_owner');
		$data = $this->data->get_map_rcsa($post);
		// var_dump($data);
		// $hasil['combo'] = $data;
		$hasil = $data;
		echo json_encode($hasil);

	}
	public function get_detail_map()
	{
		$post = $this->input->post();
		$a = $this->db->select('id,level_no')->where('id', $post['owner'])->get(_TBL_OWNER)->result_array();
		$b = array();
		// doi::dump($post);
		foreach ($a as $key => $value) {
			$b = $value['level_no'];
		}

		if ($post['kel'] == 'inherent') {
			$this->db->where('inherent_level', $post['id']);
		} else {
			$this->db->where('risk_level_action', $post['id']);
		}


		if ($post['owner'] == 0 && $post['kel'] == 'inherent') {
			$rows = $this->db->where('sts_propose', 4)->where('urgensi_no', 0)->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			// doi::dump($rows);

		} elseif ($post['owner'] == 0 && $post['kel'] == 'residual') {
			$rows['bobo'] = $this->db->where('sts_propose', 4)->where('urgensi_no', 0)->where('bulan >=', $post['bulan'])
				->where('bulan <=', $post['bulan'])->where('period_no', $post['tahun'])->where('risk_level_action', $post['id'])->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		} elseif ($post['owner'] > 0 && $post['kel'] == 'inherent') {
			if ($b == 3) {
				$rows = $this->db->where('sts_propose', 4)->where('urgensi_no', 0)->where('parent_no', $post['owner'])->where('period_no', $post['tahun'])->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			} else {


				$this->owner_child[] = $post['post'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$rows = $this->db->where('sts_propose', 4)->where('urgensi_no', 0)->where('period_no', $post['tahun'])->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			}
		} else {
			if ($b == 3) {

				$this->owner_child[] = $post['post'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$rows['bobo'] = $this->db
					->where('sts_propose', 4)
					->where('urgensi_no ', 0)->where('parent_no', $post['owner'])
					->where('period_no', $post['tahun'])
 					->where('bulan <=', $post['bulan'])->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			} else {

				$rows['bobo'] = $this->db->where('sts_propose', 4)
					->where('urgensi_no ', 0)
					->where('owner_no', $post['owner'])
					->where('period_no', $post['tahun'])
					->where('bulan >=', $post['bulan'])
					->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			}
		}
		if ($post['kel'] == 'inherent') {
			foreach ($rows as &$row) {
				$arrCouse = json_decode($row['risk_couse_no'], true);
				$rows_couse = array();
				if ($arrCouse) {
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
				}
				$arrCouse = array();
				foreach ($rows_couse as $rc) {
					$arrCouse[] = $rc['description'];
				}
				$row['couse'] = implode(', ', $arrCouse);

				$arrCouse = json_decode($row['risk_impact_no'], true);
				$rows_couse = array();
				if ($arrCouse) {
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
				}
				$arrCouse = array();
				foreach ($rows_couse as $rc) {
					$arrCouse[] = $rc['description'];
				}
				$row['impact'] = implode(', ', $arrCouse);
			}
			unset($row);
		} else {
			$rows['baba'] = array();

			foreach ($rows['bobo'] as $key => $value) {
				// if ($post['owner'] == 0) {
				// 	$this->db->where('owner_no',$post['owner']);
				// }elseif($post['owner'] > 0 && $b == 3){
				// 	$this->db->where('parent_no',$post['owner']);
				// }else{
				// 	$this->db->where('owner_no',$post['owner']);
				// }

				if ($post['owner'] > 0 && $b == 3) {
					$this->db->where('parent_no', $post['owner']);
					$this->db->where('period_no', $post['tahun']);
					$this->db->where('id', $value['rcsa_detail_no']);
				} elseif ($post['owner'] > 0) {
					$this->db->where('owner_no', $post['owner']);
					$this->db->where('period_no', $post['tahun']);
					$this->db->where('id', $value['rcsa_detail_no']);
				} else {
					$this->db->where('period_no', $post['tahun']);
					$this->db->where('id', $value['rcsa_detail_no']);
				}


				$row = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

				if ($row) {
					foreach ($row as $key1 => $value1) {
						$rows['baba'][$value['rcsa_detail_no']]['inherent_analisis'] = $value1['inherent_analisis'];
						$rows['baba'][$value['rcsa_detail_no']]['warna'] = $value1['warna'];
						$rows['baba'][$value['rcsa_detail_no']]['warna_text'] = $value1['warna_text'];
					}
				} else {
					$rows['baba'][$value['rcsa_detail_no']]['inherent_analisis'] = "";
					$rows['baba'][$value['rcsa_detail_no']]['warna'] = "";
					$rows['baba'][$value['rcsa_detail_no']]['warna_text'] = "";
				}
			}
		}

		// doi::dump($rows);

		// var_dump($value['rcsa_detail_no']);
		// die();
		$a = $post['kel'];
		$hasil['combo'] = $this->load->view('detail', ['data' => $rows, 'kel' => $a], true);
		echo json_encode($hasil);
	}
	public function get_detail_map_res()
	{
		$post = $this->input->post();
		$a = $this->db->select('id,level_no')->where('id', $post['owner'])->get(_TBL_OWNER)->result_array();
		$b = array();
		// doi::dump($post);
		foreach ($a as $key => $value) {
			$b = $value['level_no'];
		}

		if ($post['kel'] == 'residual') {
			$this->db->where('residual_level', $post['id']);
		} else {
			$this->db->where('risk_level_action', $post['id']);
		}


		if ($post['owner'] == 0 && $post['kel'] == 'residual') {
			$rows = $this->db->where('sts_propose', 4)->where('urgensi_no', 0)->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			// doi::dump($rows);

		} elseif ($post['owner'] == 0 && $post['kel'] == 'residual') {
			$rows['bobo'] = $this->db->where('sts_propose', 4)->where('urgensi_no', 0)->where('bulan >=', $post['bulan'])
				->where('bulan <=', $post['bulan'])->where('period_no', $post['tahun'])->where('risk_level_action', $post['id'])->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		} elseif ($post['owner'] > 0 && $post['kel'] == 'residual') {
			if ($b == 3) {
				$rows = $this->db->where('sts_propose', 4)->where('urgensi_no', 0)->where('parent_no', $post['owner'])->where('period_no', $post['tahun'])->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			} else {


				$this->owner_child[] = $post['post'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$rows = $this->db->where('sts_propose', 4)->where('urgensi_no', 0)->where('period_no', $post['tahun'])->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			}
		} else {
			if ($b == 3) {

				$this->owner_child[] = $post['post'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$rows['bobo'] = $this->db
					->where('sts_propose', 4)
					->where('urgensi_no ', 0)->where('parent_no', $post['owner'])
					->where('period_no', $post['tahun'])
 					->where('bulan <=', $post['bulan'])->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			} else {

				$rows['bobo'] = $this->db->where('sts_propose', 4)
					->where('urgensi_no ', 0)
					->where('owner_no', $post['owner'])
					->where('period_no', $post['tahun'])
					->where('bulan >=', $post['bulan'])
 					->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			}
		}
		if ($post['kel'] == 'residual') {
			foreach ($rows as &$row) {
				$arrCouse = json_decode($row['risk_couse_no'], true);
				$rows_couse = array();
				if ($arrCouse) {
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
				}
				$arrCouse = array();
				foreach ($rows_couse as $rc) {
					$arrCouse[] = $rc['description'];
				}
				$row['couse'] = implode(', ', $arrCouse);

				$arrCouse = json_decode($row['risk_impact_no'], true);
				$rows_couse = array();
				if ($arrCouse) {
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
				}
				$arrCouse = array();
				foreach ($rows_couse as $rc) {
					$arrCouse[] = $rc['description'];
				}
				$row['impact'] = implode(', ', $arrCouse);
			}
			unset($row);
		} else {
			$rows['baba'] = array();

			foreach ($rows['bobo'] as $key => $value) {
				// if ($post['owner'] == 0) {
				// 	$this->db->where('owner_no',$post['owner']);
				// }elseif($post['owner'] > 0 && $b == 3){
				// 	$this->db->where('parent_no',$post['owner']);
				// }else{
				// 	$this->db->where('owner_no',$post['owner']);
				// }

				if ($post['owner'] > 0 && $b == 3) {
					$this->db->where('parent_no', $post['owner']);
					$this->db->where('period_no', $post['tahun']);
					$this->db->where('id', $value['rcsa_detail_no']);
				} elseif ($post['owner'] > 0) {
					$this->db->where('owner_no', $post['owner']);
					$this->db->where('period_no', $post['tahun']);
					$this->db->where('id', $value['rcsa_detail_no']);
				} else {
					$this->db->where('period_no', $post['tahun']);
					$this->db->where('id', $value['rcsa_detail_no']);
				}


				$row = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

				if ($row) {
					foreach ($row as $key1 => $value1) {
						$rows['baba'][$value['rcsa_detail_no']]['residual_analisis'] = $value1['residual_analisis'];
						$rows['baba'][$value['rcsa_detail_no']]['warna'] = $value1['warna'];
						$rows['baba'][$value['rcsa_detail_no']]['warna_text'] = $value1['warna_text'];
					}
				} else {
					$rows['baba'][$value['rcsa_detail_no']]['residual_analisis'] = "";
					$rows['baba'][$value['rcsa_detail_no']]['warna'] = "";
					$rows['baba'][$value['rcsa_detail_no']]['warna_text'] = "";
				}
			}
		}

		$a = $post['kel'];
		$hasil['combo'] = $this->load->view('detailres', ['data' => $rows, 'kel' => $a,], true);
		echo json_encode($hasil);
	}
	function get_detail_map_old()
	{

		$post = $this->input->post();
		$a = $this->db->select('id,level_no')->where('id',$post['owner'])->get(_TBL_OWNER)->result_array();
$b = array();
foreach ($a as $key => $value) {
$b = $value['level_no'];
}
		if ($post['kel']=='inherent'){
			$this->db->where('inherent_level', $post['id']);
		}else{
			$this->db->where('risk_level_action', $post['id']);
		}
		if ($post['owner'] == 0 && $post['kel']=='inherent') {
			
		$rows = $this->db->where('urgensi_no >',0)->where('urgensi_no_kadiv', 1)->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		}elseif($post['owner'] == 0 && $post['kel']=='residual') {

		$rows['bobo'] = $this->db->where('urgensi_no >',0)->where('urgensi_no_kadiv', 1)->where('bulan', $post['bulan'])->where('risk_level_action', $post['id'])->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			
		}elseif ($post['owner'] > 0 && $post['kel']=='inherent') {
			if ($b == 3) {
			$rows = $this->db->where('urgensi_no >',0)->where('urgensi_no_kadiv', 1)->where('parent_no', $post['owner'])->where('period_no', $post['tahun'])->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			}else{
				$rows = $this->db->where('urgensi_no >',0)->where('urgensi_no_kadiv', 1)->where('owner_no', $post['owner'])->where('period_no', $post['tahun'])->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

			}
		}else {
		
		$rows['bobo'] = $this->db->where('urgensi_no >', 0)->where('urgensi_no_kadiv', 1)->where('owner_no', $post['owner'])->where('period_no', $post['tahun'])->where('bulan', $post['bulan'])->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		}
		if ($post['kel']=='inherent') {
		foreach ($rows as &$row) {
			$arrCouse = json_decode($row['risk_couse_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['couse'] = implode(', ', $arrCouse);

			$arrCouse = json_decode($row['risk_impact_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['impact'] = implode(', ', $arrCouse);
		}
		unset($row);
		}else{
		$rows['baba'] = array();

		foreach ($rows['bobo'] as $key => $value) {
			if($post['owner'] > 0 && $b == 3){
				$this->db->where('parent_no',$post['owner']);
				$this->db->where('period_no',$post['tahun']);
				$this->db->where('id', $value['rcsa_detail_no']);
			 }elseif($post['owner'] > 0){
				$this->db->where('owner_no',$post['owner']);
				$this->db->where('period_no',$post['tahun']);
				$this->db->where('id', $value['rcsa_detail_no']);
			 }else{
			 	$this->db->where('period_no',$post['tahun']);
				$this->db->where('id', $value['rcsa_detail_no']);
			 }

		$row = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		if ($row) {
			foreach ($row as $key1 => $value1) {
			$rows['baba'][$value['rcsa_detail_no']]['inherent_analisis']=$value1['inherent_analisis'];
			$rows['baba'][$value['rcsa_detail_no']]['warna']=$value1['warna'];
			$rows['baba'][$value['rcsa_detail_no']]['warna_text']=$value1['warna_text'];
		}
		}else{
			$rows['baba'][$value['rcsa_detail_no']]['inherent_analisis']="";
			$rows['baba'][$value['rcsa_detail_no']]['warna']="";
			$rows['baba'][$value['rcsa_detail_no']]['warna_text']="";
		}
	}
	}
		$a = $post['kel'];
		$hasil['combo'] = $this->load->view('detail', ['data' => $rows,'kel'=>$a], true);

		echo json_encode($hasil);

	}
	function get_subdetail()
	{
		$post = $this->input->post();
		$this->db->where('id', $post['id']);
		$row = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$arrCouse = json_decode($row['risk_couse_no'], true);
		$rows_couse = array();
		if ($arrCouse)
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
		$arrCouse = array();
		foreach ($rows_couse as $rc) {
			$arrCouse[] = $rc['description'];
		}
		$row['couse'] = implode(', ', $arrCouse);

		$arrCouse = json_decode($row['risk_impact_no'], true);
		$rows_couse = array();
		if ($arrCouse)
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
		$arrCouse = array();
		foreach ($rows_couse as $rc) {
			$arrCouse[] = $rc['description'];
		}
		$row['impact'] = implode(', ', $arrCouse);
		
		$hasil['data']=$row;
		
		$this->db->where('rcsa_detail_no', $post['id']);
		$rows = $this->db->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();

		foreach($rows as &$row){
			$arrCouse = json_decode($row['accountable_unit'],true);
			$rows_couse=array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse=array();
			foreach($rows_couse as $rc){
				$arrCouse[]=$rc['name'];
			}
			
			$row['penanggung_jawab']=implode('### ',$arrCouse);
		}
		unset($row);

		$hasil['mitigasi']=$rows;

		$this->db->where('rcsa_detail_no', $post['id']);
		$row = $this->db->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		$hasil['realisasi']=$row;
		
		$hasil['combo'] = $this->load->view('subdetail',$hasil, true);

		echo json_encode($hasil);
	}
	function get_export_data()
	{
		$post = $this->input->post();
		$bulan = $post['bulan'];
		$bulan2 = $post['bulan2'];
		$tahun2 = $post['tahun2'];
$a = $this->db->select('id,level_no')->where('id',$post['owner'])->get(_TBL_OWNER)->result_array();
$b = array();
foreach ($a as $key => $value) {
$b = $value['level_no'];
}			
		if ($post['owner'] > 0) {
			if ($b == 3) {
				$rows['bobo'] = $this->db->where('urgensi_no >', 0)->where('urgensi_no_kadiv', 1)->where('parent_no', $post['owner'])->where('period_no', $post['tahun'])->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();	
			}else{
				$rows['bobo'] = $this->db->where('urgensi_no >', 0)->where('urgensi_no_kadiv', 1)->where('owner_no', $post['owner'])->where('period_no', $post['tahun'])->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();	
			}
			$this->db->where('owner_no', $post['owner']);
			$this->db->where('period_no', $post['tahun']);
			$this->db->where('bulan', $post['bulan']);
			$this->db->where('risk_level >', 0);
			$a = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		}else {
			$rows['bobo']= $this->db->where('urgensi_no >', 0)->where('urgensi_no_kadiv', 1)->where('period_no', $post['tahun'])->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			$this->db->where('period_no', $post['tahun']);
			$this->db->where('bulan', $post['bulan']);
			$this->db->where('risk_level >', 0);
			$a = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		}
		$owner = $this->db->where('id', $post['owner'])->get(_TBL_OWNER)->row_array();
		if ($post['owner'] == 0) {
			$owner1 = 'Perum Peruri';
		}else{
			 $owner1 = $owner['name'];
		}
		$jon = array();
		foreach ($rows['bobo'] as $key => $value) {
		$this->db->where('rcsa_detail_no', $value['id']);
		$row = $this->db->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
		foreach ($row as $key1 => $value1) {
			$jon[$value['id']][]=$value1['proaktif'];
		}
		}
		$rows['baba'] = array();

		foreach ($rows['bobo'] as $key => $value) {
			if($post['owner'] > 0 && $b == 3){
				$this->db->where('parent_no',$post['owner']);
				$this->db->where('period_no',$post['tahun']);
				$this->db->where('bulan',$post['bulan']);
				$this->db->where('rcsa_detail_no', $value['id']);
			 }elseif($post['owner'] > 0){
				$this->db->where('owner_no',$post['owner']);
				$this->db->where('period_no',$post['tahun']);
				$this->db->where('bulan',$post['bulan']);
				$this->db->where('rcsa_detail_no', $value['id']);
			 }else{
			 	$this->db->where('period_no',$post['tahun']);
				$this->db->where('bulan',$post['bulan']);
				$this->db->where('rcsa_detail_no', $value['id']);
			 }
		
		$this->db->where('period_no',$post['tahun']);
		$this->db->where('bulan',$post['bulan']);
		$this->db->where('rcsa_detail_no', $value['id']);
		$row = $this->db->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		if ($row) {
			foreach ($row as $key1 => $value1) {
			$rows['baba'][$value['id']]['inherent_analisis_action']=$value1['inherent_analisis_action'];
			$rows['baba'][$value['id']]['warna_action']=$value1['warna_action'];
			$rows['baba'][$value['id']]['warna_text_action']=$value1['warna_text_action'];
		}
		}else{
			$rows['baba'][$value['id']]['inherent_analisis_action']="";
			$rows['baba'][$value['id']]['warna_action']="";
			$rows['baba'][$value['id']]['warna_text_action']="";
		}
	}

		$hasil['combo'] = $this->load->view('detail_data', ['data' => $rows,'filter' => $post,'proaktif'=>$jon,'bobo'=>$a,'owner1'=>$owner1,'bulan2'=>$bulan2,'tahun2'=>$tahun2,'bulan'=>$bulan], true);

		echo json_encode($hasil);
	}

	function cetak_top_risk()
	{
		$tipe = $this->uri->segment(3);
		$data['tipe'] = $tipe;
		
		$owner = $this->uri->segment(4);
		$tahun = $this->uri->segment(5);
		$bulan = $this->uri->segment(6);
		$bulan2 = $this->uri->segment(7);
		$tahun2 = $this->uri->segment(8);
$a = $this->db->select('id,level_no')->where('id',$owner)->get(_TBL_OWNER)->result_array();
$b = array();
foreach ($a as $key => $value) {
$b = $value['level_no'];
}
	
		if ($owner > 0) {
			if ($b == 3) {
			$rows['bobo'] = $this->db->where('urgensi_no >', 0)->where('urgensi_no_kadiv', 1)->where('parent_no', $owner)->where('period_no', $tahun)->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();	
			}else{
				$rows['bobo'] = $this->db->where('urgensi_no >', 0)->where('urgensi_no_kadiv', 1)->where('owner_no', $owner)->where('period_no', $tahun)->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();	
			}
			$this->db->where('owner_no', $owner);
			$this->db->where('period_no', $tahun);
			$this->db->where('bulan', $bulan);
			$this->db->where('risk_level >', 0);
			$a = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		}else {
			$rows['bobo'] = $this->db->where('urgensi_no >', 0)->where('urgensi_no_kadiv', 1)->where('period_no', $tahun)->order_by('inherent_analisis_id','DESC')->order_by('residual_analisis_id','DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			$this->db->where('period_no', $tahun);
			$this->db->where('bulan', $bulan);
			$this->db->where('risk_level >', 0);
			$a = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		}
		$jon = array();
		foreach ($rows['bobo'] as $key => $value) {
		$this->db->where('rcsa_detail_no', $value['id']);
		$row = $this->db->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();
		foreach ($row as $key1 => $value1) {
			$jon[$value['id']][]=$value1['proaktif'];
		}
		}
		$rows['baba'] = array();

		foreach ($rows['bobo'] as $key => $value) {
			if($owner> 0 && $b == 3){
				$this->db->where('parent_no',$owner);
				$this->db->where('period_no',$tahun);
				$this->db->where('bulan',$bulan);
				$this->db->where('rcsa_detail_no', $value['id']);
			 }elseif($owner > 0){
				$this->db->where('owner_no',$owner);
				$this->db->where('period_no',$tahun);
				$this->db->where('bulan',$bulan);
				$this->db->where('rcsa_detail_no', $value['id']);
			 }else{
				$this->db->where('period_no',$tahun);
				$this->db->where('bulan',$bulan);
				$this->db->where('rcsa_detail_no', $value['id']);
			 }
		$row = $this->db->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		if ($row) {
			foreach ($row as $key1 => $value1) {
			$rows['baba'][$value['id']]['inherent_analisis_action']=$value1['inherent_analisis_action'];
			$rows['baba'][$value['id']]['warna_action']=$value1['warna_action'];
			$rows['baba'][$value['id']]['warna_text_action']=$value1['warna_text_action'];
		}
		}else{
			$rows['baba'][$value['id']]['inherent_analisis_action']="";
			$rows['baba'][$value['id']]['warna_action']="";
			$rows['baba'][$value['id']]['warna_text_action']="";
		}
	}
		$owner = $this->db->where('id', $owner)->get(_TBL_OWNER)->row_array();
		if ($owner == 0) {
			$nama = $nama = 'Top-Risk-Peruri';
			$owner1 = 'Perum Peruri';

		}else{
			 $nama = $nama = 'Top-Risk-' . url_title($owner['name']);
			 $owner1 = $owner['name'];
		}

		$hasil = $this->load->view('detail_data', ['data' => $rows,'filter' => $post,'proaktif'=>$jon,'bobo'=>$a,'owner1'=>$owner1,'bulan2'=>$bulan2,'tahun2'=>$tahun2,'bulan'=>$bulan], true);
		$cetak = 'top_risk_' . $tipe;

		$this->$cetak($hasil, $nama);
	}
	function top_risk_pdf($data, $nama = "Top-Risk")
	{
	
		$this->load->library('pdf');
		$tgl = date('d-m-Y');
		$this->nmFile = $nama .'-'.$tgl.".pdf";
		$this->pdfFilePath = download_path_relative($this->nmFile);

		$html = '<style>
				table {
					border-collapse: collapse;
				
				}

				.test table > th > td {
					border: 1px solid #ccc;
				}
				</style>';


		// $html .= '<table width="100%" border="0"><tr><td width="100%" style="padding:20px;">';

		$html .= $data;


		// $html .= '</td></tr></table>';

		$pdf = $this->pdf->load('en-GB-x,legal,,,5,5,5,5,6,3');
		$pdf->AddPage('P','', // L - landscape, P - portrait
		 '', '', '',
        10, // margin_left
        10, // margin right
        3, // margin top
        3, // margin bottom
        3, // margin header
        3); // margin footer

		$pdf->SetHeader('');
		$pdf->setFooter('|{PAGENO} Dari {nb} Halaman|');
		$pdf->WriteHTML($html);
		ob_clean();

		$pdf->Output($this->pdfFilePath, 'F');
		redirect($this->pdfFilePath);

		return true;
	}

	function get_param()
	{
		$data['kel'] = $this->input->get('idmodal');
		$data['field'] = $data['field'] = $this->crud->get_param($data['kel']);
		$result = $this->load->view('statis/list_param', $data, true);
		echo $result;
	}
}

/* End of file welcome.php */
