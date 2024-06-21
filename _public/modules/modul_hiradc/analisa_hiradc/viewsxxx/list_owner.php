<div class="modal-body">
	<table class="table data" id="datatables">
		<thead>
			<tr>
			<th width="4%" style="text-align:center;"><input type="checkbox" id="check_all_master" target='check_item[]'></th>
			<th width="10%" style="text-align:center;">No.</th>
			<th width="35%" ><?php echo $kel;?> Name</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $key=>$row)
			{ 
				$value_chek=$row->id."#".$row->name;
				?>
				<tr>
					<td style="text-align:center;"><input type="checkbox" name="check_item[]" value="<?php echo $value_chek;?>" class="checkbox_contact"></td>
					<td style="text-align:center;width:10%;"><?php echo $i;?></td>
					<td><?php echo $row->name;?></td>
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
		<button type="button" class="btn btn-primary" id="proses_select" data-dismiss="modal"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_select');?> </button>
  </div>

<script type="text/javascript">
	var tmp_asal = "<?php echo $tmp_asal; ?>";
	var kel = "<?php echo $kel; ?>";
	
	$("#proses_select").click(function(){
		var jml_pil=0;
		var nil='';
		var myCheckboxes = new Array();
		var sts=$("input[name='owner_name[]']")
		$(".checkbox_contact").each(function() {
			if (this.checked){
				nil=$(this).val();
				myCheckboxes.push(nil);
				this.checked = false;
				++jml_pil;
				var data=nil.split('#');
				add_install(data[0], data[1], tmp_asal, kel);
			}
		}); 
	});
	loadTable();
</script>