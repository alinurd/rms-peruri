<?php
$data = $data_even_detail[0];
// Doi::dump($data);die();
?>
<?php
// doi::dump($id_rcsa_detail,false,true);
// doi::dump($data['level_residual'],false,true);
?>
<div id="content_detail">
	<table class="table table-striped table-hover dataTable data table-small-font" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="25%">
					<em><?php echo lang('msg_field_risk_event'); ?></em>
				</td>
				<td class="row-title  no-border">
					<?php echo $data['event_no'][0]['name']; ?>
				</td>
			</tr>
			<tr class="hide">
				<td><?php echo lang('msg_field_risk_owner'); ?></td>
				<td>
					<table class="table table-bordered table-striped table-hover dataTable data table-small-font" id="instlmt_owner">
						<tbody>
							<?php
$no = 1;
if (count($data['owner_no']) > 0) {
    foreach ($data['owner_no'] as $row) {
        ?>
							<tr>
								<td width="5%"> <?php echo $no++ . ". "; ?> </td>
								<td> <?php echo $row[0]['name']; ?> </td>
							</tr>
							<?php }}?>
						</tbody>
					</table>
				</td>
			</tr>
			<tr class="hide">
				<td><?php echo lang('msg_field_risk_type'); ?></td>
				<td>
					<table class="table table-bordered table-striped table-hover dataTable data table-small-font" id="instlmt_type">
						<tbody>
							<?php
$no = 1;
if (count($data['risk_type_no']) > 0) {
    foreach ($data['risk_type_no'] as $row) {
        ?>
							<tr>
								<td width="5%"> <?php echo $no++ . ". "; ?> </td>
								<td class="no-padding-left no-border padding-5" width="82%">
									<?php echo $row[0]['type']; ?>
								</td>
							</tr>
							<?php }}?>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><?php echo lang('msg_field_risk_couse'); ?></td>
				<td>
					<table class="table table-bordered table-striped table-hover dataTable data table-small-font" id="instlmt_couse">
						<tbody>
							<?php
$no = 1;
if (count($data['risk_couse_no']) > 0) {
    foreach ($data['risk_couse_no'] as $row) {
        ?>
							<tr>
								<td width="5%"> <?php echo $no++ . ". "; ?> </td>
								<td> <?php echo $row['name']; ?></td>
							</tr>
							<?php }}?>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td><?php echo lang('msg_field_risk_impact'); ?></td>
				<td>
					<table class="table table-bordered table-striped table-hover dataTable data table-small-font" id="instlmt_impact">
						<tbody>
							<?php
$no = 1;
if (count($data['risk_impact_no']) > 0) {
    foreach ($data['risk_impact_no'] as $row) {
        ?>
							<tr>
								<td width="5%"> <?php echo $no++ . ". "; ?> </td>
								<td><?php echo $row['name']; ?></td>
							</tr>
							<?php }}?>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td width="25%">
					<em><?php echo lang('msg_field_inherent_level'); ?></em>
				</td>
				<td class="row-title  no-border">
					<span class="label label-default" style="background-color:<?php echo $data['level_inherent']['color']; ?>"><?php echo $data['level_inherent']['level_mapping']; ?></span>
				</td>
			</tr>
			<tr>
				<td class="">
					<em><?php echo lang('msg_field_likelihood'); ?></em>
				</td>
				<td class="">
					<strong><?php echo $data['inherent_likelihood']; ?></strong>
				</td>
			</tr>
			<tr>
				<td class="">
					<em><?php echo lang('msg_field_impact'); ?></em>
				</td>
				<td class="">
					<strong><?php echo $data['inherent_impact']; ?></td></strong>
			</tr>
			<tr>
				<td class="" colspan="2">
					<em><?php echo lang('msg_field_control'); ?></em><br/>
					<div class="well p100">
						<div class="row">
					<?php
$jml     = intval(count($data_risk_level_control) / 2);
$check   = '';
$i       = 1;
$control = array();
if (is_array($data['control_no'])) {
    $control = $data['control_no'];
}

foreach ($data_risk_level_control as $row) {
    if ($i == 1) {
        $check .= '<div class="col-md-6">';
    }

    $sts = false;
    foreach ($control as $ctrl) {
        if ($row['component'] == $ctrl) {
            $sts = true;
            break;
        }
    }

    $check .= form_checkbox('check_item[]', $row['component'], $sts);
    $check .= '&nbsp;' . $row['component'] . '<br/>';

    // $check .='<input type="checkbox" value="'.$row['component'].'" name="check_item[]"> &nbsp;'.$row['component'].'<br/>';

    if ($i == $jml) {
        $check .= '</div><div class="col-md-6">';
    }

    ++$i;
}
$check .= '</div>';
echo $check;
?>

						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td class="row-title  no-border vcenter text-left">
					<em><?=lang('msg_field_residual_risk');?></em>
				</td>
				<td class="no-border vcenter text-left">
					<span style="margin-right:10px; float: left;"> <?=lang('msg_field_likelihood')?> :</span>
					<?=form_dropdown('inherent_likelihood', $cbo_level_like, (empty($data['inherent_likelihood'])) ? '' : $data['inherent_likelihood'], 'class="form-control" style="width:150px;float:left;margin-right:10px" id="inherent_likelihood"')?>
					<span style="margin-right:10px; float: left;"> <?=lang('msg_field_impact')?> :</span>
					<?php echo form_dropdown('inherent_impact', $cbo_level_impact_baru, (empty($data['inherent_impact'])) ? '' : $data['inherent_impact'], 'class="form-control" id="inherent_impact" style="width:150px"'); ?>
				</td>
			</tr>
			<tr>
				<td class="">
					<em><?php echo lang('msg_field_residual_level'); ?></em>
				</td>
				<td class="">
					<strong>
						<span class="label label-default" id="residual_level_label" style="background-color:<?php echo $data['level_residual']['color']; ?>"><?php echo $data['level_residual']['level_mapping']; ?></span>
					</strong>
				</td>
			</tr>
			<tr class="hide">
				<td class="row-title  no-border">
					<em><?php echo lang('msg_field_likelihood'); ?></em>
				</td>
				<td class="no-border vcenter" id="residual_likelihood_label">
					<strong><?php echo $data['residual_likelihood']; ?></strong>
				</td>
			</tr>
			<tr class="hide">
				<td class="row-title  no-border vcenter text-left">
					<em><?php echo lang('msg_field_impact'); ?></em>
				</td>
				<td class="no-border vcenter" id="residual_likelihood_label">
					<strong><?php echo $data['residual_impact']; ?></strong>
				</td>
			</tr>
			<tr>
				<td class="row-title  no-border vcenter text-left" colspan="2">
					<div class="pull-right">
						<button class="btn btn-success btn-flat update" data-content="<?=lang('msg_tbl_update');?>" data-toggle="popover" name="update" value="Update" type="submit">
							<i class="fa fa-floppy-o"></i>
							<?=lang('msg_tbl_update')?>
						</button>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<hr>

</div>

<script>

	var master_level = '<?php echo $master_level; ?>';
	var data_master_level = $.parseJSON(master_level);

	$(document).on('ready', function(){
		$("#inherent_likelihood").val(<?=$data['residual_likelihood_id']?>);
		$("#inherent_impact").val(<?=$data['residual_impact_id']?>);
	});
	$(document).on('click', '.update', function(){
		looding("light",$(this));
		setTimeout(function(){
			$('.blockUI').remove();
			pesan_toastr(Globals.success_process,"info","Residual Risk berhasil di update","toast-top-center");
		}, 3000);
	});
	$("#inherent_impact, #inherent_likelihood").change(function(){
		var url='<?php echo base_url("rcsa/get_risk_level"); ?>';
		var likelihood=$("#inherent_likelihood").val();
		var residual_likelihood=$("#residual_likelihood").val();
		var impact=$("#inherent_impact").val();
		var residual_impact=$("#residual_impact").val();
		var sts=false;

		if (likelihood>0 && residual_likelihood<=0){
			$("#residual_likelihood").val(likelihood);
			sts=true;
		}

		if (impact>0 && residual_impact<=0){
			$("#residual_impact").val(impact);
			sts=true;
		}

		if(sts)
			$("#residual_likelihood").trigger('change');

		cari_level(likelihood, impact, 1);
		return false;
	});

	function cari_level(likelihood, impact, asal){
		// alert(likelihood+'|'+impact+'|'+asal);
		var label='-';
		var id=0;
		var color=0;
		var color_text=0;
		$.each(data_master_level, function(key, value){
			if (value.impact==impact && value.likelihood==likelihood){
				label = value.level_mapping;
				id = value.id_color;
				color = value.color;
				color_text = value.color_text;
			}
		});
		var text='<span style="background-color:'+color+';color:'+color_text+'">  &nbsp;&nbsp;'+label.toUpperCase()+' &nbsp;&nbsp;</span>';
		if (asal==2){
			$("#risk_level").val(id);
			$("#residual_level").html(text);
		}else if (asal==1){
			// $("#inherent_level").val(id);

			$("#residual_level_label").css({'background-color':color,'color':color_text});
			$("#residual_level_label").text(label.toUpperCase());
		}
	}
</script>