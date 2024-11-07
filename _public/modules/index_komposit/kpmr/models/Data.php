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
                            ->where('pid', 0)
                            ->where('aktif', 1)
                            ->get('bangga_data_combo')
                            ->result_array();
        
        foreach ($combos as $combo) {
            $comboData = [
                'data' => $combo['data'],
                'parent' => []
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
                    'bobot' => $parent['bobot'],
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
    
    function simpan($data, $owner, $tw) {
         foreach ($data['id'] as $index => $id) {
             $upd = array(
                'jenis' => 0,
                'id_komposit' => $id,
                'urut' => $data['urut'][$index],
                'penjelasan' => $data['penjelasan'][$index],
                'evidence' => $data['evidence'][$index],
                'realisasi' => $data['realisasi'][$index]
            );
    
             $res = $this->db->where('id_komposit', $id)
                            ->where('urut', $data['urut'][$index])
                            ->where('owner', $owner)
                            ->where('tw', $tw)
                            ->get(_TBL_INDEXKOM_REALISASI)
                            ->result_array();
    
            if (count($res) > 0) {
                 $upd['update_user'] = $this->authentication->get_Info_User('username');
                $whereDetail = ['id' => $res[0]['id'], 'urut' => $res[0]['urut'], 'owner' => $owner, 'tw' => $tw];
    
                $this->crud->crud_data(array(
                    'table' => _TBL_INDEXKOM_REALISASI,
                    'field' => $upd,
                    'where' => $whereDetail,
                    'type' => 'update'
                ));
                
                $result[] = $res[0]['id'];
            } else {
                 $upd['create_user'] = $this->authentication->get_Info_User('username');
                 $upd['owner'] = $owner;
                 $upd['tw'] = $tw;
    
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