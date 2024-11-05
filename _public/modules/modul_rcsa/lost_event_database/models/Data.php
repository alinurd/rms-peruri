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

        // Data preparation for insertion or update
        $upd = [
            'rcsa_no'                     => $data['rcsa_no'],
            'event_no'                     => $data['event_no'],
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
            'nilai_kerugian'              => str_replace(",", "",$data['nilai_kerugian']),
            'kejadian_berulang'           => $data['kejadian_berulang'],
            'frekuensi_kejadian'          => $data['frekuensi_kejadian'],
            'skal_dampak_in'              => $data['skal_dampak_in'],
            'skal_prob_in'                => $data['skal_prob_in'],
            'target_res_dampak'           => $data['target_res_dampak'],
            'target_res_prob'             => $data['target_res_prob'],
        ];

        if($data['nama_event'] != ""){

            $lib['description'] = $data['nama_event'];
            $lib['risk_type_no'] = 0;
            $lib['type'] = 1;
            $lib['code'] = $this->cari_code_library($data, 1);
            $lib['create_user'] = $this->authentication->get_info_user('username');

            $newId =  $this->crud->crud_data([
                'table' => _TBL_LIBRARY,
                'field' => $lib,
                'type' => 'add'
            ]);

            $upd['event_no'] = $newId;

        }

        // Determine whether to add or update data based on type
        if ($data['type'] == "edit") {
            $updxx = [
                'rcsa_no'                     => $data['rcsa_no'],
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
            // Update mode
            $updxx['update_user'] = $this->authentication->get_info_user('username');
            $updxx['update_date'] = date('Y-m-d H:i:s');
            $where = ['id' => $data['id_edit']];

            // Execute update
            return $this->crud->crud_data([
                'table' => _TBL_RCSA_LOST_EVENT,
                'field' => $updxx,
                'where' => $where,
                'type' => 'update'
            ]);
        } else {
            // Insert mode
            $upd['create_user'] = $this->authentication->get_info_user('username');
            $upd['create_date'] = date('Y-m-d H:i:s');

            // Execute insertion
            return $this->crud->crud_data([
                'table' => _TBL_RCSA_LOST_EVENT,
                'field' => $upd,
                'type' => 'add'
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
