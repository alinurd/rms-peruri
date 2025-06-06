<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Top_Risk_Unit extends BackendController
{
	var $tmp_data 		= array();
	var $data_fields 	= array();

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('data');
	}

	public function index()
	{
		$data 		= array();

		if ($this->input->post())
			$post 	= $this->input->post();
		else
			$post 	= array('owner_no' => 0, 'period_no' => 0,'bulan' =>0, 'project_no' => 0);
		
		if (isset($post['project_no'])) {
			$data['project_no'] = $post['project_no'];
		}

		$data['type_dash'] 	= 1;
		$data['setting'] 		= $this->crud->get_setting($data);
		$data['post'] 			= $post;

		if (count($data['setting']['rcsa']) > 0)
			$data['cbo_project'] = $this->get_combo('project_rcsa', $data['setting']['rcsa'][0]);
		else
			$data['cbo_project'] 	= array();
			$data['cbo_owner'] 		= $this->get_combo('parent-input');

		if ($this->id_param_owner['privilege_owner']['id'] == 1) {
			$data['cbo_owner'][0] = 'Perum Peruri';
		}

		$data['cbo_bulan']	=	$this->get_combo('bulan');
		$data['cbo_period'] = $this->get_combo('periode');
		$hoho 							= $data['cbo_owner']; 

		foreach ($hoho as $key => $value) {
 			$owner_id = $key;
		}	
		
		if ($this->id_param_owner['privilege_owner']['id'] == 1){
			$data['cbo_owner'][0] = 'Perum Peruri ';
			$param 								= ['id_period' => _TAHUN_NO_,'bulan' => date('n'), 'id_owner' => 0];
		}else{
			$param 								= ['id_period' => _TAHUN_NO_,'bulan' => date('n'), 'id_owner' => $owner_id ];
		}

		$data['mapping']				= $this->data->get_map_rcsa($param); 
		$this->template->build('dashboard', $data);
	}

	function get_map()
	{
		$post 	= $this->input->post();
		$data 	= $this->data->get_map_rcsa($post);
		$hasil 	= $data;
		echo json_encode($hasil);

	}
	function map_residual2()
	{
		$post = $this->input->post();
		$data = $this->data->get_map_residual1($post);
		$hasil = $data;
		echo json_encode($hasil);

	}
	public function get_detail_map()
	{
		$post 	= $this->input->post();
		$a 		= $this->db->select('id,level_no')->where('id', $post['owner'])->get(_TBL_OWNER)->result_array();
		$b 		= array();
		foreach ($a as $key => $value) {
			$b 	= $value['level_no'];
		}
// doi::dump($post);
		$owner	= $post['owner'];
		$this->data->owner_child=array();
		$norut = isset($post['norut']) ? explode(',', $post['norut']) : [];

		if ($owner>0){
			$this->data->owner_child[]=$owner;
		}

		$this->data->get_owner_child($owner);
		$owner_child=$this->data->owner_child;

		if ($post['kel'] == 'Inherent') {
			$this->db->where('residual_likelihood', $post['like']);
			$this->db->where('residual_impact', $post['impact']);
			
			if ($post['tahun'] > 0) {
				$this->db->where('period_no', $post['tahun']);
			}
		}  
		if ($post['owner'] == 0 && $post['kel'] == 'Inherent') {
 
			$rows = $this->db->where('sts_propose', 4)
				->where('urgensi_no', 0)
				->where('sts_heatmap', '1')
				// ->where_in('norut', $norut)
				->order_by('residual_likelihood', 'DESC')
				->order_by('residual_impact', 'DESC')
				->get(_TBL_VIEW_RCSA_DETAIL)
				->result_array();
		} elseif ($post['owner'] > 0 && $post['kel'] == 'inherent') {
			if ($b == 3) {
				$rows = $this->db->where('sts_propose', 4)
					->where('urgensi_no', 0)
					->where('sts_heatmap', '1')
					->where('parent_no', $post['owner'])
					->where('period_no', $post['tahun'])
					// ->where_in('norut', $norut)
					->order_by('residual_likelihood', 'DESC')
					->order_by('residual_impact', 'DESC')
					->get(_TBL_VIEW_RCSA_DETAIL)
					->result_array();
			} else {
				if ($owner_child){
					$this->db->where_in('owner_no',$owner_child);
				}else{
					$this->db->where('owner_no',$owner);
				}
				
				$rows = $this->db->where('sts_propose', 4)
					->where('urgensi_no', 0)
					->where('sts_heatmap', '1')
					// ->where_in('norut', $norut)
					->where('period_no', $post['tahun'])
					->order_by('residual_likelihood', 'DESC')
					->order_by('residual_impact', 'DESC')
					->get(_TBL_VIEW_RCSA_DETAIL)
					->result_array();
				
			}
		} else {
			// if ($b == 3) {
  				$rows = $this->db->where('sts_propose', 4)
					->where('owner_no', $post['owner'])
					->where('urgensi_no', 0)
					->where('sts_heatmap', '1')
					->where_in('norut', $norut)
					->where('period_no', $post['tahun'])
					->order_by('residual_likelihood', 'DESC')
					->order_by('residual_impact', 'DESC')
					->get(_TBL_VIEW_RCSA_DETAIL)
					->result_array();
 		 
		}
		
		$a = $post['kel'];
		$hasil['combo'] = $this->load->view('detail', ['data' => $rows, 'kel' => $a,'bulan' => $post['bulan']], true);
		echo json_encode($hasil);
	}


	public function get_detail_map_res()
	{
		$post 	= $this->input->post();
		$a 			= $this->db->select('id,level_no')->where('id', $post['owner'])->get(_TBL_OWNER)->result_array();
		$b 			= array();
		
		foreach ($a as $key => $value) {
			$b = $value['level_no'];
		}

		$owner	= $post['owner'];
		$this->data->owner_child=array();

		if ($owner>0){
			$this->data->owner_child[]=$owner;
		}

		$this->data->get_owner_child($owner);
		$owner_child=$this->data->owner_child;

		if ($post['kel'] =='Current') {

			$this->db->where('bangga_view_rcsa_action_detail.residual_likelihood_action', $post['like']);
			$this->db->where('bangga_view_rcsa_action_detail.residual_impact_action', $post['impact']);
			if ($post['bulan'] > 0) {
				$this->db->where("bangga_view_rcsa_action_detail.bulan = {$post['bulan']}");
			}
			
			if ($post['tahun'] > 0) {
				$this->db->where('bangga_view_rcsa_action_detail.period_no', $post['tahun']);
			}

		}  
		 
		if ($owner_child){
			$this->db->where_in('bangga_view_rcsa_action_detail.owner_no',$owner_child);
		}else{
			$this->db->where('bangga_view_rcsa_action_detail.owner_no',$owner);
		}
		// doi::dump($post);
		$this->db->where("bangga_view_rcsa_action_detail.bulan = {$post['bulan']}");
		$rows = $this->db->select('bangga_view_rcsa_detail.bulan as bulan_rcsa, bangga_view_rcsa_detail.*, bangga_view_rcsa_action_detail.*,bangga_view_rcsa_detail.id as id_detail')
				->from("bangga_view_rcsa_action_detail")
				->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_view_rcsa_action_detail.rcsa_detail_no')  
				->where('bangga_view_rcsa_action_detail.sts_propose', 4)
				->where('bangga_view_rcsa_action_detail.urgensi_no', 0)
				->where('bangga_view_rcsa_detail.sts_heatmap', '1')
				// ->where_in('bangga_view_rcsa_detail.norut', $post['norut'])
				->where('bangga_view_rcsa_action_detail.period_no', $post['tahun']) 
				->get()
				->result_array();

		// die($this->db->last_query());
		// doi::dump($rows);
		$a = $post['kel'];
		$hasil['combo'] = $this->load->view('detailres', ['data' => $rows, 'kel' => $a,], true);
		echo json_encode($hasil);
	}

	public function get_detail_map_target()
	{
		$post 	= $this->input->post();
		$a 		= $this->db->select('id,level_no')->where('id', $post['owner'])->get(_TBL_OWNER)->result_array();
		$b 		= array();
		foreach ($a as $key => $value) {
			$b = $value['level_no'];
		}

		$owner	= $post['owner'];
		$this->data->owner_child=array();

		if ($owner>0){
			$this->data->owner_child[]=$owner;
		}

		$this->data->get_owner_child($owner);
		$owner_child=$this->data->owner_child;

		if ($post['kel'] == 'Target') {
			$this->db->where('bangga_analisis_risiko.target_like', $post['like']);
			$this->db->where('bangga_analisis_risiko.target_impact', $post['impact']);
			$this->db->where('bangga_analisis_risiko.bulan', 12);
		
			if ($post['tahun'] > 0) {
				$this->db->where('bangga_view_rcsa_detail.period_no', $post['tahun']);
			}

		} else {
			$this->db->where('bangga_view_rcsa_detail.risk_level_action', $post['id']);
		}


		if ($post['owner'] == 0 && $post['kel'] == 'Target') {
			
			$rows = $this->db->select('*,bangga_analisis_risiko.bulan as bulan_target') 
                ->from("bangga_analisis_risiko")
                ->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_analisis_risiko.id_detail', 'left') // Ganti dengan tabel dan kondisi yang sesuai
                ->where('bangga_view_rcsa_detail.sts_propose', 4)
                ->where('bangga_view_rcsa_detail.urgensi_no', 0)
                ->where('bangga_view_rcsa_detail.sts_heatmap', '1')
                ->order_by('bangga_analisis_risiko.target_like', 'DESC')
                ->order_by('bangga_analisis_risiko.target_impact', 'DESC')
                ->get()
                ->result_array();
		} elseif ($post['owner'] == 0 && $post['kel'] == 'Target') {
			$rows = $this->db->select('*,bangga_analisis_risiko.bulan as bulan_target') 
				->from("bangga_analisis_risiko")
				->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_analisis_risiko.id_detail', 'left') // Ganti dengan tabel dan kondisi yang sesuai
				->where('bangga_view_rcsa_detail.sts_propose', 4)
				->where('bangga_view_rcsa_detail.urgensi_no', 0)
				->where('bangga_view_rcsa_detail.sts_heatmap', '1')
				->where('bangga_view_rcsa_detail.parent_no', $post['owner'])
				->where('bangga_view_rcsa_detail.period_no', $post['tahun'])
                ->order_by('bangga_analisis_risiko.target_like', 'DESC')
                ->order_by('bangga_analisis_risiko.target_impact', 'DESC')
                ->get()
                ->result_array();
		} elseif ($post['owner'] > 0 && $post['kel'] == 'Target') {
			if ($b == 3) {
				$rows = $this->db->select('*,bangga_analisis_risiko.bulan as bulan_target') 
				->from("bangga_analisis_risiko")
				->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_analisis_risiko.id_detail', 'left') // Ganti dengan tabel dan kondisi yang sesuai
				->where('bangga_view_rcsa_detail.sts_propose', 4)
				->where('bangga_view_rcsa_detail.urgensi_no', 0)
				->where('bangga_view_rcsa_detail.sts_heatmap', '1')
				->where('bangga_view_rcsa_detail.parent_no', $post['owner'])
				->where('bangga_view_rcsa_detail.period_no', $post['tahun'])
                ->order_by('bangga_analisis_risiko.target_like', 'DESC')
                ->order_by('bangga_analisis_risiko.target_impact', 'DESC')
                ->get()
                ->result_array();
			} else {

				if ($owner_child){
					$this->db->where_in('bangga_view_rcsa_detail.owner_no',$owner_child);
				}else{
					$this->db->where('bangga_view_rcsa_detail.owner_no',$owner);
				}

				$rows = $this->db->select('*,bangga_analisis_risiko.bulan as bulan_target') 
				->from("bangga_analisis_risiko")
				->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_analisis_risiko.id_detail', 'left') // Ganti dengan tabel dan kondisi yang sesuai
				->where('bangga_view_rcsa_detail.sts_propose', 4)
				->where('bangga_view_rcsa_detail.urgensi_no', 0)
				->where('bangga_view_rcsa_detail.sts_heatmap', '1')
				->where('bangga_view_rcsa_detail.period_no', $post['tahun'])
                ->order_by('bangga_analisis_risiko.target_like', 'DESC')
                ->order_by('bangga_analisis_risiko.target_impact', 'DESC')
                ->get()
                ->result_array();
			}
		} else {
			if ($b == 3) {

				if ($owner_child){
					$this->db->where_in('bangga_view_rcsa_action_detail.owner_no',$owner_child);
				}else{
					$this->db->where('bangga_view_rcsa_action_detail.owner_no',$owner);
				}

				$rows = $this->db->select('*') 
                ->from("bangga_view_rcsa_action_detail")
                ->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_view_rcsa_action_detail.rcsa_detail_no', 'left') // Ganti dengan tabel dan kondisi yang sesuai
                ->where('bangga_view_rcsa_action_detail.sts_propose', 4)
                ->where('bangga_view_rcsa_action_detail.urgensi_no', 0)
                ->where('bangga_view_rcsa_detail.sts_heatmap', '1')
				->where('bangga_view_rcsa_action_detail.period_no', $post['tahun'])
                ->order_by('bangga_view_rcsa_detail.inherent_likelihood', 'DESC')
                ->order_by('bangga_view_rcsa_detail.inherent_impact', 'DESC')
                ->order_by('bangga_view_rcsa_action_detail.residual_likelihood_action', 'DESC')
                ->order_by('bangga_view_rcsa_action_detail.residual_impact_action', 'DESC')
                ->get()
                ->result_array();

				// $this->owner_child[] = $post['post'];
				// $this->db->where_in('rcsa_owner_no', $this->owner_child);
				// $rows['bobo'] = $this->db
				// 	->where('sts_propose', 4)
				// 	->where('urgensi_no ', 0)->where('parent_no', $post['owner'])
				// 	->where('period_no', $post['tahun'])
 				// 	->where('bulan <=', $post['bulan'])->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			} else {

				$rows['bobo'] = $this->db->where('sts_propose', 4)
					->where('urgensi_no ', 0)
					->where('owner_no', $post['owner'])
					->where('period_no', $post['tahun'])
					->where('bulan', $post['bulan'])
 					->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			}
		}
		if ($post['kel'] == 'Target') {
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
		$hasil['combo'] = $this->load->view('detail_target', ['data' => $rows, 'kel' => $a,], true);
		echo json_encode($hasil);
	}


	 

	function get_subdetail()
	{
		$post = $this->input->post();
		$this->db->where('id', $post['id']);
		$row = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
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

		$hasil['data'] = $row;

		$this->db->where('rcsa_detail_no', $post['id']);
		$rows = $this->db->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();

		foreach ($rows as &$row) {
			$arrCouse = json_decode($row['accountable_unit'], true);
			$rows_couse = array();
			if ($arrCouse) {
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			}
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['name'];
			}

			$row['penanggung_jawab'] = implode('### ', $arrCouse);
		}
		unset($row);

		$hasil['mitigasi'] = $rows;

		$this->db->where('rcsa_detail_no', $post['id']);
		$row = $this->db->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();

		$this->db->where('id_detail', $post['id']);
		$target_level  = $this->db->get(_TBL_ANALISIS_RISIKO)->result_array();
		// die($this->db->last_query());

		$hasil['realisasi']    = $row;
		$hasil['target_level'] = $target_level;

		$hasil['combo'] = $this->load->view('subdetail', $hasil, true);

		echo json_encode($hasil);
	}

	function get_subdetailTarget()
	{
		$post 		= $this->input->post();
		$this->db->where('id', $post['id']);
		$row 		= $this->db->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$arrCouse 	= json_decode($row['risk_couse_no'], true);
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

		$hasil['data'] = $row;

		$this->db->where('rcsa_detail_no', $post['id']);
		$rows = $this->db->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();

		foreach ($rows as &$row) {
			$arrCouse = json_decode($row['accountable_unit'], true);
			$rows_couse = array();
			if ($arrCouse) {
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			}
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['name'];
			}

			$row['penanggung_jawab'] = implode('### ', $arrCouse);
		}
		unset($row);


		$this->db->where('rcsa_detail_no', $post['id']);
		$this->db->where('bulan', $post['bulan']);
		$row = $this->db->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();

		$this->db->where('id_detail', $post['id']);
		$this->db->where('bulan', $post['bulan']);
		$target_level  = $this->db->get(_TBL_ANALISIS_RISIKO)->result_array();
		// die($this->db->last_query());

		$hasil['realisasi']    = $row;
		$hasil['target_level'] = $target_level;

		$hasil['combo'] = $this->load->view('subdetail_target', $hasil, true);

		echo json_encode($hasil);
	}
	
	function get_export_data()
	{
		$post 	= $this->input->post();
		$bulan 	= $post['bulan'];
		$bulan2 = $post['bulan2'];
		$tahun2 = $post['tahun2'];
		$a = $this->db->select('id,level_no')->where('id',$post['owner'])->get(_TBL_OWNER)->result_array();
		$b = array();
		foreach ($a as $key => $value) {
			$b = $value['level_no'];
		}			
		$owner	= $post['owner'];
		$this->data->owner_child=array();

		if ($owner>0){
			$this->data->owner_child[]=$owner;
		}

		$this->data->get_owner_child($owner);
		$owner_child=$this->data->owner_child;
		// doi::dump($b);

		if ($post['owner'] > 0) {
			if ($b == 3) {
				$rows['bobo'] = $this->db->where('urgensi_no', 0)->where('sts_heatmap', '1')->where('parent_no', $post['owner'])->where('period_no', $post['tahun'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();	
			}else{
				$rows['bobo'] = $this->db->where('urgensi_no', 0)->where('sts_heatmap', '1')->where('owner_no', $post['owner'])->where('period_no', $post['tahun'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();	
			}
			// $this->db->where('owner_no', $post['owner']);
			// $this->db->where('period_no', $post['tahun']);
			// $this->db->where('bulan', $post['bulan']);
			// $this->db->where('risk_level >', 0);
			// $a = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		}else {
			$rows['bobo']= $this->db->where('urgensi_no', 0)->where('sts_heatmap', '1')->where('period_no', $post['tahun'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			// $this->db->where('period_no', $post['tahun']);
			// $this->db->where('bulan', $post['bulan']);
			// $this->db->where('risk_level >', 0);
			// $a = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
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
			$row 	= $this->db->get(_TBL_RCSA_ACTION)->result_array();
			foreach ($row as $key1 => $value1) {
				// $jon[$value['id']][]=$value1['proaktif'];
				if (!empty($value1['proaktif'])) {
					$jon[$value['id']][] = $value1['proaktif'];
				} elseif (!empty($value1['reaktif'])) {
					$jon[$value['id']][] = $value1['reaktif'];
				}
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
			$row 					= $this->db->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			$target_level 			= $this->db->select('*')->where('id_detail', $value['id'])->where('bulan', $bulan)->get(_TBL_ANALISIS_RISIKO)->row_array();
			
			
			
		
			if ($row) {
				foreach ($target_level as $key1 => $target) {
					$cek_score_target 		= $this->data->cek_level_new($target_level['target_like'], $target_level['target_impact']);
					$target_level_risiko 	= $this->data->get_master_level(true, $cek_score_target['id']);
					$rows['target'][$value['id']]['tar_level_mapping'] = $target_level_risiko['level_mapping'];
					$rows['target'][$value['id']]['tar_warna_action']=$target_level_risiko['color'];
					$rows['target'][$value['id']]['tar_warna_text_action']=$target_level_risiko['color_text'];
				}

				foreach ($row as $key1 => $value1) {
					$cek_score 				= $this->data->cek_level_new($value1['residual_likelihood_action'], $value1['residual_impact_action']);
					$residual_level_risiko  = $this->data->get_master_level(true, $cek_score['id']);
					$rows['baba'][$value['id']]['res_level_mapping'] = $residual_level_risiko['level_mapping'];
					$rows['baba'][$value['id']]['res_warna_action']=$residual_level_risiko['color'];
					$rows['baba'][$value['id']]['res_warna_text_action']=$residual_level_risiko['color_text'];
				}
			}else{

				$rows['target'][$value['id']]['tar_level_mapping'] = "";
				$rows['target'][$value['id']]['tar_warna_action']="";
				$rows['target'][$value['id']]['tar_warna_text_action']="";
				$rows['baba'][$value['id']]['res_level_mapping']="";
				$rows['baba'][$value['id']]['res_warna_action']="";
				$rows['baba'][$value['id']]['res_warna_text_action']="";

				
			}

			$this->db->where('period_no',$post['tahun']);
			$this->db->where('bulan',$post['bulan']);
			$this->db->where('rcsa_detail_no', $value['id']);
			$row = $this->db->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		}

		

		$hasil['combo'] = $this->load->view('detail_data', ['data' => $rows,'filter' => $post,'treatment'=>$jon,'bobo'=>$a,'owner1'=>$owner1,'bulan2'=>$bulan2,'tahun2'=>$tahun2,'bulan'=>$bulan], true);

		echo json_encode($hasil);
	}

	function cetak_top_risk()
	{
		$tipe 			= $this->uri->segment(3);
		$data['tipe'] 	= $tipe;
		$owner 			= $this->uri->segment(4);
		$tahun 			= $this->uri->segment(5);
		$bulan 			= $this->uri->segment(6);
		$bulan2 		= $this->uri->segment(7);
		$tahun2 		= $this->uri->segment(8);
		$a 				= $this->db->select('id,level_no')->where('id',$owner)->get(_TBL_OWNER)->result_array();
		$b 				= array();
		foreach ($a as $key => $value) {
			$b 			= $value['level_no'];
		}

		$owner	= $owner;
		$this->data->owner_child=array();

		if ($owner>0){
			$this->data->owner_child[]=$owner;
		}

		$this->data->get_owner_child($owner);
		$owner_child=$this->data->owner_child;
	
		if ($owner > 0) {
			if ($b == 3) {
				$rows['bobo'] = $this->db->where('urgensi_no', 0)->where('sts_heatmap', '1')->where('parent_no', $owner)->where('period_no', $tahun)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();	
			}else{
				$rows['bobo'] = $this->db->where('urgensi_no', 0)->where('sts_heatmap', '1')->where('owner_no', $owner)->where('period_no', $tahun)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();	
			}
		}else {
			$rows['bobo']= $this->db->where('urgensi_no', 0)->where('sts_heatmap', '1')->where('period_no', $tahun)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		}

		$jon = array();
		foreach ($rows['bobo'] as $key => $value) {
			$this->db->where('rcsa_detail_no', $value['id']);
			$row 	= $this->db->get(_TBL_RCSA_ACTION)->result_array();
			foreach ($row as $key1 => $value1) {
				// $jon[$value['id']][]=$value1['proaktif'];
				if (!empty($value1['proaktif'])) {
					$jon[$value['id']][] = $value1['proaktif'];
				} elseif (!empty($value1['reaktif'])) {
					$jon[$value['id']][] = $value1['reaktif'];
				}
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
			 $row 					= $this->db->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			 $target_level 			= $this->db->select('*')->where('id_detail', $value['id'])->where('bulan', $bulan)->get(_TBL_ANALISIS_RISIKO)->row_array();
			 
			 
			 
		 
			 if ($row) {
				 foreach ($target_level as $key1 => $target) {
					 $cek_score_target 		= $this->data->cek_level_new($target_level['target_like'], $target_level['target_impact']);
					 $target_level_risiko 	= $this->data->get_master_level(true, $cek_score_target['id']);
					 $rows['target'][$value['id']]['tar_level_mapping'] = $target_level_risiko['level_mapping'];
					 $rows['target'][$value['id']]['tar_warna_action']=$target_level_risiko['color'];
					 $rows['target'][$value['id']]['tar_warna_text_action']=$target_level_risiko['color_text'];
				 }
 
				 foreach ($row as $key1 => $value1) {
					 $cek_score 				= $this->data->cek_level_new($value1['residual_likelihood_action'], $value1['residual_impact_action']);
					 $residual_level_risiko  = $this->data->get_master_level(true, $cek_score['id']);
					 $rows['baba'][$value['id']]['res_level_mapping'] = $residual_level_risiko['level_mapping'];
					 $rows['baba'][$value['id']]['res_warna_action']=$residual_level_risiko['color'];
					 $rows['baba'][$value['id']]['res_warna_text_action']=$residual_level_risiko['color_text'];
				 }
			 }else{
 
				 $rows['target'][$value['id']]['tar_level_mapping'] = "";
				 $rows['target'][$value['id']]['tar_warna_action']="";
				 $rows['target'][$value['id']]['tar_warna_text_action']="";
				 $rows['baba'][$value['id']]['res_level_mapping']="";
				 $rows['baba'][$value['id']]['res_warna_action']="";
				 $rows['baba'][$value['id']]['res_warna_text_action']="";
 
				 
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

		$hasil = $this->load->view('detail_data', ['data' => $rows,'filter' => $post,'treatment'=>$jon,'bobo'=>$a,'owner1'=>$owner1,'bulan2'=>$bulan2,'tahun2'=>$tahun2,'bulan'=>$bulan], true);
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
