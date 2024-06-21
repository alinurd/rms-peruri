<?php
	$info="";
	$sts_input="";
	$info_error="";
	if (validation_errors()){
		$info_error= validation_errors();
		$sts_input='danger';
	}elseif ($this->session->userdata('result_proses_error')){
		$info_error =  $this->session->userdata('result_proses_error');
		$this->session->set_userdata(array('result_proses_error'=>''));
		$sts_input='danger';
	}
	
	if ($this->session->userdata('result_proses')){
		$info = $this->session->userdata('result_proses');
		$this->session->set_userdata(array('result_proses'=>''));
		$sts_input='info';
	}
	
	$data=$setting['rcsa'][0];
	if (!array_key_exists('sts_propose',$data)){
		$data['sts_propose']=-1;
		$data['id']=0;
	}
	
	$owner_no='';
	$nilai_kontrak=0;
	$target_laba=0;
	if (count($setting['rcsa'])>0){
		$owner_no=$setting['rcsa'][0]['owner_no'];
		$period_no=$setting['rcsa'][0]['period_no'];
		$nilai_kontrak=$setting['rcsa'][0]['nilai_kontrak'];
		$target_laba=$setting['rcsa'][0]['target_laba'];
	}
?>
<script>
	$(function() {
		var err="<?php echo $info;?>";
		var sts="<?php echo $sts_input;?>";
		if (err.length>0)
			pesan_toastr(err,sts);
	});
</script>

<section id="main-content">
	<?php  echo form_open_multipart(base_url('approve-div/save_notes'),array('id'=>'form_input'));?>
	<section class="wrapper site-min-height">
	<div class="panel">
		<div class="row">
			<div class="col-sm-8 panel-heading">
				<h3 style="padding-left:10px;"><?php echo strtoupper(lang("msg_title"));?></h3>
			</div>
			<div class="col-sm-4" style="text-align:left; float: right;">
				<ol class="breadcrumb" style="text-align:right;">
					<li> <a href="<?php echo base_url();?>"> <i class="fa fa-home"></i> <?php echo lang('msg_breadcrumb_home');?></a></li>
					<li><a href="#"><?php echo lang('msg_title');?></a></li>
				</ol>
			</div>
		</div>
	<!--state overview start-->
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<!-- <button class="btn btn-primary btn-flat center" type="submit"><strong>A P P R O V E</strong></button> -->
				<a class="danger btn btn-default btn-flat" data-content="Kembali Ke Daftar" data-toggle="popover" href="<?php echo base_url('approve-div');?>" data-original-title="" title="">
				<i class="fa fa-sign-out"></i>
				<?php echo lang("msg_tombol_back_to_list");?>
				</a>
			</div>
		</div>
		</div>
			
		<div class="row">
			<div class="col-md-12">
				 <section class="panel">
				 <div class="panel-body progress-panel">
					<div class="task-progress">
						<h1><?php echo $judul ;?></h1>
					</div>
				</div>
				</section>
			</div>
		</div>
		<div class="row">
			
			<aside class="profile-info col-md-12">
				<section class="panel">
					<div class="row" style="overflow-x: auto !important;">
						<div class="col-md-12">
							<table class="table table-bordered table-sm table-risk-register" id="datatables_event">
								<thead>
									<tr>
										<th rowspan="2">No</th>
										<th rowspan="2"><label class="w150">Area</label></th>
										<th rowspan="2"><label>Kategori</label></th>
										<th rowspan="2"><label>Sub Kategori</label></th>
										<th rowspan="2"><label>Risiko</label></th>
										<th rowspan="2"><label>Penyebab</label></th>
										<th rowspan="2"><label>Impact/Akibat</label></th>
										<th rowspan="1" colspan="6"><label>Analisis</label></th>
										<th rowspan="1" colspan="4"><label>Evaluasi</label></th>
										<th rowspan="1" colspan="2"><label>Risk Treatment Options</label></th>
										<th rowspan="2"><label class="w100">Accountabel Unit</label></th>
										<th rowspan="2"><label class="w80">Sumber Daya</label></th>
										<th rowspan="2"><label class="w80">Deadline</label></th>
									</tr>
									<tr>
										<th colspan="2">Probabilitas</th>
										<th colspan="2">Impact</th>
										<th colspan="2">Risk Level</th>
										<th><label class="w150">PIC</label></th>
										<th>Urgency</th>
										<th>Existing Control</th>
										<th>Risk Control<br>Assessment</th>
										<th><label class="w150">Proaktif</label></th>
										<th><label class="w150">Reaktif</label></th>
									</tr>
								</thead>
								<tbody id="risk-register">
									
									<?php
									// if (count($field) == 0 )
										// echo '<tr><td colspan=22 style="text-align:center">No Data</td></tr>';
									$i=1;
									$ttl_nil_dampak=0;
									$ttl_exposure=0;
									$ttl_exposure_residual=0;
									
									foreach($field as $keys=>$row)
									{ 
										?>
										<tr>
											<td><?php echo $i;?></td>
											<td style="width: 50%"><?=$row['area_name'];?></td>
											<td><?=$row['kategori'];?></td>
											<td><?=$row['sub_kategori'];?></td>
											<td><?=$row['event_name'];?></td>
											<td><?=format_list($row['couse']);?></td>
											<td><?=$row['impact'];?></td>
											<td><?=$row['inherent_likelihood'];?></td>
											<td><?=$row['like_ket'];?></td>
											<td><?=$row['inherent_impact'];?></td>
											<td><?=$row['impact_ket'];?></td>
											<td><?=$row['inherent_level'];?></td>
											<td><?=$row['level_mapping'];?></td>
											<td><?=$row['penangung_jawab'];?></td>
											<!-- <td><?=$row['urgensi_no'];?></td> -->
											<td><?php echo form_hidden('rcsa_action_no[]', $row['id_rcsa_action']); ?>
												<?=$row['id_rcsa_action'] ?>
											</td>
											<td><?=format_list($row['control_name']);?></td>
											<td><?=$row['control_ass'];?></td>
											<td><?=$row['proaktif'];?></td>
											<td><?=$row['reaktif'];?></td>
											<td><?=$row['accountable_unit_name'];?></td>
											<td><?=$row['schedule_no'];?></td>
											<td><?=$row['target_waktu'];?></td>
										</tr>
									<?php 
										++$i;
									}
									?>
								</tbody>
								<tfoot>
									<tr>
										<th colspan=22>&nbsp;</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<hr>
					<?php 
				
					{ ?>
					<div class="row">
						<div class="col-md-12">
							<div class="panel-body">
								<?php echo lang('msg_field_risk_note').get_help('msg_help_risk_note');?>
								<?php 
								echo form_hidden('rcsa_no',$data['id']);
								
								echo form_textarea('notes',''," maxlength='1000' size=1000 class='form-control w100' rows='2' cols='5' style='overflow: hidden; height: 104px;' ");
														
								?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<button class="btn btn-default btn-flat center" type="submit" value="0" name="stsApp"><strong>Not APPROVE</strong></button> &nbsp;&nbsp;
							<button class="btn btn-primary btn-flat center" type="submit" value="1" name="stsApp"><strong>A P P R O V E</strong></button>
						</div>
					</div>
					<?php } ;?>
					<hr>
				</section>
			</aside>
		</div>
		</div>
	</section>
	<?php echo form_close();?>
</section><!-- /.right-side -->

<div class="modal fade bs-example-modal-sm" id="report_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:80%;margin:20px auto;">
		<div class="modal-content">
			  <div class="modal-body">
				
			  </div>
			  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="proses_select"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_select');?></button>
			  </div>
		  </div>
	  </div>
</div>

<script>
	$("#owner_no, #period_no").change(function(){
		var id_owner = $("#owner_no").val();
		var id_period = $("#period_no").val();
		var id=parseFloat(id_owner) + "-" + parseFloat(id_period);
		$("#btn-disabled").removeClass('disabled').addClass('disabled');
		cari_ajax_combo(id, 'spinner_param', 'project_no', 'ajax/get_project_name');
	});
	$("#project_no").change(function(){
		var id_project = $(this).val();
		if (id_project>0)
			$("#btn-search").removeClass('disabled');
		else
			$("#btn-search").addClass('disabled');
	});

</script>