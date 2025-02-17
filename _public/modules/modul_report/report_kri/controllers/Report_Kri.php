<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Report_Kri extends BackendController
{
	var $table 			= "";
	var $post 			= array();
	var $sts_cetak 	= false;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('PdfTcp');
		$this->nil_tipe 			= 1;
		$this->set_Tbl_Master("bangga_view_report_kri");
		$this->cbo_periode 		= $this->get_combo('periode');
		$this->cbo_parent 		= $this->get_combo('parent-input');
		$this->cbo_parent_all = $this->get_combo('parent-input-all');
		$this->cbo_type 			= $this->get_combo('type-project');

		$this->set_Open_Tab('Report Risk Register');
		$this->addField(array('field' => 'owner_no', 'title' => 'Risk Owner', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => true, 'search' => true));
		$this->addField(array('field' => 'judul_assesment', 'input' => 'multitext', 'size' => 1000));
		$this->addField(array('field' => 'rcsa_no', 'input' => 'multitext', 'size' => 1000));
		$this->addField(array('field' => 'periode_name', 'input' => 'multitext', 'size' => 1000));
		$this->addField(array('field' => 'name', 'input' => 'multitext', 'size' => 1000));
		$this->addField(array('field' => 'iskri', 'input' => 'multitext', 'size' => 1000));
		$this->addField(array('field' => 'sasaran', 'input' => 'multitext', 'size' => 1000));
		$this->addField(array('field' => 'tupoksi', 'input' => 'multitext', 'size' => 1000));
		$this->addField(array('field' => 'register', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
		$this->set_Close_Tab();
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master));


		$this->set_Sort_Table($this->tbl_master, 'judul_assesment');
		$this->set_Table_List($this->tbl_master, 'judul_assesment', 'Judul Assesment');
		$this->set_Table_List($this->tbl_master, 'name', 'Risk Owner');
		$this->set_Table_List($this->tbl_master, 'sasaran', 'Jumlah Sasaran', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'tupoksi', 'Jumlah Peristiwa', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'periode_name', 'Periode', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'register', 'View Risk Register', 10, 'center', 'false', false);

		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');

		$this->_CHANGE_TABLE_MASTER(_TBL_RCSA);

		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('edit', false);
		$this->_SET_PRIVILEGE('delete', false);
		$this->_SET_PRIVILEGE('view', false);
		$this->tmp_data['setActionprivilege'] = false;
		$this->set_Close_Setting();
	}

	function listBox_REGISTER($row, $value)
	{

		$id 				= $row['l_rcsa_no'];
		$detail			=	$this->db->where('rcsa_no', $id)->where('iskri', 1)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$actDetail	=	$this->db->where('rcsa_no', $id)->order_by('bulan')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		$owner 			= $row['l_owner_no'];
		if(count($detail)>0){
			$result = '<i class="fa fa-search  disabled pointer" title="belum menitoring" data-id="' . $id . '" data-owner="' . $owner . '"></i>';
			if(count($actDetail)>0){
				$result = '<strong><i class="fa fa-search showRegister pointer" data-id="' . $id . '" data-owner="' . $owner . '"></i></strong>';
			}
		}
		
		return $result;
	}


	function update_OPTIONAL_CMD($id)
	{
		$result[] = array('posisi' => 'right', 'content' => '<a class="btn btn-warning btn-flat" style="width:100%;" data-content="Detail Risk Register" data-toggle="popover" href="' . base_url($this->modul_name . '/risk-event/' . $id) . '" data-original-title="" title=""><strong style="text-shadow: 1px 2px #020202;">START<br/>Risk Register</strong></a>');
		return $result;
	}

	function risk_event()
	{
		$id 							= intval($this->uri->segment(3));
		$data['parent'] 	= $this->db->where('id', $id)->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] 		= $this->data->get_peristiwa($id);
		$data['list']			= $this->load->view('list-peristiwa', $data, true);
		$this->template->build('risk-event', $data);
	}

	function get_param()
	{
		$id 						= intval($this->uri->segment(3));
		$data['field'] 	= $this->data->get_data_param($id);
		$result 				= $this->load->view('report', $data, true);
		return $result;
	}

	function SIDEBAR_LEFTx()
	{
		return TRUE;
	}

	function SIDEBAR_RIGHTx()
	{
		return TRUE;
	}

	function print_report()
	{
		$this->template->var_tmp('posisi', FALSE);
		$id_rcsa 						= intval($this->uri->segment(3));
		$data['field'] 			= $this->data->get_data_risk_register($id_rcsa);
		$data['rcsa'] 			= $this->data->get_data($data['field']['id_rcsa']);
		$data['id_rcsa'] 		= $data['field']['id_rcsa'];
		$data['id_parent'] 	= intval($this->uri->segment(3));
		$xx = array('field' => $data['field'], 'rcsa' => $data['rcsa']);
		$this->template->build('report-register', $data);
	}


	function get_register()
	{
		$id_rcsa 						= $this->input->post('id');
		$owner_no 					= $this->input->post('owner_no');
		$bulan 							= $this->input->post('bulan');
		$data['field'] 			= $this->data->get_data_risk_register($id_rcsa);
		$data['fieldxx'] 		= $this->data->get_data_risk_reg_acc($id_rcsa);
		$data['tgl'] 				= $this->data->get_data_tanggal($id_rcsa);
		$data['id_rcsa'] 		= $id_rcsa;
		$data['owner_no'] 	= $owner_no;
		$data['id'] 				= $id_rcsa;
		$parent_no 					= $this->data->get_data_parent($owner_no);
		$data['owner'] 			= $parent_no[0]['parent_no'];
		$data['divisi'] 		= $this->data->get_data_divisi($parent_no);
		$data['fields'] 		= $this->data->get_data_officer($id_rcsa);
		$data['tipe'] 			= 'cetak';
		$xx 								= array('field' => $data['field'], 'rcsa' => $data['id_rcsa']);
		$this->session->set_userdata('result_risk_register', $xx);
		$data['cbobulan']		= $this->get_combo('bulan');
		$data['bulan']			= $bulan;
		$data['log'] 				= $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_LOG_PROPOSE)->result_array();
		$result['register'] = $this->load->view('list_risk_register', $data, true);
		echo json_encode($result);
	}

	function cetak_excel()
	{
		$id_rcsa 		= $this->uri->segment(3);
		$owner_no 	= $this->uri->segment(4);
		$bulan 			= $this->uri->segment(5);
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '2048M');
		header("Content-type:appalication/vnd.ms-excel");
		header("content-disposition:attachment;filename=risk-register-KRI-" . $id_rcsa . ".xls");
		$data['field'] 		= $this->data->get_data_risk_register($id_rcsa);
		$data['fieldxx'] 	= $this->data->get_data_risk_reg_acc($id_rcsa);
		$data['tgl'] 			= $this->data->get_data_tanggal($id_rcsa);
		$data['id_rcsa'] 	= $id_rcsa;
		$data['owner_no'] = $owner_no;
		$data['id'] 			= $id_rcsa;

		$parent_no 				= $this->data->get_data_parent($owner_no);
		$data['owner'] 		= $parent_no[0]['parent_no'];
		$data['divisi'] 	= $this->data->get_data_divisi($parent_no);
		$data['fields'] 	= $this->data->get_data_officer($id_rcsa);
		$data['tipe'] 		= 'cetak';
		$xx 							= array('field' => $data['field'], 'rcsa' => $data['id_rcsa']);
		$this->session->set_userdata('result_risk_register', $xx);
		$data['cbobulan'] = $this->get_combo('bulan');
		$data['bulan'] 		= $bulan;
		$data['log'] 			= $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_LOG_PROPOSE)->result_array();
		$datax 						= $this->load->view('cetak_excel', $data, true);
		$html 						= $datax;
		echo $html;
		exit;
	}

	function cetak_pdf()
	{
		$id_rcsa 		= $this->uri->segment(3);
		$owner_no 	= $this->uri->segment(4);
		$bulan 			= $this->uri->segment(5);
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '2048M');

		$data['field'] 		= $this->data->get_data_risk_register($id_rcsa);
		$data['fieldxx'] 	= $this->data->get_data_risk_reg_acc($id_rcsa);
		$data['tgl']			= $this->data->get_data_tanggal($id_rcsa);
		$data['id_rcsa'] 	= $id_rcsa;
		$data['owner_no'] = $owner_no;
		$data['id'] 			= $id_rcsa;
		$parent_no 				= $this->data->get_data_parent($owner_no);
		$data['owner'] 		= $parent_no[0]['parent_no'];
		$data['divisi'] 	= $this->data->get_data_divisi($parent_no);
		$data['fields'] 	= $this->data->get_data_officer($id_rcsa);
		$data['tipe'] 		= 'cetak';
		$xx 							= array('field' => $data['field'], 'rcsa' => $data['id_rcsa']);
		$this->session->set_userdata('result_risk_register', $xx);
		$data['cbobulan'] = $this->get_combo('bulan');
		$data['bulan'] 		= $bulan;
		$data 						= $this->load->view('cetak_pdf', $data, true);
		$html 						= $data;
		echo $html;
	}

	function cetak_register()
	{

		$tipe 					= $this->uri->segment(3);
		$id 						= $this->uri->segment(4);
		$parent 				= $this->uri->segment(5);
		$data 					= $this->db->where('id', $id)->get(_TBL_RCSA)->row_array();
		$rows 					= $this->db->where('id', $data['owner_no'])->get(_TBL_OWNER)->row_array();
		$nama 					= $nama = 'Risk-Register-' . url_title($rows['name']);
		$id_rcsa				= $id;
		$data['id'] 		= $id;
		$data['tipe'] 	= $tipe;
		$data['owner'] 	= $parent;
		$data['fields'] = $this->data->get_data_officer($id_rcsa);
		$data['field'] 	= $this->data->get_data_risk_register($id);
		$data['tgl'] 		= $this->data->get_data_tanggal($id);
		$data['divisi'] =  $this->db->where('id', $parent)->get(_TBL_OWNER)->row();
		$hasil = $this->load->view('list_risk_register', $data, true);
		$cetak = 'register_' . $tipe;
		// $this->$cetak($hasil, $nama);
	}

	function register_excel($data, $nama = "Risk-Register")
	{
		header("Content-type:appalication/vnd.ms-excel");
		header("content-disposition:attachment;filename=" . $nama . ".xls");

		$html = $data;
		echo $html;
		exit;
	}

	function register_pdf($data, $nama = "Risk-Register")
	{
		$this->load->library('pdf');
		$tgl = date('d-m-Y');
		// $this->nmFile = _MODULE_NAME_ . '-' . $nama .'-'.$tgl.".pdf";
		$this->nmFile = $nama . '-' . $tgl . ".pdf";
		$this->pdfFilePath = download_path_relative($this->nmFile);

		$html = '<style>
				table {
					border-collapse: collapse;
				
				}

				// .test table > th > td {
				// 	border: 1px solid #ccc;
				// }
				</style>';


		// $html .= '<table width="100%" border="0"><tr><td width="100%" style="padding:20px;">';
		$html .= $data;
		// $html .= '</td></tr></table>';

		$pdf = $this->pdf->load('en-GB-x,legal,,,5,5,5,5,6,3');
		$pdf->AddPage(
			'L',
			'', // L - landscape, P - portrait
			'',
			'',
			'',
			10, // margin_left
			10, // margin right
			5, // margin top
			5, // margin bottom
			5, // margin header
			5
		); // margin footer

		$pdf->SetHeader('');

		// $pdf->SetHTMLHeader('');
		// $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822));
		// $pdf->SetHTMLFooter('<h1>ini Footer</h1>');
		// $pdf->SetFooter('|{PAGENO}|');
		$pdf->SetFooter('|{PAGENO} Dari {nb} Halaman|');
		$pdf->WriteHTML($html);
		ob_clean();

		$pdf->Output($this->pdfFilePath, 'F');
		redirect($this->pdfFilePath);

		return true;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */