<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Risk_Event_Library extends BackendController {
	var $type_risk=0;
	var $risk_type=[];
	public function __construct() {
        parent::__construct();
		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		ini_set('memory_limit', '-1');
		$this->type_risk=1;
		// $this->kel=array('0'=>' - Select - ','1'=>'Internal','2'=>'External');
 		$this->cbo_risk_type=$this->get_combo('risk_type');
		$this->cbo_status = [1=>'aktif', 0=>'tidak aktif'];
  		$this->t1=$this->get_combo('tasktonimi','t1');
  		$this->t2=$this->get_combo('tasktonimi','t2');
  		$this->t3=$this->get_combo('tasktonimi','t3');

		$this->set_Tbl_Master(_TBL_LIBRARY);
		$this->set_Table(_TBL_RISK_TYPE);
		
		$this->set_Open_Tab('Data Peristiwa Risiko T4');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			// $this->addField(array('field'=>'kel', 'type'=>'free', 'required'=>true, 'input'=>'combo', 'combo'=>$this->kel, 'size'=>50));
			$this->addField(array('field'=>'risk_type_no','title'=>'Kategori Risiko', 'input'=>'combo', 'required'=>false,'show'=>false, 'combo'=>$this->cbo_risk_type, 'size'=>50));
			$this->addField(array('field'=>'code','title'=>'Risk Event Code', 'show'=>false, 'search'=>false, 'size'=>10));
			$this->addField(array('field' => 't1', 'title' => 'Tema (T1)', 'input' => 'combo:search', 'combo' => $this->t1, 'size' => 80, 'search' => true, 'required' => true));
			$this->addField(array('field' => 't2', 'title' => 'Kategori (T2)', 'input' => 'combo:search', 'combo' => $this->t2, 'size' => 80, 'search' => true, 'required' => true));
			$this->addField(array('field' => 't3', 'title' => 'Kelompok (T3)', 'input' => 'combo:search', 'combo' => $this->t3, 'size' => 80, 'search' => true, 'required' => true));
			$this->addField(array('field'=>'description', 'title'=>'Peristiwa Risiko (T4)', 'search'=>true, 'required' => true, 'size'=>90));
		
			$this->addField(array('field'=>'notes','show'=>false, 'input'=>'multitext', 'search'=>false, 'size'=>500));
			$this->addField(array('field'=>'jml_couse', 'type'=>'free', 'show'=>false, 'search'=>false));
			$this->addField(array('field'=>'jml_impact', 'type'=>'free', 'show'=>false, 'search'=>false));
			$this->addField(array('field'=>'cause', 'type'=>'free', 'search'=>false, 'mode'=>'o'));
			$this->addField(array('field'=>'impact', 'type'=>'free', 'search'=>false, 'mode'=>'o'));
			$this->addField(array('field'=>'create_user', 'show'=>false));
			$this->addField(array('field'=>'status', 'input'=>'combo', 'combo'=>$this->cbo_status, 'default'=>1, 'size'=>40));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		$this->set_Where_Table($this->tbl_master, 'type', '=', $this->type_risk);
		
		// $this->set_Where_Table($this->tbl_master, 'create_user', '=', $this->authentication->get_Info_User('username'));
		
		// $this->set_Table_List($this->tbl_master,'kel');
		// $this->set_Table_List($this->tbl_risk_type,'type');
		$this->set_Table_List($this->tbl_master,'code', '', 5);
		$this->set_Table_List($this->tbl_master, 'kategori_risiko', 'Kategori Risiko', 5);
		$this->set_Table_List($this->tbl_master,'description', '', 20);
		// $this->set_Table_List($this->tbl_master,'notes');
		$this->set_Table_List($this->tbl_master,'jml_couse', 'Jumlah Cause', 10, 'center');
		$this->set_Table_List($this->tbl_master,'jml_impact', 'Jumlah Impact', 10, 'center');
		$this->set_Table_List($this->tbl_master,'create_user');
		$this->set_Table_List($this->tbl_master,'status');
		// $this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		$this->set_Close_Setting();
	}
	
	function MASTER_DATA_LIST($id, $field){
		$rows = $this->db->get(_TBL_RISK_TYPE)->result_array();
		$this->risk_type=[];
		foreach($rows as $row){
			$this->risk_type[$row['id']]=$row['kelompok'];
		}
	}
	
	function listBox_KATEGORI_RISIKO($rows, $value){
	if($rows['l_kategori_risiko']){

		$hasil = $this->kel[$rows['l_kategori_risiko']] ;
	}else{
		$hasil ='-';
	}

		return $hasil;
	}
	function listBox_KEL($rows, $value){
		$value = $rows['l_risk_type_no'];
		$hasil='';
		if (array_key_exists($value, $this->risk_type))
			$hasil=$this->kel[$this->risk_type[$value]];
		return $hasil;
	}
	
	
	function updateBox_KEL($field, $rows, $value){
		$id=$rows['l_risk_type_no'];
		$rows = $this->db->where('id', $id)->get(_TBL_RISK_TYPE)->row_array();
		
		if ($rows){$value = $rows['kelompok'];}
				
		$content = $this->add_Box_Input('combo', $field, $value);
		return $content;
	}

	function insertBox_CODE($field)
	{
		// doi::dump()
		$query = $this->db->select('code')
		->from(_TBL_LIBRARY)
		->order_by('code', 'DESC')
		->limit(1)
		->get();

		// Memeriksa apakah ada hasil yang ditemukan
		if ($query->num_rows() > 0) {
			// Jika ada, ambil data terakhirnya
			$row = $query->row();
			$lastcode = $row->code;
			// echo "Data terakhir: " . $lastcode;
		} else {
			// Jika tidak ada hasil, berikan pesan yang sesuai
			echo "Tidak ada data yang ditemukan.";
		}


		$content = form_input($field['label'], $lastcode + 1, " size='{$field['size']}' class='form-control'  id='{$field['label']}' readonly='readonly' ");
		return $content;
	}
	
	function updateBox_CODE($field, $row, $value){
		$content = form_input($field['label'],$value," size='{$field['size']}' class='form-control'  id='{$field['label']}' readonly='readonly' ");
		return $content;
	}
	
	public function index() {	
		$this->data_fields['dat_edit']['fields']=$this->post;
		$this->data_fields['search']=$this->load->view('statis/tmp_search',$this->data_fields,true);	
		$this->_param_list_['content']=$this->load->view('statis/tmp_table',$this->data_fields,true);
		$this->template->build('statis/table',$this->_param_list_); 
	}
	
	function insertBox_CAUSE($field){
		$content = $this->get_cause();
		return $content;
	}
	
	function updateBox_CAUSE($field, $row, $value){
		$content = $this->get_cause();
		return $content;
	}
	
	function get_cause()
	{
		$id=$this->uri->segment(3);
		$data=$this->data->get_library($id, 2);
		$data['angka']="10";
		$data['cbogroup']=$this->get_combo('library', 2);
		$result=$this->load->view('cause',$data,true);
		return $result;
	}
	
	function insertBox_IMPACT($field){
		$content = $this->get_impact();
		return $content;
	}
	
	function updateBox_IMPACT($field, $row, $value){
		$content = $this->get_impact();
		return $content;
	}
	
	function get_impact()
	{
		$id=$this->uri->segment(3);
		$data=$this->data->get_library($id, 3);
		$data['angka']="10";
		$data['cbogroup']=$this->get_combo('library', 3);
		$result=$this->load->view('impact',$data,true);
		return $result;
	}
	
	function listBox_STATUS($row, $value){
		if ($value=='1')
			$result='<span class="label label-success"> Aktif</span>';
		else
			$result='<span class="label label-warning"> Off</span>';
		
		return $result;
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){

 		$result = $this->data->save_library($id , $new_data, $this->type_risk, 'new');
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$result = $this->data->save_library($id , $new_data, $this->type_risk, 'edit', $old_data);
		return $result;
	}
	
	function POST_CHECK_BEFORE_UPDATE($new_data, $old_data){
		$result=true;
		if ($old_data['l_code'] !== $new_data['l_code'])
		{
			$result = $this->crud->cek_double_data_library($new_data['l_code'], 1);
		}
		return $result;
	}
	
	function POST_CHECK_BEFORE_DELETE($ids=array()){
		$ada=false;
		// Doi::dump($ids);die();
		foreach($ids as $row){
			$value=$this->data->cari_total_dipakai($row);
			if ($value['jml']>0){
				$this->_set_pesan('Event : ' . $value['nama_lib']);
				$ada=true;
			}
		}
		if ($ada)
			$this->_set_pesan('Tidak bisa dihapus');
		
		return !$ada;
	}
	
	function subDelete_PROCESSOR($param){
		$this->crud->crud_data(array('table'=>_TBL_LIBRARY_DETAIL, 'where'=>array('id'=>$param['iddel']),'type'=>'delete'));
		$hasil['ket'] ="Data berhasil di hapus!";
		$hasil['sts'] =true;
		return $hasil;
	}
	
	function listBox_JML_COUSE($row, $value){
		$result='';
		$value=$this->data->cari_total_dipakai($row['l_id']);
		if ($value['jmlCouse']>0)
			$result =  '<span class="badge bg-info">' . $value['jmlCouse'] . '</span>';
		return $result;
	}
	
	function listBox_JML_IMPACT($row, $value){
		$result='';
		$value=$this->data->cari_total_dipakai($row['l_id']);
		if ($value['jmlImpact']>0)
			$result =  '<span class="badge bg-info">' . $value['jmlImpact'] . '</span>';
		return $result;
	}
}