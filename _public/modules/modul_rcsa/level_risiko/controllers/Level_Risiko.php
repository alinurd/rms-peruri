<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Level_Risiko extends BackendController
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

		$this->set_Tbl_Master(_TBL_VIEW_RCSA_DETAIL);


		$this->set_Open_Tab('Level Risiko');
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
		$this->_SET_PRIVILEGE('delete', false);
		$this->_SET_PRIVILEGE('view', false);

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
		$data['owner'] =$own;
 		$total_data = $this->data->count_all_data($data); 
		$total_pages = ceil($total_data / $limit); 
		$offset = ($page - 1) * $limit;
		$x['total_data'] = $total_data;
		$x['start_data'] = $offset + ($total_data>0)?1:0;
		$x['end_data'] = min($offset + $limit, $total_data);
		$x['cboPeriod'] = $this->cbo_periode;
		$x['triwulan'] = $tw;
		$x['cboOwner'] = $this->cbo_parent;
		$x['field'] = $this->data->getDetail($data, $limit, $offset);
		$x['cb_like'] = $this->get_combo('likelihood');
		$x['cb_impact'] = $this->get_combo('impact');
		
	
		

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

	public function save(){
		$post 	= $this->input->post();
		// die;
		$id = $this->data->simpan_realisasi($post);
		doi::dump($id);
		die;
		// echo json_encode($id);

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
				$pagination .= '<li><a href="' . site_url('level_risiko/index?page=1' . $post) . '">First</a></li>';
			}
			
 			for ($i = max(1, $page - 3); $i < $page; $i++) {
				$pagination .= '<li><a href="' . site_url('level_risiko/index?page=' . $i . $post) . '">' . $i . '</a></li>';
			}
			
 			$pagination .= '<li class="active"><span>' . $page . '</span></li>';
			
 			for ($i = $page + 1; $i <= min($page + 3, $total_pages); $i++) {
				$pagination .= '<li><a href="' . site_url('level_risiko/index?page=' . $i . $post) . '">' . $i . '</a></li>';
			}
			
 			if ($page < $total_pages - 3) {
				$pagination .= '<li><a href="' . site_url('level_risiko/index?page=' . $total_pages . $post) . '">Last</a></li>';
			}
			
			$pagination .= '</ul>';
		}
		
		return $pagination;
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
	
	
	function cek_level()
	{
		$post = $this->input->post();
		$rows = $this->db->where('impact_no', $post['impact'])->where('like_no', $post['likelihood'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();

		$result['level_text'] = '-';
		$result['level_no'] = 0;
		$result['level_resiko'] = '-';
		$result['id'] = (isset($post))?$post['id']:'';
		$result['mode'] =(isset($post['mode']))?$post['mode']:0;
		$result['month'] =(isset($post['month']))?$post['month']:0;
		// $result['cek'] = $rows;
		if ($rows) {
			$progress_detail    = $rows['code_likelihood'] . ' x ' . $rows['code_impact'];
			$result['level_text'] = "<span class='btn' style='padding:4px 8px;width:100%; background-color:" . $rows['warna_bg'] . ";color:" . $rows['warna_txt'] . ";'>&nbsp;" . $rows['tingkat'] ." [" . $progress_detail . "] &nbsp;</span>";
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

	public function get_log_modal() {
		
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

		$data['triwulan'] = $tw;

		$data['owner'] =$own;
		$x['cboPeriod'] = $this->cbo_periode;
		$x['triwulan'] = $tw;
		$x['cboOwner'] = $this->cbo_parent;
		$x['field'] = $this->data->getDetail_modal($data);
		// $x['cb_like'] = $this->get_combo('likelihood');
		// $x['cb_impact'] = $this->get_combo('impact');
		
	
		// Jika Anda perlu mengembalikan tampilan 'log_modal'
		$result['register'] = $this->load->view('log_modal', $x, true);
	
		// Mengembalikan hasil dalam format JSON
		echo json_encode($result);
	}
	
	

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */