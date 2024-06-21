<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
    var $post = [];

	public function __construct()
    {
        parent::__construct();
	}

    function grafik (){
        $result=[];
        $rows=$this->db->where('kelompok','kel-library')->order_by('urut')->get(_TBL_DATA_COMBO)->result_array();
        $master=[];
        foreach($rows as $row){
            $master[$row['id']]=['name'=>$row['data'], 'jml'=>0];
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
		
		if ($this->post['periode_no']){
			$this->db->where_in('period_no',$this->post['periode_no']);
        }
        
        $rows=$this->db->select('kategori_no, kategori, count(kategori_no) as jml')->where('owner_no',$this->post['owner_no'])->group_by(['kategori_no', 'kategori'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

        foreach($master as $key=>$mr){
            foreach($rows as $row){
                if ($row['kategori_no']==$key){
                    $master[$key]['jml']=$row['jml'];
                  
                }
            }
        }
        $result['master']=$master;

        // setelah progress
        $rows=$this->db->where('kelompok','kel-library')->order_by('urut')->get(_TBL_DATA_COMBO)->result_array();
        $master=[];
        foreach($rows as $row){
            $master[$row['id']]=['name'=>$row['data'], 'jml'=>0];
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
		
		if ($this->post['periode_no']){
			$this->db->where_in('period_no',$this->post['periode_no']);
        }
        
        $rows=$this->db->select('kategori_no, kategori, count(kategori_no) as jml')->group_by(['kategori_no', 'kategori'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

        foreach($master as $key=>$mr){
            foreach($rows as $row){
                if ($row['kategori_no']==$key){
                    $master[$key]['jml']=$row['jml'];
                }
            }
        }
        $result['master2']=$master;
        // var_dump($result);
        // die();
        return $result;
    }
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */