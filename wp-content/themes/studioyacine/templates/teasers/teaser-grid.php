<?php
// ===================================================
// Small Teaser
// ===================================================
// ===================================================
// ===================================================
?>
<a class='Teaser' title="<?php the_title_attribute(); ?>" href='<?php the_permalink() ?>'>

	<?php 
		$postTypeName = get_post_type($post->ID);
		$termsOutPut = array();
		if($postTypeName == 'news' || $postTypeName == 'event'):
			$terms = get_the_terms($post->ID, $postTypeName.'_category');
			if ($terms):
				foreach ($terms as $term) {
					$termsOutPut[] = '<span>' .$term->name .'</span>';
				}
				$termsOutPut = join( ' / ', $termsOutPut );
			endif; 	
		endif;
	?>

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

				if($date_start): ?>

					<?php $dateStartFormat = DateTime::createFromFormat('Y-m-d H:i:s', $date_start); ?>
				
					<time class='Teaser--date' datetime="<?php echo $dateStartFormat->format('c'); ?>" itemprop="datePublished">
						<?php 
							if($date_end):
								$dateEndFormat = DateTime::createFromFormat('Y-m-d H:i:s', $date_end);

								// CHECK IF SAME MONTH
								if($dateStartFormat->format('Y') != $dateEndFormat->format('Y')){
									echo $dateStartFormat->format('d M Y').' - ';
								} else if($dateStartFormat->format('M') != $dateEndFormat->format('M')){
									echo $dateStartFormat->format('d M').' - ';
								} else {
									echo $dateStartFormat->format('d').' - ';
								}
							else:
								echo $dateStartFormat->format('d M Y');
							endif; 
						?>
					</time>

				<?php endif; ?>

				<?php if($date_end): ?>
					<?php $dateEndFormat = DateTime::createFromFormat('Y-m-d H:i:s', $date_end);?>
				
					<time class='Teaser--date' datetime="<?php echo $dateEndFormat->format('c'); ?>" itemprop="datePublished">
						<?php echo $dateEndFormat->format('d M, Y'); ?>
					</time>
				<?php endif; ?>
			
		<?php endif; ?>

        <h3 class='Teaser--title'><?php the_title(); ?></h3>

        <?php if (isset($args['text']) && $args['text']) : ?>

            <?php the_excerpt(); ?>

        <?php endif; ?>

    </div>

	<?php if(!empty($termsOutPut)): ?>
		<div class='Teaser--terms'>
			<?php echo $termsOutPut; ?>
		</div>
	<?php  endif; ?>

</a>