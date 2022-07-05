<?php get_header(); ?>

<main id="" class="SimplePage" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

				<div class="SimplePage--header">

					<time class='SimplePage--postdate' datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date('d F Y'); ?></time>

					<h1 class="SimplePage--title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>

					<div class="SimplePage--categories">
						<?php
							$terms = get_the_terms($post->ID , 'news_category');
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

		<footer class='pagination-news'>
			<p class="pagination-next">
				<?php 
					previous_post_link();
				?>
			</p>
			<p class='pagination-prev'>
				<?php 
					next_post_link();
				?>
			</p>
		</footer>

	<?php else : ?>

		<article id="post-not-found" class="hentry cf">
			<header class="article-header">
				<h1><?php _e('Oops, Post Not Found!', 'bonestheme'); ?></h1>
			</header>
		</article>

	<?php endif; ?>

</main>

<?php get_footer(); ?>