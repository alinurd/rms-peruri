<?php 
	$err="";
	$hide="top";
	$option = array('class' => 'form-signin', 'id' => 'form_login');
	if ($this->session->userdata('result_login')){
		$err = $this->session->userdata('result_login');
		$this->session->set_userdata('result_login','');
		$hide="";
	}
	if (validation_errors()){
		$err = validation_errors();
		$hide = "";
  }
?>
<!-- ALERT -->
<div class="error <?=$hide;?>">

  <div class="text-center"><strong>Error: </strong></div>
	<div class="text-center"><?= $err; ?></div>
</div>
<div class="text-center box-login">
    <div class="etc-logo-login" style="background-image: <?php img_url('logo-white.png');?>"></div>
    <div class="logo"><?=$this->authentication->get_Preference('judul_atas');?></div>
    <div>
        	
        </div>
    <div class="login-form-1">
    	
    	<?php  echo form_open('auth/login', $option); ?>
        <!-- <form id="login-form" class="text-left"> -->
            <div class="main-login-form">
                <div class="login-group">
                    <div class="form-group">
                        <label for="lg_username" class="sr-only"><i class="fa fa-key fa-fw"></i>Username</label>
                        <input name="username" class="form-control" type="text" placeholder="username/email/nip" autocomplete="new-username">
                    </div>
                    <div class="form-group">
                        <label for="lg_password" class="sr-only">Password</label>
                        <input  name="password" class="form-control" type="password" placeholder="password" autocomplete="new-password">
                    </div>
                </div>
                <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
            </div>
        </form>
        <div class="etc-login-form hide">
            
                <button data-toggle="modal" data-target="#knowledge-password" class="button-evnt" data-toggle="tooltip" title="Panduan Lupa Password">
                    <i class="fa fa-info fa-fw"></i>
                </button>

                <button data-toggle="modal" data-target="#forgot-password" class="button-evnt" data-toggle="tooltip" title="Forgot Password">
                    <i class="fa fa-key fa-fw"></i>
                </button>
            
                <button data-toggle="modal" data-target="#risk-news" class="button-evnt" data-toggle="tooltip" title="Risk News">
                    <i class="fa fa-newspaper-o fa-fw"></i>
                </button>
        </div>
    </div>
</div>

<!-- panduan lupa password -->
  <div class="modal fade" id="knowledge-password" role="dialog">
    <div class="modal-dialog">
    
      <!-- content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Forgot Password</h4>
        </div>
        <div class="modal-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Step</th>
                        <th style="width: 130%;">Screenshoot</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td style="position: relative;">
                            <div style="position: relative; box-sizing: border-box;">
                                <img src="https://www.hostinger.com/tutorials/wp-content/uploads/sites/2/2017/09/wordpress-tutorial.jpg" alt="">
                            </div>
                        </td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum voluptate, modi expedita magni explicabo. Aspernatur accusamus ipsam reprehenderit quis unde. Beatae ducimus dolore repudiandae, quod maxime, tenetur blanditiis praesentium. Dicta!</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="forgot-password" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Forgot Password</h4>
        </div>
        <div class="modal-body">
	        <div class="form-group">
			  	<label for="usr">Email</label>
			  	<input type="text" class="form-control" id="usr" style="width: 300px;">
			</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<!-- Risk news -->
  <div class="modal fade" id="risk-news" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center">RISK NEWS</h4>
        </div>
        <div class="modal-body" style="padding: 0; padding-left: 5px; padding-right: 5px">
	        <table class="table data">
	        	<thead>
	        		<tr>
	        			<th class="text-center" style="background: #005398; color: white">title</th>
	        			<th class="text-center" style="background: #005398; color: white">news</th>
	        		</tr>
	        	</thead>
        		<tbody>
	        <?php 
	        	foreach ($news as $key) { ?>
		        	<tr>
		        		<td style="background: #00A4E4; color: white; padding: 10px 20px""><?php echo $key->title; ?></td>		
		        		<td style="padding: 10px 20px"><?php echo $key->content; ?></td>		
		        	</tr>
    		<?php
	        	}
	        ?>
        		</tbody>
	        </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


<!-- slider -->
<div id="mycarousel" class="carousel slide" data-ride="carousel">

    <div class="carousel-inner" role="listbox">
		<?php
		if (isset($latar)){
			foreach($latar as $row){ 
				if ($row['aktif']==1){
				?>
				<div class="item">
					<img src="<?=slide_url($row['nama']);?>">
				</div>	
			<?php 
				}
			}
		}else{ ?>
			<div class="item">
				<img src="<?=img_url('peruri2.jpg');?>">
			</div>			
		<?php } ?>
    </div>
</div>

<script>
  setTimeout(function() {
    $('.error').css('top','-999px');
  },8000);
</script>