<?php get_header(); ?>

<?php $args = array('id' => 'intro'); ?>
<?php get_template_part('templates/intro/page', null, $args); ?>

<main class="SimplePage" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

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