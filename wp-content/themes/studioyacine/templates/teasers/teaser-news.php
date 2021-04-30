<?php
// ===================================================
// Small Teaser
// ===================================================
// ===================================================
// ===================================================
?>
<a class='TeaserNews' title="<?php the_title_attribute(); ?>" href='<?php the_permalink() ?>'>

	<div class="TeaserNews--image">
        <?php if (has_post_thumbnail()) : ?>

			<?php if($args['teaserCount'] === 0): ?>
				<?php the_post_thumbnail('large'); ?>
			<?php else : ?>
            	<?php the_post_thumbnail('small'); ?>
			<?php endif; ?>

        <?php endif; ?>

    </div>
    <div class="TeaserNews--text">

        <h3 class='TeaserNews--title'><?php the_title(); ?></h3>

        <time class='TeaserNews--date' datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date('d M Y'); ?></time>

    </div>

</a>