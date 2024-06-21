    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
        <a href="../../index2.html"><b><?=$this->authentication->get_Preference('nama_kantor');?></b></a>
      </div>
      <!-- User name -->
      <div class="lockscreen-name"><strong><?=$this->authentication->get_Info_User('nama_lengkap');?></strong></div>

      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
          <img src="<?php echo staft_url($this->authentication->get_info_user('photo'));?>" class="img-circle" alt="User Image" />
        </div>
        <!-- /.lockscreen-image -->

        <!-- lockscreen credentials (contains the form) -->
       <?php  
			$option = array('class' => 'lockscreen-credentials', 'id' => 'form_login');
			echo form_open('lock-screen/open-lock',$option); ?>
          <div class="input-group" style="width:100% !important;">
            <input type="password" class="form-control" placeholder="password" style="width:100% !important" autocomplete="off" value="" name="sandi">
            <div class="input-group-btn">
              <button class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
            </div>
          </div>
        <?=form_close();?><!-- /.lockscreen credentials -->

      </div><!-- /.lockscreen-item -->
      <div class="help-block text-center">
        Enter your password to retrieve your session
      </div>
      <div class="text-center">
        <a href="<?=base_url('auth/logout');?>">Or sign in as a different user</a>
      </div>
      <div class="lockscreen-footer text-center">
			<strong><?=$this->authentication->get_Preference('judul_bawah').'<br/>';?></strong>
		  <?=$this->authentication->get_Preference('alamat_kantor').' ';?>
		  <i class="fa fa-phone"></i> <?=$this->authentication->get_Preference('telp_kantor').' ';?>
		  <i class="fa fa-envelope"></i> <?=$this->authentication->get_Preference('email_kantor').'<br/>';?>
      </div>
    </div><!-- /.center -->