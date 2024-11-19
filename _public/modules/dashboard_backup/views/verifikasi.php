<?=$icon='<i class="fa fa-dot-circle-o text-primary"></i> ';?>
<strong>Edit Alert</strong>
<?php echo form_open('edit_alert', array('class' => 'form-signin', 'id' => 'form_alert'));?>
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
	<td class="bold">Minggu : <?=$data['minggu'];?> Tahun : <?=$data['tahun'];?><td/> 
</tr> 
<tr> 	
	<td class="italic">Verifikasi<td/> 	
	<td class="bold"><?=form_dropdown('sts_verifikasi',array('0'=>'Belum Verifikasi','1'=>'Sudah Verifikasi'),$data['sts_verif'],'class="form-control"');?><td/> 
</tr> 
<tr> 	
	<td class="italic">Tgl. Verifikasi<td/> 	
	<td class="bold">
		<?=form_input('tgl_verif', $data['tgl_verif'],'class="form-control datepicker"');?>
		<?=form_hidden(array('id_edit'=>$id_edit, 'id_detail'=>$id_detail));?>
		<td/> 
</tr> 
<tr> 	
	<td class="italic">Petugas<td/> 	
	<td class="bold"><?=_USER_NAME_COMPLETE_;?><td/> 
</tr> 
<tr> 	
	<td class="italic">Jml Kematian<td/> 	
	<td class="bold"><?=form_input('jml_kematian', $data['jml_kematian'],'class="form-control"');?><td/> 
</tr> 
<tr> 	
	<td class="italic">Temuan<td/> 	
	<td class="bold"><?=form_textarea('temuan', $data['temuan']," class='form-control' rows='2' cols='5' style='overflow: hidden; width: 100% !important; height: 104px;' ");?><td/> 
</tr> 
<tr> 	
	<td class="italic">KLB<td/> 	
	<td class="bold"><?=form_dropdown('sts_klb',array('1'=>'Ya','0'=>'Tidak'),$data['sts_klb'],'class="form-control"');?><td/> 
</tr> 
<tr> 	
	<td class="italic">Respon 24 Jam<td/> 	
	<td class="bold"><?=form_dropdown('sts_respon',array('0'=>'Tidak','1'=>'Respon 24 Jam'),$data['sts_respon'],'class="form-control"');?><td/> 
</tr> 
<tr> 	
	<td class="italic">Catatan<td/> 	
	<td class="bold"><?=form_textarea('note', $data['note']," class='form-control' rows='2' cols='5' style='overflow: hidden; width: 100% !important; height: 104px;' ");?><td/> 
</tr> 
</table>
<button type="button" class="btn btn-primary pull-right" id="proses_alert"> Simpan </button> 
<button type="button" class="btn btn-default" data-dismiss="modal"> Tutup </button> 
<?php echo form_close();?>