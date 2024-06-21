	<table class="table table-striped table-hover" id="instlmt-po">
		<thead>
		<tr>
			<th rowspan="2">Nama Barang</th>
			<th rowspan="2" width="5%">Stock<br/>Akhir</th>
			<th rowspan="2" width="5%">Qty PO</th>
			<th class="text-center">Last PO</th>
			<th class="text-center">Vendor 1</th>
			<th class="text-center">Vendor 2</th>
			<th class="text-center">Vendor 3</th>
			<th rowspan="2" class="hide">Keterangan</th>
		</tr>
		<tr>
			<th>Vendor / Harga / Total</th>
			<th>Vendor / Harga / Total</th>
			<th>Vendor / Harga / Total</th>
			<th>Vendor / Harga / Total</th>
		</tr>
		</thead>
		<tbody>
		
<?php
	$i=0;
	foreach($field as $key=>$row)
	{ 
		$nama_barang=$row['nama_barang'];
		$stock=$row['stock'];
		$qty=$row['jumlah'];
		$vendor0=$row['po_supplier'];
		$harga0=number_format($row['po_harga']);
		$total = $row['jumlah'] * floatval($row['po_harga']);
		$span = '<span class="total0"><strong>'.number_format($total).'</strong></span>';
		
		++$i;
		?>
		<tr>
			<td><?php echo $nama_barang ;?> </td>
			<td><?php echo $stock;?></td>
			<td><?php echo $qty;?></td>
			<td class="text-center"><?php echo 'Supplier : <strong>'.$vendor0.'</strong><br/>Harga : <strong>'.$harga0.'</strong><br/>Total : '.$span;?></td>
		<?php
			$no=1;
			foreach($row['detail'] as $dtl){
				$vendor=$dtl['supplier'];
				$harga=number_format($dtl['harga']);
				$total = floatval($dtl['harga']) * intval($row['jumlah']);
				$span = '<span class="total'.$no.'"><strong>'.number_format($total).'</strong></span>';
		?>
				<td class="<?=($dtl['terpilih']=='1')?'bg-danger':'';?>"><?php echo 'Supplier : <strong>'.$vendor.'</strong><br/>harga : <strong>'.$harga.'</strong><br/>Total : '.$span;?></td>
			<?php
				++$no;
			}
			?>
		</tr>
	<?php
			}
	?>
	</tbody></table>