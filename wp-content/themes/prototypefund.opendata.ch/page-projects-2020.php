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
var_dump($context['hide_filters']);
if(count($round_slug_array) > 0){
    if(count($round_slug_array) < 2){
        //page is a single round page
        $context['hide_filters'] = true;
    }
}
var_dump($context['hide_filters']);

//get projects
//get projects
$round_slug_array = get_field('round',$post->ID);
$round_choices_array = get_field_object('round',$post->ID)['choices'];

$round_choices_array = [];
$round_choices_array['round_1'] = 'Round 1';
$round_choices_array['round_2'] = 'Round 2';
$round_choices_array['round_3'] = 'Round 3';
$round_choices_array['round_4'] = 'Round 4';
$round_choices_array['round_5'] = 'Round 5';
$round_choices_array['round_6'] = 'Round 6';
$round_choices_array['round_7'] = 'Round 7';
$round_choices_array['round_8'] = 'Round 8';
$round_choices_array['round_9'] = 'Round 9';
$round_choices_array['round_10'] = 'Round 10';

if(!is_array($round_slug_array) ){
    $round_slug_array = explode(',',$round_slug_array);
    $round_choices_array = explode(',',$round_choices_array);
} else {
    if(count($round_slug_array) > 1){
        //overview
        $round_slug_array = [];
        $round_slug_array[] = 'round_1';
        $round_slug_array[] = 'round_2';
        $round_slug_array[] = 'round_3';
        $round_slug_array[] = 'round_4';
        $round_slug_array[] = 'round_5';
        $round_slug_array[] = 'round_6';
        $round_slug_array[] = 'round_7';
        $round_slug_array[] = 'round_8';
        $round_slug_array[] = 'round_9';
        $round_slug_array[] = 'round_10';
    }
}

$context['projects_rounds_filter'] = get_rounds($round_slug_array, $round_choices_array);

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
