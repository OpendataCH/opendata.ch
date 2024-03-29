<?php
// ===================================================
// Article Teasers
// ===================================================
// ===================================================
// ===================================================
?>




<section class='HomeProjects'>

    <?php /* =============================================  */ ?>
    <?php /* Section title  */ ?>
    <?php $featured_posts = get_field('projects'); ?>

    <?php if (get_field('projects_title')) : ?>

        <div class='SectionHeader'>

            <h2><?php the_field('projects_title'); ?></h2>

            <a href="<?php echo get_post_type_archive_link('project'); ?>"><?php pll_e("All Projects") ?></a>

        </div>

    <?php endif; ?>







    <?php /* =============================================  */ ?>
    <?php /* Section List  */ ?>
    <?php if ($featured_posts) : ?>

        <ul class="TeaserGrid">

            <?php foreach ($featured_posts as $post) : ?>

                <li class='TeaserGrid--item'>

                    <?php $args = array('text' => true); ?>
                    <?php get_template_part('templates/teasers/teaser', 'grid', $args); ?>

                </li>

            <?php endforeach; ?>

            <?php wp_reset_postdata(); ?>

        </ul>

    <?php endif; ?>


</section>