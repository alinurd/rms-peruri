<?php
	$CI=& get_instance(); 
	// $this->authentication->set_notif();
	$lang = $this->authentication->get_Language();
	$kiri=_build_menu('atas-kiri');
	$kanan=_build_menu('atas-kanan');
	$lang_active=$this->session->userdata('bahasa');
	if (empty($lang_active))
		$lang_active=$this->config->item('language');
	$kiri_hide="hide";
	if(count($this->authentication->get_Menus('atas-kiri'))>0){
		$kiri_hide="";
	}elseif(count($this->authentication->get_Menus('atas-kanan'))>0){
		$kiri_hide="hide";
	}
	
	$photo = $this->authentication->get_Preference('list_photo');
	if (!$photo){
		$photo = img_url('blc.jpg');
	}else{
		$photo = staft_url($this->authentication->get_info_user('photo'));
	}
	
	$notif = '<li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 4 messages</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- start message -->
                        <a href="#">
                          <div class="pull-left">
                            <img src="'.staft_url($this->authentication->get_Info_User('photo')).'" width="45" class="img-circle" alt="User Image"/>
                          </div>
                          <h4>
                            Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li><!-- end message -->
                    </ul>
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>';
	
	if ($this->authentication->is_admin()){ 
        $notif .='<li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-exclamation-triangle"></i>
                  <span class="label label-warning">'.$this->authentication->get_notif_error().'</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">'.$this->authentication->get_notif_error(1).'</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">'; 
						$jml_max=intval($this->authentication->get_Preference('max_notif_debug'));
						$no=1;
						foreach($this->authentication->get_notif_error(2) as $row)
						{
							$post_date = $row->created_at;
							$tgl=time_ago($post_date);
							$notif .='<li>
								<a href="'.base_url('debug/view/' . $row->id).'" target="_blank">
									<div class="pull-left">
									<i class="fa fa-warning text-yellow"></i>
									</div>
								  <h4>
									 '.$row->priority_name.'
								  </h4>
								  <small>
									<i class="fa fa-user"></i> '.$row->user.' | 
									<i class="fa fa-clock-o"></i> '.$tgl.'
								</small>
								</a>
							  </li>';
							$no++;
							if ($no>$jml_max)
								break;
						}
                    $notif .='</ul>
                  </li>
                  <li class="footer"><a href="'.base_url('debug').'">View all</a></li>
                </ul>
              </li>';
	}
	
	// if ($this->authentication->get_Preference('notif')=='0'){$notif='';}
?>

<div class="top_nav">
  <div class="nav_menu">
	<nav>
	  <div class="nav toggle">
		<a id="menu_toggle"><i class="fa fa-bars"></i></a>
	  </div>
	 <!-- <ul class="nav navbar-nav">
		<li class="">
		<a href="">test saja</a>
		</li>
	</ul> -->
	  <ul class="nav navbar-nav navbar-right">
		<li class="">
		  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			<img src="images/img.jpg" alt=""><?=$this->authentication->get_Info_User("nama_lengkap");?>
			<span class=" fa fa-angle-down"></span>
		  </a>
		  
		  <ul class="dropdown-menu dropdown-usermenu pull-right">
			<li><a href="<?=base_url('profile');?>"> Profile</a></li>
			<li><a href="<?php echo base_url('change-password');?>"><?=lang('msg_tombol_change_pass');?></a></li>
			<li> <a href="<?php echo base_url('Panduan.pdf');?>">Help</a></li>
			<li> <a href="<?php echo base_url('auth/logout');?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
		  </ul>
		</li>
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('msg_bahasa');?> &nbsp;<i class="fa fa-sort-desc buka"></i></a>
			<ul class="dropdown-menu" role="menu">
				<li class="">
					<a href="<?php echo base_url();?>auth/language/english?redirect_to=<?php echo urlencode(current_url())?>"><img src="<?php echo img_url('lang-english.png');?>">&nbsp;English</a>
				</li>
				<li class="">
					<a href="<?php echo base_url();?>auth/language/id?redirect_to=<?php echo urlencode(current_url())?>"><img src="<?php echo img_url('lang-indonesia.png');?>">&nbsp;Indonesia</a>
				</li>
			</ul>
			</li>
         <?=$kanan;?>
	  </ul>
	</nav>
  </div>
</div>