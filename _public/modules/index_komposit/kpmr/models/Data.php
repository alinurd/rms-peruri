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
        $owner = $data['owner']; 
        $tw = $data['tw'];
        $periode = $data['periode'];
    
        $result = [];
    
        foreach ($data['id'] as $index => $id) {
            // Initialize file_name to null
            $file_name = null;
    
            // Fetch existing file from the database for this record
            $existing_file = $this->db->select('evidence')->from(_TBL_INDEXKOM_REALISASI)->where('id_komposit', $id)->get()->row();
    
            // Check if an 'evidence' file is uploaded
            if (isset($_FILES['evidence']['name'][$index]) && $_FILES['evidence']['name'][$index] != '') {
                $_FILES['userfile'] = [
                    'name'      => $_FILES['evidence']['name'][$index],
                    'type'      => $_FILES['evidence']['type'][$index],
                    'tmp_name'  => $_FILES['evidence']['tmp_name'][$index],
                    'error'     => $_FILES['evidence']['error'][$index],
                    'size'      => $_FILES['evidence']['size'][$index],
                ];
    
                // Check for upload error
                if ($_FILES['userfile']['error'] == 0) {
                    // If there's an existing file, delete it
                    if ($existing_file && file_exists('./themes/upload/evidence/' . $existing_file->evidence)) {
                        unlink('./themes/upload/evidence/' . $existing_file->evidence); // Delete old file
                    }
    
                    // Handle file upload
                    $upload = upload_file_new([
                        'nm_file'   => 'userfile',
                        'size'      => 10000000, // max file size 10 MB
                        'path'      => 'evidence',
                        'thumb'     => false,
                        'type'      => 'pdf|doc|docx|jpg|png', // Adjust file types as needed
                    ], true, $index);
    
                    // If upload successful, save the file name
                    if ($upload) {
                        $file_name = $upload['file_name'];  // Store uploaded file name
                    } else {
                        log_message('error', 'Upload failed: ' . $this->upload->display_errors());
                    }
                }
            } else {
                // If no file uploaded, keep the old file name
                $file_name = $existing_file ? $existing_file->evidence : null;
            }
    
            // Prepare data for insert or update
            $upd = array(
                'jenis'         => 0,
                'id_komposit'   => $id,
                'urut'          => $data['urut'][$index],
                'penjelasan'    => $data['penjelasan'][$index],
                'evidence'      => $file_name, // If file uploaded, use new file name, else use old file name
                'realisasi'     => $data['realisasi'][$index],
                'tw'            => $tw,
                'periode'       => $periode
            );
    
            // Check if the record exists for update
            $res = $this->db->where('id_komposit', $id)
                            ->where('urut', $data['urut'][$index])
                            ->where('tw', $tw)
                            ->where('jenis', 0)
                            ->where('periode', $periode)
                            ->get(_TBL_INDEXKOM_REALISASI)
                            ->result_array();
    
            if (count($res) > 0) {
                // If record exists, perform an update
                $upd['update_user'] = $this->authentication->get_Info_User('username');
                $whereDetail = [
                    'id' => $res[0]['id'],
                    'urut' => $res[0]['urut'],
                    'jenis' => 0,
                    'tw' => $tw,
                    'periode' => $periode
                ];
    
                // Update the record in the database
                $this->crud->crud_data([
                    'table' => _TBL_INDEXKOM_REALISASI,
                    'field' => $upd,
                    'where' => $whereDetail,
                    'type' => 'update'
                ]);
    
                // Store the updated record ID in result
                $result[] = $res[0]['id']; 
    
            } else {
                // If the record doesn't exist, perform an insert
                $upd['create_user'] = $this->authentication->get_Info_User('username');
                $inserted_id = $this->crud->crud_data([
                    'table' => _TBL_INDEXKOM_REALISASI,
                    'field' => $upd,
                    'type' => 'add'
                ]);
    
                // Store the newly inserted record ID in result
                $result[] = $inserted_id;
            }
        }
    
        return $result;
    }
    
    
    
    
    
    
}
