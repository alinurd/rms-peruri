<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Regulasi_News extends BackendController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->model('data');
		$this->load->library('pagination');
		$this->load->helper('url');
	}

 
	 

	public function news()
	{
		$x = 'news';
		$items_per_page = 5;
		$page =  $this->uri->segment(3);
		if ($page == 0 || empty($page)) {
			$page = 1;
		}
		$query_result = $this->data->get_data($x, $page, $items_per_page);

		$total_rows = $this->data->count_data($x); // Retrieve the total rows from the model

		$config['base_url'] = base_url(_MODULE_NAME_REAL_ . '/$x/');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $items_per_page;
		$this->pagination->initialize($config);

		$data['currentPage'] = $page;
		$data['total_rows'] = $config['total_rows'];
		$data['per_page'] = $config['per_page'];
		$data['title'] = 'REGULATION | NEWS';
		$data['data'] = array_slice($query_result, 0, $config['per_page']); // No need to use $page here
		$data['pagination'] = $this->pagination->create_links();
		$this->template->build($x, $data);
	}
	
	public function index()
	{
		$x = 'news';
		$items_per_page = 5;
		$page =  $this->uri->segment(3);
		if ($page == 0 || empty($page)) {
			$page = 1;
		}
		$query_result = $this->data->get_data($x, $page, $items_per_page);

		$total_rows = $this->data->count_data($x); // Retrieve the total rows from the model

		$config['base_url'] = base_url(_MODULE_NAME_REAL_ . '/$x/');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $items_per_page;
		$this->pagination->initialize($config);

		$data['currentPage'] = $page;
		$data['total_rows'] = $config['total_rows'];
		$data['per_page'] = $config['per_page'];
		$data['title'] = 'REGULATION | NEWS';
		$data['data'] = array_slice($query_result, 0, $config['per_page']); // No need to use $page here
		$data['pagination'] = $this->pagination->create_links();
		$this->template->build($x, $data);
	}

	public function internal()
	{
		$x = 'internal';
		$items_per_page = 5;
		$page =  $this->uri->segment(3);
		if ($page == 0 || empty($page)) {
			$page = 1;
		}
		$query_result = $this->data->get_data($x, $page, $items_per_page);

		$total_rows = $this->data->count_data($x); // Retrieve the total rows from the model

		$config['base_url'] = base_url(_MODULE_NAME_REAL_ . '/$x/');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $items_per_page;
		$this->pagination->initialize($config);

		$data['currentPage'] = $page;
		$data['total_rows'] = $config['total_rows'];
		$data['per_page'] = $config['per_page'];
		$data['title'] = 'REGULATION | KEBIJAKAN INTERNAL';
		$data['data'] = array_slice($query_result, 0, $config['per_page']); // No need to use $page here
		$data['pagination'] = $this->pagination->create_links();
		$this->template->build($x, $data);
	}
	public function eksternal()
	{
		$x = 'eksternal';
		$items_per_page = 5;
		$page =  $this->uri->segment(3);
		if ($page == 0 || empty($page)) {
			$page = 1;
		}
		$query_result = $this->data->get_data($x, $page, $items_per_page);

		$total_rows = $this->data->count_data($x); // Retrieve the total rows from the model

		$config['base_url'] = base_url(_MODULE_NAME_REAL_ . '/$x/');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $items_per_page;
		$this->pagination->initialize($config);

		$data['currentPage'] = $page;
		$data['total_rows'] = $config['total_rows'];
		$data['per_page'] = $config['per_page'];
		$data['title'] = 'REGULATION | KEBIJAKAN EKSTERNAL';
		$data['data'] = array_slice($query_result, 0, $config['per_page']); // No need to use $page here
		$data['pagination'] = $this->pagination->create_links();
		$this->template->build($x, $data);
	}



	
	public function detail()
	{
		$id = $this->uri->segment(3);

		$data = $this->data->get_data_detail_news($id);
// doi::dump($data);
		$this->template->build('detail', $data);

	}
	public function downloadFile()
	{
		// Mendapatkan id file dari URI segment
		$id = $this->uri->segment(3);
		$pdx = $this->uri->segment(4);
		$data = $this->data->get_data_detail($id);
// 		$pd = str_replace('####', '/', $pdx);

// // 		echo $updatedUpd;
// // doi::dump($pd);
// // die();


// 		// Cek apakah data file ditemukan
// 		if ($pd) {
// 			header('Content-Type: application/octet-stream');
// 			header("Content-Disposition: attachment; filename=\"" . $id . "\"");
// 			header('Content-Length: ' . filesize($pd));
// 			// Membaca file dan mengirimkan isinya ke output
// 			readfile($pd);
// 			// echo "<script>alert('file tidak ditemukan atau permision jalur tidak sah'); window.history.go(-1);</script>";
// 		}
		
		if ($data) {
			// Mendapatkan path file yang akan diunduh
			$filePath = "themes/file/regulasi/" . $data['nm_file'];

			// Periksa apakah file ada sebelum melakukan unduhan
			
			if ($data['nm_file']) {
				if(file_exists($filePath)){
					// Mengatur header HTTP
					header('Content-Type: application/octet-stream');
					header("Content-Disposition: attachment; filename=\"" . $data['nm_file'] . "\"");
					header('Content-Length: ' . filesize($filePath));
					// Membaca file dan mengirimkan isinya ke output
					readfile($filePath);
				} else {
					echo "<script>alert('file tidak ditemukan atau permision jalur tidak sah'); window.history.go(-1);</script>";
				}
			
			} else {
				echo "<script>alert('" . htmlspecialchars($data['title']) . " Tidak memiliki lampiran'); window.history.go(-1);</script>";			
			}		
		} else {
			echo "<script>alert('Data file tidak ditemukan.'); window.history.go(-1);</script>";			

			// echo "Data file tidak ditemukan.";
		}
	}

 
}
