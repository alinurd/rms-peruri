<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
  <h4 class="modal-title" style="text-align:center;">RISK REGISTER</h4>
</div>
<div class="modal-body">
	<div style="overflow-x: scroll;">
	<table class="table" width="100%">
		<tr>
			<td colspan="3"><strong><h2 style="margin:0px;">PROYEK</h2></strong></td>
			<td colspan="3"><strong><h2 style="margin:0px;">SASARAN</h2></strong></td>
			<td class="text-right" width="30%">
				<div class="btn-group">
					<button class="btn btn-success btn-flat" data-content="Mencetak Data yang Terfilter" data-toggle="popover" type="button" data-original-title="" title="">
					<i class="fa fa-print"></i>
					Import
					</button>
					<button class="btn btn-success btn-flat dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a onclick="cetak_lap('pdf', <?php echo $id_rcsa;?>)" href="#">
							<i class="fa fa-file-pdf-o" style=""></i>
							  PDF
							</a>
						</li>
						<li>
							<a onclick="cetak_lap('excel', <?php echo $id_rcsa;?>)" href="#">
							<i class="fa fa-file-excel-o" style=""></i>
							  MS-Excel
							</a>
						</li>
					</ul>
				</div>
			</td>
		</tr>
		<tr>
			<td width="15%">Nama Proyek</td><td width="4%">:</td><td><strong><?=$rcsa['corporate'];?></strong></td>
			<td>Laba</td><td>:</td><td colspan="2"><strong><?=number_format($rcsa['target_laba']);?></strong></td>
		</tr>
		<tr>
			<td>Pelaksana</td><td>:</td><td><strong><?=$rcsa['name_owner'];?></strong></td>
			<td>Lokasi</td><td>:</td><td colspan="2"><strong><?=$rcsa['max_periode'];?></strong></td>
		</tr>
		<tr><td>Pemilik Proyek</td><td>:</td><td colspan="5"><strong><?=$rcsa['location'];?></strong></td></tr>
		<tr><td>Nilai Kontrak</td><td>:</td><td colspan="5"><strong><?=number_format($rcsa['nilai_kontrak']);?></strong></td></tr>
	</table>
	<br/>
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
	</style>
	<table class="table data" id="datatables_event">
		<thead>
			<!-- <tr>
				<th rowspan="2" width="5%" style="text-align:center;">No.</th>
				<th rowspan="2" width="15%">Identifikasi Risiko</th>
				<th rowspan="2" width="5%">No</th>
				<th>Peristiwa Risiko</th>
				<th rowspan="2">Sebab Risiko</th>
				<th rowspan="2">Dampak Risiko</th>
				<th rowspan="2">Nilai Dampak<br/>(juta Rp)</th>
				<th colspan="2">Level Inherent</th>
				<th rowspan="2">Risk Exposure</th>
				<th colspan="2">Level Residual</th>
				<th rowspan="2">Risk Exposure</th>
				<th rowspan="2">Action Plan (Mitigasi) / Accountable Unit / Target</th>
			</tr> -->
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2">Area</th>
				<th rowspan="2">Kategori</th>
				<th rowspan="2">Risiko</th>
				<th rowspan="2">Penyebab</th>
				<th rowspan="2">Impact/Akibat</th>
				<th rowspan="1" colspan="6">Analisis</th>
				<th rowspan="1" colspan="2">Evaluasi</th>
				<th rowspan="2">Kontrol /<br> Prosedur</th>
				<th rowspan="1" colspan="2">Risk Treatment Options</th>
				<th rowspan="2">Accountbl Unit</th>
				<th rowspan="2">Sumber Daya</th>
				<th rowspan="2">Deadline</th>
			</tr>
			<tr>
				<th colspan="2">Probabilitas</th>
				<th colspan="2">Impact</th>
				<th colspan="2">Risk Level</th>
				<th>PIC</th>
				<th>Urgency</th>
				<th>Proaktif</th>
				<th>Reaktif</th>
			</tr>
			<!-- <tr>
				<th>Nama dan Uraian peristiwa</th>
				<th>Likehood</th>
				<th>Consequence</th>
				<th>Likehood</th>
				<th>Consequence</th>
			</tr> -->
			<tr>
				<th class="number-width">1</th>
				<th class="number-width">2</th>
				<th class="number-width">3</th>
				<th class="number-width">4</th>
				<th class="number-width">5</th>
				<th class="number-width">6</th>
				<th class="number-width">7</th>
				<th class="number-width">8</th>
				<th class="number-width">9</th>
				<th class="number-width">10</th>
				<th class="number-width">11</th>
				<th class="number-width">12</th>
				<th class="number-width">13</th>
				<th class="number-width">14</th>
				<th class="number-width">15</th>
				<th class="number-width">16</th>
				<th class="number-width">17</th>
				<th class="number-width">18</th>
				<th class="number-width">19</th>
				<th class="number-width">20</th>
			</tr>
		</thead>
		<!-- <tbody>
			<?php
			$i=1;
			$ttl_nil_dampak=0;
			$ttl_exposure=0;
			$ttl_exposure_residual=0;
			foreach($field as $keys=>$row)
			{ 
				?>
				<tr>
					<td rowspan="<?=count($row->detail['risk_event']);?>"><?php echo $i;?></td>
					<td rowspan="<?=count($row->detail['risk_event']);?>"><?php echo $row->type;?></td>
					<?php 
					$no=1;
					foreach ($row->detail['risk_event'] as $key=>$sub){
						$nil_inherent_likelihood=explode('#',$row->detail['inherent_likelihood'][$key]);
						$nil_inherent_impact=explode('#',$row->detail['inherent_impact'][$key]);
						$exposure=floatval($row->detail['nilai_dampak'][$key]) * ($nil_inherent_likelihood[0]/100);
						
						$nil_residual_likelihood=explode('#',$row->detail['residual_likelihood'][$key]);
						$nil_residual_impact=explode('#',$row->detail['residual_impact'][$key]);
						$exposure_residual=floatval($row->detail['nilai_dampak'][$key]) * ($nil_residual_likelihood[0]/100);
						
						$ttl_nil_dampak +=floatval($row->detail['nilai_dampak'][$key]);
						$ttl_exposure += $exposure;
						$ttl_exposure_residual += $exposure_residual;
						
						$nil_inherent_likelihood_tmp='';
						if (count($nil_inherent_likelihood)>1){$nil_inherent_likelihood_tmp=$nil_inherent_likelihood[1];}
						$nil_inherent_impact_tmp='';
						if (count($nil_inherent_impact)>1){$nil_inherent_impact_tmp=$nil_inherent_impact[1];}
						
						$nil_residual_likelihood_tmp='';
						if (count($nil_residual_likelihood)>1){$nil_residual_likelihood_tmp=$nil_residual_likelihood[1];}
						$nil_residual_impact_tmp='';
						if (count($nil_residual_impact)>1){$nil_residual_impact_tmp=$nil_residual_impact[1];}
						
						
						if ($no>1){
							?>
							<tr>
							<?php
						}
						?>
							<td width="5%"><?=$no;?></td>
							<td><?=$sub['description'];?></td>
							<td><?=$row->detail['risk_couse'][$key];?></td>
							<td><?=$row->detail['risk_impact'][$key];?></td>
							<td class="text-right"><?=number_format($row->detail['nilai_dampak'][$key]);?></td>
							<td class="text-center"><?=$nil_inherent_likelihood_tmp;?></td>
							<td class="text-center"><?=$nil_inherent_impact_tmp;?></td>
							<td class="text-right"><?=number_format($exposure);?></td>
							<td class="text-center"><?=$nil_residual_likelihood_tmp;?></td>
							<td class="text-center"><?=$nil_residual_impact_tmp;?></td>
							<td class="text-right"><?=number_format($exposure_residual);?></td>
							<td>
							<table class="table">
							<?php
							foreach($row->detail['action'][$sub['id']] as $act){
								?>
								<tr>
									<td><?=$act['title'];?></td>
									<td><?=$act['owner_no'];?></td>
									<td><?=$act['target_waktu'];?></td>
								</tr>
								<?php
							}
							?>
							</table>
							</td>
							</tr>
						<?php
						++$no;
					}
					?>
				</tr>
			<?php 
				++$i;
			}
			?>
			<tr>
				<td colspan="6" class="tebal">T O T A L</td>
				<td class="right tebal"><?php echo number_format($ttl_nil_dampak);?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="right tebal"><?php echo number_format($ttl_exposure);?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="right tebal"><?php echo number_format($ttl_exposure_residual);?></td>
				<td>&nbsp;</td>
			</tr>
		</tbody> -->
	</table>
	</div>
  </div>
  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('msg_tbl_close');?></button>
  </div>
  
 <script>
	function cetak_lap(tipe, rcsa)
	{
		var url='<?php echo base_url($this->_Snippets_['modul']); ?>/cetak_register/'+tipe+"/"+rcsa;
		window.open(url);
	}
 </script>