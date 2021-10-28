<?php
// ===================================================
// FLYOUT
// ===================================================
// ===================================================
// ===================================================
?>
<div class="Flyout">
    <div class="Flyout--inner">

        <div class="Flyout--search">
			<?php get_search_form(array('name' => 'search-flyout')); ?>
        </div>

        <?php wp_nav_menu(array(
            'container' => false,                           // remove nav container
            'container_class' => '',                 // class of container (should you choose to use it)
            'menu' => __('Category Nav', 'bonestheme'),  // nav name
            'menu_class' => 'Flyout--menu',               // adding custom nav class
            'theme_location' => 'main-nav',                 // where it's located in the theme
            'before' => '',                                 // before the menu
            'after' => '',                                  // after the menu
            'link_before' => '',                            // before each link
            'link_after' => '',                             // after each link
            'depth' => 0,                                   // limit the depth of the nav
            'fallback_cb' => ''                             // fallback function (if there is one)
        )); ?>

        <?php get_template_part('templates/global', 'sociallinks'); ?>

    </div>

    <button class='Flyout--close' role='button'>
        <span class='visuallyhidden'>Close</span>
        <svg aria-hidden='true' class="icon">
            <use xlink:href="#base--close(1)"></use>
        </svg>
    </button>

    <div class="Flyout--overlay"></div>
</div>