<?php

//mobile detection
require_once 'library/php/Mobile_Detect.php';

include('partials/base-context.php');

$last_modified = $post->post_modified;
$context['time_passed'] = timePassedSinceDate(strtotime($last_modified));

Timber::render( 'views/single-user_submission.twig', $context );

?>