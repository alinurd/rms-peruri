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
						
						<div class="nav-tabs-custom">
							<!-- Tabs within a box -->
							<ul class="nav nav-tabs">
								<li class="active ln-blue"><a href="#tab_puskesmas" class="chart-puskesmas" data-toggle="tab">SKDR Puskesmas</a></li>
								<li class="ln-yellow"><a href="#tab_rs" class="chart-rs" data-toggle="tab">SKDR Rumah Sakit</a></li>
								<li class="ln-green"><a href="#tab_lab" class="chart-lab" data-toggle="tab">SKDR Laboratorium</a></li>
								<li class="ln-orange"><a href="#tab_ebs" class="chart-ebs" data-toggle="tab">Surveilans Berbasis Kejadian (EBS)</a></li>
							</ul>
						</div>
						
						<div class="tab-content no-padding">
							<div class="tab-pane active" id="tab_puskesmas">
								<?php echo $kontent_puskesmas;?>
							</div>
							<div class="tab-pane" id="tab_rs">
								<?php echo $kontent_rs;?>
							</div>
							<div class="tab-pane" id="tab_lab">
								<?php echo $kontent_lab;?>
							</div>
							<div class="tab-pane" id="tab_ebs">
								<?php echo $kontent_ebs;?>
							</div>
						</div>
						
					</section><!-- /.content -->				
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var mode="puskesmas";
	alert(mode);
</script>
<!--welcome container end-->
