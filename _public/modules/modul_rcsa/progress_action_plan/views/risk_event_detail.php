<?php
	$disabled = 'disabled';
	if ($post['project_no']>0)
		$disabled = '';
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
				<div class="col-md-12">
					<div class="x_content">
						<div class="row">
							<div class="col-md-12">
								 <?php  //echo form_open_multipart(base_url('dashboard-project'),array('id'=>'dashboard-project'));?>
								<section class="panel">
									<header class="panel-heading">
										Filter
										<span class="tools pull-right">
											<a class="fa fa-chevron-down" href="javascript:;"></a>
										</span>
									</header>
									<div class="panel-body progress-panel">
										<table class="table borderless">
											<tr>
												<td width="15%">Owner Name :</td>
												<td colspan="2">
													<?php echo form_dropdown('owner_no',$cbo_owner,$post['owner_no'],' id="owner_no" class=" form-control select3" style=" width:auto;"');?></td>
												<td width="10%" class="text-center" rowspan="3"> 
													<button class="btn btn-round btn-flat btn-primary <?=$disabled;?>" name="search" value="Simpan" type="button" id="btn_search" data-original-title="" title="" style="min-height:60px;"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_search');?></button>
												</td>
											</tr>
											<tr>
												<td>Period : </td>
												<td><?php echo form_dropdown('period_no',$cbo_period, $post['period_no'],' id="period_no" class=" form-control" style=" width:auto;"');?></td>
											</tr>
											<tr>
												<td>Project Name :</td>
												<td colspan="2">
												<div class="input-group">
												<?php echo form_dropdown('project_no',$cbo_project,$post['project_no'],'id="project_no" class="form-control " style="height:34px;"');?> &nbsp;&nbsp;&nbsp;
												<span id="spinner_param" style="padding-top:1px;vertical-align:middle;"></span>
												</div>
												</td>
											</tr>
										</table>
									</div>
								</section>
								<?php  //echo form_close();?>
							</div>
						</div>
		
						<div class="row">
							<?php echo $tree_event;?>
							<div class="col-md-9">
								 <section class="shadow panel" id='isi_event_detail'>
									 <?php echo $event_detail;?>
								</section>
							</div>
						</div>
						<div class="overlay hide" id="overlay_content">
							<i class="fa fa-refresh fa-spin"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>

<div class="modal fade bs-example-modal-sm" id="id_tambah_data_target" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:80%;margin:20px auto;">
		<div class="modal-content">
			  <div class="modal-body">
				
			  </div>
			  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="proses_select"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_select');?></button>
			  </div>
		  </div>
	  </div>
</div>

<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content modal-question">
      <div class="modal-header"><h4 class="modal-title"><?php echo lang('msg_del_header');?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class="question"><?php echo lang('msg_del_title');?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('msg_del_batal');?></button>
        <button type="button" class="btn btn-danger btn-grad" id="confirm"><?php echo lang('msg_del_hapus');?></button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade bs-example-modal-sm" id="report_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:80%;margin:20px auto;">
		<div class="modal-content">
			  <div class="modal-body">
				
			  </div>
			  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="proses_select"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_select');?></button>
			  </div>
		  </div>
	  </div>
</div>

<script>
	$("li.event").click(function(){
		idedit=$(this).attr('value');
		rcsa=$(this).attr('rcsa');
		url = '<?php echo base_url("progress-action-plan/action-detail");?>';
		url += '/' + rcsa + '/' + idedit;
		// loading(true,'overlay_content');
		window.location = url;
	});
	
	$("span.delete").click(function(){
		var url= $(this).attr('url');
		var ket = Globals.confirm_del_one;
		$('p.question').html(ket);
		$('#confirmDelete').modal('show');
		$('#confirm').on('click', function(){
			// loading(true,'overlay_content');
			window.location.href=url;
		});
	});
	
	
	function add_install_owner(id, nama) {
		$("#owner_name").val(nama);
		$("#owner_no").val(id);
		$('#datatables >tbody').html("");
		$('#report_modal').modal('hide');
	};
	
	function add_install_period(id, nama) {
		$("#period_name").val(nama);
		$("#period_no").val(id);
		$('#datatables >tbody').html("");
		$('#report_modal').modal('hide');
	};
	
	var type_dash = '<?=$type_dash;?>';
	$("#owner_no, #period_no").change(function(){
		var id_owner = $("#owner_no").val();
		var id_period = $("#period_no").val();
		var id=parseFloat(id_owner) + "-" + parseFloat(id_period) + "-" + parseFloat(type_dash);
		$("button#btn-search").addClass('disabled');
		cari_ajax_combo(id, 'spinner_param', 'project_no', 'ajax/get_project_name');
	});
	$("#project_no").change(function(){
		var id_project = $(this).val();
		if (id_project>0)
			$("button#btn-search").removeClass('disabled');
		else
			$("button#btn-search").addClass('disabled');
	});
	
	$("#btn_search").click(function(){
		idedit=$("#project_no").val();
		url = '<?php echo base_url("progress-action-plan/action-detail/");?>';
		url += '/' + idedit;
		
		pesan_toastr('Mohon Tunggu','info','Prosess','toast-top-center');
		// loading(true,'overlay_content');
		window.location = url;
	});
</script>

