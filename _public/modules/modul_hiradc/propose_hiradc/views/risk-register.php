<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<?php
		if ($parent['sts_propose']==0){ 
			echo form_hidden(array('edit_no'=>$parent['id']));
			?>
		<span class="btn btn-flat btn-warning pointer" id="kirim_propose"> KIRIM PROPOSE </span>
		<div class="table-responsive">
			<table class="display table table-bordered table-hover" id="tbl_register" style="font-size:85%;">
				<thead>
					<tr>
						<th rowspan="2">No.</th>
						<th rowspan="2">Lokasi</th>
						<th rowspan="2">AKTIVITAS/PRODUK/JASA (Based on Process)</th>
						<th rowspan="2">BAHAYA K3(KLASIFIKASI)</th>
						<th rowspan="2">RISIKO K3 AKTUAL & POTENSIAL</th>
						<th rowspan="2">KONDISI ( N /AN / E )</th>
						<th rowspan="2">URGENSI</th>
						<th colspan="7">PENILAIAN BAHAYA & RISIKO K3</th>
						<th rowspan="2" colspan="2">TINGKAT RISIKO (O/H-M-L-D)</th>
						<th rowspan="2">RELEVANSI PERUNDANGAN</th>
						<th rowspan="2">STATUS PENTING (P/TP)</th>
						<th rowspan="2">PENGENDALIAN OPERASIONAL</th>
						<th colspan="2">PENGENDALIAN RISIKO</th>
						<th colspan="5">FAKTOR-FAKTOR PERTIMBANGAN PRIORITAS MANAGEMENT</th>
						<th rowspan="2">PROGRAM</th>
					</tr>
					<tr>
						<th>TR</th>
						<th>SRD</th>
						<th>BP</th>
						<th>LP</th>
						<th>CP</th>
						<th>Keparahan (severity)</th>
						<th>Kemungkinan terjadi(occorunce)</th>
						<th>SEKARANG</th>
						<th>MENDATANG</th>
						<th>A</th>
						<th>B</th>
						<th>C</th>
						<th>D</th>
						<th>E</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no=0;
					foreach($field as $key=>$row){?>
						<tr>
							<td><?=++$no;?></td>
							<td><?=$row['lokasi'];?></td>
							<td><?=$row['aktifitas'];?></td>
							<td><?=$row['bahaya'];?></td>
							<td><?=$row['resiko'];?></td>
							<td><?=$row['kode_kondisi'];?></td>
							<td style="padding:2px 0px;"><?=form_dropdown('urut[]', $nourut, '', 'style="width:100%;"');?></td>
							<td><?=$row['kode_tr'];?></td>
							<td><?=$row['kode_sd'];?></td>
							<td><?=$row['kode_bp'];?></td>
							<td><?=$row['kode_lp'];?></td>
							<td><?=$row['kode_cp'];?></td>
							<td><?=$row['severity'];?></td>
							<td><?=$row['kode_occorunce'];?></td>
							<td><?=$row['score_resiko'];?></td>
							<td><span style="background-color:<?=$row['warna'];?>;color:<?=$row['warna_text'];?>;padding:8px;"><?=$row['tingkat'];?></span></td>
							<td><?=$row['isiRegulasi'];?></td>
							<td class="text-center"><?=$row['kode_penting'];?></td>
							<?php
							if (count($row['mitigasi'])>0){
								foreach ($row['mitigasi'] as $det){ ?>
								<td><?=$det['operasional'];?></td>
								<td><?=$det['sekarang'];?></td>
								<td><?=$det['mendatang'];?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><?=$det['program'];?></td>
								<?php 
								break; }
							}else{ 
								?> 
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							<?php }
							?>
						</tr>
					<?php 
						if (count($row['mitigasi']>1)){
							foreach ($row['mitigasi'] as $key=>$det){ 
								if ($key>0){
									?>
									<tr>
									<?php for($x=1;$x<=17;++$x){?>
									<td>&nbsp;</td>
									<?php } ?>
									<td><?=$det['operasional'];?></td>
									<td><?=$det['sekarang'];?></td>
									<td><?=$det['mendatang'];?></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><?=$det['program'];?></td></tr>
									<?php 
								} 
							}
						}
					} ?>
				</tbody>
			</table>
		</div>
		<?php }elseif ($parent['sts_propose']==1){ ?>
			<div class="alert alert-info alert-dismissible fade in" role="alert">
				<strong>Info!</strong> <br/>Data Register ini sedang dalam proses Approval
			</div>
		<?php }elseif ($parent['sts_propose']==2){ ?>
			<div class="alert alert-success alert-dismissible fade in" role="alert">
				<strong>Success!</strong> <br/>Data Register sudah di Approval
			</div>
		<?php } ?>
	</div>
</div>