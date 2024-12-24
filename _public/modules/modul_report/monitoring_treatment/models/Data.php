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
        $this->db->where_in('owner_no', $owner_child);
    } else {
        $this->db->where('owner_no', $this->post['owner_no']);
    }

    // Filter berdasarkan periode dan bulan
    if (!empty($this->post['periode_no'])) {
        $this->db->where('period_no', $this->post['periode_no']);
    }

    // Query untuk kategori "Kurang", "Sama", "Lebih"
    $rows = $this->db->select(
        "b.bulan, 
        c.owner_no, 
        c.period_no, 
        CASE
            WHEN b.progress_detail < a.target_progress_detail AND  b.target_progress_detail < a.target_damp_loss THEN 'Kurang'
            WHEN  b.progress_detail = a.target_progress_detail AND  b.target_progress_detail =  a.target_damp_loss THEN 'Sama'
            WHEN b.progress_detail > a.target_progress_detail  AND b.target_progress_detail  > a.target_damp_loss THEN 'Lebih'
        END AS kategori, 
        COUNT(*) AS jml",
        false
    )
    ->from('bangga_rcsa_treatment a')
    ->join('bangga_rcsa_monitoring_treatment b', 'a.rcsa_detail_no = b.rcsa_detail AND a.bulan = b.bulan', 'inner') // Pastikan bulan sama
    ->join('bangga_view_rcsa_detail c', 'b.rcsa_detail = c.id', 'left')
    ->group_by([
        'b.bulan',
        'c.owner_no',
        'kategori',
        'a.target_progress_detail',
        'a.target_damp_loss',
        'b.progress_detail',
        'b.target_progress_detail',
        'c.period_no'
    ])
    ->order_by('b.bulan', 'ASC')
    ->get()
    ->result_array();


    // Daftar bulan dari Januari hingga Desember dengan key indeks 1-12
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

    // Proses hasil query
    $dataKategori = [];
    foreach ($rows as $row) {
        $bulanKey = $bulan[(int)$row['bulan']] ?? null;
        $kategori = $row['kategori'];
        $jml = $row['jml'];

        if (!isset($dataKategori[$kategori])) {
            $dataKategori[$kategori] = array_fill_keys(array_values($bulan), 0);
        }

        if ($bulanKey) {
            $dataKategori[$kategori][$bulanKey] = $jml;
        }
    }

    // Format hasil untuk master
    $result['master'] = $dataKategori;

    return $result;
}




}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */