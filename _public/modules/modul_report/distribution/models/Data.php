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
            $this->db->where('bangga_analisis_risiko.bulan',$this->post['bulan']);
        
   
        // $rows=$this->db->select('residual_analisis_id, residual_analisis, count(residual_analisis_id) as jml')->group_by(['residual_analisis_id', 'residual_analisis'])->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
        // $rows=$this->db->select('target_impact, target_like, count(target_impact) as jml')->join(_TBL_VIEW_RCSA_DETAIL.'as b','a.id_detail = b.id','left')->group_by(['target_impact', 'target_like'])->get(_TBL_ANALISIS_RISIKO.'as a')->result_array();
       // Ambil data dari bangga_analisis_risiko dan bangga_view_rcsa_detail
        $rows = $this->db->select('bangga_analisis_risiko.id,
        bangga_analisis_risiko.bulan,
        bangga_analisis_risiko.target_impact, 
        bangga_analisis_risiko.target_like, 
        COUNT(bangga_analisis_risiko.target_impact) as jml, 
        bangga_view_rcsa_detail.id AS rcsa_detail_id,
        bangga_view_rcsa_detail.owner_no,
        bangga_view_rcsa_detail.periode_name')
        ->from('bangga_analisis_risiko')
        ->join('bangga_view_rcsa_detail', 'bangga_analisis_risiko.id_detail = bangga_view_rcsa_detail.id', 'left')
        ->group_by([
        'bangga_analisis_risiko.id',
        'bangga_analisis_risiko.bulan',
        'bangga_analisis_risiko.target_impact',
        'bangga_analisis_risiko.target_like',
        'bangga_view_rcsa_detail.id',
        'bangga_view_rcsa_detail.owner_no',
        'bangga_view_rcsa_detail.periode_name'
        ])
        ->get()
        ->result_array();

        $id = $this->db->select('level_risk_no')
        ->from(_TBL_LEVEL_COLOR)
        ->where('impact', $rows[0]['target_impact'])
        ->where('likelihood', $rows[0]['target_like'])
        ->get()
        ->result_array();

       

        foreach($master as $key=>$mr){

            foreach($rows as $row){
                if ($id[0]['level_risk_no']==$key){
                    $master[$key]['jml']=$row['jml'];
                }
            }
        }
        $result['master2']=$master;
        // doi::dump($result['master2']);
        return $result;
    }
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */