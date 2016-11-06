<?php get_header(); ?>

<div class="container landing-container-tight text-xs-center">

<?php while (have_posts()): ?>
    <?php the_post(); ?>

    <?php get_template_part('template-parts/content-single', get_post_type()); ?>
<?php endwhile; ?>

</div>

<?php get_footer(); ?>
