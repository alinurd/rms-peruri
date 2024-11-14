<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Indikator_Stress_Test extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->sms=[1=>"Semester 1", 2=>"Semester 2"];
		$this->set_Tbl_Master(_TBL_VIEW_INDIKATOR_STRESS_TEST);
		$this->periode = $this->get_combo('periode');
		
		$this->set_Open_Tab('Index Indikator Stress Test');
		$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
		$this->addField(array('field'=>'periode_name', 'type'=>'int', 'show'=>false, 'size'=>4));
		$this->addField(array('field'=>'judul','title' => 'Judul', 'required'=>true, 'search'=>true, 'size'=>100));
		$this->addField(array('field'=>'periode', 'title' => 'periode', 'required' => true, 'input'=>'combo', 'combo'=>$this->periode, 'search'=>true, 'size'=>20));
		$this->addField(array('field'=>'semester', 'title' => 'Semester', 'input'=>'combo', 'combo'=>$this->sms, 'search'=>true, 'size'=>20));
		$this->addField(array('field'=>'urut', 'title' => 'Urut', 'input'=>'number', 'size'=>20));
		$this->addField(array('field'=>'status', 'type'=>'string', 'input'=>'boolean', 'search'=>true, 'size'=>20));
		$this->addField(array('field'=> 'indikator', 'type' => 'free', 'input' => 'free', 'mode' => 'o', 'size' => 100, 'title' => 'Indikator'));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		$this->set_Sort_Table($this->tbl_master,'id');
		$this->set_Table_List($this->tbl_master,'judul','',50);
		$this->set_Table_List($this->tbl_master,'periode_name', 'Tahun', 10,'center');
		$this->set_Table_List($this->tbl_master,'semester', 'Semester', 10,'center');
		$this->set_Table_List($this->tbl_master,'status','',10, 'center');
		$this->set_Table_List($this->tbl_master,'indikator', 'jml Parameter', 10, 'center');
		$this->_CHANGE_TABLE_MASTER(_TBL_INDIKATOR_STRESS_TEST);
		$this->set_Close_Setting();
	}

	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows)
	{
		$tombol['print'] = [];
		$id = $rows['l_id'];
		$url = base_url($this->modul_name . '/copy/' . $id);
		$tombol['copy'] = ['default' => false, 'url' => $url, 'label' => '<a   href="' . base_url($this->modul_name . '/copy/' . $id) . '"title="Duplikat Indikator Stress Test"></i>Copy'];

		return $tombol;
	}

	public function copy()
	{
		$id 						= $this->uri->segment(3);
		$disable 					= 'disabled';
		$data['indikator_st'] 		= $this->db->where('id', $id)->get(_TBL_VIEW_INDIKATOR_STRESS_TEST)->row_array();
		$data['detail_indikator'] 	= $this->db->where('id_parent', $id)->get(_TBL_INDIKATOR_STRESS_TEST_DETAIL)->result_array();
		$data['judul'] 				= form_input('cjudul', ($data['indikator_st']) ? $data['indikator_st']['judul'] : '', 'class="form-control disable" style="width:100%;" id="cjudul"' . $disable);
		$data['tahun'] 				= form_dropdown('ctahun', $this->periode, '', 'class="form-control select2" style="width:100%;" id="ctahun"');
		$data['semester'] 				= form_dropdown('csemester', $this->sms, '', 'class="form-control select2" style="width:100%;" id="csemester"');
		$data['id'] 				= form_hidden(['id' => $id]);
		$this->template->build('copi', $data);

	}

	public function simpan_copy(){
		// echo "OK";
		$post = $this->input->post();
		$data_header = $this->db->where('id', $post['id'])->get(_TBL_INDIKATOR_STRESS_TEST)->row_array();
		$data_detail = $this->db->where('id_parent', $post['id'])->get(_TBL_INDIKATOR_STRESS_TEST_DETAIL)->result_array();
		

		$upd = [
            'judul'         => $data_header['judul'],
            'periode'       => $post['ctahun'],
            'semester'      => $post['csemester'],
            'status'        => $data_header['status'],
            'urut'        => $data_header['urut']
        ];

		$upd['create_user'] = $this->authentication->get_Info_User('username');
		$this->crud->crud_data(array('table' => "bangga_indikator_stress_test", 'field' => $upd, 'type' => 'add'));
		$id = $this->db->insert_id();

		if ($data_detail) {
			foreach ($data_detail as $index => $value) {
				$updd = [
                    'id_parent'     => $id,
                    'urut'          => $value['urut'],
                    'parameter'     => $value['parameter'],
                    'rkap'          => $value['rkap'],
                    'satuan'        => $value['satuan'],
                    'kurang'        => $value['kurang'],
                    'sama'          => $value['sama'],
                    'lebih'         => $value['lebih'],
                    'color_kurang'  => $value['color_kurang'],
                    'color_sama'    => $value['color_sama'],
                    'color_lebih'   => $value['color_lebih']
                ];

				$updd['create_user'] = $this->authentication->get_Info_User('username');
				$this->crud->crud_data(array('table' => "bangga_indikator_stress_test_detail", 'field' => $updd, 'type' => 'add'));
		
			}

			
		}

		
		header('location:' . base_url('indikator-stress-test'));
	}
 

	function insertBox_INDIKATOR($field)
	{
		$return = $this->indikator();
		return $return;
	}

	function updateBox_INDIKATOR($field, $rows, $value)
	{
		// doi::dump($rows['l_id']);
		$return = $this->indikator($rows['l_id']);

		return $return;
	}

	function POST_DELETE_PROCESSOR($ids) {
		// Periksa apakah $ids adalah array
		if (!is_array($ids)) {
			return false; // Kembalikan false jika input bukan array
		}
		$this->db->where('id', $id);
		$del = $this->db->delete('bangga_indikator_stress_test');
		foreach ($ids as $id) {
			$this->db->where('id_parent', $id);
			$del = $this->db->delete('bangga_indikator_stress_test_detail');
			
			// Cek apakah penghapusan gagal
			if (!$del) {
				return false; // Kembalikan false jika salah satu penghapusan gagal
			}
		}
		
		return true; // Kembalikan true jika semua penghapusan berhasil
	}
	

	function indikator($id = 0)
	{
		$rows = $this->db->where('id_parent', $id)->order_by('urut')->get("bangga_indikator_stress_test_detail")->result_array();
 		$data['data']=$rows;
		$result = $this->load->view('indikator', $data, true);
		return $result;
	
	}

	function POST_CHECK_BEFORE_INSERT($data) {
		$ada = false;
	
		// 3. Pengecekan apakah periode dan semester sudah ada di database
		$this->db->where('periode', $data['l_periode']);
		$this->db->where('semester', $data['l_semester']);
		$this->db->where('judul', $data['l_judul']);
	
		// Abaikan data yang sedang diedit
		if (isset($data['l_id']) && !empty($data['l_id'])) {
			$this->db->where('id !=', $data['l_id']);
		}
	
		$existing_data = $this->db->get('bangga_view_indikator_stress_test')->row();
	
		if ($existing_data) {
			$this->_set_pesan('Data dengan periode ' . $existing_data->periode_name . ' dan semester ' . $data['l_semester'] . ' sudah ada.');
			$ada = true;
		}
	
		// 6. Mengembalikan status error
		if ($ada) {
			$this->_set_pesan('Gagal menyimpan, silakan periksa kembali.');
			return FALSE;
		}
	
		// Jika semua validasi lolos
		return TRUE;
	}
	

	function POST_INSERT_PROCESSOR($id , $new_data){
 		$result = $this->data->save_privilege($id , $new_data);
		if (!$result)
			return $result;
		
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$result = $this->data->save_privilege($id , $new_data, $old_data);
		if (!$result)
			return $result;
		
		return $result;
	}



	function listBox_PID($row, $value){
		$x="KMPR";
		if($value==1){
			$x="Kinerja";
		} 
		return $x;
	}
	
	function listBox_INDIKATOR($row, $value){
 		$rows = $this->db->where('id_parent', $row['l_id'])->get("bangga_indikator_stress_test_detail")->result_array();
 		
				return count($rows);
	}
	
}