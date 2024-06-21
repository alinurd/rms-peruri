<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<span class="btn btn-primary btn-flat"> <a href="<?=base_url(_MODULE_NAME_.'/cetak-register/excel/'.$id);?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-excel-o"></i> Ms-Excel </a></span> <span class="btn btn-warning btn-flat"> <a href="<?=base_url(_MODULE_NAME_.'/cetak-register/pdf/'.$id);?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-pdf-o"></i> PDF </a></span>
		<div class="table-responsive">
			<table class="display table table-bordered table-hover" id="tbl_register" style="font-size:85%;">
				<thead>
					<tr>
						<td colspan="2" class="text-center"><img src="<?=img_url('logo.png');?>" width="90"></td>
						<td colspan="24" class="text-center"><h2>DAFTAR IDENTIFIKASI BAHAYA K3
						<br/>PENILAIAN DAN PENGENDALIAN RISIKO K3</h2></td>
					</tr>
					<tr>
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
					</tr>
					<tr>
						<th rowspan="2">No.</th>
						<th rowspan="2">Lokasi</th>
						<th rowspan="2">AKTIVITAS/PRODUK/JASA (Based on Process)</th>
						<th rowspan="2">BAHAYA K3(KLASIFIKASI)</th>
						<th rowspan="2">RISIKO K3 AKTUAL & POTENSIAL</th>
						<th rowspan="2">KONDISI ( N /AN / E )</th>
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
						if (is_array($row['mitigasi'])){
							if (count($row['mitigasi'])>1){
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
						}
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>