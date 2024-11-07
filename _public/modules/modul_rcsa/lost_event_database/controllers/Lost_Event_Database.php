<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lost_Event_Database extends BackendController
{
    var $type_risk = 0;
    var $table = "";
    var $post = array();
    var $sts_cetak = false;

    public function __construct()
    {
        // Set required symbol for required fields
        $this->required = '<sup><span class="required"> *) </span></sup> ';
        
        parent::__construct();
        // Initialize combo box options
        $this->cbo_status_action  = $this->get_combo('status-action');
        $this->cbo_parent         = $this->get_combo('parent-input');
        $this->cbo_owner          = $this->get_combo('owner');
        $this->cbo_judul_assesment = $this->get_combo('judul_assesment');
        $this->cbo_loss           = [1 => 'Ya', 0 => 'Tidak'];
        $this->cbo_periode        = $this->get_combo('periode');
        $this->cboLike            = $this->get_combo('likelihood');
        $this->cboImpact          = $this->get_combo('impact');
    }
 
    // ==========================================
    // Method: index
    // Description: Main page for displaying loss event database
    // ==========================================
    public function index() {
        $start_time = microtime(true);
        $page       = $this->input->get('page') ?: 1;
        $limit      = 10;

        // Retrieve filter inputs
        $data['periode']   = $this->input->get('periode');
        $user_info         = $this->authentication->get_info_user();
        $own               = $user_info['group']['owner']['owner_no'];

        
        
        if ($this->input->get('owner')) {
            $own = $this->input->get('owner');
        }

        if ($this->input->get('judul_assesment')) {
            $judul_assesment = $this->input->get('judul_assesment');
        }

        
        $data['owner']             = $own;
        $data['judul_assesment']   = $judul_assesment;
        
        // Pagination calculations  
        $total_data       = $this->data->count_all_data($data);
        $total_pages      = ceil($total_data / $limit);
        $offset           = ($page - 1) * $limit;
        
        // Page data to send to view
        $x['total_data']   = $total_data;
        $x['start_data']   = $offset + ($total_data > 0 ? 1 : 0);
        $x['end_data']     = min($offset + $limit, $total_data);
        $x['cboPeriod']    = $this->cbo_periode;
        $x['cboOwner']     = $this->cbo_parent;
        // $x['judulAssesment'] = $this->cbo_judul_assesment;
        $x['judulAssesment']    = $this->get_combo('judul_assesment_new',$own);
        $x['field']             = $this->data->getDetail($data, $limit, $offset);

        // Generate pagination
        $x['pagination'] = $total_data > 0 ? $this->pagination($data, $total_pages, $page) : '';

        // Calculate execution time and load template
        $end_time = microtime(true);
        $x['timeLoad'] = round($end_time - $start_time, 2);
        $this->template->build('home', $x);
    }
    
    // ==========================================
    // Method: pagination
    // Description: Generates pagination links based on data filters
    // ==========================================
    function pagination($data, $total_pages, $page) {
        $pagination = '';
        $post = '';
        
        // Append filter parameters
        if (!empty($data['periode'])) {
            $post .= '&periode=' . $data['periode'];
        }
        if (!empty($data['owner'])) {
            $post .= '&owner=' . $data['owner'];
        }
        if (!empty($data['judul_assesment'])) {
            $post .= '&judul_assesment=' . $data['judul_assesment'];
        }
    
        if ($total_pages > 1) {
            $pagination .= '<ul class="pagination">';
            
            // First page link if beyond first few pages
            if ($page > 4) {
                $pagination .= '<li><a href="' . site_url('lost_event_database/index?page=1' . $post) . '">First</a></li>';
            }
            
            // Previous pages
            for ($i = max(1, $page - 3); $i < $page; $i++) {
                $pagination .= '<li><a href="' . site_url('lost_event_database/index?page=' . $i . $post) . '">' . $i . '</a></li>';
            }
            
            // Current page
            $pagination .= '<li class="active"><span>' . $page . '</span></li>';
            
            // Next pages
            for ($i = $page + 1; $i <= min($page + 3, $total_pages); $i++) {
                $pagination .= '<li><a href="' . site_url('lost_event_database/index?page=' . $i . $post) . '">' . $i . '</a></li>';
            }
            
            // Last page link if not near end
            if ($page < $total_pages - 3) {
                $pagination .= '<li><a href="' . site_url('lost_event_database/index?page=' . $total_pages . $post) . '">Last</a></li>';
            }
            
            $pagination .= '</ul>';
        }
        
        return $pagination;
    }

    // ==========================================
    // Method: get_detail_modal
    // Description: Loads modal form data for adding/editing a lost event
    // ==========================================
    public function get_detail_modal() {

        $id                 = $this->input->post("id_edit");
        $type               = $this->input->post("type");
        $param              = $this->input->post("rcsa");
        $data['rcsa_no']    = $this->input->post("rcsa");
        $data['cboLike']    = $this->cboLike;
        $data['cboImpact']  = $this->cboImpact;
        $data['kategori_kejadian'] = $this->get_combo('data-combo', 'kat-kejadian');
        $data['frekuensi_kejadian'] = $this->get_combo('data-combo', 'frek-kejadian');
        $data['kat_risiko'] = $this->get_combo('data-combo', 'kel-library');
        $data['type']       = 'add';
    
        // If editing, load existing data
        if ($type === "edit") {
            $detailedit = $this->db->where('id', $id)->get(_TBL_RCSA_LOST_EVENT)->row_array();
            $this->db->select([
                'a.rcsa_no AS rcsa_no',
                'a.id AS id_loss_event',
                'YEAR(a.create_date) AS tahun',
                'b.name AS name',
                'd.description AS event_name',
                'b.judul_assesment AS judul_assesment',
                'b.owner_no AS owner_no'
            ])
            ->from('bangga_rcsa_lost_event a')
            ->join('bangga_view_rcsa b', 'a.rcsa_no = b.id', 'inner')
            ->join('bangga_library d', 'a.event_no = d.id', 'inner')
            ->join('bangga_data_combo h', 'a.kategori = h.id', 'left')
            ->join('bangga_data_combo j', 'a.kat_risiko = j.id', 'left');
            
            $query = $this->db->get();
            $result = $query->result_array();
            
            $data_event = $this->db->where('id_loss_event', $id)->get(_TBL_VIEW_RCSA_LOST_EVENT)->row_array();
            $param              = $detailedit['rcsa_no'];
            $data['lost_event'] = $detailedit;
            $data['data_event'] = $data_event;
            $data['type'] = 'edit';

            // Load risk level labels
            $row_in  = $this->db->where('impact_no', $detailedit['skal_prob_in'])->where('like_no', $detailedit['skal_dampak_in'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
            $row_res = $this->db->where('impact_no', $detailedit['target_res_prob'])->where('like_no', $detailedit['target_res_dampak'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();

            $data['label_in'] = "<span style='background-color:" . $row_in['warna_bg'] . ";color:" . $row_in['warna_txt'] . ";'>&nbsp;" . $row_in['tingkat'] . "&nbsp;</span>";
            $data['label_res'] = "<span style='background-color:" . $row_res['warna_bg'] . ";color:" . $row_res['warna_txt'] . ";'>&nbsp;" . $row_res['tingkat'] . "&nbsp;</span>";
        }        
        $data['cboper']     = $this->get_combo('rcsa_detail', $param);
        
        $result['register'] = $this->load->view('form_modal', $data, true);
        echo json_encode($result);
    }

    // ==========================================
    // Method: level_action
    // Description: Retrieves level information for risk assessment
    // ==========================================
    public function level_action($like, $impact) {
        $result['like'] = $this->db->where('id', $like)->get('bangga_level')->row_array();
        $result['impact'] = $this->db->where('id', $impact)->get('bangga_level')->row_array();

        return $result;
    }

    // ==========================================
    // Method: cek_level
    // Description: Checks and returns level information based on likelihood and impact
    // ==========================================
    function cek_level() {
        $post = $this->input->post();
        $rows = $this->db->where('impact_no', $post['impact'])->where('like_no', $post['likelihood'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();

        $result['level_text'] = '-';
        $result['level_no'] = 0;
        $result['level_resiko'] = '-';

        // Set level data if found
        if ($rows) {
            $result['level_text'] = "<span style='background-color:" . $rows['warna_bg'] . ";color:" . $rows['warna_txt'] . ";'>&nbsp;" . $rows['tingkat'] . "&nbsp;</span>";
            $result['level_no'] = $rows['id'];
            $result['level_name'] = $rows['tingkat'];

            // Set risk treatment based on level
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

    // ==========================================
    // Method: simpan_lost_event
    // Description: Saves loss event data to the database
    // ==========================================
    function simpan_lost_event() {
        $post = $this->input->post();     
        $id = $this->data->simpan_lost_event($post);
        echo json_encode($post);
    } 

    public function get_mitigasi() {
        $post   = $this->input->post("id_detail"); 
        $hasil = $this->db->select('bangga_rcsa_action.proaktif AS proaktif, bangga_rcsa_detail.event_no AS event_no')
        ->from('bangga_rcsa_action')
        ->join('bangga_rcsa_detail', 'bangga_rcsa_action.rcsa_detail_no = bangga_rcsa_detail.id', 'left') // ganti sesuai kondisi join (inner, left, right)
        ->where('bangga_rcsa_action.rcsa_detail_no', $post)
        ->get()
        ->row_array();


        echo json_encode($hasil);
    }


    public function get_judul_assesment(){
        $owner_no = $this->input->post("owner_no"); 
        $tahun = $this->input->post("tahun"); 
        $hasil = $this->get_combo('judul_assesment_new', $owner_no,$tahun);
    
        // Array untuk menyimpan <option>
        $options = '';
        foreach ($hasil as $key => $value) {
            $selected = ($this->input->get('judul_assesment') == $key) ? 'selected' : '';
            $options .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
        }
    
        echo json_encode(['options' => $options]);
    }


    public function delete_data(){
        $id = $this->input->post("id");
        $this->db->where('id', $id);
        $res =  $this->db->delete('bangga_rcsa_lost_event');
        echo json_encode($res);
        // exit;
    }
    
    
}

/* End of file Lost_Event_Database.php */
/* Location: ./application/controllers/Lost_Event_Database.php */
