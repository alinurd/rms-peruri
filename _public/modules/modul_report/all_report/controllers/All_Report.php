<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class All_Report extends BackendController {
	var $table 			= "";
	var $post 			= array();
	var $sts_cetak 	= false;

	// INDEX
	public function index()
	{
		$data['korporasi'] 		= $this->get_combo('parent-input');
		$data['periode']			= $this->get_combo('periode');
		$this->template->build('all_report',$data);
	}

	// GET GRAFIK
	function get_grafik(){
		$post																	= $this->input->post();
		$data_parent													= $this->data->risk_parent($post);
		$data_progress_treatment							= $this->data->risk_progress_treatment($post);
		$data_early_warning										= $this->data->risk_early_warning($post);
		$data_tasktonomi											= $this->data->risk_tasktonomi($post);
		$result['combo']											= $this->risk_context($data_parent);
		$result['risk_criteria']							= $this->risk_criteria($data_parent);
		$result['risk_appetite']							= $this->risk_appetite($data_parent);
		$result['risk_register']							= $this->risk_register($data_parent);
		$result['efektifitas_control']				= $this->risk_efektifitas_control($data_parent);
		$result['progress_treatment']					= $this->risk_progress_treatment($data_progress_treatment);
		$result['loss_event_database']				= $this->lost_event_database($data_parent);
		$result['early_warning']							= $this->risk_early_warning($data_early_warning);
		$result['perubahan_level']						= $this->perubahan_level($post); 
		$result['heatmap']										= $this->heatmap($post);
		$result['risk_distribution']					= $this->risk_distribution($post);
		$result['risk_categories']						= $this->risk_categories($post);
		$result['risk_tasktonomi']						= $this->risk_tasktonomi($data_tasktonomi);
		$result['grapik_efektifitas_control']	= $this->grapik_efektifitas_control($post);
		$result['grapik_progress_treatment']	= $this->grapik_progress_treatment($post);
		echo json_encode($result);
	}

	// RISK CONTEXT
	public function risk_context($data)
	{
			$data['data'] 	= $data;
			$tahun 					= $data[0]['periode_name'];
			$data['tahun']  = $tahun;
			return $this->load->view('risk_context',$data,true);
	}

	// RISK KRITERIA
	public function risk_criteria($data)
	{
		$data['data'] 	= $data;
		$tahun 					= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
			return $this->load->view('risk_criteria',$data,true);
	}

	// RISK APPETITE
	public function risk_appetite($data)
	{
		$data['data'] 	= $data;
		$tahun 					= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
			return $this->load->view('risk_appetite',$data,true);
	}

	// RISK REGISTER
	public function risk_register($data)
	{
			$data['data'] 	= $data;
			$tahun 					= $data[0]['periode_name'];
			$data['tahun']  = $tahun;
			return $this->load->view('risk_register',$data,true);
	}

	// RISK EFEKTIFITAS CONTROL
	public function risk_efektifitas_control($data)
	{
		$data['data'] 	= $data;
		$tahun 					= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
			return $this->load->view('efektifitas_control',$data,true);
	}

	// RISK PROGRESS TREATMENT
	public function risk_progress_treatment($data)
	{
			$data['data'] 	= $data;
			$tahun 					= $data[0]['periode_name'];
			$data['tahun']  = $tahun;
			return $this->load->view('progress_treatment',$data,true);
	}

	// RISK LOST EVENT DATABASE
	public function lost_event_database($data)
	{
		$data['data'] 							= $data;
		$tahun 											= $data[0]['periode_name'];
		$data['tahun']  						= $tahun;
		$data['kategori_kejadian'] 	= $this->get_combo('data-combo', 'kat-kejadian');
		$data['frekuensi_kejadian'] = $this->get_combo('data-combo', 'frek-kejadian');
		$data['kat_risiko'] 				=  $this->get_combo('tasktonimi', 'kategori_risiko_loss', '');
		$data['cboLike']    				= $this->get_combo('likelihood');
		$data['cboImpact'] 					= $this->get_combo('impact');
		return $this->load->view('loss_event_database',$data,true);
	}

	// RISK ERLY WARNING
	public function risk_early_warning($data)
	{
		$data['data'] 	= $data;
		$tahun 			= $data[0]['periode_name']; 
		$data['tahun']  = $tahun;
		return $this->load->view('early_warning',$data,true);
	}

	public function perubahan_level($data){
		$data['data'] 	= $data;
		$tahun 					= $data[0]['periode_name'];
		$data['tahun']  = $tahun;
        return $this->load->view('perubahan_level',$data,true);
	}

	public function heatmap($data)
	{
		$data['data'] 			= $data; 
		$tahun 							= $data[0]['periode_name'];
		$data['tahun']  		= $tahun;
		$data['mapping'] 		= $this->data->get_map_rcsa($data);
		return $this->load->view('heatmap',$data,true);
	}

	function get_map_residual()
	{
		$post 	= $this->input->post();
		$data 	= $this->data->get_map_rcsa($post);
		$hasil 	= $data;
		echo json_encode($hasil);

	}


	public function risk_distribution($data)
    {
        $data['data'] 		= $data;
				$data							= $this->data->grafik($data);
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
				$data							= $this->data->grapik_efektifitas_control($data);
        return $this->load->view('grapik_efektifitas_control',$data,true);
    }

	public function grapik_progress_treatment($data)
    {
        $data['data'] 		= $data;
		$data				= $this->data->grapik_progress_treatment($data);
        return $this->load->view('grapik_progress_treatment',$data,true);
    }

    public function downloadPdf()
    {
        // Decode JSON input
        $json_input = json_decode($this->input->raw_input_stream, true);
        
        // Extract parameters from JSON input
        $periode_no                 = $json_input['periode_no'] ?? null;
        $owner_no                   = $json_input['owner_no'] ?? null;
        $grafik_heatmap             = $json_input['heatmap'] ?? null;
        $grafik_distribution        = $json_input['risk_distribution'] ?? null;
        $grafik_category            = $json_input['risk_categories'] ?? null;
        $grafik_efektifitas_control = $json_input['risk_efektifitas_control'] ?? null;
        $grafik_progress_treatment  = $json_input['risk_progress_treatment'] ?? null;
    
        // Initialize image paths
        $image_paths = [
            'heatmap'               => null,
            'distribution'          => null,
            'category'              => null,
            'efektifitas_control'   => null,
            'progress_treatment'    => null,
        ];
				
        // Clear existing images in the folder
        $folder_path = 'themes/upload/grafik/';
        $files = glob($folder_path . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    
        // Function to save base64 image
        $saveImage = function($base64_string, $type, &$image_path) {
            if ($base64_string) {
                $base64_string  = str_replace('data:image/png;base64,', '', $base64_string);
                $decoded_image  = base64_decode($base64_string);
                $image_path     = "themes/upload/grafik/{$type}_image_" . time() . ".png";
                if (file_put_contents($image_path, $decoded_image) === false) {
                    log_message('error', "Gagal menyimpan gambar {$type}: " . $image_path);
                    $image_path = null;
                }
            }
        };
    
        // Save images
        $saveImage($grafik_heatmap, 'heatmap', $image_paths['heatmap']);
        $saveImage($grafik_distribution, 'distribution', $image_paths['distribution']);
        $saveImage($grafik_category, 'category', $image_paths['category']);
        $saveImage($grafik_efektifitas_control, 'efektifitas_control', $image_paths['efektifitas_control']);
        $saveImage($grafik_progress_treatment, 'progress_treatment', $image_paths['progress_treatment']);
    
        // Prepare data for the PDF
        $data = [
            'periode_no'                => $periode_no,
            'id_owner'                  => $owner_no,
            'parent'                    => $this->data->risk_parent(['periode_no' => $periode_no, 'owner_no' => $owner_no]),
            'kategori_kejadian'         => $this->get_combo('data-combo', 'kat-kejadian'),
            'frekuensi_kejadian'        => $this->get_combo('data-combo', 'frek-kejadian'),
            'kat_risiko'                => $this->get_combo('tasktonimi', 'kategori_risiko_loss', ''),
            'cboLike'                   => $this->get_combo('likelihood'),
            'cboImpact'                 => $this->get_combo('impact'),
            'heatmap'                   => $image_paths['heatmap'],
            'risk_distribution'         => $image_paths['distribution'],
            'risk_category'             => $image_paths['category'],
            'risk_efektifitas_control'  => $image_paths['efektifitas_control'],
            'risk_progress_treatment'   => $image_paths['progress_treatment'],
            'early_warning'             => $this->data->risk_early_warning(['periode_no' => $periode_no, 'owner_no' => $owner_no]),
            'tasktonomi'                => $this->data->risk_tasktonomi(['periode_no' => $periode_no, 'owner_no' => $owner_no]),
        ];
        
    
        // Generate PDF
        $rows   = $this->db->where('id', $owner_no)->get(_TBL_OWNER)->row_array();
        $nama   = 'All-Report-' . url_title($rows['name']);
        $hasil  = $this->load->view('cetak_all_report', $data, true);
        $cetak  = 'cetak_pdf';
        $this->$cetak($hasil, $nama);
    }

    public function cetak_pdf($data, $nama = "All-Report")
    {
        // doi::dump($data);
        // die;
        // $this->load->library('pdf');
        $tgl = date('d-m-Y');
        $this->nmFile = $nama . '-' . $tgl . ".pdf";
        $this->pdfFilePath = download_path_relative($this->nmFile);
        $html = "";
        $html .= $data;
        $pdf = $this->pdf->load();
        $font = [
            'fontawesome' => [
                'R' => FCPATH . 'themes/default/assets/fonts/fontawesome-webfont.ttf',
                'B' => FCPATH . 'themes/default/assets/fonts/fontawesome-webfont.ttf',
            ],
        ];

        $pdf->fontdata = array_merge($pdf->fontdata, $font);
        $pdf->default_font = 'fontawesome';
        $pdf->AddPage('L', 'A4', '', '', '', 10, 10, 10, 10, 5, 5);
        $pdf->setTitle($nama);
        $pdf->SetDisplayMode('real');
        $pdf->SetHeader('');
        $pdf->setFooter('|{PAGENO} Dari {nb} Halaman|');
        $pdf->WriteHTML($html);
        ob_clean();
        $pdf->Output($this->pdfFilePath, 'F');
        redirect($this->pdfFilePath);
        return true;
    }

    public function exportExcel()
    {
        $owner_no   = $this->input->get('owner_no');
        $periode_no = $this->input->get('periode_no');
        $get        = $this->input->get();

        if (empty($owner_no) || empty($periode_no)) {
            echo "Parameter tidak lengkap!";
            return;
        }

        $parent = $this->data->risk_parent($get);

        $data =$this->data->risk_progress_treatment($get);
        // Set header untuk file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="data_export_' . $owner_no . '_' . $periode_no . '.xls"');
        header('Cache-Control: max-age=0');

        // Muat view untuk mengeluarkan data dalam format Excel
        $this->load->view('excel_progress_treatment', ['progress_treatment' => $data,'parent' => $parent]);
    }



		public function get_detail_map()
		{
			$post 	= $this->input->post();
			$a 		= $this->db->select('id,level_no')->where('id', $post['owner'])->get(_TBL_OWNER)->result_array();
			$b 		= array();
			foreach ($a as $key => $value) {
				$b 	= $value['level_no'];
			}
	// doi::dump($post);
			$owner	= $post['owner'];
			$this->data->owner_child=array();
			$norut = isset($post['norut']) ? explode(',', $post['norut']) : [];
	
			if ($owner>0){
				$this->data->owner_child[]=$owner;
			}
	
			$this->data->get_owner_child($owner);
			$owner_child=$this->data->owner_child;
	
			if ($post['kel'] == 'Inherent') {
				$this->db->where('residual_likelihood', $post['like']);
				$this->db->where('residual_impact', $post['impact']);
				
				if ($post['tahun'] > 0) {
					$this->db->where('period_no', $post['tahun']);
				}
			}  
			if ($post['owner'] == 0 && $post['kel'] == 'Inherent') {
	 
				$rows = $this->db->where('sts_propose', 4)
					->where('urgensi_no', 0)
					->where('sts_heatmap', '1')
					// ->where_in('norut', $norut)
					->order_by('residual_likelihood', 'DESC')
					->order_by('residual_impact', 'DESC')
					->get(_TBL_VIEW_RCSA_DETAIL)
					->result_array();
			} elseif ($post['owner'] > 0 && $post['kel'] == 'inherent') {
				if ($b == 3) {
					$rows = $this->db->where('sts_propose', 4)
						->where('urgensi_no', 0)
						->where('sts_heatmap', '1')
						->where('parent_no', $post['owner'])
						->where('period_no', $post['tahun'])
						// ->where_in('norut', $norut)
						->order_by('residual_likelihood', 'DESC')
						->order_by('residual_impact', 'DESC')
						->get(_TBL_VIEW_RCSA_DETAIL)
						->result_array();
				} else {
					if ($owner_child){
						$this->db->where_in('owner_no',$owner_child);
					}else{
						$this->db->where('owner_no',$owner);
					}
					
					$rows = $this->db->where('sts_propose', 4)
						->where('urgensi_no', 0)
						->where('sts_heatmap', '1')
						// ->where_in('norut', $norut)
						->where('period_no', $post['tahun'])
						->order_by('residual_likelihood', 'DESC')
						->order_by('residual_impact', 'DESC')
						->get(_TBL_VIEW_RCSA_DETAIL)
						->result_array();
					
				}
			} else {
				// if ($b == 3) {
						$rows = $this->db->where('sts_propose', 4)
						->where('owner_no', $post['owner'])
						->where('urgensi_no', 0)
						->where('sts_heatmap', '1')
						->where_in('norut', $norut)
						->where('period_no', $post['tahun'])
						->order_by('residual_likelihood', 'DESC')
						->order_by('residual_impact', 'DESC')
						->get(_TBL_VIEW_RCSA_DETAIL)
						->result_array();
				
			}
			
			$a = $post['kel'];
			$hasil['combo'] = $this->load->view('detail', ['data' => $rows, 'kel' => $a,'bulan' => $post['bulan']], true);
			echo json_encode($hasil);
		}
	
	
		public function get_detail_map_res()
		{
			$post 	= $this->input->post();
			$a 			= $this->db->select('id,level_no')->where('id', $post['owner'])->get(_TBL_OWNER)->result_array();
			$b 			= array();
			
			foreach ($a as $key => $value) {
				$b = $value['level_no'];
			}
	
			$owner	= $post['owner'];
			$this->data->owner_child=array();
	
			if ($owner>0){
				$this->data->owner_child[]=$owner;
			}
	
			$this->data->get_owner_child($owner);
			$owner_child=$this->data->owner_child;
	
			if ($post['kel'] =='Current') {
	
				$this->db->where('bangga_view_rcsa_action_detail.residual_likelihood_action', $post['like']);
				$this->db->where('bangga_view_rcsa_action_detail.residual_impact_action', $post['impact']);
				if ($post['bulan'] > 0) {
					$this->db->where("bangga_view_rcsa_action_detail.bulan = {$post['bulan']}");
				}
				
				if ($post['tahun'] > 0) {
					$this->db->where('bangga_view_rcsa_action_detail.period_no', $post['tahun']);
				}
	
			}  
			 
			if ($owner_child){
				$this->db->where_in('bangga_view_rcsa_action_detail.owner_no',$owner_child);
			}else{
				$this->db->where('bangga_view_rcsa_action_detail.owner_no',$owner);
			}
			// doi::dump($post);
			$this->db->where("bangga_view_rcsa_action_detail.bulan = {$post['bulan']}");
			$rows = $this->db->select('bangga_view_rcsa_detail.bulan as bulan_rcsa, bangga_view_rcsa_detail.*, bangga_view_rcsa_action_detail.*,bangga_view_rcsa_detail.id as id_detail')
					->from("bangga_view_rcsa_action_detail")
					->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_view_rcsa_action_detail.rcsa_detail_no')  
					->where('bangga_view_rcsa_action_detail.sts_propose', 4)
					->where('bangga_view_rcsa_action_detail.urgensi_no', 0)
					->where('bangga_view_rcsa_detail.sts_heatmap', '1')
					// ->where_in('bangga_view_rcsa_detail.norut', $post['norut'])
					// ->where('bangga_view_rcsa_action_detail.bulan', $post['bulan'])
					// ->where('bangga_view_rcsa_action_detail.owner_no', $post['owner'])
					->where('bangga_view_rcsa_action_detail.period_no', $post['tahun']) 
					->get()
					->result_array();
	
			// die($this->db->last_query());
			// doi::dump($rows);
			$a = $post['kel'];
			$hasil['combo'] = $this->load->view('detailres', ['data' => $rows, 'kel' => $a,], true);
			echo json_encode($hasil);
		}
	
		public function get_detail_map_target()
		{
			$post 	= $this->input->post();
			$a 		= $this->db->select('id,level_no')->where('id', $post['owner'])->get(_TBL_OWNER)->result_array();
			$b 		= array();
			foreach ($a as $key => $value) {
				$b = $value['level_no'];
			}
	
			$owner	= $post['owner'];
			$this->data->owner_child=array();
	
			if ($owner>0){
				$this->data->owner_child[]=$owner;
			}
	
			$this->data->get_owner_child($owner);
			$owner_child=$this->data->owner_child;
	
			if ($post['kel'] == 'Target') {
				$this->db->where('bangga_analisis_risiko.target_like', $post['like']);
				$this->db->where('bangga_analisis_risiko.target_impact', $post['impact']);
				$this->db->where('bangga_analisis_risiko.bulan', 12);
			
				if ($post['tahun'] > 0) {
					$this->db->where('bangga_view_rcsa_detail.period_no', $post['tahun']);
				}
	
			} else {
				$this->db->where('bangga_view_rcsa_detail.risk_level_action', $post['id']);
			}
	
	
			if ($post['owner'] == 0 && $post['kel'] == 'Target') {
				
				$rows = $this->db->select('*,bangga_analisis_risiko.bulan as bulan_target') 
									->from("bangga_analisis_risiko")
									->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_analisis_risiko.id_detail', 'left') // Ganti dengan tabel dan kondisi yang sesuai
									->where('bangga_view_rcsa_detail.sts_propose', 4)
									->where('bangga_view_rcsa_detail.urgensi_no', 0)
									->where('bangga_view_rcsa_detail.sts_heatmap', '1')
									->order_by('bangga_analisis_risiko.target_like', 'DESC')
									->order_by('bangga_analisis_risiko.target_impact', 'DESC')
									->get()
									->result_array();
			} elseif ($post['owner'] == 0 && $post['kel'] == 'Target') {
				$rows = $this->db->select('*,bangga_analisis_risiko.bulan as bulan_target') 
					->from("bangga_analisis_risiko")
					->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_analisis_risiko.id_detail', 'left') // Ganti dengan tabel dan kondisi yang sesuai
					->where('bangga_view_rcsa_detail.sts_propose', 4)
					->where('bangga_view_rcsa_detail.urgensi_no', 0)
					->where('bangga_view_rcsa_detail.sts_heatmap', '1')
					->where('bangga_view_rcsa_detail.parent_no', $post['owner'])
					->where('bangga_view_rcsa_detail.period_no', $post['tahun'])
									->order_by('bangga_analisis_risiko.target_like', 'DESC')
									->order_by('bangga_analisis_risiko.target_impact', 'DESC')
									->get()
									->result_array();
			} elseif ($post['owner'] > 0 && $post['kel'] == 'Target') {
				if ($b == 3) {
					$rows = $this->db->select('*,bangga_analisis_risiko.bulan as bulan_target') 
					->from("bangga_analisis_risiko")
					->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_analisis_risiko.id_detail', 'left') // Ganti dengan tabel dan kondisi yang sesuai
					->where('bangga_view_rcsa_detail.sts_propose', 4)
					->where('bangga_view_rcsa_detail.urgensi_no', 0)
					->where('bangga_view_rcsa_detail.sts_heatmap', '1')
					->where('bangga_view_rcsa_detail.parent_no', $post['owner'])
					->where('bangga_view_rcsa_detail.period_no', $post['tahun'])
									->order_by('bangga_analisis_risiko.target_like', 'DESC')
									->order_by('bangga_analisis_risiko.target_impact', 'DESC')
									->get()
									->result_array();
				} else {
	
					if ($owner_child){
						$this->db->where_in('bangga_view_rcsa_detail.owner_no',$owner_child);
					}else{
						$this->db->where('bangga_view_rcsa_detail.owner_no',$owner);
					}
	
					$rows = $this->db->select('*,bangga_analisis_risiko.bulan as bulan_target') 
					->from("bangga_analisis_risiko")
					->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_analisis_risiko.id_detail', 'left') // Ganti dengan tabel dan kondisi yang sesuai
					->where('bangga_view_rcsa_detail.sts_propose', 4)
					->where('bangga_view_rcsa_detail.urgensi_no', 0)
					->where('bangga_view_rcsa_detail.sts_heatmap', '1')
					->where('bangga_view_rcsa_detail.period_no', $post['tahun'])
									->order_by('bangga_analisis_risiko.target_like', 'DESC')
									->order_by('bangga_analisis_risiko.target_impact', 'DESC')
									->get()
									->result_array();
				}
			} else {
				if ($b == 3) {
	
					if ($owner_child){
						$this->db->where_in('bangga_view_rcsa_action_detail.owner_no',$owner_child);
					}else{
						$this->db->where('bangga_view_rcsa_action_detail.owner_no',$owner);
					}
	
					$rows = $this->db->select('*') 
									->from("bangga_view_rcsa_action_detail")
									->join('bangga_view_rcsa_detail', 'bangga_view_rcsa_detail.id = bangga_view_rcsa_action_detail.rcsa_detail_no', 'left') // Ganti dengan tabel dan kondisi yang sesuai
									->where('bangga_view_rcsa_action_detail.sts_propose', 4)
									->where('bangga_view_rcsa_action_detail.urgensi_no', 0)
									->where('bangga_view_rcsa_detail.sts_heatmap', '1')
					->where('bangga_view_rcsa_action_detail.period_no', $post['tahun'])
									->order_by('bangga_view_rcsa_detail.inherent_likelihood', 'DESC')
									->order_by('bangga_view_rcsa_detail.inherent_impact', 'DESC')
									->order_by('bangga_view_rcsa_action_detail.residual_likelihood_action', 'DESC')
									->order_by('bangga_view_rcsa_action_detail.residual_impact_action', 'DESC')
									->get()
									->result_array();
	
					// $this->owner_child[] = $post['post'];
					// $this->db->where_in('rcsa_owner_no', $this->owner_child);
					// $rows['bobo'] = $this->db
					// 	->where('sts_propose', 4)
					// 	->where('urgensi_no ', 0)->where('parent_no', $post['owner'])
					// 	->where('period_no', $post['tahun'])
					 // 	->where('bulan <=', $post['bulan'])->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
				} else {
	
					$rows['bobo'] = $this->db->where('sts_propose', 4)
						->where('urgensi_no ', 0)
						->where('owner_no', $post['owner'])
						->where('period_no', $post['tahun'])
						->where('bulan', $post['bulan'])
						 ->order_by('residual_analisis_id', 'DESC')->order_by('residual_analisis_id', 'DESC')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
				}
			}
			if ($post['kel'] == 'Target') {
				foreach ($rows as &$row) {
					$arrCouse = json_decode($row['risk_couse_no'], true);
					$rows_couse = array();
					if ($arrCouse) {
						$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
					}
					$arrCouse = array();
					foreach ($rows_couse as $rc) {
						$arrCouse[] = $rc['description'];
					}
					$row['couse'] = implode(', ', $arrCouse);
	
					$arrCouse = json_decode($row['risk_impact_no'], true);
					$rows_couse = array();
					if ($arrCouse) {
						$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
					}
					$arrCouse = array();
					foreach ($rows_couse as $rc) {
						$arrCouse[] = $rc['description'];
					}
					$row['impact'] = implode(', ', $arrCouse);
				}
				unset($row);
			} else {
				$rows['baba'] = array();
	
				foreach ($rows['bobo'] as $key => $value) {
				
					if ($post['owner'] > 0 && $b == 3) {
						$this->db->where('parent_no', $post['owner']);
						$this->db->where('period_no', $post['tahun']);
						$this->db->where('id', $value['rcsa_detail_no']);
					} elseif ($post['owner'] > 0) {
						$this->db->where('owner_no', $post['owner']);
						$this->db->where('period_no', $post['tahun']);
						$this->db->where('id', $value['rcsa_detail_no']);
					} else {
						$this->db->where('period_no', $post['tahun']);
						$this->db->where('id', $value['rcsa_detail_no']);
					}
	
	
					$row = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
	
					if ($row) {
						foreach ($row as $key1 => $value1) {
							$rows['baba'][$value['rcsa_detail_no']]['residual_analisis'] = $value1['residual_analisis'];
							$rows['baba'][$value['rcsa_detail_no']]['warna'] = $value1['warna'];
							$rows['baba'][$value['rcsa_detail_no']]['warna_text'] = $value1['warna_text'];
						}
					} else {
						$rows['baba'][$value['rcsa_detail_no']]['residual_analisis'] = "";
						$rows['baba'][$value['rcsa_detail_no']]['warna'] = "";
						$rows['baba'][$value['rcsa_detail_no']]['warna_text'] = "";
					}
				}
			}
	
			$a = $post['kel'];
			$hasil['combo'] = $this->load->view('detail_target', ['data' => $rows, 'kel' => $a,], true);
			echo json_encode($hasil);
		}

    function get_subdetail()
	{
		$post = $this->input->post();
		$this->db->where('id', $post['id']);
		$row = $this->db->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$arrCouse = json_decode($row['risk_couse_no'], true);
		$rows_couse = array();
		if ($arrCouse) {
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
		}
		$arrCouse = array();
		foreach ($rows_couse as $rc) {
			$arrCouse[] = $rc['description'];
		}
		$row['couse'] = implode(', ', $arrCouse);

		$arrCouse = json_decode($row['risk_impact_no'], true);
		$rows_couse = array();
		if ($arrCouse) {
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
		}
		$arrCouse = array();
		foreach ($rows_couse as $rc) {
			$arrCouse[] = $rc['description'];
		}
		$row['impact'] = implode(', ', $arrCouse);

		$hasil['data'] = $row;

		$this->db->where('rcsa_detail_no', $post['id']);
		$rows = $this->db->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();

		foreach ($rows as &$row) {
			$arrCouse = json_decode($row['accountable_unit'], true);
			$rows_couse = array();
			if ($arrCouse) {
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			}
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['name'];
			}

			$row['penanggung_jawab'] = implode('### ', $arrCouse);
		}
		unset($row);

		$hasil['mitigasi'] = $rows;

		$this->db->where('rcsa_detail_no', $post['id']);
		$row = $this->db->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();

		$this->db->where('id_detail', $post['id']);
		$target_level  = $this->db->get(_TBL_ANALISIS_RISIKO)->result_array();
		// die($this->db->last_query());

		$hasil['realisasi']    = $row;
		$hasil['target_level'] = $target_level;

		$hasil['combo'] = $this->load->view('subdetail', $hasil, true);

		echo json_encode($hasil);
	}

	function get_subdetailTarget()
	{
		$post 		= $this->input->post();
		$this->db->where('id', $post['id']);
		$row 		= $this->db->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$arrCouse 	= json_decode($row['risk_couse_no'], true);
		$rows_couse = array();
		if ($arrCouse) {
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
		}
		$arrCouse = array();
		foreach ($rows_couse as $rc) {
			$arrCouse[] = $rc['description'];
		}
		$row['couse'] = implode(', ', $arrCouse);

		$arrCouse = json_decode($row['risk_impact_no'], true);
		$rows_couse = array();
		if ($arrCouse) {
			$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_LIBRARY)->result_array();
		}
		$arrCouse = array();
		foreach ($rows_couse as $rc) {
			$arrCouse[] = $rc['description'];
		}
		$row['impact'] = implode(', ', $arrCouse);

		$hasil['data'] = $row;

		$this->db->where('rcsa_detail_no', $post['id']);
		$rows = $this->db->get(_TBL_VIEW_RCSA_MITIGASI)->result_array();

		foreach ($rows as &$row) {
			$arrCouse = json_decode($row['accountable_unit'], true);
			$rows_couse = array();
			if ($arrCouse) {
				$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
			}
			$arrCouse = array();
			foreach ($rows_couse as $rc) {
				$arrCouse[] = $rc['name'];
			}

			$row['penanggung_jawab'] = implode('### ', $arrCouse);
		}
		unset($row);


		$this->db->where('rcsa_detail_no', $post['id']);
		$this->db->where('bulan', $post['bulan']);
		$row = $this->db->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();

		$this->db->where('id_detail', $post['id']);
		$this->db->where('bulan', $post['bulan']);
		$target_level  = $this->db->get(_TBL_ANALISIS_RISIKO)->result_array();
		// die($this->db->last_query());

		$hasil['realisasi']    = $row;
		$hasil['target_level'] = $target_level;

		$hasil['combo'] = $this->load->view('subdetail_target', $hasil, true);

		echo json_encode($hasil);
	}

    
    public function exportExcelRegister()
    {
        $owner_no   = $this->input->get('owner_no');
        $periode_no = $this->input->get('periode_no');
        $get        = $this->input->get();

        if (empty($owner_no) || empty($periode_no)) {
            echo "Parameter tidak lengkap!";
            return;
        }

        $parent = $this->data->risk_parent($get);

        $owner_name = $parent[0]['name'];
        $owner_name = str_replace(' ', '_', $owner_name);
        $tahun      = $parent[0]['periode_name'];
        // doi::dump($parent[0]['name']);
        // die;
        // $data =$this->data->risk_progress_treatment($get);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Report_risk_register_' . $owner_name . '_' . $tahun . '.xls"');
        header('Cache-Control: max-age=0');

        // Muat view untuk mengeluarkan data dalam format Excel
        $this->load->view('cetak_excel_risk_register', ['data' => $parent]);
    }


	
}

/* End of file All_report.php */
/* Location: ./application/controllers/All_report.php */
