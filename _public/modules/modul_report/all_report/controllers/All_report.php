<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
// $tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class All_report extends BackendController {
    var $table 		= "";
	var $post 		= array();
	var $sts_cetak 	= false;
	public function __construct()
	{
		parent::__construct();
		$this->set_Tbl_Master(_TBL_VIEW_RCSA);
		$this->nil_tipe 		= 1;
		$this->cbo_periode 		= $this->get_combo('periode');
		$this->cbo_parent 		= $this->get_combo('parent-input');
		$this->cbo_parent_all 	= $this->get_combo('parent-input-all');
		$this->cbo_type 		= $this->get_combo('type-project');
		$this->cbo_bulan 		= $this->get_combo('bulan');
		$type = $this->uri->segment(6);

		if($type == 'risk_context'){
			$this->set_Open_Tab('General Information');
			$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 4));
			$this->addField(array('field' => 'judul_assesment', 'size' => 100, 'search' => false));
			$this->addField(array('field' => 'owner_no', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => true, 'search' => true));
			$this->addField(array('field' => 'officer_no', 'show' => false, 'save' => true, 'default' => $this->authentication->get_info_user('identifier')));
			$this->addField(array('field' => 'create_user', 'search' => false, 'default' => $this->authentication->get_info_user('username')));
			$this->addField(array('field' => 'period_no', 'input' => 'combo', 'combo' => $this->cbo_periode, 'size' => 15, 'search' => true, 'required' => false));
			$this->addField(array('field' => 'anggaran_rkap', 'type' => 'float', 'input' => 'float', 'required' => true));
			$this->addField(array('field' => 'owner_pic', 'title'=> 'Owner Pic','size' => 100, 'search' => false));
			$this->addField(array('field' => 'anggota_pic', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'tugas_pic', 'input' => 'multitext:sms', 'size' => 10000));
			$this->addField(array('field' => 'tupoksi', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'tahun_rcsa', 'show' => false));
			$this->addField(array('field' => 'bulan_rcsa', 'show' => false));

			$this->set_Open_Tab('Rencana Implementasi MR'); // implementasi_risiko
			$this->addField(array('field' => 'implementasi_risiko', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
			$this->set_Close_Tab();

			$this->addField(array('field' => 'item_use', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
			$this->addField(array('field' => 'register', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
			$this->addField(array('field' => 'status', 'input' => 'boolean', 'size' => 15));
			$this->addField(array('field' => 'name', 'show' => false));
			$this->addField(array('field' => 'periode_name', 'show' => false));
			$this->addField(array('field' => 'sts_propose_text', 'show' => false));
			$this->addField(array('field' => 'sts_propose', 'show' => false));
			$this->set_Close_Tab();

			$this->set_Open_Tab('Isu Internal');
			$this->addField(array('field' => 'man', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'method', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'machine', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'money', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'material', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'market', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'stakeholder_internal', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
			$this->set_Close_Tab();

			$this->set_Open_Tab('Isu External'); 
			$this->addField(array('field' => 'politics', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'economics', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'social', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'tecnology', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'environment', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'legal', 'input' => 'multitext', 'size' => 10000));
			$this->addField(array('field' => 'stakeholder_external', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
			$this->set_Close_Tab();


			$this->set_Open_Tab('Dokumen Lainnnya');
			$this->addField(array('field' => 'nm_file', 'input' => 'upload', 'path' => 'regulasix', 'file_type' => 'pdf|pdfx|PDF|docx|doc|', 'file_random' => false));
			$this->set_Close_Tab();
		}else if($type == 'risk_criteria'){
			$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 4));
			$this->set_Open_Tab('Kriteria Probabilitas');
			$this->addField(array('field' => 'kriteria_probabilitas', 'type' => 'free', 'input' => 'free', 'mode' =>'e'));		
			$this->set_Close_Tab();
			$this->set_Open_Tab('Kriteria Dampak');
			$this->addField(array('field' => 'kriteria_dampak', 'type' => 'free', 'input' => 'free', 'mode' =>'e'));		
			$this->set_Close_Tab();
		}

		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master));

		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'anggaran_rkap', 'span_right_addon' => ' Rp ', 'align' => 'right'));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'create_user', 'readonly' => true));

		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		$this->_CHANGE_TABLE_MASTER(_TBL_RCSA);
		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('edit', false);
		$this->_SET_PRIVILEGE('delete', false);
		$this->tmp_data['setActionprivilege']=false;
		$this->set_Close_Setting();
		
	}


    public function index()
    {
        $data['risk_context'] 	= $this->risk_context();
        $data['risk_criteria'] 	= $this->risk_criteria();
        $this->template->build('all_report',$data);
    }

    public function risk_context()
    {
        $data['data'] = $this->data->get_risk_context();
        return $this->load->view('risk_context',$data,true);
    }

    public function risk_criteria()
    {
        $data['data'] = $this->data->get_risk_criteria();
        return $this->load->view('risk_criteria',$data,true);
    }

    public function downloadFile()
	{
		$value = $this->uri->segment(3); 
		if ($value) {
			$filePath = "themes/file/regulasix/" . $value;
			if ($value) {
				if (file_exists($filePath)) {
					header('Content-Type: application/octet-stream');
					header("Content-Disposition: attachment; filename=\"" . $value . "\"");
					header('Content-Length: ' . filesize($filePath));
					readfile($filePath);
				} else {
					echo "<script>alert('file tidak ditemukan atau permision jalur tidak sah'); window.history.go(-1);</script>";
				}
			} else {
				echo "<script>alert('" . htmlspecialchars($value) . " Tidak memiliki lampiran'); window.history.go(-1);</script>";
			}
		} else {
			echo "<script>alert('Data file tidak ditemukan.'); window.history.go(-1);</script>";
		}
	}

	function insertBox_IMPLEMENTASI_RISIKO($field)
	{
		$content = $this->get_implementasi();
		return $content;
	}

	function updateBox_IMPLEMENTASI_RISIKO($field, $row, $value)
	{
		$content = $this->get_implementasi();
		return $content;
	}

	function get_implementasi()
	{
		$id 				= $this->uri->segment(3);
		$mode 				= $this->uri->segment(2);
		$data['id'] 		= $id;
		$data['mode'] 		= $mode;
		$data['combo'] 		= $this->db
		->where('kelompok', 'implementasi')
		->order_by('kode', 'asc')
		->get(_TBL_DATA_COMBO)
		->result_array();
		$result 			= $this->load->view('implementasi', $data, true);
		return $result;
	}

    function insertBox_STAKEHOLDER_INTERNAL($field){
		$content = $this->get_stakeholder(1);
		return $content;
	}
	
	function updateBox_STAKEHOLDER_INTERNAL($field, $row, $value){
		$content = $this->get_stakeholder(1);
		return $content;
	}

	function insertBox_STAKEHOLDER_EXTERNAL($field){
		$content = $this->get_stakeholder(2);
		return $content;
	}
	
	function updateBox_STAKEHOLDER_EXTERNAL($field, $row, $value){
		$content = $this->get_stakeholder(2);
		return $content;
	}

	function get_stakeholder($type=1, $id=0)
	{
		$id=$this->uri->segment(3);
		$data['field']=$this->db->where('stakeholder_type', $type)->where('rcsa_no', $id)->get(_TBL_RCSA_STAKEHOLDER)->result_array();
		$data['type']=$type;
		$result=$this->load->view('stakeholder',$data,true);
		return $result;
	}

	function insertBox_KRITERIA_PROBABILITAS($field){
		$content = $this->get_kriteria(1);
		return $content;
	}
	
	function updateBox_KRITERIA_PROBABILITAS($field, $row, $value){
		$content = $this->get_kriteria(1);
		return $content;
	}
	function insertBox_KRITERIA_DAMPAK($field){
		$content = $this->get_kriteria(2);
		return $content;
	}
	
	function updateBox_KRITERIA_DAMPAK($field, $row, $value){
		$content = $this->get_kriteria(2);
		return $content;
	}
	function get_kriteria($type1=1, $id=0)
	{
		$id=$this->uri->segment(3);
		doi::dump($id);
		$data['field']=$this->db->where('kriteria_type', $type1)->where('rcsa_no', $id)->get(_TBL_RCSA_KRITERIA)->result_array();
		$data['type1']=$type1;
		$result=$this->load->view('kriteria',$data,true);
	
		return $result;
	}


}

/* End of file All_report.php */
/* Location: ./application/controllers/All_report.php */
