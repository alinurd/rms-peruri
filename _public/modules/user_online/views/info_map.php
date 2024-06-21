<?php $icon='<i class="fa fa-dot-circle-o text-primary"></i> ';?>
<div style='width:300px;margin:0 0 20px 20px;height:auto;' id="alert_<?=$data['id'];?>">
<strong><?=$icon;?> Info Peringatan Dini Penyakit Minggu <?=_MINGGU_;?></strong>
<table class="table table-borderless" style="font-size:90%;">
<tr>
	<td class="italic" width="20%">Lokasi<td/>
	<td class="bold"><?=$data['lokasi'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Puskesmas<td/> 	
	<td class="bold"><?=$data['puskesmas'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Penyakit<td/> 	
	<td class="bold"><?=$data['nama_penyakit'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Waktu<td/> 	
	<td class="bold">Minggu : <?=$data['minggu'];?>. Tahun : .<?=$data['tahun'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Verifikasi<td/> 	
	<td class="bold"><?=$data['sts_verif'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Tgl. Verifikasi<td/> 	
	<td class="bold"><?=$data['tgl_verif'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Petugas<td/> 	
	<td class="bold"><?=$data['petugas'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Jml Kematian<td/> 	
	<td class="bold"><?=$data['jml_kematian'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">KLB<td/> 	
	<td class="bold"><?=$data['sts_klb'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Respon 24 Jam<td/> 	
	<td class="bold"><?=$data['sts_respon'];?><td/> 
</tr> 
</table>
<span class="pointer editaler hidet" data-edit="<?=$data['id'];?>" data-detail="<?=$data['id_detail'];?>"> Edit Data <span/>
</div>