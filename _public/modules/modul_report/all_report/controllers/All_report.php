<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class All_report extends BackendController {
    var $table 		= "";
	var $post 		= array();
	var $sts_cetak 	= false;

    public function index()
    {
		$data['korporasi'] 		= $this->get_combo('parent-input');;
		$data['periode']		= $this->get_combo('periode');
        $this->template->build('all_report',$data);
    }

	function get_grafik(){
		$post							= $this->input->post();
		$data_parent					= $this->data->risk_parent($post);
		$data_progress_treatment		= $this->data->risk_progress_treatment($post);
		$data_early_warning				= $this->data->risk_early_warning($post);
		// $data_perubahan_level			= $this->data->perubahan_level($post);
		$result['combo']				= $this->risk_context($data_parent);
		$result['risk_criteria']		= $this->risk_criteria($data_parent);
		$result['risk_appetite']		= $this->risk_appetite($data_parent);
		$result['risk_register']		= $this->risk_register($data_parent);
		$result['efektifitas_control']	= $this->risk_efektifitas_control($data_parent);
		$result['progress_treatment']	= $this->risk_progress_treatment($data_progress_treatment);
		$result['loss_event_database']	= $this->lost_event_database($data_parent);
		$result['early_warning']		= $this->risk_early_warning($data_early_warning);
		$result['perubahan_level']		= $this->perubahan_level($post);
		echo json_encode($result);

	}

    public function risk_context($data)
    {
        $data['data'] 	= $data;
		$tahun 			= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
		$data['combo'] 	= $this->db
								->where('kelompok', 'implementasi')
								->order_by('kode', 'asc')
								->get(_TBL_DATA_COMBO)
								->result_array();
        return $this->load->view('risk_context',$data,true);
    }

    public function risk_criteria($data)
    {
		$data['data'] 	= $data;
		$tahun 			= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
		$data['combo'] 	= $this->db
								->where('kelompok', 'implementasi')
								->order_by('kode', 'asc')
								->get(_TBL_DATA_COMBO)
								->result_array();
        return $this->load->view('risk_criteria',$data,true);
    }

    public function risk_appetite($data)
    {
		$data['data'] 	= $data;
		$tahun 			= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
		$data['combo'] 	= $this->db
								->where('kelompok', 'implementasi')
								->order_by('kode', 'asc')
								->get(_TBL_DATA_COMBO)
								->result_array();
        return $this->load->view('risk_appetite',$data,true);
    }
	
    public function risk_register($data)
    {
		$data['data'] 	= $data;
		$tahun 			= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
		$data['combo'] 	= $this->db
								->where('kelompok', 'implementasi')
								->order_by('kode', 'asc')
								->get(_TBL_DATA_COMBO)
								->result_array();
        return $this->load->view('risk_register',$data,true);
    }


	
    public function risk_efektifitas_control($data)
    {
		$data['data'] 	= $data;
		$tahun 			= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
		$data['combo'] 	= $this->db
								->where('kelompok', 'implementasi')
								->order_by('kode', 'asc')
								->get(_TBL_DATA_COMBO)
								->result_array();
        return $this->load->view('efektifitas_control',$data,true);
    }

    public function risk_progress_treatment($data)
    {
		$data['data'] 	= $data;
		$tahun 			= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
		$data['combo'] 	= $this->db
								->where('kelompok', 'implementasi')
								->order_by('kode', 'asc')
								->get(_TBL_DATA_COMBO)
								->result_array();
        return $this->load->view('progress_treatment',$data,true);
    }

	public function lost_event_database($data)
    {
        $data['data'] 				= $data;
		$tahun 						= $data[0]['periode_name'];
		$data['tahun']  			= $tahun;
		$data['kategori_kejadian'] 	= $this->get_combo('data-combo', 'kat-kejadian');
        $data['frekuensi_kejadian'] = $this->get_combo('data-combo', 'frek-kejadian');
		$data['kat_risiko'] 		= $this->get_combo('data-combo', 'kel-library');
		$data['cboLike']    		= $this->get_combo('likelihood');
        $data['cboImpact'] 			= $this->get_combo('impact');
		$data['combo'] 				= $this->db
											->where('kelompok', 'implementasi')
											->order_by('kode', 'asc')
											->get(_TBL_DATA_COMBO)
											->result_array();
        return $this->load->view('loss_event_database',$data,true);
    }

	public function risk_early_warning($data)
    {
		$data['data'] 	= $data;
		$tahun 			= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
		$data['combo'] 	= $this->db
								->where('kelompok', 'implementasi')
								->order_by('kode', 'asc')
								->get(_TBL_DATA_COMBO)
								->result_array();
        return $this->load->view('early_warning',$data,true);
    }

	public function perubahan_level($data){
		$data['data'] 	= $data;
		$tahun 			= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
		$data['combo'] 	= $this->db
								->where('kelompok', 'implementasi')
								->order_by('kode', 'asc')
								->get(_TBL_DATA_COMBO)
								->result_array();
        return $this->load->view('perubahan_level',$data,true);
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
