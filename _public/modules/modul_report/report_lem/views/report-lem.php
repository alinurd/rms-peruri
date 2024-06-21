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
			<aside class="profile-info col-md-12">
				<section class="panel">
					<div class="row">
						<div class="col-md-12">
							<div class="panel-body bio-graph-info">
								<table class="table no-padding no-margin borderless" style="width:100%;margin:0 auto;">
									<tr>
										<td rowspan="2" style="vertical-align:middle;" class="text-center">
											<strong><h2>Risk LEM Report</h2></strong>
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
									<tr  class="text-center">
										<td colspan="4">
											<h2><strong><?php echo $title;?></strong></h2>
											<h1><strong><?php echo $subtitle;?></strong></h1>
										</td>
									</tr>
								</table>
								<table class="table no-padding no-margin table-bordered table-hover table-striped" style="width:100%;margin:0 auto;">
									<thead>
									<tr>
										<th width="5%">No.</th>
									<?php 
										$judul=array();
										foreach($field as $key=>$jdl){
										if ($key=='param'){
										if ($jdl['sts_risk_owner']==1){$judul[]='Risk Owner';}
										if ($jdl['sts_lost_event']==1){$judul[]='Lost Event';}
										if ($jdl['sts_amount']==1){$judul[]='Amount';}
										if ($jdl['sts_cause']==1){$judul[]='Cause';}
										if ($jdl['sts_date']==1){$judul[]='Date';}
										if ($jdl['sts_action_plan']==1){$judul[]='Action Plan';}
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
										// doi::dump($setting);
										foreach($setting as $key=>$row){
											$content .= '<tr style="vertical-align:middle;">';
											$content .= '<td>'.++$i.'</td>';
											if (array_key_exists('name', $row)){
												$content .= '<td style="vertical-align:middle;">'.$row['name'].'</td>';
											}
											if (array_key_exists('loss_description', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['loss_description'].'</td>';
											}
											if (array_key_exists('amount', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['amount'].'</td>';
											}
											if (array_key_exists('cause_description', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['cause_description'].'</td>';
											}
											if (array_key_exists('date', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['date'].'</td>';
											}
											if (array_key_exists('action_plan', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['action_plan'].'</td>';
											}
											
											if (array_key_exists('attach', $row)){
												$xx=array();
												$control=json_decode($row['attach'],TRUE);
												$tmp=array();
												if (count($control)>0){
													foreach($control as $tmp){ $xx[]=$tmp['real_name']; }
												}
												$tmp=implode('<br>',$xx);
												$content .= '<td style="vertical-align:middle;">'.$tmp.'</td>';
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
											<?php echo $preference['kota_kantor'].', '.date('d-m-Y');?><br/>
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
							<button class="btn btn-primary btn-flat"><strong>PDF</strong></button>
							<button class="btn btn-primary btn-flat"><strong>Ms - Excel</strong></button>
						</div>
					</div>
					<hr>
				</section>
			</aside>
		</div>
	</section>
</section><!-- /.right-side -->