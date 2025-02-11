 <?php 
	$modul='';
	if (isset($_GET['module'])){
		$modul=$_GET['module'];
		$modul=explode('+', $modul);
		$modul=$modul[count($modul)-1];
	}
	
	$gender = $this->authentication->get_Info_User('kelamin');
	$user_photo = $this->authentication->get_Info_User('photo');
	$photo = $this->authentication->get_Preference('list_photo');
	$term = $this->authentication->get_Preference('term');
	$tahun = $this->authentication->get_Preference('tahun');
	$group = $this->authentication->get_Info_User('group');
	$group = $group['owner'];
	if (!$photo){
		$photo = img_url('logo.png');
	}else{
		if (file_exists(staft_path_relative($user_photo)) && !empty($user_photo)){
			$photo = staft_url($user_photo);
		}else{
			$photo = img_url('male.png');
			// if ($gender=="P")
			// 	$photo = base_url('/themes/defult/assets/images/logo-white.png');
		}
	}
	// $photo = base_url('/themes/defult/assets/images/logo-white.png');

 ?>
 <div class="col-md-3 left_col">
  <div class="left_col scroll-view">
	<div class="navbar nav_title" style="border: 0;">
	  <a href="<?=base_url();?>" class="site_title" style="text-align:center;">
	  	<div style="background-color:white;">
			<img src="<?=img_url('logo-white.png');?>" width="50">
		</div>
		<span><?=$this->authentication->get_Preference('judul_atas');?></span></a>
	</div> 

	<div class="clearfix"></div>

	<!-- menu profile quick info -->
	<div class="profile clearfix">
	  <div class="profile_pic">
		<img src="<?=$photo;?>" alt="..." class="img-circle profile_img">
	  </div>
	  <div class="profile_info">
		<span>Welcome,</span>
		<h2><?=$this->authentication->get_Info_User('nama_lengkap');?></h2><strong>
		<?php
		if (array_key_exists('owner_name',$group))
			echo '<span class="text-center" style="width:100%;color:#ffffff;">- '.$group['posisi'].' -</span><br/>';
		?>
		</strong>
		<div class="label label-warning pointer" style="width:100%;" id="term_aktif"> <?=$term['nama'].' tahun '.$tahun['nama'];?> </div>
	  </div>
	</div>
	<!-- /menu profile quick info -->
	<?php
		if (array_key_exists('owner_name',$group)){?>
		<div class="pointer" style="width:90%;text-align:center;display:block;color:#ffffff;margin:0 auto; border-bottom:1px solid #E6E9ED;padding-bottom:15px;">
			<strong>
			<?=trim($group['owner_name']);?><br/>
			</strong>
		</div>
		<?php } ?>
	<br />
	<!-- sidebar menu -->
	<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	  <div class="menu_section">
		<h3>MENU UTAMA</h3>
		<?php echo _build_menu('kiri');?>
	  </div>
	</div>
	<!-- /sidebar menu -->

	<!-- /menu footer buttons -->
	<div class="sidebar-footer hidden-small" style="display: flex; justify-content: center; align-items: center;">
    <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?=base_url('auth/logout');?>">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
    <!-- Jika Anda ingin menambahkan kembali elemen yang dikomentari, Anda bisa melakukannya di sini
    <a data-toggle="tooltip" data-placement="top" title="Frequently asked questions (FAQ)" href="<?=base_url('faq');?>">
        <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen full_screen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" href="<?=base_url('lock-screen' . '?redirect_to=' . current_url());?>">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    -->
</div>
	<!-- /menu footer buttons -->
  </div>
</div>
<script >
	var data="";
	var sts=0;
	var modul="";
	for(i=1;i<4;i++){
		if (i==1){
			modul ="<?php echo $this->uri->segment(1);?>";
		}else if (i==2){
			modul ="<?php echo $this->uri->segment(1) . '/' . $this->uri->segment(2);?>";
		}else if (i==3){
			modul ="<?php echo $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3);?>";
		}
		
		$('ul.side-menu').each(function() {
			$(this).find('li').each(function(){
				data = $(this).attr('data-modul');
				if (data==modul){
					$(this).addClass('active');
					$(this).parent().closest("li").addClass("active");
					$(this).parent().parent().closest("li").addClass("active");
					$(this).parent().parent().parent().closest("li").addClass("active");
					$(this).parent().parent().parent().parent().closest("li").addClass("active");
					$(this).parent().parent().parent().parent().parent().closest("li").addClass("active");
					
					$(this).parent().closest("ul").css({'display':'block'});
					$(this).parent().closest("ul").closest("ul").css({'display':'block'});
					
					sts=1;
					return false;
				}
			});
		});	
		if(sts==1)
			i=100;
	}
</script>