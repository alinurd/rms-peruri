<div class="modal-body">
	<table class="table" id="datatables">
		<thead>
			<tr>
			<th width="10%" style="text-align:center;">No.</th>
			<th width="35%" >Risk Couse</th>
			<th width="35%" ><?php echo lang('msg_tbl_select');?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $key=>$row)
			{ 
				$value_chek=$row->id."#".$row->description;
				?>
				<tr>
					<td style="text-align:center;width:10%;"><?php echo $i;?></td>
					<td style="width:80%;"><?php echo $row->description;?></td>
					<td style="text-align:center;width:10%;"><span class="btn btn-info pilih" value="<?php echo $value_chek;?>" data-dismiss="modal"><?php echo lang('msg_tbl_select');?></span></td>
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
  </div>

<script type="text/javascript">
	var jml='<?php echo $jml;?>';
	
	$(".pilih").click(function(){
		var jml_pil=0;
		var nil='';
		nil=$(this).attr('value');
		var data=nil.split('#');
		if (jml==1){
			add_install_couse(data[0], data[1]);
		}else{
			add_install_couse_more(data[0], data[1]);
		}
	});
	loadTable();
</script>