<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}

    public function getKompositData()
    {
        $result = [];
        
         $combos = $this->db->where('kelompok', 'Index Komposit')
                            ->where('pid', 1)
                            ->where('aktif', 1)
                            ->get('bangga_data_combo')
                            ->result_array();
        
        foreach ($combos as $combo) {
            $comboData = [
                'data' => $combo['data'],
                'parent' => [],
                'detail' => [],
            ];
             $parents = $this->db->where('id_combo', $combo['id'])
                                ->order_by('urut')
                                ->get('bangga_index_komposit')
                                ->result_array();
            
            foreach ($parents as $parent) {
                $parentData = [
                    'id' => $parent['id'],
                    'id_combo' => $parent['id_combo'],
                    'urut' => $parent['urut'],
                    'parameter' => $parent['parameter'],
                    'skala' => $parent['skala'],
                    'penilaian' => $parent['penilaian'],
                    'detail' => []
                ];
 
                $details = $this->db->where('id_param', $parent['id'])
                                    ->order_by('urut')
                                    ->get('bangga_index_komposit_detail')
                                    ->result_array();
                $comboData['detail'][$parent['id']] = $details;
                $comboData['parent'][] = $parentData;
            }

            $result[] = $comboData;
        }

        return $result;
    }
    

    function simpan($data) {
        foreach ($data['id'] as $index => $id) {
            $upd = array(
               'jenis' => 1,
               'id_komposit' => $id,
               'urut' => $data['urut'][$index],
               'target' => $data['target'][$index],
               'realisasitw' => $data['realisasitw'][$index],
               'absolut' => $data['absolut'][$index],
               'realisasi' => $data['realisasi'][$index]
           );
   
            $res = $this->db->where('id_komposit', $id)
                           ->where('urut', $data['urut'][$index])
                           ->get(_TBL_INDEXKOM_REALISASI)
                           ->result_array();
   
           if (count($res) > 0) {
                $upd['update_user'] = $this->authentication->get_Info_User('username');
               $whereDetail = ['id' => $res[0]['id'], 'urut' => $res[0]['urut']];
   
               $this->crud->crud_data(array(
                   'table' => _TBL_INDEXKOM_REALISASI,
                   'field' => $upd,
                   'where' => $whereDetail,
                   'type' => 'update'
               ));
               
               $result[] = $res[0]['id'];
           } else {
                $upd['create_user'] = $this->authentication->get_Info_User('username');
   
               $result[] = $this->crud->crud_data(array(
                   'table' => _TBL_INDEXKOM_REALISASI,
                   'field' => $upd,
                   'type' => 'add'
               ));
           }
       }
       
       return $result;
   }
   
    
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */