<div class="welcome-sec" style="padding-top:0px !important;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="weltext awal">
					<section class="content">
						<div class="row" style="margin-bottom:25px;">
							<a href="<?=base_url('propinsi');?>">
							<div class="col-md-2 col-sm-4 col-xs-8 hvr-float-shadow pointer rekap" target="propinsi">
								<div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Provinsi</span>
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
										<span class="info-box-text">Kab/Kota</span>
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
										<span class="info-box-text">Kecamatan</span>
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
										<span class="info-box-text">Puskesmas</span>
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
										<span class="info-box-text">Alert</span>
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
										<span class="info-box-text">Lap. Minggu</span>
										<span class="info-box-number pull-right"><?=_TAHUN_.' / '._MINGGU_;?></span>
									</div>
								</div>
							</div>
							</a>
						</div><!-- /.row -->
						
						<div class="row">
							<div class="col-sm-6">
								<div class="box box-info box-solid height-400">
									<div class="box-header with-border">
										<h3 class="box-title"><i class="fa fa-th"></i> Peringatan Dini</h3>
										<div class="box-tools pull-right">
											<span class="btn" id="refresh_alert"><i class="fa fa-refresh"></i></span>
											<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
										</div>
									</div>
									<div class="box-body">										
										<canvas id="bar-chart-alert-rs" width="800" height="380"></canvas>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="box box-info box-solid height-400">
									<div class="box-header with-border">
										<h3 class="box-title"><i class="fa fa-th"></i> Update Hasil Verifikasi Peringatan Dini</h3>
										<div class="box-tools pull-right">
											<span class="btn" id="refresh_map"><i class="fa fa-refresh"></i></span>
											<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
										</div>
									</div>
									<div class="box-body" id="content_map_rs">
										<?php echo $maps_rs['map_rs']['js']; ?>
										<?php echo $maps_rs['map_rs']['html'];?>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="box box-info box-solid height-400">
									<div class="box-header with-border">
										<h3 class="box-title"><i class="fa fa-th"></i> Kelengkapan</h3>
										<div class="box-tools pull-right">
											<span class="btn" id="refresh_lengkap"><i class="fa fa-refresh"></i></span>
											<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
										</div>
									</div>
									<div class="box-body">
										<canvas id="bar-chart-lengkap-rs" width="800" height="380"></canvas>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="box box-info box-solid height-400">
									<div class="box-header with-border">
										<h3 class="box-title"><i class="fa fa-th"></i> Ketepatan</h3>
										<div class="box-tools pull-right">
											<span class="btn" id="refresh_tepat"><i class="fa fa-refresh"></i></span>
											<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
										</div>
									</div>
									<div class="box-body">
										<canvas id="bar-chart-tepat-rs" width="800" height="380"></canvas>
									</div>
								</div>
							</div>
						</div>
					</section><!-- /.content -->				
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var mode="awal";
</script>
<!--welcome container end-->

<!--welcome container end-->


