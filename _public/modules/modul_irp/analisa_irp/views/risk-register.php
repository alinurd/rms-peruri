<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="display table table-bordered table-hover" id="tbl_register" style="font-size:85%;">
				<thead>
					<tr>
						<td colspan="2"  rowspan="6" class="text-center"><img src="<?=img_url('logo.png');?>" width="90"></td>
						<td colspan="7" rowspan="5" class="text-center"><h2>FORM <br/>IDENTIFIKASI PENILAIAN RISIKO PENGAMANAN</h2></td>
						<td class="text-center">No. Dokumen</td>
						<td></td><td></td>
					</tr>
					<tr><td>Mulai Berlaku</td><<td></td><td></td></tr>
					<tr><td>Revisi</td><td></td><td></td></tr>
					<tr><td>Tanggal Revisi</td><td></td><td></td></tr>
					<tr><td>Unit Kerja</td><td></td><td></td></tr>
					<tr>
						<td colspan="7" class="text-center"><h3>PERUM PERURI </h3></td>
						<td>Halaman</td><td></td><td></td>
					</tr>
					<tr>
						<th>No</th>
						<th>Area Kerja</th>
						<th>Aktifitas</th>
						<th>Aset</th>
						<th>Fungsi Kritis</th>
						<th>Kerawanan</th>
						<th>Ancaman</th>
						<th>Dampak</th>
						<th>Kemungkinan</th>
						<th>Level Resiko</th>
						<th>Pengendalian</th>
						<th>Mitigasi</th>
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
							<td><?=$row['aset'];?></td>
							<td><?=$row['fungsi_kritis'];?></td>
							<td><?=$row['kerawanan'];?></td>
							<td><?=$row['resiko'];?></td>
							<td><?=$row['dampak'];?></td>
							<td><?=$row['kemungkinan'];?></td>
							<td><?=$row['level_resiko'];?></td>
							<?php
							if (count($row['mitigasi'])>0){
								foreach ($row['mitigasi'] as $det){ ?>
								<td><?=$det['pengendalian'];?></td>
								<td><?=$det['mitigasi'];?></td>
								<?php 
								break; }
							}else{ 
								?> 
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							<?php }
							?>
						</tr>
					<?php
						if (count($row['mitigasi'])>1){
							foreach ($row['mitigasi'] as $key=>$det){ 
								if ($key>0){
									?>
									<tr>
									<?php for($x=1;$x<=17;++$x){?>
									<td>&nbsp;</td>
									<?php } ?>
									<td><?=$det['pengendalian'];?></td>
									<td><?=$det['mitigasi'];?></td></tr>
									<?php 
								} 
							}
						}
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>