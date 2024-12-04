<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

    public function __construct() {
        parent::__construct();
    }

    // ==========================================
    // Method: getDetail
    // Description: Retrieves loss event details based on filter criteria
    // ==========================================
    public function getDetail($data, $limit, $offset) {
        // Filter by owner if provided
        if ($data['owner']) {
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('owner_no', $this->owner_child);
        }

        // Filter by year/period if provided
        if ($data['periode']) {
            $this->db->where('tahun', $data['periode']);
        }
        
        // Filter by assessment title if provided
        if ($data['judul_assesment']) {
            $this->db->where('rcsa_no', $data['judul_assesment']);
        }

        // Limit results and set offset for pagination
        $this->db->limit($limit, $offset);

        // Retrieve and return filtered results
        return $this->db->get(_TBL_VIEW_RCSA_LOST_EVENT)->result_array();
    }

    // ==========================================
    // Method: count_all_data
    // Description: Counts all data entries based on filter criteria
    // ==========================================
    public function count_all_data($data) {
        // Filter by owner if provided
        if ($data['owner']) {
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('owner_no', $this->owner_child);
        }

        // Filter by year/period if provided
        if ($data['periode']) {
            $this->db->where('tahun', $data['periode']);
        }

        // Filter by assessment title if provided
        if ($data['judul_assesment']) {
            $this->db->where('rcsa_no', $data['judul_assesment']);
        }

        // Return count of filtered results
        return $this->db->count_all_results(_TBL_VIEW_RCSA_LOST_EVENT);
    }

    // ==========================================
    // Method: simpan_lost_event
    // Description: Adds or updates a loss event entry
    // ==========================================
    public function simpan_lost_event($data) {
        // Prepare the data for insertion or update
        $upd = [
            'rcsa_no'                     => $data['rcsa_no_e'],
            'event_no'                    => $data['event_no'],
            'rcsa_detail_id'              => $data['id_detail'],
            'identifikasi_kejadian'       => $data['identifikasi_kejadian'],
            'kategori'                    => $data['kategori'],
            'sumber_penyebab'             => $data['sumber_penyebab'],
            'penyebab_kejadian'           => $data['penyebab_kejadian'],
            'penanganan'                  => $data['penanganan'],
            'kat_risiko'                  => $data['kat_risiko'],
            'hub_kejadian_risk_event'     => $data['hub_kejadian_risk_event'],
            'status_asuransi'             => $data['status_asuransi'],
            'nilai_premi'                 => str_replace(",", "", $data['nilai_premi']),
            'nilai_klaim'                 => str_replace(",", "", $data['nilai_klaim']),
            'mitigasi_rencana'            => $data['mitigasi_rencana'],
            'mitigasi_realisasi'          => $data['mitigasi_realisasi'],
            'rencana_perbaikan_mendatang' => $data['rencana_perbaikan_mendatang'],
            'pihak_terkait'               => $data['pihak_terkait'],
            'penjelasan_kerugian'         => $data['penjelasan_kerugian'],
            'nilai_kerugian'              => str_replace(",", "", $data['nilai_kerugian']),
            'kejadian_berulang'           => $data['kejadian_berulang'],
            'frekuensi_kejadian'          => $data['frekuensi_kejadian'],
            'skal_dampak_in'              => $data['skal_dampak_in'],
            'skal_prob_in'                => $data['skal_prob_in'],
            'target_res_dampak'           => $data['target_res_dampak'],
            'target_res_prob'             => $data['target_res_prob'],
        ];
    
        
    
        // If event name is provided, insert into the library table
        if (!empty($data['peristiwabaru'])) {
            $lib = [
                'description' => $data['peristiwabaru'],
                'risk_type_no' => 0,
                'type' => 1,
                'jenis_lib' => "new",
                'code' => $this->cari_code_library($data, 1),
                'create_user' => $this->authentication->get_info_user('username'),
            ];
    
            // Insert the event into the library table
            $newId = $this->crud->crud_data([
                'table' => _TBL_LIBRARY,
                'field' => $lib,
                'type' => 'add',
            ]);
    
            // Store the new event number in the update data
            $upd['event_no'] = $newId;
        }
    
        // Check if we are in "edit" mode
        if ($data['type'] == "edit") {
            $updxx = [
                'rcsa_no'                     => $data['rcsa_no_e'],
                'identifikasi_kejadian'       => $data['identifikasi_kejadian'],
                'kategori'                    => $data['kategori'],
                'sumber_penyebab'             => $data['sumber_penyebab'],
                'penyebab_kejadian'           => $data['penyebab_kejadian'],
                'penanganan'                  => $data['penanganan'],
                'kat_risiko'                  => $data['kat_risiko'],
                'hub_kejadian_risk_event'     => $data['hub_kejadian_risk_event'],
                'status_asuransi'             => $data['status_asuransi'],
                'nilai_premi'                 => str_replace(",", "", $data['nilai_premi']),
                'nilai_klaim'                 => str_replace(",", "", $data['nilai_klaim']),
                'mitigasi_rencana'            => $data['mitigasi_rencana'],
                'mitigasi_realisasi'          => $data['mitigasi_realisasi'],
                'rencana_perbaikan_mendatang' => $data['rencana_perbaikan_mendatang'],
                'pihak_terkait'               => $data['pihak_terkait'],
                'penjelasan_kerugian'         => $data['penjelasan_kerugian'],
                'nilai_kerugian'              => str_replace(",", "",$data['nilai_kerugian']),
                'kejadian_berulang'           => $data['kejadian_berulang'],
                'frekuensi_kejadian'          => $data['frekuensi_kejadian'],
                'skal_dampak_in'              => $data['skal_dampak_in'],
                'skal_prob_in'                => $data['skal_prob_in'],
                'target_res_dampak'           => $data['target_res_dampak'],
                'target_res_prob'             => $data['target_res_prob'],
            ];

            // doi::dump($upd);
            // If a new file is uploaded, handle the replacement of the old file
            if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == 0) {
                $file = $_FILES['file_upload'];
                $uploadDir = 'themes/upload/lost_events/'; // Directory to store uploaded _FILES
                // If an old file exists, delete it before uploading the new one
                if (!empty($data['file_upload_lama'])) {
                    $fileLama = $data['file_upload_lama'];
                    $oldFilePath = $uploadDir . $fileLama;
    
                    // Check if the old file exists and delete it
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
    
                $fileBaru = time() . '_' . basename($file['name']);
                $uploadFilePath = $uploadDir . $fileBaru;
    
                // Validate file type and size (same as above)
                if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                    // Update the file path in the update data
                    $updxx['file_path'] = $fileBaru;
                } else {
                    return 'File upload failed. Please try again.';
                }
            }
    
            // Update fields for the existing event
            $updxx['update_user'] = $this->authentication->get_info_user('username');
            $updxx['update_date'] = date('Y-m-d H:i:s');
            $where = ['id' => $data['id_edit']];
    
            // Execute the update
            return $this->crud->crud_data([
                'table' => _TBL_RCSA_LOST_EVENT,
                'field' => $updxx,
                'where' => $where,
                'type' => 'update',
            ]);
        } else {
            
            // Handle file upload only if a file is uploaded
            if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == 0) {
                
                // File upload processing
                $file = $_FILES['file_upload'];
                $uploadDir = 'themes/upload/lost_events/'; // Directory to store uploaded _FILES
                $fileName = time() . '_' . basename($file['name']); // Generate a unique file name
                $uploadFilePath = $uploadDir . $fileName;
        
                // Validate file type (only allow PDFs)
                $allowedTypes = ['application/pdf'];
                if (!in_array($file['type'], $allowedTypes)) {
                    return 'Invalid file type. Only PDF _FILES are allowed.';
                }
        
                // Validate file size (5MB max)
                if ($file['size'] > 5 * 1024 * 1024) { // 5MB limit
                    return 'File size exceeds the maximum limit of 5MB.';
                }
        
                // Move the uploaded file to the desired directory
                if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                    // Update the file path in the data array
                    $upd['file_path'] = $fileName;
                } else {
                    return 'File upload failed. Please try again.';
                }
            }

            // Insert new event if it's not in edit mode
            $upd['create_user'] = $this->authentication->get_info_user('username');
            $upd['create_date'] = date('Y-m-d H:i:s');
            doi::dump($upd);
            die;
            // Execute the insertion
            return $this->crud->crud_data([
                'table' => _TBL_RCSA_LOST_EVENT,
                'field' => $upd,
                'type' => 'add',
            ]);
        }
    }
    
    

    // ==========================================
    // Method: level_action
    // Description: Retrieves risk levels for 'like' and 'impact'
    // ==========================================
    public function level_action($like, $impact) {
        return [
            'like' => $this->db->where('id', $like)->get('bangga_level')->row_array(),
            'impact' => $this->db->where('id', $impact)->get('bangga_level')->row_array()
        ];
    }


    
}
