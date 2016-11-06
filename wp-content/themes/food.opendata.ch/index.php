<?php get_header(); ?>

<div class="container landing-container-tight text-xs-center">

<?php if (!have_posts()): ?>
    <div class="alert alert-warning">
        <?php _e('Sorry, no results were found.', 'food.opendata.ch'); ?>
    </div>
    <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()): ?>
    <?php the_post(); ?>

    <?php get_template_part('template-parts/content', get_post_format()); ?>
<?php endwhile; ?>

<?php the_posts_navigation(); ?>

</div>

<?php get_footer(); ?>
