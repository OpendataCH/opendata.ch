<?php get_header(); ?>

<main id="" class="SimplePage" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

				<div class="SimplePage--header">
					<h1 class="SimplePage--title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>
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

    <?php /* =============================================  */ ?>
    <?php /* News list  */ ?>
    <?php

	$termNews = get_field('related_news');
	$termEvents = get_field('related_events');

	$args = array(
		'post_type' => array(
			!!$termEvents ? 'event' : false,
			!!$termNews ? 'news' : false
		),
		'posts_per_page' => '12',
		'orderby' => 'DESC',
		'tax_query' => array(
			'relation' => 'OR',
			array($termNews),
			array($termEvents)
		)
	);

	$projectPosts = new WP_Query($args);
	$projectPostsCount = $projectPosts->found_posts;
?>

	<?php if($projectPostsCount > 0): ?>
		<div class="Related--posts">

			<div class='SectionHeader'>

				<h2>Related</h2>

			</div>

			<div class="TeaserGrid size--3 slider">

				<?php if ($projectPosts->have_posts()) : while ($projectPosts->have_posts()) : $projectPosts->the_post(); ?>

						<?php setup_postdata($post); ?>

						<div class='TeaserGrid--item'>

							<?php $args = array('date' => true); ?>
							<?php get_template_part('templates/teasers/teaser', 'grid', $args); ?>

						</div>

						<?php wp_reset_postdata(); ?>

					<?php endwhile; else : ?>

				<?php endif; ?>

			</div>

		</div>

	<?php endif; ?>

</main>

<?php get_footer(); ?>