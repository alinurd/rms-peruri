<div class="table-responsive">
	<table class="table" id="datatablesx">
		<thead>
			<tr>
			<th width="10%" style="text-align:center;">No.</th>
			<th >Customer</th>
			<th width="40%" >Address</th>
			<th width="15%" >Select</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $key=>$row)
			{ 
				?>
				<tr style="cursor:pointer;" >
					<td style="text-align:center;"><?php echo $i;?></td>
					<td><?php echo $row['pelanggan'];?></td>
					<td><?php echo $row['address'];?></td>
					<td onClick="getData('<?php echo $row['id'];?>','<?php echo $row['pelanggan'];?>')" style="cursor:pointer;" data-dismiss="modal">[<span class="text-primary">Select</span>]</td>
				</tr>
			<?php 
				++$i;
			}
			?>
		</tbody>
	</table>
</div>
 
<script type="text/javascript">
	function getData(kd_supplier, nama_supplier, phone, address){
		$("#pelanggan_no").val(kd_supplier);
		$("#pelanggan_name").val(nama_supplier);
		$("#nama_pemilik").val(nama_supplier);
		$("#no_telp").val(phone);
		$("#alamat").val(address);
	}
	loadTable('',0,'datatablesx');
</script>