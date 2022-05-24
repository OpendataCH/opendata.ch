	<footer class="Footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

		<div class="Footer--top">

			<div class="Footer--text">
				<strong class='Footer--title'><?php pll_e("Contact") ?></strong>
				<?php $text = get_field('footer_text', 'option'); ?>
				<div>
					<?php echo $text; ?>
				</div>
			</div>

			<nav role="navigation">
				<strong class='Footer--title'><?php pll_e("Links") ?></strong>
				<?php if (have_rows('social_links', 'option')) : ?>
				<ul class="Footer--links">
					<?php while (have_rows('legal_links', 'option')) : the_row(); ?>
						<?php
						$link = get_sub_field('link');
						$link_target = $link['target'] ? $link['target'] : '_self';
						?>
						<li>
							<a rel="noopener" target="<?php echo esc_attr($link_target); ?>" title='<?php echo $link['title']; ?>' href="<?php echo $link['url']; ?>">
								<?php echo $link['title']; ?>				
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
			</nav>
			<div>
				<strong class='Footer--title'><?php pll_e("Social") ?></strong>
				<?php get_template_part('templates/global', 'sociallinks'); ?>
			</div>
			<div>
				<?php
				$link = get_field('call_to_action', 'option');
				$link_target = $link['target'] ? $link['target'] : '_self';
				?>
				<a class='Footer--button' target="<?php echo esc_attr($link_target); ?>" title='<?php echo $link['title']; ?>' href="<?php echo $link['url']; ?>">
					<?php echo $link['title']; ?>
				</a>
			</div>

		</div>

		<div class="Footer--bottom">
			<a class='Footer--okfn' target="_blank" href="https://okfn.org/network/switzerland/"><img src="<?php echo get_template_directory_uri(); ?>/library/img/okfn-logo.png" alt="Open Knowledge Foundation"></a>
			<p><?php the_field('legal_text', 'option'); ?></p>	
		</div>

	</footer>

	</div>

	<?php get_template_part('templates/flyout', 'menu'); ?>

	<?php get_template_part('templates/flyout', 'search'); ?>

	<?php get_template_part('templates/svgsprite'); ?>

	<?php wp_footer(); ?>

	</body>

	</html> <!-- end of site. what a ride! -->