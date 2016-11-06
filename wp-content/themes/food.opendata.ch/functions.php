<?php

add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style('style', get_stylesheet_uri());

});

add_action('after_setup_theme', function () {

    /**
     * Enable plugins to manage the document title
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link http://codex.wordpress.org/Function_Reference/register_nav_menu
     */
     register_nav_menu('main', 'Main Navigation Menu');

    /**
     * Enable HTML5 markup support
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

});
