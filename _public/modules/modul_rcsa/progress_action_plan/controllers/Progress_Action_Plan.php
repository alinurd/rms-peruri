<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Progress_Action_Plan extends BackendController
{
    public $table                  = "";
    public $post                   = array();
    public $sts_cetak              = false;
    public $data_jml_action_detail = array();
    public $id_list;
    public $data_rcsa_detail;

    public function __construct()
    {
        parent::__construct();

        $this->combo_sts = $this->get_combo('status-action');
        $this->set_Tbl_Master(_TBL_VIEW_RCSA_ACTION_DETAIL);

        $this->set_Open_Tab('Data Petugas');
        $this->addField(array('field' => 'id', 'show' => false));
        $this->addField(array('field' => 'action_no', 'search' => true, 'show' => false, 'size' => 20));
        $this->addField(array('field' => 'progress_date', 'type' => 'date', 'input' => 'date', 'search' => true, 'size' => 40));
        $this->addField(array('field' => 'tahun', 'type' => 'free', 'search' => true, 'size' => 40));
        $this->addField(array('field' => 'bulan', 'type' => 'free', 'search' => true, 'size' => 40));
        $this->addField(array('field' => 'description', 'type' => 'date', 'input' => 'date', 'search' => true, 'size' => 40));
        $this->addField(array('field' => 'progress', 'show' => false, 'search' => true, 'size' => 40));
        $this->addField(array('field' => 'event_name', 'show' => false, 'search' => true, 'size' => 40));
        // $this->addField(array('field' => 'corporate', 'show' => false, 'search' => false, 'size' => 40));
        $this->addField(array('field' => 'name', 'show' => false, 'search' => false, 'size' => 40));
        $this->set_Close_Tab();

        $this->set_Field_Primary('id');
        $this->set_Join_Table(array('pk' => $this->tbl_master));

        $this->set_Sort_Table($this->tbl_master, 'action_no');
        $this->set_Sort_Table($this->tbl_master, 'progress_date');

        if ($this->id_param_owner['privilege_owner']['id'] > 1) {
            $this->set_Where_Table($this->tbl_master, 'owner_no', 'in', $this->id_param_owner['owner_child']);
        }

        $this->set_Table_List($this->tbl_master, 'progress_date');
        $this->set_Table_List($this->tbl_master, 'name');
        // $this->set_Table_List($this->tbl_master, 'corporate');
        $this->set_Table_List($this->tbl_master, 'event_name');
        $this->set_Table_List($this->tbl_master, 'progress');
        // $this->set_Table_List($this->tbl_rcsa_action, 'proaktif');
        // $this->set_Table_List($this->tbl_rcsa_action, 'reaktif');
        // $this->set_Table_List($this->tbl_master, 'owner_no');
        // $this->set_Table_List($this->tbl_master, 'description');
        // $this->set_Table_List($this->tbl_master, 'amount');
        // $this->set_Table_List($this->tbl_master, 'status_no');

        $this->_SET_PRIVILEGE('add', false);
        $this->_SET_PRIVILEGE('delete', false);
        $this->set_Close_Setting();

    }

    public function searchBox_RAD_TAHUN($field, $post)
    {
        $combo   = $this->data->get_tahun_progress();
        $content = form_dropdown('q_' . $field['field'], $combo, (isset($this->post['q_l_tahun'])) ? $this->post['q_l_tahun'] : '', "class='form-control' style='width:40px;' id='{$field['label']}' ");
        $content = $this->__search_Combo_Custom($field, $post, $combo);
        return $content;
    }

    public function searchBox_RAD_BULAN($field, $post)
    {
        $combo   = $this->data->get_bulan_progress();
        $content = form_dropdown('q_' . $field['field'], $combo, (isset($this->post['q_l_bulan'])) ? $this->post['q_l_bulan'] : '', "class='form-control' style='width:40px;' id='{$field['label']}' ");
        $content = $this->__search_Combo_Custom($field, $post, $combo);
        return $content;
    }

    public function MASTER_DATA_LIST($arrId, $rows)
    {
        $this->id_list = $arrId;
        if ($this->id_list) {
            $this->data_jml_action_detail = $this->data->get_detail_action($this->id_list);
            $this->data_rcsa_detail       = $this->data->get_id_rcsa_detail($this->id_list);
        }
    }

    public function action_detail()
    {
        $data = array();
        // $post=$this->input->post();
        $id_rcsa                       = intval($this->uri->segment(3));
        $id_action                     = intval($this->uri->segment(4));
        $id_rcsa_detail                = $this->data->get_rcsa_detail_id($id_action);
        $data_tmp                      = $this->data->get_rcsa_id($id_rcsa);
        $id_action_detail              = intval($this->uri->segment(5));
        $data['cbo_level_like']        = $this->get_combo('likelihood');
        $data['cbo_level_impact_baru'] = $this->data->cbo_level_impact_baru($id_rcsa);
        // Doi::dump($data_tmp);die();
        if ($data_tmp) {
            $rcsa_no   = $data_tmp['rcsa_no'];
            $period_no = $data_tmp['period_no'];
            $owner_no  = $data_tmp['owner_no'];
        } else {
            $rcsa_no   = 0;
            $period_no = 0;
            $owner_no  = 0;
        }
        $post                   = array('owner_no' => $owner_no, 'period_no' => $period_no, 'project_no' => $rcsa_no);
        $data['project_no']     = $post['project_no'];
        $data['post']           = $post;
        $data['cbo_project']    = $this->get_combo('project_rcsa', $post);
        $data['judul']          = "Risk Monitoring - Action Plan";
        $data['id_rcsa_detail'] = $id_rcsa_detail;
        $data['id_action']      = $id_action;
        $data['id_rcsa']      	= $id_rcsa;
        $data['id_action_detail']= $id_action_detail;
        $data['type_dash']      = 2;

        $data['cbo_status'] = $this->get_combo('status-action');
        $data['cbo_owner']  = $this->get_combo('parent-input');
        $data['cbo_period'] = $this->get_combo('periode');

        $data['data_tree']  = $this->data->get_tree_list($rcsa_no);
        $data['tree_event'] = $this->load->view('tree_event', $data, true);

        $data['data_action']      = $this->data->get_data_action($id_action);
        $data['data_even_detail'] = $this->data->get_data_event_detail($id_rcsa_detail);
        $data['data_risk_level_control'] = $this->data->get_rist_level_controls();
        $data['data_progress_action']    = $this->data->get_progress_action($id_action);
        $data['data_edit_action']    = $this->data->get_data_action_detail(['id'=>$id_action_detail]);

        //$data['master_level'] = $this->data->get_master_level();

        $data['risk_info']   = $this->load->view('risk_info', $data, true);
        $data['action_info'] = $this->load->view('action_info', $data, true);
        if ($id_action > 0) {
            $data['event_detail'] = $this->load->view('edit_event', $data, true);
        } else {
            $data['event_detail'] = $this->load->view('add_event', $data, true);
        }

        $this->template->build('risk_event_detail', $data);
    }

    public function listBox_STATUS_NO($row, $value)
    {
        if (empty($value)) {
            $value = 1;
        }

        $result = "";
        if (array_key_exists($value, $this->combo_sts)) {
            $result = $this->combo_sts[$value];
        }

        $span   = $row['l_span'];
        $result = '<span class="label label-' . $span . '">' . $result . '</span>';
        return $result;
    }

    public function listBox_PROGRESS($row, $value)
    {
        $value = floatval($value);
        // $jml="";
        // $detail="";
        // if(array_key_exists($row['l_id'], $this->data_jml_action_detail)){
        // $jml="<br/><em>" . $this->data_jml_action_detail[$row['l_id']]."x</em><br/>";
        // $detail='<br/><span class="btn btn-info detail" data-id="'.$row['l_id'].'" style="padding:3px !important;">detail</span>';
        // }
        return $value . '%';
    }

    public function listBox_OWNER_NO($row, $value)
    {
        $cbo_owner = $this->get_combo('owner');
        $values    = json_decode($value);
        $no        = 0;
        $result    = "";
        if (is_array($values)) {
            $result = array();
            foreach ($values as $value) {
                if (array_key_exists($value, $cbo_owner)) {
                    $result[] = ++$no . '. ' . $cbo_owner[$value];
                }

            }
            $result = implode('<br>', $result);
        }
        return $result;
    }

    public function listBox_NAMEX($row, $value)
    {
        $cbo_owner = $this->get_combo('owner');
        $values    = json_decode($value);
        $no        = 0;
        $result    = "";
        if (is_array($values)) {
            $result = array();
            foreach ($values as $value) {
                if (array_key_exists($value, $cbo_owner)) {
                    $result[] = ++$no . '. ' . $cbo_owner[$value];
                }

            }
            $result = implode('<br>', $result);
        }
        return $result;
    }

    public function save_action_detail()
    {
        $post = $this->input->post();
        $result = $this->data->save_action_detail($post);
        if ($result == 0) {
            header('location:' . base_url('progress_action_plan'));
        } else {
            header('location:' . base_url('progress_action_plan/action_detail/' . $post['id_rcsa'] . '/' . $post['id_action']));
        }
    }

    public function get_form_action()
    {
        $data               = $this->input->get();
        $data['cbo_status'] = $this->get_combo('status-action');
		$data['cbo_level_like']        = $this->get_combo('likelihood');
        $data['cbo_level_impact_baru'] = $this->data->cbo_level_impact_baru($data['id']);
        if (intval($data['id']) > 0) {
            $data['data_action'] = $this->data->get_data_action_detail($data);
        } else {
            $data['data_action'] = array('id' => 0, 'action_no' => '', 'progress_date' => date('d-m-Y'), 'description' => '', 'progress' => '', 'notes' => '', 'attach' => array(), 'status_no' => '');
        }

        $result = $this->load->view('edit_action', $data, true);
        echo $result;
    }

    public function get_file()
    {
        $file     = upload_path_relative() . 'action/' . $this->uri->segment(3);
        $basename = basename($file);
        $length   = sprintf("%u", filesize($file));

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $basename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $length);

        ob_clean();
        set_time_limit(0);
        readfile($file);
    }

    public function del_action()
    {
        $id     = $this->input->get('id');
        $result = $this->data->delete_action($id);
        if ($result > 0) {
            $result = "berhasil";
        }

        echo $result;
    }

    public function list_MANIPULATE_PERSONAL_ACTION($tombol, $rows)
    {
        $rcsa_detail_no = $rows['l_rcsa_no'];

        $action_no = '';
        if (array_key_exists($rows['l_id'], $this->data_rcsa_detail)) {
            $action_no = $this->data_rcsa_detail[$rows['l_id']];
        }
        $url              = base_url('progress-action-plan/action-detail/' . $rcsa_detail_no . '/' . $action_no);
        $tombol['edit']   = array();
        $tombol['print']  = array();
        $tombol['view']   = array();
        $tombol['delete'] = array();
        $tombol['detail'] = array("show_id" => false, "default" => true, "url" => $url, "label" => "Detail Mitigasi");
        return $tombol;
    }

    public function AFTER_LIST_RENDER()
    {
        $js = '<script>
			$(document).ready(function() {
			$("#datatables").on("click","span.detail",function(){
				var id=$(this).attr("data-id");
				var data={"id":id};
				var url=base_url + "ajax/get-detail-action";
				loading(true);
				$.ajax({
					type:"POST",
					url:url,
					data:data,
					success:function(msg){
						loading(false);
						$("#general_modal").find(".modal-body").html(msg);
						$("#general_modal").modal("show");
					},
					failed: function(msg){
						loading(false);
						pesan_toastr("Error Load Database","err","Error","toast-top-center");
					},
					error: function(msg){
						loading(false);
						pesan_toastr("Error Load Database","err","Error","toast-top-center");
					},
				});
				return false;
				})
			})
			</script>';

        return $js;
    }

}
