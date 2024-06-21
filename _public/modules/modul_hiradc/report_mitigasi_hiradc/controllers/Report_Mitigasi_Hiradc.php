<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Report_Mitigasi_Hiradc extends BackendController {
	var $tmp_data=array();
	var $data_fields=array();
	
	public function __construct()
	{
        parent::__construct();
		$this->cbo_type_project =$this->get_combo('type-project-report');
		$this->cbo_privilege =$this->get_combo('privilege-owner');
		$this->cbo_parent_input =$this->get_combo('parent-input');
		$this->cbo_periode =$this->get_combo('periode');
		
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
			$this->addField(array('field'=>'rcsa_no', 'input'=>'float', 'size'=>15));
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
		$this->addField(array('nmtbl'=>$this->tbl_rcsa, 'field'=>'corporate', 'size'=>20, 'show'=>false));
		
		$this->set_Sort_Table($this->tbl_master,'template_name');
		$this->set_Where_Table($this->tbl_master,'type','=',3);
		
		$this->set_Table_List($this->tbl_master,'template_name');
		$this->set_Table_List($this->tbl_master,'type_view_no');
		$this->set_Table_List($this->tbl_master,'type_project_no');
		$this->set_Table_List($this->tbl_owner,'name');
		$this->set_Table_List($this->tbl_period,'periode_name');
		$this->set_Table_List($this->tbl_rcsa,'corporate');
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
	
	function updateBox_RCSA_NO($field, $row, $value){
		// Doi::dump($row);
		if ($row['l_type_project_no']>=0 && $row['l_owner_no']>0 && $row['l_periode_no']>0){
			$combo=$this->data->get_data_project($row);
		
		}else{
			$combo=array(' -select- ');
		}
		
		$result = form_dropdown($field['label'], $combo, $value,'id="'.$field['label'].'" class="form-control select2"');
		return $result;
	}
	
	function insertBox_RCSA_NO($field){
		
		$result = form_dropdown($field['label'], array(' -select- '),'','id="'.$field['label'].'" class="form-control select2" style="max-width: 350px;"');
		return $result;
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows){
		$url=base_url('report-risk-monitoring/print-report/');
		$tombol['print']=array("default"=>false,"url"=>$url,"label"=>"Print Preview");
		return $tombol;
	}
	
	function SIDEBAR_LEFTx(){
		return TRUE;
	}
	
	function SIDEBAR_RIGHTx(){
		return TRUE;
	}
	
	function print_report(){
		$this->template->var_tmp('posisi',FALSE);
		$param=intval($this->uri->segment(3));
		$data['field']=$this->data->get_data_param($param);
		// Doi::dump($data['field']);die();
		$data['setting']=$this->data->get_data_report($data['field']);
		$this->template->build('report-monitoring',$data); 
	}
	
	function cetak_report(){
		$type=$this->uri->segment(3);
		$param=intval($this->uri->segment(4));
		$data['field']=$this->data->get_data_param($param);
		$data['setting']=$this->data->get_data_report($data['field']);
		$this->$type($data);
	}
	
	function pdf($data){
		// Doi::dump($data);die();	
		$nmFile="list_risk_register.pdf";
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
		
		$html  ='<table width="100%"><tr><td rowspan="3" width="11%"><img src="'.img_url('logo_lap.png').'"></td>';
		$html .='<td>'.$this->authentication->get_Preference('nama_kantor').'</td></tr>';
		$html .='<tr><td>Kantor Pusat</td></tr>';
		$html .='<tr><td>&nbsp;</td></tr></table><br/>';
		
		$html .= "<strong><h2 style='margin:0px;'>".$data['field']['param']['title'].'<br/>'.$data['field']['param']['subtitle']."</h2></strong><br/>";
		
		$html .= '<table class="table no-padding no-margin no-border" style="width:100%;margin:0 auto;">
					<tr>
						<td style="width:10%;" class="no-border">Unit Name</td>
						<td class="no-border" style="width:2%;">:</td>
						<td class="no-border"><strong>'.$data['field']['owner_name'].'</strong></td>
					</tr>
					<tr>
						<td class="no-border">Period</td>
						<td class="no-border" style="width:2%;">:</td>
						<td class="no-border"><strong>'.$data['field']['periode_name'].'</strong></td>
					<tr>
						<td class="no-border">Cut-off Date</td>
						<td class="no-border" style="width:2%;">:</td>
						<td class="no-border"><strong>'.$data['field']['param']['cut_off'].'</strong></td>
					>/tr>
				</table>';
		// $rows  = $data;
			
		$pdf->writeHTML($html);
		
		
		$html = '<br/>
	<table class="table" border="1" width="100%">
		<thead>
			<tr>
			<th width="5%" style="text-align:center;">No.</th>
			<th width="30%">Asesmen/project</th>';

			$judul=array();
			foreach($data['field'] as $key=>$jdl){
				if ($key=='param'){
					if ($jdl['sts_risk_detail']==1){$judul[]='Risk Details';}
					if ($jdl['sts_risk_level']==1){$judul[]='Analisis';}
					$judul[]='Mitigation Plan';
					if ($jdl['sts_action_plan']==1){$judul[]='Action Detail';}
					$judul[]='Progress Date';
					if ($jdl['sts_progress']==1){$judul[]='Progress Detail';}
					if ($jdl['sts_attachment']==1){$judul[]=' Attachment';}
				}
			}
			foreach($judul as $row){
				$html .='<th>'.$row.'</th>';
			}
			$html .= '</tr></thead><tbody>';
			$i=1;
			foreach($data['setting'] as $keys=>$row)
			{ 
				$content ='';
				$content .= '<tr style="vertical-align:middle;">';
				$content .= '<td>'.++$i.'</td>';
				$content .= '<td>'.$row['corporate'].'</td>';
				
				if (array_key_exists('event_no', $row)){
					$content .= '<td style="vertical-align:middle;">'.$row['event_no'][0]['name'].'</td>';
				}
				if (array_key_exists('risk_level', $row)){
					$content .= '<td class="text-center" style="vertical-align:middle;color:'.$row['risk_level']['color_text'].';background-color:'.$row['risk_level']['color'].'">'.$row['risk_level']['level_mapping'].'</td>';
				}
				if (array_key_exists('title', $row)){
					$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['title'].'</td>';
				}
				if (array_key_exists('description', $row)){
					$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['description'].'</td>';
				}
				if (array_key_exists('progress_date', $row)){
					$content .= '<td class="text-center" style="vertical-align:middle;">'.date('d-m-Y',strtotime($row['progress_date'])).'</td>';
				}
				if (array_key_exists('progress', $row)){
					$content .= '<td class="text-center" style="vertical-align:middle;">'.number_format($row['progress']).' %</td>';
				}
				if (array_key_exists('attach', $row)){
					$xx=array();
					$control=json_decode($row['attach'],TRUE);
					$tmp=array();
					if (count($control)>0){
						foreach($control as $tmp){ $xx[]=$tmp['real_name']; }
					}
					$tmp=implode('<br>',$xx);
					$content .= '<td style="vertical-align:middle;">'.$tmp.'</td>';
				}
				
				$content .='</tr>';
				$html .= $content;
				++$i;
			}
		$html .= '</tbody>
	</table>';
	
		$pdf->writeHTML($html);
		$footer = 'Tanggal pencetakkan : '.date('d-m-Y h:m:s');
		$pdf->SetFooter($footer);
		$pdf->SetHeader('Adhi Risk');
		
		$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); 
		
		ob_clean();
		$pdf->Output($pdfFilePath, 'i'); 
		// redirect(download_url($nmFile));
		return true;
	}
	
	function excel($data){
		// Doi::dump($data);die();
		$nmfile="List-risk-register";
		$koor=array();
		$this->load->library('PHPExcel');
		$sheet = $this->phpexcel->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->setTitle($nmfile);
		$sheet->setShowGridlines(FALSE);
		
		$style_title = array('font' =>array('color' =>array('rgb' => '050504'),'bold' => true),'alignment' => array('wrap'=> true, 'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER),'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FFFD9B')));
					 
		$style_content = array('font' =>array('color' =>array('rgb' => '050504')),'alignment' => array('wrap'=> true),'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
					 
		$brs=0;
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath(img_path('logo_lap.png'));
		// $objDrawing->setHeight(55);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setOffsetX(10);     
		$objDrawing->setWorksheet($sheet);
		
		
		$sheet->getStyle('A1:AZ1000')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->setCellValue('B'.++$brs,$this->authentication->get_Preference('nama_kantor'));
		$sheet->setCellValue('B'.++$brs,'Kantor Pusat');
		$sheet->setCellValue('B'.++$brs,' ');
		++$brs;
		++$brs;
		
		$koor['col1']="A";
		$koor['row1']=$brs;
		
		$kol=0;
		++$brs;
		++$brs;
		$kol=0;
		$koor['col1']="A";
		$koor['row1']=$brs;
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"No.");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Asesmen/project");
		
		$judul=array();
		foreach($data['field'] as $key=>$jdl){
			if ($key=='param'){
				if ($jdl['sts_risk_detail']==1){$judul[]='Risk Details';}
				if ($jdl['sts_risk_level']==1){$judul[]='Analisis';}
				$judul[]='Mitigation Plan';
				if ($jdl['sts_action_plan']==1){$judul[]='Action Detail';}
				$judul[]='Progress Date';
				if ($jdl['sts_progress']==1){$judul[]='Progress Detail';}
				if ($jdl['sts_attachment']==1){$judul[]=' Attachment';}
			}
		}
		foreach($judul as $row){
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row);
		}
		
		$sheet->getColumnDimension('A')->setWidth(14);
		$sheet->getColumnDimension('B')->setWidth(60);
		$sheet->getColumnDimension('C')->setWidth(50);
		$sheet->getColumnDimension('D')->setWidth(13);
		$sheet->getColumnDimension('E')->setWidth(50);
		$sheet->getColumnDimension('F')->setWidth(40);
		$sheet->getColumnDimension('G')->setWidth(8);
		$sheet->getColumnDimension('H')->setWidth(18);
		
		$koor['col2']=huruf_kolom($kol);
		$koor['row2']=$brs;
		$sheet->getStyle($koor['col1'].$koor['row1'].':'.$koor['col2'].$koor['row2'])->applyFromArray($style_title);
		
		++$brs;
		$i=1;
		$koor['col1']="A";
		$koor['row1']=$brs;
		foreach($data['setting'] as $keys=>$row)
		{ 
			$kol=0;
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$i);
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row['corporate']);
			
			if (array_key_exists('event_no', $row)){
				$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row['event_no'][0]['name']);
			}
			if (array_key_exists('risk_level', $row)){
				$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row['risk_level']['level_mapping']);
			}
			if (array_key_exists('title', $row)){
				$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row['title']);
			}
			if (array_key_exists('description', $row)){
				$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row['description']);
			}
			if (array_key_exists('progress_date', $row)){
				$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row['progress_date']);
			}
			if (array_key_exists('progress', $row)){
				$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row['progress']);
			}
			if (array_key_exists('attach', $row)){
				$xx=array();
				$control=json_decode($row['attach'],TRUE);
				$tmp=array();
				if (count($control)>0){
					foreach($control as $tmp){ $xx[]=$tmp['real_name']; }
				}
				$tmp=implode('<br>',$xx);
				$content .= '<td style="vertical-align:middle;">'.$tmp.'</td>';
				$sheet->setCellValue(huruf_kolom(++$kol).$brs,$tmp);
			}
			++$i;
			++$brs;
		}
		// die();
		--$brs;
		$koor['col2']=huruf_kolom($kol);
		$koor['row2']=$brs;
		$sheet->getStyle($koor['col1'].$koor['row1'].':'.$koor['col2'].$koor['row2'])->applyFromArray($style_content);
		
		// die();
		ob_clean();
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=\"$nmfile.xls\"");
		header("Cache-Control: max-age=0");
		$writer = new PHPExcel_Writer_Excel5($this->phpexcel);
		$writer->save('php://output'); 
		return true;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */