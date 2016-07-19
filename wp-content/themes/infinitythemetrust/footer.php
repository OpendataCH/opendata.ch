	</div>
	<div id="footer">

		<div class="main clearfix">
		<?php
		if(is_front_page() && is_active_sidebar('footer_home')) : dynamic_sidebar('footer_home');
		elseif(is_archive() && is_active_sidebar('footer_posts')) : dynamic_sidebar('footer_posts');
		elseif(is_single() && is_active_sidebar('footer_posts')) : dynamic_sidebar('footer_posts');
		elseif(is_page() && is_active_sidebar('footer_pages')) : dynamic_sidebar('footer_pages');
		else : ?>

		<?php if (!dynamic_sidebar('footer_default')) : ?>

		<div class = "widgetBox">
			<?php include( TEMPLATEPATH . '/includes/no_widgets.php'); ?>
		</div>

		<?php endif; ?>
		<?php endif; ?>
		</div><!-- end footer main -->



		<div class="secondary clearfix">
			<?php $footer_left = of_get_option('ttrust_footer_left'); ?>
			<?php $footer_right = of_get_option('ttrust_footer_right'); ?>
			<div class="left"><p><?php if($footer_left){echo($footer_left);} else{ ?>&copy; <?php echo date('Y');?> <a href="<?php bloginfo('url'); ?>"><strong><?php bloginfo('name'); ?></strong></a> All Rights Reserved.<?php }; ?></p></div>
			<div class="right"><p><?php if($footer_right){echo($footer_right);} ?></p></div>
		</div><!-- end footer secondary-->



	</div><!-- end footer -->
</div><!-- end container -->
<?php wp_footer(); ?>
</body>
</html>