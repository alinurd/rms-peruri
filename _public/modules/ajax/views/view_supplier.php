<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
			<th width="10%" style="text-align:center;">No.</th>
			<th >Supplier</th>
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
				<tr style="cursor:pointer;">
					<td style="text-align:center;"><?php echo $i;?></td>
					<td><?php echo $row['supplier'];?></td>
					<td><?php echo $row['address'];?></td>
					<td onClick="getData('<?php echo $row['id'];?>','<?php echo $row['supplier'];?>')" style="cursor:pointer;" data-dismiss="modal">[<span class="text-primary">Select</span>]</td>
				</tr>
			<?php 
				++$i;
			}
			?>
		</tbody>
	</table>
</div>
 
<script type="text/javascript">
	function getData(kd_supplier, nama_supplier){
		$("#supplier_no").val(kd_supplier);
		$("#supplier_name").val(nama_supplier);
		var tgl= $("#tgl").val();
		$("#title_pembelian").html("Transaksi Pembelian dari Supplier : <span class='text-primary'>" + nama_supplier + "</span> | Tanggal : <span class='text-primary'>" + tgl + "</span>");
	}
</script>