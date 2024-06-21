<div class="table-responsive">
	<table class="table table-hover" id="datatablesxx">
		<thead>
			<tr>
			<th width="5%" style="text-align:center;">No.</th>
			<th width="10%" class="text-center">Kuitansi</th>
			<th width="30%">Suctomer</th>
			<th width="15%">Tanggal</th>
			<th width="15%"  class="text-right">Tagihan</th>
			<th width="15%" >Select</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $key=>$row)
			{ 
				?>
				<tr class="pilih" style="cursor:pointer;" onclick="pilih_faktur(<?php echo $row['id'];?>,'<?php echo $row['invoice_no'];?>')"  data-dismiss="modal">
					<td style="text-align:center;"><?php echo $i;?></td>
					<td class="text-center"><?php echo $row['invoice_no'];?></td>
					<td><?php echo $row['pelanggan_no'];?></td>
					<td><?php echo $row['tanggal'];?></td>
					<td class="text-right"><?php echo number_format($row['total_tagihan']);?></td>
					<td style="cursor:pointer;" data-dismiss="modal">[<span class="text-primary">Select</span>]</td>
				</tr>
			<?php 
				++$i;
			}
			?>
		</tbody>
	</table>
</div>


<script type="text/javascript">
	// loadTable('',0,'datatablesxx');
</script>

