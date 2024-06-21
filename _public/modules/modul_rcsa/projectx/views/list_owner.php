<style type="text/css">
	.tr-hover {
		background: transparent;
		transition: background .3s ease;
	}
	.tr-hover:hover {
		background: #85bddb;
		color: white;
		cursor: pointer;
	}
</style>
<div class="modal-body">
	<table class="table data" id="datatables">
		<thead>
			<tr>
			<th width="10%" style="text-align:center;">No.</th>
			<th width="35%" ><?php echo $kel;?> Name</th>
			<th width="5%"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $key=>$row)
			{ 

				$value_chek=$row['id']."#".$row['name'];
				 // doi::dump($value_chek,false,true);
				?>
				<tr class="tr-hover">
					<td style="text-align:center;width:10%;"><?php echo $i;?></td>
					<td class="owner_names"><?php echo $row['name'];?></td>
					<td style="width: 5%"><button class="btn btn-sm btn-default choose" value="<?php echo $row['id']; ?>" data-dismiss="modal">pilih</button></td>
				</tr>
			<?php 
				++$i;
			}
			?>
		</tbody>
	</table>
  </div>
  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<!-- <button type="button" class="btn btn-warning" id="proses_select"><i class="fa fa-plus" ></i> <?php echo lang('msg_tbl_select');?> </button> -->
  </div>

<script type="text/javascript">
	

	$(".choose").click(function() {
	    var id= $(this).val();
	    var row = $(this).closest("tr");
	    var owner_names = row.find(".owner_names").text(); 
		add_install_area(id,owner_names);
	});

	loadTable();


</script>