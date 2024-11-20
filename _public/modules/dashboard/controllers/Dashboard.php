<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
class Dashboard extends BackendController
{
	public $tmp_data = array();
	public $data_fields = array();

	public function __construct()
	{
		parent::__construct();

		$this->load->model('data');
		$table = $this->config->item('tbl_suffix') . 'items';
	}
	public function get_combo_bulan()
	{
		$query = array('1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
		return $query;
	}
	public function index()
	{
		$data = array();
		if ($this->input->post()) {
			$post = $this->input->post();
		} else {
			$post = array('owner_no' => 0, 'period_no' => 0, 'bulan' => 0, 'project_no' => 0);
		}
		if (isset($post['project_no'])) {
			$data['project_no'] = $post['project_no'];
		}
		$data['type_dash'] = 1;
		$data['setting'] = $this->crud->get_setting($data);
		$data['post'] = $post;
		if (count($data['setting']['rcsa']) > 0) {
			$data['cbo_project'] = $this->get_combo('project_rcsa', $data['setting']['rcsa'][0]);
		} else {
			$data['cbo_project'] = array();
		}
		$data['cbo_owner'] = $this->get_combo('parent-input');
		// $data['cbo_owner'][0] = 'Perum Peruri ';
		$data['cbo_bulan'] = $this->get_combo('bulan');
		$data['cbo_tanggal'] = $this->get_combo('tanggal');
		$data['cbo_period'] = $this->get_combo('periode');
		$data['bulan_name'] = $this->get_combo_bulan();


		$param = ['id_period' => 14, 'bulan' => '1', 'bulanx' => 12, 'id_owner' => 0];
		$data['mapping1'] = $this->data->get_map_rcsa($param);
		$data['mapping2'] = $this->data->get_map_residual1($param);
 		$data['mapping3'] = $this->data->get_map_residual2($param);
		// doi::dump($data);
		$owner_no = 0;
		if ($this->_Group_['owner']) {
			$owner_no = $this->_Group_['owner']['owner_no'];
		}

		$data['haha'] = $this->_Group_['owner'];
		$data['task'] = $this->data->get_task($owner_no);

		$data['notif'] = $this->data->get_notif($this->_Group_);

		$this->template->build('dashboard', $data);
	}
	public function get_map()
	{
		$post = $this->input->post();
		$data = $this->data->get_map_rcsa($post);
		$hasil1 = $data;
		echo json_encode($data);
	}
	public function map_residual1()
	{
		$post = $this->input->post(); 
		$data = $this->data->get_map_residual2($post);
		$hasil1 = $data;
		echo json_encode($data);
	}
	public function map_residual2()
	{
		$post = $this->input->post();
		$data = $this->data->get_map_residual1($post);
		$hasil1 = $data;
		echo json_encode($data);
	}

	public function get_detail_map2()
	{
		$post = $this->input->post();
		$a = $this->db->select('id,level_no')->where('id', $post['owner'])->get(_TBL_OWNER)->result_array();
		$b = array();
		foreach ($a as $key => $value) {
			$b = $value['level_no'];
		}

		if ($post['kel'] == 'inherent2') {
			$this->db->where('inherent_level', $post['id']);
		} else {
			$this->db->where('risk_level_action', $post['id']);
		}


		if ($post['owner'] == 0 && $post['kel'] == 'inherent2') {
			$rows = $this->db->where('sts_propose', 4)->where('urgensi_no ', 0)->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		} elseif ($post['owner'] == 0 && $post['kel'] == 'residual1'|| $post['kel'] == 'residual2') {
			$rows['bobo'] = $this->db->where('sts_propose', 4)->where('urgensi_no ', 0)->where('bulan >=', $post['bulan'])
				->where('bulan <=', $post['bulanx'])->where('period_no', $post['tahun'])->where('risk_level_action', $post['id'])->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		} elseif ($post['owner'] > 0 && $post['kel'] == 'inherent2') {
			if ($b == 3) {
				$rows = $this->db->where('sts_propose', 4)->where('urgensi_no ', 0)->where('parent_no', $post['owner'])->where('period_no', $post['tahun'])->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			} else {


				$this->owner_child[] = $post['post'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$rows = $this->db->where('sts_propose', 4)->where('urgensi_no ', 0)->where('period_no', $post['tahun'])->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			}
		} else {
			if ($b == 3) {

				$this->owner_child[] = $post['post'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$rows['bobo'] = $this->db
					->where('sts_propose', 4)
					->where('urgensi_no >', 0)->where('parent_no', $post['owner'])
					->where('period_no', $post['tahun'])
					->where('bulan >=', $post['bulan'])
					->where('bulan <=', $post['bulanx'])->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			} else {

				$rows['bobo'] = $this->db->where('sts_propose', 4)
					->where('urgensi_no >', 0)
					->where('owner_no', $post['owner'])
					->where('period_no', $post['tahun'])
					->where('bulan >=', $post['bulan'])
					->where('bulan <=', $post['bulanx'])->order_by('inherent_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			}
		}
		// doi::dump($rows);
		if ($post['kel'] == 'inherent2') {
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

		// var_dump($value['rcsa_detail_no']);
		// die();
		$a = $post['kel'];
		$hasil['combo'] = $this->load->view('detail2', ['data' => $rows, 'kel' => $a], true);
		echo json_encode($hasil);
	}
	
	public function get_detail_map()
	{
		// Mengambil data POST yang dikirim dari form atau request
		$post = $this->input->post();

		// Melakukan query ke database untuk mengambil 'id' dan 'level_no' berdasarkan 'owner' yang dikirim melalui POST
		$a = $this->db->select('id,level_no')->where('id', $post['owner'])->get(_TBL_OWNER)->result_array();
		$b = array();

		// Menyimpan nilai 'level_no' ke dalam variabel $b
		foreach ($a as $key => $value) {
			$b = $value['level_no'];
		}

		// Jika 'kel' pada POST bernilai 'inherent', menambahkan kondisi 'analisis_like_inherent' dan 'analisis_impact_inherent' pada query
		if ($post['kel'] == 'inherent') {
			$this->db->where('analisis_like_inherent', $post['like']);
			$this->db->where('analisis_impact_inherent', $post['impact']);
		}

		// Jika 'owner' bernilai 0 dan 'kel' adalah 'inherent', mengambil data berdasarkan kondisi tertentu dari tabel _TBL_VIEW_RCSA_DETAIL
		if ($post['owner'] == 0 && $post['kel'] == 'inherent') {
			$rows = $this->db->where('sts_propose', 4)
				->where('urgensi_no', 0)
				->where('sts_heatmap', '1')
				->order_by('analisis_like_inherent', 'DESC')
				->order_by('analisis_impact_inherent', 'DESC')
				->order_by('analisis_like_residual', 'DESC')
				->order_by('analisis_impact_residual', 'DESC')
				->get(_TBL_VIEW_RCSA_DETAIL)
				->result_array();

		// Jika 'owner' bernilai 0 dan 'kel' adalah 'residual', menambahkan kondisi tambahan dan mengambil data dari _TBL_VIEW_RCSA_ACTION_DETAIL
		} elseif ($post['owner'] == 0 && $post['kel'] == 'residual') {
			$rows['bobo'] = $this->db->where('sts_propose', 4)
				->where('urgensi_no', 0)
				->where('bulan >=', $post['bulan'])
				->where('bulan <=', $post['bulanx'])
				->where('period_no', $post['tahun'])
				->where('risk_level_action', $post['id'])
				->order_by('inherent_analisis_id', 'DESC')
				->order_by('residual_analisis_id', 'DESC')
				->get(_TBL_VIEW_RCSA_ACTION_DETAIL)
				->result_array();

		// Jika 'owner' lebih dari 0 dan 'kel' adalah 'inherent', melakukan query berdasarkan level tertentu
		} elseif ($post['owner'] > 0 && $post['kel'] == 'inherent') {
			doi::dump($b);
			
			if ($b == 3) { // Jika level_no adalah 3, menambahkan kondisi untuk 'parent_no'
				$rows = $this->db->where('sts_propose', 4)
					->where('urgensi_no', 0)
					->where('sts_heatmap', '1')
					->where('parent_no', $post['owner'])
					->where('period_no', $post['tahun'])
					->order_by('analisis_like_inherent', 'DESC')
					->order_by('analisis_impact_inherent', 'DESC')
					->order_by('analisis_like_residual', 'DESC')
					->order_by('analisis_impact_residual', 'DESC')
					->get(_TBL_VIEW_RCSA_DETAIL)
					->result_array();
			} else { // Jika level_no bukan 3, menambahkan kondisi untuk 'rcsa_owner_no'
				$this->owner_child[] = $post['post'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$rows = $this->db->where('sts_propose', 4)
					->where('urgensi_no', 0)
					->where('sts_heatmap', '1')
					->where('period_no', $post['tahun'])
					->order_by('analisis_like_inherent', 'DESC')
					->order_by('analisis_impact_inherent', 'DESC')
					->order_by('analisis_like_residual', 'DESC')
					->order_by('analisis_impact_residual', 'DESC')
					->get(_TBL_VIEW_RCSA_DETAIL)
					->result_array();
			}
		} else { // Kondisi lain untuk 'kel' yang bukan 'inherent'
			if ($b == 3) {
				$this->owner_child[] = $post['post'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$rows['bobo'] = $this->db->where('sts_propose', 4)
					->where('urgensi_no', 0)
					->where('parent_no', $post['owner'])
					->where('period_no', $post['tahun'])
					->where('bulan >=', $post['bulan'])
					->where('bulan <=', $post['bulanx'])
					->order_by('inherent_analisis_id', 'DESC')
					->order_by('residual_analisis_id', 'DESC')
					->get(_TBL_VIEW_RCSA_ACTION_DETAIL)
					->result_array();
			} else {
				$rows['bobo'] = $this->db->where('sts_propose', 4)
					->where('urgensi_no', 0)
					->where('owner_no', $post['owner'])
					->where('period_no', $post['tahun'])
					->where('bulan >=', $post['bulan'])
					->where('bulan <=', $post['bulanx'])
					->order_by('inherent_analisis_id', 'DESC')
					->order_by('residual_analisis_id', 'DESC')
					->get(_TBL_VIEW_RCSA_ACTION_DETAIL)
					->result_array();
			}
		}

		// Jika 'kel' adalah 'inherent', memproses data untuk menambahkan informasi 'couse' dan 'impact'
		if ($post['kel'] == 'inherent') {
			foreach ($rows as &$row) {
				// Mengambil dan memproses data 'risk_couse_no' untuk dijadikan string deskripsi
				$arrCouse = json_decode($row['risk_couse_no'], true);
				$rows_couse = array();
				if ($arrCouse) {
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
				}
				$arrCouse = array_map(function ($rc) {
					return $rc['description'];
				}, $rows_couse);
				$row['couse'] = implode(', ', $arrCouse);

				// Mengambil dan memproses data 'risk_impact_no' untuk dijadikan string deskripsi
				$arrCouse = json_decode($row['risk_impact_no'], true);
				$rows_couse = array();
				if ($arrCouse) {
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
				}
				$arrCouse = array_map(function ($rc) {
					return $rc['description'];
				}, $rows_couse);
				$row['impact'] = implode(', ', $arrCouse);
			}
			unset($row);
		} else {
			// Menyiapkan array 'baba' untuk menampung data tambahan dari 'bobo'
			$rows['baba'] = array();

			// Memproses data dari 'bobo' untuk menambahkan informasi detail
			foreach ($rows['bobo'] as $value) {
				if ($post['owner'] > 0 && $b == 3) {
					$this->db->where('parent_no', $post['owner'])
						->where('period_no', $post['tahun'])
						->where('id', $value['rcsa_detail_no']);
				} elseif ($post['owner'] > 0) {
					$this->db->where('owner_no', $post['owner'])
						->where('period_no', $post['tahun'])
						->where('id', $value['rcsa_detail_no']);
				} else {
					$this->db->where('period_no', $post['tahun'])
						->where('id', $value['rcsa_detail_no']);
				}

				$row = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

				if ($row) {
					foreach ($row as $value1) {
						$rows['baba'][$value['rcsa_detail_no']] = [
							'inherent_analisis' => $value1['inherent_analisis'],
							'warna' => $value1['warna'],
							'warna_text' => $value1['warna_text']
						];
					}
				} else {
					// Jika data tidak ditemukan, set nilai default kosong
					$rows['baba'][$value['rcsa_detail_no']] = [
						'inherent_analisis' => "",
						'warna' => "",
						'warna_text' => ""
					];
				}
			}
		}

		// Menyimpan hasil view ke dalam variabel dan mengirimkannya sebagai respon JSON
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
			$this->db->where('analisis_like_residual', $post['like']);
			$this->db->where('analisis_impact_residual', $post['impact']);
			// $this->db->where('residual_level', $post['id']);
		} else {
			$this->db->where('risk_level_action', $post['id']);
		}


		if ($post['owner'] == 0 && $post['kel'] == 'residual') {
			// $rows = $this->db->where('sts_propose', 4)->where('urgensi_no', 0)->order_by('analisis_like_inherent', 'DESC')->order_by('analisis_like_residual', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			$rows = $this->db->where('sts_propose', 4)->where('sts_heatmap', '1')->where('urgensi_no', 0)->order_by('analisis_like_residual', 'DESC')->order_by('analisis_impact_residual', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		

		} elseif ($post['owner'] == 0 && $post['kel'] == 'residual') {
			$rows['bobo'] = $this->db->where('sts_propose', 4)->where('urgensi_no', 0)->where('bulan >=', $post['bulan'])
				->where('bulan <=', $post['bulanx'])->where('period_no', $post['tahun'])->where('risk_level_action', $post['id'])->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		} elseif ($post['owner'] > 0 && $post['kel'] == 'residual') {
			if ($b == 3) {
				$rows = $this->db->where('sts_propose', 4)->where('sts_heatmap', '1')->where('urgensi_no', 0)->where('parent_no', $post['owner'])->where('period_no', $post['tahun'])->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			} else {


				$this->owner_child[] = $post['post'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$rows = $this->db->where('sts_propose', 4)->where('sts_heatmap', '1')->where('urgensi_no', 0)->where('period_no', $post['tahun'])->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
			}
		} else {
			if ($b == 3) {

				$this->owner_child[] = $post['post'];
				$this->db->where_in('rcsa_owner_no', $this->owner_child);
				$rows['bobo'] = $this->db
					->where('sts_propose', 4)
					->where('urgensi_no ', 0)->where('parent_no', $post['owner'])
					->where('period_no', $post['tahun'])
					->where('bulan >=', $post['bulan'])
					->where('bulan <=', $post['bulanx'])->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
			} else {

				$rows['bobo'] = $this->db->where('sts_propose', 4)
					->where('urgensi_no ', 0)
					->where('owner_no', $post['owner'])
					->where('period_no', $post['tahun'])
					->where('bulan >=', $post['bulan'])
					->where('bulan <=', $post['bulanx'])
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
	public function get_subdetail()
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

		$hasil['realisasi'] = $row;

		$hasil['combo'] = $this->load->view('subdetail', $hasil, true);

		echo json_encode($hasil);
	}

	
	public function regulasi()
	{
		$nama = $this->uri->segment(3);
		$fullPath = regulasi_path_relative($nama);

		if ($fd = fopen($fullPath, "r")) {
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			$ext = strtolower($path_parts["extension"]);
			switch ($ext) {
				case "pdf":
					header("Content-type: application/pdf"); // add here more headers for diff. extensions
					header("Content-Disposition: inline; filename=\"" . $path_parts["basename"] . "\"");
					break;
				default:
					header("Content-type: application/octet-stream");
					header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
			}
			header("Content-length: $fsize");
			header("Cache-control: private"); //use this to open files directly
			while (!feof($fd)) {
				$buffer = fread($fd, 2048);
				echo $buffer;
			}
		}
		fclose($fd);
		exit;
	}

	public function get_detail_rcsa()
	{
		$id = $this->input->post('id');
		$data['action'] = $this->data->get_rcsa_detail($id);
		$data['cbo_owner'] = $this->get_combo('owner');
		$hasil['detail'] =  $this->load->view('detail-dash', $data, true);
		echo json_encode($hasil);
	}

	public function news()
	{
		$id = $this->uri->segment(3);
		$data = $this->data->get_news($id);
		$this->template->build('news', $data);
	}

	public function kirim_email()
	{
		// $this->load->library('email');

		$this->email->from('erisk@adhi.co.id', 'Admin Adhi Risk ya');
		$this->email->to('tri.untoro@gmail.com');
		$this->email->cc('abutiara@gmail.com');
		$this->email->bcc('setitik.debu@facebook.com');

		$this->email->subject('Email Test ya bossss');
		$this->email->message('Testing the email class from adri risk email');

		$this->email->send();

		echo $this->email->print_debugger();
		echo "selesai";
	}

	public function update_rcsa_rata()
	{
		$sql = "SELECT b.rcsa_no, a.corporate, sum(b.nilai_dampak) rata_dampak, sum(c.score) as rata_score, sum(b.nilai_dampak * (ifnull(c.score,0) / 100)) AS rata_inherent_exposure, count(b.rcsa_no) as jml FROM risk_rcsa a INNER JOIN risk_rcsa_detail b ON a.id = b.rcsa_no INNER JOIN risk_level c ON c.id = b.inherent_likelihood WHERE b.nilai_dampak>0 GROUP BY b.rcsa_no ORDER BY b.rcsa_no";

		$sql = $this->db->query($sql);
		$rows = $sql->result_array();
		$ttl = 0;
		foreach ($rows as $row) {
			$rata_dampak = $row['rata_dampak'] / $row['jml'];
			$rata_inherent_exposure = $row['rata_inherent_exposure'] / $row['jml'];
			$jml = $this->db->update('risk_rcsa', array('rata_nil_dampak' => $rata_dampak, 'rata_inherent_exposure' => $rata_inherent_exposure), array('id' => $row['rcsa_no']));
			if ($jml >= 1) {
				++$ttl;
			}
		}

		echo "selesai update " . $ttl . ' RCSA <br>';

		$sql = "SELECT b.rcsa_no, a.corporate, sum(b.nilai_dampak) rata_dampak, sum(c.score) as rata_score, sum(b.nilai_dampak * (ifnull(c.score,0) / 100)) AS rata_residual_exposure, count(b.rcsa_no) as jml FROM bangga_rcsa a INNER JOIN bangga_rcsa_detail b ON a.id = b.rcsa_no INNER JOIN bangga_level c ON c.id = b.residual_likelihood WHERE b.nilai_dampak>0 GROUP BY b.rcsa_no ORDER BY b.rcsa_no";

		$sql = $this->db->query($sql);
		$rows = $sql->result_array();
		$ttl = 0;
		foreach ($rows as $row) {
			$rata_dampak = $row['rata_dampak'] / $row['jml'];
			$rata_residual_exposure = $row['rata_residual_exposure'] / $row['jml'];
			$jml = $this->db->update('risk_rcsa', array('rata_residual_exposure' => $rata_residual_exposure), array('id' => $row['rcsa_no']));
			if ($jml >= 1) {
				++$ttl;
			}
		}
		// die($sql);
		echo "selesai update " . $ttl . ' RCSA <br>';
	}

	public function update_code_personal()
	{
		$arr_type = array(1, 2, 3);
		$sql = $this->db->query("select * from risk_risk_type order by id");
		$rows = $sql->result_array();
		$arr_risk_type = array();
		foreach ($rows as $row) {
			$arr_risk_type[$row['id']] = $row['type'];
		}
		$grand_total = 0;
		foreach ($arr_type as $no) {
			echo "Update Library " . $no . '<br/>';
			foreach ($arr_risk_type as $key => $type) {
				$sql = "select a.id, b.code from bangga_library a left join bangga_risk_type b on a.risk_type_no=b.id where a.type='{$no}' and a.risk_type_no='{$key}' order by a.create_date, a.id";
				$query = $this->db->query($sql);
				$rows = $query->result_array();
				$ttl = 0;
				$no_urut = 1;
				foreach ($rows as $row) {
					$no_new = str_pad($no_urut, 4, '0', STR_PAD_LEFT);
					$code = strtoupper($row['code']) . $no_new;
					$jml = $this->db->update('risk_library', array('code' => $code), array('id' => $row['id']));
					if ($jml >= 1) {
						++$ttl;
					}
					++$no_urut;
				}
				$grand_total += $ttl;
				echo " &nbsp;&nbsp;- selesai update " . $ttl . ' Type ' . $type . '<br/>';
			}
			echo "<br/>";
		}
		echo "Total Seluruh library : " . $grand_total;
	}

	public function test_map()
	{
		$this->load->library('map');
		$this->map->get_child();
		$this->map->get_setting();
	}

	public function update_rcsa()
	{
		$rows = $this->db->get(_TBL_RCSA_TMP)->result_array();

		$data['field'] = [];
		foreach ($rows as $row) {
			$data['field'] = [
				'sts_propose' => $row['sts_propose'],
				'date_propose' => $row['date_propose'],
				'date_propose_kadep' => $row['date_propose_kadep'],
				'date_approve_kadiv' => $row['date_approve_kadiv'],
				'date_approve_admin' => $row['date_approve_admin'],
				'user_approve_kadep' => $row['user_approve_kadep'],
				'user_approve' => $row['user_approve'],
				'user_approve_kadiv' => $row['user_approve_kadiv'],
				'note_approve_kadep' => $row['note_approve_kadep'],
				'note_approve_kadiv' => $row['note_approve_kadiv'],
			];
			$this->db->where('id', $row['id']);
			$this->db->update(_TBL_RCSA, $data['field']);
		}
	}
}

/* End of file welcome.php */
