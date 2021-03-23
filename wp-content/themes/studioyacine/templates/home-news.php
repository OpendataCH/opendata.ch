<?php
// ===================================================
// Article Teasers
// ===================================================
// ===================================================
// ===================================================
?>


<section class='HomeNews'>



    <?php /* =============================================  */ ?>
    <?php /* Section title  */ ?>
    <?php if (get_field('news_title')) : ?>

        <div class='SectionHeader'>

            <strong><?php the_field('news_title'); ?></strong>

            <a href="<?php echo get_post_type_archive_link('news'); ?>">All News</a>

        </div>

    <?php endif; ?>






    <?php /* =============================================  */ ?>
    <?php /* News list  */ ?>
    <?php
    $args = array(
        'post_type' => 'news',
        'order'     => 'ASC',
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
                    <?php get_template_part('templates/teasers/teaser', 'grid', $args);
                    ?>

                </li>

                <?php wp_reset_postdata(); ?>

            <?php endwhile;
        else : ?>

        <?php endif; ?>

    </ul>


</section>