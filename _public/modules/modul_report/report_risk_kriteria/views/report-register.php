<?php
	// $data=$setting['rcsa'][0];
	$preference=$this->session->userdata('preference');
	$title=$field['param']['param']['title'];
	$subtitle=$field['param']['param']['subtitle'];
	// doi::dump($field['param'],false,true);
	
?>
<section id="main-content">
	<section class="wrapper site-min-height">
		
	<!--state overview start-->
		<div class="row">
			<aside class="col-md-12">
				<section class="panel">
					<div class="row">
						<div class="col-md-12">
							<div class="panel-body">
								<table class="table no-padding no-margin borderless" style="width:100%;margin:0 auto;">
									<tr>
										<td rowspan="3" style="vertical-align:middle;" class="text-center">
											<img src="<?php echo img_url("logo_report.png");?>">
										</td>	
										<td rowspan="2" style="vertical-align:middle;" class="text-left">
											<strong>
												<?php echo $this->authentication->get_Preference('nama_kantor');?>
												<br><?php echo $this->authentication->get_Preference('alamat_kantor');?><br/>
											</strong>
										</td>
										<td style="width:10%;">Create Date</td>
										<td style="width:5%;">:</td>
										<td style="width:10%;"><?php echo date('d-m-Y');?></td>
									</tr>
									<tr>
										<td>Create By</td>
										<td>:</td>
										<td><strong><?php echo  $this->authentication->get_info_user('nama_lengkap');?></strong></td>
									</tr>
									<tr>
										<td colspan="4" style="vertical-align:middle;">
											<strong>&nbsp;</strong>
										</td>
									</tr>
									<tr  class="text-center">
										<td colspan="4">
											<h2><strong><?php echo $title;?></strong></h2>
											<h1><strong><?php echo $subtitle;?></strong></h1>
										</td>
									</tr>
								</table>
								<table class="table no-padding no-margin no-border" style="width:100%;margin:0 auto;">
									<tr>
										<td style="width:10%;" class="no-border">Unit Name</td>
										<td class="no-border" style="width:2%;">:</td>
										<td class="no-border"><strong><?php echo $field['param']['owner_name'];?></strong></td>
									</tr>
									<tr>
										<td class="no-border">Period</td>
										<td class="no-border" style="width:2%;">:</td>
										<td class="no-border"><strong><?php echo $field['param']['periode_name'];?></strong></td>
								</table>
								<br/>
								<table class="table table-bordered table-striped table-hover dataTable data table-small-font dt-responsive" id="datatables_event" style="font-size:10px !important;">
									<thead>
										<tr>
										<th width="5%" style="text-align:center;">No.</th>
										<th width="15%" >Assesment / Identifikasi Risiko</th>
										<th width="5%" >No</th>
										<th>Peristiwa Risiko</th>
										<th>Sebab Risiko</th>
										<th>Dampak Risiko</th>
										<th>Nilai Dampak</th>
										<th>Likehood</th>
										<th>Consequence</th>
										<th>Risk Exposure</th>
										<th>Action Plan (Mitigasi) / Accountable Unit / Target</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i=1;
										foreach($field['data'] as $keys=>$row)
										{ 
											?>
											<tr>
												<td rowspan="<?=count($row->detail['risk_event']);?>"><?php echo $i;?></td>
												<td rowspan="<?=count($row->detail['risk_event']);?>"><strong>[<?php echo $row->corporate . ']</strong><br/>&nbsp;<br/>' . $row->type;?></td>
												<?php 
												$no=1;
												foreach ($row->detail['risk_event'] as $key=>$sub){
													$nil_inherent_likelihood=explode('#',$row->detail['inherent_likelihood'][$key]);
													$nil_inherent_impact=explode('#',$row->detail['inherent_impact'][$key]);
													$exposure=floatval($row->detail['nilai_dampak'][$key]) * ($nil_inherent_impact[0]/100);
													
													if (count($nil_inherent_likelihood)>1)
														$nil_inherent_likelihood=$nil_inherent_likelihood[1];
													else
														$nil_inherent_likelihood='';
													
													if (count($nil_inherent_impact)>1)
														$nil_inherent_impact=$nil_inherent_impact[1];
													else
														$nil_inherent_impact='';
													
													
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
														<td class="text-center"><?=$nil_inherent_likelihood;?></td>
														<td class="text-center"><?=$nil_inherent_impact;?></td>
														<td class="text-right"><?=number_format($exposure);?></td>
														<td>
														<?php
															if(count($row->detail['action'][$sub['id']])>0) {
															?>
															<table class="table">
															<thead>
															<tr>
																<th>Mitigasi</th>
																<th>Accountable Unit</th>
																<th>Target</th>
															</tr>
															</thead>
															<tbody>
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
															</tbody>
															</table>
															<?php } ?>
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
									</tbody>
								</table>
								<div id="loading" class="loading-img hide"></div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 text-center">
							<a href="<?php echo base_url('report-risk-register/cetak-report/pdf/'.$id_parent);?>" data-toggle="modal" class="btn btn-danger btn-flat btn-large"><strong><i class="fa fa-file-pdf-o"></i> Print to PDF </strong></a> 
							<a href="<?php echo base_url('report-risk-register/cetak-report/excel/'.$id_parent);?>" data-toggle="modal" class="btn btn-danger btn-flat btn-large"><strong><i class="fa fa-file-excel-o"></i> Print to MS-Excel </strong></a>
						</div>
					</div>
					<hr>
				</section>
			</aside>
		</div>
	</section>
</section><!-- /.right-side -->