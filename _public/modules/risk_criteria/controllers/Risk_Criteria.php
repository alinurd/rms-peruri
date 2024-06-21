<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
class Risk_Criteria extends BackendController
{
	public $tmp_data = array();
	public $data_fields = array();

	public function __construct()
	{
		parent::__construct();

		$this->load->model('data');
		$table = $this->config->item('tbl_suffix') . 'items';
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
		$data['cbo_period'] = $this->get_combo('periode');


		$param = ['id_period' => _TAHUN_NO_, 'bulan' => date('n'), 'id_owner' => 0];
		$data['mapping'] = $this->data->get_map_rcsa($param);
		$owner_no = 0;
		if ($this->_Group_['owner']) {
			$owner_no = $this->_Group_['owner']['owner_no'];
		}

		$data['haha'] = $this->_Group_['owner'];
		$data['task'] = $this->data->get_task($owner_no);

		$data['notif'] = $this->data->get_notif($this->_Group_);


		$data['kriteria'] = [1 => [
			'name' => 'Sangat Kecil',
			'color' => 'green',
		], 2 => [
			'name' => 'Kecil',
			'color' => 'lightgreen'
		], 3 => [
			'name' => 'Sedang',
			'color' => 'yellow'
		], 4 => [
			'name' => 'Besar',
			'color' => 'orange'
		], 5 => [
			'name' => 'Sangat Besar',
			'color' => 'red'
		]];
		$data['kemungkinan'] = $this->db->where('kelompok', 'kriteria-kemungkinan')->get(_TBL_DATA_COMBO)->result_array();
		$data['dampak'] = $this->db->where('kelompok', 'kriteria-dampak')->get(_TBL_DATA_COMBO)->result_array();

		$this->template->build('dashboard', $data);
	}
}

/* End of file welcome.php */