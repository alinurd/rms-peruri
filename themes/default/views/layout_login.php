<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?php echo $template['title']; ?></title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>themes/default/assets/img/favicon.ico" />
	<meta http-equiv="X-UA-Compatible" content="IE=9">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, maximum-scale=1, user-scalable=no'>
<meta http-equiv="Content-Security-Policy" content="frame-ancestors 'self'">
	
	<title><?php echo $template['title']; ?></title>
	<?php echo $template['partials']['css_login']; ?>
	<?php echo $template['partials']['js_login']; ?>
	<?php echo $template['metadata']; ?>
	<?php
	header('X-Frame-Options: SAMEORIGIN');
	?>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="top">
	<?php echo $template['body']; ?>
</body>
<script>
	$(document).ready(function() {
		$('.parallax-window').parallax();
	})
</script>

</html>