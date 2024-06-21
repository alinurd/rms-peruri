
<div class="row" style="margin-bottom:25px;">
	<a href="<?=base_url('propinsi');?>">
	<div class="col-md-2 col-sm-4 col-xs-8 hvr-float-shadow pointer rekap" target="propinsi">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
			<div class="info-box-content">
				<span class="info-box-text"><?=lang('msg-field-provinsi');?></span>
				<span class="info-box-number pull-right"><?=number_format($statistik['propinsi']);?></span>
			</div>
		</div>
	</div>
	</a>
	<a href="<?=base_url('kota');?>">
	<div class="col-md-2 col-sm-4 col-xs-8 hvr-float-shadow pointer rekap" target="kota">
		<div class="info-box">
			<span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline"></i></span>
			<div class="info-box-content">
				<span class="info-box-text"><?=lang('msg-field-kab');?></span>
				<span class="info-box-number pull-right"><?=number_format($statistik['kota']);?></span>
			</div>
		</div>
	</div>
	</a>
	<a href="<?=base_url('kecamatan');?>">
	<div class="col-md-2 col-sm-4 col-xs-8 hvr-float-shadow pointer rekap" target="kecamatan">
		<div class="info-box">
			<span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
			<div class="info-box-content">
				<span class="info-box-text"><?=lang('msg-field-kecamatan');?></span>
				<span class="info-box-number pull-right"><?=number_format($statistik['distrik']);?></span>
			</div>
		</div>
	</div>
	</a>
	<a href="<?=base_url('puskesmas');?>">
	<div class="col-md-2 col-sm-4 col-xs-8 hvr-float-shadow pointer rekap" target="puskesmas">
		<div class="info-box">
			<span class="info-box-icon bg-yellow"><i class="ion ion-ios-gear-outline"></i></span>
			<div class="info-box-content">
				<span class="info-box-text"><?=lang('msg-field-puskesmas');?></span>
				<span class="info-box-number pull-right"><?=number_format($statistik['puskesmas']);?></span>
			</div>
		</div>
	</div>
	</a>
	<a href="<?=base_url('analisa');?>">
	<div class="col-md-2 col-sm-4 col-xs-8 hvr-float-shadow pointer rekap" target="dashbard/rekap">
		<div class="info-box">
			<span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline"></i></span>
			<div class="info-box-content">
				<span class="info-box-text"><?=lang('msg-field-alert');?></span>
				<span class="info-box-number pull-right">10</span>
			</div>
		</div>
	</div>
	</a>
	<a href="<?=base_url('analisa');?>">
	<div class="col-md-2 col-sm-4 col-xs-8 hvr-float-shadow pointer rekap" target="entri-penyakit">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
			<div class="info-box-content">
				<span class="info-box-text"><?=lang('msg-field-lap');?></span>
				<span class="info-box-number pull-right"><?=_TAHUN_.' / '._MINGGU_;?></span>
			</div>
		</div>
	</div>
	</a>
</div><!-- /.row -->

<div class="row">
	<div class="col-sm-6">
		<div class="box box-primary box-solid height-400">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-th"></i> <?=lang('msg-tab-puskesmas-alert');?></h3>
				<div class="box-tools pull-right">
					<span class="btn" id="refresh_alert_puskesmas"><i class="fa fa-refresh"></i></span>
					<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">										
				<canvas id="bar-chart-alert-puskesmas" width="800" height="380"></canvas>
			</div>
		</div>
	</div>

	<div class="col-sm-6">
		<div class="box box-info box-solid height-400">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-th"></i> <?=lang('msg-tab-puskesmas-map');?></h3>
				<div class="box-tools pull-right">
					<span class="btn" id="refresh_map_puskesmas"><i class="fa fa-refresh"></i></span>
					<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body" id="content_map_puskesmas">
				<?php echo $maps_puskesmas['map_puskesmas']['js']; ?>
				<?php echo $maps_puskesmas['map_puskesmas']['html'];?>
			</div>
		</div>
	</div>

	<div class="col-sm-6">
		<div class="box box-warning box-solid height-400">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-th"></i> <?=lang('msg-tab-puskesmas-lengkap');?></h3>
				<div class="box-tools pull-right">
					<span class="btn" id="refresh_lengkap_puskesmas"><i class="fa fa-refresh"></i></span>
					<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<canvas id="bar-chart-lengkap-puskesmas" width="800" height="380"></canvas>
			</div>
		</div>
	</div>

	<div class="col-sm-6">
		<div class="box box-success box-solid height-400">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-th"></i> <?=lang('msg-tab-puskesmas-tepat');?></h3>
				<div class="box-tools pull-right">
					<span class="btn" id="refresh_tepat_puskesmas"><i class="fa fa-refresh"></i></span>
					<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<canvas id="bar-chart-tepat-puskesmas" width="800" height="380"></canvas>
			</div>
		</div>
	</div>
</div>
					
<script>
	var mode="puskesmas";
</script>
<!--welcome container end-->

<!--welcome container end-->
