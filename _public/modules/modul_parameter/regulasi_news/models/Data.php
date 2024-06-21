<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	var $tbl_items='';
	public function __construct()
    {
        parent::__construct();
	}
	
	function get_data_detail_news($id){
		$this->db->where('id', $id);
		$this->db->select('*');

		$query = $this->db->get('bangga_news');
		$rows = $query->row_array();
		return $rows;
	}
	function get_data_detail($id){
		$this->db->where('id', $id);
		$this->db->select('*');

		$query = $this->db->get('bangga_regulasi');
		$rows = $query->row_array();
		return $rows;
	}
	function count_data($data)
	{
		$this->db->where('status', 1);
		if ($data == 'internal') {
			$this->db->where('tipe_no', 81);
			$this->db->from('bangga_regulasi');
		} elseif ($data == 'eksternal') {
			$this->db->where('tipe_no', 82);
			$this->db->from('bangga_regulasi');
		} elseif ($data == 'news') {
			$this->db->from('bangga_news');
		} elseif ($data == 'all') {
			$this->db->from('bangga_regulasi');
		}

		return $this->db->count_all_results();
	}
	function get_data($data, $page, $per_page)
	{
		$this->db->where('status', 1);
		$this->db->limit($per_page, ($page - 1) * $per_page);

		if ($data == 'internal') {
			$this->db->where('tipe_no', 81);
			$this->db->select('*');
			$query = $this->db->get('bangga_regulasi');
			$rows = $query->result_array();
		} elseif ($data == 'eksternal') {
			$this->db->where('tipe_no', 82);
			$this->db->select('*');
			$query = $this->db->get('bangga_regulasi');
			$rows = $query->result_array();
		} elseif ($data == 'news') {
			$this->db->select('*')->order_by('create_date', 'desc');
			$query = $this->db->get('bangga_news');
			$rows = $query->result_array();
		} elseif ($data == 'all') {
			$this->db->select('*');
			$query = $this->db->get('bangga_regulasi');
			$rows['regulasi'] = $query->result_array();

			$this->db->select('*');
			$query = $this->db->get('bangga_news');
			$rows['news'] = $query->result_array();
		}

		return $rows;
	}

 
	
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */