<?php
if ($sts==1):?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_content" style="overflow-x: auto;">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<table class="table">
					<tr><td width="30%">Event </td><td>: <?=$data['l_name'];?></td></tr>
					<tr><td>Risk </td><td>: <?=$data['l_event_name'];?></td></tr>
					<tr><td>Couse </td><td>: <?=$data['l_risk_couse_no'];?></td></tr>
					<tr><td>Risk Level </td><td>: <?=$data['l_inherent_analisis'];?></td></tr>
				</table>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<table class="table">
					<tr><td width="30%">Proaktif </td><td>: <?=$data['l_proaktif'];?></td></tr>
					<tr><td>Accountable Unit </td><td>: <?=$data['l_owner_no'];?></td></tr>
					<tr><td>Deadline </td><td>: <?=$data['l_target_waktu'];?></td></tr>
				</table>
			</div>
		</div>
	</div>
</div>
<?php elseif ($sts==2):?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_content" style="overflow-x: auto;">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<table class="table">
					<tr><td width="30%">Tanggal Monitoring </td><td>: <?=$data['l_name'];?></td></tr>
					<tr><td>Progres </td><td>: <?=$data['l_progress'];?></td></tr>
					<tr><td>Keterangan </td><td>: <?=$data['l_description'];?></td></tr>
				</table>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<table class="table">
					<tr><td>Upload Eviden </td><td>: <?=$data['l_attc'];?></td></tr>
					<tr><td width="30%">Risk Level Inherent </td><td>: <?=$data['l_proaktif'];?></td></tr>
					<tr><td>Risk Level Residual </td><td>: <?=$data['l_owner_no'];?></td></tr>
				</table>
			</div>
		</div>
	</div>
</div>
<?php endif;?>