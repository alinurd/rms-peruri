<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Risk_Monitoring extends BackendController
{
	var $type_risk = 0;
	var $table = "";
	var $post = array();
	var $sts_cetak = false;

	public function __construct()
	{
		$this->required = '<sup><span class="required"> *) </span></sup> ';

		parent::__construct();
		$this->cbo_status_action = $this->get_combo('status-action');
		$this->cbo_parent = $this->get_combo('parent-input');
		$this->cbo_owner = $this->get_combo('owner');
		$this->cbo_loss = [1 => 'Ya', 0 => 'Tidak'];

		$this->cbo_periode = $this->get_combo('periode');

		$this->set_Tbl_Master(_TBL_VIEW_RCSA_DETAIL);
		// $this->set_Table(_TBL_RCSA_DETAIL);
		// $this->set_Table(_TBL_RCSA);
		// $this->set_Table(_TBL_OWNER);		

		// $this->tbl_schedule_type=_TBL_SCHEDULE_TYPE;
		// $this->tbl_status_action=_TBL_STATUS_ACTION;


		$this->set_Open_Tab('Risk Monitoring');
		$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 11));
		$this->addField(array('field' => 'rcsa_no', 'show' => false, 'size' => 100));
		$this->addField(array('field' => 'owner_no', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => true, 'search' => true));

		// $this->addField(array('field' => 'name', 'show' => true, 'search' => false, 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'save' => false, 'size' => 100));
		$this->addField(array('field' => 'event_name', 'show' => true, 'save' => false, 'size' => 100));
		$this->addField(array('field' => 'tahun', 'show' => true, 'save' => false, 'size' => 100));
		$this->addField(array('field' => 'name', 'show' => true, 'save' => false, 'size' => 100));
		$this->addField(array('field' => 'period_no', 'input' => 'combo:search', 'combo' => $this->cbo_periode, 'size' => 15, 'search' => true, 'required' => true));

		// $this->addField(array('field'=>'progress_date', 'show'=>false, 'size'=>100));


		// $this->addField(array('field'=>'inherent_analisis_action','save'=>false, 'show'=>true, 'size'=>5));
		// $this->addField(array('field'=>'status_action_detail', 'show'=>true, 'save'=>false, 'size'=>5));
		// $this->addField(array('field'=>'residual_analisis', 'save'=>false,'show'=>true, 'size'=>5));

		// $this->addField(array('field'=>'type_name','show'=>false,'save'=>false, 'size'=>5));
		// $this->addField(array('field'=>'status_loss','input'=>'combo','combo'=>$this->cbo_loss, 'show'=>true,'save'=>false, 'size'=>5));
		// $this->addField(array('field'=>'progress_detail','input'=>'updown', 'show'=>true, 'size'=>100));

		// $this->addField(array('field'=>'status_no', 'show'=>false, 'save'=>false, 'size'=>5));
		// $this->addField(array('field'=>'keterangan', 'show'=>false,'save'=>false, 'size'=>5));
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
		// $this->set_Sort_Table($this->tbl_master, 'id', 'desc');

		$this->set_Table_List($this->tbl_master, 'name', 'Risk Owner');
		$this->set_Table_List($this->tbl_master, 'period_no', 'Tahun');
		$this->set_Table_List($this->tbl_master, 'event_name', 'Peristiwa Risiko');
		// $this->set_Table_List($this->tbl_master,'reaktif','Treatment');
		// $this->set_Table_List($this->tbl_master,'progress_date','Due Date');
		$this->set_Table_List($this->tbl_master, 'inherent_analisis', 'Level Risiko Inheren');
		// $this->set_Table_List($this->tbl_master,'status_no','Pelaksanaan Treatment',10);
		$this->set_Table_List($this->tbl_master, 'residual_analisis', 'Level Risiko Residual');

		// $this->set_Table_List($this->tbl_master,'keterangan','Loss Event');
		// $this->set_Table_List($this->tbl_master,'progress_detail','Progress');
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
		$page = $this->input->get('page') ? $this->input->get('page') : 1;
		$limit = 10; 
		$data['periode'] = $this->input->get('periode');
		$data['owner'] = $this->input->get('owner');
		
		$total_data = $this->data->count_all_data($data); 
		$total_pages = ceil($total_data / $limit); 
		$offset = ($page - 1) * $limit;
		$x['total_data'] = $total_data;
		$x['start_data'] = $offset + ($total_data>0)?1:0;
		$x['end_data'] = min($offset + $limit, $total_data);
		$x['cboPeriod'] = $this->cbo_periode;
		$x['cboOwner'] = $this->cbo_parent;
		$x['field'] = $this->data->getDetail($data, $limit, $offset);
	
	 

 		if ($total_data > 0) {
			$x['pagination'] = $this->pagination($data, $total_pages, $page);
		} else {
			$x['pagination'] = '';  
		}
	
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
	
		if ($total_pages > 1) {
			$pagination .= '<ul class="pagination">';
			
 			if ($page > 4) {
				$pagination .= '<li><a href="' . site_url('risk_monitoring/index?page=1' . $post) . '">First</a></li>';
			}
			
 			for ($i = max(1, $page - 3); $i < $page; $i++) {
				$pagination .= '<li><a href="' . site_url('risk_monitoring/index?page=' . $i . $post) . '">' . $i . '</a></li>';
			}
			
 			$pagination .= '<li class="active"><span>' . $page . '</span></li>';
			
 			for ($i = $page + 1; $i <= min($page + 3, $total_pages); $i++) {
				$pagination .= '<li><a href="' . site_url('risk_monitoring/index?page=' . $i . $post) . '">' . $i . '</a></li>';
			}
			
 			if ($page < $total_pages - 3) {
				$pagination .= '<li><a href="' . site_url('risk_monitoring/index?page=' . $total_pages . $post) . '">Last</a></li>';
			}
			
			$pagination .= '</ul>';
		}
		
		return $pagination;
	}
	

	function listBox_INHERENT_ANALISIS($rows, $value)
	{
		// $nilai = ;
		// doi::dump($rows);
		$residual_level = $this->data->get_master_level(true, $rows['l_inherent_level']);
		// var_dump($a);
		$like = $this->db
			->where('id', $residual_level['likelihood'])
			->get('bangga_level')->row_array();

		$impact = $this->db
		->where('id',
			$residual_level['impact']
		)
		->get('bangga_level')->row_array();

		$likeimpac = $like['code'] . 'x' . $impact['code'];
		if (!$residual_level) {
			$residual_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
			$likeimpac = '';
		}
		// doi::dump($residual_level);


		$hasil = '<span class="btn" style="padding:4px 8px;width:100%;background-color:' . $residual_level['color'] . ';color:' . $residual_level['color_text'] . ';">' . $residual_level['level_mapping'] . ' <br>[ ' . $likeimpac . ' ]</span><div title="Nilai rata-rata realisasi" style="padding-top:8px" > </div>';

		return $hasil;
	}
	function listBox_RESIDUAL_ANALISIS($rows, $value)
	{
		// $nilai = ;
		
		$residual_level = $this->data->get_master_level(true, $rows['l_residual_level']);
		// var_dump($a);
		$like = $this->db
			->where('id', $residual_level['likelihood'])
			->get('bangga_level')->row_array();

		$impact = $this->db
			->where('id', $residual_level['impact'])
			->get('bangga_level')->row_array();

		$likeimpac = $like['code'] . 'x' . $impact['code'];
		if (!$residual_level) {
			$residual_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
			$likeimpac = '';
		}
		// doi::dump($residual_level);


		$hasil = '<span class="btn" style="padding:4px 8px;width:100%;background-color:' . $residual_level['color'] . ';color:' . $residual_level['color_text'] . ';">' . $residual_level['level_mapping'] . ' <br>[ ' . $likeimpac . ' ]</span><div title="Nilai rata-rata realisasi" style="padding-top:8px" > </div>';

		return $hasil;  
	}

	public function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows)
	{
		$id = $rows['l_id'];
		$tombol['propose'] = [];
		$tombol['edit'] = [];
		$tombol['print'] = [];
		$tombol['delete'] = [];
		$tombol['view'] = [];

		return $tombol;
	}

	function listBox_PERIOD_NO($rows, $value)
	{

		if ($value) {
			$p = $this->db->where('id', $value)->get(_TBL_PERIOD)->row_array();
			$hasil=$p['periode_name'];
 		} else {
			$hasil = 'tidak ditemukan';
		}
		return $hasil;
	}
	function listBox_KETERANGAN($rows, $value)
	{

		if ($rows['l_type_name'] == "Reaktif") {
			$hasil = '<span>Ya </span>';
		} else {
			$hasil = '<span>Tidak </span>';
		}
		return $hasil;
	}
	function list_realisasi()
	{
		$id_rcsa = $this->input->post('id');
		$id_edit = $this->input->post('edit');
		$bulan = $this->input->post('bulan');

		$data['parent'] = $this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->row_array();
		$data['detail'] = $this->db->where('id', $id_edit)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['realisasi'] = $this->data->get_realisasi($id_edit, $bulan);
		$data['list_realisasi'] = $this->load->view('list-realisasi', $data, true);
		$result['peristiwa'] = $this->load->view('realisasi', $data, true);
		echo json_encode($result);
	}

	function listBox_PROGRESS_DETAIL($rows, $value)
	{
		if ($value <= 30) {
			$warna = "danger";
		} elseif ($value <= 50) {
			$warna = "warning";
		} elseif ($value <= 75) {
			$warna = "success";
		} else {
			$warna = "primary";
		}

		$result = '<div class="progress progress-sl">
					  <div class="progress-bar progress-bar-' . $warna . '" role="progressbar" aria-valuenow="' . $value . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $value . '%;">' . number_format($value) . '% Complete
					  </div>
				  </div>';

		return $result;
	}
	function listBox_STATUS_NO($rows, $value)
	{
		$nilai = intval($rows['l_status_no']);
		$hasil = "";
		// switch ($nilai) {
		// 	case 1:
		// 		$hasil = '<span style="background-color:blue;color:white;">Close </span>';
		// 		break;
		// 	case 2:
		// 		$hasil = '<span style="background-color:blue;color:white;">On Progress</span>';
		// 		break;
		// 	case 3:
		// 		$hasil = '<span style="background-color:red;color:white;">Add </span>';
		// 		break;
		// 	case 4:
		// 		$hasil = '<span style="background-color:blue;color:white;"> Open </span>';
		// 		break;
		// }
		switch ($nilai) {
			case 1:
				$hasil = '<span>Close </span>';
				break;
			case 2:
				$hasil = '<span>On Progress</span>';
				break;
			case 3:
				$hasil = '<span>Add </span>';
				break;
			case 4:
				$hasil = '<span>Open </span>';
				break;
		}
		return $hasil;
	}

	public function listBox_OWNER_NAME($rows, $value)
	{
		$par = $this->data->getOwnerParent($rows['l_rcsa_owner_no']);
		$owner = 'tidak ada';
		if ($par != null) {
			$owner = ($par['lv_3_id'] != 22) ? $par['lv_3_name'] : $par['lv_2_name'];
		}
		if ($owner == $par['lv_3_name']) {
			$owner = ($par['lv_3_name'] == '') ? $par['lv_1_name'] : $par['lv_2_name'];
		}
		$result = $owner . ' - <b>' . $value . '</b>';
		return $result;
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


	public function listBox_MONITORING1($rows, $value)
	{
		
		$b = 1;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}

		$monthly = $data['data'];
		$like_impact = $this->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
		$progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
		$progress_detail= $like_impact['like']['code'] .' x '. $like_impact['impact']['code'];

		if (!$monthly) {
			$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
		} else {
			$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
		}
		
		return $result;
	}
	public function listBox_MONITORING2($rows, $value)
	{
		$b = 2;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}
		$monthly = $data['data'];
		$monthbefore = $data['before'];
		$angka = $monthly['progress_detail'];
$like_impact = $this->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
		$progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
		$progress_detail= $like_impact['like']['code'] .' x '. $like_impact['impact']['code'];		// doi::dump($monthly);
		if (!$monthbefore) {
			$result = '<i class="fa fa-times-circle text-danger"></i>';
		} else {
			if (!$monthly) {
				$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
			} else {
				$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
			}
		}
		return $result;
	}
	public function listBox_MONITORING3($rows, $value)
	{
		$b = 3;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}
		$monthly = $data['data'];
		$monthbefore = $data['before'];
		$angka = $monthly['progress_detail'];
$like_impact = $this->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
		$progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
		$progress_detail= $like_impact['like']['code'] .' x '. $like_impact['impact']['code'];		// doi::dump($monthly);
		if (!$monthbefore) {
			$result = '<i class="fa fa-times-circle text-danger"></i>';
		} else {
			if (!$monthly) {
				$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
			} else {
					$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
			}
		}
		return $result;
	}
	public function listBox_MONITORING4($rows, $value)
	{
		$b = 4;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}
		$monthly = $data['data'];
		$monthbefore = $data['before'];
		$angka = $monthly['progress_detail'];
$like_impact = $this->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
		$progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
		$progress_detail= $like_impact['like']['code'] .' x '. $like_impact['impact']['code'];		// doi::dump($monthly);
		if (!$monthbefore) {
			$result = '<i class="fa fa-times-circle text-danger"></i>';
		} else {
			if (!$monthly) {
				$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
			} else {
					$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
			}
		}
		return $result;
	}
	public function listBox_MONITORING5($rows, $value)
	{
		$b = 5;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}
		$monthly = $data['data'];
		$monthbefore = $data['before'];
		$angka = $monthly['progress_detail'];
$like_impact = $this->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
		$progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
		$progress_detail= $like_impact['like']['code'] .' x '. $like_impact['impact']['code'];		// doi::dump($monthly);
		if (!$monthbefore) {
			$result = '<i class="fa fa-times-circle text-danger"></i>';
		} else {
			if (!$monthly) {
				$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
			} else {
					$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
			}
		}
		return $result;
	}
	public function listBox_MONITORING6($rows, $value)
	{
		$b = 6;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}
		$monthly = $data['data'];
		$monthbefore = $data['before'];
		$angka = $monthly['progress_detail'];
$like_impact = $this->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
		$progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
		$progress_detail= $like_impact['like']['code'] .' x '. $like_impact['impact']['code'];		// doi::dump($monthly);
		if (!$monthbefore) {
			$result = '<i class="fa fa-times-circle text-danger"></i>';
		} else {
			if (!$monthly) {
				$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
			} else {
					$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
			}
		}
		return $result;
	}
	public function listBox_MONITORING7($rows, $value)
	{
		$b = 7;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}
		$monthly = $data['data'];
		$monthbefore = $data['before'];
		$angka = $monthly['progress_detail'];
$like_impact = $this->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
		$progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
		$progress_detail= $like_impact['like']['code'] .' x '. $like_impact['impact']['code'];		// doi::dump($monthly);
		if (!$monthbefore) {
			$result = '<i class="fa fa-times-circle text-danger"></i>';
		} else {
			if (!$monthly) {
				$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
			} else {
					$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
			}
		}
		return $result;
	}
	public function listBox_MONITORING8($rows, $value)
	{
		$b = 8;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}
		$monthly = $data['data'];
		$monthbefore = $data['before'];
		$angka = $monthly['progress_detail'];
$like_impact = $this->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
		$progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
		$progress_detail= $like_impact['like']['code'] .' x '. $like_impact['impact']['code'];		// doi::dump($monthly);
		if (!$monthbefore) {
			$result = '<i class="fa fa-times-circle text-danger"></i>';
		} else {
			if (!$monthly) {
				$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
			} else {
					$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
			}
		}
		return $result;
	}
	public function listBox_MONITORING9($rows, $value)
	{
		$b = 9;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}
		$monthly = $data['data'];
		$monthbefore = $data['before'];
		$angka = $monthly['progress_detail'];
$like_impact = $this->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
		$progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
		$progress_detail= $like_impact['like']['code'] .' x '. $like_impact['impact']['code'];		// doi::dump($monthly);
		if (!$monthbefore) {
			$result = '<i class="fa fa-times-circle text-danger"></i>';
		} else {
			if (!$monthly) {
				$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
			} else {
					$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
			}
		}
		return $result;
	}
	public function listBox_MONITORING10($rows, $value)
	{
		$b = 10;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}
		$monthly = $data['data'];
		$monthbefore = $data['before'];
		$angka = $monthly['progress_detail'];
$like_impact = $this->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
		$progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
		$progress_detail= $like_impact['like']['code'] .' x '. $like_impact['impact']['code'];		// doi::dump($monthly);
		if (!$monthbefore) {
			$result = '<i class="fa fa-times-circle text-danger"></i>';
		} else {
			if (!$monthly) {
				$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
			} else {
					$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
			}
		}
		return $result;
	}
	public function listBox_MONITORING11($rows, $value)
	{
		$b = 11;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}
		$monthly = $data['data'];
		$monthbefore = $data['before'];
		$angka = $monthly['progress_detail'];
$like_impact = $this->level_action($monthly['residual_likelihood_action'], $monthly['residual_impact_action']);
		$progress_detail_ = $like_impact['like']['code'] * $like_impact['impact']['code'];
		$progress_detail= $like_impact['like']['code'] .' x '. $like_impact['impact']['code'];		// doi::dump($monthly);
		if (!$monthbefore) {
			$result = '<i class="fa fa-times-circle text-danger"></i>';
		} else {
			if (!$monthly) {
				$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
			} else {
					$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $progress_detail . ']</span></a><div title=" realisasi KRI"  > <span  ' . $bgres . '> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ' . $krnm . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  </div>';
			}
		}
		return $result;
	}
	public function listBox_MONITORING12($rows, $value)
	{
		$b = 12;
		$data = $this->getMonthlyMonitoring($rows['l_id'], $b);
		$realisasi = $data['kri_detail']['realisasi'];
 		$level_1 = range($data['kri']['min_rendah'], $data['kri']['max_rendah']);
		$level_2 = range($data['kri']['min_menengah'], $data['kri']['max_menengah']);
		$level_3 = range($data['kri']['min_tinggi'], $data['kri']['max_tinggi']);
		if($data['kri']){
			$krnm="K R I";
		if (in_array($realisasi, $level_1)) {
			$bgres = 'style="background-color: #7FFF00;color: #000;"';
		} elseif (in_array($realisasi, $level_2)) {
			$bgres = 'style="background-color: #FFFF00;color:#000;"';
		} elseif (in_array($realisasi, $level_3)) {
			$bgres = 'class="bg-danger" style=" color: #000;"';
		} else {
			$bgres = '';
		}
		}else{
			$bgres = '';

		}
		$monthly = $data['data'];
		$monthbefore = $data['before'];
		// doi::dump($monthly);
		if (!$monthbefore) {
			$result = '<i class="fa fa-times-circle text-danger"></i>';
		} else {
			if (!$monthly) {
				$result = '<a href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '" class="propose pointer btn btn-light" data-id="' . $rows['l_id'] . '"><i class="icon-pencil"></i></a>';
			} else {
				$result = '<a class="propose" href="' . base_url($this->modul_name . '/update/' . $rows['l_id'] . '/' . $rows['l_rcsa_no'] . '/' . $b) . '"><span class="btn" style="padding:4px 8px;width:100%;background-color:' . $monthly['warna_action'] . ';color:' . $monthly['warna_text_action'] . ';">' . $monthly['inherent_analisis_action'] . ' [' . $monthly['progress_detail'] . ']</span></a><div title="Nilai rata-rata realisasi" style="padding-top:8px" > </div>';
			}
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

	function simpan_realisasi_kri()
	{
		$post = $this->input->post();
		// doi::dump($post);
		// die('ctr');

		$id = $this->data->simpan_realisasi_kri($post);
		if ($id) {

		$tab = 'Berhasil mengisi Key Risk Indikator ';
		$this->session->set_flashdata('tab', $tab);
		// $this->session->set_flashdata('id', $id);
		// $this->session->set_flashdata('rcsa_no', $post['rcsa_no']);
		// header('location:' . base_url($this->modul_name . '/tes/'));
 
		$data['id'] = $id;

		echo json_encode($data);		} 
	}


	function simpan_realisasi()
	{
		$post = $this->input->post();
		// doi::dump($post);
		// die('ctr');	
	 
		$id = $this->data->simpan_realisasi($post);
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['detail'] = $this->db->where('id', $post['detail_rcsa_no'])->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['realisasi'] = $this->data->get_realisasi($post['detail_rcsa_no'], $post['bulan']);
		$result['combo'] = $this->load->view('list-realisasi', $data, true);
		echo json_encode($result);
	}
	function delete_realisasi()
	{
		$id_edit = $this->input->post('edit');
		if ($id_edit > 0) {
			$detail = $this->db->delete(_TBL_RCSA_ACTION_DETAIL, ['id' => $id_edit]);
		}
		echo json_encode(['sts' => 1]);
	}

	function input_realisasi()
	{
		$post = $this->input->post();
		$id = $this->input->post('id');
		$bulan = $this->input->post('bulan');
		$rcsa_detail_no = $this->input->post('rcsa_detail_no');
		$cboRiskControl = $this->get_combo('data-combo', 'control-assesment');

		$dataxkri = $this->db
			->where('rcsa_detail', $rcsa_detail_no)
			->where('bulan',  $bulan)
			->get(_TBL_KRI_DETAIL)->row_array();

		$data['krii'] = $this->get_combo('data-combo', 'kri');
		$data['per_data'] = [
			0 => '-select-', 1 => 'Bulan', 2 => 'Triwulan', 3 => 'semester'
		];
		$data['satuan'] = $this->get_combo('data-combo', 'satuan');
		$rcsa_no = $this->input->post('rcsa_no');
		$data['data_kri'] = $this->db->where('rcsa_detail', $rcsa_detail_no)->get('bangga_kri')->row_array();
		$data['owner'] = $this->db->where('id', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['detail'] = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->row_array();
		$rows = $this->db->where('rcsa_detail_no', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_MITIGASI)->row_array();
		$data['cek'] = $this->db->where('rcsa_detail_no', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		$data['id'] = $id;
		$proaktif = [];
		$reaktif = [];
		$proaktif_text = '<ul>';
		$reaktif_text = '<ul>';
		$pilih = 0;
		$no = 0;

		$proaktif[$rows['id']] = $rows['proaktif'];
		$reaktif[$rows['id']] = $rows['reaktif'];
		$reaktif_text .= '<li>' . $rows['reaktif'] . '</li>';
		$proaktif_text .= '<li>' . $rows['proaktif'] . '</li>';

		$proaktif_text .= '</ul>';
		$reaktif_text .= '</ul>';
		$reaktif_text .= form_hidden('rcsa_action_no', $rows['id']);

		$field = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->row_array();
		$inherent_level = $data['detail'];
		if (!$inherent_level) {
			$inherent_level = ['warna_action' => '', 'warna_text_action' => '', 'inherent_analisis_action' => '-'];
		}

		$data['rcsa_detail_no'] = $rcsa_detail_no;
		$data['rcsa_no'] = $rcsa_no;
		$data['edit_no'] = $id;
		$cbo_owner = $this->get_combo('parent-input-all');
		$cboLike = $this->get_combo('likelihood');
		$cboImpact = $this->get_combo('impact');
		$cbo_status = $this->get_combo('status-action');
		$pilih = ($data['detail']) ? $data['detail']['status_loss'] : 1;

		$check_kriteria = '<label class="pointer">' . form_radio('status_loss', 1, ($pilih <= 1) ? true : false, ' id="status_loss"');
		$check_kriteria .= '&nbsp; Ya</label> &nbsp;&nbsp;&nbsp;';
		$check_kriteria .= '<label class="pointer">' . form_radio('status_loss', 0, ($pilih == 0) ? true : false, ' id="status_loss" ');
		$check_kriteria .= '&nbsp; Tidak</label> &nbsp;&nbsp;&nbsp;';

		$data['realisasi'][] = ['show' => true, 'isi' => form_hidden('bulan', $bulan, 'class="form-control" style="width:100%;" id="bulan"')];

		$data['realisasi'][] = ['show' => true, 'label' => 'Apakah peristiwa ini terjadi ', 'isi' => $check_kriteria];
		$data['realisasi'][] = ['show' => ($pilih == 0) ? true : false, 'label' => 'Proaktif', 'isi' => $proaktif_text];
		$data['realisasi'][] = ['show' => ($pilih == 1) ? true : false, 'label' => 'Reaktif', 'isi' => $reaktif_text];

		$data['realisasi'][] = ['show' => true, 'label' => '<span  onmouseover="showPopup()" onmouseout="hidePopup()">Realisasi <b class="text-danger  ">&nbsp; <img src="' . base_url("themes/idea-25.png") . '" width="25px" height="25px" ></b></span>', 'isi' => ''. form_input('realisasi', ($data['detail']) ? $data['detail']['realisasi'] : '', 'class="form-control"  style="width:100%;" id="realisasi"')];
		// $data['realisasi'][] = ['show'=>true,'label' => 'Tanggal Pelaksanaan', 'isi' => form_input('progress_date', ($field)?$field['progress_date']:date('d-m-Y')," id='progress_date' size='20' class='form-control datepicker' style='width:130px;'")];
		$data['realisasi'][] = ['show' => true, 'label' => 'Progress', 'isi' => form_input(['name' => 'progress', 'id' => 'progress', 'type' => 'number', 'value' => ($data['detail']) ? $data['detail']['progress_detail'] : '', 'class' => 'form-control', 'style' => 'width:15%;'])];

		$a = ($field) ? $field['progress_date'] : '';
		$n = date_create($a, timezone_open('Asia/Jakarta'))->format('d-m-Y');
		$data['realisasi'][] = ['show' => true, 'label' => 'Tanggal Pelaksanaan', 'isi' => form_input('progress_date', ($field) ? $n : '', " id='progress_date' size='20' class='form-control datepicker' style='width:130px;'")];
		$data['realisasi'][] = ['show' => true, 'label' => 'Efektivitas Internal Control & Treatment', 'isi' => form_dropdown('risk_control', $cboRiskControl, ($data['detail']) ? $data['detail']['risk_control'] : '', ' class="form-control select2" id="risk_control" style="width:100%;"' . $disabled)];

		
		$data['realisasi'][] = ['show' => true, 'label' => 'Analisa Risiko', 'isi' => ' Kemungkinan : ' . form_dropdown('residual_likelihood', $cboLike, ($data['detail']) ? $data['detail']['residual_likelihood_action'] : '', ' class="form-control select2" id="residual_likelihood" style="width:35%;"') . ' Dampak: ' . form_dropdown('residual_impact', $cboImpact, ($data['detail']) ? $data['detail']['residual_impact_action'] : '', ' class="form-control select2" id="residual_impact" style="width:35%;"')];
		$data['realisasi'][] = ['show' => true, 'label' => 'Risk Level', 'isi' => '<span id="inherent_level_label"><span style="background-color:' . $inherent_level['warna_action'] . ';color:' . $inherent_level['warna_text_action'] . ';">&nbsp;' . $inherent_level['inherent_analisis_action'] . '&nbsp;</span></span>' . form_hidden(['inherent_level' => ($data['detail']) ? $data['detail']['risk_level_action'] : 0])];

		// $data['realisasi'][] = ['show'=>true,'label' => 'Pelaksanaan Treatment', 'isi' => form_dropdown('pelaksana_no[]', $cbo_owner, ($data['detail']) ? json_decode($data['detail']['pelaksana_no'],true) : '', ' class="form-control select2" id="risk_control_assessment" multiple="multiple" style="width:100%;"')];
		// $data['realisasi'][] = ['show'=>true,'label' => 'Short Report', 'isi' => form_dropdown('notes', $cbo_status, ($data['detail']) ? $data['detail']['notes'] : '', ' class="form-control select2" id="notes" style="width:15%;"')];
		$data['realisasi'][] = ['show' => true, 'label' => 'Short Report', 'isi' => form_dropdown('status_no', $cbo_status, ($data['detail']) ? $data['detail']['status_no'] : '', ' class="form-control select2" id="status_no" style="width:130px;"')];

		$data['realisasi'][] = ['show' => true, 'label' => 'Data Loss Event', 'isi' =>
		form_textarea('keterangan',($data['detail']) ? $data['detail']['keterangan'] : '', "    id='keterangan'   maxlength='500' size=500 class='form-control' rows='2' cols='5'   style='overflow: hidden; width: 500 !important; height: 104px;'")];

			$data['realisasi'][] = ['show' => true, 'label' => 'Rencana Perlakuan Risiko', 'isi' =>
		form_textarea('perlakuan_risiko',($data['detail']) ? $data['detail']['perlakuan_risiko'] : '', "    id='perlakuan_risiko'   maxlength='500' size=500 class='form-control' rows='2' cols='5'   style='overflow: hidden; width: 500 !important; height: 104px;'")];

//  form_input('', ($data['detail']) ? $data['detail']['keterangan'] : '', 'class="form-control" style="width:100%;"')


// doi::dump()

		$data['realisasi'][] = ['show'=>true,'label' => 'Dampak Loss Event', 'isi' => '<div class="input-group"> <span id="span_l_amoun" class="input-group-addon"> Rp </span>'. form_input('damp_loss', ($data['detail'])? number_format($data['detail']['damp_loss']):'', 'class="form-control text-right" style="width:100%;" id="damp_loss" ') .'</div>'];

		$data['realisasi'][] = ['show' => true, 'label' => 'Attacment', 'isi' => form_upload("attach_realisasi", "")];

		$b = ($field) ? $field['create_date'] : '';
		$n1 = date_create($b, timezone_open('Asia/Jakarta'))->format('d-m-Y H:i:s');
		$data['realisasi'][] = ['show' => true, 'label' => 'Tanggal Monitoring', 'isi' => form_input('create_date', ($field) ? $n1 : '', " id='create_date' readonly='true' size='30' class='form-control' style='width:160px;'")];
		// $data['realisasi'][] = ['show' => true, 'label' => 'Realisasi KRI', 'isi' => form_input('kri', ($dataxkri) ? $dataxkri['realisasi'] : '', 'class="form-control" style="width:100%;" id="kri"')];

		$data['input_kri'] = $this->load->view('input_kri', $data, true);
		// doi::dump($data['detail']);
		$hasil['combo'] = $this->load->view('input_realisasi', $data, true);

		echo json_encode($hasil);
		// var_dump($hasil);
	}

	function simpan_mitigasi()
	{
		$post = $this->input->post();
		$id = $this->data->simpan_mitigasi($post);
		// doi::dump($post);
		// die();
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);

		$tab = 'Berhasil mengisi risk treatment, lanjutkan ke progress treatment ?';

		$this->session->set_flashdata('tab', $tab);
		$this->session->set_flashdata('done', 1);
		$this->session->set_flashdata('tabval', 'asasas');

		header('location:' . base_url($this->modul_name . '/tes/'));
		// $result['combo'] = $this->load->view('list-peristiwa', $data, true);
		// echo json_encode($result);
	}

	function update()
	{
		$bulan = $this->uri->segment($this->uri->total_segments());
		// $bulan = $this->uri->segment(2);
		$mode = $this->uri->segment(2);
		$id_rcsa = $this->uri->segment(4);
		// $id_edit = $this->input->post('edit');
		$id_edit = $this->uri->segment(3);
		// doi::dump($bulan);
		// if ($mode !== 'add') {
		// }
		$data['tema'] = $this->get_combo('library_t1');

		$data['bulan']= $bulan;
		$data['krii'] = $this->get_combo('data-combo', 'kri');
		$data['per_data'] = [0 => '-select-', 1 => 'Bulan', 2 => 'Triwulan', 3 => 'semester'];
		$data['satuan'] = $this->get_combo('data-combo', 'satuan');
		$data['kategori'] = $this->get_combo('data-combo', 'kel-library');
		$data['subkategori'] = $this->get_combo('data-combo', 'subkel-library');
		$data['area'] = $this->get_combo('parent-input');
		$data['rcsa_no'] = $id_rcsa;
		$data['np'] = $this->get_combo('negatif_poisitf');


		// $id_rcsa = $this->input->post('id');
		$data['parent'] = $this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->row_array();

		$rows = $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_RCSA_SASARAN)->result_array();
		$data['sasaran'] = ['- select -'];
		foreach ($rows as $row) {
			$data['sasaran'][$row['id']] = $row['sasaran'];
		}

		$couse = [];
		$impact = [];
		$detail = [];
		$sub = [];
		$event = [];
		if ($id_edit > 0) {
			// doi::dump($id_edit);

			$detail = $this->db->where('id', $id_edit)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
			if ($detail) {
				$disabled = 'disabled';
				$readonly = 'readonly="true"';
				$couse = json_decode($detail['risk_couse_no'], true);
				$couse_implode = implode(", ", $couse);
				$data['risk_couseno1'] = $couse_implode;
				$impect = json_decode($detail['risk_impact_no'], true);
				$impect_implode = implode(", ", $impect);
				$data['risk_impectno1'] = $impect_implode;

				$impact = json_decode($detail['risk_impact_no'], true);
				$impact_implode = implode(", ", $impact);

				$peristiwa = $this->db->where('id', $detail['event_no'])->where('status', 1)->order_by('description')->get(_TBL_LIBRARY)->result_array();
				$dtkri = $this->db->where('id', $detail['kri'])->get(_TBL_DATA_COMBO)->result_array();
			}


			$tblkri = '<table class="table peristiwa" id="tblkri"><tbody>';
			if ($peristiwa) :
				foreach ($dtkri as $key => $crs) :
					$tambah = '';
					$del = '';
					if ($key == 0) {
						$tambah = '  | <i class="fa fa-plus add-kri text-danger pointer"></i>';
						$del = 'del-event ';
					}
					$tblkri .= '<tr class="browse-kri"><td style="padding-left:0px;">' . form_textarea('kri[]', $crs['data'], " readonly='readonly'  id='kri' maxlength='500' size=500 class='form-control' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_input(['kri_no[]' => $id_rcsa]) . '</td><td class="text-center" width="10%"><i class="fa fa-search browse-kri text-primary pointer"></i>  </td></tr>';
				endforeach;
			else :
				$tblkri .= '<tr class="browse-kri"><td style="padding-left:0px;">' . form_textarea('kri[]', '', " readonly='readonly'  id='kri' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_input(['kri_no[]' => 0]) . '</td><td class="text-center"  width="10%"><i class="fa fa-search browse-event text-primary pointer"></i> </td></tr>';
			endif;
			$tblkri .= '</tbody></table>';


			$data['krii'] = $this->get_combo('data-combo', 'kri');
			$data['satuan'] = $this->get_combo('data-combo', 'satuan');
			$data['kategori'] = $this->get_combo('data-combo', 'kel-library');
			$data['subkategori'] = $this->get_combo('data-combo', 'subkel-library');
			$data['area'] = $this->get_combo('parent-input');
			$data['rcsa_no'] = $id_rcsa;
			$data['events'] = $event;
			$data['np'] = $this->get_combo('negatif_poisitf');


			$data['detail'] = $detail;
			$data['tblkri'] = $tblkri;
			$data['id_edit'] = $id_edit;
			$arrControl = json_decode($data['detail']['control_no'], true);
			//analisis
			$cboLike = $this->get_combo('likelihood');
			$cboImpact = $this->get_combo('impact');
			$cboTreatment = $this->get_combo('treatment');
			$cboTreatment1 = $this->get_combo('treatment1');
			$cboTreatment2 = $this->get_combo('treatment2');
			$cboRiskControl = $this->get_combo('data-combo', 'control-assesment');
			$inherent_level = $this->data->get_master_level(true, $data['detail']['inherent_level']);

			$residual_level = $this->data->get_master_level(true, $data['detail']['residual_level']);
			// var_dump($a);
			if (!$inherent_level) {
				$inherent_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
			}
			$a = $inherent_level['level_mapping'];

			if (!$residual_level) {
				$residual_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
			}

			$arl = $residual_level['level_mapping'];
			// doi::dump($residual_level);
			$data['inherent_level'] = $inherent_level;
			$data['residual_level'] = $residual_level;

			$cboControl = $this->db->where('status', 1)->get(_TBL_EXISTING_CONTROL)->result_array();
			$jml = intval(count($cboControl) / 2);
			$check = '';
			$i = 1;
			$control = array();
			$check .= '<div class="well p100">';
			if (is_array($arrControl))
				$control = $arrControl;
			foreach ($cboControl as $row) {
				if ($i == 1)
					$check .= '<div class="col-md-6">';

				$sts = false;
				foreach ($control as $ctrl) {
					if ($row['component'] == $ctrl) {
						$sts = true;
						break;
					}
				}

				$check .= '<label class="pointer">' . form_checkbox('check_item[]', $row['component'], $sts);
				$check .= '&nbsp;' . $row['component'] . '</label><br/>';
				if ($i == $jml)
					$check .= '</div><div class="col-md-6">';

				++$i;
			}
		}
		$check .= '</div>' . form_textarea("note_control", ($data['detail']) ? $data['detail']['note_control'] : '', ' class="form-control" style="width:100%;height:150px"' . $readonly) . '</div><br/>';


		$data['level_resiko'][] = ['label' => lang('msg_field_inherent_risk'), 'isi' => ' Kemungkinan : ' . form_dropdown('inherent_likelihood', $cboLike, ($data['detail']) ? $data['detail']['inherent_likelihood'] : '', ' class="form-control select2" id="inherent_likelihood" style="width:35%;"' . $disabled) . ' Dampak: ' . form_dropdown('inherent_impact', $cboImpact, ($data['detail']) ? $data['detail']['inherent_impact'] : '', ' class="form-control select2" id="inherent_impact" style="width:35%;"' . $disabled)];
		$data['level_resiko'][] = ['label' => lang('msg_field_inherent_level'), 'isi' => '<span id="inherent_level_label"><span style="background-color:' . $inherent_level['color'] . ';color:' . $inherent_level['color_text'] . ';">&nbsp;' . $inherent_level['level_mapping'] . '&nbsp;</span></span>' . form_hidden(['inherent_level' => ($data['detail']) ? $data['detail']['inherent_level'] : 0]) . form_hidden(['inherent_name' => ($data['detail']) ? $a : ''])];

		$data['level_resiko'][] = ['label' => lang('msg_field_existing_control'), 'isi' => $check];
		$data['level_resiko'][] = ['label' => lang('msg_field_risk_control_assessment'), 'isi' => form_dropdown('risk_control_assessment', $cboRiskControl, ($data['detail']) ? $data['detail']['risk_control_assessment'] : '', ' class="form-control select2" id="risk_control_assessment" style="width:100%;"' . $disabled)];
		
		$data['level_resiko'][] = ['label' => lang('msg_field_residual_risk'), 'isi' => ' Kemungkinan : ' . form_dropdown('residual_likelihood', $cboLike, ($data['detail']) ? $data['detail']['residual_likelihood'] : '', ' class="form-control select2" id="residual_likelihoodx" style="width:35%;"' . $disabled) . ' Dampak: ' . form_dropdown('residual_impact', $cboImpact, ($data['detail']) ? $data['detail']['residual_impact'] : '', ' class="form-control select2" id="residual_impactx" style="width:35%;"' . $disabled)];
		$data['level_resiko'][] = ['label' => lang('msg_field_residual_level'), 'isi' => '<span id="residual_level_label"><span style="background-color:' . $residual_level['color'] . ';color:' . $residual_level['color_text'] . ';">&nbsp;' . $residual_level['level_mapping'] . '&nbsp;</span></span>' . form_hidden(['residual_level' => ($data['detail']) ? $data['detail']['residual_level'] : 0]) . form_hidden(['residual_name' => ($data['detail']) ? $arl : ''])];

		if ($a == "Ekstrem") {
			$data['level_resiko'][] = ['label' => lang('msg_field_treatment'), 'isi' => form_dropdown('treatment_no', $cboTreatment1, ($data['detail']) ? $data['detail']['treatment_no'] : '', ' class="form-control select2" id="treatment_no" style="width:100%;"' . $disabled)];
		} elseif ($a == "Low") {
			$data['level_resiko'][] = ['label' => lang('msg_field_treatment'), 'isi' => form_dropdown('treatment_no', $cboTreatment2, ($data['detail']) ? $data['detail']['treatment_no'] : '', ' class="form-control select2" id="treatment_no" style="width:100%;"' . $disabled)];
		} else {
			$data['level_resiko'][] = ['label' => lang('msg_field_treatment'), 'isi' => form_dropdown('treatment_no', $cboTreatment, ($data['detail']) ? $data['detail']['treatment_no'] : '', ' class="form-control select2" id="treatment_no" style="width:100%;"' . $disabled)];
		}
		$action = $this->db->where('rcsa_detail_no', $id_edit)->get(_TBL_RCSA_ACTION)->row_array();
		$data['field'] = $action;
		$data['id_edit_mitigasi'] = $action['id'];

		// doi::dump($data);
		$data['cbo_owner'] = $this->get_combo('parent-input-all');
		$data['list_mitigasi'] = $this->load->view('input_mitigasi', $data, true);
		// $data['list_mitigasi'] = $this->load->view('input_mitigasi', $data, true);
		$data['area'] = $this->get_combo('parent-input');



		$data['realisasi'] = $this->data->get_realisasi($id_edit, $bulan);

		$data['list_realisasi'] = $this->load->view('list-realisasi', $data, true);
		$data['list_kri'] = $this->load->view('list_kri', $data, true);

		$data['cboper'] = $this->get_combo('library', 1);

		$cbogroup = $this->get_combo('library', 2);
		$data['cbogroup'] = $cbogroup;
		$data['inp_couse'] = form_input('', '', ' id="new_cause[]" name="new_cause[]" class="form-control" placeholder="Input Risk Couse Baru"' . $readonly);
		$data['lib_couse'] = form_dropdown('risk_couse_no[]', $cbogroup, '', 'class="form-control select2" id="risk_couseno');

		$cbogroup1 = $this->get_combo('library', 3);
		$data['cbogroup1'] = $cbogroup1;
		$data['inp_impact'] = form_input('', '', ' id="new_impact[]" name="new_impact[]" class="form-control" placeholder="Input Risk Impact Baru"' . $readonly);
		$data['cbbii'] = form_dropdown('new_impact_no[]', $cbogroup1, '', 'class="form-control select2"');


		//rapihin kodingan
		// $data['identi'][] = ['show' => true, 'label' => $this->required . 'Sasaran', 'isi' => form_dropdown('sasaran', $sasaran, ($detail) ? $detail['sasaran_no'] : '', ' class="form-control select2" id="sasaran" style="width:100%;   required' . $disabled)];



		$this->template->build('fom_peristiwa', $data);

		// echo json_encode($result);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */