<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	 
	function save_privilege($newid=0,$data=array(), $old_data=array())
	{
		if (isset($data['urut'])){
 				$no=0;
				 foreach ($data['urut'] as $index => $urut) {
					$upd = [
						'id_combo' => $newid,
						'urut' => $urut,
						'parameter' => $data['param'][$index],
						'skala' => $data['skala'][$index],
						'penilaian' => $data['penilaian'][$index]
					];

					$x = $this->db->where('id_combo', $newid)->where('urut', $urut)->get("bangga_index_komposit")->row_array();

						if(intval($x['id']))
						{
							$upd['update_user'] = $this->authentication->get_Info_User('username');
							$where['id'] = $x['id'];
 							$this->crud->crud_data(array('table'=>"bangga_index_komposit", 'field'=>$upd, 'where'=>$where,'type'=>'update'));
						}
						else
						{
							$upd['create_user'] = $this->authentication->get_Info_User('username');
							$this->crud->crud_data(array('table'=>"bangga_index_komposit", 'field'=>$upd,'type'=>'add'));
						}
					}

		 
			} 
		return true;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */