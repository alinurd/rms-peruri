<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Rcsa extends BackendController
{
	var $table 		= "";
	var $post 		= array();
	var $sts_cetak 	= false;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('text');

		$this->load->model('Data'); //membuat load model data
		$this->nil_tipe					= 1;
		$this->set_Tbl_Master(_TBL_VIEW_RCSA);
		$this->cbo_periode 			= $this->get_combo('periode');
		$this->cbo_parent 			= $this->get_combo('parent-input');
		$this->cbo_parent_all 	= $this->get_combo('parent-input-all');
		$this->cbo_type 				= $this->get_combo('type-project');
		$this->cbo_bulan 				= $this->get_combo('bulan');

		$this->set_Open_Tab('General Information');
		$this->addField(array('field' => 'id', 'type' => 'int', 'show' => false, 'size' => 4));
		$this->addField(array('field' => 'judul_assesment', 'size' => 100, 'search' => false));
		$this->addField(array('field' => 'owner_no', 'input' => 'combo:search', 'combo' => $this->cbo_parent, 'size' => 100, 'required' => true, 'search' => true));
		$this->addField(array('field' => 'officer_no', 'show' => false, 'save' => true, 'default' => $this->authentication->get_info_user('identifier')));
		$this->addField(array('field' => 'create_user', 'search' => false, 'default' => $this->authentication->get_info_user('username')));
		$this->addField(array('field' => 'period_no', 'input' => 'combo', 'combo' => $this->cbo_periode, 'size' => 15, 'search' => true, 'required' => true));
		$this->addField(array('field' => 'anggaran_rkap', 'type' => 'float', 'input' => 'float', 'required' => true));
		$this->addField(array('field' => 'owner_pic', 'size' => 100, 'search' => false));
		$this->addField(array('field' => 'anggota_pic', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'tugas_pic', 'input' => 'multitext:sms', 'size' => 10000));
		$this->addField(array('field' => 'tupoksi', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'sasaran', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->addField(array('field' => 'tahun_rcsa', 'show' => false));
		$this->addField(array('field' => 'bulan_rcsa', 'show' => false));

		$this->addField(array('field' => 'item_use', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
		$this->addField(array('field' => 'register', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
		$this->addField(array('field' => 'pi', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
		$this->addField(array('field' => 'progres', 'input' => 'free', 'type' => 'free', 'show' => false, 'size' => 15));
		$this->addField(array('field' => 'name', 'show' => false));
		$this->addField(array('field' => 'periode_name', 'show' => false));
		$this->addField(array('field' => 'sts_propose_text', 'show' => false));
		$this->addField(array('field' => 'sts_propose', 'show' => false));
		$this->set_Close_Tab();

		$this->set_Open_Tab('Isu Internal');
		$this->addField(array('field' => 'man', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'method', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'machine', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'money', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'material', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'market', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'stakeholder_internal', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->set_Close_Tab();

		$this->set_Open_Tab('Isu External');
		$this->addField(array('field' => 'politics', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'economics', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'social', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'tecnology', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'environment', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'legal', 'input' => 'multitext', 'size' => 10000));
		$this->addField(array('field' => 'stakeholder_external', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->set_Close_Tab();

		$this->set_Open_Tab('Dokumen Lainnnya');
		$this->addField(array('field' => 'nm_file', 'input' => 'upload', 'path' => 'regulasix', 'file_type' => 'pdf', 'file_random' => false));
		$this->set_Close_Tab();

		$this->set_Open_Tab('Kriteria Kemungkinan Risiko ');
		$this->addField(array('field' => 'kriteria_kemungkinan_risiko', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->set_Close_Tab();

		$this->set_Open_Tab('Kriteria Dampak Risiko ');
		$this->addField(array('field' => 'kriteria_dampak_risiko', 'type' => 'free', 'input' => 'free', 'mode' => 'e'));
		$this->set_Close_Tab();

		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk' => $this->tbl_master));

		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'anggaran_rkap', 'span_right_addon' => ' Rp ', 'align' => 'right'));
		$this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'create_user', 'readonly' => true));

		$this->set_Sort_Table($this->tbl_master, 'name', 'ASC');
		$this->set_Table_List($this->tbl_master, 'judul_assesment', lang('msg_field_title'), 10);
		$this->set_Table_List($this->tbl_master, 'name', lang('msg_field_owner'), 20);
		$this->set_Table_List($this->tbl_master, 'man', lang('msg_field_jml_sasaran'), 5, 'center');
		$this->set_Table_List($this->tbl_master, 'tupoksi', lang('msg_field_jml_peristiwa'), 5, 'center');
		$this->set_Table_List($this->tbl_master, 'periode_name', lang('msg_field_periode'), 5, 'center');
		$this->set_Table_List($this->tbl_master, 'status', lang('msg_field_progress'), 5, 'center');
		$this->set_Table_List($this->tbl_master, 'sts_propose_text', lang('msg_field_status'), 0, 'center');
		$this->set_Table_List($this->tbl_master, 'id', lang('msg_field_register'), 5, 'center');

		$this->_CHECK_PRIVILEGE_OWNER($this->tbl_master, 'owner_no');
		$this->_CHANGE_TABLE_MASTER(_TBL_RCSA);
		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('edit', false);

		$this->set_Close_Setting();
	}

	public function MASTER_DATA_LIST($arrId, $rows)
	{
		$this->use_list = $this->data->cari_total_dipakai($arrId);
	}
	
	// MOD LIST TABLE PERIODE
	function listBox_PERIODE_NAMEx($rows, $value)
	{
		$value .= '<br/>' . $this->cbo_bulan[$rows['l_bulan_rcsa']] . ' - ' . $rows['l_tahun_rcsa'];
		return $value;
	}

	// MOD LIST TABLE JUMLAH SASARAN
	function listBox_MAN($rows, $value)
	{
		$id 	= $rows['l_id'];
		$jml 	= '';
		if (array_key_exists($id, $this->use_list['sasaran'])) {
			$jml = $this->use_list['sasaran'][$id];
		}

		return $jml;
	}

	// MOD LIST TABLE JUMLAH PERISTIWA
	function listBox_TUPOKSI($rows, $value)
	{
		$id 		= $rows['l_id'];
		$jml 		= '';
		if (array_key_exists($id, $this->use_list['peristiwa'])) {
			$jml 	= $this->use_list['peristiwa'][$id];
		}

		return $jml;
	}

	// MOD LIST TABLE STATUS
	function listBox_STS_PROPOSE_TEXT($row, $value, $res_nilai)
	{
		$nilai 	= intval($row['l_sts_propose']);
		$id 		= $row['l_id'];
		$owner 	= $row['l_owner_no'];
		$jml 		= '';
		if (array_key_exists($id, $this->use_list['peristiwa'])) {
			$jml = $this->use_list['peristiwa'][$id];
		}
		if (empty($jml)) {
			$hasil = '';
		} else {
			switch ($nilai) {
				case 1:
					$hasil = '<span class="label label-info"> ' . $value . ' </span>';
					break;
				case 2:
					$hasil = '<span class="label label-success"> ' . $value . ' </span>';
					break;
				case 3:
					$hasil = '<span class="label label-warning"> ' . $value . ' </span>';
					break;
				case 4:
					$hasil = '<span class="label label-primary"> ' . $value . ' </span>';
					break;
				case 5:
					$hasil = '<i class="label label-danger fa fa-sticky-note showRevisi pointer" data-id="' . $id . '"data-owner="' . $owner . '" aria-hidden="true" title="lihat catatan revisi"> ' . $value . '</i>';
					break;
					default:
					$hasil = '<span class="label label-danger"> ' . $value . ' </span>';
 					break;
			}
		}
		
		return $hasil;
	}

	// MOD FIELD TABLE RISK REGISTER 
	function listBox_ID($row, $value)
	{
		$id 		= $row['l_id'];
		$owner 	= $row['l_owner_no'];
		$result = '<i class="fa fa-search showRegister pointer" data-id="' . $id . '" data-owner="' . $owner . '">  </i>';
		return $result;
	}
	
	// MOD FIELD TABLE STATUS
	function listBox_STATUS($rows, $value)
	{
		$id 	= $rows['l_id'];
		$jml 	= '';
		if (array_key_exists($id, $this->use_list['peristiwa'])) {
			$jml = $this->use_list['peristiwa'][$id];
		}

		$dt 			= $this->db->select('pi, rcsa_no')->where('rcsa_no', $id)	->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$dtkri 		= $this->db->where('rcsa_no', $id)->where('iskri', 1)->where('pi ', 6)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$jmldtkr 	= count($dtkri);
		foreach($dtkri as $ii){
			$actkri[] = $this->db->where('id', $ii['kri'])->get('bangga_data_combo')->row_array();
		}
		$jmlactkri	= count($actkri);
		$ttlkr			= $jmldtkr- $jmlactkri;

		if($dtkri){
			$jml 		= $jml-$ttlkr;
		}

		$dt 					= $this->db->select('pi, rcsa_no')->where('rcsa_no', $id)->get(_TBL_VIEW_RCSA_DETAIL)->result_array();
		$groupedData 	= array();
		$totals 			= array(); // Array untuk melacak total nilai berdasarkan 'rcsa_no'

		foreach ($dt as $datax) {
			$rcsa_no = $datax['rcsa_no'];

			// Mengassign nilai-nilai berdasarkan kondisi 'pi'
			if ($datax['pi'] == 1) {
				$bg 		= 'danger';
				$nilai 	= '25';
				$inf 		= 'risk identity';
			} elseif ($datax['pi'] == 2) {
				$bg 		= 'warning';
				$nilai 	= '30';
				$inf 		= 'risk analysis';
			} elseif ($datax['pi'] == 3) {
				$bg 		= 'primary';
				$nilai 	= '55';
				$inf 		= 'risk evaluation';
			} elseif ($datax['pi'] == 4) {
				$bg 		= 'info';
				$nilai 	= '75';
				$inf 		= 'risk treatment';
			} elseif($datax['pi'] >= 5) {

				$bg 		= 'success';
				$nilai 	= '100';
				$inf 		= 'progress treatment';
			}

			// Menjumlahkan nilai berdasarkan 'rcsa_no'
			if (isset($totals[$rcsa_no])) {
				$totals[$rcsa_no] += (int)$nilai;
			} else {
				$totals[$rcsa_no] = (int)$nilai;
			}
		}

		// Menampilkan total nilai berdasarkan 'rcsa_no'
		$res_nilai=0;
		$res_text = 'danger';
		$iskri 		= 'hide';
		$cl 			= " #6c757d";
		$tl 			= "data kri belum ada";
		foreach ($totals as $rcsa_no => $total_nilai) {
			// doi::dump($jml);
 			$res_nilai = round($total_nilai / $jml);
			if ($res_nilai<35) {
				$res_bg		= 'danger';
				$res_text = '';
  			}	
			elseif ($res_nilai<55) {
				$res_bg 	= 'waring';
				$res_text = '';

			} elseif ($res_nilai < 65) {
			$res_bg 	= 'primary';
			$res_text = '';

			} elseif ($res_nilai < 85) {
				$res_bg 	= 'info';
				$res_text = '';

			} elseif ($res_nilai < 99) {
				$res_bg 	= 'info';
				$res_text = '';
				

			} elseif ($res_nilai > 100) {
				$res_bg 	= 'success';
				$res_text = '';
				$iskri 		= '';
				$res_nilai=99; 
			}
			else{
				$res_bg = 'success';
			}
			$kirim 		= "nilai: " . $res_nilai . " id: " . $rcsa_no;

		}

		if (
			$rows['l_sts_propose'] == 2 || $rows['l_sts_propose'] == 3
		) {
			$result = '
    	<div class="progress">
        <div class="progress-bar bg-' . $res_bg . '" role="progressbar" style="width: ' . $res_nilai . '%" aria-valuenow="' . $res_nilai . '" aria-valuemin="0" aria-valuemax="100">
            ' . $res_nilai . '% 
        </div> 
    	</div>';
		}

		elseif ($res_nilai == 100 && $rows['l_sts_propose'] < 4) {
			$submiter= $this->authentication->get_info_user('group');
			if($submiter['group']['id']!=45 && $submiter['group']['id']!=1){

				$result = '<span class="label label-warning"> Need Submiter </span>';
			}else{
				$result = '<a href="' . base_url('rcsa/propose/' . $rows['l_id']) . '"><span class="label label-danger"> Submit  Risk </span> 
				 <span clas=" '.$iskri. '  " style="font-weight: bold; font-size: 25px; color: '. $cl.'; " title="'. $tl.'">
            	<i class="fa fa-key ' . $iskri . '"></i>
            </span></a> ';

			}
					}
		elseif ($rows['l_sts_propose']==4){
			$result = '
    	<div class="progress">
        <div class="progress-bar bg-' . $res_bg . '" role="progressbar" style="width: ' . $res_nilai . '%" aria-valuenow="' . $res_nilai . '" aria-valuemin="0" aria-valuemax="100">
            ' . $res_nilai . '%   
        </div>
    	</div> <span clas=" ' . $iskri . '  " style="font-weight: bold; font-size: 25px; color: ' . $cl . '; " title="' . $tl . '">
            	<i class="fa fa-key ' . $iskri . '"></i>
            </span>';
		}
		else{
			$result = '
			 
    	<div class="progress">
        <div class="progress-bar text-' . $res_text . ' bg-' . $res_bg . '" role="progressbar" style="width: ' . $res_nilai . '%" aria-valuenow="' . $res_nilai . '" aria-valuemin="0" aria-valuemax="100">
            ' . $res_nilai . '%      
        </div> 
    	</div>
		    <span clas=" '.$iskri. '  " style="font-weight: bold; font-size: 25px; color: '. $cl.'; " title="'. $tl.'">
            	<i class="fa fa-key ' . $iskri . '"></i>
            </span>
		';
		}
		return $result;
	}

	// MOD FIELD ACTION TABLE
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows)
	{
		$tombol['print'] 	= [];
		$id 							= $rows['l_id'];
		$owner 						= $rows['l_owner_no'];
		$url 							= base_url($this->modul_name . '/risk-event/' . $owner);
		$tombol['detail'] = array("default" => true, "url" => $url, "label" => lang('msg_action_table'));
		$tombol['edit'] 	= ['default' => false, 'url' => base_url($this->_Snippets_['modul'] . '/edit'), 'label' => 'Edit'];	
		
		if (array_key_exists($id, $this->use_list)) {
			if ($this->use_list[$id]['jml'] > 0)
				$tombol['delete'] = [];
		}
		return $tombol;
	}

	// FUNTION RISK EVENT
	function risk_event()
	{
		$owner 					= intval($this->uri->segment(3));
		$id 						= intval($this->uri->segment(4));
		$data['parent'] = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] 	= $this->data->get_peristiwa($id);
		$data['list'] 	= $this->load->view('list-peristiwa', $data, true);
		$this->template->build('risk-event', $data);
	}

	// FUNCTION TAMBAH PERISTIWA RISK REGISTER
	function tambah_peristiwa()
	{
		$mode 						= $this->uri->segment(3);
		$id_rcsa 					= $this->uri->segment(5);
		$id_edit 					= $this->input->post('edit');

		if ($mode !== 'add') {
			$id_edit 				= $this->uri->segment(4);
		}

		$data['krii'] 		= $this->get_combo('data-combo', 'kri');
		$data['per_data'] = [0 => '-select-', 1 => 'Bulan', 2 => 'Triwulan', 3 => 'semester'];
		$data['area'] 		= $this->get_combo('parent-input');
		$data['rcsa_no']	= $id_rcsa;
		$data['np'] 			= $this->get_combo('negatif_poisitf');
		$data['parent'] 	= $this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->row_array();
		$rows 						= $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_RCSA_SASARAN)->result_array();
		$data['sasaran'] 	= [0=>lang('msg_cbo_select')];

		foreach ($rows as $row) {
			$data['sasaran'][$row['id']] = $row['sasaran'];
		}

		$rows_bisnis 						= $this->db->where('rcsa_no',$id_rcsa)->get(_TBL_RCM)->result_array();
		$data['proses_bisnis'] 	= [0=>lang('msg_cbo_select')];

		foreach ($rows_bisnis as $rb) {
			$data['proses_bisnis'][$rb['id']] = $rb['bussines_process'];
		}

		$couse 		= [];
		$impact 	= [];
		$detail 	= [];
		$sub 			= [];
		$event 		= [];
		$rcsa_det = [];
		if ($id_edit > 0) {
			
			$detail 	= $this->db->where('id', $id_edit)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
			$rcsa_det = $this->db->where('id', $id_edit)->get(_TBL_RCSA_DETAIL)->row_array();

			if ($detail["sts_propose"] == 4) {
				$disabled = 'disabled';
				$readonly = 'readonly="true"';
			}
			
			if ($detail) {
				$couse 									= json_decode($detail['risk_couse_no'], true);
				$couse_implode 					= implode(", ", $couse);
				$data['risk_couseno1'] 	= $couse_implode;
				$impect 								= json_decode($detail['risk_impact_no'], true);
				$impect_implode 				= implode(", ", $impect);
				$data['risk_impectno1'] = $impect_implode;
				$impact									= json_decode($detail['risk_impact_no'], true);
				$impact_implode 				= implode(", ", $impact);
				$peristiwa 							= $this->db->where('id', $detail['event_no'])->where('status', 1)->order_by('description')->get(_TBL_LIBRARY)->result_array();
				$dtkri 									= $this->db->where('id', $detail['kri'])->get(_TBL_DATA_COMBO)->result_array();
			}


			$tblkri = '<table class="table peristiwa" id="tblkri"><tbody>';
			if ($peristiwa) :
				foreach ($dtkri as $key => $crs) :
					$tambah = '';
					$del 		= '';
					if ($key == 0) {
						$tambah = '  | <i class="fa fa-plus add-kri text-danger pointer"></i>';
						$del 		= 'del-event ';
					}
					$tblkri .= '<tr class="browse-kri"><td style="padding-left:0px;">' . form_textarea('kri[]', $crs['data'], " readonly='readonly'  id='kri' maxlength='500' size=500 class='form-control' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_input(['kri_no[]' => $id_rcsa]) . '</td><td class="text-center" width="10%"><i class="fa fa-search browse-kri text-primary pointer"></i>  </td></tr>';
				endforeach;
			else :
				$tblkri .= '<tr class="browse-kri"><td style="padding-left:0px;">' . form_textarea('kri[]', '', " readonly='readonly'  id='kri' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_input(['kri_no[]' => 0]) . '</td><td class="text-center"  width="10%"><i class="fa fa-search browse-event text-primary pointer"></i> </td></tr>';
			endif;
			$tblkri .= '</tbody></table>';


			$data['krii'] 				= $this->get_combo('data-combo', 'kri');
			$data['per_data'] 		= [0 => '-select-', 1 => 'Bulan', 2 => 'Triwulan', 3 => 'semester'];
			$data['satuan'] 			= $this->get_combo('data-combo', 'satuan');
			$data['area'] 				= $this->get_combo('parent-input');
			$data['rcsa_no'] 			= $id_rcsa;
			$data['events'] 			= $event;
			$data['np'] 					= $this->get_combo('negatif_poisitf');
			$data['detail'] 			= $detail;
			$data['tblkri'] 			= $tblkri;
			$data['id_edit']			= $id_edit;
			$arrControl 					= json_decode($data['detail']['control_no'], true);
			//analisis
			$cboLike 								= $this->get_combo('likelihood');
			$cboImpact 							= $this->get_combo('impact'); 
			$data['cboTreatment'] 	= $this->get_combo('treatment');
			$data['cboTreatment1'] 	= $this->get_combo('treatment1');
			$data['cboTreatment2'] 	= $this->get_combo('treatment2');
			$data['cboRiskControl'] = $this->get_combo('data-combo', 'control-assesment');
			$inherent_level 				= $this->data->get_master_level(true, $data['detail']['inherent_level']);
			$residual_level 				= $this->data->get_master_level(true, $data['detail']['residual_level']);

			if (!$inherent_level) {
				$inherent_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
			}
			$a = $inherent_level['level_mapping'];

			if (!$residual_level) {
				$residual_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
			}

			$arl = $residual_level['level_mapping'];
			$data['inherent_level']= $inherent_level;
			$data['residual_level']= $residual_level;
			$check = '';
			
		}
		$check .= '<div>' . form_textarea("note_control", ($data['detail']) ? $data['detail']['note_control'] : '', ' class="form-control" style="width:100%;height:150px"' . $readonly) . '</div><br/>';

		
		$action 									= $this->db->where('rcsa_detail_no', $id_edit)->get(_TBL_RCSA_ACTION)->row_array();
		$data["rcsa_det"] 				= $rcsa_det;
		$data['field'] 						= $action;
		$data['id_edit_mitigasi'] = $action['id'];
		$data['cbo_owner'] 				= $this->get_combo('parent-input-all');
		$data['list_mitigasi'] 		= $this->load->view('input_mitigasi', $data, true);
		$data['list_mitigasi'] 		= $this->load->view('input_mitigasi', $data, true);
		$data['area']							= $this->get_combo('parent-input');
		$bulan 										= 2;
	

		$data['realisasi'] 				= $this->data->get_realisasi($id_edit);
		$data['list_realisasi'] 	= $this->load->view('list-realisasi', $data, true);
		$data['inptkri'] 					= $this->load->view('kri', $data, true);
		$data['cboper'] 					= [0=>lang('msg_cbo_select')];
		$data['kategori'] 				= [0=>lang('msg_cbo_select')];
		$data['subkategori'] 			= [0=>lang('msg_cbo_select')];
		$data['tema'] 						= $this->get_combo('library_t1');
		$cbogroup 								= [0=>lang('msg_cbo_select')];
		$cbogroup1 								= [0=>lang('msg_cbo_select')];

		if($detail['sub_kategori']){
			$data['cboper']					= $this->get_combo('tasktonimi', 't4', $detail['sub_kategori']);
		}

		if($detail['tema']){
			$data['kategori'] 			= $this->get_combo('tasktonimi', 't2', $detail['tema']);
		}

		
		if($detail['kategori_no']){
			$data['subkategori'] 		= $this->get_combo('tasktonimi', 't3', $detail['kategori_no']);
		}

		if($detail['event_no']){
 			$cbogroup = $this->get_combo('tasktonimi',['t5', 'cause', $detail['event_no']] );
			$cbogroup1 = $this->get_combo('tasktonimi',['t5', 'impact', $detail['event_no']] );
		}

		$data['satuan'] 		= $this->get_combo('data-combo', 'satuan');
		$data['cbogroup']  	= $cbogroup;
		$data['inp_couse'] 	= form_input('', '', ' id="new_cause[]" name="new_cause[]" class="form-control" placeholder="Input Risk Cause Baru"');
		$data['lib_couse'] 	= form_dropdown('risk_couse_no[]', $cbogroup, '', 'class="form-control select2" id="risk_couseno');
 		$data['cbogroup1'] 	= $cbogroup1;
		$data['inp_impact'] = form_input('', '', ' id="new_impact[]" name="new_impact[]" class="form-control" placeholder="Input Risk Impact Baru"');
		$data['cbbii'] 			= form_dropdown('new_impact_no[]', $cbogroup1, '', 'class="form-control select2"');
		$data['cboLike']		= $cboLike;
		$data['cboImpact']	= $cboImpact;
		$data['analisiData'] = $this->db->where('id', $id_edit)->get("bangga_view_rcsa_detail")->row_array();
		$data['rcsa_action'] 	= $this->db->where('rcsa_detail_no', $id_edit)->get("bangga_rcsa_action")->result_array();
		$this->template->build('fom_peristiwa', $data);
	}


	public function updateBox_KRITERIA_KEMUNGKINAN_RISIKO($field)
	{
		$id = $this->uri->segment(3); 
		$content = $this->get_kriteria_kemungkinan_risiko($id);
		return $content;
	}

	function updateBox_KRITERIA_DAMPAK_RISIKO($field)
	{
		$id = $this->uri->segment(3);
		$content = $this->get_kriteria_dampak_risiko($id);
		return $content;
	}

	function insertBox_KRITERIA_KEMUNGKINAN_RISIKO($field)
	{
		$content = $this->get_kriteria_kemungkinan_risiko();
		return $content;
	}

	function get_kriteria_kemungkinan_risiko($id = 0)
	{
		// Ambil data kriteria dari database
		$kriteriaData = $this->db->where('category', 'likelihood')->get(_TBL_LEVEL)->result_array();

		// Definisi warna default berdasarkan level
		$defaultColors = [
			1 => 'green',
			2 => 'lightgreen',
			3 => 'yellow',
			4 => 'orange',
			5 => 'red'
		];

		// Tambahkan warna ke data kriteria berdasarkan level
		$data['kriteria'] = [];
		foreach ($kriteriaData as $item) {
			$level = (int)$item['code']; // Pastikan level berupa integer
			$data['kriteria'][$level] = [
				'name' => $item['level'], // Nama diambil dari database
				'color' => $defaultColors[$level] ?? 'gray' // Warna berdasarkan defaultColors
			];
		}

		// Query untuk mengambil data kemungkinan berdasarkan kelompok dan param1
		$data['kemungkinan'] = $this->db
			->where('kelompok', 'kriteria-kemungkinan')
			->where('param1', $id)  // Menambahkan kondisi untuk field param1
			->get(_TBL_DATA_COMBO)
			->result_array();

		// Jika data `kemungkinan` kosong, ambil data dengan `param1` kosong
		if (empty($data['kemungkinan'])) {
			$data['kemungkinan'] = $this->db
				->where('kelompok', 'kriteria-kemungkinan')
				->where('param1', NULL)  // Menambahkan kondisi untuk field param1 kosong
				->or_where('param1', '') // Jika kosong bisa berupa NULL atau string kosong
				->get(_TBL_DATA_COMBO)
				->result_array();
		}

		// Menampilkan data pada view
		$result = $this->load->view('krit_kemungkinan', $data, true);
		return $result;
	}

	function insertBox_KRITERIA_DAMPAK_RISIKO($field)
	{
		$content = $this->get_kriteria_dampak_risiko();
		return $content;
	}

	function get_kriteria_dampak_risiko($id = 0)
	{
		// Ambil data kriteria dari database
		$kriteriaData = $this->db->where('category', 'impact')->get(_TBL_LEVEL)->result_array();

		// Definisi warna default berdasarkan level
		$defaultColors = [
			1 => 'green',
			2 => 'lightgreen',
			3 => 'yellow',
			4 => 'orange',
			5 => 'red'
		];

		// Tambahkan warna ke data kriteria berdasarkan level
		$data['kriteria'] = [];
		foreach ($kriteriaData as $item) {
			$level = (int)$item['code']; // Pastikan level berupa integer
			$data['kriteria'][$level] = [
				'name' => $item['level'], // Nama diambil dari database
				'color' => $defaultColors[$level] ?? 'gray' // Warna berdasarkan defaultColors
			];
		}

			// Query untuk mengambil data dampak berdasarkan kelompok dan param1
			$data['dampak'] = $this->db
			->where('kelompok', 'kriteria-dampak')
			->where('param1', $id)  // Menambahkan kondisi untuk field param1
			->get(_TBL_DATA_COMBO)
			->result_array();

			// Jika data `dampak` kosong, ambil data dengan `param1` kosong
			if (empty($data['dampak'])) {
			$data['dampak'] = $this->db
				->where('kelompok', 'kriteria-dampak')
				->group_start()               // Memulai grouping kondisi untuk NULL atau string kosong
					->where('param1', NULL)
					->or_where('param1', '')  // Jika kosong bisa berupa NULL atau string kosong
				->group_end()                 // Mengakhiri grouping kondisi
				->get(_TBL_DATA_COMBO)
				->result_array();
			}


			$result = $this->load->view('krit_dampak',  $data, true);
			return $result;
	}

	function update_OPTIONAL_CMD($id, $row)
	{
		$owner = $row['l_owner_no'];
		$result[] = array('posisi' => 'right', 'content' => '<a class="btn btn-warning btn-flat" style="width:100%;" data-content="Detail Risk Register" data-toggle="popover" href="' . base_url($this->modul_name . '/risk-event/' . $owner . '/' . $id) . '" data-original-title="" title=""><strong style="text-shadow: 1px 2px #020202;">START<br/>Risk Register</strong></a>');
		return $result;
	}
	
	

	function propose()
	{
		$id = $this->uri->segment(3);
		$data = $this->data->get_data_risk_register_propose($id);
		// doi::dump($data);
		$data['cbo_owner'] = $this->get_combo('parent');
		$data['cbo_user'] = $this->get_combo('officer_approve');

		$data['id_rcsa'] = $id;
		$this->template->build('register', $data); 
	}

	function simpan_propose()
	{
		$id_rcsa = $this->input->post('id_rcsa');
		$id_urgency = $this->input->post('data');
		$note = $this->input->post('note');
		$approve_user = $this->input->post('approve_user');

		$data['table'] = 'rcsa';
		$data['type'] = 'update';
		$data['field']['sts_propose'] = 2;
		$data['field']['date_propose'] = date('Y-m-d');
		$data['field']['user_approve'] = $this->authentication->get_Info_User("identifier");
		$data['field']['target_user'] = $approve_user;
		$data['where'] = array('id' => $id_rcsa);

		$this->crud->crud_data($data);
		$this->db->insert('log_propose', ['rcsa_no' => $id_rcsa, 'note' => $note, 'petugas_no' => $this->authentication->get_Info_User("identifier"), 'keterangan' => 'Propose to Kadiv', 'create_user' => $this->authentication->get_Info_User('username')]);

		header('location:' . base_url('rcsa'));
	}

	

	function listBox_PROGRESx($rows, $value)
	{

		$id = $rows['l_id'];
		$jml = '';
		if (array_key_exists($id, $this->use_list['peristiwa'])) {
			$jml = $this->use_list['peristiwa'][$id];
		}

		$dt = $this->db->select('pi, rcsa_no')
			->where('rcsa_no', $id)
			->get(_TBL_VIEW_RCSA_DETAIL)
			->result_array();
		$groupedData = array();

		foreach ($dt as $datax) {
			$rcsa_no = $datax['rcsa_no'];

			// Mengassign nilai-nilai berdasarkan kondisi pi
			if ($datax['pi'] == 1) {
				$bg = 'danger';
				$nilai = '25';
				$inf = 'risk identity';
			} elseif ($datax['pi'] == 2) {
				$bg = 'warning';
				$nilai = '30';
				$inf = 'risk analysis';
			} elseif ($datax['pi'] == 3) {
				$bg = 'primary';
				$nilai = '55';
				$inf = 'risk evaluation';
			} elseif ($datax['pi'] == 4) {
				$bg = 'info';
				$nilai = '75';
				$inf = 'risk treatment';
			} elseif ($datax['pi'] == 5) {
				$bg = 'success';
				$nilai = '100';
				$inf = 'progress treatment';
			}

			// Membuat entri baru dalam array groupedData jika rcsa_no belum ada sebagai kunci
			if (!isset($groupedData[$rcsa_no])) {
				$groupedData[$rcsa_no] = array();
			}

			// Menambahkan data saat ini ke entri rcsa_no yang sesuai
			$groupedData[$rcsa_no][] = array(
				'bg' => $bg,
				'nilai' => $nilai,
				'inf' => $inf
			);
		}

		// Array groupedData sekarang berisi data yang dikelompokkan berdasarkan rcsa_no
		foreach ($groupedData as $rcsa_no => $data) {
			echo "rcsa_no: " . $rcsa_no . "<br>";
			echo "Data:<br>";
			foreach ($data as $item) {
				echo "  bg: " . $item['bg'] . ", nilai: " . $item['nilai'] . ", inf: " . $item['inf'] . "<br>";
			}
			doi::dump($item['nilai']);
			echo "<br>";
		}



		$result = '
    	<div class="progress">
        <div class="progress-bar bg-' . $bg . '" role="progressbar" style="width: ' . $nilai . '%" aria-valuenow="' . $nilai . '" aria-valuemin="0" aria-valuemax="100">
            ' . $nilai . '% | jumlah peritiwa' . $jml . '
        </div>
    	</div>';

		return $result;
	}

	function insertBox_SASARAN($field)
	{
		$content = $this->get_sasaran();
		return $content;
	}

	function updateBox_SASARAN($field, $row, $value)
	{
		$content = $this->get_sasaran();
		return $content;
	}

	function get_sasaran($id = 0)
	{
		$id = $this->uri->segment(3);
		$data['field'] = $this->db->where('rcsa_no', $id)->get(_TBL_RCSA_SASARAN)->result_array();
		$result = $this->load->view('sasaran', $data, true);
		return $result;
	}

	function insertBox_STAKEHOLDER_INTERNAL($field)
	{
		$content = $this->get_stakeholder(1);
		return $content;
	}

	function updateBox_STAKEHOLDER_INTERNAL($field, $row, $value)
	{
		$content = $this->get_stakeholder(1);
		return $content;
	}

	function insertBox_STAKEHOLDER_EXTERNAL($field)
	{
		$content = $this->get_stakeholder(2);
		return $content;
	}

	function updateBox_STAKEHOLDER_EXTERNAL($field, $row, $value)
	{
		$content = $this->get_stakeholder(2);
		return $content;
	}
	function insertBox_KRITERIA_PROBABILITAS($field)
	{
		$content = $this->get_kriteria(1);
		return $content;
	}

	function updateBox_KRITERIA_PROBABILITAS($field, $row, $value)
	{
		$content = $this->get_kriteria(1);
		return $content;
	}
	function insertBox_KRITERIA_DAMPAK($field)
	{
		$content = $this->get_kriteria(2);
		return $content;
	}

	function updateBox_KRITERIA_DAMPAK($field, $row, $value)
	{
		$content = $this->get_kriteria(2);
		return $content;
	}

	function get_kriteria($type1 = 1, $id = 0)
	{
		$id = $this->uri->segment(3);
		$data['field'] = $this->db->where('kriteria_type', $type1)->where('rcsa_no', $id)->get(_TBL_RCSA_KRITERIA)->result_array();
		$data['type1'] = $type1;
		$result = $this->load->view('kriteria', $data, true);
		return $result;
	}

	function get_stakeholder($type = 1, $id = 0)
	{
		$id = $this->uri->segment(3);
		$data['field'] = $this->db->where('stakeholder_type', $type)->where('rcsa_no', $id)->get(_TBL_RCSA_STAKEHOLDER)->result_array();
		$data['type'] = $type;
		$result = $this->load->view('stakeholder', $data, true);
		return $result;
	}

	function POST_INSERT_PROCESSOR($id, $new_data)
	{
		$result = $this->data->save_detail($id, $new_data, 'new');
		return $result;
	}

	function POST_UPDATE_PROCESSOR($id, $new_data, $old_data)
	{
		$result = $this->data->save_detail($id, $new_data, 'edit', $old_data);
		return $result;
	}

	

	
	// function tambah_peristiwa_()
	// {
	// 	$owner = intval($this->uri->segment(3));
	// 	$id = intval($this->uri->segment(4));
	// 	$data['parent'] = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA)->row_array();
	// 	$data['field'] = $this->data->get_peristiwa($id);
		
	// 	$this->template->build('fom_peristiwa', $data);
	// }

	
	function update_sts_heatmap(){
		$id   	= $this->input->post('id');
		$status = $this->input->post('status');
		$norut = $this->input->post('norut');
		// Validasi ID dan status
        if (is_numeric($id) && ($status == 0 || $status == 1)) {

			$result = $this->data->save_status($id, $status, $norut);
            // Memanggil model untuk mengupdate status
            if ($result) {
                echo "Data berhasil di Update!";
            } else {
                echo "Data gagal di Update";
            }
        } else {
            echo "Data tidak valid!";
        }
	}
	function add_peristiwa()
	{
		$id_rcsa = $this->input->post('id');
		$id_edit = $this->input->post('edit');
		$rows = $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_RCSA_SASARAN)->result_array();
		$data['sasaran'] = ['- select -'];
		foreach ($rows as $row) {
			$data['sasaran'][$row['id']] = $row['sasaran'];
		}

		$couse = [];
		$impact = [];
		$detail = [];
		$sub = [];
		$event = [];
		if ($id_edit > 0) {

			$detail = $this->db->where('id', $id_edit)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
			if ($detail) {
				// doi::dump($detail);
				$couse = json_decode($detail['risk_couse_no'], true);
				$couse_implode = implode(", ", $couse);

				$impact = json_decode($detail['risk_impact_no'], true);
				$impact_implode = implode(", ", $impact);

				$peristiwa = $this->db->where('id', $detail['event_no'])->where('status', 1)->order_by('description')->get(_TBL_LIBRARY)->result_array();
				$dtkri = $this->db->where('id', $detail['kri'])->get(_TBL_DATA_COMBO)->result_array();
				if ($couse)
					$couse = $this->db->query("SELECT *
					FROM bangga_library
					WHERE id IN ($couse_implode)
					ORDER BY FIELD(id,	$couse_implode)")->result_array(); //$this->db->where_in('id', $couse)->get(_TBL_LIBRARY)->result_array();


				if ($impact)
					$impact = $this->db->query("SELECT *
					FROM bangga_library
					WHERE id IN ($impact_implode)
					ORDER BY FIELD(id,	$impact_implode)")->result_array(); //$this->db->where_in('id', $impact)->get(_TBL_LIBRARY)->result_array();
			}
			$sql = $this->db
				->select('*')
				->from(_TBL_RISK_TYPE)
				->where('kelompok', intval($detail['kategori_no']))
				->where('id > ', 0)
				->get()
				->result_array();
			foreach ($sql as $q) {
				$sub[$q['id']] = $q['type'];
			}
		}
		$sql = $this->db->where('type', 1)->where('status', 1)->order_by('description')->get(_TBL_LIBRARY)->result();
		$no = 0;
		foreach ($sql as $q) {
			$a = $q->description;
			$b = word_limiter($a, 30, '');

			$event[$q->id] = '- ' . $b;
		}

		$data['krii'] = $this->get_combo('data-combo', 'kri');
		$data['per_data'] = [0 => '-select-', 1 => 'Bulan', 2 => 'Triwulan', 3 => 'semester'];
		$data['satuan'] = $this->get_combo('data-combo', 'satuan');
		$data['kategori'] = $this->get_combo('data-combo', 'kel-library');
		$data['subkategori'] = $this->get_combo('data-combo', 'subkel-library');
		$data['area'] = $this->get_combo('parent-input');
		$data['rcsa_no'] = $id_rcsa;
		$data['events'] = $event;
		$data['np'] = $this->get_combo('negatif_poisitf');

		$tblperistiwa = '<table class="table peristiwa" id="tblperistiwa"><tbody>';
		if ($peristiwa) :
			foreach ($peristiwa as $key => $crs) :
				$tambah = '';
				$del = '';
				if ($key == 0) {
					$tambah = '  | <i class="fa fa-plus add-event text-danger pointer"></i>';
					$del = 'del-event ';
				}
				$tblperistiwa .= '<tr class="browse-event"><td style="padding-left:0px;">' . form_textarea('risk_event[]', $crs['description'], " readonly='readonly'  id='risk_event' maxlength='500' size=500 class='form-control' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_event_no[]' => $crs['id']]) . '</td><td class="text-center" width="10%"><i class="fa fa-search browse-event text-primary pointer"></i>  </td></tr>';
			endforeach;
		else :
			$tblperistiwa .= '<tr class="browse-event"><td style="padding-left:0px;">' . form_textarea('risk_event[]', '', " readonly='readonly'  id='risk_event' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_event_no[]' => 0]) . '</td><td class="text-center"  width="10%"><i class="fa fa-search browse-event text-primary pointer"></i> </td></tr>';
		endif;
		$tblperistiwa .= '</tbody></table>';

		$tblkri = '<table class="table peristiwa" id="tblkri"><tbody>';
		if ($peristiwa) :
			foreach ($dtkri as $key => $crs) :
				$tambah = '';
				$del = '';
				if ($key == 0) {
					$tambah = '  | <i class="fa fa-plus add-kri text-danger pointer"></i>';
					$del = 'del-event ';
				}
				$tblkri .= '<tr class="browse-kri"><td style="padding-left:0px;">' . form_textarea('kri[]', $crs['data'], " readonly='readonly'  id='kri' maxlength='500' size=500 class='form-control' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['kri_no[]' => $crs['id']]) . '</td><td class="text-center" width="10%"><i class="fa fa-search browse-kri text-primary pointer"></i>  </td></tr>';
			endforeach;
		else :
			$tblkri .= '<tr class="browse-kri"><td style="padding-left:0px;">' . form_textarea('kri[]', '', " readonly='readonly'  id='kri' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['kri_no[]' => 0]) . '</td><td class="text-center"  width="10%"><i class="fa fa-search browse-event text-primary pointer"></i> </td></tr>';
		endif;
		$tblkri .= '</tbody></table>';



		$tblCouse = '<table class="table couse" id="tblCouse"><tbody>';
		if ($couse) :
			foreach ($couse as $key => $crs) :
				$tambah = '';
				$del = '';
				if ($key == 0) {
					$tambah = '  | <i class="fa fa-plus add-couse text-danger pointer"></i>';
					$del = 'del-couse ';
				}
				$tblCouse .= '<tr><td style="padding-left:0px;">' . form_textarea('risk_couse[]', $crs['description'], " readonly='readonly'  id='risk_couse' maxlength='500' size=500 class='form-control  browse-couse' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_couse_no[]' => $crs['id']]) . '</td><td class="text-center" width="10%"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash text-success ' . $del . 'pointer"></i>' . $tambah . '</td></tr>';
			endforeach;
		else :
			$tblCouse .= '<tr><td style="padding-left:0px;">' . form_textarea('risk_couse[]', '', " readonly='readonly'  id='risk_couse' maxlength='500' size=500 class='form-control  browse-couse' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_couse_no[]' => 0]) . '</td><td class="text-center"  width="10%"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash text-success del-couse pointer"></i>  | <i class="fa fa-plus add-couse text-danger pointer"></i></td></tr>';
		endif;
		$tblCouse .= '</tbody></table>';

		$tblImpact = '<table class="table peristiwa" id="tblImpact"><tbody>';
		if ($impact) :
			foreach ($impact as $key => $crs) :
				$tambah = '';
				$del = '';
				if ($key == 0) {
					$tambah = '  | <i class="fa fa-plus add-impact text-danger pointer"></i>';
					$del = 'del-impact ';
				}
				$tblImpact .= '<tr><td style="padding-left:0px;">' . form_textarea('risk_impact[]', $crs['description'], " readonly='readonly'  id='risk_impact' maxlength='500' size=500 class='form-control browse-impact' rows='2' cols='5' readonly='readonly' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_impact_no[]' => $crs['id']]) . '</td><td class="text-center" width="10%"><i class="fa fa-search browse-impact pointer text-primary"></i> | <i class="fa fa-trash text-success ' . $del . 'pointer"></i>' . $tambah . '</td></tr>';
			endforeach;
		else :
			$tblImpact .= '<tr><td style="padding-left:0px;">' . form_textarea('risk_impact[]', '', " readonly='readonly'  id='risk_impact' maxlength='500' size=500 class='form-control browse-impact' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['risk_impact_no[]' => 0]) . '</td><td class="text-center"  width="10%"><i class=" fa fa-search browse-impact text-primary pointer"></i> | <i class="fa fa-trash text-success del-impact pointer"></i> | <i class="fa fa-plus add-impact text-danger pointer"></i></td></tr>';
		endif;
		$tblImpact .= '</tbody></table>';

		$data['detail'] = $detail;
		$data['peristiwa'] = $tblperistiwa;
		$data['tblkri'] = $tblkri;
		$data['couse'] = $tblCouse;
		$data['impact'] = $tblImpact;
		$data['id_edit'] = $id_edit;
		$result['peristiwa'] = $this->load->view('peristiwa', $data, true);
		echo json_encode($result);
	}
	function edit_level()
	{

		$id_rcsa = $this->input->post('id');
		$id_edit = $this->input->post('edit');
		$data['detail'] = $this->db->where('id', $id_edit)->get(_TBL_RCSA_DETAIL)->row_array();
		$arrControl = json_decode($data['detail']['control_no'], true);
		$data['id_edit'] = $id_edit;
		$data['rcsa_no'] = $id_rcsa;

		$cboLike = $this->get_combo('likelihood');
		$cboImpact = $this->get_combo('impact');
		$cboTreatment = $this->get_combo('treatment');
		$cboTreatment1 = $this->get_combo('treatment1');
		$cboTreatment2 = $this->get_combo('treatment2');
		$cboRiskControl = $this->get_combo('data-combo', 'control-assesment');
		$inherent_level = $this->data->get_master_level(true, $data['detail']['inherent_level']);
		// var_dump($a);
		if (!$inherent_level) {
			$inherent_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
		}

		$a = $inherent_level['level_mapping'];

		$cboControl = $this->db->where('status', 1)->get(_TBL_EXISTING_CONTROL)->result_array();
		$jml = intval(count($cboControl) / 2);
		$check = '';
		$i = 1;
		$control = array();
		$check .= '<div class="well p100">';
		if (is_array($arrControl))
			$control = $arrControl;
		foreach ($cboControl as $row) {
			if ($i == 1)
				$check .= '<div class="col-md-6">';

			$sts = false;
			foreach ($control as $ctrl) {
				if ($row['component'] == $ctrl) {
					$sts = true;
					break;
				}
			}

			$check .= '<label class="pointer">' . form_checkbox('check_item[]', $row['component'], $sts);
			$check .= '&nbsp;' . $row['component'] . '</label><br/>';
			if ($i == $jml)
				$check .= '</div><div class="col-md-6">';

			++$i;
		}
		$check .= '</div>' . form_textarea("note_control", ($data['detail']) ? $data['detail']['note_control'] : '', ' class="form-control" style="width:100%;height:150px"') . '</div><br/>';


		$data['level_resiko'][] = ['label' => lang('msg_field_inherent_risk'), 'isi' => ' Probabilitas : ' . form_dropdown('inherent_likelihood', $cboLike, ($data['detail']) ? $data['detail']['inherent_likelihood'] : '', ' class="form-control select2" id="inherent_likelihood" style="width:40%;"') . ' Impact: ' . form_dropdown('inherent_impact', $cboImpact, ($data['detail']) ? $data['detail']['inherent_impact'] : '', ' class="form-control select2" id="inherent_impact" style="width:40%;"')];
		$data['level_resiko'][] = ['label' => lang('msg_field_inherent_level'), 'isi' => '<span id="inherent_level_label"><span style="background-color:' . $inherent_level['color'] . ';color:' . $inherent_level['color_text'] . ';">&nbsp;' . $inherent_level['level_mapping'] . '&nbsp;</span></span>' . form_hidden(['inherent_level' => ($data['detail']) ? $data['detail']['inherent_level'] : 0]) . form_hidden(['inherent_name' => ($data['detail']) ? $a : ''])];



		$data['level_resiko'][] = ['label' => lang('msg_field_existing_control'), 'isi' => $check];
		$data['level_resiko'][] = ['label' => lang('msg_field_risk_control_assessment'), 'isi' => form_dropdown('risk_control_assessment', $cboRiskControl, ($data['detail']) ? $data['detail']['risk_control_assessment'] : '', ' class="form-control select2" id="risk_control_assessment" style="width:100%;"')];

		if ($a == "Ekstrem") {
			$data['level_resiko'][] = ['label' => lang('msg_field_treatment'), 'isi' => form_dropdown('treatment_no', $cboTreatment1, ($data['detail']) ? $data['detail']['treatment_no'] : '', ' class="form-control select2" id="treatment_no" style="width:100%;"')];
		} elseif ($a == "Low") {
			$data['level_resiko'][] = ['label' => lang('msg_field_treatment'), 'isi' => form_dropdown('treatment_no', $cboTreatment2, ($data['detail']) ? $data['detail']['treatment_no'] : '', ' class="form-control select2" id="treatment_no" style="width:100%;"')];
		} else {
			$data['level_resiko'][] = ['label' => lang('msg_field_treatment'), 'isi' => form_dropdown('treatment_no', $cboTreatment, ($data['detail']) ? $data['detail']['treatment_no'] : '', ' class="form-control select2" id="treatment_no" style="width:100%;"')];
		}

		// $result['peristiwa'] = $this->load->view('level', $data, true);

		// echo json_encode($result);
	}
	function list_realisasi()
	{
		$id_rcsa = $this->input->post('id');
		$id_edit = $this->input->post('edit');
 
		$data['parent'] = $this->db->where('id', $id_rcsa)->get(_TBL_VIEW_RCSA)->row_array();
		$data['detail'] = $this->db->where('id', $id_edit)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['realisasi'] = $this->data->get_realisasi($id_edit);
		// $data['kri'] = $this->data->get_data_kri($id_edit);

		$data['list_realisasi'] = $this->load->view('list-realisasi', $data, true);
		$result['peristiwa'] = $this->load->view('realisasi', $data, true);
		echo json_encode($result);
	}



	function input_realisasi()
	{
		$id = $this->input->post('id');
		$rcsa_detail_no = $this->input->post('rcsa_detail_no');
		$rcsa_no = $this->input->post('rcsa_no');
		$data['owner'] = $this->db->where('id', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['detail'] = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->row_array();
		$rows = $this->db->where('rcsa_detail_no', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_MITIGASI)->row_array();
		$data['cek'] = $this->db->where('rcsa_detail_no', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
		$data['id'] = $id;
		$proaktif = [];
		$reaktif = [];
		$proaktif_text = '<ul>';
		$reaktif_text = '<ul>';
		$pilih = 0;
		$no = 0;

		$proaktif[$rows['id']] = $rows['proaktif'];
		$reaktif[$rows['id']] = $rows['reaktif'];
		$reaktif_text .= '<li>' . $rows['reaktif'] . '</li>';
		$proaktif_text .= '<li>' . $rows['proaktif'] . '</li>';

		$proaktif_text .= '</ul>';
		$reaktif_text .= '</ul>';
		$reaktif_text .= form_hidden('rcsa_action_no', $rows['id']);

		$field = $this->db->where('id', $id)->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->row_array();
		$inherent_level = $data['detail'];
		if (!$inherent_level) {
			$inherent_level = ['warna_action' => '', 'warna_text_action' => '', 'inherent_analisis_action' => '-'];
		}

		$data['rcsa_detail_no'] = $rcsa_detail_no;
		$data['rcsa_no'] = $rcsa_no;
		$data['edit_no'] = $id;
		$cbo_owner = $this->get_combo('parent-input-all');
		$cboLike = $this->get_combo('likelihood');
		$cboImpact = $this->get_combo('impact');
		$cbo_status = $this->get_combo('status-action');
		$pilih = ($data['detail']) ? $data['detail']['status_loss'] : 1;

		$check_kriteria = '<label class="pointer">' . form_radio('status_loss', 1, ($pilih <= 1) ? true : false, ' id="status_loss"');
		$check_kriteria .= '&nbsp; Ya</label> &nbsp;&nbsp;&nbsp;';
		$check_kriteria .= '<label class="pointer">' . form_radio('status_loss', 0, ($pilih == 0) ? true : false, ' id="status_loss" ');
		$check_kriteria .= '&nbsp; Tidak</label> &nbsp;&nbsp;&nbsp;';

		$data['realisasi'][] = ['show' => true, 'label' => 'Apakah peristiwa ini terjadi ', 'isi' => $check_kriteria];
		$data['realisasi'][] = ['show' => ($pilih == 0) ? true : false, 'label' => 'Proaktif', 'isi' => $proaktif_text];
		$data['realisasi'][] = ['show' => ($pilih == 1) ? true : false, 'label' => 'Reaktif', 'isi' => $reaktif_text];
		$data['realisasi'][] = ['show' => true, 'label' => 'Realisasi', 'isi' => form_input('realisasi', ($data['detail']) ? $data['detail']['realisasi'] : '', 'class="form-control" style="width:100%;" id="realisasi"')];
		// $data['realisasi'][] = ['show'=>true,'label' => 'Tanggal Pelaksanaan', 'isi' => form_input('progress_date', ($field)?$field['progress_date']:date('d-m-Y')," id='progress_date' size='20' class='form-control datepicker' style='width:130px;'")];
		$a = ($field) ? $field['progress_date'] : '';
		$n = date_create($a, timezone_open('Asia/Jakarta'))->format('d-m-Y');
		$data['realisasi'][] = ['show' => true, 'label' => 'Tanggal Pelaksanaan', 'isi' => form_input('progress_date', ($field) ? $n : '', " id='progress_date' size='20' class='form-control datepicker' style='width:130px;'")];
		$data['realisasi'][] = ['show' => true, 'label' => 'Analisa Risiko', 'isi' => ' Probabilitas : ' . form_dropdown('residual_likelihood', $cboLike, ($data['detail']) ? $data['detail']['residual_likelihood_action'] : '', ' class="form-control select2" id="residual_likelihood" style="width:40%;"') . ' Impact: ' . form_dropdown('residual_impact', $cboImpact, ($data['detail']) ? $data['detail']['residual_impact_action'] : '', ' class="form-control select2" id="residual_impact" style="width:40%;"')];
		$data['realisasi'][] = ['show' => true, 'label' => 'Risk Level', 'isi' => '<span id="inherent_level_label"><span style="background-color:' . $inherent_level['warna_action'] . ';color:' . $inherent_level['warna_text_action'] . ';">&nbsp;' . $inherent_level['inherent_analisis_action'] . '&nbsp;</span></span>' . form_hidden(['inherent_level' => ($data['detail']) ? $data['detail']['risk_level_action'] : 0])];

		// $data['realisasi'][] = ['show'=>true,'label' => 'Pelaksanaan Treatment', 'isi' => form_dropdown('pelaksana_no[]', $cbo_owner, ($data['detail']) ? json_decode($data['detail']['pelaksana_no'],true) : '', ' class="form-control select2" id="risk_control_assessment" multiple="multiple" style="width:100%;"')];
		// $data['realisasi'][] = ['show'=>true,'label' => 'Short Report', 'isi' => form_dropdown('notes', $cbo_status, ($data['detail']) ? $data['detail']['notes'] : '', ' class="form-control select2" id="notes" style="width:15%;"')];
		$data['realisasi'][] = ['show' => true, 'label' => 'Short Report', 'isi' => form_dropdown('status_no', $cbo_status, ($data['detail']) ? $data['detail']['status_no'] : '', ' class="form-control select2" id="status_no" style="width:130px;"')];

		$data['realisasi'][] = ['show' => true, 'label' => 'Keterangan', 'isi' => form_input('keterangan', ($data['detail']) ? $data['detail']['keterangan'] : '', 'class="form-control" style="width:100%;" id="keterangan"')];
		// $data['realisasi'][] = ['show'=>true,'label' => 'Short Report', 'isi' => form_input('notes', ($data['detail'])?$data['detail']['notes']:'', 'class="form-control" style="width:100%;" id="notes"')];

		$data['realisasi'][] = ['show' => true, 'label' => 'Attacment', 'isi' => form_upload("attach_realisasi", "")];
		$data['realisasi'][] = ['show' => true, 'label' => 'Progress', 'isi' => form_input(['name' => 'progress', 'id' => 'progress', 'type' => 'number', 'value' => ($data['detail']) ? $data['detail']['progress_detail'] : '', 'class' => 'form-control', 'style' => 'width:15%;'])];

		$b = ($field) ? $field['create_date'] : '';
		$n1 = date_create($b, timezone_open('Asia/Jakarta'))->format('d-m-Y H:i:s');
		$data['realisasi'][] = ['show' => true, 'label' => 'Tanggal Monitoring', 'isi' => form_input('create_date', ($field) ? $n1 : '', " id='create_date' readonly='true' size='30' class='form-control' style='width:160px;'")];

		$hasil['combo'] = $this->load->view('input_realisasi', $data, true);

		echo json_encode($hasil);
		// var_dump($hasil);
	}

	function input_mitigasi()
	{
		$rcsa_no = $this->input->post('id');
		$rcsa_detail_no = $this->input->post('edit');
		$data['owner'] = $this->db->where('id', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['detail'] = $this->db->where('id', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['parent'] = $this->db->where('id', $data['owner']['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->db->where('rcsa_detail_no', $rcsa_detail_no)->get(_TBL_VIEW_RCSA_MITIGASI)->row_array();
		$id = 0;
		$data['rcsa_no_1'] = $rcsa_no;
		if ($data['field']) {
			$rcsa_no = $this->input->post('rcsa_no');
			$id = $data['field']['id'];
		}

		$data['id_detail'] = $rcsa_detail_no;
		$data['rcsa_no'] = $rcsa_no;
		$data['edit_no'] = $id;
		$data['cbo_owner'] = $this->get_combo('parent-input-all');
		$data['list_mitigasi'] = $this->load->view('input_mitigasi', $data, true);
		$result['peristiwa'] = $this->load->view('mitigasi', $data, true);

		echo json_encode($result);
	}

	function delete_peristiwa()
	{
		$rcsa_no = $this->input->post('rcsa_no');
		$id_edit = $this->input->post('edit');
		if ($id_edit > 0) {
			$detail = $this->db->delete(_TBL_RCSA_DETAIL, ['id' => $id_edit]);
			$detail = $this->db->delete(_TBL_KRI, ['rcsa_detail' => $id_edit]);
		}
		$data['parent'] = $this->db->where('id', $rcsa_no)->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($rcsa_no);
		$result['combo'] = $this->load->view('list-peristiwa', $data, true);
		echo json_encode($result);
	}

	function delete_mitigasi()
	{
		$id_edit = $this->input->post('edit');
		if ($id_edit > 0) {
			$detail = $this->db->delete(_TBL_RCSA_ACTION, ['id' => $id_edit]);
		}
		echo json_encode(['sts' => 1]);
	}

	function delete_realisasi()
	{
		$id_edit = $this->input->post('edit');
		if ($id_edit > 0) {
			$detail = $this->db->delete(_TBL_RCSA_ACTION_DETAIL, ['id' => $id_edit]);
		}
		echo json_encode(['sts' => 1]);
	}


	function list_library()
	{
		$id = $this->input->post('id');
		$rows = $this->db->where('type', 1)->where('risk_type_no', $id)->get(_TBL_LIBRARY)->result();

		$option = '<option value="0">' . lang('msg_cbo_select') . '</option>';
		foreach ($rows as $row) {
			$option .= '<option value="' . $row->id . '">' . $row->description . '</option>';
		}
		$result['combo'] = $option;
		echo json_encode($result);
	}

	function get_library_event()
	{
		$xx = $this->db->where('type', 1)->where('status', 1)->order_by('description')->get('bangga_view_library')->result_array();

		$peristiwa = $this->db->where('type', 1)->where('status', 1)->order_by('description')->get(_TBL_LIBRARY)->result_array();
		$data['field'] = $peristiwa;
		$cbogroup = $this->get_combo('library', 2);
		$data['cbogroup'] = $cbogroup;
		$data['cbo'] = form_input('', '', ' id="new_cause[]" name="new_cause[]" class="form-control"');
		$data['cbbo'] = form_dropdown('new_cause_no[]', $cbogroup, '', 'class="form-control select4" style="width:100%;"');


		$cbogroup1 = $this->get_combo('library', 3);
		$data['cbogroup'] = $cbogroup1;
		$data['cbo1'] = form_input('', '', ' id="new_impact" name="new_impact[]" class="form-control"');
		$data['cbbii'] = form_dropdown('new_impact_no[]', $cbogroup1, '', 'class="form-control select4"');


		$rok = $this->db->where('status', 1)->order_by('kelompok, type')->get(_TBL_RISK_TYPE)->result_array();
		$arrayX = array('- Pilih-');
		foreach ($rok as $x) {
			$kel = "EXTERNAL";
			if ($x['kelompok'] == 77) {
				$kel = "INTERNAL";
			}
			$arrayX[$kel][$x['id']] = $x['type'];
		}
		$data['nilKel'] = $nilKel;
		$data['cboTypeLibrary'] = $arrayX;
		$hasil['library'] = $this->load->view('list-library-event', $data, true);
		$hasil['title'] = "Event tilte";
		echo json_encode($hasil);
	}
	function get_kri()
	{
		$data['kri'] = $this->get_combo('data-combo', 'kri');
		$data['satuan'] = $this->get_combo('data-combo', 'satuan');

		$xx = $this->db->where('type', 1)->where('status', 1)->order_by('description')->get('bangga_view_library')->result_array();

		$peristiwa = $this->db->where('type', 1)->where('status', 1)->order_by('description')->get(_TBL_LIBRARY)->result_array();
		$data['field'] = $peristiwa;
		$cbogroup = $this->get_combo('library', 2);
		$data['cbogroup'] = $cbogroup;
		$data['cbo'] = form_input('', '', ' id="new_cause[]" name="new_cause[]" class="form-control"');
		$data['cbbo'] = form_dropdown('new_cause_no[]', $cbogroup, '', 'class="form-control select4" style="width:100%;"');


		$cbogroup1 = $this->get_combo('library', 3);
		$data['cbogroup'] = $cbogroup1;
		$data['cbo1'] = form_input('', '', ' id="new_impact" name="new_impact[]" class="form-control"');
		$data['cbbii'] = form_dropdown('new_impact_no[]', $cbogroup1, '', 'class="form-control select4"');


		$rok = $this->db->where('status', 1)->order_by('kelompok, type')->get(_TBL_RISK_TYPE)->result_array();
		$arrayX = array('- Pilih-');
		foreach ($rok as $x) {
			$kel = "EXTERNAL";
			if ($x['kelompok'] == 77) {
				$kel = "INTERNAL";
			}
			$arrayX[$kel][$x['id']] = $x['type'];
		}
		$data['nilKel'] = $nilKel;
		$data['cboTypeLibrary'] = $arrayX;
		$hasil['library'] = $this->load->view('kri', $data, true);
		$hasil['title'] = "Event tilte";
		echo json_encode($hasil);
	}
	public function simpan_kri()
	{
		$post = $this->input->post();
		// doi::dump($post);
		$tipe = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$parent = $this->uri->segment(5);

		$upd_lib['data'] = $post['kri'];
		$upd_lib['kelompok'] = 'kri';
		$upd['satuan'] = $post['satuan'];
		$upd['min_tinggi'] = $post['min_tinggi'];
		$upd['max_tinggi'] = $post['max_tinggi'];
		$upd['min_menengah'] = $post['min_menengah'];
		$upd['max_menengah'] = $post['max_menengah'];
		$upd['min_rendah'] = $post['min_rendah'];
		$upd['max_rendah'] = $post['max_rendah'];
		$upd['per_data'] = $post['per_data'];
		$upd['rcsa_no'] = $post['rcsa_no'];
		$upd['rcsa_detail'] = $post['id_edit'];



		//cek apkaah kri nya udah ada
		$edit = $this->db
			->where('rcsa_detail', $post['id_edit'])
			// ->where('bulan', $post['id_edit'])
			->get('bangga_kri')->row_array();


		//cek apkaah kri nya sudah terdaftar di combo apa blum/ klo blm input dulu lalu masukan id, klo uudah langsung ambl id ya
		$kri_lib = $this->db->where('data', $upd_lib['data'])->get('bangga_data_combo')->row_array();

		if ($kri_lib) {
			$upd['kri_no'] = $kri_lib['id'];
		} else {
			$upd_lib['create_user'] = $this->authentication->get_info_user('username');
			$x = $this->crud->crud_data(['table' => 'bangga_data_combo', 'field' => $upd_lib, 'type' => 'add']);
			$id_lib = $this->db->insert_id();
			$upd['kri_no'] = $id_lib;
		}
		// doi::dump($upd['kri_no']);
		// die('cekk');

		if ($edit) {
			$upd['update_user'] = $this->authentication->get_info_user('username');
			$result = $this->crud->crud_data(array('table' => 'bangga_kri', 'field' => $upd, 'where' => array('rcsa_detail' => $post['id_edit']), 'type' => 'update'));
		} else {

			$upd['create_user'] = $this->authentication->get_info_user('username');
			$x = $this->crud->crud_data(['table' => 'bangga_kri', 'field' => $upd, 'type' => 'add']);
			$id = $this->db->insert_id();
		}
		if ($result || $x) {
			$this->session->set_flashdata('success', 'Save process successful!');
		} else {
			$this->session->set_flashdata('error', 'Save process failed!');
		}
		// die('tes');






		// doi::dump($x);
		// die();

		$tab = 'Berhasil mengisi Key Risk Indikator ?';
		$this->session->set_flashdata('tab', $tab);
		$this->session->set_flashdata('id', $id);
		$this->session->set_flashdata('rcsa_no', $post['rcsa_no']);
		header('location:' . base_url($this->modul_name . '/tes/'));


		$data['id'] = $id;

		echo json_encode($data);
	}

	function get_library()
	{
		$id = $this->input->post('id');
		// doi::dump($id);
		$nilKel = $this->input->post('kel');
		$data['field'] = $this->db->where('library_no', $id)->where('type', $nilKel)->get(_TBL_VIEW_LIBRARY)->result_array();
		$data['kel'] = ($nilKel == 2) ? "Couse" : "Impact";
		$data['event_no'] = $id;
		$rok = $this->db->where('status', 1)->order_by('kelompok, type')->get(_TBL_RISK_TYPE)->result_array();
		$arrayX = array('- Pilih-');
		foreach ($rok as $x) {
			$kel = "EXTERNAL";
			if ($x['kelompok'] == 77) {
				$kel = "INTERNAL";
			}
			$arrayX[$kel][$x['id']] = $x['type'];
		}
		$data['nilKel'] = $nilKel;
		$data['cboTypeLibrary'] = $arrayX;
		$hasil['library'] = $this->load->view('list-library', $data, true);
		$hasil['title'] = ($kel == 2) ? "List " . $data['kel'] : "List " . $data['kel'];
		echo json_encode($hasil);
	}

	public function simpanLibrary()
	{
		$post = $this->input->post();

		$lastCode = $this->data->lastCodeLibrary();
		// doi::dump($post['cause_no'].lenght);
		// die();
		// Save header type 1
		if (!empty($post['library'])) {
			$upd['description'] = $post['library'];
			$upd['code'] = $lastCode ? $lastCode + 1 : 1; // Jika $lastCode kosong, mulai dari 1
			$upd['type'] = 1;
			$upd['status'] = 1;
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$saveUpd = $this->crud->crud_data(['table' => 'bangga_library', 'field' => $upd, 'type' => 'add']);
			$idhed = $this->db->insert_id();
			// $error = $this->db->error();
			// if (!empty($error)) {
			// 	echo "Error: " . $error['message'];
			// }
		}


		if (!empty($post['cause_name'])) {
			if ($saveUpd) {
				$code = $upd['code'];
				$cd = 1; // Mulai dari 1 sebagai offset awal
				foreach ($post['cause_name'] as $data) {
					if ($data != "") {
						$updx['description'] = $data;
						$updx['type'] = 2;
						$updx['code'] = $code + $cd; // Gunakan code yang unik dengan penambahan offset
						$updx['status'] = 1;
						$updx['create_user'] = $this->authentication->get_info_user('username');

						// Cek apakah entri dengan kode yang sama sudah ada sebelum menyimpan
						$existingEntry = $this->db->get_where('bangga_library', ['code' => $updx['code'], 'description' => $data])->row();
						if ($existingEntry) {
							echo "Error: Duplicate entry for code {$updx['code']}";
						} else {
							$saveUpdx = $this->crud->crud_data(['table' => 'bangga_library', 'field' => $updx, 'type' => 'add']);
							$idcouse = $this->db->insert_id();
							$error = $this->db->error();

							$updetail['library_no'] = $idhed;
							$updetail['child_no'] = $idcouse;
							$updetail['create_user'] = $this->authentication->get_info_user('username');
							$this->crud->crud_data(['table' => 'bangga_library_detail', 'field' => $updetail, 'type' => 'add']);
							$error = $this->db->error();
							// if (!empty($error)) {
							// 	echo "Error: " . $error['message'];
							// }
						}
					}

					$cd++;
				}
			}
		}

		if (!empty($post['impact_name'])) {
			if ($saveUpdx) {
				$code = $updx['code'];
			} elseif ($saveUpd) {
				$code = $upd['code'];
			}


			$cd = 1; // Mulai dari 1 sebagai offset awal
			foreach ($post['impact_name'] as $data) {
				// doi::dump($data)
				if ($data != "") {
					$updxx['description'] = $data;
					$updxx['type'] = 3;
					$updxx['code'] = $code + $cd; // Gunakan code yang unik dengan penambahan offset
					$updxx['status'] = 1;
					$updxx['create_user'] = $this->authentication->get_info_user('username');

					// Cek apakah entri dengan kode yang sama sudah ada sebelum menyimpan 
					$existingEntry = $this->db->get_where('bangga_library', ['code' => $updxx['code'], 'description' => $data])->row();
					if ($existingEntry) {
						echo "Error: Duplicate entry for code {$updxx['code']}";
					} else {
						$saveUpdxx = $this->crud->crud_data(['table' => 'bangga_library', 'field' => $updxx, 'type' => 'add']);
						$idimpc = $this->db->insert_id();
						$error = $this->db->error();

						$updetailx['library_no'] = $idhed;
						$updetailx['child_no'] = $idimpc;
						$updetailx['create_user'] = $this->authentication->get_info_user('username');
						$this->crud->crud_data(['table' => 'bangga_library_detail', 'field' => $updetailx, 'type' => 'add']);
						// $error = $this->db->error();
						// if (!empty($error)) {
						// 	echo "Error: " . $error['message'];
						// }
					}
				}
				$cd++;
			}
		}


		// Save cause no
		if (!empty($post['cause_no'])) {
			if ($saveUpd) {
				foreach ($post['cause_no'] as $data) {
					$updetailxxx['library_no'] = $idhed;
					$updetailxxx['child_no'] = $data;
					$updetailxxx['create_user'] = $this->authentication->get_info_user('username');
					$this->crud->crud_data(['table' => 'bangga_library_detail', 'field' => $updetailxxx, 'type' => 'add']);
					// $error = $this->db->error();
					// if (!empty($error)) {
					// 	echo "Error: " . $error['message'];
					// }
				}
			}
		}
		if (!empty($post['impact_no'])) {
			if ($saveUpd) {
				foreach ($post['impact_no'] as $data) {
					$updetailxxxx['library_no'] = $idhed;
					$updetailxxxx['child_no'] = $data;
					$updetailxxxx['create_user'] = $this->authentication->get_info_user('username');
					$this->crud->crud_data(['table' => 'bangga_library_detail', 'field' => $updetailxxxx, 'type' => 'add']);
					$error = $this->db->error();
					// if (!empty($error)) {
					// 	echo "Error: " . $error['message'];
					// }
				}
			}
		}


		$data['id'] = $idhed;
		$data['event_no'] = $post['event_no'];
		$data['kel'] = 0;
		$data['event'] = $post['library'];

		echo json_encode($data);
	}

	public function simpan_library()
	{
		// $this->data->save_library_new($post, $mode="new");
		$post = $this->input->post();
		// save header  type 1

		if ($post['library']) {
			// doi::dump('masuk ke save 1');

			$upd['description'] = $post['library'];
			$upd['type'] = 1;
			$upd['status'] = 0;
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$this->crud->crud_data(['table' => _TBL_LIBRARY, 'field' => $upd, 'type' => 'add']);
			$id = $this->db->insert_id();
			doi::dump($upd);
			doi::dump($id);
		}
		die($id);

		$upd['create_user'] = $this->authentication->get_info_user('username');
		$this->crud->crud_data(['table' => _TBL_LIBRARY, 'field' => $upd, 'type' => 'add']);
		$id = $this->db->insert_id();

		$upd = [];
		if ($post['kel'] > 1) {
			$upd['library_no'] = $post['event_no'];
			$upd['child_no'] = $id;
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$this->crud->crud_data(['table' => _TBL_LIBRARY_DETAIL, 'field' => $upd, 'type' => 'add']);
		}

		$data['id'] = $id;
		$data['event_no'] = $post['event_no'];
		$data['kel'] = $post['kel'];
		$data['event'] = $post['library'];

		echo json_encode($data);
	}

	function simpan_peristiwa()
	{
		$post 	= $this->input->post();
		
		$detail = $this->db->where('id', $post['id_edit'])->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		// doi::dump($detail);
		// die;
		if (($post['sasaran'] == 0)) {
			$result['sasaran'] 	= 0;
			$result['back'] 	= false;
			echo json_encode($result);
		} elseif ($post['tema'] == 0) {
			$result['tema'] 	= 0;
			$result['back'] 	= false;
			echo json_encode($result);
		}elseif ($post['kategori'] == 0) {
			$result['kategori'] = 0;
			$result['back'] 	= false;
			echo json_encode($result);
		}elseif ($post['sub_kategori'] == 0 && $detail['sub_kategori'] == "" ) {
			$result['sub_kategori'] = 0;
			$result['back'] 		= false;
			echo json_encode($result);
		}elseif ($post['subrisiko'] == 0) {
			$result['subrisiko'] 	= 0;
			$result['back'] 		= false;
			echo json_encode($result);
		}elseif ($post['proses_bisnis'] == "") {
			$result['proses_bisnis'] 	= 0;
			$result['back'] 			= false;
			echo json_encode($result);
		}elseif ($post['event_no'] == 0 && $post['peristiwabaru'] == "") {
			$result['event_no'] 	= 0;
			$result['back'] 		= false;
			echo json_encode($result);
		}elseif (is_array($post['risk_couse_no']) && count($post['risk_couse_no']) === 1 && $post['risk_couse_no'][0] == 0 &&
			(is_array($post['new_cause']) && count($post['new_cause']) && $post['new_cause'][0] == "")) {
			$result['risk_couse_no'] = 0;
			$result['back'] = false;
			echo json_encode($result);
		} elseif (is_array($post['risk_impact_no']) && count($post['risk_impact_no']) === 1 && $post['risk_impact_no'][0] == 0 &&
			(is_array($post['new_impact']) && count($post['new_impact']) && $post['new_impact'][0] == "")) {
			$result['risk_impact_no'] = 0;
			$result['back'] = false;
			echo json_encode($result);
		}elseif ($post['kategori_dampak'] == "kuantitatif" && $post['risk_asumsi_perhitungan_dampak'] == "") {
			$result['risk_asumsi_perhitungan_dampak'] 	= 0;
			$result['back'] 			= false;
			echo json_encode($result);
			
		}elseif ($post['pic'] == 0) {
			$result['pic'] 	= 0;
			$result['back'] 			= false;
			echo json_encode($result);
		}else {
			if ($post['event_no'] == 0) {
				$post['event_no'] = $detail['event_no']; 
			}


			$id = $this->data->simpan_risk_event($post);
 			$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
			$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);


			if($id['id']){ 
				$this->session->set_flashdata('id', $id);
				 header('location:' . base_url($this->modul_name . '/tes/'));
			}else{
			$tab = 'Berhasil mengisi Identifikasi Risiko, lanjutkan ke Analisis Risiko ?';
			$this->session->set_flashdata('tab', $tab);
			$this->session->set_flashdata('id', $id);
			$this->session->set_flashdata('rcsa_no', $post['rcsa_no']);
			header('location:' . base_url($this->modul_name . '/tes/'));
			}
			
		}
	}

	function tes()
	{
		$post = $this->input->post();
		$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);

		$result['combo'] = $this->load->view('tes', $data, true);
		echo json_encode($result);
	}

	function simpan_level()
	{


		$post = $this->input->post();
		if ($post['risk_control_assessment'] === "") {
			echo json_encode(['sts' => false, 'message' => 'Risk control assesment wajib diisi.']);
			return;
		}

		if ($post['treatment_no'] === "") {
			echo json_encode(['sts' => false, 'message' => 'Treatment  wajib diisi..']);
			return;
			
		}

		$id = $this->data->simpan_risk_level($post);
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);

		$tab = 'Berhasil mengisi risk evaluation, lanjutkan ke risk treatment ?';


		$this->session->set_flashdata('tab', $tab);
		$this->session->set_flashdata('id', $id);
		$this->session->set_flashdata('rcsa_no', $post['rcsa_no']);
		$this->session->set_flashdata('tabval', 'asasas');

		header('location:' . base_url($this->modul_name . '/tes/'));
	}

	

	function simpan_mitigasi()
	{
		$post 	= $this->input->post();
		// doi::dump($post);
		// die;
		if (isset($post['proaktif']) && is_array($post['proaktif'])) {
			foreach ($post['proaktif'] as $index => $value) {
				if (empty($value)) {
					// $errors['proaktif'][$index] = "Proaktif di index $index tidak boleh kosong.";
					echo json_encode(['sts' => false, 'message' => "Treatment tidak boleh kosong."]);
					return;
				}
			}
		} else {
			echo json_encode(['sts' => false, 'message' => "Input minimal 1 treatment."]);
			return;
		}

		$bulan_nama = [
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		];
		
		$errors = []; // Menyiapkan array untuk error
		
		// Validasi untuk 'target_progress' dan 'target_damp_loss' per bulan
		for ($month = 1; $month <= 12; $month++) {
			// Validasi untuk 'target_progress'
			if (isset($post['target_progress']) && is_array($post['target_progress'])) {
				foreach ($post['target_progress'] as $index => $months) {
					// Cek apakah bulan valid
					if (!isset($bulan_nama[$month])) {
						echo json_encode(['sts' => false, 'message' => "Bulan tidak valid untuk index $index."]);
						return;
					}
		
					$value = isset($months[$month]) ? $months[$month] : null;
		
					// Validasi target_progress: Angka antara 0 dan 100
					if (empty($value) || !is_numeric($value) || $value < 0 || $value > 100) {
						echo json_encode(['sts' => false, 'message' => "Progress di bulan " . $bulan_nama[$month] . " harus berupa angka antara 0 dan 100."]);
						return;
					}
				}
			}
		
			// Validasi untuk 'target_damp_loss'
			if (isset($post['target_damp_loss']) && is_array($post['target_damp_loss'])) {
				foreach ($post['target_damp_loss'] as $index => $months) {
					// Cek apakah bulan valid
					if (!isset($bulan_nama[$month])) {
						echo json_encode(['sts' => false, 'message' => "Bulan tidak valid untuk index $index."]);
						return;
					}
		
					$value = isset($months[$month]) ? $months[$month] : null;
		
					// Validasi target_damp_loss: Pastikan angka valid
					if (empty($value) || !is_numeric(str_replace([',', '.'], '', $value))) {
						echo json_encode(['sts' => false, 'message' => "Treatment Cost di bulan " . $bulan_nama[$month] . " harus berupa angka yang valid."]);
						return;
					}
				}
			}
		}
		
		$id 	= $this->data->simpan_mitigasi($post);
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);

		if($id > 0){
			$tab = 'Berhasil mengisi risk treatment, data ini dijadikan sebagai Key Risk Indikator lanjutkan ke pengisian Key Risk ?';
		}else{
			$tab = 'Pengisian identifikasi Risiko udah selesai, kembali ke list ?';
			$this->session->set_flashdata('done', 1);

		}
		$this->session->set_flashdata('rcsa_no', $post['rcsa_no']);
		$this->session->set_flashdata('id', $post['id_detail']);
		$this->session->set_flashdata('tab', $tab);

		header('location:' . base_url($this->modul_name . '/tes/'));
		// $result['combo'] = $this->load->view('list-peristiwa', $data, true);
		// echo json_encode($result);
	}

	function close_mitigasi()
	{
		$post = $this->input->post();
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);
		$result['combo'] = $this->load->view('list-peristiwa', $data, true);
		echo json_encode($result);
	}

	function simpan_realisasi()
	{
		// die($_FILES);
		$post = $this->input->post();
		$id = $this->data->simpan_realisasi($post);
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['detail'] = $this->db->where('id', $post['detail_rcsa_no'])->get(_TBL_VIEW_RCSA_DETAIL)->row_array();
		$data['realisasi'] = $this->data->get_realisasi($post['detail_rcsa_no']);
		// $data['kri'] = $this->data->get_data_kri($post['detail_rcsa_no']);

		$result['combo'] = $this->load->view('list-realisasi', $data, true);
		echo json_encode($result);
	}

	function close_realisasi()
	{
		$post = $this->input->post();
		$data['parent'] = $this->db->where('id', $post['rcsa_no'])->get(_TBL_VIEW_RCSA)->row_array();
		$data['field'] = $this->data->get_peristiwa($post['rcsa_no']);
		$result['combo'] = $this->load->view('list-peristiwa', $data, true);
		echo json_encode($result);
	}

	function cek_level()
	{
		$post = $this->input->post();
		$rows = $this->db->where('impact_no', $post['impact'])->where('like_no', $post['likelihood'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();

		$result['level_text'] = '-';
		$result['level_no'] = 0;
		$result['level_resiko'] = '-';
		$result['mode'] =(isset($post['mode']))?$post['mode']:0;
		$result['month'] =(isset($post['month']))?$post['month']:0;
		if ($rows) {
			$result['level_text'] = "<span style='background-color:" . $rows['warna_bg'] . ";color:" . $rows['warna_txt'] . ";'>&nbsp;" . $rows['tingkat'] . "&nbsp;</span>";
			$result['level_no'] = $rows['id'];
			$result['level_name'] = $rows['tingkat'];
			$cboTreatment = $this->get_combo('treatment');
			$cboTreatment1 = $this->get_combo('treatment1');
			$cboTreatment2 = $this->get_combo('treatment2');

			
			if ($result['level_name'] == "Ekstrem") {
				$result['level_resiko'] = $cboTreatment1;
			} elseif ($result['level_name'] == "Low") {
				$result['level_resiko'] = $cboTreatment2;
			} else {
				$result['level_resiko'] = $cboTreatment;
			}
		}

		echo json_encode($result);
	}

	function get_register() 
	{ 
		$id_rcsa 			= $this->input->post('id');
		$owner_no 			= $this->input->post('owner_no');
		$data['field'] 		= $this->data->get_data_risk_register($id_rcsa);
		$data['fieldxx'] 	= $this->data->get_data_risk_reg_acc($id_rcsa);
		$data['tgl'] 		= $this->data->get_data_tanggal($id_rcsa);
		$data['id_rcsa'] 	= $id_rcsa;
		$data['id'] 		= $id_rcsa;
		$parent_no 			= $this->data->get_data_parent($owner_no);
		$data['owner'] 		= $parent_no[0]['parent_no'];
		$data['divisi'] 	= $this->data->get_data_divisi($parent_no);
		$data['fields'] 	= $this->data->get_data_officer($id_rcsa);
		$data['tipe'] 		= 'cetak';
		$xx = array('field' => $data['field'], 'rcsa' => $data['id_rcsa']);
		$this->session->set_userdata('result_risk_register', $xx);
		// $residual_level = $this->data->get_master_level(true, $data['field'][0]['residual_level']);
		// $data['residual_level'] = $residual_level;
		// $inherent_level = $this->data->get_master_level(true, $data['field'][0]['inherent_level']);
		// $data['inherent_level'] = $inherent_level;
		// doi::dump($data['field']);
  
		
 		$data['log'] = $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_LOG_PROPOSE)->result_array();
		
		$result['register'] = $this->load->view('list_risk_register', $data, true);
		echo json_encode($result);
	}

	function get_rivis() 
	{
		$id_rcsa 			= $this->input->post('id');
		$owner 				= $this->input->post('owner_no');
		$data['field'] 		= $this->data->get_data_risk_register($id_rcsa);
		$data['fieldxx'] 	= $this->data->get_data_risk_reg_acc($id_rcsa);
		$data['tgl'] 		= $this->data->get_data_tanggal($id_rcsa);
		$data['id_rcsa'] 	= $id_rcsa;
		$data['id'] 		= $id_rcsa;
		$data['owner_no'] 	= $owner;
		$parent_no 			= $this->data->get_data_parent($owner);
		$data['owner'] 		= $parent_no[0]['parent_no'];
		$data['divisi'] 	= $this->data->get_data_divisi($parent_no);
		$data['fields'] 	= $this->data->get_data_officer($id_rcsa);
		$data['tipe'] 		= 'cetak';
		$xx					= array('field' => $data['field'], 'rcsa' => $data['id_rcsa']);
		$this->session->set_userdata('result_risk_register', $xx);		
 		$data['log'] 		= $this->db->where('rcsa_no', $id_rcsa)->get(_TBL_LOG_PROPOSE)->result_array();
		$result['register'] = $this->load->view('list_risk_revisi', $data, true);
		echo json_encode($result);
	}


	function cetak_register()
	{

		$tipe = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$parent = $this->uri->segment(5);
		$data = $this->db->where('id', $id)->get(_TBL_RCSA)->row_array();
		$rows = $this->db->where('id', $data['owner_no'])->get(_TBL_OWNER)->row_array();
		$nama = $nama = 'Risk-Register-' . url_title($rows['name']);

		$id_rcsa = $id;
		$data['id'] = $id;
		$data['tipe'] = $tipe;

		$data['owner'] = $parent;
		$data['fieldxx'] = $this->data->get_data_risk_reg_acc($id_rcsa);
		$data['fields'] = $this->data->get_data_officer($id_rcsa);
		$data['field'] = $this->data->get_data_risk_register($id);
		$data['tgl'] = $this->data->get_data_tanggal($id);

		$data['divisi'] =  $this->db->where('id', $parent)->get(_TBL_OWNER)->row();


		$hasil = $this->load->view('list_risk_register', $data, true);
		$cetak = 'register_' . $tipe;
		$this->$cetak($hasil, $nama);
	}

	function cetak_rbb()
	{

		$tipe = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$parent = $this->uri->segment(5);
		$data = $this->db->where('id', $id)->get(_TBL_RCSA)->row_array();
		$rows = $this->db->where('id', $data['owner_no'])->get(_TBL_OWNER)->row_array();
		$nama = $nama = 'RBB-' . url_title($rows['name']);

		$id_rcsa = $id;
		$data['id'] = $id;
		$data['tipe'] = $tipe;

		$data['owner'] = $parent;
		$data['fieldxx'] = $this->data->get_data_risk_reg_acc($id_rcsa);
		$data['fields'] = $this->data->get_data_officer($id_rcsa);
		$data['field'] = $this->data->get_data_risk_register($id);
		$data['tgl'] = $this->data->get_data_tanggal($id);

		$data['divisi'] =  $this->db->where('id', $parent)->get(_TBL_OWNER)->row();


		$hasil = $this->load->view('list_risk_rbb', $data, true);
		$cetak = 'register_' . $tipe;
		$this->$cetak($hasil, $nama);
	}

	function register_excel($data, $nama = "Risk-Assesment")
	{
		header("Content-type:appalication/vnd.ms-excel");
		header("content-disposition:attachment;filename=" . $nama . ".xls");

		$html = $data;
		echo $html;
		exit;
	}

	function register_pdf($data, $nama = "Risk-Assesment")
	{
		$this->load->library('pdf');
		$tgl = date('d-m-Y');
		// $this->nmFile = _MODULE_NAME_ . '-' . $nama .'-'.$tgl.".pdf";
		$this->nmFile = $nama . '-' . $tgl . ".pdf";
		$this->pdfFilePath = download_path_relative($this->nmFile);

		$html = '<style>
				table {
					border-collapse: collapse;
				}

				.test th, 
				.test td {
					border: 1px solid black;
				}

				</style>';


		// $html .= '<table width="100%" border="1"><tr><td width="100%" style="padding:20px;">';
		$html .= $data;
		// $html .= '</td></tr></table>';

		// die($html);
		$align = array();
		$format = array();
		$no_urut = 0;

		// die($html);
		$pdf = $this->pdf->load();
		$pdf->AddPage(
			'L', // L - landscape, P - portrait
			'',
			'',
			'',
			'',
			10, // margin_left
			10, // margin right
			10, // margin top
			10, // margin bottom
			5, // margin header
			5
		); // margin footer
		$pdf->SetHeader('');
		// $pdf->SetHTMLHeader('');
		// $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822));
		// $pdf->SetHTMLFooter('<h1>ini Footer</h1>');
		$pdf->SetFooter('|{PAGENO} Dari {nb} Halaman|');
		$pdf->debug = true;
		$pdf->WriteHTML($html);
		ob_clean();

		$pdf->Output($this->pdfFilePath, 'F');
		redirect($this->pdfFilePath);

		return true;
	}


	function delete_sasaran()
	{ //delete from table sasaran in rcsa edit
		$halaman = $this->uri->segment(4); //halaman edit

		$this->data->delete_sasaran($this->uri->segment(3));
		redirect('/rcsa-context/edit/' . $halaman);
	}

	function delete_stakeholder()
	{ //delete from table stackholder in rcsa edit
		$halaman = $this->uri->segment(4); //halaman edit

		$this->data->delete_stakeholder($this->uri->segment(3));
		redirect('/rcsa-context/edit/' . $halaman);
	}

	function delete_kriteria()
	{ //delete from table kriteria in rcsa edit
		$halaman = $this->uri->segment(4); //halaman edit

		$this->data->delete_kriteria($this->uri->segment(3));
		redirect('/rcsa-context/edit/' . $halaman);
	}
	function delete_couse()
	{
		$post = $this->input->post();
		$detail = $this->db->where('id', $post['edit'])->get(_TBL_RCSA_DETAIL)->row_array();

		$detailRiskCauseNo = json_decode($detail['risk_couse_no']); // Mengubah string JSON menjadi array
		$postCauseNo = $post['couseno']; // Mengambil nilai dari $post['couseno']

		$newDetailRiskCauseNo = array();

		foreach ($detailRiskCauseNo as $value) {
			if ($value !== $postCauseNo) {
				$newDetailRiskCauseNo[] = $value;
			}
		}

		// Mengubah kembali array menjadi string JSON
		$updatedRiskCauseNo = json_encode($newDetailRiskCauseNo);

		// Update data di database dengan nilai baru $updatedRiskCauseNo
		$this->db->where('id', $post['edit'])->update(_TBL_RCSA_DETAIL, ['risk_couse_no' => $updatedRiskCauseNo]);

		// echo "Data diperbarui.";
		return true;
	}
	function delete_impact()
	{
		$post = $this->input->post();
		$detail = $this->db->where('id', $post['edit'])->get(_TBL_RCSA_DETAIL)->row_array();

		$detailRiskCauseNo = json_decode($detail['risk_impact_no']); // Mengubah string JSON menjadi array
		$postCauseNo = $post['impactno']; // Mengambil nilai dari $post['couseno']

		$newDetailRiskCauseNo = array();

		foreach ($detailRiskCauseNo as $value) {
			if ($value !== $postCauseNo) {
				$newDetailRiskCauseNo[] = $value;
			}
		}

		// Mengubah kembali array menjadi string JSON
		$updatedRiskCauseNo = json_encode($newDetailRiskCauseNo);

		// Update data di database dengan nilai baru $updatedRiskCauseNo
		$this->db->where('id', $post['edit'])->update(_TBL_RCSA_DETAIL, ['risk_impact_no' => $updatedRiskCauseNo]);

		// echo "Data diperbarui.";
		return true;
	}
	public function upload()
	{
		$files = $_FILES;
 				if ($files) {
 					$i = 0;
					// for ($i = 0; $i < $cpt; $i++) {
						if (!empty($files['userfile']['name'])) {
							$nmFile = $files['userfile']['name'];
							$_FILES['userfile']['name'] = $files['userfile']['name'];
							$_FILES['userfile']['type'] = $files['userfile']['type'];
							$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'];
							$_FILES['userfile']['error'] = $files['userfile']['error'];
							$_FILES['userfile']['size'] = $files['userfile']['size'];
							$upload = upload_image_new(array(
								'nm_file' => 'userfile', 
								'size' => 10000000, 
								'path' => 'rcsa', 
								'thumb' => false, 
								'type' => 'png'), true, $i);
							  die($upload);
							if ($upload) {
					$arra_upload[] = array('name' => $upload['file_name'], 'real_name' => $nmFile);
				}
			}
		 
		}
	}

	public function downloadFile()
	{
		// Mendapatkan id file dari URI segment
		$id = $this->uri->segment(3);
		$pdx = $this->uri->segment(4);
		// $data = $this->data->get_data_detail($id);
		// 		$pd = str_replace('####', '/', $pdx);

		// // 		echo $updatedUpd;
		// doi::dump($id);
		// doi::dump('download ya');
		// die();


		// 		// Cek apakah data file ditemukan
		// 		if ($pd) {
		// 			header('Content-Type: application/octet-stream');
		// 			header("Content-Disposition: attachment; filename=\"" . $id . "\"");
		// 			header('Content-Length: ' . filesize($pd));
		// 			// Membaca file dan mengirimkan isinya ke output
		// 			readfile($pd);
		// 			// echo "<script>alert('file tidak ditemukan atau permision jalur tidak sah'); window.history.go(-1);</script>";
		// 		}

		if ($id) {
			// Mendapatkan path file yang akan diunduh
			$filePath = "themes/file/rcsa/" . $id;
			header('Content-Type: application/octet-stream');
			header("Content-Disposition: attachment; filename=\"" . $id . "\"");
			header('Content-Length: ' . filesize($filePath));
			// Membaca file dan mengirimkan isinya ke output
			readfile($filePath);
			// Periksa apakah file ada sebelum melakukan unduhan

			if ($data['nm_file']) {
				if (file_exists($filePath)) {
					// Mengatur header HTTP
					
				} else {
					echo "<script>alert('file tidak ditemukan atau permision jalur tidak sah'); window.history.go(-1);</script>";
				}
			} else {
				echo "<script>alert('" . htmlspecialchars($data['title']) . " Tidak memiliki lampiran'); window.history.go(-1);</script>";
			}
		} else {
			echo "<script>alert('Data file tidak ditemukan.'); window.history.go(-1);</script>";

			// echo "Data file tidak ditemukan.";
		}
	}

	public function simpan_analisis() {
		$bulan_nama = [
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		];
		$post 			= $this->input->post();
		$rcsa_detail  	= $this->db->select('kategori_dampak')->where('id', $post['id_detail'])->get('bangga_view_rcsa_detail')->row_array();
		
		if ($post['analisis_impact_inherent'] === "") {
			echo json_encode(['sts' => false, 'message' => 'Skala impact inherent wajib diisi.']);
			return;
		}

		if ($post['analisis_like_inherent'] === "") {
			echo json_encode(['sts' => false, 'message' => 'Skala likelihood inherent wajib diisi..']);
			return;
			
		}
		
		if ($post['analisis_like_residual'] === "") {
			echo json_encode(['sts' => false, 'message' => 'Skala likelihood residual wajib diisi..']);
			return;
		}
		if ($post['analisis_impact_residual'] === "") {
			echo json_encode(['sts' => false, 'message' => 'Skala impact residual wajib diisi..']);
			return;
		}

		if (empty($post['target_impact']) || !is_array($post['target_impact'])) {
			echo json_encode(['sts' => false, 'message' => 'Skala impact januari sampai desember wajib diisi..']);
			return;
		}
		if (empty($post['target_like']) || !is_array($post['target_like'])) {
			echo json_encode(['sts' => false, 'message' => 'Skala likelihood januari sampai desember wajib diisi..']);
			return;
		}

		for ($i = 1; $i <= 12; $i++) {
			$target_impact 		= isset($post['target_impact'][$i - 1]) ? $post['target_impact'][$i - 1] : null;
			$target_like 		= isset($post['target_like'][$i - 1]) ? $post['target_like'][$i - 1] : null;
	
			if (empty($target_impact )) {
				echo json_encode(['sts' => false, 'message' => 'Skala impact untuk bulan ' . $bulan_nama[$i] . ' belum diisi.']);
				return;
			}
	
			if (empty($target_like)) {
				echo json_encode(['sts' => false, 'message' => 'Skala likelihood untuk bulan ' . $bulan_nama[$i] . ' belum diisi.']);
				return;
			}
		}
		
		if($rcsa_detail['kategori_dampak'] === "kuantitatif"){
			if (empty($post['nilai_in_impact'])) {
				echo json_encode(['sts' => false, 'message' => 'Nilai impact inherent wajib diisi.']);
				return;
			}
			if (empty($post['nilai_in_likelihood'])) {
				echo json_encode(['sts' => false, 'message' => 'Nilai likelihood inherent wajib diisi.']);
				return;
			}
			if (empty($post['nilai_in_exposure'])) {
				echo json_encode(['sts' => false, 'message' => 'Nilai exposure inherent wajib diisi.']);
				return;
			}
			if (empty($post['nilai_res_impact'])) {
				echo json_encode(['sts' => false, 'message' => 'Nilai impact residual wajib diisi.']);
				return;
			}
			if (empty($post['nilai_res_likelihood'])) {
				echo json_encode(['sts' => false, 'message' => 'Nilai likelihood residual wajib diisi.']);
				return;
			}
			if (empty($post['nilai_res_exposure'])) {
				echo json_encode(['sts' => false, 'message' => 'Nilai exposure residual wajib diisi.']);
				return;
			}
	
			if (empty($post['nilai_impact']) || !is_array($post['nilai_impact'])) {
				echo json_encode(['sts' => false, 'message' => 'Nilai impact januari sampai desember wajib diisi.']);
				return;
			}
			if (empty($post['nilai_likelihood']) || !is_array($post['nilai_likelihood'])) {
				echo json_encode(['sts' => false, 'message' => 'Nilai likelihood januari sampai desember wajib diisi..']);
				return;
			}
			
		
			for ($i = 1; $i <= 12; $i++) {
				$nilai_impact 		= isset($post['nilai_impact'][$i - 1]) ? $post['nilai_impact'][$i - 1] : null;
				$nilai_likelihood 	= isset($post['nilai_likelihood'][$i - 1]) ? $post['nilai_likelihood'][$i - 1] : null;
				if (empty($nilai_impact )) {
					echo json_encode(['sts' => false, 'message' => 'Nilai impact untuk bulan ' . $bulan_nama[$i] . ' belum diisi.']);
					return;
				}
		
				if (empty($nilai_likelihood)) {
					echo json_encode(['sts' => false, 'message' => 'Nilai likelihood untuk bulan ' . $bulan_nama[$i] . ' belum diisi.']);
					return;
				}
		
			}
		}

		

		
		
		// Proses data jika semua validasi berhasil
		$updPI['inherent_likelihood'] = $post['analisis_like_inherent'];
		$updPI['inherent_impact'] = $post['analisis_impact_inherent'];
		$updPI['residual_likelihood'] = $post['analisis_like_residual'];
		$updPI['residual_impact'] = $post['analisis_impact_residual'];
		$updPI['nilai_in_impact'] = str_replace(',', '', $post['nilai_in_impact']);
		$updPI['nilai_in_likelihood'] = str_replace(',', '', $post['nilai_in_likelihood']);
		$updPI['nilai_in_exposure'] = str_replace(',', '', $post['nilai_in_exposure']);
		$updPI['nilai_res_impact'] = str_replace(',', '', $post['nilai_res_impact']);
		$updPI['nilai_res_likelihood'] = str_replace(',', '', $post['nilai_res_likelihood']);
		$updPI['nilai_res_exposure'] = str_replace(',', '', $post['nilai_res_exposure']);
		$updPI['inherent_level'] = $post['inherent_level'];
		$updPI['residual_level'] = $post['residual_level'];
		$updPI['update_user'] = $this->authentication->get_info_user('username');
		$res = false;
		$add = false;
	
		foreach ($post['month'] as $key => $month) {
			$target_impact = isset($post['target_impact'][$key]) ? $post['target_impact'][$key] : null;
			$target_like = isset($post['target_like'][$key]) ? $post['target_like'][$key] : null;
			$nilai_impact = isset($post['nilai_impact'][$key]) ? $post['nilai_impact'][$key] : null;
			$nilai_likelihood = isset($post['nilai_likelihood'][$key]) ? $post['nilai_likelihood'][$key] : null;
			$nilai_exposure = isset($post['nilai_exposure'][$key]) ? $post['nilai_exposure'][$key] : null;
			$nilai_impact = str_replace(',', '', $nilai_impact);
			$nilai_likelihood = str_replace(',', '', $nilai_likelihood);
			$nilai_exposure = str_replace(',', '', $nilai_exposure);
	
			// Memeriksa apakah data bulan sudah ada di tabel analisis_risiko
			$cek_data = $this->db->where('id_detail', $post['id_detail'])
				->where('bulan', $month)
				->get('bangga_analisis_risiko')
				->row_array();
	
			if ($cek_data) {
				$update_bulan = [
					'target_impact' => $target_impact,
					'target_like' => $target_like,
					'nilai_impact' => $nilai_impact,
					'nilai_likelihood' => $nilai_likelihood,
					'nilai_exposure' => $nilai_exposure
				];
				$update_bulan['update_by'] = $this->authentication->get_info_user('username');
				$res = $this->crud->crud_data(array('table' => 'bangga_analisis_risiko', 'field' => $update_bulan, 'where' => array('id_detail' => $post['id_detail'], 'bulan' => $month), 'type' => 'update'));
			} else {
				$upd = [
					'id_detail' => $post['id_detail'],
					'bulan' => $month,
					'target_impact' => $target_impact,
					'target_like' => $target_like,
					'nilai_impact' => $nilai_impact,
					'nilai_likelihood' => $nilai_likelihood,
					'nilai_exposure' => $nilai_exposure
				];
				$updPI['pi'] = 3;
				$upd['create_by'] = $this->authentication->get_info_user('username');
				$res = $this->crud->crud_data(array('table' => 'bangga_analisis_risiko', 'field' => $upd, 'type' => 'add'));
			}
		}
		$this->crud->crud_data(array('table' => _TBL_RCSA_DETAIL, 'field' => $updPI, 'where' => array('id' => $post['id_detail']), 'type' => 'update'));
		$result['sts'] = $res;
		$result['add'] = $add;
		$result['post'] = $post;
		echo json_encode($result);
	
	}
	
	public function simpan_treatment(){
		$post = $this->input->post();
		
		$upd['rcsa_detail_no'] 			= $post['id_detail'];
		$upd['rcsa_no'] 				= $post['rcsa_no'];
		$upd['target_progress_detail'] 	= $post['target_progress'];
		$upd['target_damp_loss'] 		= $post['target_damp_loss'];
		$treatment = $this->db->where('rcsa_detail_no', $post['id_detail'])->get('bangga_rcsa_treatment')->row_array();
		$res=false;
		$add=false;
 		if ($treatment) {
 			$upd['update_user'] = $this->authentication->get_info_user('username');
			 $res= $this->crud->crud_data(array('table' => 'bangga_rcsa_treatment', 'field' => $upd, 'where' => array('rcsa_detail_no' => $post['id_detail']), 'type' => 'update'));
		} else {

			$upd['id_detail'] = $post['id_detail'];
			$upd['create_user'] = $this->authentication->get_info_user('username');
			$res=$this->crud->crud_data(['table' => 'bangga_rcsa_treatment', 'field' => $upd, 'type' => 'add']);
			$add=true;
		}
		$result['sts'] = $res;
		$result['add'] = $add;
		$result['post'] = $post;
		echo json_encode($result);
	}


	public function reset() {
		// Get the array of IDs from the POST request
		$id_rcsa = $this->input->post("id");
	
		// Ensure $id_rcsa is an array; if it comes in as a comma-separated string, explode it
		if (!is_array($id_rcsa)) {
			$id_rcsa = explode(',', $id_rcsa);
		}
	
		// Retrieve logs for the selected IDs
		$data['log'] = $this->db->where_in('rcsa_no', $id_rcsa)->get(_TBL_LOG_PROPOSE)->result_array();
		$data['id_rcsa'] = $id_rcsa; // Menambahkan $data['id_rcsa']
	
		// Load the view with the retrieved logs
		$result['cek'] = $this->load->view('modal_reset', $data, true);
		
		// Return the result as JSON
		echo json_encode($result);
	}
	


	public function proses_reset() {
		// Ambil data dari request POST
		$ids = $this->input->post('id');
		$note = $this->input->post('note');
		// $approve_user = $this->input->post('approve_user');
	
		// Cek apakah data ID tidak kosong
		if (empty($ids) || empty($note)) {
			$result = array(
				'status' => 'error',
				'message' => 'Data tidak lengkap. Pastikan semua input diisi.'
			);
			echo json_encode($result);
			return;
		}
	
		// Mulai proses update satu per satu
		foreach ($ids as $id) {
			$data = array(
				'table' => 'rcsa',
				'type' => 'update',
				'field' => array(
					'sts_propose' => 0
				),
				'where' => array('id' => $id)
			);
	
			// Lakukan update data
			$this->crud->crud_data($data);
	
			// Log proses
			$log_data = array(
				'rcsa_no' => $id,
				'note' => $note,
				'petugas_no' => $this->authentication->get_Info_User("identifier"),
				'keterangan' => 'Reset Drafting Risk Register',
				'create_user' => $this->authentication->get_Info_User('username')
			);
			$this->db->insert('log_propose', $log_data);
		}
	
		// Siapkan respon akhir
		$result = array(
			'status' => 'success',
			'message' => 'Proses reset berhasil dilakukan.',
			'updated_ids' => $ids
		);
	
		// Kembalikan hasil dalam format JSON
		echo json_encode($result);
	}
	
	

}
