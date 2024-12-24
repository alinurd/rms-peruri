<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}

    function get_risk_context()
    {
        // Melakukan join dengan tabel period, menghitung jumlah sasaran dan jumlah peristiwa
        $this->db->select('rcsa.*, bangga_period.periode_name as periode_name, COUNT(sasaran.id) as jumlah_sasaran, COUNT(detail.id) as jumlah_peristiwa'); // Menghitung jumlah sasaran dan peristiwa
        $this->db->from(_TBL_VIEW_RCSA . ' as rcsa'); // Alias untuk tabel RCSA
        $this->db->join('bangga_period', 'rcsa.period_no = bangga_period.id', 'left'); // Melakukan join dengan tabel period
        $this->db->join(_TBL_RCSA_SASARAN . ' as sasaran', 'rcsa.id = sasaran.rcsa_no', 'left'); // Melakukan join dengan tabel sasaran
        $this->db->join('bangga_rcsa_detail as detail', 'rcsa.id = detail.rcsa_no', 'left'); // Melakukan join dengan tabel rcsa_detail
        $this->db->group_by('rcsa.id'); // Mengelompokkan hasil berdasarkan id RCSA
        $this->db->order_by('rcsa.create_date', 'DESC'); // Mengurutkan berdasarkan create_date

        // Mendapatkan hasil
        $query = $this->db->get();

        // Kembalikan hasil dalam bentuk array
        return $query->result_array();
    }

    function get_risk_criteria()
    {
        $this->db->select('rcsa.*, bangga_period.periode_name as periode_name');
        $this->db->from(_TBL_VIEW_RCSA . ' as rcsa');
        $this->db->join('bangga_period', 'rcsa.period_no = bangga_period.id', 'left');
        $this->db->group_by('rcsa.id');
        $this->db->order_by('rcsa.create_date', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
        
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */