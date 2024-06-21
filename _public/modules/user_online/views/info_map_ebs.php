<?php $icon='<i class="fa fa-dot-circle-o text-primary"></i> ';?>
<div style='width:300px;margin:0 0 20px 20px;height:auto;' id="alert_<?=$data['id'];?>">
<strong><?=$icon;?> Informasi KLB/Rumor penyakit bersumber EBS</strong>
<table class="table table-borderless" style="font-size:90%;">
<tr>
	<td class="italic" width="20%">Lokasi<td/>
	<td class="bold"><?=$data['lokasi'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">No. EBS<td/> 	
	<td class="bold"><?=$data['no_ebs'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Penyakit<td/> 	
	<td class="bold"><?=$data['nama_penyakit'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Waktu<td/> 	
	<td class="bold">Bulan : <?=$data['bulan'];?>. Tahun : .<?=$data['tahun'];?><td/> 
</tr> 

<tr> 	
	<td class="italic">KLB<td/> 	
	<td class="bold"><?=$data['sts_klb'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Respon 24 Jam<td/> 	
	<td class="bold"><?=$data['sts_respon'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Form W1<td/> 	
	<td class="bold"><?=$data['sts_formw1'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Catatan<td/> 	
	<td class="bold"><?=$data['informasi'];?><td/> 
</tr> 
</table>
</div>