<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}

    public function getIndikatorData($periode,$semester)
    {
        $data_periode = $this->db->where('periode_name', $periode)->get('bangga_period')
        ->result_array();
        $id_periode = $data_periode[0]['id'];
        $result = [];
       // Query untuk mengambil data dengan kondisi tertentu dan urutkan berdasarkan kolom
        $result = $this->db->where('status', 1)
        ->where('periode', $id_periode)
        ->where('semester', $semester)
        ->order_by('urut', 'ASC') // Ganti 'column_name' dengan nama kolom yang ingin diurutkan, dan 'ASC' untuk ascending atau 'DESC' untuk descending
        ->get('bangga_indikator_stress_test')
        ->result_array();

        return $result;
    }
    
    function simpan($data, $periode,$semester) {
        // $owner=$data['owner'];
        $semester   = $data['semester'];
        $periode    = $data['periode'];

         foreach ($data['id'] as $index => $id) {
             $upd = array(
                'id_indikator_detail'  => $id,
                'semester'      => $semester,
                'periode'       => $periode,
                'urut'          => $data['urut'][$index],
                'best'          => $data['best'][$index],
                'base'          => $data['base'][$index],
                'worst'         => $data['worst'][$index],
                'color_best'          => $data['color_best'][$index],
                'color_base'          => $data['color_base'][$index],
                'color_worst'         => $data['color_worst'][$index]
            );

            
    
             $res = $this->db->where('id_indikator_detail', $id)
                            ->where('urut', $data['urut'][$index])
                            ->where('semester', $semester)
                            ->where('periode', $periode)
                            ->get(_TBL_STRESS_TEST)
                            ->result_array();
    
            if (count($res) > 0) {
                $upd['update_user'] = $this->authentication->get_Info_User('username');
                $whereDetail = ['id' => $res[0]['id'], 'urut' => $res[0]['urut'],'semester' => $semester, 'periode' => $periode];
    
                $this->crud->crud_data(array(
                    'table' => _TBL_STRESS_TEST,
                    'field' => $upd,
                    'where' => $whereDetail,
                    'type' => 'update'
                ));
                
                $result[] = $res[0]['id'];
            } else {
                 $upd['create_user'] = $this->authentication->get_Info_User('username');
                //  $upd['owner'] = $owner;
                 $upd['semester'] = $semester;
                 $upd['periode'] = $periode;
                $result[] = $this->crud->crud_data(array(
                    'table' => _TBL_STRESS_TEST,
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