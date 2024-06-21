
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
										<span class="info-box-text" title="Kab/Kota">Kab/Kota</span>
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
										<span class="info-box-text" title="Status KLB">Status KLB</span>
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
										<span class="info-box-text" title="Status KLB Tidak">Status KLB Tidak</span>
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
										<span class="info-box-text" title="Situasi KLB Berlangsung">Situasi KLB Berlangsung</span>
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
										<span class="info-box-text" title="Situasi KLB Selesai">Situasi KLB Selesai</span>
										<span class="info-box-number pull-right">2</span>
									</div>
								</div>
							</div>
							</a>
						</div><!-- /.row -->
						
						<div class="row">
							<div class="col-sm-12">
								<div class="box box-success box-solid height-400">
									<div class="box-header with-border">
										<h3 class="box-title"><i class="fa fa-th"></i> Informasi KLB/Rumor penyakit bersumber EBS</h3>
										<div class="box-tools pull-right">
											<span class="btn" id="refresh_map"><i class="fa fa-refresh"></i></span>
											<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
										</div>
									</div>
									<div class="box-body" id="content_map_ebs">
										<?php echo $maps_ebs['map_ebs']['js']; ?>
										<?php echo $maps_ebs['map_ebs']['html'];?>
										<hr>
										<div id="table_map">
											<?=$maps_ebs['table_map'];?>
										</div>
									</div>
								</div>
							</div>
						</div>
<script>
	var mode="ebs";
</script>

