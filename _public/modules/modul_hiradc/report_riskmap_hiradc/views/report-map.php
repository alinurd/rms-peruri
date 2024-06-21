<?php
	// $data=$setting['rcsa'][0];
	$preference=$this->session->userdata('preference');
	if ($field['param']['title_sts']=="default"){
		$title=$field['param']['title_default'];
	}elseif ($field['param']['title_sts']=="custom"){
		$title=$field['param']['title_custom'];
	}
	$subtitle="";
	if ($field['param']['subtitle_sts']=="default"){
		$subtitle=$field['param']['subtitle_default'];
	}elseif ($field['param']['subtitle_sts']=="custom"){
		$subtitle=$field['param']['subtitle_custom'];
	}
	
	$position=$field['param']['sign_position'];
	if ($field['param']['sign_sts']=="default"){
		$sign=$field['param']['sign_default'];
	}elseif ($field['param']['sign_sts']=="custom"){
		$sign=$field['param']['sign_custom'];
	}else{
		$sign="";
	}
	
?>
<section id="main-content">
	<section class="wrapper site-min-height">
		
	<!--state overview start-->
		<div class="row">
			<aside class="profile-info col-md-12">
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
										<td style="width:10%;">Unit Name</td>
										<td style="width:3%;">:</td>
										<td style="width:10%;"><strong><?=$field['owner_name'];?></strong></td>
										<td style="width:10%;">Create Date</td>
										<td style="width:3%;">:</td>
										<td style="width:10%;"><strong><?php echo date('d-m-Y');?></strong></td>
									</tr>
									<tr>
										<td style="width:10%;">Period</td>
										<td style="width:3%;">:</td>
										<td style="width:10%;"><strong><?=$field['periode_name'];?></strong></td>
										<td>Create By</td>
										<td style="width:3%;">:</td>
										<td><strong><?php echo  $this->authentication->get_info_user('nama_lengkap');?></strong></td>
									</tr>
									<tr>
										<td colspan="7"><h2 style="margin:0px;padding:0px;" class="hide">Adhi Risk Map</h2></td>
									</tr>
									<tr  class="text-center">	
										<td colspan="8">
											<h2><strong><?php echo $title;?></strong></h2>
											<h2><strong><?php echo $subtitle;?></strong></h2>
										</td>
									</tr>
								</table>
								<div class="row">
									<div class="col-md-6">
										<?=draw_map($setting,50,'inherent',array('title'=>$title,'sub_title'=>$subtitle,'level_title'=>1));
										$total=0;
										foreach($setting['tbl']['inherent']['jml'] as $row){
											foreach($row['isi'] as $isi){
												$total +=intval($isi['jml']);
											}
										}
										echo "<br/><div class='text-center'>Jumlah Risiko : <label class='label label-primary'> " . $total . '</span></div>';
										?>
									</div>
									<div class="col-md-6">
										<?=draw_map($setting,50, 'residual',array('title'=>$title,'sub_title'=>$subtitle,'level_title'=>1));
										
										$total=0;
										foreach($setting['tbl']['residual']['jml'] as $row){
											foreach($row['isi'] as $isi){
												$total +=intval($isi['jml']);
											}
										}
										echo "<br/><div class='text-center'>Jumlah Risiko : <label class='label label-danger'> " . $total . '</span></div>';
										?>
									</div>
								</div>
								<table class="table no-padding no-margin no-border" style="width:100%;margin:0 auto;">
									<tr>
										<td style="width:10%;" class="no-border">&nbsp;</td>
										<td class="no-border" style="width:2%;">&nbsp;</td>
										<td class="no-border"><strong>&nbsp;</strong></td>
										<td class="no-border"> &nbsp;</td>
										<td  rowspan="2" style="width:20%;" class="no-border text-center">
											&nbsp;<br/>
										</td>
									</tr>
									<tr>
										<td class="no-border">&nbsp;</td>
										<td class="no-border" style="width:2%;">&nbsp;</td>
										<td class="no-border"><strong></strong></td>
										<td class="no-border"> &nbsp;</td>
									</tr>
									<tr>
										<td colspan="4" class="no-border"> &nbsp;</td>
										<td class="no-border text-center">
											<?php echo $sign;?>
										</td class="no-border">
									</tr>
								</table>
								<div id="loading" class="loading-img hide"></div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 text-center">
							<a href="<?php echo base_url('report-risk-map/cetak-report/'.$id_parent);?>" data-toggle="modal" class="btn btn-danger btn-flat btn-large"><strong><i class="fa fa-file-pdf-o"></i> Print to PDF </strong></a>
						</div>
					</div>
					<hr>
				</section>
			</aside>
		</div>
	</section>
</section><!-- /.right-side -->