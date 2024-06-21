<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	var $arr_perda=array();
	var $arr_jml_perda=array();
	var $arr_jml_kota=array();
	var $arr_jml_monev=array();
	var $arr_jml_proses_monev=array();
	
	public function __construct()
    {
        parent::__construct();
		
	}
	
	public function get_faq(){
		$rows = $this->db
				->where('aktif',1)
				->get(_TBL_VIEW_FAQ)
				->result_array();
		
		$arrFaq=[];
		foreach($rows as $row){
			$arrFaq[$row['kelompok_no'].'#'.$row['kelompok']][] = $row;
		}
		return $arrFaq;
	}
	
	public function statistik()
	{
		$query = $this->db
				->select('id_pro, count(id) as jml')
				->from(_TBL_KABUPATEN)
				->where('aktif',1)
				->group_by('id_pro')
				->get();
		
		$rows = $query->result_array();
		$this->arr_jml_kota=array();
		foreach($rows as $row){
			$this->arr_jml_kota[$row['id_pro']]=$row['jml'];
		}
		
		$query = $this->db
				->select(_TBL_KABUPATEN.'.id_pro, count('._TBL_PROGRES.'.id) as jml, sum((case when '._TBL_PROGRES.'.perbub_no<>"" then 1 else 0 end)) as jmlPerbup , sum((case when '._TBL_PROGRES.'.tabg_no<>"" then 1 else 0 end)) as jmlTabg , sum('._TBL_PROGRES.'.slf_status) as jmlSlf, sum((case when '._TBL_PROGRES.'.tptp_no<>"" then 1 else 0 end)) as jmlTptpp, sum((case when '._TBL_PROGRES.'.aparat_terdata>0 then 1 else 0 end)) as jmlAparat')
				->from(_TBL_PROGRES)
				->join(_TBL_KABUPATEN, _TBL_PROGRES .'.id_kab='._TBL_KABUPATEN.'.id')
				->where(_TBL_PROGRES.'.id_sts',6)
				->group_by(_TBL_KABUPATEN.'.id_pro')
				->get();
		
		$rows = $query->result_array();
		$this->arr_jml_perda=array();
		foreach($rows as $row){
			$this->arr_jml_perda[$row['id_pro']]=$row;
		}
		
		$query = $this->db
				->select(_TBL_KABUPATEN.'.id_pro, count('._TBL_PROGRES.'.id) as jml')
				->from(_TBL_PROGRES)
				->join(_TBL_KABUPATEN, _TBL_PROGRES .'.id_kab='._TBL_KABUPATEN.'.id')
				->where(_TBL_PROGRES.'.aktif',1)
				->where(_TBL_PROGRES.'.sts_monev',2)
				->where(_TBL_PROGRES.'.id_sts',6)
				->group_by(_TBL_KABUPATEN.'.id_pro')
				->get();
		
		$rows = $query->result_array();
		$this->arr_jml_monev=array();
		foreach($rows as $row){
			$this->arr_jml_monev[$row['id_pro']]=$row['jml'];
		}
		
		$query = $this->db
				->select(_TBL_KABUPATEN.'.id_pro, count('._TBL_PROGRES.'.id) as jml')
				->from(_TBL_PROGRES)
				->join(_TBL_KABUPATEN, _TBL_PROGRES .'.id_kab='._TBL_KABUPATEN.'.id')
				->where(_TBL_PROGRES.'.aktif',1)
				->where(_TBL_PROGRES.'.sts_monev',1)
				->where(_TBL_PROGRES.'.id_sts',6)
				->group_by(_TBL_KABUPATEN.'.id_pro')
				->get();
		
		$rows = $query->result_array();
		$this->arr_jml_proses_monev=array();
		foreach($rows as $row){
			$this->arr_jml_proses_monev[$row['id_pro']]=$row['jml'];
		}
	}
	
	function get_rekap()
	{
		$hasil="select (select count(id) from "._TBL_PROPINSI." where aktif=1) as propinsi, (select count(id) from "._TBL_KABUPATEN." where aktif=1) as kota, (select count(id) from "._TBL_PROGRES." where aktif=1 and id_sts=6) as perda, (select count(id) from "._TBL_PROGRES." where sts_monev>=1) as monev";
		$sql=$this->db->query($hasil);
		$rows=$sql->result_array();
		return $rows[0];
	}
	
	function grafik($id=0){
		$this->db->select(_TBL_PROPINSI.'.id, propinsi,'._TBL_REGION.'.region');
		$this->db->from(_TBL_PROPINSI);
		$this->db->join(_TBL_REGION, _TBL_PROPINSI.'.wilayah_no='._TBL_REGION.'.id');
		$this->db->where(_TBL_PROPINSI.'.aktif',1);
		$this->db->order_by(_TBL_REGION.'.urut, '._TBL_PROPINSI.'.urut, '.'propinsi');
		if ($id>0){
			$this->db->where(_TBL_PROPINSI.'.id',$id);
		}
		$query = $this->db->get();
		
		$rows=$query->result_array();
		// Doi::dump($this->db->last_query());die();
		$category=array();
		$rekap=array('kota'=>0,'perda'=>0,'monev'=>0,'proses_monev'=>0);
		// Doi::dump($this->arr_jml_perda);
		// die();
		foreach($rows as &$row){
			$category[]=$row['propinsi'] . '  .';
			$jml=0;
			if (array_key_exists($row['id'], $this->arr_jml_kota))
				$jml=$this->arr_jml_kota[$row['id']];
			$data['kota'][]=array('y'=>intval($jml),'url'=>base_url('dashboard/detail/'.$row['id']));
			$row['kota']=$jml;
			$rekap['kota'] +=$jml;
			$jml=0;
			$jmlPerbup=0;
			$jmlTabg=0;
			$jmlSlf=0;
			$jmlTptpp=0;
			$jmlAparat=0;
			if (array_key_exists($row['id'], $this->arr_jml_perda)){
				$jml=$this->arr_jml_perda[$row['id']]['jml'];
				$jmlPerbup=$this->arr_jml_perda[$row['id']]['jmlPerbup'];
				$jmlTabg=$this->arr_jml_perda[$row['id']]['jmlTabg'];
				$jmlSlf=$this->arr_jml_perda[$row['id']]['jmlSlf'];
				$jmlTptpp=$this->arr_jml_perda[$row['id']]['jmlTptpp'];
				$jmlAparat=$this->arr_jml_perda[$row['id']]['jmlAparat'];
			}
			$data['perda'][]=array('y'=>intval($jml),'url'=>base_url('dashboard/detail/'.$row['id'].'/implementasi'));
			$data['perbup'][]=array('y'=>intval($jmlPerbup),'url'=>base_url('dashboard/detail/'.$row['id'].'/implementasi'));
			$data['tabg'][]=array('y'=>intval($jmlTabg),'url'=>base_url('dashboard/detail/'.$row['id'].'/implementasi'));
			$data['slf'][]=array('y'=>intval($jmlSlf),'url'=>base_url('dashboard/detail/'.$row['id'].'/implementasi'));
			$data['tptp'][]=array('y'=>intval($jmlTptpp),'url'=>base_url('dashboard/detail/'.$row['id'].'/implementasi'));
			$data['aparat'][]=array('y'=>intval($jmlAparat),'url'=>base_url('dashboard/detail/'.$row['id'].'/implementasi'));
			$row['perda']=$jml;
			$row['jmlPerbup']=$jmlPerbup;
			$row['jmlTabg']=$jmlTabg;
			$row['jmlSlf']=$jmlSlf;
			$row['jmlTptpp']=$jmlTptpp;
			$row['jmlAparat']=$jmlAparat;
			$rekap['perda'] +=$jml;
			$jml=0;
			if (array_key_exists($row['id'], $this->arr_jml_monev))
				$jml=$this->arr_jml_monev[$row['id']];
			$data['monev'][]=array('y'=>intval($jml),'url'=>base_url('dashboard/detail/'.$row['id']));
			$row['monev']=$jml;
			$rekap['monev'] +=$jml;
			$jml=0;
			if (array_key_exists($row['id'], $this->arr_jml_proses_monev))
				$jml=$this->arr_jml_proses_monev[$row['id']];
			$row['proses_monev']=$jml;
			$rekap['proses_monev'] +=$jml;
			$propinsi=$row['propinsi'];
		}
		unset($row);
		// Doi::dump($data);die();
		$result['table']=$rows;
		$result['table_rekap']=$rekap;
		$result['title']="'Grafik Statistik Monev Perda BG'";	
		$result['title_impl']="'Grafik Statistik Implementasi Perda BG'";	
		if ($id>0){
			$result['sub_title']="'Propinsi ".$propinsi."'";	
			$result['sub_title_impl']="'Propinsi ".$propinsi."'";	
		}else{
			$result['sub_title']="'Seluruh Indonesia'";	
			$result['sub_title_impl']="'Seluruh Indonesia'";	
		}
		$result['category']=json_encode($category);
		$result['data']=json_encode(array(array('name'=>'Kab/Kota','data'=>$data['kota']),array('name'=>'Perda','data'=>$data['perda']),array('name'=>'Monev','data'=>$data['monev'])));	
		
		$result['category_impl']=json_encode($category);
		$result['data_impl']=json_encode(array(array('name'=>'Kab/Kota','data'=>$data['kota']),array('name'=>'Perbup/Perwal','data'=>$data['perbup']),array('name'=>'TABG','data'=>$data['tabg']),array('name'=>'SLF','data'=>$data['slf']),array('name'=>'Pengkaji','data'=>$data['tptp']),array('name'=>'Pendataan BG','data'=>$data['aparat'])));	
		// Doi::dump($result);die();
		return $result;
	}
	
	function get_data_master(){
		$query=$this->db
				->select(_TBL_PROGRES.'.*,'._TBL_USERS.'.nama_lengkap')
				->from(_TBL_PROGRES)
				->join(_TBL_USERS, _TBL_PROGRES.'.user_no='._TBL_USERS.'.id','left')
				->where(_TBL_PROGRES.'.aktif',1)
				->get();
		$rows=$query->result_array();
		$this->arr_perda=array();
		foreach($rows as $row){
			$this->arr_perda[$row['id_kab']]=$row;
		}
		
		// $rows = $this->db->where('aktif',1)->where('id_sts',6)->get(_TBL_PROGRES)->result_array();
		// $this->arr_data_perda=array();
		// foreach($rows as $row){
			// $this->arr_data_perda[$row['id_kab']]=$row['id'];
		// }
	}
	
	function get_data_perda($id=0){
		$query=$this->db
				->select(_TBL_PROGRES.'.*,'._TBL_KABUPATEN.'.kota')
				->from(_TBL_PROGRES)
				->join(_TBL_KABUPATEN, _TBL_PROGRES.'.id_kab='._TBL_KABUPATEN.'.id')
				->where(_TBL_KABUPATEN.'.id_pro',$id)
				->order_by(_TBL_KABUPATEN.'.kota')
				->get();
		$rows=$query->result_array();
		foreach($rows as &$row){
			$row['rekap']=json_decode($row['rekap'], true);
		}
		unset($row);
		return $rows;
	}
	
	function get_data_pantau($id=0){
		
		$query=$this->db
				->select(_TBL_PEMANTAUAN.'.*,'._TBL_KABUPATEN.'.kota,'._TBL_STATUS_PANTAU.'.kode,'._TBL_STATUS_PANTAU.'.ket, (select count(x.id) from '._TBL_PEMANTAUAN_PHOTO.' as x where x.id_pantau='._TBL_PEMANTAUAN.'.id) as poto' )
				->from(_TBL_PEMANTAUAN)
				->join(_TBL_KABUPATEN, _TBL_PEMANTAUAN.'.id_kab='._TBL_KABUPATEN.'.id')
				->join(_TBL_STATUS_PANTAU, _TBL_PEMANTAUAN.'.status='._TBL_STATUS_PANTAU.'.id')
				->where(_TBL_KABUPATEN.'.id_pro',$id)
				->order_by(_TBL_KABUPATEN.'.kota')
				->get();
		$rows=$query->result_array();
		return $rows;
	}
	
	function get_data_kota($id){
		$query=$this->db
				->select('id, kota')
				->from(_TBL_KABUPATEN)
				->where('id_pro',$id)
				->where('aktif',1)
				->get();
		$rows=$query->result_array();
		foreach($rows as &$row){
			$row['perda']='<i class="fa fa-circle-o"> </i>';
			$row['sts_perda']=0;
			$row['sts_entry']=0;
			$row['sts_monev']=0;
			$row['petugas']='';
			$row['monev']='<span class="label label-danger"> Belum </span>';
			$row['icon']='';
			if (array_key_exists($row['id'], $this->arr_perda)){
				$offline='';
				if($this->arr_perda[$row['id']]['sts_entry']==0){
					$offline = '<i class="fa fa-cloud-upload"></a> ';
				}
				$row['sts_perda']=1;
				// Doi::dump($this->arr_perda[$row['id']]);
				if ($this->arr_perda[$row['id']]['id_sts']==6)
					$row['perda']='<i class="fa fa-check-circle"> </i> ';
				
				if (!empty($this->arr_perda[$row['id']]['file'])){
					$file = str_replace('(','',$this->arr_perda[$row['id']]['file']);
					$file = str_replace(')','',$file);
					$row['icon'] ='<a href="'.base_url('ajax/get-file/perda/'.$file).'"><i class="fa fa-file-pdf-o"> </i></a>';
				}
				
				if ($this->arr_perda[$row['id']]['id_sts']<>6){
					$row['monev']='<span class="label label-danger"> Belum </span>';
				}elseif ($this->arr_perda[$row['id']]['sts_monev']==1){
					$row['monev']=' <span class="label label-info">'.$offline.' Proses </span>';
					$row['icon'] .='&nbsp;&nbsp;<a href="'.base_url('dashboard/detail-monev/'.$this->arr_perda[$row['id']]['id']).'"><i class="fa fa-search"> </i></a>';
				}elseif ($this->arr_perda[$row['id']]['sts_monev']==2){
					$row['monev']=$offline . ' <span class="label label-success"> Selesai </span>';
					$row['icon'] .='&nbsp;&nbsp;<a href="'.base_url('dashboard/detail-monev/'.$this->arr_perda[$row['id']]['id']).'"><i class="fa fa-search"> </i></a>';
				}else{
					$row['monev']=' <span class="label label-danger"> Belum </span>';
				}
				
				$row['sts_monev']=$this->arr_perda[$row['id']]['sts_monev'];
				$row['petugas']=$this->arr_perda[$row['id']]['nama_lengkap'];
				$row['sts_entry']=$this->arr_perda[$row['id']]['sts_entry'];
			}
		}
		unset($row);
		return $rows;
	}
	
	function get_file_perbub($id, $type=0){
		$this->db->select(_TBL_PEMANTAUAN_PHOTO.'.*,'._TBL_STATUS_PANTAU.'.kode,'._TBL_STATUS_PANTAU.'.ket');
		$this->db->from(_TBL_PEMANTAUAN_PHOTO);
		$this->db->join(_TBL_STATUS_PANTAU, _TBL_PEMANTAUAN_PHOTO.'.status='._TBL_STATUS_PANTAU.'.id','left');
		$this->db->where(_TBL_PEMANTAUAN_PHOTO.'.id_pantau', $id);
		$this->db->order_by(_TBL_PEMANTAUAN_PHOTO.'.status');
		$this->db->order_by(_TBL_PEMANTAUAN_PHOTO.'.tanggal');
		$sql = $this->db->get();
		$rows=$sql->result_array();
		foreach($rows as &$row){
			$row['detail']=json_decode($row['att_file'], TRUE);
		}
		unset($row);
		return $rows;
	}
}

/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */