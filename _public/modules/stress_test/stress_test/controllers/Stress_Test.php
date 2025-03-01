<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Stress_Test extends BackendController
{
	var $type_risk = 0;
	var $table = "";
	var $post = array();
	var $sts_cetak = false;

	public function __construct()
	{
		$this->required = '<sup><span class="required"> *) </span></sup> ';

		parent::__construct();
		$this->cbo_status_action 	= $this->get_combo('status-action');
		$this->cbo_parent 				= $this->get_combo('parent-input');
		$this->cbo_periode 				= $this->get_combo('periode');
		
		$user=$this->authentication->get_Info_User();
		$this->owner=$user['group']['owner']['owner_no'];
 		$this->periode= date('Y');
 		$this->semester  = $this->getSemester(date('n'));
		if ($this->input->get('periode')) {
			$this->periode = $this->input->get('periode');
		}
		if ($this->input->get('semester')) {
			$this->semester = $this->input->get('semester');
		}

	}
	

	public function index() { 
		$periode 								= $this->periode;
		$semester 							=  $this->semester;
		$data['indikatorData'] 	= $this->data->getIndikatorData($periode,$semester);
		$data['periode']				= $periode;
		$data['semester']				= $semester;
		$data['cboPeriod']  		= $this->cbo_periode;
		$this->template->build('home', $data);
	}

	public function simpan(){
		$post 	= $this->input->post();
		$id 	= $this->data->simpan($post, $this->periode, $this->semester);
		echo json_encode($post);
	}

	
	function getSemester($month) {

		// Tentukan semester berdasarkan bulan
		if ($month >= 1 && $month <= 6) {
			return 1;
		} elseif ($month >= 7 && $month <= 12) {
			return 2;
		}
	}

	public function get_warna()
{
    // Ambil data dari POST
    $post = $this->input->post();


    // Konversi tipe data input
    $id     = intval($post['id']); // Pastikan 'id' menjadi integer
    $type   = isset($post['best']) ? 'best' : (isset($post['base']) ? 'base' : 'worst'); // Tentukan tipe berdasarkan parameter yang ada
    $value  = str_replace('.', '', $post[$type]); // Menghapus titik sebagai pemisah ribuan
    $value  = str_replace(',', '.', $value); // Mengganti koma dengan titik desimal
    $value  = floatval($value); // Konversikan menjadi float

    // Ambil data dari database berdasarkan 'id'
    $res = $this->db->where('id', $id)
                    ->get('bangga_indikator_stress_test_detail')
                    ->row_array();

    // Periksa apakah data ditemukan
    if (empty($res)) {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        return;
    }

    // Ambil nilai 'rkap' dari hasil query dan tentukan kondisi
    $rkap = str_replace('.', '', $res['rkap']); // Menghapus titik dari 'rkap'
    $rkap = str_replace(',', '.', $rkap); // Mengganti koma dengan titik desimal
    $rkap = floatval($rkap); // Konversikan menjadi float

    // Tentukan hasil berdasarkan perbandingan antara $value dan $rkap
    if ($value < $rkap) {
        $result = $res['kurang']; // Ambil hasil jika value lebih kecil dari rkap
        $warna  = $res['color_kurang']; // Ambil warna jika value lebih kecil dari rkap
    } elseif ($value == $rkap) {
        $result = $res['sama']; // Ambil hasil jika value sama dengan rkap
        $warna  = $res['color_sama']; // Ambil warna jika value sama dengan rkap
    } else {
        $result = $res['lebih']; // Ambil hasil jika value lebih besar dari rkap
        $warna  = $res['color_lebih']; // Ambil warna jika value lebih besar dari rkap
    }

    // Format hasil sebagai respons JSON
    echo json_encode([
        'status' => 'success',
        'result' => $result,  // Menambahkan hasil perbandingan
        'warna'  => $warna,   // Menambahkan warna hasil perbandingan
        'type'   => $type,    // Menambahkan tipe parameter (best, base, atau worst)
        'id'     => $id       // Menambahkan id untuk referensi
    ]);
}


 

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */