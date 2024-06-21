<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-sm-8 panel-heading">
				<h3 style="padding-left:10px;">Risk Monitoring</h3>
			</div>
			<div class="col-sm-4" style="text-align:right">
				<ul class="breadcrumb">
					<li> <a href="#"> <i class="fa fa-home"></i> Home</a></li>
					<li><a href="#">Report Risk Monitoring</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<aside class="profile-info col-md-12 col-sm-12 col-xs-12">
		<?=form_open_multipart(base_url(), array('id' => 'form_grafik', 'class'=>'form-horizontal'));?>
		<section class="panel">
			<div class="panel-body bio-graph-info" style="overflow-x: auto;">
				
				<div class="col-md-3 col-sm-3 col-xs-3">Risk Owner</div>
				<div class="col-md-9 col-sm-9 col-xs-9">
					<div class="form-group form-inline">
						<?=form_dropdown('owner_no', $korporasi, '', ' class="form-control select2" id="owner_no" style="width:100%;"');?>
					</div>
				</div>

				<div class="col-md-3 col-sm-3 col-xs-3">Periode</div>
				<div class="col-md-9 col-sm-9 col-xs-9">
					<div class="form-group form-inline">
						<?=form_dropdown('periode_no', $periode, _TAHUN_NO_, ' class="form-control select2" id="periode_no" style="width:100%;"');?>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">Bulan</div>
				<div class="col-md-9 col-sm-9 col-xs-9">
					<div class="form-group form-inline">
						<?=form_dropdown('bulan', $bulan,  date('n'), ' class="form-control select2" id="bulan" style="width:100%;"');?>
					</div>
				</div>
				<input type="hidden" id="bulan2" name="bulan2">
				<input type="hidden" id="tahun" name="tahun">
				<input type="hidden" id="unit" name="unit">
						</table>
					<span class="btn btn-primary pull-right" style="width:100px;" id="proses"> Proses </span>
				</div>
				<hr>
			</div>
			<div class="panel-body" id="content_detail">

			</div>
		</section>
		<?php echo form_close(); ?>
	</aside>
</div>