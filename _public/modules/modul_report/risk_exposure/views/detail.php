<div class="box">
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
			<td><strong><?=number_format($owner[$type]/1000000);?></strong></td>
		</tr>
	</table>
	<table class="table table-bordered table-striped table-hover" style="margin-bottom:0px;">
		<thead>
			<tr>
				<th>No.</th>
				<th>Risk Owner</th>
				<th>Likehood</th>
				<th>Consequence</th>
				<th>Exposure<sup>*</sup></th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			$ttl=0;
			$field_tmp=array();
			// Doi::dump($field);
			foreach($field as $row){
				if ($type=="inherent"){
					$rata=$row['rata_inherent']/1000000;
				}else{
					$rata=$row['rata_residual']/1000000;
				}
				$rata +=rand(1, 100);
				$field_tmp[$rata]=$row;
			}
			// Doi::dump($field_tmp);
			krsort($field_tmp);
			foreach($field_tmp as $key=>$row){
				
				if ($type=="inherent"){
					$ttl +=$row['rata_inherent'];
					$rata=$row['rata_inherent']/1000000;
					$likehood=$row['inherent_level_likehood'];
					$impact=$row['inherent_level_impact'];
				}else{
					$ttl +=$row['rata_residual'];
					$rata=$row['rata_residual']/1000000;
					$likehood=$row['residual_level_likehood'];
					$impact=$row['residual_level_impact'];
				}
				$next='';
				if ($row['child']>0){
					$next=' | <em><span id="view_next_risk" class="pointer  text-success" data-id="'.$row['id'].'" typemap="'.$type.'" data-parent="'.$id.'" data-urut="'.$urut.'" >View Risk Exposure</span></em>';
				}
			?>
			<tr>
				<td><?=++$i;?></td>
				<td><?=$row['name'];?></td>
				<td class="text-center"><?=$likehood;?></td>
				<td class="text-center"><?=$impact;?></td>
				<td class="text-right"><?=number_format($rata);?></td>
				<td class="primary text-center"><em><span id="view_risk" class="pointer  text-primary view_risk" data-id="<?=$row['id'];?>" typemap="<?=$type;?>" data-urut="<?=$urut;?>" >View Risk</span></em><?=$next;?></td>
			</tr>
			<?php } 
			$ttl = $ttl/1000000;
			?>
			<tr>
				<td colspan="4">Total Eksposure</td>
				<td class="text-right"><?=number_format($ttl);?></td>
				<td>&nbsp;</td>
			</tr>
		</tbody>
	</table>
	<sup>(* dalam jutaan</sup><br/>
	<div id="overlay" class="overlay hide">
		<i class="fa fa-refresh fa-spin"></i>
	</div>
	<button type="button" class="btn btn-flat btn-primary" id="btn_back_map" data-urut="<?=$urut;?>" typemap="<?=$type;?>"><< Kembali</button><br/><br/>
</div>