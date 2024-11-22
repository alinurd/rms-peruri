<div class="row">
  <aside class="profile-info col-md-12 col-sm-12 col-xs-12">
	  <section class="panel">
		  <div class="panel-body bio-graph-info" style="overflow-x: auto;">
			  <h1><strong><?php echo lang('msg_field_progress_mitigasi');?></strong></h1>
				  <table class="display table table-bordered table-striped dataTable table-hover" id="datatables_dashboard">
				  <thead>
					<tr>
						<th>No.</th>
						<th>Create Date</th>
						<!-- <th><?php echo lang('msg_field_module');?></th> -->
					   	<th>Judul Assesment</th>
						<th>Proaktif</th>
						<th>Reaktif</th>
						<th><?php echo lang('msg_field_pic');?></th>
						<th><?php echo lang('msg_field_status');?></th>
						<!-- <th><?php echo lang('msg_field_action');?></th> -->
					</tr>
				  </thead>
				  <tbody>
				  <?php 
					$i=1;
					$jmlaction=0;
					foreach($action as $row){
						if ($row->progress<=30){ $warna="danger";
						}elseif ($row->progress<=50){ $warna="warning";
						}elseif ($row->progress<=75){ $warna="success";
						}else{
							$warna="primary";
						}
						$values=json_decode($row->owner_no);
						$owner_name=array();
						$no=0;
						if($values){
							foreach($values as $value){
								if (array_key_exists($value, $cbo_owner))
									$owner_name[] = ++$no . '. ' . $cbo_owner[$value];
							}
							$owner_name = implode('<br>',$owner_name);
						}else{
							$owner_name='';
						}
						
						$progress='';
						if (intval($row->progress)>0)
							$progress=number_format($row->progress).'%';
						
						$span = $row->span;
						$status = '<span class="label label-'.$span.'">'.$row->status_action.'</span>';
					?>
						<tr>
						  <td><?php echo $i++;?></td>
						  <td><?php echo $row->create_date;?></td>
						  <td><?php echo $row->judul_assesment;?></td>
						  <td><?php echo $row->proaktif;?></td>
						  <td><?php echo $row->reaktif;?></td>
						  <td><?php echo $owner_name;?></td>
						  <td><?php echo $status;?></td>
		<!-- 				  <td class="text-center">
						  	<a href="<?php echo base_url('progress-action-plan/action-detail/'.$row->id_rcsa.'/'.$row->id);?>" data-toogle="tooltip" title="Edit Progres" target="_blank">
						  		<?php echo lang('msg_input_view');?>
						  	</a>
						  </td> -->
						</tr>
					<?php
					$jmlaction++;
					}
				  ?>
				  </tbody>
			  </table>
			  <script type="text/javascript">
			  	// $(document).ready(function(){
				    $('[data-toggle="tooltip"]').tooltip(); 
				// });
			  </script>
			   <?php //doi::dump($this->authentication->get_info_user('param_level'));
				// doi::dump($this->authentication->get_info_user('group'));
				// doi::dump($this->authentication->get_info_user('id_param_level'));?>
		  </div>
	  </section>
  </aside>
</div>