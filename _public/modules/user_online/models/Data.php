<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
		ini_set('max_execution_time', 0); 
	}
	
	function get_data_alert($param=array()){
		$arr_labels=array();
		
		$thn=_TAHUN_;
		$minggu=_MINGGU_;
		$minggu2=_MINGGU_;
		$ket="Propinsi";
		if (array_key_exists('cboPuskesmas', $param)){
			if (!empty($param['cboTahun']))
				$thn=$param['cboTahun'];
			if (!empty($param['cboMinggu']))
				$minggu=$param['cboMinggu'];
			if (!empty($param['cboMinggu2']))
				$minggu2=$param['cboMinggu2'];
			
			$this->db->where('minggu >= ',$minggu)->where('minggu <= ',$minggu2)->where('tahun',$thn);
			if (!empty($param['cboStsRumor']))
				$this->db->where('sts_verifikasi',$param['cboStsRumor']);
			
			if (!empty($param['cboPenyakit']))
				$this->db->where('id_penyakit',$param['id_penyakit']);
			
			if (!empty($param['cboPuskesmas'])){
				$rows = $this->db->select('puskesmas as nama, count(kota) as jml')->where('id_place',$param['cboPuskesmas'])->where('sts_verifikasi',1)->group_by('puskesmas')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
				$ket="Puskesmas";
				$rows_tbl = $this->db->where('id_place',$param['cboPuskesmas'])->get(_TBL_VIEW_ALERT_GROUP)->result_array();
				$ket="Puskesmas";
			}elseif (!empty($param['cboDistrik'])){
				$rows = $this->db->select('puskesmas as nama, count(puskesmas) as jml')->where('id_distrik',$param['cboDistrik'])->where('sts_verifikasi',1)->group_by('puskesmas')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
				$rows_tbl = $this->db->where('id_distrik',$param['cboDistrik'])->where('minggu',$minggu)->where('tahun',$thn)->get(_TBL_VIEW_ALERT_GROUP)->result_array();
				$ket="Kecamatan";
			}elseif (!empty($param['cboKota'])){
				$rows = $this->db->select('puskesmas as nama, count(puskesmas) as jml')->where('id_kota',$param['cboKota'])->where('sts_verifikasi',1)->group_by('puskesmas')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
				$rows_tbl = $this->db->where('id_kota',$param['cboKota'])->where('minggu',$minggu)->where('tahun',$thn)->get(_TBL_VIEW_ALERT_GROUP)->result_array();
				$ket="Kota";
			}elseif (!empty($param['cboPropinsi'])){
				$rows = $this->db->select('kota as nama, count(kota) as jml')->where('id_prop',$param['cboPropinsi'])->where('sts_verifikasi',1)->group_by('kota')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
				$rows_tbl = $this->db->where('id_prop',$param['cboPropinsi'])->where('minggu',$minggu)->where('tahun',$thn)->get(_TBL_VIEW_ALERT_GROUP)->result_array();
				$ket="Propinsi";
			}else{
				$rows = $this->db->select('kd_propinsi as nama, count(kd_propinsi) as jml')->group_by('kd_propinsi')->get(_TBL_VIEW_ALERT_GROUP)->where('sts_verifikasi',1)->result_array();
				$rows_tbl = $this->db->where('minggu',$minggu)->where('tahun',$thn)->get(_TBL_VIEW_ALERT_GROUP)->result_array();
			}
		}else{
			$this->db->where('minggu',$minggu)->where('tahun',$thn);
			$rows = $this->db->select('kd_propinsi as nama, count(kd_propinsi) as jml')->where('sts_verifikasi',1)->group_by('kd_propinsi')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
			$rows_tbl = $this->db->where('minggu',$minggu)->where('tahun',$thn)->get(_TBL_VIEW_ALERT_GROUP)->result_array();
		}
		
		
		$verif=array();
		foreach($rows as $row){
			$verif[$row['nama']] = $row['jml'];
		}
		
		if (array_key_exists('cboPuskesmas', $param)){
			if (!empty($param['cboTahun']))
				$thn=$param['cboTahun'];
			if (!empty($param['cboMinggu']))
				$minggu=$param['cboMinggu'];
			if (!empty($param['cboMinggu2']))
				$minggu2=$param['cboMinggu2'];
			if (!empty($param['cboPenyakit']))
				$this->db->where('id_penyakit',$param['id_penyakit']);
			
			$this->db->where('minggu >=',$minggu)->where('minggu <=',$minggu2)->where('tahun',$thn);
			if (!empty($param['cboPenyakit']))
				$this->db->where('id_penyakit',$param['id_penyakit']);
			if (!empty($param['cboPuskesmas']))
				$rows = $this->db->select('puskesmas as nama, count(kota) as jml')->where('id_place',$param['cboPuskesmas'])->group_by('puskesmas')->order_by('puskesmas')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
			elseif (!empty($param['cboDistrik']))
				$rows = $this->db->select('puskesmas as nama, count(puskesmas) as jml')->where('id_distrik',$param['cboDistrik'])->group_by('puskesmas')->order_by('puskesmas')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
			elseif (!empty($param['cboKota']))
				$rows = $this->db->select('puskesmas as nama, count(puskesmas) as jml')->where('id_kota',$param['cboKota'])->group_by('puskesmas')->order_by('puskesmas')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
			elseif (!empty($param['cboPropinsi']))
				$rows = $this->db->select('kota as nama, count(kota) as jml')->where('id_prop',$param['cboPropinsi'])->group_by('kota')->order_by('kota')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
			else
				$rows = $this->db->select('kd_propinsi as nama, count(kd_propinsi) as jml')->group_by('kd_propinsi')->order_by('kd_propinsi')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
		}else{
			$this->db->where('minggu',$minggu)->where('tahun',$thn);
			$rows = $this->db->select('kd_propinsi as nama, count(kd_propinsi) as jml')->order_by('kd_propinsi')->group_by('kd_propinsi')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
		}
		
		$hasil['title'] = "Peringatan Dini Puskesmas Menurut ".$ket." Tahun ".$thn." Minggu ".$minggu." sampai ".$minggu2;
		
		$data_sudah =array(); 
		$data_verif =array(); 
		$rekap =array(); 
		$nilMak=0;
		foreach($rows as $row){
			$sudah=0;
			if (array_key_exists($row['nama'], $verif)){
				$sudah=$verif[$row['nama']];
				$data_verif[]=$sudah;
			}else{
				$data_verif[]=0;
			}
			$data_sudah[] = $row['jml']-$sudah; 
			$arr_labels[]=$row['nama'];			
			$rekap[]=array('data'=>$row['nama'], 'alert'=>$row['jml'], 'verif'=>$sudah, 'belum'=>$row['jml']-$sudah);
			if (intval($row['jml'])>$nilMak){
				$nilMak=intval($row['jml']);
			}	
		}
		
		$chartData = array(
					'labels'=>$arr_labels,
					'datasets'=>array(array('label'=>'Belum diverifikasi','backgroundColor'=>'#DD4B39','data'=>$data_sudah), array('label'=>'Sudah diverifikasi','backgroundColor'=>'#3C8DBC','data'=>$data_verif)));
					
		$hasil['data'] = $chartData;
		$hasil['info-table'] = $rekap;
		$hasil['info-table-detail'] = $rows_tbl;
		$hasil['nil-mak'] = $nilMak + 20;
		return $hasil;
	}
	
	function get_data_personal_alert($id){
		$rows = $this->db->where('id',$id)->get(_TBL_VIEW_ALERT)->row();
		if ($rows)
			return (array) $rows;
		else
			return array();
	}
	
	function get_lokasi_alert($kel="puskesmas",$id=0){
		if ($kel=="puskesmas"){
			$rows = $this->db->where('tahun',_TAHUN_)->where('minggu',_MINGGU_)->get(_TBL_VIEW_ALERT)->result_array();
		}elseif ($kel=="rs"){
			$rows = $this->db->where('tahun',_TAHUN_)->where('minggu',_MINGGU_)->get(_TBL_VIEW_ALERT)->result_array();
			
		}elseif ($kel=="lab"){
			$rows = $this->db->where('tahun',_TAHUN_)->where('minggu',_MINGGU_)->get(_TBL_VIEW_ALERT)->result_array();
			
		}elseif ($kel=="ebs"){
			if ($id==0)
				$rows = $this->db->where("tahun",_TAHUN_)->where("sts_klb_ebs",112)->order_by('tgl_laporan','desc')->get(_TBL_VIEW_ALERT_EBS)->result_array();
			else
				$rows = $this->db->where("tahun",_TAHUN_)->where("sts_rumor_no",93)->order_by('tgl_laporan','desc')->get(_TBL_VIEW_ALERT_EBS)->result_array();
		}
		
		
		
		return $rows;
	}
	
	function simpan_verifikasi($data){
		$upd['sts_verifikasi']=$data['sts_verifikasi'];
		$upd['note']=$data['note'];
		$upd['tgl_verif']=date('Y-m-d', strtotime($data['tgl_verif']));
		$upd['petugas']=_USER_NAME_COMPLETE_;
		$upd['jml_kematian']=$data['jml_kematian'];
		$upd['temuan']=$data['temuan'];
		$upd['klb']=$data['sts_klb'];
		$upd['respon24']=$data['sts_respon'];
		$upd['update_date']=Doi::now();
		$upd['update_user']=_USER_NAME_;
		
		$result=$this->crud->crud_data(array('table'=>_TBL_LAP_ALERT, 'field'=>$upd,'type'=>'update', 'where'=>array('id'=>$data['id_edit'])));
	}
}

/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */