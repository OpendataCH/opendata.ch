<?php
/*
 Template Name: Main Nav Page 2020
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php

//mobile detection
require_once 'library/php/Mobile_Detect.php';
require 'library/php/Embera/Autoload.php' ;

include('partials/base-context.php');

Timber::render( 'views/page-main-nav-2020.twig', $context );
?>
