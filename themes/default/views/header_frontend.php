<?php
	$active[1]='';
	$active[2]='';
	$active[3]='';
	$active[4]='';
	
	$uri = explode("/",$this->uri->uri_string);
	if (count($uri)>2){
		if ($uri[2]=='puskesmas'){
			$active[1]=' active ';
		}elseif ($uri[2]=='rs'){
			$active[2]=' active ';
		}elseif ($uri[2]=='lab'){
			$active[3]=' active ';
		}elseif ($uri[2]=='ebs'){
			$active[4]=' active ';
		}
	}else{
		$active[1]=' active ';
	}
?>
<header class="site-header headerfirst">
	<!-- Header Top -->
	<div class="header-top">
		<div class="container clearfix">
			<!--Top Left-->
			<div class="top-left pull-left">
				<ul class="links-nav clearfix">
					<li><a href="<?=base_url();?>"><?=nl2br($this->authentication->get_Preference('judul_atas_motto'));?></a></li>
				</ul>
			</div>

			<!--Top Right-->
			<div class="top-right pull-right">
				<div class="social-links clearfix">
					<a href="<?=base_url('auth');?>"> Masuk </a>
				</div>
			</div>
		</div>
	</div>
	<!-- Header Top End -->

	<!--Header-Main-->
	<div class="header-main" style="padding:0px 0 0;">
		<div class="container" style="padding-top:10px;">
			<div style="background-color:#ffffff;padding:15px;">
			<div class="row">
				<div class="col-sm-2 text-center">
					<div class="logo">
						<a href="<?=base_url();?>"><img src="<?=img_url('logo.png');?>" width="80"></a>
					</div>
				</div>
				<div class="col-sm-8 text-center" style="color:#00000;">
					<strong><?=nl2br($this->authentication->get_Preference('judul_awal'));?></strong>
				</div>
				<div class="col-sm-2 text-center">
					<div class="logo">
						<a href="<?=base_url();?>"><img src="<?=img_url('logo-surv.jpg');?>" width="80"></a>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>

	<!--Header-Lower-->
	<div class="header-lower">
		<div class="container">
			<div class="nav-outer clearfix">
				<!-- Main Menu -->
				<nav class="main-menu">
					<div class="navbar-header">
						<!-- Toggle Button -->
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>

					<div class="navbar-collapse collapse clearfix">
						<ul class="navigation clearfix">
							<li class="<?=$active[1];?>"><a class="text-center" href="<?=base_url('home/skdr/puskesmas');?>"><?=lang('msg-menu-puskesmas');?></a></li>
							<li class="<?=$active[2];?>"><a href="<?=base_url('home/skdr/rs');?>"><?=lang('msg-menu-rs');?></a></li>
							<li class="<?=$active[3];?>"><a href="<?=base_url('home/skdr/lab');?>"><?=lang('msg-menu-lab');?></a></li>
							<li class="<?=$active[4];?>"><a href="<?=base_url('home/skdr/ebs');?>"><?=lang('msg-menu-ebs');?></a></li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
	</div>

	<!--Sticky Header-->
	<div class="sticky-header hide">
		<div class="auto-container clearfix">
			<!--Logo-->
			<div class="logo pull-left">
				<a href="<?=base_url();?>" class="img-responsive">
					<img src="<?=img_url('logo.png');?>" alt="Transpo" title="Transpo" width="45">
				</a>
			</div>

			<!--Right Col-->
			<div class="right-col pull-right">
				<!-- Main Menu -->
				<nav class="main-menu">
					<div class="navbar-header">
						<!-- Toggle Button -->
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>

					<div class="navbar-collapse collapse clearfix">
						<ul class="navigation clearfix">
							<li><a href="<?=base_url('skdr/puskesmas');?>">SKDR Puskesmas</a></li>
							<li><a href="<?=base_url('skdr/rs');?>">SKDR Rumah Sakit</a></li>
							<li><a href="<?=base_url('skdr/lab');?>">SKDR Laboratorium</a></li>
							<li><a href="<?=base_url('skdr/ebd');?>">Surveilans Berbasis Kejadian (EBS)</a></li>
						</ul>
					</div>
				</nav>
				<!-- Main Menu End-->
			</div>
		</div>
	</div>
	<!--End Sticky Header-->
</header>