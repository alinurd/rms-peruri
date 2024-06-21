<br/>
<strong> CAUSE LINK </strong>
<table class="table" id="instlmt_cause_x"><thead><tr>
	<th width="10%" style="text-align:center;">No.</th>
	<th>Cause</th>
	<th width="10%" style="text-align:center;">Aksi</th>
	</tr></thead><tbody>
		
<?php
	$cbo = form_dropdown('library_no[]', $cbogroup,'','class="form-control select3"');
	$edit=form_hidden('id_edit[]','0');
	?>
	<tr>
		<td style="text-align:center;width:10%;">1. <?php echo $edit;?></td>
		<td><?php echo $cbo;?></td>
		<td style="text-align:center;width:10%;"><a nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data"></i></a></td>
	</tr>
	</tbody>
</table>
<center>
	<button id="add_event_cause" class="btn btn-primary" type="button" value="<?=lang('msg_field_tambah_data');?>" name="add_event_cause" syle="margin-bottom:20px;"> <i class="fa fa-plus"></i> </button>
	<hr>
</center>

<script type="text/javascript">
	
	$("#add_event_cause").click(function(){
		var cbo='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$cbo));?>';
		var edit='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$edit));?>';
		$(this).addClass('disabled');
		var theTable= document.getElementById("instlmt_cause_x");
		
		var rl = $('table#instlmt_cause_x tr:last').index() + 1;
		
		// var rl = theTable.tBodies[0].rows.length;
		
		if (theTable.rows[rl].cells[1].childNodes[0].value=="0"){
			alert("Groups Tidak boleh Kosong!");
		}else{
		
			var lastRow = theTable.tBodies[0].rows[rl];
			var tr = document.createElement("tr");
			
			if((rl-1)%2==0)
				tr.className="dn_block";
			else
				tr.className="dn_block_alt";
			
			var td1 =document.createElement("TD");
			td1.setAttribute("style","text-align:center;width:10%;");
			var td2 =document.createElement("TD");
			td2.setAttribute("align","left");
			var td3 =document.createElement("TD");
			td3.setAttribute("style","text-align:center;width:10%;");
			
			++rl;
			td1.innerHTML=rl+edit;
			td2.innerHTML=cbo;
			td3.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install_cause(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
			
			tr.appendChild(td1);
			tr.appendChild(td2);
			tr.appendChild(td3);
			theTable.tBodies[0].insertBefore(tr , lastRow);
			$(".select3").select2({
				allowClear: false,
				placeholder: " - Select - ",
				width:'100%',
			});
			 $.fn.modal.Constructor.prototype.enforceFocus = function () {
			  var that = this;
			  $(document).on('focusin.modal', function (e) {
				 if ($(e.target).hasClass('select2-input')) {
					return true;
				 }

				 if (that.$element[0] !== e.target && !that.$element.has(e.target).length) {
					that.$element.focus();
				 }
			  });
		   };
		}
		$("#add_event_cause").removeClass('disabled');
	})
	
	function remove_install_cause(t,iddel){
		if(confirm("Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone")){
			var ri = t.parentNode.parentNode.rowIndex;
			t.parentNode.parentNode.parentNode.deleteRow(ri-1);
		}
		return false;
	}
	$(".select3").select2({
		allowClear: false,
		placeholder: " - Select - ",
		width:'100%',
	});
	 $.fn.modal.Constructor.prototype.enforceFocus = function () {
		  var that = this;
		  $(document).on('focusin.modal', function (e) {
			 if ($(e.target).hasClass('select2-input')) {
				return true;
			 }

			 if (that.$element[0] !== e.target && !that.$element.has(e.target).length) {
				that.$element.focus();
			 }
		  });
	   };
</script>