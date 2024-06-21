<div class="table-responsive">
	<table class="table table-hover" id="datatablesx">
		<thead>
			<tr>
			<th width="5%" style="text-align:center;">No.</th>
			<th width="10%" class="text-center">Code</th>
			<th width="30%">Product</th>
			<th width="15%">Satuan</th>
			<th width="15%"  class="text-right">Price</th>
			<th width="15%"  class="text-center">Stock</th>
			<th width="15%" >Select</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $key=>$row){
				if ($row['kel']=='' || ($row['kel']=='jual' && $row['stock']>0))
				{ 
					$disc=0;
					$tgl=date('Y-m-d');
					$tgldisk1=$row['start_promo_date'];
					$tgldisk2=$row['end_promo_date'];
					if ($tgl >= $tgldisk1 && $tgl <= $tgldisk2 && intval($row['disc_sts'])==1)
						$disc=$row['disc_value'];
					?>
					<tr class="pointer" >
						<td style="text-align:center;"><?php echo $i;?></td>
						<td class="text-center"><?php echo $row['sku'];?></td>
						<td><?php echo $row['nama_barang'];?></td>
						<td><?php echo $row['harga_beli'];?></td>
						<td class="text-right"><?php echo number_format($row['harga_jual']);?></td>
						<td class="text-center"><?php echo $row['stock'];?></td>
						<td onClick="add_install('<?php echo $row['id'];?>','<?php echo $row['sku'];?>','<?php echo str_replace("'",'',str_replace('"','',$row['nama_barang']));?>','<?php echo $row['satuan'];?>','<?php echo $row['harga_beli'];?>','<?php echo $row['harga_jual'];?>',1,<?php echo $disc;?>,'<?php echo $row['disc_standar'];?>')" style="cursor:pointer;" data-dismiss="modal">[<span class="text-primary">Select</span>]</td>
					</tr>
				<?php 
				++$i;
				}
			}
			?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	loadTable('',0,'datatablesx');
</script>

