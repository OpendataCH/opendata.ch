<?php get_header(); ?>

<main class="main" class="SimplePage" role="main">
	<div class="SimplePage--header">
		<h1 class="SimplePage--title">
			<span class='SimplePage--title--label'><?php _e('Search Results for:', 'bonestheme'); ?></span>
			<span><?php echo esc_attr(get_search_query()); ?></span>
		</h1>
	</div>

	<div class="SimplePage--body">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article">

					<header class="entry-header article-header">

						<h2 class="search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

						<p class="byline entry-meta vcard">
							<?php printf(
								__('%1$s', 'bonestheme'),
								/* the time the post was published */
								'<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>'
							); ?>
						</p>

					</header>

					<section class="entry-content">
						<?php the_excerpt('<span class="read-more">' . __('Read more &raquo;', 'bonestheme') . '</span>'); ?>

					</section>

					<footer class="article-footer">

						<ul class='article-categories'>
							<?php
							foreach (get_categories() as $category):
								echo "<li>";
								if ($category->name != 'Uncategorized'):
									echo $category->name;
								endif;
								echo "</li>";
							endforeach; ?>
						</ul>

						<?php //the_tags('<p class="tags"><span class="tags-title">' . __('Tags:', 'bonestheme') . '</span> ', ', ', '</p>'); ?>

					</footer> <!-- end article footer -->

				</article>

				<hr>

			<?php endwhile; ?>

		<?php else : ?>

			<article id="post-not-found" class="hentry cf">
				<header class="article-header">
					<h1><?php _e('Sorry, No Results.', 'bonestheme'); ?></h1>
				</header>
			</article>

		<?php endif; ?>

	</div>

	<?php bones_page_navi(); ?>

</main>

<?php get_footer(); ?>