<section id="main-content">
	<section class="wrapper">
		<div class="x_panel">
			<div class="row">
				<div class="col-md-12">
					 <section class="x_panel">
					 <div class="x_content progress-panel">
						<div class="task-progress">
							<span style="color:black;"><strong><?=$judul ;?></strong></span>
						</div>
					</div>
					</section>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="x_panel">
						<div class="x_content">
							<div class="row">
								<?php echo $tree_event;?>
								<div class="col-md-9">
									 <section class="x_panel" id='isi_event_detail' style="border:1px solid #2A3542;">
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
		</div>
	</section>
</section>

<div class="modal fade modal-default modal-full-screen" id="id_tambah_data_target"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog fullscreen">
		<div class="modal-content fullscreen">
			  <div class="modal-body">
				
			  </div>
			  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="proses_select"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_select');?></button>
			  </div>
			  <div class="overlay hide" id="overlay_content_modal">
					<i class="fa fa-refresh fa-spin"></i>
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

