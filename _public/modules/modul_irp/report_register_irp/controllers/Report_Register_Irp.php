<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Report_Register_Irp extends BackendController {
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
		$this->set_Where_Table($this->tbl_master,'type','=',2);
		
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
		
		$result = form_dropdown($field['label'], array(' -select- '),'','id="'.$field['label'].'" class="form-control" style="max-width: 350px;"');
		return $result;
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows){
		$url=base_url('report-risk-register/print-report/');
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
		// $this->template->var_tmp('posisi',FALSE);
		// $data['id_parent']=intval($this->uri->segment(3));
		// $data['field']=$this->data->get_data_param($data['id_parent']);
		// $data['setting']=$this->data->get_data_report($data['field']['param']);
		
		// $this->template->build('report-register',$data); 
		
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
	
	function cetak_report(){
		$type=$this->uri->segment(3);
		$type=$this->uri->segment(3);
		$id_rcsa=$this->uri->segment(4);
		$data['field'] = $this->data->get_data_risk_register($id_rcsa);
		$data['rcsa'] = $this->data->get_data($id_rcsa);
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
		
		// $html ='<table width="100%"><tr><td rowspan="3"><img src="'.img_url('logo_lap.jp').'"></td>';
		// $html .='<td>'.$this->authentication->get_Preference['nama_kantor'].'</td></tr>';
		// $html .='<tr><td>'.$this->authentication->get_Preference['alamat_kantor'].'</td></tr>';
		// $html .='<tr><td>Telp: '.$this->authentication->get_Preference['telp_kantor'].' email: '.$this->authentication->get_Preference['email_kantor'].'</td></tr></table><br/>';
		
		$html  ='<table width="100%"><tr><td rowspan="3" width="11%"><img src="'.img_url('logo_report.png').'"></td>';
		$html .='<td>'.$this->authentication->get_Preference('nama_kantor').'</td></tr>';
		$html .='<tr><td>Kantor Pusat</td></tr>';
		$html .='<tr><td>&nbsp;</td></tr></table><br/>';
		
		$html .= "<strong><h2 style='margin:0px;'>Risk Register</h2></strong><br/>";
		// $rows  = $data;
		
		$html  .='<table class="table" width="100%">
		<tr>
			<td colspan="3"><strong><h2 style="margin:0px;">PROYEK</h2></strong></td>
			<td colspan="3"><strong><h2 style="margin:0px;">SASARAN</h2></strong></td>
		</tr>
		<tr>
			<td width="15%">Nama Proyek</td><td width="4%">:</td><td><strong>'.$data['rcsa']['corporate'].'</strong></td>
			<td>Laba</td><td>:</td><td colspan="2"><strong>'.number_format($data['rcsa']['target_laba']).'</strong></td>
		</tr>
		<tr>
			<td>Pelaksana</td><td>:</td><td><strong>'.$data['rcsa']['name_owner'].'</strong></td>
			<td>Waktu</td><td>:</td><td colspan="2"><strong>'.$data['rcsa']['max_periode'].'</strong></td>
		</tr>
		<tr><td>Pemilik Proyek</td><td>:</td><td colspan="5">'.$data['rcsa']['location'].'</strong></td></tr>
		<tr><td>Nilai Kontrak</td><td>:</td><td colspan="5"><strong>'.number_format($data['rcsa']['nilai_kontrak']).'</strong></td></tr>
	</table>';
			
		$pdf->writeHTML($html);
		
		
		$html = '<br/>
	<table class="table" border="1" width="100%">
		<thead>
			<tr>
			<th width="5%" style="text-align:center;">No.</th>
			<th width="15%" >Identifikasi Risiko</th>
			<th width="5%" >No</th>
			<th>Peristiwa Risiko</th>
			<th>Sebab Risiko</th>
			<th>Dampak Risiko</th>
			<th>Nilai Dampak</th>
			<th>Likehood</th>
			<th>Consequence</th>
			<th>Risk Exposure</th>
			<th>Action Plan (Mitigasi) / Accountable Unit / Target</th>
			</tr>
		</thead>
		<tbody>';
			$i=1;
			foreach($data['field']['data'] as $keys=>$row)
			{ 
				$html .= '<tr>
					<td valign="top" rowspan="'.count($row->detail['risk_event']).'">'.$i.'</td>
					<td valign="top"  rowspan="'.count($row->detail['risk_event']).'">'.$row->type.'</td>'; 
				$no=1;
				foreach ($row->detail['risk_event'] as $key=>$sub){
					$nil_inherent_likelihood=explode('#',$row->detail['inherent_likelihood'][$key]);
					$nil_inherent_impact=explode('#',$row->detail['inherent_impact'][$key]);
					$exposure=floatval($row->detail['nilai_dampak'][$key]) * ($nil_inherent_impact[0]/100);
					
					if (count($nil_inherent_likelihood)>1)
						$nil_inherent_likelihood=$nil_inherent_likelihood[1];
					else
						$nil_inherent_likelihood='';
					
					if (count($nil_inherent_impact)>1)
						$nil_inherent_impact=$nil_inherent_impact[1];
					else
						$nil_inherent_impact='';
					
					
					if ($no>1){
						$html .= '<tr>';
					}
					$html .= '<td valign="top"  width="5%">'.$no.'</td>
					<td valign="top" >'.$sub['description'].'</td>
					<td valign="top" >'.$row->detail['risk_couse'][$key].'</td>
					<td valign="top" >'.$row->detail['risk_impact'][$key].'</td>
					<td valign="top"  class="text-right">'.number_format($row->detail['nilai_dampak'][$key]).'</td>
					<td valign="top"  class="text-center">'.$nil_inherent_likelihood.'</td>
					<td valign="top"  class="text-center">'.$nil_inherent_impact.'</td>
					<td valign="top"  class="text-right">'.number_format($exposure).'</td>
					<td valign="top" >
					<table border="0" width="100%">';
					
					foreach($row->detail['action'][$sub['id']] as $act){
						$html .= '<tr>
							<td valign="top" >'.$act['title'].'</td>
							<td valign="top" >'.$act['owner_no'].'</td>
							<td valign="top" >'.$act['target_waktu'].'</td>
						</tr>';
					}
					$html .= '</table>
					</td>
					</tr>';
				++$no;
			}
		$html .= '</tr>';
			++$i;
			}
		$html .= '</tbody>
	</table>';
	
		$pdf->writeHTML($html);
		$footer = 'Tanggal pencetakkan : '.date('d-m-Y h:m:s');
		$pdf->SetFooter($footer);
		$pdf->SetHeader('PLANET PETS SHOP');
		
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
		$objDrawing->setPath(img_path('logo_report.png'));
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
		$sheet->setCellValue('A'.$brs,'RISK REGISTER');
		++$brs;
		
		++$brs;
		$kol=0;
		$koor['col1']="A";
		$koor['row1']=$brs;
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"No.");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Identifikasi Risiko");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"No.");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Peristiwa Risiko:");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"Nama dan Uraian Peristiwa Risiko");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Sebab Risiko");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Dampak/Konsekwensi");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs," Nilai Dampak");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"(juta Rp)");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Level Risiko");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"(Likehood)");
		$sheet->setCellValue(huruf_kolom(++$kol).($brs+1),"(Consequence)");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Risk");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"Exposure");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Action Plan");
		$sheet->setCellValue(huruf_kolom($kol).($brs+1),"No");
		$sheet->setCellValue(huruf_kolom(++$kol).($brs+1),"Mitigasi");
		$sheet->setCellValue(huruf_kolom(++$kol).($brs+1),"Accountable Unit");
		$sheet->setCellValue(huruf_kolom(++$kol).($brs+1),"Target");
		
		$sheet->mergeCells('A'.$brs.':A'.($brs+1));
		$sheet->mergeCells('B'.$brs.':B'.($brs+1));
		$sheet->mergeCells('C'.$brs.':C'.($brs+1));
		$sheet->mergeCells('E'.$brs.':E'.($brs+1));
		$sheet->mergeCells('F'.$brs.':F'.($brs+1));
		$sheet->mergeCells('H'.$brs.':I'.$brs);
		$sheet->mergeCells('K'.$brs.':N'.$brs);
		
		++$brs;
		
		$koor['col2']=huruf_kolom($kol);
		$koor['row2']=$brs;
		$sheet->getStyle($koor['col1'].$koor['row1'].':'.$koor['col2'].$koor['row2'])->applyFromArray($style_title);
		
		++$brs;
		$i=1;
		$koor['col1']="A";
		$koor['row1']=$brs;
		foreach($data['field']['data'] as $keys=>$row)
		{ 
			// echo "no ke " . $i;
			// doi::dump($row);
			
			$kol=0;
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$i);
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,"[ " . $row->corporate . " ] - \n" . $row->type);
			$col_row_1=$brs;
			$no=1;
			foreach ($row->detail['risk_event'] as $key=>$sub){
				$kol_sub=$kol;
				$nil_inherent_likelihood=explode('#',$row->detail['inherent_likelihood'][$key]);
				$nil_inherent_impact=explode('#',$row->detail['inherent_impact'][$key]);
				$exposure=floatval($row->detail['nilai_dampak'][$key]) * ($nil_inherent_impact[0]/100);
				
				if (count($nil_inherent_likelihood)>1)
					$nil_inherent_likelihood=$nil_inherent_likelihood[1];
				else
					$nil_inherent_likelihood='';
				
				if (count($nil_inherent_impact)>1)
					$nil_inherent_impact=$nil_inherent_impact[1];
				else
					$nil_inherent_impact='';
				
				
				if ($no>1){
					++$brs;
				}
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$no);
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$sub['description']);
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,str_replace('<br>','\r',$row->detail['risk_couse'][$key]));
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,str_replace('<br>','\r',$row->detail['risk_impact'][$key]));
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$row->detail['nilai_dampak'][$key]);
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$nil_inherent_likelihood);
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$nil_inherent_impact);
				$sheet->setCellValue(huruf_kolom(++$kol_sub).$brs,$exposure);
				$no_act=0;
				$sts_act=false;
				foreach($row->detail['action'][$sub['id']] as $act){
					$kol_act=$kol_sub;
					$sheet->setCellValue(huruf_kolom(++$kol_act).$brs, ++$no_act);
					$sheet->setCellValue(huruf_kolom(++$kol_act).$brs,$act['title']);
					$sheet->setCellValue(huruf_kolom(++$kol_act).$brs,$act['owner_no']);
					$sheet->setCellValue(huruf_kolom(++$kol_act).$brs,$act['target_waktu']);
					++$brs;
					$sts_act=true;
				}
				if ($sts_act)
					--$brs;
				else
					++$brs;
				++$no;
			}
			$col_row_2=($brs-1);
			if ($col_row_2<$col_row_1)
				$col_row_2=$col_row_1;
			// echo $col_col_1.$col_row_1.':'.$col_col_2.$col_row_2 . '<br>';
			$sheet->mergeCells('A'.$col_row_1.':A'.$col_row_2);
			$sheet->mergeCells('B'.$col_row_1.':B'.$col_row_2);
			++$i;
			++$brs;
		}
		// die();
		if ($kol_act<=0)
			$kol_act=1;
		$koor['col2']=huruf_kolom($kol_act);
		$koor['row2']=$brs;
		// echo $koor['col1'].$koor['row1'].':'.$koor['col2'].$koor['row2'];
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