<style>
	table {
		border-collapse:collapse;
	}
	th {
		vertical-align: center;
		text-align: center;
		background: #ccc0da;
	}
	.number-width {
		font-size: 8px;
	}
	.td {
		padding: 10px
	}
</style>
<div class="modal-footer">
	<button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo lang('msg_tbl_close');?></button>
	<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cetak</button>
</div>

<div class="row" style="overflow: auto;">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="display table table-bordered table-hover" id="tbl_register" style="font-size:85%;">
				<thead>
					<tr>
						<td colspan="2" class="text-center"><img src="<?=img_url('logo.png');?>" width="90"></td>
						<td colspan="24" class="text-center"><h2>MANAJEMEN RISIKO DAN KEPATUHAN
						<br/>BIRO TINJAUAN RISIKO, JAMINAN, DAN KEPATUHAN</h2></td>
					</tr>
					<!-- <tr>
						<td colspan="11">BAGIAN : SEKSI CETAK UGAM</td>
						<td colspan="9">PENANGGUNG JAWAB :  KASEK CETAK UANG LOGAM</td>
						<td colspan="2">TANGGAL</td>
						<td colspan="4">2 AGUSTUS 2016</td>
					</tr>
					<tr>
						<td colspan="11"></td>
						<td colspan="9">TANDA TANGAN : </td>
						<td colspan="2">REVISI</td>
						<td colspan="4">ke 9</td>
					</tr> -->
					<tr>
						<td colspan="24">Tanggal : </td>
					</tr>
					<tr>
						<td colspan="2"><b>REVIEW : </b></td>
						<td colspan="24"></td>
					</tr>
		
					<tr>
						<th>ITEM</th>
						<th>LENGKAP / TIDAK</th>
						<th>KETERANGAN</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</tbody>
			</table>
		</div>
		<br><br>
		<div class="table-responsive">
			<table class="display table table-bordered table-hover" id="tbl_register" style="font-size:85%;">
				<thead>
					<tr>
						<td colspan="24">Kesimpulan : </td>
					</tr>
			
					<tr>
						<th>KATEGORI</th>
						<th>RISIKO</th>
						<th>TINDAK LANJUT</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	function cetak_lap(tipe, rcsa)
	{
var url='<?php echo base_url($this->_Snippets_['modul']); ?>/cetak_register/'+tipe+"/"+rcsa;
window.open(url);
}
</script>