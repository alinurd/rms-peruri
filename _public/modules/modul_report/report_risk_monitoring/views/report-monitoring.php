<?php
	// $data=$setting['rcsa'][0];
	$id_parent = $this->uri->segment(3);
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
										<td class="no-border"><strong><?php echo $field['owner_name'];?></strong></td>
									</tr>
									<tr>
										<td class="no-border">Period</td>
										<td class="no-border" style="width:2%;">:</td>
										<td class="no-border"><strong><?php echo $field['periode_name'];?></strong></td>
									<tr>
										<td class="no-border">Cut-off Date</td>
										<td class="no-border" style="width:2%;">:</td>
										<td class="no-border"><strong></strong></td>
								</table>
								<table class="table no-padding no-margin table-bordered table-hover table-striped" style="width:100%;margin:0 auto;">
									<thead>
									<tr>
										<th width="5%">No.</th>
										<th>Assesment</th>
									<?php 
										$judul=array();
										foreach($field as $key=>$jdl){
										if ($key=='param'){
											if ($jdl['sts_risk_detail']==1){$judul[]='Risk Details';}
											if ($jdl['sts_risk_level']==1){$judul[]='Analisis';}
											$judul[]='Mitigation Plan';
											if ($jdl['sts_action_plan']==1){$judul[]='Action Detail';}
											$judul[]='Progress Date';
											if ($jdl['sts_progress']==1){$judul[]='Progress Mitigation';}
											if ($jdl['sts_attachment']==1){$judul[]=' Attachment';}
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
											$content .= '<td>'.$row['corporate'].'</td>';
											
											if (array_key_exists('event_no', $row)){
												if (!empty($row['event_no'][0]))
													$content .= '<td style="vertical-align:middle;">'.$row['event_no'][0]['name'].'</td>';
											}
											if (array_key_exists('risk_level', $row)){
												$color=(array_key_exists('color', $row['risk_level']))?$row['risk_level']['color']:"";
												$color_text=(array_key_exists('color_text', $row['risk_level']))?$row['risk_level']['color_text']:"";
												$level = (array_key_exists('level_mapping', $row['risk_level']))?$row['risk_level']['level_mapping']:"-";
												
												$content .= '<td class="text-center" style="vertical-align:middle;color:'.$color_text.';background-color:'.$color.'">'.$level.'</td>';
											}
											if (array_key_exists('title', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['title'].'</td>';
											}
											if (array_key_exists('description', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.$row['description'].'</td>';
											}
											if (array_key_exists('progress_date', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.date('d-m-Y',strtotime($row['progress_date'])).'</td>';
											}
											if (array_key_exists('progress', $row)){
												$content .= '<td class="text-center" style="vertical-align:middle;">'.number_format($row['progress']).' %</td>';
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
								
								<table class="table no-padding no-margin no-border hide" style="width:100%;margin:0 auto;">
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
							<a href="<?php echo base_url('report-risk-monitoring/cetak-report/pdf/'.$id_parent);?>" data-toggle="modal" class="btn btn-danger btn-flat btn-large"><strong><i class="fa fa-file-pdf-o" target="_blank"></i> Print to PDF </strong></a> 
							<a href="<?php echo base_url('report-risk-monitoring/cetak-report/excel/'.$id_parent);?>" data-toggle="modal" class="btn btn-danger btn-flat btn-large"><strong><i class="fa fa-file-excel-o" target="_blank"></i> Print to MS-Excel </strong></a>
						</div>
					</div>
					<hr>
				</section>
			</aside>
		</div>
	</section>
</section><!-- /.right-side -->