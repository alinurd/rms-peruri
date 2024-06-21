<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?=link_tag(css_url('bootstrap.min.css'));?>
<?=link_tag(css_url('font-awesome.css'));?>
<?=link_tag(css_url('ionicons.min.css'));?>
<?=link_tag(css_url('AdminLTE.min.css'));?>
<title>Page Error</title>
</style>
</head>
<body>
	<div class="wrapper">
		<div class="content-wrapper" style="margin:50px 100px;">
			<section class="content">
				<div class="row">
					<div class="col-md-4">
						<img src="<?php echo img_url('error-404.jpg');?>">
					</div>
					<div class="col-md-8">
						<h1>404 Page Not Found!</h1>
						The page you requested <a href="<?php echo current_url();?>"> <?php echo current_url();?></a> was not found.<br/><br/>
						<div class="error-actions">
						   <a href="<?php echo base_url();?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span> Take Me Home </a>
							<a href="<?php echo base_url('contact');?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
							<a href="<?php echo current_url();?>" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-home"></span> Refresh</a>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>