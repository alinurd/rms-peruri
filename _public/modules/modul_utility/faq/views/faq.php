<section id="main-content">
	<section class="wrapper site-min-height">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
					<li> <a href="<?php echo base_url();?>"> <i class="fa fa-home"></i> <?php echo lang('msg_breadcrumb_home');?></a></li>
					<li><a href="#"><?php echo lang('msg_title');?></a></li>
				</ul>
			</div>
		</div>
		
		<div class="x_panel">
			<div class="row">
				<div class="col-12">
					<div class="x_content">
						<div class="row">
							<div class="col-md-3">
								<ul class="ver-inline-menu tabbable margin-bottom-10">
									<?php
									$no=0;
									foreach($faq as $key=>$row):
									$kel=explode('#', $key);
									$active= '';
									if ($no==0)
										$active= 'active';
									++$no;
									?>
									<li class="<?=$active;?>">
										<a data-toggle="tab" href="#tab_<?=$kel[0]?>">
										<i class="fa fa-briefcase"></i> <?=$kel[1];?> <span class="badge badge-warning pull-right" style="margin-top:10px;margin-right:10px;"><?=count($row);?></span></a>
										<?php
										if (!empty($active)):?>
										<span class="after"></span>
										<?php endif;?>
									</li>
									<?php
									endforeach;?>
								</ul>
							</div>
							<div class="col-md-9">
								<div class="tab-content">
									<?php
									$no=0;
									foreach($faq as $key=>$row):
										$kel=explode('#', $key);
										$active= '';
										if ($no==0)
											$active= 'active';
										++$no;
										?>
									<div id="tab_<?=$kel[0];?>" class="tab-pane <?=$active;?>">
										<div id="accordion<?=$kel[0];?>" class="panel-group">
											<?php
											foreach ($row as $kelx=>$rok):?>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?=$kel[0];?>" href="#accordion<?=$kel[0];?>_<?=$kelx;?>">
													<strong><?=$rok['judul'];?></strong></a><span class="pull-right" style="font-size:11px;"><small><em><i class="fa fa-user text-warning"></i> <?=$rok['create_user'];?> &nbsp;&nbsp;<i class="fa fa-calendar text-info"></i> <?=time_ago($rok['create_date']);?></small></em><span>
													</h4>
												</div>
												<div id="accordion<?=$kel[0];?>_<?=$kelx;?>" class="panel-collapse collapse">
													<div class="panel-body">
														 <?=nl2br($rok['faq']);?>
														 <div class="alert alert-warning" style="bottom:0px;margin-top:50px;margin-bottom:0px;">
															Apakah Informasi ini membantu anda ? <span class="pull-right pointer"><span class="label label-default"> Ya </span> &nbsp;&nbsp;&nbsp;<span class="label label-default"> Tidak </span></span>
														 </div>
													</div>
												</div>
											</div>
											<?php
											endforeach;?>
										</div>
									</div>
									<?php
									endforeach;?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT INNER -->
	</section>
</section>