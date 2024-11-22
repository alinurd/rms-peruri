<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	 
		
	function save_privilege($newid=0, $data=array(), $old_data=array())
    {

        // doi::dump($data);
        // die;
        $upd = [
            'judul'         => $data['l_judul'],
            'periode'       => $data['l_periode'],
            'semester'      => $data['l_semester'],
            'urut'          => $data['l_urut'],
            'status'        => $data['l_status']
        ];

        $x = $this->db->where('id', $newid)->get("bangga_indikator_stress_test")->row_array();     

        if(intval($x['id'])){
            $where = ['id' => $x['id']];
            $upd['update_user'] = $this->authentication->get_Info_User('username');
            $this->crud->crud_data(array('table' => "bangga_indikator_stress_test", 'field' => $upd, 'where' => $where, 'type' => 'update'));
            $id =$x['id'];
        }else{
            $upd['create_user'] = $this->authentication->get_Info_User('username');
            $this->crud->crud_data(array('table' => "bangga_indikator_stress_test", 'field' => $upd, 'type' => 'add'));
            $id = $this->db->insert_id();
        }

        if (isset($data['urut'])) {
            // Menghapus data detail yang tidak termasuk dalam daftar ID yang dikirim dari frontend
            if (isset($data['detail_edit']) && is_array($data['detail_edit'])) {
                // Hapus semua detail dengan id_parent yang sama, kecuali yang ada dalam `detail_edit`
                $this->db->where('id_parent', $id);
                $this->db->where_not_in('id', $data['detail_edit']);
                $this->db->delete('bangga_indikator_stress_test_detail');
            }
            $no = 0;
            foreach ($data['urut'] as $index => $urut) {
                $updd = [
                    'id_parent'     => $id,
                    'urut'          => $urut,
                    'parameter'     => $data['param'][$index],
                    'rkap'          => $data['rkap'][$index],
                    'satuan'        => $data['satuan'][$index],
                    'kurang'        => $data['kurang'][$index],
                    'sama'          => $data['sama'][$index],
                    'lebih'         => $data['lebih'][$index],
                    'color_kurang'        => $data['color_kurang'][$index],
                    'color_sama'          => $data['color_sama'][$index],
                    'color_lebih'         => $data['color_lebih'][$index]
                ];


                
                

                if($data['detail_edit'][$index]){
                    $where = ['id' => $data['detail_edit'][$index]];
                    $upd['update_user'] = $this->authentication->get_Info_User('username');
                    $this->crud->crud_data(array('table' => "bangga_indikator_stress_test_detail", 'field' => $updd, 'where' => $where, 'type' => 'update'));
                }else{
                    $updd['create_user'] = $this->authentication->get_Info_User('username');
                    $this->crud->crud_data(array('table' => "bangga_indikator_stress_test_detail", 'field' => $updd, 'type' => 'add'));
                    
                }

                
            }

        }

        return true;
    }

}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */

        