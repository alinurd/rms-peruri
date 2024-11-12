<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	 
		
	function save_privilege($newid=0, $data=array(), $old_data=array())
    {

    doi::dump($data);
    $upd = [
        'judul'         => $data['l_judul'],
        'periode'       => $data['l_periode'],
        'semester'      => $data['l_semester'],
        'status'        => $data['l_status']
    ];

    if (isset($data['urut'])) {
        $no = 0;
        foreach ($data['urut'] as $index => $urut) {
            $updd = [
                'id_parent'     => $newid,
                'urut'          => $urut,
                'parameter'     => $data['param'][$index],
                'rkap'          => $data['rkap'][$index],
                'satuan'        => $data['satuan'][$index],
                'kurang'        => $data['kurang'][$index],
                'sama'          => $data['sama'][$index],
                'lebih'         => $data['lebih'][$index]
            ];

            $updd['create_user'] = $this->authentication->get_Info_User('username');
            $this->crud->crud_data(array('table' => "bangga_indikator_stress_test_detail", 'field' => $updd, 'type' => 'add'));
            $id = $this->db->insert_id(); 
        }

    }

      return true;
}

}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */