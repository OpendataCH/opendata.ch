<?php
/*
 Template Name: Projects Page 2020
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

//get GET parameter
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
} else {
    $filter = '';
}
$context['filter'] = $filter;

//get projects
$round_slug_array = get_field('round',$post->ID);
if(!is_array($round_slug_array)){
    $round_slug_array = explode(',',$round_slug_array);
}
if(count($round_slug_array) > 0){
    if(count($round_slug_array) < 2){
        //page is a single round page
        $context['hide_filters'] = true;
    }
}

$context['projects_rounds_filter'] = get_rounds($round_slug_array);
$context['projects'] = get_projects($round_slug_array);

//get categories
$args = array(
    'type' => 'project',
    'taxonomy' => 'projectcategory',
    'orderby' => 'name',
    'order'   => 'ASC'
);
$context['cats'] = get_categories($args);

//activate the tiles, if on german page
if($context['options']['languageCode'] == 'de') $context['projects_active'] = true;

Timber::render( 'views/page-projects-2020.twig', $context );
?>
