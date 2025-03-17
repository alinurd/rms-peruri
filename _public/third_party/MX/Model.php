<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class MX_Model extends CI_Model
{

	protected $cbo_kategori;
	protected $module_name;
	protected $no_select = true;
	protected $id_param_owner;
	var $owner_child = array();
	protected $arr_officer = array();
	protected $arr_eksposure = array();

	public function __construct()
	{
		parent::__construct();
		$prefix = $this->db->dbprefix;

		$this->cbo_kategori = array();
		$this->id_param_owner = $this->authentication->get_info_user('group');

		$this->module_name = $this->router->fetch_module();
		$this->auth_config = $this->config->item('authentication');

		$this->cbo_kategori = array(0 => ' - Parent - ');
	}

	function get_combo_model($kel, $param = '', $param2 = '')
	{
		$query = "";
		$result = array();
		switch ($kel) {
			case "bulan":
				$query = array('' => lang('msg_cbo_select'), '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
				return $query;
				break;
			case "negatif_poisitf":
				$query = array('0' => lang('msg_cbo_select'), '1' => 'Negatif', '2' => 'Positif');
				return $query;
				break;
			case "tanggal":
				$query = array('' => lang('msg_cbo_select'));
				for ($num = 1; $num <= 31; $num++) {
					$query[$num] = $num;
				}
				return $query;

			case "bahasa":
				$query = "SELECT  `key` as id, title as name FROM " . _TBL_BAHASA . " where status=1 order by title";
				break;
			case "faktor-prioritas":
				$query = "SELECT  `key` as id, title as name FROM " . _TBL_BAHASA . " where status=1 order by title";
				break;
			case "bahasa_harian":
				$query = "SELECT  id, bahasa_harian as name FROM " . _TBL_BAHASA_HARIAN . " where aktif=1 order by urut";
				break;
			case "dashboard":
				$query = "SELECT  id, dashboard as name FROM " . _TBL_DASHBOARD . " order by dashboard";
				break;
			case "icon":
				$query = "SELECT  font as id, title as name FROM " . _TBL_FONT_ICON . " where status=1 order by title";
				break;
			case "periode":
				$query = "select id, periode_name as name from " . _TBL_PERIOD . " order by periode_name desc";
				break;
			case "investasi":
				$query = "select id, type as name from " . _TBL_JENIS_INVESTASI . " order by type desc";
				break;
			case "term":
				$query = "select id, term as name from " . _TBL_TERM . " where year(tgl_mulai)=" . date('Y') . " order by tgl_mulai";
				break;
			case "posisi-menu":
				$query = $this->auth_config['menu'];
				return $query;
				break;
			case "data-combo":
				$where = '';
 				if (is_array($param)) {
					$where = " and kelompok='" . $param[0] . "' and id='" . $param[1] . "'";
				} elseif (!empty($param)) {
					$where = " and kelompok='" . $param . "'";
				}
				$query = "SELECT  id, CASE WHEN kode='' THEN data ELSE concat(kode,'-',data) END as name FROM " . _TBL_DATA_COMBO . " where aktif='1' {$where} order by urut, data";
				break;
			case "tasktonimi":
				$where = '';
				if($param=='t1'){
					$tbl='library';
					$param=4;
				}elseif($param=='t2'){ 
					if($param2){
						$where = " and dc.pid='" . $param2 . "'";
					}
					$query = "SELECT bl.description, dc.id as id,   CONCAT(bl.description, ' - ', dc.data)   AS name FROM " . _TBL_DATA_COMBO . " AS dc JOIN bangga_library AS bl ON bl.id = dc.pid WHERE dc.aktif = '1' and dc.kelompok='kategori-risiko' {$where} ORDER BY dc.urut, dc.data";
 				}elseif($param=='t3'){
					if($param2){
						$where = " and dc.pid='" . $param2 . "'";
					}
 					$query = "SELECT bl.data, dc.id as id,  CONCAT(bl.data, ' - ', dc.data)  AS name FROM " . _TBL_DATA_COMBO . " AS dc JOIN " . _TBL_DATA_COMBO . " AS bl ON bl.id = dc.pid WHERE dc.aktif = '1' and dc.kelompok='kelompok-risiko' {$where} ORDER BY dc.urut, dc.data";
				}elseif($param=='t4'){
					$tbl='library';
					$param=1;
				}elseif($param[0]=='t5'){
					$where = "";
					if($param[1]){
						// $where = "where child_type='" . $param[1] . "'"; unComent kalo penyebab menggunakan data mapping
					}
					if($param[2]){
						// $where.= "and event_no='" . $param[2] . "'"; unComent kalo dampak menggunakan data mapping
					}
					$query = "SELECT  child_id as id, child_description as name FROM " . _TBL_VIEW_MAP_LIBRARY . " {$where} order by child_code";
				}else if($param=='kategori_risiko_loss'){
					if($param2){
						$where = " and dc.pid='" . $param2 . "'";
					}
 					$query = "SELECT dp.data, dc.id as id,  CONCAT(lib.description ,' - ', dp.data, ' - ', dc.data) AS name FROM " . _TBL_DATA_COMBO . " AS dc JOIN " . _TBL_DATA_COMBO . " dp ON dp.id = dc.pid JOIN bangga_library AS lib ON lib.id = dp.pid WHERE dc.aktif = '1' and dc.kelompok='kelompok-risiko' ORDER BY dc.urut, dc.data";
					//  doi::dump($this->db->last_query());
					//  die;
				}
				if($tbl=="library"){
					if($param2){
						$where = " and t3='" . $param2 . "'";
					}
					$query = "SELECT  id, description as name FROM " . _TBL_LIBRARY . " where status=1 and type={$param}  {$where} order by code";
				}else{
					if (is_array($param)) {
						$where = " and kelompok='" . $param[0] . "' and id='" . $param[1] . "'";
					} elseif (!empty($param)) {
						$where = " and kelompok='" . $param . "'";
					}
					
				}
				break;
			case 'accountable-input':
				$query = "select DISTINCT rcsa_owner_no as id, name from " . _TBL_VIEW_RCSA_MITIGASI . "  ";
				break;
			case 'risk-ishikawa':
				$query = "select DISTINCT sasaran as id, name from " . _TBL_VIEW_RCSA_DETAIL . "  ";
				break;
			case 'parent':
				$kategori = $this->get_combo_kategori();
				return $kategori;
				break;
			case 'parent-input':
				$kategori = $this->get_combo_kategori(1);
				return $kategori;
				break;
			case 'parent-x':
				$kategori = $this->get_combo_kategori(1);
				return $kategori;
				break;
			case 'parent-input-all':
				$kategori = $this->get_combo_kategori(1, true);
				return $kategori;
				break;
			case 'risk_tipe':
				$query = "select id, type as name from " . _TBL_RISK_TYPE . "";
				break;
			case 'likelihood':
			case 'impact':
				$query = "SELECT id, concat(code,' - ',level,' [ ', ifnull(bottom_value,''), ' < x <= ', ifnull(upper_value,''), ' ]') as name FROM " . _TBL_LEVEL . " WHERE category='{$kel}' and status=1 order by urut";
				break;
			case 'schedule':
				$query = "select id, type as name from " . _TBL_SCHEDULE_TYPE . "";
				break;
			case 'owner':
				$query = "select id, name  from " . _TBL_OWNER . " where status='1'";
				break;
			case 'treatment':
				$query = "select id, treatment as name from " . _TBL_TREATMENT . " where  status=1";
				break;
			case 'treatment1':
				$query = "select id, treatment as name from " . _TBL_TREATMENT . " where treatment != 'Accept'";
				break;
			case 'treatment2':
				$query = "select id, treatment as name from " . _TBL_TREATMENT . " where treatment != 'Avoid'";
				break;
			case 'rcsa':
				$query = "select id, corporate as name from " . _TBL_RCSA . " order by corporate";
				break;
			case 'rcsa_data':
				$query = "select id, judul_assesment as name from " . _TBL_RCSA . " order by judul_assesment";
				break;
			case 'rcsa_detail':
				$where = "rcsa_no='" . $param . "'";
				$query = "SELECT bangga_rcsa_detail.id, bangga_library.description AS name 
							  FROM bangga_rcsa_detail 
							  LEFT JOIN bangga_library ON bangga_library.id = bangga_rcsa_detail.event_no 
							  WHERE {$where}
							  ORDER BY description";
 				break;

			case 'judul_assesment':
				$query = "SELECT id, judul_assesment AS name 
							  FROM " . _TBL_RCSA . " 
							  WHERE judul_assesment IS NOT NULL 
							  AND judul_assesment != ''
							  ORDER BY judul_assesment";
				break;


			case 'judul_assesment_new':
				$where = " AND r.owner_no = '".$param."'";
				if ($param2 > 0) {
					$where .= " AND o.periode_name = '".$param2."'";
				}

				$query = "SELECT r.id, r.judul_assesment AS name,o.periode_name 
						FROM " . _TBL_RCSA . " AS r
						INNER JOIN " . _TBL_PERIOD . " AS o ON r.period_no = o.id
						WHERE r.judul_assesment IS NOT NULL 
						AND r.judul_assesment != '' {$where}
						ORDER BY r.judul_assesment";
				break;
			case 'officer':
				$query = "select id, officer_name as name from " . _TBL_OFFICER . "";
				break;
			case 'officer_approve':
				$query = "select id, nama_lengkap  as name from " . _TBL_USERS . " where aktif=1  ";
				break;
			case  "risk_type":
				$query = "SELECT  id, type as name FROM " . _TBL_RISK_TYPE . " where status=1 order by type";
				break;
			case  "yatidak":
				$type = array('ya' => 'Ya', 'tidak' => 'Tidak');
				return $type;
				break;
			case  "risk_type":
				$query = "SELECT  id, type as name FROM " . _TBL_RISK_TYPE . " where status=1 order by type";
				break;
			case  "posisi":
				$query = "SELECT  id, posisi as name FROM " . _TBL_POSISI . " where status=1 order by posisi";
				break;
			case  "groups":
				$query = "SELECT  id, group_name as name FROM " . _TBL_GROUPS . " where aktif=1 order by group_name";
				break;
			case  "level_mapping":
				$query = "SELECT  id, level_mapping as name FROM " . _TBL_LEVEL_MAPPING . " where status=1 order by urut";
				break;
			case  "project_rcsa":
				$owner_no = $param['owner_no'];
				$period_no = $param['period_no'];
				$query = "SELECT  id, corporate as name FROM " . _TBL_RCSA . " where owner_no={$owner_no} and period_no={$period_no} order by corporate";
				// die($query);
				break;
			case  "library":
				$where = '';
				if (!empty($param2)) {
					$where = $param2;
				}

				$query = "SELECT  id, description as name FROM " . _TBL_LIBRARY . " where status=1 and type={$param}  {$where} order by code";

				break;
			case  "library_t1":

				$query = "SELECT  id, description as name FROM " . _TBL_LIBRARY . " where status=1 and type=4 order by code";

				break; 
			case  "peristiwa":

				$query = "SELECT  id, description as name FROM " . _TBL_LIBRARY . " where status=1 and type=1 order by code";

				break;
			case  "status-action":
				$query = "SELECT  id, status_action as name FROM " . _TBL_STATUS_ACTION . " where status=1 order by status_action";
				break;
			case  "privilege-owner":
				$type = array(0 => '- Select -', 1 => 'All Data', 2 => 'Risk Owner', 3 => 'Project/Assesment');
				return $type;
				break;
			case  "type-project":
				if ($param) {
					$type = array('1' => 'Rutin', '2' => 'Project');
				} else {
					$type = array('0' => ' - Select - ', '1' => 'Rutin', '2' => 'Project');
				}
				return $type;
				break;
			case  "type-hiradc":
				if ($param) {
					$type = array('1' => 'HIRADC', '2' => 'IADL');
				} else {
					$type = array('0' => ' - Select - ', '1' => 'Rutin', '2' => 'Project');
				}
				return $type;
				break;
			case  "kelamin":
				$type = array('1' => 'Wanita', '2' => 'Pria');
				return $type;
				break;
			case  "aksi-tooltips":
				$type = array('1' => 'Mode List Data', '2' => 'Mode Input', '3' => 'Mode Tambah data', '4' => 'Mode Edit Data');
				return $type;
				break;
			case  "type-project-report":
				$type = array('1' => 'Rutin', '2' => 'Project', '3' => 'All Data');
				return $type;
				break;
			case "mimes":
				$mimes = array(
					'pdf'	=>	'application/pdf',
					'xls'	=>	'application/vnd.ms-excel',
					'ppt'	=>	'application/vnd.ms-powerpoint',
					'pptx'	=> 	'application/vnd.openxmlformats-officedocument.presentationml.presentation',
					'jpeg'	=>	'image/jpeg',
					'jpg'	=>	'image/jpg',
					'png'	=>	'image/png',
					'doc'	=>	'application/msword',
					'docx'	=>	'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
					'xlsx'	=>	'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
					'word'	=>	'application/msword'
				);
				return $mimes;
				break;
		}
		if (!empty($query))
			$result = $this->get_cbo($query);

		return $result;
	}

	function get_cbo($select)
	{
		$query = $select;

		$data = $this->db->query($query);

		$d = $data->result();

		if ($this->no_select)
			$combo[''] = lang('msg_cbo_select');
		else
			$combo = [];

		foreach ($d as $key => $dt) {
			$combo[$dt->id] = $dt->name;
		}
		return $combo;
	}

	function set_NoSelect($nil = false)
	{
		$this->no_select = $nil;
	}

	function get_combo_kategori($tipe = 0, $sts_all = false, $id = 0)
	{
		if ($tipe > 0) {
			$this->cbo_kategori = array();
		}
		// Doi::dump($this->id_param_owner);
		if (!is_array($this->id_param_owner)) {
			$this->cbo_kategori = array(0 => ' - Parent - ');
			$this->get_combo_parent($id, $sts_all);
		} elseif (is_array($this->id_param_owner)) {
			if ($this->id_param_owner['privilege_owner']['id'] > 1 && !$sts_all) {
				$this->level = array();
				$this->get_parent($this->id_param_owner['owner']['parent_no']);
				$space = str_repeat('&nbsp;', count($this->level) * 4);
				$this->cbo_kategori[$this->id_param_owner['owner']['owner_no']] = $space . $this->id_param_owner['owner']['owner_name'];
				$this->get_combo_parent($this->id_param_owner['owner']['owner_no'], $sts_all);
			} else {
				$this->cbo_kategori = array(0 => ' - Parent - ');
				$this->get_combo_parent(0, $sts_all);
			}
		} else {
			$this->cbo_kategori = array(0 => ' - Parent - ');
			$this->get_combo_parent(0, $sts_all);
		}

		// Doi::dump($this->cbo_kategori);
		// die();
		return $this->cbo_kategori;
	}

	function get_combo_parent($parent = 0, $sts_all = false)
	{
		$this->level = array();
		$this->db->select('*');
		$this->db->from(_TBL_OWNER);
		$this->db->where('status', 1);
		$this->db->where('parent_no', $parent);
		if (is_array($this->id_param_owner)) {
			if ($this->id_param_owner['privilege_owner']['id'] > 1 && !$sts_all) {
				$this->db->where_in('id', $this->id_param_owner['owner_child_array']);
			}
		}
		$this->db->order_by('name');
		$query = $this->db->get();
		$rows = $query->result();
		// Doi::dump($this->db->last_query());
		foreach ($rows as $row) {
			$this->level = array();
			$this->get_parent($row->parent_no);
			$space = str_repeat('&nbsp;', count($this->level) * 4);
			$this->cbo_kategori[$row->id] = $space . $row->name;
			$this->get_combo_parent($row->id, $sts_all);
		}
	}

	function get_parent($parent = 0)
	{
		$this->db->select('*');
		$this->db->from(_TBL_OWNER);
		$this->db->where('id', $parent);
		$this->db->where('status', 1);
		$this->db->order_by('name');
		$query = $this->db->get();
		$rows = $query->result();
		foreach ($rows as $row) {
			$this->level[] = $row->name;
			if ($row->parent_no > 0)
				$this->get_parent($row->parent_no);
		}
	}

	function data_judul_project($id)
	{
		$this->db->select(_TBL_RCSA . '.*,' . _TBL_OWNER . '.name,' . _TBL_PERIOD . '.periode_name');
		$this->db->from(_TBL_RCSA);
		$this->db->join(_TBL_OWNER, _TBL_OWNER . '.id=' . _TBL_RCSA . '.owner_no', 'left');
		$this->db->join(_TBL_PERIOD, _TBL_PERIOD . '.id=' . _TBL_RCSA . '.period_no', 'left');
		$this->db->where(_TBL_RCSA . '.id', $id);

		$query = $this->db->get();
		$result = $query->result_array();
		$hasil = "";
		foreach ($result as $row) {
			$hasil = 'Unit : ' . $row['name'] . ' | Periode : ' . $row['periode_name'] . ' - ' . $row['corporate'];
		}
		return $hasil;
	}

	function parent_child_owner($id)
	{
		$this->db->select(_TBL_RCSA . '.*,' . _TBL_OWNER . '.id as id_owners,' . _TBL_OWNER . '.name,' . _TBL_PERIOD . '.periode_name');
		$this->db->from(_TBL_RCSA);
		$this->db->join(_TBL_OWNER, _TBL_OWNER . '.id=' . _TBL_RCSA . '.owner_no', 'left');
		$this->db->join(_TBL_PERIOD, _TBL_PERIOD . '.id=' . _TBL_RCSA . '.period_no', 'left');
		$this->db->where(_TBL_RCSA . '.id', $id);

		$query = $this->db->get();
		$result = $query->result_array();
		return $result[0]['id_owners'];
	}

	function cbo_level_impact_baru($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get(_TBL_RCSA);
		$rows = $query->row();
		$target_laba = 0;
		if ($rows) {
			$target_laba = $rows->target_laba;
		}

		$this->db->where('category', 'impact');
		$query = $this->db->get(_TBL_LEVEL);
		$rows = $query->result();

		$combo = array();
		$combo[0] = " - select - ";
		foreach ($rows as $key => $row) {
			$awal = (intval($row->bottom_value) / 100) * $target_laba;
			$akhir = (intval($row->upper_value) / 100) * $target_laba;

			$awal = $this->format_angka($awal);
			$akhir = $this->format_angka($akhir);
			$combo[$row->id] = $row->level; // . '(('. $awal . ' s/d ' . $akhir .'))';
		}

		return $combo;
	}

	function format_angka($nil)
	{
		if ($nil == 0) {
			$result = 0;
		} elseif ($nil < 1000000) {
			$nil = $nil / 100000;
			$result = round($nil) . ' rb';
		} elseif ($nil < 1000000000) {
			$nil = $nil / 1000000;
			$result = round($nil) . ' jt';
		} elseif ($nil < 1000000000000) {
			$nil = $nil / 1000000000;
			$result = round($nil) . ' mlr';
		} else {
			$nil = $nil / 1000000000000;
			$result = round($nil) . ' tr';
		}

		return $result;
	}

	function get_owner_child($id)
	{
		$this->db->select('*');
		$this->db->from(_TBL_OWNER);
		$this->db->where('parent_no', $id);
		$this->db->where('status', 1);

		$sql = $this->db->get();
		$rows = $sql->result();
		foreach ($rows as $key => $row) {
			$this->get_owner_child($row->id);
			$this->owner_child[] = $row->id;
		}
	}

	function cari_code_library($data, $tipe)
	{
		$no = $tipe;
		$key = intval($data['l_risk_type_no']);
		$sql = $this->db->query("select * from " . _TBL_RISK_TYPE . " where id={$key}");
		$rows = $sql->row();
		$code = '';
		if ($rows) {
			$code = $rows->code;
		}
		$arr_risk_type = array();

		// $sql="select a.id, b.code from "._TBL_LIBRARY." a left join "._TBL_RISK_TYPE." b on a.risk_type_no=b.id where a.type='{$no}' and a.risk_type_no='{$key}'";
		// $query=$this->db->query($sql);
		// $rows = $query->result_array();
		// $no_urut=count($rows);
		// $no_new = str_pad($no_urut,4,'0', STR_PAD_LEFT);
		// $code = strtoupper($code).$no_new;

		$sql = "select MAX(code) AS max_code from " . _TBL_LIBRARY . "";
		$query = $this->db->query($sql);
		$rows = $query->row_array();
		$code = intval($rows['max_code'] + 1);

		return $code;
	}

	function set_officer_data()
	{

		$this->db->select('*');
		$this->db->from(_TBL_OFFICER);
		$this->db->where('sts_owner', 1);
		$this->db->order_by('owner_no');
		$query = $this->db->get();
		$rows = $query->result_array();
		$this->arr_officer = array();
		foreach ($rows as $pht) {
			$this->arr_officer[$pht['owner_no']] = $pht;
		}
	}

	function get_officer_data()
	{
		return $this->arr_officer;
	}

	function get_eksposure_data($id)
	{
		$this->owner_child = array();
		$this->owner_child[] = $id;
		$this->get_owner_child($id);

		$sql = $this->db->query("select * from " . _TBL_OFFICER . " where category='likelihood' order by bottom_value");
		$rows = $sql->result_array();
		$arr_level_like = array();
		foreach ($rows as $row) {
			$arr_level_like[$row['id']] = $row;
		}

		$sql = $this->db->query("select * from " . _TBL_OFFICER . " where category='impact' order by bottom_value");
		$rows = $sql->result_array();
		$arr_level_impact = array();
		foreach ($rows as $row) {
			$arr_level_impact[$row['id']] = $row;
		}

		$this->db->select('ifnull(sum(rata_inherent_exposure),0) as inherent, ifnull(sum(rata_residual_exposure),0) as residual, ifnull(sum(rata_nil_dampak),0) as dampak, ifnull(sum(target_laba),0) as target_laba');
		$this->db->from(_TBL_RCSA);
		$this->db->where_in('owner_no', $this->owner_child);
		$query = $this->db->get();
		$rows = $query->result();
		foreach ($rows as &$row) {
			// Doi::dump($row);die();
			$like_value_inherent = 0;
			$like_value_residual = 0;
			if ($row->dampak > 0) {
				$like_value_inherent = $row->inherent / $row->dampak * 100;
				$like_value_residual = $row->residual / $row->dampak * 100;
			}
			$level_like_inherent = 0;
			foreach ($arr_level_like as $key_like => $like) {
				if ($like_value_inherent >= $like['bottom_value'] && $like_value_inherent < $like['upper_value']) {
					$level_like_inherent = $key_like;
					break;
				}
			}
			$level_like_residual = 0;
			foreach ($arr_level_like as $key_like => $like) {
				if ($like_value_residual >= $like['bottom_value'] && $like_value_residual < $like['upper_value']) {
					$level_like_residual = $key_like;
					break;
				}
			}


			$level_impact_inherent = 0;
			foreach ($arr_level_impact as $key_like => $like) {
				if ($row->inherent >= ($row->target_laba * ($like['bottom_value'] / 100)) && $row->inherent < ($row->target_laba * ($like['upper_value'] / 100))) {
					$level_impact_inherent = $key_like - 5;
					break;
				}
			}
			$level_impact_residual = 0;
			foreach ($arr_level_impact as $key_like => $like) {
				if ($row->residual >= ($row->target_laba * ($like['bottom_value'] / 100)) && $row->residual < ($row->target_laba * ($like['upper_value'] / 100))) {
					$level_impact_residual = $key_like;
					break;
				}
			}

			$row->inherent_level_likehood = $level_like_inherent;
			$row->residual_level_likehood = $level_like_residual;
			$row->inherent_level_impact = $level_impact_inherent;
			$row->residual_level_impact = $level_impact_residual;
		}
		unset($row);
		// die($this->db->last_query());
		return $rows[0];
	}

	function get_owner_data($id)
	{
		$photo = '';
		$name = '';
		$nip = '';
		$inherent = 0;
		$residual = 0;

		$query = $this->db->select('*')->get_where('owner', array('id' => $id, 'status' => 1));
		$rows = $query->result_array();
		foreach ($rows as &$row) {
			$this->parent_no = $row['id'];
			if (array_key_exists($row['id'], $this->arr_officer)) {
				$photo = $this->arr_officer[$row['id']]['photo'];
				$name = $this->arr_officer[$row['id']]['officer_name'];
				$nip = $this->arr_officer[$row['id']]['nip'];
			}

			$eksposure = $this->get_eksposure_data($row['id']);
			$inherent = $eksposure->inherent;
			$residual = $eksposure->residual;

			$row['photo'] = show_image($photo, 160, 100);
			$row['person_name'] = $name;
			$row['nip'] = $nip;
			$row['inherent'] = $inherent;
			$row['residual'] = $residual;
			// $this->arr_parent = $row;
		}
		unset($row);
		if ($rows) {
			return $rows[0];
		}
	}

	function draw_hiradc($data)
	{
		$content = '<center><table style="text-align:center;">';
		$no = 0;
		$noTd = 1;
		foreach ($data as $key => $row) {
			++$no;
			$nilai = (!empty($row['nilai'])) ? $row['nilai'] : "";
			if ($key == 0) {
				$content .= '<tr><td rowspan="5" class="text-center"><img width="25" src="' . img_url('severity.jpg') . '"></td><td style="padding:13px;min-width:55px;">' . $noTd . '</td>';
			}
			$content .= '<td data-id="' . $row['id'] . '" class="pointer peta" style="background-color:' . $row['warna_bg'] . ';color:' . $row['warna_txt'] . ';padding:33px;border:solid 1px black;min-width:45px; font-size:16px; font-weight:bold;" data-toggle = "popover" data-placement="top" data-html="true" data-content="<strong>' . $row['tingkat'] . '</strong><br/>Standar Nilai : ' . number_format($row['score'], 1) . '" data-nilai="' . $nilai . '">' . $nilai . '</td>';
			if ($no % 5 == 0 && $key < 24) {
				++$noTd;
				$content .= '</tr><tr><td class="td-nomor-v" style="padding:13px;">' . $noTd . '</td>';
			}
		}
		$content .= '<tr><td></td><td></td>';
		for ($x = 1; $x <= 5; ++$x) {
			$content .= '<td style="padding:13px;">' . $x . '</td>';
		}
		$content .= '</tr><tr><td></td><td></td><td colspan="5" class="text-center"><img src="' . img_url('probability.jpg') . '" width="110"></td></tr>';
		$content .= '</table><br/>&nbsp;';
		$content .= '<div class="row"><div class="col-md-12" id="detail_map"></div></div>';
		return $content;
	}

	// Fungsi untuk mencari data berdasarkan like_no dan impact_no
	function find_data($data, $like_no, $impact_no)
	{
		foreach ($data as $item) {
			if ($item['like_no'] == $like_no && $item['impact_no'] == $impact_no) {
				return $item;
			}
		}
		return null;
	}

	function draw_rcsa($data, $type = 'inherent')
	{

		$like 				= $this->db->where('category', 'likelihood')->order_by('code', 'desc')->get(_TBL_LEVEL)->result_array();
		$impact 			= $this->db->where('category', 'impact')->order_by('code', 'asc')->get(_TBL_LEVEL)->result_array();
		$abjad 				= ['E', 'D', 'C', 'B', 'A'];
		$fixed_size 	= 60;
    $table_width 	= 100;

		// Mulai membuat tabel
    $content = '<center><table style="padding:0px !important; text-align:center; border-collapse: collapse; width: ' . $table_width . '%; font-size: 12px; border="0">';

    // Header tabel
    $content .= '
    <tr>
        <td style="width: ' . $fixed_size . 'px; height: ' . $fixed_size . 'px;"></td>
        <td colspan="' . count($impact) . '" style="text-align:center; font-weight:bold; padding:5px; font-size:14px;">' . $type . ' Risk</td>
    </tr>';

		// Baris tingkat kemungkinan
		foreach ($like as $index => $row_l) {

			$code_abjad = $abjad[$index] ?? $row_l['code'];
			$content .= '<tr>';

			$content .= sprintf(
					'<td style="text-align: %s; font-weight: bolder; color: black; font-size: 8px; width: %dpx; height: %dpx; aspect-ratio: 1; %s">%s<br>%s</td>',
					 "center",
						$fixed_size, // Lebar sel
						$fixed_size, // Tinggi sel
					 "", 
					 $row_l['level'],
					$code_abjad // Konten kode abjad
			);
					// Kolom tingkat dampak
			foreach ($impact as $row_i) {
				$like_no 			= $row_l['id'];
				$impact_no 		= $row_i['id'];
				$item_data 		= $this->find_data($data, $like_no, $impact_no);
				$score 				= $this->db->where('impact', $item_data['impact_no'])->where('likelihood', $item_data['like_no'])->get(_TBL_LEVEL_COLOR)->row_array();
				$nilai 				= $item_data['nilai'] ?? '';
				$warna_bg 		= $item_data['warna_bg'] ?? '#ffffff';
				$warna_txt 		= $item_data['warna_txt'] ?? '#000000';
				$tingkat			= $item_data['tingkat'] ?? '';
				$bawah_impact = $item_data['bawah_impact'] ?? '';
				$atas_impact 	= $item_data['atas_impact'] ?? '';
				$bawah_like 	= $item_data['bawah_like'] ?? '';
				$atas_like 		= $item_data['atas_like'] ?? '';

				$content .= '
					<td data-id="' . $row_i['id'] . '" 
					class="pointer peta" 
					onclick="hoho(this)" 
					style="position: relative; 
						background-color:' . $warna_bg . '; 
						color:' . $warna_txt . '; 
						width: '.$fixed_size.'px !important; 
						height: '.$fixed_size.'px !important; 
						padding: 5px; 
						border: 1px solid white; 
						font-size: 10px; 
						font-weight: bold; 
						text-align: center; 
						vertical-align: middle;"
					data-toggle="popover"
					data-placement="top"
					data-html="true"
					data-content="<strong>'.$tingkat.'</strong><br/>Standar Nilai :<br/>Impact: [ >= '.$bawah_impact.' s.d <= '.$atas_impact.']<br/>Likelihood: [ >='.$bawah_like.' s.d <= '.$atas_like.']"
					data-nilai="'.$nilai.'"
					data-kel="'.$type.'"
					data-like="'.$item_data['like_no'].'"
					data-impact="'.$item_data['impact_no'].'"
				>
				
					<div style="max-height: 60px; overflow: auto; cursor: pointer;">
					<span class="badge rounded-pill" style="border: solid 0px #000; background-color: #3d004f; z-index: 1; position: relative; font-size:10px; margin: 3px;padding:3px;" data-norut=' . trim($nilai) . '>' . trim($nilai) . '</span>
					</div>
					<div style="position: absolute; bottom: 2px; left: 2px; font-size: 8px; font-weight: normal; color: #555;">
						<strong style="font-weight:900;">' . $score['score'] . '</strong>
					</div>
					
				</td>';

			}

			// <!-- Score di pojok kiri bawah -->
			$content .= '</tr>';
		}

		// Footer tabel untuk kode dampak
    $content .= '<tr><td style="width: ' . $fixed_size . 'px; height: 20px;"></td>';
    foreach ($impact as $row_i) {
        $content .= '<td style="text-align:center; font-size:8px; font-weight:bold; color:black; width: ' . $fixed_size . 'px; height: 20px;">' . $row_i['code'] . '</td>';
    }
    $content .= '</tr>';

    // Footer tabel untuk level dampak
    $content .= '<tr><td style="width: ' . $fixed_size . 'px; height: 30px;"></td>';
    foreach ($impact as $row_i) {
        $content .= '<td style="padding:0px !important; transform: rotate(-50deg); text-align:center; font-size:8px; font-weight:bold; color:black; width: ' . $fixed_size . 'px; height: 30px;">' 
                    . $row_i['level']
                    . '</td>';
    }
    $content .= '</tr>';

    // Footer utama untuk judul "Tingkatan Dampak"
    $content .= sprintf(
        '<tr><td style="width: ' . $fixed_size . 'px; height: ' . $fixed_size . 'px;"></td><td></td><td class="text-primary" colspan="%d" style="text-align:center; font-weight:bold; padding:5px;"> </td></tr>',
        count($impact)
    );
	
		// Menutup tabel
		$content .= '</table></center>';

		return $content;
	}



	function draw_rcsa_res($data, $type = 'residual')
	{
		$like 	= $this->db->where('category', 'likelihood')->order_by('code', 'desc')->get(_TBL_LEVEL)->result_array();
		$impact = $this->db->where('category', 'impact')->order_by('code', 'asc')->get(_TBL_LEVEL)->result_array();
		$abjad 	= ['E', 'D', 'C', 'B', 'A']; // Daftar abjad untuk menggantikan kode tingkat kemungkinan

		// Fungsi untuk mencari data berdasarkan like_no dan impact_no
		function find_data_res($data, $like_no, $impact_no)
		{
			foreach ($data as $item) {
				if ($item['like_no'] == $like_no && $item['impact_no'] == $impact_no) {
					return $item;
				}
			}
			return null;
		}

		$fixed_size 	= 60;
    $table_width 	= 100;

		// Mulai membuat tabel
    $content = '<center><table style="padding:0px !important; text-align:center; border-collapse: collapse; width: ' . $table_width . '%; font-size: 12px; border="0">';

    // Header tabel
    $content .= '
    <tr>
        <td style="width: ' . $fixed_size . 'px; height: ' . $fixed_size . 'px;"></td>
        <td colspan="' . count($impact) . '" style="text-align:center; font-weight:bold; padding:5px; font-size:14px;">' . $type . ' Risk</td>
    </tr>';

		
		// Baris tingkat kemungkinan
		foreach ($like as $index => $row_l) {
			$code_abjad = $abjad[$index] ?? $row_l['code'];
			$content .= '<tr>';

			$content .= sprintf(
				'<td style="text-align: %s; font-weight: bolder; color: black; font-size: 8px; width: %dpx; height: %dpx; aspect-ratio: 1; %s">%s<br>%s</td>',
				 "right",
					$fixed_size, // Lebar sel
					$fixed_size, // Tinggi sel
				 "padding-right: 5px !important;", 
				 "",
				$code_abjad // Konten kode abjad
		);

			// Kolom tingkat dampak
			foreach ($impact as $row_i) {
				$like_no 			= $row_l['id'];
				$impact_no 		= $row_i['id'];
				$item_data 		= find_data_res($data, $like_no, $impact_no);
				$score 				= $this->db->where('impact', $item_data['impact_no'])->where('likelihood', $item_data['like_no'])->get(_TBL_LEVEL_COLOR)->row_array();
				$nilai 				= $item_data['nilai'] ?? '';
				$warna_bg 		= $item_data['warna_bg'] ?? '#ffffff';
				$warna_txt 		= $item_data['warna_txt'] ?? '#000000';
				$tingkat			= $item_data['tingkat'] ?? '';
				$bawah_impact = $item_data['bawah_impact'] ?? '';
				$atas_impact 	= $item_data['atas_impact'] ?? '';
				$bawah_like 	= $item_data['bawah_like'] ?? '';
				$atas_like 	= $item_data['atas_like'] ?? '';

				$content .= '
					<td data-id="' . $row_i['id'] . '" 
								class="pointer peta" onclick="hoho(this)" 
								style="position: relative; background-color:' . $warna_bg . '; 
								color:' . $warna_txt . '; 
								width: '.$fixed_size.'px !important; 
								height: '.$fixed_size.'px !important; 
								padding: 5px; 
								border: 1px solid white; 
								font-size: 10px; 
								font-weight: bold; 
								text-align: center; 
								vertical-align: middle;"
								data-toggle="popover"
								data-placement="top"
								data-html="true"
								data-content="<strong>'.$tingkat.'</strong><br/>Standar Nilai :<br/>Impact: [ >= '.$bawah_impact.' s.d <= '.$atas_impact.']<br/>Likelihood: [ >='.$bawah_like.' s.d <= '.$atas_like.']"
								data-nilai="'.$nilai.'"
								data-kel="'.$type.'"
								data-like="'.$item_data['like_no'].'"
								data-impact="'.$item_data['impact_no'].'"
								>
						<div style="max-height: 60px; overflow: auto; cursor: pointer;">
					<span class="badge rounded-pill" style="border: solid 0px #000; background-color: #3d004f; z-index: 1; position: relative; font-size:10px; margin: 3px;padding:3px;" data-norut=' . trim($nilai) . '>' . trim($nilai) . '</span>
					</div>
						<div style="position: absolute; bottom: 2px; left: 2px; font-size: 8px; font-weight: normal; color: #555;">
						<strong style="font-weight:900;">' . $score['score'] . '</strong>
					</div>
					</td>';
			}

			$content .= '</tr>';
		}

		// Footer tabel untuk kode dampak
    $content .= '<tr><td style="width: ' . $fixed_size . 'px; height: 20px;"></td>';
    foreach ($impact as $row_i) {
        $content .= '<td style="text-align:center; font-size:8px; font-weight:bold; color:black; width: ' . $fixed_size . 'px; height: 20px;">' . $row_i['code'] . '</td>';
    }
    $content .= '</tr>';

    // Footer tabel untuk level dampak
    $content .= '<tr><td style="width: ' . $fixed_size . 'px; height: 30px;"></td>';
    foreach ($impact as $row_i) {
        $content .= '<td style="padding:0px !important; transform: rotate(-50deg); text-align:center; font-size:8px; font-weight:bold; color:black; width: ' . $fixed_size . 'px; height: 30px;">' 
                    . $row_i['level']
                    . '</td>';
    }
    $content .= '</tr>';

    // Footer utama untuk judul "Tingkatan Dampak"
    $content .= sprintf(
        '<tr><td style="width: ' . $fixed_size . 'px; height: ' . $fixed_size . 'px;"></td><td></td><td class="text-primary" colspan="%d" style="text-align:center; font-weight:bold; padding:5px;"> </td></tr>',
        count($impact)
    );

		// Menutup tabel
		$content .= '</table></center>';

		return $content;
	}

	// Fungsi global untuk mencari data berdasarkan like_no dan impact_no

    function find_data_target($data, $like_no, $impact_no) {
        foreach ($data as $item) {
            if ($item['like_no'] == $like_no && $item['impact_no'] == $impact_no) {
                return $item;
            }
        }
        return null;
    }


	function draw_rcsa1($data, $type = 'inherent')
	{
		// Mengambil data 'likelihood' dan 'impact' dari database

		$like = $this->db->where('category', 'likelihood')->order_by('code', 'desc')->get(_TBL_LEVEL)->result_array();
		$impact = $this->db->where('category', 'impact')->order_by('code', 'asc')->get(_TBL_LEVEL)->result_array();
		$abjad = ['E', 'D', 'C', 'B', 'A']; // Daftar abjad untuk menggantikan kode tingkat kemungkinan

		$fixed_size 	= 60;
    $table_width 	= 100;

		// Mulai membuat tabel
    $content = '<center><table style="padding:0px !important; text-align:center; border-collapse: collapse; width: ' . $table_width . '%; font-size: 12px; border="0">';

    // Header tabel
    $content .= '
    <tr>
        <td style="width: ' . $fixed_size . 'px; height: ' . $fixed_size . 'px;"></td>
        <td colspan="' . count($impact) . '" style="text-align:center; font-weight:bold; padding:5px; font-size:14px;">' . $type . ' Risk</td>
    </tr>';

		// Baris tingkat kemungkinan
		foreach ($like as $index => $row_l) {
			$code_abjad = $abjad[$index] ?? $row_l['code'];
			$content .= '<tr>';

			$content .= sprintf(
				'<td style="text-align: %s; font-weight: bolder; color: black; font-size: 8px; width: %dpx; height: %dpx; aspect-ratio: 1; %s">%s<br>%s</td>',
				 "right",
					$fixed_size, // Lebar sel
					$fixed_size, // Tinggi sel
				 "padding-right: 5px !important;", 
				 "",
				$code_abjad // Konten kode abjad
			);

			// Kolom tingkat dampak
			foreach ($impact as $row_i) {
				$like_no = $row_l['id'];
				$impact_no = $row_i['id'];

				// Mencari data target
				$item_data = $this->find_data_target($data, $like_no, $impact_no);
				$score 	= $this->db->where('impact', $item_data['impact_no'])->where('likelihood', $item_data['like_no'])->get(_TBL_LEVEL_COLOR)->row_array();
				// doi::dump($data);

				// Data default jika tidak ditemukan
				// $score = $item_data['code_likelihood'] . ' - ' . $item_data['code_impact'] ?? '';
				$nilai = $item_data['nilai'] ?? '';
				$warna_bg = $item_data['warna_bg'] ?? '#ffffff';
				$warna_txt = $item_data['warna_txt'] ?? '#000000';
				$tingkat = $item_data['tingkat'] ?? '';
				$bawah_impact = $item_data['bawah_impact'] ?? '';
				$atas_impact = $item_data['atas_impact'] ?? '';
				$bawah_like = $item_data['bawah_like'] ?? '';
				$atas_like = $item_data['atas_like'] ?? '';

				$content .= '
					<td data-id="' . $row_i['id'] . '" 
						class="pointer peta" onclick="hoho(this)" 
						style="position: relative; background-color:' . $warna_bg . '; 
								color:' . $warna_txt . '; 
								width: '.$fixed_size.'px !important; 
								height: '.$fixed_size.'px !important;
								padding: 5px; 
								border: 1px solid white; 
								font-size: 10px; 
								font-weight: bold; 
								text-align: center; 
								vertical-align: middle;"
								data-toggle="popover"
								data-placement="top"
								data-html="true"
								data-content="<strong>' . $tingkat . '</strong><br/>Standar Nilai :<br/>Impact: [ >= ' . $bawah_impact . ' s.d <= ' . $atas_impact . ']<br/>Likelihood: [ >=' . $bawah_like . ' s.d <= ' . $atas_like . ']"
								data-nilai="' . $nilai . '"
								data-kel="' . $type . '"
								data-like="' . $item_data['like_no'] . '"
								data-impact="' . $item_data['impact_no'] . '"
								>
					<div style="max-height: 60px; overflow: auto; cursor: pointer;">
					<span class="badge rounded-pill" style="border: solid 0px #000; background-color: #3d004f; z-index: 1; position: relative; font-size:10px; margin: 3px;padding:3px;" data-norut=' . trim($nilai) . '>' . trim($nilai) . '</span>
					</div>
						<div style="position: absolute; bottom: 2px; left: 2px; font-size: 8px; font-weight: normal; color: #555;">
						<strong style="font-weight:900;">' . $score['score'] . '</strong>
					</div>
					</td>';
			}

			$content .= '</tr>';
		}

		// Footer tabel untuk kode dampak
		$content .= '<tr><td style="width: ' . $fixed_size . 'px; height: 20px;"></td>';
		foreach ($impact as $row_i) {
				$content .= '<td style="text-align:center; font-size:8px; font-weight:bold; color:black; width: ' . $fixed_size . 'px; height: 20px;">' . $row_i['code'] . '</td>';
		}
		$content .= '</tr>';

		// Footer tabel untuk level dampak
		$content .= '<tr><td style="width: ' . $fixed_size . 'px; height: 30px;"></td>';
		foreach ($impact as $row_i) {
				$content .= '<td style="padding:0px !important; transform: rotate(-50deg); text-align:center; font-size:8px; font-weight:bold; color:black; width: ' . $fixed_size . 'px; height: 30px;">' 
										. $row_i['level']
										. '</td>';
		}
		$content .= '</tr>';

		// Footer utama untuk judul "Tingkatan Dampak"
		$content .= sprintf(
				'<tr><td style="width: ' . $fixed_size . 'px; height: ' . $fixed_size . 'px;"></td><td></td><td class="text-primary" colspan="%d" style="text-align:center; font-weight:bold; padding:5px;"> </td></tr>',
				count($impact)
		);

		// Menutup tabel
		$content .= '</table></center>';

		return $content;
	}

	function draw_rcsa_unit_1map($data, $type = 'inherent')
	{ 
 		$like = $this->db->where('category', 'likelihood')->order_by('code', 'desc')->get(_TBL_LEVEL)->result_array();
		$impact = $this->db->where('category', 'impact')->order_by('code', 'asc')->get(_TBL_LEVEL)->result_array();
		$abjad = ['E', 'D', 'C', 'B', 'A'];

 		$content = '<center><table style="text-align:center; border-collapse: collapse;   font-size: 12px;" border="0">';

 		$content .= '
			<tr>
				<td></td><td></td>
				<td colspan="5" style="text-align:center; font-weight:bold; padding:5px; font-size:14px;">Top Risk</td>
			</tr>';
 
		$content .= '<tr>';
		$content .= '<td class="text-primary" rowspan="' . (count($like) + 1) . '" style="text-align:center; font-weight:bold;   padding-right:100px; height: 100px;  ">
						 
					</td>';
		$content .= '</tr>';

 		foreach ($like as $index => $row_l) {
			$code_abjad = $abjad[$index] ?? $row_l['code'];
			$content .= '<tr>';
			$content .= sprintf(
				'<td style="text-align:center; font-weight:bolder; color:black;   font-size:10px; height: 40px;">%s<br>%s</td>',
				$row_l['level'],
				$code_abjad
			);

			foreach ($impact as $row_i) {
				$like_no = $row_l['id'];
				$impact_no = $row_i['id'];
				$item_data = $this->find_data_target($data, $like_no, $impact_no);
				$score = $this->db->where('impact', $item_data['impact_no'])
								  ->where('likelihood', $item_data['like_no'])
								  ->get(_TBL_LEVEL_COLOR)
								  ->row_array();
			
				$nilai_1 = $item_data['nilai_1'] ?? '';
				$nilai_2 = $item_data['nilai_2'] ?? '';
				$nilai_3 = $item_data['nilai_3'] ?? '';
				$warna_bg = $item_data['warna_bg'] ?? '#ffffff';
				$warna_txt = $item_data['warna_txt'] ?? '#000000';
				$tingkat = $item_data['tingkat'] ?? '';
				$bawah_impact = $item_data['bawah_impact'] ?? '';
				$atas_impact = $item_data['atas_impact'] ?? '';
				$bawah_like = $item_data['bawah_like'] ?? '';
				$atas_like = $item_data['atas_like'] ?? '';
				 
				$arrNorut1 = explode(", ", $nilai_1);
				$val1 = '';
				foreach ($arrNorut1 as $n) {
					$val1 .= '<span class="currentMap badge rounded-pill" style="border: solid 0px #000;background-color: #3d004f ; z-index: 1; position: relative; font-size:16px;" data-norut=' . trim($n) . '>' . trim($n) . '</span> ';
				}

				$arrNorut2 = explode(", ", $nilai_2);
				$val2 = '';
				foreach ($arrNorut2 as $n) {
					$val2 .= '<span   class="inherentMap badge rounded-pill" style="border: solid 0px #000;background-color: #97beac  ; z-index: 1; position: relative; font-size:16px;"data-norut=' . trim($n) . '>' . trim($n) . '</span> ';
				}

				$arrNorut3 = explode(", ", $nilai_3);
				$val3 = ''; 
				foreach ($arrNorut3 as $n) {
					$val3 .= '<span   class="residualMap badge rounded-pill" style="border: solid 0px #000;background-color:#00d3ac; z-index: 1; position: relative; font-size:16px;" data-norut=' . trim($n) . '>' . trim($n) . '</span> ';
				}
			
				$content .= '
					<td data-id="' . $row_i['id'] . '" 
						class="pointer peta" onclick="hoho(this)" 
						style="position: relative; background-color:' . $warna_bg . '; 
							   color:' . $warna_txt . '; 
							   width: 150px; 
							   height: 130px;  
							   border: 1px solid white; 
							   font-size: 15px; 
							   font-weight: bold; 
							   text-align: center; 
							   vertical-align: middle;"
						data-toggle="popover"
						data-placement="top"
						data-html="true"
						data-content="<strong>' . $tingkat . '</strong><br/>Standar Nilai :<br/>Impact: [ >= ' . $bawah_impact . ' s.d <= ' . $atas_impact . ']<br/>Likelihood: [ >= ' . $bawah_like . ' s.d <= ' . $atas_like . ']"
 						data-kel="' . $type . '"
						data-like="' . $item_data['like_no'] . '"
						data-impact="' . $item_data['impact_no'] . '"
					>
						' . $val1 . ' <br> 
						' . $val2 . ' <br> 
						' . $val3 . '  
						<div style="width:10px; margin:2px;position: absolute; top: 2px; font-size: 10px; font-weight: normal; color: #555;">
							<strong style="font-weight:900;">' . $score['score'] . '</strong>
						</div>
					</td>';
			}
			

			$content .= '</tr>';
		}

		// Footer tabel untuk kode dampak
		$content .= '<tr><td></td><td></td>';
		foreach ($impact as $row_i) {
			$content .= '<td style="text-align:center; font-size:10px; font-weight:bold; color:black;">' . $row_i['code'] . '</td>';
		}
		$content .= '</tr>';

		// Footer tabel untuk level dampak
		$content .= '<tr><td></td><td></td>';
		foreach ($impact as $row_i) {
			$content .= '<td style="text-align:center; font-size:10px; font-weight:bold; color:black;">' . $row_i['level'] . '</td>';
		}
		$content .= '</tr>';

		// Footer utama untuk judul "Tingkatan Dampak"
		$content .= sprintf(
			'<tr><td></td><td></td><td class="text-primary" colspan="%d" style="text-align:center; font-weight:bold; padding:5px;"> </td></tr>',
			count($impact)
		);

		// Menutup tabel
		$content .= '</table></center>';

		return $content;
	}

	function draw_rcsa_unit($data, $type)
{
    // Ambil data likelihood dan impact dari database
    $like    = $this->db->where('category', 'likelihood')->order_by('code', 'desc')->get(_TBL_LEVEL)->result_array();
    $impact  = $this->db->where('category', 'impact')->order_by('code', 'asc')->get(_TBL_LEVEL)->result_array();
    $abjad   = ['E', 'D', 'C', 'B', 'A'];

    // Ukuran tetap untuk sel tabel
    $fixed_size = 60; // Ukuran sel dalam px
    $table_width = 100; // Lebar tabel dalam persen

    // Mulai membuat tabel
    $content = '<center><table style="padding:0px !important; text-align:center; border-collapse: collapse; width: ' . $table_width . '%; font-size: 12px; border="0">';

    // Header tabel
    $content .= '
    <tr>
        <td style="width: ' . $fixed_size . 'px; height: ' . $fixed_size . 'px;"></td>
        <td colspan="' . count($impact) . '" style="text-align:center; font-weight:bold; padding:5px; font-size:14px;">' . $type . ' Risk</td>
    </tr>';

    // Loop untuk likelihood (baris)
    foreach ($like as $index => $row_l) {
        $code_abjad = $abjad[$index] ?? $row_l['code'];
        $content .= '<tr>';

        $content .= sprintf(
            '<td style="text-align: %s; font-weight: bolder; color: black; font-size: 8px; width: %dpx; height: %dpx; aspect-ratio: 1; %s">%s<br>%s</td>',
            ($type != "Current" && $type != "Residual") ? "center" : "right", // Penentuan text-align
             $fixed_size, // Lebar sel
             $fixed_size, // Tinggi sel
            ($type != "Current" && $type != "Residual") ? "" : "padding-right: 5px !important;", // Padding-right jika bukan Current atau Residual
            ($type != "Current" && $type != "Residual") ? $row_l['level'] : '', // Konten level
            $code_abjad // Konten kode abjad
        );

        // Loop untuk impact (kolom)
        foreach ($impact as $row_i) {
            $like_no    = $row_l['id'];
            $impact_no  = $row_i['id'];
            $item_data  = $this->find_data_target($data, $like_no, $impact_no);
            $score      = $this->db->where('impact', $item_data['impact_no'])
                                   ->where('likelihood', $item_data['like_no'])
                                   ->get(_TBL_LEVEL_COLOR)
                                   ->row_array();

            // Ambil data dari $item_data
            $nilai_1       = $item_data['nilai_1'] ?? '';
            $nilai_2       = $item_data['nilai_2'] ?? '';
            $nilai_3       = $item_data['nilai_3'] ?? '';
            $warna_bg      = $item_data['warna_bg'] ?? '#ffffff';
            $warna_txt     = $item_data['warna_txt'] ?? '#000000';
            $tingkat       = $item_data['tingkat'] ?? '';
            $bawah_impact = $item_data['bawah_impact'] ?? '';
            $atas_impact  = $item_data['atas_impact'] ?? '';
            $bawah_like   = $item_data['bawah_like'] ?? '';
            $atas_like    = $item_data['atas_like'] ?? '';

            // Format nilai
            $val1 = $this->format_nilai($nilai_1, 'currentMap', '#3d004f');
            $val2 = $this->format_nilai($nilai_2, 'inherentMap', '#3d004f');
            $val3 = $this->format_nilai($nilai_3, 'residualMap', '#3d004f');

            // Kolom impact
            $content .= sprintf(
                '<td data-id="%s" class="pointer peta" onclick="hoho(this)" 
                        style="position: relative; background-color: %s; color: %s; width: %dpx; height: %dpx; aspect-ratio: 1; border: 1px solid white; font-size: 15px; font-weight: bold; text-align: center; vertical-align: middle; box-sizing: border-box; overflow-y: auto;"
                        data-toggle="popover" data-placement="top" data-html="true"
                        data-norut1="%s" data-norut2="%s" data-norut3="%s"
                        data-content="<strong>%s</strong><br/>Standar Nilai :<br/>Impact: [ >= %s s.d <= %s ]<br/>Likelihood: [ >= %s s.d <= %s ]"
                        data-kel="%s" data-like="%s" data-impact="%s">',
                $row_i['id'],
                $warna_bg,
                $warna_txt,
                $fixed_size, // Lebar tetap
                $fixed_size, // Tinggi tetap
                $nilai_1,
                $nilai_2,
                $nilai_3,
                $tingkat,
                $bawah_impact,
                $atas_impact,
                $bawah_like,
                $atas_like,
                $type,
                $item_data['like_no'],
                $item_data['impact_no']
            );

						$content .= '<div style="max-height: 60px; overflow: auto; cursor: pointer;">';

							// Tambahkan nilai berdasarkan tipe
							if ($type == "Inherent") {
									$content .= $val1 . '<br>';
							}
							if ($type == "Current") {
									$content .= $val2 . '<br>';
							}
							if ($type == "Residual") {
									$content .= $val3 . '<br>';
							}

							$content .= '</div>';

						

            // Tambahan skor
            $content .= '
                <div style="width:10px; margin:2px; position: absolute; top: 2px; font-size: 10px; font-weight: normal; color: #555;">
                    <strong style="font-weight:900;">' . $score['score'] . '</strong>
                </div>
            </td>';
        }

        $content .= '</tr>';
    }

    // Footer tabel untuk kode dampak
    $content .= '<tr><td style="width: ' . $fixed_size . 'px; height: 20px;"></td>';
    foreach ($impact as $row_i) {
        $content .= '<td style="text-align:center; font-size:8px; font-weight:bold; color:black; width: ' . $fixed_size . 'px; height: 20px;">' . $row_i['code'] . '</td>';
    }
    $content .= '</tr>';

    // Footer tabel untuk level dampak
    $content .= '<tr><td style="width: ' . $fixed_size . 'px; height: 30px;"></td>';
    foreach ($impact as $row_i) {
        $content .= '<td style="padding:0px !important; transform: rotate(-50deg); text-align:center; font-size:8px; font-weight:bold; color:black; width: ' . $fixed_size . 'px; height: 30px;">' 
                    . $row_i['level']
                    . '</td>';
    }
    $content .= '</tr>';

    // Footer utama untuk judul "Tingkatan Dampak"
    $content .= sprintf(
        '<tr><td style="width: ' . $fixed_size . 'px; height: ' . $fixed_size . 'px;"></td><td></td><td class="text-primary" colspan="%d" style="text-align:center; font-weight:bold; padding:5px;"> </td></tr>',
        count($impact)
    );

    // Menutup tabel
    $content .= '</table></center>';

    return $content;
}
	
	// Fungsi untuk memformat nilai
	function format_nilai($nilai, $class, $bg_color)
	{
			$arrNorut = explode(", ", $nilai);
			$val = '';
			foreach ($arrNorut as $n) {
					$val .= '<span class="' . $class . ' badge rounded-pill" style="border: solid 0px #000; background-color: ' . $bg_color . '; z-index: 1; position: relative; font-size:10px; margin: 3px;padding:3px;" data-norut=' . trim($n) . '>' . trim($n) . '</span>';
			}
			return $val;
	}


	function dfhjkdf($data, $type = 'inherent', $tipe = 'angka', $optional = [], $isPositif = 0)
	{ 
        $separate = ($isPositif == 1) ? '+' : 'x';
        $opti = '';
        $dtawal = [];
        if (isset($optional['dtawal'])) {
            $dtawal = $optional['dtawal'];
        }
        $dtmid = [];
        if (isset($optional['dtmid'])) {
            $dtmid = $optional['dtmid'];
        }
        $dtsetelah = [];
        if (isset($optional['dtsetelah'])) {
            $dtsetelah = $optional['dtsetelah'];
        }

        if ($optional) {
            if (is_array($optional)) {
                foreach ($optional as $key => $opt) {
                    if ($key == 'tipe') {
                        $opti .= ' data-' . $key . '="' . $opt . '" ';
                    }
                }
            } else {
                $opti = ' data-' . $key . '="' . $opt . '" ';
            }
        }

        $like = $this->db->where('category', 'likelihood')->where('is_positif', $isPositif)->order_by('urut', 'desc')->get(_TBL_LEVEL)->result_array();
        $impact = $this->db->where('category', 'impact')->where('is_positif', $isPositif)->order_by('urut')->get(_TBL_LEVEL)->result_array();
        


        $content = "<style>

        #table_seb {
            width:70%;
            margin-top:40px;
        }

        #table_h {
            width:70%;
            
        }

        #table_seb td, #table_h td {
            
            position:relative;
        }
        #table_seb td:after{
            content:'';
            display:block;
            margin-top:100%;
        }
        #table_seb td .content {
            text-align:center;
            position:absolute;
            top:0;
            bottom:0;
            left:0;
            right:0;
            overflow: auto;
            padding: 10px 0px;
        }
        .bad{
            display: inline-block;
            min-width: 20px;
            min-height: 20px;
            padding: 4px 4px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            background-color: #777;
            border-radius: 50%;
            margin: 1px;
        }
        .rotate {
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            width: 1.5em;
            font-size:16px;
          }
          .rotate div {
               -moz-transform: rotate(-90.0deg);  /* FF3.5+ */
                 -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
            -webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
                       filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
                   -ms-filter: 'progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)'; /* IE8 */
                   margin-left: -10em;
                   margin-right: -10em;
          }
       
        </style>";

        
        $content .= '';
        $content .= '<center>';

        $content .= '<table id="table_seb" style="text-align:center;" border="0" width="100%">';
        
        $no = 0;
        $noTd = 5;
        $nourut = 0;
        $arrBorder = [];
        
        foreach ($data as $key => $row) {
            $icon = '&nbsp;&nbsp;';
            if (!empty($row['icon'])) {
                $icon = show_image($row['icon'], 0, 10, 'slide', 0, 'pull-right');
            }

            $apetite = ' <i class="fa fa-minus-circle pull-right text-primary"></i> ';
            if ($row['sts_apetite'] == 1) {
                $apetite = ' <i class="fa fa-check-circle pull-right text-primary"></i> ';
            }
            $icon = '&nbsp;&nbsp;';
            ++$no;
            if ($tipe == 'angka') {
                $nilai = (!empty($row['nilai'])) ? $row['nilai'] : '';
                $nilaiket = $nilai;
            } else {
                $nilaiket = (!empty($row['nilai'])) ? '<span class="glyphicon glyphicon-ok-circle gi-2x"></span>' : '';
                $nilai = (!empty($row['nilai'])) ? $row['nilai'] : '';
            }

            if ($key == 0) {
                $content .= '<tr><td width="15%" class="hidden" style="padding:5px;text-align:center;">' . $like[$nourut]['level'] . '</td><td style="padding:5px;border-color: transparent;font-weight:bold" width="10%" class="hiddenx rotate" rowspan="5"><div>Kemungkinan Risiko</div></td><td style="padding:5px;border-color: transparent;font-weight:bold" width="10%" class="hiddenx"><div class="content">
                <div style="width: 100%;top: 40%;position: absolute;">' . $like[$nourut]['urut'] . '</div></div></td>';
                ++$nourut;
            }

            $notif = '<strong>' . $row['tingkat'] . '</strong><br/>Standar Nilai :<br/>Impact: [ >' . $row['bawah_impact'] . ' s.d <=' . $row['atas_impact'] . ']<br/>Likelihood: [ >' . $row['bawah_like'] . ' s.d <=' . $row['atas_like'] . ']<br/>Treatment : ' . $row['treatment'];

            $fa = 16;
            $awal = '';
            if (isset($dtawal[$row['score_dampak'] . $separate . $row['score_kemungkinan']])) {
                $aw = $dtawal[$row['score_dampak'] . $separate . $row['score_kemungkinan']];

                if (count($aw) > 50) {
                    $fa = 10;
                } elseif (count($aw) > 25) {
                    $fa = 12;
                }
                // $awal .= count($aw);
                foreach ($aw as $sey => $set) {
                    // $awal .= '<span class="badge" style="padding:3px 9px;border-color:#000;background-color:#02ae00;z-index: 1;position: relative;font-size:'.$fa.'px">'.$set.'</span>';
                    $awal .= '<span class="bad" style="border: solid 0px #000;background-color:#215968;z-index: 1;position: relative;font-size:' . $fa . 'px">' . $set . '</span>';
                }
            }

            $fm = 16;
            $mid = '';
            if (isset($dtmid[$row['score_dampak'] . $separate . $row['score_kemungkinan']])) {
                $am = $dtmid[$row['score_dampak'] . $separate . $row['score_kemungkinan']];

                if (count($am) > 50) {
                    $fm = 10;
                } elseif (count($am) > 25) {
                    $fm = 12;
                }
                // $awal .= count($aw);
                foreach ($am as $sem => $sei) {
                     $mid .= '<span class="bad" style="border: solid 0px #000;background-color:#3A9491 ;z-index: 1;position: relative;font-size:' . $fm . 'px">' . $sei . '</span>';
                }
            }

            $fs = 16;
            $setelah = '';

            if (isset($dtsetelah[$row['score_dampak'] . $separate . $row['score_kemungkinan']])) {
                $se = $dtsetelah[$row['score_dampak'] . $separate . $row['score_kemungkinan']];

                if (count($se) > 50) {
                    $fs = 10;
                } elseif (count($se) > 25) {
                    $fs = 12;
                }
                // $awal .= count($aw);
                foreach ($se as $sem => $pak) {
                     $setelah .= '<span class="bad" style="border: solid 0px #000;background-color:#93CDDD;z-index: 1;position: relative;font-size:' . $fs . 'px;color:#000">' . $pak . '</span>';
                }
            }

            $border = 'border:solid 3px #fff;';
             if ($row['score_dampak'] == 1 && $row['score_kemungkinan'] == 5) {
                $border = 'border-right-color: black !important;
                border-right-style: dasheds !important;border-right-width: thick !important;';
            } elseif ($row['score_dampak'] == 2 && $row['score_kemungkinan'] == 4) {
                $border = 'border-right-color: black !important;
                border-right-style: dasheds !important;
                border-right-width: thick !important;
                border-top-color: black !important;
                border-top-style: dasheds !important;
                border-top-width: thick !important;
                border-bottom-color: #fff !important;
                border-bottom-style: solid !important;
                border-bottom-width: thick !important;';
            } elseif ($row['score_dampak'] == 2 && $row['score_kemungkinan'] == 3) {
                $border = 'border-right-color: black !important;
                border-right-style: dasheds !important;border-right-width: thick !important;';
            } elseif ($row['score_dampak'] == 3 && $row['score_kemungkinan'] == 2) {
                $border = 'border-right-color: black !important;
                border-right-style: dasheds !important;
                border-right-width: thick !important;
                border-top-color: black !important;
                border-top-style: dasheds !important;
                border-top-width: thick !important;';
            } elseif ($row['score_dampak'] == 4 && $row['score_kemungkinan'] == 1) {
                $border = 'border-right-color: black !important;
                border-right-style: dasheds !important;
                border-right-width: thick !important;
                border-top-color: black !important;
                border-top-style: dasheds !important;
                border-top-width: thick !important;';
            }

            $content .= '<td ' . $opti . ' data-id="' . $row['id'] . '" class=" peta" style="' . $border . 'background-color:' . $row['warna_bg'] . ';color:' . $row['warna_txt'] . ';padding:5px; font-size:16px; font-weight:bold;height:50px !important;" data-togglex = "popover" data-placementx="top" data-htmlx="true" data-contentx="' . $notif . '" data-nilai="' . $nilai . '" data-batas="' . $row['sts_apetite'] . '"><div class="content">' . $awal . '<br>' . $mid . '<br>' . $setelah . '<div style="width: 100%;top: 40%;position: absolute;">' . $row['code_mapping'] . '<br>' . $row['tingkat_ex'] . '</div></div></td>';
            if ($no % 5 == 0 && $key < 24) {
                --$noTd;
                $content .= '</tr><tr><td class="hidden" width="15%" class="td-nomor-v" style="padding:5px;text-align:center;">' . $like[$nourut]['level'] . '</td><td class="hiddenx" width="10%" style="padding:5px;border-color: transparent;font-weight:bold"><div class="content">
                <div style="width: 100%;top: 40%;position: absolute;">' . $like[$nourut]['urut'] . '</div></div></td>';
                ++$nourut;
            }
        }

        $content .= '</tr>';
        $content .= '</table>';

        $content .= '<table id="table_h" style="text-align:center;"  width="100%">';
        $content .= '<tr><td class="hiddenx"  style="padding:5px" width="10%"></td>';

        foreach ($impact as $key => $row) {
            $px = 5;
            if ($key == 0) {
                $px = 7;
            }
            
            $content .= '<td class="hiddenx" style="padding:' . $px . 'px; font-size:16px; font-weight:bold;height:50px !important;">' . $row['urut'] . '</td>';
        }
        $content .= '</tr><tr>';
        $content .= '<td></td><td class="hiddenx" colspan="5" style="padding:' . $px . 'px; font-size:16px; font-weight:bold;height:50px !important;">Dampak Risiko</td>';
        $content .= '</tr></table><br/>&nbsp;';

        $content .= '<div style="display:inline-flex"><span style="background-color:#215968 ;width: 30px;border-radius: 50%;border: solid 0px black;height: 30px;"></span><strong style="padding-top: 4px;">&nbsp;Inherent&nbsp;&nbsp;</strong><span style="background-color:#3A9491  ;width: 30px;border-radius: 50%;border: solid 0px black;height: 30px;"></span><strong style="padding-top: 4px;">&nbsp;Target&nbsp;&nbsp;</strong><span style="background-color:#93CDDD ;width: 30px;border-radius: 50%;border: solid 0px black;height: 30px;"></span><strong style="padding-top: 4px;">&nbsp;Residual</strong></div>';

        $content .= '';
        $content .= '</center>';
 
		return $content;
	}



	function draw_rcsa_residual($data, $type = 'inherent')
	{
		$like = $this->db->where('category', 'likelihood')->order_by('code', 'desc')->get(_TBL_LEVEL)->result_array();
		$impact = $this->db->where('category', 'impact')->order_by('code', 'desc')->get(_TBL_LEVEL)->result_array();

		$content = '<center><table style="text-align:center;" border="0">';
		$no = 0;
		$noTd = 5;
		$nourut = 0;
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		// die();

		$keys = [4, 9, 14, 19, 24];
		foreach ($data as $key => $row) {
			++$no;
			$nilai = (!empty($row['nilai'])) ? $row['nilai'] : "";
			if ($key == 0) {
				$content .= '<tr>';
			}
			$content .= '<td height="50px" data-id="' . $row['id'] . '"  class="pointer peta" onclick="hoho(this)" style="background-color:' . $row['warna_bg'] . ';color:' . $row['warna_txt'] . ';padding:33px;border:solid 1px black;min-width:45px; font-size:16px; font-weight:bold;" data-toggle = "popover" data-placement="top" data-html="true" data-content="<strong>' . $row['tingkat'] . '</strong><br/>Standar Nilai :<br/>Impact: [ >=' . $row['bawah_impact'] . ' s.d <=' . $row['atas_impact'] . ']<br/>Likelihood: [ >=' . $row['bawah_like'] . ' s.d <=' . $row['atas_like'] . ']" data-nilai="' . $nilai . '" data-kel="' . $type . '">' . $nilai . '</td>';
			if (in_array($key, $keys)) {
				$content .= '<td height="50px" style="padding:13px;min-width:55px;">' . $impact[$nourut]['code'] . '</td><td style="padding:13px;min-width:55px;">' . $impact[$nourut]['level'] . '</td>';
				++$nourut;
			}
			if ($key == 4) {
				$content .= '<td rowspan="5" class="text-center"><strong>Impact</strong></td>';
				// ++$nourut;
			}
			if ($no % 5 == 0 && $key < 24) {
				$content .= '</tr>';
			}
		}
		$content .= '<tr>';
		foreach ($like as $key => $row) {
			$content .= '<td style="padding:13px;">' . $row['code'] . '</td>';
		}
		$content .= '</tr><tr>';
		foreach ($like as $key => $row) {
			$content .= '<td width="50px" style="padding:13px;">' . $row['level'] . '</td>';
		}
		$content .= '</tr><tr><td class="text-center" colspan="4"><strong>Probability</strong></td></tr>';

		$content .= '</table><br/>&nbsp;';

		$row_ket = $this->db->select('rcsa_owner_no, name as name')->where('sts_propose', 4)->distinct()->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

		// $content .='<table class="table" width="50%" style="text-align:left;width:50%;" border="1"><tr><td colspan="2">Keterangan :</td></tr>';
		// // Doi::dump($row_ket);
		// foreach($row_ket as $row){
		// 	$content .='<tr><td width="15%" style="vertical-align:middle !important;"><a class="kotak-list"></td><td>'.$row['name'].'</td></tr>';
		// }
		// $content .='</table><br/>&nbsp;';
		$content .= '<div class="row"><div class="col-md-12" id="detail_map"></div></div>';
		return $content;
	}

	function get_master_level($filter = false, $id = 0)
	{
		if ($filter) {
			$rows = $this->db
				->select(_TBL_LEVEL_MAPPING . '.*,' . _TBL_LEVEL_COLOR . '.id as id_color,' . _TBL_LEVEL_COLOR . '.likelihood,' . _TBL_LEVEL_COLOR . '.impact')
				->from(_TBL_LEVEL_COLOR)
				->where(_TBL_LEVEL_COLOR . '.id', $id)
				->join(_TBL_LEVEL_MAPPING, _TBL_LEVEL_COLOR . '.level_risk_no = ' . _TBL_LEVEL_MAPPING . '.id')
				->get()
				->row_array();
		} else {
			$query = $this->db
				->select(_TBL_LEVEL_MAPPING . '.*,' . _TBL_LEVEL_COLOR . '.id as id_color,' . _TBL_LEVEL_COLOR . '.likelihood,' . _TBL_LEVEL_COLOR . '.impact')
				->from(_TBL_LEVEL_COLOR)
				->join(_TBL_LEVEL_MAPPING, _TBL_LEVEL_COLOR . '.level_risk_no = ' . _TBL_LEVEL_MAPPING . '.id')
				->get();
			$rows = json_encode($query->result_array());
		}
		// var_dump($rows);die();
		return $rows;
	}

	function get_data_risk_register_list($id)
	{
		$rows = $this->db->where('rcsa_no', $id)->group_by('id_rcsa_detail')->order_by('urgensi_no_kadiv')->get(_TBL_VIEW_REGISTER)->result_array();
		foreach ($rows as &$row) {
			$arrCouse = json_decode($row['risk_couse_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['couse'] = implode('### ', $arrCouse);

			$arrCouse = json_decode($row['risk_impact_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['description'];
			}
			$row['impact'] = implode('### ', $arrCouse);

			$arrCouse = json_decode($row['accountable_unit'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['name'];
			}

			$row['penanggung_jawab'] = implode('### ', $arrCouse);

			$arrCouse = json_decode($row['penangung_no'], true);
			$rows_couse = array();
			if ($arrCouse)
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['name'];
			}
			$row['accountable_unit_name'] = implode('### ', $arrCouse);

			$arrCouse = json_decode($row['control_no'], true);
			if (!empty($row['note_control']))
				$arrCouse[] = $row['note_control'];
			$row['control_name'] = implode(', ', $arrCouse);
		}
		unset($row);
		return $rows;
	}

	function getParamDrawKomposit($p = false, $get = "")
	{
		$data = [
			'levelKPMR' => [
				['min' => 90, 'max' => 1000, 'label' => "Strong"],
				['min' => 85, 'max' => 90, 'label' => "Satisfactory"],
				['min' => 80, 'max' => 84, 'label' => "Fair"],
				['min' => 75, 'max' => 79, 'label' => "Marginal"],
				['min' => 0, 'max' => 74, 'label' => "Unsatisfactory"],
			],
			'levelKinerja' => [
				['min' => 95, 'max' => 1000, 'label' => "Sangat Baik", 'nilai' => '1, 1, 2, 3, 3'],
				['min' => 90, 'max' => 95, 'label' => "Baik", 'nilai' => '1, 2, 2, 3, 4'],
				['min' => 80, 'max' => 89, 'label' => "Cukup", 'nilai' => '2, 2, 3, 4, 4'],
				['min' => 70, 'max' => 79, 'label' => "Kurang", 'nilai' => '2, 3, 4, 4, 5'],
				['min' => 0, 'max' => 70, 'label' => "Buruk", 'nilai' => '3, 3, 4, 5, 5'],
			]
		];
		if ($p) {
			return $get === "KPMR" ? ['levelKPMR' => $data['levelKPMR']] : ($get === "KINERJA" ? ['levelKinerja' => $data['levelKinerja']] : $data);
		}

		return $data;
	}

	function getCellClassKomposit($value)
	{
		if ($value == 1) return "strong";
		if ($value == 2) return "satisfactory";
		if ($value == 3) return "fair";
		if ($value == 4) return "marginal";
		if ($value == 5) return "unsatisfactory";
	}

	function drawMapKomposit($indexKinerja, $kmpr, $data)
	{
		$kualitasKinerja = $data['KINERJA']['realisasiText'];
		$totalPenilaianKinerja = $data['KINERJA']['realisasiAngka'];

		$kualitasKPMR = $data['KPMR']['realisasiText'];
		$totalPenilaianCombo = $data['KPMR']['realisasiAngka'];
		$result = '
		<table class="indexKomposit">
			<tr>
				<th id="kinerja"class="indexKomposit"  rowspan="2"><center>Kinerja</center></th>
				<th id="kpmr" class="indexKomposit" colspan="' . count($kmpr) . '">Kualitas Penerapan Manajemen Risiko</th>
			</tr>
			<tr>';

		foreach ($kmpr as $header) {
			$result .= '<th id="kpmr">' . $header . '</th>';
		}

		$result .= '</tr>';

		foreach ($indexKinerja as $row) {
			$result .= '<tr>';
			foreach ($row as $index => $cell) {
				if ($index == 0) {
					$result .= '<th id="kinerja" >' . $cell . '</th>';
				} else {
					$highlight = ($row[0] == $kualitasKinerja && $index == array_search($kualitasKPMR, $kmpr) + 1) ? "highlight" : "";
					$cellClass = $this->getCellClassKomposit($cell);

					$result .= '
					<td class="' . $cellClass . ' indexKomposit">
						<span id="isi" class="' . $highlight . ' peta" 
							data-toggle="popover" 
							data-placement="top" 
							data-html="true" 
							data-content="
							KPMR:&nbsp;<strong>' . $kualitasKPMR . '</strong>&nbsp;[&nbsp;' . $totalPenilaianCombo . '&nbsp;]<br/>
								Kinerja:&nbsp;<strong>' . $kualitasKinerja . '</strong>&nbsp;[&nbsp;' . $totalPenilaianKinerja . '&nbsp;]"
							title="Output Index Komposit">
							' . $cell . '
						</span>
					</td>';
				}
			}
			$result .= '</tr>';
		}
		$result .= '</table>';

		return $result;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */