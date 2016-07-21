<?php

add_action('wp_enqueue_scripts', 'infinitythemetrust_enqueue_styles');
function infinitythemetrust_enqueue_styles() {
    wp_enqueue_style('infinitythemetrust', get_template_directory_uri() . '/style.css');
}
