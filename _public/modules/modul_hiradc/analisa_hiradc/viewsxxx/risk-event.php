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
						<tr><td width="30%"><em><?=lang('msg_field_corporate');?></em><br/><div class="ml10 text-danger"><?=$parent['corporate'];?></div></td></tr>
						<tr><td><em><?=lang('msg_field_owner_no');?></em><br/><div class="ml10 text-danger"><?=$parent['name'];?></div></td></tr>
						<tr><td><em><?=lang('msg_field_type');?></em><br/><div class="ml10 text-danger"><?=$parent['tipe'];?></div></td></tr>
						<tr><td><em><?=lang('msg_field_periode');?></em><br/><div class="ml10 text-danger"><?=$parent['periode_name'];?></div></td></tr>
					</table>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<table class="table">
						<tr><td width="30%"><em>Total Aktifitas</em><br/><div class="ml10 text-danger"><?=$parent['corporate'];?></div></td></tr>
						<tr><td><em>Total Mitigasi</em><br/><div class="ml10 text-danger"><?=$parent['name'];?></div></td></tr>
						<tr><td><em>Progress Mitigasi</em><br/><div class="ml10 text-danger"><?=$parent['tipe'];?></div></td></tr>
						<tr><td><em>Tingkat Risiko</em><br/><div class="ml10 text-danger"><?=$parent['periode_name'];?></div></td></tr>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
  
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<a href="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/add/'.$parent['id']);?>" class="btn btn-primary"> Tambah </a>&nbsp;&nbsp;
		<button class="btn btn-success" data-id="<?=$parent['id'];?>" id="cmdRisk_Register"> Risk Register </button>
	</div>
	<aside class="col-md-12 col-sm-12 col-xs-12">
		<section class="x_panel">
			<div class="x_content">
				<div class="table-responsive">
					<table class="display table table-bordered table-striped table-hover" id="tbl_event">
						<thead>
							<tr>
								<th>No.</th>
								<th>Lokasi</th>
								<th>AKTIVITAS/PRODUK/JASA (Based on Process)</th>
								<th>RISIKO K3 AKTUAL & POTENSIAL</th>
								<th>Kondisi</th>
								<th>Tingkat Reisiko</th>
								<th>Status</th>
								<th>Mitigas</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no=0;
							foreach($field as $key=>$row){?>
								<tr>
									<td><?=++$no;?></td>
									<td><?=$row['lokasi'];?></td>
									<td><?=$row['aktifitas'];?></td>
									<td><?=$row['kondisi'];?></td>
									<td><?=$row['score_resiko'];?></td>
									<td><span style="background-color:<?=$row['warna'];?>;color:<?=$row['warna_text'];?>;padding:8px;"><?=$row['tingkat'];?></span></td>
									<td><?=$row['tingkat'];?></td>
									<td class="text-center"><?=$row['jml_mitigasi'];?></td>
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
		loadTable('', 0, 'tbl_event');
	})
</script>