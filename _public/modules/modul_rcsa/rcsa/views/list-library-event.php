<div class="modal modal-default" id="peristiwa_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Input Peristiwa</h4>
			</div>
			<div class="modal-body">
			
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	loadTable('', 0, 'datatables_event');
	var no_urut = 1;
	var cbiImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbi)); ?>';
	var cboImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbbi)); ?>';
	var editImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $edit)); ?>';


	var cbnCouse = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbn)); ?>';
	var cboCouse = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbbo)); ?>';
	var editCouse = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $edit)); ?>';
	$(document).ready(function() {
		$('#peristiwa_modal').modal('show');
	});
	$(document).on("click", ".close", function() {
		$('#input_peristiwa').addClass('show');

	});
</script>