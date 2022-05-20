<?php
/*
 Template Name: Frontpage
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


<?php get_header(); ?>

<?php get_template_part('templates/intro/home'); ?>

<main id="" class="main" role="main" itemscope itemprop="mainContentOfPage">

	<?php get_template_part('templates/home', 'projects'); ?>

	<?php get_template_part('templates/home', 'news'); ?>

	<?php get_template_part('templates/home', 'cta'); ?>

</main>

<?php get_footer(); ?>