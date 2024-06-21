<?php
	$data_detail=$data_risk_detail[0];
?>
	<div id="content_detail">
	<table class="table table-condensed no-margin-bottom" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td class="row-title no-border latar-risk">
					<?php echo lang('msg_field_risk_event');?>
				</td>
				<td class=" no-border">
					<div class="input-group w100">
					<?php 
						echo form_textarea("risk_event", $data_detail['event_no'][0]['name']," class='form-control text-left' rows='2' readonly='' cols='5' style='overflow: hidden; width: 90% !important; height: 100px;' id='risk_event' ")."&nbsp;&nbsp;&nbsp;";
					?>
					</div>
				</td>
			</tr>
			<tr>
				<td class="row-title no-border latar-risk">
					<?php echo lang('msg_field_risk_impact');?>
				</td>
				<td class=" no-border">
					<div class="input-group w100">
					<?php 
						$i=0;
						$impact=array();
						if(count($data_detail['risk_impact_no'])>0){
							foreach($data_detail['risk_impact_no'] as $row){
								$impact[]=$row['name'];
							}
						}
						$impact=implode("\n",$impact);
						echo form_textarea("risk_event", $impact," class='form-control text-left' readonly='' rows='2' cols='5' style='overflow: hidden; width: 90% !important; height: 100px;' id='risk_event' ")."&nbsp;&nbsp;&nbsp;";
					?>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="no-margin no-padding" id="content_action">
					<span class="pull-right"> 
						<button class="add btn btn-primary btn-flat" data-content="Add New Action" data-toggle="popover" id="add_action" value="0">
							<i class="fa fa-plus"></i> <?php echo lang('msg_field_add_action');?>
						</button>
					</span>
					<div class="well" style="background-color:#FBFBFB;border:none;">
					<table class="table" id="datatables">
						<thead>
							<tr>
							<th width="10%" style="text-align:center;">No.</th>
							<!-- <th width="35%" ><?php echo lang('msg_field_action_plan_title');?></th> -->
							<th width="25%" ><?php echo lang('msg_field_proaktif');?></th>
							<th width="25%" ><?php echo lang('msg_field_reaktif');?></th>
							<th width="10%" ><?php echo lang('msg_create_stamp');?></th>
							<th width="10%" ><?php echo lang('msg_update_stamp');?></th>
							<th width="35%" ><?php echo lang('msg_tbl_edit');?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							foreach($data_risk_action as $row){ 
								?>
								<tr>
									<td style="text-align:center;width:10%;"><?php echo ++$i;?></td>
									<td style="width:25%;"> <?php echo $row['proaktif'];?></td>
									<td style="width:25%;"> <?php echo $row['reaktif'];?></td>
									<td style="width:15%;"> <?php echo $row['create_date'];?></td>
									<td style="width:15%;"> <?php echo $row['update_date'];?></td>
									<td style="text-align:center;width:10%;cursor:pointer;"><i class="fa fa-pencil edit_action" title="Edit data Action" value="<?php echo $row['id'];?>"></i> | <i url="<?php echo base_url('project/delete-action/'.$id_rcsa.'/'.$id_event_detail.'/'.$row['id']);?>" class="fa fa-cut" title="Delete data" id="delete_list_action"></i></td>
								</tr>
								<?php 
							}
							?>
						</tbody>
					</table>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<hr>
	<div class="box-body">
		<span class="pull-right" style="padding-right:20px;"> 
			<span class="next btn btn-success btn-flat" value='Back'>
			<i class="fa fa-plus"></i> <?php echo lang('msg_tbl_back');?>
			</span>
		</span>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		loadTable();
		
		$(".edit_action, #add_action").click(function(){
			var nil=$(this).attr("value");
			var url='<?php echo base_url("project/get_input_action");?>';
			var rcsa='<?php echo $id_rcsa;?>';
			var event_detail='<?php echo $id_event_detail;?>';
			
			var form={'id':nil,'rcsa':rcsa,'event_detail':event_detail};
			$.ajax({
				type: "GET",
				url: url,
				data:form,
				success: function(msg){
					$('td#content_action').html(msg);
				},
				failed: function(msg){
					alert("gagal");
				},
				error: function(msg){
					alert("gagal");
				},
			});
		});
	})
	
	$("i#delete_list_action").on("click", null, function(){
		var url= $(this).attr('url');
		var ket = Globals.confirm_del_one;
		$('p.question').html(ket);
		$('#confirmDelete').modal('show');
		$('#confirm').on('click', function(){
			window.location.href=url;
		});
    });
</script>