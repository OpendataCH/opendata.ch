<?php
// ===================================================
// Article Teasers
// ===================================================
// ===================================================
// ===================================================
?>


<section class='HomeNews HomeEvents'>



    <?php /* =============================================  */ ?>
    <?php /* Section title  */ ?>
    <?php if (get_field('event_title')) : ?>

        <div class='SectionHeader'>

            <h2><?php the_field('event_title'); ?></h2>

            <a href="<?php echo get_post_type_archive_link('event'); ?>"><?php pll_e("All Events") ?></a>

        </div>

    <?php endif; ?>






    <?php /* =============================================  */ ?>
    <?php /* News list  */ ?>
    <?php
    $args = array(
        'post_type' => 'event',
        'order'     => 'DESC',
        'post_status' => 'publish',
        'posts_per_page' => '3'
    );
    $news = new WP_Query($args);
    ?>

    <ul class="TeaserGrid size--3">

        <?php if ($news->have_posts()) : while ($news->have_posts()) : $news->the_post(); ?>

                <?php setup_postdata($post); ?>

                <li class='TeaserGrid--item'>

                    <?php $args = array('date' => true); ?>
                    <?php get_template_part('templates/teasers/teaser', 'grid', $args); ?>

                </li>

                <?php wp_reset_postdata(); ?>

            <?php endwhile; else : ?>

        <?php endif; ?>

    </ul>


</section>