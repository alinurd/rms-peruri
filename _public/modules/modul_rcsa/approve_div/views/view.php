<?php
	// $data=array();
	// if (!array_key_exists('sts_propose',$data)){
		// $data['sts_propose']=-1;
		// $data['id']=0;
	// }
	
	// $disabled = 'disabled';
	// if ($post['project_no']>0)
		// $disabled = '';
	
	// $nilai_kontrak=0;
	// $target_laba=0;
	// if (!$post){
		// if (count($setting['rcsa'])>0){
			// $nilai_kontrak=$setting['rcsa'][0]['nilai_kontrak'];
			// $target_laba=$setting['rcsa'][0]['target_laba'];
		// }
	// }else{
		// if (count($setting['rcsa'])>0){
			// $nilai_kontrak=$setting['rcsa'][0]['nilai_kontrak'];
			// $target_laba=$setting['rcsa'][0]['target_laba'];
		// }
	// }
?>
<section id="main-content">
	<section class="wrapper site-min-height">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
					<li> <a href="<?php echo base_url();?>"> <i class="fa fa-home"></i> <?php echo lang('msg_breadcrumb_home');?></a></li>
					<li><a href="#"><?php echo lang('msg_title');?></a></li>
				</ul>
			</div>
		</div>
		
		<div class="x_panel">
			<div class="row">
				<div class="col-12">
					<div class="x_content">
						<?=$propose;?>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>


<style>
	thead th, tfoot th {
	  font-size: 12px;
	  padding: 5px !important;
	  text-align: center;
	}
	.w150 { width: 150px;  } 
	.w100 { width: 100px;  } 
	.w80 { width: 80px;  } 
	.w50 { width: 50px;  } 
	td ol { padding-left: 10px; width: 300px;}
	td ol li { margin-left: 5px; }
</style>