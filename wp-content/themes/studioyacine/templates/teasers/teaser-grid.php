<?php
// ===================================================
// Small Teaser
// ===================================================
// ===================================================
// ===================================================
?>
<a class='Teaser' title="<?php the_title_attribute(); ?>" href='<?php the_permalink() ?>'>

    <div class="Teaser--image">

        <?php the_post_thumbnail('medium'); ?>

    </div>

    <div class='Teaser--text'>
        <?php// var_dump(get_field('date')); ?>
        <?php if (isset($args['date'])) : ?>
            <time class='Teaser--date' datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date('d. F Y'); ?></time>
        <?php endif; ?>


        <h3 class='Teaser--title'><?php the_title(); ?></h3>

        <?php if (isset($args['text']) && $args['text']) : ?>

            <?php the_excerpt(); ?>

        <?php endif; ?>

    </div>

</a>