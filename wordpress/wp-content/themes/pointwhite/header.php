<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />

	<title><?php wp_title('|',1,'right'); ?> <?php bloginfo('name'); ?></title>

	<link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.2.1/grids-min.css">

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