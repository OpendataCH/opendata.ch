<?php

//mobile detection
require_once 'library/php/Mobile_Detect.php';

include('partials/base-context.php');

$cat = get_category( get_query_var( 'cat' ) );


$args = array(
    'post_type' => 'project',
    'post_status' => 'publish',
    'cat' => $cat->cat_ID,
    'posts_per_page' => -1
);
$context['category_name'] = $cat->name;
$context['projects'] = Timber::get_posts($args);
Timber::render( 'views/category.twig', $context );
?>