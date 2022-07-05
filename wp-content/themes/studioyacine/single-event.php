<?php get_header(); ?>

<main id="" class="SimplePage" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

				<div class="SimplePage--header">

					<div class="SimplePage--eventdates">
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
									?></time>
							<?php endif; ?>

							<?php if($date_end): ?>
								<?php $dateEndFormat = DateTime::createFromFormat('Y-m-d H:i:s', $date_end);?>

								<time class='Teaser--date' datetime="<?php echo $dateEndFormat->format('c'); ?>" itemprop="datePublished"><?php echo $dateEndFormat->format('d M Y'); ?></time>
							<?php endif; ?>
					</div>

					<h1 class="SimplePage--title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>

					<div class='SimplePage--categories'>

						<?php
							$terms = get_the_terms($post->ID , 'event_category');
							if ( $terms && !is_wp_error( $terms ) ) :
						?>

						<ul>
							<?php foreach ( $terms as $term ) { ?>
								<li><?php echo $term->name; ?></li>
							<?php } ?>
						</ul>
						<?php endif;?>

					</div>
					
				</div>

				<div class="SimplePage--body">

					<?php the_content(); ?>

				</div>

			</article>

		<?php endwhile; ?>

	<?php else : ?>

		<article id="post-not-found" class="hentry cf">
			<header class="article-header">
				<h1><?php _e('Oops, Post Not Found!', 'bonestheme'); ?></h1>
			</header>
		</article>

	<?php endif; ?>

</main>

<?php get_footer(); ?>