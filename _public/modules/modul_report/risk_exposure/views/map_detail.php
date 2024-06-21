<table class="borderless" width="100%" style="margin-bottom:20px;">
	<tr>
		<td rowspan="3" width="22%"><?=$owner['photo'];?></td>
		<td width="15%">Owner</td>
		<td width="3%"> : </td>
		<td width="60%"><strong><?=$owner['name'];?></strong></td>
	</tr>
	<tr>
		<td>Name</td>
		<td> : </td>
		<td><strong><?=$owner['person_name'];?></strong></td>
	</tr>
	<tr>
		<td>Eksposure <sup>*</sup></td>
		<td> : </td>
		<td><strong><?=number_format($owner[$type_map]/1000000);?></strong></td>
	</tr>
</table>
<center><span class="label label-success">View Risk</span></center>
<?=draw_map($setting, 50, $type_map);?>
<br/>&nbsp;<br/>&nbsp;
<?php
if (intval($urut)>0){ ?>
<button type="button" class="btn btn-flat btn-primary" id="btn_back_list" typemap="<?=$type_map;?>"  data-urut="<?=$urut;?>"><< Kembali</button>
<?php } 
?>