<?php get_header(); ?>

<?php $args = array('prefix' => 'news'); ?>
<?php get_template_part('templates/intro/archive', null, $args); ?>

<main id="" class="main" role="main" itemscope itemprop="mainContentOfPage">

	<?php if (have_posts()) : ?>

		<ul class="TeaserList">
			<?php $k = 0; ?>
			<?php while (have_posts()) : the_post(); ?>

				<li class="TeaserList--item <?php echo ($k === 0 && !is_paged()) ? 'TeaserList--item--big' : '' ?>">

					<?php $args = array('date' => true); ?>
					<?php get_template_part('templates/teasers/teaser', 'news', $args); ?>
					<?php $k++; ?>
				</li>

			<?php endwhile; ?>

		</ul>

		<?php bones_page_navi(); ?>

	<?php else : ?>

		<article id="post-not-found" class="hentry ">
			<header class="article-header">
				<h1><?php _e('Oops, Post Not Found!', 'bonestheme'); ?></h1>
			</header>
			<section class="entry-content">
				<p><?php _e('Uh Oh. Something is missing. Try double checking things.', 'bonestheme'); ?></p>
			</section>
			<footer class="article-footer">
				<p><?php _e('This is the error message in the archive.php template.', 'bonestheme'); ?></p>
			</footer>
		</article>

	<?php endif; ?>

</main>

<?php get_footer(); ?>