<?php

/*********************
SCRIPTS & ENQUEUEING
 *********************/

function bones_scripts_and_styles()
{

    global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

    if (!is_admin()) {

        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/dist/js/jquery.min.js', array(), null, true);

        $cache_buster = date("YmdHi", filemtime(get_stylesheet_directory() . '/library/css/style.css'));

        // register main stylesheet
        wp_register_style('bones-stylesheet', get_stylesheet_directory_uri() . '/dist/css/main.min.css', array(), $cache_buster, 'all');

        // comment reply script for threaded comments
        if (is_singular() and comments_open() and (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }

        // wp_register_script( 'bones-plugins', get_stylesheet_directory_uri() . '/dist/js/plugins.min.js', '', '', true );

        //adding scripts file in the footer
        wp_register_script('bones-js', get_stylesheet_directory_uri() . '/dist/js/app.js', array('jquery'), '', true);

        // enqueue styles and scripts
        wp_enqueue_script('bones-modernizr');
        wp_enqueue_style('bones-stylesheet');

        wp_enqueue_script('jquery');
        // wp_enqueue_script( 'bones-plugins' );
        wp_enqueue_script('bones-js');
    }
}
