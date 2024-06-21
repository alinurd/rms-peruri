<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report_Monitoring extends BackendController {
	var $tmp_data=array();
	var $data_fields=array();

	public function __construct()
	{
        parent::__construct();
		$this->load->model('data');
		$table=$this->config->item('tbl_suffix').'items';
	}

	public function index()
	{
		$data['korporasi'] = $this->get_combo('parent-input');
		$data['bulan']=$this->get_combo('bulan');
		$data['periode']=$this->get_combo('periode');
		$data['risk_context']=' - select -';
		$this->template->build('info', $data);
	}

	function get_gr(){
		$post=$this->input->post();
		$data['coba']=$this->data->coba($post);
		$data['post']=$this->input->post();
	
		$result['combo']=$this->load->view('grafik', $data, true);
		echo json_encode($result);

	}
	function cetak_register()
	{
		
		$post =array();
		$tipe = $this->uri->segment(3);
		$data['tipe'] = $tipe;

		$owner_no = $this->uri->segment(4);
		$periode_no = $this->uri->segment(5);
		$bulan = $this->uri->segment(6);
		$tahun = $this->uri->segment(7);
		$bulan2 = $this->uri->segment(8);
		$rows = $this->db->where('id', $owner_no)->get(_TBL_OWNER)->row_array();
		$name = $rows['name'];
		$nama = $nama = 'Risk-Monitoring-' . url_title($rows['name']);		

		$post['owner_no']=$owner_no;
		$post['periode_no']=$periode_no;
		$post['bulan']=$bulan;
		$post['tahun']=$tahun;
		$post['unit']=$name;
		$post['bulan2']=$bulan2;

		$coba = $this->data->coba($post);
	

		$hasil = $this->load->view('grafik', ['coba' => $coba,'post'=>$post], true);
	
		$cetak = 'register_' . $tipe;
		$this->$cetak($hasil, $nama);
	}

	function register_excel($data, $nama = "Risk-Monitoring")
	{
		header("Content-type:appalication/vnd.ms-excel");
		header("content-disposition:attachment;filename=" . $nama . ".xls");

		$html = $data;
		echo $html;
		exit;
	}

	function register_pdf($data, $nama = "Risk-Monitoring")
	{
		$this->load->library('pdf');
		$tgl = date('d-m-Y');
		$this->nmFile = $nama .'-'.$tgl.".pdf";
		$this->pdfFilePath = download_path_relative($this->nmFile);

		$html = '<style>
				table {
					border-collapse: collapse;
					border-spacing: 0;
				}

				.test table > th > td {
					border: 1px solid #ccc;
				}
				</style>';


		// $html .= '<table width="100%" border="0"><tr><td width="100%" style="padding:0px;">';
		$html .= $data;
		// $html .= '</td></tr></table>';

		$pdf = $this->pdf->load('en-GB-x,legal,,,5,5,5,5,6,3');
		$pdf->AddPage('L','', // L - landscape, P - portrait
		 '', '', '',
        35, // margin_left
        10, // margin right
        3, // margin top
        3, // margin bottom
        3, // margin header
        3); // margin footer

		$pdf->SetHeader('');
		$pdf->setFooter('|{PAGENO} Dari {nb} Halaman|');
		$pdf->WriteHTML($html);
		ob_clean();

		$pdf->Output($this->pdfFilePath, 'F');
		redirect($this->pdfFilePath);

		return true;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */