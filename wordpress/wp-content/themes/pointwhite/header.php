<!DOCTYPE html>
<html>

<head>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1.0">

	<!-- <title></title> -->
	<title><?php wp_title('|',1,'right'); ?> <?php bloginfo('name'); ?></title>

	<link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.2.1/grids-min.css">
	<!--  
	<script src="js/custom-min.js" type="text/javascript"></script>
	-->
	<!-- 
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/dev/custom-ck.js"></script>
 -->
	<?php wp_head(); ?>
</head>

<body>

		<div id="main">

		<div class="pure-g-r">

			<div class="pure-u-7-24">

				<!-- Sidebar -->
				<?php get_sidebar(); ?>
				<!-- End Sidebar -->

			</div>

			<div class="pure-u-17-24">
				<div id="main-content">