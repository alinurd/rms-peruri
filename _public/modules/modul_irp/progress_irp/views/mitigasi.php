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
			<div class="x_title">
				<strong><?=$parent['corporate'];?></strong>
				<ul class="nav navbar-right panel_toolbox">
					<li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content" style="overflow-x: auto;">
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
	</div>
</div>
  
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<h3>Daftar Identifikasi Bahaya K3
		<a href="<?=base_url(_MODULE_NAME_REAL_);?>" class="btn btn-default pull-right"> Kembali ke List </a>
		</h3>
	</div>
	<aside class="col-md-12 col-sm-12 col-xs-12">
		<section class="x_panel">
			<div class="x_content">
				<div class="table-responsive">
					<table class="display table table-bordered table-striped table-hover" id="tbl_mitigasi">
						<thead>
							<tr>
								<th>No.</th>
								<th><?=lang('msg_field_bahaya');?></th>
								<th><?=lang('msg_field_aktifitas');?></th>
								<th><?=lang('msg_field_sekarang');?></th>
								<th><?=lang('msg_field_mendatang');?></th>
								<th><?=lang('msg_field_program');?></th>
								<th><?=lang('msg_field_progress');?></th>
								<th><?=lang('msg_tombol_aksi');?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no=0;
							foreach($detail as $key=>$row){?>
								<tr>
									<td><?=++$no;?></td>
									<td><?=$row['bahaya'];?></td>
									<td><?=$row['aktifitas'];?></td>
									<td><?=$row['sekarang'];?></td>
									<td><?=$row['mendatang'];?></td>
									<td><?=$row['program'];?></td>
									<td class="text-center"><?=number_format($row['progress']);?>%</td>
									<td class="text-center"><a href="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/edit/'.$parent['id'].'/'.$row['id']);?>"> <i class="fa fa-pencil"></i> </a></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</aside>
</div>

<script>
	$(function() {
		loadTable('', 0, 'tbl_mitigasi');
		$("#tbl_mitigasi_filter").css('margin-right','5px');
	})
	
</script>
</script>