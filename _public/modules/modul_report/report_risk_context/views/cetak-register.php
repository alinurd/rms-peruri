<?php
	// $data=$setting['rcsa'][0];
	$preference=$this->session->userdata('preference');
	$title=$field['param']['title'];
	$subtitle=$field['param']['subtitle'];
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
											<strong><h2>Risk Register Report</h2></strong>
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
										<td class="no-border"><strong><?php echo $field['owner_name'];?></strong></td>
									</tr>
									<tr>
										<td class="no-border">Period</td>
										<td class="no-border" style="width:2%;">:</td>
										<td class="no-border"><strong><?php echo $field['periode_name'];?></strong></td>
								</table>
								<table class="table no-padding no-margin table-bordered table-hover table-striped" style="width:100%;margin:0 auto;">
									<thead>
									<tr>
										<th width="5%">No.</th>
									<?php 
										$judul=array();
										foreach($field as $key=>$jdl){
										if ($key=='param'){
										if ($jdl['sts_risk_event']==1){$judul[]='Risk Event';}
										if ($jdl['sts_risk_couse']==1){$judul[]='Risk Cause';}
										if ($jdl['sts_risk_impact']==1){$judul[]='Risk Impact';}
										if ($jdl['sts_risk_type']==1){$judul[]='Risk Type';}
										if ($jdl['sts_risk_owner']==1){$judul[]='Risk Owner';}
										if ($jdl['sts_risk_controls']==1){$judul[]='Internal Control';}
										if ($jdl['sts_risk_level']==1){$sts_risk_controls='risk_rcsa_detail.risk_level';}
										if ($jdl['sts_residual_risk_level']==1){$judul[]='Residual Analisis';}
										if ($jdl['sts_action']==1){$judul[]='Action Plan Detail';}
										if ($jdl['sts_progress']==1){$judul[]='Action Plan Progress';}
										}
									}
									foreach($judul as $row){ ?>
										<th><?php echo $row;?></th>
									<?php } ?>
									</tr>
									</thead>
									<tbody>
										
										<?php
										$content='';
										$i=0;
										foreach($setting as $key=>$row){
											$content .= '<tr style="vertical-align:middle;">';
											$content .= '<td>'.++$i.'</td>';
											if (array_key_exists('event_no', $row)){
												$content .= '<td style="vertical-align:middle;">'.$row['event_no'][0]['name'].'</td>';
											}
											if (array_key_exists('risk_couse_no', $row)){
												$xx=array();
												foreach($row['risk_couse_no'] as $tmp){ $xx[]=$tmp['name']; }
												$tmp=implode('<br>',$xx);
												$content .= '<td style="vertical-align:middle;">'.$tmp.'</td>';
											}
											if (array_key_exists('risk_impact_no', $row)){
												$xx=array();
												foreach($row['risk_impact_no'] as $tmp){ $xx[]=$tmp['name']; }
												$tmp=implode('<br>',$xx);
												$content .= '<td style="vertical-align:middle;">'.$tmp.'</td>';
											}
											// if (array_key_exists('risk_type_no', $row)){
												// $xx=array();
												// foreach($row['risk_type_no'] as $tmp){ $xx[]=$tmp[0]['type']; }
												// $tmp=implode('<br>',$xx);
												// $content .= '<td style="vertical-align:middle;">'.$tmp.'</td>';
											// }
											if (array_key_exists('owner_no', $row)){
												$xx=array();
												foreach($row['owner_no'] as $tmp){ $xx[]=($tmp)?$tmp[0]['name']:''; }
												$tmp=implode('<br>',$xx);
												$content .= '<td style="vertical-align:middle;">'.$tmp.'</td>';
											}
											if (array_key_exists('control_no', $row)){
												$xx=array();
												$control=json_decode($row['control_no'],TRUE);
												if ($control){
													foreach($control as $tmp){ $xx[]=$tmp; }
												}
												$tmp=implode('<br>',$xx);
												$content .= '<td style="vertical-align:middle;">'.$tmp.'</td>';
											}
											if (array_key_exists('risk_level', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['risk_level'].'</td>';
											}
											if (array_key_exists('title', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['title'].'</td>';
											}
											if (array_key_exists('progress', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['progress'].'</td>';
											}
											
											$content .='</tr>';
										}
										echo $content;
										?>
									</tbody>
								</table>
								
								<table class="table no-padding no-margin no-border" style="width:100%;margin:0 auto;">
									<tr>
										<td class="no-border">&nbsp;</td>
										<td  style="width:20%;" class="no-border text-center">
											<?=date('d-m-Y');?><br/>
											( <?php echo $field['param']['position'];?> )
										</td>
									</tr>
									<tr>
										<td class="no-border">&nbsp;</td>
										<td class="no-border text-center">
											<?php echo $field['param']['person_name'];?>
										</td class="no-border">
								</table>
								<div id="loading" class="loading-img hide"></div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 text-center">
							<a href="<?php echo base_url('report-risk-map/cetak-report/pdf/'.$id_parent);?>" data-toggle="modal" class="btn btn-danger btn-flat btn-large"><strong><i class="fa fa-file-pdf-o"></i> Print to PDF </strong></a> 
							<a href="<?php echo base_url('report-risk-map/cetak-report/excel/'.$id_parent);?>" data-toggle="modal" class="btn btn-danger btn-flat btn-large"><strong><i class="fa fa-file-excel-o"></i> Print to MS-Excel </strong></a>
						</div>
					</div>
					<hr>
				</section>
			</aside>
		</div>
	</section>
</section><!-- /.right-side -->