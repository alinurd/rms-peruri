<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class All_Report extends BackendController {
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
		$post									= $this->input->post();
		$data_parent							= $this->data->risk_parent($post);
		$data_progress_treatment				= $this->data->risk_progress_treatment($post);
		$data_early_warning						= $this->data->risk_early_warning($post);
		$data_tasktonomi						= $this->data->risk_tasktonomi($post);
		$result['combo']						= $this->risk_context($data_parent);
		$result['risk_criteria']				= $this->risk_criteria($data_parent);
		$result['risk_appetite']				= $this->risk_appetite($data_parent);
		$result['risk_register']				= $this->risk_register($data_parent);
		$result['efektifitas_control']			= $this->risk_efektifitas_control($data_parent);
		$result['progress_treatment']			= $this->risk_progress_treatment($data_progress_treatment);
		$result['loss_event_database']			= $this->lost_event_database($data_parent);
		$result['early_warning']				= $this->risk_early_warning($data_early_warning);
		$result['perubahan_level']				= $this->perubahan_level($post);
		$result['heatmap']						= $this->heatmap($post);
		$result['risk_distribution']			= $this->risk_distribution($post);
		$result['risk_categories']				= $this->risk_categories($post);
		$result['risk_tasktonomi']				= $this->risk_tasktonomi($data_tasktonomi);
		$result['grapik_efektifitas_control']	= $this->grapik_efektifitas_control($post);
		$result['grapik_progress_treatment']	= $this->grapik_progress_treatment($post);
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

	public function heatmap($data)
    {
        $data['data'] 		= $data;
		$tahun 				= $data[0]['periode_name'];
		$data['tahun']  	= $tahun;
		$data['mapping'] 	= $this->data->get_map_rcsa($data);
		$data['mapping2'] 	= $this->data->get_map_residual1($data);
        return $this->load->view('heatmap',$data,true);
    }


	public function risk_distribution($data)
    {
        $data['data'] 		= $data;
		$data				= $this->data->grafik($data);
        return $this->load->view('risk_distribution',$data,true);
    }

	public function risk_categories($data)
    {
        $data['data'] 		= $data;
		$data				= $this->data->grafik_categories($data);
        return $this->load->view('risk_categories',$data,true);
    }

	public function risk_tasktonomi($data)
    {
		$data['data'] 	= $data;
        return $this->load->view('tasktonomi',$data,true);
    }

	public function grapik_efektifitas_control($data)
    {
        $data['data'] 		= $data;
		$data				= $this->data->grapik_efektifitas_control($data);
        return $this->load->view('grapik_efektifitas_control',$data,true);
    }

	public function grapik_progress_treatment($data)
    {
        $data['data'] 		= $data;
		$data				= $this->data->grapik_progress_treatment($data);
        return $this->load->view('grapik_progress_treatment',$data,true);
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

	
}

/* End of file All_report.php */
/* Location: ./application/controllers/All_report.php */
