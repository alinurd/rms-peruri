<div class="table-responsive">
	<table class="table table-hover" id="datatablesx">
		<tbody>
			<tr style="cursor:pointer;">
				<td class="text-center" width="20%">Pilih Term Anda</td>
				<td class="text-center">
					<?=form_dropdown('term_no', $cboTerm, $term_no,'class="form-control" id="term_no"');?>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="text-right">
					<span class="btn btn-primary text-center" id="simpan_term"> <i class="fa fa-save"> </i> Simpan </span>
				</td>
			</tr>
		</tbody>
	</table>
</div>
