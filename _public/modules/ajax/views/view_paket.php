<div class="table-responsive">
	<table class="table" id="datatablesx">
		<thead>
			<tr>
			<th width="10%" style="text-align:center;">No.</th>
			<th  width="30%">Paket Name</th>
			<th width="5%" >Type</th>
			<th >Description</th>
			<th width="10%" >Select</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $key=>$row)
			{ 
				?>
				<tr style="cursor:pointer;">
					<td style="text-align:center;"><?php echo $i;?></td>
					<td><?php echo $row['paket'];?></td>
					<td><?php echo $row['tipe'];?></td>
					<td><?php echo $row['description'];?></td>
					<td onClick="getDataPaket('<?php echo $row['id'];?>')" style="cursor:pointer;" data-dismiss="modal">[<span class="text-primary">Select</span>]</td>
				</tr>
			<?php 
				++$i;
			}
			?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	loadTable('',0,'datatablesx');
</script>