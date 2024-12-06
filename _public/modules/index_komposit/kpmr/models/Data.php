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
    
    function simpan($data, $owner, $tw, $periode) {
        // Optional: If you want to use $owner, you can still extract it like this
        // $owner = $data['owner']; 
        $tw = $data['tw'];
        $periode = $data['periode'];
    
        $result = []; // To store the result of each insert or update
    
        foreach ($data['id'] as $index => $id) {
            // Handle file upload for evidence[]
            $file_name = null; // Default to null if no file is uploaded
    
            if (isset($_FILES['evidence']['name'][$index]) && $_FILES['evidence']['name'][$index] != '') {
                // Upload the file if it exists
                $file_tmp = $_FILES['evidence']['tmp_name'][$index];
                $file_name = $_FILES['evidence']['name'][$index];
                $upload_dir = 'uploads/'; // Set your upload directory here
    
                // Sanitize and move the file to the desired location
                $upload_path = $upload_dir . basename($file_name);
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    $file_name = $upload_path; // Update the file name with the path
                } else {
                    $file_name = null; // If file upload failed, keep it null
                }
            }
    
            // Prepare data for insert or update
            $upd = array(
                'jenis' => 0,
                'id_komposit' => $id,
                'urut' => $data['urut'][$index],
                'penjelasan' => $data['penjelasan'][$index],
                'evidence' => $file_name, // Save the file path or null if no file was uploaded
                'realisasi' => $data['realisasi'][$index],
                'tw' => $tw,
                'periode' => $periode
            );
    
            // Check if the record exists
            $res = $this->db->where('id_komposit', $id)
                            ->where('urut', $data['urut'][$index])
                            ->where('tw', $tw)
                            ->where('jenis', 0)
                            ->where('periode', $periode)
                            ->get(_TBL_INDEXKOM_REALISASI)
                            ->result_array();
    
            if (count($res) > 0) {
                // If record exists, update it
                $upd['update_user'] = $this->authentication->get_Info_User('username');
                $whereDetail = [
                    'id' => $res[0]['id'],
                    'urut' => $res[0]['urut'],
                    'jenis' => 0,
                    'tw' => $tw,
                    'periode' => $periode
                ];
    
                // Perform the update query
                $this->crud->crud_data(array(
                    'table' => _TBL_INDEXKOM_REALISASI,
                    'field' => $upd,
                    'where' => $whereDetail,
                    'type' => 'update'
                ));
                
                $result[] = $res[0]['id']; // Store the updated record ID
            } else {
                // If record does not exist, insert a new one
                $upd['create_user'] = $this->authentication->get_Info_User('username');
                $result[] = $this->crud->crud_data(array(
                    'table' => _TBL_INDEXKOM_REALISASI,
                    'field' => $upd,
                    'type' => 'add'
                ));
            }
        }
    
        return $result; // Return the result (IDs of inserted/updated records)
    }
    
    
    
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */