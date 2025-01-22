<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
    var $post = [];

	public function __construct()
    {
        parent::__construct();
	}

//     function grafik (){
//         $result=[];
//         $rows=$this->db->order_by('urut')->get(_TBL_STATUS_ACTION)->result_array();
//         $master=[];
//         foreach($rows as $row){
//             $master[$row['id']]=['name'=>$row['status_action'], 'color'=>$row['warna'], 'jml'=>0];
//         }
        
//         $this->owner_child=array();

// 		if ($this->post['owner_no']>0){
// 			$this->owner_child[]=$this->post['owner_no'];
// 		}

// 		$this->get_owner_child($this->post['owner_no']);
// 		$owner_child=$this->owner_child;

// 		if ($owner_child){
// 			$this->db->where_in('owner_no',$owner_child);
// 		}else{
// 			$this->db->where('owner_no',$this->post['owner_no']);
// 		}

//          if ($this->post['periode_no']){
//             $this->db->where('period_no',$this->post['periode_no']);
//         }

//         if ($this->post['bulan']){
// 			$this->db->where('bulan',$this->post['bulan']);
//         }

//         $rows=$this->db->select('status_no, status_action_detail, count(status_no) as jml')->group_by(['status_no', 'status_action_detail'])->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();

//         foreach($master as $key=>$mr){
//             foreach($rows as $row){
//                 if ($row['status_no']==$key){
//                     $master[$key]['jml']=$row['jml'];
//                 }
//             }
//         }
//         $result['master']=$master;
   

//         // setelah progress
//         $rows=$this->db->order_by('urut')->get(_TBL_STATUS_ACTION)->result_array();
//         $master=[];
        
//         foreach($rows as $row){
//             $master[$row['id']]=['name'=>$row['status_action'], 'color'=>$row['warna'], 'jml'=>0];
//         }
   
        
//         $this->owner_child=array();

// 		if ($this->post['owner_no']>0){
// 			$this->owner_child[]=$this->post['owner_no'];
// 		}

// 		$this->get_owner_child($this->post['owner_no']);
// 		$owner_child=$this->owner_child;

// 		if ($owner_child){
// 			$this->db->where_in('owner_no',$owner_child);
// 		}else{
// 			$this->db->where('owner_no',$this->post['owner_no']);
// 		}
		
// 		// if ($this->post['risk_context']){
// 		// 	$this->db->where_in('rcsa_no',$this->post['risk_context']);
//   //       }
//         if ($this->post['owner_no']){
//             $this->db->where('owner_no',$this->post['owner_no']);
//         }
//          if ($this->post['periode_no']){
//             $this->db->where('period_no',$this->post['periode_no']);
//         }
//         if ($this->post['bulan']){
// 			$this->db->where('bulan',1);
//         }
        
//         $rows=$this->db->select('status_no, status_action_detail, count(status_no) as jml')->group_by(['status_no', 'status_action_detail'])->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();

//         foreach($master as $key=>$mr){
//             foreach($rows as $row){
//                 if ($row['status_no']==$key){
//                     $master[$key]['jml']=$row['jml'];
//                 }
//             }
//         }
//         $result['master2']=$master;

//         return $result;
//     }

function grafik() {
    $result = [];

    // Dapatkan owner_child berdasarkan owner_no
    $this->owner_child = [];
    if ($this->post['owner_no'] > 0) {
        $this->owner_child[] = $this->post['owner_no'];
    }

    $this->get_owner_child($this->post['owner_no']);
    $owner_child = $this->owner_child;

    // Filter berdasarkan owner_no
    if ($owner_child) {
        $this->db->where_in('c.owner_no', $owner_child);
    } else {
        $this->db->where('c.owner_no', $this->post['owner_no']);
    }

    // Filter berdasarkan periode dan bulan
    if (!empty($this->post['periode_no'])) {
        $this->db->where('c.period_no', $this->post['periode_no']);
    }

    $rows = $this->db
        ->select("
            a.bulan, 
            c.owner_no, 
            c.period_no,
            CASE
                WHEN (a.progress_detail < b.target_progress_detail) 
                     OR (a.progress_detail = b.target_progress_detail AND a.target_progress_detail < b.target_damp_loss) THEN 'Kurang'
                WHEN a.progress_detail = b.target_progress_detail AND a.target_progress_detail = b.target_damp_loss THEN 'Sama'
                WHEN (a.progress_detail > b.target_progress_detail) 
                     OR (a.progress_detail = b.target_progress_detail AND a.target_progress_detail > b.target_damp_loss) THEN 'Lebih'
                ELSE 'Tidak Diketahui'
            END AS kategori, 
            1 AS jml", false) // Setiap baris dianggap sebagai jumlah 1
        ->from('bangga_rcsa_monitoring_treatment a')
        ->join(
            'bangga_rcsa_treatment b', 
            'a.rcsa_action_no = b.id_rcsa_action AND a.bulan = b.bulan', 
            'left'
        )
        ->join(
            'bangga_view_rcsa_detail c', 
            'b.rcsa_detail_no = c.id', 
            'left'
        )
        ->order_by('a.bulan', 'ASC')
        ->get()
        ->result_array();

    // Daftar bulan dari Januari hingga Desember
    $bulan = [
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'May',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Aug',
        9 => 'Sep',
        10 => 'Oct',
        11 => 'Nov',
        12 => 'Dec'
    ];

    // Inisialisasi default untuk setiap kategori
    $dataKategori = [
        'Kurang' => array_fill_keys(array_values($bulan), 0),
        'Sama' => array_fill_keys(array_values($bulan), 0),
        'Lebih' => array_fill_keys(array_values($bulan), 0),
    ];

    // Proses hasil query
    foreach ($rows as $row) {
        $bulanKey = $bulan[(int)$row['bulan']] ?? null;
        $kategori = $row['kategori'];
        $jml = (int)$row['jml'];

        // Tambahkan jumlah berdasarkan bulan
        if ($bulanKey && isset($dataKategori[$kategori])) {
            $dataKategori[$kategori][$bulanKey] += $jml;
        }
    }

    // Format hasil untuk master
    $result['master'] = $dataKategori;
    return $result;
}





}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */