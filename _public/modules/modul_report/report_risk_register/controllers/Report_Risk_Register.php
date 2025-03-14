<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Report_Risk_Register extends BackendController {
	var $table = "";
	var $post = array();
	var $sts_cetak = false;
	
	public function __construct()
	{
        parent::__construct();
		$this->nil_tipe = 1;
		$this->set_Tbl_Master(_TBL_VIEW_RCSA);
		$this->cbo_periode = $this->get_combo('periode');
		$this->cbo_parent = $this->get_combo('parent-input');
		$this->cbo_parent_all = $this->get_combo('parent-input-all');
		$this->cbo_type = $this->get_combo('type-project');		
		
		$this->set_Open_Tab('Report Risk Register');
			$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 4));
			$this->addField(array('field' => 'owner_no','title'=>'Risk Owner', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => true, 'search' => true));
			$this->addField(array('field' => 'officer_no', 'show'=>false, 'save'=>true, 'default'=>$this->authentication->get_info_user('identifier')));
			$this->addField(array('field' => 'create_user', 'search' =>false, 'default'=>$this->authentication->get_info_user('username')));
			$this->addField(array('field' => 'period_no','title'=>'Periode', 'input' => 'combo', 'combo' => $this->cbo_periode, 'size' => 15, 'search' => true, 'required' => true));
			$this->addField(array('field' => 'anggaran_rkap', 'type'=>'float', 'input'=>'float', 'required' => true));
			$this->addField(array('field' => 'owner_pic', 'size' => 100, 'search' => false));
			$this->addField(array('field' => 'anggota_pic', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'tugas_pic', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'tupoksi', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'sasaran', 'type' => 'free', 'input' => 'free', 'mode' =>'e'));
			
			$this->addField(array('field' => 'item_use', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
			$this->addField(array('field' => 'register', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
			$this->addField(array('field' => 'status', 'input' => 'boolean', 'size' => 15));
			$this->addField(array('field' => 'name', 'show' => false));
			$this->addField(array('field' => 'periode_name', 'show' => false));
			$this->addField(array('field' => 'sts_propose_text', 'show' => false));
			$this->addField(array('field' => 'sts_propose', 'show' => false));
		$this->set_Close_Tab();
		$this->set_Open_Tab('Isu Internal');
			$this->addField(array('field' => 'man', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'method', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'machine', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'money', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'material', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'market', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'stakeholder_internal', 'type' => 'free', 'input' => 'free', 'mode' =>'e'));
		$this->set_Close_Tab();
		$this->set_Open_Tab('Isu External');
			$this->addField(array('field' => 'politics', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'economics', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'social', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'tecnology', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'environment', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'legal', 'input' => 'multitext', 'size' => 1000));
			$this->addField(array('field' => 'stakeholder_external', 'type' => 'free', 'input' => 'free', 'mode' =>'e'));
		$this->set_Close_Tab();
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master));

		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'anggaran_rkap', 'span_right_addon' => ' Rp ', 'align' => 'right'));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'create_user', 'readonly' => true));

		$this->set_Sort_Table($this->tbl_master, 'urut_owner');

		$this->set_Table_List($this->tbl_master, 'name','Risk Owner');
		$this->set_Table_List($this->tbl_master, 'sasaran', 'Jumlah Sasaran', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'tupoksi', 'Jumlah Peristiwa', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'periode_name','Periode',10,'center');
		// $this->set_Table_List($this->tbl_master, 'item_use', '', 8, 'center');
		$this->set_Table_List($this->tbl_master, 'register', 'View Risk Register', 10, 'center','false',false);

		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		// $this->set_Where_Table($this->tbl_master, 'type', '=', $this->nil_tipe);
		$this->_CHANGE_TABLE_MASTER(_TBL_RCSA);

		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('edit', false);
		$this->_SET_PRIVILEGE('delete', false);
		$this->_SET_PRIVILEGE('view', false);
		$this->tmp_data['setActionprivilege']=false;
		$this->set_Close_Setting();
	}
		function listBox_REGISTER($row, $value)
	{
		$id = $row['l_id'];
		$owner = $row['l_owner_no'];
		$result = '<i class="fa fa-search showRegister pointer" data-id="' . $id . '" data-owner="' . $owner . '"></i>';
		return $result;
	}
		function update_OPTIONAL_CMD($id)
	{
		$result[] = array('posisi' => 'right', 'content' => '<a class="btn btn-warning btn-flat" style="width:100%;" data-content="Detail Risk Register" data-toggle="popover" href="' . base_url($this->modul_name . '/risk-event/' . $id) . '" data-original-title="" title=""><strong style="text-shadow: 1px 2px #020202;">START<br/>Risk Register</strong></a>');
		return $result;
	}
		function listBox_SASARAN($rows, $value){
		$id=$rows['l_id'];
		$jml='';
		if (array_key_exists($id, $this->use_list['sasaran'])){
			$jml = $this->use_list['sasaran'][$id];
		}

		return $jml;
	}
	public function MASTER_DATA_LIST($arrId, $rows)
	{
		$this->use_list = $this->data->cari_total_dipakai($arrId);
	}
		function listBox_TUPOKSI($rows, $value){
		$id=$rows['l_id'];
		$jml='';
		if (array_key_exists($id, $this->use_list['peristiwa'])){
			$jml = $this->use_list['peristiwa'][$id];
		}

		return $jml;
	}
	
	function risk_event(){
		$id=intval($this->uri->segment(3));
		$data['parent']=$this->db->where('id', $id)->get(_TBL_VIEW_RCSA)->row_array();
		$data['field']=$this->data->get_peristiwa($id);
		$data['list'] = $this->load->view('list-peristiwa', $data, true);
		$this->template->build('risk-event', $data);
	}
	
	function get_param(){
		$id=intval($this->uri->segment(3));
		$data['field']=$this->data->get_data_param($id);
		$result=$this->load->view('report',$data,true);
		return $result;
	}
	
	function SIDEBAR_LEFTx(){
		return TRUE;
	}
	
	function SIDEBAR_RIGHTx(){
		return TRUE;
	}
	
	function print_report(){	
		$this->template->var_tmp('posisi',FALSE);
		$id_rcsa=intval($this->uri->segment(3));
		$data['field'] = $this->data->get_data_risk_register($id_rcsa);
		// doi::dump($data['field']);die();
		$data['rcsa'] = $this->data->get_data($data['field']['id_rcsa']);
		$data['id_rcsa'] = $data['field']['id_rcsa'];
		$data['id_parent']=intval($this->uri->segment(3));
		$xx=array('field'=>$data['field'], 'rcsa'=>$data['rcsa']);
		// $this->session->set_userdata('result_risk_register', $xx);
		$this->template->build('report-register',$data); 
	}
	function get_register()
	{
		$id_rcsa = $this->input->post('id');
		$owner_no = $this->input->post('owner_no');
		$data['field'] = $this->data->get_data_risk_register($id_rcsa);
		$data['fieldxx'] = $this->data->get_data_risk_reg_acc($id_rcsa);
		$data['tgl'] = $this->data->get_data_tanggal($id_rcsa);
		$data['id_rcsa'] = $id_rcsa;
		$data['id'] = $id_rcsa;

		$parent_no = $this->data->get_data_parent($owner_no);
		$data['owner'] = $parent_no[0]['parent_no'];
		$data['divisi'] = $this->data->get_data_divisi($parent_no);
		$data['fields'] = $this->data->get_data_officer($id_rcsa);
		$data['tipe'] = 'cetak';
		$xx = array('field' => $data['field'], 'rcsa' => $data['id_rcsa']);
		$this->session->set_userdata('result_risk_register', $xx);

		$data['log'] = $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_LOG_PROPOSE)->result_array();
		$result['register'] = $this->load->view('list_risk_register', $data, true);
		echo json_encode($result);
	}
	function cetak_register()
	{
		
		$tipe = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$parent = $this->uri->segment(5);
		$data = $this->db->where('id', $id)->get(_TBL_RCSA)->row_array();
		$rows = $this->db->where('id', $data['owner_no'])->get(_TBL_OWNER)->row_array();
		$nama = $nama = 'Risk-Register-' . url_title($rows['name']);
		
		$id_rcsa = $id;
		$data['id'] = $id;
		$data['tipe'] = $tipe;
		
		$data['owner'] = $parent;
		$data['fields'] = $this->data->get_data_officer($id_rcsa);
		$data['field'] = $this->data->get_data_risk_register($id);
		$data['tgl'] = $this->data->get_data_tanggal($id);
		
		$data['divisi'] =  $this->db->where('id', $parent)->get(_TBL_OWNER)->row();

		
		$hasil = $this->load->view('list_risk_register', $data, true);
		$cetak = 'register_' . $tipe;
		$this->$cetak($hasil, $nama);
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
		$this->nmFile = $nama .'-'.$tgl.".pdf";
		$this->pdfFilePath = download_path_relative($this->nmFile);

		$html = '<style>
				table {
					border-collapse: collapse;
				
				}

				td {
					border: 1px solid black;
					padding: 4px;
				}
				</style>';


		// $html .= '<table width="100%" border="0"><tr><td width="100%" style="padding:20px;">';
		$html .= $data;
		// $html .= '</td></tr></table>';

		$pdf = $this->pdf->load('en-GB-x,legal,,,5,5,5,5,6,3');
		$pdf->AddPage('L','', // L - landscape, P - portrait
		 '', '', '',
        10, // margin_left
        10, // margin right
        5, // margin top
        5, // margin bottom
        5, // margin header
        5); // margin footer

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