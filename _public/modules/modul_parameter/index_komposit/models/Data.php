<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	 
		
	function save_privilege($newid=0, $data=array(), $old_data=array())
{
    // doi::dump($data);
   
      if (isset($data['urut'])) {
        $no = 0;
        foreach ($data['urut'] as $index => $urut) {
             $upd = [
                'id_combo' => $newid,
                'urut' => $urut,
                'parameter' => $data['param'][$index],
                'min' => $data['min'][$index],
                'max' => $data['max'][$index],
                'skala' => $data['skala'][$index],
                'penilaian' => $data['penilaian'][$index],
                'bobot' => $data['bobot'][$index]
            ];
            
             $x = $this->db->where('id_combo', $newid)->where('urut', $urut)->get("bangga_index_komposit")->row_array();

            if (intval($x['id'])) {
                $upd['update_user'] = $this->authentication->get_Info_User('username');
                $where = ['id' => $x['id']];
                $this->crud->crud_data(array('table' => "bangga_index_komposit", 'field' => $upd, 'where' => $where, 'type' => 'update'));
                $id=$x['id'];
            } else {
                $upd['create_user'] = $this->authentication->get_Info_User('username');
                $this->crud->crud_data(array('table' => "bangga_index_komposit", 'field' => $upd, 'type' => 'add'));
                $id = $this->db->insert_id(); 
            }

             if (isset($data['detail_param'][$urut])) {
                foreach ($data['detail_param'][$urut] as $detailIndex => $detailUrut) {
                    $updDetail = [
                        'urut' => $urut,
                        'parameter' => $data['detail_param'][$urut][$detailIndex],
                        'skala' => $data['detail_skala'][$urut][$detailIndex],
                        'min' => $data['detail_min'][$urut][$detailIndex],
                        'max' => $data['detail_max'][$urut][$detailIndex],
                        'penilaian' => $data['detail_penilaian'][$urut][$detailIndex]
                    ];
                     $xDetail = $this->db->where('id_param', $id)->where('urut', $urut)->get("bangga_index_komposit_detail")->row_array();
                     if (isset($data['detail_edit'][$urut][$detailIndex])) {
                        $updDetail['update_user'] = $this->authentication->get_Info_User('username');
                        $whereDetail = ['id' => $data['detail_edit'][$urut][$detailIndex]];
                        $this->crud->crud_data(array('table' => "bangga_index_komposit_detail", 'field' => $updDetail, 'where' => $whereDetail, 'type' => 'update'));
                    } else {
                        $updDetail['id_param'] = $id;
                        $updDetail['create_user'] = $this->authentication->get_Info_User('username');
                        $this->crud->crud_data(array('table' => "bangga_index_komposit_detail", 'field' => $updDetail, 'type' => 'add'));
                    }
                }
            }
        }
     }
      return true;
}

}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */