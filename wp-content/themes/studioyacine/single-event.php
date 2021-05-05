<?php get_header(); ?>

<main id="" class="SimplePage" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

				<div class="SimplePage--header">

					<h1 class="SimplePage--title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>

					<div class='SimplePage--header--footer'>

						<?php
							$taxonomy = 'event_category';
							$terms = get_terms($taxonomy);
							if ( $terms && !is_wp_error( $terms ) ) :
						?>
						<ul class='SimplePage--categories'>
							<?php foreach ( $terms as $term ) { ?>
								<li><?php echo $term->name; ?></li>
							<?php } ?>
						</ul>
						<?php endif;?>

						<div class="SimplePage--eventdates">

						<?php 
							$date_start = get_field('date');
							$date_end = get_field('end_date');
							if($date_start):
								$date = DateTime::createFromFormat('Y-m-d H:i:s', $date_start);
							?>
							<time class='SimplePage--eventstart' datetime="<?php echo $date->format('c'); ?>" itemprop="datePublished"><?php echo $date->format('d M Y'); ?></time>
							<?php
							endif;
							if($date_end):
								$date = DateTime::createFromFormat('Y-m-d H:i:s', $date_end);
							?>
							<time class='SimplePage--eventstart' datetime="<?php echo $date->format('c'); ?>" itemprop="datePublished"><?php echo $date->format('d M Y'); ?></time>
							<?php endif; ?>
						</div>
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