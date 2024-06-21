<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-sm-8 panel-heading">
				<h3 style="padding-left:10px;">Risk Categories</h3>
			</div>
			<div class="col-sm-4" style="text-align:right">
				<ul class="breadcrumb">
					<li> <a href="#"> <i class="fa fa-home"></i> Home</a></li>
					<li><a href="#">Risk Distribution</a></li>
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
<!-- 				<div class="col-md-3 col-sm-3 col-xs-3">Bulan</div>
				<div class="col-md-9 col-sm-9 col-xs-9">
					<div class="form-group form-inline">
						<?=form_dropdown('bulan', $bulan, date('n'), ' class="form-control select2" id="bulan" style="width:100%;"');?>
					</div>
				</div> -->
<!-- 				<div class="col-md-3 col-sm-3 col-xs-3">Risk Context</div>
				<div class="col-md-9 col-sm-9 col-xs-9">
					<div class="form-group form-inline">
						<?=form_dropdown('risk_context', $risk_context, 0, ' class="form-control select2" id="risk_context" style="width:100%;"');?>
					</div>
				</div> -->
				<div class="col-md-3 col-sm-3 col-xs-3">&nbsp;</div>
				<div class="col-md-9 col-sm-9 col-xs-9">
					<span id="lbl_option" class="pointer text-primary">
						<< show option>>
					</span>
					<div id="option" style="display:none;">
						<table width="100%">
							<tr>
								<td width="20%">
									<div class="checkbox">
										<label><input type="checkbox" name="title" value="1" checked> Title</label>
									</div>
								</td>
								<td>
									<div class="form-group form-inline"> 
										<?=form_input('title_text', 'Risk Category', ' class="form-control" id="title_text" style="width:100%;"');?>
									</div></td>
							</tr>
							<tr>
								<td>
									<div class="checkbox">
										<label><input type="checkbox" name="label" value="1" checked> Label</label>
									</div>
								</td>
								<td>
									<div class="form-group form-inline"> 
										Position : 
										<?=form_dropdown('position_label', ['top'=>'top','left'=>'left','bottom'=>'bottom','right'=>'right']
										, 'bottom', ' class="form-control select2" id="position_label" style="width:75%;"');?>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<hr>
					<input type="hidden" id="tahun" name="tahun">
					<input type="hidden" id="bulan2" name="bulan2">
					<input type="hidden" id="owner_name" name="owner_name">
<span class="btn btn-warning btn-flat pull-right"><a href="#" style="color:#ffffff;" id="downloadPdf"><i class="fa fa-file-pdf-o"></i>Export PDF </a>
    </span>
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