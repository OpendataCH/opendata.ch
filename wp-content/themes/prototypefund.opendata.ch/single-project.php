<?php

//mobile detection
require_once 'library/php/Mobile_Detect.php';
require 'library/php/Embera/Autoload.php' ;

include('partials/base-context.php');

//$context['prev_project'] = get_adjacent_project($post->ID, 'prev');
//$context['next_project'] = get_adjacent_project($post->ID, 'next');

$values = get_field('status');
$field = get_field_object('status');
$context['choices'] = $field['choices'];
$context['status'] = [];
if($context['choices']){
    foreach ($context['choices'] as $value => $label) {
        $array = [];
        $array['label'] = $label;
        if (in_array($value, $values)) {
            $array['checked'] = 1;
        } else $array['checked'] = 0;
        $context['status'][] = $array;
    }
}


$context['post'] = extendProjectPost($post);

Timber::render( 'views/single-project-2020.twig', $context );
//Timber::render( 'views/404.twig', $context );

?>