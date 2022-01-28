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

	$newsTerms = get_field('related_news');
	$eventTerms = get_field('related_events');

	$newsArrayTerm = array(
		'taxonomy'=> 'news_category',
		'field'=> 'slug',
		'operator'=> 'IN'		
	);

	$eventsArrayTerm = array(
		'taxonomy'=> 'event_category',
		'field'=> 'slug',
		'operator'=> 'IN'
	);

	if($eventTerms){
		$temp = array();
		foreach ( $eventTerms as $term ) {
			array_push($temp,$term->slug);
		}
		$temp = implode(",", $temp);
		$eventsArrayTerm['terms'] = $temp;
	}

	if($newsTerms){
		$temp = array();
		foreach ( $newsTerms as $term ) {
			array_push($temp,$term->slug);
		}
		$temp = implode(",", $temp);
		$newsArrayTerm['terms'] = $temp;
	}
	$today = date('Y-m-d H:i:s');
	$args = array(
		'post_type' => array(
			!!$eventTerms ? 'event' : false,
			!!$newsTerms ? 'news' : false
		),
		'posts_per_page' => '12',
		'orderby' => 'DESC',
		'tax_query' => array(
			'relation' => 'OR',
			array($eventsArrayTerm),
			array($newsArrayTerm)
		),
		'meta_key' => 'date',
		'meta_compare' => '>=',
		'meta_value' => $today
	);

	$projectPosts = new WP_Query($args);
	$projectPostsCount = $projectPosts->found_posts;
?>

	<?php if($projectPostsCount > 0): ?>
		<div class="Related--posts">

			<div class='SectionHeader'>

				<h2>News and Events</h2>

			</div>

			<div class="TeaserGrid size--3 slider">

				<?php if ($projectPosts->have_posts()) : while ($projectPosts->have_posts()) : $projectPosts->the_post(); ?>

						<?php setup_postdata($post); ?>

						<div class='TeaserGrid--item'>
							<?php $post_type = get_post_type( get_the_ID() ); ?>
							<?php $args = array('date' => true, 'posttype' => $post_type); ?>
							
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