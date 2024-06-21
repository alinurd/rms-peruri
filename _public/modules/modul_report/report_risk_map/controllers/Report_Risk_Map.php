<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Report_Risk_Map extends BackendController {
	var $tmp_data=array();
	var $data_fields=array();
	
	public function __construct()
	{
        parent::__construct();
		$this->cbo_type_project =$this->get_combo('type-project-report');
		$this->cbo_privilege =$this->get_combo('privilege-owner');
		$this->cbo_parent_input =$this->get_combo('parent-input');
		$this->cbo_periode =$this->get_combo('periode');
		$this->cbo_rcsa =$this->get_combo('rcsa_data');
		
		$this->set_Tbl_Master(_TBL_REPORT);
		$this->set_Table(_TBL_OWNER);
		$this->set_Table(_TBL_PERIOD);		
		$this->set_Table(_TBL_RCSA);		
		
		$this->set_Open_Tab('Report Risk Map');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'type', 'show'=>false, 'size'=>100));
			$this->addField(array('field'=>'template_name', 'size'=>100));
			$this->addField(array('field'=>'type_project_no', 'input'=>'combo', 'combo'=>$this->cbo_type_project, 'size'=>15));
			$this->addField(array('field'=>'type_view_no', 'input'=>'combo', 'combo'=>$this->cbo_privilege, 'size'=>200));
			$this->addField(array('field'=>'owner_no', 'input'=>'combo', 'combo'=>$this->cbo_parent_input, 'size'=>10));
			$this->addField(array('field'=>'periode_no', 'input'=>'combo', 'combo'=>$this->cbo_periode, 'size'=>10));
			$this->addField(array('field'=> 'rcsa_no', 'input'=>'combo', 'combo'=>$this->cbo_rcsa, 'size'=>10));
			// $this->addField(array('field'=>'rcsa_no', 'input'=>'float', 'size'=>15));
			$this->addField(array('field'=>'param', 'input'=>'boolean', 'size'=>15));
			$this->addField(array('field'=>'create_user', 'input'=>'boolean', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'update_user', 'input'=>'boolean', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'parameter', 'type'=>'free', 'show'=>true, 'size'=>15));
			$this->addField(array('field'=>'nama_file', 'input'=>'boolean','size'=>15));
			$this->addField(array('field'=>'hit', 'type'=>'free', 'show'=>false, 'size'=>15));
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'owner_no','sp'=>$this->tbl_owner,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'periode_no','sp'=>$this->tbl_period,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'rcsa_no','sp'=>$this->tbl_rcsa,'id_sp'=>'id'));
		
		$this->addField(array('nmtbl'=>$this->tbl_owner, 'field'=>'name', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_period, 'field'=>'periode_name', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_rcsa, 'field'=> 'judul_assesment', 'size'=>20, 'show'=>false));
		
		$this->set_Sort_Table($this->tbl_master,'template_name');
		$this->set_Where_Table($this->tbl_master,'type','=',1);
		
		$this->set_Table_List($this->tbl_master,'template_name');
		$this->set_Table_List($this->tbl_master,'type_view_no');
		$this->set_Table_List($this->tbl_master,'type_project_no');
		$this->set_Table_List($this->tbl_owner,'name');
		$this->set_Table_List($this->tbl_period,'periode_name');
		$this->set_Table_List($this->tbl_rcsa, 'judul_assesment');
		$this->set_Table_List($this->tbl_master,'create_user');
		
		$this->set_Close_Setting();
		
	}
	
	function listBox_TYPE_PROJECT_NO($row, $value, $field){
		$result =  (array_key_exists($value,$this->cbo_type_project))?$this->cbo_type_project[$value]:'-';
		return $result;
	}
	
	function listBox_TYPE_VIEW_NO($row, $value, $field){
		$result =  (array_key_exists($value,$this->cbo_privilege))?$this->cbo_privilege[$value]:'-';
		return $result;
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$result = $this->data->save_data($id , $new_data);
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$result = $this->data->save_data($id , $new_data, $old_data);
		return $result;
	}
	
	function updateBox_PARAMETER($fields, $rows, $value){
		return $this->get_param();
	}
	
	function insertBox_PARAMETER($fields){
		return $this->get_param();
	}
	
	function get_param(){
		$id=intval($this->uri->segment(3));
		$data['field']=$this->data->get_data_param($id);
		$result=$this->load->view('report',$data,true);
		return $result;
	}
	
	// function updateBox_RCSA_NO($field, $row, $value){
	// 	// Doi::dump($row);
	// 	if ($row['l_type_project_no']>=0 && $row['l_owner_no']>0 && $row['l_periode_no']>0){
	// 		$combo=$this->data->get_data_project($row);
		
	// 	}else{
	// 		$combo=array(' -select- ');
	// 	}
		
	// 	$result = form_dropdown($field['label'], $combo, $value,'id="'.$field['label'].'" class="form-control select2"');
	// 	return $result;
	// }
	
	// function insertBox_RCSA_NO($field){
		
	// 	$result = form_dropdown($field['label'], array(' -select- '),'','id="'.$field['label'].'" class="form-control" style="max-width: 350px;"');
	// 	return $result;
	// }
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows){
		
		$url=base_url('report-risk-map/print-report/'. $rows['l_rcsa_no']);
		$tombol['print']=array("default"=>false,"url"=>$url,"label"=>"Print Preview");
		return $tombol;
	}
	
	function SIDEBAR_LEFT(){
		return true;
	}
	
	function SIDEBAR_RIGHT(){
		return TRUE;
	}
	
	function print_report(){
		$this->template->var_tmp('posisi',FALSE);
		$data['id_parent']=intval($this->uri->segment(3));

		doi::dump($data['id_parent']);
		$data['field']=$this->data->get_data_param($data['id_parent']);
		$project_no=intval($data['field']['rcsa_no']);
		if($project_no==0)
			$project_no=-1;
		$data['owner']=array('rcsa_no'=>$data['field']['owner_no'], 'project_no'=>$project_no,'type_map'=>$data['field']['type_view_no'],'type_dash'=>$data['field']['type_project_no']);
		// Doi::dump($data['owner']);
		$data['setting']=$this->crud->get_setting($data['owner']);
		// Doi::dump($data['setting']);die();
		$this->template->build('report-map',$data); 
	}
	
	function delete_report(){
		$data['id_report']=intval($this->input->get('id'));
		$result = $this->data->del_template($data['id_report']);
		echo $result;
	}
	
	function cetak_report(){
		$data['id_parent']=intval($this->uri->segment(3));
		$data['field']=$this->data->get_data_param($data['id_parent']);
		$project_no=intval($data['field']['rcsa_no']);
		if($project_no==0)
			$project_no=-1;
		$data['owner']=array('rcsa_no'=>$data['field']['owner_no'], 'project_no'=>$project_no,'type_map'=>$data['field']['type_view_no'],'type_dash'=>$data['field']['type_project_no']);
		// Doi::dump($data['owner']);
		$data['setting']=$this->crud->get_setting($data['owner']);
		// Doi::dump($data['setting']);die;
		$content = $this->load->view('cetak-map',$data, TRUE); 
		$this->pdf($content);
	}
	
	function pdf($data){
		// Doi::dump($data);die();	
		$nmFile="report-risk-map.pdf";
		$pdfFilePath = download_path_relative($nmFile);
		
		$pdf = $this->pdf->load();
		$pdf->defaultheaderfontsize=10;
		$pdf->defaultheaderfontstyle='B';
		$pdf->defaultheaderline=0;
		$pdf->defaultfooterfontsize=10;
		$pdf->defaultfooterfontstyle='BI';
		$pdf->defaultfooterline=0;
		
		//cover page
		// $pdf->SetMargins(25, 30, 25);
		$pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            6, // margin_left
            6, // margin right
            6, // margin top
            6, // margin bottom
            5, // margin header
            5); // margin footer
		
		$pdf->writeHTML($data);
		$footer = 'Tanggal pencetakkan : '.date('d-m-Y h:m:s');
		$pdf->SetFooter($footer);
		$pdf->SetHeader('PLANET PETS SHOP');
		
		$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); 
		
		ob_clean();
		$pdf->Output($pdfFilePath, 'i'); 
		// redirect(download_url($nmFile));
		return true;
	}
	
	function get_project_name(){
		$id  =$this->input->post('id');
		$data=$this->data->get_data_project($id);
		$result = form_dropdown('project_name',$data,'','id="project_name" class="form-control" style="height:34px;max-width:350px;"');
		 echo $result;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */