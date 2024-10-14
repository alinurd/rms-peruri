<h4>Risk Treatment</h4>
<?php
	$hide_edit='';
	$sts_risk=0;
	if (isset($parent['sts_propose']))
		$sts_risk=intval($parent['sts_propose']);
	if ($sts_risk>=1){
		$hide_edit=' hide ';
	}
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <section class="x_panel">
            <div class="x_title">
                <strong>Assesment : <?= strtoupper($parent['name']); ?></strong>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="overflow-x: auto;">
				<div class="col-md-6 col-sm-6 col-xs-12" style="background-color:#e3f9fc;">
					<table class="table">
						<tr><td colspan="2" class="text-center">RISK CONTEXT</td></tr>
						<tr><td width="20%"><em>Risk Owner</em></td><td><?= $parent['name']; ?></td></tr>
						<tr><td><em>Risk Agent</em></td><td><?= $parent['officer_name']; ?></td></tr>
						<tr><td><em>Periode</em></td><td><?= $parent['periode_name']; ?></td></tr>
						<tr><td><em>Anggaran RKAP</em></td><td><?= number_format($parent['anggaran_rkap']); ?></td></tr>
					</table>
            	</div>
				<div class="col-md-6 col-sm-6 col-xs-12" style="background-color:#c0d5e5;">
					<table class="table">
						<tr><td colspan="2" class="text-center">PERISTIWA</td></tr>
						<tr><td width="20%"><em>Kategori</em></td><td><?= $detail['kategori']; ?></td></tr>
						<tr><td><em>Sub Kategori</em></td><td><?= $detail['sub_kategori']; ?></td></tr>
						<tr><td><em>Peristiwa</em></td><td><?= $detail['event_name']; ?></td></tr>
						<tr><td><em>Risk Level</em></td><td>
						'<span id="inherent_level_label"><span style="background-color:<?=$detail['warna'];?>;color:<?=$detail['warna_text'];?>;">&nbsp;<?=$detail['inherent_analisis'];?>&nbsp;</span></span> &nbsp;&nbsp;&nbsp; => &nbsp;&nbsp;
						<span id="inherent_level_label"><span style="background-color:<?=$detail['warna_residual'];?>;color:<?=$detail['warna_text_residual'];?>;">&nbsp;<?=$detail['residual_analisis'];?>&nbsp;</span></span></td></tr>
					</table>
            	</div>
            </div>
        </section>
    </div>
</div>

<div id="list_mitigasi">
	<?=$list_mitigasi;?>
</div>
<div class="hide" id="input_mitigasi">
	
</div>