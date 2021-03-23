<?php get_header(); ?>

<main id="" class="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

	<div class="SimplePage">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

					<h1 class="SimplePage--title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>

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

	</div>

</main>

<?php get_footer(); ?>