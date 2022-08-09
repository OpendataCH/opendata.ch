<?php get_header(); ?>

<?php $args = array('prefix' => 'events'); ?>

<?php get_template_part('templates/intro/archive', null, $args); ?>

<main id="main" class="main" role="main" itemscope itemprop="mainContentOfPage">

	<?php if (!is_paged()) : ?>

		<div class="SectionHeader">
			<strong><?php pll_e("Upcoming Events") ?></strong>
		</div>

		<section class='EventsNext'>

			<?php
			$today = date('Y-m-d H:i:s');
			$upcomingPosts = get_posts(array(
				'post_type' => 'event',
				'posts_per_page'	=> -1,
				'meta_key' => 'date',
				'meta_compare' => '>=',
				'meta_value' => $today,
				'orderby' => 'meta_value',
				'order' => 'asc',
			));

			if ($upcomingPosts) : ?>

				<div class="TeaserGrid size--3">

					<?php
					foreach ($upcomingPosts as $post) :
						setup_postdata($post);
						$args = array('posttype' => 'event');
						get_template_part('templates/teasers/teaser', 'grid', $args);
					endforeach;
					wp_reset_postdata();
					?>

				</div>

			<?php endif; ?>

		</section>

		<div class="SectionHeader">
			<strong><?php pll_e("Past Events") ?></strong>
		</div>

	<?php endif; ?>


	<section class='EventsPast'>

		<?php if (have_posts()) : ?>

			<div class="TeaserGrid size--4">

				<?php while (have_posts()) : the_post(); ?>

					<div class="TeaserGrid--item">

						<?php $args = array('text' => false, 'posttype' => 'event'); ?>
						<?php get_template_part('templates/teasers/teaser', 'grid', $args); ?>

					</div>

				<?php endwhile; ?>

			</div>

			<?php bones_page_navi(); ?>

		<?php else : ?>

			<article id="post-not-found" class="hentry ">
				<header class="article-header">
					<h1><?php _e('Oh, no events.', 'bonestheme'); ?></h1>
				</header>
			</article>

		<?php endif; ?>

	</section>

</main>

<?php get_footer(); ?>