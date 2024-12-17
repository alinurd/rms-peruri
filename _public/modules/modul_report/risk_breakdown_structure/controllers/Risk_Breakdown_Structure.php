<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Risk_Breakdown_Structure extends BackendController {
	var $table = "";
	var $post = array();
	var $sts_cetak = false;
	
	public function __construct()
	{
        parent::__construct();
		$this->nil_tipe = 1;
		$this->master = $this->get_combo('risk-ishikawa');
		$this->set_Tbl_Master(_TBL_VIEW_RCSA);

		// $this->set_Tbl_Master(_TBL_RCSA_SASARAN);
		$this->cbo_periode = $this->get_combo('periode');
		$this->cbo_parent = $this->get_combo('parent-input');

		
		$this->set_Open_Tab('Risk Breakdown Structure');
			$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 4));
			$this->addField(array('field' => 'owner_no','title'=>'Risk Owner', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => false, 'search' => true));		
			$this->addField(array('field' => 'periode_name','title'=>'Periode', 'input' => 'combo', 'combo' => $this->cbo_periode, 'size' => 15, 'search' => false, 'required' => false));
			$this->addField(array('field' => 'item_use', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
			$this->addField(array('field' => 'register', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
			$this->addField(array('field' => 'sasaran', 'type' => 'free', 'input' => 'free', 'mode' =>'e'));
			$this->addField(array('field' => 'tupoksi', 'input' => 'multitext', 'size' => 1000));

			$this->addField(array('field' => 'name', 'show' => false));
			$this->addField(array('field' => 'judul_assesment', 'show' => false));
			// $this->addField(array('field' => 'event_name', 'show' => false));
			// $this->addField(array('field' => 'sasaran', 'show' => false));
		$this->set_Close_Tab();

		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master));

		// $this->set_Sort_Table($this->tbl_master, 'id');
		// $this->set_Where_Table($this->tbl_master,'rcsa_no','<>',0);
		$this->set_Sort_Table($this->tbl_master, 'name');

		$this->set_Table_List($this->tbl_master, 'judul_assesment','Judul Assesment');
		$this->set_Table_List($this->tbl_master, 'name','Risk Owner');
		// $this->set_Table_List($this->tbl_master, 'sasaran', 'Sasaran');
		$this->set_Table_List($this->tbl_master, 'sasaran', 'Jml Sasaran', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'tupoksi', 'Jml Peristiwa', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'periode_name','Periode',10,'center');
		
		$this->set_Table_List($this->tbl_master, 'register', 'View Risk Breakdown Structure', 10, 'center','false',false);
		// $this->set_Table_List($this->tbl_master, 'item_use', '', 8, 'center');
		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		// $this->set_Where_Table($this->tbl_master, 'type', '=', $this->nil_tipe);
		$this->_CHANGE_TABLE_MASTER(_TBL_VIEW_RCSA_DETAIL);

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
		$result = '<i class="fa fa-search showRegister pointer" data-id="' . $id . '" data-owner="'.$owner.'"></i>';
		return $result;
	}
		function update_OPTIONAL_CMD($tombol,$rows)
	{
		$id = $rows['l_id'];
		$owner = $rows['l_owner_no'];
		$result[] = array('posisi' => 'right', 'content' => '<a class="btn btn-warning btn-flat" style="width:100%;" data-content="Detail Risk Breakdown Structure" data-toggle="popover" href="' . base_url($this->modul_name . '/' . $id.'/'.$owner) . '" data-original-title="" title=""></a>');
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
		$owner = $this->input->post('owner');
		$id = $id_rcsa;
		$parent_no = $this->data->get_data_parent($owner);
		$data['owner'] = $parent_no[0]['parent_no'];
		$data['divisi'] = $this->data->get_data_divisi($parent_no);
		$data['id_rcsa'] = $id_rcsa;
		$data['field'] = $this->data->get_data_risk_ishikawa($id_rcsa); 
		$data['id'] = $id_rcsa;
		$data['owner'] = $owner;
		$data['fields'] = $this->data->get_data_officer($id_rcsa);
		$data['tgl'] = $this->data->get_data_tanggal($id);
		$data['tipe'] = 'cetak';
		$xx = array('field' => $data['field'], 'rcsa' => $data['id_rcsa']);

		$this->session->set_userdata('result_risk_register', $xx);

		$data['log'] = $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_LOG_PROPOSE)->result_array();
		$result['register'] = $this->load->view('list_risk_breakdown_structure', $data, true);
		echo json_encode($result);
	}
		function cetak_register()
	{
		$tipe = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$parent = $this->uri->segment(5);

		$data = $this->db->where('id', $id)->get(_TBL_RCSA)->row_array();
		$rows = $this->db->where('id', $data['owner_no'])->get(_TBL_OWNER)->row_array();
		$nama = $nama = 'Risk-Breakdown-Structure-' . url_title($rows['name']);

		$id_rcsa = $id;
		$data['id'] = $id;
		$data['tipe'] = $tipe;

		$data['owner'] = $parent;
		$data['field'] = $this->data->get_data_risk_ishikawa($id);
		$data['fields'] = $this->data->get_data_officer($id_rcsa);

		$data['tgl'] = $this->data->get_data_tanggal($id);
		$data['divisi'] =  $this->db->where('id', $parent)->get(_TBL_OWNER)->row();
		$hasil = $this->load->view('list_risk_breakdown_structure', $data, true);
		$cetak = 'register_' . $tipe;
		$this->$cetak($hasil, $nama);
	}

	function register_excel($data, $nama = "Risk-Breakdown-Structure")
	{
		header("Content-type:appalication/vnd.ms-excel");
		header("content-disposition:attachment;filename=" . $nama . ".xls");

		$html = $data;
		echo $html;
		exit;
	}

	function register_pdf($data, $nama = "Risk-Breakdown-Structure")
	{
		$this->load->library('pdf');
		$tgl = date('d-m-Y');
		$this->nmFile = $nama .'-'.$tgl.".pdf";
		$this->pdfFilePath = download_path_relative($this->nmFile);

		$html = '<style>
				table {
					border-collapse: collapse;
				}

				.test table > th > td {
					border: 1px solid #ccc;
				}
				</style>';


		// $html .= '<table width="100%" border="0"><tr><td width="100%" style="padding:0px;">';
		$html .= $data;
		// $html .= '</td></tr></table>';

		// die($html);
		$align = array();
		$format = array();
		$no_urut = 0;

		// die($html);
		$pdf = $this->pdf->load('en-GB-x,legal,,,5,5,5,5,6,3');
		$pdf->AddPage('L', // L - landscape, P - portrait
        '', '', '', '',
        10, // margin_left
        10, // margin right
        10, // margin top
        10, // margin bottom
        5, // margin header
        5); // margin footer
		$pdf->SetHeader('');
		// $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822));
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