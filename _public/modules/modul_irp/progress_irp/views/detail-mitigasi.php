<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-sm-6 panel-heading">
				<h3 style="padding-left:10px;"><?=lang('msg_title');?></h3>
			</div>
			<div class="col-sm-6" style="text-align:right">
				<ul class="breadcrumb">
					<li> <a href="<?=base_url();?>"> <i class="fa fa-home"></i> Home</a></li>
					<li><a href="<?=base_url(_MODULE_NAME_REAL_);?>"><?=_MODULE_NAME_;?></a></li>
					<li><a><?=lang('msg_title');?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<section class="x_panel">
			<section class="x_panel">
				<div class="x_title text-warning">
					<strong>Assesment : <?=$parent['corporate'];?></strong>
					<ul class="nav navbar-right panel_toolbox">
						<li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-down"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content" style="overflow-x: auto;display:none;">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<table class="table">
							<?php
							foreach($asses1 as $row){ ?>
								<tr><td width="30%"><em><?=$row['label'];?></em><br/><div class="ml10 text-warning"><?=$row['content'];?></div></td></tr>
							<?php } ?>
						</table>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<table class="table">
							<?php
							foreach($asses2 as $row){ ?>
								<tr><td width="30%"><em><?=$row['label'];?></em><br/><div class="ml10 text-warning"><?=$row['content'];?></div></td></tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</section>
			
			<section class="x_panel">
				<div class="x_title text-primary">
					<strong>Mitigasi : <?=$parent['corporate'];?></strong>
					<ul class="nav navbar-right panel_toolbox">
						<li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-down"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content" style="overflow-x: auto;display:none;">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<table class="table">
							<?php
							foreach($miti1 as $row){ ?>
								<tr><td width="30%"><em><?=$row['label'];?></em><br/><div class="ml10 text-primary"><?=$row['content'];?></div></td></tr>
							<?php } ?>
						</table>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<table class="table">
							<?php
							foreach($miti2 as $row){ ?>
								<tr><td width="30%"><em><?=$row['label'];?></em><br/><div class="ml10 text-primary"><?=$row['content'];?></div></td></tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</section>
		</section>
	</div>
</div>
  
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		
		<h3>Progress Mitigasi</h3>
	</div>
	<aside class="col-md-12 col-sm-12 col-xs-12">
		<section class="x_panel">
			<section class="x_panel <?=($mitigasi_detail)?'':'hide';?>" id="edit_detail_mitigasi">
				<div class="x_content">
					<span class="btn btn-primary" id="saveMitigasi"> Simpan </span>
					<span class="btn btn-warning" id="addMitigasi"> Tambah </span>
					<span class="btn btn-default" id="closeMitigasi"> Kembali </span>
					<table class="table">
						<?php
						foreach($form_miti as $row){ ?>
							<tr>
								<td width="20%"><?=$row['label'];?></td>
								<td width="5%" class="text-center">:</td>
								<td><?=$row['content'];?></td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</section>
			<section class="x_panel <?=($mitigasi_detail)?'hide':'';?>" id="list_detail_mitigasi">
				<div class="x_content">
					<div class="table-responsive">
						<span class="btn btn-warning" id="addDetailMitigasi"> Tambah </span>
						<a href="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/'.$param[1]);?>" class="btn btn-default" id="backMitigasi"> Kembali </a>
						<hr>
						<table class="display table table-bordered table-striped table-hover" id="tbl_event">
							<thead>
								<tr>
									<th width="5%">No.</th>
									<th width="15%"><?=lang('msg_field_progress_date');?></th>
									<th><?=lang('msg_field_mitigasi_description');?></th>
									<th><?=lang('msg_field_mitigasi_notes');?></th>
									<th width="10%" class="text-center"><?=lang('msg_field_mitigasi_progress');?></th>
									<th width="5%"><?=lang('msg_tombol_aksi');?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no=0;
								foreach($detail as $key=>$row){?>
									<tr>
										<td><?=++$no;?></td>
										<td><?=$row['progress_date'];?></td>
										<td><?=$row['description'];?></td>
										<td><?=$row['notes'];?></td>
										<td class="text-center"><?=number_format($row['progress_detail']);?>%</td>
										<td class="text-center">
											<i class="fa fa-pencil pointer text-primary editMitigasi" data-id="<?=$row['id_edit'];?>"></i>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</section>
	</aside>
</div>

<script>
	$(function() {
		loadTable('', 0, 'tbl_event');
		$("#tbl_event_filter").css('margin-right','10px');
	})
</script>