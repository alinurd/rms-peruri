<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends FrontendController {
	public function __construct()
	{
        parent::__construct();
	}
	
	function download(){
		$this->load->helper('download');
		$kel=$this->uri->segment(3);
		$nmfile=$this->uri->segment(4);
		// $nmfile=cek_nama_file();
		$path = $kel.'_path_relative';
		$url = $kel.'_url';
		if (file_exists($path($nmfile))) {
			force_download($path($nmfile), null, true);
		}
	}	
	
	function download_preview(){
		$this->load->helper('download');
		$kel=$this->input->post('kel');
		$nmfile=$this->input->post('file');
		// $nmfile=cek_nama_file();
		$hasil ='Tidak ada file';
		$path = $kel.'_path_relative';
		$url = $kel.'_url';
		if (file_exists($path($nmfile))) {
			$hasil = '<div class="row">
						<div class="col-sm-offset-2 col-sm-8"><span class="media" href="'.$url($nmfile).'#toolbar=0"></span>
						</div>
					</div>
					
					<script type="text/javascript">
						$(function () {
							$(".media").media();
						});
						
						$(document).ready(function() {
							$("iframe").attr("width", "100%");
							$(".media").css("width", "100%");
							$(".media").find("img").attr("width", "100%");
							var head = jQuery("iframe").contents().find("head");
							var css = \'<style type="text/css">\' +
									  \'#download{display:none}; \' +
									  \'#print{display:none}; \' +
									  \'</style>\';
							jQuery(head).append(css);
						})
					</script>';
		}
		echo $hasil;
	}
	
	function get_help(){
		$content ['combo'] = $this->load->view('template/help', array(), true);
		echo json_encode($content);
	}
	
	function list_libray_ajax(){
		$id = $this->input->post('id');
		$kel=$this->uri->segment(3);
		
	
		$data['field']=$this->data->get_data_event(1, $id);
		$data['kel']='event';
		$content=$this->load->view('list_event_tmp',$data,true);
		
		echo $content;
	}

	function get_approve_owner(){
		$id = $this->input->post('id');
		$x = $this->data->get_data_approve_owner($id);
		echo json_encode($x); 
 	}
	
	function takstonomi(){
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$x=$this->data->get_map_takstonomi($type,$id);
		echo json_encode($x);
	}
	function get_rist_type(){
		$id = $this->input->post('id');
		$x=$this->data->get_data_type_risk($id);
		echo json_encode($x);
	}
	function get_ajax_combo(){
		$id = $this->input->post('id');
		$kel_target = $this->input->post('kelompok');
		$x=$this->data->get_data_combo($id, $kel_target);
		echo json_encode($x);
	}
	function get_ajax_kelevent(){
		$id = $this->input->post('id');
		// doi::dump($id);

 		$x=$this->data->get_data_kelevent($id);
		echo json_encode($x);
	}
	function get_ajax_libray_couse()
	{
		$id = $this->input->post('id');
		$type = $this->input->post('type'); 
 		$x = $this->data->get_lib_event_map($id,$type);
	 
		echo json_encode($x);
	}
	function get_ajax_libray_impact()
	{
		$id = $this->input->post('id');
		$type = $this->input->post('type'); 
 		$x = $this->data->get_lib_event_map($id,$type);
		echo json_encode($x);
 	}
	
	function get_project_name(){
		$id = $this->input->post('id');
		$id = $this->input->post('id');
		$x=$this->data->get_data_project($id);
		echo json_encode($x);
	}
	
	function get_project_hiradc_name(){
		$id = $this->input->post();
		$x=$this->data->get_data_project_hiradc($id);
		echo json_encode($x);
	}
	
	function get_detail_action(){
		$data = $this->input->post();
		$data['field'] = $this->data->get_data_detail_action($data['id']);
		$result=$this->load->view('list_detail_action',$data,true);
		echo $result;
	}
	
	function get_event_popup(){
		$data = $this->input->post();
		$data['info'] = json_decode($data['info'], true);
		$data['param'] = $this->input->post();
		$this->session->set_userdata($data);
		
		$data['field'] = $this->data->get_detail_event($data);
		$result=$this->load->view('list_detail_event',$data,true);
		echo $result;
	}
	
	function get_event_exposure_popup(){
		$data = $this->input->post();
		$data['field'] = $this->data->get_detail_event_exposure($data);
		$result=$this->load->view('list_detail_event_exposure',$data,true);
		echo $result;
	}
	
	function cetak_detail_map(){
		$type=$this->uri->segment(3);
		$data = $this->session->userdata('param');
		// Doi::dump($data);die();
		$data['field'] = $this->data->get_detail_event($data);
		// $data = $this->data->get_data_detail_map();
		// die("Under Contruction");
		$this->$type($data);
	}
	
	function pdf($data){
		$info = $this->session->userdata('info');
		// Doi::dump($info);die();	
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
		
		$html  ='<table width="100%"><tr><td rowspan="3" width="11%"><img src="'.img_url('logo_lap.png').'"></td>';
		$html .='<td>'.$this->authentication->get_Preference('nama_kantor').'</td></tr>';
		$html .='<tr><td>Kantor Pusat</td></tr>';
		$html .='<tr><td>&nbsp;</td></tr></table><br/>';
		
		$htmlx = "<strong><h2 style='margin:0px;'>Risk Register</h2></strong><br/>";
		// $rows  = $data;
			
		$pdf->writeHTML($html);
		
		
		$html = $info['title'].'<br/>'.$info['sub_title'].'<br/>
	<table class="table" border="1" width="100%">
		<thead>
			<tr>
			<th width="5%" style="text-align:center;">No.</th>
			<th width="30%">Asesmen/project</th>
			<th width="5%">Code</th>
			<th width="30%">Risk Event</th>
			<th width="10%">Likehood</th>
			<th width="10%">Impact</th>
			<th width="10%">Nilai Dampak</th>
			<th width="10%">Nilai Eksposure</th>
			</tr>
		</thead>
		<tbody>';
			$i=1;
			$ttl_eksposure=0;
			foreach($data['field'] as $keys=>$row)
			{ 
				if($type_map=='inherent'){
					$likelihood = $row['inherent_likelihood_text'];
					$impact = $row['inherent_impact_text'];
					$exposure=floatval($row['nilai_dampak']) * ($row['inherent_score']/100);
				}else{
					$likelihood = $row['residual_likelihood_text'];
					$impact = $row['residual_impact_text'];
					$exposure=floatval($row['nilai_dampak']) * ($row['residual_score']/100);
				}
				$ttl_eksposure +=$exposure;
				
				$html .= '<tr>
					<td>'.$i.'</td>
					<td>'.$row['corporate'].'</td>
					<td>'.$row['code'].'</td>
					<td>'.$row['description'].'</td>
					<td>'.$likelihood.'</td>
					<td>'.$impact.'</td>
					<td align="right">'.number_format(floatval($row['nilai_dampak'])/1000000).'</td>
					<td align="right">'.number_format($exposure/1000000).'</td>'; 
				
				$html .= '</tr>';
				++$i;
			}
		$html .= '</tbody>
		<tr>
				<td colspan="7" class="text-right"><strong>T O T A L</strong></td>
				<td class="text-right"><strong>'.number_format($ttl_eksposure/1000000).'</strong></td>
			</tr>
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
		$info = $this->session->userdata('info');
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
		$sheet->setCellValue('A'.$brs,$info->title);
		$sheet->setCellValue('A'.++$brs,$info->sub_title);
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
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Code");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Risk Event");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Likehood");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Impact");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Nilai Dampak");
		$sheet->setCellValue(huruf_kolom(++$kol).$brs,"Nilai Eksposure");
		
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(55);
		$sheet->getColumnDimension('C')->setWidth(9);
		$sheet->getColumnDimension('D')->setWidth(75);
		$sheet->getColumnDimension('E')->setWidth(17);
		$sheet->getColumnDimension('F')->setWidth(17);
		$sheet->getColumnDimension('G')->setWidth(20);
		$sheet->getColumnDimension('H')->setWidth(20);
		
		$koor['col2']=huruf_kolom($kol);
		$koor['row2']=$brs;
		$sheet->getStyle($koor['col1'].$koor['row1'].':'.$koor['col2'].$koor['row2'])->applyFromArray($style_title);
		
		++$brs;
		$i=1;
		$koor['col1']="A";
		$koor['row1']=$brs;
		$ttl_eksposure=0;
		// Doi::dump("JUmlahnya : " . count($data['field']));
		foreach($data['field'] as $keys=>$row)
		{ 
			if($type_map=='inherent'){
				$likelihood = $row['inherent_likelihood_text'];
				$impact = $row['inherent_impact_text'];
				$exposure=floatval($row['nilai_dampak']) * ($row['inherent_score']/100);
			}else{
				$likelihood = $row['residual_likelihood_text'];
				$impact = $row['residual_impact_text'];
				$exposure=floatval($row['nilai_dampak']) * ($row['residual_score']/100);
			}
			$ttl_eksposure +=$exposure;
			
			$kol=0;
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$i);
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row['corporate']);
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row['code']);
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$row['description']);
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$likelihood);
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,$impact);
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,floatval($row['nilai_dampak'])/1000000);
			$sheet->getStyle(huruf_kolom($kol).$brs)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->setCellValue(huruf_kolom(++$kol).$brs,floatval($exposure)/1000000);
			$sheet->getStyle(huruf_kolom($kol).$brs)->getNumberFormat()->setFormatCode('#,##0');
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
	function cek_term(){
		$sts = $this->authentication->get_Preference('term');
		$hasil['combo']="";
		$data['cboTerm']=$this->get_combo('term');
		$data['term_no']=$sts['id'];
		$hasil['ket']="Menentukan Term Aktif";
		$hasil['combo'] = $this->load->view("view_term", $data, true);
		echo json_encode($hasil);
	}
	
	function  get_kel(){
		$id = $this->input->post('id');
		$x = $this->data->get_kel($id);
		echo json_encode($x);
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */