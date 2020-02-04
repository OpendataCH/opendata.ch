<?php

//mobile detection
require_once 'library/php/Mobile_Detect.php';
require 'library/php/Embera/Autoload.php' ;

include('partials/base-context.php');

//get the video embed code
$url = get_field('video_embed_url');
$embera = new \Embera\Embera();


Timber::render( 'views/single-members.twig', $context );

?>

