<?php
/*
 Template Name: Front Page 2020
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
include('partials/base-context.php');

calc_deadline();

$args = array(
    'post_type' => 'project',
    'posts_per_page' => -1,
    'orderby' => 'rand'
);
$context['random_projects'] = Timber::get_posts($args);

Timber::render( array('views/page-front-2020.twig'), $context );
?>
