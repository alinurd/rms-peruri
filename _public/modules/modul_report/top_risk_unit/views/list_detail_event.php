<div class="modal-body">
	<table class="table table-hover" id="datatablesx">
		<thead>
			<tr>
				<th width="10%" style="text-align:center;">No.</th>
				<th>Code</th>
				<th>Description</th>
				<th>Probabilitas</th>
				<th>Impact</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $key=>$row)
			{ 
				?>
				<tr>
					<td style="text-align:center;"><?php echo $i++	;?>.</td>
					<td><?php echo $row['code'];?></td>
					<td><?php echo $row['description'];?></td>
					<td> <span class="label label-primary"><?php echo $row['inherent_likelihood'];?></label></td>
					<td><span class="label label-info"><?php echo $row['inherent_impact'];?></span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
  </div>
  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>