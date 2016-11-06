<?php
/**
 * Template Name: Landing
 */
?>

<?php get_header(); ?>

<div class="container text-xs-center">
    <?php while (have_posts()): ?>
        <?php the_post(); ?>

        <?php the_content(); ?>
    <?php endwhile; ?>
</div>

<?php
$args = array(
    'sort_order' => 'ASC',
    'sort_column' => 'menu_order',
    'child_of' => get_the_ID()
);
$children = get_pages($args);
?>
<?php foreach ($children as $post): ?>
    <?php setup_postdata($post); ?>

    <?php
    $sectionCustom = get_post_custom_values('landing_section');
    $section = isset($sectionCustom[0]) ? 'landing-section-' . $sectionCustom[0] : '';

    $containerCustom = get_post_custom_values('landing_container');
    $container = isset($containerCustom[0]) ? 'landing-container-' . $containerCustom[0] : '';
    ?>
    <div class="landing-section <?php echo esc_html($section); ?>" id="section-<?php echo esc_html(get_post_field('post_name')); ?>">

        <div class="container text-xs-center landing-container <?php echo esc_html($container); ?>">
            <?php the_content(); ?>
        </div>

    </div>

<?php endforeach; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>
