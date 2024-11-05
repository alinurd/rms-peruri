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
    
    
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */