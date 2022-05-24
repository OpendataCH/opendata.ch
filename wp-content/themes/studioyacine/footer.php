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
				<?php wp_nav_menu(array(
					'container' => 'div',                           // enter '' to remove nav container (just make sure .footer-links in _base.scss isn't wrapping)
					'container_class' => 'Footer--links',         // class of container (should you choose to use it)
					'menu' => __('Footer Links', 'bonestheme'),   // nav name
					'menu_class' => 'nav footer-nav',            // adding custom nav class
					'theme_location' => 'footer-links',             // where it's located in the theme
					'before' => '',                                 // before the menu
					'after' => '',                                  // after the menu
					'link_before' => '',                            // before each link
					'link_after' => '',                             // after each link
					'depth' => 0,                                   // limit the depth of the nav
					'fallback_cb' => 'bones_footer_links_fallback'  // fallback function
				)); ?>
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