<?php

//mobile detection
require_once 'library/php/Mobile_Detect.php';

include('partials/base-context.php');
Timber::render( 'views/page.twig', $context );

?>
