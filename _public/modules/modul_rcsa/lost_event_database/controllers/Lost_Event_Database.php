<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Lost_Event_Database extends BackendController
{
	var $type_risk = 0;
	var $table = "";
	var $post = array();
	var $sts_cetak = false;

	public function __construct()
	{
		$this->required = '<sup><span class="required"> *) </span></sup> ';

		parent::__construct();
		$this->cbo_status_action 	= $this->get_combo('status-action');
		$this->cbo_parent 			= $this->get_combo('parent-input');
		$this->cbo_owner 			= $this->get_combo('owner');
		$this->cbo_loss 			= [1 => 'Ya', 0 => 'Tidak'];
		$this->cbo_periode 			= $this->get_combo('periode');
		$this->cboLike 		        = $this->get_combo('likelihood');
		$this->cboImpact 			= $this->get_combo('impact');
		// $data['cboLike']			= $cboLike;
		// $data['cboImpact']			= $cboImpact;

		$this->set_Tbl_Master(_TBL_VIEW_RCSA_DETAIL);
		$this->set_Open_Tab('Lost Event Database');
		$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 11));
		$this->addField(array('field' => 'rcsa_no', 'show' => false, 'size' => 100));
		$this->addField(array('field' => 'owner_no', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => true, 'search' => true));
		$this->addField(array('field' => 'event_name', 'show' => true, 'save' => false, 'size' => 100));
		$this->addField(array('field' => 'tahun', 'show' => true, 'save' => false, 'size' => 100));
		$this->addField(array('field' => 'name', 'show' => true, 'save' => false, 'size' => 100));
		$this->addField(array('field' => 'period_no', 'input' => 'combo:search', 'combo' => $this->cbo_periode, 'size' => 15, 'search' => true, 'required' => true));
		$this->addField(array('field'=> 'residual_level', 'show'=>false,'save'=>false, 'size'=>5));
		$this->addField(array('field'=> 'inherent_level', 'show'=>false,'save'=>false, 'size'=>5));
		$this->addField(array('field' => 'warna', 'show' => false, 'size' => 100));
		$this->addField(array('field' => 'warna_text', 'show' => false, 'size' => 100));
		$this->addField(array('field' => 'inherent_analisis', 'show' => false, 'size' => 100));
		$this->addField(array('field' => 'warna_residual', 'show' => false, 'size' => 100));
		$this->addField(array('field' => 'warna_text_residual', 'show' => false, 'size' => 100));
		$this->addField(array('field' => 'residual_analisis', 'show' => false, 'size' => 100));

		foreach (range(1, 12) as $key => $value) {
			$this->addField(['field' => 'monitoring' . $value, 'type' => 'free', 'show' => false]);
		}
		$this->set_Close_Tab();

		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'owner_name', 'readonly' => true));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'event_name', 'readonly' => true));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'inherent_analisis', 'readonly' => true));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'residual_analisis', 'readonly' => true));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'status_loss', 'readonly' => true));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'status_action_detail', 'readonly' => true));
		$this->set_Where_Table($this->tbl_master, 'sts_propose', '=', 4);
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'progress_detail', 'span_left_addon' => ' %'));
		$this->set_Sort_Table($this->tbl_master, 'inherent_analisis_id', "DESC", 'residual_analisis_id', "DESC");
		$this->set_Table_List($this->tbl_master, 'name', 'Risk Owner');
		$this->set_Table_List($this->tbl_master, 'period_no', 'Tahun');
		$this->set_Table_List($this->tbl_master, 'event_name', 'Peristiwa Risiko');
		$this->set_Table_List($this->tbl_master, 'inherent_analisis', 'Level Risiko Inheren');
		$this->set_Table_List($this->tbl_master, 'residual_analisis', 'Level Risiko Residual');
		$bulan = [
			1 => 'Jan',
			2 => 'Feb',
			3 => 'Mar',
			4 => 'Apr',
			5 => 'Mei',
			6 => 'Jun',
			7 => 'Jul',
			8 => 'Agu',
			9 => 'Sep',
			10 => 'Okt',
			11 => 'Nov',
			12 => 'Des',
		];
		foreach (range(1, 12) as $key => $value) {
			$datetime = DateTime::createFromFormat('m', $value);
			$nama =  $bulan[$value];
			$this->set_Table_List($this->tbl_master, 'monitoring' . $value, $nama, 3, 'center');
		}


		$this->_SET_PRIVILEGE('add', false);
		// $this->_SET_PRIVILEGE('edit', false);
		$this->_SET_PRIVILEGE('delete', false);
		$this->_SET_PRIVILEGE('view', false);
		// $this->tmp_data['setActionprivilege']=false;

		$this->_SET_ACTION_WIDTH('size', 15);
		$this->_SET_ACTION_WIDTH('align', 'center');
		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		$this->_CHANGE_TABLE_MASTER(_TBL_RCSA_ACTION_DETAIL);

		$this->set_Close_Setting();
	}

	public function index() {
		$start_time = microtime(true);
		$page = $this->input->get('page') ? $this->input->get('page') : 1;
		$limit = 10; 
 		$data['periode'] = $this->input->get('periode');
		$x=$this->authentication->get_info_user();
		$own=$x['group']['owner']['owner_no'];
 		if($this->input->get('owner')){
			$own= $this->input->get('owner');
		}
		$twD = date('n'); 

		if ($twD >= 1 && $twD <= 3) {
			$tw = 1; 
		} elseif ($twD >= 4 && $twD <= 6) {
			$tw = 2; 
		} elseif ($twD >= 7 && $twD <= 9) {
			$tw = 3;
		} elseif ($twD >= 10 && $twD <= 12) {
			$tw = 4;
		} else {
			$tw = 0;
		}
		
		// Cek apakah ada input triwulan dari form, jika ada, gunakan triwulan dari input
		if ($this->input->get('triwulan')) {
			$tw = $this->input->get('triwulan');
		}
		$data['owner'] 		= $own;
		$data['triwulan'] 	= $tw;
 		$total_data 		= $this->data->count_all_data($data); 
		$total_pages 		= ceil($total_data / $limit); 
		$offset 			= ($page - 1) * $limit;
		$x['total_data'] 	= $total_data;
		$x['start_data'] 	= $offset + ($total_data>0)?1:0;
		$x['end_data'] 		= min($offset + $limit, $total_data);
		$x['cboPeriod'] 	= $this->cbo_periode;
		$x['triwulan'] 		= $tw;
		$x['cboOwner'] 		= $this->cbo_parent;
		$x['field'] 		= $this->data->getDetail($data, $limit, $offset);
		
		
	
		

 		if ($total_data > 0) {
			$x['pagination'] = $this->pagination($data, $total_pages, $page);
		} else {
			$x['pagination'] = '';  
		}
		$end_time = microtime(true);
		$execution_time = ($end_time - $start_time);
		$x['timeLoad'] =round($execution_time,2);
		$this->template->build('home', $x);
	}
	
	
	function pagination($data, $total_pages, $page){
		$pagination = '';
  		$post = '';
		if (!empty($data['periode'])) {
			$post .= '&periode=' . $data['periode'];
		}
		if (!empty($data['owner'])) {
			$post .= '&owner=' . $data['owner'];
		}
		if (!empty($data['triwulan'])) {
			$post .= '&triwulan=' . $data['triwulan'];
		}
	
		if ($total_pages > 1) {
			$pagination .= '<ul class="pagination">';
			
 			if ($page > 4) {
				$pagination .= '<li><a href="' . site_url('lost_event_database/index?page=1' . $post) . '">First</a></li>';
			}
			
 			for ($i = max(1, $page - 3); $i < $page; $i++) {
				$pagination .= '<li><a href="' . site_url('lost_event_database/index?page=' . $i . $post) . '">' . $i . '</a></li>';
			}
			
 			$pagination .= '<li class="active"><span>' . $page . '</span></li>';
			
 			for ($i = $page + 1; $i <= min($page + 3, $total_pages); $i++) {
				$pagination .= '<li><a href="' . site_url('lost_event_database/index?page=' . $i . $post) . '">' . $i . '</a></li>';
			}
			
 			if ($page < $total_pages - 3) {
				$pagination .= '<li><a href="' . site_url('lost_event_database/index?page=' . $total_pages . $post) . '">Last</a></li>';
			}
			
			$pagination .= '</ul>';
		}
		
		return $pagination;
	}

	public function get_detail_modal() {
		// Mengambil input dari POST request
		$id = $this->input->post("id_detail");
		$month = $this->input->post("month");
		$type = $this->input->post("type");

		$data['cboLike']		= $this->cboLike;
		$data['cboImpact']		= $this->cboImpact;
	
		// Inisialisasi array untuk hasil
		// $result = [
		// 	'action_detail' => null,
		// 	'lost_event' => null,
		// 	'type' => null
		// ];
	
		// Ambil id berdasarkan rcsa_detail_no
		$act = $this->db
			->select('id')
			->where('rcsa_detail_no', $id)
			->get('bangga_rcsa_action')
			->row_array();
	
		// Cek apakah ID ditemukan
		if ($act) {
			// Ambil detail berdasarkan rcsa_action_no
			$detail = $this->db
				->where('rcsa_action_no', $act['id'])
				->where('bulan', $month)
				->get('bangga_view_rcsa_action_detail')
				->row_array();
	
			// Simpan detail ke dalam hasil
			$data['action_detail'] = $detail ?: null; // Jika tidak ada detail, set null
			$data['type'] = 'add';
		}
	
		// Jika tipe adalah "edit", ambil data tambahan dari rcsa_lost_event
		if ($type === "edit") {
			$detailedit = $this->db
				->where('rcsa_detail_id', $id)
				->where('bulan', $month)
				->get(_TBL_RCSA_LOST_EVENT)
				->row_array();
	
			// Tambahkan data edit ke hasil
			$data['lost_event'] = $detailedit ?: null; // Jika tidak ada, set null
			$data['type'] = 'edit';
			//  = ;
			$row_in 	= $this->db->where('impact_no',$detailedit['skal_prob_in'] )->where('like_no', $detailedit['skal_dampak_in'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
			$row_res 	= $this->db->where('impact_no',$detailedit['target_res_prob'] )->where('like_no',$detailedit['target_res_dampak'] )->get(_TBL_VIEW_MATRIK_RCSA)->row_array();

			 $data['label_in'] = "<span style='background-color:" . $row_in['warna_bg'] . ";color:" . $row_in['warna_txt'] . ";'>&nbsp;" . $row_in['tingkat'] . "&nbsp;</span>";
			 $data['label_res'] = "<span style='background-color:" . $row_res['warna_bg'] . ";color:" . $row_res['warna_txt'] . ";'>&nbsp;" . $row_res['tingkat'] . "&nbsp;</span>";
		}

		
		
		$result['register'] = $this->load->view('form_modal', $data, true);
		// Kode untuk mengembalikan hasil dalam format JSON
		echo json_encode($result);
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

	public function getMonthlyMonitoring($id, $month)
	{
		$act = $this->db
			->select('id')
			->where('rcsa_detail_no', $id)
			// ->where('bulan', $month)
			->get('bangga_rcsa_action')->row_array();
		// doi::dump($act);


		$result['kri'] = $this->db
			->where('rcsa_detail', $id)
			->get(_TBL_KRI)->row_array();
		// doi::dump($result['kri']);
		$result['kri_detail'] = $this->db
		->where('rcsa_detail', $result['kri']['rcsa_detail'])
		->where('bulan',  $month)
		->get(_TBL_KRI_DETAIL)->row_array();

		$result['data'] = $this->db
			->where('rcsa_action_no', $act['id'])
			->where('bulan', $month)
			->get('bangga_view_rcsa_action_detail')->row_array();


			$detail = $this->db
			->select('periode_name')
			->where('id', $id)
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


			$result['before'] = $this->db
				->where('rcsa_action_no', $act['id'])
				->where('bulan', $month - 1)
				->get('bangga_view_rcsa_action_detail')->row_array();
		}
		return $result;
	}


	

	function cek_level()
	{
		$post = $this->input->post();
		$rows = $this->db->where('impact_no', $post['impact'])->where('like_no', $post['likelihood'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();

		$result['level_text'] = '-';
		$result['level_no'] = 0;
		$result['level_resiko'] = '-';

		if ($rows) {
			$result['level_text'] = "<span style='background-color:" . $rows['warna_bg'] . ";color:" . $rows['warna_txt'] . ";'>&nbsp;" . $rows['tingkat'] . "&nbsp;</span>";
			$result['level_no'] = $rows['id'];
			$result['level_name'] = $rows['tingkat'];
			$cboTreatment = $this->get_combo('treatment');
			$cboTreatment1 = $this->get_combo('treatment1');
			$cboTreatment2 = $this->get_combo('treatment2');

			if ($result['level_name'] == "Ekstrem") {
				$result['level_resiko'] = $cboTreatment1;
			} elseif ($result['level_name'] == "Low") {
				$result['level_resiko'] = $cboTreatment2;
			} else {
				$result['level_resiko'] = $cboTreatment;
			}
		}

		echo json_encode($result);
	}

	function simpan_lost_event()
	{
		$post = $this->input->post();
		// doi::dump($post);
		// die('ctr');	
	 
		$id = $this->data->simpan_lost_event($post);
		echo json_encode($id);
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */