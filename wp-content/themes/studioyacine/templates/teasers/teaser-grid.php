<?php
// ===================================================
// Small Teaser
// ===================================================
// ===================================================
// ===================================================
?>
<a class='Teaser' title="<?php the_title_attribute(); ?>" href='<?php the_permalink() ?>'>

    <div class="Teaser--image">

        <?php the_post_thumbnail('medium-large'); ?>

    </div>

    <div class='Teaser--text'>
        
        <?php if (isset($args['date'])) : ?>
            <time class='Teaser--date' datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date('d M Y'); ?></time>
        <?php endif; ?>

		<?php if (isset($args['posttype']) && $args['posttype'] == 'event') : ?>
			<?php 
				$date_start = get_field('date');
				$date_end = get_field('end_date');
				if($date_start):
					$date = DateTime::createFromFormat('Y-m-d H:i:s', $date_start);
				?>
				<time class='Teaser--date' datetime="<?php echo $date->format('c'); ?>" itemprop="datePublished">
				<?php if($date_end): ?>
					<?php echo $date->format('d').' -'; ?>
				<?php else: ?>
					<?php echo $date->format('d M Y'); ?>
				<?php endif; ?>
				</time>
				<?php
				endif;
				if($date_end):
					$date = DateTime::createFromFormat('Y-m-d H:i:s', $date_end);
				?>
				<time class='Teaser--date' datetime="<?php echo $date->format('c'); ?>" itemprop="datePublished"><?php echo $date->format('d M, Y'); ?></time>
				<?php endif; ?>
			
		<?php endif; ?>

        <h3 class='Teaser--title'><?php the_title(); ?></h3>

        <?php if (isset($args['text']) && $args['text']) : ?>

            <?php the_excerpt(); ?>

        <?php endif; ?>

    </div>

</a>