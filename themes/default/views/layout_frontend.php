<<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/
?>
!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title><?php echo $template['title'];?></title>
		<link rel="shortcut icon" href="<?php echo base_url();?>themes/default/assets/img/favicon.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=9">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, maximum-scale=1, user-scalable=no' >
    <title><?php echo $template['title'];?></title>
    <?php echo $template['partials']['css_frontend'];?>
    <?php echo $template['partials']['js_frontend'];?>
	
	 <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
  </head>
	<body class="login-page">
		<div class="page-wrapper">
			<?=$template['partials']['header_frontend'];?>
			<?=$template['partials']['sidebar_frontend_left'];?>
			<div class="welcome-sec" style="padding-top:0px !important;">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="weltext awal">
								<section class="content">
									<?=$template['body'];?>
								</section>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?=$template['partials']['footer_frontend'];?>
		</div>
		<div class="scroll-to-top scroll-to-target" data-target=".site-header"><span class="icon fa fa-long-arrow-up"></span></div>
		<?=$template['partials']['js_frontend_bottom'];?>
		<?=$template['metadata'];?>
		
		<script>
			var base_url = "<?php echo base_url();?>";
			var modul_name = "<?php echo $this->router->fetch_module();?>";
			var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
			var csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
			$("img").addClass("lazyload");
			
			var Globals = <?php echo json_encode(array(
			'sLengthMenu' => lang('msg_data_table_sLengthMenu'),
			'sZeroRecords' => lang('msg_data_table_sZeroRecords'),
			'sInfo' => lang('msg_data_table_sInfo'),
			'sInfoEmpty' => lang('msg_data_table_sInfoEmpty'),
			'sInfoFiltered' => lang('msg_data_table_sInfoFiltered'),
			'sSearch' => lang('msg_data_table_sSearch'),
			'sFirst' => lang('msg_data_table_sFirst'),
			'sPrevious' => lang('msg_data_table_sPrevious'),
			'sNext' => lang('msg_data_table_sNext'),
			'sLast' => lang('msg_data_table_sLast'),
			'cboSelect' => lang('msg_cbo_select'),
			'nil_combo' => 10,
		)); ?>;
		</script>
	</body>
</html>