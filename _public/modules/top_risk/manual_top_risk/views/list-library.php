<div id="konten_event">
	<div class="row form-horizontal">
		<div class="form-group pull-right" style="margin-right:15px;">
			<label class="col-xs-12 control-label">Category : 
			<?=form_dropdown('cboRiskType', $cboTypeLibrary, '',"class='form-control' style='width:40px;display:inline;' data-kel='".$nilKel."' data-event='".$event_no."' id='cboRiskType' ");?></label>
		</div>
	</div>
	<br/>
	<div id="listEvent">
		<table class="table data" id="datatables_event">
			<thead>
				<tr>
				<th width="10%" style="text-align:center;">No.</th>
				<th width="15%" ><?php echo lang('msg_field_pop_risk_event_type');?></th>
				<th width="60%" ><?php echo lang('msg_field_pop_event_description_library');?></th>
				<th width="10%" ><?php echo lang('msg_tombol_select');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				foreach($field as $key=>$row)
				{ 
					$value_chek=$row['id']."#".$row['code'].' - '.$row['description'];
					?>
					<tr style="cursor:pointer;" data-value="<?=$value_chek;?>">
						<td style="text-align:center;width:10%;"><?=$i;?></td>
						<td style="width:15%;"><?php echo $row['type_kelompok'];?></td>
						<td style="width:80%;text-align: justify;"><?=$row['description'];?></td>
						<td style="text-align:center;width:10%;"><span class="btn btn-info pilih-<?=$kel;?>" data-value="<?=$value_chek;?>" data-dismiss="modal" style="padding:2px 8px;"> <?=lang('msg_tombol_select');?></span></td>
					</tr>
				<?php 
					++$i;
				}
				?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	loadTable('', 0, 'datatables_event');
</script>