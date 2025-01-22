<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
    var $post = [];

	public function __construct()
    {
        parent::__construct();
	}

    function grafik (){
        $result=[];
        $rows=$this->db->order_by('urut')->get(_TBL_LEVEL_MAPPING)->result_array();
        $master=[];
        foreach($rows as $row){
            $master[$row['id']]=['name'=>$row['level_mapping'], 'color'=>$row['color'], 'jml'=>0];
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
		
		if ($this->post['periode_no'] > 0){
			$this->db->where_in('period_no',$this->post['periode_no']);
        }

        $rows=$this->db->select('inherent_analisis_id, inherent_analisis, count(inherent_analisis_id) as jml')->group_by(['inherent_analisis_id', 'inherent_analisis'])->get(_TBL_VIEW_RCSA_DETAIL)->result_array();

        foreach($master as $key=>$mr){
            foreach($rows as $row){
                if ($row['inherent_analisis_id']==$key){
                    $master[$key]['jml']=$row['jml'];
                }
            }
        }
        $result['master']=$master;

        // setelah progress
        $rows=$this->db->order_by('urut')->get(_TBL_LEVEL_MAPPING)->result_array();
        $master=[];
        foreach($rows as $row){
            $master[$row['id']]=['name'=>$row['level_mapping'], 'color'=>$row['color'], 'jml'=>0];
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
			$this->db->where('bangga_view_rcsa_detail.owner_no',$this->post['owner_no']);
		}
		
		if ($this->post['tahun'] > 0)
			$this->db->where('bangga_view_rcsa_detail.periode_name',$this->post['tahun']);
        
        if ($this->post['bulan'] > 0)
            $this->db->where('bangga_rcsa_action_detail.bulan',$this->post['bulan']);
        

            $this->db->select('
            bangga_rcsa_action_detail.id,
            bangga_rcsa_action_detail.bulan,
            bangga_rcsa_action_detail.residual_impact_action, 
            bangga_rcsa_action_detail.residual_likelihood_action, 
            bangga_view_rcsa_detail.id AS rcsa_detail_id,
            bangga_view_rcsa_detail.owner_no,
            bangga_view_rcsa_detail.periode_name,
            bangga_level_color.level_risk_no,
            COUNT(bangga_rcsa_action_detail.id) AS jml
        ');
        $this->db->from('bangga_rcsa_action_detail');
        $this->db->join('bangga_view_rcsa_detail', 'bangga_rcsa_action_detail.rcsa_detail = bangga_view_rcsa_detail.id', 'left');
        $this->db->join('bangga_level_color', 'bangga_rcsa_action_detail.residual_impact_action = bangga_level_color.impact AND bangga_rcsa_action_detail.residual_likelihood_action = bangga_level_color.likelihood', 'left');
        $this->db->group_by('
            bangga_rcsa_action_detail.id,  
            bangga_rcsa_action_detail.bulan,
            bangga_rcsa_action_detail.residual_impact_action, 
            bangga_rcsa_action_detail.residual_likelihood_action, 
            bangga_view_rcsa_detail.id, 
            bangga_view_rcsa_detail.owner_no, 
            bangga_view_rcsa_detail.periode_name,
            bangga_level_color.level_risk_no
        ');
        
        // Mendapatkan hasil
        $rows = $this->db->get()->result_array();



        
        foreach($master as $key=>$mr){
            foreach($rows as $index=>$row){
                if ($rows[$index]['level_risk_no']==$key){
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