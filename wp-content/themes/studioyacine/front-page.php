<?php get_header(); ?>

<?php get_template_part('templates/intro/home'); ?>

<main id="" class="main" role="main" itemscope itemprop="mainContentOfPage">

	<?php get_template_part('templates/home', 'projects'); ?>

	<?php get_template_part('templates/home', 'news'); ?>

	<?php get_template_part('templates/home', 'cta'); ?>

</main>

<?php get_footer(); ?>