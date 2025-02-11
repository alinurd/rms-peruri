<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>PERUM PERURI - <?=$template['title'];?></title>
		<link rel="shortcut icon" href="<?=img_url('favicon.ico');?>" />
		
		<?php echo $template['partials']['css'];?>
		<?php echo $template['partials']['js'];?>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		<style>
			.blinking-text {
				animation: blink 2s infinite; /* Mengatur animasi kedap-kedip */
			}

			@keyframes blink {
				0%, 100% {
					opacity: 1; /* Teks terlihat */
				}
				50% {
					opacity: 0; /* Teks tidak terlihat */
				}
			}
		</style>
	</head>
	<body class="nav-md skin-blue">
	<div class="loader"></div>
    <!-- Site wrapper -->
    <div class="container body">
		<div class="main_container">
			<?php echo $template['partials']['sidebar_left'];?>
			<?php echo $template['partials']['header'];?>
			<div class="right_col" role="main">
				<div class="" style="padding-bottom: 50px !important;">
					<?php echo $template['body'];?>
				</div>
			</div>
			<?php echo $template['partials']['footer'];?>
		</div>
	</div>
	<?php echo $template['partials']['js_bottom'];?>
	<?php echo $template['metadata'];?>
	
	<!-- Modal -->

	<div class="modal modal-default" id="modal_general" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog fullscreen">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">General Content</h4>
				</div>
				<div class="modal-body">
					&nbsp;
				</div>
				<div class="modal-footer hide">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<?php $spinner='<img src="'.img_url('input-spinner.gif').'">'; ?>
	<script>
		
		var spinner='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$spinner));?>';
		var base_url = "<?php echo base_url();?>";
		var mode = "<?php echo $this->uri->segment(2);?>";
		var modul_name = "<?php echo $this->router->fetch_module();?>";
		var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
		var csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
   
		function loading(nil, id){
			if(typeof(id) == "undefined")
				id ='overlay';
			if (nil){
				$("#" + id).removeClass("hide");
			}else{
				$("#" + id).addClass("hide");
			}
		}
		
		function loading_all(nil){
			if (nil)
				$("body").addClass("loading");
			else
				$("body").removeClass("loading");
		}
		
		
		$(document).ready(function() {
			// $('#double-scroll').doubleScroll();
			setTimeout(function(){		
				$('#sts_pesan_proses').fadeOut(1000);	
				$('.row-title').removeClass('error');	
				$('select.error').removeClass('error');			
			}, 9000);	
			
			$('#sts_pesan_proses').on('click', function(e) {
				$(this).fadeOut(1000);		
				$('.row-title').removeClass('error');
				$('select.error').removeClass('error');
			}); 
			
			$('#sts_error').fadeIn('slow');
			setTimeout(function(){				
				$('#sts_error').remove();	
				$('input').removeClass('error');
				$('select.error').removeClass('error');
				
				$('#sts_error').fadeOut(1000);	
				$('.row-title').removeClass('error');
			}, 5000);	
			
			$('#sts_error').on('click', function(e) {
				$(this).fadeOut(1000);		
				$('input').removeClass('error');
				$('select.error').removeClass('error');
				$('.row-title').removeClass('error');
			}); 
			
			var url_redirect_to ="<?php echo base_url('auth/logout?redirect_to='.urlencode(uri_string()));?>";
			
			$("#logout").removeAttr('href').attr('href',url_redirect_to);
			$("#logout2").removeAttr('href').attr('href',url_redirect_to);
			
			$("input:text")
				.focus(function () { $(this).select(); } )
				.mouseup(function (e) {e.preventDefault(); });	
			
			$("img").addClass("lazyload");
		});
		
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
		
		// document.onkeypress= stopEnterKey;
	</script>
	
	</body>
</html>
