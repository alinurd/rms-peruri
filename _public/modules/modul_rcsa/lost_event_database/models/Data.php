<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

    public function __construct() {
        parent::__construct();
    }

    public function simpan_lost_event($data) {
        $upd = [
            'rcsa_detail_id'              => $data['id'],
            'bulan'                       => $data['month'],
            'identifikasi_kejadian'       => $data['identifikasi_kejadian'],
            'kategori'                    => $data['kategori'],
            'sumber_penyebab'             => $data['sumber_penyebab'],
            'penyebab_kejadian'           => $data['penyebab_kejadian'],
            'penanganan'                  => $data['penanganan'],
            'kat_risiko'                  => $data['kat_risiko'],
            'hub_kejadian_risk_event'     => $data['hub_kejadian_risk_event'],
            'status_asuransi'             => $data['status_asuransi'],
            'nilai_premi'                 => $data['nilai_premi'],
            'nilai_klaim'                 => $data['nilai_klaim'],
            'mitigasi_rencana'            => $data['mitigasi_rencana'],
            'mitigasi_realisasi'          => $data['mitigasi_realisasi'],
            'rencana_perbaikan_mendatang' => $data['rencana_perbaikan_mendatang'],
            'pihak_terkait'               => $data['pihak_terkait'],
            'penjelasan_kerugian'         => $data['penjelasan_kerugian'],
            'nilai_kerugian'              => $data['nilai_kerugian'],
            'kejadian_berulang'           => $data['kejadian_berulang'],
            'frekuensi_kejadian'          => $data['frekuensi_kejadian'],
            'skal_dampak_in'              => $data['skal_dampak_in'],
            'skal_prob_in'                => $data['skal_prob_in'],
            'target_res_dampak'           => $data['target_res_dampak'],
            'target_res_prob'             => $data['target_res_prob'],
        ];

        if ($data['type'] == "edit") {
            $upd['update_user'] = $this->authentication->get_info_user('username');
            $upd['update_date'] = date('Y-m-d H:i:s');

            // Mengatur kondisi untuk pembaruan
            $where = [
                'id' => $data['id_edit'],
                'bulan' => $data['month'],
            ];

            // Melakukan pembaruan di database
            return $this->crud->crud_data([
                'table' => _TBL_RCSA_LOST_EVENT,
                'field' => $upd,
                'where' => $where,
                'type' => 'update'
            ]);
        } else {
            $upd['create_user'] = $this->authentication->get_info_user('username');
            $upd['create_date'] = date('Y-m-d H:i:s');

            // Melakukan penambahan di database
            return $this->crud->crud_data([
                'table' => _TBL_RCSA_LOST_EVENT,
                'field' => $upd,
                'type' => 'add'
            ]);
        }
    }

    public function getDetail($data, $limit, $offset) {
        if ($data['owner']) {
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('owner_no', $this->owner_child);
        }

        if ($data['periode']) {
            $this->db->where('tahun', $data['periode']);
        }

        $this->db->where('sts_propose', 4)
                 ->limit($limit, $offset);

        return $this->db->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
    }

    public function count_all_data($data) {
        if ($data['owner']) {
            $this->get_owner_child($data['owner']);
            $this->owner_child[] = $data['owner'];
            $this->db->where_in('owner_no', $this->owner_child);
        }

        if ($data['periode']) {
            $this->db->where('tahun', $data['periode']);
        }

        $this->db->where('sts_propose', 4);

        return $this->db->count_all_results(_TBL_VIEW_RCSA_DETAIL);
    }

    public function getMonthlyMonitoringGlobal($q, $month) {
        // Ambil ID berdasarkan rcsa_detail_no
        $act = $this->db
            ->select('id')
            ->where('rcsa_detail_no', $q['id'])
            ->get('bangga_rcsa_action')
            ->row_array();

        // Ambil data untuk bulan tertentu
        $data['data'] = $this->db
            ->where('rcsa_action_no', $act['id'])
            ->where('bulan', $month)
            ->get('bangga_view_rcsa_action_detail')
            ->row_array();

        // Ambil periode_name dari detail
        $detail = $this->db
            ->select('periode_name')
            ->where('id', $q['id'])
            ->get(_TBL_VIEW_RCSA_DETAIL)
            ->row_array();

        // Cek apakah bulan ada dalam lost event
        $cek_ = $this->db
            ->select('bulan')
            ->where('rcsa_detail_id', $q['id'])
            ->where('bulan', $month)
            ->get(_TBL_RCSA_LOST_EVENT)
            ->row_array();

        // Mendapatkan bulan dan tahun sekarang
        $blnnow = date('m');
        $thnRcsa = substr($detail['periode_name'], 0, 4);
        $tgl = 1;

        // Membuat objek DateTime untuk periode RCSA
        $dateRcsa = new DateTime("$thnRcsa-$month-$tgl");
        $hariIni = new DateTime();

        // Cek apakah hari ini lebih besar atau sama dengan tanggal RCSA
        if ($hariIni >= $dateRcsa) {
            $data['before'] = $this->db
                ->where('rcsa_action_no', $act['id'])
                ->where('bulan', $month - 1)
                ->get('bangga_view_rcsa_action_detail')
                ->row_array();
        }

        $monthly = $data['data'];
        $monthbefore = $data['before'];
        $currentMonth = date('n');

        // Menentukan hasil berdasarkan kondisi
        if (!$monthbefore && $month != 1) {
            return '<center><i class="fa fa-times-circle text-danger"></i></center>';
        }

        if (!$monthly) {
            return '<center><i class="fa fa-times-circle text-warning" title="Progress Tretmen belum lengkap"></i></center>';
        }

        if ($cek_ && $cek_['bulan'] <= $currentMonth) {
            return '<center><i class="fa fa-check-circle text-success" title="Lost Event Sudah Diisi"></i></center>';
        }

        return !$cek_ 
            ? '<button class="propose pointer btn btn-light openModal" data-type="add" data-id="' . $q['id'] . '" data-month="' . $month . '"><i class="icon-pencil"></i></button>'
            : '<button class="propose pointer btn btn-light openModal" data-type="edit" data-id="' . $q['id'] . '" data-month="' . $month . '"><i class="icon-pencil text-success"></i></button>';
    }

    public function level_action($like, $impact) {
        return [
            'like' => $this->db->where('id', $like)->get('bangga_level')->row_array(),
            'impact' => $this->db->where('id', $impact)->get('bangga_level')->row_array()
        ];
    }
}
