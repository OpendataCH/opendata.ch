<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->

<head>
	<meta charset="utf-8">

	<?php // force Internet Explorer to use the latest rendering engine available 
	?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?php wp_title('-'); ?></title>

	<?php // mobile meta (hooray!) 
	?>
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">

	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/library/favicon/favicon.png">
	<!--[if IE]>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
	<![endif]-->
	<?php // or, set /favicon.ico for IE10 win 
	?>
	<meta name="msapplication-TileColor" content="#f01d4f">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
	<meta name="theme-color" content="#121212">

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php // wordpress head functions 
	?>
	<?php wp_head(); ?>
	<?php // end of wordpress head 
	?>

	<?php // drop Google Analytics Here 
	?>
	<?php // end analytics 
	?>

	<script>
		// CookieBoxConfig = {
		// 	cookieKey: 'studioyacine-wordpress-starter.local',
		// 	backgroundColor: '#333',
		// 	language: 'en',
		// 	url: '<?php // echo esc_url(get_page_link(68)); 
						// 			
						?>'
		// }
	</script>

</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

	<div id="container">

		<header class="Header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

			<div class="Header--inner">

				<?php get_template_part('templates/global', 'logo'); ?>

				<nav class='Header--nav' role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">

					<?php
					wp_nav_menu(array(
						'container' => false,                           // remove nav container
						'container_class' => 'menu',                 // class of container (should you choose to use it)
						'menu' => __('Main nav', 'bonestheme'),  // nav name
						'menu_class' => '',               // adding custom nav class
						'theme_location' => 'main-nav',                 // where it's located in the theme
						'before' => '',                                 // before the menu
						'after' => '',                                  // after the menu
						'link_before' => '',                            // before each link
						'link_after' => '',                             // after each link
						'depth' => 0,                                   // limit the depth of the nav
						'fallback_cb' => ''                             // fallback function (if there is one)
					));
					?>

				</nav>

				<button class='Header--search' role='button'>
					<span class='visuallyhidden'>Search</span>
					<svg class="icon">
						<use xlink:href="#base--search(1)"></use>
					</svg>
				</button>

				<button role='button' class="Burger">
					<span class='visuallyhidden'>Menu</span>
					<svg class="icon">
						<use xlink:href="#base--burger"></use>
					</svg>
				</button>

			</div>

		</header>