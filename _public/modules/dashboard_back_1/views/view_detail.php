<?php echo form_open_multipart($this->uri->uri_string,array('id'=>'form_input'));?>
<section class="content-header">
	<h1>Dashboard</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Dashboard</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-primary box-solid height-400">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-th"></i> <?=strtoupper($kel);?></h3>
					<div class="box-tools pull-right">
						<span class="btn" id="refresh_lengkap"><i class="fa fa-refresh"></i></span>
						<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<table class="table table-hover table-borderless" id="tbl_chart">
						<tr>
							<td class="text-right text-bold">
								<?=form_hidden(array('kel'=>$kel));?>
								<?=form_hidden(array('tipe'=>$tipe));?>
								<?=form_hidden(array('key'=>$key));?>
								<?=lang('msg_field_propinsi');?></td>
							<td><?=form_dropdown('cboPropinsi', $cbo_propinsi, $propinsi, 'class="form-control cbo-full" id="cboPropinsi"');?></td>
							<td class="text-right text-bold"><?=lang('msg_field_kota');?></td>
							<td colspan="2"><?=form_dropdown('cboKota', $cbo_kota, '', 'class="form-control cbo-full" id="cboKota"');?></td>
						</tr>
						<tr>
							<td class="text-right text-bold"><?=lang('msg_field_kecamatan');?></td>
							<td><?=form_dropdown('cboDistrik', $cbo_empty, '', 'class="form-control cbo-full" id="cboDistrik"');?></td>
							<td class="text-right text-bold"><?=lang('msg_field_puskesmas');?></td>
							<td colspan="2"><?=form_dropdown('cboPuskesmas', $cbo_empty, '', 'class="form-control cbo-full" id="cboPuskesmas"');?></td>
						</tr>
						<tr>
							<td width="10%" class="text-right text-bold"><?=lang('msg_field_tahun');?></td>
							<td width="40%"><?=form_dropdown('cboTahun', $cbo_tahun, _TAHUN_, 'class="form-control cbo-full" id="cboTahun"');?></td>
							<td width="10%" class="text-right text-bold"><?=lang('msg_field_minggu');?></td>
							<td width="20%"><?=form_dropdown('cboMinggu', $cbo_minggu, _MINGGU_, 'class="form-control cbo-full" id="cboMinggu"');?></td>
							<td width="20%"><?=form_dropdown('cboMinggu2', $cbo_minggu, _MINGGU_, 'class="form-control cbo-full" id="cboMinggu2"');?></td>
						</tr>
						<tr class="<?=$sts_penyakit;?>">
							<td class="text-right text-bold"><?=lang('msg_field_penyakit');?></td>
							<td><?=form_dropdown('cboPenyakit', $cbo_penyakit, '', 'class="form-control cbo-full" id="cboPenyakit"');?></td>
							<td class="text-right text-bold"><?=lang('msg_field_sts_verifikasi');?></td>
							<td><?=form_dropdown('cboStsRumor', $cbo_StsRumor, '', 'class="form-control cbo-full" id="cboStsRumor"');?></td>
						</tr>
						<tr>
							<td colspan="5" class="text-right"><span class="btn btn-primary btn-flat" style="width:70%;" id="btn_proses_alert"> Proses </span></td>
						</tr>
					</table>
					<hr>
					<div class="nav-tabs-custom" id="div_content">
						<ul class="nav nav-tabs pull-right">
							<li class="bt1"><a href="#div-table" data-toggle="tab"><?=lang('msg_field_table');?></a></li>
							<li class="bt1 active"><a href="#lengkap-chart" data-toggle="tab"><?=lang('msg_field_chart');?></a></li>
						</ul>
						<div class="tab-content no-padding">
							<div class="chart tab-pane active" id="lengkap-chart">
								<canvas id="bar-chart" width="800" height="400"></canvas>
							</div>
							<div class="chart tab-pane" id="div-table" style="max-height:700px;  overflow: scroll;">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?=form_close();?>

<script>
	var mode='<?=$tipe;?>';
</script>