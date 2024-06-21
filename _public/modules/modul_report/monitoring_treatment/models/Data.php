<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
    var $post = [];

	public function __construct()
    {
        parent::__construct();
	}

    function grafik (){
        $result=[];
        $rows=$this->db->order_by('urut')->get(_TBL_STATUS_ACTION)->result_array();
        $master=[];
        foreach($rows as $row){
            $master[$row['id']]=['name'=>$row['status_action'], 'color'=>$row['warna'], 'jml'=>0];
        }
        
        $this->owner_child=array();

		if ($this->post['owner_no']>0){
			$this->owner_child[]=$this->post['owner_no'];
		}

		$this->get_owner_child($this->post['owner_no']);
		$owner_child=$this->owner_child;

		if ($owner_child){
			$this->db->where_in('owner_no',$owner_child);
		}else{
			$this->db->where('owner_no',$this->post['owner_no']);
		}
		
		// if ($this->post['risk_context']){
		// 	$this->db->where_in('rcsa_no',$this->post['risk_context']);
  //       }
        // if ($this->post['owner_no']){
        //     $this->db->where('owner_no',$this->post['owner_no']);
        // }
         if ($this->post['periode_no']){
            $this->db->where('period_no',$this->post['periode_no']);
        }

        if ($this->post['bulan']){
			$this->db->where('bulan',$this->post['bulan']);
        }

        $rows=$this->db->select('status_no, status_action_detail, count(status_no) as jml')->group_by(['status_no', 'status_action_detail'])->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();

        foreach($master as $key=>$mr){
            foreach($rows as $row){
                if ($row['status_no']==$key){
                    $master[$key]['jml']=$row['jml'];
                }
            }
        }
        $result['master']=$master;
   

        // setelah progress
        $rows=$this->db->order_by('urut')->get(_TBL_STATUS_ACTION)->result_array();
        $master=[];
        
        foreach($rows as $row){
            $master[$row['id']]=['name'=>$row['status_action'], 'color'=>$row['warna'], 'jml'=>0];
        }
   
        
        $this->owner_child=array();

		if ($this->post['owner_no']>0){
			$this->owner_child[]=$this->post['owner_no'];
		}

		$this->get_owner_child($this->post['owner_no']);
		$owner_child=$this->owner_child;

		if ($owner_child){
			$this->db->where_in('owner_no',$owner_child);
		}else{
			$this->db->where('owner_no',$this->post['owner_no']);
		}
		
		// if ($this->post['risk_context']){
		// 	$this->db->where_in('rcsa_no',$this->post['risk_context']);
  //       }
        if ($this->post['owner_no']){
            $this->db->where('owner_no',$this->post['owner_no']);
        }
         if ($this->post['periode_no']){
            $this->db->where('period_no',$this->post['periode_no']);
        }
        if ($this->post['bulan']){
			$this->db->where('bulan',1);
        }
        
        $rows=$this->db->select('status_no, status_action_detail, count(status_no) as jml')->group_by(['status_no', 'status_action_detail'])->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();

        foreach($master as $key=>$mr){
            foreach($rows as $row){
                if ($row['status_no']==$key){
                    $master[$key]['jml']=$row['jml'];
                }
            }
        }
        $result['master2']=$master;

        return $result;
    }
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */