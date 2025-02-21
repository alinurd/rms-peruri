<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Report_Risk_Criteria extends BackendController {
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
		$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 4));
		$this->addField(array('field' => 'judul_assesment', 'size' => 100, 'search' => false));
		$this->addField(array('field' => 'owner_no', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => true, 'search' => true));
		$this->addField(array('field' => 'officer_no', 'show' => false, 'save' => true, 'default' => $this->authentication->get_info_user('identifier')));
		$this->addField(array('field' => 'create_user', 'search' => false, 'default' => $this->authentication->get_info_user('username')));
		$this->addField(array('field' => 'period_no', 'input' => 'combo', 'combo' => $this->cbo_periode, 'size' => 15, 'search' => true, 'required' => true));
		$this->addField(array('field' => 'anggaran_rkap', 'type' => 'float', 'input' => 'float', 'required' => true));
		$this->addField(array('field' => 'owner_pic', 'size' => 100, 'search' => false));
		$this->addField(array('field' => 'anggota_pic', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'tugas_pic', 'input' => 'multitext:sms', 'size' => 10000));
		$this->addField(array('field' => 'tupoksi', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'sasaran', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->addField(array('field' => 'tahun_rcsa', 'show' => false));
		$this->addField(array('field' => 'bulan_rcsa', 'show' => false));

		$this->addField(array('field' => 'item_use', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
		$this->addField(array('field' => 'register', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
		$this->addField(array('field' => 'pi', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
		$this->addField(array('field' => 'progres', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
		// $this->addField(array('field' => 'status', 'input' => 'boolean', 'size' => 15));
		$this->addField(array('field' => 'name', 'show' => false));
		$this->addField(array('field' => 'periode_name', 'show' => false));
		$this->addField(array('field' => 'sts_propose_text', 'show' => false));
		$this->addField(array('field' => 'sts_propose', 'show' => false));

		$this->set_Open_Tab('Kriteria Probabilitas');
		$this->addField(array('field' => 'kriteria_probabilitas', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->set_Close_Tab();
		$this->set_Open_Tab('Kriteria Dampak ');
		$this->addField(array('field' => 'kriteria_dampak', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->set_Close_Tab();
  
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master));

		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'anggaran_rkap', 'span_right_addon' => ' Rp ', 'align' => 'right'));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'create_user', 'readonly' => true));

		$this->set_Sort_Table($this->tbl_master, 'urut_owner');
		$this->set_Table_List($this->tbl_master, 'judul_assesment', 'Judul Assessment ',20);
		$this->set_Table_List($this->tbl_master, 'name','Risk Owner');
		$this->set_Table_List($this->tbl_master, 'kriteria_probabilitas', 'Jumlah Probabilitas', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'kriteria_dampak', 'Jumlah Dampak', 10, 'center');
		$this->set_Table_List($this->tbl_master, 'periode_name','Periode',10,'center');
		$this->set_Table_List($this->tbl_master, 'register', 'View Risk Criteria', 10, 'center');

		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		$this->_CHANGE_TABLE_MASTER(_TBL_RCSA);
		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('edit', false);
		$this->_SET_PRIVILEGE('delete', false);

		// $this->_SET_PRIVILEGE('view', false);
		$this->tmp_data['setActionprivilege']=false;

		$this->set_Close_Setting();

	}

	function update_OPTIONAL_CMD($tombol,$rows)
	{
		$id 		= $rows['l_id'];
		$owner 		= $rows['l_owner_no'];
		$tahun 		= $rows['l_periode_name'];
		$result[] 	= array('posisi' => 'right', 'content' => '<a class="btn btn-warning btn-flat" style="width:100%;" data-content="Cetak Pdf" data-toggle="popover" href="' . base_url($this->modul_name . '/cetak-kriteria/pdf/' . $id.'/'.$owner.'/'.$tahun) . '" data-original-title="" title="" target="blank"><strong style="text-shadow: 1px 2px #020202;"><i class="fa fa-file-pdf-o"> Cetak Pdf</i></strong></a>');
		return $result;
	}

	function listBox_REGISTER($row, $value)
	{
		$id 	= $row['l_id'];
		$owner 	= $row['l_owner_no'];
		$tahun 	= $row['l_periode_name'];
		$result = '<a class=""  href="'.base_url($this->modul_name . '/view/'.$id.'/'.$owner.'/'.$tahun).'"><i class="fa fa-search pointer"></i></a>';
		return $result;
	}

	function listBox_KRITERIA_PROBABILITAS($rows, $value) {
		$id = $rows['l_id'];
		$kemungkinan = $this->db
			->where('kelompok', 'kriteria-kemungkinan')
			->where('param1', $id)  // Menambahkan kondisi untuk field param1
			->get(_TBL_DATA_COMBO)
			->result_array();
	
		if (empty($kemungkinan)) {
			$kemungkinan = $this->db
				->where('kelompok', 'kriteria-kemungkinan')
				->where('param1', NULL)  // Menambahkan kondisi untuk field param1 kosong
				->or_where('param1', '') // Jika kosong bisa berupa NULL atau string kosong
				->get(_TBL_DATA_COMBO)
				->result_array();
		}
	
		// Hitung jumlah data yang ditemukan
		$jml = count($kemungkinan);
	
		// Mengembalikan jumlah data yang ditemukan
		return $jml;
	}
	
	
	function listBox_KRITERIA_DAMPAK($rows, $value){
		$dampak = $this->db
		->where('kelompok', 'kriteria-dampak')
		->where('param1', $id)  // Menambahkan kondisi untuk field param1
		->get(_TBL_DATA_COMBO)
		->result_array();

		// Jika data `dampak` kosong, ambil data dengan `param1` kosong
		if (empty($dampak)) {
		$dampak = $this->db
			->where('kelompok', 'kriteria-dampak')
			->group_start()               // Memulai grouping kondisi untuk NULL atau string kosong
				->where('param1', NULL)
				->or_where('param1', '')  // Jika kosong bisa berupa NULL atau string kosong
			->group_end()                 // Mengakhiri grouping kondisi
			->get(_TBL_DATA_COMBO)
			->result_array();
		}
		$jml = count($dampak);
		return $jml;
	}	
	
	function insertBox_KRITERIA_PROBABILITAS($field){
		$content = $this->get_kriteria(1);
		return $content;
	}
	
	function updateBox_KRITERIA_PROBABILITAS($field, $row, $value){
		$content = $this->get_kriteria(1);
		return $content;
	}

	function insertBox_KRITERIA_DAMPAK($field){
		$content = $this->get_kriteria(2);
		return $content;
	}
	
	function updateBox_KRITERIA_DAMPAK($field, $row, $value){
		$content = $this->get_kriteria(2);
		return $content;
	}

	function get_kriteria($type1=1, $id=0)
	{
		$id=$this->uri->segment(3);
		if($type1==1){
			$kriteriaData 	= $this->db->where('category', 'likelihood')->get(_TBL_LEVEL)->result_array();
			$defaultColors 	= [
				1 => 'green',
				2 => 'lightgreen',
				3 => 'yellow',
				4 => 'orange',
				5 => 'red'
			];

			$data['kriteria'] = [];
			foreach ($kriteriaData as $item) {
				$level = (int)$item['code']; // Pastikan level berupa integer
				$data['kriteria'][$level] = [
					'name' => $item['level'], // Nama diambil dari database
					'color' => $defaultColors[$level] ?? 'gray' // Warna berdasarkan defaultColors
				];
			}
			$data['kemungkinan'] = $this->db
			->where('kelompok', 'kriteria-kemungkinan')
			->where('param1', $id)  // Menambahkan kondisi untuk field param1
			->get(_TBL_DATA_COMBO)
			->result_array();
	
			// Jika data `kemungkinan` kosong, ambil data dengan `param1` kosong
			if (empty($data['kemungkinan'])) {
				$data['kemungkinan'] = $this->db
					->where('kelompok', 'kriteria-kemungkinan')
					->where('param1', NULL)  // Menambahkan kondisi untuk field param1 kosong
					->or_where('param1', '') // Jika kosong bisa berupa NULL atau string kosong
					->get(_TBL_DATA_COMBO)
					->result_array();
			}
			$result = $this->load->view('krit_kemungkinan',  $data, true);
		}else{
			$kriteriaData = $this->db->where('category', 'impact')->get(_TBL_LEVEL)->result_array();
			$defaultColors = [
				1 => 'green',
				2 => 'lightgreen',
				3 => 'yellow',
				4 => 'orange',
				5 => 'red'
			];

			// Tambahkan warna ke data kriteria berdasarkan level
			$data['kriteria'] = [];
			foreach ($kriteriaData as $item) {
				$level = (int)$item['code']; // Pastikan level berupa integer
				$data['kriteria'][$level] = [
					'name' => $item['level'], // Nama diambil dari database
					'color' => $defaultColors[$level] ?? 'gray' // Warna berdasarkan defaultColors
				];
			}

			$data['dampak'] = $this->db
			->where('kelompok', 'kriteria-dampak')
			->where('param1', $id)  
			->get(_TBL_DATA_COMBO)
			->result_array();

			// Jika data `dampak` kosong, ambil data dengan `param1` kosong
			if (empty($data['dampak'])) {
			$data['dampak'] = $this->db
				->where('kelompok', 'kriteria-dampak')
				->group_start()               
					->where('param1', NULL)
					->or_where('param1', '')  // Jika kosong bisa berupa NULL atau string kosong
				->group_end()                 // Mengakhiri grouping kondisi
				->get(_TBL_DATA_COMBO)
				->result_array();
			}
			$result = $this->load->view('krit_dampak',  $data, true);
		}
		return $result;
	
	}


	
	function cetak_report(){
		$type=$this->uri->segment(3);
		$type=$this->uri->segment(3);
		$id_rcsa=$this->uri->segment(4);
		$data['field'] = $this->data->get_data_risk_register($id_rcsa);
		$data['rcsa'] = $this->data->get_data($id_rcsa);
		$this->$type($data);
	}

	function cetak_kriteria()
	{
		$tipe 			= $this->uri->segment(3);
		$id 			= $this->uri->segment(4);
		$owner 			= $this->uri->segment(5);
		$tahun 			= $this->uri->segment(6);
		$data 			= $this->db->where('id', $id)->get(_TBL_RCSA)->row_array();
		$parent_no 		= $this->data->get_data_parent($owner);
		$kepala 		= $parent_no[0]['parent_no'];
		$rows 			= $this->db->where('id', $data['owner_no'])->get(_TBL_OWNER)->row_array();
		$nama 			= $nama = 'Risk-Criteria-' . url_title($rows['name']);
		$data['field'] 	= $this->data->get_data_risk_context($id);
		$kriteriaDataKemungkinan 	= $this->db->where('category', 'likelihood')->get(_TBL_LEVEL)->result_array();

		$defaultColors = [
			1 => 'green',
			2 => 'lightgreen',
			3 => 'yellow',
			4 => 'orange',
			5 => 'red'
		];

		$data['kriteria_kemungkinan'] = [];
		foreach ($kriteriaDataKemungkinan as $item) {
			$level = (int)$item['code']; // Pastikan level berupa integer
			$data['kriteria_kemungkinan'][$level] = [
				'name' => $item['level'], // Nama diambil dari database
				'color' => $defaultColors[$level] ?? 'gray' // Warna berdasarkan defaultColors
			];
		}

		// doi::dump($data['kriteria_kemungkinan']);
		// die;

		
		$kriteriaDataDampak = $this->db->where('category', 'impact')->get(_TBL_LEVEL)->result_array();

			// Definisi warna default berdasarkan level
			$defaultColors = [
				1 => 'green',
				2 => 'lightgreen',
				3 => 'yellow',
				4 => 'orange',
				5 => 'red'
			];

			// Tambahkan warna ke data kriteria berdasarkan level
			$data['kriteria_dampak'] = [];
			foreach ($kriteriaDataDampak as $item) {
				$level = (int)$item['code']; // Pastikan level berupa integer
				$data['kriteria_dampak'][$level] = [
					'name' => $item['level'], // Nama diambil dari database
					'color' => $defaultColors[$level] ?? 'gray' // Warna berdasarkan defaultColors
				];
			}

			// doi::dump($data['kriteria_dampak'] );
			// die;
		// $data['kemungkinan'] = $this->db->where('kelompok', 'kriteria-kemungkinan')->get(_TBL_DATA_COMBO)->result_array();
		// Query untuk mengambil data kemungkinan berdasarkan kelompok dan param1
		$data['kemungkinan'] = $this->db
		->where('kelompok', 'kriteria-kemungkinan')
		->where('param1', $id)  // Menambahkan kondisi untuk field param1
		->get(_TBL_DATA_COMBO)
		->result_array();

	// Jika data `kemungkinan` kosong, ambil data dengan `param1` kosong
	if (empty($data['kemungkinan'])) {
		$data['kemungkinan'] = $this->db
			->where('kelompok', 'kriteria-kemungkinan')
			->where('param1', NULL)  // Menambahkan kondisi untuk field param1 kosong
			->or_where('param1', '') // Jika kosong bisa berupa NULL atau string kosong
			->get(_TBL_DATA_COMBO)
			->result_array();
	}

	$data['dampak'] = $this->db
			->where('kelompok', 'kriteria-dampak')
			->where('param1', $id)  
			->get(_TBL_DATA_COMBO)
			->result_array();

			// Jika data `dampak` kosong, ambil data dengan `param1` kosong
			if (empty($data['dampak'])) {
			$data['dampak'] = $this->db
				->where('kelompok', 'kriteria-dampak')
				->group_start()               
					->where('param1', NULL)
					->or_where('param1', '')  // Jika kosong bisa berupa NULL atau string kosong
				->group_end()                 // Mengakhiri grouping kondisi
				->get(_TBL_DATA_COMBO)
				->result_array();
			}
		// $data['fields']=$this->db->where('rcsa_no', $id)->where('kriteria_type', 1)->get(_TBL_RCSA_KRITERIA)->result_array();
		// $data['fields1']=$this->db->where('rcsa_no', $id)->where('kriteria_type', 2)->get(_TBL_RCSA_KRITERIA)->result_array();
		$data['id'] = $id;
		$data['tipe'] = $tipe;
		$data['tahun'] = $tahun;
		$data['tgl'] = $this->data->get_data_tanggal($id);
		$data['divisi'] = $this->db->where('id', $kepala)->get(_TBL_OWNER)->row();
		$hasil = $this->load->view('list_risk_criteria', $data, true);
		$cetak = 'register_' . $tipe;
		$this->$cetak($hasil, $nama);
	}
	
	function register_pdf($data, $nama = "Risk-Criteria")
	{
		$this->load->library('pdf');
		$tgl = date('d-m-Y');
		$this->nmFile = $nama .'-'.$tgl.".pdf";
		$this->pdfFilePath = download_path_relative($this->nmFile);
		// $html = "";

		$html .= '<style>
				table {
					border-collapse: collapse;
				
					
				}

				.test table > th > td {
					border: 1px solid #ccc;
					
				
				}
				</style>';

		
		// $html .= '<table width="100%" border="1"><tr><td width="100%" style="padding:0px;">';
		$html .= $data;
		// $html .= '</td></tr></table>';
		 // footer {page-break-after: always;}
		// $html .= "<div style='page-break-after:always'>" . $html . "</div>";
		// $html .= "<pagebreak />";
		
		// $html .= "<div style='page-break-after:avoid'>" . $html . "</div>";
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
        10, // margin bottomw
        5, // margin header
        5); // margin footer
		$pdf->SetHeader('');

		// $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822));
		$pdf->setFooter('|{PAGENO} Dari {nb} Halaman|');
		// $pdf->autoPageBreak = false;
		// $pdf->shrink_tables_to_fit = 0;
		$pdf->WriteHTML($html);
		
		ob_clean();

		$pdf->Output($this->pdfFilePath, 'F');
		redirect($this->pdfFilePath);

		return true;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */