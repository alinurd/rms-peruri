<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	 
		
	function save_privilege($newid=0, $data=array(), $old_data=array())
{
     if (isset($data['urut'])) {
        $no = 0;
        foreach ($data['urut'] as $index => $urut) {
            // Data utama yang akan disimpan
            $upd = [
                'id_combo' => $newid,
                'urut' => $urut,
                'parameter' => $data['param'][$index],
                'skala' => $data['skala'][$index],
                'penilaian' => $data['penilaian'][$index]
            ];
            
            // Cek apakah data utama sudah ada
            $x = $this->db->where('id_combo', $newid)->where('urut', $urut)->get("bangga_index_komposit")->row_array();

            if (intval($x['id'])) {
                $upd['update_user'] = $this->authentication->get_Info_User('username');
                $where = ['id' => $x['id']];
                $this->crud->crud_data(array('table' => "bangga_index_komposit", 'field' => $upd, 'where' => $where, 'type' => 'update'));
            } else {
                $upd['create_user'] = $this->authentication->get_Info_User('username');
                $this->crud->crud_data(array('table' => "bangga_index_komposit", 'field' => $upd, 'type' => 'add'));
                $id = $this->db->insert_id(); // Mengambil ID terakhir yang disimpan
            }

             // Menyimpan data detail
            if (isset($data['detail_urut'][$urut])) {
                foreach ($data['detail_urut'][$urut] as $detailIndex => $detailUrut) {
                    $updDetail = [
                        'id_param' => $id,
                        'urut' => $detailUrut,
                        'parameter' => $data['detail_param'][$urut][$detailIndex],
                        'skala' => $data['detail_skala'][$urut][$detailIndex],
                        'penilaian' => $data['detail_penilaian'][$urut][$detailIndex]
                    ];

                    // Cek apakah data detail sudah ada
                    $xDetail = $this->db->where('id_param', $id)->where('urut', $detailUrut)->get("bangga_index_komposit_detail")->row_array();
                    if (intval($xDetail['id'])) {
                        $updDetail['update_user'] = $this->authentication->get_Info_User('username');
                        $whereDetail = ['id' => $xDetail['id']];
                        $this->crud->crud_data(array('table' => "bangga_index_komposit_detail", 'field' => $updDetail, 'where' => $whereDetail, 'type' => 'update'));
                    } else {
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