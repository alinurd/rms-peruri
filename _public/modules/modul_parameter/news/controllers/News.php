<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class News extends BackendController {
	public function __construct() {
        parent::__construct();
		$this->set_Tbl_Master(_TBL_NEWS);
		
		$this->set_Open_Tab('Data Risk Event Library');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'title', 'size'=>50));
		$this->addField(array('field' => 'photo', 'input' => 'upload', 'path' => 'news', 'file_type' => 'img', 'file_random' => false));

			// $this->addField(array('field'=>'photo', 'size'=>100));
			$this->addField(array('field'=>'content', 'input'=>'html', 'size'=>500));
			// $this->addField(array('field'=>'sticky', 'input'=>'boolean', 'size'=>20));
			$this->addField(array('field'=>'status', 'input'=>'boolean', 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_master,'title');
		// $this->set_Table_List($this->tbl_master,'sticky','','','','center');
		$this->set_Table_List($this->tbl_master,'status','','','','center');
		
		$this->set_Close_Setting();
		
		$js= script_tag(plugin_url("ckeditor/ckeditor.js"));
		$js .= '<script> 
				var url = "'.base_url().'";
				CKEDITOR.replace("l_content",
				{ 
					toolbar : "Full", /* this does the magic */
					uiColor : "#9AB8F3"
				});
		</script>';
		$this->template->append_metadata($js);
	}
	
	function listBox_STICKY($row, $value){
		if ($value=='1')
			$result='<span class="label label-success"> '.lang('msg_cbo_yes').'</span>';
		else
			$result='<span class="label label-warning"> '.lang('msg_cbo_no').'</span>';
		
		return $result;
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$result = $this->data->save_uri_title($id , $new_data);
		
		// $this->simpan_photo($data, $id);
		$data['email']='tri.untoro@gmail.com';
		$data['subject']='Pendaftaran Layanan pada Sirima ';
		$data['content']=nl2br($new_data['content']);
		$status=Doi::kirim_email($data);
		
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data){
		$result = $this->data->save_uri_title($id , $new_data);
		// $this->simpan_photo($new_data, $id);
		
		$data['email']='tri.untoro@gmail.com';
		$data['subject']='Pendaftaran Layanan pada Sirima ';
		$data['content']=nl2br($new_data['content']);
		$status=Doi::kirim_email($data);
		
		return $result;
	}
	
	function simpan_photo($data, $id){
		$files = $_FILES;
		$post = $this->input->post();
		// Doi::dump($files);
		if ($files){
			$cpt = count($_FILES['file_upload']['name']);
			if ($cpt>0){
				$hasil=array();
				$awal=-1;
				for($i=0; $i<$cpt; $i++)
				{
					$upd=array();
					if (!empty($_FILES['file_upload']['name'][$i])){
						++$awal;
						$nmFile = $files['file_upload']['name'][$i];
						$_FILES['userfile']['name']= $files['file_upload']['name'][$i];
						$_FILES['userfile']['type']= $files['file_upload']['type'][$i];
						$_FILES['userfile']['tmp_name']= $files['file_upload']['tmp_name'][$i];
						$_FILES['userfile']['error']= $files['file_upload']['error'][$i];
						$_FILES['userfile']['size']= $files['file_upload']['size'][$i]; 
						// Doi::dump($_FILES['userfile']);
						$upload=upload_image_new(array('nm_file'=>'userfile', 'size'=>10000000, 'path'=>'news','thumb'=>true, 'type'=>'*'), TRUE, $awal);
						// Doi::dump($upload);
						if($upload){
							
							$upd['nama']=$upload['file_name'];
							$upd['judul']=$nmFile;
							$upd['size']=$upload['file_size'];
						}
					}elseif(!empty($post['judul'][$i])){
						$upd['nama']=$post['nama'][$i];
						$upd['judul']=$post['judul'][$i];
						$upd['size']=$post['size'][$i];
						}
					$hasil[]=$upd;
				}
				if ($hasil){
					$latar=json_encode($hasil);
					$this->crud->crud_data(array('table'=>_TBL_NEWS, 'field'=>array('photo'=>$latar), 'where'=>array('id'=>$id),'type'=>'update'));
				}
			}
		}
	}
	
	// function insertBox_PHOTO($field){
	// 	$o = '<table class="table">';
	// 	$o .= '<tr><td>'.form_upload("file_upload[]").form_hidden(['judul[]'=>'', 'nama[]'=>'', 'size[]'=>'']).'</td></tr>'; 
	// 	$o .= '</table>';
		
	// 	return $o;
	// }
	
	// function updateBox_PHOTO($field, $rows, $value){
	// 	$rows = json_decode($value, true);
	// 	$o = '<table class="table">';
	// 	$x=0;
	// 	if ($rows){
	// 		foreach($rows as $row){
	// 			// Doi::dump($row);die();
	// 			if (!empty($row)){
	// 				$o .= '<tr><td>'.show_image($row['nama'],60, 0, 'news').form_hidden(['judul[]'=>$row['judul'], 'nama[]'=>$row['nama'], 'size[]'=>$row['size']]).'<span class="hide">'.form_upload("file_upload[]").'</span></td></tr>';
	// 				++$x;
	// 			}
	// 		}
	// 	}
		
	// 	for($i=$x;$i<=5;++$i){
	// 		$o .= '<tr><td>'.form_upload("file_upload[]").form_hidden(['judul[]'=>'', 'nama[]'=>'', 'size[]'=>'']).'</td></tr>';
	// 	}
	// 	$o .= '</table>';
		
	// 	return $o;
	// }
	
}