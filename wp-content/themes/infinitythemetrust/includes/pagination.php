<?php $num_pages = $wp_query->max_num_pages; if($num_pages > 1) : ?>
<?php $infinite_scrolling = of_get_option('ttrust_infinite_scrolling'); ?>

<?php if($infinite_scrolling == "enabled_with_button") : ?>
	<div class="infscrBtn"><span>Load More</span></div>
<?php endif; ?>

<div class="pagination clearfix <?php if($infinite_scrolling != "disabled") echo 'hidden'; ?>">
    	
	<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
	
	<p class="pagination-next">
	    <?php next_posts_link('&larr; Older entries'); ?>
	</p>
	<p class="pagination-prev">
	 	<?php previous_posts_link('Newer entries &rarr;'); ?>
	</p>
	
	<?php endif; ?>

</div><!-- end pagination -->

<?php endif; // endif num_pages ?>